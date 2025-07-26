<?php

namespace App\Console\Commands;

use App\Models\ChatMessage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupOldChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:cleanup {--hours=24 : Hours after which to delete chat messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up chat messages older than specified hours (default: 24 hours)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = $this->option('hours');
        $cutoffTime = Carbon::now()->subHours($hours);

        $deletedCount = ChatMessage::where('created_at', '<', $cutoffTime)->delete();

        $this->info("Cleaned up {$deletedCount} chat messages older than {$hours} hours.");

        return Command::SUCCESS;
    }
}
