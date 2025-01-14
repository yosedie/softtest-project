<?php

namespace App\Http\Controllers\Api;

use App\About;
use App\Adsense;
use App\Announcement;
use App\Answer;
use App\Appointment;
use App\Assignment;
use App\Attandance;
use App\BBL;
use App\Blog;
use App\BundleCourse;
use App\Career;
use App\Cart;
use App\Categories;
use App\CategorySlider;
use App\ChildCategory;
use App\Contact;
use App\Coupon;
use App\Course;
use App\CourseChapter;
use App\CourseClass;
use App\CourseProgress;
use App\CourseReport;
use App\Currency;
use App\FaqInstructor;
use App\FaqStudent;
use App\GetStarted;
use App\Googlemeet;
use App\Http\Controllers\Controller;
use App\Instructor;
use App\JitsiMeeting;
use App\Mail\UserAppointment;
use App\Meeting;
use App\Order;
use App\Page;
use App\Quiz;
use App\PreviousPaper;
use App\PrivateCourse;
use App\Question;
use App\QuizAnswer;
use App\QuizTopic;
use App\ReviewHelpful;
use App\ReviewRating;
use App\Setting;
use App\Slider;
use App\SliderFacts;
use App\SubCategory;
use App\Terms;
use App\Testimonial;
use App\Trusted;
use App\User;
use App\WatchCourse;
use App\Wishlist;
use Avatar;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Is_wishlist;
use Mail;
use Validator;
use App\LiveCourse;

class MainController extends Controller
{

    public function home(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        $settings = Setting::first();
        $adsense = Adsense::first();
        $currency2 = Currency::where('default', '1')->first();

        $currency = array(
            "id" => $currency2->id,
            "icon" => $currency2->symbol,
            "currency" => $currency2->code,
            "default" => $currency2->default,
            "created_at" => $currency2->created_at,
            "updated_at" => $currency2->updated_at,
            "name" => $currency2->name,
            "format" => $currency2->format,
            "exchange_rate" => $currency2->default == 1 ? 1 : $currency2->exchange_rate,
        );
        $slider = Slider::where('status', '1')->orderBy('position', 'ASC')->get();
        $sliderfacts = SliderFacts::get();
        $trusted = Trusted::where('status', 1)->get();

        $testimonials = Testimonial::where('status', 1)->get();

        $testimonial_result = array();

        foreach ($testimonials as $testimonial) {

            $testimonial_result[] = array(
                'id' => $testimonial->id,
                'client_name' => $testimonial->client_name,
                'details' => strip_tags($testimonial->details),
                'status' => $testimonial->status,
                'image' => $testimonial->image,
                'imagepath' => url('images/testimonial/' . $testimonial->image),
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->created_at,
            );
        }

        $category = Categories::where('status', 1)->orderBy('position', 'asc')->get();

        $subcategory = SubCategory::where('status', 1)->get();
        $childcategory = ChildCategory::where('status', 1)->get();

        $featured_cate = Categories::where('status', 1)->orderBy('position', 'asc')->where('featured', 1)->get();

        $all_categories = array();

        foreach ($category as $cate) {

            $cate_subcategory = SubCategory::where('status', 1)->where('category_id', $cate->id)->with('childcategory')->get();

            $all_categories[] = array(
                'id' => $cate->id,
                'title' => array_map(function ($lang) {
                    return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                }, $cate->getTranslations('title')),
                'icon' => $cate->icon,
                'slug' => $cate->slug,
                'status' => $cate->status,
                'featured' => $cate->featured,
                'image' => $cate->cat_image,
                'imagepath' => url('images/category/' . $cate->cat_image),
                'position' => $cate->position,
                'created_at' => $cate->created_at,
                'updated_at' => $cate->updated_at,
                'subcategory' => $cate_subcategory,
            );
        }

        $meeting = Meeting::get();

        $getstarted = GetStarted::first();

        $category_slider = CategorySlider::first();

        $category_slider1 = array();

        if (isset($category_slider)) {

            foreach ($category_slider->category_id as $cats) {
                $catee = Categories::find($cats);

                if (isset($catee)) {
                    $category_slider1[] = array(
                        'id' => $catee->id,
                        'title' => array_map(function ($lang) {
                            return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                        }, $catee->getTranslations('title')),
    
                    );
                }
            }

            $firstcat = Categories::whereHas('courses', function ($q) {

                return $q->where('status', '=', '1');

            })->whereHas('courses.user')->with(['courses', 'courses.user'])->find($category_slider->category_id[0]);

            if (isset($firstcat)) {
                foreach ($firstcat->courses as $course) {
                    $category_slider_courses[] = array(
                        'id' => $course->id,

                        'title' => array_map(function ($lang) {
                            return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                        }, $course->getTranslations('title')),
                        'level_tags' => $course->level_tags,
                        'short_detail' => array_map(function ($lang) {
                            return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                        }, $course->getTranslations('short_detail')),
                        'price' => $course->price,
                        'discount_price' => $course->discount_price,
                        'featured' => $course->featured,
                        'status' => $course->status,
                        'preview_image' => $course->preview_image,
                        'imagepath' => url('images/course/' . $course->preview_image),
                        'total_rating_percent' => course_rating($course->id)->getData()->total_rating_percent,
                        'total_rating' => course_rating($course->id)->getData()->total_rating,
                        'in_wishlist' => Is_wishlist::in_wishlist($course->id),
                        'instructor' => array(
                        'id' => $course->user->id,
                        'name' => $course->user->fname . ' ' . $course->user->lname,
                        'image' => url('/images/user_img/' . $course->user->user_img),
                        ),

                    );
                }

                $category_slider1[0]['course'] = $category_slider_courses;
            }
        }

        return response()->json(array('settings' => $settings,  'adsense' => $adsense, 'currency' => $currency, 'slider' => $slider, 'sliderfacts' => $sliderfacts, 'trusted' => $trusted, 'testimonial' => $testimonial_result, 'category' => $category, 'subcategory' => $subcategory, 'childcategory' => $childcategory, 'featured_cate' => $featured_cate, 'meeting' => $meeting, 'getstarted' => $getstarted, 'allcategory' => $all_categories, 'category_slider' => $category_slider1), 200);
    }

    public function main()
    {
        return response()->json(array('ok'), 200);
    }

    public function course(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $course = Course::where('status', 1)->with('include')->with('whatlearns')->with('review')->get();

        $course = $course->map(function ($c) use ($course) {

            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            return $c;

        });

        return response()->json(array('course' => $course), 200);
    }

    public function recentcourse(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $course = Course::where('status', 1)->orderBy('id', 'DESC')->with('include')->with('whatlearns')->with('user')->get();

        $course = $course->map(function ($c) use ($course) {

            $reviews = ReviewRating::where('course_id', $c->id)->where('status', '1')->get();
            $count = ReviewRating::where('course_id', $c->id)->count();
            $learn = 0;
            $price = 0;
            $value = 0;
            $sub_total = 0;
            $sub_total = 0;
            $course_total_rating = 0;
            $total_rating = 0;

            if ($count > 0) {

                foreach ($reviews as $review) {
                    $learn = $review->learn * 5;
                    $price = $review->price * 5;
                    $value = $review->value * 5;
                    $sub_total = $sub_total + $learn + $price + $value;
                }

                $count = ($count * 3) * 5;
                $rat = $sub_total / $count;
                $ratings_var0 = ($rat * 100) / 5;

                $course_total_rating = $ratings_var0;
            }

            $count = ($count * 3) * 5;

            if ($count != "" && $count != '0') {
                $rat = $sub_total / $count;

                $ratings_var = ($rat * 100) / 5;

                $overallrating = ($ratings_var0 / 2) / 10;

                $total_rating = round($overallrating, 1);
            }

            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            $c['total_rating_percent'] = round($course_total_rating, 2);
            $c['total_rating'] = $total_rating;

            return $c;

        });

        return response()->json(array('course' => $course), 200);
    }

