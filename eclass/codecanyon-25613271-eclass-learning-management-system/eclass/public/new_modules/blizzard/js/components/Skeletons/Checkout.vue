<template>
    <div class="row mb-4 mt-4">
        <div class="col-md-8">
            <b-skeleton height="30px" width="30%"></b-skeleton>
            <b-skeleton width="50%" class="mt-2"></b-skeleton>
            <b-skeleton width="50%"></b-skeleton>
            <b-skeleton width="50%"></b-skeleton>
            <b-skeleton width="50%"></b-skeleton>
            <b-skeleton-img no-aspect height="250px"></b-skeleton-img>
        </div>
        <div class="col-md-4">
            <b-skeleton width="50%" height="30px"></b-skeleton>
            <b-skeleton class="mt-2"></b-skeleton>
            <b-skeleton></b-skeleton>
            <b-skeleton></b-skeleton>
            <b-skeleton></b-skeleton>
            <b-skeleton type="button" class="btn-block"></b-skeleton>
        </div>
    </div>
</template>

<script>
    "use Strict";

    export default {
        
        name: 'checkoutSkeleton'

    }
</script>