<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Course;
use App\CourseClass;
use App\CourseChapter;

class WatchApiController extends Controller
{
    public function watch_course($user, $code, $id)
    {
        $data = DB::table('oauth_access_tokens')
            ->where('user_id', $user)
            ->where('revoked', 0)
            ->where('id', $code)->get();
        $user = $user;

        if (isset($data) && count($data) > 0) {
            $courses = Course::findorfail($id);
            $course = $courses->id;
            if ($courses->chapter[0]->courseclass[0]->iframe_url != null) {
                $url = $courses->chapter->courseclass->iframe_url;
                return view('iframe', compact('course', 'url'));
            } else {
                return view('watch', compact('courses', 'user'));
            }
        }
    }

    public function watch_class($user, $code, $id)
    {	

        $data = DB::table('oauth_access_tokens')
            ->where('user_id', $user)
            ->where('revoked', 0)
            ->where('id', $code)->get();
        $user = $user;
        if (isset($data) && count($data) > 0) {
           

            $class = CourseClass::where('id',$id)->first();

            $course = $class->course_id;

            if ($class->iframe_url != null) {
                $url = $class->iframe_url;
                return view('iframe', compact('url', 'course'));
            }
            return view('classwatch', compact('class', 'user'));
         }
    }
}
