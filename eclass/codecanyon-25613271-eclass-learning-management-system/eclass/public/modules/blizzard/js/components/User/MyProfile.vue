<template>
    <div>

        <headerSection />

        <!-- User section -->
        <section class="user-profile-main-block" v-if="loginStatus">
            <div class="container">
                <div class="row">

                        <div class="col-lg-4 col-md-5">
                            <profileSidebar />
                        </div>

                        <div class="col-lg-8 col-md-7">
                            <form @submit.prevent="updateProfile">
                                <div class="personal-block">
                                    <!-- Personal Info -->
                                    <div class="personal-info-block">
                                        <h4 class="personal-info-heading">
                                            {{ translate('frontstaticword.PersonalInfo')}}
                                        </h4>
                                        <div class="row">

                                            <!-- First Name -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        {{ translate('frontstaticword.FirstName')}}
                                                    </label>
                                                    <input type="text" class="form-control" v-model="userDetail.fname">
                                                </div>
                                            </div>

                                            <!-- Last name -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        {{ translate('frontstaticword.LastName')}}
                                                    </label>
                                                    <input type="text" class="form-control" v-model="userDetail.lname">
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        {{ translate('frontstaticword.Email')}}
                                                    </label>
                                                    <input type="text" class="form-control" v-model="userDetail.email">
                                                </div>
                                            </div>

                                            <!-- Mobile -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        {{ translate('frontstaticword.Mobile')}}
                                                    </label>
                                                    <input type="text" class="form-control" v-model="userDetail.mobile">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="address-form">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.address')}}
                                                </label>
                                                <input type="text" class="form-control" v-model="userDetail.address">
                                            </div>
                                        </div>

                                        <!-- Select Location (country,state,city) -->
                                        <!-- <div class="personal-info-select">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="form-label">
                                                        {{ translate('frontstaticword.Country')}}
                                                    </label>
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Antartica</option>
                                                        <option value="1">India</option>
                                                        <option value="2">USA</option>
                                                        <option value="3">Tokyo</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">State</label>
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Nevada</option>
                                                        <option value="1">Nevada</option>
                                                        <option value="2">Nevada</option>
                                                        <option value="3">Nevada</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">City</label>
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Helena</option>
                                                        <option value="1">Helena</option>
                                                        <option value="2">Helena</option>
                                                        <option value="3">Helena</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- Author Bio -->
                                        <div class="author-bio-form">
                                            <div class="form-group">
                                                <label class="form-label" for="bio">
                                                    {{ translate('frontstaticword.AuthorBio')}}
                                                </label>
                                                <textarea id="detail" class="form-control" v-model="userDetail.detail"></textarea>
                                            </div>
                                        </div>

                                        <!-- Update Password -->
                                        <div class="update-pass-block">
                                            <div class="form-check">
                                                <label class="form-check-label" for="gridCheck">
                                                    {{ translate('frontstaticword.UpdatePassword')}}:
                                                </label>
                                                <input class="form-check-input" v-model="updatePassword" type="checkbox" id="gridCheck">
                                            </div>
                                            <br>
                                            <div v-if="updatePassword">
                                                <div class="row">
                                                    <!-- Password -->
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="input-group mb-3">
                                                            <input v-bind:type="[showPassword ? 'text' : 'password']" v-model="password" class="form-control" placeholder="Password">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text" @click="showPassword = !showPassword">
                                                                    <i class="fa" :class="[showPassword ? 'fa-eye' : 'fa-eye-slash']" aria-hidden="true"></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Confirm Password -->
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="input-group mb-3">
                                                            <input v-bind:type="[showCPassword ? 'text' : 'password']" v-model="c_password" class="form-control" placeholder="Confirm Password">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text" @click="showCPassword = !showCPassword">
                                                                    <i class="fa" :class="[showCPassword ? 'fa-eye' : 'fa-eye-slash']" aria-hidden="true"></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Profile -->
                                    <div class="social-profile-block">
                                        <h4 class="personal-info-heading">
                                            {{ translate('frontstaticword.SocialProfile')}}
                                        </h4>
                                        <div class="row">

                                            <!-- Facebook -->
                                            <div class="col-lg-6">
                                                <div class="social-block">
                                                    <div class="form-group">
                                                        <label class="form-label" for="facebook">
                                                            {{ translate('frontstaticword.FacebookUrl')}}
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-2">
                                                                <div class="profile-update-icon">
                                                                    <a title="facebook">
                                                                        <i class="fa fa-facebook text-info"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-10">
                                                                <input type="text" id="facebook"
                                                                    class="form-control" placeholder="Facebook.com" v-model="userDetail.fb_url">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Twitter -->
                                            <div class="col-lg-6">
                                                <div class="social-block">
                                                    <div class="form-group">
                                                        <label class="form-label" for="twitter">
                                                            {{ translate('frontstaticword.TwitterUrl')}}
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-2">
                                                                <div class="profile-update-icon">
                                                                    <a title="twitter">
                                                                        <i class="fa fa-twitter text-info"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-10">
                                                                <input type="text" id="twitter"
                                                                    class="form-control" placeholder="Twitter.com" v-model="userDetail.twitter_url">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Youtube -->
                                            <div class="col-lg-6">
                                                <div class="social-block">
                                                    <div class="form-group">
                                                        <label class="form-label" for="behance2">
                                                            {{ translate('frontstaticword.YoutubeUrl')}}
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-2">
                                                                <div class="profile-update-icon">
                                                                    <a title="googleplus"><i class="fa fa-youtube text-danger"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-10">
                                                                <input type="text" id="behance2"
                                                                    class="form-control" placeholder="youtube.com" v-model="userDetail.youtube_url">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- LinkedIn -->
                                            <div class="col-lg-6">
                                                <div class="social-block">
                                                    <div class="form-group">
                                                        <label class="form-label" for="dribbble2">
                                                            {{ translate('frontstaticword.LinkedInUrl')}}
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-2">
                                                                <div class="profile-update-icon">
                                                                    <a title="linkedin"><i class="fa fa-linkedin text-info"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-10">
                                                                <input type="text" id="dribbble2"
                                                                    class="form-control" placeholder="Linkedin.com" v-model="userDetail.linkedin_url">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Update button -->
                                <button class="btn btn-danger float-right" type="submit">
                                    {{ translate('frontstaticword.UpdateProfile')}}
                                </button>
                            </form>
                        </div>

                </div>
            </div>
        </section>
                
        <!-- If user is not login -->
        <div class="col-md-12" v-else>
            <sign-in :guest="1" />
        </div>

        <footerSection />

    </div>
