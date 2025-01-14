<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Wallet;
use Auth;
use App\Affiliates;

class AffiliatesPoints implements ShouldQueue
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
       
        if(Auth::user()->wallet->status == 1) {
            if(Auth::user()->referred_by == !NULL ){
                
                        
                       
                // DB::table('wallet')->where('user_id', Auth::user()->id)->delete();

                $affiliate = Affiliates::first();

                Wallet::where('user_id', Auth::user()->id)
                    ->update(['balance' => $affiliate->point_per_referral ]);
                        
                
            }
        }
    }
}
