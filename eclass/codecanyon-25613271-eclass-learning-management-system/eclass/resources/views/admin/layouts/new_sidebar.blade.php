<div class="leftbar sidebar-two" style="background-image: url('images/navbar.png')">
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
                                    <img style="object-fit:scale-down;" src="{{ url('images/logo/'.$gsetting->footer_logo) }}"
                                        class="img-fluid" alt="logo">
                                </a>
                            </div>
                            <div class="input-group search-input">
                                <input type="text" class="form-control" id="searchInput1" placeholder="Search here..." autocomplete="off">
                                <span class="input-group-text">
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </span>
                            </div>

                            <ul id="resultList" class="result-list" style="display: none;"></ul>
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
                            @canany(['users.view','Alluser.view','Allinstructor.view'])
                            <li class="header">{{ __('Users') }}</li>
                            <!-- user start  -->
                            <li class="{{ Nav::isRoute('user.index') }} {{ Nav::isRoute('user.add') }} {{ Nav::isRoute('user.edit') }}{{ Nav::isRoute('alluser.index') }} {{ Nav::isRoute('alluser.add') }} {{ Nav::isRoute('alluser.edit') }}{{ Nav::isRoute('allinstructor.index') }} {{ Nav::isRoute('allinstructor.add') }} {{ Nav::isRoute('allinstructor.edit') }}{{ Nav::isResource('roles') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-users text-secondary"></i>
                                    <span>{{ __('Users') }}<div class="sub-menu truncate">{{__('All Users, Roles And Permission')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('users.view')
                                    <li>
                                        <a class="{{ Nav::isResource('user') }}"
                                            href="{{route('user.index')}}">{{ __('All Users') }}</a>
                                    </li>
                                    <li>
                                        <a class="{{ Nav::isResource('user.add') }}"
                                            href="{{url('user/adduser')}}">{{ __('Add User') }}</a>
                                    </li>
                                    @endcan
                                    <li>
                                        <a class="{{ Nav::isResource('alladmin') }}"
                                            href="{{route('user.verify')}}">{{ __('Verify User') }}</a>
                                    </li>
                                    @can('role.view')
                                    <li>
                                        <a class="{{ Nav::isResource('roles') }}"
                                            href="{{route('roles.index')}}">{{ __('Roles And Permission') }}</a>
                                    </li>
                                    @endcan
                                    @can('users.view')
                                    <li>
                                        <a class="{{ Nav::isResource('roles') }}"
                                            href="{{route('user-requests')}}">{{ __('User Delete Request') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany


                            @canany(['instructorrequest.view','instructor-pending-request.manage','instructor-plan-subscription.view'])
                            <li class="{{ Nav::isResource('plan/subscribe/settings') }} {{ Nav::isResource('subscription/plan') }}  {{ Nav::isRoute('all.instructor') }} {{ Nav::isResource('requestinstructor') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-user text-secondary"></i>
                                    <span>{{ __('Instructors') }}<div class="sub-menu truncate">{{__('All Instructor Request, Pending Request, Instructor Subscription, Instructor Plan, Multiple Instructor, Instructor Payout')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('instructorrequest.view')
                                    <li class="{{ Nav::isRoute('all.instructor') }}"><a
                                            href="{{route('all.instructor')}}">{{ __('All') }}
                                            {{ __('Instructor Request') }}</a></li>
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
                                            <span>{{ __('Multiple Instructor') }}</span>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('allrequestinvolve') }}"><a
                                                    href="{{route('allrequestinvolve')}}">{{ __('Request to Involve') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('involve.request.index') }}"><a
                                                    href="{{route('involve.request.index')}}">{{ __('Involvement Requests') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('involve.request') }}"><a
                                                    href="{{route('involve.request')}}">{{ __('Involved In Course') }}</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <!-- MultipleInstructor end  -->
                                    <!-- InstructorPayout start  -->
                                    <li
                                        class="{{ Nav::isRoute('instructor.settings') }} {{ Nav::isRoute('admin.instructor') }} {{ Nav::isRoute('admin.completed') }}">
                                        <a href="javaScript:void();">
                                            <span>{{ __('Instructor Payout') }}</span>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('instructor.settings') }}"><a
                                                    href="{{route('instructor.settings')}}">{{ __('Payout Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('admin.instructor') }}"><a
                                                    href="{{route('admin.instructor')}}">{{ __('Payout') }}</a>
                                            </li>


                                        </ul>
                                    </li>
                                    <!-- InstructorPayout end  -->
                                </ul>
                            </li>
                            @endcanany


                            <!-- user end -->
                            @canany(['categories.view','courses.view','bundle-courses.view','course-languages.view','course-reviews.view','assignment.view','refund-policy.view','batch.view','quiz-review.view','private-course.view','reported-course.view','reported-question.view'])

                            <li class="header">{{ __('Education') }}</li>
                            <!-- ====================Course start======================== -->
                            <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('bundle') }} {{ Nav::isResource('courselang') }} {{ Nav::isResource('coursereview') }} {{ Nav::isRoute('assignment.view') }} {{ Nav::isResource('refundpolicy') }} {{ Nav::isResource('batch') }} {{ Nav::isRoute('quiz.review') }} {{ Nav::isResource('private-course') }} {{ Nav::isResource('admin/report/view') }} {{ Nav::isResource('user/question/report') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-book text-secondary"></i>
                                    <span>{{ __('Course') }}<div class="sub-menu truncate">{{__('Categories, Courses, Bundle Course, Course Language, Course Review, Assignment, Refund Policy, Batch, Quiz Review, Private Course, Reported Course, Reported Question')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <!-- Category start  -->
                                    @canany(['categories.view','subcategories.view','childcategories.views'])
                                    <li
                                        class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }}">
                                        <a href="javaScript:void();"><span>{{ __('Category') }}</span><i
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
                                                    href="{{url('childcategory')}}">{{ __('Child Category') }}</a>
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
                                </ul>
                            </li>
                            @endcanany
                            @can(['courses.view'])

                            <li>
                                <a href="{{url('instructor/course')}}" class="menu text-truncate" title="Modified Courses Review"><i class="feather icon-check-circle text-secondary"></i>
                                    <span>{{ __('Modified Courses Review') }}</span>
                                </a>
                            </li>
                            @endcan
                            @if(Module::has('Ebook') && Module::find('Ebook')->isEnabled())
                            @include('ebook::sidebar.sidebar_menu')
                            @endif
                            <!--=================== Course end====================================  -->
                            <!-- ====================Meetings start======================== -->
                            @canany(['meetings.zoom-meetings.view','meetings.big-blue.view','meetings.google-meet.view','meetings.jitsi-meet.view','meetings.google-classroom.view','meetings.meeting-recordings.view'])
                            <li class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }} {{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }} {{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }} {{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }} {{ Nav::isResource('meeting-recordings') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-clock text-secondary"></i>
                                    <span>{{ __('Meetings') }}<div class="sub-menu truncate">{{__('Zoom Meetings, Big Blue, Google Meet, Jitsi Meeting, Meeting Recordings')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
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
                                            <li class="{{ Nav::isRoute('zoom.setting') }}"><a
                                                    href="{{route('zoom.setting')}}">{{ __('Settings') }}</a>
                                            </li>
                                            <li
                                                class="{{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('meeting.create') }}">
                                                <a href="{{route('zoom.index')}}">{{ __('Dashboard') }}</a>
                                            </li>

                                            <li class="{{ Nav::isRoute('meeting.show') }}"><a
                                                    href="{{route('meeting.show')}}">{{ __('All Meetings') }}</a>
                                            </li>

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

                                            <li class="{{ Nav::isRoute('bbl.setting') }}"><a
                                                    href="{{ route('bbl.setting') }}">{{ __('Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('bbl.all.meeting') }}"><a
                                                    href="{{ route('bbl.all.meeting') }}">{{ __('List Meetings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('download.meeting') }}"><a
                                                    href="{{ route('download.meeting') }}">{{ __('Recorded') }}</a>
                                            </li>
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

                                            <li class="{{ Nav::isRoute('googlemeet.setting') }}"><a
                                                    href="{{route('googlemeet.setting')}}">{{ __('Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('googlemeet.index') }}"><a
                                                    href="{{route('googlemeet.index')}}">{{ __('Dashboard') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('googlemeet.allgooglemeeting') }}"><a
                                                    href="{{route('googlemeet.allgooglemeeting')}}">{{ __('All Meetings') }}</a>
                                            </li>

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
                                            <li class="{{ Nav::isRoute('jitsi.dashboard') }}"><a
                                                    href="{{ route('jitsi.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                        </ul>
                                    </li>
                                    @endif

                                    @if(Module::find('Googleclassroom') && Module::find('googleclassroom')->isEnabled())
                                    @include('googleclassroom::layouts.admin_sidebar_menu')
                                    @endif
                                    <!-- Jitsi Meeting end -->
                                    <li class="{{ Nav::isResource('meeting-recordings') }}"><a
                                            href="{{url('meeting-recordings')}}"><span>{{ __('Meeting Recordings') }}</span></a>
                                    </li>

                                </ul>
                            </li>
                            @endcanany

                            @can(['institute.view'])
                            <li>
                                <a href="{{url('institute')}}" class="menu"><i class="feather icon-grid text-secondary"></i>
                                    <span>{{ __('Institute') }}</span>
                                </a>
                            </li>
                            

                            <li>
                                <a href="{{url('alumini')}}" class="menu"><i class="feather icon-user-check text-secondary"></i>
                                    <span>{{ __('Alumini') }}</span>
                                </a>
                            </li>
                            @endcan
                            <li class="{{ Nav::isRoute('certificate.index') }} {{ Nav::isRoute('create.certificate') }} {{ Nav::isRoute('certificate.setting') }}">
                                @can('certificate.manage')
                                <a href="javaScript:void();">
                                    <i class="feather icon-file-text text-secondary"></i>
                                    <span>{{ __('Certificate') }}</span>
                                    <i class="feather icon-chevron-right"></i> 
                                </a> 
                                @endcan                               
                                <ul class="vertical-submenu">
                                    @can('certificate.manage')
                                    @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                                    @include('certificate::admin.sidebar_menu')
                                    @endif
                                    <li class="{{ Nav::isRoute('certificate.index') }}">
                                        <a href="{{route('certificate.index')}}" class="menu">
                                            <span>{{ __('Certificate Verify') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                                
                            </li>
                            @can(['settings.manage'])
                            <li class="{{ Nav::isRoute('certificate.index') }}">
                                <a href="javaScript:void();">
                                    <i class="feather icon-cpu text-secondary"></i>
                                    <span>{{ __('OpenAi') }}</span><span class="badge badge-danger">New</span>
                                    <i class="feather icon-chevron-right"></i> 
                                </a>                                
                                <ul class="vertical-submenu">
                                    <li class="">
                                        <a href="{{url('admin/services')}}" class="menu">
                                            <span>{{ __('Service') }}</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{url('user/openai')}}" class="menu">
                                            <span>{{ __('User') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                
                            </li>
                           @endcan

                            <!--===================meeting end====================================  -->
                            <!-- ====================instructor start======================== -->

                            <!--===================instructor end====================================  -->
                            @can(['coupons.view'])

                            <li class="header">{{ __('Marketing') }}</li>
                            <li class="{{ Nav::isResource('coupon') }}">
                                <a href="{{url('coupon')}}" class="menu">
                                  <i class="feather icon-award text-secondary"></i><span>{{ __('Coupon') }}</span>
                                </a>
                            </li>
                            
                            @endcan
                            @can(['followers.manage'])
                            <li class="{{ Nav::isRoute('follower.view') }}">
                                <a href="{{route('follower.view')}}" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i><span>{{ __('Followers') }}</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['affiliate.manage',' wallet-setting.manage','wallet-transactions.manage'])
                            <li class="{{ Nav::isRoute('save.affiliates') }} {{ Nav::isRoute('wallet.settings') }} {{ Nav::isRoute('wallet.transactions') }}">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-dollar-sign text-secondary"></i>
                                    <span>{{ __('Affiliate & Wallet') }}
                                        <div class="sub-menu truncate">Affiliate, Wallet</div>
                                    </span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    @can(['affiliate.manage'])
                                    <li class="{{ Nav::isRoute('save.affiliates') }}">
                                        <a href="{{route('save.affiliates')}}">{{ __('Affiliate') }}</a>
                                    </li>
                                    @endcan
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
                                    </li>

                                </ul>
                            </li>
                            @endcanany
                            @can(['settings.manage'])
                            <li class="{{ Nav::isRoute('support_admin.index') }} {{ Nav::isRoute('supporttype.show') }}">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-dollar-sign text-secondary"></i>
                                    <span>{{ __('Support') }}
                                        <div class="sub-menu truncate">{{ __('Support') }}</div>
                                    </span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    @can(['settings.manage'])
                                    <li class="{{ Nav::isRoute('support_admin.index') }}">
                                        <a href="{{route('support_admin.index')}}">{{ __('Support') }}</a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isRoute('supporttype.show') }}">
                                        <a href="{{route('supporttype.show')}}">{{ __('Support Type') }}</a>
                                    </li>
                                    </li>

                                </ul>
                            </li>
                           @endcan

                            <!-- PushNotification -->
                            @can(['push-notification.manage'])
                            <li class="{{ Nav::isRoute('onesignal.settings') }}">
                                <a href="{{route('onesignal.settings')}}" class="menu">
                                    <i class="feather icon-navigation text-secondary"></i>
                                    <span>{{ __('Push Notification') }}</span>
                                </a>
                            </li>
                            @endcan


                            @can(['flash-deals.view'])
                            <li class="{{ Nav::isResource('admin/flash-sales') }}">
                                <a href="{{url('admin/flash-sales')}}" class="menu">
                                    <i class="feather icon-clock text-secondary"></i>
                                    <span>{{ __('Flash Deals') }}</span>
                                </a>
                            </li>
                            @endcan



                            <!-- attandance -->
                            @can(['attendance.manage'])
                            @if(isset($gsetting) && $gsetting->attandance_enable == 1)
                            <li class="{{ Nav::isResource('attandance') }}">
                                <a href="{{url('attandance')}}" class="menu">
                                    <i class="feather icon-user text-secondary"></i>
                                    <span>{{ __('Attandance') }}</span>
                                </a>
                            </li>
                            @endif
                            @endcan

                            <!-- coupon -->
                            @can(['orders.manage'])

                            <li class="header">{{ __('Financial') }}</li>

                            <!-- order -->
                            <li class="{{ Nav::isResource('order') }}">
                                <a href="{{url('order')}}" class="menu">
                                    <i class="feather icon-shopping-cart text-secondary"></i>
                                    <span>{{ __('Order') }}</span>
                                </a>
                            </li>
                            @endcan

                            <!-- order -->

                         
                            @can(['blogs.view'])
                            <li class="header">{{ __('Content') }}</li>
                            @endcan
                            @if(Module::has('Chatboard') && Module::find('Chatboard')->isEnabled())
                            @include('chatboard::front.icon')
                            @endif
                            
                            @can(['blogs.view'])
                            <li class="{{ Nav::isResource('blog') }}">
                                <a href="{{url('blog')}}" class="menu">
                                    <i class="feather icon-message-square text-secondary"></i>
                                    <span>{{ __('Blogs') }}</span>
                                </a>
                            </li>
                            @endcan
                           
                            <!-- pages start -->
                            @can(['pages.view'])
                            <li class="{{ Nav::isResource('page') }}">
                                <a href="{{url('page')}}" class="menu">
                                    <i class="feather icon-file-text text-secondary"></i>
                                    <span>{{ __('Pages') }}</span>
                                </a> 
                            </li>
                            @endcan
                            <!-- pages end -->
                            <!-- report start  -->
                            @canany(['report.progress-report.manage','report.quiz-report.manage','report.revenue-admin-report.manage','report.revenue-instructor-report.manage'])
                            <li class="{{ Nav::isResource('user/course/report') }} {{ Nav::isResource('user/question/report') }}{{url('show/progress/report')}} {{ Nav::isResource('show/quiz/report') }}">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-file-text text-secondary"></i>
                                    <span>{{ __('Report') }}<div class="sub-menu truncate">{{__('Quiz Report, Progress Report, Revenue Report,  Financial Reports, Device History')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">


                                    <li class="{{ Nav::isResource('show/quiz/report') }}">
                                        <a href="{{url('show/quiz/report')}}">{{ __('Quiz') }} {{ __('Report') }} </a>
                                    </li>
                                    <li class="{{ Nav::isResource('show/progress/report') }}">
                                        <a href="{{url('show/progress/report')}}">{{ __('Progress') }}
                                            {{ __('Report') }}</a>
                                    </li>

                                    <!-- revenue report start  -->
                                    <li
                                        class="{{ Nav::isRoute('admin.revenue.report') }} {{ Nav::isRoute('instructor.revenue.report') }}{{ Nav::isResource('device-logs') }}">
                                        <a href="javaScript:void();"><span>{{ __('Revenue') }}
                                                {{ __('Report') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('admin.revenue.report') }}">
                                                <a
                                                    href="{{route('admin.revenue.report')}}">{{ __('Admin Revenue') }}</a>
                                            </li>

                                            <li class="{{ Nav::isRoute('instructor.revenue.report') }}">
                                                <a
                                                    href="{{route('instructor.revenue.report')}}">{{ __('Instructor Revenue') }}</a>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="{{ Nav::isResource('admin/report/view') }}">
                                        <a href="{{ route('order.report') }}">
                                            {{ __('Financial reports') }} </a>
                                    </li>

                                    <li class="{{ Nav::isResource('device-logs') }}">
                                        <a href="{{url('device-logs')}}">{{ __('Device History') }} </a>
                                    </li>
                                    <li class="{{ Nav::isResource('report/certificate') }}">
                                        <a href="{{url('report/certificate')}}">{{ __('Certificate Report') }} </a>
                                    </li>
                                    <li class="{{ Nav::isResource('attand/report') }}">
                                        <a href="{{url('attand/report')}}">{{ __('Attandance Report') }} </a>
                                    </li>
                                    {{-- <li class="{{ Nav::isResource('coupon/report') }}">
                                        <a href="{{url('coupon/report')}}">{{ __('Coupon Report') }} </a>
                                    </li> --}}
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
                            {{-- @can(['about.manage'])
                            <li class="{{ Nav::isRoute('about.page') }}">
                                <a href="{{route('about.page')}}" class="menu">
                                    <i class="feather icon-external-link text-secondary"></i>
                                    <span>{{ __('About') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                            <!-- faq start  -->
                            @canany(['faq.faq-student.view','faq.faq-instructor.view'])
                            <li class="{{ Nav::isResource('faq') }} {{ Nav::isResource('faqinstructor') }}">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i>
                                    <span>{{ __('Faq') }}<div class="sub-menu truncate">{{__('Faq Student, Faq Instructor')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    <li class="{{ Nav::isResource('faq') }}">
                                        <a href="{{url('faq')}}">{{ __('Faq Student') }}</a>
                                    </li>

                                    <li class="{{ Nav::isResource('faqinstructor') }}">
                                        <a href="{{url('faqinstructor')}}">{{ __('Faq Instructor') }}</a>
                                    </li>

                                </ul>
                            </li>
                            @endcanany
                            {{-- @can(['career.manage'])
                            <li class="{{ Nav::isRoute('careers.page') }}">
                                <a href="{{route('careers.page')}}" class="menu">
                                    <i class="feather icon-sidebar text-secondary"></i><span>{{ __('Career') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                            <!-- faq end -->
                            <!-- location start -->
                            @canany(['locations.country.view','locations.state.view','locations.city.view'])
                            <li class="{{ Nav::isResource('admin/country') }} {{ Nav::isResource('admin/state') }} {{ Nav::isResource('admin/city') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-map-pin text-secondary"></i>
                                    <span>{{ __('Locations') }}<div class="sub-menu truncate">Country, State, City</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['locations.country.view'])

                                    <li class="{{ Nav::isResource('admin/country') }}"><a
                                            href="{{url('admin/country')}}">{{ __('Country') }}</a>
                                    </li>
                                    @endcan
                                    @can(['locations.state.view'])
                                    <li class="{{ Nav::isResource('admin/state') }}"><a
                                            href="{{url('admin/state')}}">{{ __('State') }}</a>
                                    </li>
                                    @endcan
                                    @can(['locations.city.view'])
                                    <li class="{{ Nav::isResource('admin/city') }}"><a
                                            href="{{url('admin/city')}}">{{ __('City') }}</a>
                                    </li>
                                    @endcan

                                </ul>
                            </li>
                            @endcanany
                            <!-- contact us start -->
                            @can('contact-us.manage')
                            <li class="{{ Nav::isResource('usermessage') }}">
                                <a href="{{url('usermessage')}}" class="menu"><i
                                        class="feather icon-phone-call text-secondary"></i><span>{{ __('Contact Us') }}</span>
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
                            @can(['settings.manage'])
                            <li class="header">{{ __('Setting') }}</li>
                            @endcan
                            @if(Module::has('Upi') && Module::find('Upi')->isEnabled())
                            @include('upi::icon')
                            @endif
                            @can(['get-api-key.manage'])
                            <li class="{{ Nav::isRoute('get.api.key') }}">
                                <a href="{{route('get.api.key')}}" class="menu">
                                    <i class="feather icon-share text-secondary"></i><span>{{ __('Get API Keys') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can(['currency.view'])
                            <li class="{{ Nav::isRoute('currency.index') }}">
                                <a href="{{route('currency.index')}}" class="menu">
                                    <i class="feather icon-dollar-sign text-secondary"></i><span>{{ __('Currency') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can(['themes.manage'])
    <li class="{{ request()->routeIs('themenew.index') ? 'active' : '' }}">
        <a href="{{ route('themenew.index') }}">
            <i class="feather icon-settings"></i>
            <span>Theme Settings</span>
        </a>
    </li>
@endcan
                        
                            @can(['themes.manage'])
                             
                            <li class="{{ Nav::isRoute('themesettings.index') }}">
                                <a href="{{route('themesettings.index')}}" class="menu">
                                    <i class="feather icon-airplay text-secondary"></i>
                                    <span>{{ __('Themes') }}</span>
                                </a>
                            </li>
                            @endcan
                           
                            @can(['settings.manage'])
                            <li class="{{ Nav::isRoute('mobile/setting') }}">
                                <a href="{{url('mobile/setting')}}" class="menu">
                                    <i class="feather icon-tablet text-secondary"></i>
                                    <span>{{ __('Mobile Setting') }}</span>
                                </a>
                            </li>
                            <li class="{{ Nav::isRoute('mobileqr') }}">
                                <a href="{{url('mobileqr')}}" class="menu">
                                    <i class="feather icon-maximize text-secondary"></i>
                                    <span>{{ __('QR Setting') }}</span>
                                </a>
                            </li>
                         @endcan
                            <!-- front setting start  -->
                            @canany(['front-settings.testimonial.view','front-settings.advertisement.view','front-settings.sliders.view','front-settings.fact-slider.view','category-sliders.manage','get-started.manage','front-settings.trusted-sliders.view','widget.manage','front-settings.seo-directory.view','coming-soon.manage','terms-condition.manage','privacy-policy.manage','invoice-design.manage','login-signup.manage','video-setting.manage','breadcum-setting.manage','front-settings.fact-slider.view','join-an-instructor.manage '])
                            <li class="{{ Nav::isResource('testimonial') }} {{ Nav::isResource('advertisement') }} {{ Nav::isResource('slider') }} {{ Nav::isResource('facts') }} {{ Nav::isRoute('category.slider') }} {{ Nav::isResource('getstarted') }} {{ Nav::isResource('trusted') }} {{ Nav::isRoute('widget.setting') }} {{ Nav::isRoute('terms') }} {{ Nav::isResource('directory') }} {{ Nav::isRoute('videosetting') }} {{ Nav::isRoute('breadcum') }} {{ Nav::isRoute('fact') }} {{ Nav::isRoute('joininstructor') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-monitor text-secondary"></i>
                                    <span>{{ __('Front Setting') }}<div class="sub-menu truncate">{{__('Testimonial, Advertisement, Slider, Fact Slider, Category Slider, Get Started, Trusted Slider, Widget, Seo Directory, Coming Soon, Terms & Condition, Privacy Policy, Invoice Design, Login/Signup, Videosetting, Breadcumsetting, Factsetting, Join an Instructor')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['front-settings.testimonial.view'])
                                    <li class="{{ Nav::isResource('testimonial') }}"><a
                                            href="{{url('testimonial')}}"><span>{{ __('Testimonial') }}</span></a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isResource('admin/menu') }}">
                                        <a href="{{url('admin/menu')}}">
                                            <span>{{ __('Menu Customisation') }}</span>
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
                                    @can(['homepage-setting.manage'])
                                    <li class="{{ Nav::isRoute('homepage.setting') }}">
                                        <a href="{{route('homepage.setting')}}" class="menu"><span>{{ __('Homepage Setting') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['login-signup.manage'])
                                    <li class="{{ Nav::isRoute('login') }}">
                                        <a href="{{ url('settings/login') }}">{{ __('Login/Signup') }}{{ __('') }}</a>
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
                                        <a href="{{ url('fact') }}">{{ __('Fact Setting, ') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    @can(['join-an-instructor.manage'])
                                    <li class="{{ Nav::isRoute('joininstructor') }}">
                                        <a href="{{ url('join/setting') }}">{{ __('Join an Instructor') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isRoute('setting/service') }}">
                                        <a href="{{ url('setting/service') }}">{{ __('Service Setting') }}{{ __('') }}</a>
                                    </li>
                                    <li class="{{ Nav::isRoute('service') }}">
                                        <a href="{{ url('service') }}">{{ __('Services') }}{{ __('') }}</a>
                                    </li>
                                    <li class="{{ Nav::isRoute('feature') }}">
                                        <a href="{{ url('feature') }}">{{ __('Feature') }}{{ __('') }}</a>
                                    </li>
                                    <li class="{{ Nav::isRoute('setting/feature') }}">
                                        <a href="{{ url('setting/feature') }}">{{ __('Feature Setting') }}{{ __('') }}</a>
                                    </li>
                                </ul>
                            </li>
                            @endcanany

                            <!-- front setting end -->
                            <!-- site setting start  -->
                            @canany(['settings.manage','pwa.manage','adsense-setting.manage','twilio-setting.manage','site-map-setting.manage','site-settings.language.view','email-design.manage'])
                            <li class="{{ Nav::isRoute('gen.set') }} {{ Nav::isRoute('careers.page') }}  {{ Nav::isRoute('termscondition') }} {{ Nav::isRoute('policy') }}  {{ Nav::isRoute('show.pwa') }} {{ Nav::isRoute('adsense') }} {{ Nav::isRoute('ipblock.view') }}   {{ Nav::isRoute('twilio.settings') }} {{ Nav::isRoute('show.sitemap') }} {{ Nav::isRoute('show.lang') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-settings text-secondary"></i>
                                    <span>{{ __('Site Setting') }}<div class="sub-menu truncate">{{__('Setting, PWA, Adsense, IP Block Settings, Twilio, Site Map, Language, Email Design')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    @can(['settings.manage'])
                                     <li class="{{ Nav::isRoute('gen.set') }}">
                                        <a href="{{route('gen.set')}}">{{ __('Setting') }}</a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isRoute('admincustomisation') }}">
                                        <a href="{{url('admincustomisation')}}" class="menu"><span><span>{{ __('Admin Color Setting') }}</span></a>
                                    </li>
                                    <li class="{{ Nav::isRoute('dropdown') }}">
                                        <a href="{{url('dropdown')}}"><span><span>{{ __('Dropdown') }}</span></a>
                                    </li>
                                    @can(['pwa.manage'])
                                    <li class="{{ Nav::isRoute('show.pwa') }}">
                                        <a href="{{route('show.pwa')}}">{{ __('PWA') }}</a>
                                    </li>
                                    @endcan
                                    <li class="{{ Nav::isRoute('mailchimp') }}">
                                        <a href="{{url('mailchimp/setting')}}"><span>{{ __('Mail Chimp Setting') }}</span></a>
                                    </li>
                                    @can(['adsense-setting.manage'])
                                    <li class="{{ Nav::isRoute('adsense') }}">
                                        <a href="{{url('/admin/adsensesetting')}}">{{ __('Adsense') }}</a>
                                    </li>
                                    @endcan

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
                                    <li class="{{ Nav::isRoute('chnaeword.index') }}">
                                        <a href="{{route('chnaeword.index')}}">{{ __('Language Translation') }}</a>
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
                            <li class=" {{ Nav::isRoute('api.setApiView') }}{{ Nav::isRoute('bank.transfer') }}{{ Nav::isResource('manualpayment') }} ">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-dollar-sign text-secondary"></i>
                                    <span>{{ __('Payment Setting') }}<div class="sub-menu truncate">{{__('Credentials, MPESA Settings, Bank Deatils, Manual Payment')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
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
                            <li class="{{ Nav::isRoute('player.set') }} {{ Nav::isRoute('ads') }} {{ Nav::isRoute('ad.setting') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-play-circle text-secondary"></i>
                                    <span>{{ __('Player Settings') }}<div class="sub-menu truncate">{{__('Player Customization, Advertise Settings')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
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
                                            title="Ad Settings">{{ __('Advertise Settings') }}</a>
                                    </li>
                                    @endif
                                    @endcan

                                </ul>
                            </li>
                            @endcanany
                            <!-- player setting start end -->
                            @can(['settings.manage'])
                            @if(isset($gsetting) && $gsetting->activity_enable == '1')
                            <li class="{{ Nav::isRoute('activity.index') }}">
                                <a href="{{route('activity.index')}}" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i><span>{{ __('Activity Log') }}</span>
                                </a>
                            </li>
@endcan
                            @endif
                            @can(['addon.view'])

                            <li class="header">{{ __('Support') }}</li>
                            <!-- help & support start  -->
                            <li class="{{ Nav::isResource('admin-addon') }}">
                                <a href="{{url('admin/addon')}}" class="menu"> 
                                    <i class="feather icon-move text-secondary"></i><span>{{__('Addon')}}
                                    {{ __('Manager') }}</span>
                                </a>
                            </li>
                            @endcan
                            <li class="{{ Nav::isRoute('update.process') }} {{ Nav::isRoute('manual.process') }}">
                                @can(['update-process.manage'])
                                <a href="javaScript:void();" class="menu"><i class="feather icon-share text-secondary"></i>
                                    <span>{{ __('Update') }}<div class="sub-menu truncate">{{__('Auto Update, Manual Update')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                @endcan
                                <ul class="vertical-submenu">
                                    @can(['update-process.manage'])
                                    <li class="{{ Nav::isRoute('update.process') }}">
                                        <a href="{{route('update.process')}}" class="menu"><span>{{ __('Auto Update') }}</span>
                                        </a>
                                    </li>
                                    <li class="{{ Nav::isRoute('manual.process') }}">
                                        <a href="{{route('manual.process')}}" class="menu"><span>{{ __('Manual Update') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @canany(['help-support-import-demo.manage','help-support-database-backup.manage','help-support-remove-public.manage','help-support-clear-cache.manage'])
                            <li class="{{ Nav::isRoute('import.view') }} {{ Nav::isRoute('database.backup') }} ">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i>
                                    <span>{{ __('Help & Support') }}<div class="sub-menu truncate">{{__('Import Demo, Database Backup, Remove Public, Clear Cache')}}</div></span>
                                    <i class="feather icon-chevron-right"></i>
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
                                        <a
                                            href="{{route('remove.public')}}">{{ __('Remove Public') }}</a>
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
<script>
    document.getElementById('searchInput1').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    const menuItems = document.querySelectorAll('.vertical-menu > li, .vertical-submenu > li');
    const resultList = document.getElementById('resultList');

    // Clear previous results
    resultList.innerHTML = '';

    if (searchTerm) {
        let resultsFound = false;

        menuItems.forEach(item => {
            const link = item.querySelector('a');
            const text = link ? link.textContent.toLowerCase() : '';

            if (text.includes(searchTerm)) {
                resultsFound = true;
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = link.href;
                a.textContent = link.textContent;
                li.appendChild(a);
                resultList.appendChild(li);
            }
        });

        if (!resultsFound) {
            const li = document.createElement('li');
            li.textContent = 'No menus found';
            resultList.appendChild(li);
        }

        resultList.style.display = 'block';
    } else {
        resultList.style.display = 'none';
    }
});

</script>