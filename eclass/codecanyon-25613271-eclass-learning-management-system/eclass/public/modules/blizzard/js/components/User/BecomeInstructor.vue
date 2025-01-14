<template>
    <div>

        <headerSection />

        <!-- User section -->
        <section class="user-profile-main-block">
            <div class="container">
                <div class="row">

                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-5">
                        <profileSidebar />
                    </div>

                    <!-- Show instructor form if user have not requested earlier -->
                    <div class="col-lg-8 col-md-7" :class="request_status ? 'hide' : ''">
                        <!-- Instructor Form -->
                        <form @submit.prevent="becomeInstructor" enctype="multipart/form-data">
                        
                            <div class="personal-block">
                                <div class="personal-info-block">
                                    <h4 class="personal-info-heading">
                                        {{ translate('frontstaticword.BecomeAnInstructor')}}
                                    </h4>
                                    
                                    <div class="row">
                                        <!-- First Name -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.FirstName')}}
                                                </label>
                                                <input type="text" class="form-control" :placeholder="translate('frontstaticword.EnterFirstName')"  v-model="fname" required>
                                            </div>
                                        </div>

                                        <!-- Last name -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.LastName')}}
                                                </label>
                                                <input type="text" class="form-control" :placeholder="translate('frontstaticword.EnterLastName')" v-model="lname" required>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.Email')}}
                                                </label>
                                                <input type="email" class="form-control" :placeholder="translate('frontstaticword.Pleaseenteremailaddress')" v-model="email" required>
                                            </div>
                                        </div>

                                        <!-- Mobile -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.Mobile')}}
                                                </label>
                                                <input type="number" class="form-control" :placeholder="translate('frontstaticword.EnterMobileNo')" v-model="mobile" required>
                                            </div>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.DateofBirth')}}
                                                </label>
                                                <input type="date" class="form-control" v-model="dob" required>
                                            </div>
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ translate('frontstaticword.Gender')}}
                                                </label>
                                                <input type="text" v-model="gender" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail -->
                                    <div class="author-bio-form">
                                        <div class="form-group">
                                            <label class="form-label" for="bio">
                                                {{ translate('frontstaticword.Detail')}}
                                            </label>
                                            <textarea id="detail" name="detail" class="form-control" :placeholder="translate('frontstaticword.Enteryourdetails')"
                                                v-model="detail" required></textarea>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <!-- Resume -->
                                        <div class="col-lg-6 col-md-12">
                                            <b-form-group
                                            :label="translate('frontstaticword.UploadResume')"
                                            label-for="upload-resume">
                                                <b-form-file
                                                    v-model="file"
                                                    :placeholder="translate('frontstaticword.Chooseafileordropithere')+'...'"
                                                    :drop-placeholder="translate('frontstaticword.Dropfilehere')"
                                                ></b-form-file>
                                                <div class="mt-3">
                                                    {{ translate('frontstaticword.Selectedfile')+':'}} 
                                                    {{ file ? file.name : '' }}
                                                    </div>
                                            </b-form-group>
                                        </div>

                                        <!-- Image -->
                                        <div class="col-lg-6 col-md-12">
                                            <b-form-group
                                                :label="translate('frontstaticword.UploadImage')"
                                                label-for="upload-image"
                                            >
                                                <b-form-file
                                                v-model="image"
                                                :placeholder="translate('frontstaticword.Chooseafileordropithere')+'...'"
                                                :drop-placeholder="translate('frontstaticword.Dropfilehere')"
                                                >
                                                </b-form-file>
                                                <div class="mt-3">
                                                    {{ translate('frontstaticword.Selectedfile')+':'}}
                                                    {{ image ? image.name : '' }}
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Submit button -->
                            <button class="btn btn-danger float-right" @click="becomeInstructor">
                                {{ translate('frontstaticword.Submit')}}
                            </button>

                        </form>
                    </div>

                    <!-- If user have already requested to became an instructor -->
                    <div class="col-lg-8" :class="request_status ? '' : 'hide'">
                        <div class="padd--50 text-center bg-color-white">
                            <h4>
                                {{ translate('frontstaticword.Youhavealreadyrequestedtobecameaninstructor')}}.
                            </h4>
                            <button class="btn btn-danger mt-4" @click="cancelRequest">
                                {{ translate('frontstaticword.Cancel')}} {{ translate('frontstaticword.Request')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <footerSection />

    </div>
</template>

<script>

    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import profileSidebar from '../User/ProfileSidebar.vue';

    export default {

        mixins: [mixin],

        name: 'myProfile',

        data() {
            return {
                baseurl: baseurl,
                fname: '',
                lname: '',
                email: '',
                mobile: '',
                dob: '',
                gender: '',
                detail: '',
                file: '',
                image: '',
                errors: '',
                request_status: false,
                meta: {
                    name: 'Become Instructor',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.meta.name + ' | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    {property: 'og:type', content: 'profile'},
                    {property: 'og:url', content: this.meta.profileurl },
                    {property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        components: {
            headerSection,
            footerSection,
            profileSidebar
        },

        methods: {

            // To reset the form after submission of form
            reset() {
                this.fname = '';
                this.lname = '';
                this.email = '';
                this.mobile = '';
                this.dob = '';
                this.gender = '';
                this.detail = '';
                this.file = '';
                this.image = '';
            },

            // Submit instructor form-detail
            async becomeInstructor() {

                let formData = new FormData();
                formData.append('fname', this.fname)
                formData.append('lname', this.lname)
                formData.append('email', this.email)
                formData.append('mobile', this.mobile)
                formData.append('dob', this.dob)
                formData.append('gender', this.gender)
                formData.append('detail', this.detail)
                formData.append('file', this.file)
                formData.append('image', this.image)                

                let config = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                }

                await axios.post('/api/instructor/request', formData , config)
                .then(res => {
                    
                    if(res.status == 200) {
                        let data = {
                            text: 'Request Sended!',
                            button: 'CLOSE'
                        }
                        this.$snack['success'](data);
                        this.reset();
                        this.request_status = true;
                    }

                }).catch(err => {

                    console.log(err.response);

                    if (err.response.status === 401) {
                        let data = {
                            text: err.response.data,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](data);
                    }

                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }

                });

            },

            // Check if instructor already exist
            async checkInstructorStatus() {

                let apiData = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                    }
                }

                await axios.get(`/api/instructor/request/check`, apiData)
                .then(res=> {

                    if(res.data.status  == 'success')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.request_status = true;
                    }
                    else
                    { this.request_status = false; }
                    
                    if(res.data.status == 'fail')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.request_status = false;
                    }
                })
                .catch(err=> {
                    console.log(err.response);
                })
            },

            // Cancel the became an instructor request
            async cancelRequest() {

                await axios.post(`/api/cancel/instructor/request?secret=${this.$secretKey}`,{
                    //data
                },
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                    }
                })
                .then(res=> {

                    if(res.data.status == 'success')
                    {
                        let config= {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.request_status = false;
                    }

                })
                .catch(err=> {
                    console.log(err.response);
                })
            }

        },

        mounted() {
            this.checkInstructorStatus();
        }
    }

</script>
