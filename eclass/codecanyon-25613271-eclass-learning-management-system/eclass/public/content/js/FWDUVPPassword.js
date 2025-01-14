/**
 * Ultimate Video Player PACKAGED v9.1
 * Password window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPPassword = function(_d, prt, lg){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPPassword.prototype;
			
		_s.passColoseN_img = _d.passColoseN_img;
		_s.privateVideoPassword_str = _d.privateVideoPassword_str;
		_s.embedWindowBackground_str = _d.embedWindowBackground_str;
		
		_s.secondaryLabelsColor_str = _d.secondaryLabelsColor_str;
		_s.inputColor_str = _d.inputColor_str;
		_s.mainLabelsColor_str = _d.mainLabelsColor_str;
		_s.passButtonNPath_str = _d.passButtonNPath_str;
		_s.passButtonSPath_str = _d.passButtonSPath_str;
		_s.inputBackgroundColor_str = _d.inputBackgroundColor_str;
		_s.borderColor_str = _d.borderColor_str;
		
		_s.maxTextWidth = 0;
		_s.totalWidth = 0;
		_s.sW = 0;
		_s.sH = 0;
		_s.buttonWidth = 28;
		_s.buttonHeight = 19;
		_s.embedWindowCloseButtonMargins = _d.embedWindowCloseButtonMargins;
		_s.finalEmbedPath_str = null;
		
		_s.useVectorIcons_bl = _d.useVectorIcons_bl;
		_s.isMobile_bl = FWDUVPUtils.isMobile;

	
		//#################################//
		/* init */
		//#################################//
		_s.init = function(){
			if(_s.clsBtn) return;
			_s.setBackfaceVisibility();
			_s.mainHld = new FWDUVPDisplayObject("div");
			_s.mainHld.hasTransform3d_bl = false;
			_s.mainHld.hasTransform2d_bl = false;
			_s.mainHld.setBackfaceVisibility();
			
			_s.bk_do = new FWDUVPDisplayObject("div");
			_s.bk_do.getStyle().width = "100%";
			_s.bk_do.getStyle().height = "100%";
			_s.bk_do.setAlpha(.9);
			_s.bk_do.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
		
			_s.passMainHolder_do =  new FWDUVPDisplayObject("div");
			
			_s.passMainHldBk = new FWDUVPDisplayObject("div");
			_s.passMainHldBk.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
			_s.passMainHldBk.getStyle().borderStyle = "solid";
			_s.passMainHldBk.getStyle().borderWidth = "1px";
			_s.passMainHldBk.getStyle().borderColor =  _s.borderColor_str;
			
			_s.passMainLabel_do = new FWDUVPDisplayObject("div");
			_s.passMainLabel_do.screen.className = 'UVP-main-label';
			_s.passMainLabel_do.setBackfaceVisibility();
			_s.passMainLabel_do.screen.className = 'fwdeap-main-label'
			_s.passMainLabel_do.getStyle().fontFamily = "Arial";
			_s.passMainLabel_do.getStyle().fontSize= "12px";
			_s.passMainLabel_do.getStyle().color = _s.mainLabelsColor_str;
			_s.passMainLabel_do.getStyle().whiteSpace= "nowrap";
			_s.passMainLabel_do.getStyle().padding = "0px";
			_s.passMainLabel_do.setInnerHTML("PRIVATE VIDEO");	
			
			_s.passLabel_do = new FWDUVPDisplayObject("div");
			_s.passMainLabel_do.screen.className = 'UVP-main-label';
			_s.passLabel_do.setBackfaceVisibility();
			_s.passLabel_do.screen.className = 'fwdeap-label';
			_s.passLabel_do.getStyle().fontFamily = "Arial";
			_s.passLabel_do.getStyle().fontSize= "12px";
			_s.passLabel_do.getStyle().color = _s.secondaryLabelsColor_str;
			_s.passLabel_do.getStyle().whiteSpace= "nowrap";
	
			_s.passLabel_do.getStyle().padding = "0px";
			_s.passLabel_do.setInnerHTML("Please enter password:");
			
			_s.passInput_do = new FWDUVPDisplayObject("input");
			_s.passInput_do.screen.className = 'UVP-embed-inpt';
			_s.passInput_do.setBackfaceVisibility();
			_s.passInput_do.getStyle().fontFamily = "Arial";
			_s.passInput_do.getStyle().fontSize= "12px";
			_s.passInput_do.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.passInput_do.getStyle().color = _s.inputColor_str;
			_s.passInput_do.getStyle().outline = 0;
			_s.passInput_do.getStyle().whiteSpace= "nowrap";
			_s.passInput_do.getStyle().padding = "6px";
			_s.passInput_do.getStyle().paddingTop = "4px";
			_s.passInput_do.getStyle().paddingBottom = "4px";
			_s.passInput_do.screen.setAttribute("type", "password");
			
			if(!lg){
				FWDUVPSimpleSizeButton.setPrototype();
				_s.passBtn = new FWDUVPSimpleSizeButton(
						_s.passButtonNPath_str, 
						_s.passButtonSPath_str,
						_s.buttonWidth,
						_s.buttonHeight,
						_d.useHEX,
						_d.nBC,
						_d.sBC,
						true
						);
				_s.passBtn.getStyle().position = 'absolute';
				_s.passMainLabel_do.screen.className = 'fwduvp-ok-button';
				_s.passBtn.addListener(FWDUVPSimpleSizeButton.CLICK, _s.passClickHandler);
			
				//setup close button
				FWDUVPSimpleButton.setPrototype();
				if(_s.useVectorIcons_bl){
					_s.clsBtn = new FWDUVPSimpleButton(
							0, 0, 0, true, 0, 0, 0,
							"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-close'></span></div>",
							undefined,
							"UVPCloseButtonNormalState",
							"UVPCloseButtonSelectedState"
					);
					_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
					_s.mainHld.addChild(_s.clsBtn); 
				
				}else{
					FWDUVPSimpleButton.setPrototype();
					_s.clsBtn = new FWDUVPSimpleButton(
						_s.passColoseN_img, 
						_d.embedWindowClosePathS_str, 
						0,
						true,
						_d.useHEX,
						_d.nBC,
						_d.sBC,
						0, 0, 0, 0, true);
				}
				_s.clsBtn.screen.className = 'fwduvp-close-button';
				_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
				
				_s.addChild(_s.mainHld);
				_s.mainHld.addChild(_s.bk_do);
				
				_s.passMainHolder_do.addChild(_s.passMainHldBk);
				_s.passMainHolder_do.addChild(_s.passMainLabel_do);
				_s.passMainHolder_do.addChild(_s.passLabel_do);
				_s.passMainHolder_do.addChild(_s.passInput_do);
				_s.passMainHolder_do.addChild(_s.passBtn);
				_s.mainHld.addChild(_s.passMainHolder_do);
				_s.mainHld.addChild(_s.clsBtn); 
			}else{
				_s.addChild(_s.mainHld);
				_s.mainHld.addChild(_s.bk_do);
				_s.mainHld.addChild(_s.passLabel_do);
				_s.passLabel_do.getStyle().whiteSpace = "normal";
				_s.passLabel_do.getStyle().width = "calc(100% - 40px)";
				_s.passLabel_do.getStyle().textAlign = 'center';
				_s.passLabel_do.setInnerHTML(_d.playIfLoggedInMessage);

				var clsn = 'fwduvp-loggedin-message-white';
				if(_d.isDark){
					clsn = 'fwduvp-loggedin-message-dark';
				}
				_s.passLabel_do.screen.className = clsn;
				_s.passLabel_do.setOverflow('visible');

				FWDUVPSimpleButton.setPrototype();
				if(_s.useVectorIcons_bl){
					_s.clsBtn = new FWDUVPSimpleButton(
							0, 0, 0, true, 0, 0, 0,
							"<div class='table-fwduvp-button'><span class='table-cell-fwduvp-button fwdicon-close'></span></div>",
							undefined,
							"UVPCloseButtonNormalState",
							"UVPCloseButtonSelectedState"
					);
					_s.clsBtn.screen.className = 'fwduvp-close-button';
					_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
					_s.mainHld.addChild(_s.clsBtn); 
				}else{

					var clsNImg = new Image();
					clsNImg.src = _s.passColoseN_img.src;
					clsNImg.onload = function(){
						//setup close button.
						FWDUVPSimpleButton.setPrototype();
						_s.clsBtn = new FWDUVPSimpleButton(
								clsNImg, 
								_d.embedWindowClosePathS_str, 
								undefined,
								true,
								_d.useHEX,
								_d.nBC,
								_d.sBC, 
								0, 0, 0, 0, true);
						_s.clsBtn.screen.className = 'fwduvp-close-button';
						_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
						_s.mainHld.addChild(_s.clsBtn); 
						clsNImg.onload = null;
						_s.posClsBtn();
					}
				}
			}		

			_s.posClsBtn();
		};
	
		_s.closeButtonOnMouseUpHandler = function(){
			if(!_s.isShowed_bl) return;
			_s.hide();
		};
		
	
		function selectText(){
			if(window.top != window && FWDUVPUtils.isIE) return;
			var range, selection;
			if (document.body.createTextRange) {
				range = document.body.createTextRange();
			    range.moveToElementText(this);
			    range.select();
			}else if(window.getSelection && document.createRange) {
			    selection = window.getSelection();
			    range = document.createRange();
			    range.selectNodeContents(this);
			    selection.removeAllRanges();
			    selection.addRange(range);
			}
		};
		
		_s.positionAndResize = function(){
			_s.sW = prt.sW;
			_s.sH = prt.sH;
			
			_s.maxTextWidth = Math.min(_s.sW - 150, 300);
			_s.totalWidth = _s.maxTextWidth + _s.buttonWidth;
			
			_s.positionFinal();
			
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH);
			_s.mainHld.setWidth(_s.sW);
			_s.mainHld.setHeight(_s.sH);
		};

		_s.posClsBtn = function(){
			if(_s.clsBtn){
				_s.clsBtn.getStyle().left = 'auto';
				_s.clsBtn.getStyle().right = _s.embedWindowCloseButtonMargins + 'px';
				_s.clsBtn.getStyle().top = _s.embedWindowCloseButtonMargins + 'px';
			}
		}

		_s.positionFinal = function(){			
			var totalHeight;
			var textLableHeight = _s.passLabel_do.getHeight();
			var passMainLabelHeight;
			
			passMainLabelHeight = _s.passMainLabel_do.getHeight();

			if(!lg){
				_s.passMainLabel_do.setX(14);
				_s.passLabel_do.setX(14);
				_s.passLabel_do.setY(passMainLabelHeight + 14);
				
				_s.passInput_do.setX(10);
				_s.passInput_do.setWidth(parseInt(_s.totalWidth - 40 - _s.buttonWidth));
				_s.passInput_do.setY(_s.passLabel_do.y + textLableHeight + 5);
				_s.passBtn.setX(10 + _s.passInput_do.w + 20);
				_s.passBtn.setY(_s.passLabel_do.y + textLableHeight + 7);
				
				_s.passMainHldBk.setY(_s.passLabel_do.y - 9);
				_s.passMainHldBk.setWidth(_s.totalWidth - 2);
				_s.passMainHldBk.setHeight(_s.passBtn.y + _s.passBtn.h - 9);
				_s.passMainHolder_do.setWidth(_s.totalWidth);
				_s.passMainHolder_do.setHeight(_s.passBtn.y + _s.passBtn.h + 14);

				_s.passMainHolder_do.setX(Math.round((_s.sW - _s.totalWidth)/2));
				totalHeight = _s.passMainHldBk.getHeight();
				_s.passMainHolder_do.setY(Math.round((_s.sH - totalHeight)/2) - 10);
			}else{
				_s.passLabel_do.setX(Math.round((_s.sW - _s.passLabel_do.getWidth())/2));
				_s.passLabel_do.setY(Math.round((_s.sH - _s.passLabel_do.getHeight())/2));
			}
		};

		
		//##############################################//
		/* Send email */
		//##############################################//
		_s.passClickHandler = function(){
			
			var allow = true;
			var vidPass = prt._d.playlist_ar[prt.id]['privateVideoPassword_str'];
			var playlistPass = prt.playlistPass;

			if(playlistPass){
				if(playlistPass != FWDUVPUtils.MD5(_s.passInput_do.screen.value)){
					allow = false;
				}else{
					prt.plPassPassed = true;
				}
			}else if(vidPass){
				if(vidPass != FWDUVPUtils.MD5(_s.passInput_do.screen.value)){
					allow = false;
				}
			}else{
				if(_s.privateVideoPassword_str != FWDUVPUtils.MD5(_s.passInput_do.screen.value)){
					allow = false;
				}
			}
			if(!allow){
				if(!FWDAnimation.isTweening(_s.passInput_do.screen)) FWDAnimation.to(_s.passInput_do.screen, .1, {css:{backgroundColor:'#FF0000'}, yoyo:true, repeat:3});
				return;
			}
		
			_s.dispatchEvent(FWDUVPPassword.CORRECT);
		};
		

		//##########################################//
		/* Update HEX color of a canvaas */
		//##########################################//
		_s.updateHEXColors = function(nBC, sBC){
			_s.passBtn.updateHEXColors(nBC, sBC);
			_s.clsBtn.updateHEXColors(nBC, sBC);
		}
		

		/* show hide info */
		//#########################################//
		_s.showInfo = function(text, hasError){
				
			_s.infoText_do.setInnerHTML(text);
			_s.passMainHolder_do.addChild(_s.infoText_do);
			_s.infoText_do.setWidth(_s.buttonWidth);
			_s.infoText_do.setHeight(_s.buttonHeight - 4);
			_s.infoText_do.setX(_s.passBtn.x);
			_s.infoText_do.setY(_s.passBtn.y - 23);

			_s.infoText_do.setAlpha(0);
			if(hasError){
				_s.infoText_do.getStyle().color = "#FF0000";
			}else{
				_s.infoText_do.getStyle().color = _s.mainLabelsColor_str;
			}
			FWDAnimation.killTweensOf(_s.infoText_do);
			FWDAnimation.to(_s.infoText_do, .16, {alpha:1, yoyo:true, repeat:7});
		};

		
		//###########################################//
		/* show / hide */
		//###########################################//
		_s.show = function(id){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;
			prt.main_do.addChild(_s);
			_s.init();
			
			if(_s.passBtn){
				_s.passBtn.setSelectedState();
				_s.passInput_do.setInnerHTML("");
			}
			if(!FWDUVPUtils.isMobile || (FWDUVPUtils.isMobile && FWDUVPUtils.hasPointerEvent)) prt.main_do.setSelectable(true);
			_s.positionAndResize();
			
			clearTimeout(_s.hideCompleteId_to);
			clearTimeout(_s.showCompleteId_to);
			_s.mainHld.setY(- _s.sH);
			if(_s.passBtn){
				_s.passBtn.setNormalState();
			}
			_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 900);
			setTimeout(function(){
				_s.positionAndResize();
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
			
			if(!FWDUVPUtils.isMobile || (FWDUVPUtils.isMobile && FWDUVPUtils.hasPointerEvent)) prt.main_do.setSelectable(false);
			_s.hideCompleteId_to = setTimeout(_s.hideCompleteHandler, 800);
			FWDAnimation.killTweensOf(_s.mainHld);
			FWDAnimation.to(_s.mainHld, .8, {y:-_s.sH, ease:Expo.easeInOut});
		};
		
		_s.hideCompleteHandler = function(){
			prt.main_do.removeChild(_s);
			_s.dispatchEvent(FWDUVPPassword.HIDE_COMPLETE);
		};
	
		if(_d.useHEX){
			_s.init();
		}
	};
	
		
	/* set prototype */
	FWDUVPPassword.setPrototype = function(){
		FWDUVPPassword.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPPassword.ERROR = "error";
	FWDUVPPassword.CORRECT = "correct";
	FWDUVPPassword.HIDE_COMPLETE = "hideComplete";
	
	FWDUVPPassword.prototype = null;
	window.FWDUVPPassword = FWDUVPPassword;
}(window));