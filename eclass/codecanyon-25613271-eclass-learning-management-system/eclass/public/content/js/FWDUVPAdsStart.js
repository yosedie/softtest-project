/**
 * Ultimate Video Player PACKAGED v9.1
 * Advertisement info window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
var FWDUVPAdsStart = function(
			position_str,
			borderColorN_str,
			borderColorS_str,
			adsBackgroundPath_str,
			timeColor_str
		){
		
		'use strict';

		var _s = this;
		var prototype = FWDUVPAdsStart.prototype;
		
		_s.borderNColor_str = borderColorN_str;
		_s.borderSColor_str = borderColorS_str;
		_s.adsBackgroundPath_str = adsBackgroundPath_str;
		_s.position_str = position_str;
		_s.timeColor_str = timeColor_str;
		
		_s.totalWidth = 215;
		_s.totalHeight = 64;
		_s.fontSize = 12;

		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		
	
		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setOverflow("visible");
			_s.setupMainContainers();
			_s.hide(false, true);
		};
		

		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.setupMainContainers = function(){
			
			_s.main_do = new FWDUVPDisplayObject("div");
			_s.main_do.hasTransform3d_bl = false;
			_s.main_do.hasTransform2d_bl = false;
			_s.main_do.setBackfaceVisibility();
			
			_s.bk_do = new FWDUVPDisplayObject("div");
			_s.bk_do.getStyle().background = "url('" + _s.adsBackgroundPath_str + "')";
			
			_s.text_do = new FWDUVPDisplayObject("div");
			_s.text_do.screen.className = 'UVP-skip-in';
			_s.text_do.hasTransform3d_bl = false;
			_s.text_do.hasTransform2d_bl = false;
			_s.text_do.setBackfaceVisibility();
			_s.text_do.getStyle().fontFamily = "Arial";
			_s.text_do.getStyle().fontSize= "12px";
			_s.text_do.getStyle().lineHeight = "18px";
			_s.text_do.getStyle().textAlign = "center";
			_s.text_do.getStyle().color = _s.timeColor_str;
			_s.text_do.getStyle().fontSmoothing = "antialiased";
			_s.text_do.getStyle().webkitFontSmoothing = "antialiased";
			_s.text_do.getStyle().textRendering = "optimizeLegibility";
			_s.text_do.setInnerHTML("...");
			
			_s.thumbHolder_do = new FWDUVPDisplayObject("div");
			_s.thumbHolder_do.setWidth(_s.totalHeight - 8);
			_s.thumbHolder_do.setHeight(_s.totalHeight - 8);
			_s.thumbHolder_do.setX(_s.totalWidth - _s.thumbHolder_do.w - 4);
			_s.thumbHolder_do.setY(4);
			
			_s.border_do = new FWDUVPDisplayObject("div");
			_s.border_do.getStyle().border = "1px solid " + _s.borderNColor_str + "";
		
			_s.main_do.setWidth(_s.totalWidth);
			_s.main_do.setHeight(_s.totalHeight);
			_s.bk_do.setWidth(_s.totalWidth);
			_s.bk_do.setHeight(_s.totalHeight);
			if(_s.position_str == "left"){
				_s.border_do.setX(-1);
				_s.border_do.setWidth(_s.totalWidth - 1);
				_s.border_do.setHeight(_s.totalHeight -2);
			}else{
				_s.border_do.setWidth(_s.totalWidth);
				_s.border_do.setHeight(_s.totalHeight -2);
			}
			_s.setWidth(_s.totalWidth);
			_s.setHeight(_s.totalHeight);
		
			_s.main_do.addChild(_s.bk_do);
			_s.main_do.addChild(_s.text_do);
			_s.main_do.addChild(_s.thumbHolder_do);
			_s.main_do.addChild(_s.border_do);
			
			_s.addChild(_s.main_do);
		};

		
		//#####################################//
		/* load thumbnail */
		//#####################################//
		_s.loadThumbnail = function(path){
			_s.hasThumbanil_bl = true;
			
			if(_s.smallImage_img){
				_s.smallImage_img.removeAttribute("width");
				_s.smallImage_img.removeAttribute("height");
				_s.smallImage_img.onload = null;
				_s.smallImage_img.src = "";
				try{
					if(!FWDUVPUtils.isIE) _s.thumbHolder_do.removeChild(_s.thumbnail_do);
				}catch(e){}
			}
			
			if(!_s.thumbnail_do){
				_s.thumbnail_do = new FWDUVPDisplayObject("img");
				_s.smallImage_img = new Image();
			}
			
			_s.thumbHolder_do.setVisible(true);
			_s.smallImage_img.onload = _s.onSmallImageLoad;
			_s.smallImage_img.src = path;
		};
		
		_s.onSmallImageLoad = function(){
			
			_s.smallImageOriginalW = _s.smallImage_img.width;
			_s.smallImageOriginalH = _s.smallImage_img.height;
			_s.thumbnail_do.setScreen(_s.smallImage_img);
			_s.thumbHolder_do.addChild(_s.thumbnail_do);
			
			var scaleX = _s.thumbHolder_do.w/_s.smallImageOriginalW;
			var scaleY = _s.thumbHolder_do.h/_s.smallImageOriginalH;
			var totalScale = 0;
			
			if(scaleX >= scaleY){
				totalScale = scaleX;
			}else if(scaleX <= scaleY){
				totalScale = scaleY;
			}
			
			_s.thumbnail_do.setWidth(Math.round(_s.smallImageOriginalW * totalScale));
			_s.thumbnail_do.setHeight(Math.round(_s.smallImageOriginalH * totalScale));
			_s.thumbnail_do.setX(Math.round((_s.thumbHolder_do.w - _s.thumbnail_do.w)/2));
			_s.thumbnail_do.setY(Math.round((_s.thumbHolder_do.h - _s.thumbnail_do.h)/2));
			_s.thumbnail_do.setAlpha(0);
			FWDAnimation.to(_s.thumbnail_do, .8, {alpha:1});
			_s.updateText();
		};
		

		//#####################################//
		/* Update text */
		//#####################################//
		_s.updateText = function(text){
			if(text) _s.text_do.setInnerHTML(text);
			
			if(_s.hasThumbanil_bl){
				_s.text_do.setX(16);
				_s.text_do.setWidth(_s.totalWidth - _s.totalHeight - 26);
			}else{
				_s.text_do.setX(8);
				_s.text_do.setWidth(_s.totalWidth - 16);
			}
			
			_s.text_do.setY(parseInt((_s.totalHeight - _s.text_do.getHeight())/2));
		};
	

		//#####################################//
		/* show / hide */
		//#####################################//
		_s.show = function(animate){
			if(_s.isShowed_bl) return;
			
			_s.isShowed_bl = true;
			_s.setVisible(true);
			
			FWDAnimation.killTweensOf(_s.main_do);
			if(animate && !_s.isMbl){
				if(_s.position_str == "left"){
					FWDAnimation.to(_s.main_do, .8, {x:0, delay:.2, ease:Expo.easeInOut});
				}else{
					FWDAnimation.to(_s.main_do, .8, {x:-_s.totalWidth + 1, delay:.2,  ease:Expo.easeInOut});
				}
			}else{
				if(_s.position_str == "left"){
					_s.main_do.setX(0);
				}else{
					_s.main_do.setX(-_s.totalWidth);
				}
			}
		};	
			
		_s.hide = function(animate, overwrite){
			if(!_s.isShowed_bl && !overwrite) return;
			
			_s.isShowed_bl = false;
			_s.hasThumbanil_bl = false;
			
			FWDAnimation.killTweensOf(_s.main_do);
			if(animate && !_s.isMbl){
				if(_s.position_str == "left"){
					FWDAnimation.to(_s.main_do, .8, {x:-_s.totalWidth, ease:Expo.easeInOut, onComplete:_s.hideCompleteHandler});
				}else{
					FWDAnimation.to(_s.main_do, .8, {x:0, ease:Expo.easeInOut, onComplete:_s.hideCompleteHandler});
				}
			}else{
				if(_s.position_str == "left"){
					_s.main_do.setX(-_s.totalWidth);
				}else{
					_s.main_do.setX(0);
				} 
				_s.hideCompleteHandler();
			}
		};
		
		_s.hideCompleteHandler = function(){
			if(_s.smallImage_img){
				_s.smallImage_img.onload = null;
				_s.smallImage_img.src = "";
				FWDAnimation.killTweensOf(_s.thumbnail_do);
			}
			
			if(_s.main_do.alpha != 1) _s.main_do.setAlpha(1);
			_s.thumbHolder_do.setVisible(false);
			_s.setVisible(false);
		};
		

		//###########################################//
		/* hide / show  opacity */
		//###########################################//
		_s.hideWithOpacity = function(){
			if(!FWDUVPUtils.isIEAndLessThen9){
				FWDAnimation.to(_s.main_do, .8, {alpha:.5});
			}
		};
		
		_s.showWithOpacity = function(){
			if(!FWDUVPUtils.isIEAndLessThen9){
				FWDAnimation.to(_s.main_do, .8, {alpha:1});
			}
		};
		
		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPAdsStart.setPrototype = function(){
		FWDUVPAdsStart.prototype = null;
		FWDUVPAdsStart.prototype = new FWDUVPTransformDisplayObject("div");
	};
	
	FWDUVPAdsStart.CLICK = "onClick";
	FWDUVPAdsStart.MOUSE_OVER = "onMouseOver";
	FWDUVPAdsStart.SHOW_TOOLTIP = "showTooltip";
	FWDUVPAdsStart.MOUSE_OUT = "onMouseOut";
	FWDUVPAdsStart.MOUSE_UP = "onMouseDown";
	
	FWDUVPAdsStart.prototype = null;
	window.FWDUVPAdsStart = FWDUVPAdsStart;
}(window));