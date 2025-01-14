<?php

namespace App\Http\Controllers;

use App\Course;
use App\Search;
use Illuminate\Http\Request;
use Avatar;
use Modules\Resume\Models\Postjob;
use App\Setting;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $coursequery = Course::query();

        if (isset($searchTerm)) {
            
            $search_data = collect();

            $lang = app()->getLocale();

            if ($lang == 'ar' || $lang == 'ur') {


                $course_title = $coursequery->where('title->' . app()->getLocale(), 'LIKE', '%' . $searchTerm . '%')->get();

            } else {

                $course_title = Course::where('title', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->get();

            }

            if (isset($course_title) && count($course_title) > 0) {

                $search_data->push($course_title);

            }

            $course_tags = Course::where('level_tags', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->get();

            if (isset($course_tags) && count($course_tags) > 0) {

                $search_data->push($course_tags);

            }

            $course_tags = Course::where('course_tags', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->get();

            if (isset($course_tags) && count($course_tags) > 0) {

                $search_data->push($course_tags);

            }
           

            $search_data = $search_data->flatten();

            $courses = Course::search($searchTerm)->paginate(20);
            $setting = Setting::first();
            if($setting->theme == '1'){
            return view('front.search', compact('search_data', 'searchTerm'));
        }
        return view('theme_2.front.search', compact('search_data', 'searchTerm'));
        } else {
            return back()->with('delete', trans('flash.NoSearch'));
        }

    }

    public function showcourse()
    {

        return view('front.search.index');
    }

    public function fetch(Request $request)
    {
        $data = Course::where('title', 'LIKE', "%{$request->search}%")
                ->where('status',1)->get();

        if(count($data)){
            foreach ($data as $key => $value) {

                $result[] = [
                    'id' => $value->id,
                    'value' => $value->title,
                    'url'  => route('user.course.show', ['id' => $value->id, 'slug' => $value->slug]),
                    'image' => $value->preview_image != '' && file_exists(public_path().'/images/course/'.$value->preview_image) ?  url('images/course/'.$value->preview_image) : Avatar::create($value->title)->toBase64()
                ];
    
            }
        }else{
            $result[] = [
                'id' => 0,
                'value' => __("No results found"),
                'url'  => '#',
                'image' => url('images/icons/icon-72x72.png')
            ];
        }

        return response()->json($result,200);

    }

}
