/**
 * Ultimate Video Player PACKAGED v9.1
 * Playlist select box selector.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (){
var FWDUVPComboBoxSelector = function(
			arrowW,
			arrowH,
			arrowN_str,
			arrowS_str,
			label1, 
			backgroundNormalColor,
			backgroundSelectedColor,
			textNormalColor,
			textSelectedColor,
			totalHeight,
			useHEX,
			nBC,
			sBC
		){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPComboBoxSelector.prototype;
		
		_s.arrowN_str = arrowN_str;
		_s.arrowS_str = arrowS_str;
		
		_s.label1_str = label1;
		_s.bkNColor = backgroundNormalColor;
		_s.bkSColor = backgroundSelectedColor;
		_s.tNColor = textNormalColor;
		_s.tSColor = textSelectedColor;
		
		_s.useHEX = useHEX;
		_s.nBC = nBC;
		_s.sBC = sBC;
		
		_s.totalWidth = 400;
		
		_s.totalHeight = totalHeight;
		_s.arrowWidth = arrowW;
		_s.arrowHeight = arrowH;
		
		_s.hasPointEvt = FWDUVPUtils.hasPointerEvent;
		_s.isMbl = FWDUVPUtils.isMobile;
		
		
		//##########################################//
		/* initialize  */
		//##########################################//
		_s.init = function(){
			_s.setBackfaceVisibility();
			_s.setButtonMode(true);
			_s.setupMainContainers();
			_s.setWidth(_s.totalWidth);
			_s.setHeight(_s.totalHeight);
		};
	
		//##########################################//
		/* setup main containers */
		//##########################################//
		_s.setupMainContainers = function(){
			
			_s.bk_sdo = new FWDUVPDisplayObject("div");
			_s.bk_sdo.getStyle().backgroundColor = _s.bkNColor;
			_s.addChild(_s.bk_sdo);
			
			_s.text_sdo = new FWDUVPDisplayObject("div");
			_s.text_sdo.getStyle().whiteSpace = "nowrap";
			_s.text_sdo.screen.className = 'fwduvp-cb-selector';
			_s.text_sdo.setBackfaceVisibility();
			_s.text_sdo.setOverflow("visible");
			_s.text_sdo.setDisplay("inline-block");
			_s.text_sdo.getStyle().fontFamily = "Arial";
			_s.text_sdo.getStyle().fontSize= "13px";
			_s.text_sdo.getStyle().fontWeight = "100";
			_s.text_sdo.getStyle().padding = "6px";
			_s.text_sdo.getStyle().color = _s.nBC;
			_s.text_sdo.getStyle().fontSmoothing = "antialiased";
			_s.text_sdo.getStyle().webkitFontSmoothing = "antialiased";
			_s.text_sdo.getStyle().textRendering = "optimizeLegibility";
			
			if (FWDUVPUtils.isIEAndLessThen9){
				_s.text_sdo.screen.innerText = _s.label1_str;
			}else{
				_s.text_sdo.setInnerHTML(_s.label1_str);
			}
			
			_s.addChild(_s.text_sdo);
			
			_s.arrow_do = new FWDUVPDisplayObject("div");
			_s.arrow_do.screen.className = "arrow";
			_s.arrow_do.setOverflow("visible");
			
			if(_s.useHEX){
				_s.arrowN_img = new Image();
				_s.arrowN_img.src = _s.arrowN_str;
				_s.arrowS_img = new Image();
				_s.arrowS_img.src = _s.arrowS_str;
				_s.arrowN_sdo = new FWDUVPDisplayObject("div");
				_s.arrowS_sdo = new FWDUVPDisplayObject("div");
				
				_s.arrowS_img.onload = function(){
					_s.arrowN_sdo.setWidth(_s.arrowN_img.width);
					_s.arrowN_sdo.setHeight(_s.arrowN_img.height);
					_s.nBC = _s.bkNColor;		

					_s.scrubberLines_n_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.arrowN_img, _s.nBC, true);
					_s.scrubbelinesNImage_img = _s.scrubberLines_n_canvas.image;
					_s.arrowN_sdo.getStyle().background = "url('" + _s.scrubbelinesNImage_img.src + "') repeat-y";
					
					_s.arrowS_sdo.setWidth(_s.arrowS_img.width);
					_s.arrowS_sdo.setHeight(_s.arrowS_img.height);
					_s.sBC = _s.arrowS_str;	
					_s.scrubberLines_s_canvas = FWDUVPUtils.getCanvasWithModifiedColor(_s.arrowS_img, _s.sBC, true);
					_s.scrubbelinesSImage_img = _s.scrubberLines_s_canvas.image;
					_s.arrowS_sdo.getStyle().background = "url('" + _s.scrubbelinesSImage_img.src + "') repeat-y";
				}
			}else{
				_s.arrowN_sdo = new FWDUVPDisplayObject("div");
				_s.arrowN_sdo.screen.style.backgroundImage = "url(" + _s.arrowN_str + ")";
				_s.arrowS_sdo = new FWDUVPDisplayObject("div");
				_s.arrowS_sdo.screen.style.backgroundImage = "url(" + _s.arrowS_str + ")";
			}
			
			_s.arrowS_sdo.setAlpha(0);
			_s.arrow_do.addChild(_s.arrowN_sdo);
			_s.arrow_do.addChild(_s.arrowS_sdo);
			_s.addChild(_s.arrow_do);
			
			_s.arrowN_sdo.setWidth(_s.arrowWidth);
			_s.arrowN_sdo.setHeight(_s.arrowHeight);
			_s.arrowS_sdo.setWidth(_s.arrowWidth);
			_s.arrowS_sdo.setHeight(_s.arrowHeight);
			
			_s.dumy_sdo = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				_s.dumy_sdo.setBkColor("#FF0000");
				_s.dumy_sdo.setAlpha(0);
			};
			_s.addChild(_s.dumy_sdo);
			
			if(_s.hasPointEvt){
				_s.screen.addEventListener("pointerup", _s.onClick);
				_s.screen.addEventListener("pointerover", _s.onMouseOver);
				_s.screen.addEventListener("pointerout", _s.onMouseOut);
			}else if(_s.screen.addEventListener){	
				_s.screen.addEventListener("mouseover", _s.onMouseOver);
				_s.screen.addEventListener("mouseout", _s.onMouseOut);
				_s.screen.addEventListener("mouseup", _s.onClick);
				_s.screen.addEventListener("touchend", _s.onClick);
			}
		};
		
		_s.onMouseOver = function(e){
			if(_s.isDble) return;
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				FWDAnimation.killTweensOf(_s.text_sdo);
				_s.setSelectedState(true, 0);
				_s.dispatchEvent(FWDUVPComboBoxSelector.MOUSE_OVER);
			}
		};
			
		_s.onMouseOut = function(e){
			if(_s.isDble) return;
			if(!e.pointerType || e.pointerType == e.MSPOINTER_TYPE_MOUSE){
				FWDAnimation.killTweensOf(_s.text_sdo);
				_s.setNormalState(true, true);
				_s.dispatchEvent(FWDUVPComboBoxSelector.MOUSE_OUT);
			}
		};
		
		_s.onClick = function(e){
			
			if(_s.isDeveleper_bl){
				window.open("http://www.webdesign-flash.ro", "_blank");
				return;
			}

			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPComboBoxSelector.CLICK, {e:e});
		};
		
		_s.onMouseDown = function(e){
			if(e.preventDefault) e.preventDefault();
			_s.dispatchEvent(FWDUVPComboBoxSelector.MOUSE_DOWN, {e:e});
		};
		

		//###########################################//
		/* set selected / normal state */
		//###########################################//
		_s.setSelectedState = function(animate, dl){
			
			if(animate){
				FWDAnimation.to(_s.bk_sdo, .6, {alpha:1, ease:Expo.easeOut});	
				FWDAnimation.to(_s.text_sdo.screen, .6, {css:{color:_s.tSColor}, ease:Expo.easeOut});
				FWDAnimation.to(_s.arrowS_sdo, .6, {alpha:1, ease:Expo.easeOut});
			}else{
				_s.bk_sdo.setAlpha(1);
				_s.text_sdo.getStyle().color = _s.tSColor;
				_s.arrowS_sdo.alpha = 1;
			}
		};
		
		_s.setNormalState = function(animate, removeDelay){
			var dll = .6;
			if(removeDelay) dll = 0;
			dll = 0;
			FWDAnimation.killTweensOf(_s.bk_sdo);
			FWDAnimation.killTweensOf(_s.text_sdo.screen);
			FWDAnimation.killTweensOf(_s.arrowS_sdo);

			if(animate){
				FWDAnimation.to(_s.bk_sdo, .6, {alpha:0, delay:dll, ease:Expo.easeOut});	
				FWDAnimation.to(_s.text_sdo.screen, .6, {css:{color:_s.tNColor}, delay:dll, ease:Expo.easeOut});
				FWDAnimation.to(_s.arrowS_sdo, .6, {alpha:0, delay:dll, ease:Expo.easeOut});
			}else{
				_s.bk_sdo.setAlpha(0);
				_s.text_sdo.getStyle().color = _s.tNColor;
				_s.arrowS_sdo.alpha = 0;
			}
		};

		
		//##########################################//
		/* center text */
		//##########################################//
		_s.centerText = function(){
			_s.dumy_sdo.setWidth(_s.totalWidth);
			_s.dumy_sdo.setHeight(_s.totalHeight);
			_s.bk_sdo.setWidth(_s.totalWidth);
			_s.bk_sdo.setHeight(_s.totalHeight);
			
			_s.text_sdo.setX(2);
			
			_s.text_sdo.setY(Math.round((_s.totalHeight - _s.text_sdo.getHeight())/2));
			
			_s.arrow_do.setX(_s.totalWidth - _s.arrowWidth - 5);
			_s.arrow_do.setY(Math.round((_s.totalHeight - _s.arrowHeight)/2));
		};

		
		//###############################//
		/* get max text width */
		//###############################//
		_s.getMaxTextWidth = function(){
			return _s.text_sdo.getWidth();
		};

		
		//##############################//
		/* disable / enable */
		//#############################//
		_s.disable = function(){
			_s.isDble = true;
			_s.setSelectedState(true);
			if(FWDUVPUtils.hasTransform2d){
				FWDAnimation.to(_s.arrowN_sdo.screen, .8, {css:{rotation:180}, ease:Quart.easeOut});
				FWDAnimation.to(_s.arrowS_sdo.screen, .8, {css:{rotation:180}, ease:Quart.easeOut});
			}
			_s.setNormalState(true);

		};
		
		_s.enable = function(){
			_s.isDble = false;
			if(FWDUVPUtils.hasTransform2d){
				FWDAnimation.to(_s.arrowN_sdo.screen, .8, {css:{rotation:0}, ease:Quart.easeOut});
				FWDAnimation.to(_s.arrowS_sdo.screen, .8, {css:{rotation:0}, ease:Quart.easeOut});
			}
			_s.setButtonMode(true);
		};
		
		_s.setText = function(text){
			if (FWDUVPUtils.isIEAndLessThen9){
				_s.text_sdo.screen.innerText = text;
			}else{
				_s.text_sdo.setInnerHTML(text);
			}
		};
	
		_s.init();
	};
	

	/* set prototype */
	FWDUVPComboBoxSelector.setPrototype = function(){
		FWDUVPComboBoxSelector.prototype = new FWDUVPDisplayObject ("div");
	};
	
	FWDUVPComboBoxSelector.FIRST_BUTTON_CLICK = "onFirstClick";
	FWDUVPComboBoxSelector.SECOND_BUTTON_CLICK = "secondButtonOnClick";
	FWDUVPComboBoxSelector.MOUSE_OVER = "onMouseOver";
	FWDUVPComboBoxSelector.MOUSE_OUT = "onMouseOut";
	FWDUVPComboBoxSelector.MOUSE_DOWN = "onMouseDown";
	FWDUVPComboBoxSelector.CLICK = "onClick";
	
	FWDUVPComboBoxSelector.prototype = null;
	window.FWDUVPComboBoxSelector = FWDUVPComboBoxSelector;
}(window));