<template>
    <div class="row">
        <div class="col-md-6 mb-4" v-for="(loop,index) in loops" :key="index">
            <div class="card">
                <b-skeleton-img></b-skeleton-img>
                <div class="card-body py-3">
                    <b-skeleton height="30px" class="mt-2"></b-skeleton>
                    <b-skeleton></b-skeleton>
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

        name: 'blogSkeleton',

        data() {
            return {
                loop: 0,
                loops: 4
            }
        }

    }
</script>