<template>
    <div>
        <!-- slider facts section start -->
        <section class="popular-course" v-if="sliderfactsLength > 0">
            <div class="container">
                <div class="course-creative">
                    <div class="row" v-if="!loading">
                        <div class="col-12 col-md-4" v-for="(sliderfact,index) in sliderfacts" :key="index">
                            <div class="title">
                                <i :class="`fa ${sliderfact.icon}`"></i>
                                <h2>{{sliderfact.heading}}</h2>
                                <p>{{sliderfact.sub_heading}}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Skeleton loading till we get the data -->
                    <div class="row" v-else>
                        <div class="col-12 col-md-4" v-for="(loop,index) in loops" :key="index">
                            <b-skeleton-img></b-skeleton-img>
                            <b-skeleton class="mt-2"></b-skeleton>
                            <b-skeleton></b-skeleton>
                            <div class="hide">{{loop+1}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider facts section end -->
    </div>
</template>

<script>
    "use Strict";
    
    export default {
        
        data() {
            return {
                loop: 0,
                loops: 3,
                baseurl: baseurl,
                sliderfacts: [],
                sliderfactsLength: 0,
                slider: {},
                loading: true
            }
        },

        methods: {

            // Call home api to get slider facts(this api will be called by default on the call of the component)
            async callAPI() {

                await axios.get('/api/home?secret=' + this.$secretKey)
                .then(res => {
                    
                    this.sliderfacts = res.data.sliderfacts;
                    this.sliderfactsLength = res.data.sliderfacts.length;
                    this.loading = false;

                })
                .catch(err => {

                    console.log(err.response);
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