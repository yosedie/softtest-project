<template>
    <div>
        
        <header-section />

        <!-- About Instructor section -->
        <section class="about-instructor">
            <div class="container">

                <!-- About Instructor -->
                <div class="row" v-if="!loading">
                    <!-- User Profile -->
                    <div class="col-md-4">
                        <div class="about-instructor-img text-center">
                            <img 
                            :src="instructor.user_img ? `${path}/images/user_img/${instructor.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`" 
                            alt="instructor_profile" class="b-50">
                        </div>

                        <h5 class="mt-4 p-3 ml-2 border text-center text-warning" v-if="instructor.verified != 0">
                            <i class="fa fa-star"></i>
                            {{ translate('frontstaticword.Verified')}}
                        </h5>
                    </div>

                    <div class="col-md-8">
                        <!-- Name -->
                        <h2>
                            {{instructor.fname}} {{instructor.lname}}
                        </h2>

                        <!-- Detail -->
                        <p v-html="instructor.detail"> </p>

                        <ul class="mt-4">
                            <!-- Students -->
                            <li>
                                <i class="fa fa-user"></i>
                                {{enrolled_user}} {{ translate('frontstaticword.Students')}}
                            </li>

                            <!-- Courses -->
                            <li>
                                <i class="fa fa-folder"></i>
                                {{course_count}} {{ translate('frontstaticword.Courses')}}
                            </li>
                            
                            <!-- Mail -->
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a :href="`mailto: ${instructor.email}`">
                                    {{instructor.email}}
                                </a>
                            </li>
                        </ul>

                        <!-- Social Channels -->
                        <ul class="instructor-social-links mt-4">
                            <!-- Facebook -->
                            <li v-if="instructor.fb_url != null">
                                <a class="text-info" :href="instructor.fb_url" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                    {{ translate('frontstaticword.Facebook')}}
                                </a>
                            </li>
                            <!-- Twitter -->
                            <li v-if="instructor.twitter_url != null">
                                <a class="text-info" :href="instructor.twitter_url" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                    {{ translate('frontstaticword.Twitter')}}
                                </a>
                            </li>
                            <!-- Youtube -->
                            <li v-if="instructor.youtube_url != null">
                                <a class="text-danger" :href="instructor.youtube_url" target="_blank">
                                    <i class="fa fa-youtube"></i>
                                    {{ translate('frontstaticword.Youtube')}}
                                </a>
                            </li>
                            <!-- Linkedin -->
                            <li v-if="instructor.linkedin_url != null">
                                <a class="text-info" :href="instructor.linkedin_url" target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                    {{ translate('frontstaticword.LinkedIn')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Skeleton loading of about instructor section till we get data from API -->
                <div class="row" v-else>
                    <div class="col-md-4">
                        <b-skeleton-img></b-skeleton-img>
                    </div>

                    <div class="col-md-8">
                        <b-skeleton width="30%"></b-skeleton>
                        <b-skeleton class="mt-4"></b-skeleton>
                        <b-skeleton v-for="(loop,index) in loops" :key="index"></b-skeleton>
                        <b-skeleton type="button"></b-skeleton>
                    </div>
                </div>
            </div>
        </section>

        <!-- Courses -->
        <section class="mt-70 mb-4 about-admin-course" v-if="!loading">
            <div class="container" v-if="courses.length">
                <div class="row course-tabs">
                    <div class="col-md-12">
                        <h3 class="mb-2"> 
                            {{courses.length}} {{ translate('frontstaticword.Coursesof')}} {{instructor.fname}} 
                        </h3>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4" v-for="(course,index) in courses" :key="index">
                        <div class="card">
                            <div class="bttn position-relative">

                                <!-- Course Image -->
                                <img 
                                    :src="course.preview_image!=null ? `${path}/images/course/${course.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`" 
                                    class="card-img-top" 
                                    alt="course_image">

                                <!-- Level Tag -->
                                <a v-if="course.level_tags!=null">
                                    {{course.level_tags}}
                                </a>
                            </div>
                            <div class="p-x">

                                <!-- Course Detail -->
                                <div class="card-body py-3">
                                    <h5 class="card-title mt-2 truncate">
                                        {{course.title.length>30 ? course.title.substring(0,30)+'..' : course.title}}
                                    </h5>
                                    <p class="card-text" v-html="course.short_detail.length>70 ? course.short_detail.substring(0,70)+'..' : course.short_detail"> </p>
                                </div>
                                <ul class="list-group list-group-flush inline-block">
                                    <li class="list-group-item pb-3">
                                        
                                        <!-- about instructor -->
                                        <img class="mr-2"
                                            :src="instructor.user_img!=null ? `${path}/images/user_img/${instructor.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`">
                                        <strong>
                                            {{ translate('frontstaticword.By')}} {{instructor.fname}}
                                        </strong>
                                    </li>
                                </ul>

                                <div class="price float-right mr-2">
                                    <!-- If course is discounted -->
                                    <div v-if="course.discount_price != null && course.discount_price != null">
                                        <span>
                                            {{currency.icon}}
                                            {{course.discount_price}} 
                                        </span>
                                        <del>
                                            {{currency.icon}}
                                            {{course.price}}
                                        </del>
                                    </div>

                                    <!-- If course has no discount -->
                                    <div v-if="course.discount_price == null && course.price != null">
                                        <span>
                                            {{currency.icon}}
                                            {{course.price}}
                                        </span>
                                    </div>
                                    
                                    <!-- If course is free -->
                                    <div v-if="course.discount_price == null && course.discount_price == null">
                                        <span>{{ translate('frontstaticword.FREE')}}</span>
                                    </div>
                                </div>

                                <!-- Go TO Course -->
                                <div class="start-btn text-center">
                                    <router-link :to="'/course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                        {{ translate('frontstaticword.GoToCourse')}}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skeleton loading of courses -->
        <section class="mt-70 mb-4" v-else>
            <div class="container">
                <user-courses />
            </div>
        </section>

        <footer-section />
    </div>    
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import  headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import userCourses from '../Skeletons/UserCourses.vue';

    export default {

        name: 'instructor_detail',

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            userCourses
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                instructor_id: this.$route.params.id,
                instructor_name: this.$route.params.name,
                loop: 0,
                loops: 5,
                instructor: {},
                loading: true,
                courses: [],
                enrolled_user: 0,
                course_count: 0,
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // SEO data , meta tag and meta title details
        metaInfo() {
            return {
                title: `${this.instructor_name ?? 'Instructor'} | ${this.settings.project_title ?? 'Loading...'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.meta.name + ' Quiz | ' + this.settings.project_title
                    },
                    {
                        property: 'og:site_name',
                        content: this.settings.project_title
                    },
                    {
                        property: 'og:description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:type',
                        content: 'profile'
                    },
                    {
                        property: 'og:url',
                        content: this.meta.profileurl
                    },
                    {
                        property: 'og:image',
                        content: this.baseurl + '/images/logo' + this.settings.logo
                    }
                ]
            }
        },

        methods: {

            // Call API to get instructor detail (this function will be called by default on the call of this component)
            async callInstructorApi() 
            {
                await axios.post(`/api/instructor/profile?secret=${this.$secretKey}`, 
                {    
                    instructor_id: this.instructor_id
                })
                .then(res=> 
                {
                    this.instructor = res.data.user;
                    this.enrolled_user = res.data.enrolled_user;
                    this.course_count = res.data.course_count;
                    this.courses = res.data.course;
                    this.loading = false;
                })
                .catch(err=>
                {    
                    console.log(err.response);
                    this.loading = false;
                })
            }
        },

        mounted() 
        {
            this.path = axios.defaults.baseURL;
            this.callInstructorApi();
        }
    }
</script>