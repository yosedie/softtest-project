<template>
    <div>

        <header-section />

        <!-- checkout section start -->
        <section class="checkout mt-50">
            <div class="container" v-if="loginStatus">
                <div class="row mb-4" v-if="!loading">
                    <div class="col-12 col-md-7" v-if="carts.length > 0">
                        <div class="checkout-billing">

                            <h2>
                                {{ translate('frontstaticword.Checkout')}}
                            </h2>

                            <!-- Payment Methods -->
                            <ul class="nav nav-pills mb-3 d-block" id="pills-tab" role="tablist">

                                <!-- Stripe -->
                                <li class="nav-item">
                                    <a style="background: none;" class="nav-link pl-0 pb-0" id="pills-mobile-tab"
                                        data-toggle="pill" href="#pills-mobile" role="tab" aria-controls="pills-mobile"
                                        aria-selected="false">
                                        <label>
                                            {{ translate('frontstaticword.Paywith'+'Stripe')}}
                                            <img 
                                                class="ml-2" 
                                                width="70px" 
                                                alt="Stripe"
                                                :src="`${path}/images/payment/stripe.png`">
                                        </label>
                                    </a>
                                </li>
                            </ul>

                            <!-- Payment Methods Detail -->
                            <div class="tab-content" id="pills-tabContent">  

                                <!-- Stripe -->
                                <div class="tab-pane fade show active" id="pills-mobile" role="tabpanel"
                                    aria-labelledby="pills-mobile-tab">
                                    <div class="checkout-form">
                                       
                                        <stripe-element-card
                                            ref="elementRef"
                                            :pk="'pk_test_qQEK1HlAwSUtLoRgKSc5jcAC00bTS4A93l'"
                                            @token="tokenCreated"
                                        />                                        
                                        <div class="start-btn mt-4">
                                            <button  @click="submit" class="btn-block" type="submit" :class="stripePayment ? 'hide' : ''">
                                                {{ translate('frontstaticword.Proceedtopay')}}
                                            </button>

                                            <button disabled class="btn-block" :class="stripePayment ? '' : 'hide'">
                                                <b-spinner small type="grow"></b-spinner>
                                                {{ translate('frontstaticword.Pleasewait')}}
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- If cart is empty -->
                    <div class="col-12 col-md-7 bg-light pt-4 b-50 mb-4" v-else>
                        <div class="text-center" id="explore">
                            <h5>
                                {{ translate('frontstaticword.cartempty')}}
                            </h5>
                            <router-link to="/" class="btn btn-danger">
                                {{ translate('frontstaticword.ExploreCourses')}}
                            </router-link>
                            <br>
                            <img 
                                :src="`${baseurl}/modules/blizzard/images/empty_category_concept-removebg-preview.png`" 
                                alt="empty_cart"
                                width="30%"
                                class="mt-4">
                        </div>
                    </div>

                    <!-- checkout summary start -->
                    <div class="col-12 col-md-5">
                        <div class="checkout-summary">
                            <h4>
                                {{ translate('frontstaticword.Checkout')}}
                            </h4>
                            
                            <div class="row rubikregular">
                                <div class="col-lg-8">
                                    <ul>
                                        <li>
                                            {{ translate('frontstaticword.Originalprice')}}:
                                        </li>

                                        <li v-if="data.offer_total!=0">
                                            {{ translate('frontstaticword.OfferDiscount')}}:
                                        </li>

                                        <li v-if="data.offer_percent!=0">
                                            {{ translate('frontstaticword.DiscountPercent'+':')}}
                                        </li>
                                        
                                        <li v-if="data.cpn_discount!=0">
                                            {{ translate('frontstaticword.Coupondiscounts'+':')}}
                                        </li>
                                        <hr>
                                        <li class="h4">
                                            <b>
                                                {{ translate('frontstaticword.Total')}}
                                            </b>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <ul>
                                        <li>
                                            <i :class="currency.icon"></i>
                                            {{data.price_total}}
                                        </li>

                                        <li v-if="data.offer_total!=0">
                                             - 
                                            <i :class="currency.icon"></i>
                                            {{data.offer_total}}
                                        </li>

                                        <li v-if="data.offer_percent!=0">
                                            {{data.offer_percent}}%
                                        </li>

                                        <li v-if="data.cpn_discount!=0">
                                            <i :class="currency.icon"></i>
                                            {{data.cpn_discount}}
                                        </li>

                                        <hr>
                                        <li class="h4">
                                            <b>
                                                <i :class="currency.icon"></i>
                                                {{data.cart_total}}
                                            </b>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- checkout summary end -->
                </div>

                <!-- Skeleton loading for checkout page -->
                <div v-else>
                    <checkout-skeleton />
                </div>
            </div>
            
            <!-- If user not login -->
            <div class="container mt-70 bg-light p-y80 b-50 mb-4" v-else>
                <div class="text-center" v-if="!loginStatus">
                    <h5>
                        {{ translate('frontstaticword.Youarenotlogin')}}
                    </h5>
                    <router-link to="/signIn" class="btn btn-danger">
                        {{ translate('frontstaticword.PleaseLogin'+'!')}}
                    </router-link>
                </div>
            </div>

        </section>
        <!-- checkout section start -->

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import mixin from '../../mixin.js';
    import { StripeElementCard } from '@vue-stripe/vue-stripe';
    import PayPal from 'vue-paypal-checkout';
    import checkoutSkeleton from '../Skeletons/Checkout.vue';

    export default {

        name: 'checkout',

        mixins: [mixin],

        data() 
        {
            this.pulishableKey = process.env.STRIPE_KEY;
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                carts: [],
                data: {},
                stripePayment: false,
                values: {
                    price: 0,
                    payAmount: 0
                },
                meta: {
                    name: 'Checkout',
                    profileurl: window.location.href,
                },
                token: null,
            }
        },

        components: {
            headerSection,
            footerSection,
            checkoutSkeleton,
            StripeElementCard,
            PayPal
        },

        // Meta tags / seo information
        metaInfo() 
        {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.meta.name + ' | ' + this.settings.project_title
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

            // Call api to get cart details
            async getCart() 
            {

                if (this.loginStatus == true) 
                {
                    await axios.post('/api/show/cart?secret=' + this.$secretKey, {
                        //data
                    }, 
                    {
                        headers: 
                        {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(response => {

                        this.data = response.data;
                        this.carts = response.data.cart;      
                        this.cart_total = reponse.data.cart_total,
                        this.cpn_discount = reponse.data.cpn_discount,
                        this.offer_percent = reponse.data.offer_percent,
                        this.offer_total = reponse.data.offer_total,
                        this.price_total = reponse.data.price_total,
                        this.loading = false;

                    })
                    .catch(err=> 
                    {
                        // console.log(err.response);
                        this.loading = false;
                    });

                }

            },

            // submit for stripe
            submit() 
            {
                // this will trigger the process
                this.stripePayment = true;
                this.$refs.elementRef.submit();
            },

            // Generate stripe token
            async tokenCreated(token) 
            {
                if (token) 
                {
                    await axios.post(`/api/stripe/pay/store?secret=${this.$secretKey}`, 
                    {
                        token: token.id
                    }, 
                    {
                        headers: 
                        {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res => {

                        if (res.status == 200) 
                        {
                            this.stripePayment = true;
                            let config = {
                                text: res.data,
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.$router.push('/successful_payment');
                        }

                    })
                    .catch(err => {

                        console.log(err.response);
                        this.stripePayment = false;
                        if (err.response.status == 401) 
                        {
                            let config = {
                                text: response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                    });
                }

            }

        },

        mounted() 
        {
            this.getCart();
            this.path = axios.defaults.baseURL;
        }

    }
</script>