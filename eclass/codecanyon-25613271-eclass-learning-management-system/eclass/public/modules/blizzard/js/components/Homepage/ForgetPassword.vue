<template>
    <div>

        <!-- Forget Password Section Start -->
        <section class="loginform forgot-password">
            <div class="container">
                <div class="loginform-container">
                    <div class="loginform-heading text-center">
                        <router-link to="/" v-if="settings.logo">
                            <img :src="`${path}/images/logo/${settings.logo}`" alt="logo" width="125px" height="40px">
                        </router-link>
                        <p class="mt-4">
                            {{ translate('frontstaticword.entermailforpasswordreset')}}.
                        </p>
                    </div>
                    <form @submit.prevent="forgetPassword">
                        <!-- Email -->
                        <div class="loginform-group">
                            <input type="email" v-model="email" class="loginform-control" placeholder="Email Address" :class="{'is-invalid' : this.emailError}" :disabled="disabled == 1"
                                required>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            <p v-if="this.emailError" class="text-danger mt-2">
                                <i class="feather icon-alert-circle mr-2"></i>
                                {{this.errorMessage}}
                            </p>
                            
                        </div>
                        <!-- Submit button -->
                        <div class="loginform-group clearfix text-center">
                            <button @click="forgetPassword" type="submit" class="btn btn-danger" :class="buttonLoading ? 'hide' : ''">
                                {{ translate('frontstaticword.SendPasswordResetLink')}}
                            </button>

                            <!-- loading loading button till user login -->
                            <button disabled class="btn btn-danger" :class="buttonLoading ? '' : 'hide'">
                                <b-spinner small type="grow"></b-spinner> 
                                {{ translate('frontstaticword.SendingMail')}}...
                            </button>
                        </div>
                    </form>
                    <hr>
                    <div class="loginform-register">
                        <router-link to="/signIn">
                            <span>
                                <i class="feather icon-arrow-left"></i>
                                {{ translate('frontstaticword.BacktoLoginPage')}}</span>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
        <!-- Forget Password Section end -->
    </div>
</template>

<script>

    "use Strict";
    
    import mixin from '../../mixin.js'

    export default {

        mixins: [mixin],

        name: 'forgetPassword',

        data() {

            return {
                email: '',
                emailError: false,
                errorMessage: '',
                buttonLoading: false,
                disabled: 0,
                path: null,
                baseurl: baseurl,
                meta: {
                name: 'Forget Password',
                profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // SEO and meta tag-titles
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading...'}`,
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

            async forgetPassword() {
                

                if(this.email != '')
                {
                    this.emailError = false;
                    this.errorMessage = '';
                    this.buttonLoading = true;
                    this.disabled = 1;
                    await axios.post('/api/forgotpassword', {

                        email: this.email

                    })
                    .then(res => {

                        if (res.status == 200) {
                            let config = {
                                text: 'We have e-mailed your password reset link!',
                                button: 'CLOSE'
                            }

                            this.$snack['success'](config);
                            this.email = '';
                            this.buttonLoading = false;
                            this.disabled = 0;
                        }

                    })
                    .catch(err => {
                        
                        if (err.response.status === 401) 
                        {    
                            this.emailError = true;
                            this.errorMessage = 'Please enter a valid email.';
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                        this.buttonLoading = false;
                        this.disabled = 0;

                    });
                }
                else 
                {
                    this.emailError = true;
                    this.errorMessage = 'Please enter email';
                    this.buttonLoading = false;
                    this.disabled = 0;
                }
            }

        },

        mounted() {
            this.path = axios.defaults.baseURL;
        }
    }

</script>