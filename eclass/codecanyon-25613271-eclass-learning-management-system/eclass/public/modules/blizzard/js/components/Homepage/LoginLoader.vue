<template>
    <div>
        <!-- <b-modal ref="modal" hide-footer title="Logging">
            <b-row class="p-4">
                <b-spinner type="grow" label="Spinning"></b-spinner>
                <p class="my-4">Please wait while we redirect you!</p>
            </b-row>
        </b-modal> -->
    </div>
</template>

<script>
    
    export default {

        name: 'socialLogin',

        data()
        {
            return {
                // provider: this.$route.params.provider,
            }
        },

        methods: {
            
            //Show modal
            showModal() 
            {
                this.$refs['modal'].show()
            },

            //Hide Modal
            hideModal() {
                this.$refs['modal'].hide()
            },

            //Call API
            async callAPI()
            {
                // console.log(this.provider);
                // await axios.post(``)
            } 

        },

        mounted() 
        {
            // this.showModal();
            this.callAPI();
        }
    }
</script>