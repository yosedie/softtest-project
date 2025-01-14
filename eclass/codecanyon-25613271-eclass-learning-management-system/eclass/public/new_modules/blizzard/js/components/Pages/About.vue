<template>
    <div>

        <header-section />
        
        <div v-if="!loading">
            <div v-for="(about,index) in aboutUs" :key="index">

                <!-- About Banner start -->
                <section  v-if="about.one_enable == 1" id="about-us" class="about-us-main-block" :style="`background-image: url('${path}/images/about/${about.one_image}')`">
                    <div class="overlay-bg"></div>
                    <div class="container text-center" v-if="about.one_heading">
                        <h1 class="about-us-heading">{{about.one_heading}}</h1>
                    </div>
                </section>
                <section id="about-blog" class="about-blog-main-block" v-if="about.one_text">
                    <div class="container">
                        <div class="about-blog-block text-center"><a href="#" title="NextClass Blog"><span>
                            <i class="fa fa-circle rgt-10"></i> </span>{{about.one_text}}</a>
                        </div>
                    </div>   
                </section>
                <!-- About Banner end -->

                <!--Instructor Section Start -->
                <section v-if="about.two_enable == 1" id="about-section" class="about-section-main-block">
                    <div class="container">
                        <div class="about-section-heading-block text-center">
                            <h1 class="about-section-heading-one text-center" v-if="about.two_heading">{{about.two_heading}}</h1>  
                            <p v-if="about.two_text">{{about.two_text}}</p>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" role="navigation">
                                        <!-- One -->
                                        <li class="nav-item" v-if="about.two_imageone">
                                            <a href="#tab-A" class="nav-link active" data-toggle="tab" role="tab" aria-controls="lorem">
                                                <img :src="`${path}/images/about/${about.two_imageone}`" class="img-fluid tab-img" alt="about-img">
                                                <div class="about-section-heading active" v-if="about.two_txtone">{{about.two_txtone}}</div>
                                            </a>
                                        </li>
                                        <!-- Two -->
                                        <li class="nav-item" v-if="about.two_imagetwo">
                                            <a href="#tab-B" class="nav-link" data-toggle="tab" role="tab" aria-controls="ipsum">
                                                <img :src="`${path}/images/about/${about.two_imagetwo}`" class="img-fluid tab-img" alt="about-img">
                                                <div class="about-section-heading active" v-if="about.two_txttwo">{{about.two_txttwo}}</div>
                                            </a>
                                        </li>
                                        <!-- Three -->
                                        <li class="nav-item" v-if="about.two_imagethree">
                                            <a href="#tab-C" class="nav-link" data-toggle="tab" role="tab" aria-controls="dolor">
                                                <img :src="`${path}/images/about/${about.two_imagethree}`" class="img-fluid tab-img" alt="about-img">
                                                <div class="about-section-heading active" v-if="about.two_txtthree">{{about.two_txtthree}}</div>
                                            </a>
                                        </li>
                                        <!-- Four -->
                                        <li class="nav-item" v-if="about.two_imagefour">
                                            <a href="#tab-D" class="nav-link" data-toggle="tab" role="tab" aria-controls="sit-amet">
                                                <img :src="`${path}/images/about/${about.two_imagefour}`" class="img-fluid tab-img" alt="about-img">
                                                <div class="about-section-heading active" v-if="about.two_txtfour">{{about.two_txtfour}}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-9 col-md-8" v-if="about.two_imageone">
                                    <div class="tab-content">
                                        <!-- One -->
                                        <div class="tab-pane fade show active" id="tab-A" role="tabpanel" v-if="about.two_imageone">
                                            <div class="card-body">
                                                <div class="about-section-img">
                                                    <a href="#" title="about">
                                                        <img :src="`${path}/images/about/${about.two_imageone}`" class="img-fluid" alt="about-img">
                                                        <div class="overlay-bg"></div>
                                                    </a>
                                                </div>
                                                <div class="about-section-block">
                                                    <h3 v-if="about.two_txtone">{{about.two_txtone}}</h3>
                                                    <p class="btm-40" v-if="about.two_imagetext">{{about.two_imagetext}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Two -->
                                        <div class="tab-pane fade" id="tab-B" role="tabpanel" v-if="about.two_imagetwo">
                                            <div class="card-body">
                                                <div class="about-section-img">
                                                    <a href="#" title="about">
                                                        <img :src="`${path}/images/about/${about.two_imagetwo}`" class="img-fluid" alt="about-img">
                                                        <div class="overlay-bg"></div>
                                                    </a>
                                                </div>
                                                <div class="about-section-block">
                                                    <h3>{{about.two_txttwo}}</h3>
                                                    <p class="btm-40">{{about.text_one}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Three -->
                                        <div class="tab-pane fade" id="tab-C" role="tabpanel" v-if="about.two_imagethree">
                                            <div class="card-body">
                                                <div class="about-section-img">
                                                    <a href="#" title="about">
                                                        <img :src="`${path}/images/about/${about.two_imagethree}`" class="img-fluid" alt="about-img">
                                                        <div class="overlay-bg"></div>
                                                    </a>
                                                </div>
                                                <div class="about-section-block">
                                                    <h3>{{about.two_txtthree}}</h3>
                                                    <p class="btm-40">{{about.text_two}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Four -->
                                        <div class="tab-pane fade" id="tab-D" role="tabpanel" v-if="about.two_imagefour">
                                            <div class="card-body">
                                                <div class="about-section-img">
                                                    <a href="#" title="about">
                                                        <img :src="`${path}/images/about/${about.two_imagefour}`" class="img-fluid" alt="about-img">
                                                        <div class="overlay-bg"></div>
                                                    </a>
                                                </div>
                                                <div class="about-section-block">
                                                    <h3>{{about.two_txtfour}}</h3>
                                                    <p class="btm-40">{{about.text_three}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Instructor Section End -->

                <!-- Our reach section start -->
                <section class="counter" v-if="about.three_enable == 1">
                    <div class="container">
                        <div class="row justify-content-center">
                                <h1 class="facts-block-heading text-center">{{about.three_heading}}</h1>
                                <p class="text-center text-white">{{about.three_text}}</p>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="facts-block text-center">
                                        <h1 class="facts-heading">{{about.three_countone}}</h1>
                                        <div class="facts-dtl">{{about.three_txtone}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="facts-block text-center">
                                        <h1 class="facts-heading counter">{{about.three_counttwo}}</h1>
                                        <div class="facts-dtl">{{about.three_txttwo}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="facts-block text-center">
                                        <h1 class="facts-heading counter">{{about.three_countthree}}</h1>
                                        <div class="facts-dtl">{{about.three_txtthree}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="facts-block text-center">
                                        <h1 class="facts-heading counter">{{about.three_countfour}}</h1>
                                        <div class="facts-dtl">Course {{about.three_txtfour}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="facts-block text-center">
                                        <h1 class="facts-heading counter">{{about.three_countfive}}</h1>
                                        <div class="facts-dtl">{{about.three_txtfive}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="facts-block text-center">
                                        <h1 class="facts-heading counter">{{about.three_countsix}}</h1>
                                        <div class="facts-dtl">{{about.three_txtsix}}</div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </section>
                <!-- Our reach section end-->

                <!-- Two Image and Content Start -->
                <section v-if="about.four_enable == 1" class="p-tb-100 bg-light">
                    <div class="container bg-light">
                        
                        <div class="row pt-4 bg-white" v-if="about.four_imageone || about.four_imagetwo">
                            <div class="col-md-6">
                                <img :src="`${path}/images/about/${about.four_imageone}`" alt="image_one" width="100%" height="320px">
                            </div>
                            <div class="col-md-6">
                                <img :src="`${path}/images/about/${about.four_imagetwo}`" alt="image_two" width="100%" height="320px">
                            </div>
                        </div>

                        <div class="row bg-white">
                            <div class="col-md-12 mt-4 mb-4">
                                <h4>{{about.four_heading}}</h4>
                                <p> {{about.four_text}} </p>
                                <span>{{about.four_txtone}} | {{about.four_txttwo}}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Two Image and Content End -->

                <!-- Bottom Cards - Follow Us Start -->
                <section id="about-learning" class="about-learning-main-block" v-if="about.six_enable == 1">
                    <div class="container">
                        <h1 class="about-learning-heading text-center">{{about.six_heading}}</h1>
                        <div class="about-learning-block">
                            <div class="row">
                                <!-- One -->
                                <div class="col-lg-4 col-md-4">
                                    <a :href="about.link_one!=null ? about.link_one : ''" target="_blank">
                                        <div class="about-learning-dtl">
                                        <h3 class="about-learning-dtl-heading">{{about.six_txtone}}</h3>
                                        <div class="row">
                                            <div class="col-lg-10 col-9">
                                                <div class="about-learning-paragraph">
                                                    <p class="text-truncate">{{about.six_deatilone}}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3">
                                                <div class="about-learning-icon">
                                                    <i class="fa fa-chevron-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Two -->
                                <div class="col-lg-4 col-md-4">
                                    <a :href="about.link_two!=null ? about.link_two : ''" target="_blank">
                                        <div class="about-learning-dtl about-learning-dtl-one" v-if="about.six_txttwo">
                                            <h3 class="about-learning-dtl-heading">{{about.six_txttwo}}</h3>
                                            <div class="row" v-if="about.six_deatiltwo">
                                                <div class="col-lg-10 col-9">
                                                    <div class="about-learning-paragraph">
                                                        <p class="text-truncate">{{about.six_deatiltwo}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3">
                                                    <div class="about-learning-icon">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Three -->
                                <div class="col-lg-4 col-md-4">
                                    <a :href="about.link_three!=null ? about.link_three : ''" target="_blank">
                                        <div class="about-learning-dtl about-learning-dtl-two" v-if="about.six_txtthree">
                                            <h3 class="about-learning-dtl-heading">{{about.six_txtthree}}</h3>
                                            <div class="row" v-if="about.six_deatilthree">
                                                <div class="col-lg-10 col-9">
                                                    <div class="about-learning-paragraph">
                                                        <p class="text-truncate">{{about.six_deatilthree}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3">
                                                    <div class="about-learning-icon">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Follow -->
                    <div class="about-follow-block text-center bg-color-bgray">
                        <ul>
                            <li>Follow Us :</li>
                            <!-- Facebook -->
                            <li v-if="about.four_btntext != '' || about.four_btntext != null">
                                <a :href="`${about.four_btntext}`" target="_blank">
                                    <i class="fa fa-facebook-square"></i>
                                </a>
                            </li>
                            <!-- Instagram -->
                            <li v-if="about.five_btntext != '' || about.five_btntext != null">
                                <a :href="`${about.five_btntext}`" target="_blank">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <!-- Linkedin -->
                            <li v-if="about.linkedin != null">
                                <a :href="`${about.linkedin}`" target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <!-- Twitter -->
                            <li v-if="about.twitter != null">
                                <a :href="`${about.twitter}`" target="_blank">
                                    <i class="fa fa-twitter-square"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </section>
                <!-- Bottom Cards - Follow Us End -->

            </div>
        </div>

        <!-- Skeleton Loading for about us -->
        <div v-else>
            <about-skeleton />
        </div>

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import aboutSkeleton from '../Skeletons/About.vue';

    export default {

        name: 'about_us',

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            aboutSkeleton
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                aboutUs: [],
                meta: {
                    name: 'About Us',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.mainUser.fname + 'Courses' + ' | ' + this.settings.project_title
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

            // Call the about us api (this function will be called by default on the call of this component)
            async callAPI() {

                await axios.get(`/api/aboutus?secret=${this.$secretKey}`)
                    .then(res => {

                        this.aboutUs = res.data.about;
                        this.loading = false;

                    })
                    .catch(err => {
                        console.log(err.response);
                    });
            }

        },

        mounted() {
            this.path = axios.defaults.baseURL;
            this.callAPI();
        }
    }
</script>