<template>
    <div>
        <headerSection />
        
         <!-- User section -->
        <section class="user-profile-main-block">
            <div class="container">
                <div class="row" v-if="loginStatus">
                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-5">
                        <profileSidebar />
                    </div>

                    <!-- Courses -->
                    <div class="col-lg-8 col-md-7">
                        <div class="row course-tabs" v-if="courseLength > 0">
                            <div class="col-lg-6 col-md-6 col-12 mb-20" v-for="(my_course,index) in my_courses" :key="index">
                                <div class="card">
                                    <div class="bttn position-relative">

                                        <!-- Bundle Course Image -->
                                        <img 
                                            v-if="my_course.enroll.course_id == null" 
                                            :src="my_course.bundle.preview_image ? `${path}/images/bundle/${my_course.bundle.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`"
                                            alt="bundle course image">

                                        <!-- Course Image -->
                                        <img 
                                            v-if="my_course.enroll.course_id != null"
                                            :src="my_course.course.preview_image ? `${path}/images/course/${my_course.course.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`"
                                            alt="course image">

                                        <!-- Level tag -->
                                        <div v-if="my_course.course.level_tags != null">
                                            <router-link v-if="my_course.enroll.course_id!=null"
                                                :to="'/course_content/' + my_course.course.id + '/' + my_course.course.title.replace(/\s+/g, '_')"
                                                tabindex="0">
                                                {{my_course.course.level_tags}}
                                            </router-link>
                                        </div>
                                    </div>

                                    <div class="p-x">
                                        <div class="card-body py-3">

                                            <!-- Course Title -->
                                            <router-link v-if="my_course.enroll.course_id != null"
                                                :to="'/course_content/' + my_course.course.id + '/' + my_course.course.title.replace(/\s+/g, '_')">
                                                <h5 class="card-title mt-2"> 
                                                    {{my_course.course.title.length>30 ? my_course.course.title.substring(0,30)+'..' : my_course.course.title}} 
                                                </h5>
                                            </router-link>

                                            <!-- Bundle course title -->
                                            <router-link v-if="my_course.enroll.course_id == null"
                                                :to="'bundle_course_detail'+ '/' + my_course.enroll.bundle_id + '/' + my_course.bundle.title.replace(/\s+/g, '_')">
                                                <h5 class="card-title mt-2"> 
                                                    {{my_course.bundle.title.length>30 ? my_course.bundle.title.substring(0,30)+'..' : my_course.bundle.title}} 
                                                    ({{my_course.bundle.course_id.length}}) 
                                                    Courses
                                                </h5>
                                            </router-link>

                                            <!-- Simple Course Short Description -->
                                            <div v-if="my_course.enroll.course_id != null">
                                                <p class="card-text"
                                                    v-if="my_course.course.short_detail != null">
                                                    {{my_course.course.short_detail.length>60 ? my_course.course.short_detail.substring(0,60)+'..' : my_course.course.short_detail}}
                                                </p>
                                            </div>

                                            <!-- Bundle Course Short Description -->
                                            <div v-if="my_course.enroll.course_id == null">
                                                <p class="card-text"
                                                    v-if="my_course.bundle.short_detail != null"
                                                    v-html="my_course.bundle.short_detail.length>60 ? my_course.bundle.short_detail.substring(0,60)+'..' : my_course.bundle.short_detail">
                                                </p>
                                            </div>

                                            <!-- Progress bar -->
                                            <div v-if="my_course.enroll.course_id != null">
                                                <div v-if="my_course.course.progress.length > 0">
                                                    <div class="course-progress mb-2" v-for="(progress,id) in my_course.course.progress" :key="id">
                                                        <b-progress :value="progress.mark_chapter_id.length" :max="progress.all_chapter_id.length" show-progress animated variant="success">
                                                        </b-progress>
                                                    </div>
                                                </div>
                                            
                                                <!-- If user have no progress bar (ui fixing) -->
                                                <div class="mt-4" v-else>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="list-group list-group-flush">
                                            <!-- Instructor Details -->
                                            <li class="list-group-item pb-3 d-flex align-items-center">
                                                <!-- Simple course -->
                                                <img
                                                    v-if="my_course.enroll.course_id != null" 
                                                    class="mr-3"
                                                    :src="my_course.course.user.user_img ? `${path}/images/user_img/${my_course.course.user.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`"
                                                    alt="Intructor_profile">
                                                <strong v-if="my_course.enroll.course_id != null">
                                                    {{my_course.course.user.fname}} {{my_course.course.user.lname}}
                                                </strong>

                                                <!-- Bundle course -->
                                                <img
                                                    v-if="my_course.enroll.course_id == null"  
                                                    class="mr-3"
                                                    :src="my_course.bundle.user.user_img ? `${path}/images/user_img/${my_course.bundle.user.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`"
                                                    alt="Intructor_profile">
                                                <strong v-if="my_course.enroll.course_id == null">
                                                    {{my_course.bundle.user.fname}} {{my_course.bundle.user.lname}}
                                                </strong>
                                            </li>

                                            <!-- Rating and Price -->
                                            <li class="list-group-item" v-if="my_course.enroll.course_id != null">
                                                <div class="float-left" v-if="my_course.total_rating != 0">
                                                    <div class="star-ratings-sprite inline-block">
                                                        <span :style="{ 'width' : `${my_course.total_rating_percent}%` }"
                                                            class="star-ratings-sprite-rating">
                                                        </span>
                                                    </div>
                                                    ({{my_course.total_rating}})
                                                </div>

                                                <div v-else class="no-rating float-left">
                                                    <i>No Rating</i>
                                                </div>
                                                
                                                <!-- Simple Course Price -->
                                                <div class="price float-right" v-if="my_course.enroll.course_id != null">
                                                    <!-- If course is discounted -->
                                                    <div v-if="my_course.course.discount_price != null && my_course.course.discount_price != null">
                                                        <span><i :class="currency.icon"></i>{{my_course.course.discount_price}} </span>
                                                        <del><i :class="currency.icon"></i>{{my_course.course.price}}</del>
                                                    </div>
                                                    <!-- If course has no discount -->
                                                    <div v-if="my_course.course.discount_price == null && my_course.course.price != null">
                                                        <span><i :class="currency.icon"></i>{{my_course.course.price}}</span>
                                                    </div>
                                                    <!-- If course is free -->
                                                    <div v-if="my_course.course.discount_price == null && my_course.course.discount_price == null">
                                                        <span>FREE</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Bundle Course Price -->
                                                <div class="price float-right" v-if="my_course.enroll.course_id == null">
                                                    <!-- If course is discounted -->
                                                    <div v-if="my_course.bundle.discount_price != null && my_course.bundle.discount_price != null">
                                                        <span><i :class="currency.icon"></i>{{my_course.bundle.discount_price}} </span>
                                                        <del><i :class="currency.icon"></i>{{my_course.bundle.price}}</del>
                                                    </div>
                                                    <!-- If course has no discount -->
                                                    <div v-if="my_course.bundle.discount_price == null && my_course.bundle.price != null">
                                                        <span><i :class="currency.icon"></i>{{my_course.bundle.price}}</span>
                                                    </div>
                                                    <!-- If course is free -->
                                                    <div v-if="my_course.bundle.discount_price == null && my_course.bundle.discount_price == null">
                                                        <span>FREE</span>
                                                    </div>
                                                </div>

                                            </li>
                                        </ul>

                                        <!-- Start Now Button -->
                                        <div class="start-btn text-center">
                                            <router-link :to="my_course.enroll.course_id != null ? '/course_content/' + my_course.course.id + '/' + my_course.course.title.replace(/\s+/g, '_') : 'bundle_course_detail'+ '/' + my_course.enroll.bundle_id + '/' +my_course.enroll.bundle.title.replace(/\s+/g, '_')">
                                                Start Now
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- If user has no courses -->
                        <div class="bg-white p-y80" v-else>
                            <div class="text-center">
                                <h5>
                                    {{ translate('frontstaticword.Youhavenocourses')}}
                                </h5>
                                <router-link to="/" class="btn btn-danger">
                                    {{ translate('frontstaticword.ExploreCourses')}}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- If user is not login -->
                <div v-else>
                    <sign-in :guest="1"/>
                </div>
            </div>
        </section>

        <footerSection />
    </div>    
</template>

<script>
    "use Strict";

    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import profileSidebar from '../User/ProfileSidebar.vue';
    import signIn from '../Login.vue';

    export default {

        mixins: [mixin],

        name: 'user_profile_courses',

        components: {
            headerSection,
            footerSection,
            profileSidebar,
            signIn
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                courseLength: 0,
                my_courses: [],
                loading: true,
                progress: {},
                markChapterLength: 10,
                allChapterLength: 100,
                meta: {
                    name: 'User Courses',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.meta.name + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {
            
            // CAll API to get the user courses detail (this function will be called by defaxult when the component is called)
            async callAPI() {

                if (this.loginStatus == true) 
                {
                    await axios.post('/api/my/courses?secret=' + this.$secretKey, {
                        //data
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }

                    }).then(res => {

                        this.my_courses = res.data.enroll_details;
                        this.courseLength = res.data.enroll_details.length;
                        this.loading = false;

                    })
                    .catch(err => {

                        console.log(err.response);
                        this.loading = false;
                    });
                } 
                else 
                {
                    this.loading = false;
                }

            }
        },

        mounted() {
            this.callAPI();
            this.path = axios.defaults.baseURL;
        }
    }
</script>