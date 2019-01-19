<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

use Log;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Active Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        laraLog("Log test for laratest");
        //calculate
        $this->info('Calculating ...');
        $user->calculateAndCacheActiveUsers();
        $this->info('Calculating Done!');
    }
}