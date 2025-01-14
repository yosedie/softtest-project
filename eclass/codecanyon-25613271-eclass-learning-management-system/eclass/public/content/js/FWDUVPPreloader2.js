/**
 * Ultimate Video Player PACKAGED v9.1
 * Image preloader.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	
	var FWDUVPPreloader2 = function(imageSource_img, segmentWidth, segmentHeight, totalSegments, animDelay){
		
		'use strict';

		var _s  = this;
		var prototype = FWDUVPPreloader2.prototype;
		
		_s.imageSource_img = imageSource_img;
		_s.segmentWidth = segmentWidth;
		_s.segmentHeight = segmentHeight;
		_s.totalSegments = totalSegments;
		_s.animDelay = animDelay || 300;
		_s.count = 0;
		
		_s.delayTimerId_int;
		_s.isShowed_bl = false;
		

		//###################################//
		/* init */
		//###################################//
		_s.init = function(){
			_s.setWidth(_s.segmentWidth);
			_s.setHeight(_s.segmentHeight);
		
			_s.image_sdo = new FWDUVPDisplayObject("img");
			_s.image_sdo.setScreen(_s.imageSource_img);
			_s.addChild(_s.image_sdo);
			
			_s.hide(false);
		};

		
		//###################################//
		/* start / stop preloader animation */
		//###################################//
		_s.start = function(){
			if(_s == null) return;
			clearInterval(_s.delayTimerId_int);
			_s.delayTimerId_int = setInterval(_s.updatePreloader, _s.animDelay);
		};
		
		_s.stop = function(){
			clearInterval(_s.delayTimerId_int);
		};
		
		_s.updatePreloader = function(){
			if(_s == null) return;
			_s.count++;
			if(_s.count > _s.totalSegments - 1) _s.count = 0;
			var posX = _s.count * _s.segmentWidth;
			_s.image_sdo.setX(-posX);
		};
		
		
		//###################################//
		/* show / hide preloader animation */
		//###################################//
		_s.show = function(){
			if(_s.isShowed_bl) return;
			_s.setVisible(true);
			_s.start();
			FWDAnimation.killTweensOf(_s);
			FWDAnimation.to(_s, 1, {alpha:1, delay:.2});
			_s.isShowed_bl = true;
		};
		
		_s.hide = function(animate){
			if(!_s.isShowed_bl) return;
			FWDAnimation.killTweensOf(_s);
			if(animate){
				FWDAnimation.to(_s, 1, {alpha:0, onComplete:_s.onHideComplete});
			}else{
				_s.setVisible(false);
				_s.setAlpha(0);
			}
			_s.isShowed_bl = false;
		};
		
		_s.onHideComplete = function(){
			_s.setVisible(false);
			_s.stop();
			_s.dispatchEvent(FWDUVPPreloader2.HIDE_COMPLETE);
		};
		
		_s.init();
	};
	
	
	/* set prototype */
    FWDUVPPreloader2.setPrototype = function(){
    	FWDUVPPreloader2.prototype = new FWDUVPDisplayObject("div");
    };
    
    FWDUVPPreloader2.HIDE_COMPLETE = "hideComplete";
    
    FWDUVPPreloader2.prototype = null;
	window.FWDUVPPreloader2 = FWDUVPPreloader2;
}(window));