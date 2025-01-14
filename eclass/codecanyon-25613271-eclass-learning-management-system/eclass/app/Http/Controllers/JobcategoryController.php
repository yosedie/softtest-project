<?php

namespace App\Http\Controllers;

use App\Jobcategory;
use App\Http\Requests\StoreJobcategoryRequest;
use App\Http\Requests\UpdateJobcategoryRequest;

class JobcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJobcategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobcategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcategory $jobcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcategory $jobcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobcategoryRequest  $request
     * @param  \App\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobcategoryRequest $request, Jobcategory $jobcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcategory $jobcategory)
    {
        //
    }
}
