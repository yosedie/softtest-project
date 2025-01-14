/**
 * Ultimate Video Player PACKAGED v9.1
 * Audio screen.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function(window){
	
	var FWDUVPAudioScreen = function(prt, volume){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPAudioScreen.prototype;
	
		_s.lastPercentPlayed = 0;
		_s.volume = volume;
		_s.curDuration = 0;
		_s.countNormalMp3Errors = 0;
		_s.countShoutCastErrors = 0;
		_s.maxShoutCastCountErrors = 5;
		_s.maxNormalCountErrors = 1;
		_s.testShoutCastId_to;
		_s.audioVisualizerLinesColor_str = FWDUVPUtils.hexToRgb(prt._d.audioVisualizerLinesColor_str);
		_s.audioVisualizerCircleColor_str = FWDUVPUtils.hexToRgb(prt._d.audioVisualizerCircleColor_str);
		_s.hasError_bl = true;
		_s.isStopped_bl = true;

		
		//###############################################//
		/* init */
		//###############################################//
		_s.init = function(){
			_s.setupAudio();
		};

		
		//##############################################//
		/* Resize and position */
		//##############################################//
		_s.resizeAndPosition = function(width, height){
			if(width){
				_s.sW = width;
				_s.sH = height;
			}
			
			_s.setWidth(_s.sW);
			_s.setHeight(_s.sH);
			_s.resizeSpectrumCanvas()
		};
	

		//###############################################//
		/* Setup audio element */
		//##############################################//
		_s.setupAudio = function(){
			if(_s.audio_el == null){
				_s.audio_el = document.createElement("audio");
				_s.screen.appendChild(_s.audio_el);
				_s.audio_el.controls = false;
				_s.audio_el.preload = "auto";
				_s.audio_el.volume = _s.volume;
				if(!FWDUVPUtils.isLocal) _s.audio_el.crossOrigin = "*";
				_s.setPlaybackRate(prt._d.defaultPlaybackRate_ar[prt._d.startAtPlaybackIndex]);
			}
			
			_s.audio_el.addEventListener("error", _s.errorHandler);
			_s.audio_el.addEventListener("canplay", _s.safeToBeControlled);
			_s.audio_el.addEventListener("canplaythrough", _s.safeToBeControlled);
			_s.audio_el.addEventListener("progress", _s.updateProgress);
			_s.audio_el.addEventListener("timeupdate", _s.updateAudio);
			_s.audio_el.addEventListener("pause", _s.pauseHandler);
			_s.audio_el.addEventListener("play", _s.playHandler);
			_s.audio_el.addEventListener("ended", _s.endedHandler);
		};
		
		_s.destroyAudio = function(){
			if(_s.audio_el){
				_s.audio_el.removeEventListener("error", _s.errorHandler);
				_s.audio_el.removeEventListener("canplay", _s.safeToBeControlled);
				_s.audio_el.removeEventListener("canplaythrough", _s.safeToBeControlled);
				_s.audio_el.removeEventListener("progress", _s.updateProgress);
				_s.audio_el.removeEventListener("timeupdate", _s.updateAudio);
				_s.audio_el.removeEventListener("pause", _s.pauseHandler);
				_s.audio_el.removeEventListener("play", _s.playHandler);
				_s.audio_el.removeEventListener("ended", _s.endedHandler);
				_s.audio_el.removeEventListener("waiting", _s.startToBuffer);
				_s.audio_el.removeEventListener("playing", _s.stopToBuffer);
				_s.audio_el.src = "";
				_s.audio_el.load();
			}
		};
		
		_s.startToBuffer = function(overwrite){
			_s.dispatchEvent(FWDUVPVideoScreen.START_TO_BUFFER);
		};
		
		_s.stopToBuffer = function(){
			_s.dispatchEvent(FWDUVPVideoScreen.STOP_TO_BUFFER);
		};
		
		_s.togglePlayPause = function(){
			if(_s == null) return;
			if(!_s.isSafeToBeControlled_bl) return;
			if(_s.isPlaying_bl){
				_s.pause();
			}else{
				_s.play();
			}
		};

		_s.updateLinesColor = function(lc){
			_s.audioVisualizerLinesColor_str = lc;
		}
		

		//##########################################//
		/* Video error handler. */
		//##########################################//
		_s.errorHandler = function(e){
			if(_s.sourcePath_str == null || _s.sourcePath_str == undefined) return;
			
			if(_s.isNormalMp3_bl && _s.countNormalMp3Errors <= _s.maxNormalCountErrors){
				_s.stop();
				_s.testShoutCastId_to = setTimeout(_s.play, 200);
				_s.countNormalMp3Errors ++;
				return;
			}
			
			if(_s.isShoutcast_bl && _s.countShoutCastErrors <= _s.maxShoutCastCountErrors && _s.audio_el.networkState == 0){
				_s.testShoutCastId_to = setTimeout(_s.play, 200);
				_s.countShoutCastErrors ++;
				return;
			}
			
			var error_str;
			_s.hasError_bl = true;
			_s.stop();
			
			if(_s.audio_el.networkState == 0){
				error_str = "error '_s.audio_el.networkState = 1'";
			}else if(_s.audio_el.networkState == 1){
				error_str = "error '_s.audio_el.networkState = 1'";
			}else if(_s.audio_el.networkState == 2){
				error_str = "'_s.audio_el.networkState = 2'";
			}else if(_s.audio_el.networkState == 3){
				error_str = "source not found";
			}else{
				error_str = e;
			}
			
			if(window.console) window.console.log(_s.audio_el.networkState);
			
			_s.dispatchEvent(FWDUVPAudioScreen.ERROR, {text:error_str });
		};
		

		//##############################################//
		/* Set path */
		//##############################################//
		_s.setSource = function(sourcePath){
			
			_s.sourcePath_str = sourcePath;
			clearTimeout(_s.testShoutCastId_to);
			
			if(_s.sourcePath_str.indexOf(";") != -1){
				_s.isShoutcast_bl = true;
				_s.countShoutCastErrors = 0;
			}else{
				_s.isShoutcast_bl = false;
			}
			
			if(_s.sourcePath_str.indexOf(";") == -1){
				_s.isNormalMp3_bl = true;
				_s.countNormalMp3Errors = 0;
			}else{
				_s.isNormalMp3_bl = false;
			}
			
			_s.lastPercentPlayed = 0;
			if(_s.audio_el) _s.stop(true);
		};

	
		//##########################################//
		/* Play / pause / stop methods */
		//##########################################//
		_s.play = function(overwrite){
			if(_s.isStopped_bl){
				_s.isPlaying_bl = false;
				_s.hasError_bl = false;
				_s.allowScrubing_bl = false;
				_s.isStopped_bl = false;
				_s.setupAudio();
				_s.audio_el.src = _s.sourcePath_str;
				_s.play();
				_s.setVisible(true);
			}else if(!_s.audio_el.ended || overwrite){
				try{
					_s.isPlaying_bl = true;
					_s.hasPlayedOnce_bl = true;
					var prm = _s.audio_el.play();
					if(prm !== undefined) {
					    prm.then(function(){}, function(){});
					}
					if(FWDUVPUtils.isIE) _s.dispatchEvent(FWDUVPAudioScreen.PLAY);
				}catch(e){console.log(e)};
			}
		};
		
		_s.resume = function(){
			if(_s.isStopped_bl) return;
			_s.play();
		};

		_s.pause = function(){
			if(_s == null) return;
			if(_s.audio_el == null) return;
			if(!_s.audio_el.ended){
				_s.audio_el.pause();
				_s.isPlaying_bl = false;
				if(FWDUVPUtils.isIE) _s.dispatchEvent(FWDUVPAudioScreen.PAUSE);				
			}
		};
		
		_s.pauseHandler = function(){
			if(_s.allowScrubing_bl) return;
			_s.stopSpectrum();
			_s.dispatchEvent(FWDUVPAudioScreen.PAUSE);
		};
		
		_s.playHandler = function(){
			if(_s.allowScrubing_bl) return;
			if(!_s.isStartEventDispatched_bl){
				_s.dispatchEvent(FWDUVPAudioScreen.START);
				_s.isStartEventDispatched_bl = true;
			}
		
			_s.startSpectrum();
			_s.dispatchEvent(FWDUVPAudioScreen.PLAY);
		};
		
		_s.endedHandler = function(){
			_s.dispatchEvent(FWDUVPAudioScreen.PLAY_COMPLETE);
		};
		
		_s.stop = function(overwrite){
		
			if((_s == null || _s.audio_el == null || _s.isStopped_bl) && !overwrite) return;
			_s.isPlaying_bl = false;
			_s.isStopped_bl = true;
			_s.hasPlayedOnce_bl = true;
			_s.isSafeToBeControlled_bl = false;
			_s.isStartEventDispatched_bl = false;
			_s.setVisible(false);
			clearTimeout(_s.testShoutCastId_to);
			_s.stopToUpdateSubtitles();
			_s.stopSpectrum();
			_s.audio_el.pause();
			_s.destroyAudio();
			_s.dispatchEvent(FWDUVPAudioScreen.STOP);
			_s.dispatchEvent(FWDUVPAudioScreen.LOAD_PROGRESS, {percent:0});
		};


		//###########################################//
		/* Check if audio is safe to be controlled */
		//###########################################//
		_s.safeToBeControlled = function(){
			if(!_s.isSafeToBeControlled_bl){
				_s.hasHours_bl = Math.floor(_s.audio_el.duration / (60 * 60)) > 0;
				_s.isPlaying_bl = true;
				_s.isSafeToBeControlled_bl = true;
				_s.startToUpdateSubtitles();
				_s.dispatchEvent(FWDUVPAudioScreen.SAFE_TO_SCRUBB);
				_s.dispatchEvent(FWDUVPAudioScreen.SAFE_TO_UPDATE_VOLUME);
			}
		};
	

		//###########################################//
		/* Update progress */
		//##########################################//
		_s.updateProgress = function(){
			var buffered;
			var percentLoaded = 0;
			
			if(_s.audio_el.buffered.length > 0){
				buffered = _s.audio_el.buffered.end(_s.audio_el.buffered.length - 1);
				percentLoaded = buffered.toFixed(1)/_s.audio_el.duration.toFixed(1);
				if(isNaN(percentLoaded) || !percentLoaded) percentLoaded = 0;
			}
			
			if(percentLoaded == 1) _s.audio_el.removeEventListener("progress", _s.updateProgress);
			
			_s.dispatchEvent(FWDUVPAudioScreen.LOAD_PROGRESS, {percent:percentLoaded});
		};

		
		//##############################################//
		/* Update audio */
		//#############################################//
		_s.updateAudio = function(){
			
			var percentPlayed; 
			if (!_s.allowScrubing_bl) {
				percentPlayed = _s.audio_el.currentTime /_s.audio_el.duration;
				_s.dispatchEvent(FWDUVPAudioScreen.UPDATE, {percent:percentPlayed});
			}
			
			var totalTime = FWDUVPUtils.formatTime(_s.audio_el.duration);
			var curTime = FWDUVPUtils.formatTime(_s.audio_el.currentTime);
			
			
			if(!isNaN(_s.audio_el.duration)){
				_s.dispatchEvent(FWDUVPVideoScreen.UPDATE_TIME, {curTime: curTime, totalTime:totalTime, seconds:_s.audio_el.currentTime, totalTimeInSeconds:_s.audio_el.duration});
			}else{
				_s.dispatchEvent(FWDUVPVideoScreen.UPDATE_TIME, {curTime:"00:00" , totalTime:"00:00", seconds:0, totalTimeInSeconds:0});
			}
			_s.lastPercentPlayed = percentPlayed;
			_s.curDuration = curTime;
		};

		
		//###############################################//
		/* Scrub */
		//###############################################//
		_s.startToScrub = function(){
			_s.allowScrubing_bl = true;
		};
		
		_s.stopToScrub = function(){
			_s.allowScrubing_bl = false;
		};
		
		_s.scrubbAtTime = function(duration){
			_s.audio_el.currentTime = duration;
			var totalTime = FWDUVPUtils.formatTime(_s.audio_el.duration);
			var curTime = FWDUVPUtils.formatTime(_s.audio_el.currentTime);
			_s.dispatchEvent(FWDUVPVideoScreen.UPDATE_TIME, {curTime: curTime, totalTime:totalTime});
		};
		
		_s.scrub = function(percent, e){
			if(_s.audio_el == null || !_s.audio_el.duration) return;
			if(e) _s.startToScrub();
			try{
				_s.audio_el.currentTime = _s.audio_el.duration * percent;
				var totalTime = FWDUVPUtils.formatTime(_s.audio_el.duration);
				var curTime = FWDUVPUtils.formatTime(_s.audio_el.currentTime);
				_s.dispatchEvent(FWDUVPAudioScreen.UPDATE_TIME, {curTime: curTime, totalTime:totalTime});
			}catch(e){}
		};

		
		//###############################################//
		/* replay */
		//###############################################//
		_s.replay = function(){
			_s.scrub(0);
			_s.play();
		};

		
		//##################################################//
		/* Subtitles */
		//##################################################//
		_s.stopToUpdateSubtitles = function(){
			clearInterval(_s.startToUpdateSubtitleId_int);	
		}
		
		_s.startToUpdateSubtitles = function(){
			clearInterval(_s.startToUpdateSubtitleId_int);
			_s.startToUpdateSubtitleId_int = setInterval(_s.updateSubtitleHandler, 10);
		}
		
		_s.updateSubtitleHandler = function(){
			_s.dispatchEvent(FWDUVPAudioScreen.UPDATE_SUBTITLE, {curTime:_s.audio_el.currentTime});
		}
		

		//###############################################//
		/* Volume */
		//###############################################//
		_s.setVolume = function(vol){
			if(vol != undefined) _s.volume = vol;
			if(_s.audio_el) _s.audio_el.volume = _s.volume;
		};
		
		_s.setPlaybackRate = function(rate){
			if(!_s.audio_el) return;
			if(rate == 0.25) rate = "0.5";
			
			_s.audio_el.defaultPlaybackRate = rate;
			_s.audio_el.playbackRate = rate;
		}

		
		//####################################################//
		/* Spectrum visualizer */
		//###################################################//
		_s.setupSpectrum = function(){
			if(FWDUVPUtils.isIOS) return;
			if(prt.useWithoutVideoScreen_bl) return;
			var audioContextTest = window.AudioContext || window.webkitAudioContext;
			if(_s.canvas_do || !audioContextTest) return;
			if(FWDUVPAudioScreen.countAudioContext > 3) return;
			FWDUVPAudioScreen.countAudioContext ++;
			_s.canvas_do = new FWDUVPDisplayObject("canvas");
			
			_s.addChild(_s.canvas_do);
			
			_s.canvas = _s.canvas_do.screen;
			_s.ctx = _s.canvas.getContext("2d");
			
			_s.resizeSpectrumCanvas();
			
			if(!audioContextTest) return;
			_s.context = new audioContextTest();
			_s.analyser = _s.context.createAnalyser();
			
			_s.source = _s.context.createMediaElementSource(_s.audio_el);
			
			_s.source.connect(_s.analyser);
			_s.analyser.connect(_s.context.destination);
			
			_s.fbc_array = new Uint8Array(_s.analyser.frequencyBinCount);
			_s.renderSpectrum();
		}
		
		_s.resizeSpectrumCanvas =  function(){
			if(!_s.canvas_do) return;
			_s.canvas_do.setWidth(_s.sW);
			_s.canvas_do.setHeight(_s.sH);
			_s.canvas.width  = _s.sW;
			_s.canvas.height = _s.sH;
		}
		
		
		// give vars an initial real value to validate
		_s.bars = 200;
		if(FWDUVPUtils.isMobile) _s.bars = 100;
		_s.react_x = 0;
		_s.react_y = 0;
		_s.radius = 0;
		_s.deltarad = 0;
		_s.shockwave = 0;
		_s.rot = 0;
		_s.intensity = 0;
		_s.isSeeking = 0;
		_s.center_x;
		_s.center_y;
		
		
		_s.renderSpectrum = function() {
			
			if(!_s.canvas_do) return;
			_s.resizeSpectrumCanvas(); // for some reason i have to resize the _s.canvas every update or else the framerate decreases over time
						
			var grd = _s.ctx.createLinearGradient(0, 0, 0, _s.canvas.height);
			grd.addColorStop(0, "rgba(0, 0, 0, 1)");
			grd.addColorStop(1, "rgba(0, 0, 0, 1)");

			_s.ctx.fillStyle = grd;
			_s.ctx.fillRect(0, 0, _s.canvas.width, _s.canvas.height);
			
			_s.ctx.fillStyle = "rgba(255, 255, 255, " + (_s.intensity * 0.0000125 - 0.4) + ")";
			_s.ctx.fillRect(0, 0, _s.canvas.width, _s.canvas.height);
				
			_s.rot = _s.rot + _s.intensity * 0.0000001;
				
			_s.react_x = 0;
			_s.react_y = 0;
						
			_s.intensity = 0;
						
			_s.analyser.getByteFrequencyData(_s.fbc_array);
			
			for (var i = 0; i < _s.bars; i++) {
				var rads = Math.PI * 2 / _s.bars;
								
				var bar_x = _s.center_x;
				var bar_y = _s.center_y;
			
				var limit =  _s.sH/3;
				if(isNaN(limit)) limit = 10;
				var bar_height = Math.round(_s.fbc_array[i]/256 * limit)
				var bar_width = Math.round(bar_height * 0.02);
								
				var bar_x_term = _s.center_x + Math.cos(rads * i + _s.rot) * (_s.radius + bar_height);
				var bar_y_term = _s.center_y + Math.sin(rads * i + _s.rot) * (_s.radius + bar_height);
								
				_s.ctx.save();
				
				var lineColor = _s.audioVisualizerLinesColor_str;
								
				_s.ctx.strokeStyle = lineColor;
				_s.ctx.lineWidth = bar_width;
				_s.ctx.beginPath();
				_s.ctx.moveTo(bar_x, bar_y);
				_s.ctx.lineTo(bar_x_term, bar_y_term);
				_s.ctx.stroke();
							
				_s.react_x += Math.cos(rads * i + _s.rot) * (_s.radius + bar_height);
				_s.react_y += Math.sin(rads * i + _s.rot) * (_s.radius + bar_height);
							
				_s.intensity += bar_height;
			}
						
			_s.center_x = _s.canvas.width / 2 - (_s.react_x * 0.007);
			_s.center_y = _s.canvas.height / 2 - (_s.react_y * 0.007);
						
			var radius_old = _s.radius;
			_s.radius =  25 + (_s.intensity * 0.002);
			_s.deltarad = _s.radius - radius_old;
						
			_s.ctx.fillStyle = _s.audioVisualizerCircleColor_str;
			_s.ctx.beginPath();
			_s.ctx.arc(_s.center_x, _s.center_y, _s.radius + 2, 0, Math.PI * 2, false);
			_s.ctx.fill();
			
			// _s.shockwave effect			
			_s.shockwave += 60;
						
			_s.ctx.lineWidth = 15;
			_s.ctx.strokeStyle = _s.audioVisualizerCircleColor_str;
			_s.ctx.beginPath();
			_s.ctx.arc(_s.center_x, _s.center_y, _s.shockwave + _s.radius, 0, Math.PI * 2, false);
			_s.ctx.stroke();
								
			if (_s.deltarad > 15) {
				_s.shockwave = 0;
				
				_s.ctx.fillStyle = "rgba(255, 255, 255, 0.7)";
				_s.ctx.fillRect(0, 0, _s.canvas.width, _s.canvas.height);
				
				_s.rot = _s.rot + 0.4;
			}
			
			_s.startSpectrum();
			
		}
		
		_s.startSpectrum = function(){
			if(!_s.canvas_do) return;
			_s.stopSpectrum();
			_s.spectrumAnimationFrameId = window.requestAnimationFrame(_s.renderSpectrum);
		}
		
		_s.stopSpectrum = function(){
			if(!_s.canvas_do) return;
			cancelAnimationFrame(_s.spectrumAnimationFrameId);
		}

		_s.init();
	};

	/* set prototype */
	FWDUVPAudioScreen.setPrototype = function(){
		FWDUVPAudioScreen.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPAudioScreen.UPDATE_SUBTITLE = "updateSubtitle"
	FWDUVPAudioScreen.ERROR = "error";
	FWDUVPAudioScreen.UPDATE = "update";
	FWDUVPAudioScreen.UPDATE = "update";
	FWDUVPAudioScreen.UPDATE_TIME = "updateTime";
	FWDUVPAudioScreen.SAFE_TO_SCRUBB = "safeToControll";
	FWDUVPAudioScreen.SAFE_TO_UPDATE_VOLUME = "safeToUpdateVolume";
	FWDUVPAudioScreen.LOAD_PROGRESS = "loadProgress";
	FWDUVPAudioScreen.START = "start";
	FWDUVPAudioScreen.PLAY = "play";
	FWDUVPAudioScreen.PAUSE = "pause";
	FWDUVPAudioScreen.STOP = "stop";
	FWDUVPAudioScreen.PLAY_COMPLETE = "playComplete";
	FWDUVPAudioScreen.countAudioContext = 0;
	
	window.FWDUVPAudioScreen = FWDUVPAudioScreen;

}(window));