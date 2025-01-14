<template>
    <div>

        <header-section />

        <!-- terms section start -->
        <section class="terms pb-100 pt-100">
            <div class="container">
                <h1 class="mb-5 text-center">
                    {{ translate('frontstaticword.Terms&Condition')}}
                </h1>
                <div class="row" v-if="!loading">
                    <div class="col-12 col-md-12" v-if="termsLength > 0">
                        <div class="terms-content mt-4 mt-md-0" id="account" v-for="(term,index) in terms" :key="index">
                            <p v-html="term.terms"> </p>
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
    import  headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import pageSkeleton from '../Skeletons/Pages.vue';

    export default{

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            pageSkeleton  
        },

        data(){
            return {
                terms: [],
                termsLength: 0,
                baseurl: baseurl,
                loading: true,
                meta: {
                    name: 'Terms & Conditions',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // SEO Meta title and meta data
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'}`,
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

            // Call api to get terms condition data
            async callAPI(){

                await axios.get('/api/terms_policy?secret=' + this.$secretKey).then(res => {

                    this.terms = res.data.terms_policy;
                    this.termsLength = res.data.terms_policy.length;
                    this.loading = false;

                });

            }
        },

        mounted(){
            
            this.callAPI();

        }

    }
</script>