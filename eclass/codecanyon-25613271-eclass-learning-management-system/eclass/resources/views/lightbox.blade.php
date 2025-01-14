<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{{ $class->courses->title }}</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1 user-scalable=no" />
		<script src="{{asset('js/jquery.min.js')}}"></script>
		<link rel="stylesheet" href="{{url('content/global.css')}}"/>
		{{-- <script src="https://webdesign-flash.ro/p/uvp/js/main.js"></script>  --}}
		<script src="https://webdesign-flash.ro/p/uvp/js/FWDSI.js"></script>
		<?php
	    	$psetting = App\PlayerSetting::first();
		?>
<script src="{{url('js/FWDUVPlayer.js')}}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPData.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPVideoScreen.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPComplexButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPContextMenu.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPXConsole.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPController.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPDisplayObject.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPEventDispatcher.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPInfo.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDXAnimation.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPreloader.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPVolumeButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPUtils.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPoster.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPSimpleButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPTransformDisplayObject.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPHider.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPYoutubeScreen.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPYTBQButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPLogo.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPCategories.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPCategoriesThumb.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPToolTip.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPlaylist.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPlaylistThumb.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDXUVPDL.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPEmbedWindow.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPSimpleSizeButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPInfoWindow.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPAdsButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPAdsStart.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPSubtitle.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPShareWindow.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPVimeoScreen.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPOpener.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPreloader2.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPLightBox.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPupupAds.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPopupAddButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPAnnotations.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPAnnotation.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPComboBox.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPComboBoxSelector.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPComboBoxButton.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPAudioScreen.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPPassword.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPOPWindow.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPScrubberToolip.js') }}"></script>
<script type="text/javascript" src="{{ url('content/js/FWDUVPContextMenuButton.js') }}"></script>

		<style>
			.UVPSubtitle
			{
				font-family:Arial !important;
				text-align:center !important;
				color:{{optional($psetting)->subtitle_color}}!important;
				text-shadow: 0px 0px 1px #000000 !important;
				font-size:{{optional($psetting)->subtitle_font_size}}px!important;
				line-height:{{optional($psetting)->subtitle_font_size}}px!important;
			    font-weight:600 !important;
				margin:0px !important;
				padding:0px !important;
				margin-left:20px !important;
				margin-right:20px !important;
				margin-bottom:12px !important;
			}
		</style>
		
		<!-- Setup video player-->
		<script type="text/javascript">
			FWDUVPUtils.onReady(function(){
				
				new FWDUVPlayer({		
					//main settings
					instanceName:"player1",
					parentId:"myDiv",
					playlistsId:"courseplaylist",
					mainFolderPath:"{{url('content')}}",
					skinPath:"minimal_skin_dark",
					displayType:"responsive",
					initializeOnlyWhenVisible:"no",
					useVectorIcons:"yes",
					fillEntireVideoScreen:"no",
					fillEntireposterScreen:"yes",
					goFullScreenOnButtonPlay:"no",
					playsinline:"yes",
					privateVideoPassword:"428c841430ea18a70f7b06525d4b748a",
					youtubeAPIKey:"",
					useHEXColorsForSkin:"no",
					normalHEXButtonsColor:"#FF0000",
					useDeepLinking:"yes",
					googleAnalyticsMeasurementId:"G-842HPC3W6L",
					useResumeOnPlay:"no",
					showPreloader:"yes",
					preloaderBackgroundColor:"#000000",
					preloaderFillColor:"#FFFFFF",
					addKeyboardSupport:"yes",
					autoScale:"yes",
					showButtonsToolTip:"yes", 
					stopVideoWhenPlayComplete:"no",
					playAfterVideoStop:"no",
					autoPlay:"no",
					autoPlayText:"Click To Unmute",
					loop:"no",
					shuffle:"no",
					showErrorInfo:"yes",
					maxWidth:980,
					maxHeight:552,
					buttonsToolTipHideDelay:1.5,
					volume:.03,
					rewindTime:10,
					backgroundColor:"#000000",
					videoBackgroundColor:"#000000",
					posterBackgroundColor:"#000000",
					buttonsToolTipFontColor:"#5a5a5a",
					//logo settings
					@if(optional($psetting)->logo_enable ==1)
					showLogo:"yes",
					@else
					showLogo:"no",
					@endif
					logoPath:"",
					hideLogoWithController:"yes",
					logoPosition:"topRight",
					logoLink:"{{ config('app.url') }}",
					logoTarget: '_blank',
					logoPath:"",
					logoMargins:10,
					//playlists/categories settings
					showPlaylistsSearchInput:"yes",
					usePlaylistsSelectBox:"yes",
					showPlaylistsButtonAndPlaylists:"yes",
					showPlaylistsByDefault:"no",
					thumbnailSelectedType:"opacity",
					startAtPlaylist:0,
					buttonsMargins:15,
					thumbnailMaxWidth:350, 
					thumbnailMaxHeight:350,
					horizontalSpaceBetweenThumbnails:40,
					verticalSpaceBetweenThumbnails:40,
					inputBackgroundColor:"#333333",
					inputColor:"#999999",
					//playlist settings
					showPlaylistButtonAndPlaylist:"yes",
					playlistPosition:"right",
					showPlaylistByDefault:"yes",
					showPlaylistName:"yes",
					showSearchInput:"yes",
					showLoopButton:"yes",
					showShuffleButton:"yes",
					showPlaylistOnFullScreen:"no",
					showNextAndPrevButtons:"yes",
					showThumbnail:"yes",
					showOnlyThumbnail:"no",
					forceDisableDownloadButtonForFolder:"yes",
					addMouseWheelSupport:"yes", 
					startAtRandomVideo:"no",
					stopAfterLastVideoHasPlayed:"no",
					addScrollOnMouseMove:"no",
					randomizePlaylist:'no',
					folderVideoLabel:"VIDEO ",
					playlistRightWidth:310,
					playlistBottomHeight:380,
					startAtVideo:0,
					maxPlaylistItems:50,
					thumbnailWidth:71,
					thumbnailHeight:71,
					spaceBetweenControllerAndPlaylist:1,
					spaceBetweenThumbnails:1,
					scrollbarOffestWidth:8,
					scollbarSpeedSensitivity:.5,
					playlistBackgroundColor:"#000000",
					playlistNameColor:"#FFFFFF",
					thumbnailNormalBackgroundColor:"#1b1b1b",
					thumbnailHoverBackgroundColor:"#313131",
					thumbnailDisabledBackgroundColor:"#272727",
					searchInputBackgroundColor:"#000000",
					searchInputColor:"#999999",
					youtubeAndFolderVideoTitleColor:"#FFFFFF",
					folderAudioSecondTitleColor:"#999999",
					youtubeOwnerColor:"#888888",
					youtubeDescriptionColor:"#888888",
					mainSelectorBackgroundSelectedColor:"#FFFFFF",
					mainSelectorTextNormalColor:"#FFFFFF",
					mainSelectorTextSelectedColor:"#000000",
					mainButtonBackgroundNormalColor:"#212021",
					mainButtonBackgroundSelectedColor:"#FFFFFF",
					mainButtonTextNormalColor:"#FFFFFF",
					mainButtonTextSelectedColor:"#000000",
					//controller settings
					showController:"yes",
					showControllerWhenVideoIsStopped:"yes",
					showNextAndPrevButtonsInController:"no",
					showRewindButton:"yes",
					showPlaybackRateButton:"yes",
					showVolumeButton:"yes",
					showTime:"yes",
					showAudioTracksButton:"yes",
					showQualityButton:"yes",
					showInfoButton:"yes",
					showDownloadButton:"yes",
					showShareButton:"yes",
					showEmbedButton:"yes",
					showChromecastButton:"yes",
					show360DegreeVideoVrButton:"yes",
					showFullScreenButton:"yes",
					disableVideoScrubber:"no",
					showScrubberWhenControllerIsHidden:"yes",
					showMainScrubberToolTipLabel:"yes",
					showDefaultControllerForVimeo:"yes",
					repeatBackground:"yes",
					controllerHeight:42,
					controllerHideDelay:3,
					startSpaceBetweenButtons:7,
					spaceBetweenButtons:8,
					scrubbersOffsetWidth:2,
					mainScrubberOffestTop:14,
					timeOffsetLeftWidth:5,
					timeOffsetRightWidth:3,
					timeOffsetTop:0,
					volumeScrubberHeight:80,
					volumeScrubberOfsetHeight:12,
					timeColor:"#888888",
					showYoutubeRelAndInfo:"no",
					youtubeQualityButtonNormalColor:"#888888",
					youtubeQualityButtonSelectedColor:"#FFFFFF",
					scrubbersToolTipLabelBackgroundColor:"#FFFFFF",
					scrubbersToolTipLabelFontColor:"#5a5a5a",
					//advertisement on pause window
					aopwTitle:"Advertisement",
					aopwWidth:400,
					aopwHeight:240,
					aopwBorderSize:6,
					aopwTitleColor:"#FFFFFF",
					//subtitle
					subtitlesOffLabel:"Subtitle off",
					//popup add windows
					showPopupAdsCloseButton:"yes",
					//embed window and info window
					embedAndInfoWindowCloseButtonMargins:15,
					borderColor:"#333333",
					mainLabelsColor:"#FFFFFF",
					secondaryLabelsColor:"#a1a1a1",
					shareAndEmbedTextColor:"#5a5a5a",
					inputBackgroundColor:"#000000",
					inputColor:"#FFFFFF",
					//login
		            playIfLoggedIn:"no",
		            playIfLoggedInMessage:"Please <a href='https://google.com' target='_blank'>login</a> to play this video.",
					//audio visualizer
					audioVisualizerLinesColor:"#0099FF",
					audioVisualizerCircleColor:"#FFFFFF",
					//lightbox settings
					closeLightBoxWhenPlayComplete:"no",
					lightBoxBackgroundOpacity:.6,
					lightBoxBackgroundColor:"#000000",
					//sticky on scroll
					stickyOnScroll:"no",
					stickyOnScrollShowOpener:"yes",
					stickyOnScrollWidth:"700",
					stickyOnScrollHeight:"394",
					//sticky display settings
					showOpener:"yes",
					showOpenerPlayPauseButton:"yes",
					verticalPosition:"bottom",
					horizontalPosition:"center",
					showPlayerByDefault:"yes",
					animatePlayer:"yes",
					openerAlignment:"right",
					mainBackgroundImagePath:"content/minimal_skin_dark/main-background.png",
					openerEqulizerOffsetTop:-1,
					openerEqulizerOffsetLeft:3,
					offsetX:0,
					offsetY:0,
					//playback rate / speed
					defaultPlaybackRate:1, //0.25, 0.5, 1, 1.25, 1.2, 2
					//cuepoints
					executeCuepointsOnlyOnce:"no",
					//annotations
					showAnnotationsPositionTool:"no",
					//ads
					openNewPageAtTheEndOfTheAds:"no",
					playAdsOnlyOnce:"no",
					adsButtonsPosition:"right",
					skipToVideoText:"You can skip to video in: ",
					skipToVideoButtonText:"Skip Ad",
					adsTextNormalColor:"#888888",
					adsTextSelectedColor:"#FFFFFF",
					adsBorderNormalColor:"#666666",
					adsBorderSelectedColor:"#FFFFFF",
					//a to b loop
					useAToB:"yes",
					atbTimeBackgroundColor:"transparent",
					atbTimeTextColorNormal:"#888888",
					atbTimeTextColorSelected:"#FFFFFF",
					atbButtonTextNormalColor:"#888888",
					atbButtonTextSelectedColor:"#FFFFFF",
					atbButtonBackgroundNormalColor:"#FFFFFF",
					atbButtonBackgroundSelectedColor:"#000000",
					//thumbnails preview
					thumbnailsPreviewWidth:196,
					thumbnailsPreviewHeight:200,
					thumbnailsPreviewBackgroundColor:"#000000",
					thumbnailsPreviewBorderColor:"#666",
					thumbnailsPreviewLabelBackgroundColor:"#666",
					thumbnailsPreviewLabelFontColor:"#FFF",
					// context menu
					showContextmenu:'yes',
					showScriptDeveloper:"yes",
					contextMenuBackgroundColor:"#1f1f1f",
					contextMenuBorderColor:"#1f1f1f",
					contextMenuSpacerColor:"#333",
					contextMenuItemNormalColor:"#888888",
					contextMenuItemSelectedColor:"#FFFFFF",
					contextMenuItemDisabledColor:"#444",
					// fingerprint stamp
					useFingerPrintStamp:"yes",
					frequencyOfFingerPrintStamp:3000,
					durationOfFingerPrintStamp:100
				});
			});

			var lightboxIntervalId;
			//openLightboxWhenPageReady();
			function openLightboxWhenPageReady(){
				clearInterval(lightboxIntervalId);
				if(window["player1"]){
					window["player1"].showLightbox();
				}else{
					lightboxIntervalId = setInterval(openLightboxWhenPageReady, 100);
				}
			};
			
			//Register API (an setInterval is required because the player is not available until the youtube API is loaded).
			var registerAPIInterval;
			function registerAPI(){
				clearInterval(registerAPIInterval);
				if(window.player1){
					player1.addListener(FWDUVPlayer.READY, readyHandler);
					player1.addListener(FWDUVPlayer.ERROR, errorHandler);
					player1.addListener(FWDUVPlayer.PLAY, playHandler);
					player1.addListener(FWDUVPlayer.PAUSE, pauseHandler);
					player1.addListener(FWDUVPlayer.STOP, stopHandler);
					player1.addListener(FWDUVPlayer.UPDATE, updateHandler);
					player1.addListener(FWDUVPlayer.UPDATE_TIME, updateTimeHandler);
					player1.addListener(FWDUVPlayer.UPDATE_VIDEO_SOURCE, updateVideoSourceHandler);
					player1.addListener(FWDUVPlayer.UPDATE_POSTER_SOURCE, updatePosterSourceHandler);
					player1.addListener(FWDUVPlayer.START_TO_LOAD_PLAYLIST, startToLoadPlaylistHandler);
					player1.addListener(FWDUVPlayer.LOAD_PLAYLIST_COMPLETE, loadPlaylistCompleteHandler);
					player1.addListener(FWDUVPlayer.PLAY_COMPLETE, playCompleteHandler);
					player1.addListener(FWDUVPlayer.SAFE_TO_SCRUB, safeToScrubb);
				}else{
					registerAPIInterval = setInterval(registerAPI, 100);
				}
			};

			//API event listeners examples
			function readyHandler(e){
				//console.log("API -- ready to use");
			}
			
			function errorHandler(e){
				console.log(e.error);
			}

			function playHandler(e){
				//console.log("API -- play");
			}

			function pauseHandler(e){
				//console.log("API -- pause");
			}

			function stopHandler(e){
				//console.log("API -- stop");
			}
			
			function updateHandler(e){
				//console.log("API -- update video, percent played: " + e.percent);
			}
			
			function updateTimeHandler(e){
				//console.log("API -- update time: " + e.currentTime + "/" + e.totalTime);
			}

			function updateVideoSourceHandler(e){
				//console.log("API -- video source update: " + player1.getVideoSource());
			}

			function updatePosterSourceHandler(e){
				//console.log("API -- video source update: " + player1.getPosterSource());
			}
			
			function startToLoadPlaylistHandler(e){
				//console.log("API -- start to load playlist: " + player1.getCurCatId());
			}
			
			function loadPlaylistCompleteHandler(e){
				//console.log("API -- playlist load complete: " + player1.getCurCatId());
			}
			
			function playCompleteHandler(e){
				//console.log("API -- play complete");
			}
			

			//API methods examples
			function play(){
				player1.play();
			}

			function playNext(){
				player1.playNext();
			}

			function playPrev(){
				player1.playPrev();
			}

			function playShuffle(){
				player1.playShuffle();
			}
			
			function pause(){
				player1.pause();
			}

			function stop(){
				player1.stop();
			}

			function scrub(percent){
				player1.scrub(percent);
			}

			function setVolume(percent){
				player1.setVolume(percent);
			}
			
			function share(){
				player1.share();
			}
			
			function download(){
				player1.downloadVideo();
			}

			function goFullScreen(){
				player1.goFullScreen();
			}
			
			function loadThumbnailsPreview(){
				player1.setThumbnailPreviewSource('content/thumbnails.vtt');
			}
			
			function showPlaylist(){
				player1.hidePlaylist();
			}
			
			function hidePlaylist(){
				player1.showPlaylist();
			}
			
			function safeToScrubb(){
				//player1.scrubbAtTime("00:00:05")
			}

			function loadPlaylist(playlistId){
				player1.loadPlaylist(playlistId);
			}
			
			function getRandomColor() {
				var letters = '0123456789ABCDEF';
				var color = '#';
				for (var i = 0; i < 6; i++ ) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}
			
			function changeCanvasColors(){
				var randomColor = getRandomColor();
				player1.updateHEXColors(randomColor, "#FFFFFF");
				//$('.classicDarkThumbnailTitle').css('color',randomColor);
				
				$("head").append('<style type="text/css"></style>');
				var new_stylesheet = $("head").children(':last');
				new_stylesheet.html('.classicDarkThumbnailTitle, .minimialDarkBold, .fwdChangeColor{color:' + randomColor + ';}');
				
				$(".ytbChangeColor").css("color", randomColor);
			}
		</script>
		
	</head>

	<body class="player-course-chapter">
		<div id="myDiv" class="player-course-chapter-list"></div>
	
		<!--  Playlists -->
		<ul id="courseplaylist" class="display-none">
			<li data-source="courseplaycontent{{ $class->id }}" data-playlist-name="{{ $class->coursechapters->chapter_name }}" data-thumbnail-path="{{ url('images/course/'.$class->courses->preview_image) }}">
				<p class="fwduvp-categories-title"><span class="fwduvp-header">Title: </span>{{ $class->coursechapters->chapter_name }}</p>
				<p class="fwduvp-categories-type"><span class="fwduvp-header">Category: </span>{{ $class->courses->category->title }}</p>
				<p class="fwduvp-categories-description"><span class="fwduvp-header">Course: </span>{{ strip_tags($class->courses->title) }}</p>
			</li>
		</ul>
		<ul id="courseplaycontent{{ $class->id }}" class="display-none">
				
				@php
					$myid =	$class->id;
					if($class->preview_url !== NULL){
						$url = str_replace("https://youtu.be/", "https://youtube.com/watch?v=", $class->preview_url);
					}else{
						$url = url('video/class/preview/'.$class->preview_video);
					}


				@endphp

				@php

					$pauseads = App\Ads::where('ad_location','=','onpause')->get();
					$pausead =  App\Ads::inRandomOrder()->where('ad_location','=','onpause')->first();
		        
					
				
				@endphp

				@if($class->type == 'video')
				@if($class->status == '1')
				<li 
					@if($pauseads->count()>0)
						data-advertisement-on-pause-source="{{ asset('adv_upload/image/'.$pausead->ad_image)}}" 
					@endif 
					
					@if($class->courses['preview_image'] !== NULL && $class->courses['preview_image'] !== '')
						data-thumb-source="{{ url('images/course/'.$class->courses->preview_image) }}"
					@else
						data-thumb-source="{{ Avatar::create($class->courses->title)->toBase64() }}"
					@endif 

					data-video-source="{{ $url }}"

					
					
					@if($class->courses['preview_image'] !== NULL && $class->courses['preview_image'] !== '')
				    	data-poster-source="{{ url('images/course/'.$class->courses->preview_image) }}" 
					@else
						data-poster-source="{{ url('images/default/course.jpg') }}"
					@endif

				    data-subtitle-soruce="[
			  		@foreach($class->subtitle as $sub)
			  		{source:'{{ url('subtitles/'.$sub->sub_t) }}', label:'{{ $sub->sub_lang }}'},
			  		@endforeach
			  		]" data-start-at-subtitle="1" data-downloadable="yes"> 

			  		@php
						$skipads = App\Ads::where('ad_location','=', 'skip')->get();
						$skipad = App\Ads::inRandomOrder()->where('ad_location','=','skip')->first();

					@endphp
						@if($skipads->count()>0)
						<ul data-ads="">
						<li @if($skipad->ad_video !="no")

							data-source="{{ asset('adv_upload/video/'.$skipad->ad_video) }}" 
							@else
							data-source="{{ $skipad->ad_url }}" @endif data-time-start="{{ $skipad->time }}" data-time-to-hold-ads="{{ $skipad->ad_hold }}" data-thumbnail-source="{{asset('images/course/'.$class->courses->preview_image)}}" data-link="{{ $skipad->ad_target }}" data-target="_blank"></li>
							
						</ul>
						@endif

					    <div data-video-short-description="">
					    	 <p class="fwduvp-categories-title"><span class="fwduvp-header">Title: </span>{{ $class->title }}</p>
		        			 <p class="fwduvp-categories-description"><span class="fwduvp-header">Course: </span>{{ $class->courses->title }}</p>
					    </div>

					    @php
							$popupads = App\Ads::where('ad_location','=', 'popup')->get();
							$popupad = App\Ads::inRandomOrder()->where('ad_location','=','popup')->first();	
						@endphp

						@if($popupads->count()>0)
						<div data-add-popup="">
							<p data-image-path="{{ asset('adv_upload/image/'.$popupad->ad_image) }}" data-time-start="{{ $popupad->time }}" data-time-end="{{ $popupad->endtime }}" data-link="{{ $popupad->ad_target }}" data-target="_blank"></p>
						</div>
						@endif
				</li>
				@endif
				@endif
		</ul>
	</body>
</html>
