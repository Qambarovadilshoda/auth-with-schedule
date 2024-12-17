<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users whose email is not verified';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = Carbon::now();
        $deletedCount = User::whereNull('email_verified_at')
            ->where('created_at', '<', $currentTime->subDays(3))
            ->delete();

        $this->info("Deleted {$deletedCount} unverified users.");
        return Command::SUCCESS;
    }
}
