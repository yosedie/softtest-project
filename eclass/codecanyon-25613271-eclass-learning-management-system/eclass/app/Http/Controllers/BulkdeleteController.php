<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Trusted;
use App\SliderFacts;
use App\Testimonial;
use App\Advertisement;
use App\SeoDirectory;
use App\CourseReport;
use App\QuestionReport;
use App\Country;
use App\State;
use App\City;
use App\Instructor;
use App\Meeting;
use App\BBL;
use App\Googlemeet;
use App\JitsiMeeting;
use Session;
use Illuminate\Support\Facades\Validator;

class BulkdeleteController extends Controller
{
    public function sliderdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('info',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Slider::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function factssliderdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
              return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                SliderFacts::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function trustsliderdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Trusted::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function testimonaldeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Testimonial::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
                
            }

        }
    public function advertismentdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Advertisement::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function seodirectorydeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                SeoDirectory::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
            
    public function reportedcoursedeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                CourseReport::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }

        public function reportedquestiondeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                QuestionReport::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
          

    public function countrydeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                $daa = new Country;
                State::where('country_id', $obj->country_id)->delete();
                City::where('country_id', $obj->country_id)->delete();
                Country::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();

                
            }

        }
    public function statedeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
              State::whereIn('id',$request->checked)->delete();
              Session::flash('success',trans('Deleted Successfully'));
              return redirect()->back();
                
            }

        }
    public function citydeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                City::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function instructorrequestdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Instructor::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function instructorpendingdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Instructor::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function ZoommeetingdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
              Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Meeting::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function googlemeetingdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                Googlemeet::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function bblmeetingdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                BBL::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
    public function jitsimeetingdeleteAll(Request $request)
    
        {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
               Session::flash('warning',trans('Please select delete'));
               return redirect()->back();
            }
            else{
                JitsiMeeting::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }

        }
      
            
           
            
}
