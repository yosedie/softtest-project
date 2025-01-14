<template>
    <div>
        <!-- recent courses section start -->
        <section class="view-section bg-light" v-if="!loading">
            <div class="container" v-if="recentCoursesLength > 0">
                <div class="title-txt text-center">
                    <h2 class="mb-60">
                        {{ translate('frontstaticword.RecentCourses')}}
                    </h2>
                </div>

                <!-- Courses -->
                <div class="course-tabs">
                    <div class="recent_courses slider__class row">
                        <div class="col-md-12" v-for="(course,index) in recentCourses" :key="index">
                            <div class="card">

                                <!-- Course Image -->
                                <router-link :to="'/course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                    <div class="bttn position-relative">
                                        <img :data-lazy="`${path}/images/course/${course.preview_image}`" class="card-img-top" :alt="course.title">
                                        <a v-if="course.level_tags">
                                            {{course.level_tags}}
                                        </a>
                                    </div>
                                </router-link>

                                <div class="p-x">

                                    <!-- About Course -->
                                    <div class="card-body py-3">
                                        <router-link :to="'/course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                            <h5 class="card-title truncate mt-2">
                                                {{course.title.length>25 ? course.title.substring(0,25)+'..' : course.title}}
                                            </h5>
                                        </router-link>
                                        <p class="card-text" v-html="course.short_detail.length>70 ? course.short_detail.substring(0,70)+'..' : course.short_detail"> </p>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item pb-3 d-flex align-items-center">
                                            <!-- Instructor -->
                                            <img class="mr-3"
                                                :src="`${path}/images/user_img/${course.user.user_img}`">
                                            <strong>
                                                {{ translate('frontstaticword.By')}}  
                                                {{course.user.fname}} 
                                                {{course.user.lname}}
                                            </strong>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="float-left ratings" v-if="course.total_rating != 0">
                                                <div class="star-ratings-sprite inline-block">
                                                    <span :style="{ 'width' : `${course.total_rating_percent}%` }"
                                                        class="star-ratings-sprite-rating">
                                                    </span>
                                                </div>
                                                ({{course.total_rating}})
                                            </div>

                                            <div v-else class="no-rating float-left ratings">
                                                <i>{{ translate('frontstaticword.NoRating')}}</i>
                                            </div>

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
                                    <!-- Buttons -->
                                    <div class="start-btn">
                                        <div class="row">
                                            
                                            <!-- Add to cart -->
                                            <div class="col-md-8 col-8">
                                                <a @click="addToCart(course.id)">
                                                    <i class="fa fa-shopping-cart mr-2"></i>
                                                    {{ translate('frontstaticword.AddToCart')}}
                                                </a>
                                            </div>
                                            
                                            <!-- Wishlist -->
                                            <div class="col-md-4 col-4">
                                                <div class="wishlist-icon">
                                                    <a @click="checkWishlist(index)">
                                                        <i class="p-rl-10" :class="course.in_wishlist == 0 ? 'fa fa-heart-o' : 'fa fa-heart'" aria-hidden="true"></i>
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
            <div class="pb-100" v-if="recentCoursesLength > 0"></div>
        </section> 
        <!-- recent courses end -->

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

        name: 'recentCourse',

        mixins: [mixin],

        components: 
        {
            userCoursesSkeleton
        },

        data() 
        {
            return {
                baseurl: baseurl,
                recentCourses: [],
                recentCoursesLength: 0,
                path: null,
                loading: true
            }
        },

        methods: {

            // Function to run the slickslider for featured courses
            slickslider() 
            {
                this.$nextTick(()=> 
                {
                    $('.recent_courses').slick({
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

                let apiData = 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }  
                }

                await axios.get('/api/recent/course?secret=' + this.$secretKey, apiData)
                .then(res => 
                {    
                    this.loading = false;  
                    this.recentCourses = res.data.course;
                    this.recentCoursesLength = res.data.course.length;
                    this.slickslider(); 
                })
                .catch(err=> 
                {
                    console.log(err.response);
                    this.loading = false;
                });

            },

            // Recall courses after adding-removing to wishlist
            async recall_courses() 
            {
                let apiData = 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }  
                }

                await axios.get('/api/recent/course?secret=' + this.$secretKey, apiData)
                .then(res => 
                {    
                    this.recentCourses = res.data.course;
                    this.loading = false;   
                })
                .catch(err=> 
                {
                    console.log(err.response);
                    this.loading = false;
                });
            },

            // Call aPI to add course to cart
            async addToCart(id)
            {
                if(this.loginStatus)
                {
                    await axios.post('/api/addtocart?secret=' + this.$secretKey,
                    { 
                        course_id: id
                    },
                    {
                        headers: 
                        {
                            'Authorization': `Bearer ${this.token}` 
                        }
                    })
                    .then(response=> 
                    {
                        if(response.status == 200)
                        {
                            let config = {
                                text: response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                        }
                    })
                    .catch(err => 
                    {
                        if(err.response.status === 401)
                        {
                            let config = {
                                text: err.response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config); 
                        }

                        if (err.response) 
                        {
                            this.errors = err.response.data.errors;
                        }
                    });
                }
                else
                {
                    let config = 
                    {
                        text: 'Please Login First !',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }
                
            },

            // Check the specific course wishlist status and perform the action accordingly
            checkWishlist(index) 
            {
                if(this.loginStatus)
                {
                    let course =  this.recentCourses[index];
                    
                    if(course.in_wishlist == 0)
                    {
                        this.addToWishlist(course.id);
                    }
                    else
                    {
                        this.removeFromWishlist(course.id);
                    }
                }

                else
                {
                    let config = {
                        text: 'Please login first !',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }

            },

            // Add course to wihslist
            async addToWishlist (id)
            {
                
                await axios.post('/api/addtowishlist?secret=' + this.$secretKey,
                {
                    course_id: id
                },
                {
                    headers : 
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
                        this.recall_courses();
                    }
                })
                .catch(err => 
                {
                    console.log(err.response);
                    if(err.response.status === 401)
                    {
                        let config = 
                        {
                            text: err.response.data,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                    if (err.response) 
                    {
                        this.errors = err.response.data.errors;
                    }
                });
            
            },

            // Remove course from wishlist
            async removeFromWishlist(id)
            {
                const headers = 
                {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.token}` 
                }

                await axios.post('/api/remove/wishlist?secret=' + this.$secretKey,
                {
                    course_id: id
                },
                {
                    headers : headers

                })
                .then(res=> 
                {
                    if(res.status == 200)
                    {       
                        let config = 
                        {
                            text: 'Course is removed from your wishlist !',
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.recall_courses();
                    }

                })
                .catch(err => 
                {
                    if(err.response.status === 401)
                    {
                        let config = {
                            text: 'Course does not exist in your wishlist !',
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                    if (err.response) 
                    {
                        this.errors = err.response.data.errors;
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