<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3" v-for="(loop,index) in loops" :key="index">
                <b-skeleton width="80%" height="50px"></b-skeleton>  
                <b-skeleton width="50%" class="mt-4"></b-skeleton>  
                <b-skeleton width="50%" class="mt-2"></b-skeleton>  
                <b-skeleton width="50%" class="mt-2"></b-skeleton>  
                <b-skeleton width="50%" class="mt-2"></b-skeleton>  
            </div>
        </div>
    </div>    
</template>

<script>
    "use Strict";

    export default {

        name: 'footerSkeleton',

        data() {
            return {
                loop: 0,
                loops:4
            }
        }

    }
</script>