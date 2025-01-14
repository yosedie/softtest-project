<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WidgetSetting;
use Spatie\Permission\Models\Role;


class WidgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:widget.manage', ['only' => ['edit','update','destroy']]);
    }

    public function edit()
    {
    	$show = WidgetSetting::first();
      	return view('admin.widget.edit',compact('show'));
    }

    public function update(Request $request)
    {
    	$widget = WidgetSetting::first();

        $input = $request->all();

        if(isset($widget))
        {
            $input['widget_enable'] = isset($request->widget_enable)  ? 1 : 0;
            $input['about_enable'] = isset($request->about_enable)  ? 1 : 0;
            $input['contact_enable'] = isset($request->contact_enable)  ? 1 : 0;
            $input['career_enable'] = isset($request->career_enable)  ? 1 : 0;
            $input['blog_enable'] = isset($request->blog_enable)  ? 1 : 0;
            $input['help_enable'] = isset($request->help_enable)  ? 1 : 0;

            $widget->update($input);
        }
        else
        {

            $input['widget_enable'] = isset($request->widget_enable)  ? 1 : 0;
            $input['about_enable'] = isset($request->about_enable)  ? 1 : 0;
            $input['contact_enable'] = isset($request->contact_enable)  ? 1 : 0;
            $input['career_enable'] = isset($request->career_enable)  ? 1 : 0;
            $input['blog_enable'] = isset($request->blog_enable)  ? 1 : 0;
            $input['help_enable'] = isset($request->help_enable)  ? 1 : 0;
            
            $widget = WidgetSetting::create($input);
          
            $widget->save();
        }

        return back()->with('success',trans('flash.UpdatedSuccessfully'));
    }

    public function destroy($id)
    {
    	$widget = WidgetSetting::findorfail($id);
        $widget->delete();

        return back()->with('delete',trans('flash.DeletedSuccessfully'));
    }
}
