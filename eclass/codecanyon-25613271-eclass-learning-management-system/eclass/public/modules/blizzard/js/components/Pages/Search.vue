<template>
    <div>

        <header-section />

        <!-- Search Section -->
        <section class="pd-50 mt-4 text-center">
            <!-- Search Form -->
            <form @submit.prevent>
                <div class="container">
                    <div class="form-group has-search rearch__form">
                        <span class="feather icon-search form-control-feedback"></span>
                        <input v-model="searchTerm" type="text" :placeholder="searchTerm ? searchTerm : translate('frontstaticword.SearchHere')" class="form-control">
                        <br>
                        <span class="text-danger">{{response}}:</span> {{searchTerm}}
                    </div>
                </div>
            </form>
        </section>

        <!-- Courses -->
        <section class="mt-4 mb-4" v-if="!loading">
            <div class="container" v-if="dataLength > 0">
                <div class="row course-tabs">
                    
                    <!-- About search course -->
                    <div class="col-md-12 mb-2 mt-2">
                        <div class="float-left">
                            <h4>
                                {{ translate('frontstaticword.Search')}}
                                <span class="text-warning font--22">{{searchTerm}}</span>
                                {{ translate('frontstaticword.incourses')}}
                            </h4>
                        </div>

                        <!-- Pagination -->
                        <div class="float-right">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" :class="{'disabled' : !pagination.prev_page_url}">
                                        <a role="button" @click="search(+pagination.currentpage-1)" class="page-link"
                                            tabindex="-1" aria-disabled="true">
                                            {{ translate('frontstaticword.Previous')}}
                                        </a>
                                    </li>

                                    <li class="page-item" aria-current="page">
                                        <a class="page-link" disabled="disabled">
                                            {{pagination.currentpage}} of {{ pagination.lastpage }}
                                        </a>
                                    </li>

                                    <li class="page-item" :class="{'disabled' : !pagination.next_page_url}">
                                        <a role="button" @click="search(+pagination.currentpage + 1)"
                                            class="page-link">
                                            {{ translate('frontstaticword.Next')}}
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Search Courses -->
                    <div class="col-lg-4 col-md-6 mb-4" v-for="(course,index) in courses.data" :key="index">
                        <div class="card">
                            <div class="bttn position-relative">

                                <!-- Course Image -->
                                <img 
                                    :src="course.preview_image!=null ? `${path}/images/course/${course.preview_image}` : `${baseurl}/modules/blizzard/images/course_default.png`" 
                                    class="card-img-top" 
                                    alt="course_image">

                                <!-- Level Tag -->
                                <a v-if="course.level_tags!=null">
                                    {{course.level_tags}}
                                </a>
                            </div>
                            <div class="p-x">

                                <!-- Course Detail -->
                                <div class="card-body py-3">
                                    <h5 class="card-title mt-2">
                                        {{course.title.substring(0,30)+'..'}}
                                    </h5>
                                    <p class="card-text" v-html="course.short_detail.substring(0,60)+'..'"> </p>
                                </div>
                                <ul class="list-group list-group-flush inline-block">
                                    <li class="list-group-item pb-3">
                                        
                                        <!-- about instructor -->
                                        <img class="mr-2"
                                            :src="course.user.user_img!=null ? `${path}/images/user_img/${course.user.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`">
                                        <strong>
                                            {{ translate('frontstaticword.By')}} {{course.user.fname}}
                                        </strong>
                                    </li>
                                </ul>

                                <div class="price float-right mr-2">
                                    <!-- If course is discounted -->
                                    <div v-if="course.discount_price != null && course.discount_price != null">
                                        <span>
                                            {{currency.icon}}
                                            {{course.discount_price}} 
                                        </span>
                                        <del>
                                            {{currency.icon}}
                                            {{course.price}}
                                        </del>
                                    </div>

                                    <!-- If course has no discount -->
                                    <div v-if="course.discount_price == null && course.price != null">
                                        <span>
                                            {{currency.icon}}
                                            {{course.price}}
                                        </span>
                                    </div>
                                    
                                    <!-- If course is free -->
                                    <div v-if="course.discount_price == null && course.discount_price == null">
                                        <span>
                                            {{ translate('frontstaticword.FREE')}}
                                        </span>
                                    </div>
                                </div>

                                <!-- Go TO Course -->
                                <div class="start-btn text-center">
                                    <router-link :to="'/course_detail/' + course.id + '/' + course.title.replace(/\s+/g, '_')">
                                        {{ translate('frontstaticword.GoToCourse')}}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- If search have no course match -->
            <div class="container text-center bg-light p-y80 b-50" v-else>
               <h5>
                   {{ translate('frontstaticword.Sorrywehavenomatchforyoursearch')}}: 
                   <span class="text-danger mr-2">{{this.searchTerm}}</span> :/
                </h5>
            </div>
        </section>
        
        
        <!-- Skeleton loading till you get your courses -->
        <section class="mt-70 mb-4" v-else>
            <div class="container">
                <user-courses-skeleton />
            </div>
        </section>

        <footer-section />

    </div>    
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import  headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import EventBus from '../../EventBus.js';
    import UserCoursesSkeleton from '../Skeletons/UserCourses.vue';
    
    export default {

        name: 'search',

        mixins: [mixin],

        data() {
            return {
                path: null,
                baseurl: baseurl,
                searchTerm: '',
                courses: {},
                dataLength: 0 ,
                loading: true,
                pagination: {},
                response: 'Type something in input box to Search',
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Get SEO data and meta tag-titles
        metaInfo() {
            return {
                title: `${this.searchTerm ?? 'Search'} | ${this.settings.project_title ?? 'Loading...'}`,
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

        components: {
            headerSection,
            footerSection,
            UserCoursesSkeleton
        },
            
        watch: {
            searchTerm: function () {
                this.response = "Waiting for you to stop typing"
                this.debouncedSearch()
            }
        },

        created: function () {
            this.debouncedSearch = _.debounce(this.search, 500);
            
        },

        methods: {
            
            // call search api
            async search(page) {

                page = page ?? 1;

                await axios.get(`/api/search?secret=${this.$secretKey}&searchTerm=${this.searchTerm}&page=${page}`)
                .then(res=> {

                    if(res.status == 200)
                    {
                        this.courses = res.data.courses;
                        this.dataLength = res.data.courses.data.length;
                        this.response = 'Press enter to search';
                        this.loading = false;
                        this.pagination = {
                            currentpage: res.data.courses.current_page,
                            lastpage: res.data.courses.last_page,
                            totalcourse: res.data.courses.to,
                            prev_page_url: res.data.courses.prev_page_url,
                            next_page_url: res.data.courses.next_page_url
                        }
                        
                        const url = new URL(window.location.href);
                        url.searchParams.set('searchTerm', this.searchTerm);
                        window.history.pushState({}, '', url);

                    }

                    if(this.dataLength == 0)
                    {
                        this.loading = false;
                        this.response = 'Type something in input box to Search'
                    }

                    if(res.data.status == 'fail')
                    {
                        let config = {
                                text: res.data.message,
                                button: 'CLOSE!'
                        }
                        this.$snack['danger'](config);
                    }

                })
                .catch(err=> { console.log(err.response); })

            },

        },

        mounted() {
            
            this.path = axios.defaults.baseURL;
            if(this.$route.query.searchTerm != '') 
            { 
                this.searchTerm = this.$route.query.searchTerm
            }

            // To get search term without reload if location is similar
            EventBus.$on('header_search', (payload) => {
                this.searchTerm = payload;
                this.search();
            });
            
            this.search(this.pagination.currentpage ? this.pagination.currentpage + 1 : 1);
        }
    }

</script>