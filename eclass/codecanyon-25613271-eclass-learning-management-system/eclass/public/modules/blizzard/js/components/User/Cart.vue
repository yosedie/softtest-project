<template>
    <div>

        <header-section />

        <!-- cart start -->
        <section class="cart" v-if="!loading">
            <div class="container" v-if="cartTotal > 0">
                
                <h1 class="mt-70">{{ translate('frontstaticword.ShoppingCart')}}</h1>

                <div class="row mt-50">
                    <div class="col-12 col-md-8">
                        
                        <!-- Courses count -->
                        <div class="cart-count">
                            <h4>
                                {{this.cartTotal}} {{ translate('frontstaticword.CoursesinCart')}}
                            </h4>
                        </div>

                        <!-- Course in cart -->
                        <div class="row cart-wrapper" v-for="(item,index) in cart" :key="index">
                            <div class="col-lg-10 col-md-9 col-9">
                                <div class="row">
                                    <div class="cart-list">
                                        
                                        <!-- Course image -->
                                        <div class="col-md-2 col-4">
                                            <div class="cart-img">
                                                <router-link :to="item.course_id == null ? {name: 'bundle_course_detail', params: {id: item.bundle.id, title: item.bundle.title}} : {name: 'course_detail', params: {id: item.courses.id, title: item.courses.title}}">
                                                    <img :src="item.course_id != null ? `${path}/images/course/${item.courses.preview_image}` : `${path}/images/bundle/${item.bundle.preview_image}` " alt="cart_course">
                                                </router-link>
                                            </div>
                                        </div>

                                        <!-- About course -->
                                        <div class="col-md-10 col-8">
                                            <div class="cart-thumbnail">
                                                <router-link :to="item.course_id == null ? {name: 'bundle_course_detail', params: {id: item.bundle.id, title: item.bundle.title}} : {name: 'course_detail', params: {id: item.courses.id, title: item.courses.title}}">
                                                    <h5>
                                                        {{item.course_id == null ? item.bundle.title :  item.courses.title}}
                                                    </h5>
                                                    <p class="font-12 mr-2">
                                                        {{item.course_id == null ? item.bundle.short_detail :  item.courses.short_detail}}
                                                    </p>
                                                </router-link>
                                                <span>
                                                    {{ translate('frontstaticword.By')}} {{item.course_id == null ? `${item.bundle.user.fname} ${item.bundle.user.lname}` :  `${item.courses.user.fname} ${item.courses.user.lname}`}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-lg-2 col-md-3 col-3 pl-none">
                                <div class="cart-add-remove">
                                    <!-- Price for simple course -->
                                    <div class="text-center" v-if="item.type == '0'">
                                        <!-- If course is discounted -->
                                        <div v-if="item.courses.discount_price!=null">
                                            <span class="font-18">
                                                {{currency.icon}}
                                                {{item.courses.discount_price}}
                                            </span>
                                            <br>
                                            <span>
                                                <del>
                                                    {{currency.icon}}
                                                    {{item.courses.price}}
                                                </del>
                                            </span>
                                        </div>
                                        <!-- If their is no discount on course -->
                                        <div v-else>
                                            <span class="font-18">
                                                {{currency.icon}}
                                                {{item.courses.price}}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Price for bundle course -->
                                    <div class="text-center" v-if="item.type == '1'">
                                        <!-- If course is discounted -->
                                        <div v-if="item.bundle.discount_price!=null">
                                            <span class="font-18">
                                                {{currency.icon}}
                                                {{item.bundle.discount_price}}
                                            </span>
                                            <br>
                                            <span>
                                                <del>
                                                    {{currency.icon}}
                                                    {{item.bundle.price}}
                                                </del>
                                            </span>
                                        </div>
                                        <!-- If their is no discount on course -->
                                        <div v-else>
                                            <span class="font-18">
                                                {{currency.icon}}
                                                {{item.bundle.price}}
                                            </span>
                                        </div>
                                    </div>                                    
                                    
                                    <!-- Remove course from cart -->
                                    <div class="cart-remove ml-4 mt-3">
                                        <a @click="item.course_id != null ? removeFromCart(item.course_id) : removeFromBundleCart(item.bundle_id)">
                                            <i class="fa fa-window-close-o font-20 text-danger" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Total and checkout -->
                    <div class="col-12 col-md-4">
                        <div class="checkout pd-30 bg-light">
                            <div class="checkout-container">
                                
                                <h3>{{ translate('frontstaticword.CartTotals')}}:</h3>

                                <div class="checkout-price">
                                    <ul class="mt-4">
                                        <!-- Orignal Total Price -->
                                        <li>
                                            <strong class="h5">
                                                {{ translate('frontstaticword.TotalPrice')}}
                                            </strong>
                                            <strong class="float-right">
                                                {{currency.icon}}
                                                {{this.totalPrice}}
                                            </strong>
                                        </li>

                                        <!-- Offer Discount -->
                                        <li>
                                            <strong class="h5"> 
                                                {{ translate('frontstaticword.OfferDiscount')}}
                                            </strong>
                                            <span class="float-right"> - 
                                                {{currency.icon}}
                                                {{this.discountPrice}}
                                            </span>
                                        </li>

                                        <!-- Discount Percentage -->
                                        <li>
                                            <strong class="h5"> 
                                                {{ translate('frontstaticword.DiscountPercent')}}
                                            </strong>
                                            <span class="float-right"> 
                                                {{this.discount_percent}}%
                                            </span>
                                        </li>

                                        <!-- Show coupon applied -->
                                        <li>
                                            <strong class="h5">
                                                {{ translate('frontstaticword.CouponDiscount')}}
                                            </strong>
                                            <span class="float-right">
                                                <div  v-if="!couponSuccess && this.disamount == 0">
                                                    {{ translate('frontstaticword.NoCouponApplied')}}
                                                </div>
                                                <div v-else>
                                                    {{ translate('frontstaticword.CouponApplied')}}
                                                </div>
                                            </span>
                                        </li>

                                        <!-- Coupon Disocunt Amount -->
                                        <li v-if="this.disamount != 0">
                                            <strong class="h5">
                                                {{ translate('frontstaticword.DiscountAmount')}}
                                            </strong>
                                            <span class="float-right"> - 
                                                {{currency.icon}}
                                                {{this.disamount}} 
                                            </span>
                                        </li>
                                    </ul>
                                    <hr>

                                    <!-- Total Amount -->
                                    <div class="cart__price">
                                        <h2 class="inline-block">
                                            {{ translate('frontstaticword.Total')}}
                                        </h2>
                                        <h3 class="float-right"> ${{this.total}} </h3>
                                    </div>
                                </div>

                                <!-- Checkout button -->
                                <div class="start-btn text-center">
                                    <a @click="checkout" class="flat-button bg-orange btn-block">
                                        {{('Checkout')}}
                                    </a>
                                </div>
                                
                                <!-- Enter coupon code and apply -->
                                <form @submit.prevent="applyCoupon">
                                    <div class="mb-2 mt-4">
                                        <input type="text" class="coupon__input" v-model="coupon" :placeholder="translate('frontstaticword.EnterCoupon')" :readonly="couponSuccess">
                                        <button type="submit" class="coupon-btn" :disabled="couponSuccess">
                                            {{ translate('frontstaticword.Apply')}}
                                        </button>
                                    </div>
                                </form>
                                
                                <!-- Show applied coupon -->
                                <div class="mt-4" v-if="couponSuccess">
                                    
                                    <div class="row showSuccessCoupon bg-success">
                                        <div class="col-md-10">
                                            <p>
                                                {{ translate('frontstaticword.Huury')}}! 
                                                <strong> {{this.coupon}} </strong> 
                                                {{ translate('frontstaticword.appliedsuccessfully')}}.
                                            </p>
                                        </div>

                                        <div class="col-md-2">
                                            <a class="text-white" @click="removeCoupon">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>

                                <!-- If page reloaded and cart still has coupon -->
                                <div class="mt-4" v-if="disamount != 0 && couponSuccess == false">
                                    
                                    <div class="row showSuccessCoupon">
                                        <div class="col-md-10">
                                            <p>
                                                {{ translate('frontstaticword.RemoveCoupon')}}
                                            </p>
                                        </div>

                                        <div class="col-md-2">
                                            <a class="text-white" @click="removeCoupon">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Display all coupons -->
                                <div class="bg-white mt-2 pd-10">
                                    <h5>
                                        {{ translate('frontstaticword.AllCoupons')}}
                                    </h5>
                                    <hr>
                                    <div class="display-coupons" v-for="(coupon,index) in coupons" :key="index">
                                        <p>
                                            {{ translate('frontstaticword.Usecoupon')}} 
                                            <strong> {{coupon.code}}</strong> 
                                            {{ translate('frontstaticword.toget')}} 
                                            {{coupon.amount}} {{coupon.distype}} 
                                            {{ translate('frontstaticword.discount')}}
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Else part -->
            <div v-else>
                <!-- User not login -->
                <div v-if="!loginStatus">
                    <sign-in :guest="1"/>
                </div>
                <!-- Empty Cart -->
                <div class="container mt-70  mb-4 bg-light p-y80 b-50" v-else>
                    <div class="text-center">
                        <h5>
                            {{ translate('frontstaticword.cartempty')}}
                        </h5>
                        <router-link to="/" class="btn btn-danger">
                            {{ translate('frontstaticword.ExploreCourses')}}
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
        <!-- cart start -->

        <!-- Skeleton loading for cart till we fetch the data from api -->
        <div v-else>
            <div class="container mt-100">
                <CartSkeleton></CartSkeleton>
            </div>
        </div>

        <recent-course />
        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    // import components
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import CartSkeleton from '../Skeletons/Cart.vue';
    import recentCourse from '../Course/RecentCourses.vue';
    import signIn from '../Login.vue';

    export default {

        name: 'cart',

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            CartSkeleton,
            recentCourse,
            signIn
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                cart: [],
                cartTotal: 0,
                cartAmounts: {},
                loading: true,
                totalPrice: 0,
                discountPrice: 0,
                discount_percent: 0,
                totalForDiscountedPrice: 0,
                total: 0,
                disamount: 0,
                coupons: [],
                distype: '',
                coupon: '',
                couponSuccess: false,
                meta: {
                    name: 'Cart',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'}`,
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

            // function to call cart details API and all the API's we need to call by default
            async getCart() {

                // Check if User is login
                if (this.loginStatus == true) {
                    await axios.post('/api/show/cart?secret=' + this.$secretKey, {
                        //data
                    }, 
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(response => {

                        this.cartAmounts = response.data;
                        this.cart = response.data.cart;
                        this.cartTotal = response.data.cart.length;
                        this.loading = false;

                    })
                    .catch(err=> {

                        console.log(err.response);
                        this.loading = false;

                    });

                    this.totalPrice = 0,
                    this.discountPrice = 0,
                    this.discount_percent = 0,
                    this.total = 0,
                    this.disamount = 0,
                    this.totalForDiscountedPrice = 0,

                    this.cartTotals();
                    this.getAllCoupon();
                }
                // If user is not login
                else 
                {
                    this.loading = false;
                }

            },

            // to remove the course from cart
            removeFromCart(id) {

                axios.post('/api/remove/cart?secret=' + this.$secretKey, {
                    course_id: id
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then(response => {

                    if (response.status == 200) {
                        let config = {
                            text: 'Course is removed from your cart !',
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.getCart();
                    }

                }).catch(err => {

                    if (err.response.status === 401) {
                        let config = {
                            text: 'Course does not exist in your cart !',
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }

                });

            },

            // remove bundle course from cart
            removeFromBundleCart(id) {

                axios.post(`/api/remove/bundle?secret=${this.$secretKey}`, {
                        bundle_id: id
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res => {

                        if (res.status == 200) {
                            let config = {
                                text: 'Bundle Course Removed',
                                button: 'CLOSE!'
                            }
                            this.$snack['success'](config);
                            this.getCart();
                        }
                    }).catch(err => {

                        if (err.response.status === 401) {
                            let config = {
                                text: err.response.data.message,
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                    });
            },

            // To remove all courses from cart
            async removeAll() {

                await axios.post('/api/remove/all/cart?secret=' + this.$secretKey, {
                    //data
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then(response => {

                    if (response.status == 200) {
                        let config = {
                            text: 'All Courses are removed from your cart !',
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.getCart();
                    }

                }).catch(err => {

                    if (err.response.status === 401) {
                        let config = {
                            text: err.response.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }

                });
            },

            // this function get all the cart amounts by calculation
            cartTotals() {

                this.cart.forEach(carts => {

                    //Actual Total Price
                    var price = +carts.price;
                    this.totalPrice += price;

                    //Coupon Discount Amount
                    var discountAmount = +carts.disamount;
                    this.disamount += discountAmount;
                    this.disamount.toFixed(2);

                    //Total Price
                    var disPrice = +carts.offer_price;
                    this.total += disPrice;

                    this.totalForDiscountedPrice += disPrice;

                    //Total Discounted Price
                    this.discountPrice = this.totalPrice - this.totalForDiscountedPrice;

                    //Discount Percentage
                    this.discount_percent = (this.discountPrice / this.totalPrice) * 100;
                    this.discount_percent = this.discount_percent.toFixed(2);

                });

                this.total = this.total - this.disamount.toFixed(2);

            },

            // function to call all coupons api
            async getAllCoupon() {

                await axios.get('/api/all/coupons?secret=' + this.$secretKey).then(res => {
                    this.coupons = res.data.coupon;
                });

            },

            // function to apply coupon on course
            async applyCoupon() {

                if (this.coupon != '') 
                {
                    this.couponSuccess = true;
                    await axios.post('/api/apply/coupon?secret=' + this.$secretKey, {

                        coupon: this.coupon
                    }, 
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(response => {

                        if (response.status == 200) {

                            let config = {
                                text: response.data.msg,
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.getCart();
                        }

                    })
                    .catch(err => {

                        if (err.response.status === 401) {
                            let config = {
                                text: err.response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                        this.couponSuccess = false;

                    });
                } 
                else 
                {
                    let config = {
                        text: 'Please enter coupon code',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }
            },

            // function to remove coupon from course
            async removeCoupon() {

                await axios.post('/api/remove/coupon?secret=' + this.$secretKey, {

                    //data
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }

                }).then(response => {

                    if (response.status == 200) {
                        let config = {
                            text: response.data,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.couponSuccess = false;
                        this.coupon = ''
                        this.getCart();
                    }

                }).catch(err => {

                    if (err.response.status === 401) {
                        let config = {
                            text: err.response.data,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }

                });
            },

            // Checkout function
            checkout() {

                // Send to checkout page and validation for cart value
                if (this.total != '0') 
                {
                    this.$router.push('/checkout');
                } 
                else 
                {
                    let config = {
                        text: 'Your cart value is zero',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }

            }
        },

        mounted() {

            // Call the cart detail api
            this.getCart();
            // Store the current url
            this.path = axios.defaults.baseURL;

        }
    }
</script>