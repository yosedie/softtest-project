<template>
    <div>
        <div class="container">
            <div class="row course-tabs mt-4">
                <div class="col-md-4" v-for="loop in loops" :key="loop">
                    <div class="card">
                        <b-skeleton-img width="100%"></b-skeleton-img>
                        <div class="card-body py-3">
                            <b-skeleton height="20px" class="mt-2"></b-skeleton>
                            <b-skeleton></b-skeleton>
                            <div class="row">
                                <div class="col-md-2">
                                    <b-skeleton type="avatar"></b-skeleton>
                                </div>
                                <div class="col-md-10">
                                    <b-skeleton class="mt-2" height="25px"></b-skeleton>
                                </div>
                            </div>
                            <b-skeleton height="30px" class="mt-2"></b-skeleton>
                            <span class="hide">{{loop+1}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    "use Strict";

    export default {

        name: 'UserCoursesSkeleton',

        data() {
            return {
                loop: 0,
                loops: 3
            }
        }
        
    }
</script>