/**
 * Ultimate Video Player PACKAGED v9.1
 * Advertisement popup button.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (){
var FWDUVPPopupAddButton = function(
		    prt,
			imgSrc,
			start,
			end,
			link,
			target,
			isClsd,
			id,
			google_ad_client,
			google_ad_slot,
			google_ad_width,
			google_ad_height,
			tracking,
			poppAdClsNPth,
			poppAdClsSPth,
			shwPpoppAdClsBtn,
			useHEX,
			nBC,
			sBC
		){

		'use strict';
			
		var _s = this;
		var prototype = FWDUVPPopupAddButton.prototype;
		
		_s.clsBtn;
		_s.image_do;
		_s.imgSrc = imgSrc;
		_s.link = link;
		_s.target = target;
		_s.start = start;
		_s.end = end;
		_s.google_ad_client = google_ad_client;
		_s.google_ad_slot = google_ad_slot
		_s.originalW = _s.google_ad_width = google_ad_width;
		_s.originalH = _s.google_ad_height = google_ad_height;
		_s.tracking = tracking;
		
		_s.finalW = 0;
		_s.finalH = 0;
		
		if(Boolean(_s.google_ad_client)){
			_s.type = 'adsense';
		}else if(_s.imgSrc.match(/.png|.jpg|.jpeg/ig)){
			_s.type = 'image';
		}else{
			_s.type = 'iframe';
		}
	
		_s.id = id;
		
		_s.shwPpoppAdClsBtn = shwPpoppAdClsBtn;
		_s.poppAdClsNPth = poppAdClsNPth;
		_s.poppAdClsSPth = poppAdClsSPth;
		
		_s.isClsd = isClsd;
		_s.isLded = false;
		_s.isShowed_bl = false;

		

		//##########################################//
		/* initialize  */
		//##########################################//
		_s.init = function(){
			_s.setBkColor("rgba(0, 0, 0, 0.6)");
			_s.setX(-5000);

			var pth = _s.poppAdClsNPth;
			if(window['isWhite']){
				pth = 'content/hex_white/close-button-normal.png';
			}

			if(_s.shwPpoppAdClsBtn){
				FWDUVPSimpleSizeButton.setPrototype();
				_s.clsBtn = new FWDUVPSimpleSizeButton(
						pth, 
						_s.poppAdClsSPth,
						22,
						21,
						useHEX,
						nBC,
						sBC,
						true
						);

				_s.clsBtn.addListener(FWDUVPSimpleSizeButton.MOUSE_UP, _s.closeClickButtonCloseHandler);
			}
			
			if(_s.type == 'image'){
				_s.image = new Image();
				_s.image.src = _s.imgSrc;
				_s.image.onload = _s.onLoadHandler;
			}else{
				_s.isLded = true;
				_s.setWidth(_s.originalW);
				_s.setHeight(_s.originalH);
			}
			
			if(_s.clsBtn){
				_s.addChild(_s.clsBtn);
				_s.clsBtn.setX(-300);
			}
			
			if(_s.link){
				_s.setButtonMode(true);
			}
		};
		
		_s.closeClickButtonCloseHandler = function(){
			_s.hide();
			_s.isClsd = true;
			prt.popupAds_ar[_s.id].isClosed = true;
		};
		
		_s.clickHandler = function(){
			if(_s.link){
				prt.prt.pause();
				window.open(_s.link, _s.target);
			}
		};

		
		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.onLoadHandler = function(){
			_s.originalW = _s.image.width;
			_s.originalH = _s.image.height;
			_s.image_do = new FWDUVPDisplayObject("img");
			_s.image_do.setScreen(_s.image);
			_s.image_do.setWidth(_s.originalW);
			_s.image_do.setHeight(_s.originalH);
			_s.addChild(_s.image_do);
			_s.isLded = true;
			if(_s.clsBtn){
				_s.addChild(_s.clsBtn);
				_s.clsBtn.setX(-300);
			}
			if(_s.screen.addEventListener){
				_s.image_do.screen.addEventListener("click", _s.clickHandler);
			}else{
				_s.image_do.screen.attachEvent("onclick", _s.clickHandler);
			}
		};
		
		_s.hide = function(remove){
			if(!_s.isShowed_bl) return;
			_s.isShowed_bl = false;
			var scale = Math.min(1, prt.prt.tempVidStageWidth/(_s.originalW));			
			var finalH = parseInt(scale * _s.originalH);
			var finalY = parseInt(prt.prt.tempVidStageHeight);
			prt.setY(finalY);
			
			_s.setX(-5000);
			FWDAnimation.killTweensOf(prt);
			if(remove){
				prt.removeChild(_s);
				prt.setWidth(0);
				prt.setHeight(0);
			}else{
				_s.setWidth(0);
				_s.setHeight(0);
				prt.setVisible(false);
				_s.setVisible(false);
			}
		};
		
		_s.show = function(){
			
			if(_s.isShowed_bl || _s.isClsd || !_s.isLded) return;	
			_s.isShowed_bl = true;
			
			_s.setX(0);
			setTimeout(function(){
				FWDAnimation.killTweensOf(prt);
				prt.setVisible(true);
				_s.setVisible(true);

				if(_s.type == 'adsense' && !_s.isGooglAdCreated_bl){
					
					_s.isGooglAdCreated_bl = true;
					
					window.google_ad_client = _s.google_ad_client;
					window.google_ad_slot = _s.google_ad_slot;
					window.google_ad_width = _s.originalW;
					window.google_ad_height = _s.originalH;
					
					// container is where you want the ad to be inserted
					_s.container = new FWDUVPTransformDisplayObject("div");
					_s.container.setWidth(_s.originalW);
					_s.container.setHeight(_s.originalH);
					
					_s.addChild(_s.container);
				
					var w = document.write;
					document.write = function (content) {
						_s.container.screen.innerHTML = content;
						document.write = w;
					};

					var script = document.createElement('script');
					script.type = 'text/javascript';
					if(location.href.indexOf("https") != -1){
						script.src = 'https://pagead2.googlesyndication.com/pagead/show_ads.js';
					}else{
						script.src = 'http://pagead2.googlesyndication.com/pagead/show_ads.js';
					}
					
					document.body.appendChild(script);
					if(_s.clsBtn){
						_s.addChild(_s.clsBtn);
						_s.clsBtn.setX(-300);
					}
				}else if(_s.type == 'iframe'){

					// container is where you want the ad to be inserted
					_s.container = new FWDUVPTransformDisplayObject("div");
					_s.container.setWidth(_s.originalW);
					_s.container.setHeight(_s.originalH);
					
					_s.ifr = new FWDUVPTransformDisplayObject("iframe");
					_s.ifr.screen.scrolling = 'no';
					_s.ifr.setWidth(_s.originalW);
					_s.ifr.setHeight(_s.originalH);
					_s.ifr.screen.src = _s.imgSrc;
					_s.container.addChild(_s.ifr);
				
					if(_s.link){
						_s.clicker = new FWDUVPDisplayObject('div');
						_s.clicker.screen.style.width = '100%';
						_s.clicker.screen.style.height = '100%';
						_s.container.addChild(_s.clicker);
						_s.container.addChild(_s.clicker);
						_s.container.screen.addEventListener("click", _s.clickHandler);
					}
					_s.addChild(_s.container);
					if(_s.clsBtn){
						_s.addChild(_s.clsBtn);
						_s.clsBtn.setX(-300);
					}
				}
				
				var scale = Math.min(1, prt.prt.tempVidStageWidth/(_s.originalW));			
				var finalH = parseInt(scale * _s.originalH) - 2;
				
				if(prt.prt.controller_do.isShowed_bl){
					var finalY = parseInt(prt.prt.tempVidStageHeight - prt.prt.controller_do.h - (_s.originalH * scale) + 2 + finalH);
				}else{
					var finalY = parseInt(prt.prt.tempVidStageHeight - (_s.originalH * scale) + 2 + finalH);
				}	
				prt.setY(finalY);
			
				_s.resizeAndPosition(true);
			}, 100);
		};
		
		
		
		//###############################//
		/* set final size */
		//###############################//
		_s.resizeAndPosition = function(animate){
			if(!_s.isLded || _s.isClsd || !_s.isShowed_bl) return;
	
			var finalY;
			var hasScale_bl = !FWDUVPUtils.isIEAndLessThen9;
			var scale = 1;
		
			scale = Math.min(1, prt.prt.tempVidStageWidth/(_s.originalW));			
		
			_s.finalW = parseInt(scale * _s.originalW);
			_s.finalH = parseInt(scale * _s.originalH);
			
			if(_s.finalW == _s.prevFinalW && _s.finalH == _s.prevFinalH) return;
		
			_s.setWidth(_s.finalW);
			_s.setHeight(_s.finalH);
		
			if(_s.type == 'image'){
				_s.image_do.setWidth(_s.finalW);
				_s.image_do.setHeight(_s.finalH);
			}else if(_s.container){
				_s.container.setScale2(scale);
				_s.container.setX((_s.finalW - _s.originalW)/2);
				_s.container.setY((_s.finalH - _s.originalH)/2);
			}
			
			if(prt.prt.controller_do){
				if(prt.prt.controller_do.isShowed_bl){
					finalY = parseInt(prt.prt.tempVidStageHeight - prt.prt.controller_do.h - (_s.originalH * scale) - 10);
				}else{
					finalY = parseInt(prt.prt.tempVidStageHeight - (_s.originalH * scale) - 10);
				}	
			}else{
				finalY = parseInt(prt.prt.tempVidStageHeight - (_s.originalH * scale));
			}
			
			prt.setX(parseInt((prt.prt.tempVidStageWidth - _s.finalW)/2));
			
			FWDAnimation.killTweensOf(prt);
			if(animate){
				FWDAnimation.to(prt, .8, {y:finalY, ease:Expo.easeInOut});
			}else{
				prt.setY(finalY);
			}
			
			if(_s.clsBtn){
				_s.clsBtn.setY(5);
				_s.clsBtn.setX(parseInt(_s.finalW - 21 - 5));
			}
			
			_s.prevFinalW = _s.finalW;
			_s.prevFinallH = _s.finalH;
			prt.setWidth(_s.finalW);
			prt.setHeight(_s.finalH);
		};

		_s.init();
	};
	

	/* set prototype */
	FWDUVPPopupAddButton.setPrototype = function(){
		FWDUVPPopupAddButton.prototype = new FWDUVPDisplayObject("div", "absolute", "visible");
	};
	
	FWDUVPPopupAddButton.MOUSE_OVER = "onMouseOver";
	FWDUVPPopupAddButton.MOUSE_OUT = "onMouseOut";
	FWDUVPPopupAddButton.CLICK = "onClick";
	
	FWDUVPPopupAddButton.prototype = null;
	window.FWDUVPPopupAddButton = FWDUVPPopupAddButton;
}(window));