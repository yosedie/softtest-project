/**
 * Ultimate Video Player PACKAGED v9.1
 * Annotations.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
var FWDUVPAnnotations = function(prt, _d){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPAnnotations.prototype;
		
		_s.nBC = _d.nBC;
		_s.sBC = _d.sBC;
		
		_s.ann_ar = [];
		_s.showAnnotationsPositionTool_bl = _d.showAnnotationsPositionTool_bl;
	

		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setOverflow("visible");
		};
		

		//##########################################//
		/* setup text containers */
		//##########################################//
		_s.setupAnnotations = function(source_ar){
			
			if(_s.ann_ar){
				for(var i=0; i<_s.ann_ar.length; i++){
					try{
						_s.removeChild(_s.ann_ar[i]);
					}catch(e){}
				}
			}
			
			_s.source_ar = source_ar;
			
			if(source_ar == undefined){
				_s.setVisible(false);
				return;
			}else{
				_s.setVisible(true);
			}
			
			_s.source_ar = source_ar;
			_s.ann_ar = [];
			_s.totalAnnotations = _s.source_ar.length;
			var pth = _d.annotationAddCloseNPath_str;
			if(window['isWhite']){
				pth = 'content/hex_white/annotation-close-button-normal.png';
			}
			
			for(var i=0; i<_s.totalAnnotations; i++){
				
				FWDUVPAnnotation.setPrototype();
				var ann = new FWDUVPAnnotation({
					id:i,
					start:_s.source_ar[i].start,
					end:_s.source_ar[i].end,
					left:_s.source_ar[i].left,
					top:_s.source_ar[i].top,
					clickSource:_s.source_ar[i].clickSource,
					clickSourceTarget:_s.source_ar[i].clickSourceTarget,
					content:_s.source_ar[i].content,
					showCloseButton_bl:_s.source_ar[i].showCloseButton_bl,
					closeButtonNpath:pth,
					closeButtonSPath:_d.annotationAddCloseSPath_str,
					normalStateClass:_s.source_ar[i].normalStateClass,
					selectedStateClass:_s.source_ar[i].selectedStateClass,
					showAnnotationsPositionTool_bl:_s.showAnnotationsPositionTool_bl,
					prt:_s,
					handPath_str:_d.handPath_str,
					grabPath_str:_d.grabPath_str,
					useHEX:_d.useHEX,
					nBC:_s.nBC,
					sBC:_s.sBC,
					_d:_d
				}) 
				
				_s.ann_ar[i] = ann;
				
				_s.addChild(ann);
			}	
		};
		
		_s.update = function(duration){

			if(_s.totalAnnotations == 0) return;
			var annotation;
			
			for(var i=0; i<_s.totalAnnotations; i++){
				annotation = _s.ann_ar[i];
				if(duration <=0){
					annotation.hide();
				}else if(duration >= annotation.startTime && duration <= annotation.endTime){
					annotation.show();
					_s.position();
					
				}else{
					annotation.hide();
				}
			}	
		
		};
		
		_s.position = function(animate){
			
			var selfScale = prt.sW/prt.maxWidth;
			_s.setX(Math.round((prt.sW - (selfScale * prt.maxWidth))/2));
			_s.setY(Math.round((prt.tempVidStageHeight - (selfScale * prt.maxHeight))/2));
			
			_s.scale = prt.sW/prt.maxWidth;
			_s.scaleY = _s.scale;
			_s.scaleX = _s.scale;
			
			_s.scaleInverse = prt.maxWidth/prt.sW;
			
			if(_s.showAnnotationsPositionTool_bl) return;
			for(var i=0; i<_s.totalAnnotations; i++){
				var ann_do = _s.ann_ar[i];
				
				var finalX = 0;
				var finalY = 0;
				
				ann_do.setScale2(_s.scale);
			
				ann_do.finalX = Math.floor(ann_do.left * _s.scaleX);
				if(prt.playlist_do && prt.isPlaylistShowed_bl && prt.tempPlaylistPosition_str == "right" && !prt.isFullScreen_bl && ann_do.left > prt.maxWidth/3){
					ann_do.finalX -= (prt.playlistWidth + prt.spaceBetweenControllerAndPlaylist);
				}
				
				ann_do.finalY = Math.floor(ann_do.top * _s.scaleY);
				
				if(ann_do.clsBtn){
					
					ann_do.clsBtn.setWidth(Math.round(ann_do.clsBtn.buttonWidth * _s.scaleInverse));
					ann_do.clsBtn.setHeight(Math.round(ann_do.clsBtn.buttonHeight * _s.scaleInverse));
					ann_do.clsBtn.n_do.setWidth(Math.round(ann_do.clsBtn.buttonWidth * _s.scaleInverse));
					ann_do.clsBtn.n_do.setHeight(Math.round(ann_do.clsBtn.buttonHeight * _s.scaleInverse));
					if(ann_do.clsBtn.n_do_canvas){
						ann_do.clsBtn.n_do_canvas.style.width = Math.round(ann_do.clsBtn.buttonWidth * _s.scaleInverse) + "px";
						ann_do.clsBtn.n_do_canvas.style.height = Math.round(ann_do.clsBtn.buttonheight * _s.scaleInverse) + "px";
						ann_do.clsBtn.s_do_canvas.style.width = Math.round(ann_do.clsBtn.buttonWidth * _s.scaleInverse) + "px";
						ann_do.clsBtn.s_do_canvas.style.height = Math.round(ann_do.clsBtn.buttonheight * _s.scaleInverse) + "px";
					}
					ann_do.clsBtn.s_do.setWidth(Math.round(ann_do.clsBtn.buttonWidth * _s.scaleInverse));
					ann_do.clsBtn.s_do.setHeight(Math.round(ann_do.clsBtn.buttonHeight * _s.scaleInverse));
					ann_do.clsBtn.setX(Math.floor(ann_do.getWidth() - ((ann_do.clsBtn.w/2))));
					ann_do.clsBtn.setY(Math.floor(-(ann_do.clsBtn.h/2)));
				}
				
				if(ann_do.prevFinalX != ann_do.finalX){
					if(animate){
						FWDAnimation.to(ann_do, .8, {x:ann_do.finalX, ease:Expo.easeInOut});
					}else{
						ann_do.setX(ann_do.finalX);
					}
					
				}
			
				if(ann_do.prevFinalY != ann_do.finalY){
					if(animate){
						FWDAnimation.to(ann_do, .8, {y:ann_do.finalY, ease:Expo.easeInOut});
					}else{
						ann_do.setY(ann_do.finalY);
					}
				}
				
				ann_do.prevFinalX = ann_do.finalX;
				ann_do.prevFinalY = ann_do.finalY
			}
		};
	
		_s.updateHEXColors =  function(nBC, sBC){
			
			_s.nBC = nBC;
			_s.sBC = sBC;
			if(_s.ann_ar){
				for(var i=0; i<_s.ann_ar.length; i++){
					_s.ann_ar[i].updateHEXColors(nBC, sBC);	
				}
			}
		}
		_s.init();
	};

	
	/* set prototype */
	FWDUVPAnnotations.setPrototype = function(){
		FWDUVPAnnotations.prototype = null;
		FWDUVPAnnotations.prototype = new FWDUVPDisplayObject("div", "absolute");
	};
	
	FWDUVPAnnotations.prototype = null;
	window.FWDUVPAnnotations = FWDUVPAnnotations;
}(window));