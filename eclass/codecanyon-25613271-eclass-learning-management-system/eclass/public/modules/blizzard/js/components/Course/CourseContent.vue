<template>
    <div>

        <header-section />

        <div v-if="loginStatus">
            <div v-if="this.purchased">
                <!-- Course Title, Certificate -->
                <section id="course-content-nav" class="course-content-nav-block">
                    <div class="container">
                        <div class="row">

                            <!-- Title -->
                            <div class="col-lg-7 col-md-6 col-12">
                                <div class="course-content-nav-heading" v-if="course.title">
                                    {{course.title}}
                                </div>
                            </div>

                            <!-- Certificate and Go to course detail button -->
                            <div class="col-lg-5 col-md-6 col-12">
                                <div class="course-button certificate-button text-right">
                                    <ul>
                                        <!-- Certificate -->
                                        <li v-if="this.settings.certificate_enable=='1'">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-trophy"></i>&nbsp; 
                                                {{ translate('frontstaticword.GetCertificate')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"> 
                                                        {{markChapterLength}} {{ translate('frontstaticword.of')}} {{allChapterLength}} {{ translate('frontstaticword.completed')}}
                                                    </a>
                                                    <a class="dropdown-item" v-if="markChapterLength == allChapterLength" @click="getCertificate">
                                                        {{ translate('frontstaticword.GetCertificate')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- Go To course Detail -->
                                        <li>
                                            <router-link :to="'/course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')"  class="btn btn-secondary"> 
                                                {{ translate('frontstaticword.Coursedetails')}} 
                                                <i class="fa fa-chevron-right"></i>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Course Title, Certificate Ended -->

                <!-- Course Content -->
                <section id="learning-courses-home" class="learning-courses-home-main-block">
                    <div class="container">
                        <div class="row">
                            
                            <!-- Course Image -->
                            <div class="col-lg-4">
                                <div class="learning-courses-home-video text-white btm-30">
                                    <div class="video-item hidden-xs">
                                        <div class="video-device">
                                            <img 
                                            :src="course.preview_image!=null ? `${path}/images/course/${course.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`" 
                                            class="img-fluid" 
                                            alt="Background">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="learning-courses-home-block">

                                    <!-- Title -->
                                    <h1 class="learning-courses-home-heading btm-20 text-white">
                                        {{course.title}}
                                    </h1>

                                    <!-- Description -->
                                    <p v-html="course.short_detail"> </p>

                                    <!-- Progress Bar -->
                                    <div v-if="this.purchased">
                                        <b-progress :value="markChapterLength" :max="allChapterLength" show-progress animated variant="success"></b-progress>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Course Content Ended -->

                <section id="course-content-tabs" class="course-content-tabs-main-block">
                    <div class="container">
                        <div class="row">
                            <!-- all tabs start -->
                            <div class="col-lg-2 col-12">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <!-- Overview -->
                                    <a class="nav-link active" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true">
                                        {{ translate('frontstaticword.Overview')}}
                                    </a>

                                    <!-- Course Content -->
                                    <a class="nav-link" id="v-pills-course-content-tab" data-toggle="pill" href="#v-pills-course-content" role="tab" aria-controls="v-pills-course-content" aria-selected="false">
                                        {{ translate('frontstaticword.CourseContent')}}
                                    </a>

                                    <!-- Live classes -->
                                    <a class="nav-link" id="v-pills-live-classes-tab" data-toggle="pill" href="#v-pills-live-classes" role="tab" aria-controls="v-pills-live-classes" aria-selected="false">
                                        {{ translate('frontstaticword.LiveClasses')}}
                                    </a>

                                    <!-- Q & A -->
                                    <a class="nav-link" id="v-pills-question-tab" data-toggle="pill" href="#v-pills-question" role="tab" aria-controls="v-pills-question" aria-selected="false">
                                        {{ translate('frontstaticword.Q&A')}}
                                    </a>

                                    <!-- Quiz -->
                                    <a class="nav-link" id="v-pills-quiz-tab" data-toggle="pill" href="#v-pills-quiz" role="tab" aria-controls="v-pills-quiz" aria-selected="false">
                                        {{ translate('frontstaticword.Quiz')}}
                                    </a>

                                    <!-- Announcement -->
                                    <a class="nav-link" id="v-pills-announcments-tab" data-toggle="pill" href="#v-pills-announcments" role="tab" aria-controls="v-pills-announcments" aria-selected="false">
                                        {{ translate('frontstaticword.Announcements')}}
                                    </a>

                                    <!-- Assignment -->
                                    <a v-if="this.settings.assignment_enable=='1'" class="nav-link" id="v-pills-assignment-tab" data-toggle="pill" href="#v-pills-assignment" role="tab" aria-controls="v-pills-assignment" aria-selected="false">
                                        {{ translate('frontstaticword.Assignment')}}
                                    </a>

                                    <!-- Appointment -->
                                    <a v-if="this.settings.appointment_enable=='1'" class="nav-link" id="v-pills-appointment-tab" data-toggle="pill" href="#v-pills-appointment" role="tab" aria-controls="v-pills-appointment" aria-selected="false">
                                        {{ translate('frontstaticword.Appointment')}}
                                    </a>
                                </div>
                            </div>
                            <!-- all tabs end -->

                            <div class="col-lg-10 col-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- Overview -->
                                    <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                                        <div class="overview-block">

                                            <!-- Recent Activities -->
                                            <div class="recent-activity-block" v-if="questions != null || announcments != null">
                                                
                                                <h4 class="recent-activity-heading">
                                                    {{ translate('frontstaticword.RecentActivity')}}
                                                </h4>
                                                <div class="row">

                                                    <!-- Recent Questions -->
                                                    <div class="col-lg-6" v-if="questions != null">
                                                        <div class="card recent-questions">
                                                            <div class="card-header">
                                                                {{ translate('frontstaticword.RecentQuestions')}}
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="recent-questions-content text-center">
                                                                    <p>
                                                                        {{ translate('frontstaticword.Question')}}: {{questions.title}}
                                                                    </p>
                                                                    <p>
                                                                        {{ translate('frontstaticword.ByInstructor')}}: {{questions.instructor}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Recent Announcements -->
                                                    <div class="col-lg-6" v-if="announcments != null">
                                                        <div class="card recent-questions">
                                                            <div class="card-header">
                                                                {{ translate('frontstaticword.RecentAnnouncements')}}
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="recent-questions-content text-center">
                                                                    <p>
                                                                        {{ translate('frontstaticword.By')}}: 
                                                                        <strong> {{announcments.user}} </strong>  
                                                                        {{ translate('frontstaticword.On')}}: 
                                                                        <strong> {{ moment(announcments.updated_at).format("dddd, MMMM Do YYYY") }} </strong> 
                                                                    </p>
                                                                <p class=" text-truncate" v-html="announcments.detail"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- About Course -->
                                            <div class="overview-about-block shadow-sm">
                                                <div class="about-course-block">
                                                    <h3 class="about-course-heading">
                                                        {{ translate('frontstaticword.Aboutthiscourse')}}
                                                    </h3>
                                                    <p class="btm-40" v-html="course.short_detail"> </p>
                                                </div>
                                                <hr>
                                                <div class="about-course-number-block">
                                                    
                                                    <!-- Numbers -->
                                                    <div class="row text-dark">
                                                        <div class="col-lg-3 col-sm-4 col-4">
                                                            <div class="about-course-number">
                                                                {{ translate('frontstaticword.Bythenumbers')}}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-5 col-4">
                                                            <div class="about-course-number">
                                                                <ul>
                                                                    <li>
                                                                        {{ translate('frontstaticword.studentsenrolled')}}: 
                                                                        {{student_enrolled}}
                                                                    </li>                     
                                                                    <li>
                                                                        {{ translate('frontstaticword.Languages')}}: 
                                                                        {{language.name}}
                                                                    </li>                     
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-3 col-4">
                                                            <div class="about-course-number">
                                                                <ul>
                                                                    <li>
                                                                        {{ translate('frontstaticword.Classes')}}: 
                                                                        {{courseclass}}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    
                                                    <!-- Description -->
                                                    <div class="row" v-if="course.detail != null">
                                                        <div class="col-lg-3">
                                                            <div class="about-course-number">
                                                                <h4>
                                                                    {{ translate('frontstaticword.Description')}}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="about-course-number about-course-one">
                                                                <p v-html="course.detail"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <!-- Instructor -->
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <div class="about-course-number">
                                                                <h4>
                                                                    {{ translate('frontstaticword.Instructor')}}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <div class="about-course-number about-course-number-one">
                                                                <div class="about-img-block btm-20">
                                                                    
                                                                    <!-- Instructor Profile -->
                                                                    <div class="about-img">
                                                                        <router-link 
                                                                            :to="'/instructor_detail/'+ instructor.id + '/' + instructor.fname" 
                                                                            :title="translate('frontstaticword.profile')"
                                                                        >
                                                                            <img 
                                                                                :src="instructor.user_img ? `${path}/images/user_img/${instructor.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`" 
                                                                                class="img-fluid" 
                                                                                :alt="translate('frontstaticword.Instructor')">
                                                                        </router-link>
                                                                    </div>

                                                                    <!-- Instructor detail -->
                                                                    <div class="about-img-dtl">
                                                                        <div class="profile">
                                                                            <router-link 
                                                                                :to="'/instructor_detail/'+ instructor.id + '/' + instructor.fname" 
                                                                                :title="translate('frontstaticword.profile')"
                                                                            >
                                                                                {{instructor.fname}} {{instructor.lname}}
                                                                            </router-link>
                                                                        </div>
                                                                        <a :href="`mailto:${instructor.email}`">
                                                                            {{instructor.email}}
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <!-- Social Linkings -->
                                                                <ul>  
                                                                    <!-- Facebook -->
                                                                    <li class="rgt-10" v-if="instructor.fb_url">
                                                                        <a :href="instructor.fb_url" target="_blank" :title="translate('frontstaticword.Facebook')">
                                                                            <i class="fa fa-facebook"></i>
                                                                        </a>
                                                                    </li>  

                                                                    <!-- Twitter -->
                                                                    <li class="rgt-10" v-if="instructor.twitter_url">
                                                                        <a :href="instructor.twitter_url" target="_blank" :title="translate('frontstaticword.Twitter')">
                                                                            <i class="fa fa-twitter"></i>
                                                                        </a>
                                                                    </li> 

                                                                    <!-- Youtube -->
                                                                    <li class="rgt-10" v-if="instructor.youtube_url">
                                                                        <a :href="instructor.youtube_url" target="_blank" :title="translate('frontstaticword.Youtube')">
                                                                            <i class="fa fa-youtube"></i>
                                                                        </a>
                                                                    </li> 

                                                                    <!-- Linkedin -->
                                                                    <li class="rgt-10" v-if="instructor.linkedin_url">
                                                                        <a :href="instructor.linkedin_url" target="_blank" :title="translate('frontstaticword.LinkedIn')">
                                                                            <i class="fa fa-linkedin"></i>
                                                                        </a>
                                                                    </li> 
                                                                </ul>
                                                                <p v-html="instructor.detail"> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Overview Ended -->

                                    <!-- Course Content -->
                                    <div class="tab-pane fade" id="v-pills-course-content" role="tabpanel" aria-labelledby="v-pills-course-content-tab">
                                        <div id="accordion" class="myaccordion" v-if="chapters.length > 0">
                                            
                                            <form @submit.prevent>
                                                <div class="card" v-for="chapter in chapters" :key="chapter.id">
                                                    <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0">
                                                            <button class="accordion-button btn btn-link collapsed" data-toggle="collapse" :data-target="`#collapse${chapter.id}`" aria-expanded="false" :aria-controls="`${chapter.id}`">
                                                                <div class="row">

                                                                    <!-- About Chapter -->
                                                                    <div class="col-lg-6 col-7">
                                                                        <div class="row">

                                                                            <!-- Checkbox -->
                                                                            <div class="col-lg-1 col-2">
                                                                                <div class="course-content-checkbox">
                                                                                    <label class="checkbox">
                                                                                        <b-form-checkbox
                                                                                        :id="`${chapter.id}`"
                                                                                        v-model="status"
                                                                                        :value="`${chapter.id}`"
                                                                                        unchecked-value = null
                                                                                        >
                                                                                        </b-form-checkbox>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Title -->
                                                                            <div class="col-lg-11 col-10">
                                                                                <div class="card-course-content-heading">
                                                                                    {{chapter.chapter_name}}
                                                                                    <span class="course-duration"> 
                                                                                        {{chapter.courseclass.length}} 
                                                                                        {{translate('frontstaticword.lectures')}}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Total Classes -->
                                                                    <div class="col-lg-6 col-5">
                                                                        <div class="course-content-btn">
                                                                            <a class="class-btn">
                                                                                {{chapter.courseclass.length}} 
                                                                                {{translate('frontstaticword.Classes')}}
                                                                            </a>
                                                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                    </div>

                                                    <!-- Chapter Detail -->
                                                    <div :id="`collapse${chapter.id}`" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="row chapter__classes mr-2 ml-2 mb-10" v-for="(classes,index) in chapter.courseclass" :key="index">

                                                                <!-- Course Video/Image/PDf -->

                                                                <!-- Video -->
                                                                <div class="col-md-4" v-if="classes.type == 'video'">
                                                                    
                                                                    <!-- For url video classes -->
                                                                    <div v-if="classes.url != null">
                                                                        <video
                                                                            :id="classes.id"
                                                                            class="video-js vjs-default-skin"
                                                                            controls
                                                                            width="258" height="145"
                                                                            data-setup='{"techOrder": ["youtube"]}'								  
                                                                        >
                                                                        <source :src="classes.url" type="video/youtube" />
                                                                        </video>
                                                                    </div>

                                                                    <!-- For video classes -->
                                                                    <div v-if="classes.video != null">
                                                                        <video-player
                                                                        :src="`${path}/video/class/${classes.video}`"
                                                                        width="100%"
                                                                        />
                                                                    </div>
                                                                    
                                                                    <!-- For iframe video classes -->
                                                                    <div v-if="classes.iframe_url != null">
                                                                        <iframe :src="classes.iframe_url" width="258px" height="145px">
                                                                        </iframe>
                                                                    </div>
                                                                </div>
                                                                <!-- PDF -->
                                                                <div class="col-md-4 mt-2" v-if="classes.type == 'pdf'">
                                                                    <a :href="`${path}/files/pdf/${classes.pdf}`" :download="classes.pdf" target="_blank">
                                                                        <i class="fa fa-file-pdf-o mr-2"></i> 
                                                                        {{ translate('frontstaticword.save')}}
                                                                    </a>
                                                                </div>
                                                                <!-- Image -->
                                                                <div class="col-md-4 mt-2" v-if="classes.type == 'image'">
                                                                    <a :href="`${path}/images/class/${classes.image}`" :download="classes.image" target="_blank">
                                                                        <i class="fa fa-image mr-2"></i>
                                                                        {{ translate('frontstaticword.save')}}
                                                                    </a>
                                                                </div>

                                                                <!-- Course Detail -->
                                                                <div class="col-md-8">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            {{classes.title}}
                                                                            <br>
                                                                            <span v-if="classes.duration"> 
                                                                                {{classes.duration}}
                                                                                {{ translate('frontstaticword.min')}}
                                                                            </span>

                                                                            <span v-else>
                                                                                {{ translate('frontstaticword.NoDurationMentioned')}}
                                                                            </span>
                                                                        </button>

                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="width:100%">
                                                                            <div class="course-content-dropdown" v-if="classes.detail != null">
                                                                                <p v-html="classes.detail"></p>
                                                                            </div>

                                                                            <div class="course-content-dropdown text-center" v-else>
                                                                                <p>
                                                                                    {{ translate('frontstaticword.NoDetailyet')}}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Update course button -->
                                                <button type="submit" @click="courseProgressUpdate()" class="btn btn-danger mt-4">
                                                    {{ translate('frontstaticword.MarkasComplete')}}
                                                </button>
                                    
                                            </form>
                                        </div>

                                        <div class="myaccordion" v-else>
                                            <div class="bg-light mt-30 p-y80 b-50">
                                                <h5 class="text-center">
                                                    {{chapters.length}}
                                                    {{ translate('frontstaticword.CourseClassesComingSoon')}}!
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Course Content End -->

                                    <!-- Live Classes -->
                                    <div class="tab-pane fade" id="v-pills-live-classes" role="tabpanel" aria-labelledby="v-pills-live-classes-tab">
                                        <div class="live-class-block">

                                            <!-- Google Meetings -->
                                            <div v-if="this.settings.googlemeet_enable=='1'">
                                                <div class="meeting-block" v-if="google_meets.length > 0">
                                                    <h3 class="live-class-heading">
                                                        {{ translate('frontstaticword.GoogleMeetings')}}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-md-6" v-for="(meet,index) in google_meets" :key="index">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{meet.meeting_title}} 
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="live-class-img">
                                                                                <img 
                                                                                    :src="meet.image ? `${path}/images/googlemeet/profile_image/${meet.image}` : `${baseurl}/modules/blizzard/images/header-bg.jpg`" 
                                                                                    class="img-fluid" 
                                                                                    :alt="translate('frontstaticword.GoogleMeetings')">
                                                                            </div>

                                                                            <p class="card-text mt-2">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.Created')}}:
                                                                                </b> 
                                                                                {{meet.user_id}}
                                                                            </p>

                                                                            <p class="card-text">
                                                                                <b>{{ translate('frontstaticword.Agenda')}}:</b> 
                                                                                {{meet.agenda.length>160 ? meet.agenda.substring(0,160)+'..' : meet.agenda.length}} 
                                                                            </p> 

                                                                            <p class="card-text">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.MeetingTime')}}:
                                                                                </b> 
                                                                                {{meet.start_time}}
                                                                            </p>
                                                                            <a :href="meet.meet_url" target="_blank" class="btn btn-outline-info text-white">
                                                                                {{ translate('frontstaticword.JoinMeeting')}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Big Blue Meetings -->
                                            <div v-if="this.settings.bbl_enable=='1'">
                                                <div class="meeting-block" v-if="bigblue_meetings.length > 0">
                                                    <h3 class="live-class-heading">
                                                        {{ translate('frontstaticword.BigBlueMeetings')}}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-md-6" v-for="(meet,index) in bigblue_meetings" :key="index">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{meet.meeting_title}} 
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="live-class-img">
                                                                                <img 
                                                                                    :src="`${baseurl}/modules/blizzard/images/header-bg.jpg`" 
                                                                                    class="img-fluid" 
                                                                                    :alt="translate('frontstaticword.BigBlueMeetings')">
                                                                            </div>
                                                                            <p class="card-text mt-2">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.Created')}}:
                                                                                </b> 
                                                                                {{meet.user_id}}
                                                                            </p>
                                                                            <p class="card-text">
                                                                                <b>{{ translate('frontstaticword.Agenda')}}:</b> 
                                                                                {{meet.agenda.length>160 ? meet.agenda.substring(0,160)+'..' : meet.agenda}} 
                                                                            </p> 
                                                                            <p class="card-text">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.MeetingTime')}}:
                                                                                </b> 
                                                                                {{meet.start_time}}
                                                                            </p>
                                                                            <a :href="meet.meet_url" target="_blank" class="btn btn-outline-info text-white">
                                                                                {{ translate('frontstaticword.JoinMeeting')}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Jitsi Meetings -->
                                            <div v-if="this.settings.jitsimeet_enable=='1'">
                                                <div class="meeting-block" v-if="jitsi_meetings.length > 0">
                                                    <h3 class="live-class-heading">
                                                        {{ translate('frontstaticword.JitsiMeetings')}}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-md-6" v-for="(meet,index) in jitsi_meetings" :key="index">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{meet.meeting_title}} 
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="live-class-img">
                                                                                <img 
                                                                                    :src="meet.image ? `${path}/images/jitsimeet/${meet.image}` : `${baseurl}/modules/blizzard/images/header-bg.jpg`" 
                                                                                    class="img-fluid" 
                                                                                    alt="meeting">
                                                                            </div>
                                                                            <p class="card-text mt-2">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.Created')}}:
                                                                                </b> 
                                                                                {{meet.user_id}}
                                                                            </p>
                                                                            <p class="card-text">
                                                                                <b>{{ translate('frontstaticword.Agenda')}}:</b> 
                                                                                {{meet.agenda.length>160 ? meet.agenda.substring(0,160)+'..' : meet.agenda}} 
                                                                            </p> 
                                                                            <p class="card-text">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.MeetingTime')}}:
                                                                                </b> 
                                                                                {{meet.start_time}}
                                                                            </p>
                                                                            <a :href="meet.jitsi_url" target="_blank" class="btn btn-outline-info text-white">
                                                                                {{ translate('frontstaticword.JoinMeeting')}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Zoom Meetings -->
                                            <div v-if="this.settings.zoom_enable=='1'">
                                                <div class="meeting-block" v-if="zoom_meetings.length > 0">
                                                    <h3 class="live-class-heading">
                                                        {{ translate('frontstaticword.ZoomMeetings')}}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-md-6" v-for="(meet,index) in zoom_meetings" :key="index">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{meet.meeting_title}} 
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="live-class-img">
                                                                                <img 
                                                                                    :src="meet.image ? `${path}/images/zoom/${meet.image}` : `${baseurl}/modules/blizzard/images/header-bg.jpg`" 
                                                                                    class="img-fluid" 
                                                                                    alt="meeting">
                                                                            </div>
                                                                            <p class="card-text mt-2">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.Created')}}:
                                                                                </b> 
                                                                                {{meet.user_id}}
                                                                            </p>
                                                                            <p class="card-text">
                                                                                <b>{{ translate('frontstaticword.Agenda')}}:</b> 
                                                                                {{meet.agenda.length>160 ? meet.agenda.substring(0,160)+'..' : meet.agenda}} 
                                                                            </p> 
                                                                            <p class="card-text">
                                                                                <b>
                                                                                    {{ translate('frontstaticword.MeetingTime')}}:
                                                                                </b> 
                                                                                {{meet.start_time}}
                                                                            </p>
                                                                            <a :href="meet.zoom_url" target="_blank" class="btn btn-outline-info text-white">
                                                                                {{ translate('frontstaticword.JoinMeeting')}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Live Classes Ended -->

                                    <!-- Question and Answer -->
                                    <div class="tab-pane fade" id="v-pills-question" role="tabpanel" aria-labelledby="v-pills-question">
                                        <div class="question-top-block">
                                            
                                            <!-- If user have questions -->
                                            <div class="row" v-if="qa.length">
                                                <!-- Heading for Q and A -->
                                                <div class="col-lg-6">
                                                    <h3 class="question-text">
                                                        {{qa.length}} 
                                                        {{ translate('frontstaticword.QuestionsintheCourse')}}
                                                    </h3>
                                                </div>

                                                <!-- Ask Question button -->
                                                <div class="col-lg-6">
                                                    <div class="course-content-btn">
                                                        <a class="class-btn" v-b-modal.modal-prevent-closing>
                                                            {{ translate('frontstaticword.Askanewquestion')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- If course have no question answer -->
                                            <div class="row" v-else>
                                                <div class="col-lg-12">
                                                    <div class="course-content-btn">
                                                        <h3 class="question-text float-left">
                                                            {{ translate('frontstaticword.CoursehavenoQA')}}
                                                        </h3>
                                                        <a class="class-btn" v-b-modal.modal-prevent-closing>
                                                            {{ translate('frontstaticword.Askanewquestion')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--Ask Question  Modal -->
                                            <b-modal
                                            id="modal-prevent-closing"
                                            ref="modal"
                                            :title="translate('frontstaticword.PleaseenterQuestion')"
                                            @show="resetModal"
                                            @hidden="resetModal"
                                            @ok="handleOk" :ok-title="translate('frontstaticword.Submit')"
                                            >
                                                <form ref="form" @submit.prevent="handleSubmit">
                                                    <b-form-group
                                                    :label="translate('frontstaticword.Question')"
                                                    label-for="name-input"
                                                    :invalid-feedback="translate('frontstaticword.Questionisrequired')"
                                                    :state="nameState"
                                                    >
                                                    <b-form-textarea
                                                        id="name-input"
                                                        v-model="holdSubmitQuestion"
                                                        :state="nameState"
                                                        autofocus
                                                        required
                                                    ></b-form-textarea>
                                                    </b-form-group>
                                                </form>
                                            </b-modal>
                                        </div>

                                        <!-- Course Question and Answer -->
                                        <div class="question-block mt-4">
                                            <div class="card box-shadow mb-2" v-for="(question,index) in qa" :key="index">

                                                <!-- Questions and Ask Question -->
                                                <div class="card-header" id="headingThree">
                                                    <h2 class="mb-0">
                                                        <button class="accordion-button btn btn-link collapsed" data-toggle="collapse" :data-target="`#collapse${question.id}`" aria-expanded="false" aria-controls="collapseThree"> 
                                                            <i class="fa fa-angle-down float-left" aria-hidden="true"></i>
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <h6 class="question-heading">
                                                                        {{question.title}}
                                                                    </h6>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <a class="btn btn-primary add_asnwer" v-b-modal="'modal-prevent-closing-4'" @click="sendInfo(question.id)"> + Add Answer</a>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <!-- Answers -->
                                                <div :id="`collapse${question.id}`" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                    <!-- Answers for question -->
                                                    <div class="card-body" v-if="question.answer.length > 0">
                                                        <p v-for="(answer) in question.answer" :key="answer.id">
                                                            {{answer.answer}}
                                                        </p>
                                                    </div>

                                                    <!-- If question have no answers -->
                                                    <div class="card-body" v-else>
                                                        <p>No answers for this question.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Question and Answer Ended -->

                                    <!-- Quiz Started -->
                                    <div class="tab-pane fade" id="v-pills-quiz" role="tabpanel" aria-labelledby="v-pills-quiz-tab">
                                        <div class="quiz-block" v-if="quizs.length > 0">
                                            <!-- Quiz for the course -->
                                            <div class="row">
                                                <div class="col-lg-6 mt-4" v-for="(quiz,index) in quizs" :key="index">
                                                    
                                                    <!-- Subjective -->
                                                    <div v-if="quiz.type != null">
                                                        <h5 class="quiz-block-heading">
                                                            {{ translate('frontstaticword.Subjective')}}
                                                        </h5>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                
                                                                <h4 class="card-title">
                                                                    {{quiz.title}}
                                                                </h4>

                                                                <p class="card-text text-truncate" v-html="quiz.description"></p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.PerQuestionMark')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{quiz.per_question_mark}}
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.TotalMarks')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{quiz.per_question_mark}}
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.TotalQuestions')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{quiz.questions.length}}
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.QuizPrice')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{ translate('frontstaticword.FREE')}}
                                                                </p> 
                                                                <router-link :to="{name: 'start_quiz', params: {course_title: quiz.course, quiz_id: quiz.id, title: quiz.title, course_id: quiz.course_id}}" class="btn btn-secondary">
                                                                    {{ translate('frontstaticword.StartQuiz')}}
                                                                </router-link>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Objective -->
                                                    <div v-else>
                                                        <h5 class="quiz-block-heading">
                                                            {{ translate('frontstaticword.Objective')}}
                                                        </h5>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                
                                                                <h4 class="card-title">
                                                                    {{quiz.title}}
                                                                </h4>

                                                                <p class="card-text text-truncate" v-html="quiz.description"> 
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.PerQuestionMark')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{quiz.per_question_mark}}
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.TotalMarks')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{quiz.per_question_mark}}
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.TotalQuestions')}}
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{quiz.questions.length}}
                                                                </p> 

                                                                <p class="card-text">
                                                                    {{ translate('frontstaticword.QuizPrice')}} 
                                                                    <i class="fa fa-long-arrow-right mr-2 ml-2"></i> 
                                                                    {{ translate('frontstaticword.FREE')}}
                                                                </p>

                                                                <router-link :to="{name: 'start_quiz', params: {course_title: quiz.course, quiz_id: quiz.id, title: quiz.title, course_id: quiz.course_id}}" class="btn btn-secondary">
                                                                    {{ translate('frontstaticword.StartQuiz')}}
                                                                </router-link>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- If user have no quiz's -->
                                        <div class="quiz-block" v-else>
                                            <div class="bg-light mt-30 p-y80 b-50">
                                                <h5 class="text-center">
                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                    {{course.title}} {{ translate('frontstaticword.havenoquiz')}}.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Quiz Ended -->

                                    <!-- Announcement Started -->
                                    <div class="tab-pane fade" id="v-pills-announcments" role="tabpanel" aria-labelledby="v-pills-announcments-tab">
                                        <div class="announcments-block">
                                            <div class="row" v-if="announce.length > 0">
                                                <div class="col-lg-6" v-for="(announcement,index) in announce" :key="index">
                                                    <div class="card bg-white">
                                                        <div class="card-header text-center">
                                                            <p class="text-dark">
                                                                <i class="feather icon-radio"></i>
                                                                {{announcement.course_id}}
                                                            </p>
                                                        </div>
                                                        <div class="card-body">
                                                            <p v-html="announcement.detail"></p>
                                                        </div>
                                                        <div class="card-footer">
                                                            <i class="fa fa-user mr-1"></i>
                                                            {{announcement.user}}

                                                            <i class="fa fa-clock-o mr-1 ml-2" aria-hidden="true"></i> 
                                                            {{ moment(announcement.updated_at).format("dddd, MMMM Do YYYY") }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <!-- If user have no quiz's -->
                                            <div class="bg-light mt-30 p-y80 b-50" v-else>
                                                <h5 class="text-center">
                                                    <i class="fa fa-bullhorn mr-2" aria-hidden="true"></i>
                                                    {{course.title}} {{ translate('frontstaticword.havenoannouncement')}}.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Announcement Ended -->

                                    <!-- Assignment Started -->
                                    <div v-if="this.settings.assignment_enable=='1'" class="tab-pane fade" id="v-pills-assignment" role="tabpanel" aria-labelledby="v-pills-assignment-tab">
                                        <div class="assignment-block" v-if="chapters.length > 0">
                                            
                                            <h3 class="assignment-heading text-center">
                                                {{ translate('frontstaticword.YourAssignments')}}
                                            </h3>
                                            <div class="assignments-btn text-center">
                                                <button type="button" class="btn btn-secondary" v-b-modal.modal-prevent-closing-3>
                                                    {{ translate('frontstaticword.SubmitAssignment')}}
                                                </button>
                                            </div>

                                            <!-- Assignment Submit Modal -->
                                            <b-modal
                                            id="modal-prevent-closing-3"
                                            ref="modal"
                                            :title="translate('frontstaticword.RequestAssignment')"
                                            @show="resetModalAssignment"
                                            @hidden="resetModalAssignment"
                                            @ok="handleAssignment" :ok-title="translate('frontstaticword.Submit')"
                                            >
                                                <form ref="form" @submit.prevent="handleSubmit" enctype="multipart/form-data">

                                                    <!-- Select chapter -->
                                                    <b-form-group
                                                    :label="translate('frontstaticword.SelectChapter')"
                                                    label-for="assignment-select-chapter"
                                                    :invalid-feedback="translate('frontstaticword.PleaseSelectChapter')"
                                                    :state="chapterState"
                                                    >
                                                        <b-form-select v-model="selected">
                                                            <b-form-select-option  v-for="(chapter,index) in chapters" :key="index" :value="chapter.id">{{chapter.chapter_name}}</b-form-select-option>
                                                        </b-form-select>

                                                    </b-form-group>

                                                    <!-- Title -->
                                                    <b-form-group
                                                    :label="translate('frontstaticword.Title')+':'"
                                                    label-for="assignment-title-input"
                                                    :invalid-feedback="translate('frontstaticword.Titleisrequired')"
                                                    :state="assignmentTitleState"
                                                    >
                                                        <b-form-input
                                                            id="name-input"
                                                            v-model="assignmentTitle"
                                                            :state="assignmentTitleState"
                                                            autofocus
                                                            required
                                                        ></b-form-input>
                                                    </b-form-group>

                                                    <!-- Upload assignment -->
                                                    <b-form-group
                                                    label="Upload assignment"
                                                    :label-for="translate('frontstaticword.Uploadassignment')">

                                                        <b-form-file
                                                        v-model="assignmentFile"
                                                        :state="Boolean(assignmentFile)"
                                                        :placeholder="translate('frontstaticword.Chooseafileordropithere')+'...'"
                                                        :drop-placeholder="translate('frontstaticword.Dropfilehere')+'...'"
                                                        >
                                                        </b-form-file>
                                                        
                                                        <div class="mt-3">
                                                            {{ translate('frontstaticword.Selectedfile')}}: 
                                                            {{ assignmentFile ? assignmentFile.name : '' }}
                                                        </div>
                                                    </b-form-group>

                                                </form>
                                            </b-modal>
                                            <!-- Assignment Submit Modal Ended -->

                                            <!-- Show Assignment -->
                                            <div class="row">
                                                <div class="col-lg-4" v-for="(assignment,index) in assignments" :key="index">
                                                    <div class="card text-center">

                                                        <div class="card-body">
                                                            <div>
                                                                <strong>
                                                                    {{ translate('frontstaticword.Instructor')}}:
                                                                </strong> 
                                                                {{assignment.instructor}}
                                                            </div>

                                                            <div>
                                                                <strong>
                                                                    {{ translate('frontstaticword.Title')}}:
                                                                </strong> 
                                                                {{assignment.title}}
                                                            </div>

                                                            <div>
                                                                <strong>
                                                                    {{ translate('frontstaticword.Chapter')}}:
                                                                </strong> 
                                                                {{assignment.chapter_id}}
                                                            </div>
                                                        </div>

                                                        <div class="card-footer">
                                                            <a :href="assignment.assignment_path" type="button" class="btn btn-warning" download>
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger" @click="assignmentDelete(assignment.id)">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Show Assignment End -->
                                        </div>

                                        <!-- If user have no chapters -->
                                        <div class="bg-light text-center p-y80" v-else>
                                            <h5>
                                                <i class="fa fa-file-text-o mr-2" aria-hidden="true"></i>
                                                {{ translate('frontstaticword.Noassmessage')}}.
                                            </h5>
                                        </div>
                                    </div>
                                    <!-- Assignment Ended -->

                                    <!-- Appointment -->
                                    <div v-if="this.settings.appointment_enable=='1'" class="tab-pane fade" id="v-pills-appointment" role="tabpanel" aria-labelledby="v-pills-appointment-tab">
                                        <div class="appointment-block">

                                            <h3 class="appointment-heading text-center">
                                                {{ translate('frontstaticword.YourAppointment')}}
                                            </h3>
                                            <div class="appointment-btn text-center">
                                                <button type="button" class="btn btn-secondary" v-b-modal.modal-prevent-closing-2>
                                                    {{ translate('frontstaticword.RequestAppointment')}}
                                                </button>
                                            </div>

                                            <!-- Appointment Submit Modal -->
                                            <b-modal
                                            id="modal-prevent-closing-2"
                                            ref="modal"
                                            :title="translate('frontstaticword.RequestAppointment')"
                                            @show="resetModalAppointment"
                                            @hidden="resetModalAppointment"
                                            @ok="handleAppointment" :ok-title="translate('frontstaticword.Submit')"
                                            >
                                                <form ref="form" @submit.prevent="handleSubmit">
                                                    <b-form-group
                                                    :label="translate('frontstaticword.Title')+':'"
                                                    label-for="name-input"
                                                    :invalid-feedback="translate('frontstaticword.Titleisrequired')"
                                                    :state="titleState"
                                                    >
                                                        <b-form-input
                                                            id="name-input"
                                                            v-model="appointmentTitle"
                                                            :state="titleState"
                                                            autofocus
                                                            required
                                                        ></b-form-input>
                                                    </b-form-group>

                                                    <b-form-group
                                                    :label="translate('frontstaticword.Details')+':'"
                                                    label-for="name-input"
                                                    :invalid-feedback="translate('frontstaticword.Detailisrequired')"
                                                    :state="detailState"
                                                    >
                                                    <b-form-textarea
                                                        id="name-input"
                                                        v-model="appointmentDetail"
                                                        :state="detailState"
                                                        required
                                                    ></b-form-textarea>
                                                    </b-form-group>
                                                </form>
                                            </b-modal>
                                            
                                            <!-- Show appointments -->
                                            <div class="row">
                                                <div class="col-lg-4" v-for="(appointment,index) in appointments" :key="index">
                                                    <div class="card text-center">
                                                        <div class="card-body">
                                                            <div>
                                                                <strong>
                                                                    {{ translate('frontstaticword.Instructor')}}:
                                                                </strong> 
                                                                {{appointment.instructor}}
                                                            </div>

                                                            <div>
                                                                <strong>
                                                                    {{translate('frontstaticword.Details')+':'}}
                                                                </strong> 
                                                                {{appointment.detail}}
                                                            </div>

                                                            <!-- <div v-if="appointment.reply != null">
                                                                <strong>Reply:</strong><p v-html="appointment.reply"></p>
                                                            </div> -->
                                                            <div>
                                                                <strong>
                                                                    {{ translate('frontstaticword.Accepted')}}:
                                                                </strong> 
                                                                {{appointment.accept == 0 ? 'No' : 'Yes'}}
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="btn btn-danger" @click="appointmentDelete(appointment.id)">
                                                                <i class="fa fa-trash mr-2"></i>
                                                                {{ translate('frontstaticword.Delete')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Appointment Ended -->

                                    <!-- Answer Submit Modal -->
                                    <b-modal
                                    id="modal-prevent-closing-4"
                                    ref="modal"
                                    :title="translate('frontstaticword.Answer')"
                                    @show="resetModalAnswer"
                                    @hidden="resetModalAnswer"
                                    @ok="handleAnswer" :ok-title="translate('frontstaticword.Submit')"
                                    >
                                        <form ref="form" @submit.prevent="handleSubmit">

                                            <b-form-group
                                            :label="translate('frontstaticword.Answer')+':'"
                                            label-for="answer-input"
                                            :invalid-feedback="translate('frontstaticword.Answerisrequired')"
                                            :state="answerTitleState"
                                            >
                                                <b-form-textarea
                                                    id="answer-input"
                                                    v-model="answerTitle"
                                                    :state="answerTitleState"
                                                    required
                                                    autofocus
                                                ></b-form-textarea>
                                            </b-form-group>

                                        </form>
                                    </b-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- If user have not purchased course -->
            <div class="container mt-70 mb-4 bg-light p-y80 b-50" v-else>
                <!-- User not login -->
                <div class="text-center">
                    <h5>{{ translate('frontstaticword.Youhavenotpurchasedthiscourse')}}!</h5>
                </div>
            </div>
        </div>    

        <!-- If user is not login -->
        <div v-else>
            <sign-in :guest="1" />
        </div>

        <footer-section />
            
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import VideoPlayer from '../VideoPlayer.vue';
    import signIn from '../Login.vue';

    export default {

        name: 'got_to_course',

        mixins: [mixin],

        components: 
        {
            headerSection,
            footerSection,
            VideoPlayer,
            signIn
        },

        data() {
            return {
                baseurl: baseurl,
                question_id: null,
                path: null,
                course_id: this.$route.params.id,
                course_title: this.$route.params.title,
                course: {},
                student_enrolled: 0,
                language: {},
                courseclass: 0,
                errors: {},
                questions: null,
                announcments: null,
                qa: [],
                holdSubmitQuestion: '',
                nameState: null,
                announce: [],
                appointments: [],
                titleState: null,
                appointmentTitle: '',
                appointmentDetail: '',
                detailState: null,
                assignments: [],
                selected: null,
                chapters: [],
                chapterState: null,
                assignmentFileState: null,
                assignmentFile: null,
                assignmentTitleState: null,
                assignmentTitle: '',
                answerTitleState: null,
                answerTitle: '',
                quizs: [],
                progress: {},
                markChapterLength: 0,
                markChapters: [],
                allChapterLength: 0,
                instructor: {},
                purchased: false,
                orderhistory: {},
                bigblue_meetings: [],
                google_meets: [],
                jitsi_meetings: [],
                zoom_meetings: [],
                status: [],
                tab_loading: true,
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME,
                course_player: null,
                continueWatchStatus: false

            }
        },

        metaInfo() 
        {
            return {
                title: `${this.course_title ?? 'Course'} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.course_title + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {

            // Call api for basic course detail (will be called by default when the component is called)
            async callAPI() {

                if(this.loginStatus == true)
                {
                    this.courseProgress();
                    this.purchasehistory(this.course_id);

                    await axios.post('/api/course/detail?secret=' + this.$secretKey, {

                        course_id: this.course_id

                    }).then(res => {

                        this.course = res.data.course;
                        this.student_enrolled = res.data.student_enrolled;
                        this.language = res.data.course.language;
                        this.courseclass = res.data.course.courseclass.length;
                        this.instructor = res.data.course.user;

                    }).catch(err => {

                        if (err.response.status === 401) {
                            console.log(err.response);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                    });
                }

            },

            // Call the course content API for (Q-A, Announcments, Assignments, Quiz)
            async courseContent() 
            {
                let apiData = 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }  
                }

                await axios.get(`/api/course/content/${this.course_id}?secret=${this.$secretKey}`, apiData)
                .then(res=> {

                    this.chapters = res.data.chapter;
                    this.bigblue_meetings = res.data.bigblue_meeting;
                    this.google_meets = res.data.google_meet;
                    this.jitsi_meetings = res.data.jitsi_meeting;
                    this.zoom_meetings = res.data.zoom_meeting;

                    var lastArrayQuestion = res.data.questions.length - 1;
                    this.questions = res.data.questions[lastArrayQuestion];
                    this.qa = res.data.questions;
                    
                    var lastArrayAnnouncement = res.data.announcement.length - 1;
                    this.announcments = res.data.announcement[lastArrayAnnouncement];
                    this.announce = res.data.announcement;
                    
                    this.appointments = res.data.appointment;
                    this.assignments = res.data.assignment;

                    this.quizs = res.data.quiz;
                    this.quizs = this.quizs.map(function(quiz)
                    {
                        if(quiz.due_days != '')
                        {
                            if(quiz.today_date >= quiz.quiz_live_days) {
                                return quiz;
                            }
                        }
                        else {
                            return quiz;
                        }
                        
                    });

                    this.quizs = $.grep(this.quizs, function(quiz) {
                        return quiz != undefined;
                    });

                    this.tab_loading = false;

                })
                .catch(err => 
                {
                    if (err.response.status === 401) 
                    {
                        console.log(err.response);
                    }

                    if (err.response) 
                    {
                        this.errors = err.response.data.errors;
                        console.log(this.errors);
                    }

                });
            },

            // To recall the appointment after the submission of an appointment
            recallAppointment(){

                let apiData = {
                    params: {
                        secret: this.$secretKey
                    }
                }

                axios.get(`/api/course/content/${this.course_id}`, apiData)
                .then(res=> {

                    this.appointments = res.data.appointment;

                })
            },

            // To recall the question after the submission of an question or an answer
            recallQuestion() {
                let apiData = {
                    params: {
                        secret: this.$secretKey
                    }
                }

                axios.get(`/api/course/content/${this.course_id}`, apiData)
                .then(res=> {
                  
                    this.qa = res.data.questions;

                }).catch(err=> {

                    console.log(err.response);

                });
            },

            // Validation for submit question
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.nameState = valid
                return valid
            },

            // Reset submit question modal after closing
            resetModal() {
                this.holdSubmitQuestion = ''
                this.nameState = null
            },

            // Prevent closing and call submit question function on submit
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.submitQuestion()
            },

            // Submit Question function
            async submitQuestion() 
            {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                    return
                }

                let configData = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }
                }
                
                await axios.post('/api/question/submit', {
                    
                    course_id: this.course_id,
                    question: this.holdSubmitQuestion
                    
                },configData)
                .then(res=> {

                    if(res.status == 200)
                    {
                        let config = {
                            text: "Question submitted succssfully",
                            button: 'CLOSE'
                        }

                        this.$snack['success'](config);
                        this.recallQuestion();
                    }

                    if(res.data.status == 'fail')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }

                        this.$snack['danger'](config);
                    }

                }).catch(err=> {

                    console.log(err.response);
                });

                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
                
            },

            // Reset appointment modal after closing
            resetModalAppointment(){
                this.titleState = null,
                this.appointmentTitle = '',
                this.appointmentDetail = '',
                this.detailState = null
            },

            // Prevent closing and call request appointment function on submit
            handleAppointment(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.requestAppointment()
            },

            // Validation for request appointment
            checkAppointmentValidity() {
                const valid = this.$refs.form.checkValidity()
                this.titleState = valid,
                this.detailState = valid
                return valid
            },

            // Sunmit the request appointment form
            async requestAppointment() {
                // Exit when the form isn't valid
                if (!this.checkAppointmentValidity()) {
                    return
                }

                let configData = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }
                }

                await axios.post('/api/appointment/request', {

                    course_id: this.course_id,
                    title: this.appointmentTitle,
                    detail: this.appointmentDetail

                }, configData)
                .then(res=> {

                    if(res.status == 200)
                    {
                        let config = {
                            text: 'Appointment submit successfully',
                            button: 'CLOSE'
                        }

                        this.$snack['success'](config);
                        this.recallAppointment();
                    }

                }).catch(err=> {

                    console.log(err.response);
                    
                });
                
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing-2')
                })
            },

            // Function for appointment delete
            async appointmentDelete(id) {

                await axios.post(`/api/appointment/delete/${id}?secret=` + this.$secretKey,{
                    //data
                },
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }
                })
                .then(res=> {

                    if(res.status == 200){
                        
                        let config = {
                            text: res.data,
                            button: 'CLOSE'
                        }

                        this.$snack['success'](config);
                        this.recallAppointment();
                    }

                }).catch(err=> {

                    console.log(err.response);

                })
            },

            // Reset assignment modal after closing
            resetModalAssignment(){
                this.chapterState = null,
                this.selected = null,
                this.assignmentFileState = null,
                this.assignmentFile = null,
                this.assignmentTitleState = null,
                this.assignmentTitle = ''
            },

            // Prevent closing and call submit assignment function on submit
            handleAssignment(bvModalEvt){
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.submitAssignment()
            },

            // Validation for assignment submission
            checkAssignmentValidity() {
                const valid = this.$refs.form.checkValidity()
                this.chapterState = valid,
                this.assignmentTitleState = valid,
                this.assignmentFileState = valid
                return valid
            },

            // recall only assignemnt after submission of assignemnt
            recallAssignment() {
                let apiData = {
                    params: {
                        secret: this.$secretKey
                    }
                }

                axios.get(`/api/course/content/${this.course_id}`, apiData)
                .then(res=> {

                    this.assignments = res.data.assignment;

                })
            },
            
            // Submit the assignemnt function
            async submitAssignment() {

                // Exit when the form isn't valid
                if (!this.checkAssignmentValidity()) {
                    return
                }

                let apiData = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        "Content-type" : "multipart/form-data"
                    },
                    params: {
                        secret: this.$secretKey
                    }
                }

                let formData = new FormData();

                formData.append('course_id', this.course_id);
                formData.append('chapter_id', this.selected);
                formData.append('title', this.assignmentTitle);
                formData.append('file', this.assignmentFile);


                await axios.post('/api/assignment/submit', formData, apiData)
                .then(res=> {

                    if(res.data.status == 'fail')
                    {
                        let configFail = {
                            text: res.data.message,
                            button: 'CLOSE !'
                        }

                        this.$snack['danger'](configFail);
                    }

                    if(res.data.status == 'success')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE !'
                        }

                        this.$snack['success'](config);
                        this.recallAssignment();
                    }

                }).catch(err=> {

                    console.log(err.response);

                });
                
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing-3')
                })
            },

            // Reset answer modal after closing
            resetModalAnswer() {
                this.answerTitleState = null,
                this.answerTitle = ''
            },

            // Prevent closing and call submit answer function on submit
            handleAnswer(bvModalEvt){
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.submitAnswer()
            },

            // Validation for answer submission
            checkAnswerValidity() {
                const valid = this.$refs.form.checkValidity()
                this.answerTitleState = valid
                return valid
            },

            // Get question ID
            sendInfo(id){
                this.question_id = id;
            },

            // Call api to submit the answer to the specific question
            async submitAnswer() {

                // Exit when the form isn't valid
                if (!this.checkAnswerValidity()) {
                    return
                }

                let apiData = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }
                
                let answerData = {
                    course_id: this.course_id,
                    question_id: this.question_id,
                    answer: this.answerTitle
                }
                await axios.post('/api/answer/submit', answerData ,apiData)
                .then(res=> {
                    
                    if(res.data.status == 'fail')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE!'
                        }

                        this.$snack['danger'](config);
                    }

                    if(res.data.status == 'success')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE!'
                        }

                        this.$snack['success'](config);
                        this.recallQuestion();
                        this.question_id = null
                    }

                }).catch(err=> {

                    console.log(err.response);

                });

                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing-4')
                })
            },

            // Get the course progress
            async courseProgress() {

                await axios.post('/api/course/progress?secret=' + this.$secretKey, {

                    course_id: this.course_id

                },
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`   
                    }
                })
                .then(res=> {
                    
                    this.progress = res.data.progress;
                    this.markChapters = res.data.progress.mark_chapter_id;
                    if(this.progress != null)
                    {
                        this.markChapterLength = this.progress.mark_chapter_id.length;
                        this.allChapterLength = this.progress.all_chapter_id.length
                    }

                }).catch(err=> {

                    console.log(err.response);

                });
            },

            // Get-Download certificate function
            async getCertificate() {

                await axios.get(`/api/certificate/download/${this.course_id}`,
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    },
                    responseType: 'arraybuffer'
                })
                .then(res=> {

                    let url = window.URL.createObjectURL(new Blob([res.data]));
                    let link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'file.pdf');
                    link._target = 'blank';
                    link.click();

                    let config = {
                            text: 'Certificate downloading...',
                            button: 'CLOSE!'
                    }

                    this.$snack['success'](config);

                }).catch(err=> {

                    console.log(err.response);

                })
            },

            // To get the purchase history of user
            async purchasehistory(id) {

                if(this.loginStatus == true)
                {
                    let apiData = {
                        params: 
                        {
                            secret :this.$secretKey
                        },
                        headers: 
                        {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }

                    await axios.get('/api/purchase/history', apiData)
                    .then(res => {

                        if(res.status == 200)
                        {
                            this.orderhistory = res.data.orderhistory;

                            this.orderhistory.forEach(orders => {
                                
                                if(id == orders.course_id)
                                {
                                    this.purchased = true;
                                    return false;
                                }
                                
                            });
                            
                        }
                    })
                }
            },

            // Update course progress
            async courseProgressUpdate() {

                // return alert(this.status);

                await axios.post(`/api/course/progress/update?secret=${this.$secretKey}`,
                {    
                    course_id: this.course_id,
                    checked: this.status
                },
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                })
                .then(res=> {

                    if(res.status == 200)
                    {
                        let config = {
                            text: res.data,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.courseProgress();
                    }

                })
                .catch(err=> {

                    console.log(err.response);

                })
            },

            // continue watch course
            async continue_watching() {

                let apiData = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }
                await axios.get(`/api/watch/course/${this.course_id}`, apiData)
                .then(res=> {
                    
                    this.course_player = res.data;
                    this.continueWatchStatus = true;

                })
                .catch(err=> {
                    console.log(err.response);
                })
            }

        },

        mounted() {
            
            this.path = axios.defaults.baseURL;
            this.callAPI();
            this.courseContent();

        }
    }

</script>