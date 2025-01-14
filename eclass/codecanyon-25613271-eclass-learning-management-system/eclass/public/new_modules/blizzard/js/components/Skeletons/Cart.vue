<template>
    <div>
        
        <!-- Courses -->
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="cart-wrapper" v-for="(loop, index) in loops" :key="index">
                    <div class="col-md-3">
                        <b-skeleton-img></b-skeleton-img>
                    </div>
                    <div class="col-md-7">
                        <b-skeleton animation="wave" height="30px"></b-skeleton>
                        <b-skeleton animation="wave" height="20px"></b-skeleton>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <b-skeleton height="30px"></b-skeleton>
                <b-skeleton class="mt-2"></b-skeleton>
                <b-skeleton></b-skeleton>
                <b-skeleton></b-skeleton>
                <b-skeleton></b-skeleton>
                <b-skeleton type="button" class="mt-2"></b-skeleton>
            </div>
        </div>
    </div>
</template>

<script>
    "use Strict";

    export default {
        
        name: 'CartSkeleton',

        data() {
            return {
                loop: 1,
                loops: 3
            }
        }
    }

</script>
