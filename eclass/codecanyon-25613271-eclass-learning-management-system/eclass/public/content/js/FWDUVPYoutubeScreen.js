/**
 * Ultimate Video Player PACKAGED v9.1
 * Youtube screen.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function(window){
	
	var FWDUVPYoutubeScreen = function(prt, volume){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPYoutubeScreen.prototype;
	
		_s.lastQuality_str = "auto";	
		_s.volume = volume;
		_s.controllerHeight = prt._d.controllerHeight;
		_s.isStopped_bl = true;
		_s.isPausedInEvent_bl = true;
		_s.isShowed_bl = true;
		_s.isQualityArrayDisapatched_bl = false; _s.playsinline = prt._d.playsinline ? 1 : 0;
		_s.isMbl = FWDUVPUtils.isMobile;
		

		//###############################################//
		/* init */
		//###############################################//
		_s.init = function(){
			
			_s.hasTransform3d_bl = false;
			_s.hasTransform2d_bl = false;
			_s.setBkColor("#000");
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
			_s.disableClick_do.className = 'FWDUVP-disable';
			_s.addChild(_s.disableClick_do);
		};
		
		_s.showDisable = function(){
			if(!prt.tempVidStageWidth || _s.disableClick_do.w == _s.sW){
				return;
			}
			
			_s.disableClick_do.setWidth(prt.tempVidStageWidth);
			
				_s.disableClick_do.setHeight(prt.tempVidStageHeight);
			
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
		
			_s.videoHolder_do = new FWDUVPDisplayObject("div");
			_s.videoHolder_do.hasTransform3d_bl = false;
			_s.videoHolder_do.hasTransform2d_bl = false;
			_s.videoHolder_do.screen.setAttribute("id", prt.instanceName_str + "youtube");
			_s.videoHolder_do.getStyle().width = "100%";
			_s.videoHolder_do.getStyle().height = "100%";
			_s.videoHolder_do.setBackfaceVisibility();
			_s.addChild(_s.videoHolder_do);
			
			_s.ytb = new YT.Player(prt.instanceName_str + "youtube", {
				width:"100%",
				height:"100%",
				playerVars:{
					rel:0,
					playsinline:_s.playsinline,
					wmode: 'transparent',
					controls: 0,
					enablejsapi:1,
					iv_load_policy:3,
					modestbranding: 0,
	                showinfo:0,
	                autohide: 1,
			  	},
			  	events: {
			  		"onReady":_s.playerReadyHandler,
			  		"onError":_s.playerErrorHandler,
			  		"onStateChange":_s.stateChangeHandler,
			  		"onPlaybackQualityChange":_s.qualityChangeHandler
			  	}
		    });
			_s.setBkColor("#000");
			_s.ytbIframe = document.getElementById(prt.instanceName_str + "youtube");
		};
			
		_s.playerReadyHandler = function(e){
		
			if(prt._d.autoPlay_bl) _s.ytb.mute();

			_s.resizeAndPosition();
			
			_s.dispatchEvent(FWDUVPYoutubeScreen.READY);
			_s.hasBeenCreatedOnce_bl = true;
		};
		
		_s.stateChangeHandler = function(e){
			if(e.data == -1 && _s.isCued_bl && _s.isMbl){
				_s.isStopped_bl = false;
				FWDUVPlayer.stopAllVideos(prt);
			}
			
			if(e.data == YT.PlayerState.PLAYING){
				if(!_s.isSafeToBeControlled_bl){
					_s.isStopped_bl = false;
					_s.isSafeToBeControlled_bl = true;
					_s.isPlaying_bl = true;
					_s.hasHours_bl = Math.floor(_s.ytb.getDuration() / (60 * 60)) > 0;
					_s.setVolume(prt.volume);
					_s.startToUpdate();
					_s.startToPreload();
					_s.scrub(0.00001);
					if(!_s.isMbl) _s.setQuality(_s.lastQuality_str);
					
					if(_s.ytb.getAvailableQualityLevels() && _s.ytb.getAvailableQualityLevels().length != 0){
						_s.dispatchEvent(FWDUVPYoutubeScreen.QUALITY_CHANGE, {qualityLevel:_s.ytb.getPlaybackQuality(), levels:_s.ytb.getAvailableQualityLevels()});
					}
					_s.startToUpdateSubtitles();
				    _s.dispatchEvent(FWDUVPYoutubeScreen.SAFE_TO_SCRUBB);
				}

				_s.resizeAndPosition();
				if(_s.isPausedInEvent_bl) _s.dispatchEvent(FWDUVPYoutubeScreen.PLAY);
				_s.isPausedInEvent_bl = false;
				_s.hasError_bl = false;
				
			}else if(e.data == YT.PlayerState.PAUSED){
				if(!_s.isSafeToBeControlled_bl) return;
				_s.isStopped_bl = false;
				if(!_s.isPausedInEvent_bl) _s.dispatchEvent(FWDUVPYoutubeScreen.PAUSE);
				_s.isPausedInEvent_bl = true;
			}else if(e.data == YT.PlayerState.ENDED){
				if(_s.ytb.getCurrentTime() && _s.ytb.getCurrentTime() > 0){
					_s.isStopped_bl = false;
					_s.stopToUpdateSubtitles();
					setTimeout(function(){_s.dispatchEvent(FWDUVPYoutubeScreen.PLAY_COMPLETE);}, 100);
				}
			}else if(e.data == YT.PlayerState.CUED){
				if(!_s.isStopped_bl){
					_s.dispatchEvent(FWDUVPYoutubeScreen.CUED);
				}
				_s.isCued_bl = true;
				
				if(!_s.stopp){

					if(prt._d.autoPlay_bl || prt.isThumbClick_bl){
			
						if(prt.isThumbClick_bl){
							 prt.play();
						}

						if(prt._d.autoPlay_bl){
							if(prt.controller_do) prt.controller_do.updateVolume(0);
							if(prt.displayType != FWDUVPlayer.LIGHTBOX || prt.lightBox_do.isShowed_bl){
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
				}

				_s.resizeAndPosition();
			}
		};
		
		_s.qualityChangeHandler = function(e){
			if(_s.ytb.getAvailableQualityLevels() && _s.ytb.getAvailableQualityLevels().length != 0){
				_s.dispatchEvent(FWDUVPYoutubeScreen.QUALITY_CHANGE, {qualityLevel:_s.ytb.getPlaybackQuality()});
			}
		};
		
		_s.playerErrorHandler = function(e){
			_s.isPausedInEvent_bl = true;
			if(_s.isStopped_bl || _s.hasError_bl) return;
		
			var error_str = "";
			_s.hasError_bl = true;
			if(e.data == 2){
				error_str = "The youtube id is not well formatted, make sure it has exactly 11 characters and that it dosn't contain invalid characters such as exclamation points or asterisks.";
			}else if(e.data == 5){
				error_str = "The requested content cannot be played in an HTML5 player or another error related to the HTML5 player has occurred.";
			}else if(e.data == 100){
				error_str = "The youtube video request was not found, probably the video ID is incorrect.";
			}else if(e.data == 101 || e.data == 150){
				error_str = "The owner of the requested video does not allow it to be played in embedded players.";
			}
			_s.dispatchEvent(FWDUVPYoutubeScreen.ERROR, {text:error_str});
		};
		

		//##############################################//
		/* Resize and position */
		//##############################################//
		_s.resizeAndPosition = function(){
			_s.setWidth(prt.tempVidStageWidth);
			

			if(prt._d.showYoutubeRelAndInfo_bl){
				_s.setHeight(prt.tempVidStageHeight + 2);
				_s.setY(-1);
			}else{
				// if(!_s.isSafeToBeControlled_bl){
				// 	_s.setHeight(prt.tempVidStageHeight);
				// 	_s.setY(0);
				// }else{
					
					_s.setHeight(1.776 * prt.tempVidStageHeight);
					
					_s.setY((prt.tempVidStageHeight - (1.776 * prt.tempVidStageHeight))/2);
				//}
			}
		};
		

		//##############################################//
		/* Set path */
		//##############################################//
		_s.setSource = function(sourcePath){
			if(sourcePath) _s.sourcePath_str = sourcePath;
			_s.stopp = false;

			clearInterval(_s.setSourceId_int);
			_s.setSourceId_int = setInterval(function(){
				if(_s.ytb.cueVideoById && _s.ytb.setPlaybackRate){
					_s.ytb.cueVideoById(_s.sourcePath_str);

					if(!prt._d.autoPlay_bl){
						setTimeout(function(){
						//	prt.videoPoster_do.hide();
						//	prt.lrgPlayBtn.hide();
						}, 100);
					}
					clearInterval(_s.setSourceId_int);
				}
			},50);
		};
	

		//##########################################//
		/* Play / pause / stop methods */
		//##########################################//
		_s.play = function(overwrite){
			FWDUVPlayer.curInstance = prt;
			_s.isPlaying_bl = true;
			_s.hasError_bl = false;
			_s.hasStarted_bl = true;

			try{
				_s.ytb.playVideo();
				_s.startToUpdate();
			}catch(e){}

			_s.isStopped_bl = false;
		};

		_s.pause = function(){
			if(_s.isStopped_bl || _s.hasError_bl) return;
			_s.isPlaying_bl = false;
			try{
				_s.ytb.pauseVideo();
			}catch(e){}
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
			_s.updateVideoId_int = setInterval(_s.updateVideo, 500);
		};
		
		_s.stopToUpdate = function(){
			clearInterval(_s.updateVideoId_int);
		};
		
		_s.updateVideo = function(){
			var percentPlayed; 
			if(!_s.ytb){
				stopToUpdate();
				return;
			}
			if (!_s.allowScrubing_bl) {
				percentPlayed = _s.ytb.getCurrentTime() /_s.ytb.getDuration();
				_s.dispatchEvent(FWDUVPYoutubeScreen.UPDATE, {percent:percentPlayed});
			}
			
			var totalTime = FWDUVPUtils.formatTime(_s.ytb.getDuration());
			var curTime = FWDUVPUtils.formatTime(_s.ytb.getCurrentTime());
			
			_s.dispatchEvent(FWDUVPYoutubeScreen.UPDATE_TIME, {curTime:curTime , totalTime:totalTime, seconds:_s.ytb.getCurrentTime(), totalTimeInSeconds:_s.ytb.getDuration()});
		};
		
		_s.startToPreload = function(){
			clearInterval(_s.preloadVideoId_int);
			_s.updatePreloadId_int = setInterval(_s.updateProgress, 500);
		};
		
		_s.stopToPreload = function(){
			clearInterval(_s.updatePreloadId_int);
		};
		
		_s.updateProgress = function(){
			if(!_s.ytb){
				stopToPreload();
				return;
			}
			var buffered;
			var percentLoaded = _s.ytb.getVideoLoadedFraction();
			
			_s.dispatchEvent(FWDUVPYoutubeScreen.LOAD_PROGRESS, {percent:percentLoaded});
		};
		

		//###########################################//
		/* Event handlers */
		//###########################################//	
		_s.stop = function(){
			if(_s.isStopped_bl) return;
			_s.isPlaying_bl = false;
			_s.isStopped_bl = true;
			_s.hasStarted_bl = false;
			_s.isCued_bl = false;
			clearInterval(_s.setSourceId_int);
			_s.allowScrubing_bl = false;
			_s.isSafeToBeControlled_bl = false;
			_s.isQualityArrayDisapatched_bl = false;
			_s.isPausedInEvent_bl = true;
			_s.stopToUpdateSubtitles();
			_s.stopToUpdate();
			_s.stopToPreload();
			_s.stopVideo();
			_s.dispatchEvent(FWDUVPYoutubeScreen.STOP);
			_s.dispatchEvent(FWDUVPYoutubeScreen.LOAD_PROGRESS, {percent:0});
		};
		
		_s.destroyYoutube = function(){
			if(_s.videoHolder_do){
				_s.videoHolder_do.screen.removeAttribute("id", prt.instanceName_str + "youtube");
				_s.videoHolder_do.destroy();
				_s.videoHolder_do = null;
			}
			if(_s.ytb) _s.ytb.destroy();
			_s.ytb = null;
		};
		
		_s.stopVideo = function(){
			
			if(_s.stopp) return;
			_s.stopp = true;
			_s.ytb.cueVideoById(_s.sourcePath_str);
		};
		
		_s.setPlaybackRate = function(rate){
			if(!_s.ytb || _s.isMbl) return;
			if(rate) _s.rate = rate;
			if(_s.ytb.setPlaybackRate){
				_s.ytb.setPlaybackRate(Number(_s.rate));
			}
		};
		
		//##################################################//
		/* Subtitles */
		//##################################################//
		_s.stopToUpdateSubtitles = function(){
			clearInterval(_s.startToUpdateSubtitleId_int);	
		}
		
		_s.startToUpdateSubtitles = function(){
			clearInterval(_s.startToUpdateSubtitleId_int);
			_s.startToUpdateSubtitleId_int = setInterval(_s.updateSubtitleHandler, 10);
		}
		
		_s.updateSubtitleHandler = function(){
			_s.dispatchEvent(FWDUVPYoutubeScreen.UPDATE_SUBTITLE, {curTime:_s.ytb.getCurrentTime()});
		}


		//###############################################//
		/* Scrub */
		//###############################################//
		_s.startToScrub = function(){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.allowScrubing_bl = true;
		};
		
		_s.stopToScrub = function(){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.allowScrubing_bl = false;
		};
		
		_s.scrubbAtTime = function(duration){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.ytb.seekTo(duration);
		}
		
		_s.scrub = function(percent){
			if(!_s.isSafeToBeControlled_bl) return;
			_s.ytb.seekTo(percent * _s.ytb.getDuration());
		};
	

		//###############################################//
		/* Volume */
		//###############################################//
		_s.setVolume = function(vol){
			if(vol != undefined) _s.volume = vol;
			if(_s.ytb && _s.ytb.setVolume){
				_s.ytb.setVolume(vol * 100);
				if(vol) _s.ytb.unMute();
			}
		};
		

		//###############################################//
		/* set quality */
		//###############################################//
		_s.setQuality = function(quality){
			_s.lastQuality_str = quality;
			_s.ytb.setPlaybackQuality(quality);
		};
	
		_s.init();
	};


	/* set prototype */
	FWDUVPYoutubeScreen.setPrototype = function(){
		FWDUVPYoutubeScreen.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPYoutubeScreen.UPDATE_SUBTITLE = "updateSubtitle";
	FWDUVPYoutubeScreen.READY = "ready";
	FWDUVPYoutubeScreen.ERROR = "error";
	FWDUVPYoutubeScreen.UPDATE = "update";
	FWDUVPYoutubeScreen.UPDATE_TIME = "updateTime";
	FWDUVPYoutubeScreen.SAFE_TO_SCRUBB = "safeToControll";
	FWDUVPYoutubeScreen.LOAD_PROGRESS = "loadProgress";
	FWDUVPYoutubeScreen.PLAY = "play";
	FWDUVPYoutubeScreen.PAUSE = "pause";
	FWDUVPYoutubeScreen.STOP = "stop";
	FWDUVPYoutubeScreen.PLAY_COMPLETE = "playComplete";
	FWDUVPYoutubeScreen.CUED = "cued";
	FWDUVPYoutubeScreen.QUALITY_CHANGE = "qualityChange";


	window.FWDUVPYoutubeScreen = FWDUVPYoutubeScreen;

}(window));