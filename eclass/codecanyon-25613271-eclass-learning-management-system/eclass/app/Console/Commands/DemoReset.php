<?php

namespace App\Console\Commands;
use App\Blog;
use App\Course;
use App\CourseInclude;
use App\WhatLearn;
use App\CourseChapter;
use App\CourseClass;
use App\RelatedCourse;
use App\Categories;
use App\SubCategory;
use App\ChildCategory;
use App\Wishlist;
use App\ReviewRating;
use App\Question;
use App\Announcement;
use App\Order;
use App\Answer;
use App\Cart;
use App\ReportReview;
use App\QuizTopic;
use App\Quiz;
use App\BundleCourse;
use App\CourseProgress;
use App\Adsense;
use App\Assignment;
use App\Appointment;
use App\BBL;
use App\Slider;
use App\SliderFacts;
use App\Testimonial;
use App\Trusted;
use App\GetStarted;
use App\Page;
use App\WidgetSetting;
use App\CategorySlider;
use App\Instructor;
use App\FaqInstructor;
use App\FaqStudent;
use Session;



use Illuminate\Console\Command;

class DemoReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will reset your demo !';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $this->info('Demo is resetting...');

            Session::flush();

            
            Blog::truncate();
            Course::truncate();
            CourseInclude::truncate();
            WhatLearn::truncate();
            CourseChapter::truncate();
            CourseClass::truncate();
            RelatedCourse::truncate();
            Categories::truncate();
            SubCategory::truncate();
            ChildCategory::truncate();
            Wishlist::truncate();
            ReviewRating::truncate();
            Question::truncate();
            Announcement::truncate();
            Order::truncate();
            Answer::truncate();
            Cart::truncate();
            ReportReview::truncate();
            QuizTopic::truncate();
            Quiz::truncate();
            BundleCourse::truncate();
            CourseProgress::truncate();
            Adsense::truncate();
            Assignment::truncate();
            Appointment::truncate();
            BBL::truncate();
            Slider::truncate();
            SliderFacts::truncate();
            Testimonial::truncate();
            Trusted::truncate();
            GetStarted::truncate();
            Page::truncate();
            WidgetSetting::truncate();
            CategorySlider::truncate();
            Instructor::truncate();
            FaqInstructor::truncate();
            FaqStudent::truncate();

            $dir_session = base_path().'/storage/framework/sessions';

            foreach (glob("$dir_session/*") as $file) {
               
                unlink($file);
                
            }


            $leave_files = array('index.php');

            $dir0 = public_path() . '/images/blog';

            foreach (glob("$dir0/*") as $file) {

                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }

            }

            $dir1 = public_path() . '/images/category';

            foreach (glob("$dir1/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }

            }

            $dir = public_path() . '/images/course';

            foreach (glob("$dir/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir2 = public_path() . '/images/careers';

            foreach (glob("$dir2/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir3 = public_path() . '/images/about';

            foreach (glob("$dir3/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir4 = public_path() . '/images/category';

            foreach (glob("$dir4/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir5 = public_path() . '/images/getstarted';

            foreach (glob("$dir5/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir6 = public_path() . '/images/testimonial';

            foreach (glob("$dir6/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir8 = public_path() . '/images/instructor';

            foreach (glob("$dir8/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir12 = public_path() . '/images/order';

            foreach (glob("$dir12/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            

            $dir14 = public_path() . '/images/slider';

            foreach (glob("$dir14/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir15 = public_path() . '/images/trusted';

            foreach (glob("$dir15/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            

            $dir17 = public_path() . '/images/bundle';

            foreach (glob("$dir17/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir18 = public_path() . '/video/class';

            foreach (glob("$dir18/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            

            $this->info('Demo Reset Successfully !');
            
        } catch (\Exception $e) {
            die('Database connection is not OK check .env file for more....');
        }

    }
}