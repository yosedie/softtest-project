<template>
    <div>

        <header-section />

        <!-- terms section start -->
        <section class="terms pb-100 pt-100">
            <div class="container">

                <!-- Page Title -->
                <h1 class="mb-5 text-center">
                    {{currentPage.title}}
                </h1>

                <!-- Page Details -->
                <div class="row" v-if="!loading">
                    <div class="col-12 col-md-12">
                        <div class="terms-content mt-4 mt-md-0" id="account">
                            <p v-html="currentPage.details"> </p>
                        </div>
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
    import EventBus from '../../EventBus.js';

    export default {

        name: 'page_detail',

        mixins: [mixin],

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                getPages: [],
                currentPage: {},
                page_id: this.$route.params.id,
                meta: {
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
                title: `${this.currentPage.title ?? 'Page'} | ${this.settings.project_title ?? 'Loading...'}`,
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

            // To reset the data if api's are call from the same location
            reset()
            {
                this.currentPage = {}
            },

            // Call the all pages widget API's (this function will be called by default on the load of this component)
            async callAPI() 
            {
                // All pages data
                await axios.get(`/api/all/pages?secret=${this.$secretKey}`)
                .then(res => 
                {        
                    this.reset();
                    this.getPages = res.data.pages;
                    this.getPages.forEach(page => {
                        if (page.id == this.page_id) {
                            this.currentPage = page;
                            this.loading = false;
                            return;
                        }
                    });
                    this.loading = false;

                })
                .catch(err => 
                {
                    this.loading = false;
                    console.log(err.response);
                });
            }
        },

        mounted() 
        {
            this.path = axios.defaults.baseURL;

            // To get category id without reload if location is similar
            EventBus.$on('page', (id) => 
            {
                this.page_id = id;
                this.loading = true,
                this.callAPI();
            });
            this.callAPI();
        }
    }
</script>