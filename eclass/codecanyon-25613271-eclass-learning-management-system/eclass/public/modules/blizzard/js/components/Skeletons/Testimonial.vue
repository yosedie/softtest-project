<template>
    <div class="container mt-70">
        <div class="row testimonial-skeleton">
            <div class="col-md-6" v-for="(loop,index) in loops" :key="index">
                <div class="media-head">
                    <div class="media align-items-md-center text-center text-lg-left mb-3">
                        <b-skeleton type="avatar" width="80px" height="80px"></b-skeleton>
                        
                        <div class="media-body ml-4">
                            <b-skeleton width="40%"></b-skeleton>
                            <b-skeleton width="60%" height="30px"></b-skeleton>
                        </div>
                    </div>

                    <b-skeleton></b-skeleton>
                    <b-skeleton></b-skeleton>
                    <b-skeleton></b-skeleton>
                    <b-skeleton></b-skeleton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    "use Strict";

    export default {

        name: 'testimonialSkeleton',

        data() 
        {
            return {
                loop: 0,
                loops: 2
            }
        }
    }
</script>