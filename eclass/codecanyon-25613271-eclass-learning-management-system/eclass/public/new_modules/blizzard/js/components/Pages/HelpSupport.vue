<template>
    <div>

        <header-section />

        <!-- FAQ cards -->
        <section class="faq-card-main-block">
            <div class="container">
                <div class="row">

                    <!-- Purchase History -->
                    <div class="col-lg-4 col-md-4">
                        <router-link to="/purchaseHistory">
                            <div class="card">
                                <img :src="`${path}/images/icons/05.png`" class="card-img-top" alt="purchase">
                                <div class="card-body">
                                    <h5 class="faq-card-heading">
                                        {{ translate('frontstaticword.PurchaseHistory')}}
                                    </h5>
                                    <p>
                                        {{ translate('frontstaticword.SeeyourpurchasehistoryexploremoreCourses')}}
                                    </p>
                                </div>
                            </div>
                        </router-link>
                    </div>

                    <!-- User Profile -->
                    <div class="col-lg-4 col-md-4">
                        <router-link to="/myProfile">
                            <div class="card">
                                <img :src="`${path}/images/icons/02.png`" class="card-img-top" alt="profile">
                                <div class="card-body">
                                    <h5 class="faq-card-heading">
                                        {{ translate('frontstaticword.UserProfile')}}
                                    </h5>
                                    <p>
                                        {{ translate('frontstaticword.VisitandManageyouraccountsettings')}}
                                    </p>
                                </div>
                            </div>
                        </router-link>
                    </div>

                    <!-- Contact Us -->
                    <div class="col-lg-4 col-md-4">
                        <router-link to="/contact_us">
                            <div class="card bg-color">
                                <img :src="`${path}/images/icons/contact.png`" class="card-img-top" alt="contact">
                                <div class="card-body">
                                    <h5 class="faq-card-heading text-white">
                                        {{ translate('frontstaticword.Contactus')}}
                                    </h5>
                                    <p class="text-white">
                                        {{ translate('frontstaticword.OpenaSupportTicket')}}
                                    </p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Help and Support section start -->
        <section class="faq-main-block mb-4">
            <div class="container" v-if="!loading">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" v-if="userFaqs.length">
                        <a 
                            class="nav-link active" 
                            id="home-tab" 
                            data-toggle="tab" 
                            href="#home" 
                            role="tab" 
                            aria-controls="home" 
                            aria-selected="true"
                        >
                            {{ translate('frontstaticword.StudentsFAQ')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            {{ translate('frontstaticword.InstructorFAQ')}}
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- User FAQ's -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h2 class="tab-heading">
                            {{ translate('frontstaticword.faq')}}
                        </h2>
                        
                        <div id="accordion" class="myaccordion">
                            <div class="card" v-for="(userFaq,index) in userFaqs" :key="index">
                                <div class="card-header" id="headingthree">
                                    <h2 class="mb-0">
                                        <button class="accordion-button btn btn-link collapsed" data-toggle="collapse" :data-target="'#accordian-' + userFaq.id" aria-expanded="false" aria-controls="collapsethree">
                                            {{userFaq.title}}
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div :id="'accordian-' + userFaq.id" class="collapse" aria-labelledby="headingthree" data-parent="#accordion">
                                    <div class="card-body">
                                        <p v-html="userFaq.details"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor FAQ's -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h2 class="tab-heading">
                            {{ translate('frontstaticword.faq')}}
                        </h2>
                        <div id="accordion" class="myaccordion">

                            <div class="card" v-for="(instructorFaq,index) in instructorFaqs" :key="index">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="accordion-button btn btn-link collapsed" data-toggle="collapse" :data-target="'#accordianI-' + instructorFaq.id" aria-expanded="false" aria-controls="collapseOne">
                                            {{instructorFaq.title}} 
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div :id="'accordianI-' + instructorFaq.id" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <p v-html="instructorFaq.details"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Skeleton loading for FAQ -->
            <div class="container" v-else>
                <div class="card" v-for="(loop,index) in loops" :key="index">
                    <div class="card-header">
                        <b-skeleton></b-skeleton>
                    </div>
                </div>
            </div>
        </section>
        <!-- Help and Support section end -->

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';

    export default {

        name: 'helpSupport',

        mixins: [mixin],

        data() {
            return {
                baseurl: baseurl,
                path: null,
                userFaqs: [],
                loop: 0,
                loops: 5,
                loading: true,
                instructorFaqs: [],
                meta: {
                    name: 'Help & Support',
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

        components: {
            headerSection,
            footerSection
        },

        methods: 
        {

            // Call api to get faq data
            async callAPI() 
            {
                let apiData = 
                {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }

                // User FAQ API
                await axios.get('/api/user/faq', apiData)
                .then(res => 
                {
                    this.userFaqs = res.data.faq;
                    this.loading = false;

                })
                .catch(err => 
                {
                    console.log(err.response);
                    this.loading = false;
                });

                // Instructor FAQ API
                await axios.get('/api/instructor/faq', apiData)
                .then(res => 
                {
                    this.instructorFaqs = res.data.faq;
                    this.loading = false;
                })
                .catch(err => 
                {
                    console.log(err.response);
                    this.loading = false;
                });

            }

        },

        mounted() {

            this.callAPI();
            this.path = axios.defaults.baseURL;

        }

    }
</script>