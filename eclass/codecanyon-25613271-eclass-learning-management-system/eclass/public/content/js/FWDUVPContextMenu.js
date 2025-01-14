/**
 * Ultimate Video Player PACKAGED v9.1
 * Right click context menu.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (){
	var FWDUVPContextMenu = function(prt, _d){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPContextMenu.prototype;
		_s.prt = prt;
		
		_s.buttonsTest_ar = ['copy_url', 'copy_url_time', 'fullscreen'];
		_s.itemsLabels_ar = ['Copy video URL', 'Copy video URL at current time', 'Fullscreen/Normalscreen'];
		_s.items_ar = [];
		_s.spacers_ar = [];

		_s.backgroundColor_str = _d.contextMenuBackgroundColor_str;
		_s.borderColor_str = _d.contextMenuBorderColor_str;
		_s.spacerColor_str = _d.contextMenuSpacerColor_str;
		_s.itemNormalColor_str = _d.contextMenuItemNormalColor_str;
		_s.itemSelectedColor_str = _d.contextMenuItemSelectedColor_str;
		_s.itemDisabledColor_str = _d.contextMenuItemDisabledColor_str;
		_s.draggingMode_str = _d.startDraggingMode_str;
		_s.link_str = _d.link_str;
		
		_s.borderRadius = 0;
		_s.biggestWidth;
		_s.totalWidth = 400;
		_s.totalHeight = 400;
		_s.sapaceBetweenButtons = 7;
		_s.padding = 6;
			
		_s.inverseNextAndPrevRotation_bl = _d.inverseNextAndPrevRotation_bl;
		_s.showScriptDeveloper_bl = _d.showScriptDeveloper_bl;
		
		_s.init = function(){
			
			if(_s.itemsLabels_ar || _s.showScriptDeveloper_bl){
				_s.show_bl = true;
				_s.setWidth(_s.totalWidth);
				_s.setHeight(_s.totalHeight);
				_s.setBkColor(_s.backgroundColor_str);
				_s.getStyle().borderColor = _s.borderColor_str;
				_s.getStyle().borderStyle = "solid";
				_s.getStyle().borderRadius = _s.borderRadius + "px";
				_s.getStyle().borderWidth = "1px";
				_s.setVisible(false);
				_s.setY(-2000);
				_s.prt.main_do.addChild(_s);
				
				_s.setupLabels();	
				_s.setupDeveloperButton();
				_s.setupSpacers();
				_s.disable();
				_s.getMaxWidthResizeAndPositionId_to = setTimeout(_s.getMaxWidthResizeAndPosition, 200);
			}
			
			_s.addContextEvent();
		};
		
		_s.copyText = function(str){
		 	var el = document.createElement('textarea');
		 	el.value = str;
		  	document.body.appendChild(el);
		  	el.select();
		  	document.execCommand('copy');
		  	document.body.removeChild(el);
		};
		

		//##########################################//
		/* Setup context items. */
		//##########################################//
		_s.setupLabels = function(){
			var len = _s.buttonsTest_ar.length;
			var res;
			var label1_str = "";
			var label2_str = "";
			
			if(!_s.itemsLabels_ar) return;
			
			for(var i=0; i<len; i++){
				res = _s.buttonsTest_ar[i];	
				if(res == "copy_url"){
					label1_str = _s.itemsLabels_ar[i];
					FWDUVPContextMenuButton.setPrototype();
					_s.copyURL_do = new FWDUVPContextMenuButton(label1_str, undefined, _s.itemNormalColor_str, _s.itemSelectedColor_str, _s.itemDisabledColor_str);
					_s.items_ar.push(_s.copyURL_do);
					_s.copyURL_do.addListener(FWDUVPContextMenuButton.MOUSE_DOWN, _s.copyURLHandler);
					_s.addChild(_s.copyURL_do);
				}else if(res == "copy_url_time"){
					label1_str = _s.itemsLabels_ar[i];
					FWDUVPContextMenuButton.setPrototype();
					_s.copyURLTime_do = new FWDUVPContextMenuButton(label1_str, undefined, _s.itemNormalColor_str, _s.itemSelectedColor_str, _s.itemDisabledColor_str);
					_s.items_ar.push(_s.copyURLTime_do);
					_s.copyURLTime_do.addListener(FWDUVPContextMenuButton.MOUSE_DOWN, _s.copyURLAtTimeHandler);
					_s.addChild(_s.copyURLTime_do);
				}else if(res == "fullscreen"){
					if(_d.showFullScreenButton_bl){
						var str =  _s.itemsLabels_ar[i];
						label1_str = str.substr(0, str.indexOf("/"));
						label2_str = str.substr(str.indexOf("/") + 1);
						
						FWDUVPContextMenuButton.setPrototype();
						_s.fullScreenButton_do = new FWDUVPContextMenuButton(label1_str, label2_str, _s.itemNormalColor_str, _s.itemSelectedColor_str, _s.itemDisabledColor_str);
						_s.items_ar.push(_s.fullScreenButton_do);
						_s.fullScreenButton_do.addListener(FWDUVPContextMenuButton.MOUSE_DOWN, _s.fullScreenStartHandler);
						_s.addChild(_s.fullScreenButton_do);
					}
				}
			}
		};
		
		_s.setupDeveloperButton = function(){
			if(_s.showScriptDeveloper_bl){
				if(!_s.itemsLabels_ar) _s.itemsLabels_ar = [];
				_s.itemsLabels_ar.push("&#0169; made by FWD");
				var label1_str = "&#0169; made by FWD";
				FWDUVPContextMenuButton.setPrototype();
				_s.developerButton_do = new FWDUVPContextMenuButton(label1_str, undefined, _s.itemNormalColor_str, _s.itemSelectedColor_str, _s.itemDisabledColor_str);
				_s.developerButton_do.isDeveleper_bl = true;
				_s.items_ar.push(_s.developerButton_do);
				_s.addChild(_s.developerButton_do);

			}
		};
		
		_s.copyURLAtTimeHandler = function(e){
			var curTime = prt.curTime;
			if(curTime.length == 5) curTime = '00:' + curTime;
			var time_ar = String(curTime).split(':');
			for(var i=0; i<time_ar.length; i++){
				if(time_ar[i] == '00') time_ar[i] = '0';
			}
			var args = FWDUVPUtils.getHashUrlArgs(window.location.hash);
			var href = location.href;

			href = href.replace(/&uvpi=.*/i, '');
			href = href.replace(/&playlistId=.*/i, '');
			href = href.replace(/playlistId=.*/i, '');
			href = href.replace(/&t=.*/i, '');
			
			if(location.href.indexOf('?') == -1){
				if(FWDUVPlayer.instaces_ar.length > 1){
					curTime = href + '?uvpi=' + prt.instanceName_str + '&playlistId=' + prt.catId + '&videoId=' + prt.id;
				}else{
					curTime = href + '?playlistId=' + prt.catId + '&videoId=' + prt.id;
				}
			}else{
				if(FWDUVPlayer.instaces_ar.length > 1){
					curTime =href + '&uvpi=' + prt.instanceName_str + '&playlistId=' + prt.catId + '&videoId=' + prt.id;
				}else{
					curTime = href + '&playlistId=' + prt.catId + '&videoId=' + prt.id;
				}
			}
			if(curTime.indexOf('t=') == -1) curTime = curTime + '&t=' + time_ar[0] +'h' + time_ar[1] +'m' + time_ar[2] +'s';
			_s.copyText(curTime);
			_s.removeMenuId_to = setTimeout(_s.removeFromDOM, 150);
		};
		
		
		_s.copyURLHandler = function(e){
			_s.copyText(location.href);
			_s.removeMenuId_to = setTimeout(_s.removeFromDOM, 150);
		};

		//full screen.
		_s.fullScreenStartHandler = function(e){
			if(_s.fullScreenButton_do.currentState == 0){
				prt.goFullScreen();
			}else if(_s.fullScreenButton_do.currentState == 1){
				prt.goNormalScreen();
			}
			_s.fullScreenButton_do.onMouseOut();
		};
		
		_s.updateFullScreenButton = function(currentState){
			if(!_s.fullScreenButton_do) return;
			if(currentState == 0){
				_s.fullScreenButton_do.setButtonState(0);
			}else{
				_s.fullScreenButton_do.setButtonState(1);
			}
			_s.removeMenuId_to = setTimeout(_s.removeFromDOM, 150);
		};
		
		
		//########################################//
		/* setup sapcers */
		//########################################//
		_s.setupSpacers = function(){
			var totalSpacers = _s.items_ar.length - 1;
			var spacer_sdo;
			
			for(var i=0; i<totalSpacers; i++){
				spacer_sdo = new FWDUVPDisplayObject("div");
				_s.spacers_ar[i] = spacer_sdo;
				spacer_sdo.setHeight(1);
				spacer_sdo.setBkColor(_s.spacerColor_str);
				_s.addChild(spacer_sdo);
			};
		};
		
		//########################################//
		/* Get max width and position */
		//#######################################//
		_s.getMaxWidthResizeAndPosition = function(){
			var totalItems = _s.items_ar.length;
			var item_do;
			var spacer;
			var finalX;
			var finalY;
			_s.totalWidth = 0;
			_s.totalHeight = 0;
			for(var i=0; i<totalItems; i++){
				item_do = _s.items_ar[i];
				if(item_do.getMaxTextWidth() > _s.totalWidth) _s.totalWidth = item_do.getMaxTextWidth();
			};
			
			for(var i=0; i<totalItems; i++){
				spacer = _s.spacers_ar[i - 1];
				item_do = _s.items_ar[i];
				item_do.setX(_s.padding);
				item_do.setY(10 + (i * (item_do.totalHeight + _s.sapaceBetweenButtons)) - _s.padding);
				
				if(spacer){
					spacer.setWidth(_s.totalWidth + 2);
					spacer.setX(_s.padding);
					spacer.setY(parseInt(item_do.getY() - _s.sapaceBetweenButtons/2) - 1);
				};
				
				item_do.setWidth(_s.totalWidth + 2);
				item_do.centerText();
			}
			
			_s.totalHeight = item_do.getY() + item_do.totalHeight + 2;
			
			_s.setWidth(_s.totalWidth + _s.padding * 2 + 4);
			_s.setHeight(_s.totalHeight);
			
			_s.setVisible(true);
			_s.removeMenuId_to = setTimeout(_s.removeFromDOM, 150);
		};

		
		//##########################################//
		/* Add context events. */
		//##########################################//
		_s.addContextEvent = function(){
			if(_s.prt.main_do.screen.addEventListener){
				_s.prt.main_do.screen.addEventListener("contextmenu", _s.contextMenuHandler);
			}else{
				_s.prt.main_do.screen.attachEvent("oncontextmenu", _s.contextMenuHandler);
			}
		};
		
		_s.contextMenuHandler = function(e){	

			if(!_s.show_bl || !_d.showContextmenu_bl){
				if(e.preventDefault){
					e.preventDefault();
				}else{
					return false;
				}	
				return;
			}
			clearTimeout(_s.removeMenuId_to);
			_s.prt.main_do.addChild(_s);

			_s.positionButtons(e);
			_s.setAlpha(0);
			FWDAnimation.to(_s, .4, {alpha:1, ease:Quart.easeOut});
			
			if(window.addEventListener){
				window.addEventListener("mousedown", _s.contextMenuWindowOnMouseDownHandler);
				window.addEventListener("mouseup", _s.contextMenuWindowOnMouseDownHandler);
			}else{
				document.documentElement.attachEvent("onmousedown", _s.contextMenuWindowOnMouseDownHandler);
				document.documentElement.attachEvent("onmouseup", _s.contextMenuWindowOnMouseDownHandler);
			}
			
			if(e.preventDefault){
				e.preventDefault();
			}else{
				return false;
			}
		};
		
		_s.contextMenuWindowOnMouseDownHandler = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			
			var screenX =  vc.screenX;
			var screenY =  vc.screenY;
			
			
			if(!FWDUVPUtils.hitTest(_s.screen, screenX, screenY)){
				if(window.removeEventListener){
					window.removeEventListener("mousedown", _s.contextMenuWindowOnMouseDownHandler);
					window.removeEventListener("mouseup", _s.contextMenuWindowOnMouseDownHandler);
				}else{
					document.documentElement.detachEvent("onmousedown", _s.contextMenuWindowOnMouseDownHandler);
					document.documentElement.detachEvent("onmouseup", _s.contextMenuWindowOnMouseDownHandler);
				}
				_s.removeMenuId_to = setTimeout(_s.removeFromDOM, 150);
			}
		};

	
		//####################################//
		/* position buttons */
		//####################################//
		_s.positionButtons = function(e){
		
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);
			var parentWidth = _s.prt.main_do.getWidth();
			var parentHeight = _s.prt.main_do.getHeight();
		
			var localX = vc.screenX - _s.prt.main_do.getGlobalX();
			var localY = vc.screenY - _s.prt.main_do.getGlobalY();
			var finalX = localX - 2;
			var finalY = localY - 2;
			_s.totalWidth = _s.getWidth();
			_s.totalHeight = _s.getHeight();
			
			if(finalX + _s.totalWidth > parentWidth - 2) finalX = localX - _s.totalWidth;
			if(finalX < 0) finalX = parseInt((parentWidth - _s.totalWidth)/2);
			if(finalX < 0) finalX = 0;
			
			if(finalY + _s.totalHeight > parentHeight - 2) finalY = localY - _s.totalHeight;
			if(finalY < 0) finalY = parseInt((parentHeight - _s.totalHeight)/2);
			if(finalY < 0) finalY = 0;
	
			_s.setX(finalX);
			_s.setY(finalY);			
		};
		

		//########################################//
		/* disable / enable */
		//########################################//
		_s.disable = function(){
			if(_s.copyURL_do) _s.copyURL_do.disable();
			if(_s.copyURLTime_do) _s.copyURLTime_do.disable();
			
		};
		
		_s.enable = function(){
			if(_s.copyURL_do) _s.copyURL_do.enable();
			if(_s.copyURLTime_do) _s.copyURLTime_do.enable();
		};

		
		//######################################//
		/* remove from DOM */
		//######################################//
		_s.removeFromDOM = function(){
			_s.setX(-5000);
		};
		
		_s.init();
	};
	
	FWDUVPContextMenu.setPrototype = function(){
		FWDUVPContextMenu.prototype = new FWDUVPDisplayObject("div");
	};
	
	
	FWDUVPContextMenu.prototype = null;
	window.FWDUVPContextMenu = FWDUVPContextMenu;
	
}(window));
