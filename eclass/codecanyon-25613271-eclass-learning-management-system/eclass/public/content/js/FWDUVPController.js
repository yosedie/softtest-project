/**
 * Ultimate Video Player PACKAGED v9.1
 * Video controller.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function(){
var FWDUVPController = function(
			_d,
			prt
		){
			
		'use strict';

		var _s = this;
		var prototype = FWDUVPController.prototype;
		
		_s._d = _d;
		_s.bkLeft_img = _d.bkLeft_img;
		_s.bkRight_img = _d.bkRight_img;
		_s.playN_img = _d.playN_img;
		_s.pauseN_img = _d.pauseN_img;
		_s.mainScrubberBkLeft_img = _d.mainScrubberBkLeft_img;
		_s.mainScrubberDragLeft_img = _d.mainScrubberDragLeft_img;
		_s.mainScrubberDragLeftSource = _d.mainScrubberDragLeft_img.src;
		_s.mainScrubberLine_img = _d.mainScrubberLine_img;
		_s.volumeScrubberBkLeft_img = _d.volumeScrubberBkLeft_img;
		_s.volumeScrubberDragBottom_img = _d.volumeScrubberDragBottom_img;
		_s.volumeScrubberLine_img = _d.volumeScrubberLine_img;
		_s.volumeN_img = _d.volumeN_img;
		_s.progressLeft_img = _d.progressLeft_img;
		_s.categoriesN_img = _d.categoriesN_img;
		_s.prt = prt;
		
		_s.playlistN_img = _d.playlistN_img;
		
		_s.ytbQualityN_img = _d.ytbQualityN_img;
		_s.infoN_img = _d.infoN_img;
		_s.downloadN_img = _d.downloadN_img;
		_s.facebookN_img = _d.facebookN_img;
		_s.fullScreenN_img = _d.fullScreenN_img;
		_s.normalScreenN_img = _d.normalScreenN_img;
		_s.hidePlaylistN_img = _d.hidePlaylistN_img;
		_s.showPlaylistN_img = _d.showPlaylistN_img;
		_s.embedN_img = _d.embedN_img;
	
		_s.buttons_ar = [];
		
		_s.useHEX = _d.useHEX; 
		_s.nBC = _d.nBC;
		_s.sBC = _d.sBC;
		
		_s.bkMiddlePath_str = _d.bkMiddlePath_str;
		_s.mainScrubberBkMiddlePath_str = _d.mainScrubberBkMiddlePath_str;
		_s.volumeScrubberBkMiddlePath_str = _d.volumeScrubberBkMiddlePath_str;
		_s.mainScrubberDragMiddlePath_str = _d.mainScrubberDragMiddlePath_str;
		_s.volumeScrubberDragMiddlePath_str = _d.volumeScrubberDragMiddlePath_str;
		_s.timeColor_str = _d.timeColor_str;
		_s.progressMiddlePath_str = _d.progressMiddlePath_str;
		_s.youtubeQualityButtonNormalColor_str = _d.youtubeQualityButtonNormalColor_str;
		_s.youtubeQualityButtonSelectedColor_str = _d.youtubeQualityButtonSelectedColor_str;
		_s.youtubeQualityArrowPath_str = _d.youtubeQualityArrowPath_str;
		_s.controllerBkPath_str = _d.controllerBkPath_str;
		_s.ytbQualityButtonPointerPath_str = _d.ytbQualityButtonPointerPath_str;
		_s.buttonsToolTipFontColor_str = _d.buttonsToolTipFontColor_str;
		
		_s.buttonsToolTipHideDelay = _d.buttonsToolTipHideDelay;
		_s.ttYtbBtns = 0;
		_s.sW = 0;
		_s.sH = _d.controllerHeight;
		_s.scrbsBkLARW = _s.mainScrubberBkLeft_img.width;
		_s.maiScrbW = 0;
		_s.mainScrbMinW = 100;
		_s.volumeScrubberOfsetHeight = _d.volumeScrubberOfsetHeight;
		_s.volumeScrubberHeight = _d.volumeScrubberHeight + _s.volumeScrubberOfsetHeight;
		_s.volScrbW = _s.mainScrubberBkLeft_img.height;
		_s.mainScrbH = _s.mainScrubberBkLeft_img.height;
		_s.mainScrbDrgLW = _s.mainScrubberDragLeft_img.width;
		_s.scrubbersOffsetWidth = _d.scrubbersOffsetWidth;
		_s.volume = _d.volume;
		
		_s.lastVolume = _s.volume;
		_s.startSpaceBetweenButtons = _d.startSpaceBetweenButtons;
		_s.spaceBetweenButtons = _d.spaceBetweenButtons;
		_s.percentPlayed = 0;
		_s.percentLoaded = 0;
		_s.lastTimeLength = 0;
		_s.prevYtbQualityButtonsLength = 0;
		_s.pointerWidth = 8;
		_s.pointerHeight = 5;
		_s.timeOffsetLeftWidth = _d.timeOffsetLeftWidth;
		_s.timeOffsetRightWidth = _d.timeOffsetRightWidth;
		_s.timeOffsetTop = _d.timeOffsetTop;
		_s.mainScrubberOffestTop = _d.mainScrubberOffestTop;
		
		_s.isVolumeScrubberShowed_bl = true;
		_s.volumeScrubberIsDragging_bl = false;
		_s.showButtonsToolTip_bl = _d.showButtonsToolTip_bl;
		_s.showPlaylistsButtonAndPlaylists_bl = _d.showPlaylistsButtonAndPlaylists_bl;
		_s.showPlaylistButtonAndPlaylist_bl = _d.showPlaylistButtonAndPlaylist_bl;
		_s.showEmbedButton_bl = _d.showEmbedButton_bl;
		_s.showPlaylistByDefault_bl = _d.showPlaylistByDefault_bl;
		_s.showShuffleButton_bl = _d.showShuffleButton_bl;
		_s.showLoopButton_bl = _d.showLoopButton_bl;
		
		_s.showNP_bl = prt._d.showNextAndPrevButtonsInController_bl;
		_s.showNextAndPrevButtonsInController_bl = _d.showNextAndPrevButtonsInController_bl;
		_s.showFullScreenButton_bl = _d.showFullScreenButton_bl;
		_s.disableVideoScrubber_bl = _d.disableVideoScrubber_bl;
		_s.showYoutubeQualityButton_bl = _d.showYoutubeQualityButton_bl;
		_s.showShareButton_bl = _d.showShareButton_bl;
		_s.showInfoButton_bl = _d.showInfoButton_bl;
		_s.showDownloadVideoButton_bl = _d.showDownloadVideoButton_bl;
		_s.showVolumeScrubber_bl = _d.showVolumeScrubber_bl;
		_s.allowToChangeVolume_bl = _d.allowToChangeVolume_bl;
		_s.showTime_bl = _d.showTime_bl;
		_s.showVolumeButton_bl = _d.showVolumeButton_bl;
		_s.showControllerWhenVideoIsStopped_bl = _d.showControllerWhenVideoIsStopped_bl;
		_s.showRewindButton_bl = _d.showRewindButton_bl;
		_s.showSubBtn = _d.showSubBtn;
		_s.muted = prt._d.autoPlay_bl;
		_s.isShowed_bl = true;
		_s.showNextAndPrevButtons_bl = _d.showNextAndPrevButtons_bl;
		_s.isPlaylistShowed_bl = _d.isPlaylistShowed_bl;
		_s.areYtbQualityButtonsShowed_bl = true;
		_s.repeatBackground_bl = _d.repeatBackground_bl;
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.useVectorIcons_bl = _d.useVectorIcons_bl


		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setOverflow("visible");
			_s.mainHld = new FWDUVPDisplayObject("div");
			if(_d.useAToB) _s.setupATB();

			if(_s.repeatBackground_bl){
				_s.bk_do = new FWDUVPDisplayObject("div");
				_s.bk_do.getStyle().background = "url('" + _s.controllerBkPath_str +  "')";
			}else{
				_s.bk_do = new FWDUVPDisplayObject("img");
				var img = new Image();
				img.src = _s.controllerBkPath_str;
				_s.bk_do.setScreen(img);	
			}
			_s.mainHld.addChild(_s.bk_do);
			
			_s.mainHld.setOverflow("visible");
			_s.mainHld.getStyle().zIndex = 1;
		
			_s.addChild(_s.mainHld);
			
			if(_s.showYoutubeQualityButton_bl){
				_s.ytbQuality_ar = ["hd4320", "hd2880","hd2160", "hd1440", "highres", "hd1080", "hd720", "large", "medium", "small", "tiny"];
				
				_s.ytbButtons_ar = [];
				_s.ttYtbBtns = _s.ytbQuality_ar.length;
				_s.setupYtbButtons();
			}
			
			if(_s.showNextAndPrevButtonsInController_bl) _s.setupPrevButton();
			_s.setupPlayPauseButton();
			if(_s.showRewindButton_bl) _s.setupRewindButton();
			if(_s.showNextAndPrevButtonsInController_bl) _s.setupNextButton();
			_s.setupMainScrubber();
			if(_s.showTime_bl) _s.setupTime();
			
			if(_s.showVolumeButton_bl) _s.setupVolumeButton();
			
			if(_s.showPlaylistsButtonAndPlaylists_bl) _s.setupCategoriesButton();
			if(_s.showPlaylistButtonAndPlaylist_bl) _s.setupPlaylistButton();

			if(_s.showYoutubeQualityButton_bl) _s.setupYoutubeQualityButton();
			
			if(_s.showShareButton_bl) _s.setupShareButton();
			if(_s.showEmbedButton_bl) _s.setupEmbedButton();
			if(_d.useAToB) _s.setupAtbButton();

			if(_s.showInfoButton_bl) _s.setupInfoButton();
			
			if(_d.showPlaybackRateButton_bl) _s.setupPlaybackRateButton();
			if(_s.showDownloadVideoButton_bl) _s.setupDownloadButton();
			if(_s.showSubBtn) _s.setupSubtitleButton();
			if(_d.showChromecastButton_bl) _s.setupChromecastButton();
			if(_d.showAudioTracksButton_bl) _s.setupAudioTracksButton();
			if(_d.show360DegreeVideoVrButton_bl) _s.setupVrButton();
			if(_s.showFullScreenButton_bl) _s.setupFullscreenButton();
			if(_s.showButtonsToolTip_bl) _s.setupToolTips();
			
			if(_s.showVolumeScrubber_bl){
				_s.setupVolumeScrubber();
				_s.hideVolumeScrubber();
			}
			_s.hide(false);
		};

		
		//###########################################//
		// Resize and position _s...
		//###########################################//
		_s.resizeAndPosition = function(){

			_s.sW = prt.tempVidStageWidth;
			_s.positionButtons();
			_s.setY(prt.tempVidStageHeight - _s.sH);
			_s.hideQualityButtons(false);
			if(_s.ytbButtonsHolder_do){
				FWDAnimation.killTweensOf(_s.ytbButtonsHolder_do);
				_s.ytbButtonsHolder_do.setY(prt.tempStageHeight);
			}
			
			if(_s.subtitlesButtonsHolder_do){
				FWDAnimation.killTweensOf(_s.subtitlesButtonsHolder_do);
				_s.subtitlesButtonsHolder_do.setY(prt.sH);
			}

			if(_s.ATBButtonsHolder_do){
				FWDAnimation.killTweensOf(_s.ATBButtonsHolder_do);
				_s.ATBButtonsHolder_do.setY(prt.sH);
			}
			
			if(_s.playbackRatesButtonsHolder_do){
				FWDAnimation.killTweensOf(_s.playbackRatesButtonsHolder_do);
				_s.playbackRatesButtonsHolder_do.setY(prt.sH);
			}
			
			_s.positionAdsLines();
		};
		
		_s.getButtonIndex = function(button){
			return FWDUVPUtils.indexOfArray(_s.buttons_ar, button);
		}
		
		
		//##############################//
		/* setup background */
		//##############################//
		_s.positionButtons = function(){
			if(!_s.sW) return;
			var button;
			var prevButton;
			var totalButtons = 0;
			var totalButtonsWidth = 0;
			var spaceBetweenButtons = 0;
			var leftWidth = 0;
			var hasTime_bl = _s.showTime_bl;
			var indexToAdd;
			
			if(!_d.playlist_ar || !_d.playlist_ar[prt.id]) return;

			
			if(prt.is360 && _s.vrButton_do){
				_s.addVrButton();
			}else{
				_s.removeVrButton();
			}
			
			// download button
			if(_s.showDownloadVideoButton_bl){
				if(_d.playlist_ar[prt.id]['downloadable']){
					if(_s.getButtonIndex(_s.downloadButton_do) == -1){
						if(_s.ccBtn_do && _s.getButtonIndex(_s.ccBtn_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.ccBtn_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.downloadButton_do);
						}else if(_s.vrButton_do){
							indexToAdd = _s.getButtonIndex(_s.vrButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.downloadButton_do);
						}else if(_s.fullScreenButton_do){
							indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.downloadButton_do);
						}else{
							_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.downloadButton_do);
						}
						_s.downloadButton_do.setVisible(true);
					}
				}else{
					var downloadButtonIndex = _s.getButtonIndex(_s.downloadButton_do);
					if(downloadButtonIndex != -1){
						_s.buttons_ar.splice(downloadButtonIndex,1);
						_s.downloadButton_do.setVisible(false);
					}
				}
			};
			
			// info button
			if(_s.showInfoButton_bl){
				if(_d.playlist_ar[prt.id].desc){
					if(_s.getButtonIndex(_s.infoButton_do) == -1){
						if(_s.downloadButton_do && _s.getButtonIndex(_s.downloadButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.downloadButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.infoButton_do);
						}else if(_s.ccBtn_do && _s.getButtonIndex(_s.ccBtn_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.ccBtn_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.infoButton_do);
						}else if(_s.vrButton_do){
							indexToAdd = _s.getButtonIndex(_s.vrButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.infoButton_do);
						}else if(_s.fullScreenButton_do){
							indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.infoButton_do);
						}else{
							_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.infoButton_do);
						}
						_s.infoButton_do.setVisible(true);
					}
				}else{
					var downloadButtonIndex = _s.getButtonIndex(_s.infoButton_do);
					if(downloadButtonIndex != -1){
						_s.buttons_ar.splice(downloadButtonIndex,1);
						_s.infoButton_do.setVisible(false);
					}
				}
			};
	
			// a to be buttons
			if(_d['useAToB']){
				if(_d.playlist_ar[prt.id]['atb']){
					if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.atbButton_do) == -1){
						if(_s.infoButton_do && _s.getButtonIndex(_s.infoButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.infoButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.atbButton_do);
						}else if(_s.downloadButton_do && _s.getButtonIndex(_s.downloadButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.downloadButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.atbButton_do);
						}else if(_s.ccBtn_do && _s.getButtonIndex(_s.ccBtn_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.ccBtn_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.atbButton_do);
						}else if(_s.vrButton_do){
							indexToAdd = _s.getButtonIndex(_s.vrButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.atbButton_do);
						}else if(_s.fullScreenButton_do){
							indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.atbButton_do);
						}else{
							_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.atbButton_do);
						}
						_s.atbButton_do.setVisible(true);
					}
				}else{
					var atbButtonIndex = FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.atbButton_do);
					if(atbButtonIndex != -1){
						_s.buttons_ar.splice(atbButtonIndex,1);
						_s.atbButton_do.setVisible(false);
						_s.atb.hide(true);
					}
				}
			};

			// Subtitle button
			if(_s.showSubBtn){
				if(_d.playlist_ar[prt.id].subtitleSource){
					if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.subtitleButton_do) == -1){
						if(_s.playbackRateButton_do && _s.getButtonIndex(_s.playbackRateButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.playbackRateButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else if(_s.atbButton_do && _s.getButtonIndex(_s.atbButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.atbButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else if(_s.infoButton_do && _s.getButtonIndex(_s.infoButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.infoButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else if(_s.downloadButton_do && _s.getButtonIndex(_s.downloadButton_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.downloadButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else if(_s.ccBtn_do && _s.getButtonIndex(_s.ccBtn_do) != -1){
							indexToAdd = _s.getButtonIndex(_s.ccBtn_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else if(_s.vrButton_do){
							indexToAdd = _s.getButtonIndex(_s.vrButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else if(_s.fullScreenButton_do){
							indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
							_s.buttons_ar.splice(indexToAdd, 0, _s.subtitleButton_do);
						}else{
							_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.subtitleButton_do);
						}
						_s.subtitleButton_do.setVisible(true);
					}
				}else{
					var subtitleButtonIndex = FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.subtitleButton_do);
					if(subtitleButtonIndex != -1){
						_s.buttons_ar.splice(subtitleButtonIndex,1);
						_s.subtitleButton_do.setVisible(false);
						_s.subtitleButton_do.setX(-5000);
					}
				}
			};
			

			
			if(prt.videoType_str == FWDUVPlayer.VIMEO && !_d.showDefaultControllerForVimeo_bl){
				
				var playButtonIndex = FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.playPauseButton_do);
				if(playButtonIndex != -1){
					_s.buttons_ar.splice(playButtonIndex, 1);
					_s.playPauseButton_do.setVisible(false);
					_s.playPauseButton_do.setX(-500);
				}
				_s.mainScrubber_do.setVisible(false);
			}else{
				if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.playPauseButton_do) == -1){
					if(_s.playPauseButton_do){
						indexToAdd = 0;
						_s.buttons_ar.splice(indexToAdd, 0, _s.playPauseButton_do);
						_s.playPauseButton_do.setVisible(true);
					}
				}
				
				if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.rewindButton_do) == -1){
					if(_s.rewindButton_do){
						indexToAdd = FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.playPauseButton_do);
						_s.buttons_ar.splice(indexToAdd, 0, _s.rewindButton_do);
						_s.rewindButton_do.setVisible(true);
					}
				}
			
				if(_s.showVolumeButton_bl){
					if(_s.showTime_bl){
						if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.volBtn) == -1){
							indexToAdd = FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.time_do) + 1;
							_s.buttons_ar.splice(indexToAdd, 0, _s.volBtn);
							_s.volBtn.setVisible(true);
						}
					}else{
						if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.volBtn) == -1){
							indexToAdd = FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.mainScrubber_do) + 1;
							_s.buttons_ar.splice(indexToAdd, 0, _s.volBtn);
							_s.volBtn.setVisible(true);
						}
					}
				}
				
				_s.mainScrubber_do.setVisible(true);
			}
		
			
			var buttonsCopy_ar = [];
			for (var i=0; i < _s.buttons_ar.length; i++) {
				buttonsCopy_ar[i] = _s.buttons_ar[i];
			}
			
			if(prt.tempPlaylistPosition_str == "right" 
				&& _s.showNextAndPrevButtonsInController_bl
				&& !_s.showNP_bl){
				if(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.nextButton_do) != -1){
					buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.nextButton_do), 1);
					buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.prevButton_do), 1);
					_s.nextButton_do.setX(-1000);
					_s.prevButton_do.setX(-1000);
				}
			}
			
			_s.maiScrbW = _s.sW - _s.startSpaceBetweenButtons * 2;
			for (var i=0; i < buttonsCopy_ar.length; i++) {
				button = buttonsCopy_ar[i];
				if(button != _s.mainScrubber_do){
					_s.maiScrbW -= button.w + _s.spaceBetweenButtons;
				}
			};
		
			if(prt.videoType_str == FWDUVPlayer.VIMEO && _s.maiScrbW >= 120 && !_d.showDefaultControllerForVimeo_bl){
				if(_s.mainScrubber_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.mainScrubber_do) != -1){
					buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.mainScrubber_do), 1);
					_s.positionScrollBarOnTopOfTheController();
				}
				
				if(_s.time_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.time_do) != -1){
					buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.time_do), 1);
					_s.time_do.setX(-1000);
				}
				
				totalButtons = buttonsCopy_ar.length;
				for(var i=0; i<totalButtons; i++){
					totalButtonsWidth += buttonsCopy_ar[i].w;
				}
				
				spaceBetweenButtons = _s.spaceBetweenButtons;
				leftWidth = _s.sW - buttonsCopy_ar[totalButtons - 1].w - _s.startSpaceBetweenButtons - 2;
				
				for (var i=totalButtons - 1; i>=0 ; i--) {
					
					button = buttonsCopy_ar[i];
					if(i == totalButtons - 1){
						button.setX(leftWidth);
					}else{
						prevButton = buttonsCopy_ar[i + 1];
						button.setX(prevButton.x - button.w - spaceBetweenButtons);	
					}
				}
			
			}else if(_s.maiScrbW <= 120 || prt.videoType_str == FWDUVPlayer.VIMEO && !_d.showDefaultControllerForVimeo_bl){
				if(_s.mainScrubber_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.mainScrubber_do) != -1){
					buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.mainScrubber_do), 1);
					_s.positionScrollBarOnTopOfTheController();
				}
				
				if(_s.time_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.time_do) != -1){
					buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.time_do), 1);
					_s.time_do.setX(-1000);
				}
				
				totalButtons = buttonsCopy_ar.length;
				for(var i=0; i<totalButtons; i++){
					totalButtonsWidth += buttonsCopy_ar[i].w;
				}
			
					spaceBetweenButtons = parseInt((_s.sW - totalButtonsWidth - _s.startSpaceBetweenButtons * 2)/(totalButtons - 1));
					leftWidth = parseInt((_s.sW - totalButtonsWidth - ((totalButtons - 1) * spaceBetweenButtons))/2);
					
					for (var i=0; i < totalButtons; i++) {
						button = buttonsCopy_ar[i];
						if(i == 0){
							button.setX(leftWidth);
						}else{
							prevButton = buttonsCopy_ar[i - 1];
							button.setX(prevButton.x + prevButton.w + spaceBetweenButtons);	
						}
					}
			}else{
				while(_s.maiScrbW < _s.mainScrbMinW){
					_s.maiScrbW = _s.sW - _s.startSpaceBetweenButtons * 2;
					if(_s.time_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.time_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.time_do), 1);
						_s.time_do.setX(-1000);
						hasTime_bl = false;
					}else if(_s.shareButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.shareButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.shareButton_do), 1);
						_s.shareButton_do.setX(-1000);
					}else if(_s.downloadButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.downloadButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.downloadButton_do), 1);
						_s.downloadButton_do.setX(-1000);
					}else if(_s.embedButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.embedButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.embedButton_do), 1);
						_s.embedButton_do.setX(-1000);
					}else if(_s.volBtn && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.volBtn) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.volBtn), 1);
						_s.volBtn.setX(-1000);
					}else if(_s.playbackRateButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.playbackRateButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.playbackRateButton_do), 1);
						_s.playbackRateButton_do.setX(-1000);
					}else if(_s.ytbQualityButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.ytbQualityButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.ytbQualityButton_do), 1);
						_s.ytbQualityButton_do.setX(-1000);
					}else if(_s.playlistButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.playlistButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.playlistButton_do), 1);
						_s.playlistButton_do.setX(-1000);
					}else if(_s.infoButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.infoButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.infoButton_do), 1);
						_s.infoButton_do.setX(-1000);
					}else if(_s.categoriesButton_do && FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.categoriesButton_do) != -1){
						buttonsCopy_ar.splice(FWDUVPUtils.indexOfArray(buttonsCopy_ar, _s.categoriesButton_do), 1);
						_s.categoriesButton_do.setX(-1000);
					}
							
					totalButtons = buttonsCopy_ar.length;
					for (var i=0; i < totalButtons; i++) {
						button = buttonsCopy_ar[i];
						if(button != _s.mainScrubber_do){
							_s.maiScrbW -= button.w + _s.spaceBetweenButtons;
						}
					};
				};
				
				if(_s.showNextAndPrevButtonsInController_bl
					&& _s.maiScrbW > 120){			
				}
				
				if(hasTime_bl) _s.maiScrbW -= _s.timeOffsetLeftWidth * 2;
				totalButtons = buttonsCopy_ar.length;
				
				for (var i=0; i < totalButtons; i++) {
					button = buttonsCopy_ar[i];
					
					if(i == 0){
						button.setX(_s.startSpaceBetweenButtons);
					}else if(button == _s.mainScrubber_do){
						prevButton = buttonsCopy_ar[i - 1];
						FWDAnimation.killTweensOf(_s.mainScrubber_do);
						_s.mainScrubber_do.setX(prevButton.x + prevButton.w + _s.spaceBetweenButtons);
						_s.mainScrubber_do.setY(parseInt((_s.sH - _s.mainScrbH)/2));
						_s.mainScrubber_do.setWidth(_s.maiScrbW + 1);
						_s.mainScrubberBkMiddle_do.setWidth(_s.maiScrbW - _s.scrbsBkLARW * 2);
						_s.mainScrubberBkRight_do.setX(_s.maiScrbW - _s.scrbsBkLARW);
						_s.mainScrubberDragMiddle_do.setWidth(_s.maiScrbW - _s.scrbsBkLARW - _s.scrubbersOffsetWidth);
					}else if(button == _s.time_do){
						prevButton = buttonsCopy_ar[i - 1];
						button.setX(prevButton.x + prevButton.w + _s.spaceBetweenButtons + _s.timeOffsetLeftWidth);
						var timeOffset = 0;
						if(_s.isLive) timeOffset = 1;
						button.setY(parseInt((_s.sH - button.h)/2) + timeOffset);
					}else if(button == _s.volBtn && hasTime_bl){
						prevButton = buttonsCopy_ar[i - 1];
						button.setX(prevButton.x + prevButton.w + _s.spaceBetweenButtons + _s.timeOffsetRightWidth);
					}else{
						prevButton = buttonsCopy_ar[i - 1];
						button.setX(prevButton.x + prevButton.w + _s.spaceBetweenButtons);
					}
				}
				
				if(_s.isShowed_bl){
					_s.isMainScrubberOnTop_bl = false;
				}else{
					_s.isMainScrubberOnTop_bl = true;
					_s.positionScrollBarOnTopOfTheController();
				}
			}
		
			if(_s.bk_do){
				_s.bk_do.setWidth(_s.sW);
				_s.bk_do.setHeight(_s.sH);
			}
			
			if(_s.progressMiddle_do) _s.progressMiddle_do.setWidth(Math.max(_s.maiScrbW - _s.scrbsBkLARW - _s.scrubbersOffsetWidth, 0));
			_s.updateMainScrubber(_s.percentPlayed);
			_s.updatePreloaderBar(_s.percentLoaded);
			
			_s.mainHld.setWidth(_s.sW);
			_s.mainHld.setHeight(_s.sH);
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH);

			if(_s.atb) _s.atb.resize();
		};
		
		_s.positionScrollBarOnTopOfTheController = function(){
			
			_s.maiScrbW = _s.sW;
			_s.updatePreloaderBar(_s.percentLoaded);
			
			_s.mainScrubber_do.setWidth(_s.maiScrbW + 1);
			_s.mainScrubberBkMiddle_do.setWidth(_s.maiScrbW - _s.scrbsBkLARW * 2);
			_s.mainScrubberBkRight_do.setX(_s.maiScrbW - _s.scrbsBkLARW);
			_s.mainScrubberDragMiddle_do.setWidth(_s.maiScrbW - _s.scrbsBkLARW - _s.scrubbersOffsetWidth);
			
			var offset = 0;
			if(_s.atb && _s.atb.isShowed_bl) offset = _s.sH;
			
			FWDAnimation.killTweensOf(_s.mainScrubber_do);
			_s.mainScrubber_do.setX(0);
			_s.mainScrubber_do.setAlpha(1);
			
			if(_s.isMainScrubberOnTop_bl || _s.isShowed_bl){
				if(_s.atb && _s.atb.isShowed_bl && !_s.isShowed_bl){
				 	offset += _s.mainScrubberOffestTop;
				}else{
					offset = 0;
				}
				
				FWDAnimation.killTweensOf(_s.mainScrubber_do);
				if(_s.isShowed_bl){
					_s.mainScrubber_do.setY(- _s.mainScrubberOffestTop - offset);
				}else{
					FWDAnimation.to(_s.mainScrubber_do, .8, {y:- _s.mainScrubberOffestTop - offset, ease:Expo.easeOut});
				}
			}else if(!_s.isLive){
				
				FWDAnimation.to(_s.mainScrubber_do, .8, {y:- _s.mainScrubberOffestTop - offset, ease:Expo.easeOut});
			}
			
			_s.isMainScrubberOnTop_bl = true;
		};
	
			
		//################################//
		/* Setup tooltips */
		//################################//		
		_s.setupToolTips = function(){
			FWDUVPToolTip.setPrototype();
			_s.playPauseToolTip_do = new FWDUVPToolTip(_s.playPauseButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "play / pause", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
			document.documentElement.appendChild(_s.playPauseToolTip_do.screen);
			
			if(_s.showControllerWhenVideoIsStopped_bl){
				FWDUVPToolTip.setPrototype();
				_s.prevButtonToolTip_do = new FWDUVPToolTip(_s.prevButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "previous video", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.prevButtonToolTip_do.screen);
				
				FWDUVPToolTip.setPrototype();
				_s.nextButtonToolTip_do = new FWDUVPToolTip(_s.nextButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "next video", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.nextButtonToolTip_do.screen);
			}
			
			if(_s.showPlaylistsButtonAndPlaylists_bl){
				FWDUVPToolTip.setPrototype();
				_s.playlistsButtonToolTip_do = new FWDUVPToolTip(_s.categoriesButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "show playlists", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.playlistsButtonToolTip_do.screen);
			}
			
			if(_s.showPlaylistButtonAndPlaylist_bl){
				FWDUVPToolTip.setPrototype();
				_s.playlistButtonToolTip_do = new FWDUVPToolTip(_s.playlistButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "show / hide playlist", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.playlistButtonToolTip_do.screen);
			}
			
			if(_s.showEmbedButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.embedButtonToolTip_do = new FWDUVPToolTip(_s.embedButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "show embed window", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.embedButtonToolTip_do.screen);
			}
			
			if(_s.showShareButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.facebookButtonToolTip_do = new FWDUVPToolTip(_s.shareButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "share", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.facebookButtonToolTip_do.screen);
			}
			
			if(_d.showChromecastButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.castButtonToolTip_do = new FWDUVPToolTip(_s.ccBtn_do, _d.toopTipBk_str, _d.toopTipPointer_str, "chromecast", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.castButtonToolTip_do.screen);
			}

			FWDUVPToolTip.setPrototype();
			_s.atbButtonToolTip_do = new FWDUVPToolTip(_s.atbButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "a to b loop", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
			document.documentElement.appendChild(_s.atbButtonToolTip_do.screen);
			
			if(_s.showSubBtn){
				FWDUVPToolTip.setPrototype();
				_s.subtitleButtonToolTip_do = new FWDUVPToolTip(_s.subtitleButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "show / hide subtitle", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.subtitleButtonToolTip_do.screen);
			}
			
			
			if(_s.showInfoButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.infoButtonToolTip_do = new FWDUVPToolTip(_s.infoButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "more info", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.infoButtonToolTip_do.screen);
			}
			
			if(_s.showDownloadVideoButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.downloadButtonToolTip_do = new FWDUVPToolTip(_s.downloadButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "download video", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.downloadButtonToolTip_do.screen);
			}
			
			if(_s.fullScreenButton_do){
				FWDUVPToolTip.setPrototype();
				_s.fullscreenButtonToolTip_do = new FWDUVPToolTip(_s.fullScreenButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "fullscreen / normalscreen", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.fullscreenButtonToolTip_do.screen);
			}

			if(_s.vrButton_do){
				FWDUVPToolTip.setPrototype();
				_s.vrToolTip_do = new FWDUVPToolTip(_s.vrButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "VR", _s.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.vrToolTip_do.screen);
			}
		};
		
		_s.showToolTip = function(button, toolTip, e){
			if(!_s.showButtonsToolTip_bl) return;
			var ws = FWDUVPUtils.getViewportSize();
			var wc = FWDUVPUtils.getViewportMouseCoordinates(e);
			var localX;
			var localY;
			
			if(button.screen.offsetWidth < 3){
				localX = parseInt(button.getGlobalX() * 100 + button.w/2 - toolTip.w/2);
				localY = parseInt(button.getGlobalY() * 100 - toolTip.h - 8);
			}else{
				localX = parseInt(button.getGlobalX() + button.w/2 - toolTip.w/2);
				localY = parseInt(button.getGlobalY() - toolTip.h - 8);
			}
			
			var offseX = 0;
		
			if(localX < 0){
				offseX = localX;
				localX = 0;
			}else if(localX + toolTip.w > ws.w){
				offseX = (ws.w - (localX + toolTip.w)) * -1;
				localX = localX + (offseX * -1);
			}
			
			toolTip.positionPointer(offseX, false);
			
			toolTip.setX(localX);
			toolTip.setY(localY);
			toolTip.show();
			
		};

		
		//################################################//
		/* Setup main scrubber */
		//################################################//
		_s.setupAdsLines = function(linesAr, id, catId, overwrite){
			if(_s.createdAdsOnce_bl || _s.curLinesId == id && _s.curLinesCat == catId && !overwrite) return;
			
			_s.curLinesId = id;
			_s.curLinesCat = catId;
			
			if(!linesAr) return;
			_s.resetsAdsLines();

			if(!_s.linesHolder_do){
				_s.linesHolder_do = new FWDUVPDisplayObject("div");
				_s.linesHolder_do.setOverflow("visible");
				_s.mainScrubber_do.addChild(_s.linesHolder_do);
			}
			
			_s.createdAdsOnce_bl = true;
			_s.lines_ar = linesAr;
			if(_s.lines_ar){
				var line;
				_s.line_ar = [];
				for(var i=0; i<_s.lines_ar.length; i++){
					line = new FWDUVPDisplayObject("div");
					line.screen.className = 'uvp-ad-line';
					var src = _d.adLinePat_str;
					if(_s.useHEX && window['isWhite']){
						src = _d.sknPth + 'ad-line-dark.png';
					}
					line.getStyle().background = "url('" + src + "') repeat-x";
					line.timeStart = linesAr[i].timeStart;
					line.setWidth(2);
					line.setHeight(_s.mainScrubberDragLeft_img.height);
					line.isUsed_bl = false;
					line.isShowed_bl = false;
					if(_s.lines_ar[i].played_bl) line.setVisible(false);
					line.setAlpha(0);
					_s.line_ar[i] = line;
					_s.linesHolder_do.addChild(line);
				}
			}
			_s.totalDuration = 0;
		};
		
		_s.hideAdsLines = function(){
			if(_s.linesHolder_do) _s.linesHolder_do.setX(-5000);
			if(_s.line_ar){
				for(var i=0; i<_s.line_ar.length; i++){
					_s.line_ar[i].setAlpha(0);
					_s.line_ar[i].isShowed_bl = false;
				}
			}
		}
		
		_s.positionAdsLines = function(totalDuration){
		
			if(!_s.linesHolder_do || !prt.totalDuration || !_s.createdAdsOnce_bl)  return;
		
			_s.totalDuration = prt.totalDuration;
			
			if(prt.isAdd_bl){
				_s.linesHolder_do.setX(-5000);
			}else{
				_s.linesHolder_do.setX(0);
			}
		
			if(_s.line_ar){
				var line;
				for(var i=0; i<_s.line_ar.length; i++){
					line = _s.line_ar[i];
					var x = Math.round((line.timeStart/_s.totalDuration) * _s.maiScrbW) - 1;
					line.setX(x);
					if(line.x < 0) line.setX(0);
					if(!line.isUsed_bl && _s.totalDuration != 0 && !line.isShowed_bl){
						FWDAnimation.to(line, 1, {alpha:1, delay:1, ease:Expo.easeOut});
						line.isShowed_bl = true;
					}
				}
			}
		}
		
		_s.resetsAdsLines = function(){
			if(_s.line_ar){
				for(var i=0; i<_s.line_ar.length; i++){
					FWDAnimation.killTweensOf(_s.line_ar[i]);
					_s.linesHolder_do.removeChild(_s.line_ar[i]);
				}
				_s.createdAdsOnce_bl = false;
				_s.curLinesId = -1;
				_s.line_ar = null;
				_s.hadLInes = false;
			}
		}

		
		//##########################################//
		/* Setup playback rate button */
		//##########################################//
		_s.playbackRatesSource_ar = _d.defaultPlaybackRate_ar;
		_s.playbackRateButtons_ar = [];
		_s.totalPlaybackRateButtons = 6;
		_s.arePlaybackRateButtonsShowed_bl = true;
		if(!_s.showPlaybackRateButton_bl) _s.arePlaybackRateButtonsShowed_bl = false;
		
		_s.setupPlaybackRateButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.playbackRateButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-watch-later'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
				
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.playbackRateButton_do = new FWDUVPSimpleButton(_d.playbackRateNPath_img,
															 _d.playbackRateSPath_str, 
															 undefined, 
															 true,
															 _s.useHEX,
															 _s.nBC,
															 _s.sBC);
			}
			
			_s.playbackRateButton_do.screen.className = 'fwduvp-playback-rate-button';
			_s.playbackRateButton_do.setY(parseInt((_s.sH - _s.playbackRateButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.playbackRateButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.playbackRateButton_do.setY(parseInt((_s.sH - _s.playbackRateButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.playbackRateButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.playbackRateButtonMouseUpHandler);
			_s.mainHld.addChild(_s.playbackRateButton_do);
			_s.playbackRateButton_do.setX(-500);
			
			_s.disablePlaybackRateButton();
			_s.setupPlaybackRateButtons();	
		}
		
		_s.playbackRateButtonMouseUpHandler = function(){
			if(_s.arePlaybackRateButtonsShowed_bl){
				_s.hidePlaybackRateButtons(true);
			}else{
				_s.showPlaybackRateButtons(true);
				_s.hideMainScrubberTop();
			}
		};
		
		_s.disablePlaybackRateButton = function(){
			if(_s.playbackRateButton_do) _s.playbackRateButton_do.disable();
		};
		
		_s.enablePlaybackRateButton = function(){
			if(_s.playbackRateButton_do) _s.playbackRateButton_do.enable();
		};
				
		_s.removePlaybackRateButton = function(){
			if(!_s.playbackRateButton_do) return;
			if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.playbackRateButton_do) != -1){
				_s.buttons_ar.splice(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.playbackRateButton_do), 1);
				_s.playbackRateButton_do.setX(-300);
				_s.positionButtons();
			}
		};
		
		_s.addPlaybackRateButton = function(rate){
			if(!_s.playbackRateButton_do) return;
			
			if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.playbackRateButton_do) != -1) return;
			var indexToAdd;

			if(_s.atbButton_do && _s.getButtonIndex(_s.atbButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.atbButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.playbackRateButton_do);
			}else if(_s.infoButton_do && _s.getButtonIndex(_s.infoButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.infoButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.playbackRateButton_do);
			}else if(_s.downloadButton_do && _s.getButtonIndex(_s.downloadButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.downloadButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.playbackRateButton_do);
			}else if(_s.ccBtn_do && _s.getButtonIndex(_s.ccBtn_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.ccBtn_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.playbackRateButton_do);
			}else if(_s.vrButton_do){
				indexToAdd = _s.getButtonIndex(_s.vrButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.playbackRateButton_do);
			}else if(_s.fullScreenButton_do){
				indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.playbackRateButton_do);
			}else{
				_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.playbackRateButton_do);
			}
			
			_s.updatePlaybackRateButtons(rate);
		};

		
		//###################################################//
		/* Setup PlaybackRatebuttons */
		//###################################################//
		_s.updatePlaybackRateButtons = function(playbackRateIndex){
			if(!_s.playbackRateButton_do) return;
			setTimeout(function(){
				_s.disablePlaybackRateButtons(playbackRateIndex);
			},65);
			_s.prevplaybackRateIndex = playbackRateIndex;
		};	
		
		_s.setupPlaybackRateButtons = function(){
			
			_s.playbackRatesButtonsHolder_do = new FWDUVPDisplayObject("div");
			_s.playbackRatesButtonsHolder_do.setOverflow("visible");
			
			if(_s.repeatBackground_bl){
				_s.playbackRatesButtonsHolder_do.getStyle().background = "url('" + _s.controllerBkPath_str +  "')";
			}else{
				_s.playbackRatesButtonsBackground_do = new FWDUVPDisplayObject("img");
				var img = new Image();
				img.src = _s.controllerBkPath_str;
				_s.playbackRatesButtonsBackground_do.setScreen(img);
				_s.playbackRatesButtonsHolder_do.addChild(_s.playbackRatesButtonsBackground_do);
			}
			
			_s.playbackRatesButtonsHolder_do.setX(300);
			_s.playbackRatesButtonsHolder_do.setY(-300);
			prt.videoHolder_do.addChild(_s.playbackRatesButtonsHolder_do);
			
			var img = new Image();
			img.src = _s.ytbQualityButtonPointerPath_str;
			_s.playbackRatesPonter_do = new FWDUVPDisplayObject("img");
			_s.playbackRatesPonter_do.setScreen(img);
			_s.playbackRatesPonter_do.setWidth(_s.pointerWidth);
			_s.playbackRatesPonter_do.setHeight(_s.pointerHeight);
			_s.playbackRatesButtonsHolder_do.addChild(_s.playbackRatesPonter_do);
	
			
			var img = new Image();
			img.src = _s.youtubeQualityArrowPath_str;
			_s.playbackRateQualityArrow_do = new FWDUVPDisplayObject("img");
			_s.playbackRateQualityArrow_do.setScreen(img);
			_s.playbackRateQualityArrow_do.setX(7);
			_s.playbackRateQualityArrow_do.setWidth(5);
			_s.playbackRateQualityArrow_do.setHeight(7);
			_s.playbackRatesButtonsHolder_do.addChild(_s.playbackRateQualityArrow_do);
			
			var btn;
			
			for(var i=0; i<_s.totalPlaybackRateButtons; i++){
				FWDUVPYTBQButton.setPrototype();
				btn = new FWDUVPYTBQButton("no source", 
						_s.youtubeQualityButtonNormalColor_str, 
						_s.youtubeQualityButtonSelectedColor_str,
						undefined,
						i);
				
				btn.addListener(FWDUVPYTBQButton.MOUSE_OVER, _s.plbkQualityOver);
				btn.addListener(FWDUVPYTBQButton.MOUSE_OUT, _s.plbkQualityOut);
				btn.addListener(FWDUVPYTBQButton.CLICK, _s.plbkQualityClick);
				_s.playbackRateButtons_ar[i] = btn;
				_s.playbackRatesButtonsHolder_do.addChild(btn);
			}
			_s.positionAndResizePlaybackRateButtons(_s.playbackRatesSource_ar);
			_s.hidePlaybackRateButtons(false);
		};
		
		_s.plbkQualityOver = function(e){
			_s.setPlaybackRateArrowPosition(e.target);
		};
		
		_s.plbkQualityOut = function(e){
			_s.setPlaybackRateArrowPosition(undefined);
		};
		
		_s.plbkQualityClick = function(e){
			_s.startAtPlaybackRate = e.id;
			_s.disablePlaybackRateButtons(_s.startAtPlaybackRate);
			_s.hidePlaybackRateButtons(true);
			_s.dispatchEvent(FWDUVPController.CHANGE_PLAYBACK_RATES, {rate:_s.playbackRatesSource_ar[e.id]});
		};
		
		_s.positionAndResizePlaybackRateButtons = function(ar){
			if(!ar) return;
			
			var totalButtons = ar.length;
			if(_s.prevplaybackRatesQualityButtonsLength == totalButtons) return;
			_s.prevplaybackRatesQualityButtonsLength = totalButtons;
			var btn;
			var startY = 5;
			var totalWidth = 0;
			var totalHeight = 0;
			
			for(var i=0; i<totalButtons; i++){
				btn = _s.playbackRateButtons_ar[i];
				if(ar[i] == 1){
					btn.updateText("normal");
				}else{
					btn.updateText(ar[i]);
				}
				
				btn.setFinalSize();
			}
			
			setTimeout(function(){
				for(var i=0; i<totalButtons; i++){
					btn = _s.playbackRateButtons_ar[i];
					if(i < totalButtons){
						if(btn.x != 0) btn.setX(0);
						if(btn.w > totalWidth) totalWidth = btn.w;
						btn.setY(startY);
						startY += btn.h;
					}else{
						if(btn.x != -3000) btn.setX(-3000);
					}
				}
				
				for(var i=0; i<totalButtons; i++){
					btn = _s.playbackRateButtons_ar[i];
					if(btn.dumy_do.w < totalWidth){
						btn.setWidth(totalWidth);
						btn.dumy_do.setWidth(totalWidth);
					}
				}
				
				totalHeight = startY + 5;
				_s.playbackRatesPonter_do.setX(parseInt((totalWidth - _s.playbackRatesPonter_do.w)/2));
				_s.playbackRatesPonter_do.setY(totalHeight);
				if(_s.playbackRatesButtonsBackground_do){	
					_s.playbackRatesButtonsBackground_do.setWidth(totalWidth);
					_s.playbackRatesButtonsBackground_do.setHeight(totalHeight);
				}
				_s.playbackRatesButtonsHolder_do.setWidth(totalWidth);
				_s.playbackRatesButtonsHolder_do.setHeight(totalHeight);
			}, 60);
		};
		
		_s.disablePlaybackRateButtons = function(index){
			if(index == undefined) return;
			for(var i=0; i<_s.totalPlaybackRateButtons; i++){
				var btn = _s.playbackRateButtons_ar[i];
				if(i == index){
					FWDAnimation.killTweensOf(_s.playbackRateQualityArrow_do);
					_s.playbackRateQualityArrow_do.setY(btn.y + parseInt((btn.h - _s.playbackRateQualityArrow_do.h)/2) - 1);
					btn.disable();
					_s.playbackRateDisabledButton_do = btn;
				}else{
					btn.enable();
				}
			}
		};
		
		_s.setPlaybackRateArrowPosition = function(target){
			var curY = 0;
			if(!target){
				curY = _s.playbackRateDisabledButton_do.y + parseInt((_s.playbackRateDisabledButton_do.h - _s.playbackRateQualityArrow_do.h)/2 - 1);
			}else{
				curY = target.y + parseInt((target.h - _s.playbackRateQualityArrow_do.h)/2 - 1);
			}
			FWDAnimation.killTweensOf(_s.playbackRateQualityArrow_do);
			FWDAnimation.to(_s.playbackRateQualityArrow_do, .6, {y:curY, delay:.1, ease:Expo.easeInOut});
		};
		
		_s.showPlaybackRateButtons = function(animate){
			if(_s.arePlaybackRateButtonsShowed_bl) return;
			_s.hideQualityButtons();
			_s.arePlaybackRateButtonsShowed_bl = true;
			var finalX = parseInt(_s.playbackRateButton_do.x + (parseInt(_s.playbackRateButton_do.w - _s.playbackRatesButtonsHolder_do.w)/2));
			var finalY = parseInt(prt.tempVidStageHeight - _s.sH - _s.playbackRatesButtonsHolder_do.h - 6);
			
			if(_s.hasPointerEvent_bl){
				window.addEventListener("pointerdown", _s.hideplaybackRatesButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.addEventListener("mousedown", _s.hideplaybackRatesButtonsHandler);
				}
				window.addEventListener("touchstart", _s.hideplaybackRatesButtonsHandler);
			}
			
			_s.playbackRatesButtonsHolder_do.setX(finalX);
		
			if(animate){
				FWDAnimation.to(_s.playbackRatesButtonsHolder_do, .6, {y:finalY, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.playbackRatesButtonsHolder_do);
				_s.playbackRatesButtonsHolder_do.setY(finalY);
			}
		};
	
		_s.hidePlaybackRateButtons = function(animate){
			if(!_s.arePlaybackRateButtonsShowed_bl || !_s.playbackRatesButtonsHolder_do) return;
			_s.arePlaybackRateButtonsShowed_bl = false;
			_s.showMainScrubberOnTop();
			
			if(animate){
				FWDAnimation.to(_s.playbackRatesButtonsHolder_do, .6, {y:prt.sH, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.playbackRatesButtonsHolder_do);
				_s.playbackRatesButtonsHolder_do.setY(prt.sH);
			}
			
			if(_s.hasPointerEvent_bl){
				window.removeEventListener("pointerdown", _s.hideplaybackRatesButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.removeEventListener("mousedown", _s.hideplaybackRatesButtonsHandler);
				}
				window.removeEventListener("touchstart", _s.hideplaybackRatesButtonsHandler);
			}
		};
		
		_s.hideplaybackRatesButtonsHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(FWDUVPUtils.hitTest(_s.playbackRateButton_do.screen, vc.screenX, vc.screenY)
			   || FWDUVPUtils.hitTest(_s.playbackRatesButtonsHolder_do.screen, vc.screenX, vc.screenY)){
				return;
			}
			_s.hidePlaybackRateButtons(true);
		};

		
		//###############################################//
		/* Set is live */
		//###############################################//
		_s.setIsLive = function(isLive){
			_s.isLive = isLive;
			if(isLive){
				if(!_s.mainScrubber_do.contains(_s.live_do)){
					_s.mainScrubber_do.setAlpha(.2);
					_s.mainHld.addChild(_s.live_do);
					setTimeout(function(){
							_s.live_do.setX(4);
							_s.live_do.setY(- _s.live_do.getHeight() - 4);
					}, 100)
					_s.disableMainScrubber();
				}
			}else{
				if(_s.mainHld.contains(_s.live_do)){
					_s.mainHld.removeChild(_s.live_do);
					_s.mainScrubber_do.setAlpha(1);
					
					_s.enableMainScrubber();
				}
			}
		}
		
		//################################################//
		/* Setup main scrubber */
		//################################################//
		_s.setupMainScrubber = function(){
			//setup background bar
			_s.mainScrubber_do = new FWDUVPDisplayObject("div");
			_s.mainScrubber_do.screen.className = 'fwduvp-main-scrubber';
			_s.mainScrubber_do.setY(parseInt((_s.sH - _s.mainScrbH)/2));
			_s.mainScrubber_do.setHeight(_s.mainScrbH);
			
			_s.mainScrubberBkLeft_do = new FWDUVPDisplayObject("img");
			_s.mainScrubberBkLeft_do.setScreen(_s.mainScrubberBkLeft_img);
			
			var rightImage = new Image();
			rightImage.src = _d.mainScrubberBkRightPath_str;
			_s.mainScrubberBkRight_do = new FWDUVPDisplayObject("img");
			_s.mainScrubberBkRight_do.setScreen(rightImage);
			_s.mainScrubberBkRight_do.setWidth(_s.mainScrubberBkLeft_do.w);
			_s.mainScrubberBkRight_do.setHeight(_s.mainScrubberBkLeft_do.h);
		
			var middleImage = new Image();
			middleImage.src = _s.mainScrubberBkMiddlePath_str;
			
			_s.mainScrubberBkMiddle_do = new FWDUVPDisplayObject("div");	
			_s.mainScrubberBkMiddle_do.getStyle().background = "url('" + _s.mainScrubberBkMiddlePath_str + "') repeat-x";
				
			_s.mainScrubberBkMiddle_do.setHeight(_s.mainScrbH);
			_s.mainScrubberBkMiddle_do.setX(_s.scrbsBkLARW);
			
			//setup progress bar
			_s.mainProgress_do = new FWDUVPDisplayObject("div");
			_s.mainProgress_do.setHeight(_s.mainScrbH);
		
			_s.progressLeft_do = new FWDUVPDisplayObject("img");
			_s.progressLeft_do.setScreen(_s.progress);
			
			middleImage = new Image();
			middleImage.src = _s.progressMiddlePath_str;
			
			_s.progressMiddle_do = new FWDUVPDisplayObject("div");	
			_s.progressMiddle_do.getStyle().background = "url('" + _s.progressMiddlePath_str + "') repeat-x";
		
			_s.progressMiddle_do.setHeight(_s.mainScrbH);
			_s.progressMiddle_do.setX(_s.mainScrbDrgLW);
			
			//setup darg bar.
			_s.mainScrubberDrag_do = new FWDUVPDisplayObject("div");
			_s.mainScrubberDrag_do.setHeight(_s.mainScrbH);
		
			if(_s.useHEX){
				_s.mainScrubberDragLeft_do = new FWDUVPDisplayObject("div");
				_s.mainScrubberDragLeft_do.setWidth(_s.mainScrubberDragLeft_img.width);
				_s.mainScrubberDragLeft_do.setHeight(_s.mainScrubberDragLeft_img.height);
				_s.mainScrubberDragLeft_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.mainScrubberDragLeft_img, _s.nBC).canvas;
				_s.mainScrubberDragLeft_do.screen.appendChild(_s.mainScrubberDragLeft_canvas);	
			}else{
				_s.mainScrubberDragLeft_do = new FWDUVPDisplayObject("img");
				_s.mainScrubberDragLeft_do.setScreen(_s.mainScrubberDragLeft_img);
			}
			
			_s.mainScrubberMiddleImage = new Image();
			_s.mainScrubberMiddleImage.src = _s.mainScrubberDragMiddlePath_str;
			_s.volumeScrubberDragMiddle_do = new FWDUVPDisplayObject("div");
			
			if(_s.useHEX){
				_s.mainScrubberDragMiddle_do = new FWDUVPDisplayObject("div");
				_s.mainScrubberMiddleImage.onload = function(){
					var testCanvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.mainScrubberMiddleImage, _s.nBC, true);
					_s.mainSCrubberMiddleCanvas = testCanvas.canvas;
					_s.mainSCrubberDragMiddleImageBackground = testCanvas.image;
					_s.mainScrubberDragMiddle_do.getStyle().background = "url('" + _s.mainSCrubberDragMiddleImageBackground.src + "') repeat-x";
				}
			}else{
				_s.mainScrubberDragMiddle_do = new FWDUVPDisplayObject("div");	
				_s.mainScrubberDragMiddle_do.getStyle().background = "url('" + _s.mainScrubberDragMiddlePath_str + "') repeat-x";
			}
			
			_s.mainScrubberDragMiddle_do.setHeight(_s.mainScrbH);
			_s.mainScrubberDragMiddle_do.setX(_s.mainScrbDrgLW);
			
			_s.mainScrubberBarLine_do = new FWDUVPDisplayObject("img");
			_s.mainScrubberBarLine_do.setScreen(_s.mainScrubberLine_img);
			_s.mainScrubberBarLine_do.setAlpha(0);
			_s.mainScrubberBarLine_do.hasTransform3d_bl = false;
			_s.mainScrubberBarLine_do.hasTransform2d_bl = false;
			
			_s.buttons_ar.push(_s.mainScrubber_do);
			
			_s.live_do = new FWDUVPDisplayObject("div");
			_s.live_do.hasTransform3d_bl = false;
			_s.live_do.hasTransform2d_bl = false;
			_s.live_do.setBackfaceVisibility();
			_s.live_do.getStyle().fontFamily = "Arial";
			_s.live_do.getStyle().fontSize= "12px";
			_s.live_do.getStyle().whiteSpace= "nowrap";
			_s.live_do.getStyle().textAlign = "center";
			_s.live_do.getStyle().padding = "4px";
			_s.live_do.getStyle().paddingLeft = "6px";
			_s.live_do.getStyle().paddingRIght = "6px";
			_s.live_do.getStyle().color = "#FFFFFF";
			_s.live_do.getStyle().fontSmoothing = "antialiased";
			_s.live_do.getStyle().webkitFontSmoothing = "antialiased";
			_s.live_do.getStyle().textRendering = "optimizeLegibility";
			_s.live_do.getStyle().backgroundColor = "rgba(255,0,0,0.8)";
			_s.live_do.setInnerHTML("&#x25C9; LIVE");
			
			//add all children
			_s.mainScrubber_do.addChild(_s.mainScrubberBkLeft_do);
			_s.mainScrubber_do.addChild(_s.mainScrubberBkMiddle_do);
			_s.mainScrubber_do.addChild(_s.mainScrubberBkRight_do);
			_s.mainScrubber_do.addChild(_s.mainScrubberBarLine_do);
			_s.mainScrubberDrag_do.addChild(_s.mainScrubberDragLeft_do);
			_s.mainScrubberDrag_do.addChild(_s.mainScrubberDragMiddle_do);
			_s.mainProgress_do.addChild(_s.progressLeft_do);
			_s.mainProgress_do.addChild(_s.progressMiddle_do);
			_s.mainScrubber_do.addChild(_s.mainProgress_do);
			_s.mainScrubber_do.addChild(_s.mainScrubberDrag_do);
			_s.mainScrubber_do.addChild(_s.mainScrubberBarLine_do);
			_s.mainHld.addChild(_s.mainScrubber_do);
			
			if(!_s.disableVideoScrubber_bl){
				if(_s.hasPointerEvent_bl){
					_s.mainScrubber_do.screen.addEventListener("pointerover", _s.mainScrubberOnOverHandler);
					_s.mainScrubber_do.screen.addEventListener("pointerout", _s.mainScrubberOnOutHandler);
					_s.mainScrubber_do.screen.addEventListener("pointerdown", _s.mainScrubberOnDownHandler);
				}else if(_s.screen.addEventListener){	
					if(!_s.isMbl){
						_s.mainScrubber_do.screen.addEventListener("mouseover", _s.mainScrubberOnOverHandler);
						_s.mainScrubber_do.screen.addEventListener("mousemove", _s.updateTooltipOnMove);
						_s.mainScrubber_do.screen.addEventListener("mouseout", _s.mainScrubberOnOutHandler);
						_s.mainScrubber_do.screen.addEventListener("mousedown", _s.mainScrubberOnDownHandler);
					}
					_s.mainScrubber_do.screen.addEventListener("touchstart", _s.mainScrubberOnDownHandler);
				}
			}
			
			_s.disableMainScrubber();
			_s.updateMainScrubber(0);

			FWDUVPScrubberToolip.setPrototype();
			_s.ttm = new FWDUVPScrubberToolip(_s.mainScrubber_do, _d.scrubbersToolTipLabelBackgroundColor, _d.scrubbersToolTipLabelFontColor);
			_s.addChild(_s.ttm);
		};

		_s.updateToolTip = function(localX, percentScrubbed){
			if(!_d.showMainScrubberToolTipLabel_bl) return;
			if(prt.isCasting){
				_s.ttm.setLabel(FWDUVPUtils.formatTime(Math.round(prt.cc.getDuration() * percentScrubbed)));
			}else{
				_s.ttm.setLabel(FWDUVPUtils.formatTime(Math.round(prt.totalDuration * percentScrubbed)));
			}
			_s.ttm.setX(Math.round(_s.mainScrubber_do.x + localX - _s.ttm.getWidth()/2) + 1);
			 
			_s.ttm.setY(_s.mainScrubber_do.y - _s.ttm.h - 2);
		}
		
		_s.updateThumbnailsPreview = function(localX, percentScrubbed){
			if(!_s.thumbnailsPreview_do || !prt.hasThumbnailsPreview) return;
			var pointerOffsetX = 0;
			
			var x = Math.round(_s.mainScrubber_do.x + localX - _s.thumbnailsPreview_do.getWidth()/2) + 1;
			if(x < 1){
				pointerOffsetX = x;
				x = 1;
			}else if(x > _s.sW - _s.thumbnailsPreview_do.w - 1){
				pointerOffsetX = x - _s.sW + _s.thumbnailsPreview_do.w;
				x = _s.sW - _s.thumbnailsPreview_do.w - 1;
			}
			_s.thumbnailsPreview_do.setLabel(FWDUVPUtils.formatTime(Math.round(prt.totalDuration * percentScrubbed)), Math.round(prt.totalDuration * percentScrubbed), pointerOffsetX);
			_s.thumbnailsPreview_do.setX(x);
			_s.thumbnailsPreview_do.setY(_s.mainScrubber_do.y - _s.thumbnailsPreview_do.h - 2);
		}

		_s.updateTooltipOnMove = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localX = vc.screenX - _s.mainScrubber_do.getGlobalX();
			
			if(localX < 0){
				localX = 0;
			}else if(localX > _s.maiScrbW - _s.scrubbersOffsetWidth){
				localX = _s.maiScrbW - _s.scrubbersOffsetWidth;
			}
			var percentScrubbed = localX/_s.maiScrbW;

			_s.updateToolTip(localX, percentScrubbed);
			_s.updateThumbnailsPreview(localX, percentScrubbed);
		}

		_s.mainScrubberWMouseMove = function(e){
			var wc = FWDUVPUtils.getViewportMouseCoordinates(e);
			_s.vcX = wc.screenX;
			_s.vcY = wc.screenY;
			if(!FWDUVPUtils.hitTest(_s.mainScrubber_do.screen, _s.vcX, _s.vcY)){
				if(!_s.isMainScrubberScrubbing_bl){
					window.removeEventListener('mousemove', _s.mainScrubberWMouseMove);
					_s.ttm.hide();
				} 
			}
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localX = vc.screenX - _s.mainScrubber_do.getGlobalX();
			
			if(localX < 0){
				localX = 0;
			}else if(localX > _s.maiScrbW - _s.scrubbersOffsetWidth){
				localX = _s.maiScrbW - _s.scrubbersOffsetWidth;
			}
			var percentScrubbed = localX/_s.maiScrbW;
			_s.updateThumbnailsPreview(localX, percentScrubbed);
		}
		
		_s.mainScrubberOnOverHandler =  function(e){
			if(_s.isMainScrubberDisabled_bl) return;
			if(_d.showMainScrubberToolTipLabel_bl && !prt.hasThumbnailsPreview) _s.ttm.show();
			if(_s.thumbnailsPreview_do && prt.hasThumbnailsPreview) _s.thumbnailsPreview_do.show();
		
			if(!_s.isMbl && (_s.ttm || _s.thumbnailsPreview_do)){
				window.removeEventListener('mousemove', _s.mainScrubberWMouseMove);
				window.addEventListener('mousemove', _s.mainScrubberWMouseMove);
			}
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localX = vc.screenX - _s.mainScrubber_do.getGlobalX();
		
			if(localX < 0){
				localX = 0;
			}else if(localX > _s.maiScrbW - _s.scrubbersOffsetWidth){
				localX = _s.maiScrbW - _s.scrubbersOffsetWidth;
			}
			var percentScrubbed = localX/_s.maiScrbW;

			_s.updateToolTip(localX, percentScrubbed);
			_s.updateThumbnailsPreview(localX, percentScrubbed);
		};
		
		_s.mainScrubberOnOutHandler =  function(e){
			if(!_s.isMainScrubberScrubbing_bl){
				if(_s.ttm) _s.ttm.hide();
				if(_s.thumbnailsPreview_do && prt.hasThumbnailsPreview) _s.thumbnailsPreview_do.hide();
			}
		};
		
		_s.mainScrubberOnDownHandler =  function(e){
			if(_s.isMainScrubberDisabled_bl || e.button == 2) return;
			
			prt.showDisable();
			if(e.preventDefault) e.preventDefault();
			_s.isMainScrubberScrubbing_bl = true;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localX = vc.screenX - _s.mainScrubber_do.getGlobalX();
			
			if(localX < 0){
				localX = 0;
			}else if(localX > _s.maiScrbW - _s.scrubbersOffsetWidth){
				localX = _s.maiScrbW - _s.scrubbersOffsetWidth;
			}
			var percentScrubbed = localX/_s.maiScrbW;
		
			if(_d.showMainScrubberToolTipLabel_bl && !prt.hasThumbnailsPreview) _s.ttm.show();
			if(_s.thumbnailsPreview_do && prt.hasThumbnailsPreview) _s.thumbnailsPreview_do.show();
			_s.updateToolTip(localX, percentScrubbed);
			_s.updateMainScrubber(percentScrubbed);
			_s.updateThumbnailsPreview(localX, percentScrubbed);
			
			_s.dispatchEvent(FWDUVPController.START_TO_SCRUB);
			_s.dispatchEvent(FWDUVPController.SCRUB, {percent:percentScrubbed});
			
			if(_s.hasPointerEvent_bl){
				window.addEventListener("pointermove", _s.mainScrubberMoveHandler);
				window.addEventListener("pointerup", _s.mainScrubberEndHandler);
			}else{
				window.addEventListener("mousemove", _s.mainScrubberMoveHandler);
				window.addEventListener("mouseup", _s.mainScrubberEndHandler);		
				window.addEventListener("touchmove", _s.mainScrubberMoveHandler, {passive:false});
				window.addEventListener("touchend", _s.mainScrubberEndHandler);
			}	
		};
		
		_s.mainScrubberMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localX = vc.screenX - _s.mainScrubber_do.getGlobalX();
			
			if(localX < 0){
				localX = 0;
			}else if(localX > _s.maiScrbW - _s.scrubbersOffsetWidth){
				localX = _s.maiScrbW - _s.scrubbersOffsetWidth;
			}
			
			var percentScrubbed = localX/_s.maiScrbW;
			_s.updateToolTip(localX, percentScrubbed);
			_s.updateMainScrubber(percentScrubbed);
			_s.updateThumbnailsPreview(localX, percentScrubbed);
			_s.dispatchEvent(FWDUVPController.SCRUB, {percent:percentScrubbed});
		};
		
		_s.mainScrubberEndHandler = function(e){
			prt.hideDisable();			
			if(e){
				var wp = FWDUVPUtils.getViewportMouseCoordinates(e);
				if(!FWDUVPUtils.hitTest(_s.mainScrubber_do.screen, wp.screenX, wp.screenY)){
					if(_s.ttm) _s.ttm.hide();
					if(_s.thumbnailsPreview_do && prt.hasThumbnailsPreview) _s.thumbnailsPreview_do.hide();
				}
			}
	
			_s.isMainScrubberScrubbing_bl = false;
			_s.dispatchEvent(FWDUVPController.STOP_TO_SCRUB);
			
			if(_s.hasPointerEvent_bl){
				window.removeEventListener("pointermove", _s.mainScrubberMoveHandler);
				window.removeEventListener("pointerup", _s.mainScrubberEndHandler);
			}else{
				window.removeEventListener("mousemove", _s.mainScrubberMoveHandler);
				window.removeEventListener("mouseup", _s.mainScrubberEndHandler);		
				window.removeEventListener("touchmove", _s.mainScrubberMoveHandler);
				window.removeEventListener("touchend", _s.mainScrubberEndHandler);
			}
		};
		
		_s.disableMainScrubber = function(){
			if(!_s.mainScrubber_do) return;
			_s.isMainScrubberDisabled_bl = true;
			_s.mainScrubber_do.setButtonMode(false);
			_s.mainScrubberEndHandler();
			_s.mainScrubberOnOutHandler();
			_s.updateMainScrubber(0);
			_s.updatePreloaderBar(0);
		};
		
		_s.enableMainScrubber = function(){
			if(!_s.mainScrubber_do || _s.isLive) return;
			_s.isMainScrubberDisabled_bl = false;
			if(!_s.disableVideoScrubber_bl) _s.mainScrubber_do.setButtonMode(true);
		};
		
		_s.updateMainScrubber = function(percent){
			if(!_s.mainScrubber_do) return;
			if(_s.isLive) percent = 0;
			var finalWidth = parseInt(percent * _s.maiScrbW);
			if(isNaN(finalWidth) || finalWidth == undefined) return;
			if(finalWidth < 0) finalWidth = 0;
			
			_s.percentPlayed = percent;
			if(!FWDUVPlayer.hasHTML5Video && finalWidth >= _s.mainProgress_do.w) finalWidth = _s.mainProgress_do.w;
			
			if(finalWidth < 1 && _s.isMainScrubberLineVisible_bl){
				_s.isMainScrubberLineVisible_bl = false;
				FWDAnimation.to(_s.mainScrubberBarLine_do, .5, {alpha:0});
			}else if(finalWidth > 1 && !_s.isMainScrubberLineVisible_bl){
				_s.isMainScrubberLineVisible_bl = true;
				FWDAnimation.to(_s.mainScrubberBarLine_do, .5, {alpha:1});
			}
			
			_s.mainScrubberDrag_do.setWidth(finalWidth);
			if(finalWidth > _s.maiScrbW - _s.scrubbersOffsetWidth) finalWidth = _s.maiScrbW - _s.scrubbersOffsetWidth;
			if(finalWidth < 0) finalWidth = 0;
			FWDAnimation.to(_s.mainScrubberBarLine_do, .8, {x:finalWidth + 1, ease:Expo.easeOut});
		};
		
		_s.updatePreloaderBar = function(percent){
			if(!_s.mainProgress_do) return;
			if(_s.isLive) percent = 0;
			_s.percentLoaded = percent;
			var finalWidth = parseInt(_s.percentLoaded * _s.maiScrbW); 
			if(isNaN(finalWidth) || finalWidth == undefined) return;
			if(finalWidth < 0) finalWidth = 0;
			
			if(_s.percentLoaded >= 0.98){
				_s.percentLoaded = 1;
				_s.mainProgress_do.setY(-30);
			}else if(_s.mainProgress_do.y != 0 && _s.percentLoaded!= 1){
				_s.mainProgress_do.setY(0);
			}
			if(finalWidth > _s.maiScrbW - _s.scrubbersOffsetWidth) finalWidth = _s.maiScrbW - _s.scrubbersOffsetWidth;
			if(finalWidth < 0) finalWidth = 0;
			_s.mainProgress_do.setWidth(finalWidth);
		};
		

		//################################################//
		/* Setup prev button */
		//################################################//
		_s.setupPrevButton = function(){
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.prevButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-FF-left'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.prevButton_do = new FWDUVPSimpleButton(_d.prev2N_img, _d.prevSPath_str, undefined, true, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}
			
			_s.prevButton_do.screen.className = 'fwduvp-prev-button';
			_s.prevButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.prevButtonShowTooltipHandler);
			_s.prevButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.prevButtonOnMouseUpHandler);
			_s.prevButton_do.setY(parseInt((_s.sH - _s.prevButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.prevButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.prevButton_do.setY(parseInt((_s.sH - _s.prevButton_do.buttonHeight)/2));
				}
			}, 50);
		
			_s.buttons_ar.push(_s.prevButton_do);
			_s.mainHld.addChild(_s.prevButton_do); 
		};
		
		_s.prevButtonShowTooltipHandler = function(e){
			
			_s.showToolTip(_s.prevButton_do, _s.prevButtonToolTip_do, e.e);
		};
		
		_s.prevButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPPlaylist.PLAY_PREV_VIDEO);
		};

		
		//################################################//
		/* Setup next button */
		//################################################//
		_s.setupNextButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.nextButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-FF-right'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.nextButton_do = new FWDUVPSimpleButton(_d.next2N_img, _d.nextSPath_str, undefined, true, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}

			_s.nextButton_do.screen.className = 'fwduvp-next-button';
			_s.nextButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.nextButtonShowTooltipHandler);
			_s.nextButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.nextButtonOnMouseUpHandler);
			_s.nextButton_do.setY(parseInt((_s.sH - _s.nextButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.nextButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.nextButton_do.setY(parseInt((_s.sH - _s.nextButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.buttons_ar.push(_s.nextButton_do);
			_s.mainHld.addChild(_s.nextButton_do);
		};
		
		_s.nextButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.nextButton_do, _s.nextButtonToolTip_do, e.e);
		};
		
		_s.nextButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPPlaylist.PLAY_NEXT_VIDEO);
		};

	
		//################################################//
		/* Setup play button */
		//################################################//
		_s.setupPlayPauseButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPComplexButton.setPrototype();
				_s.playPauseButton_do = new FWDUVPComplexButton(undefined, undefined, undefined, undefined, true, undefined, undefined, undefined,
					"<span class='fwdicon fwdicon-play'></span>",
					"<span class='fwdicon fwdicon-pause'></span>",
					"UVPMainButtonsNormalState play",
					"UVPMainButtonsSelectedState play"
				);
			}else{
				FWDUVPComplexButton.setPrototype();
				_s.playPauseButton_do = new FWDUVPComplexButton(
						_s.playN_img,
						_d.playSPath_str,
						_s.pauseN_img,
						_d.pauseSPath_str,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.buttons_ar.push(_s.playPauseButton_do);
			_s.playPauseButton_do.setY(parseInt((_s.sH - _s.playPauseButton_do.buttonHeight)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.playPauseButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.playPauseButton_do.setY(parseInt((_s.sH - _s.playPauseButton_do.buttonHeight)/2));
				}
			}, 50);

			_s.playPauseButton_do.screen.className = 'fwduvp-play-button';
			_s.playPauseButton_do.addListener(FWDUVPComplexButton.SHOW_TOOLTIP, _s.playButtonShowTooltipHandler);
			_s.playPauseButton_do.addListener(FWDUVPComplexButton.MOUSE_UP, _s.playButtonMouseUpHandler);
			_s.mainHld.addChild(_s.playPauseButton_do);
		};
		
		
		_s.playButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.playPauseButton_do, _s.playPauseToolTip_do, e.e);
		};
		
		_s.showPlayButton = function(){
			if(!_s.playPauseButton_do) return;
			_s.playPauseButton_do.setButtonState(1);
		};
		
		_s.showPauseButton = function(){
			if(!_s.playPauseButton_do) return;
			_s.playPauseButton_do.setButtonState(0);
		};
		
		_s.playButtonMouseUpHandler = function(){
			if(_s.playPauseButton_do.currentState == 0){
				_s.dispatchEvent(FWDUVPController.PAUSE);
			}else{
				_s.dispatchEvent(FWDUVPController.PLAY);
			}
		};
		
		_s.disablePlayButton = function(){
			_s.playPauseButton_do.disable();
			_s.playPauseButton_do.setNormalState();
			_s.showPlayButton();
		};
		
		_s.enablePlayButton = function(){
			_s.playPauseButton_do.enable();
		};
		

		//##########################################//
		/* Setup categories buttons */
		//##########################################//
		_s.setupCategoriesButton = function(){
			if(_s.useVectorIcons_bl){				
				FWDUVPSimpleButton.setPrototype();
				_s.categoriesButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-playlist'></span>",
						undefined,
						"UVPMainButtonsNormalState cats",
						"UVPMainButtonsSelectedState cats"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.categoriesButton_do = new FWDUVPSimpleButton(_s.categoriesN_img, _d.categoriesSPath_str, undefined, true, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}

			_s.categoriesButton_do.screen.className = 'fwduvp-categories-button';
			_s.categoriesButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.categoriesButtonShowTooltipHandler);
			_s.categoriesButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.categoriesButtonOnMouseUpHandler);
			_s.categoriesButton_do.setY(parseInt((_s.sH - _s.categoriesButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.categoriesButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.categoriesButton_do.setY(parseInt((_s.sH - _s.categoriesButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.buttons_ar.push(_s.categoriesButton_do);
			_s.mainHld.addChild(_s.categoriesButton_do); 
		};
		
		_s.categoriesButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.categoriesButton_do, _s.playlistsButtonToolTip_do, e.e);
		};
		
		_s.categoriesButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.SHOW_CATEGORIES);
		};
		
		_s.setCategoriesButtonState = function(state){	
			if(!_s.categoriesButton_do) return;
			if(state == "selected"){
				_s.categoriesButton_do.setSelected();
			}else if(state == "unselected"){
				_s.categoriesButton_do.setUnselected();
			}
		};
		

		//##########################################//
		/* Setup playlist button */
		//##########################################//
		_s.setupPlaylistButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPComplexButton.setPrototype();
				_s.playlistButton_do = new FWDUVPComplexButton(undefined, undefined, undefined, undefined, true, undefined, undefined, undefined,
					"<span class='fwdicon fwdicon-playlist-sidebar'></span>",
					"<span class='fwdicon fwdicon-playlist-close-sidebar'></span>",
					"UVPMainButtonsNormalState playlist",
					"UVPMainButtonsSelectedState playlist"
				);
			}else{
				FWDUVPComplexButton.setPrototype();
				_s.playlistButton_do = new FWDUVPComplexButton(
						_s.hidePlaylistN_img,
						_d.hidePlaylistSPath_str,
						_s.showPlaylistN_img,
						_d.showPlaylistSPath_str,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.buttons_ar.push(_s.playlistButton_do);
			_s.playlistButton_do.setY(parseInt((_s.sH - _s.playlistButton_do.buttonHeight)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.playlistButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.playlistButton_do.setY(parseInt((_s.sH - _s.playlistButton_do.buttonHeight)/2));
				}
			}, 50);

			_s.playlistButton_do.screen.className = 'fwduvp-playlist-button';
			_s.playlistButton_do.addListener(FWDUVPComplexButton.SHOW_TOOLTIP, _s.playlistButtonShowToolTipHandler);
			_s.playlistButton_do.addListener(FWDUVPComplexButton.MOUSE_UP, _s.playlistButtonMouseUpHandler);
			if(!_s.showPlaylistByDefault_bl) _s.playlistButton_do.setButtonState(0);
			_s.mainHld.addChild(_s.playlistButton_do);
			
		};
		
		_s.playlistButtonShowToolTipHandler = function(e){
			_s.showToolTip(_s.playlistButton_do, _s.playlistButtonToolTip_do, e.e);
		};
		
		_s.showShowPlaylistButton = function(){
			if(!_s.playlistButton_do) return;
			_s.playlistButton_do.setButtonState(1);
		};
		
		_s.showHidePlaylistButton = function(){
			if(!_s.playlistButton_do) return;
			_s.playlistButton_do.setButtonState(0);
		};
		
		_s.playlistButtonMouseUpHandler = function(){
			if(_s.playlistButton_do.currentState == 1){
				_s.dispatchEvent(FWDUVPController.SHOW_PLAYLIST);
			}else{
				_s.dispatchEvent(FWDUVPController.HIDE_PLAYLIST);
			}
			_s.playlistButton_do.setNormalState(true);
			if(_s.playlistButtonToolTip_do) _s.playlistButtonToolTip_do.hide();
		};
		
		_s.disablePlaylistButton = function(){
			if(_s.playlistButton_do){
				_s.playlistButton_do.disable();
				_s.playlistButton_do.setAlpha(.4);
			}
		};
		
		_s.enablePlaylistButton = function(){
			if(_s.playlistButton_do){
				_s.playlistButton_do.enable();
				_s.playlistButton_do.setAlpha(1);
			}
		};
		

		//##########################################//
		/* Setup embed button */
		//#########################################//
		_s.setupEmbedButton = function(){
			if(_s.useVectorIcons_bl){			
				FWDUVPSimpleButton.setPrototype();
				_s.embedButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-embed'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.embedButton_do = new FWDUVPSimpleButton(_s.embedN_img, _d.embedPathS_str, undefined, true, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}

			_s.embedButton_do.screen.className = 'fwduvp-embed-button';
			_s.embedButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.embedButtonShowToolTipHandler);
			_s.embedButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.embedButtonOnMouseUpHandler);
			_s.embedButton_do.setY(parseInt((_s.sH - _s.embedButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.embedButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.embedButton_do.setY(parseInt((_s.sH - _s.embedButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.buttons_ar.push(_s.embedButton_do);
			_s.mainHld.addChild(_s.embedButton_do);
		};
		
		_s.embedButtonShowToolTipHandler = function(e){
			_s.showToolTip(_s.embedButton_do, _s.embedButtonToolTip_do, e.e);
		};
		
		_s.embedButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.SHOW_EMBED_WINDOW);
			if(_s.embedButtonToolTip_do) _s.embedButtonToolTip_do.hide();
		};

		
		//###################################################//
		/* Setup youtube quality buttons */
		//###################################################//
		_s.setupYtbButtons = function(){
			_s.ytbButtonsHolder_do = new FWDUVPDisplayObject("div");
			_s.ytbButtonsHolder_do.setOverflow("visible");
			if(_s.repeatBackground_bl){
				_s.ytbButtonsHolder_do.getStyle().background = "url('" + _s.controllerBkPath_str +  "')";
			}else{
				_s.ytbButtonBackground_do = new FWDUVPDisplayObject("img");
				var img = new Image();
				img.src = _s.controllerBkPath_str;
				_s.ytbButtonBackground_do.setScreen(img);
				_s.ytbButtonsHolder_do.addChild(_s.ytbButtonBackground_do);
			}
			
			_s.ytbButtonsHolder_do.setX(300);
			_s.ytbButtonsHolder_do.setY(-300);
			prt.videoHolder_do.addChild(_s.ytbButtonsHolder_do, 0);
			
			var img = new Image();
			img.src = _s.ytbQualityButtonPointerPath_str;
			_s.pointer_do = new FWDUVPDisplayObject("img");
			_s.pointer_do.setScreen(img);
			_s.pointer_do.setWidth(_s.pointerWidth);
			_s.pointer_do.setHeight(_s.pointerHeight);
			_s.ytbButtonsHolder_do.addChild(_s.pointer_do);
			
			var img = new Image();
			img.src = _s.youtubeQualityArrowPath_str;
			_s.ytbQualityArrow_do = new FWDUVPDisplayObject("img");
			_s.ytbQualityArrow_do.setScreen(img);
			_s.ytbQualityArrow_do.setX(7);
			_s.ytbQualityArrow_do.setWidth(5);
			_s.ytbQualityArrow_do.setHeight(7);
			_s.ytbButtonsHolder_do.addChild(_s.ytbQualityArrow_do);
			
			var btn;
			for(var i=0; i<_s.ttYtbBtns; i++){
				FWDUVPYTBQButton.setPrototype();
				var btn = new FWDUVPYTBQButton(_s.ytbQuality_ar[i], 
						_s.youtubeQualityButtonNormalColor_str, 
						_s.youtubeQualityButtonSelectedColor_str,
						_d.hdPath_str,
						i);
				
				btn.addListener(FWDUVPYTBQButton.MOUSE_OVER, _s.ytbQualityOver);
				btn.addListener(FWDUVPYTBQButton.MOUSE_OUT, _s.ytbQualityOut);
				btn.addListener(FWDUVPYTBQButton.CLICK, _s.ytbQualityClick);
				_s.ytbButtons_ar[i] = btn;
				_s.ytbButtonsHolder_do.addChild(btn);
			}
			_s.hideQualityButtons(false);
		};
		
		_s.ytbQualityOver = function(e){
			_s.setYtbQualityArrowPosition(e.target);
		};
		
		_s.ytbQualityOut = function(e){
			_s.setYtbQualityArrowPosition(undefined);
		};
		
		_s.ytbQualityClick = function(e){
			_s.hideQualityButtons(true);
			_s.dispatchEvent(FWDUVPController.CHANGE_YOUTUBE_QUALITY, {quality:e.target.label_str, id:e.id});
		};
		
		_s.positionAndResizeYtbQualityButtons = function(ar){
			if(!ar) return;
			var totalButtons = ar.length;
			if(_s.prevYtbQualityButtonsLength == totalButtons) return;
			_s.prevYtbQualityButtonsLength = totalButtons;
			var btn;
			var startY = 5;
			var totalWidth = 0;
			var totalHeight = 0;
			
			for(var i=0; i<totalButtons; i++){
				btn = _s.ytbButtons_ar[i];
				if(btn){
					btn.updateText(ar[i]);	
				}
			}
			
			setTimeout(function(){
				for(var i=0; i<_s.ttYtbBtns; i++){
					btn = _s.ytbButtons_ar[i];

					btn.setFinalSize();
					if(i < totalButtons){
						if(btn.x != 0) btn.setX(0);
						if(btn.w > totalWidth) totalWidth = btn.w;
						btn.setY(startY);
						startY += btn.h;
					}else{
						if(btn.x != -3000) btn.setX(-3000);
					}
				}
				
				for(var i=0; i<_s.ttYtbBtns; i++){
					btn = _s.ytbButtons_ar[i];
					if(btn.dumy_do.w < totalWidth){
						btn.setWidth(totalWidth);
						btn.dumy_do.setWidth(totalWidth);
					}
				}
				
				totalHeight = startY + 5;
				_s.pointer_do.setX(parseInt((totalWidth - _s.pointer_do.w)/2));
				_s.pointer_do.setY(totalHeight);
				if(_s.ytbButtonBackground_do){
					_s.ytbButtonBackground_do.setWidth(totalWidth);
					_s.ytbButtonBackground_do.setHeight(totalHeight);
				}
				_s.ytbButtonsHolder_do.setWidth(totalWidth);
				_s.ytbButtonsHolder_do.setHeight(totalHeight);
			}, 300);
		};
		
		_s.disableQualityButtons = function(curQualityLevel, btnId){
			_s.showHDIcon(curQualityLevel);

			for(var i=0; i<_s.ttYtbBtns; i++){
				var btn = _s.ytbButtons_ar[i];
				
				if(btn.label_str == curQualityLevel
					|| btn.id === btnId){
					FWDAnimation.killTweensOf(_s.ytbQualityArrow_do);

					if(btnId !== undefined){
						if(btn.id === btnId){
							_s.showHDIcon(_s.ytbButtons_ar[btnId].label_str)
						}
					}

					if(btn.y != 0){
						_s.ytbQualityArrow_do.setY(btn.y + Math.round((btn.h - _s.ytbQualityArrow_do.h)/2));
						_s.ytbDisabledButton_do = btn;
					}
					
					btn.disable();
				}else{
					btn.enable();
				}
			}
		};

		_s.showHDIcon = function(curQualityLevel){
			if(curQualityLevel == "highres"
				|| curQualityLevel == "hd720" 
			    || curQualityLevel == "hd1080"
			 	|| curQualityLevel == "hd1440" 
			 	|| curQualityLevel == "hd2160"
			 	|| curQualityLevel == "hd2880"
			){
				_s.ytbQualityButton_do.showDisabledState();
			}else{
				_s.ytbQualityButton_do.hideDisabledState();
			}
			
		}
		
		_s.setYtbQualityArrowPosition = function(target){
			var curY = 0;
			if(!target){
				curY = _s.ytbDisabledButton_do.y + parseInt((_s.ytbDisabledButton_do.h - _s.ytbQualityArrow_do.h)/2);
			}else{
				curY = target.y + parseInt((target.h - _s.ytbQualityArrow_do.h)/2);
			}
			FWDAnimation.killTweensOf(_s.ytbQualityArrow_do);
			FWDAnimation.to(_s.ytbQualityArrow_do, .6, {y:curY, delay:.1, ease:Expo.easeInOut});
		};
		
		_s.showQualityButtons = function(animate){
			if(_s.areYtbQualityButtonsShowed_bl || !_s.showYoutubeQualityButton_bl) return;
			_s.hideSubtitleButtons();
			_s.hideMainScrubberTop();
			_s.areYtbQualityButtonsShowed_bl = true;
			var finalX = parseInt(_s.ytbQualityButton_do.x + (parseInt(_s.ytbQualityButton_do.w - _s.ytbButtonsHolder_do.w)/2));
			var finalY = parseInt(prt.tempVidStageHeight - _s.sH - _s.ytbButtonsHolder_do.h - 6);
			
			if(window.hasPointerEvent_bl){
				window.addEventListener("pointerdown", _s.hideQualityButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.addEventListener("mousedown", _s.hideQualityButtonsHandler);
				}
				window.addEventListener("touchstart", _s.hideQualityButtonsHandler);
			}
			
			_s.ytbButtonsHolder_do.setX(finalX);
		
			if(animate){
				FWDAnimation.to(_s.ytbButtonsHolder_do, .6, {y:finalY, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.ytbButtonsHolder_do);
				_s.ytbButtonsHolder_do.setY(finalY);
			}
		};
	
		_s.hideQualityButtons = function(animate){
			if(!_s.areYtbQualityButtonsShowed_bl || !_s.showYoutubeQualityButton_bl) return;
			_s.hideSubtitleButtons();
			_s.areYtbQualityButtonsShowed_bl = false;
			if(animate){
				FWDAnimation.to(_s.ytbButtonsHolder_do, .6, {y:prt.sH, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.ytbButtonsHolder_do);
				_s.ytbButtonsHolder_do.setY(prt.sH);
			}
			
			if(window.hasPointerEvent_bl){
				window.removeEventListener("pointerdown", _s.hideQualityButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.removeEventListener("mousedown", _s.hideQualityButtonsHandler);
				}
				window.removeEventListener("touchstart", _s.hideQualityButtonsHandler);
			}
		};
		

		//##########################################//
		/* Setup subtitle button */
		//##########################################//
		_s.subtitlesSource_ar = _d.subtitles_ar;
		_s.subtitleButtons_ar = [];
		_s.totalSubttleButtons = 10;
		
		_s.setupSubtitleButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPComplexButton.setPrototype();
				_s.subtitleButton_do = new FWDUVPComplexButton(undefined, undefined, undefined, undefined, true, undefined, undefined, undefined,
					"<span class='fwdicon fwdicon-CC'></span>",
					"<span class='fwdicon fwdicon-CC-off'></span>",
					"UVPMainButtonsNormalState",
					"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPComplexButton.setPrototype();
				_s.subtitleButton_do = new FWDUVPComplexButton(
						_d.showSubtitleNPath_img,
						_d.showSubtitleSPath_str,
						_d.hideSubtitleNPath_img,
						_d.hideSubtitleSPath_str,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			var checkIconInterval = setInterval(function(){
				if(_s.subtitleButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.subtitleButton_do.setY(parseInt((_s.sH - _s.subtitleButton_do.buttonHeight)/2));
				}
			}, 50);
			
			_s.subtitleButton_do.screen.className = 'fwduvp-subtitle-button';
			_s.buttons_ar.push(_s.subtitleButton_do);
			_s.subtitleButton_do.setY(parseInt((_s.sH - _s.subtitleButton_do.h)/2));
			_s.subtitleButton_do.addListener(FWDUVPComplexButton.MOUSE_UP, _s.subtitleButtonMouseUpHandler);
			_s.mainHld.addChild(_s.subtitleButton_do);
			
			_s.setupSubtitleButtons();
			
			if(location.protocol.indexOf("file:") != -1) _s.disableSubtitleButton();
			
			if(prt.subtitle_do.showSubtitileByDefault_bl) _s.subtitleButton_do.setButtonState(0);
		}
		
		_s.subtitleButtonMouseUpHandler = function(){
			if(_s.areSubtitleButtonsShowed_bl){
				_s.hideSubtitleButtons(true);
			}else{
				_s.showSubtitleButtons(true);
			}
		};
		
		_s.disableSubtitleButton = function(){
			if(_s.subtitleButton_do) _s.subtitleButton_do.disable();
		};
		
		_s.enableSubtitleButton = function(){
			if(_s.subtitleButton_do) _s.subtitleButton_do.enable();
		};




			
		//###################################################//
		/* Setup subtitlebuttons */
		//###################################################//
		_s.updateSubtitleButtons = function(subtitles, subtitleIndex){
			if(!_s.subtitleButton_do) return;
			
			_s.subtitlesSource_ar = subtitles;
			_s.positionAndResizeSubtitleButtons(subtitles);
			setTimeout(function(){
				subtitleIndex = _s.subtitlesSource_ar.length - 1 - subtitleIndex;
				_s.disableSubtitleButtons(subtitleIndex);
			},65);
			_s.prevSubtitleIndex = subtitleIndex;
		};	
		
		_s.setupSubtitleButtons = function(){
			_s.subtitlesButtonsHolder_do = new FWDUVPDisplayObject("div");
			_s.subtitlesButtonsHolder_do.setOverflow("visible");
			if(_s.repeatBackground_bl){
				_s.subtitlesButtonsHolder_do.getStyle().background = "url('" + _s.controllerBkPath_str +  "')";
			}else{
				_s.subtitlesButtonsBackground_do = new FWDUVPDisplayObject("img");
				var img = new Image();
				img.src = _s.controllerBkPath_str;
				_s.subtitlesButtonsBackground_do.setScreen(img);
				_s.subtitlesButtonsHolder_do.addChild(_s.subtitlesButtonsBackground_do);
			}
			
			_s.subtitlesButtonsHolder_do.setX(300);
			_s.subtitlesButtonsHolder_do.setY(-300);
			prt.videoHolder_do.addChild(_s.subtitlesButtonsHolder_do, 0);
			
			var img = new Image();
			img.src = _s.ytbQualityButtonPointerPath_str;
			_s.subtitlesPonter_do = new FWDUVPDisplayObject("img");
			_s.subtitlesPonter_do.setScreen(img);
			_s.subtitlesPonter_do.setWidth(_s.pointerWidth);
			_s.subtitlesPonter_do.setHeight(_s.pointerHeight);
			_s.subtitlesButtonsHolder_do.addChild(_s.subtitlesPonter_do);
	
			
			var img = new Image();
			img.src = _s.youtubeQualityArrowPath_str;
			_s.subtitleQualityArrow_do = new FWDUVPDisplayObject("img");
			_s.subtitleQualityArrow_do.setScreen(img);
			_s.subtitleQualityArrow_do.setX(7);
			_s.subtitleQualityArrow_do.setWidth(5);
			_s.subtitleQualityArrow_do.setHeight(7);
			_s.subtitlesButtonsHolder_do.addChild(_s.subtitleQualityArrow_do);
					
			for(var i=0; i<_s.totalSubttleButtons; i++){
				FWDUVPYTBQButton.setPrototype();
				var btn = new FWDUVPYTBQButton("no source", 
						_s.youtubeQualityButtonNormalColor_str, 
						_s.youtubeQualityButtonSelectedColor_str,
						_d.hdPath_str,
						i);
				
				btn.addListener(FWDUVPYTBQButton.MOUSE_OVER, _s.sbtQualityOver);
				btn.addListener(FWDUVPYTBQButton.MOUSE_OUT, _s.sbtQualityOut);
				btn.addListener(FWDUVPYTBQButton.CLICK, _s.sbtQualityClick);
				_s.subtitleButtons_ar[i] = btn;
				_s.subtitlesButtonsHolder_do.addChild(btn);
			}
			_s.hideSubtitleButtons(false);
		};
		
		_s.sbtQualityOver = function(e){
			_s.setSubtitleArrowPosition(e.target);
		};
		
		_s.sbtQualityOut = function(e){
			_s.setSubtitleArrowPosition(undefined);
		};
		
		_s.sbtQualityClick = function(e){
			_s.startAtSubtitle = e.id;
			_s.disableSubtitleButtons(_s.startAtSubtitle);
			_s.hideSubtitleButtons(true);
			
			_s.dispatchEvent(FWDUVPController.CHANGE_SUBTITLE, {id:_s.subtitlesSource_ar.length -1 - e.id});
		};
		
		_s.positionAndResizeSubtitleButtons = function(ar){
			if(!ar) return;
			
			var totalButtons = ar.length;
			if(_s.prevSubtitlesQualityButtonsLength == totalButtons) return;
			_s.prevSubtitlesQualityButtonsLength = totalButtons;
			var btn;
			var startY = 5;
			var totalWidth = 0;
			var totalHeight = 0;

			for(var i=0; i<totalButtons; i++){
				btn = _s.subtitleButtons_ar[i];
				btn.updateText(ar[i]["label"]);
				btn.setFinalSize();
			}
			
			setTimeout(function(){
				for(var i=0; i<_s.totalSubttleButtons; i++){
					btn = _s.subtitleButtons_ar[i];
					if(i < totalButtons){
						if(btn.x != 0) btn.setX(0);
						if(btn.w > totalWidth) totalWidth = btn.w;
						btn.setY(startY);
						startY += btn.h;
					}else{
						if(btn.x != -3000) btn.setX(-3000);
					}
				}
				
				for(var i=0; i<_s.totalSubttleButtons; i++){
					btn = _s.subtitleButtons_ar[i];
					if(btn.dumy_do.w < totalWidth){
						btn.setWidth(totalWidth);
						btn.dumy_do.setWidth(totalWidth);
					}
				}
				
				totalHeight = startY + 5;
				_s.subtitlesPonter_do.setX(parseInt((totalWidth - _s.subtitlesPonter_do.w)/2));
				_s.subtitlesPonter_do.setY(totalHeight);
				if(_s.subtitlesButtonsBackground_do){	
					_s.subtitlesButtonsBackground_do.setWidth(totalWidth);
					_s.subtitlesButtonsBackground_do.setHeight(totalHeight);
				}
				_s.subtitlesButtonsHolder_do.setWidth(totalWidth);
				_s.subtitlesButtonsHolder_do.setHeight(totalHeight);
			}, 60);
		};
		
		_s.disableSubtitleButtons = function(index){
			for(var i=0; i<_s.totalSubttleButtons; i++){
				var btn = _s.subtitleButtons_ar[i];
				if(i == index){
					FWDAnimation.killTweensOf(_s.subtitleQualityArrow_do);
					_s.subtitleQualityArrow_do.setY(btn.y + parseInt((btn.h - _s.subtitleQualityArrow_do.h)/2) + 1);
					btn.disable();
					_s.subtitleDisabledButton_do = btn;
				}else{
					btn.enable();
				}
			}
			
			if(_s.subtitlesSource_ar.length -1 - index == 0){
				_s.subtitleButton_do.setButtonState(0);
			}else{
				_s.subtitleButton_do.setButtonState(1);
			}
		};
		
		_s.setSubtitleArrowPosition = function(target){
			var curY = 0;
			if(!target){
				curY = _s.subtitleDisabledButton_do.y + parseInt((_s.subtitleDisabledButton_do.h - _s.subtitleQualityArrow_do.h)/2);
			}else{
				curY = target.y + parseInt((target.h - _s.subtitleQualityArrow_do.h)/2);
			}
			FWDAnimation.killTweensOf(_s.subtitleQualityArrow_do);
			FWDAnimation.to(_s.subtitleQualityArrow_do, .6, {y:curY, delay:.1, ease:Expo.easeInOut});
		};
		
		_s.showSubtitleButtons = function(animate){
			if(_s.areSubtitleButtonsShowed_bl) return;
			_s.hideQualityButtons();
			_s.hideMainScrubberTop();
			_s.areSubtitleButtonsShowed_bl = true;
			var finalX = parseInt(_s.subtitleButton_do.x + (parseInt(_s.subtitleButton_do.w - _s.subtitlesButtonsHolder_do.w)/2));
			var finalY = parseInt(prt.tempVidStageHeight - _s.sH - _s.subtitlesButtonsHolder_do.h - 6);
			
			if(_s.hasPointerEvent_bl){
				window.addEventListener("pointerdown", _s.hideSubtitlesButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.addEventListener("mousedown", _s.hideSubtitlesButtonsHandler);
				}
				window.addEventListener("touchstart", _s.hideSubtitlesButtonsHandler);
			}
			
			_s.subtitlesButtonsHolder_do.setX(finalX);
		
			if(animate){
				FWDAnimation.to(_s.subtitlesButtonsHolder_do, .6, {y:finalY, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.subtitlesButtonsHolder_do);
				_s.subtitlesButtonsHolder_do.setY(finalY);
			}
		};
	
		_s.hideSubtitleButtons = function(animate){
			if(!_s.areSubtitleButtonsShowed_bl || !_s.subtitlesButtonsHolder_do) return;
			_s.areSubtitleButtonsShowed_bl = false;
			if(animate){
				FWDAnimation.to(_s.subtitlesButtonsHolder_do, .6, {y:prt.sH, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.subtitlesButtonsHolder_do);
				_s.subtitlesButtonsHolder_do.setY(prt.sH);
			}
			
			if(_s.hasPointerEvent_bl){
				window.removeEventListener("pointerdown", _s.hideSubtitlesButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.removeEventListener("mousedown", _s.hideSubtitlesButtonsHandler);
				}
				window.removeEventListener("touchstart", _s.hideSubtitlesButtonsHandler);
			}
			_s.showMainScrubberOnTop();
		};
		
		_s.hideSubtitlesButtonsHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(FWDUVPUtils.hitTest(_s.subtitleButton_do.screen, vc.screenX, vc.screenY)
			   || FWDUVPUtils.hitTest(_s.subtitlesButtonsHolder_do.screen, vc.screenX, vc.screenY)){
				return;
			}
			_s.hideSubtitleButtons(true);
		};
		
		
		//##########################################//
		/* Setup youtube quality button */
		//##########################################//
		_s.setupYoutubeQualityButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.ytbQualityButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-settings'></span>",
						_d.hdIcn,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.ytbQualityButton_do = new FWDUVPSimpleButton(
						_s.ytbQualityN_img,
						_d.ytbQualitySPath_str,
						_d.ytbQualityDPath_str,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.ytbQualityButton_do.screen.className = 'fwduvp-quality-button';
			_s.ytbQualityButton_do.setX(-300);
			_s.ytbQualityButton_do.setY(parseInt((_s.sH - _s.ytbQualityButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.ytbQualityButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.ytbQualityButton_do.setY(parseInt((_s.sH - _s.ytbQualityButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.ytbQualityButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.ytbQualityMouseUpHandler);
			_s.mainHld.addChild(_s.ytbQualityButton_do);
		};
		
		_s.ytbQualityMouseUpHandler = function(){
			
			if(_s.areYtbQualityButtonsShowed_bl){
				_s.hideQualityButtons(true);
				if(_s.isMainScrubberOnTop_bl){
					_s.mainScrubber_do.setX(0);
					FWDAnimation.to(_s.mainScrubber_do, .6, {alpha:1});
				}
			}else{
				_s.showQualityButtons(true);
			}
		};
		
		_s.hideQualityButtonsHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(FWDUVPUtils.hitTest(_s.ytbQualityButton_do.screen, vc.screenX, vc.screenY)
			   || FWDUVPUtils.hitTest(_s.ytbButtonsHolder_do.screen, vc.screenX, vc.screenY)){
				return;
			}
			_s.hideQualityButtons(true);
			_s.showMainScrubberOnTop();
		};
		
		_s.addYtbQualityButton = function(){
			if(_s.hasYtbButton_bl || !_s.showYoutubeQualityButton_bl) return;
			_s.hasYtbButton_bl = true;
			var indexToAdd;
			if(_s.subtitleButton_do && _s.getButtonIndex(_s.subtitleButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.subtitleButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.playbackRateButton_do && _s.getButtonIndex(_s.playbackRateButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.playbackRateButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.atbButton_do && _s.getButtonIndex(_s.atbButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.atbButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.infoButton_do && _s.getButtonIndex(_s.infoButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.infoButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.downloadButton_do && _s.getButtonIndex(_s.downloadButton_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.ytbQualityButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.ccBtn_do && _s.getButtonIndex(_s.ccBtn_do) != -1){
				indexToAdd = _s.getButtonIndex(_s.ccBtn_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.vrButton_do){
				indexToAdd = _s.getButtonIndex(_s.vrButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else if(_s.fullScreenButton_do){
				indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.ytbQualityButton_do);
			}else{
				_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.ytbQualityButton_do);
			}
			
			_s.ytbQualityButton_do.disable();
			_s.ytbQualityButton_do.rotation = 0;
			_s.ytbQualityButton_do.setRotation(_s.ytbQualityButton_do.rotation);
			_s.ytbQualityButton_do.hideDisabledState();
			_s.hideQualityButtons(false);
			
			_s.positionButtons();
		};
		
		_s.removeYtbQualityButton = function(){
			if(!_s.hasYtbButton_bl || !_s.showYoutubeQualityButton_bl) return;
			_s.hasYtbButton_bl = false;
			_s.buttons_ar.splice(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.ytbQualityButton_do), 1);
			
			_s.ytbQualityButton_do.setX(-300);
			_s.ytbQualityButton_do.hideDisabledState();
			_s.hideQualityButtons(false);
			_s.positionButtons();
		};
		
		_s.updateQuality = function(qualityLevels, curQualityLevel, id){
			if(!_s.hasYtbButton_bl || !_s.showYoutubeQualityButton_bl) return;

			_s.positionAndResizeYtbQualityButtons(qualityLevels);
			
			setTimeout(function(){
				_s.disableQualityButtons(curQualityLevel, id);
			},300);
		};	

		
		//##########################################//
		/* Setup info  button */
		//#########################################//
		_s.setupInfoButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.infoButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-info'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.infoButton_do = new FWDUVPSimpleButton(_s.infoN_img, _d.infoSPath_str, undefined, true, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}

			_s.infoButton_do.screen.className = 'fwduvp-ifon-button';
			var checkIconInterval = setInterval(function(){
				if(_s.infoButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.infoButton_do.setY(parseInt((_s.sH - _s.infoButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.infoButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.infoButtonShowToolTipHandler);
			_s.infoButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.infoButtonOnMouseUpHandler);
			_s.infoButton_do.setX(-300);
			_s.infoButton_do.setY(parseInt((_s.sH - _s.infoButton_do.h)/2));
			_s.mainHld.addChild(_s.infoButton_do);
		};
		
		_s.infoButtonShowToolTipHandler = function(e){
			_s.showToolTip(_s.infoButton_do, _s.infoButtonToolTip_do, e.e);
		};
		
		_s.infoButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.SHOW_INFO_WINDOW);
		};
		
		_s.enableQualtyButton = function(){
			if(_s.ytbQualityButton_do) _s.ytbQualityButton_do.enable();
		}
		
		_s.disableQualtyButton = function(){
			if(_s.ytbQualityButton_do) _s.ytbQualityButton_do.disable();
		}
		

		//##########################################//
		/* Setup download button */
		//#########################################//
		_s.setupDownloadButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.downloadButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-download'></span>",
						undefined,
						"UVPMainButtonsNormalState dw",
						"UVPMainButtonsSelectedState dw"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.downloadButton_do = new FWDUVPSimpleButton(_s.downloadN_img, _d.downloadSPath_str, undefined, true, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}

			_s.downloadButton_do.screen.className = 'fwduvp-download-button';
			_s.downloadButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.downloadButtonShowToolTipHandler);
			_s.downloadButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.downloadButtonOnMouseUpHandler);
			_s.downloadButton_do.setX(-300);
			_s.downloadButton_do.setY(parseInt((_s.sH - _s.downloadButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.downloadButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.downloadButton_do.setY(parseInt((_s.sH - _s.downloadButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.mainHld.addChild(_s.downloadButton_do); 
		};
		
		_s.downloadButtonShowToolTipHandler = function(e){
			_s.showToolTip(_s.downloadButton_do, _s.downloadButtonToolTip_do, e.e);
		};
		
		_s.downloadButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.DOWNLOAD_VIDEO);
		};
		
		
		//##########################################//
		/* Setup thumbnails preview */
		//##########################################//
		_s.setupThumbnailsPreview =  function(){
			if(_s.thumbnailsPreview_do || !window['FWDUVPThumbnailsPreview']) return;
			FWDUVPThumbnailsPreview.setPrototype();
			_s.thumbnailsPreview_do = new FWDUVPThumbnailsPreview(_s);
			_s.thumbnailsPreview_do.addListener(FWDUVPData.LOAD_ERROR, function(e){
				
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:e.text});
			});
		}

		//##########################################//
		/* Setup a to b button */
		//##########################################//
		_s.setupATB = function(){
			FWDUVPATB.setPrototype();
			_s.atb = new FWDUVPATB(_s);
			_s.mainHld.addChild(_s.atb);
			_s.atb.addListener(FWDUVPATB.START_TO_SCRUB, _s.atbStartToScrub);
			_s.atb.addListener(FWDUVPATB.STOP_TO_SCRUB, _s.atbStopToScrub);
		}

		_s.atbStartToScrub = function(){
			prt.showDisable();
		}

		_s.atbStopToScrub = function(){
			prt.hideDisable();
		}

		_s.setupAtbButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.atbButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-AB'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.atbButton_do = new FWDUVPSimpleButton(
						_d.atbNPath_img,
						_d.atbSPath_str,
						undefined,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.atbButton_do.screen.className = 'fwduvp-a-to-b-button';
			_s.atbButton_do.setX(-5000);
			_s.atbButton_do.setY(parseInt((_s.sH - _s.atbButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.atbButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.atbButton_do.setY(parseInt((_s.sH - _s.atbButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.atbButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.atbButtonShowTooltipHandler);
			_s.atbButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.atbButtonMouseUpHandler);
			_s.mainHld.addChild(_s.atbButton_do);
		};
		
		_s.atbButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.atbButton_do, _s.atbButtonToolTip_do, e.e);
		};
		
	
		_s.atbButtonMouseUpHandler = function(){
			if(_s.atbButton_do.isSelected){
				_s.atbButton_do.doNotallowToSetNormal = false;
				_s.atbButton_do.isSelected = false;
				_s.atb.hide(true);
				if(_s.isMbl) _s.atbButton_do.setNormalState();
			}else{
				_s.atbButton_do.isSelected = true;
				_s.atbButton_do.doNotallowToSetNormal = true;
				_s.atbButton_do.setSelectedState();
				_s.atb.show(true);
			}
			
		};

		_s.disableAtbButton = function(){
			if(_s.atbButton_do) _s.atbButton_do.disable();
		};
		
		_s.enableAtbButton = function(){
			if(_s.atbButton_do) _s.atbButton_do.enable();
		};

		
		//##########################################//
		/* Setup facebook button */
		//##########################################//
		_s.setupShareButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.shareButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-share'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.shareButton_do = new FWDUVPSimpleButton(
						_d.shareN_img,
						_d.shareSPath_str,
						undefined,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.shareButton_do.screen.className = 'fwduvp-share-button';
			_s.buttons_ar.push(_s.shareButton_do);
			_s.shareButton_do.setY(parseInt((_s.sH - _s.shareButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.shareButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.shareButton_do.setY(parseInt((_s.sH - _s.shareButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.shareButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.facebookButtonShowTooltipHandler);
			_s.shareButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.facebookButtonMouseUpHandler);
			_s.mainHld.addChild(_s.shareButton_do);
		};
		
		_s.facebookButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.shareButton_do, _s.facebookButtonToolTip_do, e.e);
		};
		
	
		_s.facebookButtonMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.SHOW_SHARE_WINDOW);
		};

		
		//##########################################//
		/* Setup chromecast button */
		//##########################################//
		_s.setupChromecastButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPComplexButton.setPrototype();
				_s.ccBtn_do = new FWDUVPComplexButton(undefined, undefined, undefined, undefined, true, undefined, undefined, undefined,
					"<span class='fwdicon fwdicon-cast'></span>",
					"<span class='fwdicon fwdicon-uncast'></span>",
					"UVPMainButtonsNormalState",
					"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPComplexButton.setPrototype();
				_s.ccBtn_do = new FWDUVPComplexButton(
					_d.castN_img,
					_d.castSPath_str,
					_d.uncastN_img,
					_d.uncastSPath_str,
					true,
					_s.useHEX,
					_s.nBC,
					_s.sBC
				);
			}
				
			var checkIconInterval = setInterval(function(){
				if(_s.ccBtn_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.ccBtn_do.setY(parseInt((_s.sH - _s.ccBtn_do.buttonHeight)/2));
				}
			}, 50);

			_s.ccBtn_do.screen.className = 'fwduvp-chromecast-button';
			_s.ccBtn_do.setY(parseInt((_s.sH - _s.ccBtn_do.buttonHeight)/2));
			_s.ccBtn_do.addListener(FWDUVPComplexButton.MOUSE_UP, _s.chormecastMouseUpHandler);
			_s.ccBtn_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.castTooltipHandler);
			_s.ccBtn_do.setX(-500);
			_s.mainHld.addChild(_s.ccBtn_do);
		}
		
		_s.castTooltipHandler = function(e){
			_s.showToolTip(_s.ccBtn_do, _s.castButtonToolTip_do, e.e);
		};

		_s.chormecastMouseUpHandler = function(){
			if(_s.ccBtn_do.currentState == 0){
				_s.dispatchEvent(FWDUVPController.UNCAST);
			}else{
				_s.dispatchEvent(FWDUVPController.CAST);
			}
		}
		
		_s.removeCCButton = function(){
			if(!_s.ccBtn_do) return;
			if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.ccBtn_do) != -1){
				_s.buttons_ar.splice(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.ccBtn_do), 1);
				_s.ccBtn_do.setX(-300);
				_s.positionButtons();
			}
		};
		
		_s.addCCButton = function(){
			
			if(!_s.ccBtn_do) return;
			
			if(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.ccBtn_do) == -1){
				if(_s.vrButton_do){
					var indexToAdd = _s.getButtonIndex(_s.vrButton_do);
					_s.buttons_ar.splice(indexToAdd, 0, _s.ccBtn_do);
				}else if(_s.fullScreenButton_do && FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.fullScreenButton_do) != -1){
					_s.buttons_ar.splice(FWDUVPUtils.indexOfArray(_s.buttons_ar, _s.fullScreenButton_do), 0, _s.ccBtn_do);
				}else{
					_s.buttons_ar.splice(_s.buttons_ar.length, 0, _s.ccBtn_do);
				}
				_s.positionButtons();
			}
		};


		//###################################################//
		/* Setup audio traks button */
		//###################################################//
		_s.setupAudioTracksButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.atButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-headephone'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
				_s.atButton_do.screen.className = "fwduvp-audio-tracks-button vector";
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.atButton_do = new FWDUVPSimpleButton(_d.at_img,
															 _d.atSPath_img, 
															 undefined, 
															 true,
															 _s.useHEX,
															 _s.nBC,
															 _s.sBC);
				_s.atButton_do.screen.className = "fwduvp-audio-tracks-button";
			}

			var checkIconInterval = setInterval(function(){
				if(_s.atButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.atButton_do.setY(parseInt((_s.sH - _s.atButton_do.buttonHeight)/2));
				}
			}, 50);
			
			_s.atButton_do.screen.className = 'fwduvp-audio-tracks-button';
			_s.atButton_do.setY(parseInt((_s.sH - _s.atButton_do.h)/2));
			_s.atButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.atButtonMouseUpHandler);
			_s.atButton_do.setX(-300);
			_s.mainHld.addChild(_s.atButton_do);

			_s.setupATBButtons();
			
			_s.disableAtButton();
		}
		
		_s.atButtonMouseUpHandler = function(){
			_s.showATBButtons(true);
		};
		
		_s.disableAtButton = function(){
			if(_s.atButton_do) _s.atButton_do.disable();
		};
		
		_s.enableAtButton = function(){
			if(_s.atButton_do) _s.atButton_do.enable();
		};
		
		_s.removeAtButton = function(){
			if(!_s.atButton_do) return;
			if(_s.getButtonIndex(_s.atButton_do) != -1){
				_s.buttons_ar.splice(_s.getButtonIndex(_s.atButton_do), 1);
				_s.atButton_do.setX(-300);
			}
		};
		
		_s.addAtButton = function(){
			if(!_s.atButton_do) return;
			if(_s.getButtonIndex(_s.atButton_do) != -1) return;
			
			_s.disableAtButton();
			if(_s.ytbQualityButton_do && _s.getButtonIndex(_s.ytbQualityButton_do) != -1){
				var indexToAdd = _s.getButtonIndex(_s.ytbQualityButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.atButton_do);
			}else if(_s.fullScreenButton_do && _s.getButtonIndex(_s.fullScreenButton_do) != -1){
				var indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.atButton_do);
			}else{
				_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.atButton_do);
			}
			_s.positionButtons();
		};


		//###################################################//
		/* Setup audio tracks buttons. */
		//###################################################//
		_s.totalATBButtons = 10;
		_s.areATBButtonsShowed_bl = false;
		_s.updateATBButtons = function(ATB, ATBIndex){
			if(!_s.atButton_do) return;
		
			_s.ATBSource_ar = ATB;

			_s.positionAndResizeATBButtons(ATB);
			
			setTimeout(function(){
				ATBIndex = _s.ATBSource_ar.length - 1 - ATBIndex;
				_s.disableATBButtons(ATBIndex);
			},65);
			_s.prevATBIndex = ATBIndex;
		};	
		
		_s.setupATBButtons = function(){

			_s.ATBButtons_ar = [];
			_s.ATBButtonsHolder_do = new FWDUVPDisplayObject("div");
			_s.ATBButtonsHolder_do.setOverflow("visible");
			if(_s.repeatBackground_bl){
				_s.ATBButtonsHolder_do.getStyle().background = "url('" + _s.controllerBkPath_str +  "')";
			}else{
				_s.ATBButtonsBackground_do = new FWDUVPDisplayObject("img");
				var img = new Image();
				img.src = _s.controllerBkPath_str;
				_s.ATBButtonsBackground_do.setScreen(img);
				_s.ATBButtonsHolder_do.addChild(_s.ATBButtonsBackground_do);
			}
			
			_s.ATBButtonsHolder_do.setX(300);
			_s.ATBButtonsHolder_do.setY(-300);
			prt.videoHolder_do.addChild(_s.ATBButtonsHolder_do, 0);
			
			var img = new Image();
			img.src = _s.ytbQualityButtonPointerPath_str;
			_s.ATBPonter_do = new FWDUVPDisplayObject("img");
			_s.ATBPonter_do.setScreen(img);
			_s.ATBPonter_do.setWidth(_s.pointerWidth);
			_s.ATBPonter_do.setHeight(_s.pointerHeight);
			_s.ATBButtonsHolder_do.addChild(_s.ATBPonter_do);
	
			var img = new Image();
			img.src = _s.youtubeQualityArrowPath_str;
			_s.ABTQualityArrow_do = new FWDUVPDisplayObject("img");
			_s.ABTQualityArrow_do.setScreen(img);
			_s.ABTQualityArrow_do.setX(7);
			_s.ABTQualityArrow_do.setWidth(5);
			_s.ABTQualityArrow_do.setHeight(7);
			_s.ATBButtonsHolder_do.addChild(_s.ABTQualityArrow_do);
					
			for(var i=0; i<_s.totalATBButtons; i++){
				FWDUVPYTBQButton.setPrototype();
				var btn = new FWDUVPYTBQButton("no source", 
						_s.youtubeQualityButtonNormalColor_str, 
						_s.youtubeQualityButtonSelectedColor_str,
						_d.hdPath_str,
						i);
				
				btn.addListener(FWDUVPYTBQButton.MOUSE_OVER, _s.ATBQualityOver);
				btn.addListener(FWDUVPYTBQButton.MOUSE_OUT, _s.ATBQualityOut);
				btn.addListener(FWDUVPYTBQButton.CLICK, _s.ATBQualityClick);
				_s.ATBButtons_ar[i] = btn;
				_s.ATBButtonsHolder_do.addChild(btn);
			}
			_s.hideATBButtons(false);
		};
		
		_s.ATBQualityOver = function(e){
			_s.setATBArrowPosition(e.target);
		};
		
		_s.ATBQualityOut = function(e){
			_s.setATBArrowPosition(undefined);
		};
		
		_s.ATBQualityClick = function(e){
			_s.startAtATB = e.id;
			
			_s.disableATBButtons(_s.startAtATB);
			_s.hideATBButtons(true);
			
			_s.dispatchEvent(FWDUVPController.CHANGE_AUDIO_TRACKS, {id:_s.ATBSource_ar.length -1 - e.id});
		};
		
		_s.positionAndResizeATBButtons = function(ar){
			if(!ar) return;
			
			var totalButtons = ar.length;

			if(_s.prevATBButtonsLength == totalButtons) return;
			_s.prevATBButtonsLength = totalButtons;

			var btn;
			var startY = 5;
			var totalWidth = 0;
			var totalHeight = 0;

			for(var i=0; i<totalButtons; i++){
				btn = _s.ATBButtons_ar[i];
				btn.updateText(ar[i]["label"]);
				btn.setFinalSize();
			}

			setTimeout(function(){
				for(var i=0; i<_s.totalATBButtons; i++){
					btn = _s.ATBButtons_ar[i];
					if(i < totalButtons){
						if(btn.x != 0) btn.setX(0);
						if(btn.w > totalWidth) totalWidth = btn.w;
						btn.setY(startY);
						startY += btn.h;
					}else{
						if(btn.x != -3000) btn.setX(-3000);
					}
				}
				
				for(var i=0; i<_s.totalATBButtons; i++){
					btn = _s.ATBButtons_ar[i];
					if(btn.dumy_do.w < totalWidth){
						btn.setWidth(totalWidth);
						btn.dumy_do.setWidth(totalWidth);
					}
				}
				
				totalHeight = startY + 5;

				_s.ATBPonter_do.setX(parseInt((totalWidth - _s.ATBPonter_do.w)/2));
				_s.ATBPonter_do.setY(totalHeight);
				if(_s.ATBButtonsBackground_do){	
					_s.ATBButtonsBackground_do.setWidth(totalWidth);
					_s.ATBButtonsBackground_do.setHeight(totalHeight);
				}
				_s.ATBButtonsHolder_do.setWidth(totalWidth);
				_s.ATBButtonsHolder_do.setHeight(totalHeight);
			}, 60);
		};
		
		_s.disableATBButtons = function(index){
			for(var i=0; i<_s.totalATBButtons; i++){
				var btn = _s.ATBButtons_ar[i];
				if(i == index){
					FWDAnimation.killTweensOf(_s.ABTQualityArrow_do);
					_s.ABTQualityArrow_do.setY(btn.y + parseInt((btn.h - _s.ABTQualityArrow_do.h)/2) + 1);
					btn.disable();
					_s.ABTDisabledButton_do = btn;
				}else{
					btn.enable();
				}
			}
		};
		
		_s.setATBArrowPosition = function(target){
			var curY = 0;
			if(!target){
				curY = _s.ABTDisabledButton_do.y + parseInt((_s.ABTDisabledButton_do.h - _s.ABTQualityArrow_do.h)/2);
			}else{
				curY = target.y + parseInt((target.h - _s.ABTQualityArrow_do.h)/2);
			}
			FWDAnimation.killTweensOf(_s.ABTQualityArrow_do);
			FWDAnimation.to(_s.ABTQualityArrow_do, .6, {y:curY, delay:.1, ease:Expo.easeInOut});
		};
		
		_s.showATBButtons = function(animate){
			_s.hideATBButtons();
			_s.hideMainScrubberTop();
			_s.areATBButtonsShowed_bl = true;
			var finalX = parseInt(_s.atButton_do.x + (parseInt(_s.atButton_do.w - _s.ATBButtonsHolder_do.w)/2));
			var finalY = parseInt(prt.tempVidStageHeight - _s.sH - _s.ATBButtonsHolder_do.h - 6);
			
			if(_s.hasPointerEvent_bl){
				window.addEventListener("pointerdown", _s.hideATBsButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.addEventListener("mousedown", _s.hideATBsButtonsHandler);
				}
				window.addEventListener("touchstart", _s.hideATBsButtonsHandler);
			}
			
			_s.ATBButtonsHolder_do.setX(finalX);
		
			if(animate){
				FWDAnimation.to(_s.ATBButtonsHolder_do, .6, {y:finalY, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.ATBButtonsHolder_do);
				_s.ATBButtonsHolder_do.setY(finalY);
			}
		};
	
		_s.hideATBButtons = function(animate){
			if(!_s.ATBButtonsHolder_do) return;
			
			_s.areATBButtonsShowed_bl = false;
			if(animate){
				FWDAnimation.to(_s.ATBButtonsHolder_do, .6, {y:prt.sH, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.ATBButtonsHolder_do);
				_s.ATBButtonsHolder_do.setY(prt.sH);
			}

			if(_s.hasPointerEvent_bl){
				window.removeEventListener("pointerdown", _s.hideATBsButtonsHandler);
			}else{
				if(!_s.isMbl){
					window.removeEventListener("mousedown", _s.hideATBsButtonsHandler);
				}
				window.removeEventListener("touchstart", _s.hideATBsButtonsHandler);
			}
			_s.showMainScrubberOnTop();
		};
		
		_s.hideATBsButtonsHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(FWDUVPUtils.hitTest(_s.atButton_do.screen, vc.screenX, vc.screenY)
			   || FWDUVPUtils.hitTest(_s.ATBButtonsHolder_do.screen, vc.screenX, vc.screenY)){
				return;
			}
			_s.hideATBButtons(true);
		};


		//###################################################//
		/* Setup VR button */
		//###################################################//
		_s.setupVrButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.vrButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-vr'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
					_s.vrButton_do.screen.className = "FWDUVP-vr-button vector";
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.vrButton_do = new FWDUVPSimpleButton(_d.vr_img,
															 _d.vrSPath_img, 
															 undefined, 
															 true,
															 _s.useHEX,
															 _s.nBC,
															 _s.sBC);
					_s.vrButton_do.screen.className = "FWDUVP-vr-button";
			}
			
			_s.vrButton_do.screen.className = 'fwduvp-vr-button';
			_s.vrButton_do.setY(parseInt((_s.sH - _s.vrButton_do.h)/2));
			_s.vrButton_do.addListener(FWDUVPComplexButton.SHOW_TOOLTIP, _s.vrButtonShowToolTipHandler);
			_s.vrButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.vrButtonMouseUpHandler);
			_s.mainHld.addChild(_s.vrButton_do);
			_s.vrButton_do.setX(-300);
			_s.disableVrButton();
		}

		_s.vrButtonShowToolTipHandler =  function(e){
			_s.showToolTip(_s.vrButton_do, _s.vrToolTip_do, e.e);
		}
		
		_s.vrButtonMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.VR);
		};
		
		_s.disableVrButton = function(){
			if(_s.vrButton_do) _s.vrButton_do.disable();
		};
		
		_s.enableVrButton = function(){
			if(_s.vrButton_do) _s.vrButton_do.enable();
		};
		
		_s.removeVrButton = function(){
			if(!_s.vrButton_do) return;
			if(_s.getButtonIndex(_s.vrButton_do) != -1){
				_s.buttons_ar.splice(_s.getButtonIndex(_s.vrButton_do), 1);
				_s.vrButton_do.setX(-300);
			}
		};
		
		_s.addVrButton = function(){
			if(!_s.vrButton_do) return;
			if(_s.getButtonIndex(_s.vrButton_do) != -1) return;
			
			_s.disableVrButton();
			if(_s.fullScreenButton_do && _s.getButtonIndex(_s.fullScreenButton_do) != -1){
				var indexToAdd = _s.getButtonIndex(_s.fullScreenButton_do);
				_s.buttons_ar.splice(indexToAdd, 0, _s.vrButton_do);
			}else{
				_s.buttons_ar.splice(_s.buttons_ar.length,0, _s.infoButton_do);
			}
		};



		//##########################################//
		/* Setup fullscreen button */
		//##########################################//
		_s.setupFullscreenButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPComplexButton.setPrototype();
				_s.fullScreenButton_do = new FWDUVPComplexButton(undefined, undefined, undefined, undefined, true, undefined, undefined, undefined,
					"<span class='fwdicon fwdicon-fullscreen'></span>",
					"<span class='fwdicon fwdicon-normalscreen'></span>",
					"UVPMainButtonsNormalState",
					"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPComplexButton.setPrototype();
				_s.fullScreenButton_do = new FWDUVPComplexButton(
						_s.fullScreenN_img,
						_d.fullScreenSPath_str,
						_s.normalScreenN_img,
						_d.normalScreenSPath_str,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.buttons_ar.push(_s.fullScreenButton_do);
			_s.fullScreenButton_do.setY(parseInt((_s.sH - _s.fullScreenButton_do.buttonHeight)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.fullScreenButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.fullScreenButton_do.setY(parseInt((_s.sH - _s.fullScreenButton_do.buttonHeight)/2));
				}
			}, 50);

			_s.fullScreenButton_do.screen.className = 'fwduvp-fullscreen-button';
			_s.fullScreenButton_do.addListener(FWDUVPComplexButton.SHOW_TOOLTIP, _s.fullscreenButtonShowToolTipHandler);
			_s.fullScreenButton_do.addListener(FWDUVPComplexButton.MOUSE_UP, _s.fullScreenButtonMouseUpHandler);
			_s.mainHld.addChild(_s.fullScreenButton_do);
		};
		
		_s.fullscreenButtonShowToolTipHandler = function(e){
			_s.showToolTip(_s.fullScreenButton_do, _s.fullscreenButtonToolTip_do, e.e);
		};
		
		_s.showFullScreenButton = function(){
			if(!_s.fullScreenButton_do) return;
			_s.fullScreenButton_do.setButtonState(1);
		};
		
		_s.showNormalScreenButton = function(){
			if(!_s.fullScreenButton_do) return;
			_s.fullScreenButton_do.setButtonState(0);
		};
		
		_s.setNormalStateToFullScreenButton = function(){
			if(!_s.fullScreenButton_do) return;
			_s.fullScreenButton_do.setNormalState(true);
			_s.hideQualityButtons(false);
		};
		
		_s.fullScreenButtonMouseUpHandler = function(){
			if(_s.fullscreenButtonToolTip_do) _s.fullscreenButtonToolTip_do.hide();
			if(_s.fullScreenButton_do.currentState == 1){
				_s.dispatchEvent(FWDUVPController.FULL_SCREEN);
			}else{
				_s.dispatchEvent(FWDUVPController.NORMAL_SCREEN);
			}
		};

		
		//########################################//
		/* Setup time*/
		//########################################//
		_s.setupTime = function(){
			_s.time_do = new FWDUVPDisplayObject("div");
			_s.time_do.screen.className = 'fwduvp-time';
			_s.time_do.hasTransform3d_bl = false;
			_s.time_do.hasTransform2d_bl = false;
			_s.time_do.setBackfaceVisibility();
			_s.time_do.getStyle().fontFamily = "Arial";
			_s.time_do.getStyle().fontSize= "12px";
			_s.time_do.getStyle().whiteSpace= "nowrap";
			_s.time_do.getStyle().textAlign = "center";
			_s.time_do.getStyle().color = _s.timeColor_str;
			_s.time_do.getStyle().fontSmoothing = "antialiased";
			_s.time_do.getStyle().webkitFontSmoothing = "antialiased";
			_s.time_do.getStyle().textRendering = "optimizeLegibility";	
			_s.mainHld.addChild(_s.time_do);
			_s.updateTime("00:00/00:00");
			_s.buttons_ar.push(_s.time_do);
		};
		
		_s.updateTime = function(time){
			if(!_s.time_do) return;
			if(_s.isLive) time = time.substr(0, time.indexOf("/"));
			_s.time_do.setInnerHTML(time);
			
			if(_s.lastTimeLength != time.length){
				_s.time_do.w = _s.time_do.getWidth();
				_s.positionButtons();
				
				setTimeout(function(){
					_s.time_do.w = _s.time_do.getWidth();
					_s.time_do.h = _s.time_do.getHeight();
					_s.time_do.setY(parseInt((_s.sH - _s.time_do.h)/2) + 1 + _s.timeOffsetTop);
					_s.positionButtons();
				}, 50);
				_s.lastTimeLength = time.length;
			}
		};

		
		//##########################################//
		/* Setup facebook button */
		//##########################################//
		_s.setupRewindButton = function(){
			
			if(_s.useVectorIcons_bl){				
				FWDUVPSimpleButton.setPrototype();
				_s.rewindButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-10'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.rewindButton_do = new FWDUVPSimpleButton(
						_d.rewindN_img,
						_d.rewindSPath_str,
						undefined,
						true,
						_s.useHEX,
						_s.nBC,
						_s.sBC
				);
			}
			
			_s.rewindButton_do.screen.className = 'fwduvp-rewind-button';
			_s.buttons_ar.push(_s.rewindButton_do);
			_s.rewindButton_do.setY(parseInt((_s.sH - _s.rewindButton_do.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.rewindButton_do.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.rewindButton_do.setY(parseInt((_s.sH - _s.rewindButton_do.buttonHeight)/2));
				}
			}, 50);
			_s.rewindButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.rewindButtonMouseUpHandler);
			_s.mainHld.addChild(_s.rewindButton_do);
		};
	
		_s.rewindButtonMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPController.REWIND);
		};
		
		_s.disableRewindButton = function(){
			if(_s.rewindButton_do) _s.rewindButton_do.disable();
		}
		
		_s.enableRewindButton = function(){
			if(_s.rewindButton_do) _s.rewindButton_do.enable();
		}
		

		//##########################################//
		/* Setup volume button */
		//#########################################//
		_s.setupVolumeButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPVolumeButton.setPrototype();
				_s.volBtn = new FWDUVPVolumeButton(undefined, undefined, undefined, undefined, undefined, undefined,
					"<span class='fwdicon fwdicon-sound'></span>",
					"<span class='fwdicon fwdicon-sound-off'></span>",
					"UVPMainButtonsNormalState volume",
					"UVPMainButtonsSelectedState volume"
				);
			}else{
				FWDUVPVolumeButton.setPrototype();
				_s.volBtn = new FWDUVPVolumeButton(_s.volumeN_img, _d.volumeSPath_str, _d.volumeDPath_str, _s.useHEX,
						_s.nBC,
						_s.sBC);
			}
			_s.volBtn.addListener(FWDUVPVolumeButton.SHOW_TOOLTIP, _s.volumeButtonShowTooltipHandler);
			_s.volBtn.addListener(FWDUVPVolumeButton.MOUSE_OVER, _s.volumeOnMouseOverHandler);;
			_s.volBtn.addListener(FWDUVPVolumeButton.MOUSE_UP, _s.volumeOnMouseUpHandler);
			_s.volBtn.setY(parseInt((_s.sH - _s.volBtn.h)/2));
			var checkIconInterval = setInterval(function(){
				if(_s.volBtn.buttonHeight > 0){
					clearInterval(checkIconInterval);
					_s.volBtn.setY(parseInt((_s.sH - _s.volBtn.buttonHeight)/2));
				}
			}, 50);
			_s.buttons_ar.push(_s.volBtn);
			_s.mainHld.addChild(_s.volBtn); 
			if(_s.volume == 0) _s.volBtn.setDisabledState();
		};
		
		_s.volumeButtonShowTooltipHandler = function(e){};
		
		_s.hideMainScrubberTop = function(){
			if(_s.isMainScrubberOnTop_bl){
				FWDAnimation.to(_s.mainScrubber_do, .4, {alpha:0, onComplete:function(){_s.mainScrubber_do.setX(-5000);}});
			}
		}
		
		_s.showMainScrubberOnTop = function(){
			if(_s.isMainScrubberOnTop_bl){
				_s.mainScrubber_do.setX(0);
				FWDAnimation.to(_s.mainScrubber_do, .6, {alpha:1});
			}
		}
		
		_s.volumeOnMouseOverHandler = function(){
			_s.showVolumeScrubber(true);
			_s.hideQualityButtons(true);
			_s.hideSubtitleButtons(true);
			_s.hideATBButtons(true);
			_s.hidePlaybackRateButtons(true);
			_s.hideMainScrubberTop();
		};
		
		_s.volumeOnMouseUpHandler = function(){
			var vol = _s.lastVolume;
			if(_s.isMbl){
				if(!_s.isVolumeScrubberShowed_bl){
					_s.volumeOnMouseOverHandler();
				}
				return;
			}

			if(_s.muted){
				vol = _s.lastVolume;
				_s.muted = false;
			}else{
				vol = 0.000001;
				_s.muted = true;
			};
			_s.updateVolume(vol);
		};
		

		//################################################//
		/* Setup volume scrubber */
		//################################################//
		_s.setupVolumeScrubber = function(){
			
			//setup background bar
			_s.volumeScrubberHolder_do = new FWDUVPDisplayObject("div");
			
			if(_s.repeatBackground_bl){
				_s.volumeBk_do = new FWDUVPDisplayObject("div");
				_s.volumeBk_do.getStyle().background = "url('" + _s.controllerBkPath_str +  "')";
			}else{
				_s.volumeBk_do = new FWDUVPDisplayObject("img");
				var volumeBk_img = new Image();
				volumeBk_img.src = _s.controllerBkPath_str;
				_s.volumeBk_do.setScreen(volumeBk_img);
			}
			_s.volumeScrubberHolder_do.addChild(_s.volumeBk_do);

			_s.volumeScrubber_do = new FWDUVPDisplayObject("div");
			_s.volumeScrubber_do.setHeight(_s.mainScrbH);
			_s.volumeScrubber_do.setY(parseInt(_s.volumeScrubberOfsetHeight/2));
			
			var volumeScrubberBkBottom_img = new Image();
			volumeScrubberBkBottom_img.src = _d.volumeScrubberBkBottomPath_str;
			_s.volumeScrubberBkBottom_do = new FWDUVPDisplayObject("img");
			_s.volumeScrubberBkBottom_do.setScreen(volumeScrubberBkBottom_img);
			_s.volumeScrubberBkBottom_do.setWidth(_s.mainScrubberBkLeft_img.height);
			_s.volumeScrubberBkBottom_do.setHeight(_s.mainScrubberBkLeft_img.width);
			_s.volumeScrubberBkBottom_do.setY(_s.volumeScrubberHeight - _s.volumeScrubberOfsetHeight - _s.volumeScrubberBkBottom_do.h);
		
			var volumeScrubberBkTop_img = new Image();
			volumeScrubberBkTop_img.src = _d.volumeScrubberBkTopPath_str;
			_s.volumeScrubberBkTop_do = new FWDUVPDisplayObject("img");
			
			_s.volumeScrubberBkTop_do.setScreen(volumeScrubberBkTop_img);
			_s.volumeScrubberBkTop_do.setWidth(_s.volumeScrubberBkBottom_do.w);
			_s.volumeScrubberBkTop_do.setHeight(_s.volumeScrubberBkBottom_do.h);
			
			var middleImage = new Image();
			middleImage.src = _d.volumeScrubberBkMiddlePath_str;
			
			if(_s.isMbl){
				_s.volumeScrubberBkMiddle_do = new FWDUVPDisplayObject("div");	
				_s.volumeScrubberBkMiddle_do.getStyle().background = "url('" + _s.volumeScrubberBkMiddlePath_str + "') repeat-y";
			}else{
				_s.volumeScrubberBkMiddle_do = new FWDUVPDisplayObject("img");
				_s.volumeScrubberBkMiddle_do.setScreen(middleImage);
			}
			
			_s.volumeScrubberBkMiddle_do.setWidth(_s.volumeScrubberBkBottom_do.w);
			_s.volumeScrubberBkMiddle_do.setHeight((_s.volumeScrubberHeight - _s.volumeScrubberOfsetHeight) - _s.volumeScrubberBkTop_do.h * 2);
			_s.volumeScrubberBkMiddle_do.setY(_s.volumeScrubberBkTop_do.h);
			
			//setup darg bar.
			_s.volumeScrubberDrag_do = new FWDUVPDisplayObject("div");
			_s.volumeScrubberDrag_do.setWidth(_s.volumeScrubberBkBottom_do.w);
			
			if(_s.useHEX){
				_s.volumeScrubberDragBottom_do = new FWDUVPDisplayObject("div");
				_s.volumeScrubberDragBottom_do.setWidth(_s.volumeScrubberDragBottom_img.width);
				_s.volumeScrubberDragBottom_do.setHeight(_s.volumeScrubberDragBottom_img.height);
				_s.volumeScrubberDragBottom_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.volumeScrubberDragBottom_img, _s.nBC).canvas;
				_s.volumeScrubberDragBottom_do.screen.appendChild(_s.volumeScrubberDragBottom_canvas);	
			}else{
				_s.volumeScrubberDragBottom_do = new FWDUVPDisplayObject("img");
				_s.volumeScrubberDragBottom_do.setScreen(_s.volumeScrubberDragBottom_img);
			}
		
			_s.volumeScrubberDragBottom_do.setWidth(_s.mainScrubberDragLeft_img.height);
			_s.volumeScrubberDragBottom_do.setHeight(_s.mainScrubberDragLeft_img.width);
			_s.volumeScrubberDragBottom_do.setY(_s.volumeScrubberHeight - _s.volumeScrubberOfsetHeight - _s.volumeScrubberDragBottom_do.h);
			
			
			_s.middleImage = new Image();
			_s.middleImage.src = _s.volumeScrubberDragMiddlePath_str;
			
			if(_s.useHEX){
				_s.volumeScrubberDragMiddle_do = new FWDUVPDisplayObject("div");
				_s.middleImage.onload = function(){
					_s.volumeScrubberDragMiddle_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.middleImage, _s.nBC, true);
					_s.volumeScrubberDragImage_img = _s.volumeScrubberDragMiddle_canvas.image;
					_s.volumeScrubberDragMiddle_do.getStyle().background = "url('" + _s.volumeScrubberDragImage_img.src + "') repeat-y";
				}
			}else{
				_s.volumeScrubberDragMiddle_do = new FWDUVPDisplayObject("img");
				_s.volumeScrubberDragMiddle_do.setScreen(_s.middleImage);
			}
			
			_s.volumeScrubberDragMiddle_do.setWidth(_s.volumeScrubberDragBottom_do.w);
			_s.volumeScrubberDragMiddle_do.setHeight(_s.volumeScrubberHeight);
			
			var volumeScrubberBarLine_img = new Image();
			volumeScrubberBarLine_img.src = _d.volumeScrubberLinePath_str;
			_s.volumeScrubberBarLine_do = new FWDUVPDisplayObject("img");
			_s.volumeScrubberBarLine_do.setScreen(volumeScrubberBarLine_img);
			_s.volumeScrubberBarLine_do.setWidth(_s.mainScrubberLine_img.height);
			_s.volumeScrubberBarLine_do.setHeight(_s.mainScrubberLine_img.width);
			_s.volumeScrubberBarLine_do.setAlpha(0);
			_s.volumeScrubberBarLine_do.hasTransform3d_bl = false;
			_s.volumeScrubberBarLine_do.hasTransform2d_bl = false;
			_s.volumeScrubberHolder_do.setWidth(_s.volScrbW);
			_s.volumeScrubberHolder_do.setHeight(_s.volumeScrubberHeight + _s.sH);
			_s.volumeBk_do.setWidth(_s.volScrbW);
			_s.volumeBk_do.setHeight(_s.volumeScrubberHeight + _s.sH);
			_s.volumeScrubber_do.setWidth(_s.volScrbW);
			_s.volumeScrubber_do.setHeight(_s.volumeScrubberHeight - _s.volumeScrubberOfsetHeight);
			
			//add all children
			_s.volumeScrubber_do.addChild(_s.volumeScrubberBkBottom_do);
			_s.volumeScrubber_do.addChild(_s.volumeScrubberBkMiddle_do);
			_s.volumeScrubber_do.addChild(_s.volumeScrubberBkTop_do);
			_s.volumeScrubber_do.addChild(_s.volumeScrubberBarLine_do);
			_s.volumeScrubber_do.addChild(_s.volumeScrubberDragBottom_do);
			_s.volumeScrubberDrag_do.addChild(_s.volumeScrubberDragMiddle_do);
			_s.volumeScrubber_do.addChild(_s.volumeScrubberDrag_do);
			_s.volumeScrubber_do.addChild(_s.volumeScrubberBarLine_do);
			_s.volumeScrubberHolder_do.addChild(_s.volumeScrubber_do);
		
			_s.addChild(_s.volumeScrubberHolder_do);
			
			if(_s.isMbl){
				if(_s.hasPointerEvent_bl){
					_s.volumeScrubber_do.screen.addEventListener("pointerover", _s.volumeScrubberOnOverHandler);
					_s.volumeScrubber_do.screen.addEventListener("pointerout", _s.volumeScrubberOnOutHandler);
					_s.volumeScrubber_do.screen.addEventListener("pointerdown", _s.volumeScrubberOnDownHandler);
				}else{
					_s.volumeScrubber_do.screen.addEventListener("touchstart", _s.volumeScrubberOnDownHandler);
				}
			}else if(_s.screen.addEventListener){	
				_s.volumeScrubber_do.screen.addEventListener("mouseover", _s.volumeScrubberOnOverHandler);
				_s.volumeScrubber_do.screen.addEventListener("mouseout", _s.volumeScrubberOnOutHandler);
				_s.volumeScrubber_do.screen.addEventListener("mousedown", _s.volumeScrubberOnDownHandler);
			}
			
			_s.enableVolumeScrubber();
			_s.updateVolumeScrubber(_s.volume);
		};
		
		_s.volumeScrubberOnOverHandler =  function(e){
			if(_s.isVolumeScrubberDisabled_bl) return;
		};
		
		_s.volumeScrubberOnOutHandler =  function(e){
			if(_s.isVolumeScrubberDisabled_bl) return;
		};
		
		_s.volumeScrubberOnDownHandler =  function(e){
			if(_s.isVolumeScrubberDisabled_bl || e.button == 2) return;
			if(e.preventDefault) e.preventDefault();
			_s.volumeScrubberIsDragging_bl = true;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localY = vc.screenY - _s.volumeScrubber_do.getGlobalY();
			prt.showDisable();
			if(localY < 0){
				localY = 0;
			}else if(localY > _s.volumeScrubber_do.h - _s.scrubbersOffsetWidth){
				localY = _s.volumeScrubber_do.h - _s.scrubbersOffsetWidth;
			}
			var percentScrubbed = 1 - localY/_s.volumeScrubber_do.h;

			_s.lastVolume = percentScrubbed;
			_s.updateVolume(percentScrubbed);
			
			if(_s.isMbl){
				if(_s.hasPointerEvent_bl){
					window.addEventListener("MSPointerMove", _s.volumeScrubberMoveHandler);
					window.addEventListener("pointerup", _s.volumeScrubberEndHandler);
				}else{
					window.addEventListener("touchmove", _s.volumeScrubberMoveHandler, {passive:false});
					window.addEventListener("touchend", _s.volumeScrubberEndHandler);
				}
			}else{
				window.addEventListener("mousemove", _s.volumeScrubberMoveHandler);
				window.addEventListener("mouseup", _s.volumeScrubberEndHandler);		
			}
		};
		
		_s.volumeScrubberMoveHandler = function(e){
			if(_s.isVolumeScrubberDisabled_bl) return;
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var localY = vc.screenY - _s.volumeScrubber_do.getGlobalY();
			
			if(localY < _s.scrubbersOffsetWidth){
				localY = _s.scrubbersOffsetWidth;
			}else if(localY > _s.volumeScrubber_do.h){
				localY = _s.volumeScrubber_do.h;
			}
			var percentScrubbed = 1 - localY/_s.volumeScrubber_do.h;
		
			_s.lastVolume = percentScrubbed;
			_s.updateVolume(percentScrubbed);
		};
		
		_s.volumeScrubberEndHandler = function(){
			prt.hideDisable();
			_s.volumeScrubberIsDragging_bl = false;
			if(_s.isMbl){
				if(_s.hasPointerEvent_bl){
					window.removeEventListener("MSPointerMove", _s.volumeScrubberMoveHandler);
					window.removeEventListener("pointerup", _s.volumeScrubberEndHandler);
				}else{
					window.removeEventListener("touchmove", _s.volumeScrubberMoveHandler);
					window.removeEventListener("touchend", _s.volumeScrubberEndHandler);
				}
			}else{
				window.removeEventListener("mousemove", _s.volumeScrubberMoveHandler);
				window.removeEventListener("mouseup", _s.volumeScrubberEndHandler);		
			}
		};
		
		_s.disableVolumeScrubber = function(){
			_s.isVolumeScrubberDisabled_bl = true;
			_s.volumeScrubber_do.setButtonMode(false);
			_s.volumeScrubberEndHandler();
		};
		
		_s.enableVolumeScrubber = function(){
			_s.isVolumeScrubberDisabled_bl = false;
			_s.volumeScrubber_do.setButtonMode(true);
		};
		
		_s.updateVolumeScrubber = function(percent){
			var totalHeight = _s.volumeScrubberHeight - _s.volumeScrubberOfsetHeight;
			var finalHeight = Math.round(percent * totalHeight); 
			
			_s.volumeScrubberDrag_do.setHeight(Math.max(0,finalHeight - _s.volumeScrubberDragBottom_do.h));
			_s.volumeScrubberDrag_do.setY(totalHeight - finalHeight);
		
			if(finalHeight < 1 && _s.isVolumeScrubberLineVisible_bl){
				_s.isVolumeScrubberLineVisible_bl = false;
				FWDAnimation.to(_s.volumeScrubberBarLine_do, .5, {alpha:0});
				FWDAnimation.to(_s.volumeScrubberDragBottom_do, .5, {alpha:0});
			}else if(finalHeight > 1 && !_s.isVolumeScrubberLineVisible_bl){
				_s.isVolumeScrubberLineVisible_bl = true;
				FWDAnimation.to(_s.volumeScrubberBarLine_do, .5, {alpha:1});
				FWDAnimation.to(_s.volumeScrubberDragBottom_do, .5, {alpha:1});
			}
			
			if(finalHeight > totalHeight) finalHeight = totalHeight;
			
			FWDAnimation.to(_s.volumeScrubberBarLine_do, .8, {y:totalHeight - finalHeight - 2, ease:Expo.easeOut});
		};
		
		_s.updateVolume = function(volume, preventEvent){
			if(!_s.showVolumeScrubber_bl) return;
			_s.volume = volume;
			if(_s.volume <= 0.000001){
				_s.muted = true;
				_s.volume = 0;
			}else if(_s.voume >= 1){
				_s.muted = false;
				_s.volume = 1;
				prt.removeAPT();
			}else{
				_s.muted = false;
				prt.removeAPT();
			}
			
			if(_s.volume == 0){
				if(_s.volBtn) _s.volBtn.setDisabledState();
			}else{
				if(_s.volBtn) _s.volBtn.setEnabledState();
			}
			
			if(_s.volumeScrubberBarLine_do) _s.updateVolumeScrubber(_s.volume);
			if(!preventEvent) _s.dispatchEvent(FWDUVPController.CHANGE_VOLUME, {percent:_s.volume});
		};
		
		_s.showVolumeScrubber = function(animate){
			if(_s.isVolumeScrubberShowed_bl) return;
			_s.isVolumeScrubberShowed_bl = true;
			var finalY = - _s.volumeScrubberHolder_do.h + _s.h;
			_s.volumeScrubberHolder_do.setVisible(true);
			
			if(_s.isMbl){
				setTimeout(function(){
					window.addEventListener("touchstart", _s.hideVolumeSchubberOnMoveHandler);
				},50);
			}else{
				window.addEventListener("mousemove", _s.hideVolumeSchubberOnMoveHandler);
			}
			
			_s.volumeScrubberHolder_do.setX(parseInt(_s.volBtn.x + (_s.volBtn.w - _s.volumeScrubberHolder_do.w)/2));
			
			if(animate){
				FWDAnimation.to(_s.volumeScrubberHolder_do, .6, {y:finalY, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.volumeScrubberHolder_do);
				_s.volumeScrubberHolder_do.setY(finalY);
			}
		};
		
		_s.hideVolumeSchubberOnMoveHandler = function(e){
			
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			
			if((FWDUVPUtils.hitTest(_s.volumeScrubberHolder_do.screen, vc.screenX, vc.screenY)
			   || FWDUVPUtils.hitTest(_s.volBtn.screen, vc.screenX, vc.screenY)
			 ) && !_s.isMbl){
				return;
			}
			
			if(FWDUVPUtils.hitTest(_s.volumeScrubber_do.screen, vc.screenX, vc.screenY) && _s.isMbl){
				return;
			}
			
			if(_s.volumeScrubberIsDragging_bl) return;
		
			_s.hideVolumeScrubber(true);
			if(_s.isMainScrubberOnTop_bl){
				_s.mainScrubber_do.setX(0);
				FWDAnimation.to(_s.mainScrubber_do, .6, {alpha:1});
			}
		};
	
		_s.hideVolumeScrubber = function(animate){
			if(!_s.isVolumeScrubberShowed_bl) return;
			_s.isVolumeScrubberShowed_bl = false;
			
			_s.volBtn.setNormalState(true);
			if(animate){
				FWDAnimation.to(_s.volumeScrubberHolder_do, .6, {y:prt.sH, ease:Expo.easeInOut, onComplete:function(){_s.volumeScrubberHolder_do.setVisible(false);}});
			}else{
				FWDAnimation.killTweensOf(_s.ytbButtonsHolder_do);
				_s.volumeScrubberHolder_do.setY(prt.sH);
				_s.volumeScrubberHolder_do.setVisible(false);
			}
			
			if(_s.isMbl){
				window.removeEventListener("touchstart", _s.hideVolumeSchubberOnMoveHandler);
			}else{
				window.removeEventListener("mousemove", _s.hideVolumeSchubberOnMoveHandler);
			}
		};

		
		//###################################//
		/* show / hide */
		//###################################//
		_s.show = function(animate){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;

			_s.setX(0);
			if(animate){
				FWDAnimation.to(_s.mainHld, .8, {y:0, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.mainHld);
				_s.mainHld.setY(0);
			}

			_s.disableCtrl_to = setTimeout(function(){
				_s.positionButtons();
				_s.getStyle().pointerEvents = 'auto';
			}, 200);

		};
		
		_s.hide = function(animate, offset){

			if(!_s.isShowed_bl) return;
			if(!offset) offset = 0;
			if(_s.atb && _s.atb.isShowed_bl) offset += _s.h + 1;
			if(_s.isMainScrubberOnTop_bl  && _s.atb && _s.atb.isShowed_bl) offset += _s.mainScrubberOffestTop;
			if(!_d.showScrubberWhenControllerIsHidden_bl) offset +=_s.mainScrubber_do.h - 14;
			_s.isShowed_bl = false;
			clearTimeout(_s.disableCtrl_to);
			_s.getStyle().pointerEvents = 'none';
			
			if(animate){
				FWDAnimation.to(_s.mainHld, .8, {y:_s.sH + offset, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s.mainHld);
				_s.mainHld.setY(_s.sH + offset);
			}

			_s.hideQualityButtons(true);
			_s.hideSubtitleButtons(true);
			_s.hideATBButtons(true);
			_s.hidePlaybackRateButtons(true);
		};
		
		_s.mainScrubberDragMiddleAddPath_str = _d.mainScrubberDragMiddleAddPath_str;
		_s.updateHexColorForScrubber = function(isAdd){
			if(isAdd){
				_s.mainScrubberDragMiddle_do.getStyle().background = "url('" + _s.mainScrubberDragMiddleAddPath_str + "') repeat-x";
				_s.mainScrubberDragLeft_do.screen.src = _d.mainScrubberDragLeftAddPath_str;
			}else{
				if(_s.useHEX && _s.mainSCrubberMiddleCanvas){
					var newCenterImage = FWDUVPUtils.changeCanvasHEXColor(_s.mainScrubberMiddleImage, _s.mainSCrubberMiddleCanvas, _s.nBC, true);
					_s.mainScrubberDragMiddle_do.getStyle().background = "url('" + newCenterImage.src + "') repeat-x";
				}else{
					_s.mainScrubberDragMiddle_do.getStyle().background = "url('" + _s.mainScrubberDragMiddlePath_str + "') repeat-x";
					_s.mainScrubberDragLeft_do.screen.src = _s.mainScrubberDragLeftSource;
				}
			}
		}

		_s.updateHEXColors = function(nBC, sBC){
		 	_s.nBC = nBC;
            _s.sBC = sBC;
		}
	
		_s.init();
	};

	
	/* set prototype */
	FWDUVPController.setPrototype = function(){
		FWDUVPController.prototype = new FWDUVPDisplayObject("div");
	};
	

	FWDUVPController.VR = 'vr';
	FWDUVPController.UNCAST = 'uncast';
	FWDUVPController.CAST = 'cast';	
	FWDUVPController.SHOW_SHARE_WINDOW = "showShareWindow";
	FWDUVPController.SHOW_SUBTITLE = "showSubtitle";
	FWDUVPController.HIDE_SUBTITLE = "hideSubtitle";
	FWDUVPController.SHOW_PLAYLIST = "showPlaylist";
	FWDUVPController.HIDE_PLAYLIST = "hidePlaylist";
	FWDUVPController.SHOW_CATEGORIES = "showCategories";
	FWDUVPController.DOWNLOAD_VIDEO = "downloadVideo";
	FWDUVPController.UNCAST = 'uncast';
	FWDUVPController.REWIND = "rewind";
	FWDUVPController.FULL_SCREEN = "fullScreen";
	FWDUVPController.NORMAL_SCREEN = "normalScreen";
	FWDUVPController.PLAY = "play";
	FWDUVPController.PAUSE = "pause";
	FWDUVPController.START_TO_SCRUB = "startToScrub";
	FWDUVPController.SCRUB = "scrub";
	FWDUVPController.STOP_TO_SCRUB = "stopToScrub";
	FWDUVPController.CHANGE_VOLUME = "changeVolume";
	FWDUVPController.CHANGE_YOUTUBE_QUALITY = "changeYoutubeQuality";
	FWDUVPController.SHOW_EMBED_WINDOW = "showEmbedWindow";
	FWDUVPController.SHOW_INFO_WINDOW = "showInfoWindow";
	FWDUVPController.CHANGE_SUBTITLE = "changeSubtitle";
	FWDUVPController.CHANGE_PLAYBACK_RATES = "changePlaybackRate";
	FWDUVPController.CHANGE_AUDIO_TRACKS = 'changeAudioTracks';
	
	FWDUVPController.prototype = null;
	window.FWDUVPController = FWDUVPController;
	
}());