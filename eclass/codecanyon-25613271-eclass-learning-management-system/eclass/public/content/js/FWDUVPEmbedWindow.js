/**
 * Easy Video Player PACKAGED v8.4
 * Embed window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPEmbedWindow = function(_d, prt){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPEmbedWindow.prototype;
		
		_s.embedColoseN_img = _d.embedColoseN_img;	
		_s.useHEX = _d.useHEX;
		_s.nBC = _d.nBC
		_s.sBC = _d.sBC;

		_s.embedWindowBackground_str = _d.embedWindowBackground_str;
		_s.embedWindowInputBackgroundPath_str = _d.embedWindowInputBackgroundPath_str;
		_s.secondaryLabelsColor_str = _d.secondaryLabelsColor_str;
		_s.inputColor_str = _d.inputColor_str;
		_s.mainLabelsColor_str = _d.mainLabelsColor_str;
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

		_s.isMbl = FWDUVPUtils.isMobile;
		_s.useVectorIcons_bl = _d.useVectorIcons_bl
	

		//#################################//
		/* init */
		//#################################//
		_s.init = function(){
			if(_s.clsBtn) return;
			if(_d.sknPth.indexOf("hex_white") != -1){
				_s.sBC = "#FFFFFF";
			} 
		
			_s.setBackfaceVisibility();
			_s.mainHld = new FWDUVPDisplayObject("div");
			
			_s.bk_do = new FWDUVPDisplayObject("div");
			_s.bk_do.getStyle().width = "100%";
			_s.bk_do.getStyle().height = "100%";
			_s.bk_do.setAlpha(.9);
			_s.bk_do.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
		
			//setup link and embed text
			_s.linkAndEmbedHld =  new FWDUVPDisplayObject("div");
			
			_s.lnkAndEbdHldBk = new FWDUVPDisplayObject("div");
			_s.lnkAndEbdHldBk.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
			_s.lnkAndEbdHldBk.getStyle().borderStyle = "solid";
			_s.lnkAndEbdHldBk.getStyle().borderWidth = "1px";
			_s.lnkAndEbdHldBk.getStyle().borderColor =  _s.borderColor_str;
			
			_s.mainLbl = new FWDUVPDisplayObject("div");
			_s.mainLbl.setBackfaceVisibility();
			_s.mainLbl.getStyle().fontFamily = "Arial";
			_s.mainLbl.getStyle().fontSize= "12px";
			_s.mainLbl.getStyle().color = _s.mainLabelsColor_str;
			_s.mainLbl.getStyle().whiteSpace= "nowrap";
			_s.mainLbl.getStyle().fontSmoothing = "antialiased";
			_s.mainLbl.getStyle().webkitFontSmoothing = "antialiased";
			_s.mainLbl.getStyle().textRendering = "optimizeLegibility";
			_s.mainLbl.getStyle().padding = "0px";
			_s.mainLbl.screen.className = 'UVP-main-label';
			_s.mainLbl.setInnerHTML("SHARE & EMBED");	
			
			_s.linkLbl = new FWDUVPDisplayObject("div");
			_s.linkLbl.screen.className = 'UVP-secnd-label';
			_s.linkLbl.setBackfaceVisibility();
			_s.linkLbl.getStyle().fontFamily = "Arial";
			_s.linkLbl.getStyle().fontSize= "12px";
			_s.linkLbl.getStyle().color = _s.secondaryLabelsColor_str;
			_s.linkLbl.getStyle().whiteSpace= "nowrap";
			_s.linkLbl.getStyle().fontSmoothing = "antialiased";
			_s.linkLbl.getStyle().webkitFontSmoothing = "antialiased";
			_s.linkLbl.getStyle().textRendering = "optimizeLegibility";
			_s.linkLbl.getStyle().padding = "0px";
			_s.linkLbl.setInnerHTML("Link to _s video:");	
			
			_s.linkTxt = new FWDUVPDisplayObject("div");
			_s.linkTxt.screen.className = 'UVP-embed-inpt';
			_s.linkTxt.setBackfaceVisibility();
			_s.linkTxt.getStyle().fontFamily = "Arial";
			_s.linkTxt.getStyle().fontSize= "12px";
			_s.linkTxt.getStyle().color = _s.shareAndEmbedTextColor_str;
			if(!FWDUVPUtils.isIEAndLessThen9) _s.linkTxt.getStyle().wordBreak = "break-all";
			_s.linkTxt.getStyle().fontSmoothing = "antialiased";
			_s.linkTxt.getStyle().webkitFontSmoothing = "antialiased";
			_s.linkTxt.getStyle().textRendering = "optimizeLegibility";
			_s.linkTxt.getStyle().padding = "6px";
			_s.linkTxt.getStyle().paddingTop = "4px";
			_s.linkTxt.getStyle().paddingBottom = "4px";
			_s.linkTxt.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.linkTxt.screen.addEventListener('touchstart',function(){
				selectText(_s.linkTxt.screen);
			});
			
			_s.embedLbl = new FWDUVPDisplayObject("div");
			_s.embedLbl.setBackfaceVisibility();
			_s.embedLbl.screen.className = 'UVP-secnd-label';
			_s.embedLbl.getStyle().fontFamily = "Arial";
			_s.embedLbl.getStyle().fontSize= "12px";
			_s.embedLbl.getStyle().color = _s.secondaryLabelsColor_str;
			_s.embedLbl.getStyle().whiteSpace= "nowrap";
			_s.embedLbl.getStyle().fontSmoothing = "antialiased";
			_s.embedLbl.getStyle().webkitFontSmoothing = "antialiased";
			_s.embedLbl.getStyle().textRendering = "optimizeLegibility";
			_s.embedLbl.getStyle().padding = "0px";
			_s.embedLbl.setInnerHTML("Embed _s video:");
			
			_s.embdTxt = new FWDUVPDisplayObject("div");
			_s.embdTxt.screen.className = 'UVP-embed-inpt';
			_s.embdTxt.setBackfaceVisibility();
			if(!FWDUVPUtils.isIEAndLessThen9) _s.embdTxt.getStyle().wordBreak = "break-all";
			_s.embdTxt.getStyle().fontFamily = "Arial";
			_s.embdTxt.getStyle().fontSize= "12px";
			_s.embdTxt.getStyle().lineHeight = "16px";
			_s.embdTxt.getStyle().color = _s.shareAndEmbedTextColor_str;
			_s.embdTxt.getStyle().fontSmoothing = "antialiased";
			_s.embdTxt.getStyle().webkitFontSmoothing = "antialiased";
			_s.embdTxt.getStyle().textRendering = "optimizeLegibility";
			_s.embdTxt.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.embdTxt.getStyle().padding = "6px";
			_s.embdTxt.getStyle().paddingTop = "4px";
			_s.embdTxt.getStyle().paddingBottom = "4px";
			_s.embdTxt.screen.addEventListener('touchstart',function(){
				selectText(_s.embdTxt.screen);
			});
		
			//setup flash buttons
			FWDUVPSimpleSizeButton.setPrototype();
			_s.copyLinkBtn = new FWDUVPSimpleSizeButton(
					_d.embedCopyButtonNPath_str,
					_d.embedCopyButtonSPath_str,
					_s.buttonWidth,
					_s.buttonHeight,
					_d.useHEX,
					_d.nBC,
					_d.sBC,
					true
			);
			_s.copyLinkBtn.screen.style.position = 'absolute';
			_s.copyLinkBtn.addListener(FWDUVPSimpleSizeButton.CLICK, function(){
				_s.copyToClipboard(_s.linkTxt.screen);
			});

			FWDUVPSimpleSizeButton.setPrototype();
			_s.copyEmbedBtn = new FWDUVPSimpleSizeButton(
					_d.embedCopyButtonNPath_str,
					_d.embedCopyButtonSPath_str,
					_s.buttonWidth,
					_s.buttonHeight,
					_d.useHEX,
					_d.nBC,
					_d.sBC,
					true
			);
			
			_s.copyEmbedBtn.screen.style.position = 'absolute';
			_s.copyEmbedBtn.addListener(FWDUVPSimpleSizeButton.CLICK,function(){
				_s.copyToClipboard(_s.embdTxt.screen);
			});

			//setup send to a friend
			_s.sendMainHld =  new FWDUVPDisplayObject("div");
			
			_s.sendMainHldBk = new FWDUVPDisplayObject("div");
			_s.sendMainHldBk.getStyle().background = "url('" + _s.embedWindowBackground_str + "')";
			_s.sendMainHldBk.getStyle().borderStyle = "solid";
			_s.sendMainHldBk.getStyle().borderWidth = "1px";
			_s.sendMainHldBk.getStyle().borderColor =  _s.borderColor_str;
			
			_s.sendMainLbl = new FWDUVPDisplayObject("div");
			_s.sendMainLbl.setBackfaceVisibility();
			_s.sendMainLbl.getStyle().fontFamily = "Arial";
			_s.sendMainLbl.getStyle().fontSize= "12px";
			_s.sendMainLbl.getStyle().color = _s.mainLabelsColor_str;
			_s.sendMainLbl.getStyle().whiteSpace= "nowrap";
			_s.sendMainLbl.getStyle().fontSmoothing = "antialiased";
			_s.sendMainLbl.getStyle().webkitFontSmoothing = "antialiased";
			_s.sendMainLbl.getStyle().textRendering = "optimizeLegibility";
			_s.sendMainLbl.getStyle().padding = "0px";
			_s.sendMainLbl.screen.className = 'UVP-main-label';
			_s.sendMainLbl.setInnerHTML("SEND TO A FRIEND");	
			
			_s.yourEmailLabel_do = new FWDUVPDisplayObject("div");
			_s.yourEmailLabel_do.setBackfaceVisibility();
			_s.yourEmailLabel_do.screen.className = 'UVP-secnd-label';
			_s.yourEmailLabel_do.getStyle().fontFamily = "Arial";
			_s.yourEmailLabel_do.getStyle().fontSize= "12px";
			_s.yourEmailLabel_do.getStyle().color = _s.secondaryLabelsColor_str;
			_s.yourEmailLabel_do.getStyle().whiteSpace= "nowrap";
			_s.yourEmailLabel_do.getStyle().padding = "0px";
			_s.yourEmailLabel_do.setInnerHTML("Your email:");
			
			_s.yourEmailInpt = new FWDUVPDisplayObject("input");
			_s.yourEmailInpt.screen.className = 'UVP-embed-inpt';
			_s.yourEmailInpt.setBackfaceVisibility();
			_s.yourEmailInpt.getStyle().fontFamily = "Arial";
			_s.yourEmailInpt.getStyle().fontSize= "12px";
			_s.yourEmailInpt.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.yourEmailInpt.getStyle().color = _s.inputColor_str;
			_s.yourEmailInpt.getStyle().outline = 0;
			_s.yourEmailInpt.getStyle().whiteSpace= "nowrap";
			_s.yourEmailInpt.getStyle().padding = "6px";
			_s.yourEmailInpt.getStyle().paddingTop = "4px";
			_s.yourEmailInpt.getStyle().paddingBottom = "4px";
			
			_s.friendEmailLbl = new FWDUVPDisplayObject("div");
			_s.friendEmailLbl.setBackfaceVisibility();
			_s.friendEmailLbl.screen.className = 'UVP-secnd-label';
			_s.friendEmailLbl.getStyle().fontFamily = "Arial";
			_s.friendEmailLbl.getStyle().fontSize= "12px";
			_s.friendEmailLbl.getStyle().color = _s.secondaryLabelsColor_str;
			_s.friendEmailLbl.getStyle().whiteSpace= "nowrap";
			_s.friendEmailLbl.getStyle().padding = "0px";
			_s.friendEmailLbl.setInnerHTML("Your friend's email:");
			
			_s.friendEmailInpt = new FWDUVPDisplayObject("input");
			_s.friendEmailInpt.screen.className = 'UVP-embed-inpt';
			_s.friendEmailInpt.setBackfaceVisibility();
			_s.friendEmailInpt.getStyle().fontFamily = "Arial";
			_s.friendEmailInpt.getStyle().fontSize= "12px";
			_s.friendEmailInpt.getStyle().backgroundColor = _s.inputBackgroundColor_str;
			_s.friendEmailInpt.getStyle().color = _s.inputColor_str;
			_s.friendEmailInpt.getStyle().outline= 0;
			_s.friendEmailInpt.getStyle().whiteSpace= "nowrap";
			_s.friendEmailInpt.getStyle().padding = "6px";
			_s.friendEmailInpt.getStyle().paddingTop = "4px";
			_s.friendEmailInpt.getStyle().paddingBottom = "4px";	

			FWDUVPSimpleSizeButton.setPrototype();
			_s.sndBtn = new FWDUVPSimpleSizeButton(
					_s.sendButtonNPath_str, 
					_s.sendButtonSPath_str,
					_s.buttonWidth,
					_s.buttonHeight,
					_s.useHEX,
					_d.nBC,
					_d.sBC,
					true);
			_s.sndBtn.addListener(FWDUVPSimpleSizeButton.MOUSE_UP, _s.sendClickHandler);
			
		
			_s.infoText_do = new FWDUVPDisplayObject("div");
			_s.infoText_do.setBackfaceVisibility();
			_s.infoText_do.getStyle().fontFamily = "Arial";
			_s.infoText_do.getStyle().fontSize= "12px";
			_s.infoText_do.getStyle().color = _s.secondaryLabelsColor_str;
			_s.infoText_do.getStyle().whiteSpace= "nowrap";
			_s.infoText_do.getStyle().fontSmoothing = "antialiased";
			_s.infoText_do.getStyle().webkitFontSmoothing = "antialiased";
			_s.infoText_do.getStyle().textRendering = "optimizeLegibility";
			_s.infoText_do.getStyle().padding = "0px";
			_s.infoText_do.getStyle().paddingTop = "4px";
			_s.infoText_do.getStyle().textAlign = "center";
			_s.infoText_do.getStyle().color = _s.mainLabelsColor_str;
			
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
				_s.clsBtn = new FWDUVPSimpleButton(_d.embedColoseN_img, _d.embedWindowClosePathS_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						_d.sBC,
						false, false, false, false, true);
			}
			_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
			
			_s.addChild(_s.mainHld);
			_s.mainHld.addChild(_s.bk_do)
			
			_s.linkAndEmbedHld.addChild(_s.lnkAndEbdHldBk);
			_s.linkAndEmbedHld.addChild(_s.mainLbl);
			_s.linkAndEmbedHld.addChild(_s.linkLbl);
			_s.linkAndEmbedHld.addChild(_s.linkTxt);
			_s.linkAndEmbedHld.addChild(_s.embedLbl);
			_s.linkAndEmbedHld.addChild(_s.embdTxt);
			_s.linkAndEmbedHld.addChild(_s.copyLinkBtn);
			_s.linkAndEmbedHld.addChild(_s.copyEmbedBtn);
			
			_s.sendMainHld.addChild(_s.sendMainHldBk);
			_s.sendMainHld.addChild(_s.sendMainLbl);
			_s.sendMainHld.addChild(_s.yourEmailLabel_do);
			_s.sendMainHld.addChild(_s.yourEmailInpt);
			_s.sendMainHld.addChild(_s.friendEmailLbl);
			_s.sendMainHld.addChild(_s.friendEmailInpt);
			_s.sendMainHld.addChild(_s.sndBtn);
			
			_s.mainHld.addChild(_s.linkAndEmbedHld);
			_s.mainHld.addChild(_s.sendMainHld);
			
			_s.mainHld.addChild(_s.clsBtn); 
		};
	
		_s.closeButtonOnMouseUpHandler = function(){
			if(!_s.isShowed_bl) return;
			_s.hide();
		};
	
		_s.copyToClipboard = function(element){
			  selectText(element);
			  document.execCommand("copy");
		}
	
		function selectText(element){
			if(window.top != window && FWDEVPUtils.isIE) return;
			if(!element) element = _s;
			
			var range, selection;
			if (document.body.createTextRange) {
				range = document.body.createTextRange();
			    range.moveToElementText(element);
			    range.select();
			}else if(window.getSelection && document.createRange) {
			    selection = window.getSelection();
			    range = document.createRange();
			    range.selectNodeContents(element);
			    selection.removeAllRanges();
			    selection.addRange(range);
			}
		};
		
		_s.positionAndResize = function(){
			_s.sW = prt.sW;
			_s.sH = prt.sH;
			
			_s.maxTextWidth = Math.min(_s.sW - 150, 500);
			_s.totalWidth = _s.maxTextWidth + _s.buttonWidth + 40;
			
			if(_s.isMbl){
				_s.linkTxt.setWidth(_s.maxTextWidth + 52);
				_s.embdTxt.setWidth(_s.maxTextWidth + 52);
			}else{
				_s.linkTxt.setWidth(_s.maxTextWidth);
				_s.embdTxt.setWidth(_s.maxTextWidth);
			}
			
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
			
			if(_s.sH < 360 || _s.sW < 350){
				_s.linkTxt.getStyle().whiteSpace= "nowrap";
				_s.embdTxt.getStyle().whiteSpace= "nowrap";
			}else{
				_s.linkTxt.getStyle().whiteSpace = "normal";
				_s.embdTxt.getStyle().whiteSpace= "normal";
			}
			
			if(_s.linkLbl.screen.offsetHeight < 6) isEmbeddedAndFScreenOnIE11Bug_bl = true;
			
			var embedAndLinkMainLabelHeight;
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				embedAndLinkMainLabelHeight = Math.round(_s.mainLbl.screen.getBoundingClientRect().height * 100);
			}else{
				embedAndLinkMainLabelHeight = _s.mainLbl.getHeight();
			}
			_s.mainLbl.setX(16);
			_s.linkLbl.setX(16);
			_s.linkLbl.setY(embedAndLinkMainLabelHeight + 14);
			
			var linkTextLabelHeight;
			var linkTextHeight;
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				linkTextLabelHeight = Math.round(_s.linkLbl.screen.getBoundingClientRect().height * 100);
				linkTextHeight = Math.round(_s.linkTxt.screen.getBoundingClientRect().height * 100);
			}else{
				linkTextLabelHeight = _s.linkLbl.getHeight();
				linkTextHeight = _s.linkTxt.getHeight();
			}
			
			_s.linkTxt.setX(10);
			_s.linkTxt.setY(_s.linkLbl.y + linkTextLabelHeight + 5);
			if(_s.isMbl){
				_s.copyLinkBtn.setX(-100);
			}else{
				_s.copyLinkBtn.setX(_s.maxTextWidth + 30);
			}
			
			_s.copyLinkBtn.setY(_s.linkTxt.y + linkTextHeight - _s.buttonHeight);
			_s.embedLbl.setX(16);
			_s.embedLbl.setY(_s.copyLinkBtn.y + _s.copyLinkBtn.h + 14);
			
			var embedTextHeight;
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				embedTextHeight = Math.round(_s.embdTxt.screen.getBoundingClientRect().height * 100);
			}else{
				embedTextHeight = _s.embdTxt.getHeight();
			}
			_s.embdTxt.setX(10);
			_s.embdTxt.setY(_s.embedLbl.y + linkTextLabelHeight + 5);
			if(_s.isMbl){
				_s.copyEmbedBtn.setX(-100);
			}else{
				_s.copyEmbedBtn.setX(_s.maxTextWidth + 30);
			}
			_s.copyEmbedBtn.setY(_s.embdTxt.y + embedTextHeight - _s.buttonHeight);
			_s.lnkAndEbdHldBk.setY(_s.linkLbl.y - 9);
			_s.lnkAndEbdHldBk.setWidth(_s.totalWidth - 2);
			_s.lnkAndEbdHldBk.setHeight(_s.embdTxt.y + embedTextHeight - 9);
			_s.linkAndEmbedHld.setWidth(_s.totalWidth);
			_s.linkAndEmbedHld.setHeight(_s.embdTxt.y + embedTextHeight + 14);
			
			var sendMainLabelHeight;
			var inputHeight;
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				sendMainLabelHeight = Math.round(_s.sendMainLbl.screen.getBoundingClientRect().height * 100);
				inputHeight = Math.round(_s.yourEmailInpt.screen.getBoundingClientRect().height * 100);
			}else{
				sendMainLabelHeight = _s.sendMainLbl.getHeight();
				inputHeight = _s.yourEmailInpt.getHeight();
			}
			_s.sendMainLbl.setX(16);
			_s.yourEmailLabel_do.setX(16);
			_s.yourEmailLabel_do.setY(sendMainLabelHeight + 14);
			
			if(_s.sW > 400){
				_s.yourEmailInpt.setX(10);
				_s.yourEmailInpt.setWidth(parseInt(_s.totalWidth - 52 - _s.buttonWidth)/2);
				_s.yourEmailInpt.setY(_s.yourEmailLabel_do.y + linkTextLabelHeight + 5);
				
				_s.friendEmailLbl.setX(_s.yourEmailInpt.x + _s.yourEmailInpt.w + 26);
				_s.friendEmailLbl.setY(_s.yourEmailLabel_do.y);
				_s.friendEmailInpt.setX(_s.yourEmailInpt.x + _s.yourEmailInpt.w + 20);
				_s.friendEmailInpt.setWidth(parseInt((_s.maxTextWidth - 30)/2));
				_s.friendEmailInpt.setY(_s.yourEmailLabel_do.y + linkTextLabelHeight + 5);
				_s.sndBtn.setX(_s.friendEmailInpt.x + _s.yourEmailInpt.w + 10);
				_s.sndBtn.setY(_s.friendEmailInpt.y +inputHeight - _s.buttonHeight);
			}else{
				_s.yourEmailInpt.setX(10);
				_s.yourEmailInpt.setWidth(_s.totalWidth -32);
				_s.yourEmailInpt.setY(_s.yourEmailLabel_do.y + linkTextLabelHeight + 5);
				
				_s.friendEmailLbl.setX(16);
				_s.friendEmailLbl.setY(_s.yourEmailInpt.y + inputHeight + 14);
				_s.friendEmailInpt.setX(10);
				_s.friendEmailInpt.setY(_s.friendEmailLbl.y + linkTextLabelHeight + 5);
				_s.friendEmailInpt.setWidth(_s.totalWidth - 32);
				
				_s.sndBtn.setX(_s.totalWidth - _s.buttonWidth - 10);
				_s.sndBtn.setY(_s.friendEmailInpt.y + inputHeight + 10);
			}
			
			_s.sendMainHldBk.setY(_s.yourEmailLabel_do.y - 9);
			_s.sendMainHldBk.setWidth(_s.totalWidth - 2);
			_s.sendMainHldBk.setHeight(_s.sndBtn.y + _s.sndBtn.h - 9);
			_s.sendMainHld.setWidth(_s.totalWidth);
			_s.sendMainHld.setHeight(_s.sndBtn.y + _s.sndBtn.h + 14);
			
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				totalHeight = Math.round(_s.linkAndEmbedHld.screen.getBoundingClientRect().height * 100 + _s.sendMainHld.screen.getBoundingClientRect().height * 100);
			}else{
				totalHeight = _s.linkAndEmbedHld.getHeight() + _s.sendMainHld.getHeight();
			}
			
			_s.linkAndEmbedHld.setX(parseInt((_s.sW - _s.totalWidth)/2));
			_s.linkAndEmbedHld.setY(parseInt((_s.sH - totalHeight)/2) - 8);
			_s.sendMainHld.setX(parseInt((_s.sW - _s.totalWidth)/2));
			if(isEmbeddedAndFScreenOnIE11Bug_bl){
				_s.sendMainHld.setY(Math.round(_s.linkAndEmbedHld.y + _s.linkAndEmbedHld.screen.getBoundingClientRect().height * 100 + 20));
			}else{
				_s.sendMainHld.setY(_s.linkAndEmbedHld.y + _s.linkAndEmbedHld.getHeight() + 20);
			}
		};
		
		//##############################################//
		/* Send email */
		//##############################################//
		_s.sendClickHandler = function(){
			var hasError_bl = false;
			if(!_s.getValidEmail(_s.yourEmailInpt.screen.value)){
				if(FWDAnimation.isTweening(_s.yourEmailInpt.screen)) return;
				FWDAnimation.to(_s.yourEmailInpt.screen, .1, {css:{backgroundColor:'#FF0000'}, yoyo:true, repeat:3});
				hasError_bl = true;
			}
			if(!_s.getValidEmail(_s.friendEmailInpt.screen.value)){
				if(FWDAnimation.isTweening(_s.friendEmailInpt.screen)) return;
				FWDAnimation.to(_s.friendEmailInpt.screen, .1, {css:{backgroundColor:'#FF0000'}, yoyo:true, repeat:3});
				hasError_bl = true;
			}
			if(hasError_bl) return;
			_s.sendEmail();
		};
		
		
		//############ send email ####################//
		_s.sendEmail = function(){
			if(_s.isSending_bl) return;
			_s.isSending_bl = true;
			_s.xhr = new XMLHttpRequest();
			_s.xhr.onreadystatechange = _s.onChange;
			_s.xhr.onerror = _s.ajaxOnErrorHandler;
			
			try{
				_s.xhr.open("get", _s.sendToAFriendPath_str + "?friendMail=" + _s.friendEmailInpt.screen.value + "&yourMail=" + _s.yourEmailInpt.screen.value + "&link=" + encodeURI(_s.linkToVideo_str) , true);
				_s.xhr.send();
			}catch(e){
				_s.showInfo("ERROR", true);
				if(console) console.log(e);
				if(e.message && window.console) console.log(e.message);
			}
			_s.resetInputs();
		};
		
		_s.ajaxOnErrorHandler = function(e){
			_s.showInfo("ERROR", true);
			try{
				if(window.console) console.log(e);
				if(window.console) console.log(e.message);
			}catch(e){};
			_s.isSending_bl = false;
		};
		
		_s.onChange = function(response){
			if(_s.xhr.readyState == 4 && _s.xhr.status == 200){
				if(_s.xhr.responseText == "sent"){
					_s.showInfo("SENT");
				}else{
					_s.showInfo("ERROR", true);
					if(window.console) console.log("Error The server can't send the email!");
				}
				_s.isSending_bl = false;
			}
		};
		
		_s.resetInputs = function(){
			_s.yourEmailInpt.screen.value = "";
			_s.friendEmailInpt.screen.value = "";
		};
	
		_s.getValidEmail = function(email){
			var emailRegExp = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			if(!emailRegExp.test(email) || email == "") return false;
			return true;
		};

		
		//#############################################//
		/* Set embed data */
		//#############################################//
		_s.setEmbedData = function(){
		
			var allUrl = location.href;
			var host = location.protocol + "//" + location.host;
			var pathName = location.pathname;
			var hash = location.hash;
			var search = location.search;
			var pathWithoutHashOrSearch = host + pathName;
			
		
			search = search.replace(/&?UVPInstanceName=.+UVPVideoId=[0-9]+/g, "");
			allUrl = allUrl.replace(/&?UVPInstanceName=.+UVPVideoId=[0-9]+/g, "");
		
			if(search){
				if(hash){
					_s.finalEmbedPath_str = pathWithoutHashOrSearch + search + "&UVPInstanceName=" + prt.instanceName_str + "&UVPPlaylistId=" + prt.catId + "&UVPVideoId=" + prt.id + hash;
				}else{
					_s.finalEmbedPath_str = pathWithoutHashOrSearch + search + "&UVPInstanceName=" + prt.instanceName_str + "&UVPPlaylistId=" + prt.catId + "&UVPVideoId=" + prt.id;
				}
			}else{
				if(hash){
					_s.finalEmbedPath_str = pathWithoutHashOrSearch + "?UVPInstanceName=" + prt.instanceName_str + "&UVPPlaylistId=" + prt.catId + "&UVPVideoId=" + prt.id + hash;
				}else{
					_s.finalEmbedPath_str = pathWithoutHashOrSearch + "?UVPInstanceName=" + prt.instanceName_str + "&UVPPlaylistId=" + prt.catId + "&UVPVideoId=" + prt.id;
				}
			}
			
			if(hash){
				if(hash.indexOf("playlistId=") == -1){
					_s.linkToVideo_str = pathWithoutHashOrSearch + search + hash + "&playlistId=" + prt.catId + "&videoId=" + prt.id;
				}else{
					_s.linkToVideo_str = allUrl;
				}
			}else{
				_s.linkToVideo_str = allUrl + "#/?playlistId=" + prt.catId + "&videoId=" + prt.id;;
			}
	
			_s.finalEmbedPath_str = encodeURI(_s.finalEmbedPath_str);
			_s.linkToVideo_str = encodeURI(_s.linkToVideo_str);	
			_s.finalEmbedCode_str = "<iframe src='" + _s.finalEmbedPath_str + "' width='" + prt.sW + "' height='" + prt.sH + "' frameborder='0' scrolling='no' allowfullscreen></iframe>";
		
			if(FWDUVPUtils.isIE){
				_s.linkTxt.screen.innerText = _s.linkToVideo_str;
				_s.embdTxt.screen.innerText = _s.finalEmbedCode_str;
			}else{
				_s.linkTxt.screen.textContent = _s.linkToVideo_str;
				_s.embdTxt.screen.textContent = _s.finalEmbedCode_str;
			}
		};	
		

		//#########################################//
		/* show hide info */
		//#########################################//
		_s.showInfo = function(text, hasError){
				
			_s.infoText_do.setInnerHTML(text);
			_s.sendMainHld.addChild(_s.infoText_do);
			_s.infoText_do.setWidth(_s.buttonWidth);
			_s.infoText_do.setHeight(_s.buttonHeight - 4);
			_s.infoText_do.setX(_s.sndBtn.x);
			_s.infoText_do.setY(_s.sndBtn.y - 23);

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
			
			_s.resetInputs();
			_s.setEmbedData();
			if(!FWDUVPUtils.isMobile || (FWDUVPUtils.isMobile && FWDUVPUtils.hasPointerEvent)) prt.main_do.setSelectable(true);
			
			if(_s.useVectorIcons_bl){
				_s.checkButtonsId_to = setInterval(function(){
					
					if(_s.clsBtn.w != 0){	
						_s.positionAndResize();
						
						clearInterval(_s.checkButtonsId_to);
						clearTimeout(_s.hideCompleteId_to);
						clearTimeout(_s.showCompleteId_to);
						_s.mainHld.setY(- _s.sH);
						
						_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 900);
						setTimeout(function(){
							FWDAnimation.to(_s.mainHld, .8, {y:0, delay:.1, ease:Expo.easeInOut});
						}, 100);
					
					}
				
				}, 50);
			}else{
				_s.positionAndResize();
			
				clearTimeout(_s.hideCompleteId_to);
				clearTimeout(_s.showCompleteId_to);
				_s.mainHld.setY(- _s.sH);
				
				_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 900);
				setTimeout(function(){
					FWDAnimation.to(_s.mainHld, .8, {y:0, delay:.1, ease:Expo.easeInOut});
				}, 100);
			}
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
			_s.dispatchEvent(FWDUVPEmbedWindow.HIDE_COMPLETE);
		};

		if(_s.useHEX){
			_s.init();
		}
	};
		
		
	/* set prototype */
	FWDUVPEmbedWindow.setPrototype = function(){
		FWDUVPEmbedWindow.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPEmbedWindow.ERROR = "error";
	FWDUVPEmbedWindow.HIDE_COMPLETE = "hideComplete";
	
	FWDUVPEmbedWindow.prototype = null;
	window.FWDUVPEmbedWindow = FWDUVPEmbedWindow;
}(window));