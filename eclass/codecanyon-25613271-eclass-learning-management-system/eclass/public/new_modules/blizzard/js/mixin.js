"use Strict";

import axios from "axios";

export default {

    data(){
        return{

            mainUser:{},
            token: '',
            loginStatus: false,
            currency: {},
            settings: {},
            cookieToken: ''

        }
    },

    methods: {

        // Call user API globally for user detail
        callUserAPI(){

            if(localStorage.getItem('access_token'))
            {
                this.token = JSON.parse(localStorage.getItem('access_token'));
                
                axios.post('/api/show/profile?secret=' + this.$secretKey,{
                    //..data
                },
                {
                    headers : {
                        'Authorization': `Bearer ${this.token}` 
                    }
    
                }).then(res =>{
    
                    this.mainUser =  res.data.user;
    
                });
                
                // Store Login Status
                if (this.token){
                    this.loginStatus = true
                }

            }
        },

        // Call home API globally for currency detail
        callHomeAPI() {

            axios.get('/api/home?secret=' + this.$secretKey)
            .then(res=> {

                this.currency = res.data.currency;
                this.settings = res.data.settings;

                //right click and inspect
                if(this.settings.rightclick=='1' || this.settings.inspect=='1')
                {
                    this.disableRightInspect();
                }

            })

            
        },


        //Disable right click and inspect element
        disableRightInspect() 
        {
            if(this.settings.rightclick=='1')
            {
                window.addEventListener('contextmenu', function (e) { 
                    // do something here... 
                    e.preventDefault(); 
                }, false);  
            }
            
            if(this.settings.inspect=='1')
            {
                document.onkeydown = function(e) {
                    if(event.keyCode == 123) {
                        return false;
                    }
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                        return false;
                    }
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                        return false;
                    }
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                        return false;
                    }
                    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                        return false;
                    }
                }
            }

        }
        
    },

    mounted() 
    {
        // Call User API
        this.callUserAPI();
        // Call Home API
        this.callHomeAPI();
    },
    
 }
