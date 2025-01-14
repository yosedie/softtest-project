/**
 * Ultimate Video Player PACKAGED v9.1
 * Categories thumbnail.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	var FWDUVPCategoriesThumb = function(
			prt,
			pId, 
			catThumbBkTextPath_str,
			catThumbTextBkPath_str,
			thumbnailSelectedType_str,
			htmlContent,
			htmlText
		){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPCategoriesThumb.prototype;
	
		_s.backgroundImagePath_str = catThumbBkTextPath_str;
		_s.catThumbTextBkPath_str = catThumbTextBkPath_str;
		_s.canvas_el = null;
		_s.htmlContent = htmlContent;
		_s.htmlText_str = htmlText;
		_s.thumbnailSelectedType_str = thumbnailSelectedType_str;
		
		_s.id = pId;
		
		_s.isDark = true;
		if(catThumbBkTextPath_str.indexOf('dark') == -1){
			_s.isDark = false;
		}
		
		_s.dispatchShowWithDelayId_to;
		_s.hasCanvas_bl = FWDUVPlayer.hasCanvas;
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;

		_s.init = function(){
			_s.getStyle().background = "url('" + _s.backgroundImagePath_str + "')";
			_s.screen.className = 'fwduvp-categories-thumbnail-background';
			_s.setupMainContainers();
			_s.setupDescription();
			_s.setupDumy();
		};

		
		//#################################//
		/* set image */
		//#################################//
		_s.setupMainContainers = function(){
			_s.imageHolder_do = new FWDUVPDisplayObject("div");
			_s.addChild(_s.imageHolder_do);
		};
		

		//#################################//
		/* setup dumy */
		//#################################//
		_s.setupDumy = function(){
			_s.dumy_do = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.dumy_do.setBkColor("#FFFFFF");
				_s.dumy_do.setAlpha(0);
			}
			_s.addChild(_s.dumy_do);
		};
		

		//################################################//
		/* Setup title bar */
		//###############################################//
		_s.setupDescription = function(){
			_s.simpleText_do = new FWDUVPDisplayObject("div");
			_s.simpleText_do.getStyle().background = "url('" + _s.catThumbTextBkPath_str + "')";
			var cls = 'fwduvp-categories-white-text';
			if(_s.isDark){
				cls = 'fwduvp-categories-dark-text';
			}
			_s.simpleText_do.screen.className = cls;
			_s.slTitle = _s.simpleText_do.screen.className;

			if(FWDUVPUtils.isFirefox){
				_s.simpleText_do.hasTransform3d_bl = false;
				_s.simpleText_do.hasTransform2d_bl = false;
			}
			_s.simpleText_do.setBackfaceVisibility();
			_s.simpleText_do.getStyle().width = "100%";
			_s.simpleText_do.getStyle().fontFamily = "Arial";
			_s.simpleText_do.getStyle().fontSize= "12px";
			_s.simpleText_do.getStyle().textAlign = "left";
			_s.simpleText_do.getStyle().color = "#FFFFFF";	
			_s.simpleText_do.setInnerHTML(_s.htmlContent);
			_s.addChild(_s.simpleText_do);
		};
		
		_s.positionDescription = function(){
			_s.simpleText_do.setY(parseInt(_s.finalH - _s.simpleText_do.getHeight()));
		};

		
		//#################################//
		/* setup black an white image */
		//#################################//
		_s.setupBlackAndWhiteImage = function(image){
			if(!_s.hasCanvas_bl || _s.thumbnailSelectedType_str == "opacity") return;
			var canvas = document.createElement("canvas");

			var ctx = canvas.getContext("2d");
			
			canvas.width = _s.imageOriginalW;
			canvas.height = _s.imageOriginalH; 
			ctx.drawImage(image, 0, 0); 
			
			var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
			
			var d = imgPixels._d;
			
			if(_s.thumbnailSelectedType_str == "threshold"){
				//treshhold
				for (var i=0; i<d.length; i+=4) {
				    var r = d[i];
				    var g = d[i+1];
				    var b = d[i+2];
				    var v = (0.2126*r + 0.7152*g + 0.0722*b >= 150) ? 255 : 0;
				    d[i] = d[i+1] = d[i+2] = v;
				}
			}else if(_s.thumbnailSelectedType_str == "blackAndWhite"){
				//grayscale
				for (var i=0; i<d.length; i+=4) {
					var r = d[i];
				    var g = d[i+1];
				    var b = d[i+2];
				    // CIE luminance for the RGB
				    // The human eye is bad at seeing red and blue, so we de-emphasize them.
				    var v = 0.2126*r + 0.7152*g + 0.0722*b;
				    d[i] = d[i+1] = d[i+2] = v;
				}
			}
		
			ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
			
			_s.effectImage_do = new FWDUVPDisplayObject("canvas");
			_s.effectImage_do.screen = canvas;
			_s.effectImage_do.setAlpha(.9);
			
			_s.effectImage_do.setMainProperties();
		};

	
		//#################################//
		/* set image */
		//#################################//
		_s.setImage = function(image){
			_s.normalImage_do = new FWDUVPDisplayObject("img");
			_s.normalImage_do.setScreen(image);
			
			_s.imageOriginalW = _s.normalImage_do.w;
			_s.imageOriginalH = _s.normalImage_do.h;
			
			_s.setButtonMode(true);
			_s.setupBlackAndWhiteImage(image);
			
			_s.resizeImage();
			
			_s.imageHolder_do.setX(parseInt(_s.finalW/2));
			_s.imageHolder_do.setY(parseInt(_s.finalH/2));
			_s.imageHolder_do.setWidth(0);
			_s.imageHolder_do.setHeight(0);
			
			_s.normalImage_do.setX(- parseInt(_s.normalImage_do.w/2));
			_s.normalImage_do.setY(- parseInt(_s.normalImage_do.h/2));
			_s.normalImage_do.setAlpha(0);
			
			if(_s.effectImage_do){
				_s.effectImage_do.setX(- parseInt(_s.normalImage_do.w/2));
				_s.effectImage_do.setY(- parseInt(_s.normalImage_do.h/2));
				_s.effectImage_do.setAlpha(0.01);
			}
			
			FWDAnimation.to(_s.imageHolder_do, .8, {
				x:0, 
				y:0,
				w:_s.finalW,
				h:_s.finalH, 
				ease:Expo.easeInOut});
			
			FWDAnimation.to(_s.normalImage_do, .8, {
				alpha:1,
				x:_s.imageFinalX, 
				y:_s.imageFinalY, 
				ease:Expo.easeInOut});
			
			if(_s.effectImage_do){
				FWDAnimation.to(_s.effectImage_do, .8, {
					x:_s.imageFinalX, 
					y:_s.imageFinalY, 
					ease:Expo.easeInOut});
			}
			
			if(_s.hasPointerEvent_bl){
				_s.screen.addEventListener("pointerup", _s.onMouseUp);
				_s.screen.addEventListener("pointerover", _s.onMouseOver);
				_s.screen.addEventListener("pointerout", _s.onMouseOut);
			}else if(_s.screen.addEventListener){	
				if(!_s.isMbl){
					_s.screen.addEventListener("mouseover", _s.onMouseOver);
					_s.screen.addEventListener("mouseout", _s.onMouseOut);
					_s.screen.addEventListener("mouseup", _s.onMouseUp);
				}
				_s.screen.addEventListener("touchend", _s.onMouseUp);
			}
		
			_s.imageHolder_do.addChild(_s.normalImage_do);
			if(_s.effectImage_do) _s.imageHolder_do.addChild(_s.effectImage_do);
			
			_s.hasImage_bl = true;
			
			if(_s.id == prt.id){
				_s.disable();
			}
			
		};
		
		_s.onMouseOver = function(e, animate){
			if(_s.isDisabled_bl) return;
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				_s.setSelectedState(true);
			}
		};
			
		_s.onMouseOut = function(e){
			if(_s.isDisabled_bl) return;
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				_s.setNormalState(true);
			}
		};
		
		_s.onMouseUp = function(e){
			if(_s.isDisabled_bl || e.button == 2) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPCategoriesThumb.MOUSE_UP, {id:_s.id});
		};

	
		//#################################//
		/* resize thumbnail*/
		//#################################//
		_s.resizeAndPosition = function(animate, dl){
			
			FWDAnimation.killTweensOf(_s);
			FWDAnimation.killTweensOf(_s.imageHolder_do);
			
			if(animate){
				FWDAnimation.to(_s, .8, {
					x:_s.finalX, 
					y:_s.finalY,
					delay:dl,
					ease:Expo.easeInOut});
			}else{
				_s.setX(_s.finalX);
				_s.setY(_s.finalY);
			}
			
			_s.setWidth(_s.finalW);
			_s.setHeight(_s.finalH);
			_s.imageHolder_do.setX(0);
			_s.imageHolder_do.setY(0);
			_s.imageHolder_do.setWidth(_s.finalW);
			_s.imageHolder_do.setHeight(_s.finalH);
			
			_s.dumy_do.setWidth(_s.finalW);
			_s.dumy_do.setHeight(_s.finalH);
			
			_s.resizeImage();
			_s.positionDescription();
		};
	

		//#################################//
		/* resize image*/
		//#################################//
		_s.resizeImage = function(animate){
			
			if(!_s.normalImage_do) return;
			FWDAnimation.killTweensOf(_s.normalImage_do);
			var scX = _s.finalW/_s.imageOriginalW;
			var scY = _s.finalH/_s.imageOriginalH;
			var ttsc;
			
			if(scX >= scY){
				ttsc = scX;
			}else{
				ttsc = scY;
			}
			
			_s.imageFinalW = Math.ceil(ttsc * _s.imageOriginalW);
			_s.imageFinalH = Math.ceil(ttsc * _s.imageOriginalH);
			_s.imageFinalX = Math.round((_s.finalW - _s.imageFinalW)/2);
			_s.imageFinalY = Math.round((_s.finalH - _s.imageFinalH)/2);
			
			if(_s.effectImage_do){
				FWDAnimation.killTweensOf(_s.effectImage_do);
				_s.effectImage_do.setX(_s.imageFinalX);
				_s.effectImage_do.setY(_s.imageFinalY);
				_s.effectImage_do.setWidth(_s.imageFinalW);
				_s.effectImage_do.setHeight(_s.imageFinalH);
				if(_s.isDisabled_bl) _s.setSelectedState(false, true);
			}
			
			_s.normalImage_do.setX(_s.imageFinalX);
			_s.normalImage_do.setY(_s.imageFinalY);
			_s.normalImage_do.setWidth(_s.imageFinalW + 1);
			_s.normalImage_do.setHeight(_s.imageFinalH);
			
			if(_s.isDisabled_bl){
				_s.normalImage_do.setAlpha(.3);
			}else{
				_s.normalImage_do.setAlpha(1);
			}
		};
		

		//##############################//
		/* set normal/selected state*/
		//##############################//
		_s.setNormalState = function(animate){
			if(!_s.isSelected_bl) return;
			_s.isSelected_bl = false;
			if(_s.slTitle){
				_s.simpleText_do.screen.className = _s.slTitle;
			}

			if(_s.thumbnailSelectedType_str == "threshold" || _s.thumbnailSelectedType_str == "blackAndWhite"){
				if(animate){
					FWDAnimation.to(_s.effectImage_do, 1, {alpha:.01, ease:Quart.easeOut});
				}else{
					_s.effectImage_do.setAlpha(.01);
				}
			}else if(_s.thumbnailSelectedType_str == "opacity"){
				if(animate){
					FWDAnimation.to(_s.normalImage_do, 1, {alpha:1, ease:Quart.easeOut});
				}else{
					_s.normalImage_do.setAlpha(1);
				}
			}
		};
		
		_s.setSelectedState = function(animate, overwrite){
			if(_s.isSelected_bl && !overwrite) return;
			_s.isSelected_bl = true;
			_s.setTitleSelectedClass();
			if(_s.thumbnailSelectedType_str == "threshold" || _s.thumbnailSelectedType_str == "blackAndWhite"){
				if(animate){
					FWDAnimation.to(_s.effectImage_do, 1, {alpha:1, ease:Expo.easeOut});
				}else{
					_s.effectImage_do.setAlpha(1);
				}
			}else if(_s.thumbnailSelectedType_str == "opacity"){
				if(animate){
					FWDAnimation.to(_s.normalImage_do, 1, {alpha:.3, ease:Expo.easeOut});
				}else{
					_s.normalImage_do.setAlpha(.3);
				}
			}
		};
		

		//###############################//
		/* Hide / show */
		//###############################//
		_s.show = function(){
			FWDAnimation.to(_s, .8, {scale:1, ease:Expo.easeInOut});
		}
		
		_s.hide = function(){
			FWDAnimation.to(_s, .8, {scale:0, ease:Expo.easeInOut});
		}
		

		//###############################//
		/* enable / disable */
		//##############################//
		_s.enable = function(){
			if(!_s.hasImage_bl) return;
			_s.isDisabled_bl = false;
			_s.setButtonMode(true);
			_s.setNormalState(true);
		};
		
		_s.disable = function(){
			if(!_s.hasImage_bl) return;
			_s.isDisabled_bl = true;
			_s.setButtonMode(false);
			_s.setSelectedState(true);
			_s.setTitleSelectedClass();
		};

		_s.setTitleSelectedClass = function(){
			if(_s.slTitle){
				_s.simpleText_do.screen.className = _s.slTitle  + ' active';
			}
		}
	
		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPCategoriesThumb.setPrototype = function(){
		FWDUVPCategoriesThumb.prototype = new FWDUVPTransformDisplayObject("div");
	};
	
	
	FWDUVPCategoriesThumb.MOUSE_UP = "onMouseUp";
	
	FWDUVPCategoriesThumb.prototype = null;
	window.FWDUVPCategoriesThumb = FWDUVPCategoriesThumb;
}(window));