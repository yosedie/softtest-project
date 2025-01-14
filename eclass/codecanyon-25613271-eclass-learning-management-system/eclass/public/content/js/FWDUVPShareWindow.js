/**
 * Ultimate Video Player PACKAGED v9.1
 * Share window.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPShareWindow = function(_d, prt){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPShareWindow.prototype;
				
		_s.embedColoseN_img = _d.embedColoseN_img;
		_s.btns_ar = [];
		_s.embedWindowBackground_str = _d.embedWindowBackground_str;
		_s.embedWindowCloseButtonMargins = _d.embedWindowCloseButtonMargins;
			
		_s.totalWidth = 0;
		_s.sW = 0;
		_s.sH = 0;
		_s.minMrgXSpc = 20;
		_s.hSpace = 20;
		_s.minHSpace = 10;
		_s.vSpace = 15;

		_s.isMbl = FWDUVPUtils.isMobile;
		_s.useVectorIcons_bl = _d.useVectorIcons_bl;
	
		//#################################//
		/* init */
		//#################################//
		_s.init = function(){
			_s.setupButtons();
		};

		_s.stpInit =  function(){
			if(_s.clsBtn) return;
			var sBC = _d.sBC;
			if(window['isWhite']){
				sBC = '#000000';
			}

			_s.setBackfaceVisibility();
			_s.mainHld = new FWDUVPDisplayObject("div");
			_s.mainHld.hasTransform3d_bl = false;
			_s.mainHld.hasTransform2d_bl = false;
			_s.mainHld.setBackfaceVisibility();
			
			_s.bk_do = new FWDUVPDisplayObject("div");
			_s.bk_do.getStyle().width = "100%";
			_s.bk_do.getStyle().height = "100%";
			_s.bk_do.setAlpha(.9);
			var pth = _s.embedWindowBackground_str;

			if(window['isWhite']){
				pth = 'content/hex_white/embed-window-background.png';
			}
			_s.bk_do.getStyle().background = "url('" + pth + "')";

		
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
				_s.clsBtn = new FWDUVPSimpleButton(_d.shareClooseN_img, _d.embedWindowClosePathS_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC,
						false, false, false, false, true);
			}

			_s.clsBtn.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.closeButtonOnMouseUpHandler);
			
			_s.addChild(_s.mainHld);
			_s.mainHld.addChild(_s.bk_do);
			_s.mainHld.addChild(_s.clsBtn); 
		}
	
		_s.closeButtonOnMouseUpHandler = function(){
			if(!_s.isShowed_bl) return;
			_s.hide();
		};
		
		_s.positionAndResize = function(){
			_s.sW = prt.sW;
			_s.sH = prt.sH;
				
			_s.clsBtn.setX(_s.sW - _s.clsBtn.w - _s.embedWindowCloseButtonMargins);
			_s.clsBtn.setY(_s.embedWindowCloseButtonMargins);
			
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH);
			_s.mainHld.setWidth(_s.sW);
			_s.mainHld.setHeight(_s.sH);
			setTimeout(function(){
				_s.positionButtons();
			}, 100);
			
		};
		
		
		//###########################################//
		/* Setup buttons */
		//###########################################//
		_s.setupButtons = function(){
			if(_s.btsCrted){
				return;
			}

			_s.stpInit();	
			
			_s.btsCrted = true;
			var sBC = _d.sBC;
			if(window['isWhite']){
				sBC = '#000000';
			}
		
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.facebookButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-facebook'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.facebookButton_do = new FWDUVPSimpleButton(_d.facebookN_img, _d.facebookSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);
			}
			_s.facebookButton_do.screen.className = 'fwduvp-facebook-share-button';
			_s.facebookButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.facebookOnMouseUpHandler);
			_s.addBtnToArray(_s.facebookButton_do);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.twitterButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-twitter'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.twitterButton_do = new FWDUVPSimpleButton(_d.twitterN_img, _d.twitterSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);
			}
			_s.twitterButton_do.screen.className = 'fwduvp-twitter-share-button';
			_s.twitterButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.twitterOnMouseUpHandler);
			_s.addBtnToArray(_s.twitterButton_do);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.likedinButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-linkedin'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.likedinButton_do = new FWDUVPSimpleButton(_d.likedInkN_img, _d.likedInSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);
			}
			_s.likedinButton_do.screen.className = 'fwduvp-likedin-share-button';
			_s.likedinButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.likedinOnMouseUpHandler);
			_s.addBtnToArray(_s.likedinButton_do);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.bufferButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-comments'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.bufferButton_do = new FWDUVPSimpleButton(_d.bufferkN_img, _d.bufferSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);
			}
			_s.bufferButton_do.screen.className = 'fwduvp-buffer-share-button';
			_s.bufferButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.bufferOnMouseUpHandler);
			_s.addBtnToArray(_s.bufferButton_do);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.diggButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-digg'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.diggButton_do = new FWDUVPSimpleButton(_d.diggN_img, _d.diggSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);
			}
			_s.diggButton_do.screen.className = 'fwduvp-digg-share-button';
			_s.diggButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.diggOnMouseUpHandler);
			_s.addBtnToArray(_s.diggButton_do);
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.redditButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-reddit'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.redditButton_do = new FWDUVPSimpleButton(_d.redditN_img, _d.redditSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);	
			}
			_s.redditButton_do.screen.className = 'fwduvp-reddit-share-button';
			_s.redditButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.redditOnMouseUpHandler);
			_s.addBtnToArray(_s.redditButton_do);
			
			
			if(_s.useVectorIcons_bl){
				FWDUVPSimpleButton.setPrototype();
				_s.thumbrlButton_do = new FWDUVPSimpleButton(
						undefined, undefined, undefined, true, undefined, undefined, undefined,
						"<span class='uvpicon fwdicon-tumblr'></span>",
						undefined,
						"UVPSocialMediaButtonsNormalState",
						"UVPSocialMediaButtonsSelectedState"
				);
			}else{
				FWDUVPSimpleButton.setPrototype();
				_s.thumbrlButton_do = new FWDUVPSimpleButton(_d.thumbrlN_img, _d.thumbrlSPath_str, undefined,
						true,
						_d.useHEX,
						_d.nBC,
						sBC);
			}
			_s.thumbrlButton_do.screen.className = 'fwduvp-thumbrl-share-button';
			_s.addBtnToArray(_s.thumbrlButton_do);
			_s.thumbrlButton_do.addListener(FWDUVPSimpleButton.MOUSE_UP, _s.thumbrlOnMouseUpHandler);

			_s.mainHld.addChild(_s.facebookButton_do);
			_s.mainHld.addChild(_s.twitterButton_do);
			_s.mainHld.addChild(_s.likedinButton_do);
			_s.mainHld.addChild(_s.bufferButton_do);
			_s.mainHld.addChild(_s.diggButton_do);
			_s.mainHld.addChild(_s.redditButton_do);
			_s.mainHld.addChild(_s.thumbrlButton_do);

		}
		
		_s.facebookOnMouseUpHandler = function(){
			var url = "http://www.facebook.com/share.php?u=" + encodeURIComponent(location.href);
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
	
		_s.twitterOnMouseUpHandler = function(){
			var url = "http://twitter.com/home?status=" + encodeURIComponent(location.href)
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
		
		_s.likedinOnMouseUpHandler = function(){
			var url = "https://www.linkedin.com/cws/share?url=" + location.href;
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
		
		_s.bufferOnMouseUpHandler = function(){
			var url = "https://buffer.com/add?url=" + location.href;
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
		
		_s.diggOnMouseUpHandler = function(){
			var url = "http://digg.com/submit?url=" + location.href;
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
		
		_s.redditOnMouseUpHandler = function(){
			var url = "https://www.reddit.com/?submit=" + location.href;
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
		
		_s.thumbrlOnMouseUpHandler = function(){
			var url = "http://www.tumblr.com/share/link?url=" + location.href;
			window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
		};
		

		//########################################//
		/* Add buttons to array */
		//########################################//
		_s.addBtnToArray = function(btn){
			setTimeout(function(){
				if(window.getComputedStyle(btn.screen).display != 'none'){
					_s.btns_ar.push(btn);
				}
			}, 50);
		}
		
		//########################################//
		/* Position buttons */
		//########################################//
		_s.positionButtons = function(){
			var button;
			var prevButton;
			var rowsAr = [];
			var rowsWidthAr = [];
			var rowsThumbsWidthAr = [];
			var tempX;
			var tempY = 0;
			var maxY = 0;
			var totalRowWidth = 0;
			var rowsNr = 0;

			if(!_s.btns_ar.length) return;

			if(_s.btns_ar.length == 1){
				button = _s.btns_ar[0];
			
				button.setX(Math.round((_s.sW - button.getWidth())/2))
				button.setY(parseInt((_s.sH - ((rowsNr + 1) * (button.totalHeight + _s.vSpace) - _s.vSpace))/2));

				return;
			}
			
			rowsAr[rowsNr] = [0];
			rowsWidthAr[rowsNr] = _s.btns_ar[0].totalWidth;
			rowsThumbsWidthAr[rowsNr] = _s.btns_ar[0].totalWidth;
			_s.totalButtons = _s.btns_ar.length;
			
			for (var i=1; i<_s.totalButtons; i++){
				button = _s.btns_ar[i];
				
				if (rowsWidthAr[rowsNr] + button.totalWidth + _s.minHSpace > _s.sW - _s.minMrgXSpc){	
					rowsNr++;
					rowsAr[rowsNr] = [];
					rowsAr[rowsNr].push(i);
					rowsWidthAr[rowsNr] = button.totalWidth;
					rowsThumbsWidthAr[rowsNr] = button.totalWidth;
				}else{
					rowsAr[rowsNr].push(i);
					rowsWidthAr[rowsNr] += button.totalWidth + _s.minHSpace;
					rowsThumbsWidthAr[rowsNr] += button.totalWidth;
				}
			}
		
			tempY = parseInt((_s.sH - ((rowsNr + 1) * (button.totalHeight + _s.vSpace) - _s.vSpace))/2);
			
			for (var i=0; i<rowsNr + 1; i++){
				var rowMarginXSpace = 0;
				
				var rowHSpace;
				
				if (rowsAr[i].length > 1){
					rowHSpace = Math.min((_s.sW - _s.minMrgXSpc - rowsThumbsWidthAr[i]) / (rowsAr[i].length - 1), _s.hSpace);
					
					var rowWidth = rowsThumbsWidthAr[i] + rowHSpace * (rowsAr[i].length - 1);
					
					rowMarginXSpace = parseInt((_s.sW - rowWidth)/2);
				}else{
					rowMarginXSpace = parseInt((_s.sW - rowsWidthAr[i])/2);
				}
				
				if (i > 0) tempY += button.h + _s.vSpace;
				
				for (var j=0; j<rowsAr[i].length; j++){
					button = _s.btns_ar[rowsAr[i][j]];
				
					if (j == 0){
						tempX = rowMarginXSpace;
					}else{
						prevButton = _s.btns_ar[rowsAr[i][j] - 1];
						tempX = prevButton.finalX + prevButton.screen.offsetWidth + rowHSpace;
					}
					

					button.finalX = tempX;
					button.finalY = tempY;
						
					if (maxY < button.finalY) maxY = button.finalY;
					
					_s.buttonsBarTotalHeight = maxY + button.totalHeight + _s.startY ;
					button.setX(button.finalX);
					button.setY(button.finalY);
				}
			}
		}
		
		
		//###########################################//
		/* show / hide */
		//###########################################//
		_s.show = function(id){
			if(_s.isShowed_bl) return;
			_s.isShowed_bl = true;
			prt.main_do.addChild(_s);
			_s.init();
		
			if(_s.useVectorIcons_bl){
				_s.checkButtonsId_to = setInterval(function(){
					
					if(_s.clsBtn.w != 0){
				
						_s.positionAndResize();
						
						clearInterval(_s.checkButtonsId_to);
						clearTimeout(_s.hideCompleteId_to);
						clearTimeout(_s.showCompleteId_to);
						_s.mainHld.setY(- _s.sH);
						
						_s.showCompleteId_to = setTimeout(_s.showCompleteHandler, 900);
						
						FWDAnimation.to(_s.mainHld, .8, {y:0, delay:.1, ease:Expo.easeInOut});
					
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
			
			if(!FWDUVPUtils.isMobile || (FWDUVPUtils.isMobile && FWDUVPUtils.hasPointerEvent)) prt.main_do.setSelectable(false);
			
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
			_s.dispatchEvent(FWDUVPShareWindow.HIDE_COMPLETE);
		};

		if(_d.useHEX){
			_s.init();
		}
	};
	

	/* set prototype */
	FWDUVPShareWindow.setPrototype = function(){
		FWDUVPShareWindow.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPShareWindow.HIDE_COMPLETE = "hideComplete";
	
	FWDUVPShareWindow.prototype = null;
	window.FWDUVPShareWindow = FWDUVPShareWindow;
}(window));