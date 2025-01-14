<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Navigationbar -->

        <div class="navigationbar">
            
            <div class="vertical-menu-detail">

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade active show" id="v-pills-dashboard" role="tabpanel"
                        aria-labelledby="v-pills-dashboard">
                        <ul class="vertical-menu">
                            <div class="logobar">
                                <a href="{{ url('/') }}" class="logo logo-large">
                                    <img style="object-fit:scale-down;" src="{{ url('images/logo/'.$gsetting->logo) }}"
                                        class="img-fluid" alt="logo">
                                </a>
                            </div>
                             <li class="{{ Nav::isRoute('admin.index') }}">
                                <a class="nav-link" href="{{route('admin.index')}}">
                                    <i class="feather icon-pie-chart text-secondary"></i>
                                    <span>{{ __('Dashboard') }}</span>
                                </a>
                            </li>
                            
                            @can(['marketing-dashboard.manage'])
                            <li class="{{ Nav::isRoute('market.index') }}">
                                <a class="nav-link" href="{{route('market.index')}}">
                                    <i class="feather icon-activity text-secondary"></i>
                                    <span>{{ __('Marketing Dashboard') }}</span>
                                </a>
                            </li>
                            @endcan
                            <!-- dashboard end -->
                            @canany(['users.view','Alluser.view','Allinstructor.view','Alladmin.view'])
                            <li class="header">{{ __('Users') }}</li>
                            <!-- user start  -->
                            <!-- user start  -->
                            <li class="{{ Nav::isRoute('user.index') }} {{ Nav::isRoute('user.add') }} {{ Nav::isRoute('user.edit') }}{{ Nav::isRoute('alluser.index') }} {{ Nav::isRoute('alluser.add') }} {{ Nav::isRoute('alluser.edit') }}{{ Nav::isRoute('allinstructor.index') }} {{ Nav::isRoute('allinstructor.add') }} {{ Nav::isRoute('allinstructor.edit') }}{{ Nav::isResource('roles') }}">
                                <a href="javaScript:void();">
                                    <i class="feather icon-users text-secondary"></i><span>{{ __('Users') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('users.view')
                                    <li>
                                        <a class="{{ Nav::isResource('user') }}"
                                            href="{{route('user.index')}}">{{ __('All Users') }}</a>
                                    </li>
                                    @endcan
                                    @can('Alluser.view')
                                    <li>
                                        <a class="{{ Nav::isResource('allusers') }}"
                                            href="{{route('allusers.index')}}">{{ __('All Students') }}</a>
                                    </li>
                                    @endcan
                                    @can('Allinstructor.view')
                                    <li>
                                        <a class="{{ Nav::isResource('allinstructor') }}"
                                            href="{{route('allinstructor.index')}}">{{ __('All Instructors') }}</a>
                                    </li>
                                    @endcan 
                                    @can('Alladmin.view')
                                    <li>
                                        <a class="{{ Nav::isResource('alladmin') }}"
                                            href="{{route('alladmin.index')}}">{{ __('All Admins') }}</a>
                                    </li>
                                    @endcan
                                    @can('Alladmin.view')
                                    <li>
                                        <a class="{{ Nav::isResource('alladmin') }}"
                                            href="{{route('user.verify')}}">{{ __('Verify User') }}</a>
                                    </li>
                                    @endcan
                                    @can('Alladmin.view')
                                    <li>
                                        <a class="{{ Nav::isResource('roles') }}"
                                            href="{{route('roles.index')}}">{{ __('Roles And Permission') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            @canany(['instructorrequest.view','instructor-pending-request.manage','instructor-plan-subscription.view','instructor-payout-setting.manage','instructor-pending-payout.manage'])
                            <li
                                class="{{ Nav::isResource('plan/subscribe/settings') }} {{ Nav::isResource('subscription/plan') }}  {{ Nav::isRoute('all.instructor') }} {{ Nav::isResource('requestinstructor') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-user text-secondary"></i><span>{{ __('Instructors') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('instructorrequest.view')
                                    <li class="{{ Nav::isRoute('all.instructor') }}"><a
                                            href="{{route('all.instructor')}}">{{ __('All') }}
                                            {{ __('InstructorRequest') }}</a></li>
                                     @endcan 
                                    @can('instructor-pending-request.manage')
                                    <li class="{{ Nav::isResource('requestinstructor') }}"><a
                                            href="{{url('requestinstructor')}}">{{ __('Pending') }}
                                            {{ __('Request') }}</a></li>
                                    @endcan
                                    @can('instructor-plan-subscription.view')
                                    <li class="{{ Nav::isResource('plan/subscribe/settings') }}"><a
                                            href="{{url('plan/subscribe/settings')}}">{{ __('Instructor') }}
                                            {{ __('Subscription') }}</a></li>
                                    @endcan 
                                    @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
                                    <li class="{{ Nav::isResource('subscription/plan') }}"><a
                                            href="{{url('subscription/plan')}}">{{ __('Instructor Plan') }}</a>
                                    </li>
                                    @endif
                                    <!-- MultipleInstructor start  -->
                                    <li
                                        class="{{ Nav::isRoute('allrequestinvolve') }} {{ Nav::isRoute('involve.request.index') }} {{ Nav::isRoute('involve.request') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('MultipleInstructor') }}</span>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('requestinvole.manage')
                                            <li class="{{ Nav::isRoute('allrequestinvolve') }}"><a
                                                href="{{route('allrequestinvolve')}}">{{ __('Request to Involve') }}</a>
                                            </li>
                                            @endcan
                                            @can('involvement.view')
                                            <li class="{{ Nav::isRoute('involve.request.index') }}"><a
                                                href="{{route('involve.request.index')}}">{{ __('Involvement Requests') }}</a>
                                            </li>  
                                            <li class="{{ Nav::isRoute('involve.request') }}"><a
                                                href="{{route('involve.request')}}">{{ __('InvolvedInCourse') }}</a>
                                            </li> 
                                            @endcan
                                            
                                            @can('instructorCourseVerify')
                                            <li class="{{ Nav::isResource('instructor/course') }}"><a href="{{url('instructor/course')}}">{{ __('Instructor Course') }}</a></li>
                                            @endcan

                                        </ul>
                                    </li>
                                    <!-- MultipleInstructor end  -->
                                    <!-- InstructorPayout start  -->
                                    <li
                                        class="{{ Nav::isRoute('instructor.settings') }} {{ Nav::isRoute('admin.instructor') }} {{ Nav::isRoute('admin.completed') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Instructor Payout') }}</span>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('instructor-payout-setting.manage')
                                            <li class="{{ Nav::isRoute('instructor.settings') }}"><a
                                                href="{{route('instructor.settings')}}">{{ __('Payout Settings') }}</a>
                                            </li>
                                            @endcan
                                            @can('instructor-pending-payout.manage')
                                            <li class="{{ Nav::isRoute('admin.instructor') }}"><a
                                                href="{{route('admin.instructor')}}">{{ __('Pending Payout') }}</a>
                                            </li>  
                                            @endcan
                                        </ul>
                                    </li>
                                    <!-- InstructorPayout end  -->
                                </ul>
                            </li>
                            @endcanany
                            <!-- user end -->
                            @canany(['categories.view','courses.view','bundle-courses.view','course-languages.view','course-reviews.view','assignment.view','refund-policy.view','batch.view','quiz-review.view','private-course.view','reported-course.view','reported-question.view','courses.view'])

                            <li class="header">{{ __('Education') }}</li>
                            <!-- ====================Course start======================== -->
                            <li
                                class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('bundle') }} {{ Nav::isResource('courselang') }} {{ Nav::isResource('coursereview') }} {{ Nav::isRoute('assignment.view') }} {{ Nav::isResource('refundpolicy') }} {{ Nav::isResource('batch') }} {{ Nav::isRoute('quiz.review') }} {{ Nav::isResource('private-course') }} {{ Nav::isResource('admin/report/view') }} {{ Nav::isResource('user/question/report') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-book text-secondary"></i><span>{{ __('Course') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <!-- Category start  -->
                                    @canany(['categories.view','subcategories.view','childcategories.views'])
                                    <li
                                        class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Category') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can(['categories.view'])
                                            <li class="{{ Nav::isResource('category') }}"><a
                                                    href="{{url('category')}}">{{ __('Category') }}</a>
                                            </li>
                                            @endcan
                                            @can(['subcategories.view'])
                                            <li class="{{ Nav::isResource('subcategory') }}"><a
                                                    href="{{url('subcategory')}}">{{ __('SubCategory') }}</a>
                                            </li>
                                            @endcan
                                            @can(['childcategories.view'])
                                            <li class="{{ Nav::isResource('childcategory') }}"><a
                                                    href="{{url('childcategory')}}">{{ __('ChildCategory') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcanany


                                    <!-- Category end  -->
                                    @can(['courses.view'])
                                    <li class="{{ Nav::isResource('course') }}"><a
                                            href="{{url('course')}}"><span>{{ __('Courses') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['bundle-courses.view'])
                                    <li class="{{ Nav::isResource('bundle') }}"><a
                                            href="{{url('bundle')}}"><span>{{ __('Bundle Course') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['course-languages.view'])
                                    <li class="{{ Nav::isResource('courselang') }}"><a
                                            href="{{url('courselang')}}"><span>{{ __('Course Language') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['course-reviews.view'])
                                    <li class="{{ Nav::isResource('coursereview') }}"><a
                                            href="{{url('coursereview')}}"><span>{{ __('Course Review') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['assignment.view'])
                                    @if($gsetting->assignment_enable == 1)
                                    <li class="{{ Nav::isRoute('assignment.view') }}"><a
                                            href="{{route('assignment.view')}}"><span>{{ __('Assignment') }}</span></a>
                                    </li>
                                    @endif
                                    @endcan
                                    @can(['refund-policy.view'])
                                    <li class="{{ Nav::isResource('refundpolicy') }}"><a
                                            href="{{url('refundpolicy')}}"><span>{{ __('Refund Policy') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['batch.view'])
                                    <li class="{{ Nav::isResource('batch') }}"><a
                                            href="{{url('batch')}}"><span>{{ __('Batch') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['quiz-review.view'])
                                    <li class="{{ Nav::isRoute('quiz.review') }}"><a
                                            href="{{route('quiz.review')}}"><span>{{ __('Quiz Review') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['private-course.view'])
                                    <li class="{{ Nav::isResource('private-course') }}"><a
                                            href="{{url('private-course')}}"><span>{{ __('Private Course') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['reported-course.view'])
                                    <li class="{{ Nav::isResource('admin/report/view') }}">
                                        <a href="{{url('admin/report/view')}}">{{ __('Reported') }}
                                            {{ __('Course') }}
                                        </a>
                                    </li>
                                    @endcan
                                    
                                    @can(['reported-question.view'])
                                    <li class="{{ Nav::isResource('user/question/report') }}">
                                        <a href="{{url('user/question/report')}}">{{ __('Reported') }}
                                            {{ __('Question') }}</a>
                                    </li>
                                    @endcan
                                    @can('courses.view')
                                    <li>
                                        <a href="{{url('instructor/course')}}" class="menu"><i class="feather icon-check-circle text-secondary"></i>
                                            <span>{{ __('Modified Courses Review') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!--=================== Course end====================================  -->
                            <!-- ====================Meetings start======================== -->
                            @canany(['meetings.zoom-meetings.view','meetings.big-blue.view','meetings.google-meet.view','meetings.jitsi-meet.view','meetings.google-classroom.view','meetings.meeting-recordings.view'])
                            <li
                                class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }} {{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }} {{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }} {{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }} {{ Nav::isResource('meeting-recordings') }}">
                                <a href="javaScript:void();">
                                    <i class="feather icon-clock text-secondary"></i>
                                    <span>{{ __('Meetings') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <!-- ZoomLiveMeetings start  -->
                                    @if(isset($zoom_enable) && $zoom_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Zoom Meetings') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('meetings.zoom-meetings.view')
                                            <li class="{{ Nav::isRoute('zoom.setting') }}"><a
                                                href="{{route('zoom.setting')}}">{{ __('Settings') }}</a>
                                            </li> 
                                            <li
                                                class="{{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('meeting.create') }}">
                                                <a href="{{route('zoom.index')}}">{{ __('Dashboard') }}</a>
                                            </li>

                                            <li class="{{ Nav::isRoute('meeting.show') }}"><a
                                                    href="{{route('meeting.show')}}">{{ __('AllMeetings') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endif
                                    <!-- ZoomLiveMeetings end  -->
                                    <!-- BigBlueMeetings start  -->
                                    @if(isset($gsetting) && $gsetting->bbl_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Big Blue') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('meetings.big-blue.view')
                                            <li class="{{ Nav::isRoute('bbl.setting') }}"><a
                                                href="{{ route('bbl.setting') }}">{{ __('Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('bbl.all.meeting') }}"><a
                                                    href="{{ route('bbl.all.meeting') }}">{{ __('ListMeetings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('download.meeting') }}"><a
                                                    href="{{ route('download.meeting') }}">{{ __('Recorded') }}</a>
                                            </li> 
                                            @endcan
                                        </ul>
                                    </li>
                                    @endif
                                    <!-- BigBlueMeetings end  -->

                                    <!-- Google Meet Meeting start  -->
                                    @if(isset($gsetting) && $gsetting->googlemeet_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Google Meet') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('meetings.google-meet.view  ')
                                            <li class="{{ Nav::isRoute('googlemeet.setting') }}"><a
                                                    href="{{route('googlemeet.setting')}}">{{ __('Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('googlemeet.index') }}"><a
                                                    href="{{route('googlemeet.index')}}">{{ __('Dashboard') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('googlemeet.allgooglemeeting') }}"><a
                                                    href="{{route('googlemeet.allgooglemeeting')}}">{{ __('AllMeetings') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endif
                                    <!-- Google Meet Meeting end  -->

                                    <!-- Jitsi Meeting start -->
                                    @if(isset($gsetting) && $gsetting->jitsimeet_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Jitsi Meeting') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('meetings.jitsi-meet.view ')
                                            <li class="{{ Nav::isRoute('jitsi.dashboard') }}"><a
                                                    href="{{ route('jitsi.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endif

                                    @if(Module::find('Googleclassroom') && Module::find('googleclassroom')->isEnabled())
                                    @include('googleclassroom::layouts.admin_sidebar_menu')
                                    @endif
                                    <!-- Jitsi Meeting end -->
                                    @can('meeting-recordings.view')
                                    <li class="{{ Nav::isResource('meeting-recordings') }}"><a
                                            href="{{url('meeting-recordings')}}"><span>{{ __('MeetingRecordings') }}</span></a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            @can(['institute.view'])
                            <li><a href="{{url('institute')}}"><i
                                        class="feather icon-grid text-secondary"></i><span>{{ __('Institute') }}</span></a>
                            </li>
                            @endcan
                            @can('alumini.view')
                            <li>
                                <a href="{{url('alumini')}}" class="menu"><i class="feather icon-user-check text-secondary"></i>
                                    <span>{{ __('Alumini') }}</span>
                            </li>
                            @endcan
                            @can('certificate.manage')
                            @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                            @include('certificate::admin.sidebar_menu')
                            @endif
                            @can('certificate.manage')
                            <li class="{{ Nav::isRoute('certificate.index') }}"><a
                                    href="{{route('certificate.index')}}">
                                    <i
                                    class="feather icon-help-circle text-secondary"></i><span>{{ __('Certificate Verify') }}</span>
                                </a>
                            </li>
                            @endcan
                            @endcan

                            <!--===================meeting end====================================  -->
                            <!-- ====================instructor start======================== -->

                            <!--===================instructor end====================================  -->
                            <li class="header">{{ __('Marketing') }}</li>
                            @can(['coupons.view'])
                            <li class="{{ Nav::isResource('coupon') }}"><a href="{{url('coupon')}}"><i
                                        class="feather icon-award text-secondary"></i><span>{{ __('Coupon') }}</span></a>
                            </li>
                            @endcan
                            @can(['followers.manage'])
                            <li class="{{ Nav::isRoute('follower.view') }}"><a href="{{route('follower.view')}}"><i
                                        class="feather icon-help-circle text-secondary"></i><span>{{ __('Followers') }}</span></a>
                            </li>
                            @endcan
                            @canany(['affiliate.manage',' wallet-setting.manage','wallet-transactions.manage'])
                            <li
                                class="{{ Nav::isRoute('save.affiliates') }} {{ Nav::isRoute('wallet.settings') }} {{ Nav::isRoute('wallet.transactions') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-dollar-sign text-secondary"></i><span>{{ __('Affiliate & Wallet') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['affiliate.manage'])
                                    <li class="{{ Nav::isRoute('save.affiliates') }}">
                                        <a href="{{route('save.affiliates')}}">{{ __('Affiliate') }}</a>
                                    </li>
                                    @endcan
                                    @canany(['wallet-setting.manage','wallet-transactions.manage'])

                                    <li class="{{ Nav::isRoute('wallet.settings') }} {{ Nav::isRoute('wallet.transactions') }}">
                                        <a href="javaScript:void();">
                                            <span>{{ __('Wallet') }}</span>
                                    @endcan  
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can(['wallet-setting.manage'])
                                            <li class="{{ Nav::isRoute('wallet.settings') }}"><a
                                                    href="{{route('wallet.settings')}}">{{ __('Wallet') }}
                                                    {{ __('Setting') }}</a>
                                            </li>
                                            @endcan
                                            @can(['wallet-transactions.manage'])
                                            <li class="{{ Nav::isRoute('wallet.transactions') }}"><a
                                                    href="{{route('wallet.transactions')}}">{{ __('Wallet') }}
                                                    {{ __('Transactions') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            @endcanany
                            <!-- PushNotification -->
                            @can(['push-notification.manage'])
                            <li class="{{ Nav::isRoute('onesignal.settings') }}">
                                <a href="{{route('onesignal.settings')}}"><i class="feather icon-navigation text-secondary"></i><span>{{ __('Push Notification') }}</span></a>
                            </li>
                            @endcan
                            @can(['flash-deals.view'])
                            <li class="{{ Nav::isResource('admin/flash-sales') }}"><a
                                    href="{{url('admin/flash-sales')}}"><i
                                        class="feather icon-clock text-secondary"></i>
                                    <span>{{ __('Flash Deals') }}</span></a>
                            </li>
                            @endcan
                            <!-- attandance -->
                            @can(['attendance.manage'])
                            @if(isset($gsetting) && $gsetting->attandance_enable == 1)
                            <li class="{{ Nav::isResource('attandance') }}"><a href="{{url('attandance')}}"><i
                                        class="feather icon-user text-secondary"></i><span>{{ __('Attandance') }}</span></a>
                            </li>
                            @endif
                            @endcan
                            <!-- coupon -->
                            @can(['orders.manage'])
                            <li class="header">{{ __('Financial') }}</li>
                            <!-- order -->
                            <li class="{{ Nav::isResource('order') }}"><a href="{{url('order')}}"><i
                                        class="feather icon-shopping-cart text-secondary"></i><span>{{ __('Order') }}</span></a>
                            </li>
                            @endcan

                            <!-- order -->
                            <li class="header">{{ __('Content') }}</li>
                            @if(Module::has('Chatboard') && Module::find('Chatboard')->isEnabled())
                            @include('chatboard::front.icon')
                            @endif
                            @can(['blogs.view'])

                            <li class="{{ Nav::isResource('blog') }}">
                                <a href="{{url('blog')}}"><i class="feather icon-message-square"></i>
                                    <span>{{ __('Blogs') }}</span>
                                </a>
                            </li>
                            @endcan
                           
                            <!-- pages start -->
                            @can(['pages.view'])
                            <li class="{{ Nav::isResource('page') }}"><a
                                    href="{{url('page')}}"><i class="feather icon-file-text"></i><span>{{ __('Pages') }}</span></a> 
                            </li>
                            @endcan
                            <!-- pages end -->
                            <!-- report start  -->
                            @canany(['report.progress-report.manage','report.quiz-report.manage','report.revenue-admin-report.manage','report.revenue-instructor-report.manage'])
                            <li
                                class="{{ Nav::isResource('user/course/report') }} {{ Nav::isResource('user/question/report') }}{{url('show/progress/report')}} {{ Nav::isResource('show/quiz/report') }}">
                                <a href="javaScript:void();">
                                    <i class="feather icon-file-text text-secondary"></i><span>{{ __('Report') }}</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('report.quiz-report.manage')
                                    <li class="{{ Nav::isResource('show/quiz/report') }}">
                                        <a href="{{url('show/quiz/report')}}">{{ __('Quiz') }} {{ __('Report') }} </a>
                                    </li>
                                    @endcan
                                    @can('report.progress-report.manage')
                                    <li class="{{ Nav::isResource('show/progress/report') }}">
                                        <a href="{{url('show/progress/report')}}">{{ __('Progress') }}
                                            {{ __('Report') }}</a>
                                    </li>
                                    @endcan
                                    <!-- revenue report start  -->
                                    <li
                                        class="{{ Nav::isRoute('admin.revenue.report') }} {{ Nav::isRoute('instructor.revenue.report') }}{{ Nav::isResource('device-logs') }}">
                                        <a href="javaScript:void();"><span>{{ __('Revenue') }}
                                                {{ __('Report') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can('report.revenue-admin-report.manage')
                                            <li class="{{ Nav::isRoute('admin.revenue.report') }}">
                                                <a
                                                    href="{{route('admin.revenue.report')}}">{{ __('Admin Revenue') }}</a>
                                            </li>  
                                            @endcan
                                            @can('report.revenue-instructor-report.manage')
                                            <li class="{{ Nav::isRoute('instructor.revenue.report') }}">
                                                <a
                                                    href="{{route('instructor.revenue.report')}}">{{ __('Instructor Revenue') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @can('orders.manage')
                                    <li class="{{ Nav::isResource('admin/report/view') }}">
                                        <a href="{{ route('order.report') }}">
                                            {{ __('Financial reports') }} </a>
                                    </li>
                                    @endcan
                                    @can('reported-course.view')
                                    <li class="{{ Nav::isResource('device-logs') }}">
                                        <a href="{{url('device-logs')}}">{{ __('Device History') }} </a>
                                    </li>
                                    @endcan
                                    @can('certificate.manage')
                                    <li class="{{ Nav::isResource('report/certificate') }}">
                                        <a href="{{url('report/certificate')}}">{{ __('Certificate Report') }} </a>
                                    </li>
                                    @endcan
                                    @can('attendance.manage')
                                    <li class="{{ Nav::isResource('attand/report') }}">
                                        <a href="{{url('attand/report')}}">{{ __('Attandance Report') }} </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!-- report end -->
                            <!-- forum -->
                            @can('forum-discussion.manage')
                            @if(Module::find('forum') && Module::find('forum')->isEnabled())
                            @include('forum::layouts.admin_sidebar_menu')
                            @endif
                            @endcan
                            @can(['about.manage'])
                            <li class="{{ Nav::isRoute('about.page') }}">
                                <a href="{{route('about.page')}}"><i
                                        class="feather icon-external-link text-secondary"></i>{{ __('About') }}</a>
                            </li>
                            @endcan
                            <!-- faq start  -->
                            @canany(['faq.faq-student.view','faq.faq-instructor.view'])
                            <li class="{{ Nav::isResource('faq') }} {{ Nav::isResource('faqinstructor') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-help-circle text-secondary"></i><span>{{ __('Faq') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('faq.faq-student.view')
                                    <li class="{{ Nav::isResource('faq') }}">
                                        <a href="{{url('faq')}}">{{ __('FaqStudent') }}</a>
                                    </li>
                                    @endcan
                                    @can('faq.faq-instructor.view')
                                    <li class="{{ Nav::isResource('faqinstructor') }}">
                                        <a href="{{url('faqinstructor')}}">{{ __('Faq Instructor') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            @can(['career.manage'])
                            <li class="{{ Nav::isRoute('careers.page') }}">
                                <a href="{{route('careers.page')}}"><i
                                        class="feather icon-sidebar text-secondary"></i>{{ __('Career') }}</a>
                            </li>
                            @endcan
                            <!-- faq end -->
                            <!-- location start -->
                            @canany(['locations.country.view','locations.state.view','locations.city.view'])
                            <li class="{{ Nav::isResource('admin/country') }} {{ Nav::isResource('admin/state') }} {{ Nav::isResource('admin/city') }}">
                                <a href="javaScript:void();">
                                    <i class="fa fa-map-marker text-secondary"></i><span>{{ __('Locations') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['locations.country.view'])
                                    <li class="{{ Nav::isResource('admin/country') }}">
                                        <a href="{{url('admin/country')}}">{{ __('Country') }}</a>
                                    </li>
                                    @endcan
                                    @can(['locations.state.view'])
                                    <li class="{{ Nav::isResource('admin/state') }}">
                                        <a href="{{url('admin/state')}}">{{ __('State') }}</a>
                                    </li>
                                    @endcan
                                    @can(['locations.city.view'])
                                    <li class="{{ Nav::isResource('admin/city') }}">
                                        <a href="{{url('admin/city')}}">{{ __('City') }}</a>
                                    </li>
                                    @endcan

                                </ul>
                            </li>
                            @endcanany
                            <!-- contact us start -->
                            @can('contact-us.manage')
                            <li class="{{ Nav::isResource('usermessage') }}">
                                <a href="{{url('usermessage')}}"><i class="feather icon-phone-call text-secondary"></i><span>{{ __('Contact Us') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('job.manage')
                            @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                            @include('resume::front.job.admin.icon')
                            @endif
                            @endcan
                            <!-- contact us end -->
                            <!-- location end -->
                            <li class="header">{{ __('Setting') }}</li>
                            @if(Module::has('Upi') && Module::find('Upi')->isEnabled())
                            @include('upi::icon')
                            @endif
                            @can(['get-api-key.manage'])
                            @can(['get-api-key.manage'])
                            <li class="{{ Nav::isRoute('get.api.key') }}">
                                <a href="{{route('get.api.key')}}"><i
                                class="feather icon-share text-secondary"></i><span>{{ __('Get API Keys') }}</span></a>
                            </li>
                            @endcan
                            @can(['currency.view'])
                            <li class="{{ Nav::isRoute('currency.index') }}"><a href="{{route('currency.index')}}"><i
                                        class="feather icon-dollar-sign text-secondary"></i><span>{{ __('Currency') }}</span></a>
                            </li>
                            @endcan
                            @can(['themes.manage'])
                            <li class="{{ Nav::isRoute('themesettings.index') }}">
                                <a href="{{route('themesettings.index')}}">
                                    <i class="feather icon-airplay text-secondary"></i>
                                    <span>{{ __('Themes') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('mobilesetting.manage')
                            <li class="{{ Nav::isRoute('mobile/setting') }}">
                                <a href="{{url('mobile/setting')}}" class="menu">
                                    <i class="feather icon-tablet text-secondary"></i>
                                    <span>{{ __('Mobile Setting') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('downloadqr.manage')
                            <li class="{{ Nav::isRoute('mobileqr') }}">
                                <a href="{{url('mobileqr')}}" class="menu">
                                    <i class="feather icon-maximize text-secondary"></i>
                                    <span>{{ __('QR Setting') }}</span>
                                </a>
                            </li>
                            @endcan
                            <!-- front setting start  -->
                            @canany(['front-settings.testimonial.view','front-settings.advertisement.view','front-settings.sliders.view','front-settings.fact-slider.view','category-sliders.manage','get-started.manage','front-settings.trusted-sliders.view','widget.manage','front-settings.seo-directory.view','coming-soon.manage','terms-condition.manage','privacy-policy.manage','invoice-design.manage','login-signup.manage','video-setting.manage','breadcum-setting.manage','front-settings.fact-slider.view','join-an-instructor.manage','serviceSetting.manage','admin.searvice.view','admin.features.view','admin.featuresetting.manage'])
                            <li
                                class="{{ Nav::isResource('testimonial') }} {{ Nav::isResource('advertisement') }} {{ Nav::isResource('slider') }} {{ Nav::isResource('facts') }} {{ Nav::isRoute('category.slider') }} {{ Nav::isResource('getstarted') }} {{ Nav::isResource('trusted') }} {{ Nav::isRoute('widget.setting') }} {{ Nav::isRoute('terms') }} {{ Nav::isResource('directory') }} {{ Nav::isRoute('videosetting') }} {{ Nav::isRoute('breadcum') }} {{ Nav::isRoute('fact') }} {{ Nav::isRoute('joininstructor') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-monitor text-secondary"></i><span>{{ __('Front Setting') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['front-settings.testimonial.view'])
                                    <li class="{{ Nav::isResource('testimonial') }}"><a
                                            href="{{url('testimonial')}}"><span>{{ __('Testimonial') }}</span></a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isResource('admin/menu') }}">
                                        <a href="{{url('admin/menu')}}">
                                            <span>{{ __('Menu Customiosation') }}</span>
                                        </a>
                                    </li>
                                    @can(['front-settings.advertisement.view'])
                                    <li class="{{ Nav::isResource('advertisement') }}"><a
                                            href="{{url('advertisement')}}"><span>{{ __('Advertisement')}}</span></a>
                                    </li>
                                    @endcan
                                    @can(['front-settings.sliders.view'])
                                    <li class="{{ Nav::isResource('slider') }}"><a
                                            href="{{url('slider')}}"><span>{{ __('Slider') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['front-settings.fact-slider.view'])
                                    <li class="{{ Nav::isResource('facts') }}"><a
                                            href="{{url('facts')}}"><span>{{ __('Fact Slider') }}</span></a>
                                    </li>
                                    @endcan

                                    @can(['category-sliders.manage'])
                                    <li class="{{ Nav::isRoute('category.slider') }}"><a
                                            href="{{route('category.slider')}}"><span>{{ __('Category Slider') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['get-started.manage'])

                                    <li class="{{ Nav::isResource('getstarted') }}"><a
                                            href="{{url('getstarted')}}">{{ __('Get Started') }}</a>
                                    </li>
                                    @endcan
                                    @can(['front-settings.trusted-sliders.view'])
                                    <li class="{{ Nav::isResource('trusted') }}"><a
                                            href="{{url('trusted')}}"><span>{{ __('Trusted Slider') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['widget.manage'])
                                    
                                    <li class="{{ Nav::isRoute('widget.setting') }}"><a
                                            href="{{route('widget.setting')}}">{{ __('Widget') }}</a>
                                    </li>
                                    @endcan
                                    @can(['front-settings.seo-directory.view'])
                                    <li class="{{ Nav::isResource('directory') }}"><a
                                            href="{{url('directory')}}"><span>{{ __('Seo') }}
                                                {{ __('Directory') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['coming-soon.manage'])

                                    <li class="{{ Nav::isRoute('comingsoon.page') }}">
                                        <a
                                            href="{{route('comingsoon.page')}}">{{ __('Coming Soon') }}</a>
                                    </li>
                                    @endcan
                                    @can(['terms-condition.manage'])
                                    <li class="{{ Nav::isRoute('termscondition') }}">
                                        <a href="{{route('termscondition')}}">{{ __('Terms & Condition') }}
                                        </a>
                                    </li>
                                    @endcan
                                    @can(['privacy-policy.manage'])
                                    <li class="{{ Nav::isRoute('policy') }}">
                                        <a href="{{route('policy')}}">{{ __('Privacy Policy') }}</a>
                                    </li>
                                    @endcan
                                    @can(['invoice-design.manage'])
                                    <li class="{{ Nav::isRoute('invoice/settings') }}">
                                        <a href="{{ url('invoice/settings') }}">{{ __('Invoice Design') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can(['login-signup.manage'])
                                    <li class="{{ Nav::isRoute('login') }}">
                                        <a href="{{ url('settings/login') }}">{{ __('Login/Signup') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can(['homepage-setting.manage'])
                                    <li class="{{ Nav::isRoute('homepage.setting') }}">
                                        <a href="{{route('homepage.setting')}}"><span>{{ __('Homepage Setting') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['video-setting.manage'])
                                    <li class="{{ Nav::isRoute('videosetting') }}">
                                        <a href="{{ route('videosetting') }}">{{ __('Video Setting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can(['breadcum-setting.manage'])
                                    <li class="{{ Nav::isRoute('breadcum') }}">
                                        <a href="{{ url('breadcum/setting') }}">{{ __('Breadcum Setting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can(['front-settings.fact-slider.view'])
                                    <li class="{{ Nav::isRoute('fact') }}">
                                        <a href="{{ url('fact') }}">{{ __('Fact Setting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can(['join-an-instructor.manage'])
                                    <li class="{{ Nav::isRoute('joininstructor') }}">
                                        <a href="{{ url('join/setting') }}">{{ __('Join an Instructor') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can('serviceSetting.manage')
                                    <li class="{{ Nav::isRoute('setting/service') }}">
                                        <a href="{{ url('setting/service') }}">{{ __('Service Setting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can('admin.searvice.view')
                                    <li class="{{ Nav::isRoute('service') }}">
                                        <a href="{{ url('service') }}">{{ __('Services') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can('admin.features.view')
                                    <li class="{{ Nav::isRoute('feature') }}">
                                        <a href="{{ url('feature') }}">{{ __('Feature') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can('admin.featuresetting.manage')
                                    <li class="{{ Nav::isRoute('setting/feature') }}">
                                        <a href="{{ url('setting/feature') }}">{{ __('Feature Setting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany

                            <!-- front setting end -->
                            <!-- site setting start  -->
                            @canany(['settings.manage','pwa.manage','adsense-setting.manage','twilio-setting.manage','site-map-setting.manage','site-settings.language.view','email-design.manage','admin.costomisation.manage'])
                            <li
                                class="{{ Nav::isRoute('gen.set') }} {{ Nav::isRoute('careers.page') }}  {{ Nav::isRoute('termscondition') }} {{ Nav::isRoute('policy') }}  {{ Nav::isRoute('show.pwa') }} {{ Nav::isRoute('adsense') }} {{ Nav::isRoute('ipblock.view') }}   {{ Nav::isRoute('twilio.settings') }} {{ Nav::isRoute('show.sitemap') }} {{ Nav::isRoute('show.lang') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-settings text-secondary"></i><span>{{ __('Site Setting') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    @can(['settings.manage'])
                                     <li class="{{ Nav::isRoute('gen.set') }}">
                                        <a href="{{route('gen.set')}}">{{ __('Setting') }}</a>
                                    </li>
                                    @endcan
                                    @can('admin.costomisation.manage')
                                    <li class="{{ Nav::isRoute('admincustomisation') }}">
                                        <a href="{{url('admincustomisation')}}"><span><span>{{ __('Admin Color Setting') }}</span></a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isRoute('dropdown') }}">
                                        <a href="{{url('dropdown')}}"><span><span>{{ __('Drop down') }}</span></a>
                                    </li>
                                    @can(['pwa.manage'])
                                    <li class="{{ Nav::isRoute('show.pwa') }}">
                                        <a href="{{route('show.pwa')}}">{{ __('PWA') }}</a>
                                    </li>
                                    @endcan
                                    
                                    @can(['adsense-setting.manage'])
                                    <li class="{{ Nav::isRoute('adsense') }}">
                                        <a href="{{url('/admin/adsensesetting')}}">{{ __('Adsense') }}</a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isRoute('mailchimp') }}">
                                        <a href="{{url('mailchimp/setting')}}"><span>{{ __('Mail Chimp Setting') }}</span></a>
                                    </li>
                                    @if(isset($gsetting) && $gsetting->ipblock_enable == 1)
                                    <li class="{{ Nav::isRoute('ipblock.view') }}">
                                        <a
                                            href="{{url('admin/ipblock')}}">{{ __('IP Block Settings') }}</a>
                                    </li>
                                    @endif
                                    @can(['twilio-setting.manage'])
                                    <li class="{{ Nav::isRoute('twilio.settings') }}">
                                        <a href="{{route('twilio.settings')}}">{{ __('Twilio') }}</a>
                                    </li>
                                    @endcan
                                    @can(['site-map-setting.manage'])
                                    <li class="{{ Nav::isRoute('show.sitemap') }}">
                                        <a href="{{route('show.sitemap')}}">{{ __('Site Map') }}</a>
                                    </li>
                                    @endcan
                                    
                                    @can(['site-settings.language.view'])
                                    <li class="{{ Nav::isRoute('show.lang') }}">
                                        <a href="{{route('show.lang')}}">{{ __('Language') }}</a>
                                    </li>
                                    @endcan
                                    @can(['email-design.manage'])
                                    
                                    <li class="{{ Nav::isRoute('maileclipse/mailables') }}">
                                        <a href="{{ url('maileclipse/mailables') }}">{{ __('Email Design') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!-- site setting end -->
                            <!-- payment setting start -->
                            @canany(['payment-setting-credentials.manage','payment-setting-MPESA-setting.manage','payment-setting-bank-details.manage','payment-setting.manual-payment.view'])
                            <li
                                class=" {{ Nav::isRoute('api.setApiView') }}{{ Nav::isRoute('bank.transfer') }}{{ Nav::isResource('manualpayment') }} ">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-dollar-sign text-secondary"></i><span>{{ __('Payment Setting') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['payment-setting-credentials.manage'])
                                    <li class="{{ Nav::isRoute('api.setApiView') }}">
                                        <a href="{{route('api.setApiView')}}">{{ __('Credentials') }}</a>
                                    </li>
                                    @endcan

                                    @if(Module::has('MPesa') && Module::find('MPesa')->isEnabled())
                                    @include('mpesa::admin.sidebar')
                                    @endif
                                    @can(['payment-setting-bank-details.manage'])

                                    <li class="{{ Nav::isRoute('bank.transfer') }}">
                                        <a href="{{route('bank.transfer')}}">{{ __('Bank Details') }}</a>
                                    </li>
                                    @endcan
                                    @can(['payment-setting.manual-payment.view'])
                                    <li class="{{ Nav::isResource('manualpayment') }}">
                                        <a href="{{url('manualpayment')}}">{{ __('Manual Payment') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!-- payment setting start end -->
                            <!-- player setting start -->
                            @canany(['player-settings.manage','player-settings.advertise.view'])
                            <li
                                class="{{ Nav::isRoute('player.set') }} {{ Nav::isRoute('ads') }} {{ Nav::isRoute('ad.setting') }}">
                                <a href="javaScript:void();">
                                    <i
                                        class="feather icon-play-circle text-secondary"></i><span>{{ __('Player Settings') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['player-settings.manage'])


                                    <li class="{{ Nav::isRoute('player.set') }}"><a
                                            href="{{route('player.set')}}">{{ __('Player Customization') }}</a>
                                    </li>
                                    @endcan

                                    <li class="{{ Nav::isRoute('ads') }}"><a href="{{url('admin/ads')}}"
                                            title="Create ad">{{ __('Advertise') }}</a></li>
                                    @php $ads = App\Ads::all(); @endphp
                                    @can(['player-settings.advertise.view'])
                                    @if($ads->count()>0)
                                    <li class="{{ Nav::isRoute('ad.setting') }}"><a href="{{url('admin/ads/setting')}}"
                                            title="Ad Settings">{{ __('AdvertiseSettings') }}</a>
                                    </li>
                                    @endif
                                    @endcan

                                </ul>
                            </li>
                            @endcanany
                            <!-- player setting start end -->
                            @if(isset($gsetting) && $gsetting->activity_enable == '1')
                            <li class="{{ Nav::isRoute('activity.index') }}"><a href="{{route('activity.index')}}">
                                    <i
                                        class="feather icon-help-circle text-secondary"></i><span>{{ __('Activity Log') }}</span>
                                </a></li>

                            @endif
                            @can(['addon.view'])

                            <li class="header">{{ __('Support') }}</li>
                            <!-- help & support start  -->
                            <li class="{{ Nav::isResource('admin-addon') }}">
                                <a href="{{url('admin/addon')}}"> <i
                                        class="feather icon-move  text-secondary"></i><span>{{ __('Addon') }}</span>
                                    {{ __('Manager') }}</a>
                            </li>
                            @endcan
                            @can(['update-process.manage'])
                            <li class="{{ Nav::isRoute('update.process') }}">
                                <a href="{{route('update.process')}}"><i class="feather icon-share text-secondary"></i><span>{{ __('Update Process') }}</span></a>
                            </li>
                            @endcan
                            @canany(['help-support-import-demo.manage','help-support-database-backup.manage','help-support-remove-public.manage','help-support-clear-cache.manage'])
                            <li
                                class="{{ Nav::isRoute('import.view') }} {{ Nav::isRoute('database.backup') }} ">
                                <a href="javaScript:void();">
                                    <i class="feather icon-help-circle text-secondary"></i><span>{{ __('Help & Support') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['help-support-import-demo.manage'])
                                    <li class="{{ Nav::isRoute('import.view') }}">
                                        <a href="{{route('import.view')}}">{{ __('Import Demo') }}</a>
                                    </li>
                                    @endcan
                                    @can(['help-support-database-backup.manage'])
                                    <li class="{{ Nav::isRoute('database.backup') }}">
                                        <a
                                            href="{{route('database.backup')}}">{{ __('Database Backup') }}</a>
                                    </li>
                                    @endcan
                                    @can(['help-support-remove-public.manage'])
                                    <li class="{{ Nav::isRoute('remove.public') }}">
                                        <a href="{{route('remove.public')}}">{{ __('Remove Public') }}</a>
                                    </li>
                                    @endcan
                                    @can(['help-support-clear-cache.manage'])
                                    <li class="{{ Nav::isRoute('clear-cache') }}">
                                        <a href="{{url('clear-cache')}}">{{ __('Clear Cache') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!-- help & support end -->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>