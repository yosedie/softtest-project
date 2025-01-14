<template>
    <div class="row mt-100 mb-100">
        <div class="col-md-8">
            <b-skeleton height="30px" width="40%" animation="throbe" class="mt-2"></b-skeleton>
            <b-skeleton-img></b-skeleton-img>
        </div>
        <div class="col-md-4">
            <b-skeleton height="40px" width="80%" animation="throbe" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton height="30px" width="50%" class="mt-2"></b-skeleton>
            <b-skeleton type="button" class="mt-2"></b-skeleton>
        </div>
    </div>    
</template>

<script>
    "use Strict";

    export default {

        name: 'blogDetailSkeleton'
        
    }
</script>