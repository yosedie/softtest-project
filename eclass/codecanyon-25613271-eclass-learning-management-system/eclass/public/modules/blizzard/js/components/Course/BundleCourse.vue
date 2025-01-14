<template>
    <div>
        <!-- features section start -->
        <section class="features-section bg-light" v-if="!loading">
            <div class="container" v-if="bundleCoursesLength > 0">
                <div class="title-txt text-center">
                    <h2 class="mb-60">Bundle Courses</h2>
                </div>

                <!-- Courses -->
                <div class="course-tabs">
                    <div class="agn-bundle bundle-course slider__class row">
                        <div class="col-md-12" v-for="(course,index) in bundleCourses" :key="index">
                            <div class="card">
                                <!-- Course image -->
                                <div class="bttn position-relative">
                                    <img :data-lazy="`${course.imagepath}`" class="card-img-top" :alt="course.title">
                                </div>
                                <div class="p-x">
                                    <!-- Course title -->
                                    <div class="card-body py-3">
                                        <router-link :to="'/bundle_course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                            <h5 class="card-title truncate mt-2">
                                                {{course.title}} ({{course.course_id.length}}) {{ translate('frontstaticword.Courses')}}
                                            </h5>
                                        </router-link>
                                            <p v-html="course.detail.length>60 ? course.detail.substring(0,60)+'..' : course.detail">
                                            </p>
                                    </div>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item pb-3">
                                            
                                            <!-- about instructor -->
                                            <div class="float-left">
                                                <img
                                                    class="mr-1"
                                                    :src="course.user_img ? `${path}/images/user_img/${course.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`"
                                                    alt="Intructor_profile"
                                                    style="display:initial">
                                                <strong>
                                                    {{course.user}}
                                                </strong>
                                            </div>
                                        
                                            <!-- Course Price -->
                                            <div class="price float-right">
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
                                        </li>
                                    </ul>
                                    <hr>
                                    
                                    <div class="featured-bundle-card card-body py-3">
                                        <!-- Featured -->
                                        <a class="card-link" v-if="course.featured == '1'">
                                            <img
                                                style="margin: -5px 5px 0;"
                                                class="d-inline-block"  
                                                :src="`${baseurl}/modules/blizzard/images/star.png`" alt="star_image">
                                            <strong>{{ translate('frontstaticword.Featured')}}</strong>
                                        </a>

                                        <!-- If course is not featured -->
                                        <a class="card-link" v-else>
                                            <strong>{{ translate('frontstaticword.BundleCourses')}}</strong>
                                        </a>

                                        <!-- Total Courses in Bundle Course -->
                                        <a class="card-link float-right" v-if="course.course_id.length">
                                            <img 
                                                style="margin: -5px 5px 0;"
                                                class="d-inline-block" 
                                                :src="`${baseurl}/modules/blizzard/images/lecture-icon.png`">
                                            <strong>
                                                {{course.course_id.length}} {{ translate('frontstaticword.Courses')}}
                                            </strong>
                                        </a>
                                    </div>

                                    <!-- Buttons -->
                                    <a class="start-btn">
                                        <div class="row">
                                            <!-- Add to cart -->
                                            <div class="col-md-6 col-6">
                                                <a @click="addToCart(course.id)">
                                                    <i class="fa fa-shopping-cart mr-2"></i>
                                                    {{ translate('frontstaticword.AddToCart')}}
                                                </a>
                                            </div>
                                            <!--Go to Course  -->
                                            <div class="col-md-6 col-6">
                                                <div class="wishlist-icon">
                                                    <router-link :to="'/bundle_course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                                        {{ translate('frontstaticword.GoToCourse')}}
                                                    </router-link>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-100" v-if="bundleCoursesLength > 0"></div>
        </section> 
        <!-- features section start -->

        <!-- Skeleton loading for courses -->
        <div v-else>
            <user-courses-skeleton />
        </div>
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import userCoursesSkeleton from '../Skeletons/UserCourses.vue';

    export default {

        name: 'bundleCourse',

        mixins: [mixin],

        components: {
            userCoursesSkeleton
        },

        data() 
        {
            return {

                baseurl: baseurl,
                bundleCourses: [],
                bundleCoursesLength: 0,
                path: null,
                loading: true
            }
        },

        methods: {

            // Function to run the slickslider for featured courses
            slickslider() {
                this.$nextTick(()=> { 
                    $('.agn-bundle').slick({
                    lazyLoad: 'ondemand',
                    speed: 2500,
                    arrows: true,
                    slidesToShow: 3,
                    autoplay: false,
                    fade: false,
                    autoplaySpeed: 3000,
                    slidesToScroll: 1,
                    responsive: [{
                        breakpoint: 992,
                        settings: {
                        slidesToShow: 1,
                        arrows: true,
                        fade: false,
                        autoplay: true,
                        slidesToScroll: 1,

                        }
                    },

                    {
                        breakpoint: 767,
                        settings: {
                        slidesToShow: 1,
                        arrows: false,
                        fade: false,
                        autoplay: true,
                        slidesToScroll: 1,
                        dots: false,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                        slidesToShow: 2,
                        arrows: true,
                        fade: false,
                        autoplay: true,
                        slidesToScroll: 1,
                        dots: false,
                        }
                    },
                    ]
                });
                });
            },

            // Call the bundle course API (this function will be call by default on the call of this component)
            async callAPI(){

                await axios.get('/api/bundle/courses?secret=' + this.$secretKey)
                .then(res => {
                    
                    this.loading = false;
                    this.$nextTick(()=> { this.slickslider(); });
                    this.bundleCourses = res.data.bundle;
                    this.bundleCoursesLength = res.data.bundle.length;
                    
                })
                .catch(err=> 
                {
                    console.log(err.response);
                    this.loading = false;
                });

            },

            async addToCart(id) {

                await axios.post(`/api/addtocart/bundle?secret=${this.$secretKey}`, {

                    bundle_id: id

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
                    }

                })
                .catch(err=> {
                
                        if(err.response.status === 401)
                        {
                            let config = {
                                text: err.response.data,
                                button: 'CLOSE'
                            }

                            this.$snack['success'](config);
                        }

                    }   
                );
            }

        },
        
        mounted() {
            this.callAPI();
            this.path = axios.defaults.baseURL;
        }

    }
    
</script>