</template>

<script>

    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import profileSidebar from '../User/ProfileSidebar.vue';
    import signIn from '../Login.vue';

    export default {

        mixins: [mixin],

        name: 'myProfile',

        components: {
            headerSection,
            footerSection,
            profileSidebar,
            signIn
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                userDetail: {},
                updatePassword: false,
                errors: '',
                password: null,
                c_password: null,
                showPassword: false,
                showCPassword: false,
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.mainUser.fname ?? 'User'}'s Profile | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.mainUser.fname + 'Courses' + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {

            // Call the user profile API
            async callAPI() {

                let config = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }

                await axios.post('/api/show/profile', {}, config)
                    .then(res => {

                        this.userDetail = res.data.user;

                    }).catch(err => {

                        if (err.response.status === 401) {
                            console.log(err.response.data);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                    });

            },

            // Reset password field
            resetPassword() {
                this.password = null,
                this.c_password = null,
                this.showPassword = false,
                this.showCPassword = false
            },

            // Update user profile
            async updateProfile() {

                let sendData = {
                    fname: this.userDetail.fname,
                    lname: this.userDetail.lname,
                    email: this.userDetail.email,
                    mobile: this.userDetail.mobile,
                    address: this.userDetail.address,
                    country_id: this.country_id,
                    state_id: this.state_id,
                    city_id: this.city_id,
                    detail: this.userDetail.detail,
                    password: this.password,
                    status: this.status,
                    fb_url: this.userDetail.fb_url,
                    twitter_url: this.userDetail.twitter_url,
                    youtube_url: this.userDetail.youtube_url,
                    linkedin_url: this.userDetail.linkedin_url
                }

                // Check if password and confirm password match
                if(this.password != null)
                {
                    // Password length must be atleast of 6 character
                    if(this.password.length < 6 )
                    {
                        let config = {
                            text: 'Password should be atleast of 6 character',
                            button: 'CLOSE!'
                        }
                        return this.$snack['danger'](config);
                    }

                    // Password and confirm password should match
                    if(this.password != this.c_password)
                    {
                        this.password = null; 
                        this.c_password = null;
                        let config = {
                            text: 'Password does not match',
                            button: 'CLOSE!'
                        }
                        return this.$snack['danger'](config);
                        
                    }
                }

                // Call API to update   profile
                await axios.post(`/api/instructor/update/profile?secret=${this.$secretKey}`, sendData, 
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                })
                .then(res=> {

                    if(res.status === 200)
                    {
                        let config = {
                            text: "Profile updated successfully",
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.resetPassword();
                        this.callAPI();
                    }
                    
                })
                .catch(err=> {

                    console.log(err.response);
                    if(response.status === 500)
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                });
            }

        },

        mounted() {

            this.callAPI();
            this.path = axios.defaults.baseURL;

        }
    }

</script>
