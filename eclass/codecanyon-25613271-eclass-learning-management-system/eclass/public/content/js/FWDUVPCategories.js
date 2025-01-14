/**
 * Ultimate Video Player PACKAGED v9.1
 * Categories window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function(){
var FWDUVPCategories = function(_d, prt){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPCategories.prototype;
		
		_s.image_img;
		_s.catThumbBk_img = _d.catThumbBk_img;
		_s.catNextN_img = _d.catNextN_img;
		_s.catPrevN_img = _d.catPrevN_img;
		_s.catCloseN_img = _d.catCloseN_img;
	
		_s.thumbs_ar = [];
		_s.categories_ar = _d.cats_ar;	
		_s.catBkPath_str = _d.catBkPath_str;
		
		_s.id = 0;
		_s.mouseX = 0;
		_s.mouseY = 0;
		_s.dif = 0;
		_s.tempId = _s.id;
		_s.sW = 0;
		_s.sH = 0;
		_s.thumbW = 0;
		_s.thumbH = 0;
		_s.buttonsMargins = _d.buttonsMargins;
		_s.thumbnailMaxWidth = _d.thumbnailMaxWidth;
		_s.thumbnailMaxHeight = _d.thumbnailMaxHeight;
		_s.spacerH = _d.horizontalSpaceBetweenThumbnails;
		_s.spacerV = _d.verticalSpaceBetweenThumbnails;
		_s.dl;
		_s.howManyThumbsToDisplayH = 0;
		_s.howManyThumbsToDisplayV = 0;
		if(_s.catNextN_img){
			_s.categoriesOffsetTotalWidth = _s.catNextN_img.width * 2 + 40 + _s.buttonsMargins * 2; 
			_s.categoriesOffsetTotalHeight = _s.catNextN_img.height + 40;
		}
		_s.totalThumbnails = _s.categories_ar.length;
		_s.delayRate = .06;
		_s.countLoadedThumbs = 0;
		
		_s.inputBackgroundColor_str = _d.searchInputBackgroundColor_str;
		_s.inputColor_str = _d.searchInputColor_str;
	
		_s.showSearchInpt = _d.showPlaylistsSearchInput_bl;
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.useVectorIcons_bl = _d.useVectorIcons_bl;


		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.screen.className = 'fwduvp fwduvp-categories';
			if(_d.sknPth.indexOf("hex_white") != -1){
				_s.sBC = "#FFFFFF";
			}else{
				_s.sBC = _d.sBC;
			}
			
			_s.getStyle().zIndex = 2147483647;
			_s.getStyle().msTouchAction = "none";
			_s.getStyle().webkitTapHighlightColor = "rgba(0, 0, 0, 0)";
			_s.getStyle().width = "100%";
			
			_s.mainHld = new FWDUVPDisplayObject("div");
			_s.mainHld.screen.className = 'fwduvp-categories-background';
			_s.mainHld.getStyle().background = "url('" + _s.catBkPath_str + "')";
			_s.mainHld.setY(- 3000);
			_s.addChild(_s.mainHld);
			_s.setupButtons();
			_s.setupDisable();
			if(_s.isMbl){
				_s.setupMobileMove();
			}
			
			if(!_s.isMbl || (_s.isMbl && _s.hasPointerEvent_bl)) _s.setSelectable(false);
			
			if(window.addEventListener){
				_s.screen.addEventListener ("mousewheel", _s.mouseWheelDumyHandler);
				_s.screen.addEventListener('DOMMouseScroll', _s.mouseWheelDumyHandler);
			}else if(document.attachEvent){
				_s.screen.attachEvent ("onmousewheel", _s.mouseWheelDumyHandler);
			}
			if(_s.showSearchInpt) _s.setupInput();

		};
		
		_s.mouseWheelDumyHandler = function(e){	
			var thumb;
			if(FWDAnimation.isTweening(_s.mainHld)){
				if(e.preventDefault){
					e.preventDefault();
				}
				return false;
			}
			
			for (var i = 0; i<_s.totalThumbnails; i++) {
				thumb = _s.thumbs_ar[i];
				if(FWDAnimation.isTweening(thumb)){
					if(e.preventDefault){
						e.preventDefault();
					}
					return false;
				}
			}
			
			var dir = e.detail || e.wheelDelta;	
			if(e.wheelDelta) dir *= -1;
			if(FWDUVPUtils.isOpera) dir *= -1;
			
			if(dir > 0){
				_s.nextButtonOnMouseUpHandler();
			}else if(dir < 0){
				if(_s.leftId <= 0) return;
				_s.prevButtonOnMouseUpHandler();
			}
		
		
			if(e.preventDefault){
				e.preventDefault();
			}else{
				return false;
			}
		};
		

		//###########################################//
		// Resize and position.
		//###########################################//
		_s.resizeAndPosition = function(overwrite){
			if(!_s.isShowed_bl && !overwrite) return;
			
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			var viewportSize = FWDUVPUtils.getViewportSize();
			
			_s.sW = viewportSize.w;
			_s.sH = viewportSize.h;
			
			FWDAnimation.killTweensOf(_s.mainHld);
			_s.mainHld.setX(0);
			_s.mainHld.setWidth(_s.sW);
			_s.mainHld.setHeight(_s.sH);
			
			_s.setX(scrollOffsets.x);
			_s.setY(scrollOffsets.y);
			
			_s.setHeight(_s.sH);
			if(_s.isMbl || prt.isEmbedded_bl) _s.setWidth(_s.sW);
			_s.positionButtons();
			_s.tempId = _s.id;
			_s.resizeAndPositionThumbnails();
			_s.disableEnableNextAndPrevButtons();
			
			if(_s.input_do){
				_s.input_do.setX(_s.sW - _s.input_do.getWidth() - _s.buttonsMargins);
				_s.input_do.setY(_s.sH - _s.input_do.getHeight() - _s.buttonsMargins);
				_s.inputArrow_do.setX(_s.input_do.x +  _s.input_do.getWidth() - 20);
				_s.inputArrow_do.setY(_s.input_do.y + _s.input_do.getHeight()/2 - _s.inputArrow_do.getHeight()/2 );
			}
		};

		
		//##########################################//
		/* resize and scroll handler */
		//##########################################//
		_s.onScrollHandler = function(){
			var scrollOffsets = FWDUVPUtils.getScrollOffsets();
			_s.setX(scrollOffsets.x);
			_s.setY(scrollOffsets.y);
		};
		

		//################################################//
		/* setup input */
		//################################################//
		_s.setupInput = function(){
			
			_s.input_do = new FWDUVPDisplayObject("input");
			_s.input_do.screen.className = 'fwduvp-search';
			_s.input_do.screen.maxLength = 20;
			_s.input_do.getStyle().textAlign = "left";
			_s.input_do.getStyle().outline = "none";
			_s.input_do.getStyle().boxShadow  = "none";
			_s.input_do.getStyle().fontFamily = "Arial";
			_s.input_do.getStyle().fontSize= "12px";
			_s.input_do.getStyle().padding = "14px 10px";
			_s.input_do.getStyle().boxSizing = 'border-box';
			_s.input_do.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.input_do.getStyle().color = _s.inputColor_str;
			_s.input_do.screen.value = "Search";
			_s.input_do.setHeight(20);
			_s.input_do.setX(18);
			
			_s.noSearchFound_do = new FWDUVPDisplayObject("div");
			_s.noSearchFound_do.screen.className = 'fwduvp-search-not-found';
			_s.noSearchFound_do.setX(0);
			_s.noSearchFound_do.getStyle().textAlign = "center";
			_s.noSearchFound_do.getStyle().width = "100%";
			_s.noSearchFound_do.getStyle().fontFamily = "Arial";
			_s.noSearchFound_do.getStyle().fontSize= "12px";
			_s.noSearchFound_do.getStyle().color = _s.inputColor_str;
			_s.noSearchFound_do.setInnerHTML("NOTHING FOUND!");
			_s.noSearchFound_do.setVisible(false);
			_s.addChild(_s.noSearchFound_do);
			
			var img = new Image();
			img.src = _d.inputArrowPath_str;
			
			_s.inputArrow_do = new FWDUVPDisplayObject("img"); 
			_s.inputArrow_do.setScreen(img);
			_s.inputArrow_do.setWidth(12);
			_s.inputArrow_do.setHeight(12);
			
			if(_s.hasPointerEvent_bl){
				_s.input_do.screen.addEventListener("pointerdown", _s.inputFocusInHandler);
			}else if(_s.input_do.screen.addEventListener){
				_s.input_do.screen.addEventListener("mousedown", _s.inputFocusInHandler);
				_s.input_do.screen.addEventListener("touchstart", _s.inputFocusInHandler);
			}
			
			_s.input_do.screen.addEventListener("keyup", _s.keyUpHandler);
			_s.mainHld.addChild(_s.input_do);
			_s.mainHld.addChild(_s.inputArrow_do);
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
			}, 50);
		};
		
		_s.inputFocusOutHandler = function(e){
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
				clearTimeout(_s.keyPressedId_to);
				_s.keyPressed_bl = true;
				clearTimeout(_s.rsId_to);
				_s.rsId_to = setTimeout(function(){
					_s.resizeAndPositionThumbnails(true);
					_s.disableEnableNextAndPrevButtons();
				}, 400);
			}
			_s.prevInputValue_str = _s.input_do.screen.value;
			_s.keyPressedId_to = setTimeout(function(){
				_s.keyPressed_bl = false;
			}, 450)
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
		

		//###############################//
		/* setup disable */
		//##############################//
		_s.setupDisable = function(){
			_s.disable_do = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.disable_do.setBkColor("#FFFFFF");
				_s.disable_do.setAlpha(0.01);
			}
			_s.addChild(_s.disable_do);
		};
		
		_s.showDisable = function(){
			if(_s.disable_do.w == _s.sW) return;
			_s.disable_do.setWidth(_s.sW);
			_s.disable_do.setHeight(_s.sH);
		};
		
		_s.hideDisable = function(){
			if(_s.disable_do.w == 0) return;
			_s.disable_do.setWidth(0);
			_s.disable_do.setHeight(0);
		};

		
		//############################################//
		/* setup buttons */
		//############################################//
		_s.setupButtons = function(){
			if(_s.clsBtn) return;

			//setup close button
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.clsBtn = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-close'></span></div>",
						undefined,
						"UVPCategoriesNextAndPrevNormalState",
						"UVPCategoriesNextAndPrevSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.clsBtn = new FWDUVPSimpleButton(_s.catCloseN_img, _d.catCloseSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						_s.sBC,
						false, false, false, false, true);

			}
			_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.nextButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-FF-right'></span></div>",
						undefined,
						"UVPCategoriesNextAndPrevNormalState",
						"UVPCategoriesNextAndPrevSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.nextButton_do = new FWDUVPSimpleButton(_s.catNextN_img, _d.catNextSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						_s.sBC,
						false, false, false, false, true);
			}
			_s.nextButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.nextButtonOnMouseUpHandler);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.prevButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-FF-left'></span></div>",
						undefined,
						"UVPCategoriesNextAndPrevNormalState",
						"UVPCategoriesNextAndPrevSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.prevButton_do = new FWDUVPSimpleButton(_s.catPrevN_img, _d.catPrevSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						_s.sBC,
						false, false, false, false, true);
			}
			_s.prevButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.prevButtonOnMouseUpHandler);
		};
		
		_s.closeButtonOnMouseUpHandler = function(){
			 _s.hide();
		};
		
		_s.nextButtonOnMouseUpHandler = function(){
			var availableThumbsPerSection = (_s.howManyThumbsToDisplayH * _s.howManyThumbsToDisplayV);
			_s.tempId += availableThumbsPerSection;
			if(_s.tempId > _s.totalThumbnails - 1) _s.tempId = _s.totalThumbnails - 1;
			var curSet = Math.floor(_s.tempId / availableThumbsPerSection);
			_s.tempId = curSet * availableThumbsPerSection;
			_s.resizeAndPositionThumbnails(true, "next");
			_s.disableEnableNextAndPrevButtons(false, true);
		};
		
		_s.prevButtonOnMouseUpHandler = function(){
			var availableThumbsPerSection = (_s.howManyThumbsToDisplayH * _s.howManyThumbsToDisplayV);
			_s.tempId -= availableThumbsPerSection;
			if(_s.tempId < 0) _s.tempId = 0;
			var curSet = Math.floor(_s.tempId / availableThumbsPerSection);
			_s.tempId = curSet * availableThumbsPerSection;
			_s.resizeAndPositionThumbnails(true, "prev");
			_s.disableEnableNextAndPrevButtons(true, false);
		};
		
		_s.positionButtons = function(){
			_s.clsBtn.setX(_s.sW - _s.clsBtn.w - _s.buttonsMargins);
			_s.clsBtn.setY(_s.buttonsMargins);
			_s.nextButton_do.setX(_s.sW - _s.nextButton_do.w - _s.buttonsMargins);
			_s.nextButton_do.setY(parseInt((_s.sH - _s.nextButton_do.h)/2));
			_s.prevButton_do.setX(_s.buttonsMargins);
			_s.prevButton_do.setY(parseInt((_s.sH - _s.prevButton_do.h)/2));
		};
		
		_s.disableEnableNextAndPrevButtons = function(hitTestLeft, hitTestRight){
			var availableThumbsPerSection = (_s.howManyThumbsToDisplayH * _s.howManyThumbsToDisplayV);
			var curSet = Math.floor(_s.tempId / availableThumbsPerSection);
			var totalSets = Math.ceil(_s.totalThumbnails / availableThumbsPerSection) - 1;
			var currentLeftColId = _s.howManyThumbsToDisplayH * curSet;
			var maxId = totalSets * _s.howManyThumbsToDisplayH;
		
			if(availableThumbsPerSection >= _s.totalThumbnails){
				_s.nextButton_do.disable();
				_s.prevButton_do.disable();
				_s.nextButton_do.setDisabledState();
				_s.prevButton_do.setDisabledState();
			}else if(curSet == 0){
				_s.nextButton_do.enable();
				_s.prevButton_do.disable();
				_s.nextButton_do.setEnabledState();
				_s.prevButton_do.setDisabledState();
			}else if(curSet == totalSets){
				_s.nextButton_do.disable();
				_s.prevButton_do.enable();
				_s.nextButton_do.setDisabledState();
				_s.prevButton_do.setEnabledState();
			}else{
				_s.nextButton_do.enable();
				_s.prevButton_do.enable();
				_s.nextButton_do.setEnabledState();
				_s.prevButton_do.setEnabledState();
			}
			
			if(!hitTestLeft){
				_s.prevButton_do.setNormalState();
			}
			
			if(!hitTestRight){
				_s.nextButton_do.setNormalState();
			}
		};
		
		//##########################################//
		/* setup mobile scrollbar */
		//##########################################//
		_s.setupMobileMove = function(){	
			if(_s.hasPointerEvent_bl){
				_s.screen.addEventListener("pointerdown", _s.mobileDownHandler);
			}else{
				_s.screen.addEventListener("touchstart", _s.mobileDownHandler);
			}
		};
		
		_s.mobileDownHandler = function(e){
			if (e.touches) if(e.touches.length != 1) return;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			_s.mouseX = vc.screenX;;
			_s.mouseY = vc.screenY;
			if(_s.hasPointerEvent_bl){
				window.addEventListener("pointerup", _s.mobileUpHandler);
				window.addEventListener("pointermove", _s.mobileMoveHandler);
			}else{
				window.addEventListener("touchend", _s.mobileUpHandler);
				window.addEventListener("touchmove", _s.mobileMoveHandler, {passive:false});
			}
		};
		
		_s.mobileMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			if (e.touches) if(e.touches.length != 1) return;
			_s.showDisable();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			_s.dif = _s.mouseX - vc.screenX;
			_s.mouseX = vc.screenX;
			_s.mouseY = vc.screenY;
		};
		
		_s.mobileUpHandler = function(e){
			_s.hideDisable();
			if(_s.dif > 10){
				_s.nextButtonOnMouseUpHandler();
			}else if(_s.dif < -10){
				_s.prevButtonOnMouseUpHandler();
			}
			_s.dif = 0;
			
			if(_s.hasPointerEvent_bl){
				window.removeEventListener("pointerup", _s.mobileUpHandler);
				window.removeEventListener("pointermove", _s.mobileMoveHandler);
			}else{
				window.removeEventListener("touchend", _s.mobileUpHandler);
				window.removeEventListener("touchmove", _s.mobileMoveHandler);
			}
		};
		

		//######################################//
		/* setup thumbnails */
		//######################################//
		_s.setupThumbnails = function(){
			if(_s.areThumbnailsCreated_bl) return;

			_s.areThumbnailsCreated_bl = true;
			var thumb;
			for(var i=0; i<_s.totalThumbnails; i++){
				FWDUVPCategoriesThumb.setPrototype();
				thumb = new FWDUVPCategoriesThumb(_s,
						i,
						_d.catThumbBkPath_str,
						_d.catThumbBkTextPath_str,
						_d.thumbnailSelectedType_str, 
						_s.categories_ar[i].htmlContent,
						_s.categories_ar[i].htmlText_str);
				thumb.addListener(FWDUVPCategoriesThumb.MOUSE_UP, _s.thumbnailOnMouseUpHandler);
				_s.thumbs_ar[i] = thumb;
				_s.mainHld.addChild(thumb);
			}
			_s.mainHld.addChild(_s.clsBtn); 
			_s.mainHld.addChild(_s.nextButton_do); 
			_s.mainHld.addChild(_s.prevButton_do);
		};
		
		_s.thumbnailOnMouseUpHandler = function(e){
			_s.id = e.id;
			_s.disableOrEnableThumbnails();
			_s.hide();
		};
		

		//#############################################//
		/* set _d for resize */
		//#############################################//
		_s.resizeAndPositionThumbnails = function(animate, direction){
			if(!_s.areThumbnailsCreated_bl) return;
			var thumb;
			var totalWidth;
			var curSet;
			var tempSet;
			var newX;
			var newY;
			var totalWidth;
			var totalHeight;
			var remainWidthSpace;
			var firsId;
			var lastId;
			var addToX;
			var currentLeftColId;
			var availableThumbsPerSection;
			
			var copy_ar = [].concat(_s.thumbs_ar);
			_s.isSearched_bl = false;
		
			if(_s.input_do){
				var inputValue = _s.input_do.screen.value.toLowerCase();
				if(inputValue != "Search".toLowerCase()){
					for(var i=0; i<copy_ar.length; i++){
						thumb = copy_ar[i];
						if(thumb.htmlText_str.toLowerCase().indexOf(inputValue.toLowerCase()) == -1){
							FWDAnimation.killTweensOf(thumb);
							thumb.hide();
							copy_ar.splice(i, 1);
							i--;
						}
					}
				}
			}
		
			_s.totalThumbnails = copy_ar.length;
			if(_s.totalThumbnails != _s.thumbs_ar.length) _s.isSearched_bl = true;
			
			if(_s.totalThumbnails == 0){
				_s.showNothingFound();
			}else{
				_s.hideNothingFound();
			}
			
			_s.remainWidthSpace = (_s.sW - totalWidth);
			
			var widthToResize = _s.sW - _s.categoriesOffsetTotalWidth;
			var heightToResize = _s.sH - _s.categoriesOffsetTotalHeight;
			
			_s.howManyThumbsToDisplayH = Math.ceil((widthToResize - _s.spacerH)/(_s.thumbnailMaxWidth + _s.spacerH));
			_s.thumbW = Math.floor(((widthToResize - _s.spacerH * (_s.howManyThumbsToDisplayH - 1)))/_s.howManyThumbsToDisplayH);
			if(_s.thumbW > _s.thumbnailMaxWidth){
				_s.howManyThumbsToDisplayH += 1;
				_s.thumbW = Math.floor(((widthToResize - _s.spacerH * (_s.howManyThumbsToDisplayH - 1)))/_s.howManyThumbsToDisplayH);
			}
			
			_s.thumbH = Math.floor((_s.thumbW/_s.thumbnailMaxWidth) * _s.thumbnailMaxHeight);
			
			_s.howManyThumbsToDisplayV = Math.floor(heightToResize/(_s.thumbH + _s.spacerV));
			if(_s.howManyThumbsToDisplayV < 1) _s.howManyThumbsToDisplayV = 1;
			
			totalWidth = (Math.min(_s.howManyThumbsToDisplayH, _s.totalThumbnails) * (_s.thumbW + _s.spacerH)) - _s.spacerH;
			totalHeight = Math.min(Math.ceil(_s.totalThumbnails/_s.howManyThumbsToDisplayH), _s.howManyThumbsToDisplayV) * (_s.thumbH + _s.spacerV) - _s.spacerV;
			
			if(_s.howManyThumbsToDisplayH > _s.totalThumbnails){
				remainWidthSpace = 0;
			}else{
				remainWidthSpace = (widthToResize - totalWidth);
			}
			
			if(_s.howManyThumbsToDisplayH > _s.totalThumbnails) _s.howManyThumbsToDisplayH = _s.totalThumbnails;
			availableThumbsPerSection = (_s.howManyThumbsToDisplayH * _s.howManyThumbsToDisplayV);
	
			curSet = Math.floor(_s.tempId / availableThumbsPerSection);
			if(_s.isSearched_bl) curSet = 0;
			currentLeftColId = _s.howManyThumbsToDisplayH * curSet;
			
			var firstId = curSet * availableThumbsPerSection;
			
			var lastId = firstId + availableThumbsPerSection;
			if(lastId > _s.totalThumbnails)  lastId = _s.totalThumbnails;
			
			for (var i = 0; i<_s.totalThumbnails; i++) {
				
				thumb = copy_ar[i];
				
				thumb.finalW = _s.thumbW;
				if(i % _s.howManyThumbsToDisplayH == _s.howManyThumbsToDisplayH - 1) thumb.finalW += remainWidthSpace;
				thumb.finalH = _s.thumbH;
				
				thumb.finalX = (i % _s.howManyThumbsToDisplayH) * (_s.thumbW + _s.spacerH);
				thumb.finalX += Math.floor((i / availableThumbsPerSection)) * _s.howManyThumbsToDisplayH * (_s.thumbW + _s.spacerH);
				thumb.finalX += (_s.sW - totalWidth)/2;
				thumb.finalX = Math.floor(thumb.finalX - currentLeftColId * (_s.thumbW + _s.spacerH));
				
				thumb.finalY = i % availableThumbsPerSection;
				thumb.finalY = Math.floor((thumb.finalY / _s.howManyThumbsToDisplayH)) * (_s.thumbH + _s.spacerV);
				thumb.finalY += (heightToResize - totalHeight)/2;
				thumb.finalY += _s.categoriesOffsetTotalHeight/2;
				thumb.finalY = Math.floor(thumb.finalY);
				
				tempSet = Math.floor((i / availableThumbsPerSection));
			
				if(tempSet > curSet){
					thumb.finalX += 150;
				}else if(tempSet < curSet){
					thumb.finalX -= 150;
				}
				
				if(animate){
					if ((i >= firstId) && (i < lastId)){
						if(direction == "next"){
							var dl = (i % availableThumbsPerSection) * _s.delayRate + .1;
						}else{
							var dl = (availableThumbsPerSection -  (i % availableThumbsPerSection)) * _s.delayRate + .1;
						}
						if(_s.keyPressed_bl) dl = 0;
						thumb.resizeAndPosition(true, dl);
					}else{
						thumb.resizeAndPosition(true, 0);
					}
					
				}else{
					thumb.resizeAndPosition();
				}	
				thumb.show();
			}
			if((_s.howManyThumbsToDisplayH * _s.howManyThumbsToDisplayV) >= _s.totalThumbnails){
				_s.nextButton_do.setVisible(false);
				_s.prevButton_do.setVisible(false);
				
			}else{
				_s.nextButton_do.setVisible(true);
				_s.prevButton_do.setVisible(true);
				
			}
		};
		

		//#############################################//
		/* load images */
		//#############################################//
		_s.loadImages = function(){

			if(_s.countLoadedThumbs > _s.totalThumbnails-1) return;
			
			if(_s.image_img){
				_s.image_img.onload = null;
				_s.image_img.onerror = null;
			}
			
			_s.image_img = new Image();
			_s.image_img.onerror = _s.onImageLoadError;
			_s.image_img.onload = _s.onImageLoadComplete;
			_s.image_img.src = _s.categories_ar[_s.countLoadedThumbs].thumbnailPath;
		};
		
		_s.onImageLoadError = function(e){};
		
		_s.onImageLoadComplete = function(e){
			var thumb = _s.thumbs_ar[_s.countLoadedThumbs];
			thumb.setImage(_s.image_img);
			_s.countLoadedThumbs++;
			_s.loadWithDelayId_to = setTimeout(_s.loadImages, 40);	
		};

		
		//###########################################//
		/* disable / enable thumbnails */
		//###########################################//
		_s.disableOrEnableThumbnails = function(){
			var thumb;
			for(var i = 0; i<_s.totalThumbnails; i++) {
				thumb = _s.thumbs_ar[i];	
				if(i == _s.id){
					thumb.disable();
				}else{
					thumb.enable();
				}
			}
		};
		

		//###########################################//
		/* show / hide */
		//###########################################//
		_s.show = function(id){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;
			_s.isOnDOM_bl = true;
			_s.id = id;
			
			if(prt.isFullScreen_bl){
				prt.main_do.addChild(_s);
			}else{
				document.documentElement.appendChild(_s.screen);
			}	
					
			if(window.addEventListener){
				window.addEventListener("scroll", _s.onScrollHandler);
			}else if(window.attachEvent){
				window.attachEvent("onscroll", _s.onScrollHandler);
			}
				
			_s.setupThumbnails();	
			
			if(_s.useVectorIcons_bl){
			
				_s.clsBtn.setFinalSize(true);
				_s.nextButton_do.setFinalSize(true);
				_s.prevButton_do.setFinalSize(true);

				_s.checkButtonsId_to = setInterval(function(){
					if(_s.clsBtn.w != 0){
						_s.categoriesOffsetTotalWidth = _s.clsBtn.w * 2 + 40 + _s.buttonsMargins * 2;
						_s.categoriesOffsetTotalHeight = _s.clsBtn.h;
						_s.resizeAndPosition(true);
						_s.showDisable();
						_s.disableOrEnableThumbnails();
						clearTimeout(_s.hideCompleteId_to);
						clearTimeout(_s.showCompleteId_to);
						_s.mainHld.setY(- _s.sH);
						
						if(_s.isMbl){
							_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 1200);
							FWDAnimation.to(_s.mainHld, .8, {y:0, delay:.4, ease:Expo.easeInOut});
						}else{
							_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 800);
							FWDAnimation.to(_s.mainHld, .8, {y:0, ease:Expo.easeInOut});
						}
					
						clearInterval(_s.checkButtonsId_to);
					}
				
				}, 50);
			}else{
				_s.resizeAndPosition(true);
				_s.showDisable();
				_s.disableOrEnableThumbnails();
				clearTimeout(_s.hideCompleteId_to);
				clearTimeout(_s.showCompleteId_to);
				_s.mainHld.setY(- _s.sH);
				
				if(_s.isMbl){
					_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 1200);
					FWDAnimation.to(_s.mainHld, .8, {y:0, delay:.4, ease:Expo.easeInOut});
				}else{
					_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 800);
					FWDAnimation.to(_s.mainHld, .8, {y:0, ease:Expo.easeInOut});
				}
				
			}
		};
		
		_s.showCompleteHandler = function(){
			_s.mainHld.setY(0);
			_s.hideDisable();
			if(FWDUVPUtils.isIphone){
				if(prt.videoScreen_do) prt.videoScreen_do.setY(-5000);
				if(prt.ytb_do) prt.ytb_do.setY(-5000);
			}
			_s.resizeAndPosition(true);
			if(!_s.areThumbnailsLoaded_bl){
				_s.loadImages();
				_s.areThumbnailsLoaded_bl = true;
			}
		};
		
		_s.hide = function(){
			if(!_s.isShowed_bl) return;
			_s.isShowed_bl = false;
			
			if(FWDUVPUtils.isIphone){
				if(prt.videoScreen_do) prt.videoScreen_do.setY(0);
				if(prt.ytb_do) prt.ytb_do.setY(0);
			}
			
			clearTimeout(_s.hideCompleteId_to);
			clearTimeout(_s.showCompleteId_to);
			_s.showDisable();
			_s.hideCompleteId_to = setTimeout(_s.hideCompleteHandler, 800);
			FWDAnimation.killTweensOf(_s.mainHld);
			FWDAnimation.to(_s.mainHld, .8, {y:-_s.sH, ease:Expo.easeInOut});
			
			if(window.addEventListener){
				window.removeEventListener("scroll", _s.onScrollHandler);
			}else if(window.detachEvent){
				window.detachEvent("onscroll", _s.onScrollHandler);
			}
			_s.resizeAndPosition();
		};
		
		_s.hideCompleteHandler = function(){
			
			if(prt.main_do.contains(_s)){
				prt.main_do.removeChild(_s);
			}else{
				document.documentElement.removeChild(_s.screen);
			}	
			
			_s.isOnDOM_bl = false;
			_s.dispatchEvent(FWDUVPCategories.HIDE_COMPLETE);
		};
		
		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPCategories.setPrototype = function(){
		FWDUVPCategories.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPCategories.HIDE_COMPLETE = "hideComplete";

	FWDUVPCategories.prototype = null;
	window.FWDUVPCategories = FWDUVPCategories;
	
}());