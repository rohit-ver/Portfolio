<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Handle an incoming request and track page view if valid.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET responses for HTML pages
        if (!$request->isMethod('GET') || $request->ajax()) {
            return $response;
        }

        // Skip admin routes, tracking endpoints, and asset paths
        $path = '/' . ltrim($request->path(), '/');
        if (Str::startsWith($path, ['/admin', '/track', '/livewire', '/telescope', '/horizon'])) {
            return $response;
        }

        // Do not track if admin is logged in
        if (Auth::check()) {
            return $response;
        }

        // Do not track if "no_track" cookie is present
        if ($request->cookie('no_track') === '1') {
            return $response;
        }

        $userAgent = (string) $request->userAgent();

        // Detect bot user agents
        $isBot = $this->isBot($userAgent);
        if ($isBot) {
            return $response;
        }

        // 1. Visitor ID handling (1-year first-party cookie)
        $visitorId = $request->cookie('visitor_id');
        $cookieVisitor = null;
        if (!$visitorId) {
            $visitorId = (string) Str::uuid();
            // 525600 minutes = 1 year
            $cookieVisitor = cookie('visitor_id', $visitorId, 525600, null, null, false, false);
        }

        // 2. Session ID handling (30 minutes inactivity timeout)
        $sessionId = $request->cookie('portfolio_session_id');
        $lastActivity = $request->cookie('portfolio_last_activity');
        $nowTimestamp = time();
        $cookieSession = null;
        $cookieActivity = cookie('portfolio_last_activity', (string) $nowTimestamp, 60, null, null, false, false);

        if (!$sessionId || !$lastActivity || ($nowTimestamp - (int) $lastActivity > 1800)) {
            $sessionId = (string) Str::uuid();
            $cookieSession = cookie('portfolio_session_id', $sessionId, 60, null, null, false, false);
        }

        // 3. IP hashing (SHA-256 with APP_KEY pepper)
        $ip = $request->ip() ?: '127.0.0.1';
        $ipHash = hash('sha256', $ip . config('app.key'));

        // 4. Source detection from UTM or Referrer
        $referrer = $request->headers->get('referer');
        $source = $this->determineSource($request, $referrer);

        // 5. Device, Browser, and OS detection
        $deviceInfo = $this->parseUserAgent($userAgent);

        // 6. Record Page View in database asynchronously / safely
        try {
            PageView::create([
                'visitor_id' => $visitorId,
                'session_id' => $sessionId,
                'path' => $path,
                'page_title' => null, // Can be matched by path
                'referrer' => $referrer ? Str::limit($referrer, 500) : null,
                'source' => $source,
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'device' => $deviceInfo['device'],
                'browser' => $deviceInfo['browser'],
                'os' => $deviceInfo['os'],
                'country' => null, // Localhost skips geo
                'city' => null,
                'ip_hash' => $ipHash,
                'is_bot' => false,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Silently fail to never break user browsing experience
        }

        // Attach cookies to response
        if ($cookieVisitor) {
            $response->headers->setCookie($cookieVisitor);
        }
        if ($cookieSession) {
            $response->headers->setCookie($cookieSession);
        }
        $response->headers->setCookie($cookieActivity);

        return $response;
    }

    /**
     * Check if user agent belongs to a crawler/bot.
     */
    protected function isBot(string $userAgent): bool
    {
        if (empty($userAgent)) {
            return true;
        }

        $botPatterns = [
            'bot', 'crawl', 'spider', 'slurp', 'headless', 'phantom',
            'preview', 'curl', 'wget', 'python', 'postman', 'lighthouse',
            'mediapartners', 'facebookexternalhit', 'whatsapp', 'slackbot',
            'twitterbot', 'telegrambot', 'discordbot', 'linkedinbot',
        ];

        $lowerUa = strtolower($userAgent);
        foreach ($botPatterns as $pattern) {
            if (str_contains($lowerUa, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine traffic source from UTM or Referrer.
     */
    protected function determineSource(Request $request, ?string $referrer): string
    {
        if ($request->filled('utm_source')) {
            return strtolower($request->query('utm_source'));
        }

        if (empty($referrer)) {
            return 'direct';
        }

        $refHost = parse_url($referrer, PHP_URL_HOST);
        if (!$refHost) {
            return 'direct';
        }

        $refHost = strtolower($refHost);
        $currentHost = strtolower($request->getHost());

        // Internal clicks are not external referrers
        if ($refHost === $currentHost) {
            return 'direct';
        }

        if (str_contains($refHost, 'linkedin.') || str_contains($refHost, 'lnkd.in')) {
            return 'linkedin';
        }
        if (str_contains($refHost, 'google.')) {
            return 'google';
        }
        if (str_contains($refHost, 'whatsapp.') || str_contains($refHost, 'wa.me')) {
            return 'whatsapp';
        }
        if (str_contains($refHost, 'github.')) {
            return 'github';
        }
        if (str_contains($refHost, 'instagram.') || str_contains($refHost, 'facebook.') || str_contains($refHost, 't.co') || str_contains($refHost, 'twitter.') || str_contains($refHost, 'x.com')) {
            return 'social';
        }

        return 'other';
    }

    /**
     * Parse User Agent into device, browser, and OS.
     */
    protected function parseUserAgent(string $ua): array
    {
        $device = 'desktop';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            $device = 'tablet';
        } elseif (preg_match('/(mobile|ipod|iphone|android|blackberry|iemobile|opera mini)/i', $ua)) {
            $device = 'mobile';
        }

        // Browser detection
        $browser = 'Other';
        if (preg_match('/edg/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/chrome/i', $ua) && !preg_match('/edg/i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/safari/i', $ua) && !preg_match('/chrome/i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/firefox/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/opera|opr/i', $ua)) {
            $browser = 'Opera';
        }

        // OS detection
        $os = 'Other';
        if (preg_match('/windows nt 10/i', $ua) || preg_match('/windows nt 11/i', $ua)) {
            $os = 'Windows 10/11';
        } elseif (preg_match('/windows/i', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/android/i', $ua)) {
            $os = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $ua)) {
            $os = 'iOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        }

        return [
            'device' => $device,
            'browser' => $browser,
            'os' => $os,
        ];
    }
}
