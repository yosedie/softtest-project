/**
 * Ultimate Video Player PACKAGED v9.1
 * Youtube quality button.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (){
var FWDUVPYTBQButton = function(
			label,
			nBC,
			sBC,
			hdPath,
			id
		){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPYTBQButton.prototype;
	
		_s.label_str = label;
		_s.nBC = nBC;
		_s.sBC = sBC;
		_s.hdPath_str = hdPath;

		_s.id = id;
		_s.totalWidth = 0;
		_s.totalHeight = 23;
		_s.hdWidth = 7;
		_s.hdHeight = 5;

		_s.hasHd_bl = _s.hdPath_str
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.isDisabled_bl = false;

		
		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setBackfaceVisibility();
			_s.setupMainContainers();
			_s.setHeight(_s.totalHeight);
		};
		

		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.setupMainContainers = function(){
			_s.text_do = new FWDUVPDisplayObject("div");
			_s.text_do.setBackfaceVisibility();
			_s.text_do.hasTransform3d_bl = false;
			_s.text_do.hasTransform2d_bl = false;
			_s.text_do.getStyle().display = "inline-block";
			_s.text_do.getStyle().whiteSpace = "nowrap";
			_s.text_do.getStyle().fontFamily = "Arial";
			_s.text_do.getStyle().fontSize= "12px";
			_s.text_do.getStyle().color = _s.nBC;
			_s.text_do.setInnerHTML(_s.label_str);
			_s.addChild(_s.text_do);
			
			if(_s.hasHd_bl){
				var img = new Image();
				
				img.src = _s.hdPath_str;
				_s.hd_do = new FWDUVPDisplayObject("img");
				_s.hd_do.setScreen(img);
				_s.hd_do.setWidth(_s.hdWidth);
				_s.hd_do.setHeight(_s.hdHeight);
				_s.addChild(_s.hd_do);
			}
				
			_s.dumy_do = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.dumy_do.setBkColor("#FF0000");
				_s.dumy_do.setAlpha(0.0001);
			};
			
			_s.dumy_do.setButtonMode(true);
			_s.dumy_do.setHeight(_s.totalHeight);
			_s.addChild(_s.dumy_do);
			
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
		};
		
		_s.onMouseOver = function(e){
			if(_s.isDisabled_bl) return;
			_s.setSelectedState(true);
			_s.dispatchEvent(FWDUVPYTBQButton.MOUSE_OVER, {e:e, id:_s.id});
		};
			
		_s.onMouseOut = function(e){
			if(_s.isDisabled_bl) return;
			_s.setNormalState(true);
			_s.dispatchEvent(FWDUVPYTBQButton.MOUSE_OUT, {e:e, id:_s.id});
		};
		
		_s.onMouseUp = function(e){
			if(_s.isDisabled_bl || e.button == 2) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPYTBQButton.CLICK, {e:e, id:_s.id});
		};
	

		//###############################//
		/* set final size */
		//###############################//
		_s.setFinalSize = function(){
			var width = _s.text_do.getWidth() + 34;
			var height = _s.text_do.getHeight();
		
			_s.text_do.setX(18);
			_s.text_do.setY(parseInt((_s.totalHeight - height)/2));
			
			if(_s.hd_do){
				_s.hd_do.setX(width - 12);
				_s.hd_do.setY(_s.text_do.y + 1);
			}
			
			_s.dumy_do.setWidth(width);
			_s.setWidth(width);
		}
		
		_s.updateText = function(label){
			_s.label_str = label;
			_s.text_do.setInnerHTML(_s.label_str);
			
			if(_s.hd_do){
				if(_s.label_str == "highres" || _s.label_str == "hd1080" || _s.label_str == "hd720" || _s.label_str == "hd1440" || _s.label_str == "hd2160"){
					_s.hd_do.setVisible(true);
				}else{
					_s.hd_do.setVisible(false);
				}
			}
		};
		

		//################################//
		/* Set states */
		//###############################//
		_s.setSelectedState = function(animate){
			_s.isSelected_bl = true;
			FWDAnimation.killTweensOf(_s.text_do);
			if(animate){
				FWDAnimation.to(_s.text_do.screen, .5, {css:{color:_s.sBC}, ease:Expo.easeOut});
			}else{
				_s.text_do.getStyle().color = _s.sBC;
			}
		};
		
		_s.setNormalState = function(animate){
			_s.isSelected_bl = false;
			FWDAnimation.killTweensOf(_s.text_do);
			if(animate){
				FWDAnimation.to(_s.text_do.screen, .5, {css:{color:_s.nBC}, ease:Expo.easeOut});
			}else{
				_s.text_do.getStyle().color = _s.nBC;
			}
		};
		

		//##############################//
		/* disable /enable button */
		//##############################//
		_s.disable = function(){
			_s.isDisabled_bl = true;
			FWDAnimation.killTweensOf(_s.text_do);
			_s.setSelectedState(true);
			_s.dumy_do.setButtonMode(false);
		};
		
		_s.enable = function(){
			_s.isDisabled_bl = false;
			FWDAnimation.killTweensOf(_s.text_do);
			_s.setNormalState(true);
			_s.dumy_do.setButtonMode(true);
		};
		

		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPYTBQButton.setPrototype = function(){
		FWDUVPYTBQButton.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPYTBQButton.MOUSE_OVER = "onMouseOver";
	FWDUVPYTBQButton.MOUSE_OUT = "onMouseOut";
	FWDUVPYTBQButton.CLICK = "onClick";
	
	FWDUVPYTBQButton.prototype = null;
	window.FWDUVPYTBQButton = FWDUVPYTBQButton;
}(window));