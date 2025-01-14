<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Auth;
use DB;

class EnrollExpire implements ShouldQueue
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
        //Get User Wallet
        $todayDate = date('Y-m-d');
       
        foreach (Auth::user()->orders as $order) {
            if($order->status == 1 ){
                if($order->enroll_expire != NULL && $order->enroll_expire != '' ){
                    if($todayDate >= date('Y-m-d',strtotime($order->enroll_expire))){
                        
                       
                        DB::table('orders')->where('enroll_expire', '<', $todayDate)->delete();
                        
                    }
                }
            }
        }
            
    }
}
