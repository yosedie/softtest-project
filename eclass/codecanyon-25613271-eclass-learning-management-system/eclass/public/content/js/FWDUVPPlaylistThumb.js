/**
 * Ultimate Video Player PACKAGED v9.1
 * Playlist thumb.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	var FWDUVPPlaylistThumb = function(
			prt,
			pId, 
			backgroundImagePath,
			thumbnailNormalBackgroundColor,
			thumbnailHoverBackgroundColor,
			thumbnailDisabledBackgroundColor,
			thumbImageWidth,
			thumbImageHeight,
			padding,
			htmlContent,
			htmlText,
			showThumbnail_bl
		){
		
		'use strict';

		var _s = this;
		var prototype = FWDUVPPlaylistThumb.prototype;
	
		_s.backgroundImagePath_str = backgroundImagePath;
		_s.thumbnailNormalBackgroundColor_str = thumbnailNormalBackgroundColor;
		_s.thumbnailHoverBackgroundColor_str = thumbnailHoverBackgroundColor;
		_s.thumbnailDisabledBackgroundColor_str = thumbnailDisabledBackgroundColor;
		_s.htmlContent_str = htmlContent;
		_s.htmlText_str = htmlText.toLowerCase();
		_s.curStt = "none";
	
		_s.id = pId;
		_s.padding = padding;
		_s.thumbImageWidth = thumbImageWidth;
		_s.thumbImageHeight = thumbImageHeight;
		_s.finalH = _s.padding * 2 + _s.thumbImageHeight;
	
		_s.isDark = true;
		if(backgroundImagePath.indexOf('dark') == -1){
			_s.isDark = false;
		}
	
		_s.hasCanvas_bl = FWDUVPlayer.hasCanvas;
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.showThumbnail_bl = showThumbnail_bl;


		//#################################//
		/* initialize */
		//#################################//
		_s.init = function(){
			_s.setupMainContainers();
			
			_s.setButtonMode(true);
			_s.setNormalState();
			
			if(_s.hasPointerEvent_bl){
				_s.screen.addEventListener("pointerover", _s.onMouseOver);
				_s.screen.addEventListener("pointerout", _s.onMouseOut);
				_s.screen.addEventListener("pointerup", _s.onMouseUp);
			}else if(_s.screen.addEventListener){	
				_s.screen.addEventListener("mouseover", _s.onMouseOver);
				_s.screen.addEventListener("mouseout", _s.onMouseOut);
				_s.screen.addEventListener("click", _s.onMouseUp);
			}
		};
		
		_s.onMouseUp = function(e){
			if(_s.isDisabled_bl || e.button == 2) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPPlaylistThumb.MOUSE_UP, {id:_s.id});
		};
		
		_s.onMouseOver = function(e){
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				if(_s.isDisabled_bl) return;
				_s.setSelectedState(true);
			}
		};
			
		_s.onMouseOut = function(e){
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				if(_s.isDisabled_bl) return;
				_s.setNormalState(true);
			}
		};
		

		//#################################//
		/* set image */
		//#################################//
		_s.setupMainContainers = function(){

			_s.mainImgHld = new FWDUVPDisplayObject("div");
			_s.mainImgHld.screen.className = 'fwduvp-playlist-thumbnail';
			_s.mainImgHld.getStyle().background = "url('" + _s.backgroundImagePath_str + "')";
			_s.mainImgHld.setX(_s.padding);
			_s.mainImgHld.setY(_s.padding);
			_s.mainImgHld.setWidth(_s.thumbImageWidth);
			_s.mainImgHld.setHeight(_s.thumbImageHeight);
			_s.imageHolder_do = new FWDUVPDisplayObject("div");
			
			_s.txt = new FWDUVPDisplayObject("div");
			var cls = 'fwduvp-playlist-thumbnail-white-text';
			if(_s.isDark){
				cls = 'fwduvp-playlist-thumbnail-dark-text';
			}
			_s.txt.screen.className = cls;
			_s.txt.hasTransform3d_bl = false;
			_s.txt.hasTransform2d_bl = false;
			_s.txt.setHeight(_s.finalH - 6);
			_s.txt.setBackfaceVisibility();
			_s.txt.getStyle().fontFamily = "Arial";
			_s.txt.getStyle().fontSize= "12px";
			_s.txt.getStyle().color = _s.fontColor_str;
			_s.txt.getStyle().fontSmoothing = "antialiased";
			_s.txt.getStyle().webkitFontSmoothing = "antialiased";
			_s.txt.getStyle().textRendering = "optimizeLegibility";
			
			_s.slTitle = _s.txt.screen.className;
			
			if(_s.showThumbnail_bl){
				_s.txt.setX((_s.padding * 2) + _s.thumbImageWidth + 4);
			}else{
				_s.txt.setX((_s.padding * 2));
			}
		
			_s.txt.setInnerHTML(_s.htmlContent_str);	
			if(!prt.showOnlyThmb) _s.addChild(_s.txt);
			
			_s.dumy_do = new FWDUVPDisplayObject("div");
			_s.dumy_do.getStyle().width = "100%";
			_s.dumy_do.getStyle().height = "100%";
			if(FWDUVPUtils.isIE){
				_s.dumy_do.setBkColor("#FF0000");
				_s.dumy_do.setAlpha(0.01);
			}
		
			if(_s.showThumbnail_bl) _s.addChild(_s.mainImgHld); 	
			_s.mainImgHld.addChild(_s.imageHolder_do);
			_s.addChild(_s.dumy_do);
		};
		
		_s.updateText = function(htmlContent_str){
			try{
				_s.htmlContent_str = htmlContent_str;
				_s.txt.setInnerHTML(_s.htmlContent_str);
			}catch(e){}
		}

	
		//#################################//
		/* set image */
		//#################################//
		_s.setImage = function(image){
			_s.normalImage_do = new FWDUVPDisplayObject("img");
			_s.normalImage_do.setScreen(image);
			
			_s.imageOriginalW = _s.normalImage_do.w;
			_s.imageOriginalH = _s.normalImage_do.h;
		
			_s.resizeImage();
			
			_s.imageHolder_do.setX(parseInt(_s.thumbImageWidth/2));
			_s.imageHolder_do.setY(parseInt(_s.thumbImageHeight/2));
			_s.imageHolder_do.setWidth(0);
			_s.imageHolder_do.setHeight(0);
			
			_s.normalImage_do.setX(- parseInt(_s.normalImage_do.w/2));
			_s.normalImage_do.setY(- parseInt(_s.normalImage_do.h/2));
		
			FWDAnimation.to(_s.imageHolder_do, .8, {
				x:0, 
				y:0,
				w:_s.thumbImageWidth,
				h:_s.thumbImageHeight, 
				ease:Expo.easeInOut});
			_s.normalImage_do.setAlpha(0);
			
			if(_s.isMbl){
				var curAlpha;
				if(_s.id == prt.curId){
					curAlpha = .3;
				}else{
					curAlpha = 1;
				}
			
				FWDAnimation.to(_s.normalImage_do, .8, {
					alpha:curAlpha,
					x:_s.imageFinalX, 
					y:_s.imageFinalY, 
					ease:Expo.easeInOut});
				
			}else{
				FWDAnimation.to(_s.normalImage_do, .8, {
					alpha:1,
					x:_s.imageFinalX, 
					y:_s.imageFinalY, 
					ease:Expo.easeInOut});
			}
			
			_s.imageHolder_do.addChild(_s.normalImage_do);
			_s.hasImage_bl = true;
		};
		

		//#################################//
		/* resize thumbnail*/
		//#################################//
		_s.resizeAndPosition = function(animate){
			if(_s.showThumbnail_bl){
				_s.txt.setWidth(_s.finalW - ((_s.padding * 2) + _s.thumbImageWidth) - 16);
			}else{
				_s.txt.setWidth(_s.finalW - ((_s.padding * 2)) - 16);
			}
			_s.setWidth(_s.finalW);
			_s.setHeight(_s.finalH);
			
			if(animate){
				FWDAnimation.to(_s, .6, {x:_s.finalX, y:_s.finalY, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(_s);
				_s.setX(_s.finalX);
				_s.setY(_s.finalY);
			}
			
			_s.resizeImage();
		};
	

		//#################################//
		/* resize image*/
		//#################################//
		_s.resizeImage = function(animate){
			if(prt.showOnlyThmb){
				_s.mainImgHld.setWidth(_s.thumbImageWidth);
				_s.mainImgHld.setHeight(_s.thumbImageHeight);
				_s.imageHolder_do.setWidth(_s.thumbImageWidth);
				_s.imageHolder_do.setHeight(_s.thumbImageHeight);
			}

			if(!_s.normalImage_do) return;
			
			if(_s.isMbl){	
				if(_s.normalImage_do.alpha != 1 && !_s.isDisabled_bl) _s.normalImage_do.setAlpha(1);
			}else{
				if(_s.imageHolder_do.alpha != 1 && !_s.isDisabled_bl) _s.imageHolder_do.setAlpha(1);
			}

			var scX = _s.thumbImageWidth/_s.imageOriginalW;
			var scY = _s.thumbImageHeight/_s.imageOriginalH;
			var ttsc;
			
			if(scX >= scY){
				ttsc = scX;
			}else{
				ttsc = scY;
			}
			
			_s.imageFinalW = Math.ceil(ttsc * _s.imageOriginalW);
			_s.imageFinalH = Math.ceil(ttsc * _s.imageOriginalH);
			_s.imageFinalX = Math.round((_s.thumbImageWidth - _s.imageFinalW)/2);
			_s.imageFinalY = Math.round((_s.thumbImageHeight - _s.imageFinalH)/2);
		
			_s.normalImage_do.setX(_s.imageFinalX);
			_s.normalImage_do.setY(_s.imageFinalY);
			_s.normalImage_do.setWidth(_s.imageFinalW);
			_s.normalImage_do.setHeight(_s.imageFinalH);
		};
		

		//#######################################//
		/* Set selected/normal/disable states */
		//######################################//
		_s.setNormalState = function(animate){
			if(_s.curStt == "normal") return;
			_s.curStt = "normal";

			if(_s.slTitle){
				_s.txt.screen.className = _s.slTitle;
			}

			if(animate){
				FWDAnimation.to(_s.screen, .8, {css:{backgroundColor:_s.thumbnailNormalBackgroundColor_str},ease:Expo.easeOut});
			}else{
				FWDAnimation.killTweensOf(_s.screen);
				_s.getStyle().backgroundColor = _s.thumbnailNormalBackgroundColor_str;
			}
		};
		
		_s.setSelectedState = function(animate){
			if(_s.curStt == "selected") return;
			_s.curStt = "selected";
		
			_s.setTitleSelectedClass();
			if(animate){
				FWDAnimation.to(_s.screen, .8, {css:{backgroundColor:_s.thumbnailHoverBackgroundColor_str},ease:Expo.easeOut});
			}else{
				FWDAnimation.killTweensOf(_s.screen);
				_s.getStyle().backgroundColor = _s.thumbnailNormalBackgroundColor_str;
			}
		};
		
		_s.setDisabledState = function(animate){
			if(_s.curStt == "disabled") return;
			_s.curStt = "disabled";

			_s.setTitleSelectedClass();
			if(animate){
				FWDAnimation.to(_s.screen, .8, {css:{backgroundColor:_s.thumbnailDisabledBackgroundColor_str},ease:Expo.easeOut});
			}else{
				FWDAnimation.killTweensOf(_s.screen);
				_s.getStyle().backgroundColor = _s.thumbnailNormalBackgroundColor_str;
			}
		};

		_s.setTitleSelectedClass = function(){
			if(_s.slTitle){
				_s.txt.screen.className = _s.slTitle  + ' active';
			}
		}
		

		//###############################//
		/* enable / disable */
		//##############################//
		_s.enable = function(){
			if(!_s.isDisabled_bl) return;
			_s.isDisabled_bl = false;
			_s.setButtonMode(true);
			_s.setNormalState(true);
			
			if(_s.isMbl){
				if(_s.normalImage_do) _s.normalImage_do.setAlpha(1);
			}else{
				FWDAnimation.to(_s.imageHolder_do, .6, {alpha:1});
			}
		};
		
		_s.disable = function(){
			if(_s.isDisabled_bl) return;
			_s.disableForAWhile_bl = true;
			clearTimeout(_s.disableForAWhileId_to);
			_s.disableForAWhileId_to = setTimeout(function(){
				_s.disableForAWhile_bl = false;
			}, 200);
			_s.isDisabled_bl = true;
			_s.setButtonMode(false);
			_s.setDisabledState(true);
			
			if(_s.isMbl){
				if(_s.normalImage_do) _s.normalImage_do.setAlpha(.3);
			}else{
				FWDAnimation.to(_s.imageHolder_do, .6, {alpha:.3});
			}
		};

		
		//################################//
		/* Destroy */
		//################################//
		_s.destroy = function(){
			FWDAnimation.killTweensOf(_s);
			if(_s.normalImage_do){
				FWDAnimation.killTweensOf(_s.normalImage_do);
				_s.normalImage_do.destroy();
			}
			
			FWDAnimation.killTweensOf(_s.imageHolder_do);
			_s.imageHolder_do.destroy();
			_s.dumy_do.destroy();
			_s.txt.destroy();
			_s.backgroundImagePath_str = backgroundImagePath;
			_s.imageHolder_do = null;
			_s.normalImage_do = null;
			_s.dumy_do = null;
			_s.txt = null;
			_s.htmlContent_str = null;
			_s.htmlText_str = null;
			_s.curStt = null;
		};
	
		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPPlaylistThumb.setPrototype = function(){
		FWDUVPPlaylistThumb.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPPlaylistThumb.SHOW_TOOL_TIP = "showToolTip";
	FWDUVPPlaylistThumb.HIDE_TOOL_TIP = "hideToolTip";
	FWDUVPPlaylistThumb.MOUSE_UP = "onMouseUp";
	
	FWDUVPPlaylistThumb.prototype = null;
	window.FWDUVPPlaylistThumb = FWDUVPPlaylistThumb;
}(window));