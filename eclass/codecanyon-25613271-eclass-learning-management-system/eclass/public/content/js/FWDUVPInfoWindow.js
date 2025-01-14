/**
 * Ultimate Video Player PACKAGED v9.1
 * Info window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPInfoWindow = function(prt, _d){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPInfoWindow.prototype;
		
		_s.embedColoseN_img = _d.embedColoseN_img;
		
		_s.embedWindowBackground_str = _d.embedWindowBackground_str;
		_s.embedWindowInputBackgroundPath_str = _d.embedWindowInputBackgroundPath_str;
		_s.secondaryLabelsColor_str = _d.secondaryLabelsColor_str;
		_s.inputColor_str = _d.inputColor_str;
		_s.sendButtonNPath_str = _d.sendButtonNPath_str;
		_s.sendButtonSPath_str = _d.sendButtonSPath_str;
		_s.inputBackgroundColor_str = _d.inputBackgroundColor_str;
		_s.borderColor_str = _d.borderColor_str;
		_s.sendToAFriendPath_str = _d.sendToAFriendPath_str;
		
		_s.maxTextWidth = 0;
		_s.totalWidth = 0;
		_s.sW = 0;
		_s.sH = 0;
		_s.buttonWidth = 44;
		_s.buttonHeight = 19;
		_s.embedWindowCloseButtonMargins = _d.embedWindowCloseButtonMargins;
		_s.shareAndEmbedTextColor_str = _d.shareAndEmbedTextColor_str;

		_s.isDark = true;
		if(_s.embedWindowBackground_str.indexOf('dark') == -1){
			_s.isDark = false;
		}

		_s.isMbl = FWDUVPUtils.isMobile;
		_s.useVectorIcons_bl = _d.useVectorIcons_bl;
	

		//#################################//
		/* init */
		//#################################//
		_s.init = function(){
			_s.setBackfaceVisibility();
			_s.mainHld = new FWDUVPDisplayObject("div");
			var css = 'fwduvp-info-window-white';
			
			if(_s.isDark){
				css = 'fwduvp-info-window-dark';
			}
			_s.mainHld.screen.className = css;
			
			_s.mainBk_do = new FWDUVPDisplayObject("div");
			_s.mainBk_do.getStyle().width = "100%";
			_s.mainBk_do.getStyle().height = "100%";
			_s.mainBk_do.setAlpha(.9);
			_s.mainBk_do.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
		
			//setup link and embed text
			_s.mainTextHolder_do =  new FWDUVPDisplayObject("div", "absolute");
			
			_s.bk_do = new FWDUVPDisplayObject("div");
			_s.bk_do.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
			_s.bk_do.getStyle().borderStyle = "solid";
			_s.bk_do.getStyle().borderWidth = "1px";
			_s.bk_do.getStyle().borderColor =  _s.borderColor_str;
			
			_s.text_do = new FWDUVPDisplayObject("div", "relative");
			_s.text_do.hasTransform3d_bl = false;
			_s.text_do.hasTransform2d_bl = false;
			_s.text_do.getStyle().fontFamily = "Arial";
			_s.text_do.getStyle().fontSize= "12px";
			_s.text_do.getStyle().fontSmoothing = "antialiased";
			_s.text_do.getStyle().webkitFontSmoothing = "antialiased";
			_s.text_do.getStyle().textRendering = "optimizeLegibility";

			//setup close button
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.clsBtn = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-close'></span></div>",
						undefined,
						"UVPCloseButtonNormalState",
						"UVPCloseButtonSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.clsBtn = new FWDUVPSimpleButton(_d.infoWindowClooseN_img, _d.embedWindowClosePathS_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						_d.sBC,
						false, false, false, false, true);
			}
			_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
			
			_s.mainHld.addChild(_s.mainBk_do);
			_s.mainTextHolder_do.addChild(_s.bk_do);
			_s.mainTextHolder_do.addChild(_s.text_do);	
			_s.mainHld.addChild(_s.mainTextHolder_do);
			_s.addChild(_s.mainHld);

			_s.mainHld.addChild(_s.clsBtn); 
		};
	
		_s.closeButtonOnMouseUpHandler = function(){
			if(!_s.isShowed_bl) return;
			_s.hide();
		};
		
		_s.positionAndResize = function(){
		
			_s.sW = prt.sW;
			_s.sH = prt.sH;
			
			_s.maxTextWidth = Math.min(_s.sW - 150, 500);
			_s.totalWidth = _s.maxTextWidth + _s.buttonWidth + 40;
			
			_s.positionFinal();
			
			_s.clsBtn.setX(_s.sW - _s.clsBtn.w - _s.embedWindowCloseButtonMargins);
			_s.clsBtn.setY(_s.embedWindowCloseButtonMargins);
			
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH);
			_s.mainHld.setWidth(_s.sW);
			_s.mainHld.setHeight(_s.sH);
		};
		
		_s.positionFinal = function(){
			var totalHeight;
			var isEmbeddedAndFScreenOnIE11Bug_bl = false;
			_s.mainTextHolder_do.setWidth(_s.totalWidth);
			
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				totalHeight = Math.round(_s.mainTextHolder_do.screen.getBoundingClientRect().height * 100);
			}else{
				totalHeight = _s.mainTextHolder_do.getHeight();
			}
			
			_s.bk_do.setWidth(_s.totalWidth - 2);
			_s.bk_do.setHeight(totalHeight - 2);
			
			_s.mainTextHolder_do.setX(parseInt((_s.sW - _s.totalWidth)/2));
			_s.mainTextHolder_do.setY(parseInt((_s.sH - totalHeight)/2) - 8);
		};

		
		//###########################################//
		/* show / hide */
		//###########################################//
		_s.show = function(videoDesc){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;
			prt.main_do.addChild(_s);
			_s.text_do.setInnerHTML(videoDesc);
		
			_s.positionAndResize();
			
			clearTimeout(_s.hideCompleteId_to);
			clearTimeout(_s.showCompleteId_to);
			_s.mainHld.setY(- _s.sH);
			
			_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 900);
			setTimeout(function(){
				FWDAnimation.to(_s.mainHld, .8, {y:0, delay:.1, ease:Expo.easeInOut});
			}, 100);
		};
		
		_s.showCompleteHandler = function(){};
		
		_s.hide = function(){
			if(!_s.isShowed_bl) return;
			_s.isShowed_bl = false;
			
			if(prt.customContextMenu_do) prt.customContextMenu_do.enable();
			_s.positionAndResize();
			
			clearTimeout(_s.hideCompleteId_to);
			clearTimeout(_s.showCompleteId_to);
			
			_s.hideCompleteId_to = setTimeout(_s.hideCompleteHandler, 800);
			FWDAnimation.killTweensOf(_s.mainHld);
			FWDAnimation.to(_s.mainHld, .8, {y:-_s.sH, ease:Expo.easeInOut});
		};
		
		_s.hideCompleteHandler = function(){
			prt.main_do.removeChild(_s);
			_s.dispatchEvent(FWDUVPInfoWindow.HIDE_COMPLETE);
		};
	
		_s.init();
	};
	
		
	/* set prototype */
	FWDUVPInfoWindow.setPrototype = function(){
		FWDUVPInfoWindow.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPInfoWindow.ERROR = "error";
	FWDUVPInfoWindow.HIDE_COMPLETE = "hideComplete";
	
	FWDUVPInfoWindow.prototype = null;
	window.FWDUVPInfoWindow = FWDUVPInfoWindow;
}(window));