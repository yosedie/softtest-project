/**
 * Ultimate Video Player PACKAGED v9.1
 * Vimeo screen.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function(window){
	
	var FWDUVPVimeoScreen = function(prt, volume){
		
		'use strict';

		var _s = this;
		var prototype = FWDUVPVimeoScreen.prototype;
		
		_s.lastQuality_str = "auto";
		_s.volume = volume;
		
		_s.controllerHeight = prt._d.controllerHeight;
		_s.hasBeenCreatedOnce_bl = true;
		_s.isStopped_bl = true;
		_s.isPausedInEvent_bl = true;
		_s.isShowed_bl = true;
		_s.isMbl = FWDUVPUtils.isMobile;
		

		//###############################################//
		/* init */
		//###############################################//
		_s.init = function(){
			_s.hasTransform3d_bl = false;
			_s.hasTransform2d_bl = false;
			_s.setBkColor(prt.videoBackgroundColor_str);
		
			_s.setBackfaceVisibility();
			prt.videoHolder_do.addChildAt(_s, 0);
			_s.resizeAndPosition();
			_s.setupVideo();
			_s.setupDisableClick();
		};
	
		
		//#####################################//
		/* Setup disable click */
		//#####################################//
		_s.setupDisableClick = function(){
			_s.disableClick_do = new FWDUVPDisplayObject("div");
			_s.disableClick_do.setBkColor(prt.backgroundColor_str);	
			_s.disableClick_do.setAlpha(0.00000001);
			_s.addChild(_s.disableClick_do);
		};
		
		_s.showDisable = function(){
			if(!prt.tempVidStageWidth || _s.disableClick_do.w == _s.sW) return;
			_s.disableClick_do.setWidth(prt.tempVidStageWidth);
			if(FWDUVPUtils.isIphone){	
				_s.disableClick_do.setHeight(prt.tempVidStageHeight - _s.controllerHeight);
			}else{
				_s.disableClick_do.setHeight(prt.tempVidStageHeight);
			}
		};
		
		_s.hideDisable = function(){
			if(_s.disableClick_do.w == 0) return;
			_s.disableClick_do.setWidth(0);
			_s.disableClick_do.setHeight(0);
		};
	

		//###############################################//
		/* Setup youtube video */
		//##############################################//
		_s.setupVideo = function(){
			if(_s.vimeoPlayer) return;
			_s.iframe_do = new FWDUVPDisplayObject("IFRAME");
			_s.iframe_do.hasTransform3d_bl = false;
			_s.iframe_do.hasTransform2d_bl = false;
			_s.iframe_do.screen.setAttribute("id", prt.instanceName_str + "vimeo");
			if(_s.isMbl){
				_s.iframe_do.screen.setAttribute("webkitallowfullscreen", "1");
				_s.iframe_do.screen.setAttribute("mozallowfullscreen", "1");
				_s.iframe_do.screen.setAttribute("allowfullscreen", "1");
			}
			
			var bk = 0;
			if(prt._d.showDefaultControllerForVimeo_bl && !_s.isMobile_bl) bk = 1;

			var inl = 0;
			if(prt._d.playsinline) inl = 1;
			
			_s.iframe_do.screen.setAttribute("src", "https://player.vimeo.com/video/76979871" + "?player_id=" + prt.instanceName_str + "vimeo&playsinline=" + inl + "&muted=0&autoplay=0&background=" + bk +"");

			_s.iframe_do.screen.setAttribute("id", prt.instanceName_str + "vimeo");		
			_s.iframe_do.screen.setAttribute("frameborder", "0");
			_s.iframe_do.screen.setAttribute("allow", "fullscreen; autoplay;");
			_s.iframe_do.screen.dataset.ready = 'true';
			
			if(prt._d.autoPlay_bl){
				_s.iframe_do.screen.setAttribute("muted", "1");
			}
			_s.iframe_do.getStyle().width = "100%";
			_s.iframe_do.getStyle().height = "100%";
			_s.iframe_do.setBackfaceVisibility();
			_s.addChild(_s.iframe_do);
			
			_s.vimeoPlayer = new Vimeo.Player(_s.iframe_do.screen); 
			_s.vimeoPlayer.on('play', function(e) {
				_s.playHandler();
			});
			
			_s.vimeoPlayer.on('pause', function(e) {
				_s.pauseHandler();
			});
			
			_s.vimeoPlayer.on('loadProgress', function(e) {
				_s.loadProgressHandler();
			});

			_s.vimeoPlayer.on('loaded', function(e) {
				_s.loadedHandler();
			});
			
			_s.vimeoPlayer.ready().then(function(){
				_s.readyHandler();
			});
			
			_s.blackOverlay_do = new FWDUVPDisplayObject("div");
			_s.blackOverlay_do.getStyle().backgroundColor = "#000000";
			_s.blackOverlay_do.getStyle().width = "100%";
			_s.blackOverlay_do.getStyle().height = "100%";
			_s.addChild(_s.blackOverlay_do);

		};
			
		//##############################################//
		/* Resize and position */
		//##############################################//
		_s.resizeAndPosition = function(){
			if(!prt.tempVidStageWidth) return;
			_s.setWidth(prt.tempVidStageWidth);
			_s.setHeight(prt.tempVidStageHeight);
			if(!prt._d.showDefaultControllerForVimeo_bl && prt.controller_do){
				_s.setHeight(prt.tempVidStageHeight - prt.controller_do.h)
			}
		};
		

		//##############################################//
		/* Set source and initialize player */
		//##############################################//
		_s.setSource = function(sourcePath){
			if(sourcePath) _s.sourcePath_str = sourcePath;
			_s.stopToUpdateSubtitles();
	
			var videoId = _s.sourcePath_str.match(/[^\/]+$/i);	
			
			_s.vimeoPlayer.loadVideo(videoId).then(function(id) {
				if(prt._d.autoPlay_bl || prt.isThumbClick_bl){

					if( prt.isThumbClick_bl){
						prt.videoPoster_do.hide(true);
						prt.play();
					} 

					if(prt._d.autoPlay_bl){
						if(prt.controller_do) prt.controller_do.updateVolume(0);
						if(prt.displayType != FWDUVPlayer.LIGHTBOX || prt.lightBox_do.isShowed_bl){
							prt.videoPoster_do.hide(true);
							prt.play();
						} 
					}
				}else{
					prt.videoPoster_do.show();
					if(prt.lrgPlayBtn) prt.lrgPlayBtn.show();
				}

				if(!_s.isMbl && prt.isAdd_bl && !prt.loadAddFirstTime_bl){
					prt.play();
					prt.videoPoster_do.hide(true);
				}
				_s.setVolume(prt.volume);
			}).catch(function(error) {
				if(console) console.log(error);
				_s.displayErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPVimeoScreen.ERROR, {error:error.name});
				} , 2000);
				if(console) console.log(error);
			});
		};

		
		//########################################//
		/* Ready handler */
		//########################################//
		_s.readyHandler = function(){
			
			clearTimeout(_s.intitErrorId_to);
			if(_s.contains(_s.blackOverlay_do)){
				clearTimeout(_s.removeChildWithDelayId_to);
				_s.removeChildWithDelayId_to = setTimeout(function(){
					_s.removeChild(_s.blackOverlay_do);
				}, 1500);
			}
			_s.resizeAndPosition();
			
			
			if(_s.isReady_bl){
				try{
					_s.vimeoPlayer.api("setColor", '#FFFFFF');
				}catch(e){}
				if(prt.videoType_str == FWDUVPlayer.VIMEO) _s.setX(0);
				if(prt._d.autoPlay_bl) prt.play();
			
				return;
			}
			_s.isReady_bl = true;
		
			_s.dispatchEvent(FWDUVPVimeoScreen.READY);
		};
		
		_s.loadedHandler = function(){
			_s.isVideoLoaded_bl = true;
		};
		
		_s.playHandler = function(){
			clearInterval(_s.startToPlayWithDelayId_to);
			clearTimeout(_s.displayErrorId_to);
			_s.isStopped_bl = false;
			_s.isSafeToBeControlled_bl = true;
			_s.isPlaying_bl = true;
			_s.startToUpdateSubtitles();
			_s.startToUpdate();
		
			_s.dispatchEvent(FWDUVPVimeoScreen.SAFE_TO_SCRUBB);
			_s.dispatchEvent(FWDUVPVimeoScreen.PLAY);
			_s.hasHours_bl = Math.floor(_s.getDuration() / (60 * 60)) > 0;
		};
		
		_s.loadProgressHandler = function(e){
			if(_s.isShowed_bl) return;
			_s.dispatchEvent(FWDUVPVimeoScreen.LOAD_PROGRESS, {percent:e.percent});
		};
		
		_s.pauseHandler = function(){
			if(!_s.isPlaying_bl ) return;
		
			_s.isPlaying_bl = false;
			clearInterval(_s.startToPlayWithDelayId_to);
			_s.dispatchEvent(FWDUVPVimeoScreen.PAUSE);
			_s.stopToUpdate();
		};
		
		_s.finishHandler = function(){
			if(prt._d.loop_bl && !prt.isAdd_bl){
				_s.stop();
				setTimeout(_s.play, 200);
			}
			_s.dispatchEvent(FWDUVPVimeoScreen.PLAY_COMPLETE);
		};
	

		//##########################################//
		/* Play / pause / stop methods */
		//##########################################//
		_s.play = function(overwrite){
			FWDUVPlayer.curInstance = prt;
			_s.hasError_bl = false;
			_s.vimeoPlayer.play();
			if(!_s.isMbl) _s.isStopped_bl = false;
		};

		_s.pause = function(){
			if(_s.isStopped_bl || _s.hasError_bl) return;
			clearInterval(_s.startToPlayWithDelayId_to);
			_s.vimeoPlayer.pause();
			_s.stopToUpdate();
		};
		
		_s.togglePlayPause = function(){
			if(_s.isPlaying_bl){
				_s.pause();
			}else{
				_s.play();
			}
		};
		
		_s.resume = function(){
			if(_s.isStopped_bl) return;
			_s.play();
		};
		

		//###########################################//
		/* Updates. */
		//###########################################//
		_s.startToUpdate = function(){
			clearInterval(_s.updateVideoId_int);
			_s.updateVideoId_int = setInterval(_s.updateVideo, 50);
		};
		
		_s.stopToUpdate = function(){
			clearInterval(_s.updateVideoId_int);
		};
		
		_s.updateVideo = function(){
		
			var percentPlayed; 
			if(!_s.vimeoPlayer){
				stopToUpdate();
				return;
			}
			
			var totalTime = FWDUVPUtils.formatTime(_s.getDuration());
			var curTime = FWDUVPUtils.formatTime(_s.getCurrentTime());
			
			percentPlayed = _s.getCurrentTime()/_s.getDuration();
			if(isNaN(percentPlayed)) percentPlayed = 0;

			if(_s.getCurrentTime() == _s.getDuration()){
				_s.finishHandler();
				return;
			} 
		
			_s.dispatchEvent(FWDUVPYoutubeScreen.UPDATE, {percent:percentPlayed});
			_s.dispatchEvent(FWDUVPVimeoScreen.UPDATE_TIME, {curTime:curTime , totalTime:totalTime, seconds:_s.getCurrentTime(), totalTimeInSeconds:_s.getDuration()});
		};	

		
		//###########################################//
		/* Event handlers */
		//###########################################//	
		_s.stop = function(addEvents){
			_s.isVideoLoaded_bl = false;
			
			if(_s.isStopped_bl) return;
			clearInterval(_s.startToPlayWithDelayId_to);
			clearTimeout(_s.displayErrorId_to);
			_s.stopVideo();
			_s.stopToUpdateSubtitles();
			
			_s.isPlaying_bl = false;
			_s.isStopped_bl = true;
			_s.isCued_bl = false;
			_s.allowScrubing_bl = false;
			_s.isSafeToBeControlled_bl = false;
			_s.isPausedInEvent_bl = true;
			
			_s.stopToUpdate();
			if(!addEvents){
				_s.stopVideo();
				_s.dispatchEvent(FWDUVPVimeoScreen.STOP);
			}
		};
		
		_s.destroy = function(){
			if(_s.iframe_do){
				_s.iframe_do.screen.removeAttribute("id", prt.instanceName_str + "vimeo");
				_s.removeChild(_s.iframe_do);
				_s.iframe_do.destroy();
				_s.iframe_do = null;
			}
			_s.vimeoPlayer = null;
		};
		
		_s.stopVideo = function(){
			_s.vimeoPlayer.unload().then(function() {
				// the video was unloaded
			}).catch(function(e) {
				// an error occurred
				console.log(e)
			});
		};
		

		//########################################//
		/* Various Vimeo API methods */
		//########################################//
		_s.startToScrub = function(){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.allowScrubing_bl = true;
		};
		
		_s.stopToScrub = function(){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.allowScrubing_bl = false;
		};
		
		_s.scrubbAtTime = function(duration){
			_s.vimeoPlayer.setCurrentTime(duration).then(function(seconds) {
				// seconds = the actual time that the player seeked to
			})
		}
		
		_s.scrub = function(percent){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.vimeoPlayer.setCurrentTime(percent * _s.getDuration()).then(function(seconds) {
				// seconds = the actual time that the player seeked to
			})
		};
	
		_s.setVolume = function(vol){
			if(vol != undefined) _s.volume = vol;
			if(_s.vimeoPlayer) {
				_s.vimeoPlayer.setVolume(_s.volume);
			}
		};
		
		
		_s.getDuration = function(){
			if(!_s.isSafeToBeControlled_bl) return;
				_s.vimeoPlayer.getDuration().then(function(duration) {
				_s.duration = Math.round(duration);
            });
			return _s.duration;
		};
		
		_s.getCurrentTime = function(){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.vimeoPlayer.getCurrentTime().then(function(time) {
               _s.currentTime = Math.round(time);
            });
			
			return _s.currentTime;
		};

		
		//##################################################//
		/* Suntitles */
		//##################################################//
		_s.stopToUpdateSubtitles = function(){
			clearInterval(_s.startToUpdateSubtitleId_int);	
		}
		
		_s.startToUpdateSubtitles = function(){
			clearInterval(_s.startToUpdateSubtitleId_int);
			_s.startToUpdateSubtitleId_int = setInterval(_s.updateSubtitleHandler, 10);
		}
		
		_s.updateSubtitleHandler = function(){
			if(!_s.getCurrentTime()) return;
			_s.dispatchEvent(FWDUVPVimeoScreen.UPDATE_SUBTITLE, {curTime:_s.getCurrentTime()});
		}
		
	
		_s.init();
	};


	/* set prototype */
	FWDUVPVimeoScreen.setPrototype = function(){
		FWDUVPVimeoScreen.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPVimeoScreen.UPDATE_SUBTITLE = "updateSubtitle";
	FWDUVPVimeoScreen.SAFE_TO_SCRUBB = "safeToScrub";
	FWDUVPVimeoScreen.READY = "ready";
	FWDUVPVimeoScreen.ERROR = "initError";
	FWDUVPVimeoScreen.UPDATE = "update";
	FWDUVPVimeoScreen.UPDATE_TIME = "updateTime";
	FWDUVPVimeoScreen.LOAD_PROGRESS = "loadProgress";
	FWDUVPVimeoScreen.PLAY = "play";
	FWDUVPVimeoScreen.PAUSE = "pause";
	FWDUVPVimeoScreen.STOP = "stop";
	FWDUVPVimeoScreen.PLAY_COMPLETE = "playComplete";
	FWDUVPVimeoScreen.CUED = "cued";
	FWDUVPVimeoScreen.QUALITY_CHANGE = "qualityChange";


	window.FWDUVPVimeoScreen = FWDUVPVimeoScreen;

}(window));