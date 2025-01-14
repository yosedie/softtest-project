<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\CourseClass;

class DownloadController extends Controller
{
    public function getDownload($id)
    {

    	$entry = CourseClass::where('id', '=', $id)->firstOrFail();
    	// $pathToFile=public_path()."/files/pdf/".$entry->pdf;
    	// return response()->download($pathToFile);

    	return view('pdf', compact('entry'));

	}

	
}
