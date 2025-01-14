<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiController extends Controller
{
    public function index(){
        return view('admin.ai.index');
    }
}
