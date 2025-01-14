/**
 * Ultimate Video Player PACKAGED v9.1
 * Button tooltip.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
var FWDUVPToolTip = function(
			buttonRef_do,
			bkPath_str,
			pointerPath_str,
			toolTipLabel_str,
			fontColor_str,
			toolTipsButtonsHideDelay
		){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPToolTip.prototype;
		
		_s.buttonRef_do = buttonRef_do;
		
		_s.bkPath_str = bkPath_str;
		_s.pointerPath_str = pointerPath_str;
	
		_s.fontColor_str = fontColor_str;
		_s.toolTipLabel_str = toolTipLabel_str;
		
		_s.toolTipsButtonsHideDelay = toolTipsButtonsHideDelay * 1000;
		_s.pointerWidth = 7;
		_s.pointerHeight = 4;
		
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.isShowed_bl = true;
	

		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setOverflow("visible");
			_s.screen.className = 'UVP-tooltip-bk';
			_s.setupMainContainers();
			_s.setLabel(_s.toolTipLabel_str);
			_s.hide();
			_s.getStyle().background = "url('" + _s.bkPath_str + "')";
			_s.getStyle().zIndex = 9999999999999;
		};
		

		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.setupMainContainers = function(){
			_s.text_do = new FWDUVPDisplayObject("div");
			_s.text_do.screen.className = 'UVP-tooltip-text';
			_s.text_do.hasTransform3d_bl = false;
			_s.text_do.hasTransform2d_bl = false;
			_s.text_do.setBackfaceVisibility();
			_s.text_do.setDisplay("inline");
			_s.text_do.getStyle().fontFamily = "Arial";
			_s.text_do.getStyle().fontSize= "12px";
			_s.text_do.getStyle().color = _s.fontColor_str;
			_s.text_do.getStyle().whiteSpace= "nowrap";
			_s.text_do.getStyle().padding = "6px";
			_s.text_do.getStyle().paddingTop = "4px";
			_s.text_do.getStyle().paddingBottom = "4px";
			_s.setLabel();
			_s.addChild(_s.text_do);
			
			
			_s.pointer_do = new FWDUVPDisplayObject("div");
			_s.pointer_do.screen.className = 'UVP-tooltip-pointer';
			_s.pointer_do.getStyle().background = "url('" + _s.pointerPath_str + "')";
			_s.pointer_do.setWidth(_s.pointerWidth);
			_s.pointer_do.setHeight(_s.pointerHeight);
			_s.addChild(_s.pointer_do);
		};
		

		//##########################################//
		/* set label */
		//##########################################//
		_s.setLabel = function(label){
			_s.text_do.setInnerHTML(toolTipLabel_str);
			setTimeout(function(){
				if(_s == null) return;
					_s.setWidth(_s.text_do.getWidth());
					_s.setHeight(_s.text_do.getHeight());
					_s.positionPointer();
				},50);
		};
		
		_s.positionPointer = function(offsetX){
			var finalX;
			var finalY;
			
			if(!offsetX) offsetX = 0;
			
			finalX = parseInt((_s.w - _s.pointerWidth)/2) + offsetX;
			finalY = _s.h;
			_s.pointer_do.setX(finalX);
			_s.pointer_do.setY(finalY);
		};
		

		//##########################################//
		/* show / hide*/
		//##########################################//
		_s.show = function(){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;
			
			FWDAnimation.killTweensOf(_s);
			clearTimeout(_s.showWithDelayId_to);
			_s.showWithDelayId_to = setTimeout(_s.showFinal, _s.toolTipsButtonsHideDelay);
			_s.setMVId_to = setTimeout(function(){
				window.addEventListener("mousemove", _s.moveHandler);
			}, 50);
		};
		
		_s.showFinal = function(){
			_s.setVisible(true);
			_s.setAlpha(0);
			FWDAnimation.to(_s, .4, {alpha:1, onComplete:function(){_s.setVisible(true);}, ease:Quart.easeOut});
		};
		
		_s.moveHandler = function(e){
			var wc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(!FWDUVPUtils.hitTest(_s.buttonRef_do.screen, wc.screenX, wc.screenY)) _s.hide();
		};
		
		_s.hide = function(){
			if(!_s.isShowed_bl) return;
			clearTimeout(_s.setMVId_to);
			clearTimeout(_s.showWithDelayId_to);
			window.removeEventListener("mousemove", _s.moveHandler);
			
			FWDAnimation.killTweensOf(_s);
			_s.setVisible(false);
			_s.isShowed_bl = false;
		};
		
		_s.init();
	};
	
	/* set prototype */
	FWDUVPToolTip.setPrototype = function(){
		FWDUVPToolTip.prototype = null;
		FWDUVPToolTip.prototype = new FWDUVPDisplayObject("div", "fixed");
	};
	
	FWDUVPToolTip.CLICK = "onClick";
	FWDUVPToolTip.MOUSE_DOWN = "onMouseDown";
	
	FWDUVPToolTip.prototype = null;
	window.FWDUVPToolTip = FWDUVPToolTip;
}(window));