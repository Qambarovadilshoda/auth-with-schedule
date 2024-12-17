<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

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
        $unverifiedUsers = User::whereNull('email_verified_at')->get();
        if ($unverifiedUsers->isEmpty()) {
            $this->info('No unverified users found.');
        } else {
            $this->info('Deleting unverified users...');
            foreach ($unverifiedUsers as $user) {
                $user->delete();
                $this->info("Deleted user: {$user->email}");
            }

            $this->info('Unverified users deleted successfully.');
        }
    }
}
