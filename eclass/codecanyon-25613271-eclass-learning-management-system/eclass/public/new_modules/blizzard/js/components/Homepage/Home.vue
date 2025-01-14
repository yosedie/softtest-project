<!-- This is the home page of the site -->
<template>
    <div>

        <!-- Promo Bar -->
        <div class="text-center" v-if="this.settings.promo_enable=='1'">
            <b-alert
            show='120'
            dismissible
            variant="promo"
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged"
            >
                <!-- If promo has link -->
                <div v-if="this.settings.promo_link!=null">
                    <a :href="this.settings.promo_link" target="_blank" class="alert-link">
                        {{this.settings.promo_text}}
                    </a>
                </div>
                <!-- Promo with no link -->
                <div v-else>
                    {{this.settings.promo_text}}
                </div>
            </b-alert>
        </div>

        <!-- Call all imported components -->
        <header-section />
        <slider />
        <sliderfacts />
        <all-courses />
        <recent-course />
        <featured-course />
        <get-started />
        <bundle-courses />
        <partners />
        <popular-blog />
        <testimonial />
        <div class="margin_above_footer"></div>
        <footer-section />
        
        <cookie 
            v-if="this.settings.cookie_enable=='1'" 
            :cookietext="translate('frontstaticword.cookieMsg') "
            :cookiebutton="translate('frontstaticword.Allow')" 
            :cookiename="cookiename" 
            :cookievalue="cookievalue" 
            :cookieexdays="cookieexdays" >
        </cookie>

    </div>
</template>

<script>
    "use Strict";
    
    import cookie from 'vue-cookie-notification';
    // import the components
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import slider from '../Homepage/Slider.vue';
    import allCourses from '../Course/AllCourse.vue';
    import sliderfacts from '../Homepage/SliderFacts.vue';
    import recentCourse from '../Course/RecentCourses.vue';
    import featuredCourse from '../Course/FeaturedCourse.vue';
    import getStarted from '../Homepage/GetStarted.vue';
    import bundleCourses from '../Course/BundleCourse.vue';
    import partners from '../Homepage/Partner.vue';
    import popularBlog from '../Blog/PopularBlog.vue';
    import testimonial from '../Homepage/Testimonial.vue';
    import footerSection from '../Footer.vue';
    
    export default {

        name: 'home',

        mixins: [mixin],

        // Define components
        components: {
            cookie,
            headerSection,
            slider,
            allCourses,
            sliderfacts,
            recentCourse,
            featuredCourse,
            getStarted,
            bundleCourses,
            partners,
            popularBlog,
            testimonial,
            footerSection
        },

        data()
        {
            return {
                dismissCountDown: 0,
                baseurl: baseurl,
                meta: {
                    name: 'Home',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME,
                cookiename:'COOKIE',
                cookievalue:'COOKIE',
                cookieexdays:365
            }
        },

        methods: {

            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
        },

        // Set the SEO and meta for the homepage
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'} `,
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
        }
    }
</script>