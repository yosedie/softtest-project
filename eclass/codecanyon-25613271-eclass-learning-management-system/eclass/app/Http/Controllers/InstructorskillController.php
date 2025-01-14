<?php

namespace App\Http\Controllers;

use App\Instructorskill;
use App\User;
use Session;
use Illuminate\Http\Request;


class InstructorskillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Instructorskill::get();
        return view('admin.instructorskill.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = User::select('*')->where('role', 'instructor')->get();
        return view('admin.instructorskill.create',compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstructorskillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "instructor_id" => "required",
            "skills" => "required",

        ]);
        $data['instructor_id'] = strip_tags($request->instructor_id);
        $data['skills'] = strip_tags($request->skills);
        Instructorskill::create($data);
        Session::flash('success', __('flash.AddedSuccessfully'));
        return redirect('instructor/skills');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Instructorskill  $instructorskill
     * @return \Illuminate\Http\Response
     */
    public function show(Instructorskill $instructorskill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Instructorskill  $instructorskill
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instructor = Instructorskill::find($id);
        $data = User::select('*')->where('role', 'instructor')->get();
        return view("admin.instructorskill.edit", compact('instructor','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstructorskillRequest  $request
     * @param  \App\Instructorskill  $instructorskill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $instructor = Instructorskill::find($id);
        $request->validate([
            "instructor_id" => "required",
            "skills" => "required",

        ]);
        $input = $request->all();
        $input['instructor_id'] = strip_tags($request->instructor_id);
        $input['skills'] = strip_tags($request->skills);
        $instructor->update($input);
        Session::flash('success', trans('flash.UpdateSuccessfully'));
        return redirect('instructor/skills');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Instructorskill  $instructorskill
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instructor = Instructorskill::find($id);
        $instructor->delete();
        return back()->with('deleted', 'Skill has been deleted !');
    }
}
