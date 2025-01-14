<template>
    <div>
        <!-- header-banner section start -->
        <section class="header-banner" v-if="sliderLength > 0">
            <div class="container">
                <div class="row">
                    
                    <!-- Slider Texts -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="mt-50 col-md-12">
                                <div class="text-fade-slider">
                                    <span v-for="(slider,index) in sliders" :key="index">
                                        <h1 class="text-white">{{slider.heading}}</h1>
                                        <h4 class="text-white">{{slider.sub_heading}}</h4>
                                        <p>{{slider.detail}}</p>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Search Box -->
                        <div class="row">
                            <div class="col-md-12 m-5rem">
                                <form @submit.prevent="sendToSearch">
                                    <input type="search" id="search" placeholder="What do you want learn ?"
                                        v-model="searchTerm">
                                    <svg class="srch-icon" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                        xml:space="preserve" width="30px" height="30px">
                                        <g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M508.875,493.792L353.089,338.005c32.358-35.927,52.245-83.296,52.245-135.339C405.333,90.917,314.417,0,202.667,0 S0,90.917,0,202.667s90.917,202.667,202.667,202.667c52.043,0,99.411-19.887,135.339-52.245l155.786,155.786 c2.083,2.083,4.813,3.125,7.542,3.125c2.729,0,5.458-1.042,7.542-3.125C513.042,504.708,513.042,497.958,508.875,493.792z M202.667,384c-99.979,0-181.333-81.344-181.333-181.333S102.688,21.333,202.667,21.333S384,102.677,384,202.667 S302.646,384,202.667,384z"
                                                        data-original="#000000" class="active-path"
                                                        data-old_color="#000000" fill="#655C54">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </form>
                                <span class="text-light">{{response}}:</span> 
                                <span class="text-white">{{searchTerm}}</span> 
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slider images -->
                    <div class="col-md-6" v-if="!sliderLoading">
                        <b-carousel
                            id="carousel-1"
                            :interval="8000"
                            indicators
                            style="text-shadow: 1px 1px 2px #333;"
                            >
                            <!-- Text slides with image -->
                            <b-carousel-slide 
                                :img-src="`${path}/images/slider/${slider.image}`"
                                v-for="(slider,index) in sliders" :key="index"
                            >
                            </b-carousel-slide>
                        </b-carousel>
                    </div>

                    <!-- Skeleton loading till we get slider images -->
                    <div class="col-md-6" v-else>
                        <b-skeleton-img></b-skeleton-img>
                    </div>
                </div>
            </div>
        </section>
        <!-- header-banner section End -->
    </div>
</template>

<script>
    "use Strict";
    
    export default {

        name: 'slider',

        data() {
            return {
                sliderLoading: true,
                baseurl: baseurl,
                sliders: [],
                path: null,
                slider: {},
                sliderLength: 0,
                searchTerm: '',
                response: 'Type something in input box to Search'
            }
        },
        
        watch: {
            searchTerm: function (newSearchTerm, oldSearchTerm) {
                this.response = "Waiting for you to stop typing"
                this.debouncedSearch()
            }
        },

        created: function () {
            this.debouncedSearch = _.debounce(this.search, 500)
        },
        
        methods : {

            // Function to run the slickslider for featured courses
            slickslider() 
            {
                this.$nextTick(()=> 
                {
                    $('.text-fade-slider').slick({
                        speed: 2500,
                        arrows: false,
                        slidesToShow: 1,
                        autoplay: true,
                        fade: true,
                        autoplaySpeed: 2500,
                        slidesToScroll: 1,
                        responsive: [{
                            breakpoint: 992,
                            settings: {
                            slidesToShow: 1,
                            arrows: false,
                            fade: true,
                            autoplay: true,
                            slidesToScroll: 1,

                            }
                        },

                        {
                            breakpoint: 767,
                            settings: {
                            slidesToShow: 1,
                            arrows: false,
                            fade: true,
                            autoplay: true,
                            slidesToScroll: 1,
                            dots: false,
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                            slidesToShow: 1,
                            arrows: true,
                            fade: true,
                            autoplay: true,
                            slidesToScroll: 1,
                            dots: true,
                            }
                        },
                        ]
                    });
                
                });
            },

            // Call home api to get  slider data
            async callAPI(){
                
                await axios.get('/api/home?secret=' + this.$secretKey)
                .then(res => {

                    this.sliders = res.data.slider;
                    this.sliderLength = res.data.slider.length,
                    this.sliderLoading = false;
                    this.slickslider(); 

                })
                .catch(err=> {
                    
                    console.log(err.response);
                    this.sliderLoading = false;
                });
            },

            // call search api
            async search() {

                await axios.get(`/api/search?secret=${this.$secretKey}&searchTerm=${this.searchTerm}`)
                .then(res=> {

                    if(res.status == 200)
                    {
                        this.response = 'Press enter to search'
                    }

                })
                .catch(err=> {

                    console.log(err.response);

                })
            },

            // On click push to search
            sendToSearch() {
                
                if(this.searchTerm != '')
                {
                    this.$router.push(`/search?searchTerm=${this.searchTerm}`);
                }
                else
                {
                    let config = {
                        text: 'Please enter something',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }
            }

        },

        mounted() {

            this.path = axios.defaults.baseURL;  
            this.callAPI();
            
        },
    }

</script>