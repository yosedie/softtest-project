{{-- <?php foreach($jitsimeetings as $key => $meeting){} ?> --}}

<div class="container-fluid">
    <div id='meet'></div>
</div>
<script src='https://meet.jit.si/external_api.js'></script>
<script>

const domain = 'meet.jit.si';
const options = {
    roomName: <?php echo $jitsimeetings->meeting_id; ?>,
    width: 1250,
    height: 700,
    parentNode: document.querySelector('#meet'),
    userInfo: {
            displayName: '<?php echo $jitsimeetings->meeting_title; ?>'
            
        },
    // jwt: '<jwt_token>',
    

    configOverwrite:{
            // doNotStoreRoom: true,
            // startVideoMuted: 0,
            startWithVideoMuted: true,
            startWithAudioMuted: true,
            // liveStreamingEnabled: true
            // desktopSharingFrameRate: {
            // min: 5,
            // max: 5
            // },
            enableWelcomePage: false,
            prejoinPageEnabled: false,
            enableSaveLogs: false,
            enableNoisyMicDetection: true
            // disableRemoteMute: false
            
        },
    interfaceConfigOverwrite: {
            // filmStripOnly: false,
            SHOW_JITSI_WATERMARK: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
            SHOW_BRAND_WATERMARK: false,
            SHOW_POWERED_BY: false
            //  DEFAULT_REMOTE_DISPLAY_NAME: 'New User'
            // TOOLBAR_BUTTONS: []
        }
};
const api = new JitsiMeetExternalAPI(domain, options);
api.executeCommand('subject', '<?php echo $jitsimeetings->meeting_title; ?>');

</script>