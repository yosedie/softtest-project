/**
 * Ultimate Video Player PACKAGED v9.1
 * Annotation item.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
var FWDUVPAnnotation = function(props_obj){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPAnnotation.prototype;
		
		_s.id = props_obj.id;
		_s.startTime = props_obj.start;
		_s.endTime = props_obj.end;
		_s.htmlContent_str = props_obj.content;
		_s.left = props_obj.left;
		_s.top = props_obj.top;
		_s.showCloseButton_bl = props_obj.showCloseButton_bl;
		_s.clickSource = props_obj.clickSource;
		_s.clickSourceTarget = props_obj.clickSourceTarget;
		_s.closeButtonNpath = props_obj.closeButtonNpath;
		_s.closeButtonSPath = props_obj.closeButtonSPath;
		_s.normalStateClass = props_obj.normalStateClass;
		_s.selectedStateClass = props_obj.selectedStateClass;
		_s.showAnnotationsPositionTool_bl = props_obj.showAnnotationsPositionTool_bl;
		_s.prt = props_obj.prt;
		_s.curX = _s.left;
		_s.curY = _s.top;
		_s._d = props_obj._d;
		
		_s.useHEX = props_obj.useHEX;
		_s.nBC = props_obj.nBC;
		_s.sBC = props_obj.sBC;
		
		_s.handPath_str = props_obj.handPath_str;
		_s.grabPath_str = props_obj.grabPath_str;

	
		//##########################################//
		/* initialize  */
		//##########################################//
		_s.init = function(){
			if(_s._d.sknPth.indexOf("hex_white") != -1){
				_s.sBC = "#FFFFFF";
			}
			
			_s.setOverflow("visible");
			_s.setAlpha(0);
			_s.setVisible(false);
			
			if(FWDUVPUtils.hasTransform2d){
				_s.getStyle().transformOrigin = "0% 0%";
			}
			
			_s.screen.innerHTML = _s.htmlContent_str;
			_s.screen.className = _s.normalStateClass;
			_s.setBackfaceVisibility();
			_s.getStyle().fontSmoothing = "antialiased";
			_s.getStyle().webkitFontSmoothing = "antialiased";
			_s.getStyle().textRendering = "optimizeLegibility";
			
			_s.dummy_do = new FWDUVPDisplayObject("div");
			_s.dummy_do.getStyle().width = "100%";
			_s.dummy_do.getStyle().height = "100%";
			_s.addChild(_s.dummy_do);
		
			setTimeout(function(){
				_s.w = _s.getWidth();
				_s.h = _s.getHeight();
			}, 100);
			
			if(_s.showCloseButton_bl && !_s.showAnnotationsPositionTool_bl){
				FWDUVPSimpleSizeButton.setPrototype();
				_s.clsBtn = new FWDUVPSimpleSizeButton(
						_s.closeButtonNpath, 
						_s.closeButtonSPath,
						26,
						26,
						_s.useHEX,
						_s.nBC,
						_s.sBC,
						true
						);
			    _s.clsBtn.setScale2(0);
				_s.clsBtn.addListener(FWDUVPSimpleSizeButton.MOUSE_UP, _s.closeClickButtonCloseHandler);
				_s.clsBtn.getStyle().position = "absolute";
				_s.addChild(_s.clsBtn);
			}
			
			if(_s.showAnnotationsPositionTool_bl){
				_s.info_do = new FWDUVPDisplayObject("div");
				_s.info_do.getStyle().backgroundColor = "#FFFFFF";
				_s.info_do.getStyle().boxShadow = "2px 2px 2px #888888;";
				
				_s.info_do.getStyle().fontSmoothing = "antialiased";
				_s.info_do.getStyle().webkitFontSmoothing = "antialiased";
				_s.info_do.getStyle().textRendering = "optimizeLegibility";
				_s.addChild(_s.info_do);
				
				setTimeout(function(){
					_s.info_do.screen.innerHTML = "<div style='padding:4px; maring:4px; color:#000000'> _d-left=" + Math.round(_s.curX * _s.prt.scaleInverse)  + "</div><div style='padding:4px; margin:4px; color:#000000;'> _d-top=" + Math.round(_s.curY * _s.prt.scaleInverse)  + "</div>";
					
					_s.setX(Math.round(_s.curX * _s.prt.scale));
					_s.setY(Math.round(_s.curY * _s.prt.scale));
				}, 100)
				if(_s.isMbl){
				if(_s.hasPointerEvent_bl){
						_s.screen.addEventListener("pointerdown", _s.selfOnDownHandler);
					}else{
						_s.screen.addEventListener("touchdown", _s.selfOnDownHandler);
					}
				}else{
					if(window.addEventListener){
						_s.screen.addEventListener("mousedown", _s.selfOnDownHandler);		
					}
				}
				_s.getStyle().cursor = 'url(' + _s.handPath_str + '), default';
			}
		
			if(_s.clickSource && !_s.showAnnotationsPositionTool_bl){
				_s.dummy_do.setButtonMode(true);
				_s.dummy_do.screen.addEventListener("click", _s.onClickHandler);
				_s.dummy_do.screen.addEventListener("mouseover", _s.onMouseOverHandler);
				_s.dummy_do.screen.addEventListener("mouseout", _s.onMouseOutHandler);
			}
		};
		
		_s.selfOnDownHandler =  function(e){
			if(e.preventDefault) e.preventDefault();
			
			_s.getStyle().cursor = 'url(' + _s.grabPath_str + '), default';
			_s.prt.addChild(_s);
			
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			_s.startX = vc.screenX - _s.prt.getGlobalX();
			_s.startY = vc.screenY - _s.prt.getGlobalY();
			_s.curX = _s.x;
			_s.curY = _s.y;
		
			if(_s.isMbl){
				if(_s.hasPointerEvent_bl){
					window.addEventListener("pointermove", _s.selfMoveHandler);
					window.addEventListener("pointerup", _s.selfEndHandler);
				}else{
					window.addEventListener("touchmove", _s.selfMoveHandler);
					window.addEventListener("touchend", _s.selfEndHandler);
				}
			}else{
				if(window.addEventListener){
					window.addEventListener("mousemove", _s.selfMoveHandler);
					window.addEventListener("mouseup", _s.selfEndHandler);		
				}
			}
		};
		
		_s.selfMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			_s.localX = vc.screenX - _s.prt.getGlobalX();
			_s.localY = vc.screenY - _s.prt.getGlobalY();
			
			_s.curX = _s.x;
			_s.curY = _s.y;
			_s.curX += (_s.localX - _s.startX);
			_s.curY += (_s.localY - _s.startY);
			
			_s.setX(_s.curX);
			_s.setY(_s.curY);
			_s.startX = vc.screenX - _s.prt.getGlobalX();
			_s.startY = vc.screenY - _s.prt.getGlobalY();
			
			_s.info_do.screen.innerHTML = "<div style='padding:4px; maring:4px; color:#000000'> _d-left=" + Math.round(_s.curX * _s.prt.scaleInverse)  + "</div><div style='padding:4px; margin:4px; color:#000000;'> _d-top=" + Math.round(_s.curY * _s.prt.scaleInverse)  + "</div>";
		};
		
		_s.selfEndHandler = function(e){
			_s.getStyle().cursor = 'url(' + _s.handPath_str + '), default';
			if(_s.isMbl){
				if(_s.hasPointerEvent_bl){
					window.removeEventListener("pointermove", _s.selfMoveHandler);
					window.removeEventListener("pointerup", _s.selfEndHandler);
				}else{
					window.removeEventListener("touchmove", _s.selfMoveHandler);
					window.removeEventListener("touchend", _s.selfEndHandler);
				}
			}else{
				if(window.removeEventListener){
					window.removeEventListener("mousemove", _s.selfMoveHandler);
					window.removeEventListener("mouseup", _s.selfEndHandler);		
				}
			}
		};
		
		_s.onMouseOverHandler = function(e){
			_s.setSelectedAtate();
		};
		
		_s.onMouseOutHandler = function(e){
			_s.setNormalState();
		};
		
		_s.onClickHandler = function(){
		
			if(_s.clickSource.indexOf("https") != -1 || _s.clickSource.indexOf("http") != -1){
				window.open(_s.clickSource, _s.clickSourceTarget);
			}else{
				eval(_s.clickSource);
			}
		};
		
		_s.closeClickButtonCloseHandler = function(){
			_s.hide();
			_s.isClsd = true;
		};
	
		_s.show = function(){
			if(_s.isShowed_bl || _s.isClsd) return;
			_s.isShowed_bl = true;
			_s.setVisible(true);
			FWDAnimation.killTweensOf(_s);
			FWDAnimation.to(_s, .8, {alpha:1, ease:Quint.easeOut});
			if(_s.clsBtn) FWDAnimation.to(_s.clsBtn, .8, {scale:1, delay:.2, ease:Elastic.easeOut});
		};
		
		_s.hide = function(){
			if(!_s.isShowed_bl) return;
			FWDAnimation.killTweensOf(_s);
			_s.isShowed_bl = false;
			_s.setVisible(false);
			_s.setAlpha(0);
			if(_s.clsBtn){
				FWDAnimation.killTweensOf(_s.clsBtn);
				_s.clsBtn.setScale2(0);
			}
		};
		
		_s.setNormalState = function(){
			if(!_s.selectedStateClass) return;
			FWDAnimation.to(_s.screen, .8, {className:_s.normalStateClass, ease:Quint.easeOut});
		};
		
		_s.setSelectedAtate = function(){
			if(!_s.selectedStateClass) return;
			FWDAnimation.to(_s.screen, .8, {className:_s.selectedStateClass, ease:Quint.easeOut});
		};

		
		//##########################################//
		/* Update HEX color of a canvaas */
		//##########################################//
		_s.updateHEXColors = function(nBC, sBC){
			if(_s.clsBtn) _s.clsBtn.updateHEXColors(nBC, sBC, _s.buttonWidth, _s.buttonHeight);
		}
		
		_s.init();
	};
	

	/* set prototype */
	FWDUVPAnnotation.setPrototype = function(){
		FWDUVPAnnotation.prototype = null;
		if(FWDUVPUtils.hasTransform2d){
			FWDUVPAnnotation.prototype = new FWDUVPTransformDisplayObject("div");
		}else{
			FWDUVPAnnotation.prototype = new FWDUVPDisplayObject("div");
		}
	};

	FWDUVPAnnotation.prototype = null;
	window.FWDUVPAnnotation = FWDUVPAnnotation;
}(window));