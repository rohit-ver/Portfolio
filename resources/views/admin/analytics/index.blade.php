@extends('admin.layout')

@section('title', 'Portfolio Analytics')
@section('page_title', 'Portfolio Analytics & Insights')
@section('page_subtitle', 'Privacy-friendly visitor tracking, conversion funnels, and click analytics')

@section('page_actions')
    <!-- Exclude/Include this browser toggle -->
    <form action="{{ route('track.opt-out') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" 
                class="btn-glass py-1 px-3 {{ $isExcluded ? 'btn-glass-primary' : '' }}" 
                style="font-size: 0.85rem;"
                title="{{ $isExcluded ? 'Click to re-enable tracking for this browser' : 'Exclude this browser from analytics' }}">
            <i class="bi {{ $isExcluded ? 'bi-eye-slash-fill' : 'bi-shield-check' }} me-1"></i>
            {{ $isExcluded ? 'This Browser is Excluded' : 'Don\'t Track This Browser' }}
        </button>
    </form>
@endsection

@section('content')

<!-- Date Filter Bar -->
<div class="glass p-3 mb-4">
    <form action="{{ route('admin.analytics.index') }}" method="GET" class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Preset pills -->
        <div class="btn-group" role="group">
            <a href="{{ route('admin.analytics.index', ['period' => 'today']) }}" 
               class="btn btn-sm {{ $period === 'today' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Today
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => '7']) }}" 
               class="btn btn-sm {{ $period === '7' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Last 7 Days
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => '30']) }}" 
               class="btn btn-sm {{ $period === '30' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Last 30 Days
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => '90']) }}" 
               class="btn btn-sm {{ $period === '90' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Last 90 Days
            </a>
        </div>

        <!-- Custom Date Range -->
        <div class="d-flex align-items-center gap-2">
            <input type="hidden" name="period" value="custom">
            <span class="text-muted" style="font-size: 0.85rem;">Custom:</span>
            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
            <span class="text-muted">&ndash;</span>
            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
            <button type="submit" class="btn btn-sm btn-outline-info">
                <i class="bi bi-funnel"></i> Apply
            </button>
        </div>
    </form>
</div>

<!-- Automated Intelligent Insights Box -->
@if(!empty($insights))
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="glass p-4" style="border-left: 4px solid var(--accent);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-lightbulb-fill text-warning fs-4"></i>
                <h5 class="font-heading mb-0">Automated Conversion Insights</h5>
            </div>
            <div class="row g-3">
                @foreach($insights as $insight)
                    <div class="col-md-6">
                        <div class="p-3 rounded h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08);">
                            <div class="d-flex align-items-start gap-2 mb-1">
                                <i class="bi {{ $insight['icon'] }} fs-5" style="color: var(--accent);"></i>
                                <div>
                                    <strong style="color: var(--text-main); font-size: 0.95rem;">{{ $insight['title'] }}</strong>
                                    <p class="text-muted mb-0 mt-1" style="font-size: 0.88rem; line-height: 1.5;">
                                        {{ $insight['text'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Summary Metric Cards (8 Cards) -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Total Page Views</span>
                <i class="bi bi-eye fs-5" style="color: var(--accent);"></i>
            </div>
            <h3 class="font-heading mb-0">{{ number_format($totalViews) }}</h3>
            <small class="text-muted">Total hits</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Unique Visitors</span>
                <i class="bi bi-people fs-5" style="color: #38BDF8;"></i>
            </div>
            <h3 class="font-heading mb-0">{{ number_format($uniqueVisitors) }}</h3>
            <small class="text-muted">Distinct UUIDs</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Returning Visitors</span>
                <i class="bi bi-arrow-repeat fs-5" style="color: #818CF8;"></i>
            </div>
            <h3 class="font-heading mb-0">{{ number_format($returningVisitors) }}</h3>
            <small class="text-muted">Multi-session users</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Pages / Session</span>
                <i class="bi bi-layers fs-5" style="color: #A78BFA;"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $avgPagesPerSession }}</h3>
            <small class="text-muted">Average depth</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Contact Messages</span>
                <i class="bi bi-chat-left-dots fs-5 text-warning"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $contactMessages }}</h3>
            <small class="text-muted">Form submissions</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Resume Downloads</span>
                <i class="bi bi-download fs-5 text-success"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $resumeDownloads }}</h3>
            <small class="text-muted">CV clicks</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">Phone Call Clicks</span>
                <i class="bi bi-telephone fs-5" style="color: #F43F5E;"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $callClicks }}</h3>
            <small class="text-muted">tel: clicks</small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted" style="font-size: 0.8rem;">WhatsApp Clicks</span>
                <i class="bi bi-whatsapp fs-5" style="color: #25D366;"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $whatsappClicks }}</h3>
            <small class="text-muted">Direct chats</small>
        </div>
    </div>
</div>

