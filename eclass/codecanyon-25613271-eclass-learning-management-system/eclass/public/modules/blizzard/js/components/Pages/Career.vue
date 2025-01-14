<template>
    <div>

        <header-section />

        <div v-if="!loading">
            <div v-for="(career,index) in careers" :key="index">

                <!-- Section One -->
                <section class="p-y80 bg-light" v-if="career.one_enable == 1">

                    <div class="container">
                        <div class="row">
                            <!-- Content -->
                            <div class="col-md-6">
                                <h1> {{career.one_heading}} </h1>
                                <p> {{career.one_text}} </p>
                                <div class="start-btn">
                                    <a :href="career.three_btntxt ? `${career.three_btntxt}` : '/'" target="_blank">
                                        {{career.one_btntxt}}
                                    </a>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-6">
                                <img :src="`${path}/images/careers/${career.one_video}`" alt="">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section Three -->
                <div v-if="career.three_enable == 1">
                    <section class="pd-100 career-three-main-block" :style="`background-image: url('${path}/images/careers/${career.three_bg_image}'); background-size: cover;`">
                        <div class="container">
                            <div class="row">
                                <!-- Heading -->
                                <div class="pd-50 bg-light col-md-6 career-three-block">
                                    <h1 class="career-three-heading"> {{career.three_heading}} </h1>
                                </div>

                                <!-- Image -->
                                <div class="contact__img col-md-6 plr-none">
                                    <img :src="`${path}/images/careers/${career.three_video}`" alt="image">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Section Four -->
                <section class="career__four__section mb-4" v-if="career.four_enable == 1">
                    <div class="container-fluid pl-none pr-none">
                        
                            <div class="row no-gutters">
                                <div class="col-md-3" v-if="career.four_img_one">
                                    <img :src="`${path}/images/careers/${career.four_img_one}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_two">
                                    <img :src="`${path}/images/careers/${career.four_img_two}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_three">
                                    <img :src="`${path}/images/careers/${career.four_img_three}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_four">
                                    <img :src="`${path}/images/careers/${career.four_img_four}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_fivr">
                                    <img :src="`${path}/images/careers/${career.four_img_fivr}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_six">
                                    <img :src="`${path}/images/careers/${career.four_img_six}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_seven">
                                    <img :src="`${path}/images/careers/${career.four_img_seven}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_eight">
                                    <img :src="`${path}/images/careers/${career.four_img_eight}`" title="img" class="img-fluid">
                                </div>

                                <div class="col-md-3" v-if="career.four_img_nine">
                                    <img :src="`${path}/images/careers/${career.four_img_nine}`" title="img" class="img-fluid">
                                </div>
                            </div>
                        
                    </div>
                </section>
                <!-- Section Four ended -->

                <!-- Section five -->
                <section class="section_five" v-if="career.five_enable == 1">
                    <div class="container">
                        <div class="text-center">
                            <h1>{{career.five_heading}}</h1>
                            <p>{{career.five_text}}</p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-4">

                                <!-- One -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textone!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textone}}</h2>
                                        <p>{{career.five_dtlone}}</p>
                                    </div>
                                </div>

                                <!-- Three -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textthree != '' ">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textthree}}</h2>
                                        <p>{{career.five_dtlthree}}</p>
                                    </div>
                                </div>

                                <!-- Five -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textfive!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textfive}}</h2>
                                        <p>{{career.five_dtlfive}}</p>
                                    </div>
                                </div>

                                <!-- Seven -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textseven!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textseven}}</h2>
                                        <p v-html="career.five_dtlseven"> </p>
                                    </div>
                                </div>

                                <!-- Nine -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textnine!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textnine}}</h2>
                                        <p v-html="career.five_dtlnine"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-4">

                                <!-- Two -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_texttwo!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_texttwo}}</h2>
                                        <p>{{career.five_dtltwo}}</p>
                                    </div>
                                </div>

                                <!-- Four -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textfour!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textfour}}</h2>
                                        <p>{{career.five_dtlfour}}</p>
                                    </div>
                                </div>

                                <!-- Six -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textsix!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textsix}}</h2>
                                        <p>{{career.five_dtlsix}}</p>
                                    </div>
                                </div>

                                <!-- Eight -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_texteight!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_texteight}}</h2>
                                        <p v-html="career.five_dtleight"> </p>
                                    </div>
                                </div>

                                <!-- Ten -->
                                <div class="careers-benefits-dtl-block" v-if="career.five_textten!=''">
                                    <div class="careers-benefits-icon">
                                        <i class="fa fa-fire"></i>
                                    </div>

                                    <div class="careers-benefits-dtl">
                                        <h2>{{career.five_textten}}</h2>
                                        <p v-html="career.five_dtlten"> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section Six -->
                <section class="section__six" v-if="career.six_enable == 1">
                    <div class="container">
                        <!-- Heading -->
                        <div class="text-center mb-30">
                            <!-- Heading -->
                            <h1 v-if="career.six_heading">
                                {{career.six_heading}}
                            </h1>

                            <!-- Content -->
                            <h5 v-if="career.six_text">
                                {{career.six_text}}
                            </h5>
                        </div>

                        <!-- Content -->
                        <div class="row">        
                            <div class="col-md-4 col-6" v-if="career.six_topic_one">
                                <p class=" career__six__list__name">{{career.six_topic_one}}</p>
                            </div>

                            <div class="col-md-4 col-6" v-if="career.six_topic_two">
                                <p class=" career__six__list__name">{{career.six_topic_two}}</p>
                            </div>

                            <div class="col-md-4 col-6" v-if="career.six_topic_three">
                                <p class=" career__six__list__name">{{career.six_topic_three}}</p>
                            </div>

                            <div class="col-md-4 col-6" v-if="career.six_topic_four">
                                <p class=" career__six__list__name">{{career.six_topic_four}}</p>
                            </div>

                            <div class="col-md-4 col-6" v-if="career.six_topic_five">
                                <p class=" career__six__list__name">{{career.six_topic_five}}</p>
                            </div>

                            <div class="col-md-4 col-6" v-if="career.six_topic_six">
                                <p class=" career__six__list__name">{{career.six_topic_six}}</p>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Section Six ended -->

            </div>

        </div>

        <!-- Skeleton loading till api fetch the data -->
        <div v-else>
            <career-skeleton />
        </div>

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import mixin from '../../mixin.js';
    import careerSkeleton from '../Skeletons/Career.vue';
    
    export default 
    {

        mixins: [mixin],

        components: 
        {
            headerSection,
            footerSection,
            careerSkeleton
        },

        data() 
        {
            return{
                baseurl: baseurl,
                careers: [],
                path: null,
                loading: true,
                meta: {
                    name: 'Career',
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
                    { property: 'og:title', content: this.mainUser.fname + 'Courses' + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {

            // Call career api to get data (function will be call by defualt on the call of component)
            async callAPI()
            {
                await axios.get('/api/career?secret=' + this.$secretKey)
                .then(res=> 
                {
                    this.careers = res.data.career;
                    this.loading = false;
                })
                .catch(err=> 
                {
                    console.log(err.response);
                    this.loading = false;
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