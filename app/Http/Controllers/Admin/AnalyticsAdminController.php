<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClickEvent;
use App\Models\Contact;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsAdminController extends Controller
{
    /**
     * Display the analytics dashboard with date filtering and aggregated stats.
     */
    public function index(Request $request)
    {
        $period = $request->input('period', '30'); // default 30 days
        $startDate = null;
        $endDate = now();

        if ($period === 'today') {
            $startDate = now()->startOfDay();
        } elseif ($period === '7') {
            $startDate = now()->subDays(7)->startOfDay();
        } elseif ($period === '30') {
            $startDate = now()->subDays(30)->startOfDay();
        } elseif ($period === '90') {
            $startDate = now()->subDays(90)->startOfDay();
        } elseif ($period === 'custom') {
            $startInput = $request->input('start_date');
            $endInput = $request->input('end_date');
            if ($startInput && $endInput) {
                $startDate = Carbon::parse($startInput)->startOfDay();
                $endDate = Carbon::parse($endInput)->endOfDay();
            } else {
                $startDate = now()->subDays(30)->startOfDay();
            }
        } else {
            $startDate = now()->subDays(30)->startOfDay();
        }

        $cacheKey = 'admin_analytics_' . md5($period . ($startDate ? $startDate->toDateTimeString() : '') . $endDate->toDateTimeString());

        // Cache dashboard metrics for 5 minutes
        $analytics = Cache::remember($cacheKey, 300, function () use ($startDate, $endDate) {
            return $this->computeMetrics($startDate, $endDate);
        });

        return view('admin.analytics.index', array_merge($analytics, [
            'period' => $period,
            'startDate' => $startDate ? $startDate->format('Y-m-d') : now()->subDays(30)->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'isExcluded' => request()->cookie('no_track') === '1',
        ]));
    }

    /**
     * Compute aggregated metrics for the date range.
     */
    protected function computeMetrics(Carbon $start, Carbon $end): array
    {
        $viewsQuery = PageView::human()->whereBetween('created_at', [$start, $end]);
        $clicksQuery = ClickEvent::whereBetween('created_at', [$start, $end]);

        // 1. Core Summary Metrics
        $totalViews = (clone $viewsQuery)->count();
        $uniqueVisitors = (clone $viewsQuery)->distinct('visitor_id')->count('visitor_id');
        $totalSessions = (clone $viewsQuery)->distinct('session_id')->count('session_id');

        // Returning visitors: visitor_ids that appeared in more than 1 session
        $returningVisitors = (clone $viewsQuery)
            ->select('visitor_id')
            ->groupBy('visitor_id')
            ->havingRaw('COUNT(DISTINCT session_id) > 1')
            ->get()
            ->count();

        $avgPagesPerSession = $totalSessions > 0 ? round($totalViews / $totalSessions, 1) : 0;

        // Specific Click Events counts
        $callClicks = (clone $clicksQuery)->where('event', 'call_click')->count();
        $whatsappClicks = (clone $clicksQuery)->where('event', 'whatsapp_click')->count();
        $emailClicks = (clone $clicksQuery)->where('event', 'email_click')->count();
        $resumeDownloads = (clone $clicksQuery)->where('event', 'resume_download')->count();
        $liveDemoClicks = (clone $clicksQuery)->where('event', 'project_live_demo')->count();
        $hireMeClicks = (clone $clicksQuery)->where('event', 'hire_me_click')->count();

        // Contact messages submitted in this timeframe
        $contactMessages = Contact::whereBetween('created_at', [$start, $end])->count();

        // 2. Line Chart: Views & Unique Visitors per Day
        $dailyData = (clone $viewsQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views, COUNT(DISTINCT visitor_id) as visitors')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = [];
        $chartViews = [];
        $chartVisitors = [];

        foreach ($dailyData as $row) {
            $chartLabels[] = Carbon::parse($row->date)->format('M d');
            $chartViews[] = (int) $row->views;
            $chartVisitors[] = (int) $row->visitors;
        }

        // 3. Traffic Sources Breakdown (Doughnut)
        $sourcesData = (clone $viewsQuery)
            ->select('source', DB::raw('COUNT(*) as total'))
            ->groupBy('source')
            ->orderByDesc('total')
            ->get();

        // 4. Top Pages Breakdown
        $topPages = (clone $viewsQuery)
            ->select('path', DB::raw('COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_visitors'))
            ->groupBy('path')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        // 5. Device & Browser Breakdowns
        $devices = (clone $viewsQuery)
            ->select('device', DB::raw('COUNT(*) as total'))
            ->groupBy('device')
            ->orderByDesc('total')
            ->get();

        $browsers = (clone $viewsQuery)
            ->select('browser', DB::raw('COUNT(*) as total'))
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        // 6. Conversion Funnel
        $step1Visitors = $uniqueVisitors;
        $step2Projects = (clone $viewsQuery)->where('path', 'like', '%projects%')->distinct('visitor_id')->count('visitor_id');
        $step3Contact = (clone $viewsQuery)->where('path', 'like', '%contact%')->distinct('visitor_id')->count('visitor_id');
        $step4IntentClicks = (clone $clicksQuery)->whereIn('event', ['call_click', 'whatsapp_click', 'email_click'])->distinct('visitor_id')->count('visitor_id');
        $step5Submits = $contactMessages;

        $funnel = [
            ['name' => 'All Visitors', 'count' => $step1Visitors, 'percent' => 100],
            ['name' => 'Viewed Projects', 'count' => $step2Projects, 'percent' => $step1Visitors > 0 ? round(($step2Projects / $step1Visitors) * 100, 1) : 0],
            ['name' => 'Viewed Contact Page', 'count' => $step3Contact, 'percent' => $step1Visitors > 0 ? round(($step3Contact / $step1Visitors) * 100, 1) : 0],
            ['name' => 'Clicked Direct Contact (Call/WA/Email)', 'count' => $step4IntentClicks, 'percent' => $step1Visitors > 0 ? round(($step4IntentClicks / $step1Visitors) * 100, 1) : 0],
            ['name' => 'Submitted Contact Form', 'count' => $step5Submits, 'percent' => $step1Visitors > 0 ? round(($step5Submits / $step1Visitors) * 100, 1) : 0],
        ];

        // 7. Click Events Table
        $topClicks = (clone $clicksQuery)
            ->select('event', 'label', DB::raw('COUNT(*) as total'))
            ->groupBy('event', 'label')
            ->orderByDesc('total')
            ->take(15)
            ->get();

        // 8. Recent 50 Page Views
        $recentViews = (clone $viewsQuery)
            ->orderByDesc('created_at')
            ->take(50)
            ->get();

        // 9. Automated Intelligent Insights
        $insights = $this->generateInsights([
            'totalViews' => $totalViews,
            'uniqueVisitors' => $uniqueVisitors,
            'callClicks' => $callClicks,
            'whatsappClicks' => $whatsappClicks,
            'step2Projects' => $step2Projects,
            'step3Contact' => $step3Contact,
            'resumeDownloads' => $resumeDownloads,
            'contactMessages' => $contactMessages,
            'devices' => $devices,
        ]);

        return compact(
            'totalViews',
            'uniqueVisitors',
            'returningVisitors',
            'totalSessions',
            'avgPagesPerSession',
            'callClicks',
            'whatsappClicks',
            'emailClicks',
            'resumeDownloads',
            'liveDemoClicks',
            'hireMeClicks',
            'contactMessages',
            'chartLabels',
            'chartViews',
            'chartVisitors',
            'sourcesData',
            'topPages',
            'devices',
            'browsers',
            'funnel',
            'topClicks',
            'recentViews',
            'insights'
        );
    }

    /**
     * Generate clear, actionable insights based on traffic rules.
     */
    protected function generateInsights(array $data): array
    {
        $insights = [];

        // Rule 1: High visitors but zero direct contact clicks
        if ($data['uniqueVisitors'] >= 15 && ($data['callClicks'] + $data['whatsappClicks']) === 0) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'bi-telephone-x',
                'title' => 'Low Direct Contact Conversion',
                'text' => 'Visitors are exploring your portfolio, but none have clicked your phone or WhatsApp buttons. Consider moving the WhatsApp floating button or Hire Me button to a more prominent position.',
            ];
        }

        // Rule 2: Mobile traffic dominance
        $totalDeviceHits = $data['devices']->sum('total');
        $mobileHits = $data['devices']->where('device', 'mobile')->first()->total ?? 0;
        if ($totalDeviceHits > 0 && ($mobileHits / $totalDeviceHits) >= 0.55) {
            $insights[] = [
                'type' => 'info',
                'icon' => 'bi-phone',
                'title' => 'Mobile-First Audience',
                'text' => 'Over ' . round(($mobileHits / $totalDeviceHits) * 100) . '% of your traffic comes from mobile devices. Ensure tap targets, navigation speed, and project live demo links load effortlessly on mobile screens.',
            ];
        }

        // Rule 3: High project views but low contact page navigation
        if ($data['step2Projects'] >= 10 && $data['step3Contact'] <= 2) {
            $insights[] = [
                'type' => 'primary',
                'icon' => 'bi-code-square',
                'title' => 'Project Curiosity Drop-off',
                'text' => 'Visitors spend time looking at your projects, but few click through to the Contact page. Add an explicit "Interested in a similar build? Let\'s talk" button inside each project card.',
            ];
        }

        // Rule 4: Resume downloads high but low inquiries
        if ($data['resumeDownloads'] >= 5 && $data['contactMessages'] === 0) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'bi-file-earmark-person',
                'title' => 'Resume Download Follow-through',
                'text' => 'Several prospective recruiters or clients have downloaded your PDF resume, but haven\'t submitted the contact form. Ensure your email, phone, and WhatsApp are prominently visible right on page 1 of your PDF resume.',
            ];
        }

        // Default positive insight if no warnings triggered
        if (empty($insights)) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'bi-check2-circle',
                'title' => 'Healthy Engagement Ratio',
                'text' => 'Your conversion funnel and interaction metrics are balanced across pages and devices.',
            ];
        }

        return $insights;
    }
}
