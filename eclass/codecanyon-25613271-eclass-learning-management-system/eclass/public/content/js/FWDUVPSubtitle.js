/**
 * Ultimate Video Player PACKAGED v9.1
 * Subtitle.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
var FWDUVPSubtitle = function(prt, _d){
		
		'use strict';

		var _s = this;
		var prototype = FWDUVPSubtitle.prototype;
		
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.showSubtitileByDefault_bl = _d.showSubtitileByDefault_bl;
		

		//##########################################//
		/* initialize */
		//##########################################//
		_s.init = function(){
			_s.setOverflow("visible");
			_s.getStyle().pointerEvents = "none";
			_s.getStyle().cursor = "default";
			_s.setupTextContainer();
			_s.getStyle().margin = "auto";		
			_s.hide();
		};
		
	
		//##########################################//
		/* setup text containers */
		//##########################################//
		_s.setupTextContainer = function(){
			_s.text_do = new FWDUVPTransformDisplayObject("div");
			_s.text_do.getStyle().pointerEvents = "none";
			_s.text_do.hasTransform3d_bl = false;
			_s.text_do.setBackfaceVisibility();
			_s.text_do.getStyle().transformOrigin = "50% 0%";
			_s.text_do.getStyle().textAlign = "center";
			_s.addChild(_s.text_do);
		};
		

		//##########################################//
		/* Load subtitle */
		//##########################################//
		_s.loadSubtitle = function(path){
			_s.text_do.setX(-5000);
			if(location.protocol.indexOf("file:") != -1) return;
			_s.subtitiles_ar = [];
			_s.stopToLoadSubtitle();
			_s.sourceURL_str = path;
			_s.xhr = new XMLHttpRequest();
			_s.xhr.onreadystatechange = _s.onLoad;
			_s.xhr.onerror = _s.onError;
			
			try{
				_s.xhr.open("get", _s.sourceURL_str + "?rand=" + parseInt(Math.random() * 99999999), true);
				_s.xhr.send();
			}catch(e){
				var message = e;
				if(e){if(e.message)message = e.message;}
			}
		};
		
		_s.onLoad = function(e){
			var response;
			
			if(_s.xhr.readyState == 4){
				if(_s.xhr.status == 404){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Subtitle file path is not found: <font color='#FF0000'>" + _s.sourceURL_str + "</font>"});
				}else if(_s.xhr.status == 408){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Loadiong subtitle file file request load timeout!"});
				}else if(_s.xhr.status == 200){
					if(window.JSON){
						_s.subtitle_txt = _s.xhr.responseText;
					}else{
						_s.subtitle_txt = _s.xhr.responseText;
					}
					if(_s.isShowed_bl) _s.show();
					
					_s.parseSubtitle(_s.subtitle_txt)
					_s.prevText = "none";
					_s.shId_to = setTimeout(function(){
						_s.show();
						_s.text_do.setX(0);
						_s.updateSubtitle(prt.currentSecconds);
					}, 400);
				}
			}
			
			_s.dispatchEvent(FWDUVPSubtitle.LOAD_COMPLETE);
		};
		
		_s.onError = function(e){
			try{
				if(window.console) console.log(e);
				if(window.console) console.log(e.message);
			}catch(e){};
			_s.dispatchEvent(FWDUVPSubtitle.LOAD_ERROR, {text:"Error loading subtitle file : <font color='#FF0000'>" + _s.sourceURL_str + "</font>."});
		};

		
		//####################################################//
		/* Stop to load subtitile */
		//####################################################//
		_s.stopToLoadSubtitle = function(){
			if(_s.xhr != null){
				try{_s.xhr.abort();}catch(e){}
				_s.xhr.onreadystatechange = null;
				_s.xhr.onerror = null;
				_s.xhr = null;
			}
			_s.hide();
			_s.isLded = false;
			
		};
		

		//##########################################//
		/* parse subtitle */
		//##########################################//
		_s.parseSubtitle = function(file_str){
			
			 _s.isLded = true;
			 function strip(s) {
				if(s ==  undefined) return "";
		        return s.replace(/^\s+|\s+$/g,"");
		     }
			 
			file_str = file_str.replace(/\r\n|\r|\n/g, '\n');
			file_str = strip(file_str);

		    var srt_ = file_str.split('\n\n');
		    var cont = 0;
			
		    for(var s in srt_) {
		        var st = srt_[s].split('\n');

		        if(st.length >=2) {
		            var n = st[0];

		            var i = strip(st[1].split(' --> ')[0]);
		            var o = strip(st[1].split(' --> ')[1]);
		            var t = st[2];
					

		            if(st.length > 2) {
		                for(var j=3; j<st.length;j++)
		                  t += '<br>'+st[j];
		            }
		            
		            //define variable type as Object
		            _s.subtitiles_ar[cont] = {};
		            _s.subtitiles_ar[cont].number = n;
		            _s.subtitiles_ar[cont].start = i;
		            _s.subtitiles_ar[cont].end = o;
		            _s.subtitiles_ar[cont].startDuration = FWDUVPUtils.formatTimeWithMiliseconds(i);
		            _s.subtitiles_ar[cont].endDuration = FWDUVPUtils.formatTimeWithMiliseconds(o);
		            _s.subtitiles_ar[cont].text = "<p class='fwduvp-subtitle'>" + t + "</p>";
		        }
		        cont++;
		    }
			for(var i=0; i<_s.subtitiles_ar.length; i++){
				if(!_s.subtitiles_ar[i]){
					_s.subtitiles_ar.splice(i,1);
					i--;
				}
			}
		};
		
		
		//#####################################//
		/* Update text */
		//#####################################//
		_s.updateSubtitle = function(duration){
			if(!_s.isLded) return;
		
			var start;
			var end;
			var text = "";
			for(var i=0; i<_s.subtitiles_ar.length; i++){
				start = _s.subtitiles_ar[i].startDuration;
				end = _s.subtitiles_ar[i].endDuration;
				if(start < duration  && end > duration ){
					text = _s.subtitiles_ar[i].text
					break;
				};
			}

			if(prt.sW < 260){
				_s.setVisible(false);
			}else{
				_s.setVisible(true);
			}

			if(prt.tempStageWidth <= 600){
				text = text.replace('fwduvp-subtitle', 'fwduvp-subtitle phone');
			}else if(prt.tempStageWidth <= 1000){
				text = text.replace('fwduvp-subtitle', 'fwduvp-subtitle tablet');
			}else if(prt.tempStageWidth <= 1800){
				text = text.replace('fwduvp-subtitle', 'fwduvp-subtitle normal');
			}else{
				text = text.replace('fwduvp-subtitle', 'fwduvp-subtitle large');
			}
			
			if(_s.prevText != text){
				var totalWidth;
				_s.text_do.setInnerHTML(text);
				_s.setAlpha(0);
				setTimeout(function(){
					_s.setAlpha(1);
					_s.position();
				}, 300);
				_s.hasText_bl = true;
			}
			_s.prevText = text;
		};
		
		_s.position = function(animate){
			if(!_s.isLded) return;
			
			var finalY;
			_s.setWidth(prt.tempVidStageWidth);
			_s.text_do.setWidth(prt.tempVidStageWidth);
			_s.setX(Math.round((prt.tempVidStageWidth - _s.w)/2));

			var textHeight = _s.text_do.getHeight();
			
			if(prt.controller_do){
				if(prt.controller_do.isShowed_bl){
					finalY = parseInt(prt.vidStageHeight - prt.controller_do.h - textHeight);
				}else{
					finalY = parseInt(prt.vidStageHeight - textHeight - 10);
				}	
			}else{
				finalY = parseInt(prt.vidStageHeight - textHeight);
			}
			
			FWDAnimation.killTweensOf(_s.text_do)
			if(animate){
				FWDAnimation.to(_s.text_do, .8, {y:finalY, ease:Expo.easeInOut});
			}else{
				_s.text_do.setY(finalY)
			}
			_s.text_do.setX(0);
		};
		
		_s.show = function(){
			_s.setVisible(true);
		};
		
		_s.hide = function(){
			clearTimeout(_s.shId_to);
			_s.setVisible(false);
		}
		
		_s.init();
	};
	
	FWDUVPSubtitle.getDuration = function(str){
		var hours = 0;
		var minutes = 0;
		var seconds = 0;
		var duration = 0;
		
		str = str.split(":");
		
		hours = str[0];
		if(hours[0] == "0" && hours[1] != "0"){
			hours = parseInt(hours[1]);
		}
		if(hours == "00") hours = 0;
		
		minutes = str[1];
		if(minutes[0] == "0" && minutes[1] != "0"){
			minutes = parseInt(minutes[1]);
		}
		if(minutes == "00") minutes = 0;
		
		secs = parseInt(str[2].replace(/,.*/ig, ""));
		if(secs[0] == "0" && secs[1] != "0"){
			secs = parseInt(secs[1]);
		}
		if(secs == "00") secs = 0;
		
		if(hours != 0){
			duration += (hours * 60 * 60)
		}
		
		if(minutes != 0){
			duration += (minutes * 60)
		}
		
		duration += secs;
		
		return duration;
	}
	

	/* set prototype */
	FWDUVPSubtitle.setPrototype = function(){
		FWDUVPSubtitle.prototype = null;
		FWDUVPSubtitle.prototype = new FWDUVPTransformDisplayObject("div");
	};
	
	FWDUVPSubtitle.LOAD_ERROR = "error";
	FWDUVPSubtitle.LOAD_COMPLETE = "complete";
	
	
	FWDUVPSubtitle.prototype = null;
	window.FWDUVPSubtitle = FWDUVPSubtitle;
}(window));