    public function featuredcourse(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $featured = Course::where('status', 1)->where('featured', 1)->with('include')->with('whatlearns')->with('review')->with('user')->get();

        $featured = $featured->map(function ($c) use ($featured) {

            $reviews = ReviewRating::where('course_id', $c->id)->where('status', '1')->get();
            $count = ReviewRating::where('course_id', $c->id)->count();
            $learn = 0;
            $price = 0;
            $value = 0;
            $sub_total = 0;
            $sub_total = 0;
            $course_total_rating = 0;
            $total_rating = 0;

            if ($count > 0) {

                foreach ($reviews as $review) {
                    $learn = $review->learn * 5;
                    $price = $review->price * 5;
                    $value = $review->value * 5;
                    $sub_total = $sub_total + $learn + $price + $value;
                }

                $count = ($count * 3) * 5;
                $rat = $sub_total / $count;
                $ratings_var0 = ($rat * 100) / 5;

                $course_total_rating = $ratings_var0;
            }

            $count = ($count * 3) * 5;

            if ($count != "" && $count != '0') {
                $rat = $sub_total / $count;

                $ratings_var = ($rat * 100) / 5;

                $overallrating = ($ratings_var0 / 2) / 10;

                $total_rating = round($overallrating, 1);
            }

            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            $c['total_rating_percent'] = round($course_total_rating, 2);
            $c['total_rating'] = $total_rating;
            return $c;

        });

        return response()->json(array('featured' => $featured), 200);
    }

    public function bundle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $bundles = BundleCourse::where('status', 1)->get();

        $result = array();
        if(isset($courses_in_bundle))
    {
        foreach ($bundles as $bundle) {

            $courses_in_bundle = array();

            foreach ($bundle->course_id as $bundles) {
                $course = Course::where('id', $bundles)->first();

                $courses_in_bundle[] = array(
                    'id' => $course->id,
                    'user' => $course->user->fname,
                    'title' => $course->title,
                    'short_detail' => $course->short_detail,
                    'image' => $course->preview_image,
                    'img_path' => url('images/course/' . $course->preview_image),
                    'type' => $course->type,
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                );

            }

            $result[] = array(
                'id' => $bundle->id,
                'user' => $bundle->user->fname . ' ' . $bundle->user->lname,
                'user_image' => $bundle->user->user_img,
                'user_image_path' => url('images/user_img/' . $bundle->user->user_img),
                'course_id' => $bundle->course_id,
                'title' => $bundle->title,
                'detail' => strip_tags($bundle->detail),
                'price' => $bundle->price,
                'discount_price' => $bundle->discount_price,
                'type' => $bundle->type,
                'slug' => $bundle->slug,
                'status' => $bundle->status,
                'featured' => $bundle->featured,
                'preview_image' => $bundle->preview_image,
                'imagepath' => url('images/bundle/' . $bundle->preview_image),
                'created_at' => $bundle->created_at,
                'updated_at' => $bundle->updated_at,
                'course' => $courses_in_bundle,
            );
        }
    }
        if (empty($result)) {
            return response()->json(array('bundle' => $result), 200);
        }

