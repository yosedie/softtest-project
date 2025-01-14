<template>
    <div>
        <!-- recent courses section start -->
        <section class="features-section bg-light" v-if="!loading">
            <div class="container" v-if="blogsLength > 0">
                <div class="title-txt text-center">
                    <h2 class="mb-60">
                        {{ translate('frontstaticword.PopularBlogs')}}
                    </h2>
                </div>

                <!-- Courses -->
                <div class="course-tabs blog-section">
                    <div class="popular_blog slider__class row">
                        <div class="col-md-12" v-for="(blog,index) in blogs" :key="index">
                            <div class="card">

                                <!-- Blog Image -->
                                <div class="bttn position-relative">
                                    <img :data-lazy="`${path}/images/blog/${blog.image}`" class="card-img-top" :alt="blog.heading">
                                </div>
                                <div class="blog-date">
                                    <ul>
                                        <li>
                                            <i class="feather icon-clock"></i> 
                                            {{ moment(blog.updated_at).format('Do-MMMM-YYYY')}}
                                        </li>
                                        <li v-if="blog.approved == '1'">
                                            <i class="feather icon-check-circle"></i> 
                                            {{ translate('frontstaticword.Approved')}}
                                        </li>
                                    </ul>
                                </div>

                                <div class="p-x mt-4">
                                    <!-- About Blog -->
                                    <div class="card-body py-3">
                                        <h4 class="card-title truncate">
                                            {{blog.heading.length>26 ? blog.heading.substring(0,26)+'..' : blog.heading}}
                                        </h4>
                                        <p class="card-text mt-2" v-html="blog.detail.length>75 ? blog.detail.substring(0,75)+'..' : blog.detail"> </p>
                                        
                                        <div class="blog-btn">
                                            <router-link :to="'/blog_detail/'+ blog.id + '/' + blog.heading" class="btn btn-default">
                                                {{ translate('frontstaticword.READMORE')}} 
                                                <i class="feather icon-arrow-right"></i>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-100" v-if="blogsLength > 0"></div>
        </section> 
        <!-- recent courses end -->

        <!-- Skeleton loading for blog -->
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

        name: 'popularBlog',

        mixins: [mixin],

        components: 
        {
            userCoursesSkeleton
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                blogs: [],
                blogsLength: 0
            }
        },

        methods: {

            // Function to run the slickslider for featured courses
            slickslider() 
            {
                this.$nextTick(()=> 
                {
                    $('.popular_blog').slick({
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

            // Call recent blog API (function will be called by defualt on the call of this component)
            async callAPI(){

                await axios.get('/api/recent/blog?secret=' + this.$secretKey)
                .then(res => {

                    this.blogs = res.data.blog;
                    this.blogsLength = res.data.blog.length;
                    this.$nextTick(() =>{ this.slickslider(); });
                    this.loading = false;

                })
                .catch(err=> {

                    this.loading = false;
                    console.log(err.response);
                });

            }
        },
        
        mounted(){

            this.path = axios.defaults.baseURL;
            this.callAPI();

        }
    }
</script>