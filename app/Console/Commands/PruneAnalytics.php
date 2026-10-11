<?php

namespace App\Console\Commands;

use App\Models\ClickEvent;
use App\Models\PageView;
use Illuminate\Console\Command;

class PruneAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:prune {days=180 : The number of days of analytics data to retain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune old page views and click events older than the specified retention period';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->argument('days');
        $cutoff = now()->subDays($days);

        $this->info("Pruning analytics records older than {$days} days (before {$cutoff->toDateTimeString()})...");

        $deletedViews = PageView::where('created_at', '<', $cutoff)->delete();
        $this->line("Deleted {$deletedViews} page view records.");

        $deletedClicks = ClickEvent::where('created_at', '<', $cutoff)->delete();
        $this->line("Deleted {$deletedClicks} click event records.");

        $this->info('Analytics pruning completed successfully.');

        return Command::SUCCESS;
    }
}
