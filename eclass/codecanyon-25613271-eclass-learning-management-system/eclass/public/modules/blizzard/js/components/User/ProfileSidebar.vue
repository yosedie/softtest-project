<template>
    <div>
        
        <!-- Profile Sidebar -->
        <div class="profile-block">
            <div class="user-profile-block text-center">
                <!-- Update image form -->
                <form @submit.prevent="updateUserProfile">
                    <div class="edit-icon">
                        <input ref="fileInput" type="file" id="imageUpload" @input="pickFile">
                        <label for="imageUpload">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#7A7A7A" viewBox="0 0 30 30"
                                width="24px" height="24px">
                                <path
                                    d="M 22.828125 3 C 22.316375 3 21.804562 3.1954375 21.414062 3.5859375 L 19 6 L 24 11 L 26.414062 8.5859375 C 27.195062 7.8049375 27.195062 6.5388125 26.414062 5.7578125 L 24.242188 3.5859375 C 23.851688 3.1954375 23.339875 3 22.828125 3 z M 17 8 L 5.2597656 19.740234 C 5.2597656 19.740234 6.1775313 19.658 6.5195312 20 C 6.8615312 20.342 6.58 22.58 7 23 C 7.42 23.42 9.6438906 23.124359 9.9628906 23.443359 C 10.281891 23.762359 10.259766 24.740234 10.259766 24.740234 L 22 13 L 17 8 z M 4 23 L 3.0566406 25.671875 A 1 1 0 0 0 3 26 A 1 1 0 0 0 4 27 A 1 1 0 0 0 4.328125 26.943359 A 1 1 0 0 0 4.3378906 26.939453 L 4.3632812 26.931641 A 1 1 0 0 0 4.3691406 26.927734 L 7 26 L 5.5 24.5 L 4 23 z" />
                            </svg>
                        </label>
                    </div>
                    <!-- User Profile Image -->
                    <div class="user-profile-img">
                        <div v-if="userDetail.user_img">
                            <img :src="livePreviewImage" class="img-fluid" alt="">
                        </div>
                        <div v-else>
                            <img :src="`${baseurl}/modules/blizzard/images/user_default.jpg`" class="img-fluid" alt="user">
                        </div>
                    </div>
                    <!-- User name -->
                    <h4 class="user-profile-name">
                        {{userDetail.fname}} {{userDetail.lname}}
                    </h4>
                    <!-- Update image button -->
                    <button type="submit" class="btn btn-danger mt-4">
                        {{ translate('frontstaticword.UpdateProfile')}}
                    </button>
                </form>    
            </div>
            
            <!-- Sidebar listing -->
            <div class="account-menu-block">
                <ul>

                    <!-- My Profile -->
                    <li>
                        <router-link to="/myProfile" title="user profile">
                            <img :src="`${baseurl}/modules/blizzard/images/icons8-user.png`">
                            {{ translate('frontstaticword.UserProfile')}}
                        </router-link>
                    </li>
                    
                    <!-- My courses -->
                    <li>
                        <router-link to="/userCourses" class="active" title="user courses">
                            <img :src="`${baseurl}/modules/blizzard/images/icons8-bookmark.png`">
                            {{ translate('frontstaticword.MyCourses')}}
                        </router-link>
                    </li>
                    <!-- Wishlist -->
                    <li>
                        <router-link to="/userWishlist" title="wishlist">
                            <img :src="`${baseurl}/modules/blizzard/images/icons8-heart.png`">
                            {{ translate('frontstaticword.MyWishlist')}}
                        </router-link>
                    </li>

                    <!-- Purchase History -->
                    <li>
                        <router-link to="/purchaseHistory" title="purchase history">
                            <img :src="`${baseurl}/modules/blizzard/images/icons8-time-machine.png`">
                            {{ translate('frontstaticword.PurchaseHistory')}}
                        </router-link>
                    </li>

                    <!-- Became instructor -->
                    <li>
                        <router-link to="/becomeInstructor" title="become an instructor">
                            <img :src="`${baseurl}/modules/blizzard/images/icons8-training.png`">
                            {{ translate('frontstaticword.BecomeAnInstructor')}}
                        </router-link>
                    </li>

                    <!-- Bank Details -->
                    <li>
                        <router-link to="/bank_details" title="bank_details">
                            <img :src="`${baseurl}/modules/blizzard/images/icons8-bank.png`">
                            {{ translate('frontstaticword.MyBankDetails')}}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';

    export default {

        mixins: [mixin],

        name: 'profileSidebar',

        data() {
            return {
                baseurl: baseurl,
                path: null,
                userDetail: {},
                password: false,
                previewImage: null,
                livePreviewImage: null,
                userProfile: null
            }
        },

        components: {
            headerSection,
            footerSection
        },

        methods: {

            // Call profile API to get user image
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
                        this.livePreviewImage = `${this.path}/images/user_img/${this.userDetail.user_img}`;

                    }).catch(err => {

                        if (err.response.status === 401) {
                            console.log(err.response.data);
                        }

                        if (err.response) {
                            this.errors = err.response.data.errors;
                        }

                    });

            },

            // get the selected file of user image
            pickFile () {
                let input = this.$refs.fileInput
                let file = input.files
                if (file && file[0]) {
                let reader = new FileReader
                    reader.onload = e => {
                        this.livePreviewImage = e.target.result;
                        this.previewImage = file[0];
                    }
                    reader.readAsDataURL(file[0])
                    this.$emit('input', file[0])
                }
            },

            // Update user profile
            async updateUserProfile() {
                
                if(this.previewImage == null)
                {
                    let config= {
                        text: 'Please select image',
                        button: 'CLOSE!'
                    }
                    return this.$snack['danger'](config);
                }

                let formData = new FormData();
                formData.append('user_img', this.previewImage);
                formData.append('email', this.userDetail.email);

                let apiData = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        "Content-type" : "multipart/form-data"
                    },
                    params: {
                        secret: this.$secretKey
                    }
                }

                // Call API to update profile
                await axios.post(`/api/instructor/update/profile`, formData, apiData)
                .then(res=> {

                    if(res.status === 200)
                    {
                        let config = {
                            text: "Profile updated successfully",
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.callAPI();
                    }
                    
                }).catch(err=> {

                    console.log(err.response);
                    if(response.status === 500)
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }

                })
            }

        },

        mounted() {
            this.callAPI();
            this.path = axios.defaults.baseURL;
        }
    }

</script>
