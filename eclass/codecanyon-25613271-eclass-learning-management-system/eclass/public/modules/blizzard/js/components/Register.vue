<template>
    <div>

        <!-- register section start -->
        <section class="loginform signupform">
            <div class="container">
                <div class="loginform-container">
                    
                    <!-- Logo -->
                    <div class="loginform-heading text-center">
                        <router-link to="/" v-if="settings.logo">
                            <img :src="`${path}/images/logo/${settings.logo}`" class="mb-3" alt="logo" width="125px" height="40px">
                        </router-link>
                        <p>{{ translate('frontstaticword.Createanaccount')}}</p>
                    </div>

                    <!-- Register Form -->
                    <form @submit.prevent="register">
                        <!-- Name -->
                        <div class="loginform-group">
                            <input type="text" v-model="name" class="loginform-control" :placeholder="translate('frontstaticword.Fullname')" autofocus required>
                            <i class="feather icon-user" aria-hidden="true"></i>
                        </div>

                        <!-- Email -->
                        <div class="loginform-group">
                            <input :class="{'is-invalid' : errors.email && errors.email.length }" type="email" v-model="email" class="loginform-control" :placeholder="translate('frontstaticword.EmailAddress')" required>
                            <i class="feather icon-mail" aria-hidden="true"></i>

                            <!-- Display error message -->
                            <p v-if="errors.email && errors.email.length" class="text-danger">
                                {{errors.email[0]}}
                            </p>
                        </div>

                        <!-- Mobile -->
                        <div v-if="this.settings.mobile_enable=='1'">
                            <div class="loginform-group">
                                <input :class="{'is-invalid' : errors.mobile}" type="number" v-model="mobile" class="loginform-control" :placeholder="translate('frontstaticword.Mobile')" required>
                                <i class="feather icon-phone" aria-hidden="true"></i>

                                <!-- Display error message -->
                                <p v-if="errors.mobile" class="text-danger">
                                    {{errors.mobile[0]}}
                                </p>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="loginform-group">
                            <input type="password" v-model="password" class="loginform-control" id="password" :placeholder="translate('frontstaticword.Password')" autocomplete="" :class="{'is-invalid': this.passwordError}" required>
                            <i class="feather icon-lock" aria-hidden="true"></i>

                            <p v-if="this.passwordError" class="text-danger">
                                {{ translate('frontstaticword.Pleaseenteratleast6digitpassword')}}
                            </p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="loginform-group">
                            <input type="password" v-model="c_password" id="C-password" class="loginform-control" :placeholder="translate('ConfirmPassword')" autocomplete="" :class="{'is-invalid': this.passwordError}" required>
                            <i class="feather icon-lock" aria-hidden="true"></i>

                            <p v-if="this.passwordError" class="text-danger">
                                {{ translate('frontstaticword.Pleaseenteratleast6digitpassword')}}
                            </p>
                        </div>

                        <!-- Register Button -->
                        <div class="loginform-group clearfix">
                            <button type="submit" class="loginform-btn-md" :class="isLogging ? 'hide' : ''">
                                {{ translate('frontstaticword.Register')}}
                            </button>

                            <!-- Register loading button till user login -->
                            <button type="submit" class="loginform-btn-md" :class="isLogging ? '' : 'hide'">
                                <b-spinner small type="grow"></b-spinner>
                                {{ translate('frontstaticword.Pleasewaitwhilewecheckyourdetails')}}...
                            </button>
                        </div>
                    </form>
                        
                    <!-- Forgot Password and Terms -->
                    <div class="loginform-group">
                        <p class="text-center">
                            {{ translate('frontstaticword.Bysigningup')}}
                            <router-link to="/terms__condition"> 
                                {{ translate('frontstaticword.Terms&Condition')}} 
                            </router-link> , 
                            <router-link to="/privacy__policy"> 
                                {{ translate('frontstaticword.PrivacyPolicy')}} 
                            </router-link>.
                        </p>
                    </div>
                    
                    <!-- Or login with -->
                    <div class="loginform-other text-center">
                        <span>
                            {{ translate('frontstaticword.OrRegisterWith')}}
                        </span>
                    </div>

                    <!-- Social Logins -->
                    <div class="loginform-social--list text-center">
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

                    <!-- Login -->
                    <div class="loginform-register">
                        <router-link to="/signIn">
                                    {{ translate('frontstaticword.Alreadyhaveanaccount')}} 
                            <span>  {{ translate('frontstaticword.Loginhere')}} </span>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
        <!-- Register section end -->
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../mixin.js';

    export default {

        mixins: [mixin],

        data() {
            return {
                name: '',
                email : '',
                password : '',
                mobile: Number,
                c_password: '',
                baseurl: baseurl,
                errors : [],
                isLogging: false,
                passwordError: false,
                path: null,
                meta: {
                    name: 'Register',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME,
            }
        },

        // SEO data and meta tags-titles
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

        methods : {
            
            // Register user function
            async register()
            {

                this.isLogging = true;
                const registerData = {
                    name: this.name,
                    email : this.email,
                    password : this.password,
                    mobile: this.mobile
                }

                //Password length Validations
                if(this.password.length < 6 && this.c_password.length < 6)
                { 
                    this.passwordError = true; 
                    this.isLogging = false;
                    return false;
                }
                else
                { 
                    this.passwordError = false; 
                }
                
                // Register user
                if(this.password === this.c_password){

                    await axios.post('/api/register',registerData)
                    .then(res => {

                        if(res.status == 200)
                        {
                            localStorage.setItem('access_token', JSON.stringify(res.data.access_token));
                            this.$router.push('/');
                        }
                        
                    }).catch(err => {

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }
                        this.isLogging = false;
                    });
                    
                }
                else
                {
                    let config = {
                        text: 'Password does not match',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                    this.password = '';
                    this.c_password = '';
                    this.isLogging = false;
                }

            },

            //Check Login Status
            checkLoginStatus() {
                if(this.loginStatus == true)
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