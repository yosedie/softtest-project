<template>
    <div>

        <header-section />

        <!-- Leadership: Practical Leadership start -->
        <div class="blog-header" v-if="blog.heading">
            <div class="blog-title">
                <h1>{{ blog.heading }}</h1>
            </div>
        </div>

        <section class="course-features">
            <div class="container">
                <div class="row mb-4" v-if="!loadingBlogs">

                    <!-- About Blog -->
                    <div class="col-12 col-md-8 mt-50">

                        <!-- Blog title -->
                        <div class="features-title" v-if="blog.heading">
                            <h3>{{ blog.heading }}</h3>
                        </div>

                        <div class="course-meta">
                            <ul>
                                <!-- Blog Author -->
                                <li class="author">
                                    <div class="thumb">
                                        <img class="mr-3" :src="`${baseurl}/modules/blizzard/images/user_default.jpg`" alt="image">
                                    </div>

                                    <div class="text mr-5">
                                        <router-link :to="'/instructor_detail/'+ instructor.id + '/' + instructor.fname">
                                            {{instructor.fname}} {{instructor.lname}}
                                        </router-link>
                                        <p>
                                            {{ translate('frontstaticword.Instructor')}}
                                        </p>
                                    </div>
                                </li>

                                <!-- Updated at -->
                                <li class="categories">
                                    <a class="course-name">{{ blog.text }}</a>
                                    <p>
                                        {{ translate('frontstaticword.Updatedat')}}: 
                                        {{ moment(blog.updated_at).format("dddd, MMMM Do YYYY") }}
                                    </p>
                                </li>
                            </ul>
                        </div>

                        <!-- Blog Image -->
                        <div class="course-img">
                            <img :src="blog.image != null ? `${path}/images/blog/${blog.image}` : `${baseurl}/modules/blizzard/images/3125988.jpg`">
                        </div>

                        <!-- Blog Detail -->
                        <div class="row mb-4">
                            <div class="entry-content mt-50 col-12" v-html="blog.detail">

                            </div>
                        </div>
                    </div>

                    <!-- Recent Blog -->
                    <div class="col-12 col-md-4">

                        <!-- recent blog start -->
                        <div class="course-categories">
                            <div class="course-details-list mt-50 border-0 pt-0">
                                <h4 class="course-title">
                                    {{ translate('frontstaticword.RecentBlogsCapital')}}
                                </h4>

                                <!-- Blog Title -->
                                <ul>
                                    <li v-for="(recent,index) in recentBlogs" :key="index">
                                        <a @click="goToBlog(recent.id,recent.heading)">
                                            {{recent.heading}}
                                        </a>
                                    </li>
                                </ul>

                                <!-- View all blogs -->
                                <router-link to="/blogs" class="btn btn-danger mt-4">
                                    {{ translate('frontstaticword.ViewallBlogs')}}
                                </router-link>
                            </div>
                        </div> 
                        <!-- recent blog start -->

                    </div>
                </div>

                <!-- Skeleton loading till we get blog detail from api -->
                <div v-else>
                    <blog-detail-skeleton />
                </div>

            </div>
        </section>

        <footer-section />
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import blogDetailSkeleton from '../Skeletons/BlogDetail.vue';

    export default {

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            blogDetailSkeleton
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                blog: {},
                recentBlogs: [],
                loadingBlogs: true,
                blog_heading: this.$route.params.title,
                blog_id: this.$route.params.id,
                instructor: {},
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Get SEO data and meta tag-titles
        metaInfo() {
            return {
                title: `${this.blog_heading ?? 'Blog'} | ${this.settings.project_title ?? 'Loading...'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.blog_heading + ' Quiz | ' + this.settings.project_title
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

            // CAll API to get blog detail
            async callAPI() 
            {
                
                await axios.post('/api/blog/detail?secret=' + this.$secretKey, {

                    blog_id: this.blog_id

                })
                .then(res => {

                    const blogs = res.data.blog;
                    this.blog = res.data.blog[0];
                    this.instructor = res.data.blog[0].user;
                    this.recentBlog();
                    this.loadingBlogs = false;

                })
                .catch(err => { 
                
                    console.log(err);
                    this.loadingBlogs = false;

                });
            },

            // Get Recent Blogs
            async recentBlog() {

                await axios.get(`/api/recent/blog?secret=${this.$secretKey}`)
                .then(res=> {

                    this.recentBlogs = res.data.blog;

                })
                .catch(err => { console.log(err) });
            },

            // Go to another blog
            goToBlog(id,title) 
            {
                this.blog_id = id;
                this.$router.push(`/blog_detail/${id}/${title}`);
                this.callAPI();
            }

        },

        mounted() {

            this.callAPI();
            this.path = axios.defaults.baseURL;

        }
    }
</script>