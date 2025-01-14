<template>
    <div>

        <header-section />

        <!-- About Instructor section -->
        <section class="about-instructor">
            <div class="container">

                <!-- About Instructor -->
                <div class="row" v-if="!loading">
                    
                    <!-- Course Image -->
                    <div class="col-md-4">
                        <div class="card b-n">
                            <img 
                                :src="currentBundleCourse.preview_image!=null ? `${path}/images/bundle/${currentBundleCourse.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`" 
                                alt="instructor_profile">
                            <div class="pt-2 pl-2 price">
                                <span>
                                    {{currency.icon}}
                                    {{currentBundleCourse.discount_price}}
                                </span>
                                <del>
                                    {{currency.icon}}
                                    {{currentBundleCourse.price}}
                                </del>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <!-- Name -->
                        <h2>
                            {{currentBundleCourse.title}}
                        </h2>

                        <!-- Detail -->
                        <p v-html="currentBundleCourse.detail"> </p>

                        <ul class="mt-4">
                            <!-- Instructor -->
                            <li>
                                <i class="fa fa-user"></i>
                                {{currentBundleCourse.user}}
                            </li>

                            <!-- Last Updated -->
                            <li>
                                <i class="fa fa-hourglass"></i>
                                {{ moment(currentBundleCourse.updated_at ).format("dddd, MMMM Do YYYY") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Skeleton loading of about course section till we get data from API -->
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

        <!-- Course cards -->
        <section class="mt-70 mb-4" v-if="!loading">
            <div class="container">
                <div class="row course-tabs">
                    <div class="col-md-4" v-for="(bundleCourse,index) in bundleCourses" :key="index">
                        <div class="card bundle-course-dtl-card">

                            <router-link :to="'/course_detail/' + bundleCourse.id + '/' + bundleCourse.title.replace(/\s+/g, '_')">
                                <div class="bttn position-relative">
                                    <!-- Course Image -->
                                    <img 
                                        :src="bundleCourse.image ? `${path}/images/course/${bundleCourse.image}` : `${baseurl}/modules/blizzard/images/course_default.png`" 
                                        class="card-img-top" 
                                        :alt="bundleCourse.title">
                                </div>
                            </router-link>

                            <div class="p-x">

                                <!-- Course Detail -->
                                <router-link :to="'/course_detail/' + bundleCourse.id + '/' + bundleCourse.title.replace(/\s+/g, '_')">
                                    <div class="card-body py-3">
                                        <h5 class="card-title mt-2 truncate">
                                            {{bundleCourse.title.length>30 ? bundleCourse.title.substring(0,30)+'..' : bundleCourse.title}}
                                        </h5>
                                        <p class="card-text"  v-html="bundleCourse.short_detail.length>60 ? bundleCourse.short_detail.substring(0,60)+'..' : bundleCourse.short_detail"> </p>
                                    </div>
                                </router-link>

                                <!-- Course Price -->
                                <div class="price float-right mr-2">
                                    <!-- If course is discounted -->
                                    <div v-if="bundleCourse.discount_price != null && bundleCourse.discount_price != null">
                                        <span>
                                            {{currency.icon}}
                                            {{bundleCourse.discount_price}} 
                                        </span>
                                        <del>
                                            {{currency.icon}}
                                            {{bundleCourse.price}}
                                        </del>
                                    </div>

                                    <!-- If course has no discount -->
                                    <div v-if="bundleCourse.discount_price == null && bundleCourse.price != null">
                                        <span>
                                            {{currency.icon}}
                                            {{bundleCourse.price}}
                                        </span>
                                    </div>

                                    <!-- If course is free -->
                                    <div v-if="bundleCourse.discount_price == null && bundleCourse.discount_price == null">
                                        <span>FREE</span>
                                    </div>
                                </div>
                                
                                <!-- Button -->
                                <div class="start-btn text-center">
                                    <router-link :to="'/course_detail/'+ bundleCourse.id + '/' + bundleCourse.title.replace(/\s+/g, '_')">
                                        {{ translate('frontstaticword.GoToCourse')}}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skeleton loading for courses -->
        <section class="mt-70 mb-4" v-else>
            <user-courses-skeleton />
        </section>

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import userCoursesSkeleton from '../Skeletons/UserCourses.vue';
    
    export default{

        name: 'bundle_course_detail',

        mixins: [mixin],

        components: 
        {
            headerSection,
            footerSection,
            userCoursesSkeleton
        },
        
        data() 
        {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                loop: 0,
                loops: 5,
                bundleCourses: [],
                bundleCourseId: this.$route.params.id,
                currentBundleCourse: {},
                bundleCoursesLength: 0,
                bundleCourses: [],
                purchased: false,
                meta: 
                {
                  name: 'Bundle Courses',
                  profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // SEO detail, meta tag, meta titile
        metaInfo() 
        {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.mainUser.fname + 'Courses' + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: 
        {

            // Call the bundle course API (this function will be call by default on the call of this component)
            async callAPI()
            {
                await axios.get('/api/bundle/courses?secret=' + this.$secretKey)
                .then(res => 
                {    
                    this.bundleCourses = res.data.bundle;
                    this.bundleCourses.forEach(bundleCourse => 
                    {
                        if(this.bundleCourseId == bundleCourse.id)
                        {
                            this.currentBundleCourse = bundleCourse;
                            this.bundleCourses = bundleCourse.course;
                            this.bundleCoursesLength = bundleCourse.course.length;
                        }
                    })
                    this.loading = false;
                    
                })
                .catch(err=>
                {
                    console.log(err.response);
                    this.loading = false;
                });

            },

            // Function to add bundle course to cart
            async addToCart(id) 
            {
                await axios.post(`/api/addtocart/bundle?secret=${this.$secretKey}`, 
                {
                    bundle_id: id
                },
                {
                    headers: 
                    {
                        'Authorization': `Bearer ${this.token}` 
                    }
                })
                .then(res=> 
                {
                    if(res.status == 200)
                    {
                        let config = 
                        {
                            text: res.data,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.$router.push('/cart');
                    }

                })
                .catch(err=> 
                {
                    console.log(err.response);
                    if(err.response.status === 401)
                    {
                        let config = 
                        {
                            text: err.response.data,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                    }

                });
            }

        },

        mounted() 
        {
            this.callAPI();
            this.path = axios.defaults.baseURL;
        }
    }
</script>