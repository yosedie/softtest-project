<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['emails'] = EmailTemplate::all();
        return view('admin.email_template.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.email_template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id){
            $params['type'] = $request->type;
            $params['subject'] = $request->subject;
            $params['title'] = $request->title;
            $params['action'] = $request->action;
            $params['message'] = $request->message;
            \Session::flash('success',trans('Update Successfully'));
            EmailTemplate::whereId($request->id)->update($params);
        } else {
            $params['type'] = $request->type;
            $params['subject'] = $request->subject;
            $params['title'] = $request->title;
            $params['action'] = $request->action;
            $params['message'] = $request->message;
            \Session::flash('success',trans('Create Successfully'));
            EmailTemplate::create($params);
        }

        return redirect('email-template');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $data['emailTemplate'] = $emailTemplate;
        return view('admin.email_template.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        return $emailTemplate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        \Session::flash('success',trans('Deleted Successfully'));
        return back();
    }
}
