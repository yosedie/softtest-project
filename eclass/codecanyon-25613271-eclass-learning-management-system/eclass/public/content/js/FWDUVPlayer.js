/**
 * Ultimate Video Player PACKAGED v9.1
 * Main class.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPlayer = function(props){

		'use strict';

		FWDUVPlayer.V = '8.4';
		
		var _s = this;
		_s.isInstantiate_bl = false;
		_s.displayType = props.displayType || FWDUVPlayer.RESPONSIVE;
		
		if(_s.displayType.toLowerCase() != FWDUVPlayer.RESPONSIVE 
		   && _s.displayType.toLowerCase() != FWDUVPlayer.FULL_SCREEN
		   && _s.displayType.toLowerCase() != FWDUVPlayer.STICKY
		   && _s.displayType.toLowerCase() != FWDUVPlayer.AFTER_PARENT
		   && _s.displayType.toLowerCase() != FWDUVPlayer.LIGHTBOX){
			_s.displayType = FWDUVPlayer.RESPONSIVE;
		}
		_s.displayType = _s.displayType.toLowerCase();
		
		_s.stickyOnScroll = props.stickyOnScroll || "no";
		_s.stickyOnScroll = _s.stickyOnScroll == "yes" ? true : false;
		if(_s.displayType != FWDUVPlayer.RESPONSIVE) _s.stickyOnScroll = false;
		_s.isMinShowed = true;
		
		_s.stickyOnScrollWidth = props.stickyOnScrollWidth || 700;
		_s.stickyOnScrollHeight = props.stickyOnScrollHeight || 394; 

		_s.maxWidth = props.maxWidth || 640;
		_s.maxHeight = props.maxHeight || 380;
	
		_s.useYoutube_bl = props.useYoutube || "no"; 
		_s.useYoutube_bl = _s.useYoutube_bl == "yes" ? true : false;
		
		_s.useVimeo_bl = props.useVimeo || "no"; 
		_s.useVimeo_bl = _s.useVimeo_bl == "yes" ? true : false;
		
		_s.mainFolderPath_str = props.mainFolderPath;
		if((_s.mainFolderPath_str.lastIndexOf("/") + 1) != _s.mainFolderPath_str.length){
			_s.mainFolderPath_str += "/";
		}
		
		_s.sknPth = props.skinPath;
		if((_s.sknPth.lastIndexOf("/") + 1) != _s.sknPth.length){
			_s.sknPth += "/";
		}
		
		_s.warningIconPath_str = _s.mainFolderPath_str + _s.sknPth + "warningIcon.png";
		
		FWDUVPlayer.YTAPIReady = false;
		_s.fillEntireVideoScreen_bl = false;
	
		/* init gallery */
		_s.init = function(){
			if(_s.isInstantiate_bl) return;
			FWDUVPlayer.instaces_ar.push(_s);
			
			FWDTweenLite.ticker.useRAF(false);
			_s.props = props;
			
			_s.instanceName_str = _s.props.instanceName;
			
			if(!_s.instanceName_str){
				alert("FWDUVPlayer instance name is required please make sure that the instanceName parameter exsists and it's value is uinique.");
				return;
			}
			
			if(window[_s.instanceName_str]){
				alert("FWDUVPlayer instance name " + _s.instanceName_str +  " is already defined and contains a different instance reference, set a different instance name.");
				return;
			}else{
				window[_s.instanceName_str] = _s;
			}
		
			if(!_s.props){
				alert("FWDUVPlayer constructor properties object is not defined!");
				return;
			}
			
			if(!_s.props.parentId){		
				alert("Property parentId is not defined in the FWDUVPlayer constructor, _s property represents the div id into which the megazoom is added as a child!");
				return;
			}
			
			if(_s.displayType == FWDUVPlayer.RESPONSIVE) _s.mustHaveHolderDiv_bl = true;
		
			if(_s.mustHaveHolderDiv_bl && !FWDUVPUtils.getChildById(_s.props.parentId)){
				alert("FWDUVPlayer holder div is not found, please make sure that the div exsists and the id is correct! " + _s.props.parentId);
				return;
			}
			
			_s.body = document.getElementsByTagName("body")[0];
			if(_s.displayType == FWDUVPlayer.STICKY){
				_s.stageContainer = document.createElement("div");
				_s.stageContainer.style.position = "fixed";
				_s.stageContainer.style.width = "100%";
				_s.stageContainer.style.zIndex = "999999";
				_s.stageContainer.style.height = "0px";
			
				document.documentElement.appendChild(_s.stageContainer);
				_s.stageContainer.style.overflow = "visible";
				
			}else if(_s.displayType == FWDUVPlayer.FULL_SCREEN  || _s.displayType == FWDUVPlayer.LIGHTBOX){
				_s.stageContainer = document.documentElement;
			}else{
				_s.stageContainer = FWDUVPUtils.getChildById(_s.props.parentId);
			}
		
			_s.position_str = _s.props.verticalPosition;
			if(!_s.position_str) _s.position_str = FWDUVPlayer.POSITION_TOP;
			if(_s.position_str == "bottom"){
				_s.position_str = FWDUVPlayer.POSITION_BOTTOM;
			}else{
				_s.position_str = FWDUVPlayer.POSITION_TOP;
			}
			
			_s.horizontalPosition_str = _s.props.horizontalPosition;
			if(!_s.horizontalPosition_str) _s.horizontalPosition_str = FWDUVPlayer.CENTER;
			if(_s.horizontalPosition_str == "center"){
				_s.horizontalPosition_str = FWDUVPlayer.CENTER;
			}else if(_s.horizontalPosition_str == "left"){
				_s.horizontalPosition_str = FWDUVPlayer.LEFT;
			}else if(_s.horizontalPosition_str == "right"){
				_s.horizontalPosition_str = FWDUVPlayer.RIGHT;
			}else{
				_s.horizontalPosition_str = FWDUVPlayer.CENTER;
			}
			
			if(_s.isEmbedded_bl) _s.displayType = FWDUVPlayer.FULL_SCREEN;
			
			_s.listeners = {events_ar:[]};
			_s.spaceBetweenControllerAndPlaylist = _s.props.spaceBetweenControllerAndPlaylist || 1;
			_s.autoScale_bl = _s.props.autoScale;
			_s.autoScale_bl = _s.autoScale_bl == "yes" ? true : false;

			_s.ec = document.getElementById('fwduvp_extra_content');
			
			_s.showPreloader_bl = _s.props.showPreloader;
			_s.showPreloader_bl = _s.showPreloader_bl == "yes" ? true : false;
			
			_s.preloaderColors = _s.props.preloaderColors || ["#666666", "#FFFFFF"];
			
			_s.backgroundColor_str = _s.props.backgroundColor || "transparent";
			_s.videoBackgroundColor_str = _s.props.videoBackgroundColor || "transparent";
			
			_s.mainBackgroundImagePath_str = _s.props.mainBackgroundImagePath;
			if(_s.mainBackgroundImagePath_str && _s.mainBackgroundImagePath_str.length < 3) _s.mainBackgroundImagePath_str = undefined;
			
			_s.animate_bl = true; 
			_s.isShowedFirstTime_bl = true;
			
			_s.offsetX = parseInt(_s.props.offsetX) || 0;
			_s.offsetY = parseInt(_s.props.offsetY) || 0
			_s.lastX = 0;
			_s.lastY = 0;
			_s.tempStageWidth = 0;
			_s.tempStageHeight = 0;
			_s.tempVidStageWidth = 0;
			_s.tempVidStageHeight = 0;
			_s.sW = 0;
			_s.sH = 0;
			_s.vidStageWidth = 0;
			_s.vidStageHeight = 0;
			_s.catId = -1;
			_s.id = -1;
			_s.totaadsIdeos = 0;
			_s.prevCatId = -1;
			_s.totalTimePlayed = 0;
			_s.isFullScreen_bl = false;
			
			_s.videoSourcePath_str = "";
			_s.prevVideoSourcePath_str;
			_s.posterPath_str = _s.props.posterPath;
			_s.playListThumbnailWidth = _s.props.thumbnailWidth || 80;
			_s.playListThumbnailHeight = _s.props.thumbnailHeight || 80;

			_s.showOnlyThumbnail = _s.props.showOnlyThumbnail;
			_s.showOnlyThumbnail = _s.showOnlyThumbnail == "yes" ? true : false;

			_s.playlistWidth = _s.props.playlistRightWidth || 250;
			_s.playlistHeight = 0;
			
			_s.showPlaylistButtonAndPlaylist_bl = _s.props.showPlaylistButtonAndPlaylist;
			_s.showPlaylistButtonAndPlaylist_bl = _s.showPlaylistButtonAndPlaylist_bl == "no" ? false : true;
			
			_s.isPlaylistShowed_bl = _s.props.showPlaylistByDefault;
			_s.isPlaylistShowed_bl = _s.isPlaylistShowed_bl == "no" ? false : true;
			
			_s.showErrorInfo_bl = _s.props.showErrorInfo; 
			_s.showErrorInfo_bl = _s.showErrorInfo_bl == "no" ? false : true;
			
			_s.showAnnotationsPositionTool_bl =  _s.props.showAnnotationsPositionTool;
			_s.showAnnotationsPositionTool_bl = _s.showAnnotationsPositionTool_bl == "yes" ? true : false;
			if(_s.showAnnotationsPositionTool_bl) _s.isPlaylistShowed_bl = false;
			
			if(FWDUVPlayer.videoStartBehaviour != "pause" 
			&& FWDUVPlayer.videoStartBehaviour != "stop"
			&& FWDUVPlayer.videoStartBehaviour != "default"
			){
				FWDUVPlayer.videoStartBehaviour = "pause";
			}
			
			_s.lightBoxBackgroundOpacity = _s.props.lightBoxBackgroundOpacity || 1;
			_s.lightBoxBackgroundColor_str = _s.props.lightBoxBackgroundColor || "transparent";
			_s.preloaderBackgroundColor = _s.props.preloaderBackgroundColor || "#000000";
			_s.preloaderFillColor = _s.props.preloaderFillColor || "#FFFFFF";
			_s.addPrevId = Math.random() * 999999999;
			_s.orintationChangeComplete_bl = true;
			_s.isInstantiate_bl = true;
			_s.useDeepLinking_bl = _s.props.useDeepLinking;
			_s.useDeepLinking_bl = _s.useDeepLinking_bl == "yes" ? true : false;
			
			_s.isMbl = FWDUVPUtils.isMobile;
			_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
			
			_s.lightBoxWidth = _s.props.maxWidth || 500;
			_s.lightBoxHeight =  _s.props.maxHeight || 400;
			
			_s.isShowed_bl = _s.props.showPlayerByDefault; 
			_s.isShowed_bl = _s.isShowed_bl == "yes" ? true : false;
			
			_s.googleAnalyticsMeasurementId = _s.props.googleAnalyticsMeasurementId; 
			if(!window['gtag'] && _s.googleAnalyticsMeasurementId){
				var script = document.createElement('script');
			    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + _s.googleAnalyticsMeasurementId;
			    script.setAttribute("async", "true");
			    script.onload = function() {

			      _s.initGoogleAnalytics();
			    };
			    document.head.appendChild(script);
			}else if(window['gtag'] && _s.googleAnalyticsMeasurementId){
				_s.initGoogleAnalytics();
			}

		
			if(_s.displayType == FWDUVPlayer.LIGHTBOX){
				_s.setupLightBox();
			}else if(_s.displayType == FWDUVPlayer.STICKY){
				_s.setupPlayer();
				_s.startResizeHandler();
			}else{
				if(_s.initializeOnlyWhenVisible_bl){
					_s.startResizeHandler();
					window.addEventListener("scroll", _s.onInitlalizeScrollHandler);
					setTimeout(_s.onInitlalizeScrollHandler, 500);
				}else{
					_s.setupPlayer();
					_s.startResizeHandler();
				}
			}
		};

		_s.initGoogleAnalytics = function(){
			  // Once the script is loaded, initialize Google Analytics
		      window.dataLayer = window.dataLayer || [];
			  _s.gtag = function(){dataLayer.push(arguments);}

		      _s.gtag('js', new Date());
		      _s.gtag('config', _s.googleAnalyticsMeasurementId);
		}

		_s.addMinOnScroll = function(){
			if(_s.displayType != FWDUVPlayer.RESPONSIVE) return;
			if(_s.stickyOnScroll) window.addEventListener("scroll", _s.minimizeOnScrollHandler);
		}

		_s.removeMinOnScroll = function(){
			if(_s.stickyOnScroll) window.removeEventListener("scroll", _s.minimizeOnScrollHandler);
		}

		_s.minimizeOnScrollHandler = function(e){
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.pageXOffset = scrollOffsets.x;
			_s.pageYOffset = scrollOffsets.y;
			
			if(_s.stageContainer.getBoundingClientRect().bottom < 0){
				_s.setMinimized();
			}else{
				_s.setNormal();
			}
		}

		_s.setMinimized = function(){
			if(_s.isMin || _s.isFullscreen_bl) return;
			_s.isMin = true;
			_s.main_do.getStyle().position = 'fixed';
			_s.main_do.getStyle().zIndex = 9999999999999;
			_s.main_do.setAlpha(0);
			_s.startPosisionOnMin();
		}

		_s.startPosisionOnMin = function(){
			_s.wasPlaylistShowed_bl = _s.isPlaylistShowed_bl;
			_s.showPlaylist();
			_s.resizeHandler();
			_s.positionOnMin();
		}

		_s.setNormal = function(){
			if(!_s.isMin) return;
			_s.isMinShowed = true;
			_s.isMin = false;
			_s.main_do.getStyle().position = "relative";
			_s.main_do.getStyle().zIndex = 0;
			FWDAnimation.killTweensOf(_s.main_do);
			_s.main_do.setAlpha(1);
			_s.main_do.setX(0);
			_s.main_do.setY(0);
			if(_s.opener_do) _s.opener_do.setX(-1000);
						
			_s.startPosisionOnNormal();
		}

		_s.startPosisionOnNormal = function(){
			if(_s.opener_do) _s.opener_do.showCloseButton();
			_s.isPlaylistShowed_bl = _s.wasPlaylistShowed_bl;
			if(_s.isPlaylistShowed_bl) _s.hidePlaylist(true);
			_s.resizeHandler();
		}
		
		_s.positionOnMin = function(animate){
			if(!_s.isMin && !animate) return;
			var offset = 5;
			var dl = .2;
			if(_s.isMbl) offset= 0;
			var offsetTop = 0;
			if(!_s.isMinShowed){
				dl = 0;
				offsetTop = Math.round(_s.tempStageHeight) + offset;
			} 

			if(_s.opener_do){
				var oX = _s.ws.w - _s.opener_do.w - offset;
				var oY = _s.ws.h - _s.tempStageHeight - offset + offsetTop - _s.opener_do.h;
			}
			
			_s.main_do.setX(_s.ws.w - _s.tempStageWidth - offset);
			if(_s.main_do.alpha == 0 || animate){
				if(_s.main_do.alpha == 0){
					_s.main_do.setY(_s.ws.h);
					if(_s.opener_do){
						_s.opener_do.setX(oX);
						_s.opener_do.setY(_s.ws.h);
					}
				}
				FWDAnimation.to(_s.main_do, .8, {alpha:1, y:_s.ws.h - _s.tempStageHeight - offset + offsetTop, delay:dl, ease:Expo.easeInOut});
				if(_s.opener_do){
					FWDAnimation.killTweensOf(_s.opener_do);
					FWDAnimation.to(_s.opener_do, .8, {x:oX, y:oY, delay:dl, ease:Expo.easeInOut});
				}
			}else{
				FWDAnimation.killTweensOf(_s.main_do);
				_s.main_do.setAlpha(1);
				_s.main_do.setY(_s.ws.h - _s.tempStageHeight - offset + offsetTop);
				if(_s.opener_do){
					FWDAnimation.killTweensOf(_s.opener_do);
					_s.opener_do.setX(oX);
					_s.opener_do.setY(oY);
				}
			}			
		}

		_s.onInitlalizeScrollHandler = function(){
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.pageXOffset = scrollOffsets.x;
			_s.pageYOffset = scrollOffsets.y;
			
			if(_s.main_do.getRect().top >= -_s.sH && _s.main_do.getRect().top < _s.ws.h){
				window.removeEventListener("scroll", _s.onInitlalizeScrollHandler);
				_s.setupPlayer();
			}
		};
		
		_s.setupPlayer = function(){
			if(!_s.main_do){
				_s.setupMainDo();
				_s.setupInfo();
				_s.setupData();
			}
		}
		
		//#############################################//
		/* setup  lighbox...*/
		//#############################################//
		_s.setupLightBox = function(){
			
			FWDUVPLightBox.setPrototype();
			_s.lightBox_do =  new FWDUVPLightBox(_s, 
					_s.lightBoxBackgroundColor_str, 
					_s.backgroundColor_str, 
					_s.lightBoxBackgroundOpacity, 
					_s.lightBoxWidth, 
					_s.lightBoxHeight);
					
			_s.lightBox_do.addListener(FWDUVPLightBox.SHOW, _s.lightBoxShowHandler);
			_s.lightBox_do.addListener(FWDUVPLightBox.CLOSE, _s.lightBoxCloseHandler);
			_s.lightBox_do.addListener(FWDUVPLightBox.HIDE_COMPLETE, _s.lightBoxHideCompleteHandler);
			_s.setupPlayer();
		};
		
		_s.lightBoxShowHandler = function(){}
		
		_s.lightBoxCloseHandler = function(){
		
			_s.stop();
			_s.stopResizeHandler();
		};
		
		_s.lightBoxHideCompleteHandler = function(){
			_s.dispatchEvent(FWDUVPlayer.HIDE_LIGHTBOX_COMPLETE);
		};

	
		//#############################################//
		/* setup main do */
		//#############################################//
		_s.setupMainDo = function(){
		
			_s.main_do = new FWDUVPDisplayObject("div", "relative");
			_s.main_do.screen.className = 'fwduvp';
			if(_s.hasPointerEvent_bl) _s.main_do.getStyle().touchAction = "none";
			_s.main_do.getStyle().webkitTapHighlightColor = "rgba(0, 0, 0, 0)";
			_s.main_do.getStyle().webkitFocusRingColor = "rgba(0, 0, 0, 0)";
			_s.main_do.getStyle().width = "100%";
			_s.main_do.getStyle().height = "100%";
			_s.main_do.setBackfaceVisibility();
			_s.main_do.setBkColor(_s.backgroundColor_str);
			if(!FWDUVPUtils.isMobile || (FWDUVPUtils.isMobile && FWDUVPUtils.hasPointerEvent)) _s.main_do.setSelectable(false);	
			_s.videoHolder_do = new FWDUVPDisplayObject("div");
			_s.main_do.addChild(_s.videoHolder_do);

			if(_s.displayType ==  FWDUVPlayer.STICKY){
				_s.background_do = new FWDUVPDisplayObject("div");
				_s.background_do.getStyle().width = "100%";
				if(_s.mainBackgroundImagePath_str){
					_s.mainBackground_do =  new FWDUVPDisplayObject("div");
					_s.stageContainer.appendChild(_s.mainBackground_do.screen);
				}
				_s.stageContainer.appendChild(_s.background_do.screen);
				_s.stageContainer.appendChild(_s.main_do.screen);
			}else if(_s.displayType == FWDUVPlayer.FULL_SCREEN){	
				_s.stageContainer.style.overflow = "hidden";
				_s.main_do.getStyle().position = "absolute";
				document.documentElement.appendChild(_s.main_do.screen);
				_s.stageContainer.style.zIndex = 9999999999998;
				_s.main_do.getStyle().zIndex = 9999999999998;
			}else if(_s.displayType == FWDUVPlayer.BACKGROUND_VIDEO){	
				document.documentElement.appendChild(_s.main_do.screen);
				_s.main_do.getStyle().zIndex = -9999999999998;
				_s.main_do.getStyle().position = "fixed";
				document.documentElement.insertBefore(_s.main_do.screen, document.documentElement.firstChild);
			}else if(_s.displayType == FWDUVPlayer.LIGHTBOX){
				_s.main_do.getStyle().position = "absolute";
			
				_s.stageContainer = _s.lightBox_do.mainLightBox_do.screen;
				_s.stageContainer.appendChild(_s.main_do.screen);
				_s.main_do.setX(-10000);
				_s.main_do.setY(-10000);
				_s.main_do.setWidth(0);
				_s.main_do.setHeight(0);
			}else{
				_s.stageContainer.style.overflow = "hidden";
				_s.stageContainer.appendChild(_s.main_do.screen);
			}	

			if(_s.isEmbedded_bl) _s.main_do.getStyle().zIndex = 9999999999998;
		};
		
		
		//#############################################//
		/* setup info_do */
		//#############################################//
		_s.setupInfo = function(){
			FWDUVPInfo.setPrototype();
			_s.info_do = new FWDUVPInfo(_s, _s.warningIconPath_str, _s.showErrorInfo_bl);
			_s.info_do.getStyle().zIndex = "9999999999999999";
		};		
		

		//#############################################//
		/* resize handler */
		//#############################################//
		_s.startResizeHandler = function(){
			
			if(_s.displayType == FWDUVPlayer.STICKY){
				if(FWDUVPUtils.isAndroid) window.addEventListener("orientationchange", _s.orientationChange);
				window.addEventListener("scroll", _s.onScrollHandler);
			}
			
			if(_s.displayType == FWDUVPlayer.LIGHTBOX){
				window.addEventListener("scroll", _s.onScrollHandler);
			}
			
			window.addEventListener("resize", _s.onResizeHandler);
		
			_s.onResizeHandler(true);
			_s.resizeHandlerId_to = setTimeout(function(){_s.resizeHandler();}, 500);
		};
		
		_s.orientationChange = function(){
			_s.orintationChangeComplete_bl = false;	
			clearTimeout(_s.resizeHandlerId_to);
			clearTimeout(_s.resizeHandler2Id_to);
			clearTimeout(_s.orientationChangeId_to);
		
			_s.orientationChangeId_to = setTimeout(function(){
				_s.orintationChangeComplete_bl = true; 
				_s.stageContainer.style.left = "0";
				_s.resizeHandler(true);
				}, 1000);
			
			_s.stageContainer.style.left = "-5000px";
			if(_s.preloader_do) _s.preloader_do.setX(-5000);	
		};
		
		_s.onScrollHandler = function(e){
			if(_s.displayType == FWDUVPlayer.STICKY && _s.isMbl) _s.onResizeHandler();
			if(_s.lightBox_do && !_s.lightBox_do.isShowed_bl) return;
			_s.scrollHandler();
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.scrollOffsets = scrollOffsets;
		};
		
		_s.scrollHandler = function(){
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.pageXOffset = scrollOffsets.x;
			_s.pageYOffset = scrollOffsets.y;
			if(_s.displayType == FWDUVPlayer.LIGHTBOX){
				_s.lightBox_do.setX(scrollOffsets.x);
				_s.lightBox_do.setY(scrollOffsets.y);
			}else if(_s.isFullScreen_bl || _s.displayType == FWDUVPlayer.FULL_SCREEN){	
				_s.main_do.setX(scrollOffsets.x);
				_s.main_do.setY(scrollOffsets.y);
			}
		};
		
		_s.stopResizeHandler = function(){
			if(window.removeEventListener){
				window.removeEventListener("resize", _s.onResizeHandler);
			}else if(window.detachEvent){
				window.detachEvent("onresize", _s.onResizeHandler);
			}	
			clearTimeout(_s.resizeHandlerId_to);
		};

		
		_s.onResizeHandler = function(e){
			_s.resizeHandler();
			clearTimeout(_s.resizeHandler2Id_to);
			_s.resizeHandler2Id_to = setTimeout(function(){_s.resizeHandler();}, 300);
		};
		
		_s.prevVpW;
		_s.resizeHandler = function(allowToResizeFinal, resizePlaylistWithAnim){
			_s.tempPlaylistPosition_str;
		
			var viewportSize = FWDUVPUtils.getViewportSize();
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.ws = viewportSize;
			_s.showPlaylistOnFullScreen = _s._d.showPlaylistOnFullScreen;
			if(_s.ws.w < 1000) _s.showPlaylistOnFullScreen = false;
			
			if(_s.displayType == FWDUVPlayer.STICKY  && !_s.isFullScreen_bl){	
				_s.main_do.getStyle().width = "100%";
				if(_s.main_do.getWidth() > _s.maxWidth){
					_s.main_do.setWidth(_s.maxWidth);
				}
				
				_s.sW = _s.main_do.getWidth();
				if(_s.autoScale_bl){
					_s.sH = parseInt(_s.maxHeight * (_s.sW/_s.maxWidth));
				}else{
					_s.sH = _s.maxHeight;
				}
			
			}else if(_s.displayType == FWDUVPlayer.LIGHTBOX && !_s.isFullScreen_bl){
				if(!_s.lightBox_do.isShowed_bl ||  !_s.main_do) return;
				if(_s.lightBoxWidth > viewportSize.w){
					_s.finalLightBoxWidth = viewportSize.w;
					_s.finalLightBoxHeight = parseInt(_s.lightBoxHeight * (viewportSize.w/_s.lightBoxWidth));
				}else{
					_s.finalLightBoxWidth = _s.lightBoxWidth;
					_s.finalLightBoxHeight = _s.lightBoxHeight;
				}
				_s.lightBox_do.setWidth(viewportSize.w);
				_s.lightBox_do.setHeight(viewportSize.h);
				_s.lightBox_do.setX(scrollOffsets.x);
				_s.lightBox_do.setY(scrollOffsets.y);
				_s.lightBox_do.mainLightBox_do.setX(parseInt((viewportSize.w - _s.finalLightBoxWidth)/2));
				_s.lightBox_do.mainLightBox_do.setY(parseInt((viewportSize.h - _s.finalLightBoxHeight)/2));
				if(_s.lightBox_do.clsBtn && _s.lightBox_do.isShowed_bl){ 
					_s.lightBox_do.clsBtn.setX(viewportSize.w - _s.lightBox_do.clsBtn.w - 15);
					_s.lightBox_do.clsBtn.setY(15);
				}
				_s.main_do.setX(0);
				_s.main_do.setY(0);
				_s.lightBox_do.mainLightBox_do.setWidth(_s.finalLightBoxWidth);
				_s.lightBox_do.mainLightBox_do.setHeight(_s.finalLightBoxHeight);	
				_s.sW = _s.finalLightBoxWidth;
				_s.sH = _s.finalLightBoxHeight;
			}else if(_s.isFullScreen_bl || _s.displayType == FWDUVPlayer.FULL_SCREEN){	
				_s.main_do.setX(0);
				_s.main_do.setY(0);
				_s.sW = viewportSize.w;
				_s.sH = viewportSize.h;
			}else if(_s.displayType == FWDUVPlayer.AFTER_PARENT){
				_s.main_do.setX(0);
				_s.main_do.setY(0);
				_s.sW = _s.stageContainer.offsetWidth;
				_s.sH = _s.stageContainer.offsetHeight;
			}else{
				_s.stageContainer.style.width = "100%";
				if(_s.stageContainer.offsetWidth > _s.maxWidth){
					_s.stageContainer.style.width = _s.maxWidth + "px";
				}
				_s.sW = _s.stageContainer.offsetWidth;
				if(_s.autoScale_bl){
					_s.sH = parseInt(_s.maxHeight * (_s.sW/_s.maxWidth));
					_s.tempStageHeight = _s.sH;
				}else{
					_s.sH = _s.maxHeight;
					_s.tempStageHeight = _s.sH;
				}
			}
			
			if(_s.sH > viewportSize.h && _s.isFullScreen_bl) _s.sH = viewportSize.h;
			if(_s._d && _s.playlist_do){
				_s.playlistHeight = parseInt(_s._d.playlistBottomHeight);
			}

			if(_s.isMin && !_s.isFullScreen_bl){
				_s.sW = Math.min(_s.stickyOnScrollWidth - 10, _s.ws.w - 10)
				_s.sH = parseInt(_s.stickyOnScrollHeight * (_s.sW/_s.stickyOnScrollWidth));
				_s.tempStageHeight = _s.sH;
			}
		
			if(_s._d){
				_s.tempPlaylistPosition_str = _s._d.playlistPosition_str;
				if(_s.sW < 800 || (_s.ec && _s.sH < 600)){
					_s.tempPlaylistPosition_str = "bottom";
				}
				_s.playlistPosition_str = _s.tempPlaylistPosition_str;
				if(_s.playlist_do) _s.playlist_do.position_str = _s.tempPlaylistPosition_str;
			}
			
			if(_s.playlist_do && _s.isPlaylistShowed_bl){
				if(_s.playlistPosition_str == "bottom"){
					_s.vidStageWidth = _s.sW;
					_s.sH += _s.playlistHeight + _s.spaceBetweenControllerAndPlaylist;
					_s.vidStageHeight = _s.sH - _s.playlistHeight - _s.spaceBetweenControllerAndPlaylist;
					if(_s.displayType == FWDUVPlayer.FULL_SCREEN) _s.controller_do.disablePlaylistButton();
				}else if(_s.playlistPosition_str == "right"){
					if(_s.isFullScreen_bl && !_s.showPlaylistOnFullScreen){
						_s.vidStageWidth = _s.sW;
					}else{
						_s.vidStageWidth = _s.sW - _s.playlistWidth - _s.spaceBetweenControllerAndPlaylist;
					}
					if(_s.controller_do) _s.controller_do.enablePlaylistButton();
					_s.vidStageHeight = _s.sH;
				}
			}else{
				_s.vidStageWidth = _s.sW;
				_s.vidStageHeight = _s.sH;
			}
				
			if(_s.controller_do){
				if(_s.playlist_do){
					if(_s.playlistPosition_str == "right"){
						if(_s.isFullScreen_bl && !_s.showPlaylistOnFullScreen){
							_s.controller_do.disablePlaylistButton();
						}else{
							_s.controller_do.enablePlaylistButton();
						}
					}else if(_s.isEmbedded_bl){
						_s.controller_do.disablePlaylistButton();
					}
				}
			}
			
			if(_s.mainBackground_do){
				_s.mainBackground_do.setWidth(_s.ws.w);
				_s.mainBackground_do.setHeight(_s.sH);
			}
			
			if(!allowToResizeFinal){
				FWDAnimation.killTweensOf(_s);
				
				_s.tempStageWidth = _s.sW;
				_s.tempStageHeight = _s.sH;
				_s.tempVidStageWidth = _s.vidStageWidth;
				_s.tempVidStageHeight = Math.max(0, _s.vidStageHeight);
				
				_s.resizeFinal(resizePlaylistWithAnim);
				if(_s.prevVpW != viewportSize.w || _s.displayType != FWDUVPlayer.STICKY){
					_s.setStageContainerFinalHeightAndPosition(resizePlaylistWithAnim);
				}
			}	

			setTimeout(function(){
				_s.prevVpW = viewportSize.w;
			},50)
		};

		_s.resizeFinal = function(resizePlaylistWithAnim){

			if(_s.displayType != FWDUVPlayer.STICKY && !_s.isMin) _s.stageContainer.style.height = _s.tempStageHeight + "px";

			if(_s.mainBackground_do){
				_s.mainBackground_do.setWidth(_s.ws.w);
				_s.mainBackground_do.setHeight(_s.tempStageHeight);
			}
			
			_s.main_do.setWidth(_s.tempStageWidth);
			_s.videoHolder_do.setWidth(_s.tempVidStageWidth);
			_s.videoHolder_do.setHeight(_s.tempVidStageHeight);
			
			if(_s.showPlaylistButtonAndPlaylist_bl && _s.isPlaylistShowed_bl && _s.playlistPosition_str == "bottom"){
				_s.main_do.setHeight(_s.tempStageHeight);
			}else{
				_s.main_do.setHeight(_s.tempStageHeight);
			}
			
			if(_s.displayType == FWDUVPlayer.LIGHTBOX) _s.lightBox_do.mainLightBox_do.setY(parseInt((_s.ws.h - _s.tempStageHeight)/2));
			
			if(_s.audioScreen_do && _s.videoType_str == FWDUVPlayer.MP3){
				_s.audioScreen_do.resizeAndPosition(_s.tempVidStageWidth, _s.tempVidStageHeight);
			}
			
			if(_s.ytb_do && _s.videoType_str == FWDUVPlayer.YOUTUBE){
				_s.ytb_do.setWidth(_s.tempVidStageWidth);
				_s.ytb_do.setHeight(_s.tempVidStageHeight);
			}
			
			if(_s.logo_do) _s.logo_do.positionAndResize();
			if(_s.playlist_do && !FWDAnimation.isTweening(_s)){
				_s.playlist_do.resizeAndPosition(resizePlaylistWithAnim);
			}
		
			if(_s.annotations_do){
				if(FWDAnimation.isTweening(_s)){
					_s.annotations_do.position(true);
				}else{
					_s.annotations_do.position(false);
				}
			}

			if(_s.controller_do) _s.controller_do.resizeAndPosition();
			if(_s.categories_do) _s.categories_do.resizeAndPosition();
			
			if(_s.videoScreen_do && (_s.videoType_str == FWDUVPlayer.VIDEO || _s.videoType_str == FWDUVPlayer.HLS_JS || _s.videoType_str == FWDUVPlayer.DASH)){
				_s.finaadsIdeoScreenW = _s.tempVidStageWidth;
				_s.finaadsIdeoScreenH = _s.tempVidStageHeight;
				_s.finaadsIdeoScreenX = _s.finaadsIdeoScreenY = 0;
				
				_s.videoScreen_do.resizeAndPosition(_s.finaadsIdeoScreenW, _s.finaadsIdeoScreenH, _s.finaadsIdeoScreenX, _s.finaadsIdeoScreenY);
			}

			if(_s.isIMA && _s.IMA) _s.IMA.resizeAndPosition();
		
			if(_s.ytb_do && _s.ytb_do.ytb && _s.videoType_str == FWDUVPlayer.YOUTUBE){
				_s.ytb_do.resizeAndPosition();
			}
			
			if(_s.vimeo_do && _s.videoType_str == FWDUVPlayer.VIMEO){
				_s.vimeo_do.resizeAndPosition();
			}
			
			if(_s.preloader_do) _s.positionPreloader();
			if(_s.dClk_do){
				if(_s.is360 && _s.videoType_str == FWDUVPlayer.YOUTUBE){
					_s.dClk_do.setWidth(0);
				}else if(_s.videoType_str == FWDUVPlayer.VIMEO && !_s._d.showDefaultControllerForVimeo_bl){
					_s.dClk_do.setWidth(0);
				}else{
					_s.dClk_do.setWidth(_s.tempVidStageWidth);
					if(_s.isMbl){
						_s.dClk_do.setHeight(_s.tempVidStageHeight);
					}else{
						if(_s.videoType_str == FWDUVPlayer.YOUTUBE && !_s.isAdd_bl){
							_s.dClk_do.setHeight(_s.tempVidStageHeight);
						}else{
							_s.dClk_do.setHeight(_s.tempVidStageHeight);
						}
					}
				}
			}
			
			if(_s.videoHider_do) _s.resizeVideoHider();
			if(_s.lrgPlayBtn) _s.positionLargePlayButton();
			if(_s.videoPoster_do && _s.videoPoster_do.allowToShow_bl) _s.videoPoster_do.positionAndResize();
			if(_s.popw_do && _s.popw_do.isShowed_bl) _s.popw_do.positionAndResize();
			if(_s.embedWindow_do && _s.embedWindow_do.isShowed_bl) _s.embedWindow_do.positionAndResize();
			if(_s.passWindow_do && _s.passWindow_do.isShowed_bl) _s.passWindow_do.positionAndResize();
			if(_s.lg_do && _s.lg_do.isShowed_bl) _s.lg_do.positionAndResize();
			if(_s.infoWindow_do && _s.infoWindow_do.isShowed_bl) _s.infoWindow_do.positionAndResize();
			if(_s.info_do && _s.info_do.isShowed_bl) _s.info_do.positionAndResize();
			if(_s.shareWindow_do && _s.shareWindow_do.isShowed_bl) _s.shareWindow_do.positionAndResize();
			if(_s.adsStart_do && _s.isAdd_bl) _s.positionAds();
			if(_s.subtitle_do) _s.subtitle_do.position(resizePlaylistWithAnim);
			if(_s.popupAds_do) _s.popupAds_do.position(resizePlaylistWithAnim);
			_s.positionAdsImage();
			
			_s.positionOnMin();
			
		};
		
		_s.setStageContainerFinalHeightAndPosition = function(animate){
			if(_s.displayType != FWDUVPlayer.STICKY) return;
			
			_s.allowToResizeAndPosition_bl = true;
			clearTimeout(_s.showPlaylistWithDelayId_to);
			
			if(_s.horizontalPosition_str == FWDUVPlayer.LEFT){
				_s.main_do.setX(_s.offsetX);
				if(_s.opener_do){
					if(_s._d.openerAlignment_str == "right"){
						_s.opener_do.setX(Math.round(_s.sW - _s.opener_do.w + _s.offsetX));
					}else{
						_s.opener_do.setX(_s.offsetX);
					}
				}
			}else if(_s.horizontalPosition_str == FWDUVPlayer.CENTER){
				_s.main_do.setX(Math.round((_s.ws.w - _s.sW)/2));
				if(_s.opener_do){
					if(_s._d.openerAlignment_str == "right"){
						_s.opener_do.setX(parseInt((_s.ws.w - _s.sW)/2) + _s.sW - _s.opener_do.w);
					}else{
						_s.opener_do.setX(_s.main_do.x);
					}
				}
			}else if(_s.horizontalPosition_str == FWDUVPlayer.RIGHT){
				_s.main_do.setX(Math.round(_s.ws.w - _s.sW - _s.offsetX));
				if(_s.opener_do){
					if(_s._d.openerAlignment_str == "right"){
						_s.opener_do.setX(Math.round(_s.ws.w - _s.opener_do.w - _s.offsetX));
					}else{
						_s.opener_do.setX(Math.round(_s.ws.w - _s.sW - _s.offsetX));
					}
				}
			}
		
			if(animate){		
				if(_s.position_str ==  FWDUVPlayer.POSITION_TOP){
					if(_s.isShowed_bl && !_s.isShowedFirstTime_bl){
						FWDAnimation.to(_s.stageContainer, .8, {css:{top:_s.offsetY}, ease:Expo.easeInOut});
					}else{
						FWDAnimation.to(_s.stageContainer, .8, {css:{top:-_s.sH}, ease:Expo.easeInOut});
					}
					
					if(_s.isShowedFirstTime_bl){
						if(_s.opener_do) FWDAnimation.to(_s.opener_do, .8, {y:_s.sH - _s.opener_do.h, ease:Expo.easeInOut});
					}else{
						if(_s.opener_do) FWDAnimation.to(_s.opener_do, .8, {y:_s.sH, ease:Expo.easeInOut});
					}
				}else{
					if(_s.isShowed_bl && !_s.isShowedFirstTime_bl){
						FWDAnimation.to(_s.stageContainer, .8, {css:{top:_s.ws.h - _s.sH - _s.offsetY}, ease:Expo.easeInOut});
					}else{
						FWDAnimation.to(_s.stageContainer, .8, {css:{top:_s.ws.h}, ease:Expo.easeInOut, onComplete:_s.moveWheyLeft});
					}
					
					if(_s.isShowedFirstTime_bl){
						if(_s.opener_do) FWDAnimation.to(_s.opener_do, .8, {y:0, ease:Expo.easeInOut});
					}else{
						if(_s.opener_do) FWDAnimation.to(_s.opener_do, .8, {y:-_s.opener_do.h, ease:Expo.easeInOut});
					}
				}
			}else{
				FWDAnimation.killTweensOf(_s.stageContainer);
				if(_s.position_str ==  FWDUVPlayer.POSITION_TOP){
					if(_s.isShowed_bl && !_s.isShowedFirstTime_bl){
						_s.stageContainer.style.top = _s.offsetY + "px";
					}else{
						_s.stageContainer.style.top = -_s.sH + "px";
					}
					if(_s.isShowedFirstTime_bl){
						if(_s.opener_do) _s.opener_do.setY(_s.sH - _s.opener_do.h);
					}else{
						if(_s.opener_do) _s.opener_do.setY(_s.sH);
					}
				}else{
					
					if(_s.isShowed_bl && !_s.isShowedFirstTime_bl){
						_s.stageContainer.style.top = (_s.ws.h - _s.sH - _s.offsetY) + "px";
					}else{
						_s.stageContainer.style.top = _s.ws.h + "px";
					}
					
					if(_s.isShowedFirstTime_bl){
						if(_s.opener_do) _s.opener_do.setY(0);
					}else{
						if(_s.opener_do) _s.opener_do.setY(-_s.opener_do.h);
					}
				}
			}
		}
		
		
		//###############################################//
		/* Setup click screen */
		//###############################################//
		_s.setupClickScreen = function(){
			_s.dClk_do = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.dClk_do.setBkColor("rgba(255,0,0,.00001");
			}
			
			if(_s.hasPointerEvent_bl){
				_s.dClk_do.screen.addEventListener("pointerdown", _s.playPauseDownHandler);
				_s.dClk_do.screen.addEventListener("pointerup", _s.playPauseClickHandler);
				_s.dClk_do.screen.addEventListener("pointermove", _s.playPauseMoveHandler);
			}else{	
				if(!_s.isMbl){
					_s.dClk_do.screen.addEventListener("mousedown", _s.playPauseDownHandler);
					_s.dClk_do.screen.addEventListener("mouseup", _s.playPauseClickHandler);
					_s.dClk_do.screen.addEventListener("mousemove", _s.playPauseMoveHandler);
				}else{
					_s.dClk_do.screen.addEventListener("click", _s.playPauseClickHandler);
				}
			}
			
			_s.hideClickScreen();
			_s.videoHolder_do.addChild(_s.dClk_do);
		};
		
		_s.playPauseDownHandler = function(e){
			_s.isClickHandlerMoved_bl = false;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			_s.firstDommyTapX = vc.screenX;
			_s.firstDommyTapY = vc.screenY;
			if(_s.is360) _s.dClk_do.getStyle().cursor = 'url(' + _s._d.grabPath_str + '), default';
		}
		
		_s.playPauseMoveHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			var dx;
			var dy;
			
			if(e.touches && e.touches.length != 1) return;
			dx = Math.abs(vc.screenX - _s.firstDommyTapX);   
			dy = Math.abs(vc.screenY - _s.firstDommyTapY); 
			
			if(_s.isMbl && (dx > 10 || dy > 10)){
				_s.isClickHandlerMoved_bl = true;
			}else if(!_s.isMbl && (dx > 2 || dy > 2)){
				_s.isClickHandlerMoved_bl = true;
			}
		}
		
		_s.playPauseClickHandler = function(e){
			if(_s.is360) _s.dClk_do.getStyle().cursor = 'url(' + _s._d.handPath_str + '), default';
			if(e.button == 2) return;
			if(_s.isClickHandlerMoved_bl) return;
			if(_s.isAdd_bl){
				
				if(_s._d.adsPageToOpenURL_str && _s._d.adsPageToOpenURL_str != "none"){
					if(_s.ClickTracking) _s.executeVastEvent(_s.ClickTracking);
					window.open(_s._d.adsPageToOpenURL_str, _s._d.adsPageToOpenTarget_str);
					_s.pause();
				}
				return;
			}
			
			if(_s.disableClick_bl) return;
			_s.firstTapPlaying_bl = _s.isPlaying_bl;
			
			FWDUVPlayer.keyboardCurInstance = _s;
			
			if(_s.controller_do && _s.controller_do.mainHld.y != 0 && _s.isMbl) return;
			
			if(!_s.isMbl){
				if(FWDUVPlayer.videoStartBehaviour == FWDUVPlayer.PAUSE_ALL_VIDEOS){
					FWDUVPlayer.pauseAllVideos(_s);
				}else if(FWDUVPlayer.videoStartBehaviour == FWDUVPlayer.STOP_ALL_VIDEOS){
					FWDUVPlayer.stopAllVideos(_s);
				}
			}
			
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
				_s.ytb_do.togglePlayPause();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				_s.audioScreen_do.togglePlayPause();
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO){
				_s.vimeo_do.togglePlayPause();
			}else{
				if(_s.videoScreen_do) _s.videoScreen_do.togglePlayPause();	
			}
		};
		
		_s.showClickScreen = function(){
			_s.dClk_do.setVisible(true);
			if(_s.isAdd_bl && _s._d.adsPageToOpenURL_str && _s._d.adsPageToOpenURL_str != "none"){
				_s.dClk_do.setButtonMode(true);
			}else{	
				if(_s.is360){
					_s.dClk_do.getStyle().cursor = 'url(' + _s._d.handPath_str + '), default';
				}else{
					_s.dClk_do.setButtonMode(false);
				}
			}
		};
		
		_s.hideClickScreen = function(){
			_s.dClk_do.setVisible(false);
		};
		

		//#####################################//
		/* Setup disable click */
		//#####################################//
		_s.setupDisableClick = function(){
			_s.disableClick_do = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.disableClick_do.setBkColor('rgba(0,255,0,.0001');
			}
			_s.main_do.addChild(_s.disableClick_do);
			
		};
		
		_s.disableClick = function(){
			_s.disableClick_bl = true;
			clearTimeout(_s.disableClickId_to);
			if(_s.disableClick_do){
				_s.disableClick_do.setWidth(_s.sW);
				_s.disableClick_do.setHeight(_s.sH);
			}
			_s.disableClickId_to =  setTimeout(function(){
				if(_s.disableClick_do){
					_s.disableClick_do.setWidth(0);
					_s.disableClick_do.setHeight(0);
				}
				_s.disableClick_bl = false;
			}, 500);
		};
		
		_s.showDisable = function(){
			_s.disableClick_do.setWidth(_s.sW);
			_s.disableClick_do.setHeight(_s.sH);
		};
		
		_s.hideDisable = function(){
			if(!_s.disableClick_do) return;
			if(_s.disableClick_do.w == 0) return;
			_s.disableClick_do.setWidth(0);
			_s.disableClick_do.setHeight(0);
		};

		
		//########################################//
		/* add double click and tap support */
		//########################################//
		_s.addDoubleClickSupport = function(){
			
			if(_s.hasPointerEvent_bl){
				_s.dClk_do.screen.addEventListener("pointerdown", _s.onFirstDown);
			}else{
				if(!_s.isMbl){
					_s.dClk_do.screen.addEventListener("mousedown", _s.onFirstDown);
				}
				_s.dClk_do.screen.addEventListener("touchstart", _s.onFirstDown);
			}
			_s.setupVisualization();
		};
		
		_s.onFirstDown = function(e){
			if(e.button == 2) return;
			if(_s.isFullscreen_bl && e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			_s.firstTapX = vc.screenX - _s.main_do.getGlobalX();
			_s.firstTapY = vc.screenY - _s.main_do.getGlobalY();
		
			_s.firstTapPlaying_bl = _s.isPlaying_bl;
			
			if(FWDUVPUtils.isIEWebKit) return;
			if(_s.hasPointerEvent_bl){
				
				_s.dClk_do.screen.removeEventListener("pointerdown", _s.onFirstDown);
				_s.dClk_do.screen.addEventListener("pointerdown", _s.onSecondDown);
			}else{
				if(!_s.isMbl){
					_s.dClk_do.screen.addEventListener("mousedown", _s.onSecondDown);
					_s.dClk_do.screen.removeEventListener("mousedown", _s.onFirstDown);
				}
				_s.dClk_do.screen.addEventListener("touchstart", _s.onSecondDown);
				_s.dClk_do.screen.removeEventListener("touchstart", _s.onFirstDown);
			}
			clearTimeout(_s.secondTapId_to);
			_s.secondTapId_to = setTimeout(_s.doubleTapExpired, 500);
		};
		
		_s.doubleTapExpired = function(){
			clearTimeout(_s.secondTapId_to);
			if(_s.hasPointerEvent_bl){
				_s.dClk_do.screen.removeEventListener("pointerdown", _s.onSecondDown);
				_s.dClk_do.screen.addEventListener("pointerdown", _s.onFirstDown);
			}else{
				_s.dClk_do.screen.removeEventListener("touchstart", _s.onSecondDown);
				_s.dClk_do.screen.addEventListener("touchstart", _s.onFirstDown);
				if(!_s.isMbl){
					_s.dClk_do.screen.removeEventListener("mousedown", _s.onSecondDown);
					_s.dClk_do.screen.addEventListener("mousedown", _s.onFirstDown);
				}
			}
		};
		
		_s.onSecondDown = function(e){
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			var dx;
			var dy;
			
			if(FWDUVPUtils.isIEWebKit) _s.firstTapPlaying_bl = _s.isPlaying_bl;
			if(e.touches && e.touches.length != 1) return;
			dx = Math.abs((vc.screenX - _s.main_do.getGlobalX()) - _s.firstTapX);   
			dy = Math.abs((vc.screenY - _s.main_do.getGlobalY()) - _s.firstTapY); 
			if(dx > 10 || dy > 10) return;

			if(_s.firstTapX < _s.tempVidStageWidth * 0.33){
				if(!_s.isPlaying_bl){
					_s.skipOnDb_bl = true;
					_s.rewind(_s._d.rewTm);
					_s.addVisualization('left');
					setTimeout(function(){
						if(!_s.isPlaying_bl) _s.play();
					}, 200);
					setTimeout(function(){
						_s.skipOnDb_bl = false;
					}, 500);
				} 
			}else if(_s.firstTapX > _s.tempVidStageWidth * 0.67){
					if(!_s.isPlaying_bl){
						_s.skipOnDb_bl = true;
						_s.rewind(- _s._d.rewTm);
						_s.addVisualization('right');
						setTimeout(function(){
							if(!_s.isPlaying_bl) _s.play();
						}, 200);
						setTimeout(function(){
							_s.skipOnDb_bl = false;
						}, 500);
				} 
			}else{
				_s.switchFullScreenOnDoubleClick();
				if(_s.firstTapPlaying_bl){
					_s.play();
				}else{
					_s.pause();
				}
			}
		};
		
		_s.switchFullScreenOnDoubleClick = function(){
			_s.disableClick();
			if(!_s.isFullScreen_bl){
				_s.goFullScreen();
			}else{
				_s.goNormalScreen();
			}
		};


		//############################################//
		/* Setup double click visualization */
		//############################################//
		_s.lasPosition;
		_s.setupVisualization = function(){
			_s.mainVz_do = new FWDUVPDisplayObject('div');
			_s.mainVz_do.getStyle().pointerEvents = 'none';
			_s.mainVz_do.getStyle().backgroundColor = 'rgba(0,0,0,0.01)';
			_s.mainVzBackgrond_do = new FWDUVPDisplayObject('div');
			_s.mainVzBackgrond_do.getStyle().width = '100%';
			_s.mainVzBackgrond_do.getStyle().height = '100%';
			_s.mainVzBackgrond_do.getStyle().backgroundColor = 'rgba(255,255,255, .15)';
			_s.mainVz_do.getStyle().borderRadius = '100%';
			_s.mainVz_do.addChild(_s.mainVzBackgrond_do);

			_s.circle_do = new FWDUVPTransformDisplayObject('div');
			_s.circle_do.getStyle().backgroundColor = 'rgba(255,255,255, .15)';
			_s.circle_do.getStyle().borderRadius = '100%';
			_s.mainVz_do.addChild(_s.circle_do);

			var vzImg1 = new Image();
			vzImg1.src = _s.mainFolderPath_str + _s.sknPth + 'vis.png';
			_s.vzImg1_do = new FWDUVPTransformDisplayObject('img');
			_s.vzImg1_do.setScreen(vzImg1);
			_s.vzImg1_do.setWidth(17);
			_s.vzImg1_do.setHeight(23);
			_s.mainVz_do.addChild(_s.vzImg1_do);

			var vzImg2 = new Image();
			vzImg2.src = _s.mainFolderPath_str + _s.sknPth + 'vis.png';
			_s.vzImg2_do = new FWDUVPTransformDisplayObject('img');
			_s.vzImg2_do.setScreen(vzImg2);
			_s.vzImg2_do.setWidth(17);
			_s.vzImg2_do.setHeight(23);
			_s.mainVz_do.addChild(_s.vzImg2_do);

			var vzImg3 = new Image();
			vzImg3.src = _s.mainFolderPath_str + _s.sknPth + 'vis.png';
			_s.vzImg3_do = new FWDUVPTransformDisplayObject('img');
			_s.vzImg3_do.setScreen(vzImg3);
			_s.vzImg3_do.setWidth(17);
			_s.vzImg3_do.setHeight(23);
			_s.mainVz_do.addChild(_s.vzImg3_do);
		}

		_s.addVisualization = function(pos){
			clearTimeout(_s.vizFinisedId_to);
			clearTimeout(_s.vizFinished2Id_to);
			var w = Math.round(_s.tempVidStageWidth/2);
			var h = Math.round(_s.tempVidStageHeight * 1.5);

			FWDAnimation.killTweensOf(_s.mainVzBackgrond_do);
			if(_s.lasPosition != pos) _s.mainVzBackgrond_do.setAlpha(0);
			FWDAnimation.to(_s.mainVzBackgrond_do, .4, {alpha:1});

			_s.mainVz_do.setVisible(true);
			_s.mainVz_do.setWidth(w);
			_s.mainVz_do.setHeight(h);
			_s.mainVz_do.setY((_s.tempVidStageHeight - h)/2);
			var offsetY = Math.abs(_s.mainVz_do.y);
			if(_s.controller_do && _s.controller_do.isShowed_bl) offsetY -= _s.controller_do.sH/2;
			if(!_s.videoHolder_do.contains(_s.mainVz_do)){
				if(_s.controller_do){
					_s.videoHolder_do.addChildAt(_s.mainVz_do, _s.videoHolder_do.getChildIndex(_s.controller_do) - 1);
				}else{
					_s.videoHolder_do.addChild(_s.mainVz_do);
				}
			} 
			if(pos == 'right'){
				_s.mainVz_do.getStyle().borderRadius = '100% 0% 0% 100%';
				_s.mainVz_do.setX(w);
				_s.vzImg1_do.setRotation(0);
				_s.vzImg2_do.setRotation(0);
				_s.vzImg3_do.setRotation(0);
			}else{
				_s.mainVz_do.getStyle().borderRadius = '0% 100% 100% 0%';
				_s.mainVz_do.setX(0);
				_s.vzImg1_do.setRotation(180);
				_s.vzImg2_do.setRotation(180);
				_s.vzImg3_do.setRotation(180);
			}

			_s.vzImg1_do.setX(Math.round(w - (_s.vzImg1_do.w * 3))/2);
			_s.vzImg1_do.setY(Math.round(offsetY + (_s.tempVidStageHeight - _s.vzImg1_do.h)/2));
			_s.vzImg2_do.setX(_s.vzImg1_do.x + _s.vzImg1_do.w);
			_s.vzImg2_do.setY(_s.vzImg1_do.y);
			_s.vzImg3_do.setX(_s.vzImg2_do.x + _s.vzImg2_do.w);
			_s.vzImg3_do.setY(_s.vzImg2_do.y);
			
			FWDAnimation.killTweensOf(_s.vzImg1_do);
			FWDAnimation.killTweensOf(_s.vzImg2_do);
			FWDAnimation.killTweensOf(_s.vzImg3_do);
			_s.vzImg1_do.setAlpha(0);
			_s.vzImg2_do.setAlpha(0);
			_s.vzImg3_do.setAlpha(0);
			if(pos == 'right'){
				FWDAnimation.to(_s.vzImg1_do, .4, {alpha:1});
				FWDAnimation.to(_s.vzImg1_do, .4, {alpha:0, delay:.3});
				FWDAnimation.to(_s.vzImg2_do, .4, {alpha:1, delay:.3});
				FWDAnimation.to(_s.vzImg2_do, .4, {alpha:0, delay:.6});
				FWDAnimation.to(_s.vzImg3_do, .4, {alpha:1, delay:.6});
				FWDAnimation.to(_s.vzImg3_do, .4, {alpha:0, delay:.9});
			}else{
				FWDAnimation.to(_s.vzImg3_do, .4, {alpha:1});
				FWDAnimation.to(_s.vzImg3_do, .4, {alpha:0, delay:.3});
				FWDAnimation.to(_s.vzImg2_do, .4, {alpha:1, delay:.3});
				FWDAnimation.to(_s.vzImg2_do, .4, {alpha:0, delay:.6});
				FWDAnimation.to(_s.vzImg1_do, .4, {alpha:1, delay:.6});
				FWDAnimation.to(_s.vzImg1_do, .4, {alpha:0, delay:.9});
			}

			FWDAnimation.killTweensOf(_s.circle_do);
			_s.circle_do.setAlpha(1);
			_s.circle_do.setScale2(1);
			_s.circle_do.setWidth(w);
			_s.circle_do.setHeight(w);
			_s.circle_do.setScale2(0);
			_s.circle_do.setX(_s.firstTapX - _s.mainVz_do.x - _s.circle_do.w/2);
			_s.circle_do.setY(_s.firstTapY + offsetY - _s.circle_do.w/2);
			FWDAnimation.to(_s.circle_do, .8, {scale:2, ease:Expo.easeInOut});

			_s.vizFinisedId_to = setTimeout(function(){
				FWDAnimation.to(_s.mainVzBackgrond_do, .4, {alpha:0});
				FWDAnimation.to(_s.circle_do, .4, {alpha:0});
				_s.vizFinished2Id_to = setTimeout(function(){
					_s.mainVz_do.setVisible(false);
				}, 400)
			}, 800);

			_s.lasPosition = pos;
		}

		_s.stopVisualization =  function(){
			if(!_s.mainVz_do) return;
			clearTimeout(_s.vizFinisedId_to);
			clearTimeout(_s.vizFinished2Id_to);
			_s.mainVz_do.setVisible(false);
		}
		

		//############################################//
		/* Setup video hider */
		//############################################//
		_s.setupVideoHider = function(){
			_s.videoHider_do = new FWDUVPDisplayObject("div");
			_s.videoHolder_do.addChild(_s.videoHider_do);
		};
		
		_s.showVideoHider = function(){
			if(_s.isVideoHiderShowed_bl || !_s.videoHider_do) return;
			_s.isVideoHiderShowed_bl = true;
			_s.videoHider_do.setVisible(true);
			_s.resizeVideoHider();
		};
		
		_s.hideVideoHider = function(){
			if(!_s.isVideoHiderShowed_bl) return;
			_s.isVideoHiderShowed_bl = false;
			clearTimeout(_s.videoHilderId_to);
			_s.videoHilderId_to = setTimeout(function(){
				_s.videoHider_do.setVisible(false);
			}, 300);
		};
		
		_s.resizeVideoHider = function(){
			if(_s.isVideoHiderShowed_bl){
				_s.videoHider_do.setWidth(_s.tempStageWidth);
				_s.videoHider_do.setHeight(_s.tempStageHeight);
			}
		};
		

		//############################################//
		/* Setup youtube player */
		//############################################//
		_s.setupYoutubeAPI = function(){
			if(_s.ytb_do) return;
			if(typeof YT != "undefined" && YT.Player){
				_s.setupYoutubePlayer();
				return;
			}else{
				if(FWDUVPlayer.isYoutubeAPILoadedOnce_bl){
					_s.keepCheckingYoutubeAPI_int =  setInterval(function(){
						if(typeof YT != "undefined" && YT && YT.Player){
							if(_s.videoSourcePath_str.indexOf("youtube.") == -1) clearInterval(_s.keepCheckingYoutubeAPI_int);
							clearInterval(_s.keepCheckingYoutubeAPI_int);
							_s.setupYoutubePlayer();
						}
					}, 50);
					return;
				}
				
				var tag = document.createElement("script");
				tag.src = "https://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName("script")[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			
				tag.onload = function(){
					_s.checkIfYoutubePlayerIsReadyId_int = setInterval(function(){
						if(YT && YT.Player){
							clearInterval(_s.checkIfYoutubePlayerIsReadyId_int);
							_s.setupYoutubePlayer();
						}
					}, 50);
				}
				
				tag.onerror = function(){
					setTimeout(function(){
						_s.showSourceError("Error loading Youtube API");
					}, 500);
					return;
				}
				
				FWDUVPlayer.isYoutubeAPILoadedOnce_bl = true;
			}
		};
		
		_s.setupYoutubePlayer = function(){
			if(_s.ytb_do) return;
			
			
			FWDUVPYoutubeScreen.setPrototype();
			_s.ytb_do = new FWDUVPYoutubeScreen(_s, _s._d.volume);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.READY, _s.youtubeReadyHandler);
			_s.ytb_do.addListener(FWDUVPVideoScreen.ERROR, _s.videoScreenErrorHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.SAFE_TO_SCRUBB, _s.videoScreenSafeToScrubbHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.STOP, _s.videoScreenStopHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.PLAY, _s.videoScreenPlayHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.PAUSE, _s.videoScreenPauseHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.UPDATE, _s.videoScreenUpdateHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.UPDATE_TIME, _s.videoScreenUpdateTimeHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.LOAD_PROGRESS, _s.videoScreenLoadProgressHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.PLAY_COMPLETE, _s.videoScreenPlayCompleteHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.CUED, _s.youtubeScreenCuedHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.QUALITY_CHANGE, _s.youtubeScreenQualityChangeHandler);
			_s.ytb_do.addListener(FWDUVPYoutubeScreen.UPDATE_SUBTITLE, _s.videoScreenUpdateSubtitleHandler);

			if(!_s.isMobile_bl) _s.ytb_do.showDisable();
		};
		
		_s.youtubeReadyHandler = function(e){
			
			_s.isYoutubeReady_bl = true;
		
			_s.hidePreloaderId_to = setTimeout(function(){
				if(_s.preloader_do) _s.preloader_do.hide(true);}
			, 50);
			
			_s.isTempYoutubeAdd_bl = _s.isAdd_bl;
			if(_s.isAdd_bl){
				if(_s.videoType_str == FWDUVPlayer.YOUTUBE) _s.setSource(_s.addSource_str);
			}else{
				if(_s.videoType_str == FWDUVPlayer.YOUTUBE) _s.updateAds(0, true);
			}
		};
		
		_s.youtubeScreenCuedHandler = function(){
			if(_s.main_do) if(_s.main_do.contains(_s.info_do)) _s.main_do.removeChild(_s.info_do);
		};
		
		_s.youtubeScreenQualityChangeHandler = function(e){
			if(_s.videoType_str == FWDUVPlayer.VIDEO) _s.curDurration = _s.videoScreen_do.curDuration;
			if(_s.controller_do) _s.controller_do.updateQuality(e.levels, e.qualityLevel);
		};

		
		//############################################//
		/* Setup Vimeo API */
		//############################################//
		_s.setupVimeoAPI = function(){
			if(_s.vimeo_do) return;
			if(typeof Vimeo != "undefined" && Vimeo.Player){
				_s.setupVimeoPlayer();
				return;
			}else{
				if(FWDUVPlayer.isVimeoAPILoadedOnce_bl){
					_s.keepCheckingVimeoAPI_int =  setInterval(function(){
						if(typeof Vimeo != "undefined" && Vimeo && Vimeo.Player){
							if(_s.videoSourcePath_str.indexOf("vimeo.") == -1) clearInterval(_s.keepCheckingVimeoAPI_int);
							clearInterval(_s.keepCheckingVimeoAPI_int);
							_s.setupVimeoPlayer();
						}
					}, 50);
					return;
				}
				
				var tag = document.createElement("script");
				tag.src = "https://player.vimeo.com/api/player.js";
				var firstScriptTag = document.getElementsByTagName("script")[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			
				tag.onload = function(){
					_s.keepCheckingVimeoAPI_int = setInterval(function(){
						if(typeof Vimeo != "undefined" && Vimeo && Vimeo.Player){
							clearInterval(_s.keepCheckingVimeoAPI_int);
							_s.setupVimeoPlayer();
						}
					}, 50);
				}
										
				tag.onerror = function(){
					setTimeout(function(){
						_s.showSourceError("Error loading Vimeo API");
					}, 500);
					return;
				}
				
				FWDUVPlayer.isVimeoAPILoadedOnce_bl = true;
			}
		};
		

		//############################################//
		/* Setup Vimeo player */
		//############################################// 
		_s.setupVimeoPlayer = function(){
			if(_s.vimeo_do) return;
			FWDUVPVimeoScreen.setPrototype();

			_s.vimeo_do = new FWDUVPVimeoScreen(_s, _s._d.volume);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.ERROR, _s.vimeoInitErrorHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.READY, _s.vimeoReadyHandler);
			
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.SAFE_TO_SCRUBB, _s.videoScreenSafeToScrubbHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.STOP, _s.videoScreenStopHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.PLAY, _s.videoScreenPlayHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.PAUSE, _s.videoScreenPauseHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.UPDATE, _s.videoScreenUpdateHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.UPDATE_TIME, _s.videoScreenUpdateTimeHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.LOAD_PROGRESS, _s.videoScreenLoadProgressHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.PLAY_COMPLETE, _s.videoScreenPlayCompleteHandler);
			_s.vimeo_do.addListener(FWDUVPVimeoScreen.UPDATE_SUBTITLE, _s.videoScreenUpdateSubtitleHandler);
			
		};
		
		_s.vimeoInitErrorHandler = function(e){
			_s.showSourceError(e.error);
		};
		
		_s.vimeoReadyHandler = function(e){
			_s.isVimeoReady_bl = true;
	
			clearInterval(_s.hidePreloaderId_to);
			_s.hidePreloaderId_to = setTimeout(function(){
				if(_s.preloader_do) _s.preloader_do.hide(true);}
			, 50);
		
			if(_s.isAdd_bl){
				if(_s.videoType_str == FWDUVPlayer.VIMEO) _s.setSource(_s.addSource_str);
			}else{
				if(_s.videoType_str == FWDUVPlayer.VIMEO) _s.updateAds(0, true);
			}
		};		

		
		//#############################################//
		/* setup context menu */
		//#############################################//
		_s.setupContextMenu = function(){
			FWDUVPContextMenu.setPrototype();
			_s.customContextMenu_do = new FWDUVPContextMenu(_s, _s._d);
		};


		//#############################################//
		/* setup RSM */
		//#############################################//
		_s.setupRSM = function(){
			window.addEventListener("beforeunload", function (e) {
				var test = Math.random() * 1000;
				if(_s.isPlaying_bl && !_s.isAdd_bl){
					document.cookie = "fwduvp_video_path=" + _s.videoSourcePath_str + "; expires=Thu, 18 Dec 2040 00:00:01 GMT; path=/";
					var curTime = _s.getCurrentTime();
					if(curTime.length == 5) curTime = "00:" + curTime;
					document.cookie = "fwduvp_time=" + curTime + "; expires=Thu, 18 Dec 2040 00:00:01 GMT; path=/";	
				}
			});
		};
		
		
		//#############################################//
		/* setup _d */
		//#############################################//
		_s.setupData = function(){
			FWDUVPData.setPrototype();
			_s._d = new FWDUVPData(_s.props, _s.rootElement_el, _s);
			_s._d.useYoutube_bl = _s.useYoutube_bl;
			
			if(_s.mainBackground_do) _s.mainBackground_do.getStyle().background = "url('" + _s.mainBackgroundImagePath_str + "')";
			
			_s._d.addListener(FWDUVPData.VAST_LOADED, _s.vastLoaded);
			_s._d.addListener(FWDUVPData.PRELOADER_LOAD_DONE, _s.onPreloaderLoadDone);
			_s._d.addListener(FWDUVPData.LOAD_ERROR, _s._dLoadError);
			_s._d.addListener(FWDUVPData.SKIN_PROGRESS, _s._dSkinProgressHandler);
			_s._d.addListener(FWDUVPData.SKIN_LOAD_COMPLETE, _s._dSkinLoadComplete);
			_s._d.addListener(FWDUVPData.PLAYLIST_LOAD_COMPLETE, _s._dPlayListLoadComplete);
			_s._d.addListener(FWDUVPData.IMA_READY, _s._dImaReady);
			_s._d.addListener(FWDUVPData.IMA_ERROR, _s._dImaError);
			
		};
		
		_s.vastLoaded = function(e){
			_s.isAdd_bl = false
			_s.isVastLoading_bl = false;
			_s._d.playlist_ar[_s.id].popupAds_ar = e.popupAds;
			_s._d.playlist_ar[_s.id].ads_ar = e.ads;
			_s.adsId = -1;
			_s.updateAds(0);
			_s.dispatchEvent(FWDUVPData.VAST_LOADED);
		}
	
		_s.onPreloaderLoadDone = function(){
			if(_s.showPreloader_bl) _s.setupPreloader();
			if(!_s.isMbl) _s.setupContextMenu();
			_s.fillEntireVideoScreen_bl = _s._d.fillEntireVideoScreen_bl;
			_s.resizeHandler();
		};
		
		_s._dLoadError = function(e){
			_s.showSourceError(e.text);
			if(_s.playlist_do) _s.playlist_do.catId = -1;
			_s.dispatchEvent(FWDUVPlayer.ERROR, {error:e.text});
		};
		
		_s._dSkinProgressHandler = function(e){};
		
		_s._dSkinLoadComplete = function(){
			if(location.protocol.indexOf("file:") != -1){
				if(FWDUVPUtils.isOpera || FWDUVPUtils.isIEAndLessThen9){
					_s.showSourceError("This browser can't play video local, please test online or use a browser like Firefox of Chrome.");
					return;
				}
			}

			if(_s.showOnlyThumbnail){
				_s.playlistWidth = _s.playListThumbnailWidth;
			}
			
			_s.volume = _s._d.volume;
			_s.playlistHeight = _s._d.playlistBottomHeight;
			
			if(_s.displayType == FWDUVPlayer.FULL_SCREEN  && !FWDUVPUtils.hasFullScreen){
				_s._d.showFullScreenButton_bl = false;
			}
		
			if(_s.isEmbedded_bl){
				_s.useDeepLinking_bl = false;
				_s._d.playlistPosition_str = "right";
			}
			
			if(FWDUVPlayer.atLeastOnePlayerHasDeeplinking_bl) _s.useDeepLinking_bl = false;
			if(_s.useDeepLinking_bl) FWDUVPlayer.atLeastOnePlayerHasDeeplinking_bl = true;
			
			if(_s.useDeepLinking_bl){
				setTimeout(function(){_s.setupDL();}, 200);
			}else{
				if(_s.isEmbedded_bl){
					_s.catId = _s.embeddedPlaylistId;
					_s.id = _s.embeddedVideoId;
				}else{
					var args = FWDUVPUtils.getHashUrlArgs(window.location.hash);
					if(_s.useDeepLinking_bl && args.playlistId !== undefined && args.videoId !== undefined){
						_s.catId = args.playlistId;
						_s.id = args.videoId;
					}else{
						if(args.videoId){
							_s.id = args.videoId;
						}else{
							_s.id = _s._d.startAtVideo;
						}

						if(args.playlistId){
							_s.catId = args.playlistId;
						}else{
							_s.catId = _s._d.startAtPlaylist;
						}
						
					}
				}
				_s.loadInternalPlaylist();
			}
		};
		
		_s._dPlayListLoadComplete = function(){
			if(_s._d.cats_ar[_s.catId].pass) _s.playlistPass = _s._d.cats_ar[_s.catId].pass;
			
			_s.loadAddFirstTime_bl = true;
			if(!_s.isPlaylistLoadedFirstTime_bl){
				_s.setupNormalVideoPlayers();
				if(!FWDUVPUtils.isIEAndLessThen9) _s.updatePlaylist();
			}
			
			if(_s.isPlaylistLoadedFirstTime_bl) _s.updatePlaylist();	
			_s.isPlaylistLoaded_bl = true;
			_s.videoHolder_do.setY(0);
			_s.resizeHandler();
			setTimeout(function(){
				_s.positionLargePlayButton();
				if(_s.controller_do) _s.controller_do.resizeAndPosition();
				if(_s.playlist_do) _s.playlist_do.resizeAndPosition();
			}, 350);
		};
		
		_s.updatePlaylist = function(){
			_s.videoType_str =  "none";
			if(!_s._d.playlist_ar || !_s._d.playlist_ar[_s.id]) return;
			
			if(_s.main_do) if(_s.main_do.contains(_s.info_do)) _s.main_do.removeChild(_s.info_do);
			if(_s.preloader_do){
				_s.preloader_do.hide(true);
			} 

			_s.totaadsIdeos = _s._d.playlist_ar.length;
			
	    	if(_s.id < 0){
				_s.id = 0;
			}else if(_s.id > _s.totaadsIdeos - 1){
				_s.id = _s.totaadsIdeos - 1;
			}
			
	    	
			if(_s.playlist_do) _s.playlist_do.updatePlaylist(_s._d.playlist_ar, _s.catId, _s.id, _s._d.cats_ar[_s.catId].playlistName);
			_s.hideVideoHider();
			
			if(_s._d.startAtRandomVideo_bl){
				_s.id = parseInt(Math.random() * _s._d.playlist_ar.length);
				if(_s.useDeepLinking_bl){
					FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + _s.id);
					return;
				}
	    	}
			_s.plPassPassed = false;
			_s.prevSource = Math.random() * 99999999999;
	    	_s.posterPath_str = _s._d.playlist_ar[_s.id].posterSource;
			_s.updateAds(0);
			
			if(_s.isFirstPlaylistLoaded_bl && !_s.isMbl && !_s._d.startAtRandomVideo_bl && _s._d.autoPlay_bl) _s.play();
			_s._d.startAtRandomVideo_bl = false;
			_s.isFirstPlaylistLoaded_bl = true;
			_s.dispatchEvent(FWDUVPlayer.LOAD_PLAYLIST_COMPLETE);
			
			if(_s.displayType == FWDUVPlayer.STICKY){
				setTimeout(function(){
					_s.isShowedFirstTime_bl = false;
					_s.setStageContainerFinalHeightAndPosition(_s.animate_bl);
				}, 50);
			}
		};
		
		_s._dImaReady = function(){
			if(_s.isIMA) _s.setSource(_s.videoSourcePath_str);
		}
		
		_s._dImaError = function(){
			_s.errorImaSDK = true;
			_s.setSource(_s.videoSourcePath_str);
		}

		
		//############################################//
		/* Load playlists */
		//############################################//
		_s.loadInternalPlaylist = function(){
			
			_s.isPlaylistLoaded_bl = false;
			_s.isThumbClick_bl = false;
			_s.playlistPass = false;
			_s.isAdd_bl = false;
			_s.adsId = -1;
			
			_s.prvAdSource = Math.random() * 999999999;
			if(_s.prevCatId == _s.catId) return;
			_s.prevCatId = _s.catId;

			if(_s.preloader_do){
				 _s.positionPreloader();
				 _s.preloader_do.show(false);
			}
		
			_s.stop();
			_s.videoHolder_do.setY(-5000);
			if(_s.hider) _s.hider.stop();
			_s.setPosterSource("none");
			if(_s.videoPoster_do){
				_s.videoPoster_do.id = -1;
				_s.videoPoster_do.hide(true);
			}
		
			if(_s.lrgPlayBtn) _s.lrgPlayBtn.hide();
			if(_s.controller_do) _s.controller_do.hide(false, 10);
			_s.showVideoHider();
			_s._d.resetVastId();
			if(_s.popupAds_do) _s.popupAds_do.resetId();

			_s._d.loadPlaylist(_s.catId);
			if(_s.logo_do) _s.logo_do.hide(false, true);
			if(_s.isAdd_bl){
				_s.adsSkip_do.hide(false);
				_s.adsStart_do.hide(false);
			}
			

			if(_s.playlist_do) _s.playlist_do.destroyPlaylist();
			
			if(_s.isAPIReady_bl) _s.dispatchEvent(FWDUVPlayer.START_TO_LOAD_PLAYLIST);
		};

		
		//############################################//
		/* update deeplink */
		//############################################//
		_s.setupDL = function(){
			_s.initFirstDL = true;
			FWDUVPDL.onChange = _s.dlChangeHandler;
			if(_s.isEmbedded_bl){
				FWDUVPDL.setValue("?playlistId=" + _s.embeddedPlaylistId + "&videoId=" + _s.embeddedVideoId);
			}
			_s.dlChangeHandler();
		};
		
		_s.dlChangeHandler = function(){
			if(_s.hasOpenedInPopup_bl) return;
			
			var mustReset_bl = false;
			
			if(_s.categories_do && _s.categories_do.isOnDOM_bl){
				_s.categories_do.hide();
				return;
			}
			
			_s.prevId = _s.id;
			_s.prevEventCatId = _s.catId;
			
			_s.catId = parseInt(FWDUVPDL.getParameter("playlistId"));
			_s.id = parseInt(FWDUVPDL.getParameter("videoId"));
			
			if(_s.catId == undefined || _s.id == undefined || isNaN(_s.catId) || isNaN(_s.id)){
				_s.catId = _s._d.startAtPlaylist;
				_s.id = _s._d.startAtVideo;
				mustReset_bl = true;
			}
		
			if(_s.catId < 0 || _s.catId > _s._d.totalCategories - 1 && !mustReset_bl){
				_s.catId = _s._d.startAtPlaylist;
				_s.id = _s._d.startAtVideo;
				mustReset_bl = true;
			}
			
			if(_s._d.playlist_ar){
				if(_s.id < 0 && !mustReset_bl){
					_s.id = _s._d.startAtVideo;
					mustReset_bl = true;
				}else if(_s.prevCatId == _s.catId && _s.id > _s._d.playlist_ar.length - 1  && !mustReset_bl){
					_s.id = _s._d.playlist_ar.length - 1;
					mustReset_bl = true;
				}
			}
			_s.totalDuration = 0;
			var curValue = _s.catId +  ' - ' + _s.id;
			if(mustReset_bl){
				FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + _s.id);
				return;
			}
			if(_s.lastValue == curValue) return;
			_s.lastValue = _s.catId +  ' - ' + _s.id;
			
			if(_s.prevId == -1) _s.prevId  = _s.id;
			if(_s.prevEventCatId == -1) _s.prevEventCatId = _s.catId;
			
			if(_s.prevCatId != _s.catId){
				_s.loadInternalPlaylist();
				_s.prevCatId = _s.catId;
			}else{
				_s.stop();
				_s.isThumbClick_bl = true;
				_s.updateAds(0, true);
				_s._d.startAtRandomVideo_bl = false;
			}
			
			_s.pastHref = window['location']['href'];
		};
		
		
		//###########################################//
		/* Setup normal video players */
		//###########################################//
		_s.setupNormalVideoPlayers = function(){
			if(_s.videoScreen_do) return;
			
			_s.isAPIReady_bl = true;
			_s.setupRSM();
			_s.setupVideoScreen();
			_s.setupAudioScreen();
			_s.setupVideoPoster();
			if(_s.preloader_do) _s.main_do.addChild(_s.preloader_do);
			_s.setupSubtitle();
			_s.setupClickScreen();
			_s.setupPopupAds();
			if(_s._d.showLogo_bl) _s.setupLogo();
			_s.addDoubleClickSupport();
			_s.setupVideoHider();
			_s.setupAnnotations();
			if(_s._d.showController_bl) _s.setupController();
			_s.setupAdsStart();
			if(_s._d.showPlaylistButtonAndPlaylist_bl) _s.setupPlaylist();
			_s.setupLargePlayPauseButton();
			if(_s._d.showChromecastButton_bl) _s.setupChormecast();
			if(_s._d.showController_bl) _s.setupHider();
			if(_s._d.showPlaylistsButtonAndPlaylists_bl) _s.setupCategories();
			_s.setupDisableClick();
			if(_s._d.showEmbedButton_bl) _s.setupEmbedWindow();
			_s.setupPasswordWindow();
			if(!_s._d.isLoggedIn_bl && _s._d.showController_bl) _s.setupLoginWindow();
			if(_s._d.showShareButton_bl) _s.setupShareWindow();
			_s.setupAopw();
			if(_s._d.showInfoButton_bl) _s.setupInfoWindow();
			if((_s._d.showOpener_bl && _s.displayType == FWDUVPlayer.STICKY)
				|| (_s._d.stickyOnScrollShowOpener_bl && _s.stickyOnScroll)){
				_s.setupOpener();
			} 

			if(_s._d.useFingerPrintStamp){
				_s.setupFingerPrintStamp();
			}
			
			if(FWDUVPlayer.useYoutube == "no") _s.isPlaylistLoadedFirstTime_bl = true;
			_s.addMinOnScroll();
			_s.isAPIReady_bl = true;
			_s.dispatchEvent(FWDUVPlayer.READY);
			
			if(_s._d.addKeyboardSupport_bl) _s.addKeyboardSupport();
		
		};


		//###########################################//
		/* setup finger print stamp */
		//###########################################//
		_s.setupFingerPrintStamp = function(){
			FWDUVPFPS.setPrototype();
			_s.fps = new FWDUVPFPS(_s)
			_s.videoHolder_do.addChild(_s.fps);
		}
		
		
		//###########################################//
		/* setup opener */
		//###########################################//
		_s.setupOpener = function(){
	
			FWDUVPOpener.setPrototype();
			_s.opener_do = new FWDUVPOpener(_s._d, _s.position_str, _s.isShowed_bl);
			if(FWDUVPUtils.isIEAndLessThen9){
				_s.opener_do.getStyle().zIndex = "2147483634";
			}else{
				_s.opener_do.getStyle().zIndex = "99999999994";
			}
			_s.opener_do.setX(-10000);
			if(_s.isShowed_bl){
				_s.opener_do.showCloseButton();
			}else{
				_s.opener_do.showOpenButton();
			}
			_s.opener_do.addListener(FWDUVPOpener.SHOW, _s.openerShowHandler);
			_s.opener_do.addListener(FWDUVPOpener.HIDE, _s.openerHideHandler);
			_s.opener_do.addListener(FWDUVPController.PLAY, _s.controllerOnPlayHandler);
			_s.opener_do.addListener(FWDUVPController.PAUSE, _s.controllerOnPauseHandler);
			_s.stageContainer.appendChild(_s.opener_do.screen);
			if(_s.stickyOnScroll){
				 _s.opener_do.getStyle().position = 'fixed';
				 document.documentElement.appendChild(_s.opener_do.screen);
			}
		};
		
		_s.openerShowHandler = function(){
			_s.showPlayer();
		};
		
		_s.openerHideHandler = function(){
			_s.hidePlayer();
		};
		

		//#############################################//
		/* setup preloader */
		//#############################################//
		_s.setupPreloader = function(){
			FWDUVPPreloader.setPrototype();
			_s.preloader_do = new FWDUVPPreloader(_s, 'center', 10, _s.preloaderBackgroundColor, _s.preloaderFillColor, 3, 0.8);
			_s.preloader_do.show(false);
			if(_s.showPreloader_bl){
				if(_s.displayType == FWDUVPlayer.STICKY){
					document.documentElement.appendChild(_s.preloader_do.screen);
				}else{
					_s.main_do.addChild(_s.preloader_do);
				}
			}
		};
	
		_s.positionPreloader = function(){
			if(_s.displayType == FWDUVPlayer.STICKY){
				if(!_s.main_do.contains(_s.preloader_do)){
					_s.preloader_do.setX(Math.round((_s.ws.w - _s.preloader_do.w)/2));
					if(_s.position_str == FWDUVPlayer.POSITION_BOTTOM){
						_s.preloader_do.setY(Math.round((_s.ws.h - _s.preloader_do.h) - 10) + FWDUVPUtils.getScrollOffsets().y);
					}else{
						_s.preloader_do.setY(10);
					}
				}else{
					posPreloader();
				}
			}else{
				posPreloader();
			}

			function posPreloader(){
				var x;
				if(!_s.isPlaylistLoaded_bl){
					x = _s.sW;
				}else{
					x = _s.tempVidStageWidth;
				}
				_s.preloader_do.setX(parseInt((x - _s.preloader_do.w)/2));
				_s.preloader_do.setY(parseInt((_s.tempVidStageHeight - _s.preloader_do.h)/2));
			}
		};
		

		//###########################################//
		/* setup categories */
		//###########################################//
		_s.setupCategories = function(){
			FWDUVPCategories.setPrototype();
			_s.categories_do = new FWDUVPCategories(_s._d, _s);
			_s.categories_do.getStyle().zIndex = "2147483647";
			_s.categories_do.addListener(FWDUVPCategories.HIDE_COMPLETE, _s.categoriesHideCompleteHandler);
			if(_s._d.showPlaylistsByDefault_bl){
				_s.showCatWidthDelayId_to = setTimeout(function(){
					_s.showCategories();
				}, 1400);
			};
		};
		
		_s.categoriesHideCompleteHandler = function(e){
			if(_s.controller_do){
				_s.controller_do.setCategoriesButtonState("unselected");
				_s.controller_do.categoriesButton_do.setNormalState(true);
			}
			
			if(_s.useDeepLinking_bl){
				if(_s.categories_do.id != _s.catId){
					_s.catId = _s.categories_do.id;
					_s.id = 0;
					FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + _s.id);
					return;
				}
			}else{
				if(_s.catId == _s.categories_do.id) return;
				_s.catId = _s.categories_do.id;
				_s.id = 0;
				_s.loadInternalPlaylist(_s.catId);
			}
			
			if(_s.isVideoPlayingWhenOpenWindows_bl) _s.resume();
		};
		

		//##########################################//
		/* setup video poster */
		//##########################################//
		_s.setupVideoPoster = function(){
			FWDUVPPoster.setPrototype();
			_s.videoPoster_do = new FWDUVPPoster(_s,  _s._d.show, _s._d.posterBackgroundColor_str);
			_s.videoHolder_do.addChild(_s.videoPoster_do);
		};
		

		//##########################################//
		/* setup info window */
		//##########################################//
		_s.setupInfoWindow = function(){
			FWDUVPInfoWindow.setPrototype();
			_s.infoWindow_do = new FWDUVPInfoWindow(_s, _s._d);
			_s.infoWindow_do.addListener(FWDUVPInfoWindow.HIDE_COMPLETE, _s.infoWindowHideCompleteHandler);
			_s.main_do.addChild(_s.infoWindow_do);
		};
		
		_s.infoWindowHideCompleteHandler = function(){
			
			if(_s.isVideoPlayingWhenOpenWindows_bl) _s.resume();
			
			if(_s.controller_do && !_s.isMbl){
				_s.controller_do.infoButton_do.isDisabled_bl = false;
				_s.controller_do.infoButton_do.setNormalState(true);
			}
		};

		
		//##########################################//
		/* setup chromecast */
		//##########################################//
		_s.setupChormecast = function(){
			if(!_s._d.showController_bl) return;
			FWDUVPCC.setPrototype();
			_s.cc = new FWDUVPCC(_s.controller_do);
		}

		
		//###########################################//
		/* Setup large play / pause button */
		//###########################################//
		_s.setupLargePlayPauseButton = function(){
			if(_s._d.useVectorIcons_bl){				
				FWDUVPSimpleButton.setPrototype();
				_s.lrgPlayBtn = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-play'></span></div>",
						undefined,
						"UVPLargePlayButtonNormalState",
						"UVPLargePlayButtonSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				if(_s.sknPth.indexOf("hex_white") != -1){
					_s.lrgPlayBtn = new FWDUVPSimpleButton(_s._d.largePlayN_img, _s._d.largePlayS_str, undefined, true,
															 _s._d.useHEX,
															 _s._d.nBC,
															 "#FFFFFF",
															 false, false, false, false, true);
				}else{
					_s.lrgPlayBtn = new FWDUVPSimpleButton(_s._d.largePlayN_img, _s._d.largePlayS_str, undefined, true,
															 _s._d.useHEX,
															 _s._d.nBC,
															 _s._d.sBC,
															 false, false, false, false, true);
				}
			}
			
			_s.lrgPlayBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.largePlayButtonUpHandler);
			_s.lrgPlayBtn.setOverflow("visible");
			_s.lrgPlayBtn.hide(false);
			_s.main_do.addChild(_s.lrgPlayBtn);
		};
		
		_s.largePlayButtonUpHandler = function(){
			if(_s.isIMA && _s.IMA && !_s.IMA.isReady) return;
			_s.isThumbClick_bl = true;
			_s.disableClick();
			_s.lrgPlayBtn.hide();
			_s.play();
			if(_s._d.goFullScreenOnPlay_bl) _s.goFullScreen();
		};
		
		_s.positionLargePlayButton =  function(){
			_s.lrgPlayBtn.setX(parseInt((_s.tempVidStageWidth - _s.lrgPlayBtn.w)/2));
			_s.lrgPlayBtn.setY(parseInt((_s.tempVidStageHeight - _s.lrgPlayBtn.h)/2));
		};

		
		//###########################################//
		/* Setup logo */
		//###########################################//
		_s.setupLogo = function(){
			FWDUVPLogo.setPrototype();
			_s.logo_do = new FWDUVPLogo(_s, _s._d.logoPath_str, _s._d.logoPosition_str, _s._d.logoMargins, _s._d.logoTarget);
			_s.main_do.addChild(_s.logo_do);
		};
		

		//###########################################//
		/* Setup playlist */
		//###########################################//
		_s.setupPlaylist = function(){
			FWDUVPPlaylist.setPrototype();
			_s.playlist_do = new FWDUVPPlaylist(_s, _s._d);
			_s.playlist_do.addListener(FWDUVPPlaylist.THUMB_MOUSE_UP, _s.playlistThumbMouseUpHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.PLAY_PREV_VIDEO, _s.playPrevVideoHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.PLAY_NEXT_VIDEO, _s.playNextVideoHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.ENABLE_SHUFFLE, _s.enableShuffleHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.DISABLE_SHUFFLE, _s.disableShuffleHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.ENABLE_LOOP, _s.enableLoopHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.DISABLE_LOOP, _s.disableLoopHandler);
			_s.playlist_do.addListener(FWDUVPPlaylist.CHANGE_PLAYLIST, _s.changePlaylistHandler);
			_s.main_do.addChildAt(_s.playlist_do, 0);
			if(_s._d.useVectorIcons_bl){
				setTimeout(function(){
					_s.playlist_do.resizeAndPosition(true);
				}, 340);
			}
		};
		
		_s.changePlaylistHandler = function(e){
			_s.loadPlaylist(e.id);
		}
		
		_s.playlistThumbMouseUpHandler = function(e){
			if(_s.disableClick_bl) return;
			
			if(_s._d.playlist_ar){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
			_s.totalDuration = 0;
			
			if(_s.useDeepLinking_bl && _s.id != e.id){
				FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + e.id);
				_s.id = e.id;
				_s.isThumbClick_bl = true;
			}else{
				_s.stop();
				_s.id = e.id;
				_s.changeHLS_bl = true;
				_s.isThumbClick_bl = true;
				_s.isAdd_bl = false;
				
				_s.updateAds(0);			
			}
			if(_s._d.goFullScreenOnPlay_bl) _s.goFullScreen();
		};
		
		_s.playPrevVideoHandler = function(){
			_s.isThumbClick_bl = true;
			if(_s._d.shuffle_bl){
				_s.playShuffle();
			}else{
				_s.playPrev();
			}
		};
		
		_s.playNextVideoHandler = function(){
		
			_s.isThumbClick_bl = true;
			if(_s._d.shuffle_bl){
				_s.playShuffle();
			}else{
				_s.playNext();
			}
		};
		
		_s.enableShuffleHandler = function(e){
			_s._d.shuffle_bl = true;
			_s._d.loop_bl = false;
			_s.playlist_do.setShuffleButtonState("selected");
			_s.playlist_do.setLoopStateButton("unselected");
		};
		
		_s.disableShuffleHandler = function(e){
			_s._d.shuffle_bl = false;
			_s.playlist_do.setShuffleButtonState("unselected");
		};
		
		_s.enableLoopHandler = function(e){
			_s._d.loop_bl = true;
			_s._d.shuffle_bl = false;
			_s.playlist_do.setLoopStateButton("selected");
			_s.playlist_do.setShuffleButtonState("unselected");
		};
		
		_s.disableLoopHandler = function(e){
			_s._d.loop_bl = false;
			_s.playlist_do.setLoopStateButton("unselected");
		};


		//###########################################//
		/* Setup autoplay click. */
		//###########################################//
		_s.setupAPT = function(){
			if(!_s.apt && _s._d.autoPlayText && _s._d.autoPlay_bl){
				_s.apt = new FWDUVPTransformDisplayObject('div');
				_s.apt.screen.className = 'fwduvp-autoplay-text';
				_s.apt.setButtonMode(true);
				_s.apt.setInnerHTML(_s._d.autoPlayText + '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M9.4272 0.430497C9.4272 0.267667 9.33293 0.113407 9.18724 0.0448468C9.03298 -0.0322832 8.86158 -0.00657319 8.73303 0.0962667L4.93652 3.12147L9.4272 7.61215V0.430497Z" fill="black"/><path d="M11.8742 11.2702L0.733188 0.129242C0.566073 -0.0378725 0.294404 -0.0378725 0.127289 0.129242C-0.0398256 0.296357 -0.0398256 0.568026 0.127289 0.735141L2.82341 3.43212H2.57231C2.30664 3.43212 2.07525 3.5521 1.92099 3.74064C1.79244 3.88633 1.71531 4.08344 1.71531 4.28912V7.71712C1.71531 8.18847 2.10096 8.57412 2.57231 8.57412H4.56055L8.73413 11.9078C8.81126 11.9678 8.90553 12.0021 8.9998 12.0021C9.05979 12.0021 9.12835 11.985 9.18834 11.9593C9.33403 11.8907 9.4283 11.7364 9.4283 11.5736V10.037L11.2674 11.8761C11.3514 11.9601 11.4611 12.0021 11.5708 12.0021C11.6805 12.0021 11.7902 11.9601 11.8742 11.877C12.0413 11.709 12.0413 11.4382 11.8742 11.2702Z" fill="black"/></g></svg>');
				_s.main_do.addChild(_s.apt);

				_s.apt.screen.addEventListener('click', function(e){
					_s.setVolume(_s._d.volume, true);
				});
			}
			_s.showAPT();
		}

		_s.removeAPT = function(){
			if(_s.apt && _s.main_do.contains(_s.apt)) _s.main_do.removeChild(_s.apt);
			_s.aptRemoved = true;
		}

		_s.hideAPT = function(){
			if(_s.apt) _s.apt.setX(-5000);
		}

		_s.showAPT = function(){
			if(_s.apt && !_s.aptRemoved){
				 _s.apt.setX(0);
				 _s.apt.setScale2(0);
				 FWDAnimation.to(_s.apt, 1, {scale:1, ease:Elastic.easeInOut});
			}
		}
		

		//###########################################//
		/* Setup popup ads */
		//###########################################//
		_s.setupPopupAds = function(){
			FWDUVPPupupAds.setPrototype();
			_s.popupAds_do =  new FWDUVPPupupAds(_s, _s._d);
			_s.videoHolder_do.addChild(_s.popupAds_do);
		};
		
		
		//###########################################//
		/* Setup subtitle */
		//###########################################//
		_s.setupSubtitle = function(){
			FWDUVPSubtitle.setPrototype();
			_s.subtitle_do =  new FWDUVPSubtitle(_s, _s._d);
			_s.subtitle_do.addListener(FWDUVPSubtitle.LOAD_COMPLETE, _s.subtitleLoadComplete);
		};
		
		_s.subtitleLoadComplete = function(){
			_s.subtitle_do.show();
			if(_s.controller_do) _s.controller_do.enableSubtitleButton();
		};
		
		_s.loadSubtitle = function(path){
			if(_s.isCasting){
				_s.cc.loadSubtitle();
				return;
			}
			
			if(_s.controller_do) _s.controller_do.disableSubtitleButton();
			if(path){
				_s.subtitle_do.loadSubtitle(path);
				_s.videoHolder_do.addChildAt(_s.subtitle_do, _s.videoHolder_do.getChildIndex(_s.dClk_do) - 1);
				
			}
		}

		
		//###########################################//
		/* setup controller */
		//###########################################//
		_s.setupController = function(){
			FWDUVPController.setPrototype();
			_s.controller_do = new FWDUVPController(_s._d, _s);
			
			_s.controller_do.addListener(FWDUVPController.CHANGE_AUDIO_TRACKS, _s.audioTracksHanlder);
			_s.controller_do.addListener(FWDUVPController.VR, _s.vrHanlder);
			_s.controller_do.addListener(FWDUVPData.LOAD_ERROR, _s.controllerErrorHandler);
			_s.controller_do.addListener(FWDUVPController.REWIND, _s.rewindHandler);
			_s.controller_do.addListener(FWDUVPController.CHANGE_PLAYBACK_RATES, _s.changePlaybackRateHandler);
			_s.controller_do.addListener(FWDUVPController.CHANGE_SUBTITLE, _s.changeSubtitileHandler);
			_s.controller_do.addListener(FWDUVPController.SHOW_CATEGORIES, _s.showCategoriesHandler);
			_s.controller_do.addListener(FWDUVPController.SHOW_PLAYLIST, _s.showPlaylistHandler);
			_s.controller_do.addListener(FWDUVPController.HIDE_PLAYLIST, _s.hidePlaylistHandler);
			_s.controller_do.addListener(FWDUVPController.PLAY, _s.controllerOnPlayHandler);
			_s.controller_do.addListener(FWDUVPController.PAUSE, _s.controllerOnPauseHandler);
			_s.controller_do.addListener(FWDUVPController.START_TO_SCRUB, _s.controllerStartToScrubbHandler);
			_s.controller_do.addListener(FWDUVPController.SCRUB, _s.controllerScrubbHandler);
			_s.controller_do.addListener(FWDUVPController.STOP_TO_SCRUB, _s.controllerStopToScrubbHandler);
			_s.controller_do.addListener(FWDUVPController.CHANGE_VOLUME, _s.controllerChangeVolumeHandler);
			_s.controller_do.addListener(FWDUVPController.DOWNLOAD_VIDEO, _s.controllerDownloadVideoHandler);
			_s.controller_do.addListener(FWDUVPController.CHANGE_YOUTUBE_QUALITY, _s.controllerChangeYoutubeQualityHandler);
			_s.controller_do.addListener(FWDUVPController.FULL_SCREEN, _s.controllerFullScreenHandler);
			_s.controller_do.addListener(FWDUVPController.NORMAL_SCREEN, _s.controllerNormalScreenHandler);
			_s.controller_do.addListener(FWDUVPPlaylist.PLAY_PREV_VIDEO, _s.playPrevVideoHandler);
			_s.controller_do.addListener(FWDUVPPlaylist.PLAY_NEXT_VIDEO, _s.playNextVideoHandler);
			_s.controller_do.addListener(FWDUVPController.SHOW_EMBED_WINDOW, _s.showEmbedWindowHandler);
			_s.controller_do.addListener(FWDUVPController.SHOW_INFO_WINDOW, _s.showInfoWindowHandler);
			_s.controller_do.addListener(FWDUVPController.SHOW_SHARE_WINDOW, _s.controllerShareHandler);
			_s.controller_do.addListener(FWDUVPController.SHOW_SUBTITLE, _s.showSubtitleHandler);
			_s.controller_do.addListener(FWDUVPController.HIDE_SUBTITLE, _s.hideSubtitleHandler);
			_s.videoHolder_do.addChild(_s.controller_do);
		};

		_s.audioTracksHanlder = function(e){
			if(_s.hlsJS){
				_s.hlsJS.audioTrack = e.id;
			}else{
				_s.videoScreen_do.setAudioTrack(e.id);
			}
		}

		_s.vrHanlder = function(){
			_s.play();
			if(!_s.videoScreen_do.vrSupport_bl){
				_s.videoScreen_do.showVrMessage();
			}else{
				_s.videoScreen_do.startVR();
			}
		}
		
		_s.controllerErrorHandler = function(e){
			_s.showSourceError(e.text);
		}
		
		_s.rewindHandler = function(){
			_s.rewind(_s._d.rewTm);
		}

		_s.rewind = function(offset){
			var curTime = _s.getCurrentTime();
			if(curTime.length == 5) curTime = "00:" + curTime;
			if(curTime.length == 7) curTime = "0" + curTime;
			curTime = FWDUVPUtils.getSecondsFromString(curTime);
			curTime -= offset;
			curTime = FWDUVPUtils.formatTime(curTime);
			if(curTime.length == 5) curTime = "00:" + curTime;
			if(curTime.length == 7) curTime = "0" + curTime;
			_s.scrubbAtTime(curTime);
		}
		
		_s.changePlaybackRateHandler = function(e){
			_s.setPlaybackRate(e.rate);
		}
		
		_s.changeSubtitileHandler = function(e){
			_s._d.playlist_ar[_s.id].startAtSubtitle = e.id;
			_s.controller_do.updateSubtitleButtons(_s._d.playlist_ar[_s.id].subtitleSource, _s._d.playlist_ar[_s.id].startAtSubtitle);
			_s.ccSS = Number(_s._d.playlist_ar[_s.id].subtitleSource.length - e.id);
			if(!_s.isAdd_bl) _s.loadSubtitle(_s._d.playlist_ar[_s.id].subtitleSource[_s._d.playlist_ar[_s.id].subtitleSource.length - 1 - _s._d.playlist_ar[_s.id].startAtSubtitle]["source"]);
			
		}
		
		_s.showSubtitleHandler = function(){
			_s.subtitle_do.show();
			_s.subtitle_do.isShowed_bl = true;
			
		};
		
		_s.hideSubtitleHandler = function(){
			_s.subtitle_do.isShowed_bl = false;
			_s.subtitle_do.hide();
		};
		
		_s.showCategoriesHandler = function(e){
			
			_s.showCategories();
			if(_s.controller_do) _s.controller_do.setCategoriesButtonState("selected");
		};
		
		_s.showPlaylistHandler = function(e){
			_s.disableClick();
			_s.showPlaylist();			
		};
		
		_s.hidePlaylistHandler = function(e){
			_s.disableClick();
			_s.hidePlaylist();	
		};
		
		_s.controllerOnPlayHandler = function(e){
			_s.play();
			if(_s._d.goFullScreenOnPlay_bl) _s.goFullScreen();
		};
		
		_s.controllerOnPauseHandler = function(e){
			_s.pause();
		};
		
		_s.controllerStartToScrubbHandler = function(e){
			if(_s.isCasting){
				_s.cc.startToScrub();
				return;
			}
			_s.startToScrub();
		};
		
		_s.controllerScrubbHandler = function(e){
			if(_s.isCasting){
				_s.cc.seek(e.percent);
				return;
			}
			_s.scrub(e.percent);
		};
		
		_s.controllerStopToScrubbHandler = function(e){
			if(_s.isCasting){
				_s.cc.stopToScrub();
				return;
			}
			_s.stopToScrub();
		};
		
		_s.controllerChangeVolumeHandler = function(e){
			_s.setVolume(e.percent);
		};
		
		_s.controllerDownloadVideoHandler = function(){
			_s.downloadVideo();
		};
		
		_s.controllerShareHandler = function(e){
			_s.setVideoPlayingStateOnWindowShow();
			_s.pause();
			
			_s.shareWindow_do.show();
			if(_s.controller_do && !_s.isMbl){
				_s.controller_do.shareButton_do.setSelectedState();
				_s.controller_do.shareButton_do.isDisabled_bl = true;
			}
		};
		
		_s.controllerChangeYoutubeQualityHandler = function(e){
			if(_s.videoType_str == FWDUVPlayer.HLS_JS){
				_s.curHlsLevel = Math.abs(e.id - _s.hlsLevels_ar.length + 1);
				_s.hlsJS.currentLevel = _s.curHlsLevel;
				
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
				_s.ytb_do.setQuality(e.quality);
			}else{
				_s.curDurration = _s.curTimeInSecond;
				_s._d.playlist_ar[_s.id].startAtVideo = _s._d.playlist_ar[_s.id].videoSource.length - 1 - e.id;
				_s.setSource(_s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["source"], false, _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["is360"]);
				_s.isQualityChanging_bl = true;
				_s.play();
			}
		};
		
		_s.controllerFullScreenHandler = function(){
			_s.goFullScreen();
		};
		
		_s.controllerNormalScreenHandler = function(){
			_s.goNormalScreen();
		};
		
		_s.showEmbedWindowHandler = function(){
			_s.setVideoPlayingStateOnWindowShow();
			_s.pause();
		
			_s.embedWindow_do.show();
			
			if(_s.controller_do && !_s.isMbl){
				_s.controller_do.embedButton_do.setSelectedState();
				_s.controller_do.embedButton_do.isDisabled_bl = true;
			}
		};
		
		_s.showInfoWindowHandler = function(){
			_s.setVideoPlayingStateOnWindowShow();
			_s.pause();
			
			_s.infoWindow_do.show(_s._d.playlist_ar[_s.id].desc);
			
			if(_s.controller_do && !_s.isMbl){
				_s.controller_do.infoButton_do.setSelectedState();
				_s.controller_do.infoButton_do.isDisabled_bl = true;
			}
		};
		
		_s.setVideoPlayingStateOnWindowShow =  function(){
			if(_s.isCasting){
				_s.isVideoPlayingWhenOpenWindows_bl = _s.cc.playerState == 'PLAYING';
			}else if(_s.isIMA && _s.IMA.started){
				_s.isVideoPlayingWhenOpenWindows_bl = _s.IMA.isPlaying;
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do){
				_s.isVideoPlayingWhenOpenWindows_bl = _s.ytb_do.isPlaying_bl;
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO && _s.vimeo_do){
				_s.isVideoPlayingWhenOpenWindows_bl = _s.vimeo_do.isPlaying_bl;
			}else{
				if(_s.videoScreen_do) _s.isVideoPlayingWhenOpenWindows_bl = _s.videoScreen_do.isPlaying_bl;
			}
		}

		
		//###########################################//
		/* setup FWDUVPAudioScreen */
		//###########################################//
		_s.setupAudioScreen = function(){	
			if(_s.audioScreen_do) return;
			FWDUVPAudioScreen.setPrototype();
			_s.audioScreen_do = new FWDUVPAudioScreen(_s, _s._d.volume);
			
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.ERROR, _s.videoScreenErrorHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.SAFE_TO_SCRUBB, _s.videoScreenSafeToScrubbHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.STOP, _s.videoScreenStopHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.PLAY, _s.videoScreenPlayHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.PAUSE, _s.videoScreenPauseHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.UPDATE, _s.videoScreenUpdateHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.UPDATE_TIME, _s.videoScreenUpdateTimeHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.LOAD_PROGRESS, _s.videoScreenLoadProgressHandler);
			_s.audioScreen_do.addListener(FWDUVPVideoScreen.START_TO_BUFFER, _s.videoScreenStartToBuferHandler);
			_s.audioScreen_do.addListener(FWDUVPVideoScreen.STOP_TO_BUFFER, _s.videoScreenStopToBuferHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.PLAY_COMPLETE, _s.videoScreenPlayCompleteHandler);
			_s.audioScreen_do.addListener(FWDUVPAudioScreen.UPDATE_SUBTITLE, _s.videoScreenUpdateSubtitleHandler);
			
			_s.videoHolder_do.addChild(_s.audioScreen_do);
		};

		
		//###########################################//
		/* setup FWDUVPVideoScreen */
		//###########################################//
		_s.setupVideoScreen = function(){
			FWDUVPVideoScreen.setPrototype();
			_s.videoScreen_do = new FWDUVPVideoScreen(_s, _s._d.volume);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.ERROR, _s.videoScreenErrorHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.SAFE_TO_SCRUBB, _s.videoScreenSafeToScrubbHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.STOP, _s.videoScreenStopHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.PLAY, _s.videoScreenPlayHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.PAUSE, _s.videoScreenPauseHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.UPDATE, _s.videoScreenUpdateHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.UPDATE_TIME, _s.videoScreenUpdateTimeHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.LOAD_PROGRESS, _s.videoScreenLoadProgressHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.START_TO_BUFFER, _s.videoScreenStartToBuferHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.STOP_TO_BUFFER, _s.videoScreenStopToBuferHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.PLAY_COMPLETE, _s.videoScreenPlayCompleteHandler);
			_s.videoScreen_do.addListener(FWDUVPVideoScreen.UPDATE_SUBTITLE, _s.videoScreenUpdateSubtitleHandler);
			_s.videoHolder_do.addChild(_s.videoScreen_do);
		};
		
		_s.videoScreenErrorHandler = function(e){

			var error;
			_s.isPlaying_bl = false;
			if(FWDUVPlayer.hasHTML5Video || _s.videoType_str == FWDUVPlayer.YOUTUBE){
				error = e.text;
				if(window.console) console.log(e.text);
				_s.showSourceError(error);
				
				if(_s.controller_do){
					_s.controller_do.disableMainScrubber();
					_s.controller_do.disablePlayButton();
					if(!_s._d.showControllerWhenVideoIsStopped_bl) _s.controller_do.hide(!_s.isMbl);
					_s.lrgPlayBtn.hide();
					_s.hideClickScreen();
					if(_s.hider) _s.hider.stop();
				}
			}else{
				error = e;
				_s.showSourceError(error);
			}
			
			if(_s.logo_do) _s.logo_do.hide(false);
			if(_s.preloader_do) _s.preloader_do.hide(false);
			_s.showCursor();
			_s.dispatchEvent(FWDUVPlayer.ERROR, {error:error});
		};
		
		_s.videoScreenSafeToScrubbHandler = function(){
			var curPlaylist = _s._d.playlist_ar[_s.id];

			if(_s.preloader_do) _s.preloader_do.hide();
			
			if(_s.controller_do){
				if(_s.isAdd_bl){
					_s.controller_do.disableMainScrubber();
					if(_s._d.timeToHoldAds) _s.adsStart_do.show(true);
					if(_s._d.adsThumbnailPath_str && _s._d.adsThumbnailPath_str != "none") _s.adsStart_do.loadThumbnail(_s._d.adsThumbnailPath_str);
					_s.positionAds();
				}else{
					_s.controller_do.enableMainScrubber();
				}
				
				_s.controller_do.enablePlayButton();
				_s.controller_do.show(true);
				
				if(!_s.isAdd_bl){
					if(_s.controller_do.ytbQualityButton_do){
						_s.controller_do.ytbQualityButton_do.enable();
						_s.controller_do.enablePlaybackRateButton();
					}
					_s.controller_do.enableAtButton();
				}
				if(!_s.isAdd_bl && _s.controller_do.playbackRateButton_do) _s.controller_do.enablePlaybackRateButton();
				if(!_s.isAdd_bl){
					 if(_s.controller_do.downloadButton_do) _s.controller_do.downloadButton_do.enable();
					 if(_s.controller_do.rewindButton_do) _s.controller_do.rewindButton_do.enable();
				}

				if(_s.hider) _s.hider.start();
			}
			
			if(!_s.isAdd_bl && !_s.isIMA && curPlaylist && curPlaylist.subtitleSource){
				_s.loadSubtitle(curPlaylist.subtitleSource[curPlaylist.subtitleSource.length - 1 - curPlaylist.startAtSubtitle]["source"]);
			}
			
			if(!_s.isAdd_bl){
				if(_s.customContextMenu_do) _s.customContextMenu_do.enable();
				if((_s.controller_do && _s.controller_do.thumbnailsPreview_do && curPlaylist['thumbnailsPreview'])
					|| ((_s.controller_do && _s.controller_do.thumbnailsPreview_do && curPlaylist['thumbnailsPreview'] == 'auto')
						&& (_s.videoType_str == FWDUVPlayer.VIDEO || _s.videoType_str == FWDUVPlayer.HLS_JS))){
						_s._d.tempShowMainScrubberToolTipLabel_bl = false;
						_s.controller_do.thumbnailsPreview_do.load(curPlaylist['thumbnailsPreview'], _s.videoType_str, _s.videoSourcePath_str, _s.videoScreen_do.video_el);
					} 
			}
			
			if(_s.controller_do){
				if( !_s.isQualityChanging_bl) _s.controller_do.disableSubtitleButton();
				_s.controller_do.enableAtbButton();
				if(_s.isAdd_bl && window['FWDUVPCC']) FWDUVPCC.disableButton();
			} 
			
			if(_s.isMbl){
				_s.adsSkip_do.hide(false);
			}

			if(_s.isQualityChanging_bl && !_s.isAdd_bl){
				_s.scrubbAtTime(_s.curDurration);
				_s.curDurration = 0;
				_s.isQualityChanging_bl = false;
			}
			
			_s.videoPoster_do.hide(true);
			
			_s.callVastEvent("start");
			_s.executeVastEvent(_s.Impression);
			
			_s.showClickScreen();
			setTimeout(function(){
				if(_s.totalDuration && _s.controller_do) _s.controller_do.positionAdsLines(_s.totalDuration);
			}, 1500);

			if(_s.getStartTimeStamp("t") != "00:00:00"){
				if(args['uvpi']){
					if(args['uvpi'] == _s.instanceName_str) _s.scrubbAtTime(_s.getStartTimeStamp("t"));
				}else{
					_s.scrubbAtTime(_s.getStartTimeStamp("t"));
				}
			}
			
			if(document.cookie && _s._d.useResumeOnPlay_bl && !_s.isAdd_bl){
				if(FWDUVPUtils.getCookie("fwduvp_video_path") && FWDUVPUtils.getCookie("fwduvp_time") 
				   && FWDUVPUtils.getCookie("fwduvp_video_path") == _s.videoSourcePath_str){
					var curTime = FWDUVPUtils.getCookie("fwduvp_time");
					if(!_s.rmsPlayed_bl){
						_s.scrubbAtTime(FWDUVPUtils.getCookie("fwduvp_time"));
					}
				}
				_s.rmsPlayed_bl = true;
			}

			_s.dispatchEvent(FWDUVPlayer.SAFE_TO_SCRUB);
		};
		
		_s.videoScreenUpdateSubtitleHandler = function(e){
			if(_s.subtitle_do) _s.subtitle_do.updateSubtitle(e.curTime);
		}
	
		_s.videoScreenStopHandler = function(e){
			if(_s.main_do) if(_s.main_do.contains(_s.info_do)) _s.main_do.removeChild(_s.info_do);
			_s.videoPoster_do.allowToShow_bl = true;
			_s.isPlaying_bl = false;
			
			if(_s.controller_do){
				_s.controller_do.disableMainScrubber();
				_s.controller_do.showPlayButton();
				if(!_s._d.showControllerWhenVideoIsStopped_bl){
					_s.controller_do.hide(!_s.isMbl);
				}else{
					_s.controller_do.show(!_s.isMbl);
				}
				if(_s.hider) _s.hider.stop();
			}
			
			if(_s.ytb_do){
				_s.ytb_do.stopVideo();
			}
			
			if(_s.logo_do) _s.logo_do.hide(true);
			
			_s.hideClickScreen();
			
			if(_s.isMbl){
				_s.adsSkip_do.hide(false);
				_s.adsStart_do.hide(false);
			}
			
			_s.showCursor();
			_s.dispatchEvent(FWDUVPlayer.STOP);
		};
		
		_s.videoScreenPlayHandler = function(){
			if(_s.preloader_do) _s.preloader_do.hide();
			if(_s.is360) _s.dClk_do.getStyle().cursor = 'url(' + _s._d.handPath_str + '), default';
			FWDUVPlayer.keyboardCurInstance = _s;
			
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE
			   && _s.ytb_do && _s.ytb_do.isStopped_bl) return;
			 
			_s.setupAPT();
			_s.callVastEvent("resume");
			
			if(_s.isMbl){
				if(FWDUVPlayer.videoStartBehaviour == FWDUVPlayer.STOP_ALL_VIDEOS){
					FWDUVPlayer.stopAllVideos(_s);
				}
			}else{
				if(FWDUVPlayer.videoStartBehaviour == FWDUVPlayer.PAUSE_ALL_VIDEOS){
					FWDUVPlayer.pauseAllVideos(_s);
				}
			}
		
			if(_s.logo_do) _s.logo_do.show(true);
			  
			if(_s.controller_do){
				_s.controller_do.showPauseButton();
				_s.controller_do.show(true);
			}
			
			_s.playAtTime_bl = false;
			_s.hasHlsPlayedOnce_bl = true;
			if(_s.lrgPlayBtn) _s.lrgPlayBtn.hide();
			if(_s.hider) _s.hider.start();
			_s.showCursor();

			_s.videoScreenStopToBuferHandler();
			
			if(_s.popw_do) _s.popw_do.hide();
		
			if((!_s.hasStartedToPlay_bl && _s._d.playlist_ar[_s.id] && _s._d.playlist_ar[_s.id].startAtTime && !_s.isAdd_bl && !_s.wasAdd_bl)
				|| (_s._d.playlist_ar[_s.id].startAtTime &&  !_s.isAdd_bl && _s.addStartAtZero)
			){
				_s.scrubbAtTime(_s._d.playlist_ar[_s.id].startAtTime);
			} 
			
			if(!_s.isMbl || _s.source.indexOf('.m3u') == -1 || (_s.isMbl && _s.source.indexOf('.m3u') == -1)){
				_s.resumeAfterAd();
			} 

			if(!_s.hasStartedToPlay_bl && _s.castStartAtTime && !_s.isAdd_bl){
				_s.scrubbAtTime(_s.castStartAtTime);
				_s.castStartAtTime = undefined;
			}
			
			_s.isPlaying_bl = true;
			//_s.isThumbClick_bl = false;
			_s.loadAddFirstTime_bl = false;
			_s.hasStartedToPlay_bl = true;
			if(_s.opener_do) _s.opener_do.showPauseButton();
			if(_s.fps) _s.fps.start();
			
			_s.dispatchEvent(FWDUVPlayer.PLAY);
		};

		_s.resumeAfterAd = function(){
			if(_s.wasAdd_bl){
				if(FWDUVPUtils.isSafari){
					setTimeout(function(){
						_s.scrubbAtTime(_s.scrubAfterAddDuration);
					},500);
				}else{
					if(_s.videoType_str == FWDUVPlayer.VIMEO){
						setTimeout(function(){
							_s.scrubbAtTime(_s.scrubAfterAddDuration);
						},500);
					}else{
						_s.scrubbAtTime(_s.scrubAfterAddDuration)
					}
				
				}
				_s.wasAdd_bl = _s.addStartAtZero = false;
			}
		}
		
		_s.videoScreenPauseHandler = function(){

			if(_s.videoType_str == FWDUVPlayer.YOUTUBE
			   && _s.ytb_do && _s.ytb_do.isStopped_bl) return;
			   
			if(_s.videoType_str == FWDUVPlayer.VIMEO
			   && _s.vimeo_do && _s.vimeo_do.isStopped_bl) return;
			   
			_s.callVastEvent("pause");
			if(_s.preloader_do) _s.preloader_do.hide();

			_s.isPlaying_bl = false;
			if(_s.controller_do){
				_s.controller_do.showPlayButton();
				_s.controller_do.show(true);
			}
			
			var isShareWIndowShowed_bl = _s.shareWindow_do && _s.shareWindow_do.isShowed_bl;
			var isEmbedWIndowShowed_bl = _s.embedWindow_do && _s.embedWindow_do.isShowed_bl;

			if(!isShareWIndowShowed_bl && !isEmbedWIndowShowed_bl){
				if(_s.showPopW_bl) _s.popw_do.show(_s.popwSource);	
			}
				
			if(_s.lrgPlayBtn && !_s._d.showAnnotationsPositionTool_bl) _s.lrgPlayBtn.show();
			
			if(_s.hider){
				_s.hider.reset();
				_s.hider.stop();
			}
			
			_s.showClickScreen();
			
			_s.showCursor();
			if(_s.opener_do) _s.opener_do.showPlayButton();
			if(_s.fps) _s.fps.stop();
			_s.dispatchEvent(FWDUVPlayer.PAUSE);
		};
		
		_s.videoScreenUpdateHandler = function(e){
			var percent;	
			if(FWDUVPlayer.hasHTML5Video || _s.videoType_str == FWDUVPlayer.YOUTUBE){
				percent = e.percent;
				if(_s.controller_do) _s.controller_do.updateMainScrubber(percent);
			}else{
				percent = e;
				console.log(e)
				if(_s.controller_do) _s.controller_do.updateMainScrubber(percent);
			}
			_s.dispatchEvent(FWDUVPlayer.UPDATE, {percent:percent});
		};
		
		_s.videoScreenUpdateTimeHandler = function(e, e2, e3){
			if(_s.isStopped_bl) return;
			
			if(_s.prevSeconds != Math.round(e.seconds)) _s.totalTimePlayed += 1;
			_s.totalTimeInSeconds = Math.round(e.totalTimeInSeconds);
			_s.totalTimeInMilliseconds = e.totalTimeInSeconds;
			_s.curTimeInSecond = Math.round(e.seconds);
			_s.curTimeInmilliseconds = e.seconds;
			_s.prevSeconds =  Math.round(e.seconds)
			_s.totalPercentPlayed = _s.totalTimePlayed/e.totalTimeInSeconds;

			if(!isFinite(_s.totalPercentPlayed)) _s.totalPercentPlayed = 0;
			
			if(FWDUVPUtils.getSecondsFromString(_s.getStartTimeStamp("e"))){
				if(_s.curTimeInSecond >= parseInt(FWDUVPUtils.getSecondsFromString(_s.getStartTimeStamp("e")))) _s.stop();
			}
		
			if(_s.controller_do 
			   && !_s.controller_do.isMainScrubberScrubbing_bl
			   && _s.controller_do.atb
			   && _s.controller_do.atb.isShowed_bl
			   && !_s.controller_do.atb.scrub){
				
				var a = Math.round(_s.totalTimeInSeconds * _s.controller_do.atb.pa);
				var b = Math.round(_s.totalTimeInSeconds * _s.controller_do.atb.pb);
				
				
				if(_s.prevCurTimeInSeconds != _s.curTimeInSecond){
					_s.prevCurTimeInSeconds = _s.curTimeInSecond;
					if(_s.curTimeInSecond < a){
						_s.scrub(_s.controller_do.atb.pa);
					}else if(_s.curTimeInSecond > b){
						_s.scrub(_s.controller_do.atb.pa);
					}
				}
			}
			
			if(_s.isAdd_bl){
				if(_s.totalPercentPlayed >= .25 && _s.callFirstQuartile){
					_s.callVastEvent("firstQuartile");
					_s.callFirstQuartile = false;
				}else if(_s.totalPercentPlayed >= .50 && _s.callMidpoint){
					_s.callVastEvent("midpoint");
					_s.callMidpoint = false;
				}else if(_s.totalPercentPlayed >= .75 && _s.callThirdQuartile){
					_s.callVastEvent("thirdQuartile");
					_s.callThirdQuartile = false;
				}
			}

			var time;
			var seconds;
			if(FWDUVPlayer.hasHTML5Video || _s.videoType_str == FWDUVPlayer.YOUTUBE || _s.videoType_str == FWDUVPlayer.VIMEO){
				_s.curTime = e.curTime;
				_s.totalTime = e.totalTime;
				time = _s.curTime + "/" + _s.totalTime;
				seconds = _s.curTimeInSecond;
				if(_s.controller_do) _s.controller_do.updateTime(time);
			}else{
				_s.curTime = e;
				_s.totalTime = e2;
				time = _s.curTime + "/" + _s.totalTime;
				if(e == undefined || e2 ==  undefined) time = "00:00/00:00";
				seconds = Math.round(e3);
				if(_s.controller_do) _s.controller_do.updateTime(time);
			}
			
			_s.currentSecconds = e.seconds;
			
			if(_s.popupAds_do && !_s.isAdd_bl) _s.popupAds_do.update(_s.curTimeInSecond);
			if(_s.annotations_do && !_s.isAdd_bl) _s.annotations_do.update(_s.curTimeInSecond);
			
			if(_s._d.playlist_ar && _s._d.playlist_ar[_s.id]){
				_s.cuePointsSource_ar = _s._d.playlist_ar[_s.id].cuepoints_ar;
			}
			
			if(_s.cuePointsSource_ar && !_s.isAdd_bl){
				var length = _s.cuePointsSource_ar.length;
				for(var i=0; i<length; i++){
					if(_s.cuePointsSource_ar){
						var cuePoint = _s.cuePointsSource_ar[i];
						if(cuePoint.timeStart == _s.curTimeInSecond && !cuePoint.played_bl){
							if(_s._d.executeCuepointsOnlyOnce_bl ){
								if(!cuePoint.played_bl) eval(cuePoint.javascriptCall);
							}else{
								eval(cuePoint.javascriptCall);
							}
							cuePoint.played_bl = true;
						}
					}
				}
			}
			
			if(!_s.isAdd_bl){
				if(_s.totalTime.length>5){
					_s.totalDuration = FWDUVPUtils.getSecondsFromString(_s.totalTime);
				}else{
					_s.totalDuration = FWDUVPUtils.getSecondsFromString("00:" + _s.totalTime);
				}
			}
			
			if(_s.isIMA){
				_s.IMA.updateCuepointLines(seconds);
			}
			
			if(_s.isAdd_bl){
				if(_s._d.timeToHoldAds > seconds){
					_s.adsStart_do.updateText(_s._d.skipToVideoText_str + Math.abs(_s._d.timeToHoldAds - seconds));
					if(_s.isMbl) _s.adsSkip_do.hide(false);
					if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
						_s.adsStart_do.show(true);
					}
				}else if(_s.isPlaying_bl){
					_s.adsStart_do.hide(true);
					if(_s._d.timeToHoldAds) _s.adsSkip_do.show(true);
				}
			}else{
				_s.adsStart_do.hide(true);
				_s.adsSkip_do.hide(true);
			}
		
			if(seconds != 0){
				_s.updateAds(seconds);
			}

			if(_s.isPlaying_bl && _s._d.playlist_ar[_s.id] && FWDUVPUtils.getSecondsFromString(_s._d.playlist_ar[_s.id].stopAtTime) <= e.seconds){
				if(_s._d.playAfterVideoStop_bl){
					if(_s._d.stopAfterLastVideoHasPlayed_bl && _s._d.playlist_ar.length - 1 == _s.id){
						_s.stop();
					}else{
						_s.playNext();
					}
				}else if(!_s._d.stopAfterLastVideoHasPlayed_bl && _s._d.playlist_ar.length - 1 == _s.id && _s._d.playlist_ar.length > 1){
					_s.playNext();
				}else{
					_s.stop();
				}
			}

			_s.dispatchEvent(FWDUVPlayer.UPDATE_TIME, {currentTime:_s.curTime, totalTime:_s.totalTime});
		};
		
		_s.videoScreenLoadProgressHandler = function(e){
			if(FWDUVPlayer.hasHTML5Video || _s.videoType_str == FWDUVPlayer.YOUTUBE){
				if(_s.controller_do) _s.controller_do.updatePreloaderBar(e.percent);
			}else{
				if(_s.controller_do) _s.controller_do.updatePreloaderBar(e);
			}
		};
		
		_s.videoScreenStartToBuferHandler = function(){
			if(_s.preloader_do){
				_s.preloader_do.show(false);
			}
		};
		
		_s.videoScreenStopToBuferHandler = function(){
			if(_s.preloader_do && _s.isPlaylistLoaded_bl) _s.preloader_do.hide(true);
		};
		
		_s.videoScreenPlayCompleteHandler = function(e, buttonUsedToSkipAds){
			if(_s._d.playlist_ar){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
			
			_s.stopedAtComplete = true;
			_s.callVastEvent("complete");
			
			if(_s.isIMA && _s.IMA.hasPostRoll && _s.curTimeInSecond >= _s.totalTimeInSeconds - 1){
				_s.IMA.playPostRoll();
				return;
			}
			
			if(!_s.isAdd_bl && _s._d.playlist_ar[_s.id].redirectURL){
				if(_s._d.playlist_ar[_s.id].redirectTarget == "_self"){
					location.replace(_s._d.playlist_ar[_s.id].redirectURL);
				}else{
					window.open(_s._d.playlist_ar[_s.id].redirectURL, _s._d.playlist_ar[_s.id].redirectTarget);
				}
			}
			
			var tempIsAdd_bl = _s.isAdd_bl;
			
			if(_s.isAdd_bl){
				_s.isThumbClick_bl = true;
				if(_s._d.openNewPageAtTheEndOfTheAds_bl && _s._d.adsPageToOpenURL_str != "none" && !buttonUsedToSkipAds){
					if(_s._d.adsPageToOpenTarget_str == "_self"){
						location.href = _s._d.adsPageToOpenURL_str;
					}else{
						window.open(_s._d.adsPageToOpenURL_str, _s._d.adsPageToOpenTarget_str);
					}
				}

				_s.sendGAPlayedAdEvent();
				
				_s.isAdd_bl = false;
				_s.updateAds(0);
				_s.wasAdd_bl = true;


				if(buttonUsedToSkipAds && _s.videoType_str == FWDUVPlayer.VIDEO){	
					_s.play();
				}else{
					if(!_s.isMbl && (_s.videoType_str != FWDUVPlayer.DASH && _s.videoType_str != FWDUVPlayer.VIMEO)) _s.play();
				}
			}
			
			if(!tempIsAdd_bl){

				if((_s.lightBox_do && _s.lightBox_do.isShowed_bl && _s._d.closeLightBoxWhenPlayComplete)){
					_s.stop();
					_s.lightBox_do.closeButtonOnStartHandler();
				}

				if(_s._d.loop_bl){
					if(_s.videoType_str == FWDUVPlayer.HLS_JS
					|| _s.videoType_str == FWDUVPlayer.DASH){
						setTimeout(function(){
							_s.scrub(0);
							_s.resume();
						}, 50);
					}else{						
						_s.scrub(0);
						_s.play();
					}
				}else if((_s._d.stopVideoWhenPlayComplete_bl || _s._d.playlist_ar.length == 1)
				||  (_s._d.stopAfterLastVideoHasPlayed_bl && _s._d.playlist_ar.length - 1 == _s.id)
				){	
					_s.stop();
				}else if(_s._d.shuffle_bl){
					_s.playShuffle();
					if(_s.isMbl) _s.stop();
					if(_s.videoType_str == FWDUVPlayer.DASH){
						_s.setSource(_s.source);
					}
				}else{
					_s.playNext();
					if(_s.isMbl){
						if(_s.videoType_str == FWDUVPlayer.DASH){
							_s.setSource(_s.source);
						}
					} 
				}
			}
			if(_s.hider) _s.hider.reset();
			_s.dispatchEvent(FWDUVPlayer.PLAY_COMPLETE);
		};
		

		//##########################################//
		/* Setup annotations */
		//##########################################//
		_s.setupAnnotations = function(){
			FWDUVPAnnotations.setPrototype();
			_s.annotations_do = new FWDUVPAnnotations(_s, _s._d);
			_s.videoHolder_do.setBkColor = props.backgroundColor;
			_s.videoHolder_do.screen.className = 'fwduvp-video-holder';
			_s.videoHolder_do.addChild(_s.annotations_do);
		};
		

		//##########################################//
		/* Setup skip adds buttons */
		//##########################################//
		_s.setupAdsStart = function(){
			FWDUVPAdsStart.setPrototype();
			_s.adsStart_do = new FWDUVPAdsStart(
					_s._d.adsButtonsPosition_str, 
					_s._d.adsBorderNormalColor_str, 
					"", 
					_s._d.adsBackgroundPath_str,
					_s._d.adsTextNormalColor);
			
			FWDUVPAdsButton.setPrototype();
			_s.adsSkip_do = new FWDUVPAdsButton(
					_s,
					_s._d.skipIconPath_img,
					_s._d.skipIconSPath_str,
					_s._d.skipToVideoButtonText_str,
					_s._d.adsButtonsPosition_str, 
					_s._d.adsBorderNormalColor_str, 
					_s._d.adsBorderSelectedColor_str, 
					_s._d.adsBackgroundPath_str,
					_s._d.adsTextNormalColor,
					_s._d.adsTextSelectedColor,
					_s._d.useHEX,
					_s._d.nBC,
					_s._d.sBC);
			_s.adsSkip_do.addListener(FWDUVPAdsButton.MOUSE_UP, _s.skipAdsMouseUpHandler);
			
			_s.videoHolder_do.addChild(_s.adsSkip_do);
			_s.videoHolder_do.addChild(_s.adsStart_do);
		};
		
		_s.skipAdsMouseUpHandler = function(){
			_s.isThumbClick_bl = true;
			_s.callVastEvent("skip");
			_s.videoScreenPlayCompleteHandler(null, true);
		};
		
		_s.positionAds = function(animate){
			
			var finalX;
			var finalY;
		
			if(_s._d.adsButtonsPosition_str == "left"){
				finalX = 0;
			}else{
				finalX = _s.tempVidStageWidth;
			}
			
			if(_s.controller_do){
				if(_s.controller_do.isShowed_bl){
					finalY = _s.tempVidStageHeight - _s.adsStart_do.h - _s._d.controllerHeight - 30;
				}else{
					finalY = _s.tempVidStageHeight - _s.adsStart_do.h - _s._d.controllerHeight;
				}
			}else{
				finalY = _s.tempVidStageHeight - _s.adsStart_do.h
			}
			
			FWDAnimation.killTweensOf(_s.adsStart_do);
			if(animate){
				FWDAnimation.to(_s.adsStart_do, .8, {y:finalY, ease:Expo.easeInOut});
			}else{
				_s.adsStart_do.setY(finalY);
			}
			
			_s.adsStart_do.setX(finalX);

			var mbl = false;
			if(_s.tempStageWidth < 600) mbl = true;
		
			_s.adsSkip_do.resize(mbl);
			
			if(_s._d.adsButtonsPosition_str == "left"){
				finalX = 0;
			}else{
				finalX = _s.tempVidStageWidth;
			}
			
			if(_s.controller_do){
				if(_s.controller_do.isShowed_bl){
					finalY = _s.tempVidStageHeight - _s.adsSkip_do.h - _s._d.controllerHeight - 30;
				}else{
					finalY = _s.tempVidStageHeight - _s.adsSkip_do.h - _s._d.controllerHeight;
				}
			}else{
				finalY = _s.tempVidStageHeight - _s.adsSkip_do.h
			}
			
			FWDAnimation.killTweensOf(_s.adsSkip_do);
			if(animate){
				FWDAnimation.to(_s.adsSkip_do, .8, {y:finalY, ease:Expo.easeInOut});
			}else{
				_s.adsSkip_do.setY(finalY);
			}
			
			_s.adsSkip_do.setX(finalX);
			
		};

		
		//##########################################//
		/* Setup embed window */
		//##########################################//
		_s.setupShareWindow = function(){
			FWDUVPShareWindow.setPrototype();
			_s.shareWindow_do = new FWDUVPShareWindow(_s._d, _s);
			_s.shareWindow_do.addListener(FWDUVPShareWindow.HIDE_COMPLETE, _s.shareWindowHideCompleteHandler);
		};
		
		_s.shareWindowHideCompleteHandler = function(){
			if(_s.isVideoPlayingWhenOpenWindows_bl) _s.resume();
			
			if(_s.controller_do && !_s.isMbl){
				_s.controller_do.shareButton_do.isDisabled_bl = false;
				_s.controller_do.shareButton_do.setNormalState(true);
			}
		};


		//##########################################//
		/* Setup login window */
		//##########################################//
		_s.setupLoginWindow =  function(){
			FWDUVPPassword.setPrototype();
			_s.lg_do = new FWDUVPPassword(_s._d, _s, true);
		}

		
		//##########################################//
		/* Setup embed window */
		//##########################################//
		_s.setupPasswordWindow = function(){
			FWDUVPPassword.setPrototype();
			_s.passWindow_do = new FWDUVPPassword(_s._d, _s);
			_s.passWindow_do.addListener(FWDUVPPassword.CORRECT, _s.passordCorrect);
		};
		
		_s.passordCorrect = function(){
			_s.passWindow_do.hide();
			_s.hasPassedPassowrd_bl = true;
			_s.play();
		}

		_s.checkPassWindow = function(){
			if(!_s.isAdd_bl && (_s._d.playlist_ar[_s.id]["isPrivate"] || _s.playlistPass) && !_s.hasPassedPassowrd_bl && _s.passWindow_do && !_s.plPassPassed){
				if(_s.lrgPlayBtn) _s.lrgPlayBtn.show();
				_s.passWindow_do.show();
				_s.videoPoster_do.show();
				return;
			}

			return true;
		}
		

		//##########################################//
		/* Setup embed window */
		//##########################################//
		_s.setupEmbedWindow = function(){
			FWDUVPEmbedWindow.setPrototype();
			_s.embedWindow_do = new FWDUVPEmbedWindow(_s._d, _s);
			_s.embedWindow_do.addListener(FWDUVPEmbedWindow.ERROR, _s.embedWindowErrorHandler);
			_s.embedWindow_do.addListener(FWDUVPEmbedWindow.HIDE_COMPLETE, _s.embedWindowHideCompleteHandler);
		};
		
		_s.embedWindowErrorHandler = function(e){
			_s.showSourceError(e.error);
		};
		
		_s.embedWindowHideCompleteHandler = function(){
			if(_s.isVideoPlayingWhenOpenWindows_bl) _s.resume();
			
			if(_s.controller_do && !_s.isMbl){
				_s.controller_do.embedButton_do.isDisabled_bl = false;
				_s.controller_do.embedButton_do.setNormalState(true);
			}
		};
		
		_s.copyLinkButtonOnMouseOver = function(){
			_s.embedWindow_do.copyLinkButton_do.setSelectedState();
		};
		
		_s.copyLinkButtonOnMouseOut = function(){
			_s.embedWindow_do.copyLinkButton_do.setNormalState();
		};
		
		_s.getLinkCopyPath = function(){
			return _s.embedWindow_do.linkToVideo_str;
		};
		
		_s.embedkButtonOnMouseOver = function(){
			_s.embedWindow_do.copyEmbedButton_do.setSelectedState();
		};
		
		_s.embedButtonOnMouseOut = function(){
			_s.embedWindow_do.copyEmbedButton_do.setNormalState();
		};
		
		_s.getEmbedCopyPath = function(){
			return _s.embedWindow_do.finalEmbedCode_str;
		};
		
		
		//######################################//
		/* Add keyboard support */
		//######################################//
		_s.setInputs = function(){
			var numInputs = document.querySelectorAll('input');
			for (var i = 0; i < numInputs.length; i++) {
				numInputs[i].addEventListener("mousedown", _s.inputFocusInHandler);
				numInputs[i].addEventListener("touchstart", _s.inputFocusInHandler);
			}

			var numTextA = document.querySelectorAll('textarea');
			for (var i = 0; i < numTextA.length; i++) {
				numTextA[i].addEventListener("mousedown", _s.inputFocusInHandler);
				numTextA[i].addEventListener("touchstart", _s.inputFocusInHandler);
			}
		}
		
		_s.inputFocusInHandler = function(e){
			_s.curInput = e.target;
			setTimeout(function(){
				if(_s.hasPointerEvent_bl){
					window.addEventListener("pointerdown", _s.inputFocusOutHandler);
				}else if(window.addEventListener){
					window.addEventListener("mousedown", _s.inputFocusOutHandler);
					window.addEventListener("touchstart", _s.inputFocusOutHandler);
				}
				FWDUVPlayer.isSearchedFocused_bl = true;
			}, 50);
		}
		
		_s.inputFocusOutHandler = function(e){
			
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(!FWDUVPUtils.hitTest(_s.curInput, vc.screenX, vc.screenY)){
				if(_s.hasPointerEvent_bl){
					window.removeEventListener("pointerdown", _s.inputFocusOutHandler);
				}else if(window.removeEventListener){
					window.removeEventListener("mousedown", _s.inputFocusOutHandler);
					window.removeEventListener("touchstart", _s.inputFocusOutHandler);
				}
				FWDUVPlayer.isSearchedFocused_bl = false;
				return;
			}
		};
		
		_s.addKeyboardSupport = function(){
			_s.setInputs();
			document.addEventListener("keydown",  _s.onKeyDownHandler);	
			document.addEventListener("keyup",  _s.onKeyUpHandler);
		};
		
		_s.onKeyDownHandler = function(e){
			if((_s.isSpaceDown_bl || !_s.hasStartedToPlay_bl || FWDUVPlayer.isSearchedFocused_bl) && !_s.isCasting) return;
			if(_s != FWDUVPlayer.keyboardCurInstance && (FWDUVPlayer.videoStartBehaviour == "pause" || FWDUVPlayer.videoStartBehaviour == "none")) return;
			if(_s.embedWindow_do && _s.embedWindow_do.isShowed_bl) return;
			_s.isSpaceDown_bl = true;
			if(e.preventDefault) e.preventDefault();

			if (e.keyCode == 32){
				
				_s.stickOnCurrentInstanceKey_bl = true;
				if(_s.isCasting){
					_s.cc.togglePlayPause();
				}else if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
					if(_s.isImageAdsPlaying_bl){
						_s.stopUpdateImageInterval();
					}else{
						_s.startUpdateImageInterval();
					}
				}else if(_s.isIMA && _s.IMA.started){
					_s.IMA.togglePlayPause();
				}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
					if(!_s.ytb_do.isSafeToBeControlled_bl) return;
					_s.ytb_do.togglePlayPause();
				}else if(_s.videoType_str == FWDUVPlayer.VIMEO){
					if(!_s.vimeo_do.isSafeToBeControlled_bl) return;
					_s.vimeo_do.togglePlayPause();
				}else if(_s.videoType_str == FWDUVPlayer.MP3){
					if(!_s.audioScreen_do.isSafeToBeControlled_bl) return;
					_s.audioScreen_do.togglePlayPause();
				}else if(FWDUVPlayer.hasHTML5Video){
					if(!_s.videoScreen_do.isSafeToBeControlled_bl) return;
					if(_s.videoScreen_do) _s.videoScreen_do.togglePlayPause();
				}
				if(e.preventDefault) e.preventDefault();
				return false;
			}else if (e.keyCode == 70){
				if(_s.isFullScreen_bl){
					_s.goNormalScreen();
				}else{
					_s.goFullScreen();
				}
			}else if (e.keyCode == 77){
				if(_s.volume != 0) _s.lastVolume = _s.volume;
				if(_s.volume != 0){
					_s.volume = 0;
				}else{
					_s.volume = _s.lastVolume;
				}
				_s.setVolume(_s.volume);
			}else if (e.keyCode == 38){
				_s.volume += .1;
				if(_s.volume > 1) _s.volume = 1;
				_s.setVolume(_s.volume);
			}else if (e.keyCode == 40){
				_s.volume -= .1;
				if(_s.volume < 0) _s.volume = 0;
				_s.setVolume(_s.volume);
			}else if (e.keyCode == 77){
				
				if(_s.volume < 0) _s.volume = 0;
				_s.setVolume(_s.volume);
			}else if (e.keyCode == 39 && !_s.isAdd_bl && !_s.isIMA){
				var curTime = _s.getCurrentTime();
				if(curTime.length == 5) curTime = "00:" + curTime;
				if(curTime.length == 7) curTime = "0" + curTime;
				curTime = FWDUVPUtils.getSecondsFromString(curTime);
				curTime += 5;
				curTime = FWDUVPUtils.formatTime(curTime);
				if(curTime.length == 5) curTime = "00:" + curTime;
				if(curTime.length == 7) curTime = "0" + curTime;
				
				_s.scrubbAtTime(curTime);
			}else if (e.keyCode == 37 && !_s.isAdd_bl && !_s.isIMA){
				var curTime = _s.getCurrentTime();
				if(curTime.length == 5) curTime = "00:" + curTime;
				if(curTime.length == 7) curTime = "0" + curTime;
				curTime = FWDUVPUtils.getSecondsFromString(curTime);
				curTime -= 5;
				curTime = FWDUVPUtils.formatTime(curTime);
				if(curTime.length == 5) curTime = "00:" + curTime;
				if(curTime.length == 7) curTime = "0" + curTime;
				_s.scrubbAtTime(curTime);
			}
		};
		
		_s.onKeyUpHandler = function(e){
			_s.isSpaceDown_bl = false;
		};
		
		_s.setupAopw = function(){
			FWDUVPOPWindow.setPrototype();
			_s.popw_do = new FWDUVPOPWindow(_s._d, _s);
		}
		

		//####################################//
		/* Setup hider */
		//####################################//
		_s.setupHider = function(){
			FWDUVPHider.setPrototype();
			_s.hider = new FWDUVPHider(_s.main_do, _s.controller_do, _s._d.controllerHideDelay);
			_s.hider.addListener(FWDUVPHider.SHOW, _s.hiderShowHandler);
			_s.hider.addListener(FWDUVPHider.HIDE, _s.hiderHideHandler);
			_s.hider.addListener(FWDUVPHider.HIDE_COMPLETE, _s.hiderHideCompleteHandler);
		};
		
		_s.hiderShowHandler = function(){
			if(_s.controller_do && _s.isPlaying_bl) _s.controller_do.show(true);
			if(_s.logo_do && _s._d.hideLogoWithController_bl && _s.isPlaying_bl) _s.logo_do.show(true);
			_s.showCursor();
			
			if(_s.isAdd_bl){
				_s.positionAds(true);
				_s.adsStart_do.showWithOpacity();
				_s.adsSkip_do.showWithOpacity();	
			}
			
			if(_s.subtitle_do) _s.subtitle_do.position(true);
			if(_s.popupAds_do) _s.popupAds_do.position(true);
			
		};
		

		_s.hiderHideHandler = function(){
			if(_s.controller_do.volumeScrubber_do && _s.controller_do.isVolumeScrubberShowed_bl){
				_s.hider.reset();
				return;
			}

			if(_s.controller_do.atb && _s.controller_do.atb.isShowed_bl){
				if(FWDUVPUtils.hitTest(_s.controller_do.atb.mainHld.screen, _s.hider.globalX, _s.hider.globalY)){
					_s.hider.reset();
					return;
				}
			}
		
			if(_s._d.showYoutubeQualityButton_bl && FWDUVPUtils.hitTest(_s.controller_do.ytbButtonsHolder_do.screen, _s.hider.globalX, _s.hider.globalY)){
				_s.hider.reset();
				return;
			}
			
			if(_s._d.showPlaybackRateButton_bl && _s.controller_do && FWDUVPUtils.hitTest(_s.controller_do.playbackRatesButtonsHolder_do.screen, _s.hider.globalX, _s.hider.globalY)){
				_s.hider.reset();
				return;
			}

			if(_s._d.showAudioTracksButton_bl && _s.controller_do && FWDUVPUtils.hitTest(_s.controller_do.ATBButtonsHolder_do.screen, _s.hider.globalX, _s.hider.globalY)){
				_s.hider.reset();
				return;
			}
			
			if(_s.controller_do && _s._d.showSubBtn && FWDUVPUtils.hitTest(_s.controller_do.subtitlesButtonsHolder_do.screen, _s.hider.globalX, _s.hider.globalY)){
				_s.hider.reset();
				return;
			}
			
			if(FWDUVPUtils.hitTest(_s.controller_do.screen, _s.hider.globalX, _s.hider.globalY)){
				_s.hider.reset();
				return;
			}
			
			if(FWDUVPUtils.hitTest(_s.controller_do.mainScrubber_do.screen, _s.hider.globalX, _s.hider.globalY)){
				_s.hider.reset();
				return;
			}
			
			
			if(_s._d.showDefaultControllerForVimeo_bl || _s.videoType_str != FWDUVPlayer.VIMEO){
				_s.controller_do.hide(true);
			}
			
			if(_s.logo_do && _s._d.hideLogoWithController_bl) _s.logo_do.hide(true);
			if(_s.isFullScreen_bl) _s.hideCursor();
			
			if(_s.isAdd_bl){
				_s.positionAds(true);
				_s.adsStart_do.hideWithOpacity();
				_s.adsSkip_do.hideWithOpacity();	
			}
			
			_s.subtitle_do.position(true);
			if(_s.popupAds_do) _s.popupAds_do.position(true);
		};
		
		_s.hiderHideCompleteHandler = function(){
			_s.controller_do.positionScrollBarOnTopOfTheController();
		};
		

		//####################################//
		// API
		//###################################//
		_s.play = function(){
			
			if(!_s.isAPIReady_bl) return;
			
			if(_s.isCasting){
				_s.cc.play();
				return;
			}
		
			// if(_s.videoType_str == FWDUVPlayer.HLS_JS){
			// 	if(location.protocol.indexOf("file:") >= 0){
			// 		_s.showSourceError("HLS m3u8 videos can't be played local on _s browser, please test it online!.");
			// 		return;
			// 	}
			// }

			var check = _s.checkPassWindow();
			if(!check) return;
			_s.hasPassedPassowrd_bl = true;

			if(_s._d.playIfLoggedIn || _s._d.playlist_ar[_s.id]['playIfLoggedIn']){
				_s.lg_do.show();
				_s.videoPoster_do.show();
				return;
			}
			
			if(_s.isMbl){
				  FWDUVPlayer.stopAllVideos(_s);
			}else{
				if(FWDUVPlayer.videoStartBehaviour == FWDUVPlayer.PAUSE_ALL_VIDEOS){
					FWDUVPlayer.pauseAllVideos(_s);
				}else if(FWDUVPlayer.videoStartBehaviour == FWDUVPlayer.STOP_ALL_VIDEOS){
					FWDUVPlayer.stopAllVideos(_s);
				}
			}
			
			if(_s.isIMA){
				if(_s.isIMA && _s.IMA && !_s.IMA.isReady) return;
				_s.IMA.play();
			}else if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
				_s.startUpdateImageInterval();
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
				if(_s.ytb_do) _s.ytb_do.play();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.play();
				if(!FWDUVPUtils.isLocal) _s.audioScreen_do.setupSpectrum();
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO){
				if(_s.vimeo_do) _s.vimeo_do.play();
			}else if(FWDUVPlayer.hasHTML5Video){
				if(_s.videoType_str == FWDUVPlayer.HLS_JS && !_s.isHLSManifestReady_bl){
					_s.videoScreen_do.initVideo();
					if(window['Hls']){
						_s.setupHLS();
						_s.hlsJS.loadSource(_s.videoSourcePath_str);
						_s.hlsJS.attachMedia(_s.videoScreen_do.video_el);
						
						_s.hlsJS.on(Hls.Events.MANIFEST_PARSED,function(e){
							_s.isHLSManifestReady_bl = true;
							if(_s.videoType_str == FWDUVPlayer.HLS_JS){
								_s.play();
								_s.parseLevels();
							} 
						});
					}
				}else if(_s.videoType_str == FWDUVPlayer.DASH && !_s.isDASHManifestReady_bl){
					_s.videoScreen_do.initVideo();
					
					if(window['dashjs']){
						_s.setupDASH();
						_s.dashJS.initialize(_s.videoScreen_do.video_el, _s.videoSourcePath_str, false);
	                 	_s.dashJS.attachSource(_s.videoSourcePath_str);
	                 	_s.dashJS.on(dashjs.MediaPlayer.events.MANIFEST_LOADED, function(e){
	                 		_s.isDASHManifestReady_bl = true;
	                 		if(_s.videoType_str == FWDUVPlayer.DASH) setTimeout(_s.play, 100);
	                 	});
                 	}
				}else{
					_s.videoScreen_do.play();
				}
			}

			_s.lrgPlayBtn.hide();
			_s.videoPoster_do.hide();
		};
		
		_s.pause = function(){
			if(!_s.isAPIReady_bl) return;
			
			if(_s.isCasting){
				_s.cc.pause();
				return;
			}
			if(_s.isIMA){
				_s.IMA.pause();
			}else if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
				_s.stopUpdateImageInterval();
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
				_s.ytb_do.pause();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.pause();
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO){
				_s.vimeo_do.pause();
			}else if(FWDUVPlayer.hasHTML5Video){
				if(_s.videoScreen_do) _s.videoScreen_do.pause();
			}
		};
		
		_s.resume = function(){
			if(!_s.isAPIReady_bl) return;
			
			if(_s.isCasting){
				_s.cc.play();
			}else if(_s.isIMA && _s.IMA.started){
				_s.IMA.play();
			}else if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
				_s.startUpdateImageInterval();
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do){
				_s.ytb_do.resume();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.resume();
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO && _s.vimeo_do){
				_s.vimeo_do.resume();
			}else if(FWDUVPlayer.hasHTML5Video){
				if(_s.videoScreen_do) _s.videoScreen_do.resume();
			}
		};

		_s.sendGAPlayedEvent = function(){
			if(!isNaN(_s.totalPercentPlayed) && _s.gtag && !_s.isAdd_bl){
				if(Math.round(_s.totalPercentPlayed * 100)){

					var params = {
						'video_name': _s.videoNameGa,
						'video_url': _s.source,
						'percent_played' : Math.round(_s.totalPercentPlayed * 100),
						'stopped_at_time': _s.getCurrentTime(),
						'duration' : _s.getTotalTime(),
						'full_screen': _s.isFullScreen_bl
					}

					_s.gtag('event', 'played', params);
				
					_s.totalTimePlayed = 0;
					_s.totalPercentPlayed = 0;
				}
			}
		}	

		_s.sendGAPlayedAdEvent = function(source, percentPlayed, duration){
			if(!source){
				source = _s.source;
			}

			if(!percentPlayed){
				percentPlayed = _s.totalPercentPlayed;
			}

			if(!duration){
				duration = _s.getTotalTime();
			}
			
			if(!isNaN(percentPlayed) && _s.gtag){
				if(Math.round(_s.totalPercentPlayed * 100)){

					var params = {
						'video_url': source,
						'percent_played' : Math.round(percentPlayed * 100),
						'stopped_at_time': _s.getCurrentTime(),
						'duration': duration,
						'full_screen': _s.isFullScreen_bl
					}
				
					_s.gtag('event', 'ads', params);

					_s.totalTimePlayed = 0;
					_s.totalPercentPlayed = 0;
				}
			}
		}	
		
		_s.stop = function(source){
			if(!_s.isAPIReady_bl) return;
			if(_s.isStopped_bl) return;
			
			_s.sendGAPlayedEvent();
			
			if(_s.isCasting){
				_s.cc.stop();
			}
			if(_s.IMA) _s.IMA.stop();
			
			FWDUVPPassword.isCorect = true;
			_s.totalTimePlayed = 0;
			_s.totalDuration = 0;
			_s.isIMA = undefined;
			_s.hlsLevels_ar = null;
			_s.hasPassedPassowrd_bl = false;
			_s.isHLSManifestReady_bl = false;
			_s.isDASHManifestReady_bl = false;
			clearInterval(_s.tryHLS_int);
			clearInterval(_s.checkIfYoutubePlayerIsReadyId_int);
			clearInterval(_s.keepCheckingYoutubeAPI_int);
			_s.hideAPT();
			_s.destroyDASH();
			_s.destroyHLS();
			_s._d.closeVast();
			if(_s.fps) _s.fps.stop();
			_s.isPlaying_bl = false;
			if(_s.customContextMenu_do) _s.customContextMenu_do.disable();
				
			if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
				_s.stopUpdateImageInterval();
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do){
				_s.ytb_do.stop();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.stop();
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO && _s.vimeo_do){
				_s.vimeo_do.stop();
			}else if(FWDUVPlayer.hasHTML5Video){
				_s.videoScreen_do.stop();
			}
			
			clearTimeout(_s.playVimeoWhenLoadedId_to); 
			if(_s.popw_do) _s.popw_do.hide();
			
			if(_s._d.playlist_ar[_s.id]){
				_s.posterPath_str = _s._d.playlist_ar[_s.id].posterSource;
			}
			
			if(_s.isMbl){
				if(_s._d.showControllerWhenVideoIsStopped_bl && _s.controller_do) _s.controller_do.show(true);
				
				_s.videoPoster_do.show();
				_s.lrgPlayBtn.show();
				
			}else{
				if(!_s.isThumbClick_bl){
					if(_s.controller_do && _s._d.showControllerWhenVideoIsStopped_bl) _s.controller_do.show(true);
					if(_s.videoPoster_do) _s.videoPoster_do.show();
					if(_s.lrgPlayBtn) _s.lrgPlayBtn.show();
				}
			}
			
			if(_s.controller_do){
				if(_s.controller_do.atb) _s.controller_do.atb.hide(true);
				if(_s.controller_do.subtitleButton_do){
					_s.controller_do.disableSubtitleButton();
					if(_s.subtitle_do){
						if(_s.subtitle_do.showSubByDflt){
							_s.controller_do.subtitleButton_do.setButtonState(0);
						}else{
							_s.controller_do.subtitleButton_do.setButtonState(1);
						}
					}
				}
				if(_s.controller_do.thumbnailsPreview_do) _s.controller_do.thumbnailsPreview_do.remove();

				if(_s.controller_do.atbButton_do){
					_s.controller_do.atbButton_do.doNotallowToSetNormal = false;
					_s.controller_do.atbButton_do.isSelected = false;
					_s.controller_do.atbButton_do.setNormalState();
				}

				_s.controller_do.disableAtbButton();
				if(_s.controller_do.ttm) _s.controller_do.ttm.hide();
				if(_s.controller_do.ytbQualityButton_do) _s.controller_do.ytbQualityButton_do.disable();
				if(_s.controller_do.playbackRateButton_do) _s.controller_do.playbackRateButton_do.disable();
				if(_s.controller_do && _s.controller_do.rewindButton_do) _s.controller_do.rewindButton_do.disable();
			}
			
			if(_s.popupAds_do){
				_s.popupAds_do.hideAllPopupButtons(false);
			}
			
			_s.hasHlsPlayedOnce_bl = false;
			_s.isSafeToScrub_bl = false;
			_s.hlsState = undefined;
			_s.changeHLS_bl = false;
			_s.totalDuration = 0;
			_s.hasStartedToPlay_bl = false;
			
			if(_s.controller_do){
				_s.controller_do.disablePlaybackRateButton();
				_s.controller_do.disableAtButton();
			}
			if(_s.subtitle_do) _s.subtitle_do.hide();
			if(_s.annotations_do) _s.annotations_do.update(-1);
			if(_s.hider) _s.hider.reset();
			_s.showCursor();
			if(_s.adsStart_do) _s.adsStart_do.hide(true);
			if(_s.adsSkip_do) _s.adsSkip_do.hide(true);
			if(_s.controller_do) _s.controller_do.hideAdsLines();
			_s.stopVisualization();
			_s.isStopped_bl = false;
		};
		
		_s.startToScrub = function(){
			if(!_s.isAPIReady_bl) return;
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do && _s.ytb_do.isSafeToBeControlled_bl){
				_s.ytb_do.startToScrub();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.startToScrub();
			}else{
				if(_s.videoScreen_do) _s.videoScreen_do.startToScrub();
			}
		};
		
		_s.stopToScrub = function(){
			if(!_s.isAPIReady_bl) return;
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do && _s.ytb_do.isSafeToBeControlled_bl){
				_s.ytb_do.stopToScrub();
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.stopToScrub();
			}else {
				if(_s.videoScreen_do) _s.videoScreen_do.stopToScrub();
			}
		};
		
		_s.scrubbAtTime = function(duration){
			if(!_s.isAPIReady_bl || !duration) return;
			if(String(duration).indexOf(":") != -1) duration = FWDUVPUtils.getSecondsFromString(duration);
			if(_s.isCasting){
				_s.cc.scrubbAtTime(duration);
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do && _s.ytb_do.isSafeToBeControlled_bl){
				_s.ytb_do.scrubbAtTime(duration);
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO && _s.vimeo_do){
				_s.vimeo_do.scrubbAtTime(duration);
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.scrubbAtTime(duration);
			}else if(FWDUVPlayer.hasHTML5Video){
				if(_s.videoScreen_do) _s.videoScreen_do.scrubbAtTime(duration);
			}
		};
		
		_s.scrub = function(percent){
			if(!_s.isAPIReady_bl) return;
			if(isNaN(percent)) return;
			if(percent < 0){
				percent = 0;
			}else if(percent > 1){
				percent = 1;
			}
			
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do && _s.ytb_do.isSafeToBeControlled_bl){
				_s.ytb_do.scrub(percent);
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				if(_s.audioScreen_do) _s.audioScreen_do.scrub(percent);
			}else if(_s.videoType_str == FWDUVPlayer.VIMEO && _s.vimeo_do && _s.vimeo_do.isSafeToBeControlled_bl){
				_s.vimeo_do.scrub(percent);
			}else{
				if(_s.videoScreen_do) _s.videoScreen_do.scrub(percent);
			}
		};
		
		_s.setVolume = function(volume, removeAutoPlay){
			if(!_s.isAPIReady_bl) return;
			_s.volume = volume;

			if(volume && removeAutoPlay){
				_s._d.autoPlay_bl = false;
				_s.removeAPT();
			} 

			if(_s.controller_do) _s.controller_do.updateVolume(volume, true);
			
			if(_s.isIMA) _s.IMA.setVolume(volume);
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE && _s.ytb_do){
				_s.ytb_do.setVolume(volume);
			}
			
			if(_s.videoType_str == FWDUVPlayer.VIMEO && _s.vimeo_do){
				_s.vimeo_do.setVolume(volume);
			}
			
			if(_s.audioScreen_do){
				_s.audioScreen_do.setVolume(volume);
			}
			
			if(FWDUVPlayer.hasHTML5Video){
				if(_s.videoScreen_do) _s.videoScreen_do.setVolume(volume);
			}
			
			if(_s.isCasting){
				_s.cc.setVolume();
			}
			
			_s.dispatchEvent(FWDUVPlayer.VOLUME_SET, {volume:volume});
		};
			
		_s.showCategories = function(){
			
			if(!_s.isAPIReady_bl) return;
			_s.setVideoPlayingStateOnWindowShow();
			
			if(_s.categories_do){
				_s.categories_do.show(_s.catId);
				if(_s.controller_do) _s.controller_do.setCategoriesButtonState("selected");
				_s.pause();
			}
		};
		
		_s.hideCategories = function(){
			if(!_s.isAPIReady_bl) return;
			if(_s.categories_do){
				_s.categories_do.hide();
				if(_s.controller_do) _s.controller_do.setCategoriesButtonState("unselected");
			}
		};
		
		_s.showPlaylist = function(){
			if(!_s.isAPIReady_bl || !_s.showPlaylistButtonAndPlaylist_bl) return;
			_s.isPlaylistShowed_bl = false;
			
			if(_s.controller_do) _s.controller_do.showHidePlaylistButton();
			_s.playlist_do.hide(_s.animate_bl);
			if(_s.playlistPosition_str == 'right'){
				_s.resizeHandler(!_s.isMbl);
			}
			
			_s.sH = _s.vidStageHeight;
			_s.setStageContainerFinalHeightAndPosition(_s.animate_bl);

			FWDAnimation.to(_s, .8, {tempStageWidth:_s.sW,
										 tempStageHeight:_s.sH,
										 tempVidStageWidth:_s.vidStageWidth,
										 tempVidStageHeight:_s.vidStageHeight,
										 ease:Expo.easeInOut,
										 onUpdate:_s.resizeFinal});
		};
		
		_s.hidePlaylist = function(resNoAnim){
			if(!_s.isAPIReady_bl || !_s.showPlaylistButtonAndPlaylist_bl) return;
			
			_s.isPlaylistShowed_bl = true;
			if(_s.controller_do) _s.controller_do.showShowPlaylistButton();
			if(resNoAnim){
				_s.playlist_do.show(false);
			}else{
				_s.playlist_do.show(_s.animate_bl);
			}
			
			_s.resizeHandler(_s.animate_bl);
			_s.setStageContainerFinalHeightAndPosition(_s.animate_bl);
			
			FWDAnimation.to(_s, .8, {tempStageWidth:_s.sW,
										 tempStageHeight:_s.sH,
										 tempVidStageWidth:_s.vidStageWidth,
										 tempVidStageHeight:_s.vidStageHeight,
										 ease:Expo.easeInOut,
										 onUpdate:_s.resizeFinal});
		
		};
		
		_s.setPosterSource = function(path){
			
			if(!_s.isAPIReady_bl || !path || _s.videoType_str == 'none') return;
			var path_ar = path.split(",");
				
			if(_s.isMbl && path_ar[1] != undefined){
				path = path_ar[1];
			}else{
				path = path_ar[0];
			}

			if(!_s.videoPoster_do) return;
			_s.posterPath_str = path;
			
			_s.videoPoster_do.setPoster(_s.posterPath_str);
			if(_s.prUVPosterSource_str != path) _s.dispatchEvent(FWDUVPlayer.UPDATE_POSTER_SOURCE);
			
			_s.prUVPosterSource_str = path;
		};
		
		_s.setThumbnailPreviewSource = function(source){
			if(!_s.isAPIReady_bl || FWDUVPUtils.isLocal) return;
			if(_s.controller_do){
				
				if(!_s.thumbnailsPreviewLoaded_bl){
					var script = document.createElement('script');
					script.src =  _s.mainFolderPath_str + 'java/FWDUVPThumbnailsPreview.js'
					document.head.appendChild(script);
	
					script.onload = function () {
						_s.thumbnailsPreviewLoaded_bl = true;
						_s.setThumbnailPreviewSource(source);
					}
					return;
				}
					
				_s.hasThumbnailsPreview = true;
				_s.controller_do.setupThumbnailsPreview()
				_s.controller_do.thumbnailsPreview_do.load(source);
			}
		}

		
		//#####################################################//
		/* Update ads */
		//#####################################################//
		_s.updateAds = function(duration, setSourceOverwrite){
			if(_s._d.vastXML && !_s._d.isVastXMLParsed_bl){
				if(_s.controller_do){
					_s.controller_do.hideAdsLines();
					_s.controller_do.resetsAdsLines();
				}
				_s._d.setVastSource(_s._d.vastXML);
				return;
			} 

			if(!_s._d.playlist_ar[_s.id]) return;
			_s.curAddData = _s._d.playlist_ar[_s.id].ads_ar;

			_s.curPopupAdsData = _s._d.playlist_ar[_s.id].popupAds_ar;
			var hasPopupAds = (_s.curPopupAdsData && _s.curPopupAdsData.length > 0);
			
			if(_s.adsId != _s.id){
				if(_s.popupAds_do) _s.popupAds_do.hideAllPopupButtons(true);
				if(_s.controller_do) _s.controller_do.resetsAdsLines();
			}
			
			if(_s._d.playlist_ar[_s.id].vastURL && !_s.curAddData){
				if(_s.adsId != _s.id){
					_s._d.setVastSource(_s._d.playlist_ar[_s.id].vastURL, _s._d.playlist_ar[_s.id].vastLinearStartTime);
				}
				_s.adsId = _s.id;
				return;
			}
			_s.adsId = _s.id;
			
			if(!_s.isAdd_bl){
				_s.TrackingEvents = undefined;
				_s.Impression = undefined;
				_s.ClickTracking = undefined;
				if(_s.curAddData){
					_s.callFirstQuartile = true;
					_s.callMidpoint = true;
					_s.callThirdQuartile = true;
				}
			}
			
			if(!_s.isAdd_bl){
				if(_s.controller_do){

					if(_s.totalDuration){
						_s._d.fixVmapTimes(_s.totalDuration, _s.curAddData, _s.curPopupAdsData, _s.id);
						_s.controller_do.setupAdsLines(_s.curAddData, _s.id, _s.catId);
						if(_s.totalDuration) _s.controller_do.positionAdsLines(_s.totalDuration);
						if(hasPopupAds){
							_s.popupAds_do.resetPopups(_s.curPopupAdsData, _s.id);
							_s.popupAds_do.id = _s.id;
						}
					}
				}
				
				_s.curSource = _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["source"];
				
				if(_s.curAddData){
					for(var i=0; i<_s.curAddData.length; i++){
						if(duration >= _s.curAddData[i].timeStart && duration <= (_s.curAddData[i].timeStart + 1) 
							&& !_s.curAddData[i].played_bl && duration != _s.prevDuration){
								
							_s.addId = i;
							if(_s.curAddData[i].timeStart == 0){
								setSourceOverwrite = false;
								_s.addStartAtZero = true;
							}else{
								_s.addStartAtZero = false;
							}
							_s.isAdd_bl = true;
						
							_s.addSource_str = _s.curAddData[i].source;
							_s.curAddData[_s.addId].played_bl = true;
							_s.adDuation = duration;
						
							_s._d.adsThumbnailPath_str = _s.curAddData[i].thumbnailSource;
							_s._d.timeToHoldAds = _s.curAddData[i].timeToHoldAds;
							_s._d.adsPageToOpenURL_str = _s.curAddData[i].link;
							_s._d.adsPageToOpenTarget_str = _s.curAddData[i].target;
							_s.TrackingEvents = _s.curAddData[i].TrackingEvents;
							_s.Impression = _s.curAddData[i].Impression
							_s.ClickTracking = _s.curAddData[i].ClickTracking
							_s.scrubAfterAddDuration = _s.curAddData[i].timeStart;
							_s.curImageTotalTime = _s.curAddData[i].addDuration;
							_s.setSource(_s.addSource_str);
						
							if(_s.controller_do && _s.controller_do.line_ar) _s.controller_do.line_ar[i].setVisible(false);
							_s.prvAdSource = _s.addSource_str;
							return;
						}
					}
				}
			}else{
				if(!_s.isAdd_bl){
					_s.curSource = _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["source"];
				}else{
					_s.curSource = "FWDUVPDummy" + new Date().getTime();
				}
			}
		
			
			_s.isLive = _s._d.playlist_ar[_s.id]["isLive"];
			
			if(!_s.isAdd_bl && _s.prevSource != _s.curSource && _s.curSource.indexOf("FWDUVPDummy") == -1 || setSourceOverwrite){
				if(setSourceOverwrite){
					_s.isAdd_bl = false;
					_s.curSource = _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["source"]
				}
				_s.setSource(_s.curSource, false, _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["is360"]);
			}
			if(_s.controller_do) _s.controller_do.positionAdsLines(_s.curDuration);
			_s.prevDuration = duration;
			_s.prevSource = _s.curSource;
		};
		

		//#####################################################//
		/* Setup image screen */
		//#####################################################//
		_s.updateImageScreen = function(source){
			if(_s.videoType_str == FWDUVPlayer.IFRAME){
				if(!_s.ifr_do){		
					_s.ifr_do = new FWDUVPDisplayObject("iframe");
					_s.ifr_do.hasTransform3d_bl = false;
					_s.ifr_do.hasTransform2d_bl = false;
					_s.ifr_do.setBackfaceVisibility();
				}
				
				_s.videoHolder_do.addChildAt(_s.ifr_do, _s.videoHolder_do.getChildIndex(_s.dClk_do) + 1);
				_s.showClickScreen();
				
				_s.ifr_do.screen.src = source;
				_s.ifr_do.setBkColor("#000000");
				_s.positionAdsImage();
				_s.startToUpdateAdsButton();
				return;
			}

			if(!_s.imgH_do){
				_s.imgH_do = new FWDUVPDisplayObject("div");
				_s.imgH_do.setX(0);
				_s.imgH_do.setY(0);
				_s.imgH_do.setBkColor("#000000");
			}
			
			_s.videoHolder_do.addChildAt(_s.imgH_do,  _s.videoHolder_do.getChildIndex(_s.dClk_do) - 1);
			_s.showClickScreen();
			if(_s.imgH_do.contains(_s.imageScreen_do)) _s.imgH_do.removeChild(_s.imageScreen_do);
			_s.imageScreen_do = null;
			
			_s.imageScreen_do = new FWDUVPDisplayObject("img");
			
			_s.imageAdd_img = new Image()
			_s.imageAdd_img.src = source;
		
			if(_s.preloader_do){
				_s.preloader_do.show(false);
			}
			if(_s.lrgPlayBtn) _s.lrgPlayBtn.hide();
			
			_s.imageAdd_img.onload = function(){
				_s.imageScreen_do.setScreen(_s.imageAdd_img);
				_s.imageScreen_do.setAlpha(0);
				FWDAnimation.to(_s.imageScreen_do, 1, {alpha:1});
				_s.imageAddOriginalWidth = _s.imageAdd_img.width;
				_s.imageAddOriginalHeight = _s.imageAdd_img.height;
				if(_s.preloader_do) _s.preloader_do.hide();
				_s.imgH_do.addChild(_s.imageScreen_do);
				_s.positionAdsImage();
				_s.startToUpdateAdsButton();
			}
			
			_s.imageAdd_img.onerror = function(){
				_s.showSourceError("Advertisment image with path " +  source + " can't be found");
				return;
			}
		}
		
		_s.positionAdsImage = function(){

			if(_s.videoType_str == FWDUVPlayer.IFRAME && _s.ifr_do){
				_s.ifr_do.setWidth(_s.tempVidStageWidth);
				_s.ifr_do.setHeight(_s.tempVidStageHeight);
			}

			if(!_s.imageScreen_do || _s.videoType_str != FWDUVPlayer.IMAGE) return;
			var scaleX = _s.tempVidStageWidth/_s.imageAddOriginalWidth;
			var scaleY = _s.tempVidStageHeight/_s.imageAddOriginalHeight;
			
			var totalScale = 0;
			if(scaleX >= scaleY){
				totalScale = scaleX;
			}else if(scaleX <= scaleY){
				totalScale = scaleY;
			}
			
			var finalW = parseInt(_s.imageAddOriginalWidth * totalScale);
			var finalH = parseInt(_s.imageAddOriginalHeight * totalScale);
			var finalX = parseInt((_s.tempVidStageWidth - finalW)/2);
			var finalY = parseInt((_s.tempVidStageHeight - finalH)/2);
			
			_s.imageScreen_do.setWidth(finalW); 
			_s.imageScreen_do.setHeight(finalH); 
			_s.imageScreen_do.setX(finalX); 
			_s.imageScreen_do.setY(finalY); 
			_s.imgH_do.setWidth(_s.tempVidStageWidth);
			_s.imgH_do.setHeight(_s.tempVidStageHeight);
		}
		
		_s.startToUpdateAdsButton = function(){
			_s.curImageTime = 0;
			_s.updateAdsButton();
			_s.stopUpdateImageInterval();
			
			if(_s._d.autoPlay_bl || _s.adDuation || _s.isThumbClick_bl){ 
				_s.startUpdateImageInterval();
				_s.setPlayAndPauseButtonState();	
			}
		}
		
		_s.stopUpdateImageInterval = function(){
			_s.isImageAdsPlaying_bl = false;
			clearInterval(_s.startUpdateAdsId_int);
			_s.setPlayAndPauseButtonState();
			_s.isPlaying_bl = false;
			_s.hider.stop();	
		}
		
		_s.startUpdateImageInterval = function(){
			_s.isImageAdsPlaying_bl = true;
			_s.startUpdateAdsId_int = setInterval(_s.updateAdsButton, 1000);
			_s.setPlayAndPauseButtonState();
			if(_s.lrgPlayBtn) _s.lrgPlayBtn.hide();
			_s.isPlaying_bl = true;
			_s.hider.start();
		}
		
		_s.updateAdsButton = function(){
			_s.videoScreenUpdateTimeHandler({curTime:FWDUVPUtils.formatTime(_s.curImageTime), totalTime:FWDUVPUtils.formatTime(_s.curImageTotalTime), seconds:_s.curImageTime});
			_s.videoScreenUpdateHandler({percent:_s.curImageTime/_s.curImageTotalTime});
			if(_s.curImageTime == _s.curImageTotalTime) _s.videoScreenPlayCompleteHandler();
			_s.curImageTime += 1;
		}
		
		_s.setPlayAndPauseButtonState = function(){
			if(_s.isImageAdsPlaying_bl){
				if(_s.controller_do) _s.controller_do.showPauseButton();
			}else{
				if(_s.controller_do) _s.controller_do.showPlayButton();
			}
		}
		
		// Set source
		_s.showSourceError = function(txt){
			_s.main_do.addChild(_s.info_do);
			_s.info_do.showText(txt);
			if(_s.preloader_do) _s.preloader_do.hide();
			_s.resizeHandler();
		}
		
		_s.setSource = function(source, overwrite, is360){
			
			if(source) _s.source = source;

			if(_s._d.playlist_ar && _s._d.playlist_ar[_s.id] && !_s._d.playlist_ar[_s.id]['playIfLoggedIn']){
				if(_s.lg_do) _s.lg_do.hide();
			}
			
			_s.is360 = is360;

			// Thumbnails preview.
			if(_s._d.playlist_ar && _s._d.playlist_ar[_s.id]['thumbnailsPreview']){
				if(location.protocol.indexOf("file:") != -1){
					setTimeout(function(){
						_s.showSourceError("This browser doesn't allow thumbnails preview videos local, please test online.")
					}, 50);
				}

				if(_s._d.playlist_ar[_s.id]['thumbnailsPreview'].length > 2
				   && location.protocol.indexOf("file:") == -1
				   && !_s.thumbnailsPreviewLoaded_bl){
					var script = document.createElement('script');
					script.src =  _s.mainFolderPath_str + 'java/FWDUVPThumbnailsPreview.js'
					document.head.appendChild(script);
					
					script.onerror = function(e){
						_s.main_do.addChild(_s.info_do);
						_s.showSourceError('The thumbnails preview javascript file named <font color="#FF0000">FWDUVPThumbnailsPreview.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPThumbnailsPreview.js</font> file.');
					}
					
					script.onload = function () {
						_s.thumbnailsPreviewLoaded_bl = true;
						_s.setSource(_s.source, false, _s.is360);
					}
					return;
				}
			}
			
			_s.hasThumbnailsPreview = false;
			if(_s._d.playlist_ar[_s.id]['thumbnailsPreview'] && _s._d.playlist_ar[_s.id]['thumbnailsPreview'].length > 2){
				_s.hasThumbnailsPreview = true;
				if(_s.controller_do) _s.controller_do.setupThumbnailsPreview();
			}
			
			if(!_s.isAPIReady_bl || _s.id == -1) return;
			
			if(_s.id < 0){
				_s.id = 0;
			}else if(_s.id > _s.totaadsIdeos - 1){
				_s.id = _s.totaadsIdeos - 1;
			}
			
			if(_s._d.playlist_ar[_s.id] == undefined) return;
			
			_s.stop(source);

			// Remove APT.
			if(_s.isThumbClick_bl && !_s.aptRemoved){
				_s._d.autoPlay_bl = false;
				_s.removeAPT();
				_s.setVolume(_s._d.volume, true);
			}

			// Cuepoints.
			_s.cuePointsSource_ar = _s._d.playlist_ar[_s.id].cuepoints_ar;
			
			// Advertisement.
			if(_s.playlist_do && _s.playlist_do.curId != _s.id){
				_s.prvAdSource = Math.random() * 999999999;
				if(!_s._d.playAdsOnlyOnce_bl){
					for(var i=0; i<_s._d.playlist_ar.length; i++){
						if(_s._d.playlist_ar[i].ads_ar){
							for(var j=0; j<_s._d.playlist_ar[i].ads_ar.length; j++){
								_s._d.playlist_ar[i].ads_ar[j].played_bl = false;
							}
						}	
						if(_s._d.playlist_ar[i].popupAds_ar){
							for(var j=0; j<_s._d.playlist_ar[i].popupAds_ar.length; j++){
								_s._d.playlist_ar[i].popupAds_ar[j].isClsd = false;
							}
						}	
					}
				}

				if(!_s._d.executeCuepointsOnlyOnce_bl){
					if(_s.cuePointsSource_ar){
						for(var i=0; i<_s.cuePointsSource_ar.length; i++){
							_s.cuePointsSource_ar[i].played_bl = false;
						}
					}
				}
			}
		
			if(source.toLowerCase().indexOf("vimeo.com") != -1 
			   && source.toLowerCase().indexOf(".m3u8") == -1
			   && source.toLowerCase().indexOf(".mp4") == -1){
				_s.videoType_str = FWDUVPlayer.VIMEO;
			}else if(source.toLowerCase().indexOf("youtube.") != -1){
				_s.videoType_str = FWDUVPlayer.YOUTUBE;
			}else if(source.toLowerCase().indexOf(".mp3") != -1){
				_s.videoType_str = FWDUVPlayer.MP3;
				if(_s.controller_do) _s.controller_do.setX(0);
			}else if(source.toLowerCase().indexOf(".jpg") != -1 
					|| source.toLowerCase().indexOf(".jpeg") != -1 
					|| source.toLowerCase().indexOf(".png") != -1
			){
				_s.videoType_str = FWDUVPlayer.IMAGE;
				if(_s.controller_do) _s.controller_do.setX(0);
			}else if(!source.match(/\.mpd|\.m3u8|\.mp4|\.mov|google.com|lh3.|myqnapcloud/ig)){
				_s.videoType_str = FWDUVPlayer.IFRAME;
				if(_s.controller_do) _s.controller_do.setX(0);
			}else{
				if(_s.controller_do) _s.controller_do.setX(0);
				if(!FWDUVPlayer.hasHTMLHLS && source.toLowerCase().indexOf(".m3u8") != -1){
					_s.videoType_str = FWDUVPlayer.HLS_JS;
				}else if(source.toLowerCase().indexOf(".mpd") != -1){
					_s.videoType_str = FWDUVPlayer.DASH;
				}else{
					_s.videoType_str = FWDUVPlayer.VIDEO;
				}
			}

			_s.videoSourcePath_str = source;
			_s.finalVideoPath_str = source;
			_s.posterPath_str = _s._d.playlist_ar[_s.id].posterSource;

			// Set is live.
			if(_s.controller_do) _s.controller_do.setIsLive(_s.isLive);
			
			// IMA
			var isIMA = _s._d.playlist_ar[_s.id].imaURL;
			if(_s.videoType_str != FWDUVPlayer.VIDEO || _s.errorImaSDK) isIMA = false;
			if(isIMA){
				_s.isIMA = isIMA;
				if(!_s._d.imaReady){
					_s._d.startToLoadIMA();
					return;
				}
				
				if(!_s.IMA){
					FWDUVPIMA.setPrototype();
					_s.IMA = new FWDUVPIMA(_s);
				}
			}
			if(!_s.IMA) _s.isIMA = false;
			
			// Casting
			if(_s.cc) _s.cc.checkButtonState();

			//DASH
			if(source.indexOf(".mpd") != -1 && !_s.isDASHLoaded_bl && !FWDUVPlayer.isDASHLoaded_bl){
				if(location.protocol.indexOf("file:") != -1){
					_s.showSourceError("This browser doesn't allow playing MPEG DASH videos local, please test online.");
					return;
				}

				var script = document.createElement('script');
				script.src = _s._d.dashPath_str;
				document.head.appendChild(script);
				script.onerror = function(){
					_s.showSourceError("Error loading MPEG DASH library <font color='#FF0000'>" + _s._d.dashPath_str + "</font>.")
					return;
				}

				script.onload = function () {
					_s.isDASHLoaded_bl = true;
					FWDUVPlayer.isDASHLoaded_bl = true;
					_s.setupDASH();
					_s.setSource(source, false, _s.is360);
				}

				if(_s.isMbl) _s.isThumbClick_bl = false;

				if(!_s._d.autoPlay_bl && !_s.isThumbClick_bl){
					_s.setPosterSource(_s.posterPath_str);
					if(_s.videoPoster_do) _s.videoPoster_do.show();
					if(_s.lrgPlayBtn) _s.lrgPlayBtn.show();
				}
				return;
			}
			

			// HLS
			if(!FWDUVPlayer.hasHTMLHLS && source.indexOf(".m3u8") != -1 && !_s.isHLSJsLoaded_bl && !FWDUVPlayer.isHLSJsLoaded_bl){
				// if(location.protocol.indexOf("file:") != -1){
				// 	_s.showSourceError("This browser doesn't allow playing HLS videos local, please test online.")
				// 	return;
				// }
				
				var script = document.createElement('script');
				script.src = _s._d.hlsPath_str;
				document.head.appendChild(script);
				script.onerror = function(){3
					_s.showSourceError("Error loading HLS library <font color='#FF0000'>" + _s._d.hlsPath_str + "</font>.")
					return;
				}
				
				script.onload = function () {
					_s.isHLSJsLoaded_bl = true;
					FWDUVPlayer.isHLSJsLoaded_bl = true;
					_s.setupHLS();
					_s.setSource(source, false, _s.is360);
				}
				
				if(!_s._d.autoPlay_bl && !_s.isThumbClick_bl){
					_s.setPosterSource(_s.posterPath_str);
					if(_s.videoPoster_do) _s.videoPoster_do.show();
					if(_s.lrgPlayBtn) _s.lrgPlayBtn.show();
				}
				return;
			}
			
			if(source.indexOf("youtube.") != -1 && !_s.ytb_do){
				setTimeout(function(){
					
					if(_s.showPreloader_bl){
						_s.main_do.addChild(_s.preloader_do);	
						if(_s.preloader_do){
							_s.preloader_do.show(false);
						}
						if(_s.lrgPlayBtn) _s.lrgPlayBtn.hide();
						
						if(location.protocol.indexOf("file:") != -1 && FWDUVPUtils.isIE) _s.main_do.addChild(_s.info_do);
					}
				}, 50);
				
				if(location.protocol.indexOf("file:") != -1 && FWDUVPUtils.isIE){
					_s.showSourceError("This browser doesn't allow the Youtube API to run local, please test it online or in another browser like Firefox or Chrome.");
					return;
				}	
				
				_s.setupYoutubeAPI();
				return;
			}
		
			if(source.indexOf("vimeo.") != -1 && !_s.vimeo_do && _s.videoType_str == FWDUVPlayer.VIMEO){
					
				if(location.protocol.indexOf("file:") != -1){
					_s.showSourceError("This browser doesn't allow playing Vimeo videos local, please test online.");
					return;
				}
				
				if(_s.showPreloader_bl){
					_s.main_do.addChild(_s.preloader_do);	
					if(_s.preloader_do){
						_s.preloader_do.show(false);
					}
				}
				if(_s.lrgPlayBtn) _s.lrgPlayBtn.hide();
			
				_s.setupVimeoAPI();
				return;
			}
			
			
			if(_s.is360  && !_s.isThreeJsOrbigLoaded_bl && (_s.videoType_str == FWDUVPlayer.VIDEO && _s.videoType_str != FWDUVPlayer.HLS_JS)){
					
				if(FWDUVPUtils.isLocal){
					_s.showSourceError("This browser doesn't allow playing 360 videos local, please test online.");
					return;
				}
				
				if(!FWDUVPUtils.hasWEBGL){
					_s.showSourceError("Playing 360 videos in _s browser is not possible because it doesn't support WEBGL.");
					return;
				}
				
				if(!_s.isThreeJsLoaded_bl && !FWDUVPlayer.hasThreeJsLoaded_bl){
					var script = document.createElement('script');
					script.src = _s._d.threeJsPath_str;
					script.onerror = function(){
						_s.showSourceError("Error loading 360 degree library <font color='#FF0000'>" + _s._d.threeJsPath_str + "</font>.");
						return;
					}
					script.onload = function () {
						_s.isThreeJsOrbigLoaded_bl = true;
						
							var script2 = document.createElement('script');
							script2.src = _s._d.threeJsControlsPath_str;
							script2.onerror = function(){
								_s.showSourceError("Error loading three.js from <font color='#FF0000'>" + _s._d.threeJsControlsPath_str + "</font>.");
								return;
							}
							script2.onload = function () {
								FWDUVPlayer.hasThreeJsLoaded_bl = true;
								_s.isThreeJsOrbitLoaded_bl = true;
								if(_s.isThreeJsOrbigLoaded_bl && _s.isThreeJsOrbitLoaded_bl) _s.setSource(source, true, true);
								clearTimeout(_s.load360ScriptsId_to);
								if(_s.preloader_do) _s.preloader_do.hide();
							};
							document.head.appendChild(script2);
							};

					document.head.appendChild(script);
					
					
					_s.load360ScriptsId_to = setTimeout(function(){
						if(_s.showPreloader_bl){
							if(_s.preloader_do){
								_s.preloader_do.show(false);
							}
						}
					},1000);
					return;
				}
			}
			
			if(_s.is360){
				_s.dClk_do.getStyle().cursor = 'url(' + _s._d.handPath_str + '), default';
			}else{
				_s.dClk_do.getStyle().cursor = "auto";
			}

			_s.rotationY360DegreeVideo = _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["rotationY360DegreeVideo"];
			_s.startWhenPlayButtonClick360DegreeVideo = _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["startWhenPlayButtonClick360DegreeVideo"];


			if(_s._d.playlist_ar[_s.id] && _s._d.playlist_ar[_s.id].scrubAtTimeAtFirstPlay) _s.playAtTime_bl = true;
			if(_s.controller_do && _s.controller_do.rewindButton_do) _s.controller_do.rewindButton_do.disable();
		
			_s.popwSource = _s._d.playlist_ar[_s.id]._dAdvertisementOnPauseSource;
			if(_s._d.playlist_ar[_s.id] && _s._d.playlist_ar[_s.id]._dAdvertisementOnPauseSource){
				_s.showPopW_bl = true;
			}else{
				_s.showPopW_bl = false;
			}

			if(!source) source = _s._d.playlist_ar[_s.id].videoSource[_s._d.playlist_ar[_s.id].startAtVideo].source;

			if(source.indexOf("youtube.") != -1){
				var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
				source = source.match(regExp)[2];
			}
			
			if(_s.controller_do) _s.controller_do.enablePlayButton();
			_s.prevVideoSource_str = source;
			
			if(!source){
				_s.showSourceError("Video source is not defined!");
				return;
			}
		
			if(_s.playlist_do){
				_s.playlist_do.curId = _s.id;
				_s.playlist_do.checkThumbsState();
			}
			
			if(_s.controller_do && _s._d.playlist_ar[_s.id].subtitleSource && _s._d.playlist_ar[_s.id].subtitleSource.length > 1){
				_s.subsSource_ar = _s._d.playlist_ar[_s.id].subtitleSource;
				_s.subsStartAtSubtitle = Number(_s._d.playlist_ar[_s.id].startAtSubtitle);
				_s.controller_do.updateSubtitleButtons(_s.subsSource_ar, _s.subsStartAtSubtitle);
				_s.ccSS = Number(_s._d.playlist_ar[_s.id].subtitleSource.length - _s._d.playlist_ar[_s.id].startAtSubtitle);
			}
			_s.subtitle_do.stopToLoadSubtitle();
			
			if(_s.controller_do){
				_s.controller_do.updateHexColorForScrubber(_s.isAdd_bl);
				_s.controller_do.removeAtButton();
			} 
			
			_s.annotations_ar = _s._d.playlist_ar[_s.id].annotations_ar;
			_s.annotations_do.setupAnnotations(_s.annotations_ar);
			
			_s.startAtPlaybackIndex = _s._d.startAtPlaybackIndex;
			
			if(_s._d.playlist_ar[_s.id]["_dPlaybackRate"] == "0.25"){
				_s.startAtPlaybackIndex = 5;
			}else if(_s._d.playlist_ar[_s.id]["_dPlaybackRate"] == "0.5"){
				_s.startAtPlaybackIndex = 4;
			}else if(_s._d.playlist_ar[_s.id]["_dPlaybackRate"] == "1"){
				_s.startAtPlaybackIndex = 3;
			}else if(_s._d.playlist_ar[_s.id]["_dPlaybackRate"] == "1.25"){
				_s.startAtPlaybackIndex = 2;
			}else if(_s._d.playlist_ar[_s.id]["_dPlaybackRate"] == "1.5"){
				_s.startAtPlaybackIndex = 1;
			}else if(_s._d.playlist_ar[_s.id]["_dPlaybackRate"] == "2"){
				_s.startAtPlaybackIndex = 0;
			}
			
			_s.prevVideoSourcePath_str = _s.videoSourcePath_str;
			_s.resizeHandler(false, true);
			
			// Image & iframe
			if(_s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
				_s.updateImageScreen(_s.videoSourcePath_str);
				if(_s.videoPoster_do) _s.videoPoster_do.setX(-5000);
				return;
			}else{
				if(_s.videoHolder_do.contains(_s.ifr_do)) _s.videoHolder_do.removeChild(_s.ifr_do);
				if(_s.videoHolder_do.contains(_s.imgH_do)) _s.videoHolder_do.removeChild(_s.imgH_do);
		   		if(_s.videoPoster_do) _s.videoPoster_do.setX(0);
			}
			
			if(_s.getVideoSource()) _s.dispatchEvent(FWDUVPlayer.UPDATE_VIDEO_SOURCE);
			

			//Vimeo
			if(_s.videoType_str == FWDUVPlayer.VIMEO){
				
				if(_s.ytb_do && _s.ytb_do.ytb ){
					_s.ytb_do.showDisable();
				}
				if(_s.ytb_do) _s.ytb_do.setX(-5000);

				if(_s.videoScreen_do) _s.videoScreen_do.setX(-5000);
				if(_s.vimeo_do.x != 0) _s.vimeo_do.setX(0);
			
				if(_s.isAdd_bl){
					_s.showClickScreen();
				}else{
					_s.hideClickScreen();
				}
				
				if(_s.audioScreen_do) _s.audioScreen_do.setX(-5000);
				_s.audioScreen_do.setVisible(false);
				
				if(_s.videoScreen_do) _s.videoScreen_do.setVisible(false);
				if(_s.controller_do) _s.controller_do.removePlaybackRateButton();

				if(_s.controller_do){
					_s.controller_do.hideQualityButtons(false);
					_s.controller_do.removeYtbQualityButton();
				}
				
				 _s.videoPoster_do.hide(true);
				_s.setPosterSource(_s.posterPath_str);
				
				_s.vimeo_do.setSource(source);

				if(_s.getVideoSource()) _s.dispatchEvent(FWDUVPlayer.UPDATE_VIDEO_SOURCE);
				_s.resizeHandler();
				return;
			}
			
			//Youtube
			if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
				
				if(_s.vimeo_do) _s.vimeo_do.setX(-5000);
				_s.videoScreen_do.setX(-5000);
				_s.videoScreen_do.setVisible(false);
				
				if(_s.audioScreen_do) _s.audioScreen_do.setX(-5000);
				_s.audioScreen_do.setVisible(false);
								
				if(_s.ytb_do) _s.ytb_do.setX(0);

				if(_s.ytb_do && _s.ytb_do.ytb && !_s.is360){
					_s.ytb_do.showDisable();
				}else{
					_s.ytb_do.hideDisable();
				}
				
				_s.videoPoster_do.hide(true);
				_s.setPosterSource(_s.posterPath_str);

				if(_s.lrgPlayBtn && !_s._d.showAnnotationsPositionTool_bl){
					if(_s.videoPoster_do) _s.videoPoster_do.show();
					_s.lrgPlayBtn.show();
				}
				
				_s.isTempYoutubeAdd_bl = false;
				_s.ytb_do.setSource(source);

				if(_s.controller_do){
					_s.controller_do.addYtbQualityButton();
					if(_s.controller_do){
						if(_s.videoType_str == FWDUVPlayer.VIMEO || _s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
							_s.controller_do.removePlaybackRateButton();
						}else{
							_s.controller_do.addPlaybackRateButton(_s.startAtPlaybackIndex);
						}
					}
				}

				if(_s.isAdd_bl){
					_s.setPlaybackRate(1);
				}else{
					_s.setPlaybackRate(_s._d.defaultPlaybackRate_ar[_s._d.startAtPlaybackIndex]);
				}

				if(_s.controller_do && _s._d.showPlaybackRateButton_bl){
					_s.controller_do.updatePlaybackRateButtons(_s.startAtPlaybackIndex);
				}
				
				_s.resizeHandler(false, true);
				if(_s.getVideoSource()) _s.dispatchEvent(FWDUVPlayer.UPDATE_VIDEO_SOURCE);
				return;
			}
			
			_s.finalVideoPath_str = source;
			
			if(_s.videoType_str == FWDUVPlayer.MP3){
				
				if(_s.vimeo_do) _s.vimeo_do.setX(-5000);
				if(_s.ytb_do) _s.ytb_do.setX(-5000);
				if(_s.ytb_do && _s.ytb_do.ytb){
					_s.ytb_do.showDisable();
				}
				
				if(_s.audioScreen_do) _s.audioScreen_do.setX(-5000);
				_s.audioScreen_do.setVisible(false);
				_s.videoScreen_do.setVisible(true);
				
				
				if(_s.controller_do && _s._d.playlist_ar[_s.id].videoSource.length > 1){
					_s.controller_do.updatePreloaderBar(0);
					if(_s.controller_do){
						_s.controller_do.addYtbQualityButton();
					}
					_s.controller_do.updateQuality(_s._d.playlist_ar[_s.id].videoLabels_ar, _s._d.playlist_ar[_s.id].videoLabels_ar[_s._d.playlist_ar[_s.id].videoLabels_ar.length - 1 - _s._d.playlist_ar[_s.id].startAtVideo]);
				}else if(_s.controller_do){
					_s.controller_do.removeYtbQualityButton();
				}
				
				if(_s.controller_do){
					if(_s.videoType_str == FWDUVPlayer.VIMEO || _s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IMAGE){
						_s.controller_do.removePlaybackRateButton();
					}else{
						_s.controller_do.addPlaybackRateButton(_s.startAtPlaybackIndex);
					}
				}

				_s._d.autoPlay_bl = false;
				_s.removeAPT();
				
				_s.audioScreen_do.setX(0);
				_s.audioScreen_do.setVisible(true);
				if(!_s.isAdd_bl && window['FWDUVPCC']) FWDUVPCC.enableButton();
				_s.videoPoster_do.hide(true);
				_s.setPosterSource(_s.posterPath_str);
				_s.audioScreen_do.setSource(source);

				if(_s.isAdd_bl && !_s.isMbl){
					_s.play();
				}else if(_s.isThumbClick_bl){
					if(_s.displayType != FWDUVPlayer.LIGHTBOX  || _s.lightBox_do.isShowed_bl){
						_s.play();
					} 
				}else{
					if(_s.videoPoster_do) _s.videoPoster_do.show();
					if(_s.lrgPlayBtn) _s.lrgPlayBtn.show();
				}
			}
			
			if(FWDUVPlayer.hasHTML5Video 
			   && _s.videoType_str == FWDUVPlayer.VIDEO
			   || _s.videoType_str == FWDUVPlayer.HLS_JS
			   || _s.videoType_str == FWDUVPlayer.DASH){
				
				if(_s.vimeo_do) _s.vimeo_do.setX(-5000);
				if(_s.ytb_do) _s.ytb_do.setX(-5000);
				if(_s.ytb_do && _s.ytb_do.ytb){
					_s.ytb_do.showDisable();
				}
				
				if(_s.audioScreen_do) _s.audioScreen_do.setX(-5000);
				_s.audioScreen_do.setVisible(false);
				
				_s.videoScreen_do.setVisible(true);
				
				if(_s.controller_do && _s._d.playlist_ar[_s.id].videoSource.length > 1){
					_s.controller_do.updatePreloaderBar(0);
					if(_s.controller_do){
						_s.controller_do.addYtbQualityButton();
					}
				
					_s.controller_do.updateQuality(_s._d.playlist_ar[_s.id].videoLabels_ar, _s._d.playlist_ar[_s.id].videoLabels_ar[_s._d.playlist_ar[_s.id].videoLabels_ar.length - 1 - _s._d.playlist_ar[_s.id].startAtVideo]);
				}else if(_s.controller_do){
					_s.controller_do.removeYtbQualityButton();
				}
				
				if(_s.controller_do){
					if(_s.controller_do){
						if(_s.videoType_str == FWDUVPlayer.VIMEO || _s.videoType_str == FWDUVPlayer.IMAGE || _s.videoType_str == FWDUVPlayer.IFRAME){
							_s.controller_do.removePlaybackRateButton();
						}else{
							_s.controller_do.addPlaybackRateButton(_s.startAtPlaybackIndex);
						}
					}
				}
				
				if(_s.videoType_str == FWDUVPlayer.DASH){
					_s.setPosterSource(_s.posterPath_str);
					if(_s._d.autoPlay_bl || _s.isThumbClick_bl || (!_s.isMbl && _s.isAdd_bl && !_s.loadAddFirstTime_bl)){
						_s.videoPoster_do.hide(true);
					} 
					_s.videoScreen_do.setSource(source);
					_s.setupDASH();

					_s.dashJS.initialize(_s.videoScreen_do.video_el, _s.videoSourcePath_str, false);
                 	_s.dashJS.attachSource(_s.videoSourcePath_str);

                 	_s.dashJS.on(dashjs.MediaPlayer.events.MANIFEST_LOADED, function(e){
                 		_s.isDASHManifestReady_bl = true;
                 		
                 		if(!_s.isMbl && _s.isAdd_bl && !_s.loadAddFirstTime_bl){
							setTimeout(_s.play, 100);
						}

                 		if(_s._d.autoPlay_bl || _s.isThumbClick_bl){
                 			
                 			if(_s.isThumbClick_bl){
								if(_s.videoType_str == FWDUVPlayer.DASH){
									setTimeout(_s.play, 100);
								}
							}

							if(_s._d.autoPlay_bl){
								if(_s.controller_do) _s.controller_do.updateVolume(0);
								if(_s.displayType != FWDUVPlayer.LIGHTBOX  || _s.lightBox_do.isShowed_bl){
									if(_s.videoType_str == FWDUVPlayer.DASH){
										setTimeout(_s.play, 100);
									}
								} 
							}
						}else{
							_s.videoPoster_do.show(true);
							_s.lrgPlayBtn.show();
						}

						if(_s.isAdd_bl){
							_s.setPlaybackRate(1);
						}else{
							_s.setPlaybackRate(_s._d.defaultPlaybackRate_ar[_s.startAtPlaybackIndex]);
						}
						if(_s.controller_do && _s._d.showPlaybackRateButton_bl){
							_s.controller_do.updatePlaybackRateButtons(_s.startAtPlaybackIndex);
						}
                 	});
					
				}else if(_s.videoType_str == FWDUVPlayer.HLS_JS){
					_s.setPosterSource(_s.posterPath_str);
					if(_s._d.autoPlay_bl || _s.isThumbClick_bl || (!_s.isMbl && _s.isAdd_bl && !_s.loadAddFirstTime_bl)){
						_s.videoPoster_do.hide(true);
					} 
					_s.videoScreen_do.setSource(source);
					_s.videoScreen_do.initVideo();
					_s.setupHLS();
					_s.hlsJS.loadSource(_s.videoSourcePath_str);
					_s.hlsJS.attachMedia(_s.videoScreen_do.video_el);
					
					_s.hlsJS.on(Hls.Events.MANIFEST_PARSED,function(e){
						if(_s.videoType_str == FWDUVPlayer.HLS_JS){
							
							_s.isHLSManifestReady_bl = true;
							

							if(_s.controller_do){
								_s.controller_do.addYtbQualityButton();
							}

							if(_s.isAdd_bl && !_s.loadAddFirstTime_bl){
								_s.play();
							}
							
							if(_s._d.autoPlay_bl || _s.isThumbClick_bl){
				
								if( _s.isThumbClick_bl) _s.play();

								if(_s._d.autoPlay_bl){
									if(_s.controller_do) _s.controller_do.updateVolume(0);
									if(_s.displayType != FWDUVPlayer.LIGHTBOX  || _s.lightBox_do.isShowed_bl){
										_s.play();
									} 
								}
							}
							
							if(_s.isAdd_bl){
								_s.setPlaybackRate(1);
							}else{
								_s.setPlaybackRate(_s._d.defaultPlaybackRate_ar[_s.startAtPlaybackIndex]);
							}
							if(_s.controller_do && _s._d.showPlaybackRateButton_bl){
								_s.controller_do.updatePlaybackRateButtons(_s.startAtPlaybackIndex);
							}

							_s.parseLevels();
						}
					});
				}else{
					if(!_s.isAdd_bl && window['FWDUVPCC']) FWDUVPCC.enableButton();
					_s.setPosterSource(_s.posterPath_str);
					_s.videoPoster_do.hide(true);
					_s.videoScreen_do.setSource(source);

					if(_s.isAdd_bl && !_s.loadAddFirstTime_bl){
						_s.play();
					}
					
					if(_s._d.autoPlay_bl || _s.isThumbClick_bl){

						if(_s.isThumbClick_bl ) _s.play();

						if(_s._d.autoPlay_bl){
							if(_s.controller_do) _s.controller_do.updateVolume(0);
							if(_s.displayType != FWDUVPlayer.LIGHTBOX  || _s.lightBox_do.isShowed_bl){
								_s.play();
							} 
						}

						if(_s.isCasting){
							_s.videoPoster_do.show();
						}
					}else{
						_s.videoPoster_do.show(true);
						_s.lrgPlayBtn.show();
					}
					
					if(_s.isAdd_bl){
						_s.setPlaybackRate(1);
					}else{
						_s.setPlaybackRate(_s._d.defaultPlaybackRate_ar[_s.startAtPlaybackIndex]);
					}
					if(_s.controller_do && _s._d.showPlaybackRateButton_bl){
						_s.controller_do.updatePlaybackRateButtons(_s.startAtPlaybackIndex);
					}
					
				}
				
				if(_s.isIMA) _s.IMA.setSource(_s.isIMA);
			}
			_s.resizeHandler();
		};
		
		// DASH
		_s.setupDASH = function(){
			if(_s.dashJS) return;
			_s.isDASHLoaded_bl = true;
			_s.dashJS = dashjs.MediaPlayer().create();

			_s.dashJS.on(dashjs.MediaPlayer.events.ERROR, function(e){
				console.log(e);
				_s.main_do.addChild(_s.info_do);
				_s.info_do.showText(e.error.message);
			});
		}

		_s.destroyDASH = function(o){
			if(_s.dashJS){
				try{	
					_s.dashJS.reset();
				}catch(e){}
			 _s.dashJS = null;
			}
		}

		// HLS
		_s.destroyHLS = function(){
			if(_s.hlsJS){
				_s.hlsJS.destroy();
				_s.hlsJS = null;
			}
		}

		_s.setupHLS = function(){
			
			if(_s.hlsJS || !window['Hls']) return;
			_s.isHLSJsLoaded_bl = true;
			_s.hlsJS = new Hls();
			
			FWDUVPRegisterHLSError(_s);

			_s.hlsJS.on(Hls.Events.MANIFEST_LOADED,function(event, data){
				_s.setAudioTracks(_s.hlsJS.audioTracks);
			});

			_s.hlsJS.on(Hls.Events.LEVEL_UPDATED,function(event, data){
				_s.curHlsLevel = data.level;
				_s.updateHlsControllerLevels();
			});

			_s.hlsJS.on(Hls.Events.LEVEL_SWITCHING,function(event, data){
				_s.curHlsLevel = data.level;
				_s.updateHlsControllerLevels();
			});
		}

		_s.setAudioTracks = function(audioTracks_ar){
			if(audioTracks_ar && audioTracks_ar.length > 1){
				_s.controller_do.addAtButton();

				_s.audioTracks_ar = [];
				audioTracks_ar.forEach((o,i) =>{
					_s.audioTracks_ar[i] = {'label':o['name'] || o['label']};
				})
				_s.audioTracks_ar.reverse();
				_s.controller_do.updateATBButtons(_s.audioTracks_ar, 0);
			}
		}

		_s.updateHlsControllerLevels = function(){
			if(_s.controller_do && _s.hlsLevels_ar){
				_s.curHlsLevel = Math.abs(_s.curHlsLevel - _s.hlsLevels_ar.length + 1)
				_s.controller_do.disableQualityButtons('', _s.curHlsLevel);
			}
		}

		_s.parseLevels = function(){
			var hlsLevels = _s.hlsJS.levels;
			_s.hlsLevels_ar = [];

			setTimeout(function(){
				
				hlsLevels.forEach(function(el){
					var level = '';
					var levelW = el.width;
					var levelH = el.height;
					if(levelW == 320){
						level = 'tiny';
					}else if(levelW == 480){
						level = 'small';
					}else if(levelW == 640){
						level = 'medium';
					}else if(levelW == 960){
						level = 'large';
					}else if(levelW == 1280){
						level = 'hd720';
					}else if(levelW == 1920){
						level = 'hd1080';
					}else if(levelW == 2560){
						level = 'hd1440p';
					}else if(levelW == 3840){
						level = 'hd2160';
					}else if(levelW == 3840){
						level = 'hd2160';
					}else if(levelW == 5120){
						level = 'hd2880';
					}else if(levelW == 7680){
						level = 'hd4320';
					}else{
						level = levelW + 'x' + levelH;
					}

					_s.hlsLevels_ar.push(level);					
				});
				
				if(!_s.hlsLevels_ar) return;
				
				_s.hlsLevels_ar.reverse();
			
				if(_s.controller_do){
					_s.curHlsLevel = Math.abs(_s.hlsLevels_ar.length - _s.hlsLevels_ar.length);
					_s.curHlsLevel = _s.curHlsLevel;
					_s.controller_do.updateQuality(_s.hlsLevels_ar, _s.curHlsLevel, _s.curHlsLevel);
				}
			}, 500);
		
		}

	
		//#############################################//
		/* go fullscreen / normal screen */
		//#############################################//
		_s.goFullScreen = function(){
			if(!_s.isAPIReady_bl) return;
			_s.wasMin = _s.isMin;
			_s.isFullScreen_bl = true;
			_s.removeMinOnScroll();
			
			if(document.addEventListener){
				document.addEventListener("fullscreenchange", _s.onFullScreenChange);
				document.addEventListener("mozfullscreenchange", _s.onFullScreenChange);
				document.addEventListener("webkitfullscreenchange", _s.onFullScreenChange);
				document.addEventListener("MSFullscreenChange", _s.onFullScreenChange);
			}
			
			if(FWDUVPUtils.isSafari && FWDUVPUtils.isWin){
				
			}else{
				if(document.documentElement.requestFullScreen) {
					_s.main_do.screen.requestFullScreen();
				}else if(document.documentElement.mozRequestFullScreen){ 
					_s.main_do.screen.mozRequestFullScreen();
				}else if(document.documentElement.webkitRequestFullScreen){
					_s.main_do.screen.webkitRequestFullScreen();
				}else if(document.documentElement.msRequestFullscreen){
					_s.main_do.screen.msRequestFullscreen();
				}
			}
			
			_s.callVastEvent("playerExpand");
			_s.stopVisualization();
			_s.disableClick();
			
			if(!_s.isEmbedded_bl){
				_s.main_do.getStyle().position = "fixed";
				document.documentElement.style.overflow = "hidden";
				_s.main_do.getStyle().zIndex = 2147483641;
			}
			
			if(_s.controller_do){
				_s.controller_do.showNormalScreenButton();
				_s.controller_do.setNormalStateToFullScreenButton();
			}
			if(_s.customContextMenu_do) _s.customContextMenu_do.updateFullScreenButton(1);
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.lastX = scrollOffsets.x;
			_s.lastY = scrollOffsets.y;
			window.scrollTo(0,0);

			if(_s.isMbl) window.addEventListener("touchmove", _s.disableFullScreenOnMobileHandler);
			_s.dispatchEvent(FWDUVPlayer.GO_FULLSCREEN);
			_s.resizeHandler();
		};
		
		_s.disableFullScreenOnMobileHandler = function(e){
			if(e.preventDefault) e.preventDefault();
		};
		
		_s.goNormalScreen = function(){		
			if(!_s.isAPIReady_bl) return;
			
			if (document.cancelFullScreen) {  
				document.cancelFullScreen();  
			}else if (document.mozCancelFullScreen) {  
				document.mozCancelFullScreen();  
			}else if (document.webkitCancelFullScreen) {  
				document.webkitCancelFullScreen();  
			}else if (document.msExitFullscreen) {  
				document.msExitFullscreen();  
			}

			_s.disableClick();
			_s.addMainDoToTheOriginalParent();
			_s.isFullScreen_bl = false;
		};
		
		_s.addMainDoToTheOriginalParent = function(){
			if(!_s.isFullScreen_bl) return;
			
			if(document.removeEventListener){
				document.removeEventListener("fullscreenchange", _s.onFullScreenChange);
				document.removeEventListener("mozfullscreenchange", _s.onFullScreenChange);
				document.removeEventListener("webkitfullscreenchange", _s.onFullScreenChange);
				document.removeEventListener("MSFullscreenChange", _s.onFullScreenChange);
			}
			
			_s.callVastEvent("playerCollapse");
				
			if(_s.controller_do){
				_s.controller_do.setNormalStateToFullScreenButton();
			}

			if(_s.categories_do && _s.categories_do.isShowed_bl){
				try{
					_s.main_do.removeChild(_s.categories_do);
				}catch(e){}
				document.documentElement.appendChild(_s.categories_do.screen);
			}
		
			if(!_s.isEmbedded_bl){
				if(_s.displayType == FWDUVPlayer.RESPONSIVE
				   || _s.displayType == FWDUVPlayer.AFTER_PARENT
				   || _s.displayType == FWDUVPlayer.LIGHTBOX
				    || _s.displayType == FWDUVPlayer.STICKY
				 ){
					
					document.documentElement.style.overflow = "visible";
					if(_s.isMin){
						_s.main_do.getStyle().position = 'fixed';
						_s.main_do.getStyle().zIndex = 9999999999999;
					}else{
						_s.main_do.getStyle().position = "relative";
						_s.main_do.getStyle().zIndex = 0;
					}
				
				}else{
					_s.main_do.getStyle().position = "absolute";
					_s.main_do.getStyle().zIndex = 9999999999998;
				}
			}
			
			if(_s.displayType != FWDUVPlayer.FULL_SCREEN) _s.controller_do.enablePlaylistButton();
			
			if(_s.customContextMenu_do) _s.customContextMenu_do.updateFullScreenButton(0);
			_s.controller_do.showFullScreenButton();
			window.scrollTo(_s.lastX, _s.lastY);

			_s.showCursor();
			_s.resizeHandler();

			setTimeout(function(){
				_s.addMinOnScroll();
				_s.resizeHandler();
			}, 500);
			
			window.scrollTo(_s.lastX, _s.lastY);
			if(!FWDUVPUtils.isIE){
				setTimeout(function(){
					window.scrollTo(_s.lastX, _s.lastY);
				}, 150);
			}
			
			if(_s.isMbl) window.removeEventListener("touchmove", _s.disableFullScreenOnMobileHandler);
			_s.dispatchEvent(FWDUVPlayer.GO_NORMALSCREEN);
		};
		
		_s.onFullScreenChange = function(e){
			if(!(document.fullScreen || document.msFullscreenElement  || document.mozFullScreen || document.webkitIsFullScreen || document.msieFullScreen)){
				_s.controller_do.showNormalScreenButton();
				_s.addMainDoToTheOriginalParent();
				_s.isFullScreen_bl = false;
			}
		};
		
		_s.loadPlaylist = function(id){
			if(!_s.isAPIReady_bl) return;
			if(_s._d.prevId == id) return;
			
			if(_s._d.playlist_ar && _s._d.playlist_ar[_s.id]){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
			
			_s.catId = id;
			_s.id = 0;
			
			if(_s.catId < 0){
				_s.catId = 0;
			}else if(_s.catId > _s._d.totalPlaylists - 1){
				_s.catId = _s._d.totalPlaylists - 1;
			};
			
			if(_s.useDeepLinking_bl){
				FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + _s.id);
			}else{
				_s.loadInternalPlaylist();
			}
		};
		
		_s.playNext = function(){	
			if(!_s.isAPIReady_bl || !_s.isPlaylistLoaded_bl) return;
			
			if(_s._d.playlist_ar){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
		
			_s.id ++;
			_s.executePlayNextPrevOrShuffle();
		};
		
		_s.playPrev = function(){
			if(!_s.isAPIReady_bl || !_s.isPlaylistLoaded_bl) return;
			
			if(_s._d.playlist_ar){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
			
			_s.id --;	
			_s.executePlayNextPrevOrShuffle();
		};
		
		_s.playShuffle = function(){
			if(!_s.isAPIReady_bl || !_s.isPlaylistLoaded_bl) return;
			
			if(_s._d.playlist_ar){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
			
			var tempId = parseInt(Math.random() * _s.totaadsIdeos);
			while(tempId == _s.id) tempId = parseInt(Math.random() * _s.totaadsIdeos);
			
			_s.id = tempId;	
			_s.executePlayNextPrevOrShuffle();
		};
		
		_s.executePlayNextPrevOrShuffle = function(){
			_s._d.isVastXMLParsed_bl = false;
			_s.totalDuration = 0;
			if(_s.id < 0){
				_s.id = _s.totaadsIdeos - 1;
			}else if(_s.id > _s.totaadsIdeos - 1){
				_s.id = 0;
			}
			if(_s.useDeepLinking_bl){
				FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + _s.id);
			}else{
				_s.isThumbClick_bl = true;
				_s.updateAds(0, true);
			}
		}
		
		_s.playVideo = function(videoId){	
			if(!_s.isAPIReady_bl || !_s.isPlaylistLoaded_bl) return;
			
			if(_s._d.playlist_ar){
				_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				_s.videoCat = _s._d.cats_ar[_s.catId]["playlistName"];
			}
			
			_s.id = videoId;
			
			if(_s.id < 0){
				_s.id = _s.totaadsIdeos - 1;
			}else if(_s.id > _s.totaadsIdeos - 1){
				_s.id = 0;
			}
			
			if(_s.useDeepLinking_bl){
				FWDUVPDL.setValue("?playlistId=" + _s.catId + "&videoId=" + _s.id);
			}else{
				_s.updateAds(0, true);
				if(_s.isMbl && _s.videoType_str == FWDUVPlayer.VIDEO) _s.play();
				if(!_s.isMbl){
					_s.play();
				}
			}
		};
		
		_s.setVideoSource =  function(source, is360, isLive){
			_s.isAdd_bl = false;
			var s360_str = "no";
			if(is360) s360_str = "yes";
			_s.isLive = isLive;
			_s.setSource(source, false, is360);
		};
	
		
		_s.downloadVideo = function(pId){

			var check = _s.checkPassWindow();
			if(!check) return;

			_s.hasPassedPassowrd_bl = true;
			
			if(pId ==  undefined) pId = _s.id;
			
			var sourceName;
			var source = _s._d.playlist_ar[pId].videoSource[_s._d.playlist_ar[_s.id].startAtVideo]["source"];
			if(String(source.indexOf("encrypt:")) != -1){
				source = atob(source.substr(8));
			}
			if(source.indexOf("/") != -1){
				sourceName = source.substr(source.lastIndexOf("/") + 1);
			}else{
				sourceName = source;
			}
			
			if(_s.gtag){
				if(_s._d.playlist_ar){
					_s.videoNameGa = _s._d.playlist_ar[_s.id]["gaStr"]
				}
				
				var params = {
					'video_name': _s.videoNameGa,
					'video_url': source,
				}
				_s.gtag('event', 'download', params);
			}
	
			_s._d.downloadVideo(source, sourceName);
		};
		
		_s.share = function(){
			if(!_s.isAPIReady_bl) return;
			_s.controllerShareHandler();
		};	
		
		_s.getVideoSource = function(){
			if(!_s.isAPIReady_bl) return;
			return _s.finalVideoPath_str;
		};
		
		_s.getPosterSource = function(){
			if(!_s.isAPIReady_bl) return;
			return _s.posterPath_str;
		};
		
		_s.getPlaylistId = function(){
			return _s.catId;
		};
		
		_s.getVideoId = function(){
			return _s.id;
		};
		
		_s.getCurrentTime = function(format){
			if(!format) format = 'text';
			var tm;
			if(format == 'milliseconds'){
				if(!_s.curTimeInmilliseconds){
					tm = 0;
				}else{
					tm = _s.curTimeInmilliseconds;
				}
				if(_s.isCasting) tm = _s.cc.getCurrentTime();
			}else if(format == 'seconds'){
				if(!_s.curTimeInSecond){
					tm = 0;
				}else{
					tm = _s.curTimeInSecond;
				}
				if(_s.isCasting) tm = _s.cc.getCurrentTime();
			}else{
				if(!_s.curTime){
					tm = "00:00";
				}else{
					tm = _s.curTime;
				}
				if(_s.isCasting) tm = FWDUVPUtils.formatTime(_s.cc.getCurrentTime());
			}
			return tm;
		};
		
		_s.getTotalTime = function(format){
			if(!format) format = 'text';
			var tm;
			if(format == 'milliseconds'){
				if(!_s.totalTimeInMilliseconds){
					tm = 0;
				}else{
					tm = _s.totalTimeInMilliseconds;
				}
				if(_s.isCasting) tm = _s.cc.getCurrentTime();
			}else if(format == 'seconds'){
				tm = Math.round(_s.totalTimeInSeconds);
				if(_s.isCasting) tm = _s.cc.getDuration();
			}else{
				if(!_s.totalTime){
					tm = "00:00";
				}else{
					tm = _s.totalTime;
				}
				if(_s.isCasting) tm = FWDUVPUtils.formatTime(_s.cc.getDuration());
			}
			return tm;
		};
	
		
		_s.setPlaybackRate = function(rate){
			if(!_s.isAPIReady_bl) return;
			if( _s.videoScreen_do && _s.videoType_str == FWDUVPlayer.VIDEO
			 || _s.videoType_str == FWDUVPlayer.HLS_JS
			 || _s.videoType_str == FWDUVPlayer.DASH){
				_s.videoScreen_do.setPlaybackRate(rate);
			}else if(_s.videoType_str == FWDUVPlayer.YOUTUBE){
				_s.ytb_do.setPlaybackRate(rate);
			}else if(_s.videoType_str == FWDUVPlayer.MP3){
				_s.audioScreen_do.setPlaybackRate(rate);
			}
		}
		
		_s.showLightbox = function(){
			if(_s.lightBox_do) _s.lightBox_do.show();
		}
		
		_s.fillEntireVideoScreen = function(param){
			_s.fillEntireVideoScreen_bl = param;
			_s.resizeHandler();
		};

		
		//###########################################//
		/* Hide / show cursor */
		//###########################################//
		_s.hideCursor = function(){
			document.documentElement.style.cursor = "none";
			document.getElementsByTagName("body")[0].style.cursor = "none";
			if(!_s.isAdd_bl) _s.dClk_do.getStyle().cursor = "none";
		};
		
		_s.showCursor = function(){
			document.documentElement.style.cursor = "auto";
			document.getElementsByTagName("body")[0].style.cursor = "auto";
			if(_s.isAdd_bl){
				_s.dClk_do.setButtonMode(true);
			}else{
				if(_s.is360){
					_s.dClk_do.getStyle().cursor = 'url(' + _s._d.handPath_str + '), default';
				}else{
					_s.dClk_do.getStyle().cursor = "auto";
				}
			}
		};
		
		_s.showPlayer = function(){
			if(!_s.isAPIReady_bl) return;
			_s.isShowed_bl = true;
			_s.opener_do.showCloseButton();
			_s.setStageContainerFinalHeightAndPosition(_s.animate_bl);
			if(_s.isMin){
				_s.isMinShowed = true;
				_s.positionOnMin(true);
			}
		};
		
		_s.hidePlayer = function(){
			if(!_s.isAPIReady_bl) return;
			_s.isShowed_bl = false;
			_s.opener_do.showOpenButton();
			_s.setStageContainerFinalHeightAndPosition(_s.animate_bl);
			if(_s.isMin){
				_s.isMinShowed = false;
				_s.positionOnMin(true);
			}
		};
		
		_s.getStartTimeStamp = function(str){

			var ts  = window.location.href;
			ts = ts.substr(ts.indexOf(str + "=") + 2);

			if(ts.indexOf("&") != -1){
				ts = ts.substr(0, ts.indexOf("&"));
			}

			if(ts.indexOf("s&") != -1){
				ts = ts.substr(0, ts.indexOf("s&") + 1);
			}

			if(ts.length > 10) return;
		
			var pattern = /\d+h/g;
			var hours = ts.match(pattern);
			try{ hours = ts.match(pattern)[0] }catch(e){}
			if(hours){
				hours = hours.substr(0, hours.length -1);
				if(hours.length == 1 && parseInt(hours) < 10){
					hours = "0" + hours;
				}
				if(parseInt(hours) > 59) hours = 59;
			}
			hours = hours ? hours : "00";
			
			var pattern = /h\d+m/g;
			var minutes = ts.match(pattern);
			try{ minutes = ts.match(pattern)[0].substr(1) }catch(e){}
			
			if(minutes){
				minutes = minutes.substr(0, minutes.length -1);
				if(minutes.length == 1 && parseInt(minutes) < 10){
					minutes = "0" + minutes;
				}
				if(parseInt(minutes) > 59) minutes = 59;
			}
			minutes = minutes ? minutes : "00";
			
			var pattern = /\d+s/g;
			var seconds = ts.match(pattern);
			try{ seconds = ts.match(pattern)[0] }catch(e){}
			if(seconds){
				seconds = seconds.substr(0, seconds.length -1);
				if(seconds.length == 1 && parseInt(seconds) < 10){
					seconds = "0" + seconds;
				}
				if(parseInt(seconds) > 59) seconds = 59;
			}
			seconds = seconds ? seconds : "00";
		
			return hours + ":" + minutes + ":" + seconds;
		}
		
		_s.setVastSource =  function(source){
			if(!_s.isAPIReady_bl) return;
			_s.isAdd_bl = false;
			_s.adDone_bl = false;
			_s.stop();
			_s.prevDuration = -1;
			_s._d.vastXML = source;
			_s._d.isVastXMLParsed_bl = false;
			_s._d.vast.id = -1;
			_s.updateAds();
		}


		//###########################################//
		/* event dispatcher */
		//###########################################//
		_s.addListener = function (type, listener){
	    	if(type == undefined) throw Error("type is required.");
	    	if(typeof type === "object") throw Error("type must be of type String.");
	    	if(typeof listener != "function") throw Error("listener must be of type Function.");
	    	
	        var event = {};
	        event.type = type;
	        event.listener = listener;
	        event.target = _s;
	        _s.listeners.events_ar.push(event);
	    };
	    
	    _s.dispatchEvent = function(type, props){
	    	if(_s.listeners == null) return;
	    	if(type == undefined) throw Error("type is required.");
	    	if(typeof type === "object") throw Error("type must be of type String.");
	    	
	        for (var i=0, len=_s.listeners.events_ar.length; i < len; i++){
	        	if(_s.listeners.events_ar[i].target === _s && _s.listeners.events_ar[i].type === type){		
	    	        if(props){
	    	        	for(var prop in props){
	    	        		_s.listeners.events_ar[i][prop] = props[prop];
	    	        	}
	    	        }
	        		_s.listeners.events_ar[i].listener.call(_s, _s.listeners.events_ar[i]);
	        	}
	        }
	    };
	    
	   _s.removeListener = function(type, listener){
	    	
	    	if(type == undefined) throw Error("type is required.");
	    	if(typeof type === "object") throw Error("type must be of type String.");
	    	if(typeof listener != "function") throw Error("listener must be of type Function." + type);
	    	
	        for (var i=0, len=_s.listeners.events_ar.length; i < len; i++){
	        	if(_s.listeners.events_ar[i].target === _s 
	        			&& _s.listeners.events_ar[i].type === type
	        			&& _s.listeners.events_ar[i].listener ===  listener
	        	){
	        		_s.listeners.events_ar.splice(i,1);
	        		break;
	        	}
	        }  
	    };
		
		//#############################################//
		/* Tracking vast events */
		//#############################################//
		_s.callVastEvent = function(eventName){
			
			if(!_s.TrackingEvents) return;
			var URI;
			
			for(var i=0; i<_s.TrackingEvents.length; i++){
				if(eventName == _s.TrackingEvents[i]["event"]){
					URI = _s.TrackingEvents[i]["URI"];
				}
			}
		
			if(!URI) return;
			_s.executeVastEvent(URI);
		}
		
		_s.executeVastEvent = function(URI){
			if(!URI) return;
			var img = new Image();
			img.src = URI;
		}
	    
	  	//#############################################//
		/* clean main events */
		//#############################################//
		_s.cleanMainEvents = function(){
			if(window.removeEventListener){
				window.removeEventListener("resize", _s.onResizeHandler);
			}else if(window.detachEvent){
				window.detachEvent("onresize", _s.onResizeHandler);
			}
		
			clearTimeout(_s.resizeHandlerId_to);
			clearTimeout(_s.resizeHandler2Id_to);
			clearTimeout(_s.hidePreloaderId_to);
			clearTimeout(_s.orientationChangeId_to);
		};
	
		
		var args = FWDUVPUtils.getUrlArgs(window.location.search);
		var embedTest = args.UVPInstanceName;
		var instanceName = args.UVPInstanceName;
		
		if(embedTest){
			_s.isEmbedded_bl = props.instanceName == instanceName;
		}
	
		if(_s.isEmbedded_bl){
			var ws = FWDUVPUtils.getViewportSize();
			
			_s.embeddedPlaylistId = parseInt(args.UVPPlaylistId);
			_s.embeddedVideoId = parseInt(args.UVPVideoId);
			
			var dumy_do = new FWDUVPDisplayObject("div");
			dumy_do.setBkColor(props.backgroundColor);
			dumy_do.setWidth(ws.w);
			dumy_do.setHeight(ws.h);
			
			document.documentElement.style.overflow = "hidden";
			document.getElementsByTagName("body")[0].style.overflow = "hidden";
			
			if(FWDUVPUtils.isIEAndLessThen9){
				document.getElementsByTagName("body")[0].appendChild(dumy_do.screen);
			}else{
				document.documentElement.appendChild(dumy_do.screen);
			}
		}
		_s.init();
	};

	
	/* set prototype */
	FWDUVPlayer.setPrototype =  function(){
		FWDUVPlayer.prototype = new FWDUVPEventDispatcher();
	};
		
	
	FWDUVPlayer.stopAllVideos = function(pVideo){
		var tt = FWDUVPlayer.instaces_ar.length;
		var video;
		for(var i=0; i<tt; i++){
			video = FWDUVPlayer.instaces_ar[i];
			if(video != pVideo){
				video.stop();
			}
		};
	};
	
	FWDUVPlayer.pauseAllVideos = function(pVideo){
		var tt = FWDUVPlayer.instaces_ar.length;
		var video;
		for(var i=0; i<tt; i++){
			video = FWDUVPlayer.instaces_ar[i];
			if(video != pVideo){
				video.pause();
			}
		};
	};
	
	FWDUVPlayer.hasHTML5Video = true;
	FWDUVPlayer.hasCanvas = (function(){
		return Boolean(document.createElement("canvas"));
	})();
	
	FWDUVPlayer.instaces_ar = [];
	
	FWDUVPlayer.hasHTMLHLS = (function(){
		return navigator.userAgent.match(/(iPhone|iPod)/g);
	}());
	
	
	FWDUVPlayer.areMainInstancesInitialized_bl = false;
	FWDUVPlayer.curInstance = null;
	FWDUVPlayer.keyboardCurInstance = null;
	FWDUVPlayer.isYoutubeAPICreated_bl = false;
	
	FWDUVPlayer.HLS_JS = "HLS";
	FWDUVPlayer.DASH = 'DASH';
	FWDUVPlayer.PAUSE_ALL_VIDEOS = "pause";
	FWDUVPlayer.STOP_ALL_VIDEOS = "stop";
	FWDUVPlayer.DO_NOTHING = "none";
	FWDUVPlayer.YOUTUBE = "youtube";
	FWDUVPlayer.VIMEO = "vimeo";
	FWDUVPlayer.VIDEO = "video";
	FWDUVPlayer.IFRAME = "iframe";
	FWDUVPlayer.atLeastOnePlayerHasDeeplinking_bl = false;
	FWDUVPlayer.MP3 = "mp3";
	
	FWDUVPlayer.CENTER = "center";
	FWDUVPlayer.RIGHT = "right";
	FWDUVPlayer.LEFT = "left";
	FWDUVPlayer.POSITION_BOTTOM = "bottom";
	FWDUVPlayer.POSITION_TOP = "top";
	FWDUVPlayer.HIDE_LIGHTBOX_COMPLETE = "lightboxHideComplete";
	FWDUVPlayer.START_TO_LOAD_PLAYLIST = "startToLoadPlaylist";
	FWDUVPlayer.LOAD_PLAYLIST_COMPLETE = "loadPlaylistComplete";
	FWDUVPlayer.READY = "ready";
	FWDUVPlayer.STOP = "stop";
	FWDUVPlayer.PLAY = "play";
	FWDUVPlayer.PAUSE = "pause";
	FWDUVPlayer.UPDATE = "update";
	FWDUVPlayer.UPDATE_TIME = "updateTime";
	FWDUVPlayer.UPDATE_VIDEO_SOURCE = "updateVideoSource";
	FWDUVPlayer.UPDATE_POSTER_SOURCE = "udpatePosterSource";
	FWDUVPlayer.ERROR = "error";
	FWDUVPlayer.PLAY_COMPLETE = "playComplete";
	FWDUVPlayer.VOLUME_SET = "volumeSet";
	FWDUVPlayer.GO_FULLSCREEN = "goFullScreen";
	FWDUVPlayer.GO_NORMALSCREEN = "goNormalScreen";
	FWDUVPlayer.IMAGE = "image";
	FWDUVPlayer.HLS_JS = "hls_flash"
	FWDUVPlayer.SAFE_TO_SCRUB = "safeToScrub";
	
	FWDUVPlayer.LIGHTBOX = "lightbox";
	FWDUVPlayer.STICKY = "sticky";
	FWDUVPlayer.RESPONSIVE = "responsive";
	FWDUVPlayer.FULL_SCREEN = "fullscreen";
	FWDUVPlayer.AFTER_PARENT = "afterparent";
	
	window.FWDUVPlayer = FWDUVPlayer;
	
}(window));