<!-- Charts Section: Views Over Time & Traffic Sources -->
<div class="row g-4 mb-4">
    <!-- Line Chart: Page Views & Visitors -->
    <div class="col-lg-8">
        <div class="glass p-4 h-100">
            <h5 class="font-heading mb-3">Traffic Overview Over Time</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="viewsLineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Doughnut: Traffic Sources -->
    <div class="col-lg-4">
        <div class="glass p-4 h-100">
            <h5 class="font-heading mb-3">Traffic Acquisition Sources</h5>
            <div style="height: 220px; position: relative;" class="mb-3">
                <canvas id="sourcesDoughnutChart"></canvas>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0" style="font-size: 0.82rem;">
                    <tbody>
                        @foreach($sourcesData as $src)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-capitalize">{{ $src->source }}</span>
                                </td>
                                <td class="text-end font-monospace">{{ $src->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Conversion Funnel Section -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="glass p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-heading mb-0">Visitor Conversion Funnel</h5>
                <small class="text-muted">From landing to contact submission</small>
            </div>

            <div class="row g-3">
                @foreach($funnel as $step)
                    <div class="col-md">
                        <div class="p-3 rounded h-100 text-center" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                            <span class="text-muted d-block mb-1" style="font-size: 0.78rem;">Step {{ $loop->iteration }}</span>
                            <strong class="d-block mb-2" style="font-size: 0.88rem; color: var(--text-main);">{{ $step['name'] }}</strong>
                            <h4 class="font-heading mb-1 text-accent" style="color: var(--accent);">{{ $step['count'] }}</h4>
                            <div class="progress my-2" style="height: 6px; background: rgba(255, 255, 255, 0.1);">
                                <div class="progress-bar" style="width: {{ $step['percent'] }}%; background: linear-gradient(90deg, var(--primary), var(--accent));"></div>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $step['percent'] }}% of visitors</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Top Pages & Devices Breakdown -->
<div class="row g-4 mb-4">
    <!-- Top Pages Table -->
    <div class="col-lg-6">
        <div class="glass p-4 h-100">
            <h5 class="font-heading mb-3">Top Visited Pages</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead>
                        <tr class="text-muted" style="font-size: 0.8rem;">
                            <th>Path</th>
                            <th class="text-end">Total Views</th>
                            <th class="text-end">Unique Visitors</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPages as $page)
                            <tr>
                                <td>
                                    <code style="color: var(--accent);">{{ $page->path }}</code>
                                </td>
                                <td class="text-end font-monospace">{{ $page->total }}</td>
                                <td class="text-end font-monospace text-muted">{{ $page->unique_visitors }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-3 text-muted">No page view data recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Devices & Browsers -->
    <div class="col-lg-6">
        <div class="glass p-4 h-100">
            <h5 class="font-heading mb-3">Devices &amp; Browsers</h5>
            <div class="row g-3">
                <div class="col-sm-6">
                    <h6 class="text-muted" style="font-size: 0.8rem;">Device Categories</h6>
                    <ul class="list-group list-group-flush bg-transparent">
                        @foreach($devices as $dev)
                            <li class="list-group-item bg-transparent border-0 px-0 py-1 d-flex justify-content-between align-items-center" style="font-size: 0.85rem;">
                                <span>
                                    <i class="bi {{ $dev->device === 'mobile' ? 'bi-phone' : ($dev->device === 'tablet' ? 'bi-tablet' : 'bi-laptop') }} me-2 text-accent"></i>
                                    {{ ucfirst($dev->device) }}
                                </span>
                                <span class="badge bg-secondary font-monospace">{{ $dev->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6">
                    <h6 class="text-muted" style="font-size: 0.8rem;">Browsers</h6>
                    <ul class="list-group list-group-flush bg-transparent">
                        @foreach($browsers as $br)
                            <li class="list-group-item bg-transparent border-0 px-0 py-1 d-flex justify-content-between align-items-center" style="font-size: 0.85rem;">
                                <span>{{ $br->browser ?: 'Other' }}</span>
                                <span class="badge bg-secondary font-monospace">{{ $br->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Click Events Table -->
<div class="glass p-4 mb-4">
    <h5 class="font-heading mb-3">Top Button &amp; Link Click Events</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
            <thead>
                <tr class="text-muted" style="font-size: 0.8rem;">
                    <th>Event Key</th>
                    <th>Label / Target</th>
                    <th class="text-end">Total Clicks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topClicks as $click)
                    <tr>
                        <td>
                            <span class="badge bg-primary">{{ $click->event }}</span>
                        </td>
                        <td>{{ $click->label ?: 'None' }}</td>
                        <td class="text-end font-monospace">{{ $click->total }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-3 text-muted">No click events logged yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent 50 Page Views Table -->
<div class="glass p-4">
    <h5 class="font-heading mb-3">Recent 50 Page Hits</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
            <thead>
                <tr class="text-muted">
                    <th>Timestamp</th>
                    <th>Path</th>
                    <th>Source</th>
                    <th>Device</th>
                    <th>OS / Browser</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentViews as $view)
                    <tr>
                        <td class="text-muted">{{ $view->created_at->format('M d, H:i') }}</td>
                        <td><code>{{ $view->path }}</code></td>
                        <td><span class="badge bg-secondary">{{ $view->source }}</span></td>
                        <td>{{ ucfirst($view->device) }}</td>
                        <td>{{ $view->os }} / {{ $view->browser }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-3 text-muted">No hits recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Line Chart: Views & Visitors Over Time
    const lineCtx = document.getElementById('viewsLineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Page Views',
                        data: {!! json_encode($chartViews) !!},
                        borderColor: '#06B6D4',
                        backgroundColor: 'rgba(6, 182, 212, 0.15)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                    },
                    {
                        label: 'Unique Visitors',
                        data: {!! json_encode($chartVisitors) !!},
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#CBD5E1' }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94A3B8' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94A3B8', precision: 0 }
                    }
                }
            }
        });
    }

    // 2. Doughnut Chart: Acquisition Sources
    const doughnutCtx = document.getElementById('sourcesDoughnutChart');
    if (doughnutCtx) {
        const sourceLabels = {!! json_encode($sourcesData->pluck('source')) !!};
        const sourceCounts = {!! json_encode($sourcesData->pluck('total')) !!};

        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: sourceLabels.length ? sourceLabels : ['None'],
                datasets: [{
                    data: sourceCounts.length ? sourceCounts : [1],
                    backgroundColor: [
                        '#4F46E5', '#06B6D4', '#10B981', '#F59E0B', '#EC4899', '#8B5CF6'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#CBD5E1', boxWidth: 12 }
                    }
                }
            }
        });
    }
});
</script>
@endpush
