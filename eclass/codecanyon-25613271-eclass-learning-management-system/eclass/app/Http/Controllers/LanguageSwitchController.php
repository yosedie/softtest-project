<?php

namespace App\Http\Controllers;

use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitchController extends Controller
{
    public function languageSwitch($local)
    {
    	Session::put('changed_language', $local);
		  return back();
    }
}
