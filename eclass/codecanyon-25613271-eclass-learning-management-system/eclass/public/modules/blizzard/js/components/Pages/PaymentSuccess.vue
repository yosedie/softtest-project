<template>
    <div>

        <header-section />

        <!-- Successfull payment section -->
        <section>
            <div class="container pd-100 text-center bg-white">
                <h3 class="text-success">
                    {{ translate('frontstaticword.Yourcourseissuccessfullypurchased')}}.
                </h3>
                <h6 class="mt-4">
                    <router-link class="btn btn-success" to="/purchaseHistory">
                        {{ translate('frontstaticword.PurchaseHistory')}}
                    </router-link>
                </h6>
                <br>
                <img :src="`${baseurl}/modules/blizzard/images/3226836.jpg`" alt="payment success" width="50%">
            </div>
        </section>

        <footer-section />

    </div>
</template>

<script>
    "use Strict";
    
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import mixin from '../../mixin.js';
    
    export default{

        name: 'successful_payment',

        mixins: [mixin],

        data() {
            return {
                baseurl: baseurl,
                path: null,
                meta: {
                    name: 'Successful Payment',
                    profileurl: window.location.href,
                },
            }
        },

        // SEO data, meta-tag, meta-title
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.meta.name + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        components: {
            headerSection,
            footerSection
        },

        mounted() {
            this.path = axios.defaults.baseURL;
        }

    }

</script>