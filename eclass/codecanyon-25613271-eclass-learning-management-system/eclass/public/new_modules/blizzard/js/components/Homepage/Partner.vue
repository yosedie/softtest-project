<template>
    <div>
        <!-- company & partner section start -->
        <section class="cmpy-section" v-if="partners.length">
            <div class="container">
                <div class="title-txt text-center">
                    <h2>
                        {{ translate('frontstaticword.Ourcompanypartners')}}
                    </h2>
                </div>
                <div class="company-name">
                    <div class="row align-items-md-center mt-70 company-row-slide">
                        <div class="col text-md-center" v-for="(partner,index) in partners" :key="index">
                            <div class="cmpy-img">
                                <img :src="`${path}/images/trusted/${partner.image}`" :alt=" translate('frontstaticword.OurPartners')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-100"></div>
        </section> 
        <!-- company & partner section start -->
    </div>
</template>

<script>
    "use Strict";
    
    export default {

        name: 'partners',

        data() {
            return {
                heading: 'Trusted partners',
                partners: [],
                path: ''
            }
        },

        methods: {

            slickslider() {
                this.$nextTick(() => {

                    $('.company-row-slide').slick({
                        speed: 2500,
                        arrows: false,
                        slidesToShow: 5,
                        autoplay: true,
                        fade: false,
                        autoplaySpeed: 3000,
                        slidesToScroll: 1,
                        dots: false,
                        responsive: [{
                            breakpoint: 992,
                            settings: {
                            slidesToShow: 1,
                            arrows: true,
                            fade: false,
                            autoplay: true,
                            slidesToScroll: 1,

                            }
                        },

                        {
                            breakpoint: 480,
                            settings: {
                            slidesToShow: 3,
                            arrows: false,
                            fade: false,
                            autoplay: true,
                            slidesToScroll: 1,
                            dots: true,
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                            slidesToShow: 3,
                            arrows: false,
                            fade: false,
                            autoplay: true,
                            slidesToScroll: 1,
                            dots: true,
                            }
                        },
                        ]
                    });
                });
            },

            async callAPI() {
                await axios.get('/api/home?secret=' + this.$secretKey).then(res => {
                    this.partners = res.data.trusted;
                    this.slickslider();

                });
            }
        },

        mounted() {

            this.callAPI();
            this.path = axios.defaults.baseURL;

        },
    }
</script>