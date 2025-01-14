<template>
    <div>
        
        <header-section />

        <!-- SubCategory Section -->
        <div v-if="!loadingCourses">
            <section id="categories" class="categories-main-block" v-if="subCatgeories.length > 0">
                <div class="container">
                    <h4 class="categories-heading">
                        {{ translate('frontstaticword.SubCategories')}}
                        ({{subCatgeories.length}})
                    </h4>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6" v-for="(item,index) in subCatgeories" :key="index">
                            <div class="categories-block">
                                <ul>
                                    <li>
                                        <a @click="call_sub_category(item.id,item.title)" title="Web Design"><i :class="`fa ${item.icon}`"></i></a>
                                    </li>
                                    <li><a @click="call_sub_category(item.id,item.title)">{{item.title}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Skeleton loading for sub-child categories -->
        <section class="categories-main-block" v-else>
            <div class="container">
                <b-skeleton height="40px" width="30%"></b-skeleton>
                <div class="row">
                    <div class="col-md-3" v-for="(loop,index) in loops" :key="index">
                        <b-skeleton-img no-aspect height="50px"></b-skeleton-img>
                    </div>
                </div>
            </div>
        </section>

        <!-- Child Categories Section -->
        <section id="categories" class="categories-main-block" v-if="childCategories.length > 0">
            <div class="container">
                <h4 class="categories-heading">
                    {{ translate('frontstaticword.ChildCategories')}}
                    ({{childCategories.length}})
                </h4>

                <div class="row">
                    <div class="col-lg-3 col-sm-6" v-for="(item,index) in childCategories" :key="index">
                        <div class="categories-block">
                            <ul>
                                <li>
                                    <a @click="call_child_category(item.id, item.title)" title="Web Design">
                                        <i :class="`fa ${item.icon}`"></i>
                                    </a>
                                </li>
                                <li>
                                    <a @click="call_child_category(item.id, item.title)">{{item.title}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Courses and Filters -->
        <section id="categories-popularity" class="categories-popularity-main-block category-filters">
            <div class="container">
                <h2 class="categories-popularity-heading">
                    {{title.en}} 
                    {{ translate('frontstaticword.Courses')}}
                </h2>

                <!-- Top Bar (filter-pagination) -->
                <div class="row">
                    <!-- Filter Sorting -->
                    <div class="col-lg-8 col-md-7">
                        
                    </div>

                    <!-- Pagination -->
                    <div class="col-lg-4 col-md-5">
                        <nav>
                            <ul class="pagination float-right">
                                <li class="page-item" :class="{'disabled' : !pagination.prev_page_url}">
                                    <a role="button" @click="categoryDetail(+pagination.currentpage-1)" class="page-link"
                                        tabindex="-1" aria-disabled="true">
                                        {{ translate('frontstaticword.Previous')}}
                                    </a>
                                </li>

                                <li class="page-item" aria-current="page">
                                    <a class="page-link" disabled="disabled">
                                        {{pagination.currentpage}}
                                        {{ translate('frontstaticword.of')}}
                                        {{ pagination.lastpage }}
                                    </a>
                                </li>

                                <li class="page-item" :class="{'disabled' : !pagination.next_page_url}">
                                    <a role="button" @click="categoryDetail(+pagination.currentpage + 1)"
                                        class="page-link">
                                        {{ translate('frontstaticword.Next')}}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 col-md-4">
                        <div id="accordian">
                            <!-- Categories section -->
                            <div class="card">
                                <div class="card-header" data-toggle="collapse" href="#collapseOne"
                                    data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                                    <a class="card-title">
                                        {{ translate('frontstaticword.Categories')}}
                                    </a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="">
                                    <div class="card-body">
                                        <div class="wrapper-two center-block">

                                            <!-- Show categories -->
                                            <div class="panel-group mb-3" id="accordion" role="tablist"
                                                aria-multiselectable="true" v-for="(category,index) in get_categories" :key="index">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading active" role="tab" :id="`headingOne${category.id}`">
                                                        <h4 class="panel-title">
                                                            <a 
                                                                role="button" 
                                                                data-toggle="collapse"
                                                                data-parent="#accordion" 
                                                                :href="`#collapseOne${category.id}`"
                                                                aria-expanded="false" 
                                                                :aria-controls="`collapseOne${category.id}`"
                                                            >
                                                                <i :class="`fa ${category.icon}`"></i>
                                                                <label 
                                                                    class="prime-cat" 
                                                                    data-url="#" 
                                                                    @click="call_category(category.id,category.title.en)"
                                                                >
                                                                    {{category.title.en}}
                                                                </label>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div :id="`collapseOne${category.id}`"
                                                        class="subcate-collapse panel-collapse collapse in"
                                                        role="tabpanel" :aria-labelledby="`headingOne${category.id}`">
                                                        <div class="panel-body">

                                                            <!-- Show sub categories -->
                                                            <div class="panel panel-default" v-for="(sub_category,id) in category.subcategory" :key="id">
                                                                <div class="panel-heading" role="tab"
                                                                    :id="`headingeleven${sub_category.id}`">
                                                                    <h4 class="panel-title panel-title-one">
                                                                        <a 
                                                                            class="collapsed" role="button"
                                                                            data-toggle="collapse"
                                                                            data-parent="#accordion"
                                                                            :href="`#collapseeleven${sub_category.id}`"
                                                                            aria-expanded="false"
                                                                            :aria-controls="`collapseeleven${sub_category.id}`"
                                                                        >
                                                                            <i :class="`fa ${sub_category.icon}`"></i>
                                                                            <label 
                                                                                class="sub-cate" 
                                                                                data-url="#" 
                                                                                @click="call_sub_category(sub_category.id,sub_category.title)"
                                                                            >
                                                                                {{sub_category.title}}
                                                                            </label>
                                                                        </a>
                                                                    </h4>
                                                                </div>

                                                                <!-- Show Child Categories -->
                                                                <div 
                                                                    :id="`collapseeleven${sub_category.id}`"
                                                                    class="panel-collapse collapse mb-2" 
                                                                    role="tabpanel"
                                                                    :aria-labelledby="`headingeleven${sub_category.id}`"
                                                                >
                                                                    <div class="panel-body sub-cat" v-for="(child_category,unique) in sub_category.childcategory" :key="unique">
                                                                        <i :class="`fa ${child_category.icon}`"></i>
                                                                        <label class="child-cate" data-url="#">
                                                                            <a @click="call_child_category(child_category.id,child_category.title)">
                                                                                {{child_category.title}}
                                                                            </a>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!-- End Child Categories -->
                                                            </div>
                                                            <!-- End Sub Categories -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End categories -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo"
                                    data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                                    <a class="card-title">
                                        {{ translate('frontstaticword.Price')}}
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse show" data-parent="">
                                    <div class="card-body">
                                        <div class="categories-tags">
                                            <div class="categories-content-one">
                                                <div class="categories-tags-content-one">
                                                    <ul>
                                                        <!-- Paid -->
                                                        <li>
                                                            <div class="form-check form-check-inline">
                                                                <b-form-group v-slot="{ ariaDescribedby }">
                                                                    <b-form-radio 
                                                                        v-model="price" 
                                                                        :aria-describedby="ariaDescribedby" 
                                                                        name="some-radios" 
                                                                        value="paid"
                                                                        @change="categoryDetail"
                                                                        class="text-dark"
                                                                    >
                                                                        {{ translate('frontstaticword.Paid')}}
                                                                    </b-form-radio>
                                                                </b-form-group>
                                                            </div>
                                                        </li>
                                                        <!-- Free -->
                                                        <li>
                                                            <div class="form-check form-check-inline">
                                                                <b-form-group v-slot="{ ariaDescribedby }">
                                                                    <b-form-radio 
                                                                        v-model="price" 
                                                                        :aria-describedby="ariaDescribedby" 
                                                                        name="some-radios" 
                                                                        value="free"
                                                                        @change="categoryDetail"
                                                                        class="text-dark"
                                                                    >
                                                                        {{ translate('frontstaticword.Free')}}
                                                                    </b-form-radio>
                                                                </b-form-group>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo"
                                    data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                                    <a class="card-title">
                                        {{ translate('frontstaticword.Languages')}}
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse show" data-parent="">
                                    <div class="card-body">
                                        <div class="categories-tags">
                                            <div class="categories-content-one">
                                                <div class="categories-tags-content-one">
                                                    <ul v-for="(language,ln) in courseLanguages" :key="ln">
                                                        <li>
                                                            <div class="form-check form-check-inline">
                                                                <b-form-group v-slot="{ ariaDescribedby1 }">
                                                                    <b-form-radio 
                                                                        v-model="languageID" 
                                                                        :aria-describedby1="ariaDescribedby1" 
                                                                        name="some-radios" 
                                                                        :value="language.id"
                                                                        @change="categoryDetail"
                                                                        class="text-dark"
                                                                    >
                                                                        {{language.name.en}}
                                                                    </b-form-radio>
                                                                </b-form-group>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Courses -->
                    <div class="col-lg-9 col-md-8" v-if="!loadingCourses">
                        <div class="students-bought" v-if="courseData.length > 0">
                            <div class="course-bought-block protip" data-pt-placement="outside"
                                data-pt-interactive="false" data-pt-title="#prime-next-item-description-block1" v-for="(course,index) in courseData" :key="index">
                                <div class="row">

                                    <!-- Course image -->
                                    <div class="col-lg-4 col-md-4">
                                        <router-link :to="{name: 'course_detail', params: {id: course.id, title: course.title.replace(/\s+/g, '_')}}">
                                            <img
                                                :src="`${path}/images/course/${course.preview_image}`"
                                                :alt="translate('frontstaticword.course')" class="img-fluid">
                                        </router-link>
                                    </div>

                                    <div class="col-lg-6 col-md-5">
                                        <div class="categories-popularity-dtl">
                                            <div class="view-heading">
                                                <router-link :to="{name: 'course_detail', params: {id: course.id, title: course.title.replace(/\s+/g, '_')}}">
                                                    {{course.title}}
                                                </router-link>
                                            </div>
                                            <p v-html="course.short_detail"> </p>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3">
                                        <div class="rate text-right">
                                            <ul>
                                                <li class="rate-r" v-if="course.discount_price">
                                                    {{currency.icon}}
                                                    {{course.discount_price}} &nbsp;
                                                    <s>
                                                        {{currency.icon}}
                                                        {{course.price}}
                                                    </s> 
                                                </li>
                                                <li class="rate-r" v-if="course.discount_price == null && course.price != null">
                                                    {{currency.icon}}
                                                    {{course.price}}
                                                </li>
                                                <li class="rate-r" v-if="course.discount_price == null && course.price == null">
                                                    {{ translate('frontstaticword.FREE')}}
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                            </div>
                        </div>

                        <!-- If category have no courses -->
                        <div class="students-bought text-center bg-color-pink padd--20" v-else>
                            <h4 class="mb-4"> 
                                <span class="text-info"> {{this.category_name}} </span> 
                                {{ translate('frontstaticword.Categoryhavenocourses')}}!
                            </h4>
                            <img :src="`${baseurl}/modules/blizzard/images/empty_category_concept.jpg`" :alt="translate('frontstaticword.emptycategory')">
                        </div>
                    </div>

                    <!-- Show skeleton loading till we fetch data of courses  -->
                    <div class="col-lg-9" v-else>
                        <filter-skelton />
                    </div>
                </div>
            </div>
        </section>
        <!-- Courses and Filters ended -->

        <footer-section />

    </div>    
</template>

<script>
    "use Strict";
    
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import mixin from '../../mixin.js';
    import EventBus from '../../EventBus.js';
    import FilterSkelton from '../Skeletons/filter.vue';
    import userCoursesSkeleton from '../Skeletons/UserCourses.vue';

    export default {

        name: 'single_category_detail',

        mixins: [mixin],

        data() 
        {
            return {
                baseurl: baseurl,
                path: null,
                get_categories: [],
                loop: 0,
                loops:4,
                category_id: this.$route.params.id,
                category_name: this.$route.params.title,
                category_type: this.$route.params.category_type, 
                subCatgeories: [],
                childCategories: [],
                title: {},
                courses: {},
                courseData: [],
                loadingCourses: true,
                price: '',
                courseLanguages: [],
                languageID: 0,
                sort: '',
                pagination: {

                },
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        components: {
            headerSection,
            footerSection,
            FilterSkelton,
            userCoursesSkeleton
        },

        // SEO data and meta tags
        metaInfo() {
            return {
                title: `${this.category_name ?? 'Category'} | ${this.settings.project_title ?? "Loading..."}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.category_name + ' Quiz | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {

            // To reset the data if api's are call from the same location
            reset() {  
                this.subCatgeories = [],
                this.childCategories = [],
                this.title = {},
                this.courses = {},
                this.courseData = [],
                this.pagination = {
                }
            },

            // this api will be call by default - check category type (category, sub, child)
            callAPI(){

                this.courselanguages();
                
                this.get_all_categories();
                if(this.category_type == 'category')
                {   
                    this.reset();
                    this.categoryDetail(this.pagination.currentpage ? this.pagination.currentpage + 1 : 1);
                }
                if(this.category_type == 'sub_category')
                {
                    this.reset();
                    this.sub_categoryDetail(this.pagination.currentpage ? this.pagination.currentpage + 1 : 1);
                }
                if(this.category_type == 'child_category')
                {
                    this.reset();
                    this.child_categoryDetail(this.pagination.currentpage ? this.pagination.currentpage + 1 : 1);
                }
            },

            // Call API for the specific category detail
            async categoryDetail(page) {
                
                page = page ?? 1;

                // Change price parameter in url
                if(this.price != '')
                {
                    if( window.location.search != '')
                    {
                        const url = new URL(window.location);
                        url.searchParams.set('price', this.price);
                        window.history.pushState({}, '', url);
                    }
                    else
                    {
                        this.$router.push(`/category_detail/${this.category_type}/${this.category_id}/${this.category_name}?price=${this.price}`);
                    }
                    
                }

                // Change language parameter in url
                if(this.languageID != 0)
                {
                    if( window.location.search!='')
                    {
                        const url = new URL(window.location);
                        url.searchParams.set('language', this.languageID);
                        window.history.pushState({}, '', url);
                    }
                    else
                    {
                        this.$router.push(`/category_detail/${this.category_type}/${this.category_id}/${this.category_name}?language=${this.languageID}`);
                    }
                }
                
                let apiData = {
                    params: {
                        secret: this.$secretKey,
                        page: page,
                        type: this.price,
                        language: this.languageID
                    }
                }
                
                await axios.get(`/api/category/${this.category_id}/${this.category_name}`,apiData)
                .then(res=> 
                {
                    this.loadingCourses = false;
                    this.subCatgeories = res.data.subcategory;
                    this.title = res.data.title;
                    this.courses = res.data.course;
                    this.courseData = this.courses.data;
                    this.pagination = {
                        currentpage: res.data.course.current_page,
                        lastpage: res.data.course.last_page,
                        totalcourse: res.data.course.to,
                        prev_page_url: res.data.course.prev_page_url,
                        next_page_url: res.data.course.next_page_url
                    }

                }).catch(err=> 
                { 
                    console.log(err.response); 
                    this.loadingCourses = false;
                });
            },

            // Call API for the specific sub category detail
            async sub_categoryDetail(page) 
            {
                page = page ?? 1;

                await axios.get(`/api/subcategory/${this.category_id}/${this.category_name}?secret=${this.$secretKey}&page=${page}`)
                .then(res=> 
                {    
                    this.loadingCourses = false;
                    this.childCategories = res.data.childcategory;
                    this.title = res.data.title;
                    this.courses = res.data.course;
                    this.courseData = this.courses.data;
                    this.pagination = {
                        currentpage: res.data.course.current_page,
                        lastpage: res.data.course.last_page,
                        totalcourse: res.data.course.to,
                        prev_page_url: res.data.course.prev_page_url,
                        next_page_url: res.data.course.next_page_url
                    }
                })
                .catch(err=> 
                { 
                    console.log(err.response); 
                    this.loadingCourses = false;
                });
            },

            // Call API for the specific child category detail
            async child_categoryDetail(page)
            {
                page = page ?? 1;

                await axios.get(`/api/childcategory/${this.category_id}/${this.category_name}?secret=${this.$secretKey}&page=${page}`)
                .then(res=> {
                    
                    this.loadingCourses = false;
                    this.title = res.data.title;
                    this.courses = res.data.course;
                    this.courseData = this.courses.data;
                    this.pagination = {
                        currentpage: res.data.course.current_page,
                        lastpage: res.data.course.last_page,
                        totalcourse: res.data.course.to,
                        prev_page_url: res.data.course.prev_page_url,
                        next_page_url: res.data.course.next_page_url
                    }

                })
                .catch(err=> 
                {
                    console.log(err.response);
                    this.loadingCourses = false;
                });
            },

            //call categories from the same component
            call_category(id,title) 
            {
                this.category_type = 'category';
                this.category_id = id;
                this.category_name = title;
                this.loadingCourses = true,
                this.$router.push(`/category_detail/category/${id}/${title}`);
                this.callAPI();
            },

            //call sub categories from the same component
            call_sub_category(id,title) 
            {
                this.category_type = 'sub_category';
                this.category_id = id;
                this.category_name = title;
                this.loadingCourses = true,
                this.$router.push(`/category_detail/sub_category/${id}/${title}`);
                this.callAPI();
            },

            //call child categories from the same component
            call_child_category(id,title) 
            {
                this.category_type = 'child_category';
                this.category_id = id;
                this.category_name = title;
                this.loadingCourses = true,
                this.$router.push(`/category_detail/child_category/${id}/${title}`);
                this.callAPI();
            },

            // Get all categories of courses
            async get_all_categories() {
                await axios.get('/api/home?secret=' + this.$secretKey)
                .then(res  => 
                {
                    this.get_categories = res.data.allcategory;
                });
            },

            // Get all languages courses available in
            async courselanguages() {

                let apiData = {
                    params:{
                        secret: this.$secretKey
                    }
                }

                await axios.get(`/api/courselanguage`,apiData)
                .then(res=> 
                {
                    this.courseLanguages = res.data.language;
                })
                .catch(err=> 
                { 
                    console.log(err.response);
                });
            }
        
        },

        mounted() {

            this.path = axios.defaults.baseURL;
            // To get category id without reload if location is similar
            EventBus.$on('category', (category_type,id,title) => {
                this.category_type = category_type;
                this.category_id = id;
                this.category_name = title;
                this.loadingCourses = true,
                this.callAPI();
            });
            this.callAPI();
            
        }
    }

</script>