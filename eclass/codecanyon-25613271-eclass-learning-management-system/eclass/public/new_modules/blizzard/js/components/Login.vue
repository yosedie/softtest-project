<template>
    <div>

        <!-- login start -->
        <section class="loginform">
            <div class="container">
                <div class="loginform-container">
                    <div class="loginform-heading text-center">
                        <router-link to="/" v-if="settings.logo">
                            <img :src="`${path}/images/logo/${settings.logo}`" alt="logo" width="125px" height="40px">
                        </router-link>
                        <p class="mt-2">{{ translate('frontstaticword.Signintoyouraccount')}}</p>
                    </div>

                    <form @submit.prevent="login">
                        <!-- Email -->
                        <div class="loginform-group">
                            <input type="email" v-model="email" class="loginform-control" :placeholder="translate('frontstaticword.EmailAddress')"
                                required autofocus>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </div>

                        <!-- Password -->
                        <div class="loginform-group">
                            <input type="password" v-model="password" class="loginform-control" :placeholder=" translate('frontstaticword.Password')"
                                :class="{'is-invalid': this.passwordError}" autocomplete="" required>
                            <i class="fa fa-lock" aria-hidden="true"></i>

                            <p v-if="this.passwordError" class="text-danger">
                                {{ translate('frontstaticword.Pleaseenteratleast6digitpassword')}}
                            </p>
                        </div>

                        <!-- Submit button -->
                        <div class="loginform-group clearfix">
                            <button type="submit" class="loginform-btn-md" :class="isLogging ? 'hide' : ''">
                                {{ translate('frontstaticword.Login')}}
                            </button>

                            <!-- loading loading button till user login -->
                            <button disabled class="loginform-btn-md" :class="isLogging ? '' : 'hide'">
                                <b-spinner small type="grow"></b-spinner> {{ translate('frontstaticword.LoggingIn')}}...
                            </button>

                            <!-- Forgot Password -->
                            <router-link to="/forgetPassword" class="loginform-forgot--password text-infor">
                                {{ translate('frontstaticword.ForgotPassword')}}
                            </router-link>
                        </div>
                    </form>

                    <!-- Or login with -->
                    <div class="loginform-other text-center" v-if="guest==0">
                        <span>
                            {{ translate('frontstaticword.OrLoginWith')}}
                        </span>
                    </div>

                    <!-- Social Logins -->
                    <div class="loginform-social--list text-center" v-if="guest==0">
                        <ul>
                            <!-- Facebook -->
                            <li v-if="settings.fb_login_enable=='1'">
                                <a :href="`${baseurl}/auth/facebook`" class="loginform-facebook">
                                    <i class="fa fa-facebook facebook-i"></i>
                                    <span>
                                        {{ translate('frontstaticword.Facebook')}}
                                    </span>
                                </a>
                            </li>

                            <!-- Google -->
                            <li v-if="settings.google_login_enable=='1'">
                                <a :href="`${baseurl}/auth/google`" class="loginform-google">
                                    <i class="fa fa-google google-i"></i>
                                    <span>
                                        {{ translate('frontstaticword.Google')}}
                                    </span>
                                </a>
                            </li>

                            <!-- Gitlab -->
                            <li v-if="settings.gitlab_login_enable=='1'">
                                <a :href="`${baseurl}/auth/gitlab`" class="loginform-gitlab">
                                    <i class="fa fa-gitlab gitlab-i"></i>
                                    <span>
                                        {{ translate('frontstaticword.Gitlab')}}
                                    </span>
                                </a>
                            </li>

                            <!-- Amazon -->
                            <li v-if="settings.amazon_enable=='1'">
                                <a :href="`${baseurl}/auth/amazon`" class="loginform-amazon">
                                    <i class="fa fa-amazon amazon-i"></i>
                                    <span>
                                        {{ translate('frontstaticword.Amazon')}}
                                    </span>
                                </a>
                            </li>

                            <!-- Twitter -->
                            <li v-if="settings.twitter_enable=='1'">
                                <a :href="`${baseurl}/auth/twitter`" class="loginform-twitter">
                                    <i class="fa fa-twitter twitter-i"></i>
                                    <span>
                                        {{ translate('frontstaticword.Twitter')}}
                                    </span>
                                </a>
                            </li>

                            <!-- Linkedin -->
                            <li v-if="settings.linkedin_enable=='1'">
                                <a :href="`${baseurl}/auth/linkedin`" class="loginform-linkedin">
                                    <i class="fa fa-linkedin linkedin-i"></i>
                                    <span>
                                        {{ translate('frontstaticword.LinkedIn')}}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Sign up Link -->
                    <div class="loginform-register">
                        <router-link to="/signUp">
                            {{ translate('frontstaticword.Donothaveanaccount')}}? 
                            <span>{{ translate('frontstaticword.Registerhere')}}</span>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
        <!-- login start -->
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../mixin.js';

    export default {

        name: 'signIn',

        mixins: [mixin],

        props : {
            guest: {
                default: 0,
                type: Number
            }
        },

        data() {
            return {
                email: '',
                password: '',
                baseurl: baseurl,
                isLogging: false,
                passwordError: false,
                path: null,
                meta: {
                    name: 'Login',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME,
            }
        },

        // SEO Information and meta tags
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

            // Login function
            async login() {

                this.isLogging = true;
                const logindata = {
                    email: this.email,
                    password: this.password
                }

                // Login form validation
                if (this.password.length < 6) {
                    this.passwordError = true;
                    this.isLogging = false;
                    return false;
                } else {
                    this.passwordError = false;
                }

                await axios.post('/api/login', logindata)
                    .then(res => {

                        if (res.status == 200) {
                            localStorage.setItem('access_token', JSON.stringify(res.data.access_token));

                            if(this.guest === 1)
                            {
                                location.reload();
                            }
                            else{
                                this.$router.push('/');
                            }

                            
                        }

                    })
                    .catch(err => {

                        if(err.response.status === 402) {
                            let config = {
                                text: 'Please verify your email',
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                        if (err.response.status === 401) {
                            let config = {
                                text: err.response.data,
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                        if (err.response.status === 400) {
                            let config = {
                                text: 'Please enter correct password',
                                button: 'CLOSE'
                            }
                            this.$snack['danger'](config);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                        this.isLogging = false;

                    });

            },

            // Check Login Status
            checkLoginStatus() {
                if(this.loginStatus == true && this.guest === 0)
                {
                    this.$router.push('/');
                }
            }

        },

        mounted() {
            this.checkLoginStatus();
            this.path = axios.defaults.baseURL;
        }
    }
</script>