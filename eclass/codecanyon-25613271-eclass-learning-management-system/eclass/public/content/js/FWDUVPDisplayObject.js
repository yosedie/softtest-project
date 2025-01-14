/**
 * Ultimate Video Player PACKAGED v9.1
 * Display object.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
	/*
	 * @ type values: div, img.
	 * @ positon values: relative, absolute.
	 * @ positon values: hidden.
	 * @ display values: block, inline-block, _s applies only if the position is relative.
	 */
	var FWDUVPDisplayObject = function(type, position, overflow, display){

		'use strict';
		
		var _s = this;
		_s.listeners = {events_ar:[]};
		
		if(type == "div" || type == "img" || type == "canvas" || "input"){
			_s.type = type;	
		}else{
			throw Error("Type is not valid! " + type);
		}
	
		_s.children_ar = [];
		_s.position = position || "absolute";
		_s.overflow = overflow || "hidden";
		_s.display = display || "inline-block";
		_s.visible = true;
		_s.buttonMode;
		_s.x = 0;
		_s.y = 0;
		_s.w = 0;
		_s.h = 0;
		_s.rect;
		_s.alpha = 1;
		_s.innerHTML = "";
		_s.opacityType = "";
		
		_s.hasTransform3d_bl =  FWDUVPUtils.hasTransform3d;
		_s.hasTransform2d_bl =  FWDUVPUtils.hasTransform2d;
		_s.hasBeenSetSelectable_bl = false;
		

		//##############################//
		/* init */
		//#############################//
		_s.init = function(){
			_s.setScreen();
		};	

		
		//######################################//
		/* check if it supports transforms. */
		//######################################//
		_s.getTransform = function() {
		    var properties = ['transform', 'msTransform', 'WebkitTransform', 'MozTransform', 'OTransform'];
		    var p;
		    while (p = properties.shift()) {
		       if (typeof _s.screen.style[p] !== 'undefined') {
		            return p;
		       }
		    }
		    return false;
		};
		

		//######################################//
		/* set opacity type */
		//######################################//
		_s.getOpacityType = function(){
			var opacityType;
			if (typeof _s.screen.style.opacity != "undefined") {//ie9+ 
				opacityType = "opacity";
			}else{ //ie8
				opacityType = "filter";
			}
			return opacityType;
		};

		
		//######################################//
		/* setup main screen */
		//######################################//
		_s.setScreen = function(element){
			if(_s.type == "img" && element){
				_s.screen = null;
				_s.screen = element;
				_s.setMainProperties();
			}else{
				_s.screen = document.createElement(_s.type);
				_s.setMainProperties();
			}
		};
		

		//########################################//
		/* set main properties */
		//########################################//
		_s.setMainProperties = function(){
			
			_s.transform = _s.getTransform();
			_s.setPosition(_s.position);
			_s.setOverflow(_s.overflow);
			_s.opacityType = _s.getOpacityType();
			
			if(_s.opacityType == "opacity") _s.isHtml5_bl = true;
			
			if(_s.opacityType == "filter") _s.screen.style.filter = "inherit";
			_s.screen.style.left = "0px";
			_s.screen.style.top = "0px";
			_s.screen.style.margin = "0px";
			_s.screen.style.padding = "0px";
			_s.screen.style.maxWidth = "none";
			_s.screen.style.maxHeight = "none";
			_s.screen.style.border = "none";
			_s.screen.style.lineHeight = "1";
			_s.screen.style.backfaceVisibility = "hidden";
			_s.screen.style.webkitBackfaceVisibility = "hidden";
			_s.screen.style.MozBackfaceVisibility = "hidden";
			
			if(type == "img"){
				_s.setWidth(_s.screen.width);
				_s.setHeight(_s.screen.height);
			}
		};
			
		_s.setBackfaceVisibility =  function(){
			_s.screen.style.backfaceVisibility = "visible";
			_s.screen.style.webkitBackfaceVisibility = "visible";
			_s.screen.style.MozBackfaceVisibility = "visible";		
		};

		
		//###################################################//
		/* set / get various peoperties.*/
		//###################################################//
		_s.setSelectable = function(val){
			
			if(!val){
				_s.screen.style.userSelect = "none";
				_s.screen.style.MozUserSelect = "none";
				_s.screen.style.webkitUserSelect = "none";
				_s.screen.style.khtmlUserSelect = "none";
				_s.screen.style.oUserSelect = "none";
				_s.screen.style.msUserSelect = "none";
				_s.screen.msUserSelect = "none";
				_s.screen.ondragstart = function(e){return false;};
				_s.screen.onselectstart = function(){return false;};
				_s.screen.ontouchstart = function(){return false;};
				_s.screen.style.webkitTouchCallout='none';
				_s.hasBeenSetSelectable_bl = true;
			}else{
				if(FWDUVPUtils.isFirefox || FWDUVPUtils.isIE){
					_s.screen.style.userSelect = "element";
					_s.screen.style.MozUserSelect = "element";
					_s.screen.style.msUserSelect = "element";
				}else if(FWDUVPUtils.isSafari){
					_s.screen.style.userSelect = "text";
					_s.screen.style.webkitUserSelect = "text";
				}else{
					_s.screen.style.userSelect = "auto";
					_s.screen.style.webkitUserSelect = "auto";
				}
				
				_s.screen.style.khtmlUserSelect = "auto";
				_s.screen.style.oUserSelect = "auto";
				
				if(FWDUVPUtils.isIEAndLessThen9){
					_s.screen.ondragstart = null;
					_s.screen.onselectstart = null;
					_s.screen.ontouchstart = null;
				}else{
					_s.screen.ondragstart = undefined;
					_s.screen.onselectstart = undefined;
					_s.screen.ontouchstart = undefined;
				}
				
				_s.screen.style.webkitTouchCallout='default';
				_s.hasBeenSetSelectable_bl = false;
			}
			
		};
		
		_s.getScreen = function(){
			return _s.screen;
		};
		
		_s.setVisible = function(val){
			_s.visible = val;
			if(_s.visible == true){
				_s.screen.style.visibility = "visible";
			}else{
				_s.screen.style.visibility = "hidden";
			}
		};
		
		_s.getVisible = function(){
			return _s.visible;
		};
			
		_s.setResizableSizeAfterParent = function(){
			_s.screen.style.width = "100%";
			_s.screen.style.height = "100%";
		};
		
		_s.getStyle = function(){
			return _s.screen.style;
		};
		
		_s.setOverflow = function(val){
			_s.overflow = val;
			_s.screen.style.overflow = _s.overflow;
		};
		
		_s.setPosition = function(val){
			_s.position = val;
			_s.screen.style.position = _s.position;
		};
		
		_s.setDisplay = function(val){
			_s.display = val;
			_s.screen.style.display = _s.display;
		};
		
		_s.setButtonMode = function(val){
			_s.buttonMode = val;
			if(_s.buttonMode ==  true){
				_s.screen.style.cursor = "pointer";
			}else{
				_s.screen.style.cursor = "default";
			}
		};
		
		_s.setBkColor = function(val){
			_s.screen.style.backgroundColor = val;
		};
		
		_s.setInnerHTML = function(val){
			_s.innerHTML = val;
			_s.screen.innerHTML = _s.innerHTML;
		};
		
		_s.getInnerHTML = function(){
			return _s.innerHTML;
		};
		
		_s.getRect = function(){
			return _s.screen.getBoundingClientRect();
		};
		
		_s.setAlpha = function(val){
			_s.alpha = val;
			if(_s.opacityType == "opacity"){
				_s.screen.style.opacity = _s.alpha;
			}else if(_s.opacityType == "filter"){
				_s.screen.style.filter = "alpha(opacity=" + _s.alpha * 100 + ")";
				_s.screen.style.filter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=" + Math.round(_s.alpha * 100) + ")";
			}
		};
		
		_s.getAlpha = function(){
			return _s.alpha;
		};
		
		_s.getRect = function(){
			return _s.screen.getBoundingClientRect();
		};
		
		_s.getGlobalX = function(){
			return _s.getRect().left;
		};
		
		_s.getGlobalY = function(){
			return _s.getRect().top;
		};
		
		_s.setX = function(val){
			_s.x = val;
			if(_s.hasTransform3d_bl){
				_s.screen.style[_s.transform] = 'translate3d(' + _s.x + 'px,' + _s.y + 'px,0)';
			}else if(_s.hasTransform2d_bl){
				_s.screen.style[_s.transform] = 'translate(' + _s.x + 'px,' + _s.y + 'px)';
			}else{
				_s.screen.style.left = _s.x + "px";
			}
		};
		
		_s.getX = function(){
			return  _s.x;
		};
		
		_s.setY = function(val){
			_s.y = val;
			if(_s.hasTransform3d_bl){
				_s.screen.style[_s.transform] = 'translate3d(' + _s.x + 'px,' + _s.y + 'px,0)';	
			}else if(_s.hasTransform2d_bl){
				_s.screen.style[_s.transform] = 'translate(' + _s.x + 'px,' + _s.y + 'px)';
			}else{
				_s.screen.style.top = _s.y + "px";
			}
		};
		
		_s.getY = function(){
			return  _s.y;
		};
		
		_s.setWidth = function(val){
			_s.w = val;
			if(_s.type == "img"){
				_s.screen.width = _s.w;
				_s.screen.style.width = _s.w + "px";
			}else{
				_s.screen.style.width = _s.w + "px";
			}
		};
		
		_s.getWidth = function(){
			if(_s.type == "div" || _s.type == "input"){
				if(_s.screen.offsetWidth != 0) return  _s.screen.offsetWidth;
				return _s.w;
			}else if(_s.type == "img"){
				if(_s.screen.offsetWidth != 0) return  _s.screen.offsetWidth;
				if(_s.screen.width != 0) return  _s.screen.width;
				return _s._w;
			}else if( _s.type == "canvas"){
				if(_s.screen.offsetWidth != 0) return  _s.screen.offsetWidth;
				return _s.w;
			}
		};
		
		_s.setHeight = function(val){
			_s.h = val;
			if(_s.type == "img"){
				_s.screen.height = _s.h;
				_s.screen.style.height = _s.h + "px";
			}else{
				_s.screen.style.height = _s.h + "px";
			}
		};
		
		_s.getHeight = function(){
			if(_s.type == "div" || _s.type == "input"){
				if(_s.screen.offsetHeight != 0) return  _s.screen.offsetHeight;
				return _s.h;
			}else if(_s.type == "img"){
				if(_s.screen.offsetHeight != 0) return  _s.screen.offsetHeight;
				if(_s.screen.height != 0) return  _s.screen.height;
				return _s.h;
			}else if(_s.type == "canvas"){
				if(_s.screen.offsetHeight != 0) return  _s.screen.offsetHeight;
				return _s.h;
			}
		};
		

		//#####################################//
		/* DOM list */
		//#####################################//
		_s.addChild = function(e){
			if(_s.contains(e)){	
				_s.children_ar.splice(FWDUVPUtils.indexOfArray(_s.children_ar, e), 1);
				_s.children_ar.push(e);
				_s.screen.appendChild(e.screen);
			}else{
				_s.children_ar.push(e);
				_s.screen.appendChild(e.screen);
			}
		};
		
		_s.removeChild = function(e){
			if(_s.contains(e)){
				_s.children_ar.splice(FWDUVPUtils.indexOfArray(_s.children_ar, e), 1);
				_s.screen.removeChild(e.screen);
			}else{
				throw Error("##removeChild()## Child dose't exist, it can't be removed!");
			};
		};
		
		_s.contains = function(e){
			if(FWDUVPUtils.indexOfArray(_s.children_ar, e) == -1){
				return false;
			}else{
				return true;
			}
		};
		
		_s.addChildAt = function(e, index){
			if(_s.getNumChildren() == 0){
				_s.children_ar.push(e);
				_s.screen.appendChild(e.screen);
			}else if(index == 1){
				_s.screen.insertBefore(e.screen, _s.children_ar[0].screen);
				_s.screen.insertBefore(_s.children_ar[0].screen, e.screen);	
				if(_s.contains(e)){
					_s.children_ar.splice(FWDUVPUtils.indexOfArray(_s.children_ar, e), 1, e);
				}else{
					_s.children_ar.splice(FWDUVPUtils.indexOfArray(_s.children_ar, e), 0, e);
				}
			}else{
				if(index < 0  || index > _s.getNumChildren() -1) throw Error("##getChildAt()## Index out of bounds!");
				
				_s.screen.insertBefore(e.screen, _s.children_ar[index].screen);
				if(_s.contains(e)){
					_s.children_ar.splice(FWDUVPUtils.indexOfArray(_s.children_ar, e), 1, e);
				}else{
					_s.children_ar.splice(FWDUVPUtils.indexOfArray(_s.children_ar, e), 0, e);
				}
			}
		};
		
		_s.getChildAt = function(index){
			if(index < 0  || index > _s.getNumChildren() -1) throw Error("##getChildAt()## Index out of bounds!");
			if(_s.getNumChildren() == 0) throw Error("##getChildAt## Child dose not exist!");
			return _s.children_ar[index];
		};
		
		_s.getChildIndex = function(child){
			if(_s.contains(child)){
				return FWDUVPUtils.indexOfArray(_s.children_ar, child);
			}
			return 0;
		};
		
		_s.removeChildAtZero = function(){
			_s.screen.removeChild(_s.children_ar[0].screen);
			_s.children_ar.shift();
		};
		
		_s.getNumChildren = function(){
			return _s.children_ar.length;
		};
		
		
		//################################//
		/* event dispatcher */
		//#################################//
		_s.addListener = function (type, listener){
	    	
	    	if(type == undefined) throw Error("type is required.");
	    	if(typeof type === "object") throw Error("type must be of type String.");
	    	if(typeof listener != "function") throw Error("listener must be of type Function.");
	    	
	    	
	        var event = {};
	        event.type = type;
	        event.listener = listener;
	        event.target = _s;
	        _s.listeners.events_ar.push(event);
	    };
	    
	    _s.dispatchEvent = function(type, props){
	    	if(_s.listeners == null) return;
	    	if(type == undefined) throw Error("type is required.");
	    	if(typeof type === "object") throw Error("type must be of type String.");
	    	
	        for (var i=0, len=_s.listeners.events_ar.length; i < len; i++){
	        	if(_s.listeners.events_ar[i].target === _s && _s.listeners.events_ar[i].type === type){		
	    	        if(props){
	    	        	for(var prop in props){
	    	        		_s.listeners.events_ar[i][prop] = props[prop];
	    	        	}
	    	        }
	        		_s.listeners.events_ar[i].listener.call(_s, _s.listeners.events_ar[i]);
	        	}
	        }
	    };
	    
	    _s.removeListener = function(type, listener){
	    	
	    	if(type == undefined) throw Error("type is required.");
	    	if(typeof type === "object") throw Error("type must be of type String.");
	    	if(typeof listener != "function") throw Error("listener must be of type Function." + type);
	    	
	        for (var i=0, len=_s.listeners.events_ar.length; i < len; i++){
	        	if(_s.listeners.events_ar[i].target === _s 
	        			&& _s.listeners.events_ar[i].type === type
	        			&& _s.listeners.events_ar[i].listener ===  listener
	        	){
	        		_s.listeners.events_ar.splice(i,1);
	        		break;
	        	}
	        }  
	    };
	    

	    //###########################################//
	    /* destroy methods*/
	    //###########################################//
		_s.disposeImage = function(){
			if(_s.type == "img") _s.screen.src = null;
		};
		
		
		_s.destroy = function(){
			
			if(_s.hasBeenSetSelectable_bl){
				_s.screen.ondragstart = null;
				_s.screen.onselectstart = null;
				_s.screen.ontouchstart = null;
			};
			
			_s.screen.removeAttribute("style");
			
			//destroy properties
			_s.listeners = [];
			_s.listeners = null;
			_s.children_ar = [];
			_s.children_ar = null;
			_s.style = null;
			_s.screen = null;
			_s.transform = null;
			_s.position = null;
			_s.overflow = null;
			_s.display = null;
			_s.visible = null;
			_s.buttonMode = null;
			_s.x = null;
			_s.y = null;
			_s.w = null;
			_s.h = null;
			_s.rect = null;
			_s.alpha = null;
			_s.innerHTML = null;
			_s.opacityType = null;
			_s.isHtml5_bl = null;
		
			_s.hasTransform3d_bl = null;
			_s.hasTransform2d_bl = null;
			_s = null;
		};
		
	    /* init */
		_s.init();
	};
	
	window.FWDUVPDisplayObject = FWDUVPDisplayObject;
}(window));