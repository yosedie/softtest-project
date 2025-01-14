<template>
    <div>
        <!-- start learning section start -->
        <section class="learnig-section" v-if="!loading">
            <div v-if="getStarted != null">
                <div class="header-banner header-banner1 p-y80" :style="getStarted.image ? `background-image: url('${path}/images/getstarted/${getStarted.image}')` : ''">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-7 align-self-md-center mb-5 mb-lg-0">

                                <!-- Sub Heading -->
                                <p v-if="getStarted.sub_heading">{{getStarted.sub_heading}}</p>
                                
                                <!-- Heading -->
                                <div class="header-title">
                                    <h1 v-if="getStarted.heading">{{getStarted.heading}}</h1>
                                </div>

                                <!-- Button -->
                                <div class="start-btn mb-40" v-if="getStarted.button_txt">
                                    <a :href="getStarted.link!=null ? getStarted.link : ''">
                                        {{getStarted.button_txt}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- start learning section start -->

        <section class="learning-section mt-4" v-else>
            <b-skeleton-img no-aspect height="240px"></b-skeleton-img>
        </section>
    </div>
</template>

<script>
    "use Strict";
    
    export default {

        name: 'getStarted',

        data() 
        {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                getStarted:{}
            }
        },

        methods: {

            // Call home API to get data
            async callAPI() 
            {
                await axios.get('/api/home?secret=' + this.$secretKey)
                .then(res=> 
                {
                    this.loading = false;
                    this.getStarted = res.data.getstarted;
                })
                .catch(err=> 
                { 
                    this.loading = false;
                    console.log(err.response); 
                })
            }
        },

        mounted() 
        {
            this.callAPI();
            this.path = axios.defaults.baseURL;
        }
    }

</script>