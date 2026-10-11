<?php

namespace App\Http\Controllers;

use App\Models\ClickEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrackController extends Controller
{
    /**
     * Allowed click events whitelist.
     */
    protected const ALLOWED_EVENTS = [
        'call_click',
        'whatsapp_click',
        'email_click',
        'resume_download',
        'project_live_demo',
        'social_click',
        'hire_me_click',
        'contact_form_submit',
    ];

    /**
     * Handle incoming beacon or keepalive click tracking events.
     */
    public function track(Request $request)
    {
        // Skip if admin user is logged in
        if (Auth::check()) {
            return response()->json(['status' => 'ignored_admin']);
        }

        // Skip if visitor opted out
        if ($request->cookie('no_track') === '1') {
            return response()->json(['status' => 'ignored_optout']);
        }

        $validated = $request->validate([
            'event' => ['required', 'string', 'in:' . implode(',', static::ALLOWED_EVENTS)],
            'label' => ['nullable', 'string', 'max:255'],
            'path' => ['nullable', 'string', 'max:255'],
        ]);

        $visitorId = $request->cookie('visitor_id') ?: $request->input('visitor_id', 'unknown');

        ClickEvent::create([
            'visitor_id' => Str::limit($visitorId, 64),
            'event' => $validated['event'],
            'label' => $validated['label'] ? Str::limit($validated['label'], 255) : null,
            'path' => $validated['path'] ? Str::limit($validated['path'], 255) : null,
            'created_at' => now(),
        ]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Set or toggle the no_track cookie for the current browser.
     */
    public function optOut(Request $request)
    {
        $current = $request->cookie('no_track') === '1';
        $newVal = $current ? '0' : '1';

        // 525600 minutes = 1 year
        $cookie = cookie('no_track', $newVal, 525600, null, null, false, false);

        return redirect()->back()
            ->withCookie($cookie)
            ->with('success', $newVal === '1' 
                ? 'Your browser is now excluded from all portfolio analytics tracking.' 
                : 'Analytics tracking re-enabled for this browser.');
    }
}
