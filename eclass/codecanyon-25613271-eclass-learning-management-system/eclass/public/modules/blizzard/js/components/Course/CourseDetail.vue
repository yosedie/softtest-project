<template>
    <div>
        <header-section />

        <!-- Leadership: Practical Leadership start -->
        <section class="full-width-streamer">
            <div class="container">
                <div class="row text-md-right">
                    <div class="col-12">
                        <div class="gift-this-course">

                            <!-- Gift Course -->
                            <span class="mr-3"  >
                                <a v-b-modal.modal-prevent-closing-2>
                                    <i class="fa fa-gift" aria-hidden="true"></i> 
                                    {{ translate('frontstaticword.Giftacourse')}}
                                </a>
                            </span>

                            <!-- Gift Modal -->
                            <b-modal
                            id="modal-prevent-closing-2"
                            ref="modal"
                            :title="translate('frontstaticword.Giftacourse')"
                            @show="resetGiftModal"
                            @hidden="resetGiftModal"
                            @ok="handleGift" :ok-title="translate('frontstaticword.Submit')"
                            >
                                <form ref="form" @submit.prevent="handleSubmit">

                                    <!-- First name -->
                                    <b-form-group
                                    :label="translate('frontstaticword.FirstName')+':'"
                                    label-for="fname-input"
                                    :invalid-feedback="translate('frontstaticword.EnterFirstName')"
                                    :state="emailState"
                                    >
                                        <b-form-input
                                            id="fname-input"
                                            type="text"
                                            v-model="fname"
                                            :state="fnameState"
                                            required
                                        ></b-form-input>
                                    </b-form-group>

                                    <!-- Last Name -->
                                    <b-form-group
                                    :label="translate('frontstaticword.LastName')+':'"
                                    label-for="lname-input"
                                    :invalid-feedback="translate('frontstaticword.EnterLastName')"
                                    :state="emailState"
                                    >
                                        <b-form-input
                                            id="lname-input"
                                            type="text"
                                            v-model="lname"
                                            :state="lnameState"
                                            required
                                        ></b-form-input>
                                    </b-form-group>

                                    <!-- Email -->
                                    <b-form-group
                                    id="input-group-1"
                                    :label="translate('frontstaticword.EmailAddress')+':'"
                                    label-for="email-input"
                                    :invalid-feedback="translate('frontstaticword.Pleaseenteremailaddress')"
                                    :state="emailState"
                                    :description="translate('frontstaticword.giftcoursemaildes')+'.'"
                                    >
                                        <b-form-input
                                            id="email-input"
                                            type="email"
                                            v-model="email"
                                            :state="emailState"
                                            required
                                        ></b-form-input>
                                    </b-form-group>

                                </form>
                            </b-modal>
                            <!-- Gift Modal Ended -->

                            <!-- Wishlist -->
                            <span class="mr-3" v-if="!purchased">
                                <a @click="actionOnWishlist">
                                    <i :class="wishlistClass"
                                        aria-hidden="true"></i>
                                    {{ translate('frontstaticword.Wishlist')}}
                                </a>
                            </span>

                            <!-- If course is purchased -->
                             <span v-if="purchased">
                                <div class="start-btn d-inline-block">
                                    <router-link 
                                        class="flat-button bg-orange" 
                                        :to="'/course_content/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                        {{ translate('frontstaticword.GoToCourse')}}
                                    </router-link>
                                </div>
                            </span>

                            <!-- Buy Now -->
                            <span v-if="!purchased">
                                <div class="start-btn d-inline-block" v-if="course.price">
                                    <a class="flat-button bg-orange" @click="addToCart(course.id)">
                                        <i class="feather shopping-cart"></i> 
                                        {{ translate('frontstaticword.BuyNow')}}
                                    </a>
                                </div>

                                <!-- Enroll Now -->
                                <div class="start-btn d-inline-block" v-else>
                                    <a class="flat-button bg-orange" @click="enroll(course.id)">
                                        {{ translate('frontstaticword.EnrollNow')}}
                                    </a>
                                </div>
                            </span>

                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Preview Video/Image -->
                    <div class="col-12 col-md-4">
                        <div class="course-img">

                            <!-- Video uploaded -->
                            <video-player 
                                v-if="course.preview_type == 'video'" 
                                width="300px" 
                                height="200px"
                                :src="`${path}/video/preview/${course.video}`" />

                            <!-- URL -->
                            <video
                                v-if="course.preview_type == 'url' && course.url != null"
                                id="#course"
                                class="video-js vjs-default-skin"
                                controls
                                width="300" height="200"
                                data-setup='{"techOrder": ["youtube"]}'								  
                            >
                            <source :src="course.url" type="video/youtube" />
                            </video>

                            <!-- Preview Image -->
                            <img
                                v-if="course.video == null && course.url == null && course.preview_image != null"
                                :src="`${path}/images/course/${course.preview_image}`"
                                width="300px" 
                                height="200px" 
                                :alt="translate('frontstaticword.courseimage')">

                            <!-- If course has no preview item -->
                            <img 
                                v-if="course.url == null && course.preview_image == null && course.video == null" 
                                :src="`${baseurl}/modules/blizzard/images/course_default.png`" 
                                :alt="translate('frontstaticword.defaultimage')">

                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="col-12 col-md-8">

                        <!-- Title -->
                        <h1 class="clip-lead-title">
                            {{ course.title }}
                        </h1>

                        <!-- Short detail -->
                        <div class="lead-heading">
                            <p v-html="course.short_detail">

                            </p>
                        </div>

                        <div class="clip-element mb-20">
                            <!-- Level tag -->
                            <span class="badge badge-accented data-purpose badge" v-if="course.level_tags">
                                <b>{{course.level_tags}}</b>
                            </span>

                            <!-- Basic information -->
                            <ul>
                                <!-- Rating and Review -->
                                <li>
                                    <span class="reviews mr-3">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <b>{{totalRating}}</b>
                                        <p>({{review}} {{ translate('frontstaticword.Reviews')}})</p>
                                    </span>
                                </li>
                                
                                <!-- Enrolled Students -->
                                <li>
                                    <span class="reviews mr-3">
                                        <b>{{student_enrolled}}</b>
                                        <p>{{ translate('frontstaticword.studentsenrolled')}}</p>
                                    </span>
                                </li>
                                
                                <!-- Instructor -->
                                <li>
                                    <span class="reviews mr-3">
                                        <b>{{ translate('frontstaticword.Created')}}</b>
                                        <p>{{instructor.fname}} {{instructor.lname}}</p>
                                    </span>
                                </li>

                                <!-- Updated at -->
                                <li>
                                    <span class="reviews mr-3">
                                        <b>{{ translate('frontstaticword.LastUpdated')}}</b>
                                        <p>{{ moment(course.updated_at).format('Do YYYY') }}</p>
                                    </span>
                                </li>

                                <!-- Language -->
                                <li>
                                    <span class="reviews mr-3">
                                        <b>{{languageDetail.name}}</b>
                                        <p>{{languageDetail.name}} [{{ translate('frontstaticword.Autogenerated')}}]</p>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Leadership: Practical Leadership end -->

        <section class="course-features">
            <div class="container">
                <div class="row">
                    
                    <!-- Share Course -->
                    <div class="col-12 col-md-12 mt-4">
                        <h3 class="mb-2">
                            {{ translate('frontstaticword.Sharethiscourse')}}
                        </h3>

                        <div class="social-icon">
                            <div class="row">
                                <ShareNetwork
                                    v-for="network in networks"
                                    :network="network.network"
                                    :key="network.network"
                                    :style="{backgroundColor: network.color}"
                                    :url="sharing.url"
                                    :title="sharing.title"
                                    :description="sharing.description"
                                    :quote="sharing.quote"
                                    :hashtags="sharing.hashtags"
                                    :twitterUser="sharing.twitterUser"
                                >
                                <i :class="network.icon"></i>
                                <span>{{ network.name }}</span>
                                </ShareNetwork>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 mt-50">
                        
                        <!-- Course Title -->
                        <div class="features-title">
                            <h2>{{ course.title }}</h2>
                        </div>

                        <!-- Instructor/Category -->
                        <div class="course-meta">
                            <ul>
                                <li class="author">
                                    <!-- Instructor profile -->
                                    <div class="thumb">
                                        <img class="mr-3" :src="`${path}/images/user_img/${instructor.user_img}`" :alt="translate('frontstaticword.image')">
                                    </div>

                                    <!-- Name -->
                                    <div class="text mr-5">
                                        <router-link :to="'/instructor_detail/'+ instructor.id + '/' + instructor.fname">
                                            {{instructor.fname}} {{instructor.lname}}
                                        </router-link>
                                        <p>{{ translate('frontstaticword.Instructor')}}</p>
                                    </div>
                                </li>

                                <!-- Category -->
                                <li class="categories">
                                    <a href="#" class="course-name">{{categoryDetail.title}}</a>
                                    <p>{{ translate('frontstaticword.Category')}}</p>
                                </li>
                            </ul>
                        </div>

                        <!-- Course Image -->
                        <div class="course-img">
                            <img :src="course.preview_image != null ? `${path}/images/course/${course.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`" alt="Course_image" title="course_image">
                        </div>

                        <div class="row">

                            <!-- Course Include and Cart and price -->
                            <div class="course-details-list mt-50 col-12 col-md-4">
                                <h3 class="course-title" v-if="includes.length > 0">
                                    {{ translate('frontstaticword.COURSEFEATURES')}}
                                </h3>
                                <ul>
                                    <li v-for="(include,index) in includes" :key="index">
                                        <i class="fa fa-clock-o mr-2" aria-hidden="true"></i>
                                        <span>
                                            {{include.detail}}
                                        </span>
                                    </li>
                                </ul>

                                <div v-if="!purchased">

                                    <!-- If Course has discounted price -->
                                    <h5 class="price bt-course" v-if="course.discount_price != null">
                                        {{ translate('frontstaticword.CoursePrice')}}: 
                                        <span>
                                            {{currency.icon}}
                                            {{course.discount_price}}
                                        </span>
                                        <del>
                                            {{currency.icon}}
                                            {{course.price}}
                                        </del>
                                    </h5>

                                    <!-- Simple price -->
                                    <h5 class="price bt-course" v-if="course.discount_price == null && course.price!=null">
                                        {{ translate('frontstaticword.CoursePrice')}}: 
                                        <span>
                                            {{currency.icon}}
                                            {{course.price}}
                                        </span>
                                    </h5>

                                    <!-- If course is free -->
                                    <h5 class="price bt-course" v-if="course.discount_price==null && course.price==null">
                                        {{ translate('frontstaticword.CoursePrice')}}: 
                                        <span>
                                            {{ translate('frontstaticword.FREE')}}
                                        </span>
                                    </h5>

                                    <!-- Add To Cart -->
                                    <div class="start-btn" v-if="course.price!=null">
                                        <a class="flat-button bg-orange" @click="addToCart(course.id)">
                                            {{ translate('frontstaticword.ADDTOCARTCAPITAL')}}
                                        </a>
                                    </div>

                                    <!-- Enroll -->
                                    <div class="start-btn" v-if="course.discount_price==null && course.price==null">
                                        <a class="flat-button bg-orange" @click="enroll(course.id)">
                                            {{ translate('frontstaticword.EnrollNow')}}
                                        </a>
                                    </div>
                                </div>

                                <div v-if="purchased">
                                    <!-- GO TO COURSE -->
                                    <div class="start-btn">
                                        <router-link class="flat-button bg-orange" :to="'/course_content/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                            {{ translate('frontstaticword.GoToCourse')}}
                                        </router-link>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Detail -->
                            <div class="entry-content mt-50 col-12 col-md-8">
                                <h3 class="title-1 bold">
                                    {{translate('frontstaticword.ABOUTTHECOURSE')}}
                                </h3>
                                <p v-html="course.detail"></p>
                            </div>
                        </div>

                        <!-- About Instructor start -->
                        <div class="col-12 col-md-12 mt-70 mb-4">
                            <h3>
                                {{ translate('frontstaticword.AboutInstructor')}}
                            </h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <router-link :to="'/instructor_detail/'+ instructor.id + '/' + instructor.fname">
                                        <img 
                                            :src="instructor.user_img ? `${path}/images/user_img/${instructor.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`" 
                                            :alt="translate('frontstaticword.Instructor')" 
                                            class="b-50 mt-2 mb-2" 
                                            width="50px">
                                    </router-link>
                                    <router-link :to="'/instructor_detail/'+ instructor.id + '/' + instructor.fname">
                                        <p class="mt-2" v-if="instructor.fname">
                                            {{instructor.fname}} {{instructor.lname}}
                                        </p>
                                    </router-link>
                                    <p>
                                        {{ translate('frontstaticword.Email')}}: 
                                        <a :href="`mailto: ${instructor.email}`">{{instructor.email}}</a>
                                    </p>
                                    <p>
                                        <strong> {{ translate('frontstaticword.Publishedat')}}: </strong> 
                                        {{ moment(instructor.created_at).format("MMMM Do YYYY ") }}
                                    </p>
                                </div>
                                <div class="col-md-8">
                                    <p v-html="instructor.detail"></p>
                                </div>
                            </div>
                        </div>
                        <!-- About Instructor end -->

                        <!-- What you'll learn start -->
                        <div class="what-learn-list" v-if="whatlearns.length > 0">
                            <div class="p-0">
                                <div class="learn-box">
                                    <div class="learn-title mb-4">
                                        <h2>{{ translate('frontstaticword.Whatyoulllearn')}}</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <ul>
                                                <li class="learn-icon-item" v-for="(learn,id) in whatlearns" :key="id">
                                                    <span> <i class="fa fa-check mr-2" aria-hidden="true"></i></span> 
                                                    <span class="learn-txt">
                                                        {{learn.detail}}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- What you'll learn end -->

                        <!-- Curriculum start -->
                        <div class="col-12 col-md-12" v-if="chapters.length">
                            <h2 class="mb-4">
                                {{ translate('frontstaticword.Curriculum')}}
                            </h2>
                            <div class="curriculum course-details" v-for="(chapter,index) in chapters" :key="index">
                                <h4 class="course-title">
                                    {{chapter.chapter_name}}
                                </h4>
                                <button class="btn btn-danger float-right">
                                    <router-link class="buy-btn" :to="'/course_content/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                        <i class="fa fa-play-circle-o" aria-hidden="true"></i> 
                                        {{ translate('frontstaticword.StartNow')}}
                                    </router-link>
                                </button>
                            </div>
                        </div>
                        <!-- Curriculum end -->

                        <!-- review start -->
                        <div class="comment-list">

                            <!-- Submit review and rating -->
                            <h3 class="mb-3">
                                {{ translate('frontstaticword.SubmitReview')}}
                            </h3>
                            <div class="col-md-8 pd-30 bg-light">
                                <form @submit.prevent="submitReview">
                                    <div class="row padd--40-0">

                                        <!-- Submit stars -->
                                        <div class="col-md-2 col-3 submit__review__titles">
                                            <h5>{{ translate('frontstaticword.Learn')}}</h5>
                                            <h5>{{ translate('frontstaticword.Price')}}</h5>
                                            <h5>{{ translate('frontstaticword.Value')}}</h5>
                                        </div>
                                        
                                        <div class="col-md-10 col-9">
                                            <b-form-rating class="mb-2" variant="warning" v-model="learn" show-clear show-value ></b-form-rating>
                                            <b-form-rating class="mb-2" variant="warning" v-model="price" show-clear show-value></b-form-rating>
                                            <b-form-rating class="mb-2" variant="warning" v-model="value" show-clear show-value></b-form-rating>

                                            <span :class="hide ? 'hide': 'text-danger'">
                                                <i class="fa fa-exclamation-circle mr-2"></i>
                                                {{ translate('frontstaticword.Pleaseselecttheratings')}}!
                                            </span>
                                        </div>

                                        <!-- Write review textarea -->
                                        <div class="col-md-12">
                                            <b-form-group
                                                label="Write a review"
                                                class="mt-2"
                                            >
                                                <b-form-textarea
                                                    id="textarea"
                                                    v-model="reviewText"
                                                    :placeholder="translate('frontstaticword.Entersomething')+'...'"
                                                    rows="3"
                                                    max-rows="6"
                                                    required
                                                    :class="reviewTextError ? 'is-invalid' : ''"
                                                ></b-form-textarea>

                                                <span :class="reviewTextError ? 'text-danger' : 'd-none'">
                                                    <i class="fa fa-exclamation-circle mr-2">
                                                        {{ translate('frontstaticword.enteratleastcharacters')}}.
                                                    </i>
                                                </span>
                                            </b-form-group>
                                        </div>

                                        <!-- Submit button -->
                                        <div class="col-md-12">
                                            <button class="btn btn-warning" type="submit">
                                                {{ translate('frontstaticword.SubmitReview')}}
                                            </button>
                                        </div>
                                    
                                    </div>
                                </form>
                            </div>

                             <!--Show reviews  -->                            
                            <div class="comment-title mt-50">
                                <h3 class="mb-3">
                                    {{ translate('frontstaticword.Comments')}} ({{review}})
                                </h3>
                            </div>
                            <ul class="col-md-8">
                                <li v-for="(courseReview,index) in courseReviews" :key="index">
                                    <div class="media">
                                        
                                        <!-- User Image -->
                                        <img 
                                            class="mr-3"
                                            :src="courseReview.userimage != null ? `${path}/images/user_img/${courseReview.userimage}` : `${baseurl}/modules/blizzard/images/user_default.jpg`" 
                                            :alt="translate('frontstaticword.User')">

                                        <div class="media-body">
                                            
                                            <!-- User name -->
                                            <h5 class="m-0">
                                                {{courseReview.fname}} {{courseReview.lname}}
                                            </h5>
                                            <span class="comment-date"> 
                                                {{ moment(courseReview.created_by).format("Do YYYY") }}
                                            </span>

                                            <!-- Review -->
                                            <p class="mt-2" v-html="courseReview.reviews">
                                            </p>
                                            
                                            <!-- Like Comment -->
                                            <a @click="reviewLike(courseReview.id)">
                                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                            </a> 
                                            {{courseReview.like_count}}

                                            <!-- Dislike Comment -->
                                            <a @click="reviewDislike(courseReview.id)">
                                                <i class="fa fa-thumbs-o-down ml-4" aria-hidden="true"></i> 
                                            </a>    
                                            {{courseReview.dislike_count}}

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- review start -->
                    </div>
                </div>
            </div>
        </section>

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import SocialSharing from 'vue-social-sharing';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import VideoPlayer from '../VideoPlayer.vue';

    export default {

        name: 'course_detail',

        mixins: [mixin, SocialSharing],

        components: {
            headerSection,
            footerSection,
            VideoPlayer
        },

        data() {
            return {
                baseurl: baseurl,
                course: {},
                course_id: this.$route.params.id,
                course_title: this.$route.params.title,
                includes: [],
                percent: null,
                path: null,
                student_enrolled: 0,
                instructor: {},
                language: {},
                review: 0,
                courseReviews: [],
                courseclass: 0,
                wishlist: [],
                wishlistClass: '',
                checkIDInWishlist: false,
                chapters: [],
                purchased: false,
                title: '',
                detailState: null,
                detail: '',
                relatedCourses: [],
                email: '',
                emailState: null,
                giftUser: {},
                fname: '',
                fnameState: null,
                lname: '',
                lnameState: null,
                orderhistory: {},
                learn: 0,
                price: 0,
                value: 0,
                reviewText: null,
                reviewTextError: false,
                hide: true,
                settings: {},
                currency: {},
                courseTagsLength: 0,
                totalRating: 0,
                total_rating_percent: 0,
                categoryDetail: {},
                languageDetail: {},
                whatlearns: {},
                sharing: {
                    url: window.location.href,
                    title: this.$route.params.title,
                    description: 'When it comes to the design of effective learning experiences, one provocative question is worth a hundred proclamations',
                    quote: 'Learn Wherever, Whenever, However... with our Online Classes',
                    hashtags: 'elearning, learn, teaching, education, classroom',
                },
                networks: [{
                        network: 'email',
                        name: 'Email',
                        icon: 'fa fa-envelope-o',
                        color: '#333333'
                    },
                    {
                        network: 'facebook',
                        name: 'Facebook',
                        icon: 'fa fa-facebook',
                        color: '#1877f2'
                    },
                    {
                        network: 'linkedin',
                        name: 'LinkedIn',
                        icon: 'fa fa-linkedin',
                        color: '#007bb5'
                    },
                    {
                        network: 'pinterest',
                        name: 'Pinterest',
                        icon: 'fa fa-pinterest-p',
                        color: '#bd081c'
                    },
                    {
                        network: 'quora',
                        name: 'Quora',
                        icon: 'fa fa-quora',
                        color: '#a82400'
                    },
                    {
                        network: 'reddit',
                        name: 'Reddit',
                        icon: 'fa fa-reddit-alien',
                        color: '#ff4500'
                    },
                    {
                        network: 'skype',
                        name: 'Skype',
                        icon: 'fa fa-skype',
                        color: '#00aff0'
                    },
                    {
                        network: 'twitter',
                        name: 'Twitter',
                        icon: 'fa fa-twitter',
                        color: '#1da1f2'
                    },
                    {
                        network: 'whatsapp',
                        name: 'Whatsapp',
                        icon: 'fa fa-whatsapp',
                        color: '#25d366'
                    },
                    {
                        network: 'wordpress',
                        name: 'Wordpress',
                        icon: 'fa fa-wordpress',
                        color: '#21759b'
                    },
                ],
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // SEO data - meta tags - meta title - meta data
        metaInfo() {
            return {
                title: `${this.course_title ?? 'Course'} | ${this.settings.project_title ?? 'Loading...'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.course_title + this.settings.project_title
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

            // To keep the tabs activate (function will be called by defualt when page is load)
            tab() {

                this.$nextTick(() => {
                    $('button.review-btn').on('click', function () {
                        $('.tab-content, button.review-btn').removeClass('active');
                        var dataTarget = $(this).attr('data-target');
                        $('#' + dataTarget).toggleClass('active');
                        $(this).toggleClass('active');
                    });
                })

            },

            // Call home API to get settings data
            async callHomeAPI() {
                await axios.get(`/api/home?secret=${this.$secretKey}`).then(res => 
                {
                    this.currency = res.data.currency;
                    this.settings = res.data.settings;
                });
            },

            // Call the course detail API (function will be called by defualt when page is load)
            async callAPI() {

                this.callHomeAPI();
                this.checkWishlist(this.course_id);
                if (this.loginStatus == true) {
                    this.purchasehistory(this.course_id);
                }

                await axios.post('/api/course/detail?secret=' + this.$secretKey, {

                    course_id: this.course_id

                }).then(res => {

                    this.course = res.data.course;
                    if (this.course.course_tags != null) {
                        this.courseTagsLength = this.course.course_tags;
                    }
                    this.includes = res.data.course.include;
                    this.student_enrolled = res.data.student_enrolled;
                    this.instructor = res.data.course.user;
                    this.categoryDetail = res.data.course.category;
                    this.languageDetail = res.data.course.language;
                    this.language = res.data.course.language;
                    this.courseclass = res.data.course.courseclass.length;
                    this.whatlearns = res.data.course.whatlearns;
                    this.chapters = res.data.course.chapter;
                    this.totalRating = res.data.total_rating;
                    this.total_rating_percent = res.data.total_rating_percent;
                    if (res.data.review != null) {
                        this.review = res.data.review.length
                    }
                    this.courseReviews = res.data.review;
                    this.relatedCourses = res.data.course.related;

                });

                this.percentage();

            },

            // Calculate the discount percentag of course
            percentage() {

                let difference = this.course.price - this.course.discount_price
                this.percent = parseFloat(((difference / this.course.price) * 100).toFixed(0))

            },

            // Check if the course is in wislist or not on the load of page
            async checkWishlist(id) {

                if (this.loginStatus == true) {
                    await axios.post('/api/show/wishlist?secret=' + this.$secretKey, {
                        //data
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res => {

                        this.wishlist = res.data.wishlist;

                        //Check course id in wishlist API
                        this.wishlist.forEach(wishlists => {
                            if (id == wishlists.course_id) 
                            {
                                this.checkIDInWishlist = true
                            } 
                            else 
                            {
                                this.checkIDInWishlist = false
                            }
                        });

                    });

                    //Pass class for wishlist
                    if (this.checkIDInWishlist == true) 
                    {
                        this.wishlistClass = 'fa fa-heart'
                    } 
                    else 
                    {
                        this.wishlistClass = 'fa fa-heart-o'
                    }
                } 
                else 
                {
                    this.wishlistClass = 'fa fa-heart-o'
                }

            },

            // Change the wishlist icon as per action
            actionOnWishlist() {
                if (this.loginStatus == true) {
                    if (this.wishlistClass == 'fa fa-heart-o') 
                    {
                        this.addToWishlist(this.course_id);
                    } 
                    else 
                    {
                        this.removeFromWishlist(this.course_id);
                    }
                } 
                else 
                {
                    let config = {
                        text: 'Please Login !',
                        button: 'CLOSE'
                    }

                    this.$snack['danger'](config);
                }
            },

            // Add the course to wishlist
            async addToWishlist(id) {

                await axios.post('/api/addtowishlist?secret=' + this.$secretKey, {
                    course_id: id
                }, 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }

                })
                .then(res => {

                    if (res.status == 200) {
                        let config = {
                            text: res.data,
                            button: 'CLOSE'
                        }

                        this.$snack['success'](config);
                        this.wishlistClass = 'fa fa-heart';
                    }

                })
                .catch(err => {

                    if (err.response.status === 401) {
                        let config = {
                            text: err.response.data,
                            button: 'CLOSE'
                        }

                        this.$snack['danger'](config);
                    }

                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }

                });

            },

            // To remove the course from wishlist
            async removeFromWishlist(id) {

                const headers = {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.token}`
                }

                await axios.post('/api/remove/wishlist?secret=' + this.$secretKey, {
                    course_id: id
                }, 
                {
                    headers: headers

                })
                .then(res => {

                    if (res.status == 200) {

                        let config = {
                            text: 'Course is removed from your wishlist !',
                            button: 'CLOSE'
                        }

                        this.$snack['success'](config);
                        this.wishlistClass = 'fa fa-heart-o';

                    }

                })
                .catch(err => {

                    if (err.res.status === 401) {
                        let config = {
                            text: 'Course does not exist in your wishlist !',
                            button: 'CLOSE'
                        }

                        this.$snack['danger'](config);
                    }

                    if (err.response) {
                        this.errors = err.res.data.errors;
                    }

                });

            },

            // Call aPI to add course to cart
            async addToCart(id) {

                if (this.loginStatus) {

                    await axios.post('/api/addtocart?secret=' + this.$secretKey, {
                        course_id: id
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }).then(response => {

                        if (response.status == 200) {
                            let config = {
                                text: response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.$router.push('/cart');
                        }

                    }).catch(err => {

                        if (err.response.status === 401) {
                            let config = {
                                text: err.response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                    });
                } else {
                    let config = {
                        text: 'Please Login First !',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                    this.$router.push('/signIn');
                }

            },

            // Api to enroll a course
            async enroll(id) {

                if (this.loginStatus) {

                    await axios.post('/api/free/enroll?secret=' + this.$secretKey, {

                            course_id: id

                        }, {
                            headers: {
                                'Authorization': `Bearer ${this.token}`
                            }
                        })
                        .then(res => {

                            if (res.data.status == 'success') {
                                let config = {
                                    text: res.data.message,
                                    button: 'CLOSE'
                                }

                                this.$snack['success'](config);
                                this.purchasehistory(id);
                            }

                        }).catch(err => {

                            console.log(err.response);

                        });
                } else {
                    let config = {
                        text: 'Please Login First !',
                        button: 'CLOSE'
                    }

                    this.$snack['danger'](config);

                    this.$router.push('/login');
                }

            },

            // To get the purchase history of user
            async purchasehistory(id) {

                if (this.loginStatus == true) {
                    let apiData = {
                        params: {
                            secret: this.$secretKey
                        },
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }

                    await axios.get('/api/purchase/history', apiData)
                        .then(res => {

                            if (res.status == 200) {
                                this.orderhistory = res.data.orderhistory;

                                this.orderhistory.forEach(orders => {

                                    if (id == orders.course_id) {
                                        this.purchased = true;
                                        return false;
                                    }

                                });

                            }
                        })
                }
            },

            // Report the course validation check
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.detailState = valid
                return valid
            },

            // Reset the report modal after submission
            resetModal() {
                this.detailState = null,
                    this.detail = ''
            },

            // Prevent report to submit if validation is nnot fullfill
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.submitReport()
            },

            // This function submit the reported course 
            async submitReport() {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
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

                let submitData = {
                    course_id: this.course_id,
                    detail: this.detail
                }

                await axios.post('/api/course/report', submitData, apiData)
                    .then(res => {

                        if (res.data.status == 'fail') {
                            let configFail = {
                                text: res.data.message,
                                button: 'CLOSE!'
                            }
                            this.$snack['danger'](configFail);
                        }

                        if (res.data.status == 'success') {
                            let config = {
                                text: res.data.message,
                                button: 'CLOSE'
                            }

                            this.$snack['success'](config);
                        }

                    }).catch(err => {

                        console.log(err.response);

                    });

                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
            },

            // Gift course validation check
            checkGiftFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.emailState = valid
                return valid
            },

            // Reset the Gift modal after submission
            resetGiftModal() {
                this.emailState = null,
                    this.email = '',
                    this.fname = '',
                    this.fnameState = null,
                    this.lname = '',
                    this.lnameState = null
            },

            // Prevent Gift modal to submit if validation is not fullfill
            handleGift(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.giftCourse()
            },

            // Gift course function
            async giftCourse() {

                // Exit when the form isn't valid
                if (!this.checkGiftFormValidity()) {
                    return
                }

                await axios.post(`/api/gift/user/check?secret=${this.$secretKey}`, {
                        course_id: this.course_id,
                        email: this.email,
                        fname: this.fname,
                        lname: this.lname
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res => {

                        if (res.status == 200) {
                            let config = {
                                text: 'Lets Checkout with the gift!',
                                button: 'CLOSE!'
                            }
                            this.$snack['success'](config);

                            this.$nextTick(() => {
                                this.$bvModal.hide('modal-prevent-closing-2')
                            });
                            this.giftUser = res.data.user;
                            
                            this.$router.push({
                                name: 'giftCheckout',
                                params: {
                                    course_id: this.course_id,
                                    user_id: res.data.user.id
                                }
                            });
                        }

                        if (res.data.status == 'fail') {
                            let config = {
                                text: res.data.message,
                                button: 'CLOSE!'
                            }
                            this.$snack['danger'](config);
                        }

                    })
                    .catch(err => {

                        if (err.response.status == 500) {
                            let config = {
                                text: err.response.data.message,
                                button: 'CLOSE!'
                            }
                            this.$snack['danger'](config);
                        }

                    });
            },

            // To reset the values after submission
            resetReview() {
                this.learn = 0,
                this.price = 0,
                this.value = 0,
                this.reviewText = null,
                this.hide = true
            },

            // To recall review api after review submission
            async recallReview() {

                if (this.loginStatus == true) {
                    this.purchasehistory(this.course_id);
                }
                await axios.post('/api/course/detail?secret=' + this.$secretKey, {

                    course_id: this.course_id

                }).then(res => {

                    if (res.data.review != null) {
                        this.review = res.data.review.length
                    }
                    this.courseReviews = res.data.review;

                });
            },

            // Submit the review
            async submitReview() {

                // validation for star ratings
                if (this.learn == 0 || this.price == 0 || this.value == 0) 
                {
                    this.hide = false;
                    return false;
                } 
                else 
                {
                    if(this.reviewText.length > 5)
                    {
                        this.reviewTextError = false;
                        let formData = {
                            course_id: this.course_id,
                            learn: this.learn,
                            price: this.price,
                            value: this.value,
                            review: this.reviewText
                        }

                        let apiData = {
                            headers: {
                                'Authorization': `Bearer ${this.token}`
                            }
                        }

                        await axios.post(`/api/review/submit?secret=${this.$secretKey}`, formData, apiData)
                        .then(response => {

                            if (response.status == 200) {
                                let config = {
                                    text: 'Review Submitted Successfully',
                                    button: 'CLOSE'
                                }
                                this.$snack['success'](config);
                                this.resetReview();
                                this.recallReview();
                            }

                        })
                        .catch(err => {

                            console.log(err.response);
                            if (err.response.status == 402) {
                                let config = {
                                    text: 'You have already submitted a review',
                                    button: 'CLOSE'
                                }
                                this.$snack['danger'](config);
                                this.resetReview();
                            }

                        });
                    }
                    else
                    {
                        this.reviewTextError = true;
                    }
                }
            },

            // Like the Review
            async reviewLike(id)
            {
                if(this.loginStatus == true)
                {
                    await axios.post(`/api/review/helpful/${id}?secret=${this.$secretKey}`, {
                        course_id: this.course_id,
                        review_like: '1'
                    },
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res=> {
                        if(res.data.status=='success')
                        {
                            let config = {
                                text: 'You liked the review',
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.recallReview();
                        }
                    })
                    .catch( err=> {
                        console.log(err.response);
                    });
                }
                else
                {
                    let config = {
                        text: 'Please Login',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }
            },
            // Dislike a Review
            async reviewDislike(id)
            {
                if(this.loginStatus == true)
                {    
                    await axios.post(`/api/review/helpful/${id}?secret=${this.$secretKey}`, {
                        course_id: this.course_id,
                        review_dislike: '1'
                    },
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res=> {
                        if(res.data.status=='success')
                        {
                            let config = {
                                text: 'You disliked the review',
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.recallReview();
                        }
                    })
                    .catch( err=> {
                        console.log(err.response);
                    });
                }
                else
                {
                    let config = {
                        text: 'Please Login',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }
            }

        },

        mounted() {

            this.callAPI();
            this.tab();
            this.path = axios.defaults.baseURL;

        }
    }
</script>