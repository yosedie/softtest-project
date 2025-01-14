<template>
    <div>

        <header-section />

        <div class="container">
            <div class="row pd-100">
                <h4>Gift Checkout</h4>
            </div>
        </div>

        <footer-section />
        
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';

    export default {

        name: 'giftCheckout',
        
        mixins: [mixin],

        data(){
            return {
                baseurl: baseurl,
                path: null
            }
        },
        
        components: {
            headerSection,
            footerSection
        },

        // SEO
        metaInfo() 
        {
            return {
                title: `'Gift Checkout' | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.course_title + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        mounted()
        {
            this.path = axios.defaults.baseURL;
        }

    }

</script>