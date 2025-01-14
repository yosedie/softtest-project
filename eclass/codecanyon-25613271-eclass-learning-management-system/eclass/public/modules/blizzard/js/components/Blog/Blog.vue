<template>
    <div>

        <header-section />

        <!-- blog list start -->
        <section class="blog-list">

            <!-- Heading Section -->
            <div class="blog-header">
                <div class="blog-title">
                    <h1>
                        {{ translate('frontstaticword.BLOGS')}}
                    </h1>
                    <h6 class="text-white">
                        {{ translate('frontstaticword.OURSTORY')}}
                    </h6>
                </div>
            </div>

            <!--Blogs  -->
            <div class="container">
                <div class="row course-tabs pb-100 mt-70" v-if="!loading">
                    <div class="col-md-6 col-12 mb-20" v-for="(blog,index) in allBlogs" :key="index">
                        <div class="card mb-4">

                            <!-- Blog Image -->
                            <div class="position-relative">
                                <router-link :to="'/blog_detail/'+ blog.id + '/' + blog.heading">
                                    <img 
                                        :src="`${path}/images/blog/${blog.image}`" 
                                        class="blog-card-img" 
                                        :alt="translate('frontstaticword.blogimage')">
                                </router-link>
                            </div>

                            <div class="p-x">
                                <router-link :to="'/blog_detail/'+ blog.id + '/' + blog.heading">
                                    <div class="card-body py-3">
                                        <!-- Blog Title -->
                                        <h5 class="card-title mt-4">
                                            {{blog.heading}}
                                        </h5>

                                        <!-- Blog detail -->
                                        <p class="card-text" v-html="blog.detail.length>400 ? blog.detail.substring(0,400)+'..' : blog.detail"></p>
                                        
                                        <!-- Last Updated at -->
                                        <p>
                                            <strong>{{ translate('frontstaticword.LastUpdated')}}:</strong> 
                                            {{ moment(blog.updated_at).format("dddd, MMMM Do YYYY") }}
                                        </p>
                                    </div>
                                </router-link>

                                <!-- View Blog -->
                                <div class="start-btn text-center">
                                    <router-link :to="'/blog_detail/'+ blog.id + '/' + blog.heading" tabindex="0">
                                        {{ translate('frontstaticword.ViewDetails')}}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skeleton loading till api fetch blogs -->
                <div class="course-tabs pb-100 mt-70" v-else>
                    <blog-skeleton />
                </div>
            </div>
        </section>
        <!-- blog list end -->

        <footer-section />
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import blogSkeleton from '../Skeletons/Blog.vue';

    export default {

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            blogSkeleton
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                allBlogs: [],
                loading: true,
                meta: {
                    name: 'Blogs',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // SEO data , meta tag and meta title details
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.meta.name + ' Quiz | ' + this.settings.project_title
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

            // Call API to get all blogs
            async callAPI() {

                await axios.get('/api/blog?secret=' + this.$secretKey)
                .then(res => {

                    this.allBlogs = res.data.blog;
                    this.loading = false;

                })
                .catch(err=> { 

                    console.log(err.response) ;
                    this.loading = false;

                });

            }

        },

        mounted() {

            this.path = axios.defaults.baseURL;
            this.callAPI();

        }
    }
</script>