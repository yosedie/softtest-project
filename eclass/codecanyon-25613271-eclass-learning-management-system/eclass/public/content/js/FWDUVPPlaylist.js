/**
 * Ultimate Video Player PACKAGED v9.1
 * Playlist.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPPlaylist = function(
			prt, 
			_d
		){

		'use strict';
		
		var _s  = this;
		var prototype = FWDUVPPlaylist.prototype;
		
		_s.prt = prt;
		_s._d = _d;
		_s.prevN_img = _d.prevN_img;
		_s.nextN_img = _d.nextN_img;
		_s.replayN_img = _d.replayN_img;
		_s.shuffleN_img = _d.shuffleN_img;
		_s.scrBkTop_img = _d.scrBkTop_img;
		_s.scrDragTop_img = _d.scrDragTop_img;
		_s.scrLinesN_img = _d.scrLinesN_img;
		_s.buttons_ar = [];

		_s.useHEX = _d.useHEX; 
		_s.nBC = _d.nBC;
		_s.sBC = _d.sBC;
		
		_s.bkPath_str = _d.controllerBkPath_str;
		_s.position_str = prt.playlistPosition_str;
		_s.playlistBackgroundColor_str = _d.playlistBackgroundColor_str;
		_s.inputBackgroundColor_str = _d.searchInputBackgroundColor_str;
		_s.inputColor_str = _d.searchInputColor_str;
		_s.prevInputValue_str = "none";
		
		_s.showOnlyThmb = _d.showOnlyThumbnail;
		_s.scrWidth = _s.scrBkTop_img.width;
		_s.mouseX = 0;
		_s.mouseY = 0;
		_s.catId = -1;
		_s.dif = 0;
		_s.countLoadedThumbs = 0;
		_s.curId = -1;
		_s.finalX = 0;
		_s.finalY = 0;
		_s.controlBarHeight = _d.controllerHeight;
		_s.totalThumbs = 0;
		_s.totalWidth = prt.playlistWidth;
		_s.totalHeight = prt.playlistHeight;
		_s.dThumbW = _s.thumbImageW = _d.thumbnailWidth;
		_s.dThumbH = _s.thumbImageH = _d.thumbnailHeight;
		_s.thumbInPadding = 3;
		_s.spaceBetweenThumbnails = _d.spaceBetweenThumbnails;
		_s.startSpaceBetweenButtons = _d.startSpaceBetweenButtons;
		_s.spaceBetweenButtons = _d.spaceBetweenButtons;
	
		_s.totalButtons = 0;
		_s.buttonsToolTipHideDelay = _d.buttonsToolTipHideDelay;
		_s.removeFromThumbsHolderHeight = 0;
		_s.totalThumbsHeight = 0;
		_s.scrollBarHandlerFinalY = 0;
		_s.sW = _s.totalWidth;
		_s.sH = _s.totalHeight;
		_s.scrollbarOffestWidth = _d.scrollbarOffestWidth;
		_s.lastThumbnailFinalY = -1;
		_s.thumbsFinalY = 0;
		_s.scollbarSpeedSensitivity = _d.scollbarSpeedSensitivity;
		_s.vy = 0;
		_s.vy2 = 0;
		_s.friction = .9;
		
		_s.showThumbnail_bl = _d.showThumbnail_bl;

		_s.showPlaylistName_bl = _d.showPlaylistName_bl;
		_s.showController_bl = _d.showSearchInpt || _d.showNextAndPrevButtons_bl || _d.showLoopButton_bl || _d.showShuffleButton_bl;
		_s.loop_bl = _d.loop_bl;
		_s.shuffle_bl = _d.shuffle_bl;
		_s.showSearchInpt = _d.showSearchInpt;
		_s.allowToScrollAndScrollBarIsActive_bl = true;
		_s.showPlaylistToolTips_bl = _d.showPlaylistToolTips_bl;
		_s.showPlaylistByDefault_bl = _d.showPlaylistByDefault_bl;
		_s.repeatBackground_bl =  _d.repeatBackground_bl;
		_s.addMouseWheelSupport_bl = _d.addMouseWheelSupport_bl;
		_s.showNextAndPrevButtons_bl = _d.showNextAndPrevButtons_bl;
		_s.showShuffleButton_bl = _d.showShuffleButton_bl;
		_s.showLoopButton_bl = _d.showLoopButton_bl;
		_s.showButtonsToolTip_bl = _d.showButtonsToolTip_bl;
		_s.isShowed_bl = true;
		_s.usePlaylistsSelectBox_bl = _d.usePlaylistsSelectBox_bl;
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.addScrOnMM_bl = _d.addScrOnMM_bl;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.useVectorIcons_bl = _d.useVectorIcons_bl;
		
		_s.init = function(){
			_s.setOverflow('hidden');
			_s.screen.className = 'fwduvp-playlist';

			_s.mainHld = new FWDUVPDisplayObject("div");
			_s.mainHld.screen.className = 'fwduvp-playlist-background';

			if(_d.isWhite){
				_s.mainHld.screen.className = 'fwduvp-playlist-background white';
			}

			_s.mainHld.setBkColor(_s.playlistBackgroundColor_str);
			
			_s.mainThumbsHolder_do = new FWDUVPDisplayObject("div");
			_s.mainThumbsHolder_do.screen.className = 'fwduvp-playlist-thumbs-holder';
			_s.mainThumbsHolder_do.setBkColor(_s.playlistBackgroundColor_str);
			
			_s.thumbsHolder_do = new FWDUVPDisplayObject("div");
			_s.thumbsHolder_do.setOverflow("visible");
			_s.mainThumbsHolder_do.addChild(_s.thumbsHolder_do);
			_s.mainHld.addChild(_s.mainThumbsHolder_do);
			_s.addChild(_s.mainHld);

			
			if(_s.showController_bl){
				_s.controllBar_do = new FWDUVPDisplayObject("div");
				
				if(_s.repeatBackground_bl){
					_s.controllerBk_do =  new FWDUVPDisplayObject("div");
					_s.controllerBk_do.getStyle().background = "url('" + _s.bkPath_str +  "')";
				}else{
					_s.controllerBk_do = new FWDUVPDisplayObject("img");
					var imageBk_img = new Image();
					imageBk_img.src = _s.bkPath_str;
					_s.controllerBk_do.setScreen(imageBk_img);
				}
				
				_s.controllerBk_do.setHeight(_s.controlBarHeight);
				_s.controllerBk_do.getStyle().width = "100%";
				
				_s.controllBar_do.addChild(_s.controllerBk_do);
				_s.controllBar_do.setHeight(_s.controlBarHeight);
				_s.mainHld.addChild(_s.controllBar_do);
			}
			
			if(_s.showShuffleButton_bl) _s.setupShuffleButton();
			if(_s.showLoopButton_bl) _s.setupLoopButton();
			if(_s.showNextAndPrevButtons_bl){
				_s.setupPrevButton();
				_s.setupNextButton();
			}
			
			if(_s.showButtonsToolTip_bl) _s.setupToolTips();
			_s.totalButtons = _s.buttons_ar.length;
		
			if(_s.showSearchInpt && _s.showController_bl) _s.setupInput();
			
			if(_s.showController_bl){
				_s.removeFromThumbsHolderHeight = _s.controllBar_do.h + _s.spaceBetweenThumbnails;
			}
			
			_s.setupMobileScrollbar();
			if(!_s.isMbl) _s.setupScrollbar();
			if(_s.addMouseWheelSupport_bl) _s.addMouseWheelSupport();
			
			if(_s.showPlaylistName_bl){
				_s.setupPlaylistName();
				_s.removeFromThumbsHolderHeight += _s.controlBarHeight + _s.spaceBetweenThumbnails;
				_s.mainThumbsHolder_do.setY(_s.controlBarHeight + _s.spaceBetweenThumbnails);
				if(_s.scrMainHolder_do) _s.scrMainHolder_do.setY(_s.mainThumbsHolder_do.y);
			}

			var ec = prt.ec;
			if(ec){
				_s.ec = new FWDUVPDisplayObject("div", 'relative');
				_s.ec.setInnerHTML(ec.innerHTML);
				prt.main_do.addChild(_s.ec);
				_s.positionEc();
			}
			
			if(!_s.showPlaylistByDefault_bl){
				_s.hide();
			}
		};

		_s.positionEc =  function(){
			if(_s.ec){
				_s.ec.setWidth(_s.sW);
				_s.ec.setX(prt.sW - _s.sW);
				_s.ec.setY(0);
			}
		}
		
		
		//#####################################//
		/* resize and position */
		//#####################################//
		_s.resizeAndPosition = function(resizePlaylistWithAnim){
			
			if(!prt.sW) return;
			
			var offset = 0;
			if(_s.ec){
				offset = Math.round(_s.ec.getHeight());
				_s.positionEc();
			}
			
			if(_s.position_str == "bottom"){
				_s.sW = prt.sW;
				_s.sH = prt.playlistHeight;
				if(_s.showOnlyThmb){
					_s.thumbImageW = _s.sW - _s.scrWidth;
				}
				_s.finalX = 0;
				_s.finalY = prt.tempVidStageHeight + prt.spaceBetweenControllerAndPlaylist;
			}else{
				_s.sW = _s.totalWidth;
				if(_s.showOnlyThmb){
					_s.thumbImageW = _s.sW - _s.scrWidth;
				}
				_s.sH = prt.sH - offset;
				_s.finalX = prt.sW - _s.totalWidth;
				_s.finalY = 0;
			}
			
			if(_s.comboBox_do) _s.comboBox_do.resizeAndPosition();
			
			if(_s.bk_do){
				_s.bk_do.setWidth(_s.sW);
				_s.bk_do.setHeight(_s.sH);
			}
			
			_s.positionThumbs(resizePlaylistWithAnim);
			
			if(_s.allowToScrollAndScrollBarIsActive_bl && _s.scrMainHolder_do){
				_s.mainThumbsHolder_do.setWidth(_s.sW - _s.scrollbarOffestWidth + 1);
			}else{
				_s.mainThumbsHolder_do.setWidth(_s.sW);
			}
			_s.mainThumbsHolder_do.setHeight(_s.sH - _s.removeFromThumbsHolderHeight);
			if(_s.scrHandler_do)  _s.updateScrollBarSizeActiveAndDeactivate();
			
			if(_s.controllBar_do) _s.positionControllBar();
			_s.updateScrollBarHandlerAndContent(resizePlaylistWithAnim);

			
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH + offset);
			_s.setX(_s.finalX);
			_s.setY(_s.finalY + offset);
			_s.mainHld.setWidth(_s.sW);
			_s.mainHld.setHeight(_s.sH);
		};

		
		//#################################//
		/* update playlist */
		//#################################//
		_s.updatePlaylist = function(playlist, catId, id, playlistName){
			
			clearTimeout(_s.populateNextItemId_to);
			_s.hasPlaylist_bl = true;
			_s.catId = catId;
			_s.curId = id;
			
			_s.playlist_ar = playlist;	
			_s.countLoadedThumbs = 0;
			_s.allowToScrollAndScrollBarIsActive_bl = false;
				
			if(_s.input_do){
				_s.hasInputFocus_bl = false;
				_s.input_do.screen.value = "Search";
			}
				
			_s.setupThumbnails();
			_s.updatePlaylistName(playlistName);
			if(_s.showThumbnail_bl) _s.loadImages();
			if(_s.comboBox_do) _s.comboBox_do.setButtonsStateBasedOnId(_s.catId);

			_s.hideAndShow(true);
			_s.thumbsHolder_do.setY(0);
			_s.resizeAndPosition();

			if(_s.scrHandler_do){
				_s.updateScrollBarSizeActiveAndDeactivate();
				_s.updateScrollBarHandlerAndContent(false, true);
			}
		};
		
	
		_s.destroyPlaylist = function(){
			if(!_s.thumbs_ar) return;
			var thumb;

			_s.stopToUpdateDrag();

			_s.hasPlaylist_bl = false;
			if(_s.image_img){
				_s.image_img.onerror = null;
				_s.image_img.onload = null;
			}
			
			FWDAnimation.killTweensOf(_s.mainHld);
			if(_s.position_str == "bottom"){
				_s.mainHld.setY(-_s.sH - 5);
			}else{
				_s.mainHld.setX(-_s.sW - 5);
			}

			if(_s.ec){
				_s.ec.setX(-5000);
			}
			
			clearTimeout(_s.loadWithDelayId_to);
			for(var i=0; i<_s.totalThumbs; i++){
				thumb = _s.thumbs_ar[i];
				_s.thumbsHolder_do.removeChild(thumb);
				thumb.destroy();
			}
			_s.thumbs_ar = null;
		};

		
		//#################################################//
		/* Setup combo-box */
		//#################################################//
		_s.setupcomboBox = function(){
			_s.labels_ar = [];
			for (var i=0; i<_d.cats_ar.length; i++){
				_s.labels_ar[i] = _d.cats_ar[i].playlistName;
			}

			var settingsObj ={
				categories_ar:_s.labels_ar,
				selectorLabel:_s.labels_ar[0],
				selectorBackgroundNormalColor:_d.mainSelectorBackgroundSelectedColor,
				selectorTextNormalColor:_d.mainSelectorTextNormalColor,
				selectorTextSelectedColor:_d.mainSelectorTextSelectedColor,
				buttonBackgroundNormalColor:_d.mainButtonBackgroundNormalColor,
				buttonBackgroundSelectedColor:_d.mainButtonBackgroundSelectedColor,
				buttonTextNormalColor:_d.mainButtonTextNormalColor,
				buttonTextSelectedColor:_d.mainButtonTextSelectedColor,
				buttonHeight:_s.controlBarHeight,
				arrowN_str:_d.arrowN_str,
				arrowS_str:_d.arrowS_str,
				arrowW:11,
				arrowH:6
			}
			
			FWDUVPComboBox.setPrototype();
			_s.comboBox_do = new FWDUVPComboBox(_s, settingsObj);
			_s.comboBox_do.addListener(FWDUVPComboBox.BUTTON_PRESSED, _s.changePlaylistOnClick);
			_s.mainHld.addChild(_s.comboBox_do);
		}
		
		_s.changePlaylistOnClick = function(e){
			_s.dispatchEvent(FWDUVPPlaylist.CHANGE_PLAYLIST, {id:e.id});
		}

		
		//#################################################//
		/* Setup playlist name */
		//#################################################//
		_s.setupPlaylistName = function(){
			
			_s.playlistNameHolder_do =  new FWDUVPDisplayObject("div");
			_s.playlistNameHolder_do.setHeight(_s.controlBarHeight);
			_s.playlistNameHolder_do.getStyle().width = "100%";
	
			if(_s.repeatBackground_bl){
				_s.playlistNameBk_do =  new FWDUVPDisplayObject("div");
				_s.playlistNameBk_do.getStyle().background = "url('" + _s.bkPath_str +  "')";
			}else{
				_s.playlistNameBk_do = new FWDUVPDisplayObject("img");
				var imageBk_img = new Image();
				imageBk_img.src = _s.bkPath_str;
				_s.playlistNameBk_do.setScreen(imageBk_img);
			}
			
			_s.playlistNameBk_do.getStyle().width = "100%";
			_s.playlistNameBk_do.getStyle().height = "100%"

			_s.playlistName_do = new FWDUVPDisplayObject("div");
			_s.playlistName_do.getStyle().width = "100%";
			_s.playlistName_do.screen.className = 'fwduvp-playlist-name';
			_s.playlistName_do.getStyle().textAlign = "center";
			_s.playlistName_do.getStyle().fontSmoothing = "antialiased";
			_s.playlistName_do.getStyle().webkitFontSmoothing = "antialiased";
			_s.playlistName_do.getStyle().textRendering = "optimizeLegibility";
			_s.playlistName_do.getStyle().fontFamily = "Arial";
			_s.playlistName_do.getStyle().fontSize= "14px";
			_s.playlistName_do.getStyle().color = _d.playlistNameColor_str;
			
			_s.playlistNameHolder_do.addChild(_s.playlistNameBk_do);	
			
			if(!_s.usePlaylistsSelectBox_bl){
				_s.playlistNameHolder_do.addChild(_s.playlistName_do);
			}
			_s.mainHld.addChild(_s.playlistNameHolder_do);
			if(_s.usePlaylistsSelectBox_bl){
				_s.setupcomboBox();
				if(_s.controllBar_do){
					_s.mainHld.addChild(_s.controllBar_do);
				}
			} 
		};
		
		_s.updatePlaylistName = function(label){
			
			if(!_s.playlistName_do) return;
			_s.playlistName_do.setInnerHTML(label);
			
			setTimeout(function(){
				_s.playlistName_do.setY(parseInt((_s.playlistNameHolder_do.h - _s.playlistName_do.getHeight())/2) + 1);
			}, 50);
		};

		
		//################################################//
		/* setup input */
		//################################################//
		_s.setupInput = function(){
			
			_s.input_do = new FWDUVPDisplayObject("input");
			_s.input_do.screen.maxLength = 20;
			_s.input_do.screen.className = 'fwduvp-search';
			_s.input_do.getStyle().textAlign = "left";
			_s.input_do.getStyle().outline = "none";
			_s.input_do.getStyle().boxShadow  = "none";
			_s.input_do.getStyle().fontFamily = "Arial";
			_s.input_do.getStyle().fontSize= "12px";
			_s.input_do.getStyle().padding =  '7px 10px 7px';
			_s.input_do.getStyle().boxSizing = 'border-box';
			if(!FWDUVPUtils.isIEAndLessThen9) _s.input_do.getStyle().paddingRight = "-6px";
			_s.input_do.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.input_do.getStyle().color = _s.inputColor_str;
			_s.input_do.screen.value = "Search";
			
			_s.noSearchFound_do = new FWDUVPDisplayObject("div");
			_s.noSearchFound_do.setX(0);
			_s.noSearchFound_do.screen.className = 'fwduvp-search-not-found';
			_s.noSearchFound_do.getStyle().textAlign = "center";
			_s.noSearchFound_do.getStyle().width = "100%";
			_s.noSearchFound_do.getStyle().fontFamily = "Arial";
			_s.noSearchFound_do.getStyle().fontSize= "12px";
			_s.noSearchFound_do.getStyle().color = _s.inputColor_str;
			_s.noSearchFound_do.setInnerHTML("NOTHING FOUND!");
			_s.noSearchFound_do.setVisible(false);
			_s.mainHld.addChild(_s.noSearchFound_do);
			
			if(_s.hasPointerEvent_bl){
				_s.input_do.screen.addEventListener("pointerdown", _s.inputFocusInHandler);
			}else if(_s.input_do.screen.addEventListener){
				_s.input_do.screen.addEventListener("mousedown", _s.inputFocusInHandler);
				_s.input_do.screen.addEventListener("touchstart", _s.inputFocusInHandler);
			}
			
			_s.input_do.screen.addEventListener("keyup", _s.keyUpHandler);
			
			var inputArrow_img = new Image();
			inputArrow_img.src = _d.inputArrowPath_str;
			_s.inputArrow_do = new FWDUVPDisplayObject("img"); 
			_s.inputArrow_do.setScreen(inputArrow_img);
			_s.inputArrow_do.setWidth(12);
			_s.inputArrow_do.setHeight(12);
			
			_s.controllBar_do.addChild(_s.input_do);
			_s.controllBar_do.addChild(_s.inputArrow_do);
		};
		
		_s.inputFocusInHandler = function(){
			
			if(_s.hasInputFocus_bl) return;
			
			_s.hasInputFocus_bl = true;
			
			if(_s.input_do.screen.value == "Search"){
				_s.input_do.screen.value = "";
			}
			
			_s.input_do.screen.focus();
			
			setTimeout(function(){
				if(_s.hasPointerEvent_bl){
					window.addEventListener("pointerdown", _s.inputFocusOutHandler);
				}else if(window.addEventListener){
					window.addEventListener("mousedown", _s.inputFocusOutHandler);
					window.addEventListener("touchstart", _s.inputFocusOutHandler);
				}
				FWDUVPlayer.isSearchedFocused_bl = true;
			}, 50);
		};
		
		_s.inputFocusOutHandler = function(e){
			
			FWDUVPlayer.isSearchedFocused_bl = false;
			if(!_s.hasInputFocus_bl) return;
			
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(!FWDUVPUtils.hitTest(_s.input_do.screen, vc.screenX, vc.screenY)){
				_s.hasInputFocus_bl = false;
				if(_s.input_do.screen.value == ""){
					_s.input_do.screen.value = "Search";
					if(_s.hasPointerEvent_bl){
						window.removeEventListener("pointerdown", _s.inputFocusOutHandler);
					}else if(window.removeEventListener){
						window.removeEventListener("mousedown", _s.inputFocusOutHandler);
						window.removeEventListener("touchstart", _s.inputFocusOutHandler);
					}
				}
				return;
			}
		};
		
		_s.keyUpHandler = function(e){
			if(e.stopPropagation) e.stopPropagation();
			if(_s.prevInputValue_str != _s.input_do.screen.value){
				if(_s.isMbl){
					_s.positionThumbs(false);
					_s.thumbsFinalY = Math.round((_s.curId/(_s.totalThumbs - 1)) * (_s.totalThumbsHeight - _s.mainThumbsHolder_do.h)) * -1;
				}else{
					_s.positionThumbs(true);
				}
			}
			
			_s.prevInputValue_str = _s.input_do.screen.value;
			
			if(_s.scrHandler_do){
				_s.updateScrollBarSizeActiveAndDeactivate();
				_s.updateScrollBarHandlerAndContent(true, true);
			}
		};
		
		_s.showNothingFound = function(){
			if(_s.isShowNothingFound_bl) return;
			_s.isShowNothingFound_bl = true;
			
			_s.noSearchFound_do.setVisible(true);
			_s.noSearchFound_do.setY(parseInt((_s.sH - _s.noSearchFound_do.getHeight())/2));
			_s.noSearchFound_do.setAlpha(0);
			FWDAnimation.to(_s.noSearchFound_do, .1, {alpha:1, yoyo:true, repeat:4});
		};
		
		_s.hideNothingFound = function(){
			if(!_s.isShowNothingFound_bl) return;
			_s.isShowNothingFound_bl = false;
			
			FWDAnimation.killTweensOf(_s.noSearchFound_do);
			_s.noSearchFound_do.setVisible(false);
		};
		

		//##########################################//
		/* position controllbar */
		//##########################################//
		_s.positionControllBar = function(){
			
			var inputWidth;
			var button;
			var prevButton;
			
			if(_s.input_do && _s.sW <= 340){
				inputWidth = _s.sW - (_s.startSpaceBetweenButtons * 2);
				
				if(_s.nextButton_do) inputWidth -= _s.nextButton_do.w + _s.spaceBetweenButtons;
				if(_s.prevButton_do) inputWidth -= _s.prevButton_do.w + _s.spaceBetweenButtons;
				if(_s.shuffleButton_do) inputWidth -= _s.shuffleButton_do.w + _s.spaceBetweenButtons;
				if(_s.loopButton_do) inputWidth -= _s.loopButton_do.w + _s.spaceBetweenButtons;
				
				for(var i=0; i<_s.totalButtons; i++){
					button = _s.buttons_ar[_s.totalButtons - 1 - i];
					prevButton = _s.buttons_ar[_s.totalButtons - i];
					if(i == 0){
						button.setX(_s.sW - button.w - _s.startSpaceBetweenButtons);
					}else{
						button.setX(prevButton.x - prevButton.w - _s.spaceBetweenButtons);
					}
					
					button.setY(parseInt((_s.controllBar_do.h - button.h)/2));
				}
			}else if(_s.input_do && _s.sW > 340){
				inputWidth = _s.sW - (_s.startSpaceBetweenButtons * 2) + _s.spaceBetweenButtons - 2;
				if(inputWidth > 350) inputWidth = 350;
				
				if(_s.nextButton_do)inputWidth -= _s.nextButton_do.w + _s.spaceBetweenButtons;
				if(_s.prevButton_do)inputWidth -= _s.prevButton_do.w + _s.spaceBetweenButtons;
				if(_s.shuffleButton_do) inputWidth -= _s.shuffleButton_do.w + _s.spaceBetweenButtons;
				if(_s.loopButton_do) inputWidth -= _s.loopButton_do.w + _s.spaceBetweenButtons;
				
				for(var i=0; i<_s.totalButtons; i++){
					button = _s.buttons_ar[_s.totalButtons - 1 - i];
					prevButton = _s.buttons_ar[_s.totalButtons - i];
					if(i == 0){
						button.setX(_s.sW - button.w - _s.startSpaceBetweenButtons);
					}else{
						button.setX(prevButton.x - prevButton.w - _s.spaceBetweenButtons);
					}
					
					button.setY(parseInt((_s.controllBar_do.h - button.h)/2));
				}
			}else{
				if(_s.shuffleButton_do){
					_s.shuffleButton_do.setX(_s.spaceBetweenButtons);
					_s.shuffleButton_do.setY(parseInt((_s.controllBar_do.h - _s.shuffleButton_do.h)/2));
					if(_s.loopButton_do){
						_s.loopButton_do.setX(_s.shuffleButton_do.x + _s.shuffleButton_do.w + _s.spaceBetweenButtons);
						_s.loopButton_do.setY(parseInt((_s.controllBar_do.h - _s.shuffleButton_do.h)/2));
					}
				}else if(_s.loopButton_do){
					_s.loopButton_do.setX(_s.spaceBetweenButtons);
					_s.loopButton_do.setY(parseInt((_s.controllBar_do.h - _s.loopButton_do.h)/2));
				}
				
				if(_s.nextButton_do){
					_s.nextButton_do.setX(_s.sW - _s.nextButton_do.w - _s.startSpaceBetweenButtons);
					_s.nextButton_do.setY(parseInt((_s.controllBar_do.h - _s.nextButton_do.h)/2));
					
					_s.prevButton_do.setX(_s.nextButton_do.x - _s.nextButton_do.w - _s.spaceBetweenButtons);
					_s.prevButton_do.setY(parseInt((_s.controllBar_do.h - _s.prevButton_do.h)/2));
				}
			}
			
			if(_s.input_do){
				_s.input_do.setWidth(inputWidth);
				_s.input_do.setX(_s.startSpaceBetweenButtons);
				_s.input_do.setY(parseInt((_s.controllBar_do.h - _s.input_do.getHeight())/2));
				_s.inputArrow_do.setX(parseInt(_s.input_do.x + _s.input_do.getWidth()) - _s.inputArrow_do.w - 7);
				_s.inputArrow_do.setY(parseInt((_s.controllBar_do.h - _s.inputArrow_do.h)/2));
			}
		
			_s.controllBar_do.setWidth(_s.sW);
			_s.controllBar_do.setY(_s.sH - _s.controllBar_do.h);
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
				_s.prevButton_do = new FWDUVPSimpleButton(_s.prevN_img, _d.prevSPath_str, undefined, true, 
				_d.useHEX,
				_d.nBC,
				_d.sBC);
			}

			_s.prevButton_do.screen.className = 'fwduvp-prev-button';
			_s.prevButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.prevButtonShowTooltipHandler);
			_s.prevButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.prevButtonOnMouseUpHandler);
			_s.buttons_ar.push(_s.prevButton_do);
			_s.controllBar_do.addChild(_s.prevButton_do); 
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
				_s.nextButton_do = new FWDUVPSimpleButton(_s.nextN_img, _d.nextSPath_str, undefined, true, 
				_d.useHEX,
				_d.nBC,
				_d.sBC);
			}

			_s.nextButton_do.screen.className = 'fwduvp-next-button';
			_s.nextButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.nextButtonShowTooltipHandler);
			_s.nextButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.nextButtonOnMouseUpHandler);
			_s.buttons_ar.push(_s.nextButton_do);
			_s.controllBar_do.addChild(_s.nextButton_do);
		};
		
		_s.nextButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.nextButton_do, _s.nextButtonToolTip_do, e.e);
		};
		
		_s.nextButtonOnMouseUpHandler = function(){
			_s.dispatchEvent(FWDUVPPlaylist.PLAY_NEXT_VIDEO);
		};
		

		//##########################################//
		/* Setup shuffle button */
		//#########################################//
		_s.setupShuffleButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.shuffleButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-shuffle'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.shuffleButton_do = new FWDUVPSimpleButton(_s.shuffleN_img, _d.shufflePathS_str, undefined, true, 
				_d.useHEX,
				_d.nBC,
				_d.sBC);
			}

			_s.shuffleButton_do.screen.className = 'fwduvp-shuffle-button';
			_s.shuffleButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.shuffleButtonShowToolTipHandler);
			_s.shuffleButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.shuffleButtonOnMouseUpHandler);
			_s.buttons_ar.push(_s.shuffleButton_do);
			_s.controllBar_do.addChild(_s.shuffleButton_do); 
			if(!_s.loop_bl && _s.shuffle_bl) _s.setShuffleButtonState("selected");
		};
		
		_s.shuffleButtonShowToolTipHandler = function(e){
			_s.showToolTip(_s.shuffleButton_do, _s.shuffleButtonToolTip_do, e.e);
		};
		
		_s.shuffleButtonOnMouseUpHandler = function(){
			if(_s.shuffleButton_do.isSelectedFinal_bl){
				_s.dispatchEvent(FWDUVPPlaylist.DISABLE_SHUFFLE);
			}else{
				_s.dispatchEvent(FWDUVPPlaylist.ENABLE_SHUFFLE);
			}
		};
		
		_s.setShuffleButtonState = function(state){	
			if(!_s.shuffleButton_do) return;
			if(state == "selected"){
				_s.shuffleButton_do.setSelected();
			}else if(state == "unselected"){
				_s.shuffleButton_do.setUnselected();
			}
		};
		

		//##########################################//
		/* Setup loop button */
		//#########################################//
		_s.setupLoopButton = function(){
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.loopButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='fwdicon fwdicon-loop'></span>",
						undefined,
						"UVPMainButtonsNormalState",
						"UVPMainButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.loopButton_do = new FWDUVPSimpleButton(_s.replayN_img, _d.replaySPath_str, undefined, true, 
				_d.useHEX,
				_d.nBC,
				_d.sBC);
			}

			_s.loopButton_do.screen.className = 'fwduvp-loop-button';
			_s.loopButton_do.addListener(FWDUVPSimpleButton.SHOW_TOOLTIP, _s.loopButtonShowTooltipHandler);
			_s.loopButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.loopButtonOnMouseUpHandler);
			_s.buttons_ar.push(_s.loopButton_do);
			_s.controllBar_do.addChild(_s.loopButton_do); 
			if(_s.loop_bl) _s.setLoopStateButton("selected");
		};
		
		
		_s.loopButtonShowTooltipHandler = function(e){
			_s.showToolTip(_s.loopButton_do, _s.loopButtonToolTip_do, e.e);
		};
		
		_s.loopButtonOnMouseUpHandler = function(){
			if(_s.loopButton_do.isSelectedFinal_bl){
				_s.dispatchEvent(FWDUVPPlaylist.DISABLE_LOOP);
			}else{
				_s.dispatchEvent(FWDUVPPlaylist.ENABLE_LOOP);
			}
		};
		
		
		_s.setLoopStateButton = function(state){
			if(!_s.loopButton_do) return;
			if(state == "selected"){
				_s.loopButton_do.setSelected();
			}else if(state == "unselected"){
				_s.loopButton_do.setUnselected();
			}
		};
		

		//################################//
		/* Setup tooltips */
		//################################//		
		_s.setupToolTips = function(){
			
			if(_s.showNextAndPrevButtons_bl){
				FWDUVPToolTip.setPrototype();
				_s.prevButtonToolTip_do = new FWDUVPToolTip(_s.prevButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "previous video", _d.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.prevButtonToolTip_do.screen);
				
				FWDUVPToolTip.setPrototype();
				_s.nextButtonToolTip_do = new FWDUVPToolTip(_s.nextButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "next video", _d.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.nextButtonToolTip_do.screen);
			}
		
			if(_s.showShuffleButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.shuffleButtonToolTip_do = new FWDUVPToolTip(_s.shuffleButton_do, _d.toopTipBk_str, _d.toopTipPointer_str,  "shuffle", _d.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.shuffleButtonToolTip_do.screen);
			}
			
			if(_s.showLoopButton_bl){
				FWDUVPToolTip.setPrototype();
				_s.loopButtonToolTip_do = new FWDUVPToolTip(_s.loopButton_do, _d.toopTipBk_str, _d.toopTipPointer_str, "loop", _d.buttonsToolTipFontColor_str, _s.buttonsToolTipHideDelay);
				document.documentElement.appendChild(_s.loopButtonToolTip_do.screen);
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
		
		_s.setupThumbnails = function(){
			_s.totalThumbs = _s.playlist_ar.length;
			_s.thumbs_ar = [];
			var thumb;
			var nClr = _d.thumbnailNormalBackgroundColor_str;
			var sClr = _d.thumbnailHoverBackgroundColor_str;
			var dClr = _d.thumbnailDisabledBackgroundColor_str;
			
			if(window['isWhite']){
				nClr = '#FFFFFF';
				sClr = dClr = '#EEEEEE';
			}

			for(var i=0; i<_s.totalThumbs; i++){
				FWDUVPPlaylistThumb.setPrototype();
				thumb = new FWDUVPPlaylistThumb(
						_s, 
						i, 
						_d.playlistThumbnailsBkPath_str,
						nClr,
						sClr,
						dClr,
						_s.thumbImageW,
						_s.thumbImageH,
						_s.thumbInPadding,
						_s.playlist_ar[i].title,
						_s.playlist_ar[i].titleText,
						_s.showThumbnail_bl);
				
				_s.thumbs_ar[i] = thumb;
			
				thumb.addListener(FWDUVPPlaylistThumb.MOUSE_UP, _s.thumbMouseUpHandler);
				_s.thumbsHolder_do.addChild(thumb);
			}
		};
		
		_s.thumbMouseUpHandler = function(e){
			if(_s.disableThumbs_bl) return;
			_s.disableForAWhileAfterThumbClick_bl = true;
			clearTimeout(_s.disableForAWhileAfterThumbClickId_to);
			_s.disableForAWhileAfterThumbClickId_to = setTimeout(function(){
				_s.disableForAWhileAfterThumbClick_bl = false;
			}, 200);
			_s.dispatchEvent(FWDUVPPlaylist.THUMB_MOUSE_UP, {id:e.id});
		};
		

		//#############################################//
		/* load thumbnail images */
		//#############################################//
		_s.loadImages = function(){
			if(!_s.playlist_ar[_s.countLoadedThumbs]) return;
			if(_s.image_img){
				_s.image_img.onload = null;
				_s.image_img.onerror = null;
			}
			
			_s.image_img = new Image();
			_s.image_img.onerror = _s.onImageLoadError;
			_s.image_img.onload = _s.onImageLoadComplete;
			
			_s.image_img.src = _s.playlist_ar[_s.countLoadedThumbs].thumbSource;
		};
		
		_s.onImageLoadError = function(e){};
		
		_s.onImageLoadComplete = function(e){
			var thumb = _s.thumbs_ar[_s.countLoadedThumbs];
			thumb.setImage(_s.image_img);
			_s.countLoadedThumbs++;
			_s.loadWithDelayId_to = setTimeout(_s.loadImages, 40);	
		};
		

		//#####################################//
		/* enable disable thumbs based on id */
		//#####################################//
		_s.checkThumbsState = function(){
			if(!_s.thumbs_ar) return;
			var thumb;
			for(var i=0; i< _s.totalThumbs; i++){
				thumb = _s.thumbs_ar[i];
				if(i == _s.curId){
					thumb.disable();
				}else{
					thumb.enable();
				}
			};
		};
		
		_s.positionThumbs = function(animate){
			if(!_s.thumbs_ar) return;
			var thumb;
			var curX;
			var curY;
			var inputValue;
			var tmpSpaceBetwThmbs = _s.spaceBetweenThumbnails;
			var copy_ar = [].concat(_s.thumbs_ar);
			_s.isSearched_bl = false;
		
			if(_s.input_do){
				inputValue = _s.input_do.screen.value.toLowerCase();
				if(inputValue.toLowerCase() != "Search".toLowerCase()){
					for(var i=0; i<copy_ar.length; i++){
						thumb = copy_ar[i];
						
						if(thumb.htmlText_str.indexOf(inputValue) == -1){
							FWDAnimation.killTweensOf(thumb);
							thumb.setX(-thumb.w - 20);
							copy_ar.splice(i, 1);
							i--;
						}
					}
				}
			}
		
			var totalThumbs = copy_ar.length;
			if(_s.totalThumbs != totalThumbs) _s.isSearched_bl = true;
		
			for(var i=0; i<totalThumbs; i++){
				thumb = copy_ar[i];
				thumb.thumbImageWidth = _s.thumbImageW;
				thumb.thumbImageHeight = _s.thumbImageH;
				thumb.finalW = _s.sW;
				thumb.finalX = 0;
				thumb.finalY = i * (thumb.finalH + tmpSpaceBetwThmbs);
				thumb.resizeAndPosition(animate);
			}
			
			if(totalThumbs == 0){
				_s.showNothingFound();
			}else{
				_s.hideNothingFound();
			}
			
			if(thumb){
				_s.totalThumbsHeight = Math.max(0, totalThumbs * (thumb.h + _s.spaceBetweenThumbnails) - _s.spaceBetweenThumbnails);
				
				if(_s.totalThumbsHeight > _s.sH - _s.removeFromThumbsHolderHeight){
					_s.allowToScrollAndScrollBarIsActive_bl = true;
				}else{
					_s.allowToScrollAndScrollBarIsActive_bl = false;
				}
			}
		};
		
		
		//##########################################//
		/* setup mobile scrollbar */
		//##########################################//
		_s.setupMobileScrollbar = function(){
			if(!_s.isMbl) return;
			if(_s.hasPointerEvent_bl){
				_s.mainThumbsHolder_do.screen.addEventListener("pointerdown", _s.scrollBarTouchStartHandler);
			}else{
				_s.mainThumbsHolder_do.screen.addEventListener("touchstart", _s.scrollBarTouchStartHandler);
			}
		};
		
		_s.scrollBarTouchStartHandler = function(e){
			_s.isScrollingOnMove_bl = false;
			FWDAnimation.killTweensOf(_s.thumbsHolder_do);

			var vmc = FWDUVPUtils.getViewportMouseCoordinates(e);		
			_s.isDragging_bl = true;
			_s.thumbsFinalY = _s.lastThumbsFinalY = _s.thumbsHolder_do.y;
			_s.lastPresedY = _s.lastPresedY2 = vmc.screenY;
			_s.startToUpdateDrag();
		
			if(_s.hasPointerEvent_bl){
				window.addEventListener("pointerup", _s.scrollBarTouchEndHandler);
				window.addEventListener("pointermove", _s.scrollBarTouchMoveHandler);
			}else{
				window.addEventListener("touchend", _s.scrollBarTouchEndHandler);
				window.addEventListener("touchmove", _s.scrollBarTouchMoveHandler, {passive:false});
			}
		};
		
		_s.scrollBarTouchMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			e.stopImmediatePropagation();
			
			if(_s.totalThumbsHeight < _s.mainThumbsHolder_do.h) return;
			if(_s.comboBox_do && _s.comboBox_do.isShowed_bl) return;
			
			var vmc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var toAdd = vmc.screenY - _s.lastPresedY;
			_s.thumbsFinalY += toAdd;
			_s.thumbsFinalY = Math.round(_s.thumbsFinalY);
			var dy = vmc.screenY - _s.lastPresedY2;
			_s.lastPresedY = vmc.screenY;

			if(Math.abs(dy) > 5){
				prt.showDisable();
			}
			FWDAnimation.killTweensOf(_s.thumbsHolder_do)
			_s.thumbsHolder_do.setY(_s.thumbsFinalY);
		};
		
		_s.scrollBarTouchEndHandler = function(e){
			_s.isDragging_bl = false;
			
			clearTimeout(_s.disableOnMoveId_to);
			_s.disableOnMoveId_to = setTimeout(function(){
				prt.hideDisable();
			},50);
			if(_s.hasPointerEvent_bl){
				window.removeEventListener("pointerup", _s.scrollBarTouchEndHandler);
				window.removeEventListener("pointermove", _s.scrollBarTouchMoveHandler);
			}else{
				window.removeEventListener("touchend", _s.scrollBarTouchEndHandler);
				window.removeEventListener("touchmove", _s.scrollBarTouchMoveHandler);
			}
		};
		
		_s.stopToUpdateDrag = function(){
			FWDAnimation.killTweensOf(_s.thumbsHld_do)
			cancelAnimationFrame(_s.updateMov_af);
		}

		_s.startToUpdateDrag = function(){
			_s.stopToUpdateDrag();
			_s.updateDrag();

		}

		_s.updateDrag = function(animate){
			_s.updateMov_af = requestAnimationFrame(_s.updateDrag);

			if(_s.isDragging_bl){
				_s.vy = _s.thumbsFinalY - _s.lastThumbsFinalY;
				_s.lastThumbsFinalY = _s.thumbsFinalY;	
				if(Math.abs(_s.vy) < 20){
					_s.vy = 0;
				}
			}else{
				_s.vy *= _s.friction;		
				_s.thumbsFinalY += _s.vy;
				if(_s.mainThumbsHolder_do.h <= _s.totalThumbsHeight){
					if(_s.thumbsFinalY > 0){
						_s.vy2 = (0 - _s.thumbsFinalY) * .3;
						_s.vy *= _s.friction;
						_s.thumbsFinalY += _s.vy2;
					}else if(_s.thumbsFinalY <= _s.mainThumbsHolder_do.h - _s.totalThumbsHeight){
						_s.vy2 = (_s.mainThumbsHolder_do.h - _s.totalThumbsHeight - _s.thumbsFinalY) * .3;
						_s.vy *= _s.friction;
						_s.thumbsFinalY += _s.vy2;
					}
				}

				_s.thumbsFinalY = parseFloat(_s.thumbsFinalY.toFixed(2));				
				if(_s.prevThumbsFinalY == _s.thumbsFinalY){
					_s.stopToUpdateDrag();
					_s.thumbsFinalY = Math.round(_s.thumbsFinalY);
				}

				FWDAnimation.killTweensOf(_s.thumbsHolder_do);
				_s.thumbsHolder_do.setY(_s.thumbsFinalY);
				_s.prevThumbsFinalY = _s.thumbsFinalY;
			}
		};
		
		//#################################//
		/* setup mouse scrollbar */
		//#################################//
		_s.setupScrollbar = function(){
			_s.scrMainHolder_do = new FWDUVPDisplayObject("div");
			_s.scrMainHolder_do.setWidth(_s.scrWidth);
			
			//track
			_s.scrTrack_do = new FWDUVPDisplayObject("div");
			_s.scrTrack_do.setWidth(_s.scrWidth);
			_s.scrTrackTop_do = new FWDUVPDisplayObject("img");
			_s.scrTrackTop_do.setScreen(_s.scrBkTop_img);
			_s.scrTrackMiddle_do = new FWDUVPDisplayObject("div");
			_s.scrTrackMiddle_do.getStyle().background = "url('" + _d.scrBkMiddlePath_str + "')";
			_s.scrTrackMiddle_do.setWidth(_s.scrWidth);
			_s.scrTrackMiddle_do.setY(_s.scrTrackTop_do.h);
			var scrTrackBottomImage_img = new Image();
			scrTrackBottomImage_img.src = _d.scrBkBottomPath_str;
			_s.scrTrackBottom_do = new FWDUVPDisplayObject("img");
			_s.scrTrackBottom_do.setScreen(scrTrackBottomImage_img);
			_s.scrTrackBottom_do.setWidth(_s.scrTrackTop_do.w);
			_s.scrTrackBottom_do.setHeight(_s.scrTrackTop_do.h);
			
			//handler
			_s.scrHandler_do = new FWDUVPDisplayObject("div");
			_s.scrHandler_do.setWidth(_s.scrWidth);
			
			_s.scrHandlerTop_do = new FWDUVPDisplayObject("img");
			if(_s.useHEX){
				_s.scrHandlerTop_do = new FWDUVPDisplayObject("div");
				_s.scrHandlerTop_do.setWidth(_s.scrDragTop_img.width);
				_s.scrHandlerTop_do.setHeight(_s.scrDragTop_img.height);
				_s.mainScrubberDragTop_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.scrDragTop_img, _s.nBC).canvas;
				_s.scrHandlerTop_do.screen.appendChild(_s.mainScrubberDragTop_canvas);	
			}else{
				_s.scrHandlerTop_do = new FWDUVPDisplayObject("img");
				_s.scrHandlerTop_do.setScreen(_s.scrDragTop_img);
			}
		
			_s.scrHandlerMiddle_do = new FWDUVPDisplayObject("div");
			_s.middleImage = new Image();
			_s.middleImage.src = _d.scrDragMiddlePath_str;
			if(_s.useHEX){
				_s.middleImage.onload = function(){
					_s.scrubberDragMiddle_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.middleImage, _s.nBC, true);
					_s.scrubberDragImage_img = _s.scrubberDragMiddle_canvas.image;
					_s.scrHandlerMiddle_do.getStyle().background = "url('" + _s.scrubberDragImage_img.src + "') repeat-y";
				}
			}else{
				_s.scrHandlerMiddle_do.getStyle().background = "url('" + _d.scrDragMiddlePath_str + "')";
			}
			_s.scrHandlerMiddle_do.setWidth(_s.scrWidth);
			_s.scrHandlerMiddle_do.setY(_s.scrHandlerTop_do.h);
			
			_s.scrHandlerBottom_do = new FWDUVPDisplayObject("div");
			_s.bottomImage = new Image();
			_s.bottomImage.src = _d.scrDragMiddlePath_str;
			if(_s.useHEX){
				_s.bottomImage.onload = function(){
					_s.scrubberDragBottom_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.bottomImage, _s.nBC, true);
					_s.scrubberDragBottomImage_img = _s.scrubberDragBottom_canvas.image;
					_s.scrHandlerBottom_do.getStyle().background = "url('" + _s.scrubberDragBottomImage_img.src + "') repeat-y";
					
				}
			}else{
				_s.scrHandlerBottom_do.getStyle().background = "url('" + _d.scrDragBottomPath_str + "')";
			}
			_s.scrHandlerBottom_do.setWidth(_s.scrWidth);
			_s.scrHandlerBottom_do.setY(_s.scrHandlerTop_do.h);
			
			_s.scrHandlerBottom_do.setWidth(_s.scrHandlerTop_do.w);
			_s.scrHandlerBottom_do.setHeight(_s.scrHandlerTop_do.h);
			
			if(_s.useHEX){
				_s.scrHandlerLinesN_do = new FWDUVPDisplayObject("div");
				_s.scrHandlerLinesN_do.setWidth(_s.scrLinesN_img.width);
				_s.scrHandlerLinesN_do.setHeight(_s.scrLinesN_img.height);
				_s.mainhandlerN_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.scrLinesN_img, _s.sBC).canvas;
				_s.scrHandlerLinesN_do.screen.appendChild(_s.mainhandlerN_canvas);	
			}else{
				_s.scrHandlerLinesN_do = new FWDUVPDisplayObject("img");
				_s.scrHandlerLinesN_do.setScreen(_s.scrLinesN_img);
			}
			
			_s.scrHandlerLinesS_img = new Image();
			_s.scrHandlerLinesS_img.src = _d.scrLinesSPath_str;
			if(_s.useHEX){
				_s.scrHandlerLinesS_do = new FWDUVPDisplayObject("div");
				_s.scrHandlerLinesS_img.onload = function(){
					_s.scrHandlerLinesS_do.setWidth(_s.scrHandlerLinesN_do.w);
					_s.scrHandlerLinesS_do.setHeight(_s.scrHandlerLinesN_do.h);
					_s.scrubberLines_s_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.scrHandlerLinesS_img, _s.sBC, true);
					_s.scrubbelinesSImage_img = _s.scrubberLines_s_canvas.image;
					_s.scrHandlerLinesS_do.getStyle().background = "url('" + _s.scrubbelinesSImage_img.src + "') repeat-y";
				}
			}else{
				_s.scrHandlerLinesS_do = new FWDUVPDisplayObject("img");
				_s.scrHandlerLinesS_do.setScreen(_s.scrHandlerLinesS_img);
				_s.scrHandlerLinesS_do.setWidth(_s.scrHandlerLinesN_do.w);
				_s.scrHandlerLinesS_do.setHeight(_s.scrHandlerLinesN_do.h);
			}
			_s.scrHandlerLinesS_do.setAlpha(0);
			
			_s.scrHandlerLines_do = new FWDUVPDisplayObject("div");
			_s.scrHandlerLines_do.setWidth(_s.scrHandlerLinesN_do.w);
			_s.scrHandlerLines_do.setHeight(_s.scrHandlerLinesN_do.h);
		
			_s.scrTrack_do.addChild(_s.scrTrackTop_do);
			_s.scrTrack_do.addChild(_s.scrTrackMiddle_do);
			_s.scrTrack_do.addChild(_s.scrTrackBottom_do);
			_s.scrHandler_do.addChild(_s.scrHandlerTop_do);
			_s.scrHandler_do.addChild(_s.scrHandlerMiddle_do);
			_s.scrHandler_do.addChild(_s.scrHandlerBottom_do);
			_s.scrHandlerLines_do.addChild(_s.scrHandlerLinesN_do);
			_s.scrHandlerLines_do.addChild(_s.scrHandlerLinesS_do);
			_s.scrMainHolder_do.addChild(_s.scrTrack_do);
			_s.scrMainHolder_do.addChild(_s.scrHandler_do);
			_s.scrMainHolder_do.addChild(_s.scrHandlerLines_do);
			_s.mainHld.addChild(_s.scrMainHolder_do);
			
			_s.scrHandler_do.screen.addEventListener("mouseover", _s.scrollBarHandlerOnMouseOver);
			_s.scrHandler_do.screen.addEventListener("mouseout", _s.scrollBarHandlerOnMouseOut);
			_s.scrHandler_do.screen.addEventListener("mousedown", _s.scrollBarHandlerOnMouseDown);
			_s.scrHandlerLines_do.screen.addEventListener("mouseover", _s.scrollBarHandlerOnMouseOver);
			_s.scrHandlerLines_do.screen.addEventListener("mouseout", _s.scrollBarHandlerOnMouseOut);
			_s.scrHandlerLines_do.screen.addEventListener("mousedown", _s.scrollBarHandlerOnMouseDown);
			
			if(_s.addScrOnMM_bl){
				window.addEventListener('mousemove', _s.scrOnMM);
			}
		};

		_s.scrOnMM = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(FWDUVPUtils.hitTest(_s.mainThumbsHolder_do.screen, vc.screenX, vc.screenY)){
				_s.isDragging_bl = true;
				_s.scrollBarHandlerMoveHandler(e);
			}else{
				_s.isDragging_bl = false;
			}
		}
		
		_s.scrollBarHandlerOnMouseOver = function(e){
			if(!_s.allowToScrollAndScrollBarIsActive_bl || _s.addScrOnMM_bl) return; 
			FWDAnimation.killTweensOf(_s.scrHandlerLinesN_do);
			FWDAnimation.killTweensOf(_s.scrHandlerLinesS_do);
			FWDAnimation.to(_s.scrHandlerLinesN_do, .8, {alpha:0, ease:Expo.easeOut});
			FWDAnimation.to(_s.scrHandlerLinesS_do, .8, {alpha:1, ease:Expo.easeOut});
		};
		
		_s.scrollBarHandlerOnMouseOut = function(e){
			if(_s.isDragging_bl || !_s.allowToScrollAndScrollBarIsActive_bl) return;
			FWDAnimation.killTweensOf(_s.scrHandlerLinesN_do);
			FWDAnimation.killTweensOf(_s.scrHandlerLinesS_do);
			FWDAnimation.to(_s.scrHandlerLinesN_do, .8, {alpha:1, ease:Expo.easeOut});
			FWDAnimation.to(_s.scrHandlerLinesS_do, .8, {alpha:0, ease:Expo.easeOut});
		};
		
		_s.scrollBarHandlerOnMouseDown = function(e){
			if(!_s.allowToScrollAndScrollBarIsActive_bl || _s.addScrOnMM_bl) return;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);		
			_s.isDragging_bl = true;
			_s.yPositionOnPress = _s.scrHandler_do.y;
			_s.lastPresedY = vc.screenY;
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			prt.showDisable();
			
			if(window.addEventListener){
				window.addEventListener("mousemove", _s.scrollBarHandlerMoveHandler);
				window.addEventListener("mouseup", _s.scrollBarHandlerEndHandler);	
			}
		};
		
		_s.scrollBarHandlerMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var linesY = _s.scrollBarHandlerFinalY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLines_do.h)/2);
			if(_s.addScrOnMM_bl){
				_s.scrollBarHandlerFinalY = Math.round(vc.screenY - _s.mainThumbsHolder_do.getGlobalY() - _s.scrHandler_do.h/2);
			}else{
				_s.scrollBarHandlerFinalY = Math.round(_s.yPositionOnPress + vc.screenY - _s.lastPresedY);
			}
			
			if(_s.scrollBarHandlerFinalY >= _s.scrTrack_do.h - _s.scrHandler_do.h){
				_s.scrollBarHandlerFinalY = _s.scrTrack_do.h -  _s.scrHandler_do.h;
			}else if(_s.scrollBarHandlerFinalY <= 0){
				_s.scrollBarHandlerFinalY = 0;
			}
			
			_s.scrHandler_do.setY(_s.scrollBarHandlerFinalY);
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			FWDAnimation.to(_s.scrHandlerLines_do, .8, {y:linesY, ease:Quart.easeOut});
			_s.updateScrollBarHandlerAndContent(true);
		};
		
		_s.scrollBarHandlerEndHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			_s.isDragging_bl = false;
			
			if(!FWDUVPUtils.hitTest(_s.scrHandler_do.screen, vc.screenX, vc.screenY)){
				FWDAnimation.killTweensOf(_s.scrHandlerLinesN_do);
				FWDAnimation.killTweensOf(_s.scrHandlerLinesS_do);
				FWDAnimation.to(_s.scrHandlerLinesN_do, .8, {alpha:1, ease:Expo.easeOut});
				FWDAnimation.to(_s.scrHandlerLinesS_do, .8, {alpha:0, ease:Expo.easeOut});
			}
		
			prt.hideDisable();
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			FWDAnimation.to(_s.scrHandler_do, .4, {y:_s.scrollBarHandlerFinalY, ease:Quart.easeOut});
			
			if(window.removeEventListener){
				window.removeEventListener("mousemove", _s.scrollBarHandlerMoveHandler);
				window.removeEventListener("mouseup", _s.scrollBarHandlerEndHandler);	
			}
		};
		
		_s.updateScrollBarSizeActiveAndDeactivate = function(){
			if(_s.disableForAWhileAfterThumbClick_bl) return;
			if(_s.allowToScrollAndScrollBarIsActive_bl){
				_s.allowToScrollAndScrollBarIsActive_bl = true;
				_s.scrMainHolder_do.setX(_s.sW - _s.scrMainHolder_do.w);
				_s.scrMainHolder_do.setHeight(_s.sH - _s.removeFromThumbsHolderHeight);
				_s.scrTrack_do.setHeight(_s.scrMainHolder_do.h);
				_s.scrTrackMiddle_do.setHeight(_s.scrTrack_do.h - (_s.scrTrackTop_do.h * 2));
				_s.scrTrackBottom_do.setY(_s.scrTrackMiddle_do.y + _s.scrTrackMiddle_do.h);
				_s.scrMainHolder_do.setAlpha(1);
				if(!_s.addScrOnMM_bl){
					_s.scrHandler_do.setButtonMode(true);
					_s.scrHandlerLines_do.setButtonMode(true);
				}
			}else{
				_s.allowToScrollAndScrollBarIsActive_bl = false;
				_s.scrMainHolder_do.setX(_s.sW - _s.scrMainHolder_do.w);
				_s.scrMainHolder_do.setHeight(_s.sH - _s.removeFromThumbsHolderHeight);
				_s.scrTrack_do.setHeight(_s.scrMainHolder_do.h);
				_s.scrTrackMiddle_do.setHeight(_s.scrTrack_do.h - (_s.scrTrackTop_do.h * 2));
				_s.scrTrackBottom_do.setY(_s.scrTrackMiddle_do.y + _s.scrTrackMiddle_do.h);
				_s.scrMainHolder_do.setAlpha(.5);
				_s.scrHandler_do.setY(0);
				_s.scrHandler_do.setButtonMode(false);
				_s.scrHandlerLines_do.setButtonMode(false);
			}
			
			_s.scrHandler_do.setHeight(Math.max(120, Math.round(Math.min(1,(_s.scrMainHolder_do.h/_s.totalThumbsHeight)) * _s.scrMainHolder_do.h)));
			_s.scrHandlerMiddle_do.setHeight(_s.scrHandler_do.h - (_s.scrHandlerTop_do.h * 2));
			_s.scrHandlerBottom_do.setY(_s.scrHandlerMiddle_do.y + _s.scrHandlerMiddle_do.h);
			FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
			_s.scrHandlerLines_do.setY(_s.scrollBarHandlerFinalY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLines_do.h)/2));
			_s.scrHandlerBottom_do.setY(_s.scrHandler_do.h - _s.scrHandlerBottom_do.h);
		};
		
		_s.updateScrollBarHandlerAndContent = function(animate, overwrite){

			if(_s.isMbl && _s.disableForAWhileAfterThumbClick_bl) return;
			if(!_s.allowToScrollAndScrollBarIsActive_bl && !overwrite) return;

			var percentScrolled = 0;
			var thumb;
			
			if(_s.isDragging_bl && !_s.isMbl){
				percentScrolled = (_s.scrollBarHandlerFinalY/(_s.scrMainHolder_do.h - _s.scrHandler_do.h));
				if(percentScrolled == "Infinity"){
					percentScrolled = 0;
				}else if(percentScrolled >= 1){
					percentScrolled = 1;
				}
				_s.thumbsFinalY = Math.round(percentScrolled * (_s.totalThumbsHeight - _s.mainThumbsHolder_do.h)) * -1;
			}else{
				if(_s.isSearched_bl){
					_s.percentScrolled = 0;
					percentScrolled = 0;
				}else{
					percentScrolled = _s.curId/(_s.totalThumbs - 1);
				}
				
				_s.thumbsFinalY = Math.min(0, Math.round(percentScrolled * (_s.totalThumbsHeight - _s.mainThumbsHolder_do.h)) * -1);
				
				if(_s.scrMainHolder_do){
					_s.scrollBarHandlerFinalY = Math.round((_s.scrMainHolder_do.h - _s.scrHandler_do.h) * percentScrolled);
					
					if(_s.scrollBarHandlerFinalY < 0){
						_s.scrollBarHandlerFinalY = 0;
					}else if(_s.scrollBarHandlerFinalY > _s.scrMainHolder_do.h - _s.scrHandler_do.h - 1){
						_s.scrollBarHandlerFinalY = _s.scrMainHolder_do.h - _s.scrHandler_do.h - 1;
					}
					
					FWDAnimation.killTweensOf(_s.scrHandler_do);
					FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
					if(animate){
						FWDAnimation.to(_s.scrHandler_do, .4, {y:_s.scrollBarHandlerFinalY, ease:Quart.easeOut});
						FWDAnimation.to(_s.scrHandlerLines_do, .8, {y:_s.scrollBarHandlerFinalY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLinesN_do.h)/2), ease:Quart.easeOut});
					}else{
						_s.scrHandler_do.setY(_s.scrollBarHandlerFinalY);
						_s.scrHandlerLines_do.setY(_s.scrollBarHandlerFinalY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLinesN_do.h)/2));
					}
				}
			}
			
			if(_s.lastThumbnailFinalY != _s.thumbsFinalY){
				FWDAnimation.killTweensOf(_s.thumbsHolder_do);
				if(animate){
					FWDAnimation.to(_s.thumbsHolder_do, .5, {y:_s.thumbsFinalY, ease:Quart.easeOut});
				}else{
					_s.thumbsHolder_do.setY(_s.thumbsFinalY);
				}
			}
			
			_s.lastThumbnailFinalY = _s.thumbsFinalY;
		};

		
		//###########################################//
		/* Add mousewheel support */
		//###########################################//
		_s.addMouseWheelSupport = function(){
			if(_s.screen.addEventListener){
				_s.screen.addEventListener('DOMMouseScroll', _s.mouseWheelHandler);
				_s.screen.addEventListener ("mousewheel", _s.mouseWheelHandler);
			}
		};
		
		_s.mouseWheelHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			if(_s.disableMouseWheel_bl || _s.isDragging_bl) return false;
			if(_s.comboBox_do && _s.comboBox_do.isShowed_bl) return;
			
			var dir = e.detail || e.wheelDelta;	
			if(e.wheelDelta) dir *= -1;
		
			if(dir > 0){
				_s.scrollBarHandlerFinalY += Math.round((160 * _s.scollbarSpeedSensitivity)  * (_s.mainThumbsHolder_do.h/_s.totalThumbsHeight));
			}else if(dir < 0){
				_s.scrollBarHandlerFinalY -= Math.round((160 * _s.scollbarSpeedSensitivity)  * (_s.mainThumbsHolder_do.h/_s.totalThumbsHeight));
			}
			
			if(_s.scrollBarHandlerFinalY >= _s.scrTrack_do.h - _s.scrHandler_do.h){
				_s.scrollBarHandlerFinalY = _s.scrTrack_do.h -  _s.scrHandler_do.h;
			}else if(_s.scrollBarHandlerFinalY <= 0){
				_s.scrollBarHandlerFinalY = 0;
			}
			
			var linesY = _s.scrollBarHandlerFinalY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLines_do.h)/2);
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
			FWDAnimation.to(_s.scrHandlerLines_do, .8, {y:linesY, ease:Quart.easeOut});
			FWDAnimation.to(_s.scrHandler_do, .5, {y:_s.scrollBarHandlerFinalY, ease:Quart.easeOut});
			_s.isDragging_bl = true;
			_s.updateScrollBarHandlerAndContent(true);
			_s.isDragging_bl = false;
		
			if(e.preventDefault){
				e.preventDefault();
			}else{
				return false;
			}
		};

		
		//################################//
		/* show / hide */
		//################################//
		_s.hideAndShow = function(animate){
			if(_s.position_str == "bottom"){
				_s.mainHld.setY(-_s.sH);
				FWDAnimation.to(_s.mainHld, .8, {y:0, delay: .3, ease:Expo.easeInOut});
			}else{
				_s.mainHld.setX(-_s.sW - 2);
				FWDAnimation.to(_s.mainHld, .8, {x:0, delay: .3, ease:Expo.easeInOut});
				if(_s.ec){
					_s.positionEc();
					_s.ec.setAlpha(0);
					FWDAnimation.to(_s.ec, .8, {alpha:1, delay: .3, ease:Expo.easeInOut});
				}
			}
		};
		
		_s.hide = function(animate){
		
			_s.isShowed_bl = false;
			if(animate){
				if(_s.position_str == "bottom"){
					FWDAnimation.to(_s.mainHld, .8, {y: -_s.sH, ease:Expo.easeInOut});
				}
			}else{
				FWDAnimation.killTweensOf(_s.mainHld);
				if(_s.position_str == "bottom"){
					_s.mainHld.setY(-_s.sH);
				}
			}
		};
		
		_s.show = function(animate){

			_s.isShowed_bl = true;
			if(!FWDAnimation.isTweening(_s.mainHld)) _s.hide(false);
			if(animate){
				if(_s.position_str == "bottom"){
					FWDAnimation.to(_s.mainHld, .8, {y:0, ease:Expo.easeInOut});
				}else{
					_s.mainHld.setY(0);
				}
			}else{
				FWDAnimation.killTweensOf(_s.mainHld);
				_s.mainHld.setX(0);
				_s.mainHld.setY(0);
				clearTimeout(_s.disableThumbsId_to);
				_s.disableThumbsId_to =  setTimeout(function(){_s.disableThumbs_bl = false;}, 200);
				_s.disableThumbs_bl = true;
			}
		};
	
		_s.init();
	};
	
	
	/* set prototype */
    FWDUVPPlaylist.setPrototype = function(){
    	FWDUVPPlaylist.prototype = new FWDUVPDisplayObject("div", "absolute", "visible");
    };
    
    FWDUVPPlaylist.THUMB_MOUSE_UP = "thumbMouseOut";
    FWDUVPPlaylist.PLAY_PREV_VIDEO = "playPrevVideo";
	FWDUVPPlaylist.PLAY_NEXT_VIDEO = "playNextVideo";
	FWDUVPPlaylist.DISABLE_LOOP = "disableLoop";
	FWDUVPPlaylist.ENABLE_LOOP = "enableLoop";
	FWDUVPPlaylist.DISABLE_SHUFFLE = "disableShuffle";
	FWDUVPPlaylist.ENABLE_SHUFFLE = "enableShuffle";
	FWDUVPPlaylist.CHANGE_PLAYLIST = "changePlaylist";
    
    FWDUVPPlaylist.prototype = null;
	window.FWDUVPPlaylist = FWDUVPPlaylist;
}(window));