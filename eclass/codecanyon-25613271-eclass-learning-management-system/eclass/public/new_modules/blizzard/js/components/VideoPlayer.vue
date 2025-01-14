<template>
    <div>
        <div>
            
            <!-- <video ref="videoPlayer" class="video-js"></video> -->
            <video-js
                controls
                preload="auto"
                ref="video-player"
                class="video-js vjs-big-play-centered"
            >

                <source :src="src" />

            </video-js>

        </div>
    </div>
</template>

<script>
"use Strict";

import videojs from 'video.js';
import '../../../../node_modules/video.js/dist/video.min.js';
import '../../../../node_modules/videojs-youtube/dist/Youtube';

export default {

    props: [
        "src"
    ],

    data(){
        return {
            player: null,
        };
    },

    mounted()
    {
        const element = this.$refs['video-player']
        this.player = videojs(element, {
            fluid: true,
        });
        this.player.volume(0.5);
    }
}

</script>