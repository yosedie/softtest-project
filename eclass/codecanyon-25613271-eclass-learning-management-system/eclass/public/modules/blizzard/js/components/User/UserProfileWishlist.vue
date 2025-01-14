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

                    <!-- Wishlist -->
                    <div class="col-lg-8 col-md-7" v-if="!loading">
                        <!-- User Wishlist -->
                        <div class="row wishlist-block course-tabs" v-if="wishlistLength > 0">
                            <div class="col-lg-6 col-md-6 col-12 mb-20" v-for="(course,index) in wishlist" :key="index">
                                <div class="card mb-30">
                                    <div class="bttn position-relative">

                                        <!-- Course Image -->
                                        <img 
                                            :src="course.courses.preview_image ? `${path}/images/course/${course.courses.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`"
                                            alt="course image">

                                        <!-- Level tag -->
                                        <router-link
                                            v-if="course.courses.level_tags!=null"
                                            :to="'course_detail'+ '/' + course.courses.id + '/' + course.courses.title.replace(/\s+/g, '_')"
                                            tabindex="0">
                                            {{course.courses.level_tags}}
                                        </router-link>
                                    </div>

                                    <div class="p-x">
                                        <div class="card-body py-3">

                                            <!-- Course Title -->
                                            <router-link
                                                :to="'course_detail'+ '/' + course.courses.id + '/' + course.courses.title.replace(/\s+/g, '_')">
                                                <h5 class="card-title mt-2"> 
                                                    {{course.courses.title.length>30 ? course.courses.title.substring(0,30)+'..' : course.courses.title}} 
                                                </h5>
                                            </router-link>

                                            <!-- Short Description -->
                                            <p class="card-text"
                                                v-html="course.courses.short_detail.length>70 ? course.courses.short_detail.substring(0,70)+'..' : course.courses.short_detail">
                                            </p>
                                        </div>

                                        <ul class="list-group list-group-flush">
                                            <!-- Instructor Details -->
                                            <li class="list-group-item pb-3">
                                                <div class="float-left">
                                                    <!-- Simple course -->
                                                    <img
                                                        class="mr-1"
                                                        :src="course.courses.user.user_img ? `${path}/images/user_img/${course.courses.user.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`"
                                                        alt="Intructor_profile">
                                                    <strong>
                                                        {{course.courses.user.fname}} {{course.courses.user.lname}}
                                                    </strong>
                                                </div>

                                                <!-- Course Price -->
                                                <div class="price float-right" >
                                                    <!-- If course is discounted -->
                                                    <div v-if="course.courses.discount_price != null && course.courses.discount_price != null">
                                                        <span><i :class="currency.icon"></i>{{course.courses.discount_price}} </span>
                                                        <del><i :class="currency.icon"></i>{{course.courses.price}}</del>
                                                    </div>
                                                    <!-- If course has no discount -->
                                                    <div v-if="course.courses.discount_price == null && course.courses.price != null">
                                                        <span><i :class="currency.icon"></i>{{course.courses.price}}</span>
                                                    </div>
                                                    <!-- If course is free -->
                                                    <div v-if="course.courses.discount_price == null && course.courses.discount_price == null">
                                                        <span>
                                                            {{ translate('frontstaticword.FREE')}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>

                                        <!-- Start Now Button -->
                                        <div class="start-btn">
                                            <div class="row">
                                                <!-- Add to cart -->
                                                <div class="col-lg-6 col-md-6 col-6">
                                                    <a @click="addToCart(course.courses.id)">
                                                        {{ translate('frontstaticword.AddToCart')}}
                                                    </a>
                                                </div>
                                                <!-- Remove form wishlist -->
                                                <div class="col-lg-6 col-md-6 col-6 text-right remove_button">
                                                    <a @click="removeFromWishlist(course.courses.id)">
                                                        <i class="fa fa-times p-rl-10"></i>
                                                    </a>
                                                </div>
                                            </div>
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

        name: 'user_profile_wishlist',

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
                wishlist: [],
                wishlistLength: 0,
                loading: true,
                meta: {
                    name: 'User Wishlist',
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

            // Fetch user wishlist courses
            async getWishlist() {

                if(this.loginStatus == true)
                {
                    await axios.post('/api/show/wishlist?secret=' + this.$secretKey, {
                        //data
                    }, 
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }).then(res => {

                        this.wishlist = res.data.wishlist;
                        this.wishlistLength = res.data.wishlist.length;
                        this.loading = false;
                    });
                }
                else
                { 
                    this.loading = false; 
                }
            },

            // Function to remove the course from wishlist
            async removeFromWishlist(id)
            {
                const headers = {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.token}` 
                }

                await axios.post('/api/remove/wishlist?secret=' + this.$secretKey,
                {
                    course_id: id
                },
                {
                    headers : headers

                }).then(res=> {

                    if(res.status == 200)
                    {
                        
                        let config = {
                            text: 'Course is removed from your wishlist !',
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.loading = true;
                        this.getWishlist();
                    }

                }).catch(err => {

                    if(err.response.status === 401)
                    {
                        let config = {
                            text: 'Course does not exist in your wishlist !',
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }

                });

            },

            // Add course to wishlist
            async addToCart(id){

                await axios.post('/api/addtocart?secret=' + this.$secretKey,{        
                    course_id: id
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
                        this.getWishlist();
                    }

                }).catch(err => {

                    if(err.response.status === 401)
                    {
                        console.log(err.response.data);
                        let config = {
                            text: err.response.data,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config); 
                    }

                    if (err.res) {
                        this.errors = err.res.data.errors;
                    }

                });
            }
        },

        mounted() {

            this.getWishlist();
            this.path = axios.defaults.baseURL;
        }
    }
</script>