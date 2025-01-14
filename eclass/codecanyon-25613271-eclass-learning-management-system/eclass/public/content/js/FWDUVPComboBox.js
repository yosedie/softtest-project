/**
 * Ultimate Video Player PACKAGED v9.1
 * Playlist select box.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPComboBox = function(prt, props_obj){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPComboBox.prototype;
		
		_s.categories_ar = props_obj.categories_ar;
		_s.buttons_ar = [];
		
		_s.arrowW = props_obj.arrowW;
		_s.arrowH = props_obj.arrowH;
		
		_s.useHEX = prt._d.useHEX; 
		_s.nBC = prt._d.nBC;
		_s.sBC = prt._d.sBC;
	
		_s.arrowN_str = props_obj.arrowN_str 
		_s.arrowS_str = props_obj.arrowS_str;
		
		_s.selLabel = props_obj.selectorLabel;
		_s.selBkColN = props_obj.selectorBackgroundNormalColor;
		_s.selBkColS = props_obj.selectorBackgroundSelectedColor;
		_s.selTxtColN = props_obj.selectorTextNormalColor;
		_s.selTxtColS = props_obj.selectorTextSelectedColor;
		
		_s.itmBkClrN = props_obj.buttonBackgroundNormalColor;
		_s.itmBkClrS = props_obj.buttonBackgroundSelectedColor;
		_s.itmTxtClrN = props_obj.buttonTextNormalColor;
		_s.itmTxtClrS = props_obj.buttonTextSelectedColor;
		
		_s.scrBarHandY = 0;
		_s.ttBtns = _s.categories_ar.length;
		_s.curId = props_obj.startAtPlaylist;
		_s.btnsHldW = 0;
		_s.btnsHldH = 0;
		_s.totalWidth = prt.sW;
		_s.buttonHeight = props_obj.buttonHeight;
		
		_s.ttBtnH = 0;
		_s.spcBtwBtns = 1;
		_s.thmbsFinY = 0;
		_s.vy = 0;
		_s.vy2 = 0;
		_s.frc = .9;
	
		_s.addMouseWheelSupport_bl = prt._d.addMouseWheelSupport_bl;
		_s.scollbarSpeedSensitivity = prt._d.scollbarSpeedSensitivity;
		_s.hasPointEvt = FWDUVPUtils.hasPointerEvent;
		_s.isMbl = FWDUVPUtils.isMobile;
		

		//#####################################//
		/* Initialize */
		//####################################//
		_s.init = function(){
			_s.setOverflow("visible");
			_s.setupMainContainers();
			_s.setupScrollLogic();
			_s.getMaxWidthResizeAndPosition();
			_s.mainButtonsHolder_do.setVisible(false);
			_s.bk_do.setVisible(false);
			
		};
		

		//#####################################//
		/* setup main containers */
		//####################################//
		_s.setupMainContainers = function(){
			var button_do;
			
			_s.mainHld = new FWDUVPDisplayObject("div");
			_s.mainHld.setOverflow("visible");
			_s.addChild(_s.mainHld);
			
			_s.bk_do = new FWDUVPDisplayObject("div");
			_s.bk_do.screen.className = 'fwduvp-combobox-background';
			_s.bk_do.setY(_s.buttonHeight);
			_s.bk_do.setBkColor(prt.playlistBackgroundColor_str);
			_s.bk_do.setAlpha(0);
			
			_s.mainHld.addChild(_s.bk_do);
			
			_s.mainButtonsHolder_do = new FWDUVPDisplayObject("div");
			_s.mainButtonsHolder_do.setY(_s.buttonHeight);
			_s.mainHld.addChild(_s.mainButtonsHolder_do);
			
			if(prt.repeatBackground_bl){
				_s.dummyBk_do =  new FWDUVPDisplayObject("div");
				_s.dummyBk_do.getStyle().background = "url('" + prt.bkPath_str +  "')";
			}else{
				_s.dummyBk_do = new FWDUVPDisplayObject("img");
				var imageBk_img = new Image();
				imageBk_img.src = prt.bkPath_str;
				_s.dummyBk_do.setScreen(imageBk_img);
			}
	
			_s.dummyBk_do.setHeight(_s.buttonHeight);
			_s.mainHld.addChild(_s.dummyBk_do);
			
			_s.buttonsHolder_do = new FWDUVPDisplayObject("div");
			_s.mainButtonsHolder_do.addChild(_s.buttonsHolder_do);
			
			var selLabel = _s.selLabel;
			
			if (_s.selLabel == "default"){
				selLabel = _s.categories_ar[_s.curId];
			}
			
			FWDUVPComboBoxSelector.setPrototype();
			_s.selector_do = new FWDUVPComboBoxSelector(
					11,
					6,
					props_obj.arrowN_str,
					props_obj.arrowS_str,
					selLabel,
					_s.selBkColN,
					_s.selBkColS,
					_s.selTxtColN,
					_s.selTxtColS,
					_s.buttonHeight,
					_s.useHEX,
					_s.nBC,
					_s.sBC);
			_s.mainHld.addChild(_s.selector_do);
			_s.selector_do.setNormalState(false);
			_s.selector_do.addListener(FWDUVPComboBoxSelector.CLICK, _s.openMenuHandler);
			
			for(var i=0; i<_s.ttBtns; i++){
				FWDUVPComboBoxButton.setPrototype();


				button_do = new FWDUVPComboBoxButton(
						_s,
						_s.categories_ar[i],
						_s.itmBkClrN,
						_s.itmBkClrS,
						_s.itmTxtClrN,
						_s.itmTxtClrS,
						i,
						_s.buttonHeight);
				_s.buttons_ar[i] = button_do;
				button_do.addListener(FWDUVPComboBoxButton.CLICK, _s.buttonOnMouseDownHandler);
				_s.buttonsHolder_do.addChild(button_do);
			}
		};

		_s.buttonOnMouseDownHandler = function(e){
			_s.curId = e.id;
			clearTimeout(_s.hideMenuTimeOutId_to);
			_s.hide(true);
			_s.selector_do.enable(); 
			if(_s.hasPointEvt){
				window.removeEventListener("pointerdown", _s.checkOpenedMenu);
			}else{
				window.removeEventListener("touchstart", _s.checkOpenedMenu);
				if(!_s.isMbl){
					window.removeEventListener("mousedown", _s.checkOpenedMenu);
					window.removeEventListener("mousemove", _s.checkOpenedMenu);
				}
			}
		
			_s.selector_do.setText(_s.buttons_ar[_s.curId].label1_str);
			_s.dispatchEvent(FWDUVPComboBox.BUTTON_PRESSED, {id:_s.curId});
		};

		_s.openMenuHandler = function(e){
			if(FWDAnimation.isTweening(_s.mainButtonsHolder_do)) return;
			if(_s.isShd){
				_s.checkOpenedMenu(e.e, true);
			}else{
				_s.selector_do.disable();
				_s.show(true);
				_s.startToCheckOpenedMenu();
				_s.dispatchEvent(FWDUVPComboBox.OPEN);
			}
		};
		

		//#######################################//
		/* Disable or enable buttons */
		//#######################################//
		_s.setButtonsStateBasedOnId = function(id){
			_s.curId = id;
			for(var i=0; i<_s.ttBtns; i++){
				var button_do = _s.buttons_ar[i];
				if(i == _s.curId){
					button_do.disable();
				}else{
					button_do.enable();
				}
			}
			_s.selector_do.setText(_s.buttons_ar[_s.curId].label1_str);
			if(_s.scrHandler_do){
				_s.updateScrollBarSizeActiveAndDeactivate();
				_s.updateScrollBarHandlerAndContent(false, true);
			}else{
				_s.thmbsFinY = 0;
			}
		};
		
		_s.setValue = function(id){
			_s.curId = id;
			_s.setButtonsStateBasedOnId();
		};


		//#######################################//
		/* Start to check if mouse is over menu */
		//#######################################//
		_s.startToCheckOpenedMenu = function(e){
			if(_s.hasPointEvt){
				window.addEventListener("pointerdown", _s.checkOpenedMenu);
			}else{
				window.addEventListener("touchstart", _s.checkOpenedMenu);
				if(!_s.isMbl){
					window.addEventListener("mousedown", _s.checkOpenedMenu);
				}
			}
		};
		_s.checkOpenedMenu = function(e, forceHide){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var hideDelay  = 1000;
			if(e.type == "mousedown") hideDelay = 0;

			if(!FWDUVPUtils.hitTest(_s.screen, vc.screenX, vc.screenY) &&
			   !FWDUVPUtils.hitTest(_s.mainButtonsHolder_do.screen, vc.screenX, vc.screenY)
			   || forceHide
			){
				_s.hide(true);
				_s.selector_do.enable();
				if(_s.hasPointEvt){
					window.removeEventListener("pointerdown", _s.checkOpenedMenu);
				}else{
					if(!_s.isMbl){
						window.removeEventListener("touchstart", _s.checkOpenedMenu);
						window.removeEventListener("mousemove", _s.checkOpenedMenu);
					}
					window.removeEventListener("mousedown", _s.checkOpenedMenu);
				}
			}else{
				clearTimeout(_s.hideMenuTimeOutId_to);
			}

			if(FWDUVPUtils.hitTest(_s.selector_do.screen, vc.screenX, vc.screenY) && !_s.isMbl){
				setTimeout(function(){
					_s.selector_do.setSelectedState(true);
				}, 50)
			}
		};
		
		
		//########################################//
		/* Get max width and position */
		//#######################################//
		_s.getMaxWidthResizeAndPosition = function(){
			
			var button_do;
			var finalX;
			var finalY;
			_s.ttBtnH = 0;		
			
			for(var i=0; i<_s.ttBtns; i++){
				button_do = _s.buttons_ar[i];
				button_do.setY((i * (button_do.totalHeight + _s.spcBtwBtns)));
				if(_s.allowToScrollAndScrollBarIsActive_bl && !_s.isMbl){
					_s.totalWidth = prt.sW ;
				}else{
					_s.totalWidth = prt.sW;
				}
				
				button_do.totalWidth =  _s.totalWidth;
				button_do.setWidth(_s.totalWidth);
				button_do.centerText();
			}
		
			_s.ttBtnH = button_do.getY() + button_do.totalHeight - _s.spcBtwBtns;
			var offset = 2;
			if(_s.isMbl){
				offset = 0;
			}
			
			_s.dummyBk_do.setWidth(_s.totalWidth + offset);
			_s.setWidth(_s.totalWidth);
			_s.setHeight(_s.buttonHeight);
			_s.selector_do.totalWidth =  _s.totalWidth + offset;
			_s.selector_do.setWidth(_s.totalWidth + offset);
			_s.selector_do.centerText();
			_s.buttonsHolder_do.setWidth(_s.totalWidth);
			_s.buttonsHolder_do.setHeight(_s.ttBtnH);	
		};

		//######################################//
		/* position */
		//######################################//
		_s.position = function(){		
			if (FWDUVPUtils.isAndroid){
				_s.setX(Math.floor(_s.finalX));
				_s.setY(Math.floor(_s.finalY-1));
				setTimeout(_s.poscombo-box, 100);
			}else{
				_s.poscombo-box();
			}
		};
			
		_s.resizeAndPosition = function(){
			_s.sW = prt.sW;
			_s.sH = prt.sH;
			_s.bk_do.setWidth(_s.sW);
			_s.bk_do.setHeight(_s.sH - prt.removeFromThumbsHolderHeight + 5);
			_s.mainButtonsHolder_do.setWidth(_s.sW);
			_s.mainButtonsHolder_do.setHeight(_s.sH - prt.removeFromThumbsHolderHeight);

			if(_s.ttBtnH > _s.mainButtonsHolder_do.h){
				_s.allowToScrollAndScrollBarIsActive_bl = true;
			}else{
				_s.allowToScrollAndScrollBarIsActive_bl = false;
			}
			
			if(!_s.allowToScrollAndScrollBarIsActive_bl && _s.scrMainHolder_do){
				_s.scrMainHolder_do.setVisible(false);
			}else if(_s.allowToScrollAndScrollBarIsActive_bl && _s.scrMainHolder_do && _s.isShd){
				_s.scrMainHolder_do.setVisible(true);
			}
			
			if(_s.scrHandler_do) _s.updateScrollBarSizeActiveAndDeactivate();
			_s.getMaxWidthResizeAndPosition();
			_s.updateScrollBarHandlerAndContent();
		};
		
		_s.hide = function(animate, overwrite){
			if(!_s.isShd && !overwrite) return;
			FWDAnimation.killTweensOf(_s);
			_s.isShd = false;
			FWDAnimation.killTweensOf(_s.mainButtonsHolder_do);
			FWDAnimation.killTweensOf(_s.bk_do);
			if(animate){
				FWDAnimation.to(_s.mainButtonsHolder_do, .8, {y:-_s.ttBtnH, ease:Expo.easeInOut, onComplete:_s.hideComplete});	
				FWDAnimation.to(_s.bk_do, .8, {alpha:0});	
			}else{
				_s.mainButtonsHolder_do.setY(_s.buttonHeight - _s.ttBtnH);
				_s.bk_do.setAlpha(0);
				_s.setHeight(_s.buttonHeight);
			}
		};
		
		_s.hideComplete = function(){
			_s.mainButtonsHolder_do.setVisible(false);
			_s.bk_do.setVisible(false);
		}

		_s.show = function(animate, overwrite){
			if(_s.isShd && !overwrite) return;
			FWDAnimation.killTweensOf(_s);
			_s.mainButtonsHolder_do.setY(- _s.ttBtnH);
			_s.isShd = true;
			_s.mainButtonsHolder_do.setVisible(true);
			_s.bk_do.setVisible(true);
			_s.resizeAndPosition();
			FWDAnimation.killTweensOf(_s.mainButtonsHolder_do);
			FWDAnimation.killTweensOf(_s.bk_do);
			if(_s.scrMainHolder_do && _s.allowToScrollAndScrollBarIsActive_bl) _s.scrMainHolder_do.setVisible(true);
		
			if(animate){
				FWDAnimation.to(_s.bk_do, .8, {alpha:1});
				FWDAnimation.to(_s.mainButtonsHolder_do, .8, {y:_s.buttonHeight + prt.spaceBetweenThumbnails, ease:Expo.easeInOut});
			}else{
				_s.bk_do.setAlpha(1);
				_s.mainButtonsHolder_do.setY(_s.buttonHeight + prt.spaceBetweenThumbnails);
			}
		};
		_s.setupScrollLogic = function(){
			
			_s.setupMobileScrollbar();
			if(!_s.isMbl) _s.setupScrollbar();
			if(_s.addMouseWheelSupport_bl) _s.addMouseWheelSupport();
		};
		

		//##########################################//
		/* setup mobile scrollbar */
		//##########################################//
		_s.setupMobileScrollbar = function(){
			if(_s.hasPointEvt){
				_s.mainButtonsHolder_do.screen.addEventListener("pointerdown", _s.scrollBarTouchStartHandler);
			}else{
				_s.mainButtonsHolder_do.screen.addEventListener("touchstart", _s.scrollBarTouchStartHandler);
			}
			if(_s.isMbl) _s.updateMobileScrollBarId_int = setInterval(_s.updateMobileScrollBar, 16);
		};

		_s.scrollBarTouchStartHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			_s.isScrollingOnMove_bl = false;
			FWDAnimation.killTweensOf(_s.buttonsHolder_do);
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);		
			_s.isDragging_bl = true;
			_s.lastPresedY = vc.screenY;
			_s.checkLastPresedY = vc.screenY;
			if(_s.hasPointEvt){
				window.addEventListener("pointerup", _s.scrollBarTouchEndHandler);
				window.addEventListener("pointermove", _s.scrollBarTouchMoveHandler);
			}else{
				window.addEventListener("touchend", _s.scrollBarTouchEndHandler);
				window.addEventListener("touchmove", _s.scrollBarTouchMoveHandler, {passive:false});
			}
			window.addEventListener("mouseup", _s.scrollBarTouchEndHandler);
			window.addEventListener("mousemove", _s.scrollBarTouchMoveHandler);
			clearInterval(_s.updateMoveMobileScrollbarId_int);
			_s.updateMoveMobileScrollbarId_int = setInterval(_s.updateMoveMobileScrollbar, 20);
		};

		_s.scrollBarTouchMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			e.stopImmediatePropagation();
			if(_s.ttBtnH < _s.mainButtonsHolder_do.h) return;
			prt.prt.showDisable();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(vc.screenY >= _s.checkLastPresedY + 6 || vc.screenY <= _s.checkLastPresedY - 6) _s.isScrollingOnMove_bl = true;
			var toAdd = vc.screenY - _s.lastPresedY;
			_s.thmbsFinY += toAdd;
			_s.thmbsFinY = Math.round(_s.thmbsFinY);
			_s.lastPresedY = vc.screenY;
			_s.vy = toAdd  * 2;
			
			if(!_s.isMobile){
				if(_s.thmbsFinY > 0){
					_s.thmbsFinY = 0;
				}else if(_s.thmbsFinY < _s.mainButtonsHolder_do.h - _s.ttBtnH){
					_s.thmbsFinY = _s.mainButtonsHolder_do.h - _s.ttBtnH;
				}	
				
				var percentScrolled = Math.max(0,(_s.thmbsFinY/(_s.mainButtonsHolder_do.h - _s.ttBtnH)));
				
				if(_s.scrMainHolder_do){
					_s.scrBarHandY = Math.round((_s.scrMainHolder_do.h - _s.scrHandler_do.h) * percentScrolled);
					
					if(_s.scrBarHandY < 0){
						_s.scrBarHandY = 0;
					}else if(_s.scrBarHandY > _s.scrMainHolder_do.h - _s.scrHandler_do.h - 1){
						_s.scrBarHandY = _s.scrMainHolder_do.h - _s.scrHandler_do.h - 1;
					}
					
					FWDAnimation.killTweensOf(_s.scrHandler_do);
					FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
					
						_s.scrHandler_do.setY(_s.scrBarHandY);
						_s.scrHandlerLines_do.setY(_s.scrBarHandY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLinesN_do.h)/2));
					
				}
			}
		};

		_s.scrollBarTouchEndHandler = function(e){
			_s.isDragging_bl = false;
			clearInterval(_s.updateMoveMobileScrollbarId_int);
			clearTimeout(_s.disableOnMoveId_to);
			_s.disableOnMoveId_to = setTimeout(function(){
				prt.prt.hideDisable();
			},100);
			if(_s.hasPointEvt){
				window.removeEventListener("pointerup", _s.scrollBarTouchEndHandler);
				window.removeEventListener("pointermove", _s.scrollBarTouchMoveHandler);
			}else{
				window.removeEventListener("touchend", _s.scrollBarTouchEndHandler);
				window.removeEventListener("touchmove", _s.scrollBarTouchMoveHandler);
			}
			window.removeEventListener("mousemove", _s.scrollBarTouchMoveHandler);
		};

		_s.updateMoveMobileScrollbar = function(){
			_s.buttonsHolder_do.setY(_s.thmbsFinY);
		};

		_s.updateMobileScrollBar = function(animate){
			if(!_s.isDragging_bl){
				if(_s.ttBtnH < _s.mainButtonsHolder_do.h) _s.thmbsFinY = 0.01;
				_s.vy *= _s.frc;
				_s.thmbsFinY += _s.vy;	
				if(_s.thmbsFinY > 0){
					_s.vy2 = (0 - _s.thmbsFinY) * .3;
					_s.vy *= _s.frc;
					_s.thmbsFinY += _s.vy2;
				}else if(_s.thmbsFinY < _s.mainButtonsHolder_do.h - _s.ttBtnH){
					_s.vy2 = (_s.mainButtonsHolder_do.h - _s.ttBtnH - _s.thmbsFinY) * .3;
					_s.vy *= _s.frc;
					_s.thmbsFinY += _s.vy2;
				}
				_s.buttonsHolder_do.setY(Math.round(_s.thmbsFinY));
			}
		};

		//#################################//
		/* setup mouse scrollbar */
		//#################################//
		_s.setupScrollbar = function(){
			_s.scrMainHolder_do = new FWDUVPDisplayObject("div");
			_s.scrMainHolder_do.setVisible(false);
			
			_s.scrMainHolder_do.setWidth(prt.scrWidth);
			
			//track
			_s.scrTrack_do = new FWDUVPDisplayObject("div");
			_s.scrTrack_do.setWidth(prt.scrWidth);
			
			var scrBkTop_img = new Image();
			scrBkTop_img.src = prt.scrBkTop_img.src;
			_s.scrTrackTop_do = new FWDUVPDisplayObject("img");
			_s.scrTrackTop_do.setWidth(prt.scrTrackTop_do.w);
			_s.scrTrackTop_do.setHeight(prt.scrTrackTop_do.h);
			_s.scrTrackTop_do.setScreen(scrBkTop_img);
			
			_s.scrTrackMiddle_do = new FWDUVPDisplayObject("div");
			_s.scrTrackMiddle_do.getStyle().background = "url('" + prt._d.scrBkMiddlePath_str + "')";
			_s.scrTrackMiddle_do.setWidth(prt.scrWidth);
			_s.scrTrackMiddle_do.setY(_s.scrTrackTop_do.h);
		
			var scrTrackBottomImage_img = new Image();
			scrTrackBottomImage_img.src = prt._d.scrBkBottomPath_str;
			_s.scrTrackBottom_do = new FWDUVPDisplayObject("img");
			_s.scrTrackBottom_do.setScreen(scrTrackBottomImage_img);
			_s.scrTrackBottom_do.setWidth(_s.scrTrackTop_do.w);
			_s.scrTrackBottom_do.setHeight(_s.scrTrackTop_do.h);
			
			//handler
			_s.scrHandler_do = new FWDUVPDisplayObject("div");
			_s.scrHandler_do.setWidth(prt.scrWidth);
		
			_s.scrDragTop_img = new Image();
			_s.scrDragTop_img.src = prt.scrDragTop_img.src;
			_s.scrDragTop_img.width = prt.scrDragTop_img.width;
			_s.scrDragTop_img.height = prt.scrDragTop_img.height;
			
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
			_s.middleImage.src = prt._d.scrDragMiddlePath_str;
			if(_s.useHEX){
				_s.middleImage.onload = function(){
					_s.scrubberDragMiddle_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.middleImage, _s.nBC, true);
					_s.scrubberDragImage_img = _s.scrubberDragMiddle_canvas.image;
					_s.scrHandlerMiddle_do.getStyle().background = "url('" + _s.scrubberDragImage_img.src + "') repeat-y";
				}
			}else{
				_s.scrHandlerMiddle_do.getStyle().background = "url('" + prt._d.scrDragMiddlePath_str + "')";
			}
	
			_s.scrHandlerMiddle_do.setWidth(prt.scrWidth);
			_s.scrHandlerMiddle_do.setY(_s.scrHandlerTop_do.h);
			
			_s.scrHandlerBottom_do = new FWDUVPDisplayObject("div");
			_s.bottomImage = new Image();
			_s.bottomImage.src = prt._d.scrDragMiddlePath_str;
			if(_s.useHEX){
				_s.bottomImage.onload = function(){
					_s.scrubberDragBottom_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.bottomImage, _s.nBC, true);
					_s.scrubberDragBottomImage_img = _s.scrubberDragBottom_canvas.image;
					_s.scrHandlerBottom_do.getStyle().background = "url('" + _s.scrubberDragBottomImage_img.src + "') repeat-y";
					
				}
			}else{
				_s.scrHandlerBottom_do.getStyle().background = "url('" + prt._d.scrDragBottomPath_str + "')";
			}
			_s.scrHandlerBottom_do.setWidth(prt.scrWidth);
			_s.scrHandlerBottom_do.setY(_s.scrHandlerTop_do.h);
			
			_s.scrHandlerBottom_do.setWidth(_s.scrHandlerTop_do.w);
			_s.scrHandlerBottom_do.setHeight(_s.scrHandlerTop_do.h);
			_s.scrHandler_do.setButtonMode(true);
			
			_s.scrLinesN_img = new Image();
			_s.scrLinesN_img.src = prt.scrLinesN_img.src;
			_s.scrLinesN_img.width = prt.scrLinesN_img.width;
			_s.scrLinesN_img.height = prt.scrLinesN_img.height;
			
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
			_s.scrHandlerLinesS_img.src = prt._d.scrLinesSPath_str;
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
			_s.scrHandlerLines_do.setButtonMode(true);
				
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
			_s.mainButtonsHolder_do.addChild(_s.scrMainHolder_do);
			
			_s.scrHandler_do.screen.addEventListener("mouseover", _s.scrollBarHandlerOnMouseOver);
			_s.scrHandler_do.screen.addEventListener("mouseout", _s.scrollBarHandlerOnMouseOut);
			_s.scrHandler_do.screen.addEventListener("mousedown", _s.scrollBarHandlerOnMouseDown);
			_s.scrHandlerLines_do.screen.addEventListener("mouseover", _s.scrollBarHandlerOnMouseOver);
			_s.scrHandlerLines_do.screen.addEventListener("mouseout", _s.scrollBarHandlerOnMouseOut);
			_s.scrHandlerLines_do.screen.addEventListener("mousedown", _s.scrollBarHandlerOnMouseDown);
		
		};
		
		_s.scrollBarHandlerOnMouseOver = function(e){
			if(!_s.allowToScrollAndScrollBarIsActive_bl) return; 
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
			if(!_s.allowToScrollAndScrollBarIsActive_bl) return;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);		
			_s.isDragging_bl = true;
			_s.yPositionOnPress = _s.scrHandler_do.y;
			_s.lastPresedY = vc.screenY;
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			prt.prt.showDisable();
			
			if(window.addEventListener){
				window.addEventListener("mousemove", _s.scrollBarHandlerMoveHandler);
				window.addEventListener("mouseup", _s.scrollBarHandlerEndHandler);	
			}else if(document.attachEvent){
				document.attachEvent("onmousemove", _s.scrollBarHandlerMoveHandler);
				document.attachEvent("onmouseup", _s.scrollBarHandlerEndHandler);
			}
		};
		
		_s.scrollBarHandlerMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			var linesY = _s.scrBarHandY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLines_do.h)/2);
	
			_s.scrBarHandY = Math.round(_s.yPositionOnPress + vc.screenY - _s.lastPresedY);
			if(_s.scrBarHandY >= _s.scrTrack_do.h - _s.scrHandler_do.h){
				_s.scrBarHandY = _s.scrTrack_do.h -  _s.scrHandler_do.h;
			}else if(_s.scrBarHandY <= 0){
				_s.scrBarHandY = 0;
			}
			
			_s.scrHandler_do.setY(_s.scrBarHandY);
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
			
			prt.prt.hideDisable();
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			FWDAnimation.to(_s.scrHandler_do, .4, {y:_s.scrBarHandY, ease:Quart.easeOut});
			
			if(window.removeEventListener){
				window.removeEventListener("mousemove", _s.scrollBarHandlerMoveHandler);
				window.removeEventListener("mouseup", _s.scrollBarHandlerEndHandler);	
			}else if(document.detachEvent){
				document.detachEvent("onmousemove", _s.scrollBarHandlerMoveHandler);
				document.detachEvent("onmouseup", _s.scrollBarHandlerEndHandler);
			}
		};
		
		_s.updateScrollBarSizeActiveAndDeactivate = function(){
			if(_s.disableForAWhileAfterThumbClick_bl) return;
		
			if(_s.allowToScrollAndScrollBarIsActive_bl){
				_s.allowToScrollAndScrollBarIsActive_bl = true;
				_s.scrMainHolder_do.setX(_s.sW - _s.scrMainHolder_do.w);
				_s.scrMainHolder_do.setHeight(_s.mainButtonsHolder_do.h);
				_s.scrTrack_do.setHeight(_s.scrMainHolder_do.h);
				_s.scrTrackMiddle_do.setHeight(_s.scrTrack_do.h - (_s.scrTrackTop_do.h * 2));
				_s.scrTrackBottom_do.setY(_s.scrTrackMiddle_do.y + _s.scrTrackMiddle_do.h);
				_s.scrMainHolder_do.setAlpha(1);
				_s.scrHandler_do.setButtonMode(true);
				_s.scrHandlerLines_do.setButtonMode(true);
			}else{
				_s.allowToScrollAndScrollBarIsActive_bl = false;
				_s.scrMainHolder_do.setX(_s.sW - _s.scrMainHolder_do.w);
				_s.scrMainHolder_do.setHeight(_s.mainButtonsHolder_do.h);
				_s.scrTrack_do.setHeight(_s.scrMainHolder_do.h);
				_s.scrTrackMiddle_do.setHeight(_s.scrTrack_do.h - (_s.scrTrackTop_do.h * 2));
				_s.scrTrackBottom_do.setY(_s.scrTrackMiddle_do.y + _s.scrTrackMiddle_do.h);
				_s.scrMainHolder_do.setAlpha(.5);
				_s.scrHandler_do.setY(0);
				_s.scrHandler_do.setButtonMode(false);
				_s.scrHandlerLines_do.setButtonMode(false);
			}
			
			_s.scrHandler_do.setHeight(Math.max(120, Math.round(Math.min(1,(_s.scrMainHolder_do.h/_s.ttBtnH)) * _s.scrMainHolder_do.h)));
			_s.scrHandlerMiddle_do.setHeight(_s.scrHandler_do.h - (_s.scrHandlerTop_do.h * 2));
			_s.scrHandlerBottom_do.setY(_s.scrHandlerMiddle_do.y + _s.scrHandlerMiddle_do.h);
			FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
			_s.scrHandlerLines_do.setY(_s.scrBarHandY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLines_do.h)/2));
			_s.scrHandlerBottom_do.setY(_s.scrHandler_do.h - _s.scrHandlerBottom_do.h);
		};

		
		//###########################################//
		/* Add mousewheel support */
		//###########################################//
		_s.addMouseWheelSupport = function(){
			if(_s.screen.addEventListener){
				_s.screen.addEventListener('DOMMouseScroll', _s.mouseWheelHandler);
				_s.screen.addEventListener ("mousewheel", _s.mouseWheelHandler);
			}else if(_s.screen.attachEvent){
				_s.screen.attachEvent('onmousewheel', _s.mouseWheelHandler);
			}
		};
	
		_s.mouseWheelHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			if(_s.disableMouseWheel_bl || _s.isDragging_bl) return false;
			var dir = e.detail || e.wheelDelta;	
			if(e.wheelDelta) dir *= -1;
			if(dir > 0){
				_s.scrBarHandY += Math.round((160 * _s.scollbarSpeedSensitivity)  * (_s.mainButtonsHolder_do.h/_s.ttBtnH));
			}else if(dir < 0){
				_s.scrBarHandY -= Math.round((160 * _s.scollbarSpeedSensitivity)  * (_s.mainButtonsHolder_do.h/_s.ttBtnH));
			}
			
			if(_s.scrBarHandY >= _s.scrTrack_do.h - _s.scrHandler_do.h){
				_s.scrBarHandY = _s.scrTrack_do.h -  _s.scrHandler_do.h;
			}else if(_s.scrBarHandY <= 0){
				_s.scrBarHandY = 0;
			}
			
			var linesY = _s.scrBarHandY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLines_do.h)/2);
			FWDAnimation.killTweensOf(_s.scrHandler_do);
			FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
			FWDAnimation.to(_s.scrHandlerLines_do, .8, {y:linesY, ease:Quart.easeOut});
			FWDAnimation.to(_s.scrHandler_do, .5, {y:_s.scrBarHandY, ease:Quart.easeOut});
			_s.isDragging_bl = true;
			_s.updateScrollBarHandlerAndContent(true);
			_s.isDragging_bl = false;
		
			if(e.preventDefault){
				e.preventDefault();
			}else{
				return false;
			}
		};
		
		_s.updateScrollBarHandlerAndContent = function(animate, overwrite){
			if(_s.disableForAWhileAfterThumbClick_bl) return;
			if(!_s.allowToScrollAndScrollBarIsActive_bl && !overwrite) return;

			var percentScrolled = 0;
			var thumb;
			if(_s.isDragging_bl && !_s.isMbl){
				percentScrolled = (_s.scrBarHandY/(_s.scrMainHolder_do.h - _s.scrHandler_do.h));
				if(percentScrolled == "Infinity"){
					percentScrolled = 0;
				}
				_s.thmbsFinY = Math.round(percentScrolled * (_s.ttBtnH - _s.mainButtonsHolder_do.h)) * -1;
				if(_s.mainButtonsHolder_do.h == 0) _s.thmbsFinY = 0;
			}else{
				percentScrolled = _s.curId/(_s.ttBtns - 1);
				_s.thmbsFinY = Math.min(0, Math.round(percentScrolled * (_s.ttBtnH - _s.mainButtonsHolder_do.h)) * -1);
				if(_s.mainButtonsHolder_do.h == 0) _s.thmbsFinY = 0;
				if(_s.scrMainHolder_do){
					_s.scrBarHandY = Math.round((_s.scrMainHolder_do.h - _s.scrHandler_do.h) * percentScrolled);
					if(_s.scrBarHandY < 0){
						_s.scrBarHandY = 0;
					}else if(_s.scrBarHandY > _s.scrMainHolder_do.h - _s.scrHandler_do.h - 1){
						_s.scrBarHandY = _s.scrMainHolder_do.h - _s.scrHandler_do.h - 1;
					}
					
					FWDAnimation.killTweensOf(_s.scrHandler_do);
					FWDAnimation.killTweensOf(_s.scrHandlerLines_do);
					if(animate){
						FWDAnimation.to(_s.scrHandler_do, .4, {y:_s.scrBarHandY, ease:Quart.easeOut});
						FWDAnimation.to(_s.scrHandlerLines_do, .8, {y:_s.scrBarHandY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLinesN_do.h)/2), ease:Quart.easeOut});
					}else{
						_s.scrHandler_do.setY(_s.scrBarHandY);
						_s.scrHandlerLines_do.setY(_s.scrBarHandY + parseInt((_s.scrHandler_do.h - _s.scrHandlerLinesN_do.h)/2));
					}
				}
			}
			
			if(_s.lastThumbnailFinalY != _s.thmbsFinY){
				FWDAnimation.killTweensOf(_s.buttonsHolder_do);
				if(animate){
					FWDAnimation.to(_s.buttonsHolder_do, .5, {y:_s.thmbsFinY, ease:Quart.easeOut});
				}else{
					_s.buttonsHolder_do.setY(_s.thmbsFinY);
				}
			}
			
			_s.lastThumbnailFinalY = _s.thmbsFinY;
		};
		
		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPComboBox.setPrototype =  function(){
		FWDUVPComboBox.prototype = new FWDUVPDisplayObject("div");
	};
	FWDUVPComboBox.OPEN = "open";
	FWDUVPComboBox.HIDE_COMPLETE = "infoWindowHideComplete";
	FWDUVPComboBox.BUTTON_PRESSED = "buttonPressed";
	FWDUVPComboBox.prototype = null;
	window.FWDUVPComboBox = FWDUVPComboBox;
	
}(window));