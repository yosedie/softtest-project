<template>
    <div>
        <headerSection />

        <!-- User section -->
        <section class="user-profile-main-block">
            <div class="container">
                <div class="row" v-if="loginStatus">
                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-5">
                        <profileSidebar />
                    </div>

                    <!-- User Banks -->
                    <div class="col-lg-8 col-md-7">
                        <div class="personal-block">
                            <div class="personal-info-block">
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-7">
                                        <h4 class="bank-data-heading">{{ translate('frontstaticword.BankDetails')}}</h4>
                                    </div>

                                    <!-- Add Bank Button -->
                                    <div class="col-lg-6 col-md-5">
                                        <div class="float-right">
                                            <b-button variant="outline-danger" v-b-modal.modal-prevent-closing>
                                                {{ translate('frontstaticword.AddBank')}}
                                            </b-button>
                                        </div>
                                    </div>

                                    <!-- Submit bank details modal -->
                                    <b-modal
                                    id="modal-prevent-closing"
                                    ref="modal"
                                    :title="translate('frontstaticword.AddBankDetails')"
                                    @show="resetModal"
                                    @hidden="resetModal"
                                    @ok="handleOk" :ok-title="translate('frontstaticword.Submit')"
                                    >
                                        <form ref="form" @submit.prevent="submitBankDetail">
                                            <!-- Enter holder name -->
                                            <b-form-group
                                            :label="translate('frontstaticword.Accountholdername')+':'"
                                            label-for="name-input"
                                            :invalid-feedback="translate('frontstaticword.Holdernameisrequired')"
                                            :state="account_holder_name_state"
                                            >
                                                <b-form-input
                                                    id="name-input"
                                                    v-model="account_holder_name"
                                                    :state="account_holder_name_state"
                                                    :placeholder="translate('frontstaticword.Pleaseenteraccountholdername')"
                                                    required
                                                ></b-form-input>
                                            </b-form-group>

                                            <!-- Enter bank name -->
                                            <b-form-group
                                            :label="translate('frontstaticword.BankName')+':'"
                                            label-for="name-input"
                                            :invalid-feedback="translate('frontstaticword.Banknameisrequired')"
                                            :state="bank_name_state"
                                            >
                                                <b-form-input
                                                    id="name-input"
                                                    v-model="bank_name"
                                                    :state="bank_name_state"
                                                    :placeholder="translate('frontstaticword.Pleaseenterbankname')"
                                                    required
                                                ></b-form-input>
                                            </b-form-group>

                                            <!-- Enter account number -->
                                            <b-form-group
                                            :label="translate('frontstaticword.AccountNumber')+':'"
                                            label-for="name-input"
                                            :invalid-feedback="translate('frontstaticword.AccountNumberisrequired')"
                                            :state="account_number_state"
                                            >
                                                <b-form-input
                                                    id="name-input"
                                                    v-model="account_number"
                                                    :state="account_number_state"
                                                    type="number"
                                                    :placeholder="translate('frontstaticword.Pleaseenteraccountnumber')"
                                                    required
                                                ></b-form-input>
                                            </b-form-group>

                                            <!-- Enter IFSC Code -->
                                            <b-form-group
                                            :label="translate('frontstaticword.IFSCCode')+':'"
                                            label-for="name-input"
                                            :invalid-feedback="translate('frontstaticword.IFSCCodeisrequired')"
                                            :state="ifcs_code_state"
                                            >
                                                <b-form-input
                                                    id="name-input"
                                                    v-model="ifcs_code"
                                                    :state="ifcs_code_state"
                                                    :placeholder="translate('frontstaticwordPleaseenterIFSCCode')"
                                                    required
                                                ></b-form-input>
                                            </b-form-group>
                                        </form>
                                    </b-modal>

                                </div>

                                <div class="row">    
                                    <!-- Show bank details -->
                                    <div class="col-md-12">
                                        <table class="table table-hover">
                                            <!-- Table Headings -->
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ translate('frontstaticword.A/CHolderName')}}</th>
                                                    <th scope="col">{{ translate('frontstaticword.Bankname')}}</th>
                                                    <th scope="col">{{ translate('frontstaticword.A/CNo')}}</th>
                                                    <th scope="col">{{ translate('frontstaticword.IFSCCode')}}</th>
                                                    <!-- <th scope="col">Actions</th> -->
                                                </tr>
                                            </thead>
                                            <!-- Table Details -->
                                            <tbody>
                                                <tr v-for="(user_bankdetail,index) in user_bankdetails" :key="index">
                                                    <td>{{index + 1}}</td>
                                                    <td>{{user_bankdetail.account_holder_name}}</td>
                                                    <td>{{user_bankdetail.bank_name}}</td>
                                                    <td>{{user_bankdetail.account_number}}</td>
                                                    <td>{{user_bankdetail.ifcs_code}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- If user is not login -->
                <div class="col-md-12" v-else>
                    <sign-in :guest="1"/>
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
    import signIn from '../Login.vue';

    export default {

        mixins: [mixin],

        name: 'bank_details',

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
                user_bankdetails: [],
                bank_name: '',
                bank_name_state: null,
                ifcs_code: '',
                ifcs_code_state: null,
                account_number: '',
                account_number_state: null,
                account_holder_name: '',
                account_holder_name_state: null,
                meta: {
                    name: 'User Bank',
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
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {

            // get user bank detials
            async getBankDetails() {

                let apiData = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }
                await axios.get(`/api/user/bankdetails?secret=${this.$secretKey}`,apiData)
                .then(res=> {
                    
                    this.user_bankdetails = res.data.user_bankdetail;
                })
                .catch(err=> console.log(err.response));
            },

            // reset form after submission
            resetModal() {
                this.bank_name = '',
                this.bank_name_state = null,
                this.ifcs_code = '',
                this.ifcs_code_state = null,
                this.account_number = '',
                this.account_number_state = null,
                this.account_holder_name = '',
                this.account_holder_name_state = null
            },

            // Check validation for bank detail submission
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.bank_name_state = valid
                this.ifcs_code_state = valid
                this.account_number_state = valid
                this.account_holder_name_state = valid
                return valid
            },

            // Handle submit operation
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.submitBankDetail()
            },

            // Submit bank details api
            async submitBankDetail() {

                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                    return
                }

                let formData = {
                    bank_name: this.bank_name,
                    ifcs_code: this.ifcs_code,
                    account_number: this.account_number,
                    account_holder_name: this.account_holder_name
                }

                let apiData = {
                    params: {
                        secret: this.$secretKey
                    },
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }
                
                await axios.post(`/api/add/bankdetails`, formData, apiData)
                .then(res=> {
                    
                    // If detail submit succssfully
                    if(res.data.status == 'success')
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                        this.getBankDetails();
                        // Hide the modal manually
                        this.$nextTick(() => {
                            this.$bvModal.hide('modal-prevent-closing')
                        });
                    }
                    
                    // If status fail
                    if(res.status == 'fail')
                    {
                        let config = {
                            text: res.data,
                            button: 'CLOSE'
                        }
                        this.$snack['danger'](config);
                    }
                })
                .catch(err=> { console.log(err.response); })
            }
        },
        
        mounted() {
            this.getBankDetails();
            this.path = axios.defaults.baseURL;
        }
    }
</script>