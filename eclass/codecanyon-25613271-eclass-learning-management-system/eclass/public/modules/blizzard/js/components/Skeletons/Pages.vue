<template>
    <div>
        <div class="col-12 col-md-12 mb-2">
            <b-skeleton height="50px"></b-skeleton>
        </div>
        <div class="col-12 col-md-12 mt-2" v-for="(loop,index) in loops" :key="index">
            <b-skeleton></b-skeleton>
        </div>
    </div>
</template>

<script>
    "use Strict";

    export default {

        name: 'pageSkeleton',

        data() {
            return {
                loop: 0,
                loops: 15
            }
        }

    }
</script>