/**
 * Ultimate Video Player PACKAGED v9.1
 * Poster.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPPoster = function(
			prt,
			showPoster,
			posterBackgroundColor_str
		){
		
		'use strict';

		var _s  = this;
		var prototype = FWDUVPPoster.prototype;
		
		_s.img_img = new Image();
		_s.img_do = null;
		_s.imgW = 0;
		_s.imgH = 0;
		_s.finalW = 0;
		_s.finalH = 0;
		_s.finalX = 0;
		_s.finalY = 0;
		
		_s.curPath_str;
		_s.posterBackgroundColor_str = posterBackgroundColor_str;
		
		_s.isTransparent_bl = false;
		_s.showPoster_bl = showPoster;
		_s.showOrLoadOnMobile_bl = false;
		_s.isShowed_bl = true;
		_s.allowToShow_bl = true;
		_s.isMbl = FWDUVPUtils.isMobile;
	
		_s.init = function(){
			_s.img_img = new Image();
			_s.img_do = new FWDUVPDisplayObject("img");
			_s.hide();
		};
		
		_s.positionAndResize = function(){
			if(!prt.vidStageWidth) return;
			_s.setWidth(prt.tempVidStageWidth);
			_s.setHeight(prt.tempVidStageHeight);
		
			if(!_s.imgW) return;
			var scX = prt.tempVidStageWidth/_s.imgW;
			var scY = prt.tempVidStageHeight/_s.imgH;
			var ttSc;
			
			if(scX <= scY){
				ttSc = scX;
			}else{
				ttSc = scY;
			}

			if(prt._d.fillEntireposterScreen_bl){
				if(scX >= scY){
					ttSc = scX;
				}else{
					ttSc = scY;
				}
			}
			
			_s.finalW = Math.round(ttSc * _s.imgW);
			_s.finalH = Math.round(ttSc * _s.imgH);
			_s.finalX = parseInt((prt.tempVidStageWidth - _s.finalW)/2);
			_s.finalY = parseInt((prt.tempVidStageHeight - _s.finalH)/2);
		
			_s.img_do.setX(_s.finalX);
			_s.img_do.setY(_s.finalY);
			_s.img_do.setWidth(_s.finalW);
			_s.img_do.setHeight(_s.finalH);		
		};
		
		_s.setPoster = function(path){
			
			if(_s.id == prt.id || !path) return;
			_s.id = prt.id;
			
			if(path && (FWDUVPUtils.trim(path) == "") || path =="none"){
				_s.showOrLoadOnMobile_bl = true;
				_s.isTransparent_bl = true;
				_s.show();
				return;
			}else if(path == "youtubemobile" && _s.isMbl){
				_s.isTransparent_bl = false;
				_s.showOrLoadOnMobile_bl = false;
				_s.img_img.src = null;
				_s.imgW = 0;
				return;
			}else if(path == _s.curPath_str){
				_s.isTransparent_bl = false;
				_s.showOrLoadOnMobile_bl = true;
			}else{
				_s.isTransparent_bl = false
			}
			
			if(_s.isTransparent_bl){
				_s.getStyle().backgroundColor = "transparent";
			}else{
				_s.getStyle().backgroundColor = _s.posterBackgroundColor_str;
			}
			
			_s.isTransparent_bl = false;
			_s.showOrLoadOnMobile_bl = true;
			_s.curPath_str = path;
			if(_s.allowToShow_bl) _s.isShowed_bl = false;
			
			try{
				_s.removeChild(_s.img_do);
			}catch(e){}
			_s.img_img = new Image();
			_s.img_img.onload = _s.posterLoadHandler;
			_s.img_img.src = _s.curPath_str;
		};
		
		_s.posterLoadHandler = function(e){
			_s.imgW = _s.img_img.width;
			_s.imgH = _s.img_img.height;
			_s.img_do.setScreen(_s.img_img);
			_s.addChild(_s.img_do);
			_s.positionAndResize();
			if(_s.isShowed_bl){
				_s.show();
			}
		};

		
		//################################//
		/* show / hide */
		//################################//
		_s.show = function(allowToShow_bl){
			if(!_s.allowToShow_bl || _s.isShowed_bl || !_s.showOrLoadOnMobile_bl) return;
			_s.isShowed_bl = true;
			
			if(_s.isTransparent_bl){
				if(_s.alpha != 0) _s.setAlpha(0);
			}else {
				if(_s.alpha != 1) _s.setAlpha(1);
			}
			
			_s.setVisible(true);

			if(!_s.isMbl && !_s.isTransparent_bl){
				FWDAnimation.killTweensOf(_s);
				_s.setAlpha(0);
				FWDAnimation.to(_s, .6, {alpha:1, delay:.4});
			}
			
			_s.positionAndResize();
		};
		
		_s.hide = function(overwrite){
			if(!_s.isShowed_bl && !overwrite) return;
			FWDAnimation.killTweensOf(_s);
			_s.isShowed_bl = false;
			_s.setVisible(false);
		};
		
		_s.init();
	};
	
	
	/* set prototype */
    FWDUVPPoster.setPrototype = function(){
    	FWDUVPPoster.prototype = new FWDUVPDisplayObject("div");
    };
    
    FWDUVPPoster.prototype = null;
	window.FWDUVPPoster = FWDUVPPoster;
}(window));