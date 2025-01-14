<template>
    <div>

        <headerSection />

        <!-- Show quiz details and Q-A -->
        <div :class="after_submit_quiz ? 'hide' : ''">

            <div v-if="loginStatus">
                <!-- Course Content Head -->
                <section class="mt-70 bg-color-gray">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 float-left">
                                <div class="heading" v-if="presentQuiz.title">
                                    <h4>{{presentQuiz.title}}</h4>
                                    <p v-html="presentQuiz.description"></p>
                                </div>
                                <div v-else>
                                    <b-skeleton height="45px"></b-skeleton>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Show quiz section -->
                <section class="mt-50" v-if="!loading">
                    <div class="container" v-if="this.purchased">
                        <form @submit.prevent="submit_quiz" v-if="questions.length > 0">
                            <!-- Objective Quiz -->
                            <div class="row" v-if="presentQuiz.type != '1'">
                                <div class="col-md-10" v-for="(question,index) in questions" :key="index">
                                    <div class="display_question_answer mb-70">
                                        <h5>
                                            {{ translate('frontstaticword.Question')}}.
                                            {{index + 1}} 
                                            {{question.question}}
                                        </h5>
                                        
                                        <p>
                                            <label>
                                                <input v-model="answer[index+1]" :id="`answer${index+1}`" type="radio" value="A"/>  {{ question.all_answers.A }}
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input v-model="answer[index+1]" :id="`answer${index+2}`"  type="radio" value="B"/> {{ question.all_answers.B }}
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input v-model="answer[index+1]" :id="`answer${index+3}`" type="radio" value="C"/>  {{ question.all_answers.C }}
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input v-model="answer[index+1]" :id="`answer${index+4}`" type="radio" value="D"/>  {{ question.all_answers.D }}
                                            </label>
                                        </p>

                                    </div>
                                </div>
                                
                            </div>
                            <!-- Subjective Quiz -->
                            <div class="row" v-else>
                                <div class="col-md-10" v-for="(question,index) in questions" :key="index">
                                    <div class="display_question_answer mb-4">
                                        <h4>
                                            {{ translate('frontstaticword.Question')}}.
                                            {{index+1}}  
                                            {{question.question}}
                                        </h4>
                                        <textarea autofocus placeholder="Please describe your answer" v-model="txt_answer[index]" class="form-control" rows="5" cols="5"></textarea> 
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <button type="submit" class="btn btn-danger mt-4">
                                    {{ translate('frontstaticword.Submit')}}
                                </button>
                            </div>
                        </form>
                        
                        <!-- If quiz has no questions -->
                        <div class="text-center" v-else>
                            <h4>
                                {{ translate('frontstaticword.noQuestionInQuiz')}}.
                            </h4>
                            <router-link :to="'/course_content/' + this.course_id + '/' + this.course_title.replace(/\s+/g, '_')">
                                {{ translate('frontstaticword.Letsgoback')}} :)
                            </router-link>
                        </div>
                    </div>

                    <!-- If user has not purchased course -->
                    <div class="container text-center" v-else>
                        <h5>{{ translate('frontstaticword.Youhavenotpurchasedthiscourse')}}.</h5>
                        <router-link :to="'/course_detail/' + this.course_id + '/' + this.course_title.replace(/\s+/g, '_')" class="btn btn-danger mt-2">
                            {{ translate('frontstaticword.GoToCourse')}}
                        </router-link>
                    </div>
                </section>

                <!-- Skeleton loading till we fetch the data from api -->
                <section class="course_content_section" v-else>
                    <div class="container padd--20">
                        <div class="row">
                            <div class="col-md-10 mt-4">
                                <b-skeleton animation="throbe" height="30px" width="80%"></b-skeleton>
                                <b-skeleton animation="wave" width="70%" class="mt-2"></b-skeleton>
                                <b-skeleton animation="wave" width="68%"></b-skeleton>
                                <b-skeleton animation="wave" width="66%"></b-skeleton>
                                <b-skeleton animation="wave" width="64%"></b-skeleton>
                            </div>
                            <div class="col-md-10 mt-4">
                                <b-skeleton animation="throbe" height="30px" width="80%"></b-skeleton>
                                <b-skeleton animation="wave" width="70%" class="mt-2"></b-skeleton>
                                <b-skeleton animation="wave" width="68%"></b-skeleton>
                                <b-skeleton animation="wave" width="66%"></b-skeleton>
                                <b-skeleton animation="wave" width="64%"></b-skeleton>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- If user is not logged in -->
            <div class="course__content__section" v-else>
                <sign-in :guest="1"/>
            </div>
        </div>

        <!-- View screen after submitting the quiz -->
        <div :class="after_submit_quiz ? '' : 'hide'">
            <div class="container">
                <div class="text-center pd-100">
                    <h3 class="mb-4">{{ translate('frontstaticword.quizSubmittedMessage')}}.</h3>
                    <router-link :to="'/course_detail/' +  this.course_id + '/' + this.course_title.replace(/\s+/g, '_')">
                        {{ translate('frontstaticword.Letsgoback')}} 
                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                    </router-link>
                    <br>
                    <img :src="`${baseurl}/modules/blizzard/images/4365502.jpg`" alt="Quiz Completed" width="50%">
                </div>
            </div>
        </div>

        <footerSection />

    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../../mixin.js';
    import headerSection from '../Header.vue';
    import footerSection from '../Footer.vue';
    import signIn from '../Login.vue';
    
    export default {
        
        name: 'quiz',

        mixins: [mixin],

        components: {
            headerSection,
            footerSection,
            signIn
        },

        data() {
            return {
                baseurl: baseurl,
                path: null,
                quizs: [],
                selected : 'selected',
                quiz_id: this.$route.params.quiz_id,
                title: this.$route.params.title,
                course_id: this.$route.params.course_id,
                course_title: this.$route.params.course_title,
                purchased: false,
                orderhistory: {},
                presentQuiz: {},
                questions: [],
                selected: [],
                txt_answer: [],
                txt_answer2: '',
                loading: true,
                canswer : [],
                answer : [],
                question_id : [],
                after_submit_quiz: false,
                meta: {
                    profileurl: window.location.href,
                },
                url: process.env.APP_NAME
            }
        },

        metaInfo() {
            return {
                title: `${this.title ?? 'Quiz'} | ${this.settings.project_title ?? 'Loading..'}`,
                meta: [
                    { name: 'description', content: this.settings.meta_data_desc},
                    { property: 'og:title', content: this.title + ' Quiz | ' + this.settings.project_title},
                    { property: 'og:site_name', content: this.settings.project_title},
                    { property: 'og:description', content: this.settings.meta_data_desc},
                    { property: 'og:type', content: 'profile'},
                    { property: 'og:url', content: this.meta.profileurl },
                    { property: 'og:image', content: this.baseurl + '/images/logo' + this.settings.logo }
                ]
            }
        },

        methods: {

            // Call API for quiz questions
            async callQuizAPI() {
                    
                this.purchasehistory(this.course_id);

                let apiData = {
                    params: {
                        secret: this.$secretKey
                    }
                }

                await axios.get(`/api/course/content/${this.course_id}`, apiData)
                .then(res=> {
                    
                    this.quizs = res.data.quiz;
                    this.quizs.forEach(quiz=> {
                        
                        if(this.quiz_id == quiz.id)
                        {
                            this.presentQuiz = quiz;
                        }
                    })

                    this.questions = this.presentQuiz.questions;
                    this.loading = false;

                }).catch(err=> {

                    console.log(err.response.data);

                });
            },
            
            //submit quiz answer
            async submit_quiz() {

                this.questions.forEach(question => {
                    this.canswer.push(question.correct_answer);
                });

                this.questions.forEach(question => {
                    this.question_id.push(question.id);
                });

                this.answer = $.grep(this.answer, function(ans) {
                    return ans != undefined;
                });
                
                await axios.post(`/api/quiz/submit?secret=${this.$secretKey}`,{

                    question_id : this.question_id,
                    canswer     : this.canswer,
                    answer      : this.answer,
                    txt_answer  : this.txt_answer,
                    course_id   : this.course_id,
                    topic_id    : this.quiz_id,

                },
                {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                })
                .then(res=> {
                    
                    if(res.data.status == 200)
                    {
                        let config = {
                            text: res.data.message,
                            button: 'CLOSE'
                        }
                        this.$snack['success'](config);
                    }

                    if(res.data.status == 'success') {
                        this.after_submit_quiz = true;
                    }

                })
                .catch(err=> {
                    console.log(err.response);
                })
            },

            // To get the purchase history of user
            async purchasehistory(id) {

                let apiData = {
                    params: 
                    {
                        secret :this.$secretKey
                    },
                    headers: 
                    {
                        'Authorization': `Bearer ${this.token}`
                    }
                }

                await axios.get('/api/purchase/history', apiData)
                .then(res => {

                    if(res.status == 200)
                    {
                        this.orderhistory = res.data.orderhistory;
                        this.orderhistory.forEach(orders => {
                            
                            if(id == orders.course_id)
                            {
                                this.purchased = true;
                                return false;
                            }
                            
                        });

                        this.loading = false;
                        
                    }
                })
            }

        },

        mounted() {

            this.callQuizAPI();
            this.path = axios.defaults.baseURL;
        }

    }
    
</script>