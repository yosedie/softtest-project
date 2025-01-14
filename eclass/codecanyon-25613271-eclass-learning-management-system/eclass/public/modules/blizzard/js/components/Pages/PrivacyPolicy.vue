<template>
    <div>

        <header-section />

        <!-- terms section start -->
        <section class="terms pb-100 pt-100">
            <div class="container">
                <h1 class="mb-5 text-center">
                    {{ translate('frontstaticword.PrivacyPolicy')}}
                </h1>
                <div class="row" v-if="!loading">
                    <div class="col-12 col-md-12" v-if="terms.length">
                        <div class="terms-content mt-4 mt-md-0" id="account" v-for="(term,index) in terms" :key="index">
                            <p v-html="term.policy"> </p>
                        </div>
                    </div>

                    <!-- If user have no data -->
                    <div class="margin_0_auto bg-light pd-50 b-50" v-else>
                        <h4>
                            {{ translate('frontstaticword.Youhavenodata')}}
                        </h4>
                    </div>
                </div>

                <!-- Skeleton Loading till we fetch data from API -->
                <div v-else>
                    <page-skeleton />
                </div>
            </div>
        </section>
        <!-- terms section ending-->

        <footer-section />
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import pageSkeleton from '../Skeletons/Pages.vue';

    export default {

        mixins: [mixin],

        data() {
            return {
                terms: [],
                baseurl: baseurl,
                loading: true,
                meta: {
                    name: 'Privacy Policy',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        components: {
            headerSection,
            footerSection,
            pageSkeleton
        },

        // SEO Meta title and meta data
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'}`,
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

            // API to get policy data fom API
            async callAPI() {

                await axios.get('/api/terms_policy?secret=' + this.$secretKey)
                    .then(res => {

                        this.terms = res.data.terms_policy;
                        this.loading = false;

                    })
                    .catch(err => {
                        console.log(err.response);
                        this.loading = false;
                    });

            }
        },

        mounted() {

            this.callAPI();

        }

    }
</script>