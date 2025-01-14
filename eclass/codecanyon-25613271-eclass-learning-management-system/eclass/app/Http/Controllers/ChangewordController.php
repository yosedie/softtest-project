<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;

class ChangewordController extends Controller
{
    public function index(){
       
        return view('admin.changeword.index');
    }
    public function store($langCode){

     
        $url = str_replace('public','',URL::to('/'));
        $path = $url.'resources/lang/'.$langCode;
        $jsonContents = @file_get_contents($path);


      
       
        return view('admin.changeword.edit',compact('jsonContents','langCode'));
        // $counttype = $_POST['name'];
        // $value = $_POST['value'];
        // $data = json_decode($jsonContents, true);        
        // $data[$counttype] = $value;   
       
        // $json = json_encode($data);
        // file_put_contents($path, $json);
       
        // $result = file_get_contents($path);
        // return response()->json(['data' => $data]);
    }

    public function update(Request $request){

        $request->validate([
            'content' => 'required',
            'langcode' => 'required|string'
        ]);
        
        $file = @file_put_contents(resource_path("/lang/".$request->langcode),$request->content);

        return 'done';
        
    }

}
