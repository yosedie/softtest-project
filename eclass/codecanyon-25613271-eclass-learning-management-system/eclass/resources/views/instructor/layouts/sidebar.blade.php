<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Navigationbar -->

        <div class="navigationbar">

            <div class="vertical-menu-detail">

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade active show" id="v-pills-dashboard" role="tabpanel"
                        aria-labelledby="v-pills-dashboard">
                        @if(Auth::User()->role == "instructor")
                        <ul class="vertical-menu">
                            <div class="logobar">
                                <a href="{{ url('/') }}" class="logo logo-large">
                                    <img style="object-fit:scale-down;" src="{{ url('images/logo/'.$gsetting->logo) }}"
                                        class="img-fluid" alt="logo">
                                </a>
                            </div>


                            <li class="{{ Nav::isRoute('instructor.index') }}">
                                <a class="nav-link" href="{{route('instructor.index')}}">
                                    <i class="feather icon-box text-secondary"></i>
                                    <span>{{ __('Dashboard') }}</span>
                                </a>
                            </li>
                            <!-- dashboard end -->
                            <li class="header">{{ __('Education') }}</li>

                            <!-- Course start  -->
                            <li
                                class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('courselang') }}">
                                <a href="javaScript:void();">
                                    <i class="feather icon-book text-secondary"></i>
                                    <span>{{ __('Course') }}</span><i
                                        class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    <li
                                        class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('courselang') }} {{ Nav::isRoute('assignment.view') }}">
                                        @if($gsetting->cat_enable == 1)
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Category') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isResource('category') }}">
                                                <a href="{{url('category')}}">{{ __('Category') }}</a>
                                            </li>

                                            <li class="{{ Nav::isResource('subcategory') }}">
                                                <a
                                                    href="{{url('subcategory')}}">{{ __('SubCategory') }}</a>
                                            </li>

                                            <li class="{{ Nav::isResource('childcategory') }}">
                                                <a
                                                    href="{{url('childcategory')}}">{{ __('ChildCategory') }}</a>
                                            </li>

                                        </ul>
                                        @endif
                                    <li class="{{ Nav::isResource('course') }}">
                                        <a href="{{url('course')}}">{{ __('Course') }}</a>
                                    </li>
                                    <li class="{{ Nav::isRoute('courses.reject') }}">
                                        <a
                                            href="{{route('courses.reject')}}">{{ __('RejectedCourses') }}</a>
                                    </li>
                                    <li class="{{ Nav::isResource('courselang') }}">
                                        <a href="{{url('courselang')}}">{{ __('Course') }}
                                            {{ __('Language') }}</a>
                                    </li>
                                    @if($gsetting->assignment_enable == 1)
                                    <li class="{{ Nav::isRoute('assignment.view') }}">
                                        <a
                                            href="{{route('assignment.view')}}">{{ __('Assignment') }}</a>
                                    </li>
                                    @endif

                                    <li class="{{ Nav::isRoute('quiz.review') }}"><a
                                            href="{{route('quiz.review')}}"><span>{{ __('QuizReview') }}</span></a>
                                    </li>


                            </li>

                        </ul>
                        </li>

                        <!-- meeeting start  -->

                        <li
                            class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }} {{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }} {{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }} {{ Nav::isResource('meeting-recordings') }}">
                            <a href="javaScript:void();">
                                <i class="fa fa-podcast text-secondary"></i>
                                <span>{{ __('Meetings') }}</span><i
                                    class="feather icon-chevron-right"></i>
                            </a>
                            @if(isset($zoom_enable) && $zoom_enable == 1)
                            <ul class="vertical-submenu">

                                <li
                                    class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }}">
                                    <a href="javaScript:void();">
                                        <i class=""></i> <span>{{ __('ZoomLiveMeetings') }}</span><i
                                            class="feather icon-chevron-right"></i>
                                    </a>
                                    <ul class="vertical-submenu">

                                        <li class="{{ Nav::isRoute('zoom.setting') }}">
                                            <a
                                                href="{{route('zoom.setting')}}">{{ __('ZoomSettings') }}</a>
                                        </li>

                                        <li
                                            class="{{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('meeting.create') }}">
                                            <a
                                                href="{{route('zoom.index')}}">{{ __('ZoomDashboard') }}</a>
                                        </li>

                                    </ul>
                                </li>

                            </ul>
                            @endif
                            <!-- ======= bbl_enable start =============== -->
                            @if(isset($gsetting) && $gsetting->bbl_enable == 1)
                            <ul class="vertical-submenu">

                                <li
                                    class="{{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }}">
                                    <a href="javaScript:void();">
                                        <i class=""></i> <span>{{ __('BigBlueMeetings') }}</span><i
                                            class="feather icon-chevron-right"></i>
                                    </a>
                                    <ul class="vertical-submenu">
                                        <li class="{{ Nav::isRoute('bbl.all.meeting') }}">
                                            <a
                                                href="{{ route('bbl.all.meeting') }}">{{ __('ListMeetings') }}</a>
                                        </li>
                                        <li class="{{ Nav::isRoute('download.meeting') }}">
                                            <a
                                                href="{{ route('download.meeting') }}">{{ __('MeetingRecordings') }}</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                            @endif
                            <!-- ======= bbl_enable end ================= -->
                            <!-- ======= googlemmet start =============== -->
                            @if(isset($gsetting) && $gsetting->googlemeet_enable == 1)
                            <ul class="vertical-submenu">

                                <li
                                    class="{{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }}">
                                    <a href="javaScript:void();">
                                        <i class=""></i> <span>{{ __('Google Meet Meeting') }}</span><i
                                            class="feather icon-chevron-right"></i>
                                    </a>
                                    <ul class="vertical-submenu">

                                        <li class="{{ Nav::isRoute('googlemeet.setting') }}">
                                            <a
                                                href="{{route('googlemeet.setting')}}">{{ __('Google Meet Settings') }}</a>
                                        </li>
                                        <li class="{{ Nav::isRoute('googlemeet.index') }}">
                                            <a
                                                href="{{route('googlemeet.index')}}">{{ __('Google Meet Dashboard') }}</a>
                                        </li>
                                        <li class="{{ Nav::isRoute('googlemeet.allgooglemeeting') }}">
                                            <a
                                                href="{{route('googlemeet.allgooglemeeting')}}">{{ __('AllMeetings') }}</a>
                                        </li>

                                    </ul>
                                </li>

                            </ul>
                            @endif
                            <!-- ======= googlemeet end ================= -->

                            <!-- ======= jisti start =============== -->
                            @if(isset($gsetting) && $gsetting->jitsimeet_enable == 1)
                            <ul class="vertical-submenu">

                                <li class="{{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }}">
                                    <a href="javaScript:void();">
                                        <i class=""></i> <span>{{ __('Jitsi Meeting') }}</span><i
                                            class="feather icon-chevron-right"></i>
                                    </a>
                                    <ul class="vertical-submenu">

                                        <li class="{{ Nav::isRoute('jitsi.dashboard') }}">
                                            <a href="{{ route('jitsi.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>

                                    </ul>
                                </li>

                            </ul>
                            @endif
                            <!-- ======= jisti end ================= -->

                        </li>

                        <!-- meeeting end -->
                        <li><a href="{{url('institute')}}"><i
                                    class="feather icon-grid text-secondary"></i><span>{{ __('Institute') }}</span></a>
                        </li>
                        <!-- Course end -->

                        <!-- featurecourse start -->
                        @if(isset($gsetting->feature_amount))
                        <li class="{{ Nav::isResource('featurecourse') }}">
                            <a class="nav-link" href="{{url('featurecourse')}}">
                                <i class="feather icon-phone-forwarded text-secondary"></i><span>{{ __('Featured') }}
                                    {{ __('Course') }}</span>
                            </a>
                        </li>
                        @endif


                        <!-- MultipleInstructor start  -->
                        <li
                            class="{{ Nav::isRoute('allrequestinvolve') }} {{ Nav::isRoute('involve.request.index') }} {{ Nav::isRoute('involve.request') }}">
                            <a href="javaScript:void();">
                                <i
                                    class="feather icon-users text-secondary"></i><span>{{ __('MultipleInstructor') }}</span><i
                                    class="feather icon-chevron-right"></i>
                            </a>
                            <ul class="vertical-submenu">

                                <li>
                                    <a class="{{ Nav::isRoute('allrequestinvolve') }}"
                                        href="{{route('allrequestinvolve')}}">{{ __('RequestToInvolve') }}</a>
                                </li>
                                <li>
                                    <a class="{{ Nav::isRoute('involve.request.index') }}"
                                        href="{{route('involve.request.index')}}">{{ __('InvolvementRequests') }}</a>
                                </li>
                                <li>
                                    <a class="{{ Nav::isRoute('involve.request') }}"
                                        href="{{route('involve.request')}}">{{ __('InvolvedInCourse') }}</a>
                                </li>

                            </ul>
                        </li>
                        <!-- Question & Answer start  -->
                        <li
                            class="{{ Nav::isResource('instructorquestion') }} {{ Nav::isResource('instructoranswer') }}">
                            <a href="javaScript:void();">
                                <i class="feather icon-help-circle text-secondary"></i><span>{{ __('Question') }}
                                    / {{ __('Answer') }}</span><i
                                    class="feather icon-chevron-right"></i>
                            </a>
                            <ul class="vertical-submenu">

                                <li class="{{ Nav::isResource('instructorquestion') }}">
                                    <a href="{{url('instructorquestion')}}">{{ __('Question') }}</a>
                                </li>

                                <li class="{{ Nav::isResource('instructoranswer') }}">
                                    <a href="{{url('instructoranswer')}}">{{ __('Answer') }}</a>
                                </li>

                            </ul>
                        </li>
                        <!-- Question & Answer end -->
                        <!-- MultipleInstructor end -->
                        <li class="header">{{ __('Financial') }}</li>

                        <!-- userenroll start -->
                        <li class="{{ Nav::isResource('userenroll') }}">
                            <a class="nav-link" href="{{url('userenroll')}}">
                                <i class="feather icon-users text-secondary"></i><span>{{ __('User') }}
                                    {{ __('Enrolled') }}</span>
                            </a>
                        </li>
                        <!-- userenroll end -->




                        <li class="header">{{ __('Content') }}</li>
                        <!-- Announcement start -->
                        <li class="{{ Nav::isResource('instructor/announcement') }}">
                            <a class="nav-link" href="{{url('instructor/announcement')}}">
                                <i
                                    class="feather icon-volume-1 text-secondary"></i><span>{{ __('Announcement') }}</span>
                            </a>
                        </li>
                        <!-- Announcement end -->
                        <!-- featurecourse end -->
                       
                        <!-- blog start -->
                        <li class="{{ Nav::isResource('blog') }}">
                            <a class="nav-link" href="{{url('blog')}}">
                                <i
                                    class="feather icon-book text-secondary"></i><span>{{ __('Blog') }}</span>
                            </a>
                        </li>
                        <!-- blog end -->




                        <li class="header">{{ __('Reports') }}</li>

                        <!-- revenue start  -->
                        <li class="{{ Nav::isResource('pending.payout') }} {{ Nav::isRoute('admin.completed') }}">
                            <a href="javaScript:void();">
                                <i
                                    class="feather icon-dollar-sign text-secondary"></i><span>{{ __('MyRevenue') }}</span><i
                                    class="feather icon-chevron-right"></i>
                            </a>
                            <ul class="vertical-submenu">

                                <li class="{{ Nav::isResource('pending.payout') }}">
                                    <a href="{{route('pending.payout')}}">{{ __('PendingPayout') }}</a>
                                </li>

                                <li class="{{ Nav::isRoute('admin.completed') }}">
                                    <a
                                        href="{{route('admin.completed')}}">{{ __('CompletedPayout') }}</a>
                                </li>

                            </ul>
                        </li>
                        <!-- revenue end -->
                        <!-- report start  -->
                        <li class="{{url('show/progress/report')}} {{ Nav::isResource('show/quiz/report') }}">
                            <a href="javaScript:void();">
                                <i
                                    class="feather icon-file-text text-secondary"></i><span>{{ __('Report') }}</span><i
                                    class="feather icon-chevron-right"></i>
                            </a>
                            <ul class="vertical-submenu">

                                <li class="{{ Nav::isResource('show/quiz/report') }}">
                                    <a href="{{url('show/quiz/report')}}"> {{__('Quiz')}} {{ __('Report') }}</a>
                                </li>
                                <li class="{{ Nav::isResource('show/progress/report') }}">
                                    <a href="{{url('show/progress/report')}}">
                                        Progress{{ __('Report') }}</a>
                                </li>


                            </ul>
                        </li>
                        <!-- report end -->
                        <li class="header">{{ __('Settings') }}</li>
                        <!-- PayoutSettings start -->
                        @if(isset($isetting))
                    
                        <li class="{{ Nav::isResource('instructor.pay') }}">
                            <a class="nav-link" href="{{route('instructor.pay')}}">
                                <i
                                    class="feather icon-settings text-secondary"></i><span>{{ __('PayoutSettings') }}</span>
                            </a>
                        </li>
                        @endif
                        <!-- PayoutSettings end -->

                        <!-- Vacation Enable start -->
                        <li class="{{ Nav::isResource('vacation.view') }}">
                            <a class="nav-link" href="{{route('vacation.view')}}">
                                <i
                                    class="feather icon-toggle-left text-secondary"></i><span>{{ __('Vacation Enable') }}</span>
                            </a>
                        </li>
                        <!-- Vacation Enable end -->

                        </ul>
                        @endif
                    </div>

                </div>

            </div>
        </div>
        <!-- End Navigation-bar -->
    </div>
    <!-- End Sidebar -->
</div>