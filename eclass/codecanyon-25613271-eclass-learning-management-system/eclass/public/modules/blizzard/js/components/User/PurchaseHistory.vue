<template>
    <div>

        <header-section />

        <!-- Page Heading -->
        <div class="blog-header" v-if="loginStatus">
            <div class="blog-title" v-if="!loading">
                <h1>
                    {{ translate('frontstaticword.PurchaseHistory')}}
                </h1>
            </div>

            <!-- Skeleton loading for header -->
            <b-row v-else>
                <b-col md="6" offset-md="5">
                    <b-skeleton height="40px" width="40%"></b-skeleton>
                </b-col>
            </b-row>
        </div>

        <!-- Purchase History and Refund -->
        <section class="mb-4 mt-4">
            <div class="container">
                <div v-if="!loading">
                    <!-- Load content -->
                    <div class="row" v-if="orderhistory.length">

                        <!-- Purchase history Table -->
                        <div class="purchase-history-table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="table-main-heading">
                                            {{ translate('frontstaticword.PurchaseHistory')}}
                                        </th>
                                        <th>
                                            {{ translate('frontstaticword.Enrollon')}}
                                        </th>
                                        <th>
                                            {{ translate('frontstaticword.EnrollEnd')}}
                                        </th>
                                        <th>
                                            {{ translate('frontstaticword.PaymentMode')}}
                                        </th>
                                        <th>
                                            {{ translate('frontstaticword.TotalPrice')}}
                                        </th>
                                        <th>
                                            {{ translate('frontstaticword.PaymentStatus')}}
                                        </th>
                                        <th>
                                            {{ translate('frontstaticword.Actions')}}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(order,index) in orderhistory" :key="index">
                                        <td>
                                            <!-- {{order.courses.title}} -->
                                        </td>
                                        <td>
                                            {{ order.enroll_start != null ? moment(order.enroll_start).format("dddd, MMMM Do YYYY") : '-' }}
                                        </td>
                                        <td>
                                            {{ order.enroll_expire != null ? moment(order.enroll_expire).format("dddd, MMMM Do YYYY") : '-' }}
                                        </td>
                                        <td>
                                            {{ order.payment_method != '' ? order.payment_method : '-' }}
                                        </td>
                                        <td>
                                            {{ order.total_amount != '' ? order.total_amount : '-' }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div v-else>
                        <!-- User not login -->
                        <div v-if="!loginStatus">
                            <sign-in :guest="1"/>
                        </div>

                        <!-- No purchase history -->
                        <div class="mt-70 bg-light p-y80 b-50 mb-4" v-else>
                            <div class="text-center" id="explore">
                                <h5>{{ translate('frontstaticword.Yourhavenopurchasehistory')}} !</h5>
                                <router-link to="/courses" class="btn btn-danger">
                                    {{ translate('frontstaticword.ExploreCourses')}}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skeleton loading -->
                <div class="mt-4" v-else>
                    <b-skeleton-table :rows="3" :columns="6" :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>
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
    import signIn from '../Login.vue';

    export default {

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            signIn
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                orderhistory: [],
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.mainUser.fname ?? 'User'}'s Purchase History  | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [{
                        name: 'description',
                        content: this.settings.meta_data_desc
                    },
                    {
                        property: 'og:title',
                        content: this.mainUser.fname + 'Courses' + ' | ' + this.settings.project_title
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

            // Call api to get purchase history of user (this would be the default api to be called)
            async callAPI() 
            {
                if (this.loginStatus == true) 
                {   
                    // this.getRefund();
                    let apiData = {
                        params: {
                            secret: this.$secretKey
                        },
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }

                    await axios.get('/api/purchase/history', apiData)
                    .then(res => 
                    {
                        if (res.status == 200) 
                        {
                            this.orderhistory = res.data.orderhistory;
                            this.loading = false;
                        }
                    })
                } 
                else 
                {
                    this.loading = false;
                }
            },

            // Call API to get refund data of user
            async getRefund() 
            {

                let apiData = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }

                await axios.get('/api/refundorder', apiData)
                .then(res=> 
                {


                })
                .catch(err=> { console.log(err.response) });
            }

        },

        mounted() {
            this.callAPI();
            this.path = axios.defaults.baseURL;
        }
    }
</script>