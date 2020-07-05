<?php

namespace App\Console\Commands;

use App\Jobs\SendMailJob;
use App\Mail\Login;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendemail:everyminute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To send email to users';

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
     * @return int
     */
    public function handle()
    {
        Log::info('Cronjob started');
        $users = User::all();
        if($users){
            foreach($users as $user) {
                dispatch(new SendMailJob($user->email,new Login($user)));
            }
        }
        Log::info('Cronjob end');
    }
}
