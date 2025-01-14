/**
 * Ultimate Video Player PACKAGED v9.1
 * Popup window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPOPWindow = function(_d, prt){
		
		'use strict';

		var _s = this;
		var prototype = FWDUVPOPWindow.prototype;
		
		_s.buttons_ar = [];
		
		_s.maxWidth = _d.aopwWidth;
		_s.maxHeight = _d.aopwHeight + _d.popwColseN_img.height + 1; 
		_s.sW = 0;
		_s.sH = 0;
		_s.aopwSource = _d.aopwSource;
		_s.aopwTitle = _d.aopwTitle;
		_s.aopwTitleColor_str = _d.aopwTitleColor_str;
		_s.aopwBorderSize = _d.aopwBorderSize;

		_s.isMbl = FWDUVPUtils.isMobile;
	

		//#################################//
		/* init */
		//#################################//
		_s.init = function(){
			_s.setBackfaceVisibility();
			
			_s.mainBar_do = new FWDUVPDisplayObject("div");
			
			_s.bar_do = new FWDUVPDisplayObject("div");
			_s.bar_do.getStyle().background = "url('" + _d.popwBarBackgroundPath_str + "')";
			
			_s.adHolder_do = new FWDUVPDisplayObject("div");
		
			_s.adBk_do = new FWDUVPDisplayObject("div");
			_s.adBk_do.getStyle().background = "url('" + _d.popwWindowBackgroundPath_str + "')";
				
			//setup close button
			FWDUVPSimpleButton.setPrototype();
			_s.clsBtn = new FWDUVPSimpleButton(_d.popwColseN_img, _d.popwColseSPath_str, undefined,
					true,
					_d.useHEX,
					_d.nBC,
					_d.sBC,
					false, false, false, false, true);
			_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
			
			_s.title_do = new FWDUVPDisplayObject("div");
			_s.title_do.getStyle().width = "100%";
			_s.title_do.getStyle().textAlign = "left";
			_s.title_do.getStyle().fontFamily = "Arial";
			_s.title_do.getStyle().fontSize= "14px";
			_s.title_do.getStyle().fontWeight = "100";
			_s.title_do.getStyle().color = _s.aopwTitleColor_str;
			_s.title_do.setInnerHTML(_s.aopwTitle);
			_s.bar_do.addChild(_s.title_do);
			
			_s.addChild(_s.adBk_do);
			_s.mainBar_do.addChild(_s.bar_do);
			_s.mainBar_do.addChild(_s.clsBtn); 
			_s.mainBar_do.setHeight(_s.clsBtn.h);
			_s.addChild(_s.mainBar_do);
			_s.addChild(_s.adHolder_do);
			_s.bar_do.setHeight(_s.mainBar_do.h);
		};
		
		_s.closeButtonOnMouseUpHandler = function(){
			if(!_s.isShowed_bl) return;
			_s.hide();
			prt.play();
		};
		
		_s.positionAndResize = function(){
			_s.sW = Math.min(prt.tempVidStageWidth, _s.maxWidth);
			_s.sH = Math.min(prt.tempVidStageHeight, _s.maxHeight);
			var totalScale = 1;
			var scaleX = prt.tempVidStageWidth/_s.maxWidth;
			var scaleY = prt.tempVidStageHeight/_s.maxHeight;
			if(scaleX < scaleY){
				totalScale = scaleX;
			}else if(scaleX > scaleY){
				totalScale = scaleY;
			}
			if(totalScale > 1) totalScale = 1;
			
			_s.sW = totalScale * _s.maxWidth;
			_s.sH = totalScale * _s.maxHeight;
			
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH);
	
			_s.setHeight(_s.sH);
			_s.setX(Math.round((prt.tempVidStageWidth - _s.sW)/2));
			_s.setY(Math.round((prt.tempVidStageHeight - _s.sH)/2));
			
			_s.mainBar_do.setWidth(_s.sW);
			_s.clsBtn.setX(_s.sW - _s.clsBtn.w);
			_s.bar_do.setWidth(_s.sW - _s.clsBtn.w - 1);
			
			_s.adBk_do.setWidth(_s.sW);
			_s.adBk_do.setHeight(_s.sH - _s.mainBar_do.h - 1);
			_s.adBk_do.setY(_s.mainBar_do.h + 1);
			
			_s.adHolder_do.setWidth(_s.sW - _s.aopwBorderSize * 2);
			_s.adHolder_do.setX(_s.aopwBorderSize);
			_s.adHolder_do.setY(_s.mainBar_do.h + _s.aopwBorderSize + 1);
			_s.adHolder_do.setHeight(_s.sH - _s.mainBar_do.h - _s.aopwBorderSize * 2 - 1);
		};
		
		
		//###########################################//
		/* show / hide */
		//###########################################//
		_s.show = function(aopwSource){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;
			if(aopwSource) _s.aopwSource = aopwSource;
			prt.main_do.addChild(_s);
			_s.adHolder_do.setInnerHTML("<iframe width='100%' height='100%' scrolling='no' frameBorder='0' src=" + _s.aopwSource + "></iframe>");
			_s.positionAndResize();
			
			_s.title_do.setX(8);
			_s.title_do.setY(Math.round((_s.bar_do.h - _s.title_do.getHeight())/2));
		};
		
		_s.showCompleteHandler = function(){};
		
		_s.hide = function(){
			if(!_s.isShowed_bl) return;
			_s.isShowed_bl = false;
			if(prt.main_do.contains(_s)) prt.main_do.removeChild(_s);
		};
		
		_s.hideCompleteHandler = function(){
			prt.main_do.removeChild(_s);
			_s.dispatchEvent(FWDUVPOPWindow.HIDE_COMPLETE);
		};
		

		//##########################################//
		/* Update HEX color of a canvaas */
		//##########################################//
		_s.updateHEXColors = function(nBC, sBC){
			_s.clsBtn.updateHEXColors(nBC, sBC);
		}
	
		_s.init();
	};
		
		
	/* set prototype */
	FWDUVPOPWindow.setPrototype = function(){
		FWDUVPOPWindow.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPOPWindow.HIDE_COMPLETE = "hideComplete";
	
	FWDUVPOPWindow.prototype = null;
	window.FWDUVPOPWindow = FWDUVPOPWindow;
}(window));