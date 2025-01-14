/**
 * Ultimate Video Player PACKAGED v9.1
 * Right click context menu button.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (){
var FWDUVPContextMenuButton = function(
			label1, 
			label2, 
			normalColor,
			selectedColor,
			disabledColor,
			padding
		){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPContextMenuButton.prototype;
		
		_s.label1_str = label1;
		_s.label2_str = label2;
		_s.nBC = normalColor;
		_s.sBC = selectedColor;
		_s.disabledColor_str = disabledColor;
		
		_s.totalWidth = 400;
		_s.totalHeight = 20;		
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.currentState = 1;
		_s.showSecondButton_bl = label2 != undefined;


		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setBackfaceVisibility();
			_s.setButtonMode(true);
			_s.setupMainContainers();
			_s.setWidth(_s.totalWidth);
			_s.setHeight(_s.totalHeight);
			_s.setButtonState(0);
		};

		
		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.setupMainContainers = function(){
			
			_s.text1_sdo = new FWDUVPDisplayObject("div");
			_s.text1_sdo.setBackfaceVisibility();
			_s.text1_sdo.setDisplay("inline-block");
			_s.text1_sdo.getStyle().fontFamily = "Arial";
			_s.text1_sdo.getStyle().fontSize= "12px";
			_s.text1_sdo.getStyle().color = _s.nBC;
			_s.text1_sdo.getStyle().fontSmoothing = "antialiased";
					_s.text1_sdo.setInnerHTML(_s.label1_str);
			_s.addChild(_s.text1_sdo);
			
			if(_s.showSecondButton_bl){
				_s.text2_sdo = new FWDUVPDisplayObject("div");
				_s.text2_sdo.setBackfaceVisibility();
				_s.text2_sdo.setDisplay("inline-block");
				_s.text2_sdo.getStyle().fontFamily = "Arial";
				_s.text2_sdo.getStyle().fontSize= "12px";
				_s.text2_sdo.getStyle().color = _s.nBC;
				_s.text2_sdo.getStyle().fontSmoothing = "antialiased";
				_s.text2_sdo.setInnerHTML(_s.label2_str);
				_s.addChild(_s.text2_sdo);
			}
			
			_s.dumy_sdo = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.dumy_sdo.setBkColor("#FF0000");
				_s.dumy_sdo.setAlpha(0);
			};
			_s.addChild(_s.dumy_sdo);
			
			if(_s.isMbl){
				_s.screen.addEventListener("touchstart", _s.onMouseDown);
			}else if(_s.screen.addEventListener){
				_s.screen.addEventListener("mouseover", _s.onMouseOver);
				_s.screen.addEventListener("mouseout", _s.onMouseOut);
				_s.screen.addEventListener("mousedown", _s.onMouseDown);
				_s.screen.addEventListener("click", _s.onClick);
			}
		};
		
		_s.onMouseOver = function(animate){
			if(_s.isDisabled_bl) return;
			FWDAnimation.killTweensOf(_s.text1_sdo);
			if(animate){
				FWDAnimation.to(_s.text1_sdo.screen, .5, {css:{color:_s.sBC}, ease:Expo.easeOut});
				if(_s.showSecondButton_bl) FWDAnimation.to(_s.text2_sdo.screen, .5, {css:{color:_s.sBC}, ease:Expo.easeOut});
			}else{
				_s.text1_sdo.getStyle().color = _s.sBC;
				if(_s.showSecondButton_bl){
					FWDAnimation.killTweensOf(_s.text2_sdo);
					_s.text2_sdo.getStyle().color = _s.sBC;
				}
			}
			_s.dispatchEvent(FWDUVPContextMenuButton.MOUSE_OVER);
		};
			
		_s.onMouseOut = function(e){
			if(_s.isDisabled_bl) return;
			FWDAnimation.killTweensOf(_s.text1_sdo);
			FWDAnimation.to(_s.text1_sdo.screen, .5, {css:{color:_s.nBC}, ease:Expo.easeOut});
			
			if(_s.showSecondButton_bl){
				FWDAnimation.killTweensOf(_s.text2_sdo);
				FWDAnimation.to(_s.text2_sdo.screen, .5, {css:{color:_s.nBC}, ease:Expo.easeOut});
			}
			_s.dispatchEvent(FWDUVPContextMenuButton.MOUSE_OUT);
		};
		
		_s.onClick = function(e){
			if(_s.isDeveleper_bl){
				window.open("http://www.webdesign-flash.ro", "_blank");
				return;
			}
			if(_s.isDisabled_bl) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPContextMenuButton.CLICK);
		};
		
		_s.onMouseDown = function(e){
			if(_s.isDisabled_bl) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPContextMenuButton.MOUSE_DOWN, {e:e});
		};
		

		//##############################//
		/* toggle button */
		//#############################//
		_s.toggleButton = function(){
			if(!_s.showSecondButton_bl ) return;
			if(_s.currentState == 1){
				_s.text1_sdo.setVisible(true);
				_s.text2_sdo.setVisible(false);
				_s.currentState = 0;
				_s.dispatchEvent(FWDUVPContextMenuButton.FIRST_BUTTON_CLICK);
			}else{
				_s.text1_sdo.setVisible(false);
				_s.text2_sdo.setVisible(true);
				_s.currentState = 1;
				_s.dispatchEvent(FWDUVPContextMenuButton.SECOND_BUTTON_CLICK);
			}
		};
		

		//##############################//
		/* set second buttons state */
		//##############################//
		_s.setButtonState = function(state){
			if(state == 0){
				_s.text1_sdo.setVisible(true);
				if(_s.showSecondButton_bl) _s.text2_sdo.setVisible(false);
				_s.currentState = 0;
			}else if(state == 1){
				_s.text1_sdo.setVisible(false);
				if(_s.showSecondButton_bl) _s.text2_sdo.setVisible(true);
				_s.currentState = 1;
			}
		};		


		//##########################################//
		/* center text */
		//##########################################//
		_s.centerText = function(){
			_s.dumy_sdo.setWidth(_s.totalWidth);
			_s.dumy_sdo.setHeight(_s.totalHeight);
			if(FWDUVPUtils.isIEAndLessThen9){
				_s.text1_sdo.setY(Math.round((_s.totalHeight - _s.text1_sdo.getHeight())/2) - 1);
				if(_s.showSecondButton_bl) _s.text2_sdo.setY(Math.round((_s.totalHeight - _s.text2_sdo.getHeight())/2) - 1);
			}else{
				_s.text1_sdo.setY(Math.round((_s.totalHeight - _s.text1_sdo.getHeight())/2));
				if(_s.showSecondButton_bl) _s.text2_sdo.setY(Math.round((_s.totalHeight - _s.text2_sdo.getHeight())/2));
			}
			_s.text1_sdo.setHeight(_s.totalHeight + 2);
			if(_s.showSecondButton_bl) _s.text2_sdo.setHeight(_s.totalHeight + 2);
		};
		

		//###############################//
		/* get max text width */
		//###############################//
		_s.getMaxTextWidth = function(){
			var w1 = _s.text1_sdo.getWidth();
			var w2 = 0;
			if(_s.showSecondButton_bl) w2 = _s.text2_sdo.getWidth();
			return Math.max(w1, w2);
		};

		
		//##############################//
		/* disable /enable button */
		//##############################//
		_s.disable = function(){
			_s.isDisabled_bl = true;
			FWDAnimation.killTweensOf(_s.text1_sdo);
			FWDAnimation.to(_s.text1_sdo.screen, .5, {css:{color:_s.disabledColor_str}, ease:Expo.easeOut});
			_s.setButtonMode(false);
		};
		
		_s.enable = function(){
			_s.isDisabled_bl = false;
			FWDAnimation.killTweensOf(_s.text1_sdo);
			FWDAnimation.to(_s.text1_sdo.screen, .5, {css:{color:_s.nBC}, ease:Expo.easeOut});
			_s.setButtonMode(true);
		};
		
		_s.init();
	};

	
	/* set prototype */
	FWDUVPContextMenuButton.setPrototype = function(){
		FWDUVPContextMenuButton.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPContextMenuButton.FIRST_BUTTON_CLICK = "onFirstClick";
	FWDUVPContextMenuButton.SECOND_BUTTON_CLICK = "secondButtonOnClick";
	FWDUVPContextMenuButton.MOUSE_OVER = "onMouseOver";
	FWDUVPContextMenuButton.MOUSE_OUT = "onMouseOut";
	FWDUVPContextMenuButton.MOUSE_DOWN = "onMouseDown";
	FWDUVPContextMenuButton.CLICK = "onClick";
	
	FWDUVPContextMenuButton.prototype = null;
	window.FWDUVPContextMenuButton = FWDUVPContextMenuButton;
}(window));