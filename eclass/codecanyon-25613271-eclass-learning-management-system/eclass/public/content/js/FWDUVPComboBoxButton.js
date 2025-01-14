/**
 * Ultimate Video Player PACKAGED v9.1
 * Playlist select box button.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (){
var FWDUVPComboBoxButton = function(
			prt,
			label1, 
			backgroundNormalColor,
			backgroundSelectedColor,
			textNormalColor,
			textSelectedColor,
			id,
			totalHeight
		){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPComboBoxButton.prototype;
		
		_s.label1_str = label1;
		_s.bkNClr = backgroundNormalColor;
		_s.bkSClr = backgroundSelectedColor;
		_s.txtNClr = textNormalColor;
		_s.txtSClr = textSelectedColor;
		
		_s.totalWidth = 400;
		_s.totalHeight = totalHeight;
		_s.id = id;
		
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.isMbl = FWDUVPUtils.isMobile;

	
		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setBackfaceVisibility();
			_s.setButtonMode(true);
			_s.setupMainContainers();
			_s.setWidth(_s.totalWidth);
			_s.setHeight(_s.totalHeight);
			_s.setNormalState();
		};

		
		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.setupMainContainers = function(){
			
			_s.bk_sdo = new FWDUVPDisplayObject("div");
			_s.bk_sdo.setBkColor(_s.bkNClr);
			_s.addChild(_s.bk_sdo);
			
			_s.text_sdo = new FWDUVPDisplayObject("div");
			_s.text_sdo.getStyle().whiteSpace = "nowrap";
			_s.text_sdo.screen.className = 'fwduvp-cb-button'
			_s.text_sdo.setBackfaceVisibility();
			_s.text_sdo.setOverflow("visible");
			_s.text_sdo.setDisplay("inline-block");
			_s.text_sdo.getStyle().fontFamily = "Arial";
			_s.text_sdo.getStyle().fontSize= "13px";
			_s.text_sdo.getStyle().padding = "6px";
			_s.text_sdo.getStyle().fontWeight = "100";
			_s.text_sdo.getStyle().color = _s.nBC;
			_s.text_sdo.getStyle().fontSmoothing = "antialiased";
			_s.text_sdo.getStyle().webkitFontSmoothing = "antialiased";
			_s.text_sdo.getStyle().textRendering = "optimizeLegibility";	
			
			if (FWDUVPUtils.isIEAndLessThen9){
				_s.text_sdo.screen.innerText = _s.label1_str;
			}else{
				_s.text_sdo.setInnerHTML(_s.label1_str);
			}
			
			_s.addChild(_s.text_sdo);
			
			_s.dumy_sdo = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.dumy_sdo.setBkColor("#FF0000");
				_s.dumy_sdo.setAlpha(0);
			};
			_s.addChild(_s.dumy_sdo);
			
			
			if(_s.hasPointerEvent_bl){
				_s.screen.addEventListener("pointerup", _s.onClick);
				_s.screen.addEventListener("pointerover", _s.onMouseOver);
				_s.screen.addEventListener("pointerout", _s.onMouseOut);
			}else if(_s.screen.addEventListener){	
				if(!_s.isMbl){
					_s.screen.addEventListener("mouseover", _s.onMouseOver);
					_s.screen.addEventListener("mouseout", _s.onMouseOut);
					_s.screen.addEventListener("mouseup", _s.onClick);
				}
				_s.screen.addEventListener("touchend", _s.onClick);
			}
		};
		
		_s.onMouseOver = function(e){
			if(_s.isDisabled_bl) return;
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				FWDAnimation.killTweensOf(_s.text_sdo);
				_s.setSelectedState(true);
				_s.dispatchEvent(FWDUVPComboBoxButton.MOUSE_OVER);
			}
		};
			
		_s.onMouseOut = function(e){
			if(_s.isDisabled_bl) return;
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				FWDAnimation.killTweensOf(_s.text_sdo);
				_s.setNormalState(true);
				_s.dispatchEvent(FWDUVPComboBoxButton.MOUSE_OUT);
			}
		};
		
		_s.onClick = function(e){
			if(_s.isDisabled_bl || prt.isScrollingOnMove_bl) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPComboBoxButton.CLICK, {id:_s.id});
		};
		
		_s.onMouseDown = function(e){
			if(_s.isDisabled_bl || prt.isScrollingOnMove_bl) return;
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPComboBoxButton.MOUSE_DOWN, {id:_s.id});
		};
		

		//###########################################//
		/* set selected / normal state */
		//###########################################//
		_s.setSelectedState = function(animate){
			FWDAnimation.killTweensOf(_s.bk_sdo.screen);
			FWDAnimation.killTweensOf(_s.text_sdo.screen);
			if(animate){
				FWDAnimation.to(_s.bk_sdo.screen, .6, {css:{backgroundColor:_s.bkSClr}, ease:Quart.easeOut});
				FWDAnimation.to(_s.text_sdo.screen, .6, {css:{color:_s.txtSClr}, ease:Quart.easeOut});
			}else{
				_s.bk_sdo.setBkColor(_s.bkSClr);
				_s.text_sdo.getStyle().color = _s.txtSClr;
			}
		};
		
		_s.setNormalState = function(animate){
			FWDAnimation.killTweensOf(_s.bk_sdo.screen);
			FWDAnimation.killTweensOf(_s.text_sdo.screen);
			if(animate){
				FWDAnimation.to(_s.bk_sdo.screen, .6, {css:{backgroundColor:_s.bkNClr}, ease:Quart.easeOut});
				FWDAnimation.to(_s.text_sdo.screen, .6, {css:{color:_s.txtNClr}, ease:Quart.easeOut});
			}else{
				_s.bk_sdo.setBkColor(_s.bkNClr);
				_s.text_sdo.getStyle().color = _s.txtNClr;
			}
		};
		

		//##########################################//
		/* center text */
		//##########################################//
		_s.centerText = function(){
			
			_s.dumy_sdo.setWidth(_s.totalWidth);
			_s.dumy_sdo.setHeight(_s.totalHeight);
			_s.bk_sdo.setWidth(_s.totalWidth);
			_s.bk_sdo.setHeight(_s.totalHeight);
			_s.text_sdo.setX(4);
			_s.text_sdo.setY(Math.round((_s.totalHeight - _s.text_sdo.getHeight())/2));
		};
		

		//###############################//
		/* get max text width */
		//###############################//
		_s.getMaxTextWidth = function(){
			return _s.text_sdo.getWidth();
		};

		
		//##############################//
		/* disable / enable */
		//#############################//
		_s.disable = function(){
			_s.isDisabled_bl = true;
			_s.setButtonMode(false);
			_s.setSelectedState(true);
		};
		
		_s.enable = function(){
			_s.isDisabled_bl = false;
			_s.setNormalState(true);
			_s.setButtonMode(true);
		};
		
		_s.init();
	};
	
	
	/* set prototype */
	FWDUVPComboBoxButton.setPrototype = function(){
		FWDUVPComboBoxButton.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPComboBoxButton.FIRST_BUTTON_CLICK = "onFirstClick";
	FWDUVPComboBoxButton.SECOND_BUTTON_CLICK = "secondButtonOnClick";
	FWDUVPComboBoxButton.MOUSE_OVER = "onMouseOver";
	FWDUVPComboBoxButton.MOUSE_OUT = "onMouseOut";
	FWDUVPComboBoxButton.MOUSE_DOWN = "onMouseDown";
	FWDUVPComboBoxButton.CLICK = "onClick";
	
	FWDUVPComboBoxButton.prototype = null;
	window.FWDUVPComboBoxButton = FWDUVPComboBoxButton;
}(window));