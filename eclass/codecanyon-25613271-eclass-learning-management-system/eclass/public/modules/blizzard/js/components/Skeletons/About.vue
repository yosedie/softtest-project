<template>
    <div>

        <!-- Section One -->
        <section>
            <b-skeleton-img no-aspect height="300px"></b-skeleton-img>
        </section>

        <!-- Section Two -->
        <section>
            <div class="container mt-4">
                <b-row>
                    <b-col md="6" offset-md="5">
                        <b-skeleton height="50px" width="40%"></b-skeleton>
                    </b-col>
                    <b-col md="10" class="mt-2" offset-md="1">
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                    </b-col>
                </b-row>

                <b-row class="mt-4">
                    <div class="col-md-4">
                        <b-skeleton-img no-aspect height="120px" width="80%"></b-skeleton-img>
                        <br>
                        <b-skeleton-img no-aspect height="120px" width="80%"></b-skeleton-img>
                        <br>
                        <b-skeleton-img no-aspect height="120px" width="80%"></b-skeleton-img>
                    </div>
                    <div class="col-md-8">
                        <b-skeleton-img no-aspect height="310px"></b-skeleton-img>
                        <b-skeleton width="30%" height="30px" class="mt-2"></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                    </div>
                </b-row>
            </div>
        </section>

        <!-- Section Three -->
        <section class="bg-light mt-4 pd-30">
            <b-row class="mt-2">
                <b-col md="6" offset="5">
                    <b-skeleton height="40px" width="40%"></b-skeleton>
                </b-col>
                <b-col md="10" class="mt-2" offset-md="1">
                    <b-skeleton></b-skeleton>
                    <b-skeleton></b-skeleton>
                </b-col>
            </b-row>
            
            <b-row class="pd-30 ml-4 mr-4">
                <b-col md="2" v-for="(loop,index) in loops" :key="index">
                    <b-skeleton height="60px"></b-skeleton>
                    <b-skeleton></b-skeleton>
                </b-col>
            </b-row>
        </section>

        <!-- Section Four -->
        <section class="mt-70">
            <div class="container">
                <b-row>
                    <b-col md="5" offset="1">
                        <b-skeleton-img no-aspect height="200px"></b-skeleton-img>
                    </b-col>

                    <b-col md="5">
                        <b-skeleton-img no-aspect height="200px"></b-skeleton-img>
                    </b-col>
                </b-row>

                <b-row class="mt-2">
                    <b-col md="12" offset="1">
                        <b-skeleton width="50%" height="30px"></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton></b-skeleton>
                        <b-skeleton width="30%"></b-skeleton>
                    </b-col>
                </b-row>
            </div>
        </section>

        <!-- Section Six -->
        <section class="mt-50 bg-light p-4">
            <div class="container">
                <b-row>
                    <b-col md="6" offset="5">
                        <b-skeleton height="40px" width="40%"></b-skeleton>
                    </b-col>
                </b-row>

                <b-row class="mt-4">
                    <b-col md="4" v-for="(loop,index) in 3" :key="index">
                        <b-skeleton-img no-aspect height="100px"></b-skeleton-img>
                    </b-col>
                </b-row>
            </div>
        </section>
        
        <section>
            <b-row class="p-4">
                <b-col md="8" offset="4">
                    <b-skeleton width="20%" height="30px"></b-skeleton>
                </b-col>
            </b-row>
        </section>
    </div>
</template>

<script>
    "use Strict";

    export default {

        name: 'aboutSkeleton',

        data(){
            return {
                loop:0,
                loops: 6
            }
        }

    }
</script>