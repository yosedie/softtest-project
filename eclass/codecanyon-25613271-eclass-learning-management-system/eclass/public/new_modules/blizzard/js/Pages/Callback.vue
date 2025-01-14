<template>
    <div>
        <b-modal ref="my-modal" centered hide-footer hide-header size="lg" v-if="!alert">
            <div class="d-block text-center">
                <b-spinner type="grow" label="Spinning"></b-spinner>
                {{ translate('frontstaticword.Pleasewaitwhilewecheckyourdetails')}}...
            </div>
        </b-modal>

        <b-modal ref="my-modal" centered hide-footer hide-header size="lg" v-if="alert">
            <div class="d-block text-center text-danger">
                {{ translate('frontstaticword.usedCodeLoginAgain')}}
            </div>
        </b-modal>
        
    </div>
</template>

<script>


export default 
{
    data(){
        return{
            alert: false
        }
    },

    props : [
        'access_token','status','msg'
    ],

    methods: 
    {
        //Show Modal
        showModal() 
        {
            this.$refs['my-modal'].show()
        }
    },

    created(){
        // store this.access_token to storage folder
        if(this.status == 200)
        {
            localStorage.setItem('access_token', JSON.stringify(this.access_token));
            location.href = '/';
        }
        else
        {
            // router push to login
            this.alert = true;
            location.href = '/signIn';
        }
    },

    mounted() 
    {
      this.showModal();
    }
}
</script>

<style>

    .modal-body{
        padding: 5rem;
    }
    .modal-content{
        height: 30vh;
        font-size: 20px;
    }

</style>