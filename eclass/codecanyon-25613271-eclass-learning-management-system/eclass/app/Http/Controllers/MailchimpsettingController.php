<?php

namespace App\Http\Controllers;

use App\mailchimpsetting;
use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class MailchimpsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.mailchimp.setting');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemailchimpsettingRequest  $request
     * @param  \App\mailchimpsetting  $mailchimpsetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $msetting = DotenvEditor::setKeys([
            'MAILCHIMP_APIKEY' => strip_tags($request->MAILCHIMP_APIKEY),
            'MAILCHIMP_LIST_ID' => strip_tags($request->MAILCHIMP_LIST_ID),
        ]);

        $msetting->save();
        return back()->with('success',trans('Mailchimp setting has been updated'));

    }
}

   

