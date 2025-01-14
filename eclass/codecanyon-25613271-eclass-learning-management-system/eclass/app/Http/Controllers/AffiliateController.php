<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use File;
use Image;
use App\Affiliate;
use Session;
use Spatie\Permission\Models\Role;
use App\Setting;


class AffiliateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AffiliateController
    |--------------------------------------------------------------------------
    |
    | This controller holds the logics and functionality of Affiliate system.
    |
     */

    /**
     * This function shows the affilate settings on admin dashboard.
     */
    public function __construct()
    {
        $this->middleware('permission:affiliate.manage', ['only' => ['index','update']]);
    
    }
    public function index()
    {

        $affilates = Affiliate::first();
        return view('admin.affiliates.index', compact('affilates'));
    }

    /**
     * This function holds the functionality to updates the affilate settings.
     */

    public function update(Request $request)
    {
        
        $affilates = $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);
        /* Retrieve all affiliate rows*/

        $affilates = Affiliate::all();
        
        try {

            /* Retrieve first affiliate row*/

            $affilates = Affiliate::first();

            $input = $request->all();

            if ($affilates) {

                $input['point_per_referral'] = $request->point_per_referral;

                if (!isset($input['status'])) {
                    $input['status'] = 0;
                } else {
                    $input['status'] = 1;
                }

                if ($file = $request->file('image')) {

                    $path = 'images/affiliate/';

                    /* Create directory of not exist */

                    if (!file_exists(public_path() . '/' . $path)) {

                        $path = 'images/affiliate/';
                        File::makeDirectory(public_path() . '/' . $path, 0777, true);
                    }
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path() . '/images/affiliate/';
                    $image = time() . $file->getClientOriginalName();
                    $optimizeImage->save($optimizePath . $image, 72);

                    $input['image'] = $image;

                }

                $affilates->update($input);

            } else {

                /** Create row if not exist */

                $affilates = new Affiliate;

                $input['point_per_referral'] = $request->point_per_referral;

                if ($file = $request->file('image')) {

                    $path = 'images/affiliate/';

                    /* Create directory of not exist */

                    if (!file_exists(public_path() . '/' . $path)) {

                        $path = 'images/affiliate/';
                        File::makeDirectory(public_path() . '/' . $path, 0777, true);
                    }
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path() . '/images/affiliate/';
                    $image = time() . $file->getClientOriginalName();
                    $optimizeImage->save($optimizePath . $image, 72);

                    $input['image'] = $image;

                }

                if (!isset($input['status'])) {
                    $input['status'] = 0;
                } else {
                    $input['status'] = 1;
                }

                $affilates->create($input);
            }

            Session::flash('success', __('flash.UpdatedSuccessfully'));
            return back()->with(__('Saved successfully'));

        } catch (\Exception $e) {

            /** If any error then return back to old view with exception message */

            \Session::flash('delete', $e->getMessage());
            return back();
        }

    }

    /**
     * This functions holds the funcnality to show User's affiliate link.
     */

    public function getlink()
    {
        $affilates = Affiliate::first();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.affiliate.show', compact('affilates'));
        }
        else{
         return view('theme_2.front.affiliate.show', compact('affilates'));

        }
    }

    /**
     * This functions holds the funcnality to generate user's affiliate link.
     */

    public function generatelink()
    {

        $refercode = User::createReferCode();

        User::where('id', auth()->id())
            ->update(['affiliate_id' => $refercode]);

        return view('front.affiliate.show');
    }
}
