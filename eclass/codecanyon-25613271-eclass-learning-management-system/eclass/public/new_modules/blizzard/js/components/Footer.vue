<template>
    <div>
        <!-- footer section start -->
        <footer class="main-footer">
            <div class="footer-section" v-if="!loading">
                <div class="footer-bg" v-if="widgets != null"></div>
                <div class="container" v-if="widgets != null">
                    <div class="row" v-if="widgets.widget_enable == '1'">
                        <!-- Widget One -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="sub-footer">
                                <h4>{{widgets.widget_one}}</h4>
                                <ul>
                                    <!-- About Us -->
                                    <li v-if="widgets.about_enable == '1'">
                                        <router-link to="/about_us"> 
                                            {{ translate('frontstaticword.Aboutus')}}
                                        </router-link>
                                    </li>
                                    <!-- Contact Us -->
                                    <li v-if="widgets.contact_enable == '1'">
                                        <router-link to="/contact_us">
                                        {{ translate('frontstaticword.Contactus')}}
                                        </router-link>
                                    </li>
                                    <!-- Become instructor -->
                                    <li v-if="mainUser.role == 'user'">
                                        <router-link to="/becomeInstructor">
                                            {{ translate('frontstaticword.BecomeAnInstructor')}}
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Widget Two -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="sub-footer">
                                <h4>{{widgets.widget_two}}</h4>
                                <ul>
                                    <li v-if="widgets.blog_enable == '1'">
                                        <router-link to="/blogs">
                                            {{ translate('frontstaticword.Blog')}} 
                                        </router-link>
                                    </li>
                                    <li v-if="widgets.career_enable == '1'">
                                        <router-link to="/career">
                                            {{ translate('frontstaticword.Careers')}}
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="/helpSupport">
                                            {{ translate('frontstaticword.Help&Support')}}
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Widget Three -->
                        <div class="col-12 col-sm-6 col-lg-3" v-if="pages.length > 0">
                            <div class="sub-footer">
                                <h4>{{widgets.widget_three}}</h4>
                                <ul>
                                    <li v-for="(page,index) in pages" :key="index">
                                        <a @click="goToPage(page.id, page.slug)">
                                            {{page.title}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- About -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="sub-footer">
                                <h4>
                                    {{ translate('frontstaticword.About')}}
                                </h4>
                                <ul>
                                    <!-- Address -->
                                    <li>
                                        <i class="feather icon-map-pin mr-2"></i>
                                        {{settings.default_address}}
                                    </li>
                                    <!-- Mobile Number -->
                                    <li>
                                        <i class="feather icon-smartphone mr-2"></i>
                                        {{settings.default_phone}}
                                    </li>
                                    <!-- Mail -->
                                    <li>
                                        <i class="feather icon-mail mr-2"></i>
                                        {{settings.wel_email}}
                                    </li>
                                </ul>
                                <div class="start-btn mt-3">
                                    <a @click="goToHome">
                                        {{ translate('frontstaticword.GetStarted')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skeleton loading till we fetch footer data -->
            <div class="footer-section" v-else>
                <div class="footer-bg"></div>
                <footer-skeleton />
            </div>

            <!-- Copyright -->
            <div class="copy-ryt">
                <div class="container">
                    <div class="row align-items-center">

                        <!-- Logo -->
                        <div class="col-12 col-sm-4">
                            <div class="footer-logo" v-if="settings.logo">
                                <router-link to="/">
                                    <img class="mb-3 mb-sm-0"
                                        :src="`${path}/images/logo/${settings.logo}`" alt="logo" width="125px" height="40px">
                                </router-link>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <!-- Play store link -->
                            <a v-if="this.settings.play_download=='1'" :href="this.settings.play_link" target="_blank">
                                <img :src="`${path}/images/icons/download-google-play.png`" alt="playStore" width="30%">
                            </a>

                            <!-- Apple store link -->
                            <a v-if="this.settings.app_download=='1'" :href="this.settings.app_link" target="_blank">
                                <img :src="`${path}/images/icons/app-download-ios.png`" alt="appleStore" width="30%">
                            </a>
                        </div>

                        <div class="col-12 col-sm-4 text-md-right">
                            <!-- Copyright -->
                            <p class="mb-2" v-if="copyright.cpy_txt != '' && copyright.cpy_txt != null">{{copyright.cpy_txt}}</p>

                            <!-- Terms/Condition -->
                            <router-link to="/terms__condition" class="mr-2"> 
                                {{ translate('frontstaticword.Terms&Condition')}}
                            </router-link>

                            <!-- Privacy Policy -->
                            <router-link to="/privacy__policy"> 
                                {{ translate('frontstaticword.PrivacyPolicy')}}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll to top button -->
            <div id="pagetop" class="scroll" v-show="scY> 300" @click="toTop">
                <i class="feather icon-chevron-up"></i>
            </div>
        </footer> 
        <!-- footer section end-->

    </div>
</template>

<script>
    
    "use Strict";
    
    import mixin from '../mixin.js';
    import footerSkeleton from './Skeletons/Footer.vue';
    import EventBus from '../EventBus.js';

    export default {

        name: 'footerSection',

        mixins: [mixin],

        data() {
            return {
                baseurl : baseurl,
                path: null,
                loading: true,
                copyright: {},
                pages: [],
                widgets: {},
                scTimer: 0,
                scY: 0
            }
        },

        components: {
            footerSkeleton
        },

        methods: {

            // Call the home and footer widget API's (this function will be called by default on the load of this component)
            async callAPI() {
                
                this.getWidgetData();
                this.getPages();

                // Get copyright data from home api
                await axios.get(`/api/home?secret=${this.$secretKey}`)
                .then(res => 
                {
                    this.copyright = res.data.settings;
                    this.loading = false;
                })
                .catch(err => 
                {
                    console.log(err.response);
                    this.loading = false;
                });
                
                this.loading = false;
                
            },

            async getPages() 
            {
                // All pages data
                await axios.get(`/api/all/pages?secret=${this.$secretKey}`)
                .then(res => 
                {
                    this.pages = res.data.pages;
                })
                .catch(err => 
                {
                    console.log(err.response);
                });
            },

            //Go to dynamic pages
            async goToPage(id, slug)
            {
                var pathname = window.location.pathname.split( '/' );

                var one;
                pathname.forEach(findPath=> {
                    if(findPath == 'page_detail')
                    {
                        one = 'page_detail';
                        return false;
                    }
                })
                
                if(one == `page_detail`)
                {
                    EventBus.$emit('page',id);
                    this.$router.push(`/page_detail/${id}/${slug.replace(/\s+/g, '_')}`);
                }
                else
                {
                    this.$router.push(`/page_detail/${id}/${slug.replace(/\s+/g, '_')}`);
                }

            },

            // Get widget details
            async getWidgetData() 
            {
                await axios.get(`/api/footer/widget?secret=${this.$secretKey}`)
                .then(res => 
                {
                    this.widgets = res.data.widget;
                })
                .catch(err => 
                {
                    console.log(err.response);
                });
            },

            // Go To Home
            goToHome() 
            {
                if (this.$router.currentRoute.path == '/') 
                {
                    location.reload();
                } 
                else 
                {
                    this.$router.push('/');
                }
            },

            //Function for scroll to top
            handleScroll: function () {
                if (this.scTimer) return;
                this.scTimer = setTimeout(() => {
                this.scY = window.scrollY;
                clearTimeout(this.scTimer);
                this.scTimer = 0;
                }, 100);
            },
            toTop: function () {
                window.scrollTo({
                top: 0,
                behavior: "smooth"
                });
            },

        },

        mounted() 
        {
            window.addEventListener('scroll', this.handleScroll);
            this.path = axios.defaults.baseURL;
            this.callAPI();
        },

    }
</script>

<style scoped>
#scrollToTopBtn {
  background-color: black;
  border: none;
  border-radius: 50%;
  color: white;
  cursor: pointer;
  font-size: 16px;
  line-height: 48px;
  width: 48px;
}
</style>