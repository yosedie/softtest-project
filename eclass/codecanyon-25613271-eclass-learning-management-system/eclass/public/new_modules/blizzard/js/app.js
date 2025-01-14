/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 "use Strict";
 
 require('./bootstrap');
 require('axios');
 import Vue from 'vue';
 
 import '../../../node_modules/vue-snack/dist/vue-snack.min.css';
 import '../../../node_modules/vue-social-sharing/dist/vue-social-sharing.js';
 
 //import videoJs
 import VideoPlayer from './components/VideoPlayer.vue';
 require('../../../node_modules/video.js/dist/video-js.css');
 Vue.config.ignoredElements = [
   'video-js'
 ];

 // import vue cookie package
 import VueCookies from 'vue-cookies';
 Vue.use(VueCookies);
 
 // Import Social SHaring
 import SocialSharing from 'vue-social-sharing'
 Vue.use(SocialSharing);
 
// GLOBAL DECLARATIONS

import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)

 // For Google SEO
 import VueMeta from 'vue-meta'
 Vue.use(VueMeta);
 
 //default axios baseURL
 axios.defaults.baseURL = baseurl;
 
 Vue.config.productionTip = false;
 
 //global variables
 Vue.prototype.$secretKey = secret;
 
 //Import View Router
 import VueRouter from 'vue-router'
 Vue.use(VueRouter)
 
 //Import Bootstrap Vue
 import BootstrapVue from 'bootstrap-vue';
 import 'bootstrap-vue/dist/bootstrap-vue.css';
 Vue.use(BootstrapVue);
 
 //import slick carousel
 import '../../../node_modules/slick-carousel/slick/slick';
 
 //import snackbar for popup message
 import VueSnackbar from 'vue-snack';
 Vue.use(VueSnackbar);
 
 // import vue moment for date time conversion
 import moment from 'moment';
// import { component } from 'vue/types/umd';
 Vue.prototype.moment = moment

 // If you want to add to window object
 // Translation
 Vue.prototype.translate=require('../../js/VueTranslation/Translation').default.translate;

 
  //Vue Routes
  const router = new VueRouter ({
    mode: 'history',
    base: mix_theme_folder,
    routes: [
      { path: '/', name: 'home', component: require('./components/Homepage/Home.vue').default },

      //Credential
      { path: '/signIn', name: 'signIn',component: require('./components/Login.vue').default },
      { path: '/signUp', component: require('./components/Register.vue').default },
      { path: '/forgetPassword', component: require('./components/Homepage/ForgetPassword.vue').default },

      //Social Login
      { path: '/facebook/login', component: require('./components/Homepage/LoginLoader.vue').default },

      //Courses
      { path: '/bundle_course_detail/:id/:title', name: 'bundle_course_detail',component: require('./components/Course/BundleCourseDetail.vue').default },
      { path: '/course_detail/:id/:title', params: true, name: 'course_detail', component: require('./components/Course/CourseDetail.vue').default },
      { path: '/course_content/:id/:title', params: true, name: 'go_to_course', component: require('./components/Course/CourseContent.vue').default },
      { path: '/start_quiz/:course_title/:quiz_id/:title/:course_id', params: true, name: 'start_quiz', component: require('./components/Course/StartQuiz.vue').default },
      { path: '/courses', params: true, name: 'courses', component: require('./components/Course/AllCourse.vue').default },
      { path: '/meetings', name: 'meetings', component: require('./components/Course/Meetings.vue').default },
      { path: '/meeting_detail/:id/:title', params: true, name: 'meeting_detail', component: require('./components/Course/MeetingDetail.vue').default },
      
      //Blog
      { path: '/blogs', name: 'blog', component: require('./components/Blog/Blog.vue').default },
      { path: '/blog_detail/:id/:title', params:true, name: 'blog_detail', component: require('./components/Blog/BlogDetail.vue').default },

      //Categories
      { path: '/category_detail/:category_type/:id/:title', params:true, name: 'category_detail', component: require('./components/Category/CategoryFilter.vue').default },

      //Pages
      { path: '/terms__condition', component: require('./components/Pages/TermsCondition.vue').default },
      { path: '/privacy__policy', component: require('./components/Pages/PrivacyPolicy.vue').default },
      { path: '/career', component: require('./components/Pages/Career.vue').default },
      { path: '/helpSupport', component: require('./components/Pages/HelpSupport.vue').default },
      { path: '/404', name: 'not_found' , component: require('./components/Pages/NotFound.vue').default },
      { path: '/about_us', name: 'about_us' , component: require('./components/Pages/About.vue').default },
      { path: '/contact_us', name: 'contact_us' , component: require('./components/Pages/Contact.vue').default },
      { path: '/search', component: require('./components/Pages/Search.vue').default },
      { path: '/page_detail/:id/:slug', name: 'page_detail', params: true,component: require('./components/Pages/PageDetail.vue').default },
      { path: '/successful_payment', component: require('./components/Pages/PaymentSuccess.vue').default },

      //For User
      { path: '/myCourses', component: require('./components/User/MyCourses.vue').default },
      { path: '/wishlist', component: require('./components/User/Wishlist.vue').default },
      { path: '/myProfile', component: require('./components/User/MyProfile.vue').default },
      { path: '/userCourses', component: require('./components/User/UserProfileCourses.vue').default },
      { path: '/userWishlist', component: require('./components/User/UserProfileWishlist').default },
      { path: '/becomeInstructor', component: require('./components/User/BecomeInstructor.vue').default },
      { path: '/cart', name: 'cart', component: require('./components/User/Cart.vue').default },
      { path: '/checkout', name: 'checkout', component: require('./components/User/Checkout.vue').default },
      { path: '/giftCheckout/:course_id/:user_id', name: 'giftCheckout', component: require('./components/User/GiftCheckout.vue').default },
      { path: '/purchaseHistory', component: require('./components/User/PurchaseHistory.vue').default },
      { path: '/bank_details', component: require('./components/User/Bank.vue').default },

      //Instructor
      {path: '/instructor_detail/:id/:name', params: true, name: 'instructor_detail', component: require('./components/Instructor/Instructor.vue').default },

      { path: '*', redirect: {name:'not_found'}},
    ],

    scrollBehavior() {
    return {x: 0, y: 0}
    }

  });
 
     
  const app = new Vue({
    components: {
      VideoPlayer
    },
    router
  }).$mount('#app')
 
