<template>
    <div class="mt-4">
        <b-row v-for="(loop,index) in loops" :key="index" class="mb-4">
            <b-col cols="4">
                <b-skeleton-img></b-skeleton-img>
            </b-col>
            <b-col cols="6">
                <b-skeleton animation="throb" height="30px" width="90%"></b-skeleton>
                <br>
                <b-skeleton width="75%"></b-skeleton>
                <b-skeleton width="75%"></b-skeleton>
                <b-skeleton width="75%"></b-skeleton>
                <b-skeleton width="75%"></b-skeleton>

            </b-col>
            <b-col cols="2">
                <b-skeleton type="button"></b-skeleton>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    "use Strict";

    export default {

        name: 'filterSkeleton',

        data()
        {
            return {
                loop: 0,
                loops: 4
            }
        }
        
    }
</script>