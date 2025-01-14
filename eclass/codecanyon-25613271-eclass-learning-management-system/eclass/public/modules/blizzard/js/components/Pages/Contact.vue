<template>
    <div>

        <header-section />
        
        <!-- Page Heading -->
        <div class="blog-header">
            <div class="blog-title">
                <h1>
                    {{ translate('frontstaticword.Contactus')}}
                </h1>
            </div>
        </div>

        <!-- Contact Section -->
        <section class="pd-30 mt-50">
            <div class="container">
                <div class="row">

                    <!-- Contact image -->
                    <div class="col-md-6" v-if="!loading">
                        <div class="contact-img">
                            <img :src="settings.contact_image!=null ? `${path}/images/contact/${settings.contact_image}` : `${baseurl}/modules/blizzard/images/contact_us_default.jpg`" :alt="translate('frontstaticword.Contactus')">
                        </div>
                    </div>

                    <!-- Skeleton loading till we fetch image -->
                    <div class="col-md-6" v-else>
                        <b-skeleton-img></b-skeleton-img>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h4>
                            {{ translate('frontstaticword.KeepinTouch')}}
                        </h4>

                        <!-- Form Start -->
                        <form @submit.prevent="sendMessage()">

                            <!-- Name -->
                            <b-form-group id="input-group-1" label-for="input-group-1" class="mt-2">
                                <b-form-input
                                id="input-1"
                                v-model="$v.form.fname.$model"
                                :state="validateState('fname')"
                                :placeholder=" translate('frontstaticword.EnterName')"
                                aria-describedby="input-1-live-feedback"
                                ></b-form-input>

                                <b-form-invalid-feedback
                                    id="input-1-live-feedback"
                                >
                                    {{ translate('frontstaticword.Thisisarequiredfield')}}.
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <!--Phone Number  -->
                            <b-form-group id="input-group-2" label-for="input-group-2" class="mt-2">
                                <b-form-input
                                id="input-2"
                                v-model="$v.form.mobile.$model"
                                type="number"
                                :state="validateState('mobile')"
                                :placeholder="translate('frontstaticword.EnterPhoneNumber')"
                                aria-describedby="input-2-live-feedback"
                                ></b-form-input>

                                <b-form-invalid-feedback id="input-2-live-feedback">
                                    {{ translate('frontstaticword.Thisisarequiredfield')}}.
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <!-- Email -->
                            <b-form-group
                            id="input-group-3"
                            label-for="input-group-3"
                            class="mt-2"
                            description="We'll never share your email with anyone else."
                            >
                                <b-form-input
                                id="input-3"
                                v-model="$v.form.email.$model"
                                :state="validateState('email')"
                                type="email"
                                :placeholder="translate('frontstaticword.Enteremail')"
                                aria-describedby="input-3-live-feedback"
                                ></b-form-input>

                                <b-form-invalid-feedback id="input-3-live-feedback">
                                    {{ translate('frontstaticword.Thisisarequiredfield')}}.
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <!-- Message -->
                            <b-form-group id="input-group-4" label-for="input-group-4" class="mt-2">
                                <b-form-textarea
                                id="textarea"
                                v-model="$v.form.message.$model"
                                :state="validateState('message')"
                                :placeholder="translate('frontstaticword.Entersomething')+'...'"
                                rows="3"
                                aria-describedby="input-4-live-feedback"
                                max-rows="6"
                                >
                                </b-form-textarea>

                                <b-form-invalid-feedback id="input-4-live-feedback">
                                    {{ translate('frontstaticword.Thisisarequiredfieldandmustbeatleastcharacters')}}.
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <!-- Send message button -->
                            <b-button type="submit" variant="secondary" size="lg" class="mt-2">
                                {{ translate('frontstaticword.Message')}}
                            </b-button>
                            <b-button variant="outline-secondary" size="lg" class="ml-2 mt-2" @click="resetForm()">
                                {{ translate('frontstaticword.Reset')}}
                            </b-button>

                        </form>
                        <!-- Form End -->
                    </div>
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
    import { validationMixin } from 'vuelidate';
    import { required, minLength } from "vuelidate/lib/validators";

    export default {

        name: 'contact_us',

        mixins: [mixin, validationMixin],

        components: {
            headerSection,
            footerSection
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                loading: true,
                form: {
                    fname: null,
                    email: null,
                    mobile: null,
                    message: null
                },
                meta: {
                    name: 'Contact Us',
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        // Meta tags / seo information
        metaInfo() {
            return {
                title: `${this.meta.name} | ${this.settings.project_title ?? 'Loading..'}`,
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

        // Contact us form validations
        validations: {
            form: {
                fname: {
                    required
                },
                email: {
                    required
                },
                mobile: {
                    required
                },
                message: {
                    required,
                    minLength: minLength(10)
                },
            }
        },

        methods: {

            // Validation message
            validateState(message) {
                const {
                    $dirty,
                    $error
                } = this.$v.form[message];
                return $dirty ? !$error : null;
            },

            // Reset contact form
            resetForm() {
                this.form = {
                    fname: null,
                    email: null,
                    mobile: null,
                    message: null
                };
                this.$nextTick(() => {
                    this.$v.$reset();
                });
            },

            // Send Contact Message
            async sendMessage() {

                this.$v.form.$touch();
                if (this.$v.form.$anyError) {
                    return;
                }

                let sendData = {
                    fname: this.form.fname,
                    email: this.form.email,
                    mobile: this.form.mobile,
                    message: this.form.message
                }

                await axios.post(`/api/contactus?secret=${this.$secretKey}`, sendData)
                    .then(res => {

                        if (res.status == 200) {
                            let config = {
                                text: 'We will reach you soon :)',
                                button: 'CLOSE!'
                            }
                            this.$snack['success'](config);
                            this.resetForm();
                        }

                    })
                    .catch(err => {
                        console.log(err.response);
                    })
            }
        },

        mounted() 
        {
            this.path = axios.defaults.baseURL;
            setTimeout(() => {
                this.loading = false;
            }, 6000);

        }
    }
</script>