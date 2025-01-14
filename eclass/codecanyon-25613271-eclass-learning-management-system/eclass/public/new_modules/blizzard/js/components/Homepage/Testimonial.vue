<template>
    <div>
        <!-- testimonial section start -->
        <section class="testimonial" v-if="!loading">
            <div class="container" v-if="testimonialsLength > 0">
                <div class="txt text-center position-relative">
                    <h2>
                        {{ translate('frontstaticword.Whatsatisfieduserssay')}}
                    </h2>
                </div>

                <div class="testimonial-section">
                    <div class="row testimonial-slide">
                        <div class="col-md-12 mb-5 mb-md-0" v-for="(testimonial,index) in testimonials" :key="index">
                            <div class="media-head">
                                <div class="media align-items-md-center text-center text-lg-left mb-3">
                                    <img class="mr-3 rounded-circle" :src="`${testimonial.imagepath}`" alt="testimonials">
                                    <div class="media-body">
                                        <h4 class="mt-0">{{testimonial.client_name}}</h4>
                                    </div>

                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1" id="Capa_1" x="0px" y="0px" width="55px" height="58px"
                                        viewBox="0 0 349.078 349.078" style="enable-background:new 0 0 349.078 349.078;"
                                        xml:space="preserve" class="">
                                        <g>
                                            <g>
                                                <path
                                                    d="M150.299,26.634v58.25c0,7.9-6.404,14.301-14.304,14.301c-28.186,0-43.518,28.909-45.643,85.966h45.643 c7.9,0,14.304,6.407,14.304,14.304v122.992c0,7.896-6.404,14.298-14.304,14.298H14.301C6.398,336.745,0,330.338,0,322.447V199.455 c0-27.352,2.754-52.452,8.183-74.611c5.568-22.721,14.115-42.587,25.396-59.048c11.608-16.917,26.128-30.192,43.16-39.44 C93.886,17.052,113.826,12.333,136,12.333C143.895,12.333,150.299,18.734,150.299,26.634z M334.773,99.186 c7.896,0,14.305-6.407,14.305-14.301v-58.25c0-7.9-6.408-14.301-14.305-14.301c-22.165,0-42.108,4.72-59.249,14.023 c-17.035,9.248-31.563,22.523-43.173,39.44c-11.277,16.461-19.824,36.328-25.393,59.054c-5.426,22.166-8.18,47.266-8.18,74.605 v122.992c0,7.896,6.406,14.298,14.304,14.298h121.69c7.896,0,14.299-6.407,14.299-14.298V199.455 c0-7.896-6.402-14.304-14.299-14.304h-44.992C291.873,128.095,306.981,99.186,334.773,99.186z"
                                                    data-original="#000000" class="active-path" data-old_color="#000000"
                                                    fill="#E5E5E5" />
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <p v-html="testimonial.details"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- testimonial section end -->

        <!-- Skeleton loading for testimonials -->
        <div v-else>
            <testimonial-skeleton />
        </div>
    </div>
</template>

<script>
    "use Strict";
    
    import testimonialSkeleton from '../Skeletons/Testimonial.vue';
    
    export default 
    {  
        name: 'testimonial',

        components: {
            testimonialSkeleton
        },

        data() 
        {
            return {
                baseurl: baseurl,
                testimonials: [],
                testimonialsLength: 0,
                path: null,
                loading: true
            }
        },

        methods: {

            // Function to run slider
            slickslider() 
            {    
                $('.testimonial-slide').slick({
                    speed: 2500,
                    arrows: false,
                    slidesToShow: 2,
                    autoplay: true,
                    fade: false,
                    autoplaySpeed: 3000,
                    slidesToScroll: 1,
                    dots: true,
                    responsive: [{
                        breakpoint: 992,
                        settings: {
                        slidesToShow: 1,
                        arrows: false,
                        fade: false,
                        autoplay: true,
                        slidesToScroll: 1,
                        dots: true,
                        }
                    },

                    {
                        breakpoint: 767,
                        settings: {
                        slidesToShow: 1,
                        arrows: false,
                        fade: false,
                        autoplay: true,
                        slidesToScroll: 1,
                        dots: false,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                        slidesToShow: 2,
                        arrows: false,
                        fade: false,
                        autoplay: true,
                        slidesToScroll: 1,
                        dots: false,
                        }
                    },
                    ]
                });

            },

            // Call home api to get testimonial details (This api will be call by default on the call of the component)
            async callAPI() 
            {    
                await axios.get(`/api/home?secret=${this.$secretKey}`)
                .then(res => 
                {
                    this.loading = false;
                    this.testimonials = res.data.testimonial;
                    this.testimonialsLength = res.data.testimonial.length;
                    this.$nextTick(()=> { this.slickslider(); });
                })
                .catch(err=> 
                {
                    this.loading = false;
                    console.log(err.response);
                });

            }

        },

        async mounted() 
        {    
            await this.callAPI();
            this.path = axios.defaults.baseURL;
        },

    }
</script>