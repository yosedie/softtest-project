<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FaqStudent;
use app\setting;
use App\FaqInstructor;

class HelpController extends Controller
{
    public function faqstudentpage($id)
    {

      	$data = FaqStudent::findorfail($id);
         {
	  	  return view('front.help.faq_detail',compact('data')); 
          }
    }

    public function faqinstructorpage($id)
    {
    	
	  	$data = FaqInstructor::findorfail($id);
          $setting = Setting::first();
          if($setting->theme == '1'){
	  	return view('front.help.faq_detail',compact('data')); 
          }
	  	return view('theme_2.front.help.faq_detail',compact('data')); 

    }
}
