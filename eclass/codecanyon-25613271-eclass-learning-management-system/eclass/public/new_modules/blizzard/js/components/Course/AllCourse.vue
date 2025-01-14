<template>
    <div>
        <!-- largest courses section start -->
        <section class="tabs-section">
            <div class="container">
                <div class="title-txt text-center">
                    <h2>
                        {{translate('frontstaticword.AllCourseHead')}}
                    </h2>
                </div>
                <div class="course-tabs">
                    <!-- Categories -->
                    <ul class="nav nav-pills justify-content-center mb-5" id="pills-tab" role="tablist">
                        <li class="nav-item" v-for="(category,index) in category_slider" :key="index">
                            <a class="nav-link" :id="`pills-${category.title.en}-tab`" data-toggle="pill" :href="`#pills-${category.title.en}`"
                                role="tab" :aria-controls="`pills-${category.title.en}`" aria-selected="false" :class="{ 'active': index === 0 }"
                                @click="getCourse(category.id)">
                                {{category.title.en}}
                            </a>
                        </li>
                    </ul>
                    <!-- Courses -->
                    <div class="tab-content tab-pane fade show">
                        <div class="row" v-if="courses!=null">
                            <div class="col-md-4 col-12" v-for="(course,index) in courses" :key="index">
                                <div class="card">
                                    <div class="bttn position-relative">
                                        <img :src="course.imagepath" class="card-img-top" :alt="course.title.en">
                                        <router-link 
                                            v-if="course.level_tags!=null" 
                                            :to="'/course_detail/' + course.id + '/' + course.title.en.replace(/\s+/g, '_')">
                                            {{course.level_tags}}
                                        </router-link>
                                    </div>

                                    <div class="p-x">

                                        <div class="card-body py-3">
                                            <h5 class="card-title mt-2">
                                                {{course.title.en.length>25 ? course.title.en.substring(0,25)+'...' : course.title.en}}
                                            </h5>
                                            <p class="card-text">
                                                {{course.short_detail.en.length>70 ? course.short_detail.en.substring(0,70)+'...' : course.short_detail.en}}
                                            </p>
                                        </div>
                                        
                                        <ul class="list-group list-group-flush">

                                            <!-- Instructor -->
                                            <li class="list-group-item pb-3">
                                                <img 
                                                    class="mr-2"
                                                    :src="course.instructor.image">
                                                <strong>
                                                    {{ translate('frontstaticword.By')}}  
                                                    {{ course.instructor.name }}
                                                </strong>
                                            </li>

                                            <li class="list-group-item">

                                                <!-- Rating -->
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

                                                <!-- Price -->
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
                                                <div class="col-md-8 col-6">
                                                    <a @click="addToCart(course.id)">
                                                        <i class="fa fa-shopping-cart mr-2"></i>
                                                        {{ translate('frontstaticword.AddToCart')}}
                                                    </a>
                                                </div>
                                                
                                                <!-- Wishlist -->
                                                <div class="col-md-4 col-6">
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

                        <!-- If category have no course -->
                        <div class="row mb-4 bg-light p-y80 b-50" v-else>
                            <h5 class="my-0 mx-auto">
                                {{translate('frontstaticword.Categoryhavenocourses')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- largest courses section end -->
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    
    export default {

        name: 'allCourses',

        mixins: [mixin],

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                category_slider: [],
                courses: [],
            }
        },

        methods: {

            //fetch courses on click
            getCourse(id)
            {
                let apiData = 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }  
                }

                axios.get(`/api/fetch/category/${id}/courses`, apiData)
                .then(res=> 
                {
                    this.courses = res.data.course;
                    this.loading = false;
                })
                .catch(err=> 
                {
                    console.log(err.response);
                    this.loading = false;
                })
            },
            
            // Call home api to get  slider data
            async callAPI()
            {
                let apiData = 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}` 
                    }  
                }

                await axios.get('/api/home?secret=' + this.$secretKey, apiData)
                .then(res => {

                    this.category_slider = res.data.category_slider;
                    this.courses = this.category_slider[0].course;
                    this.loading = false;

                })
                .catch(err=> {
                    
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
                    let course =  this.courses[index];
                    
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

            // Add course to wishlist
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

        mounted() {

            this.callAPI();
            this.path = axios.defaults.baseURL;
        }
    }
</script>