        return response()->json(array('bundle' => $result), 200);
    }

    public function studentfaq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $faq = FaqStudent::where('status', 1)->get();
        return response()->json(array('faq' => $faq), 200);
    }

    public function instructorfaq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $faq = FaqInstructor::where('status', 1)->get();
        return response()->json(array('faq' => $faq), 200);
    }

    public function blog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $blog = Blog::where('status', 1)->get();

        $blog_result = array();

        foreach ($blog as $data) {

            $blog_result[] = array(
                'id' => $data->id,
                'user' => $data->user_id,
                'date' => $data->date,
                'image' => $data->image,
                'heading' => preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($data->heading))),
                'detail' => preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($data->detail))),
                'text' => $data->text,
                'approved' => $data->approved,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('blog' => $blog_result), 200);
    }

    public function blogdetail(Request $request)
    {
        $this->validate($request, [
            'blog_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $blog = Blog::where('id', $request->blog_id)->where('status', 1)->with('user')->get();

        return response()->json(array('blog' => $blog), 200);
    }

    public function recentblog(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $blog = Blog::where('status', 1)->orderBy('id', 'DESC')->get();

        return response()->json(array('blog' => $blog), 200);
    }

    public function showwishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();

        $wishlist = Wishlist::where('user_id', $user->id)

            ->with(['courses' => function ($query) {
                $query->with('user');
            }])->get();

        return response()->json(array('wishlist' => $wishlist), 200);

    }

    public function addtowishlist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $orders = Order::where('user_id', $auth->id)->where('course_id', $request->course_id)->first();

        $wishlist = Wishlist::where('course_id', $request->course_id)->where('user_id', $auth->id)->first();

        if (isset($orders)) {

            return response()->json('You Already purchased this course !', 401);
        } else {

            if (!empty($wishlist)) {

                return response()->json('Course is already in wishlist !', 401);
            } else {

                $wishlist = Wishlist::create([

                    'course_id' => $request->course_id,
                    'user_id' => $auth->id,
                ]);

                return response()->json('Course is added to your wishlist !', 200);
            }

        }

    }
    public function quiz_reports(Request $request, $id)
    {
        $auth = Auth::user();
        $topic = QuizTopic::where('id',$id)->get();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics=QuizTopic::where('id',$id)->first();
        $ans = QuizAnswer::where('user_id',$auth->id)
              ->where('topic_id',$id)->get();


        $mark = 0;
        $ca=0;
        $correct = collect();

        foreach ($ans as $answer)
        {
            $mark++;
            $ca++;

        }

        
        $correct = $ca;

        $per_question_mark = $topics->per_q_mark;

        $correct = $mark*$topics->per_q_mark;

        $correct_ans = $correct;
                    
                      
               


        return response()->json([
            'question_count' => $count_questions,
            'correct_count' => $mark,
            'correct_answer' => $correct,
            'per_question_mark' => $per_question_mark,
            'total_marks' => $correct_ans
        ]);

      
    }

    public function removewishlist(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $wishlist = Wishlist::where('course_id', $request->course_id)->where('user_id', $auth->id)->delete();

        if ($wishlist == 1) {
            return response()->json(array('1'), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function userprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();
        $code = $user->token();
        return response()->json(array('user' => $user, 'code' => $code->id), 200);
    }

    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $request->validate([
            'email' => 'required',
            'current_password' => 'required',
        ]);
        $input = $request->all();

        if (Hash::check($request->current_password, $auth->password)) {
            if ($file = $request->file('user_img')) {
                if ($auth->user_img != null) {
                    $image_file = @file_get_contents(public_path() . '/images/user_img/' . $auth->user_img);
                    if ($image_file) {
                        unlink(public_path() . '/images/user_img/' . $auth->user_img);
                    }
                }
                $name = time() . $file->getClientOriginalName();
                $file->move('images/user_img', $name);
                $input['user_img'] = $name;
            }
            $auth->update([
                'fname' => isset($input['fname']) ? $input['fname'] : $auth->fname,
                'lname' => isset($input['lname']) ? $input['lname'] : $auth->lname,
                'email' => $input['email'],
                'password' => isset($input['password']) ? bcrypt($input['password']) : $auth->password,
                'mobile' => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
                'dob' => isset($input['dob']) ? $input['dob'] : $auth->dob,
                'user_img' => isset($input['user_img']) ? $input['user_img'] : $auth->user_img,
                'address' => isset($input['address']) ? $input['address'] : $auth->address,
                'detail' => isset($input['detail']) ? $input['detail'] : $auth->detail,
            ]);

            $auth->save();
            return response()->json(array('auth' => $auth), 200);
        } else {
            return response()->json('error: password doesnt match', 400);
        }

    }

    public function addtocart(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $courses = Course::where('id', $request->course_id)->first();

        $orders = Order::where('user_id', $auth->id)->where('course_id', $request->course_id)->first();
        $cart = Cart::where('course_id', $request->course_id)->where('user_id', $auth->id)->first();

        if (isset($courses)) {
            if ($courses->type == 1) {
                if (isset($orders)) {
                    return response()->json('You Already purchased this course !', 401);
                } else {

                    if (!empty($cart)) {
                        return response()->json('Course is already in cart !', 401);
                    } else {
                        $cart = Cart::create([

                            'course_id' => $request->course_id,
                            'user_id' => $auth->id,
                            'category_id' => $courses->category_id,
                            'price' => $courses->price,
                            'offer_price' => $courses->discount_price,
                        ]);

                        return response()->json('Course is added to your cart !', 200);
                    }
                }
            } else {
                return response()->json('Course is free', 401);
            }
        } else {
            return response()->json('Invalid Course ID', 401);
        }

    }

    public function removecart(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $cart = Cart::where('course_id', $request->course_id)->where('user_id', $auth->id)->delete();

        if ($cart == 1) {
            return response()->json(array('1'), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function showcart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();

        $carts = Cart::where('user_id', $user->id)
            ->with('courses')

            ->with(['courses' => function ($query) {
                $query->with('user');
            }])

            ->with(['bundle' => function ($query) {
                $query->with('user');
            }])

            ->get();

        $price_total = 0;
        $offer_total = 0;
        $cpn_discount = 0;
        $offer_percent = 0;
        $offer_amount = 0;

        //cart price after offer
        foreach ($carts as $key => $c) {
            if ($c->offer_price != 0) {
                $offer_total = $offer_total + $c->offer_price;
            } else {
                $offer_total = $offer_total + $c->price;
            }
        }

        //for price total
        foreach ($carts as $key => $c) {

            $price_total = $price_total + $c->price;

        }

        //for coupon discount total
        foreach ($carts as $key => $c) {

            $cpn_discount = $cpn_discount + $c->disamount;
        }

        $cart_total = 0;

        foreach ($carts as $key => $c) {

            if ($cpn_discount != 0) {
                $cart_total = $offer_total - $cpn_discount;
            } else {

                $cart_total = $offer_total;
            }
        }

        //for offer percent
        foreach ($carts as $key => $c) {
            if ($cpn_discount != 0) {
                $offer_amount = $price_total - ($offer_total - $cpn_discount);
                $value = $offer_amount / $price_total;
                $offer_percent = $value * 100;
            } else {
                $offer_amount = $price_total - $offer_total;
                $value = $offer_amount / $price_total;
                $offer_percent = $value * 100;
            }
        }

        return response()->json(array(
            'cart' => $carts,
            'price_total' => $price_total,
            'offer_total' => $price_total - $offer_total,
            'cpn_discount' => $cpn_discount,
            'offer_percent' => round($offer_percent, 2),
            'cart_total' => $cart_total,

        ), 200);

    }

    public function removeallcart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $cart = Cart::where('user_id', $auth->id)->delete();

        if (isset($cart)) {
            return response()->json(array('1'), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function addbundletocart(Request $request)
    {

        $this->validate($request, [
            'bundle_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $bundle_course = BundleCourse::where('id', $request->bundle_id)->first();

        $orders = Order::where('user_id', $auth->id)->where('bundle_id', $request->bundle_id)->first();

        $cart = Cart::where('bundle_id', $request->bundle_id)->where('user_id', $auth->id)->first();

        if (isset($bundle_course)) {
            if ($bundle_course->type == 1) {
                if (isset($orders)) {

                    return response()->json('You Already purchased this course !', 401);
                } else {

                    if (!empty($cart)) {

                        return response()->json('Bundle Course is already in cart !', 401);
                    } else {

                        $cart = Cart::create([

                            'bundle_id' => $request->bundle_id,
                            'user_id' => $auth->id,
                            'type' => '1',
                            'price' => $bundle_course->price,
                            'offer_price' => $bundle_course->discount_price,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ]);

                        return response()->json('Bundle Course is added to your cart !', 200);
                    }

                }
            } else {
                return response()->json('Bundle course is free !', 401);
            }

        } else {
            return response()->json('Invalid Bundle Course ID !', 401);
        }

    }

    public function removebundlecart(Request $request)
    {
        $this->validate($request, [
            'bundle_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $cart = Cart::where('bundle_id', $request->bundle_id)->where('user_id', $auth->id)->delete();

        if ($cart == 1) {
            return response()->json(array('1'), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function detailpage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            $private_courses = PrivateCourse::where('status', 1)->where('course_id', '=', $request->course_id)->first();

            if (isset($private_courses)) {
                $user_id = array();
                array_push($user_id, $private_courses->user_id);
                $user_id = array_values(array_filter($user_id));
                $user_id = array_flatten($user_id);

                $user_id;

                if (in_array($user->id, $user_id)) {

                    return response()->json(['Unauthorized Action'], 401);
                }
            }
        }

        $result = Course::where('id', '=', $request->course_id)->where('status', 1)

            ->with('category')

            ->with(['include' => function ($query) {
                $query->where('status', 1);
            }])

            ->with(['whatlearns' => function ($query) {
                $query->where('status', 1);
            }])
            ->with(['related' => function ($query) {
                $query->where('status', 1)->with('courses');
            }])
            ->with(['language' => function ($query) {
                $query->where('status', 1);
            }])

            ->with('user')

            ->with(['order' => function ($query) {
                $query->where('status', 1);
            }])
            ->with(['chapter' => function ($query) {
                $query->where('status', 1)->with('user');
            }])

            ->with(['courseclass' => function ($query) {
                $query->where('status', 1)->with('user');
            }])

            ->with('policy')->first();

        if (!$result) {
            return response()->json('404 | Course not found !');
        }

        if (isset($result->review)) {

            $ratings_var11 = 0;
            $review_like = 0;
            $review_dislike = 0;

            foreach ($result->review as $key => $review) {

                $user_count = count([$review]);
                $user_sub_total = 0;
                $user_learn_t = $review->learn * 5;
                $user_price_t = $review->price * 5;
                $user_value_t = $review->value * 5;
                $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;

                $user_count = ($user_count * 3) * 5;
                $rat1 = $user_sub_total / $user_count;
                $ratings_var11 = ($rat1 * 100) / 5;

                $review_like = ReviewHelpful::where('review_id', $review->id)->where('course_id', $request->course_id)->where('review_like', 1)->count();

                $review_dislike = ReviewHelpful::where('review_id', $review->id)->where('course_id', $request->course_id)->where('review_dislike', 1)->count();

                $reviewszz[] = [
                    'id' => $review->id,
                    'user_id' => $review->user_id,
                    'fname' => $review->user->fname,
                    'lname' => $review->user->lname,
                    'userimage' => $review->user->user_img,
                    'imagepath' => url('images/user_img/'),
                    'learn' => $review->learn,
                    'price' => $review->price,
                    'value' => $review->value,
                    'reviews' => $review->review,
                    'created_by' => $review->created_at,
                    'updated_by' => $review->updated_at,
                    'total_rating' => $ratings_var11,
                    'like_count' => $review_like,
                    'dislike_count' => $review_dislike,

                ];
            }

        }

        $reviews = ReviewRating::where('course_id', $request->course_id)->where('status', '1')->get();
        $count = ReviewRating::where('course_id', $request->course_id)->count();
        $learn = 0;
        $price = 0;
        $value = 0;
        $sub_total = 0;
        $sub_total = 0;
        $course_total_rating = 0;
        $total_rating = 0;

        if ($count > 0) {

            foreach ($reviews as $review) {
                $learn = $review->learn * 5;
                $price = $review->price * 5;
                $value = $review->value * 5;
                $sub_total = $sub_total + $learn + $price + $value;
            }

            $count = ($count * 3) * 5;
            $rat = $sub_total / $count;
            $ratings_var0 = ($rat * 100) / 5;

            $course_total_rating = $ratings_var0;
        }

        $count = ($count * 3) * 5;

        if ($count != "" && $count != '0') {
            $rat = $sub_total / $count;

            $ratings_var = ($rat * 100) / 5;

            $overallrating = ($ratings_var0 / 2) / 10;

            $total_rating = round($overallrating, 1);
        }

        //learn
        $learn = 0;
        $total = 0;
        $total_learn = 0;

        if ($count > 0) {

            $count = ReviewRating::where('course_id', $request->course_id)->count();

            foreach ($reviews as $review) {
                $learn = $review->learn * 5;
                $total = $total + $learn;
            }

            $count = ($count * 1) * 5;
            $rat = $total / $count;
            $ratings_var1 = ($rat * 100) / 5;

            $total_learn = $ratings_var1;
        }

        //price
        $price = 0;
        $total = 0;
        $total_price = 0;

        if ($count > 0) {
            $count = ReviewRating::where('course_id', $request->course_id)->count();

            foreach ($reviews as $review) {
                $price = $review->price * 5;
                $total = $total + $price;
            }

            $count = ($count * 1) * 5;
            $rat = $total / $count;
            $ratings_var2 = ($rat * 100) / 5;

            $total_price = $ratings_var2;
        }

        //value
        $value = 0;
        $total = 0;
        $total_value = 0;

        if ($count > 0) {
            $count = ReviewRating::where('course_id', $request->course_id)->count();

            foreach ($reviews as $review) {
                $value = $review->value * 5;
                $total = $total + $value;
            }

            $count = ($count * 1) * 5;
            $rat = $total / $count;
            $ratings_var3 = ($rat * 100) / 5;

            $total_value = $ratings_var3;
        }

        $student_enrolled = Order::where('course_id', $request->course_id)->count();

        return response()->json([
            'course' => $result->makeHidden(['review']),
            'review' => isset($reviewszz) ? $reviewszz : null,
            'learn' => $total_learn,
            'price' => $total_price,
            'value' => $total_value,
            'total_rating_percent' => $course_total_rating,
            'total_rating' => $total_rating,
            'student_enrolled' => isset($student_enrolled) ? $student_enrolled : null,
        ]);
    }

    public function pages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        return response()->json(['pages' => Page::get()], 200);
    }

    public function allnotification(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();
        $notifications = $user->unreadnotifications;

        if ($notifications) {
            return response()->json(array('notifications' => $notifications), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function notificationread(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $userunreadnotification = Auth::guard('api')->user()->unreadNotifications->where('id', $id)->first();

        if ($userunreadnotification) {
            $userunreadnotification->markAsRead();
            return response()->json(array('1'), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function readallnotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $notifications = auth()->User()->unreadNotifications()->count();

        if ($notifications > 0) {

            $user = auth()->User();

            foreach ($user->unreadNotifications as $unnotification) {
                $unnotification->markAsRead();
            }

            return response()->json(array('1'), 200);
        } else {
            return response()->json(array('Notification already marked as read !'), 401);
        }
    }

    public function instructorprofile(Request $request)
    {
        $this->validate($request, [
            'instructor_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = User::where('id', $request->instructor_id)->first();
        $course_count = Course::where('user_id', $user->id)->count();
        $enrolled_user = Order::where('instructor_id', $user->id)->count();
        $course = Course::where('user_id', $user->id)->get();

        if ($user) {

            return response()->json(array('user' => $user, 'course' => $course, 'course_count' => $course_count, 'enrolled_user' => $enrolled_user), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function review(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $review = ReviewRating::where('course_id', $request->course_id)->with('user')->get();

        $review_count = ReviewRating::where('course_id', $request->course_id)->count();

        if ($review) {

            return response()->json(array('review' => $review), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function duration(Request $request)
    {
        $this->validate($request, [
            'chapter_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $chapter = CourseChapter::where('course_id', $request->chapter_id)->first();

        if ($chapter) {

            $duration = CourseClass::where('coursechapter_id', $chapter->id)->sum("duration");
        } else {
            return response()->json(['Invalid Chapter ID !'], 401);
        }

        if ($chapter) {

            return response()->json(array('duration' => $duration), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }

    public function apikeys(Request $request)
    {

        $key = DB::table('api_keys')->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        return response()->json(array('key' => $key), 200);
    }

    public function coursedetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $course = Course::where('status', 1)

            ->with(['include' => function ($query) {
                $query->where('status', 1);
            }])

            ->with(['whatlearns' => function ($query) {
                $query->where('status', 1);
            }])
            ->with(['related' => function ($query) {
                $query->where('status', 1);
            }])

            ->with('review')

            ->with(['language' => function ($query) {
                $query->where('status', 1);
            }])

            ->with('user')

            ->with(['order' => function ($query) {
                $query->where('status', 1);
            }])
            ->with(['chapter' => function ($query) {
                $query->where('status', 1);
            }])

            ->with(['courseclass' => function ($query) {
                $query->where('status', 1);
            }])

            ->with('policy')->get();

        return response()->json(array('course' => $course), 200);

    }

    public function showcoupon(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $coupon = Coupon::get();

        return response()->json(array('coupon' => $coupon), 200);
    }

    public function becomeaninstructor(Request $request)
    {

        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'age' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'detail' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $users = Instructor::where('user_id', $auth->id)->get();

        if (!$users->isEmpty()) {

            return response()->json('Already Requested !', 401);
        } else {

            if ($file = $request->file('image')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images/instructor', $name);
                $input['image'] = $name;
            }

            if ($file = $request->file('file')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/instructor/', $name);
                $input['file'] = $name;
            }

            $input = $request->all();

            $instructor = Instructor::create([
                'user_id' => $auth->id,
                'fname' => isset($input['fname']) ? $input['fname'] : $auth->fname,
                'lname' => isset($input['lname']) ? $input['lname'] : $auth->lname,
                'email' => $input['email'],
                'mobile' => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
                'age' => isset($input['age']) ? $input['age'] : $auth->age,
                'image' => isset($input['image']) ? $input['image'] : $auth->image,
                'file' => $input['file'],
                'detail' => isset($input['detail']) ? $input['detail'] : $auth->detail,
                'gender' => isset($input['gender']) ? $input['gender'] : $auth->gender,
                'status' => '0',
            ]);

            return response()->json(array('instructor' => $instructor), 200);
        }

    }

    public function aboutus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $about = About::all()->toArray();
        return response()->json(array('about' => $about), 200);
    }

    public function contactus(Request $request)
    {

        $this->validate($request, [
            'fname' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'message' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $created_contact = Contact::create([
            'fname' => $request->fname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]
        );

        return response()->json(array('contact' => $created_contact), 200);
    }

    public function courseprogress(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $course = Course::where('status', 1)->where('id', $request->course_id)->first();

        $progress = CourseProgress::where('course_id', $course->id)->where('user_id', $auth->id)->first();

        return response()->json(array('progress' => $progress), 200);

    }

    public function courseprogressupdate(Request $request)
    {

        $this->validate($request, [
            'checked' => 'required',
            'course_id' => 'required',
        ]);

        $course_return = $request->checked;

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $course = Course::where('id', $request->course_id)->first();

        $progress = CourseProgress::where('course_id', $course->id)->where('user_id', $auth->id)->first();

        if (isset($progress)) {

            $chapter = CourseChapter::where('status', 1)->where('course_id', $course->id)->get();

            $chapter_id = array();

            foreach ($chapter as $c) {
                array_push($chapter_id, "$c->id");
            }

            CourseProgress::where('course_id', $course->id)->where('user_id', '=', $auth->id)
                ->update([
                    'mark_chapter_id' => $course_return,
                    'all_chapter_id' => $chapter_id,
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);

            return response()->json('Updated sucessfully !', 200);
        } else {

            $chapter = CourseChapter::where('status', 1)->where('course_id', $course->id)->get();

            $chapter_id = array();

            foreach ($chapter as $c) {
                array_push($chapter_id, "$c->id");
            }

            $created_progress = CourseProgress::create([
                'course_id' => $course->id,
                'user_id' => $auth->id,
                'mark_chapter_id' => json_decode($course_return, true),
                'all_chapter_id' => $chapter_id,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
            );

            return response()->json(array('created_progress' => $created_progress), 200);
        }

    }

    public function terms(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $terms_policy = Terms::get()->toArray();

        return response()->json(array('terms_policy' => $terms_policy), 200);
    }

    public function career(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $career = Career::get()->toArray();

        return response()->json(array('career' => $career), 200);
    }

    public function zoom(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $meeting = Meeting::get()->toArray();

        return response()->json(array('meeting' => $meeting), 200);
    }

    public function bigblue(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $bigblue = BBL::get()->toArray();

        return response()->json(array('bigblue' => $bigblue), 200);
    }

    public function coursereport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'title' => 'required',
            'email' => 'required',
            'detail' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('detail')) {
                return response()->json(['message' => $errors->first('detail'), 'status' => 'fail']);
            }

        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $created_report = CourseReport::create([
            'course_id' => $course->id,
            'user_id' => $auth->id,
            'title' => $course->title,
            'email' => $auth->email,
            'detail' => $request->detail,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]
        );
        return response()->json(array('message' => 'Course reported!', 'status' => 'success'), 200);
    }

    public function coursecontent(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $result = Course::where('id', '=', $id)->where('status', 1)->first();

        if (!$result) {
            return response()->json('404 | Course not found !');
        }

        $order = Order::where('course_id', $result->id)->get();

        $chapters = CourseChapter::where('course_id', $result->id)
            ->where('status', 1)
            ->with('courseclass')
            ->get();

        $classes = CourseClass::where('course_id', $result->id)->where('status', 1)->get();

        $overview[] = array(
            'course_title' => $result->title,
            'short_detail' => strip_tags($result->short_detail),
            'detail' => strip_tags($result->detail),
            'instructor' => $result->user->fname,
            'instructor_email' => $result->user->email,
            'instructor_detail' => strip_tags($result->user->detail),
            'user_enrolled' => count($order),
            'classes' => count($classes),
        );

        $quiz = array();

        if (isset($result->quiztopic)) {

            foreach ($result->quiztopic as $key => $topic) {

                $questions = [];

                if ($topic->type == null) {

                    foreach ($topic->quizquestion as $key => $data) {

                        if ($data->type == null) {

                            if ($data->answer == 'A') {

                                $correct_answer = $data->a;

                                $options = [
                                    $data->b,
                                    $data->c,
                                    $data->d,
                                ];

                            } elseif ($data->answer == 'B') {
                                $correct_answer = $data->b;

                                $options = [
                                    $data->a,
                                    $data->c,
                                    $data->d,
                                ];

                            } elseif ($data->answer == 'C') {
                                $correct_answer = $data->c;

                                $options = [
                                    $data->a,
                                    $data->b,
                                    $data->d,
                                ];

                            } elseif ($data->answer == 'D') {

                                $correct_answer = $data->d;

                                $options = [
                                    $data->a,
                                    $data->b,
                                    $data->c,
                                ];

                            }

                        }

                        $all_options = [
                            'A' => $data->a,
                            'B' => $data->b,
                            'C' => $data->c,
                            'D' => $data->d,
                        ];

                        $questions[] = [
                            'id' => $data->id,
                            'course' => $result->title,
                            'topic' => $topic->title,
                            'question' => $data->question,
                            'correct' => $correct_answer,
                            'status' => $data->status,
                            'incorrect_answers' => $options,
                            'all_answers' => $all_options,
                            'correct_answer' => $data->answer,

                        ];
                    }

                } elseif ($topic->type == 1) {

                    foreach ($topic->quizquestion as $key => $data) {

                        $questions[] = [
                            'id' => $data->id,
                            'course' => $result->title,
                            'topic' => $topic->title,
                            'question' => $data->question,
                            'status' => $data->status,
                            'correct' => null,
                            'correct' => null,
                            'status' => $data->status,
                            'incorrect_answers' => null,
                            'correct_answer' => null,
                        ];
                    }

                }

                $startDate = '0';

                if (Auth::guard('api')->check()) {

                    $order = Order::where('course_id', $id)->where('user_id', '=', Auth::guard('api')->user()->id)->first();

                    $days = $topic->due_days;
                    $orderDate = optional($order)['created_at'];

                    $bundle = Order::where('user_id', Auth::guard('api')->user()->id)->where('bundle_id', '!=', null)->get();

                    $course_id = array();

                    foreach ($bundle as $b) {
                        $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                        array_push($course_id, $bundle->course_id);
                    }

                    $course_id = array_values(array_filter($course_id));
                    $course_id = array_flatten($course_id);

                    if ($orderDate != null) {
                        $startDate = date("Y-m-d", strtotime("$orderDate +$days days"));
                    } elseif (isset($course_id) && in_array($id, $course_id)) {
                        $startDate = date("Y-m-d", strtotime("$bundle->created_at +$days days"));
                    } else {
                        $startDate = '0';
                    }

                }

                $mytime = \Carbon\Carbon::now()->toDateString();

                $quiz[] = array(
                    'id' => $topic->id,
                    'course_id' => $result->id,
                    'course' => $result->title,
                    'title' => $topic->title,
                    'description' => $topic->description,
                    'per_question_mark' => $topic->per_q_mark,
                    'status' => $topic->status,
                    'quiz_again' => $topic->quiz_again,
                    'due_days' => $topic->due_days,
                    'type' => $topic->type,
                    'created_by' => $topic->created_at,
                    'updated_by' => $topic->updated_at,
                    'quiz_live_days' => $startDate,
                    'today_date' => $mytime,
                    'questions' => $questions,

                );

            }

        }

        $announcement = Announcement::where('course_id', $id)->where('status', 1)->get();

        $announcements = array();

        foreach ($announcement as $announc) {

            $announcements[] = array(
                'id' => $announc->id,
                'user' => $announc->user->fname,
                'course_id' => $announc->courses->title,
                'detail' => strip_tags($announc->announsment),
                'status' => $announc->status,
                'created_at' => $announc->created_at,
                'updated_at' => $announc->updated_at,
            );
        }

        $assign = array();

        if (Auth::guard('api')->check()) {

            $user = Auth::guard('api')->user();

            $assignments = Assignment::where('course_id', $id)->where('user_id', Auth::guard('api')->user()->id)->get();

            foreach ($assignments as $assignment) {

                $assign[] = array(
                    'id' => $assignment->id,
                    'user' => $assignment->user->fname,
                    'course_id' => $assignment->courses->title,
                    'instructor' => $assignment->instructor->fname,
                    'chapter_id' => $assignment->chapter['chapter_name'],
                    'title' => $assignment->title,
                    'assignment' => $assignment->assignment,
                    'assignment_path' => url('files/assignment/' . $assignment->assignment),
                    'type' => $assignment->type,
                    'detail' => strip_tags($assignment->detail),
                    'rating' => $assignment->rating,
                    'created_at' => $assignment->created_at,
                    'updated_at' => $assignment->updated_at,
                );
            }
        }

        $appointments = Appointment::where('course_id', $id)->get();

        $appointment = array();

        foreach ($appointments as $appoint) {

            $appointment[] = array(
                'id' => $appoint->id,
                'user' => $appoint->user->fname,
                'course_id' => $appoint->courses->title,
                'instructor' => $appoint->instructor->fname,
                'title' => $appoint->title,
                'detail' => strip_tags($appoint->detail),
                'accept' => $appoint->accept,
                'reply' => $appoint->reply,
                'status' => $appoint->status,
                'created_at' => $appoint->created_at,
                'updated_at' => $appoint->updated_at,
            );
        }

        $questions = Question::where('course_id', $id)->get();

        $question = array();

        foreach ($questions as $ques) {

            $answer = [];
            foreach ($ques->answers as $key => $data) {

                $answer[] = [
                    'course' => $data->courses->title,
                    'user' => $data->user->fname,
                    'instructor' => $data->instructor->fname,
                    'image' => $ques->instructor->user_img,
                    'imagepath' => url('images/user_img/' . $ques->user->user_img),
                    'question' => $data->question->question,
                    'answer' => strip_tags($data->answer),
                    'status' => $data->status,

                ];
            }

            $question[] = array(
                'id' => $ques->id,
                'user' => $ques->user->fname,
                'instructor' => $ques->instructor->fname,
                'image' => $ques->instructor->user_img,
                'imagepath' => url('images/user_img/' . $ques->user->user_img),
                'course' => $ques->courses->title,
                'title' => strip_tags($ques->question),
                'status' => $ques->status,
                'created_at' => $ques->created_at,
                'updated_at' => $ques->updated_at,
                'answer' => $answer,
            );
        }

        $zoom_meeting = Meeting::where('course_id', '=', $id)->get();
        $bigblue_meeting = BBL::where('course_id', '=', $id)->get();
        $google_meet = Googlemeet::where('course_id', '=', $id)->get();
        $jitsi_meeting = JitsiMeeting::where('course_id', '=', $id)->get();

        $previouspapers = PreviousPaper::where('course_id', '=', $id)->get();

        $papers = array();

        foreach ($previouspapers as $data) {

            $papers[] = array(
                'id' => $data->id,
                'course' => $data->courses->title,
                'title' => $data->title,
                'file' => $data->file,
                'filepath' => url('files/papers/' . $data->file),
                'detail' => strip_tags($data->detail),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('overview' => $overview, 'quiz' => $quiz, 'announcement' => $announcements, 'assignment' => $assign, 'questions' => $question, 'appointment' => $appointment, 'chapter' => $chapters, 'zoom_meeting' => $zoom_meeting, 'bigblue_meeting' => $bigblue_meeting, 'jitsi_meeting' => $jitsi_meeting, 'google_meet' => $google_meet, 'papers' => $papers), 200);
    }

    public function assignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'chapter_id' => 'required',
            'title' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('chapter_id')) {
                return response()->json(['message' => $errors->first('chapter_id'), 'status' => 'fail']);
            }
            if ($errors->first('title')) {
                return response()->json(['message' => $errors->first('title'), 'status' => 'fail']);
            }
            if ($errors->first('file')) {
                return response()->json(['message' => $errors->first('file'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        if ($file = $request->file('file')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('files/assignment', $name);
            $input['assignment'] = $name;
        }
        $assignment = Assignment::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'assignment' => $name,
            'type' => 0,
        ]
        );

        return response()->json(array('message' => 'Assignment submitted successfully', 'status' => "success"), 200);

    }

    public function appointment(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
            'title' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $course = Course::where('id', $request->course_id)->first();

        $appointment = Appointment::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'title' => $request->title,
            'detail' => $request->detail,
            'accept' => '0',
            'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
        ]
        );

        $users = User::where('id', $course->user_id)->first();

        if ($appointment) {
            if (env('MAIL_USERNAME') != null) {
                try {

                    /*sending email*/
                    $x = 'You get Appointment Request';
                    $request = $appointment;
                    Mail::to($users->email)->send(new UserAppointment($x, $request));

                } catch (\Swift_TransportException $e) {
                    return back()->with('success', trans('flash.RequestMailError'));
                }
            }
        }

        return response()->json(array('appointment' => $appointment), 200);

    }

    public function question(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question')) {
                return response()->json(['message' => $errors->first('question'), 'status' => 'fail']);
            }

        }

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $course = Course::where('id', $request->course_id)->first();

        $question = Question::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'status' => 1,
            'question' => $request->question,
        ]
        );

        return response()->json(array('question' => $question), 200);

    }

    public function answer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question_id' => 'required',
            'answer' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question_id')) {
                return response()->json(['message' => $errors->first('question_id'), 'status' => 'fail']);
            }
            if ($errors->first('answer')) {
                return response()->json(['message' => $errors->first('answer'), 'status' => 'fail']);
            }
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $question = Question::where('id', $request->question_id)->first();

        $question = Answer::create([
            'ans_user_id' => $auth->id,
            'ques_user_id' => $question->user_id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'question_id' => $question->id,
            'status' => 1,
            'answer' => $request->answer,
        ]
        );
        return response()->json(array('message' => 'Answer Submitted', 'status' => 'success'), 200);

    }

    public function appointmentdelete(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        Appointment::where('id', $id)->delete();

        return response()->json('Deleted Successfully !', 200);

    }

    public function quizsubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question_id' => 'required',
            'topic_id' => 'required',
            'answer' => 'required',
            'canswer' => 'required',
            'txt_answer' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question_id')) {
                return response()->json(['message' => $errors->first('question_id'), 'status' => 'fail']);
            }
            if ($errors->first('topic_id')) {
                return response()->json(['message' => $errors->first('topic_id'), 'status' => 'fail']);
            }
            if ($errors->first('answer')) {
                return response()->json(['message' => $errors->first('answer'), 'status' => 'fail']);
            }
            if ($errors->first('canswer')) {
                return response()->json(['message' => $errors->first('canswer'), 'status' => 'fail']);
            }
            if ($errors->first('txt_answer')) {
                return response()->json(['message' => $errors->first('txt_answer'), 'status' => 'fail']);
            }
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $question_id = json_decode($request->question_id, true);
        $canswer  = json_decode($request->canswer, true);
        $answer  = json_decode($request->answer , true);
        $txt_answer  = json_decode($request->txt_answer , true);
        if($question_id == ''){
            return response()->json(['message' => "Please pass Question Id Valid Format.", 'status' => 'fail']);
        }
        if($answer == ''){
            return response()->json(['message' => "Please pass Answer in Valid Format.", 'status' => 'fail']);
        }
        if($canswer == ''){
            return response()->json(['message' => "Please pass correct answer in  Valid Format.", 'status' => 'fail']);
        }
        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $topics = QuizTopic::where('id', $request->topic_id)->first();
        $unique_question = array_unique($question_id);
        $quiz_already = QuizAnswer::where('user_id', $auth->id)->where('topic_id', $topics->id)->first();
        if ($topics->type == null) {
            if ($quiz_already == null) {
                for ($i = 0; $i <= count($answer); $i++) {
                    if(isset($unique_question[$i])){
                    $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id', $topics->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                    if ($already_answer == null) {
                        $answers[] = [
                            'user_id' => Auth::guard('api')->user()->id,
                            'user_answer' => $answer[$i],
                            'question_id' => $unique_question[$i],
                            'course_id' => $topics->course_id,
                            'topic_id' => $topics->id,
                            'answer' => $canswer[$i],
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ];
                    }
                }
                }
                QuizAnswer::insert($answers);
            }
            else{
                return response()->json(array('message' => 'Quiz Already Submitted', 'status' => 'Fail'), 402);
            }
        } elseif ($topics->type == 1) {
            if ($quiz_already == null) {
                for ($i = 0; $i <= count($txt_answer); $i++) {
                    if(isset($unique_question[$i])){
                    $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id', $topics->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                    if (!isset($already_answer)) {
                        $answers[] = [
                            'user_id' => Auth::guard('api')->user()->id,
                            'question_id' => $unique_question[$i],
                            'course_id' => $topics->course_id,
                            'topic_id' => $topics->id,
                            'txt_answer' => $txt_answer[$i],
                            'type' => '1',
                            'txt_approved' => '0',
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ];
                    }
                    }
                }
                QuizAnswer::insert($answers);
            }
        }
        return response()->json(array('message' => 'Quiz Submitted', 'status' => 'success'), 200);
    }
    public function userreview(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
            'learn' => 'required|integer|min:1|max:5|between:1,5',
            'price' => 'required|integer|min:1|max:5|between:1,5',
            'value' => 'required|integer|min:1|max:5|between:1,5',
            'review' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $course = Course::where('id', $request->course_id)->first();

        $orders = Order::where('user_id', Auth::guard('api')->User()->id)->where('course_id', $course->id)->first();

        $review = ReviewRating::where('user_id', Auth::guard('api')->User()->id)->where('course_id', $course->id)->first();

        if (!empty($orders)) {
            if (!empty($review)) {
                return response()->json('Already Reviewed !', 402);
            } else {

                $input = $request->all();

                $review = ReviewRating::create([
                    'user_id' => $auth->id,
                    'course_id' => $input['course_id'],
                    'learn' => $input['learn'],
                    'price' => $input['price'],
                    'value' => $input['value'],
                    'review' => $input['review'],
                    'approved' => '1',
                    'featured' => '0',
                    'status' => '1',
                ]);

                return response()->json(array('review' => $review), 200);
            }

        } else {

            return response()->json('Please Purchase course !', 401);

        }

    }

    public function paginationcourse(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $paginator = Course::where('status', 1)->with('include')->with('whatlearns')->with('review')->paginate(5);

        $paginator->getCollection()->transform(function ($c) use ($paginator) {

            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            return $c;

        });

        return response()->json(array('course' => $paginator), 200);
    }

    public function categoryPage(Request $request, $id, $name)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $category = Categories::where('status', '1')->where('id', $id)->first();

        if (!$category) {
            return response()->json(['Invalid Category !']);
        }

        $subcategory = $category->subcategory()->where('status', 1)->get();

        if ($request->type) {

            $course = $category->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);

        } else if ($request->sortby) {

            if ($request->sortby == 'l-h') {

                $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
            }

            if ($request->sortby == 'h-l') {

                $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
            }

            if ($request->sortby == 'a-z') {

                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
                } else {

                    $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 10);

                }
            }

            if ($request->sortby == 'z-a') {

                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
                } else {

                    $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
                }

            }

            if ($request->sortby == 'newest') {

                if ($request->type) {

                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);

                } else {

                    $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);

                }

            }

            if ($request->sortby == 'featured') {

                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 10);
                } else {

                    $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 10);

                }

            } else if ($request->limit) {

                $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
            }

        } else {
            $course = Course::where('status', 1)->where('category_id', $category->id)->paginate($request->limit ?? 10);
        }

        $result = array(
            'id' => $category->id,
            'title' => array_map(function ($lang) {
                return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            }, $category->getTranslations('title')),
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'featured' => $category->featured,
            'image' => $category->cat_image,
            'imagepath' => url('images/category/' . $category->cat_image),
            'position' => $category->position,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'subcategory' => $subcategory,
            'course' => $course,
        );
        return response()->json($result, 200);
    }

    public function subcategoryPage(Request $request, $id, $name)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $category = SubCategory::where('id', $id)->first();
        if (!$category) {
            return response()->json(['Invalid Category !']);
        }
        $subcategory = ChildCategory::where('status', 1)->where('subcategory_id', $category->id)->get();
        if ($request->type) {
            $course = $category->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
        } else if ($request->sortby) {
            if ($request->sortby == 'l-h') {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
            }
            if ($request->sortby == 'h-l') {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
            }
            if ($request->sortby == 'a-z') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
                }
            }
            if ($request->sortby == 'z-a') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
                }
            }
            if ($request->sortby == 'newest') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
                }
            }
            if ($request->sortby == 'featured') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 10);
                }
            } else if ($request->limit) {
                $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
            }
        } else {
            $course = Course::where('status', 1)->where('category_id', $category->id)->paginate($request->limit ?? 10);
        }
        $result = array(
            'id' => $category->id,
            'title' => array_map(function ($lang) {
                return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            }, $category->getTranslations('title')),
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'image' => Avatar::create($category->title),
            'position' => $category->position,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'childcategory' => $subcategory,
            'course' => $course,
        );
        return response()->json($result, 200);
    }
    public function childcategoryPage(Request $request, $id, $name)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $category = ChildCategory::where('id', $id)->first();
        if (!$category) {
            return response()->json(['Invalid Category !']);
        }
        if ($request->type) {
            $course = $category->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
        } else if ($request->sortby) {
            if ($request->sortby == 'l-h') {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
            }
            if ($request->sortby == 'h-l') {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
            }
            if ($request->sortby == 'a-z') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
                }
            }
            if ($request->sortby == 'z-a') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
                }
            }
            if ($request->sortby == 'newest') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
                }
            }
            if ($request->sortby == 'featured') {
                if ($request->type) {
                    $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 10);
                } else {
                    $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 10);
                }
            } else if ($request->limit) {
                $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
            }
        } else {
            $course = Course::where('status', 1)->where('category_id', $category->id)->paginate($request->limit ?? 10);
        }
        $result = array(
            'id' => $category->id,
            'title' => array_map(function ($lang) {
                return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            }, $category->getTranslations('title')),
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'featured' => $category->featured,
            'image' => Avatar::create($category->title),
            'position' => $category->position,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'course' => $course,
        );
        return response()->json($result, 200);
    }

    public function deleteAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'assignment_id' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('assignment_id')) {
                return response()->json(['message' => $errors->first('assignment_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();

        Assignment::where('id', $request->assignment_id)->where('user_id', $user->id)->delete();

        return response()->json(array('watchlist' => $watch), 200);
    }

    public function requestCheck(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $user = Auth::guard('api')->user();

        $alreadyRequest = Instructor::where('user_id', Auth::guard('api')->user()->id)->first();

        if ($alreadyRequest != null) {

            return response()->json([
                "message" => "Already Requested",
            ]);

        }

        return response()->json([
            "message" => "Please Request to became an instructor",
        ]);

    }

    public function cancelRequest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $user = Auth::guard('api')->user();

        if (Instructor::where('user_id', $user->id)->exists()) {
            $instructor = Instructor::where('user_id', $user->id)->first();
            $instructor->delete();

            return response()->json([
                "message" => "records deleted",
            ]);

        } else {
            return response()->json([
                "message" => "Instructor not found",
            ], 404);
        }

    }

    public function watchcourse($id)
    {
        if (Auth::guard('api')->check()) {

            $order = Order::where('status', '1')->where('user_id', Auth::guard('api')->User()->id)->where('course_id', $id)->first();

            $courses = Course::where('id', $id)->first();

            $bundle = Order::where('user_id', Auth::guard('api')->User()->id)->where('bundle_id', '!=', null)->get();

            $gsetting = Setting::first();

            //attandance start
            if (!empty($order)) {
                if ($gsetting->attandance_enable == 1) {

                    $date = Carbon::now();
                    //Get date
                    $date->toDateString();

                    $courseAttandance = Attandance::where('course_id', '=', $id)->where('user_id', Auth::guard('api')->User()->id)->where('date', '=', $date->toDateString())->first();

                    if (!$courseAttandance) {
                        $attanded = Attandance::create([
                            'user_id' => Auth::guard('api')->user()->id,
                            'course_id' => $id,
                            'instructor_id' => $courses->user_id,
                            'date' => $date->toDateString(),
                            'order_id' => $id,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ]
                        );
                    }
                }
            } //attandance end

            $course = Course::findOrFail($id);

            $course_id = array();

            foreach ($bundle as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($course_id, $bundle->course_id);
            }

            $course_id = array_values(array_filter($course_id));

            $course_id = array_flatten($course_id);

            if (Auth::guard('api')->User()->role == "admin") {
                return view('watch', compact('courses'));
            } elseif (Auth::guard('api')->User()->id == $course->user_id) {
                return view('watch', compact('courses'));
            } else {
                if (!empty($order)) {

                    $coursewatch = WatchCourse::where('course_id', '=', $id)->where('user_id', Auth::guard('api')->User()->id)->first();

                    if ($gsetting->device_control == 1) {

                        if (!$coursewatch) {

                            $watching = WatchCourse::create([
                                'user_id' => Auth::guard('api')->user()->id,
                                'course_id' => $id,
                                'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                'active' => '1',
                                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                            );

                            return view('watch', compact('courses'));

                        } else {

                            if ($coursewatch->active == 0) {

                                $coursewatch->active = 1;
                                $coursewatch->save();
                                return view('watch', compact('courses'));
                            } else {

                                return response()->json(array('message' => 'User Already Watching Course !!', 'status' => 'fail'), 402);
                            }

                        }
                    } else {
                        return view('watch', compact('courses'));
                    }

                } elseif (isset($course_id) && in_array($id, $course_id)) {
                    return view('watch', compact('courses'));
                } else {
                    return response()->json(array('message' => 'Unauthorization Action', 'status' => 'fail'), 402);
                }

            }
        }
        return response()->json(array('message' => 'Please Login to Continue', 'status' => 'fail'), 401);
    }

    public function reviewlike(Request $request, $id)
    {

        $user = Auth::user();

        $help = ReviewHelpful::where('review_id', $id)->where('user_id', $user->id)->first();

        if ($request->review_like == '1') {
            if (isset($help)) {

                ReviewHelpful::where('id', $help->id)
                    ->update([
                        'review_like' => '1',
                        'review_dislike' => '0',

                    ]);

            } else {

                $created_review = ReviewHelpful::create([
                    'course_id' => $request->course_id,
                    'user_id' => $user->id,
                    'review_id' => $id,
                    'helpful' => 'yes',
                    'review_like' => '1',

                ]
                );

                ReviewHelpful::where('id', $created_review->id)
                    ->update([
                        'review_dislike' => '0',

                    ]);

            }

        } elseif ($request->review_dislike == '1') {

            if (isset($help)) {

                ReviewHelpful::where('id', $help->id)
                    ->update([
                        'review_dislike' => '1',
                        'review_like' => '0',

                    ]);

            } else {

                $created_review = ReviewHelpful::create([
                    'course_id' => $request->course_id,
                    'user_id' => $user->id,
                    'review_id' => $id,
                    'helpful' => 'yes',
                    'review_dislike' => '1',

                ]
                );

                ReviewHelpful::where('id', $created_review->id)
                    ->update([
                        'review_like' => '0',

                    ]);

            }

        } elseif ($help->review_like == '1') {
            ReviewHelpful::where('id', $help->id)
                ->update([
                    'review_like' => '0',

                ]);

        } elseif ($help->review_dislike == '1') {
            ReviewHelpful::where('id', $help->id)
                ->update([
                    'review_dislike' => '0',

                ]);

        }

        return response()->json(array('message' => 'Updated Successfully', 'status' => 'success'), 200);

    }

    public function getcategoryCourse($catid)
    {

        $cat = Categories::whereHas('courses')
            ->whereHas('courses.user')
            ->where('status', '1')
            ->with(['courses.instructor'])
            ->find($catid);

        if (isset($cat)) {
            foreach ($cat->courses as $course) {

                $category_slider_courses[] = array(
                    'id' => $course->id,

                    'title' => array_map(function ($lang) {
                        return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                    }, $course->getTranslations('title')),
                    'level_tags' => $course->level_tags,
                    'short_detail' => array_map(function ($lang) {
                        return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                    }, $course->getTranslations('short_detail')),
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                    'featured' => $course->featured,
                    'status' => $course->status,
                    'preview_image' => $course->preview_image,
                    'total_rating_percent' => course_rating($course->id)->getData()->total_rating_percent,
                    'total_rating' => course_rating($course->id)->getData()->total_rating,
                    'imagepath' => url('images/course/' . $course->preview_image),
                    'in_wishlist' => Is_wishlist::in_wishlist($course->id),
                    'instructor' => array(
                        'id' => $course->user->id,
                        'name' => $course->user->fname . ' ' . $course->user->lname,
                        'image' => url('/images/user_img/' . $course->user->user_img),
                    ),
                );
            }

            $category_slider1['course'] = $category_slider_courses;

            return response()->json([
                'course' => $category_slider_courses,
            ]);
        } else {
            return response()->json([
                'course' => null,
                'msg' => 'No courses or category found !',
            ]);
        }

    }
    public function mycourses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();

        $enroll = Order::where('user_id', $user->id)->where('status', 1)->get()
                    ->transform(function ($order) {

                        $order['bundle_course_id'] = isset($order->bundle) ? $order->bundle->course_id : null;
                        return $order;

                    });

        $enroll_details = array();
        $title = null;
        if (isset($enroll)) {
            foreach ($enroll as $enrol) {

                $course = Course::where('status', 1)
                    ->where('id', $enrol->course_id)
                    ->with(['include' => function ($query) {
                        $query->where('status', 1);
                    }])
                    ->with(['user'])
                    ->with(['whatlearns' => function ($query) {
                        $query->where('status', 1);
                    }])
                    ->with(['progress' => function ($query) {
                        $query->where('user_id', Auth::guard('api')->user()->id);
                    }])
                    ->first();

                if (!isset($course)) {
                    $bundle = BundleCourse::where('id', $enrol->bundle_id)->with('user')->first();
                }

                if (isset($bundle)) {
                    $title = $bundle->title;
                }

                if (isset($bundle) || isset($course)) {

                    $total_rating_percent = 0;
                    $course_total_rating = 0;
                    $total_rating = 0;

                    if (isset($course)) {
                        $reviews = ReviewRating::where('course_id', $course->id)->where('status', '1')->get();
                        $count = ReviewRating::where('course_id', $course->id)->count();
                        $learn = 0;
                        $price = 0;
                        $value = 0;
                        $sub_total = 0;
                        $sub_total = 0;
                        $title = $course->title;

                        if ($count > 0) {
                            foreach ($reviews as $review) {
                                $learn = $review->learn * 5;
                                $price = $review->price * 5;
                                $value = $review->value * 5;
                                $sub_total = $sub_total + $learn + $price + $value;
                            }
                            $count = ($count * 3) * 5;
                            $rat = $sub_total / $count;
                            $ratings_var0 = ($rat * 100) / 5;
                            $course_total_rating = $ratings_var0;
                        }

                        $count = ($count * 3) * 5;

                        if ($count != "" && $count != '0') {
                            $rat = $sub_total / $count;
                            $ratings_var = ($rat * 100) / 5;
                            $overallrating = ($ratings_var0 / 2) / 10;
                            $total_rating = round($overallrating, 1);
                        }
                        $total_rating_percent = round($course_total_rating, 2);
                        $total_rating = $total_rating;
                    }

                    $enroll_details[] = array(
                        'title' => $title,
                        'enroll' => $enrol,
                        'course' => $course ?? null,
                        'bundle' => $bundle ?? null,
                        'total_rating_percent' => $total_rating_percent,
                        'total_rating' => $total_rating,
                    );
                }

            }
        }
        return response()->json(['enroll_details' => $enroll_details], 200);
    }
    public function useraccount($id){
        if (env('DEMO_LOCK') == 1) {
            return back()->with('deleted', __('This action is disabled in the demo !'));
        }
        $user = User::findOrFail($id);


        if ($user->image) {
            unlink(public_path() . 'images/users/' . $user->image);
        }
        if (isset($user->plans)) {
            foreach ($user->plans as $plan_delete) {
                $plan_delete->delete();
            }
        }

        if (isset($user->bundle)) {
            foreach ($user->bundle as $bundle_delete) {
                $bundle_delete->delete();
            }
        }

        if (isset($user->completed)) {
            foreach ($user->completed as $completed_delete) {
                $completed_delete->delete();
            }
        }
        

        if (isset($user->pending)) {
            foreach ($user->pending as $pending_delete) {
                $pending_delete->delete();
            }
        }

        if (isset($user->orders)) {
            foreach ($user->orders as $orders_delete) {
                $orders_delete->delete();
            }
        }
        
        if (isset($user->courseclass)) {
            foreach ($user->courseclass as $courseclass_delete) {
                $courseclass_delete->delete();
            }
        }
        
        if (isset($user->relatedcourse)) {
            foreach ($user->relatedcourse as $relatedcourse_delete) {
                $relatedcourse_delete->delete();
            }
        }
        
        if (isset($user->orders)) {
            foreach ($user->orders as $orders_delete) {
                $orders_delete->delete();
            }
        }
        
        if (isset($user->blogs)) {
            foreach ($user->blogs as $blogs_delete) {
                $blogs_delete->delete();
            }
        }
        
        if (isset($user->wishlist)) {
            foreach ($user->wishlist as $wishlist_delete) {
                $wishlist_delete->delete();
            }
        }
        
       
        if (isset($user->reportreview)) {
            foreach ($user->reportreview as $reportreview_delete) {
                $reportreview_delete->delete();
            }
        }
        if (isset($user->review)) {
            foreach ($user->review as $review_delete) {
                $review_delete->delete();
            }
        }
        if (isset($user->announsment)) {
            foreach ($user->announsment as $announsment_delete) {
                $announsment_delete->delete();
            }
        }
        if (isset($user->answer)) {
            foreach ($user->answer as $answer_delete) {
                $answer_delete->delete();
            }
        }
        if (isset($user->courses)) {
            foreach ($user->courses as $courses_delete) {
                $courses_delete->delete();
            }
        }
       
      if($user->delete())
        {   
          return response([
              'message' => ['User has been Deleted sucessfully.']
          ], 200);
        }
        else{
            return response([
                'message' => ['Error']
            ], 201);
        }

}
public function test()
{
   return $students = json_decode(file_get_contents(storage_path() . "resources/lang/ar.json"), true);

}
}
