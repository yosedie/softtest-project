<template>
    <div>

        <!-- Section one skeleton loading -->
        <section class="p-y80 bg-light">
            <div class="container">
                <div class="row mt-4 mb-4">
                    <div class="col-md-6">
                        <b-skeleton class="mt-4" height="40px"></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton type="button"></b-skeleton>
                    </div>
                    <div class="col-md-6">
                        <b-skeleton-img></b-skeleton-img>
                    </div>
                </div>
            </div>    
        </section>
        
        <!-- Section three skeleton loading -->
        <section>
            <div class="row pd-100">
                <div class="pd-50 bg-light col-md-6">
                    <b-skeleton height="40px" width="80%"></b-skeleton>
                    <b-skeleton height="40px" width="80%"></b-skeleton>
                    <b-skeleton height="40px" width="80%"></b-skeleton>
                </div>
                <div class="contact__img col-md-6 pl-none">
                    <b-skeleton-img></b-skeleton-img>
                </div>
            </div>
        </section>

        <!-- Section four skeleton loading -->
        <section class="mb-4">
            <div class="container-fluid pl-none pr-none">
                <div class="row no-gutters">
                    <div class="col-md-3" v-for="(loop,index) in loops" :key="index">
                        <b-skeleton-img></b-skeleton-img>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section six skeleton loading -->
        <section class="section__six">
            <div class="container">
                <div class="mb-30">
                    <b-skeleton width="30%" height="30px"></b-skeleton>
                    <b-skeleton></b-skeleton>
                </div>

                <div class="row">
                    <div class="col-md-4" v-for="(loop,index) in loopSix" :key="index">
                        <p class=" career__six__list__name">
                            <b-skeleton></b-skeleton>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
    </div>
</template>

<script>
    "use Strict";

    export default {

        name: 'carrerSkeleton',

        data() 
        {
            return {
                loop:0,
                loops: 4,
                loopSix: 6
            }
        }

    }
</script>