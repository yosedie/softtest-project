<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Auth;
use DB;

class InstructorPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $todayDate = date('Y-m-d');
       
        foreach (Auth::user()->plans as $plan) {
           
            if($plan->enroll_expire != NULL && $plan->enroll_expire != '' ){
                if($todayDate >= date('Y-m-d',strtotime($plan->enroll_expire))){
                    
                   
                    DB::table('plan_subscription')->where('enroll_expire', '<', $todayDate)->delete();
                    
                }
            }
            
        }
    }
}
