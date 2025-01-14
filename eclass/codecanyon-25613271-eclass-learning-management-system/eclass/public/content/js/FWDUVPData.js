/**
 * Easy Video Player PACKAGED v8.4
 * Data.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function(window){
	
	var FWDUVPData = function(props, playListElement, prt){

		'use strict';
		
		var _s = this;
		var prototype = FWDUVPData.prototype;

		_s.props = props;
		_s.skinPaths_ar = [];
		_s.images_ar = [];
		_s.cats_ar = [];
		_s.catsRef_ar = [];
	
		_s.controllerHeight = 0;
		_s.countLoadedSkinImages = 0;
		_s.volume = 1;
		_s.controllerHideDelay = 0;
		_s.startSpaceBetweenButtons = 0;
		_s.spaceBetweenButtons = 0;
		_s.scrubbersOffsetWidth = 0;
		_s.volumeScrubberOffsetTopWidth = 0;
		_s.timeOffsetLeftWidth = 0;
		_s.timeOffsetTop = 0;
		_s.logoMargins = 0;
		_s.startAtPlaylist = 0;
		_s.startAtVideo = 0;
		_s.playlistBottomHeight = 0;
		_s.maxPlaylistItems = 0;
		_s.totalPlaylists = 0;
		_s.thumbnailMaxWidth = 0; 
		_s.buttonsMargins = 0;
		_s.nextAndPrevSetButtonsMargins = 0;
		_s.thumbnailMaxHeight = 0;
		_s.horizontalSpaceBetweenThumbnails = 0;
		_s.verticalSpaceBetweenThumbnails = 0;
		_s.buttonsToolTipHideDelay = 0;
		_s.thumbnailWidth = 0;
		_s.thumbnailHeight = 0;
		_s.timeOffsetTop = 0;
		_s.embedWindowCloseButtonMargins = 0;
		_s.plsCache_ar = [];
		
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
	

		//###################################//
		/*init*/
		//###################################//
		_s.init = function(){
			_s.parseProperties();
		};
		

		//#############################################//
		// parse properties.
		//#############################################//
		_s.parseProperties = function(){
			
			_s.useHEX = _s.props.useHEXColorsForSkin; 
			_s.useHEX = _s.useHEX == "yes" ? true : false;
			if(location.protocol.indexOf("file:") != -1) _s.useHEX = false;
			
			_s.categoriesId_str = _s.props.playlistsId;
			if(!_s.categoriesId_str){
				setTimeout(function(){
					if(_s == null) return;
					var errorMessage_str = "The <font color='#ff0000'>playlistsId</font> property is not defined in the constructor function!";
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:errorMessage_str});
				}, 50);
				return;
			}
				
			_s.mainFolderPath_str = _s.props.mainFolderPath;
			if(!_s.mainFolderPath_str){
				setTimeout(function(){
					if(_s == null) return;
					var errorMessage_str = "The <font color='#ff0000'>mainFolderPath</font> property is not defined in the constructor function!";
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:errorMessage_str});
				}, 50);
				return;
			}
			
			if((_s.mainFolderPath_str.lastIndexOf("/") + 1) != _s.mainFolderPath_str.length){
				_s.mainFolderPath_str += "/";
			}
			
			_s.sknPth = _s.props.skinPath;
			if(!_s.sknPth){
				setTimeout(function(){
					if(_s == null) return;
					var errorMessage_str = "The <font color='#ff0000'>skinPath</font> property is not defined in the constructor function!";
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:errorMessage_str});
				}, 50);
				return;
			}
			
			if((_s.sknPth.lastIndexOf("/") + 1) != _s.sknPth.length){
				_s.sknPth += "/";
			}
		
			_s.sknPth = _s.mainFolderPath_str + _s.sknPth;
			_s.flashPath_str = _s.mainFolderPath_str + "flashlsChromeless.swf";
			_s.flashCopyToCBPath_str = _s.mainFolderPath_str + "cb.swf";
			_s.proxyPath_str =  _s.mainFolderPath_str + "proxy.php";
			_s.proxyFolderPath_str = _s.mainFolderPath_str  + "proxyFolder.php";
			_s.mailPath_str = _s.mainFolderPath_str  + "sendMail.php";
			_s.sendToAFriendPath_str = _s.mainFolderPath_str  + "sendMailToAFriend.php";
			_s.videoDownloaderPath_str = _s.mainFolderPath_str  + "downloader.php";
			
			_s.handPath_str = _s.sknPth + "hand.cur";
			_s.grabPath_str = _s.sknPth + "grab.cur";
			if(_s.sknPth.indexOf('white') != -1){
				_s.isWhite = true;
			}
			
			_s.categories_el = document.getElementById(_s.categoriesId_str);
			
			if(!_s.categories_el){
				setTimeout(function(){
					if(_s == null) return;
					var errorMessage_str = "The playlist with the id <font color='#ff0000'>" + _s.categoriesId_str + "</font> is not found!";
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:errorMessage_str});
				}, 50);
				return;
			}
			
			var catsChildren_ar = FWDUVPUtils.getChildren(_s.categories_el);
			_s.totalCats = catsChildren_ar.length;	
			
			if(_s.totalCats == 0){
				setTimeout(function(){
					if(_s == null) return;
					var errorMessage_str = "At least one playlist is required!";
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:errorMessage_str});
				}, 50);
				return;
			}
			
			
			for(var i=0; i<_s.totalCats; i++){
				var obj = {};
				
				var cat_el = null;
				var child = catsChildren_ar[i];
				
				if(!FWDUVPUtils.hasAttribute(child, "data-source")){
					setTimeout(function(){
						if(_s == null) return;
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Attribute <font color='#ff0000'>data-source</font> is required in the plalists html element at position <font color='#ff0000'>" + (i + 1)});
					}, 50);
					return;
				}
				
				if(!FWDUVPUtils.hasAttribute(child, "data-thumbnail-path")){
					setTimeout(function(){
						if(_s == null) return;
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Attribute <font color='#ff0000'>data-thumbnail-path</font> is required in the playlists html element at position <font color='#ff0000'>" + (i + 1)});
					}, 50);
					return;
				}
				
				obj.source = FWDUVPUtils.getAttributeValue(child, "data-source");
				if(obj.source.indexOf("=") == -1 && obj.source.indexOf(".xml") == -1 && obj.source.indexOf("vimeo.com") == -1 && obj.source.indexOf("youtube.") == -1){
					cat_el = document.getElementById(obj.source);
				}else{
					cat_el = obj.source;
				}

				_s.catsRef_ar.push(cat_el);
				
				obj.thumbnailPath = FWDUVPUtils.getAttributeValue(child, "data-thumbnail-path");
			
				obj.htmlContent = child.innerHTML;
				obj.htmlText_str = child.innerText;
				obj.vimeoUserId = FWDUVPUtils.getAttributeValue(child, "data-user-id");
				
				obj.clientId = FWDUVPUtils.getAttributeValue(child, "data-client-id");
				obj.vimeoSecret = FWDUVPUtils.getAttributeValue(child, "data-vimeo-secret");
				obj.vimeoToken = FWDUVPUtils.getAttributeValue(child, "data-vimeo-token");

				if(FWDUVPUtils.hasAttribute(child, "data-playlist-name")){
					obj.playlistName =  FWDUVPUtils.getAttributeValue(child, "data-playlist-name");
				}else{
					obj.playlistName = "not defined!";
				};

				obj.pass =  FWDUVPUtils.getAttributeValue(child, "data-password");	

				_s.cats_ar[i] = obj;
			}
			
			for(var i=0; i<_s.totalCats; i++){
				var obj = {};
				var cat_el = null;
				child = catsChildren_ar[i];	
				cat_el = document.getElementById(FWDUVPUtils.getAttributeValue(child, "data-source"));
			}
		
			_s.startAtPlaylist = _s.props.startAtPlaylist || 0;
			if(isNaN(_s.startAtPlaylist)) _s.startAtPlaylist = 0;
			if(_s.startAtPlaylist < 0){
				_s.startAtPlaylist = 0;
			}else if(_s.startAtPlaylist > _s.totalCats - 1){
				_s.startAtPlaylist = _s.totalCats - 1;
			}
			
			_s.playlistBottomHeight = _s.props.playlistBottomHeight || 0;
			_s.playlistBottomHeight = Math.min(800, _s.playlistBottomHeight);
			
			_s.subtitlesOffLabel_str = _s.props.subtitlesOffLabel || "Subtitle off";
		
			_s.videoSourcePath_str = _s.props.videoSourcePath || undefined;
			_s.timeColor_str = _s.props.timeColor || "#FF0000";
			
			_s.youtubeQualityButtonNormalColor_str = _s.props.youtubeQualityButtonNormalColor || "#FF0000";
			_s.youtubeQualityButtonSelectedColor_str = _s.props.youtubeQualityButtonSelectedColor || "#FF0000";
			_s.posterBackgroundColor_str = _s.props.posterBackgroundColor || "transparent";
		
			_s.showPlaylistButtonAndPlaylist_bl = _s.props.showPlaylistButtonAndPlaylist;
			_s.showPlaylistButtonAndPlaylist_bl = _s.showPlaylistButtonAndPlaylist_bl == "no" ? false : true;

			_s.showYoutubeRelAndInfo_bl = _s.props.showYoutubeRelAndInfo;
			_s.showYoutubeRelAndInfo_bl = _s.showYoutubeRelAndInfo_bl == "no" ? false : true;	

			_s.useResumeOnPlay_bl = _s.props.useResumeOnPlay;
			_s.useResumeOnPlay_bl = _s.useResumeOnPlay_bl == "yes" ? true : false;

			_s.useResumeOnPlay_bl = _s.props.useResumeOnPlay;
			_s.useResumeOnPlay_bl = _s.useResumeOnPlay_bl == "yes" ? true : false;

			_s.showOnlyThumbnail = _s.props.showOnlyThumbnail;
			_s.showOnlyThumbnail = _s.showOnlyThumbnail == "yes" ? true : false;

			_s.showThumbnail_bl = _s.props.showThumbnail;
			_s.showThumbnail_bl = _s.showThumbnail_bl == "no" ? false : true;
			if(_s.showOnlyThumbnail) _s.showThumbnail_bl = true;
	
			_s.showPlaylistOnFullScreen = _s.props.showPlaylistOnFullScreen;
			_s.showPlaylistOnFullScreen = _s.showPlaylistOnFullScreen == "yes" ? true : false;
			
			_s.stopAfterLastVideoHasPlayed_bl = _s.props.stopAfterLastVideoHasPlayed;
			_s.stopAfterLastVideoHasPlayed_bl = _s.stopAfterLastVideoHasPlayed_bl == "yes" ? true : false;
			
	
			_s.usePlaylistsSelectBox_bl = _s.props.usePlaylistsSelectBox;
			_s.usePlaylistsSelectBox_bl = _s.usePlaylistsSelectBox_bl == "yes" ? true : false;
			
			_s.executeCuepointsOnlyOnce_bl = _s.props.executeCuepointsOnlyOnce; 
			_s.executeCuepointsOnlyOnce_bl = _s.executeCuepointsOnlyOnce_bl == "yes" ? true : false;
			
			_s.showPlaylistByDefault_bl = _s.props.showPlaylistByDefault;
			_s.showPlaylistByDefault_bl = _s.showPlaylistByDefault_bl == "no" ? false : true;
		
			_s.playAfterVideoStop_bl = _s.props.playAfterVideoStop;
			_s.playAfterVideoStop_bl = _s.playAfterVideoStop_bl == "no" ? false : true;
			
			_s.openerAlignment_str = _s.props.openerAlignment;
			_s.openerEqulizerOffsetTop = _s.props.openerEqulizerOffsetTop || 0;
			_s.openerEqulizerOffsetLeft = _s.props.openerEqulizerOffsetLeft || 0;
			
			_s.showOpener_bl = _s.props.showOpener; 
			_s.showOpener_bl = _s.showOpener_bl == "yes" ? true : false;

			_s.stickyOnScrollShowOpener_bl = _s.props.stickyOnScrollShowOpener; 
			_s.stickyOnScrollShowOpener_bl = _s.stickyOnScrollShowOpener_bl == "yes" ? true : false;
			
			_s.showOpenerPlayPauseButton_bl = _s.props.showOpenerPlayPauseButton;
			_s.showOpenerPlayPauseButton_bl = _s.showOpenerPlayPauseButton_bl == "yes" ? true : false;
			
			_s.animate_bl = _s.props.animatePlayer; 
			_s.animate_bl = _s.animate_bl == "yes" ? true : false;
			
			_s.showChromecastButton_bl = _s.props.showChromecastButton; 
			_s.showChromecastButton_bl = _s.showChromecastButton_bl == "yes" ? true : false;
			if(!FWDUVPUtils.isChrome || FWDUVPUtils.isLocal || location.href.indexOf("https:") == -1) _s.showChromecastButton_bl = false;

			_s.show360DegreeVideoVrButton_bl = _s.props.show360DegreeVideoVrButton; 
			_s.show360DegreeVideoVrButton_bl = _s.show360DegreeVideoVrButton_bl == "yes" ? true : false;
		
			_s.showAnnotationsPositionTool_bl =  _s.props.showAnnotationsPositionTool;
			_s.showAnnotationsPositionTool_bl = _s.showAnnotationsPositionTool_bl == "yes" ? true : false;
			if(_s.showAnnotationsPositionTool_bl) _s.showPlaylistByDefault_bl = false;
			
			_s.showPlaylistName_bl = _s.props.showPlaylistName;
			_s.showPlaylistName_bl = _s.showPlaylistName_bl == "no" ? false : true;
			
			_s.showSearchInpt = _s.props.showSearchInput;
			_s.showSearchInpt = _s.showSearchInpt == "no" ? false : true;
			
			_s.showSubByDflt = _s.props.showSubtitleByDefault;
			_s.showSubByDflt = _s.showSubByDflt == "no" ? false : true;
				 
			_s.showSubBtn = _s.props.showSubtitleButton;
			_s.showSubBtn = _s.showSubBtn == "no" ? false : true;
			
			_s.forceDisableDownloadButtonForFolder_bl = _s.props.forceDisableDownloadButtonForFolder; 
			_s.forceDisableDownloadButtonForFolder_bl = _s.forceDisableDownloadButtonForFolder_bl == "yes" ? true : false;
			
			_s.nBC = _s.props.normalHEXButtonsColor || "#FFFFFF";

			if(_s.sknPth.indexOf('dark') != -1){
				_s.sBC = '#FFFFFF';
			}else{
				_s.sBC = '#000000';
			}

			_s.playlistPosition_str = _s.props.playlistPosition || "bottom";
			var test = _s.playlistPosition_str == "bottom" || _s.playlistPosition_str == "right";		   
			if(!test) _s.playlistPosition_str = "right";		
			
			_s.folderVideoLabel_str = _s.props.folderVideoLabel || "Video ";
			
			_s.logoPosition_str = _s.props.logoPosition || "topleft";
			_s.logoPosition_str = String(_s.logoPosition_str).toLowerCase();
			test = _s.logoPosition_str == "topleft" 
					   || _s.logoPosition_str == "topright"
					   || _s.logoPosition_str == "bottomleft"
					   || _s.logoPosition_str == "bottomright"; 
			if(!test) _s.logoPosition_str = "topleft";
			
			_s.thumbnailSelectedType_str = _s.props.thumbnailSelectedType || "opacity";
			if(_s.thumbnailSelectedType_str != "blackAndWhite"  
				&& _s.thumbnailSelectedType_str != "threshold" 
				&& _s.thumbnailSelectedType_str != "opacity"){
				_s.thumbnailSelectedType_str = "opacity";
			}
			if(_s.isMbl || FWDUVPUtils.isIEAndLessThen9)  _s.thumbnailSelectedType_str = "opacity";
			if(document.location.protocol == "file:") _s.thumbnailSelectedType_str = "opacity";
			
			_s.adsButtonsPosition_str = _s.props.adsButtonsPosition || "left";
			_s.adsButtonsPosition_str = String(_s.adsButtonsPosition_str).toLowerCase();
			test = _s.adsButtonsPosition_str == "left" 
					   || _s.adsButtonsPosition_str == "right";
					 	   
			if(!test) _s.adsButtonsPosition_str = "left";
			
			_s.skipToVideoButtonText_str = _s.props.skipToVideoButtonText || "not defined";
			_s.skipToVideoText_str = _s.props.skipToVideoText;
			
			_s.adsTextNormalColor = _s.props.adsTextNormalColor || "#FF0000";
			_s.adsTextSelectedColor = _s.props.adsTextSelectedColor || "#FF0000";
			_s.adsBorderNormalColor_str = _s.props.adsBorderNormalColor || "#FF0000";
			_s.adsBorderSelectedColor_str = _s.props.adsBorderSelectedColor || "#FF0000";
				
			_s.volume = _s.props.volume;
			if(_s.volume == undefined || isNaN(_s.volume)) _s.volume = 1;
			
			if(_s.volume > 1){
				_s.volume = 1;
			}else if(_s.volume <=0){
				_s.volume = 0;
			}

			_s.rewTm = _s.props.rewindTime;
			if(_s.rewTm == undefined || isNaN(_s.rewTm)) _s.rewTm = 10;
			if(_s.rewTm <=1){
				_s.rewTm = 1;
			}
		
			_s.buttonsToolTipFontColor_str = _s.props.buttonsToolTipFontColor || "#FF0000";
			_s.toolTipsButtonFontColor_str = _s.props.toolTipsButtonFontColor || "#FF0000";
			_s.shareAndEmbedTextColor_str = _s.props.shareAndEmbedTextColor || "#FF0000";
			_s.inputBackgroundColor_str = _s.props.inputBackgroundColor || "#FF0000";
			_s.inputColor_str = _s.props.inputColor || "#FF0000";
			_s.searchInputBackgroundColor_str = _s.props.searchInputBackgroundColor || "#FF0000";
			_s.borderColor_str = _s.props.borderColor || "#FF0000";
			_s.searchInputColor_str = _s.props.searchInputColor || "#FF0000";
			_s.youtubeAndFolderVideoTitleColor_str = _s.props.youtubeAndFolderVideoTitleColor || "#FF0000";
			_s.folderAudioSecondTitleColor_str = _s.props.folderAudioSecondTitleColor || "#666666";
			_s.youtubeDescriptionColor_str = _s.props.youtubeDescriptionColor || "#FF0000"; 
			_s.youtubeOwnerColor_str = _s.props.youtubeOwnerColor || "#FF0000";
			_s.secondaryLabelsColor_str = _s.props.secondaryLabelsColor || "#FF0000"; 
			_s.mainLabelsColor_str = _s.props.mainLabelsColor || "#FF0000"; 
			_s.playlistBackgroundColor_str = _s.props.playlistBackgroundColor || "#FF0000"; 
			_s.thumbnailNormalBackgroundColor_str = _s.props.thumbnailNormalBackgroundColor || "#FF0000"; 
			_s.playlistNameColor_str = _s.props.playlistNameColor || "#FF0000"; 
			_s.thumbnailHoverBackgroundColor_str = _s.props.thumbnailHoverBackgroundColor || "#FF0000"; 
			_s.thumbnailDisabledBackgroundColor_str = _s.props.thumbnailDisabledBackgroundColor || "#FF0000"; 
			_s.mainSelectorBackgroundSelectedColor = _s.props.mainSelectorBackgroundSelectedColor || "#FFFFFF";
			_s.mainSelectorTextNormalColor = _s.props.mainSelectorTextNormalColor || "#FFFFFF";
			_s.mainSelectorTextSelectedColor = _s.props.mainSelectorTextSelectedColor || "#000000";
			_s.mainButtonBackgroundNormalColor = _s.props.mainButtonBackgroundNormalColor || "#212021";
			_s.mainButtonBackgroundSelectedColor = _s.props.mainButtonBackgroundSelectedColor || "#FFFFFF"; 
			_s.mainButtonTextNormalColor = _s.props.mainButtonTextNormalColor || "#FFFFFF";
			_s.mainButtonTextSelectedColor = _s.props.mainButtonTextSelectedColor || "#000000";
			_s.logoLink_str = _s.props.logoLink || "none"; 
			_s.logoTarget = _s.props.logoTarget || "_self"; 

			_s.startAtVideo = parseInt(_s.props.startAtVideo) || 0;
			_s.audioVisualizerLinesColor_str = _s.props.audioVisualizerLinesColor || "#0099FF";
			_s.audioVisualizerCircleColor_str = _s.props.audioVisualizerCircleColor || "#FFFFFF";
			_s.privateVideoPassword_str = _s.props.privateVideoPassword;
			_s.youtubeAPIKey = _s.props.youtubeAPIKey || 'AIzaSyCgbixU3aIWCkiZ76h_E-XpEGig5mFhnVY'; 

			_s.contextMenuBackgroundColor_str = _s.props.contextMenuBackgroundColor || "#000000";
			_s.contextMenuBorderColor_str = _s.props.contextMenuBorderColor || "#FF0000";
			_s.contextMenuSpacerColor_str = _s.props.contextMenuSpacerColor || "#FF0000";
			_s.contextMenuItemNormalColor_str = _s.props.contextMenuItemNormalColor || "#FF0000";
			_s.contextMenuItemSelectedColor_str = _s.props.contextMenuItemSelectedColor || "#FF0000";
			_s.contextMenuItemDisabledColor_str = _s.props.contextMenuItemDisabledColor || "#FF0000";

			_s.showScriptDeveloper_bl = _s.props.showScriptDeveloper;
			_s.showScriptDeveloper_bl = _s.showScriptDeveloper_bl == "yes" ? true : false;

			_s.showContextmenu_bl = _s.props.showContextmenu;
			_s.showContextmenu_bl = _s.showContextmenu_bl == "no" ? false : true;

			_s.useFingerPrintStamp = _s.props.useFingerPrintStamp;
			_s.useFingerPrintStamp = _s.useFingerPrintStamp == "yes" ? true : false;
			if(!window['fwduvpFingerPrintStamp']) _s.useFingerPrintStamp = false;
			_s.frequencyOfFingerPrintStamp = _s.props.frequencyOfFingerPrintStamp || 5000;
			_s.durationOfFingerPrintStamp = _s.props.durationOfFingerPrintStamp || 400;

			_s.nextAndPrevSetButtonsMargins = _s.props.nextAndPrevSetButtonsMargins || 0;
			_s.buttonsMargins = _s.props.buttonsMargins || 0; 
			_s.thumbnailMaxWidth = _s.props.thumbnailMaxWidth || 330; 
			_s.thumbnailMaxHeight = _s.props.thumbnailMaxHeight || 330;
			_s.horizontalSpaceBetweenThumbnails = _s.props.horizontalSpaceBetweenThumbnails;
			_s.verticalSpaceBetweenThumbnails = _s.props.verticalSpaceBetweenThumbnails;
			_s.totalPlaylists = _s.cats_ar.length;
			_s.controllerHeight = _s.props.controllerHeight || 50;
			_s.startSpaceBetweenButtons = _s.props.startSpaceBetweenButtons || 0;
			_s.controllerHideDelay = _s.props.controllerHideDelay || 2;
			_s.controllerHideDelay *= 1000;
			_s.spaceBetweenButtons = _s.props.spaceBetweenButtons || 0;
			_s.scrubbersOffsetWidth = _s.props.scrubbersOffsetWidth || 0;
			_s.mainScrubberOffestTop = _s.props.mainScrubberOffestTop || 0;
			_s.volumeScrubberOffsetTopWidth = _s.props.volumeScrubberOffsetTopWidth || 0;
			_s.timeOffsetLeftWidth = _s.props.timeOffsetLeftWidth || 0;
			_s.timeOffsetRightWidth = _s.props.timeOffsetRightWidth || 0;
			_s.timeOffsetTop = _s.props.timeOffsetTop || 0;
			_s.embedWindowCloseButtonMargins = _s.props.embedAndInfoWindowCloseButtonMargins || 0;
			_s.logoMargins = _s.props.logoMargins || 0;
			_s.maxPlaylistItems = _s.props.maxPlaylistItems || 50;
			_s.volumeScrubberHeight = _s.props.volumeScrubberHeight || 10;
			_s.volumeScrubberOfsetHeight = _s.props.volumeScrubberOfsetHeight || 0;
			if(_s.volumeScrubberHeight > 200) _s.volumeScrubberHeight = 200;
			_s.buttonsToolTipHideDelay = _s.props.buttonsToolTipHideDelay || 1.5;
			_s.thumbnailWidth = _s.props.thumbnailWidth || 80;
			_s.thumbnailHeight = _s.props.thumbnailHeight || 80;

			_s.spaceBetweenThumbnails = _s.props.spaceBetweenThumbnails || 0;
			_s.timeOffsetTop = _s.props.timeOffsetTop || 0;
			_s.scrollbarOffestWidth = _s.props.scrollbarOffestWidth || 0;
			_s.scollbarSpeedSensitivity = _s.props.scollbarSpeedSensitivity || .5;
			_s.facebookAppId_str = _s.props.facebookAppId;
			
			_s.aopwBorderSize = _s.props.aopwBorderSize || 0; 
			_s.aopwTitle = _s.props.aopwTitle || "Advertisement";
			_s.aopwTitleColor_str = _s.props.aopwTitleColor || "#FFFFFF"; 
			_s.aopwWidth = _s.props.aopwWidth || 200; 
			_s.aopwHeight = _s.props.aopwHeight || 200; 
			
			_s.fillEntireVideoScreen_bl = _s.props.fillEntireVideoScreen; 
			_s.fillEntireVideoScreen_bl = _s.fillEntireVideoScreen_bl == "yes" ? true : false;

			_s.fillEntireposterScreen_bl = _s.props.fillEntireposterScreen; 
			_s.fillEntireposterScreen_bl = _s.fillEntireposterScreen_bl == "yes" ? true : false;

			_s.goFullScreenOnPlay_bl = _s.props.goFullScreenOnButtonPlay; 
			_s.goFullScreenOnPlay_bl = _s.goFullScreenOnPlay_bl == "yes" ? true : false;
			
			_s.showContextMenu_bl = _s.props.showContextMenu; 
			_s.showContextMenu_bl = _s.showContextMenu_bl == "no" ? false : true;
			
			_s.showController_bl = _s.props.showController; 
			_s.showController_bl = _s.showController_bl == "no" ? false : true;
			
			_s.showButtonsToolTip_bl = _s.props.showButtonsToolTips; 
			_s.showButtonsToolTip_bl = _s.showButtonsToolTip_bl == "no" ? false : true;
			if(_s.isMbl) _s.showButtonsToolTip_bl = false;
			
			_s.addKeyboardSupport_bl = _s.props.addKeyboardSupport; 
			_s.addKeyboardSupport_bl = _s.addKeyboardSupport_bl == "no" ? false : true;

			_s.playsinline = _s.props.playsinline == "yes" ? true : false;

			_s.useAToB = _s.props.useAToB == "yes" ? true : false;
			_s.atbTimeBackgroundColor = _s.props.atbTimeBackgroundColor || "transparent";
			_s.atbTimeTextColorNormal = _s.props.atbTimeTextColorNormal ||  "#888888";
			_s.atbTimeTextColorSelected = _s.props.atbTimeTextColorSelected || "#FFFFFF";
			_s.atbButtonTextNormalColor = _s.props.atbButtonTextNormalColor || "#888888";
			_s.atbButtonTextSelectedColor = _s.props.atbButtonTextSelectedColor || "#FFFFFF";
			_s.atbButtonBackgroundNormalColor = _s.props.atbButtonBackgroundNormalColor || "#FFFFFF";
			_s.atbButtonBackgroundSelectedColor = _s.props.atbButtonBackgroundSelectedColor || "#000000";
			
			_s.addMouseWheelSupport_bl = _s.props.addMouseWheelSupport; 
			_s.addMouseWheelSupport_bl = _s.addMouseWheelSupport_bl == "no" ? false : true;

			_s.addScrOnMM_bl = _s.props.addScrollOnMouseMove; 
			_s.addScrOnMM_bl = _s.addScrOnMM_bl == "yes" ? true : false;
			
			_s.showPlaylistsSearchInput_bl = _s.props.showPlaylistsSearchInput; 
			_s.showPlaylistsSearchInput_bl = _s.showPlaylistsSearchInput_bl == "yes" ? true : false;
		
			_s.scrubbersToolTipLabelBackgroundColor = _s.props.scrubbersToolTipLabelBackgroundColor || "#FFFFFF";
			_s.scrubbersToolTipLabelFontColor  = _s.props.scrubbersToolTipLabelFontColor || "#000000";
		
			_s.autoPlay_bl = _s.props.autoPlay; 
			_s.autoPlay_bl = _s.autoPlay_bl == "yes" ? true : false;
			_s.autoPlayText = _s.props.autoPlayText || '';
			
			_s.showNextAndPrevButtons_bl = _s.props.showNextAndPrevButtons; 
			_s.showNextAndPrevButtons_bl = _s.showNextAndPrevButtons_bl == "no" ? false : true;
			
			_s.showPlaylistsButtonAndPlaylists_bl = _s.props.showPlaylistsButtonAndPlaylists;
			_s.showPlaylistsButtonAndPlaylists_bl = _s.showPlaylistsButtonAndPlaylists_bl == "no" ? false : true;
			
			_s.showEmbedButton_bl = _s.props.showEmbedButton;
			_s.showEmbedButton_bl = _s.showEmbedButton_bl == "no" ? false : true;

			_s.showScrubberWhenControllerIsHidden_bl = _s.props.showScrubberWhenControllerIsHidden; 
			_s.showScrubberWhenControllerIsHidden_bl = _s.showScrubberWhenControllerIsHidden_bl == "no" ? false : true;

			_s.showMainScrubberToolTipLabel_bl = _s.props.showMainScrubberToolTipLabel;
			_s.showMainScrubberToolTipLabel_bl = _s.showMainScrubberToolTipLabel_bl == "yes" ? true : false;
			
			_s.showPlaylistsByDefault_bl = _s.props.showPlaylistsByDefault; 
			_s.showPlaylistsByDefault_bl = _s.showPlaylistsByDefault_bl == "yes" ? true : false;
			
			_s.loop_bl = _s.props.loop; 
			_s.loop_bl = _s.loop_bl == "yes" ? true : false;
			
			_s.shuffle_bl = _s.props.shuffle; 
			_s.shuffle_bl = _s.shuffle_bl == "yes" ? true : false;
			
			_s.showLoopButton_bl = _s.props.showLoopButton; 
			_s.showLoopButton_bl = _s.props.showLoopButton == "no" ? false : true;
			
			_s.showShuffleButton_bl = _s.props.showShuffleButton; 
			_s.showShuffleButton_bl = _s.props.showShuffleButton == "no" ? false : true;
			
			_s.showDownloadVideoButton_bl = _s.props.showDownloadButton; 
			_s.showDownloadVideoButton_bl = _s.showDownloadVideoButton_bl == "no" ? false : true;

			_s.randomizePlaylist_bl = _s.props.randomizePlaylist; 
			_s.randomizePlaylist_bl = _s.randomizePlaylist_bl == "yes" ? true : false;
			
			_s.showDefaultControllerForVimeo_bl = _s.props.showDefaultControllerForVimeo; 
			_s.showDefaultControllerForVimeo_bl = _s.showDefaultControllerForVimeo_bl == "yes" ? true : false;
			
			_s.showInfoButton_bl = _s.props.showInfoButton; 
			_s.showInfoButton_bl = _s.showInfoButton_bl == "no" ? false : true;
		
			_s.showLogo_bl = _s.props.showLogo; 
			_s.showLogo_bl = _s.showLogo_bl == "yes" ? true : false;
			
			_s.hideLogoWithController_bl = _s.props.hideLogoWithController;
			_s.hideLogoWithController_bl = _s.hideLogoWithController_bl == "yes" ? true : false;
			
			_s.showPoster_bl = _s.props.showPoster; 
			_s.showPoster_bl = _s.showPoster_bl == "yes" ? true : false;
			
			_s.useVectorIcons_bl = _s.props.useVectorIcons; 
			_s.useVectorIcons_bl = _s.useVectorIcons_bl == "yes" ? true : false;
			
			_s.showVolumeButton_bl = _s.props.showVolumeButton; 
			_s.showVolumeButton_bl = _s.showVolumeButton_bl == "no" ? false : true;
			
			_s.showVolumeScrubber_bl = _s.showVolumeButton_bl;
			
			_s.showControllerWhenVideoIsStopped_bl = _s.props.showControllerWhenVideoIsStopped; 
			_s.showControllerWhenVideoIsStopped_bl = _s.showControllerWhenVideoIsStopped_bl == "yes" ? true : false;
			
			_s.showNextAndPrevButtonsInController_bl = _s.props.showNextAndPrevButtonsInController; 
			_s.showNextAndPrevButtonsInController_bl = _s.showNextAndPrevButtonsInController_bl == "yes" ? true : false;
			
			_s.showTime_bl = _s.props.showTime; 
			_s.showTime_bl = _s.showTime_bl == "no" ? false : true;
			
			_s.shwPpoppAdClsBtn = _s.props.showPopupAdsCloseButton; 
			_s.shwPpoppAdClsBtn = _s.shwPpoppAdClsBtn == "no" ? false : true
			
			_s.showRewindButton_bl = _s.props.showRewindButton; 
			_s.showRewindButton_bl = _s.showRewindButton_bl == "no" ? false : true;
			
			_s.disableVideoScrubber_bl = _s.props.disableVideoScrubber; 
			_s.disableVideoScrubber_bl = _s.disableVideoScrubber_bl == "yes" ? true : false;
			
			_s.showPlaybackRateButton_bl = _s.props.showPlaybackRateButton;
			_s.showPlaybackRateButton_bl = _s.showPlaybackRateButton_bl == "yes" ? true : false;
			
			_s.defaultPlaybackRate_str = _s.props.defaultPlaybackRate;
			if(_s.defaultPlaybackRate_str ==  undefined) _s.defaultPlaybackRate_str = 1;
			_s.defaultPlaybackRate_ar = ["0.25", "0.5", "1", "1.25", "1.5", "2"];
			
			_s.defaultPlaybackRate_ar.reverse();
			var found_bl = false;
			for(var i=0; i<_s.defaultPlaybackRate_ar.length; i++){
				if(_s.defaultPlaybackRate_ar[i] == _s.defaultPlaybackRate_str){
					found_bl = true;
					_s.startAtPlaybackIndex = i;
				}
			}
			
			if(!found_bl){
				_s.startAtPlaybackIndex = 3;
				_s.defaultPlaybackRate_str = _s.defaultPlaybackRate_ar[_s.startAtPlaybackIndex];
			}
			
			_s.showFullScreenButton_bl = _s.props.showFullScreenButton; 
			_s.showFullScreenButton_bl = _s.showFullScreenButton_bl == "no" ? false : true;
			
			_s.repeatBackground_bl = _s.props.repeatBackground; 
			_s.repeatBackground_bl = _s.repeatBackground_bl == "no" ? false : true;
			
			//loggin
			_s.playVideoOnlyWhenLoggedIn_bl = _s.props.playVideoOnlyWhenLoggedIn; 
			_s.playVideoOnlyWhenLoggedIn_bl = _s.playVideoOnlyWhenLoggedIn_bl == "yes" ? true : false;
			
			_s.playIfLoggedIn = _s.props.playIfLoggedIn; 
			_s.playIfLoggedIn = _s.playIfLoggedIn == "yes" ? true : false;
			_s.playIfLoggedInMessage = _s.props.playIfLoggedInMessage || 'Please loggin';
			
			_s.showShareButton_bl = _s.props.showShareButton; 
			_s.showShareButton_bl = _s.showShareButton_bl == "no" ? false : true;
			
			_s.openNewPageAtTheEndOfTheAds_bl =  _s.props.openNewPageAtTheEndOfTheAds;
			_s.openNewPageAtTheEndOfTheAds_bl = _s.openNewPageAtTheEndOfTheAds_bl == "yes" ? true : false;
			
			_s.playAdsOnlyOnce_bl =  _s.props.playAdsOnlyOnce;
			_s.playAdsOnlyOnce_bl = _s.playAdsOnlyOnce_bl == "yes" ? true : false;
			
			_s.startAtRandomVideo_bl =  _s.props.startAtRandomVideo;
			_s.startAtRandomVideo_bl = _s.startAtRandomVideo_bl == "yes" ? true : false;
			
			_s.stopVideoWhenPlayComplete_bl =  _s.props.stopVideoWhenPlayComplete;
			_s.stopVideoWhenPlayComplete_bl = _s.stopVideoWhenPlayComplete_bl == "yes" ? true : false;

			_s.closeLightBoxWhenPlayComplete =  _s.props.closeLightBoxWhenPlayComplete;
			_s.closeLightBoxWhenPlayComplete = _s.closeLightBoxWhenPlayComplete == "yes" ? true : false;

			_s.showYoutubeQualityButton_bl = _s.props.showQualityButton; 
			_s.showYoutubeQualityButton_bl = _s.showYoutubeQualityButton_bl == "no" ? false : true;

			_s.showAudioTracksButton_bl = _s.props.showAudioTracksButton; 
			_s.showAudioTracksButton_bl = _s.showAudioTracksButton_bl == "no" ? false : true;
			
			_s.thumbnailsPreviewWidth = _s.props.thumbnailsPreviewWidth || 300
			_s.thumbnailsPreviewHeight = _s.props.thumbnailsPreviewHeight || 168
			_s.thumbnailsPreviewBackgroundColor =  _s.props.thumbnailsPreviewBackgroundColor || "#000";
			_s.thumbnailsPreviewBorderColor =	_s.props.thumbnailsPreviewBorderColor || "#333";
			_s.thumbnailsPreviewLabelBackgroundColor =	_s.props.thumbnailsPreviewLabelBackgroundColor || "#FFF";
			_s.thumbnailsPreviewLabelFontColor =	_s.props.thumbnailsPreviewLabelFontColor || "#000";
			
			_s.arrowN_str = _s.sknPth + "combobox-arrow-normal.png";
			_s.arrowS_str = _s.sknPth + "combobox-arrow-selected.png";
			
			_s.hlsPath_str = _s.mainFolderPath_str  + "java/hls.js";
			_s.dashPath_str = _s.mainFolderPath_str  + "java/dash.all.min.js";
			_s.threeJsPath_str = _s.mainFolderPath_str  + "java/three.js";
			_s.threeJsControlsPath_str = _s.mainFolderPath_str  + "java/threeControled.js";

			_s.isDark = true;
			if(_s.sknPth.indexOf('dark') == -1){
				_s.isDark = false;
			}
			
			_s.logoPath_str = _s.sknPth + "logo.png";
			_s.adLinePat_str = _s.sknPth + "ad-line.png";
			if(_s.props.logoPath) _s.logoPath_str = _s.props.logoPath;
			
			_s.mainScrubberDragLeftAddPath_str = _s.sknPth + "scrubber-left-drag-add.png";
			_s.mainScrubberDragMiddleAddPath_str = _s.sknPth + "scrubber-middle-drag-add.png";
		
			_s.mainPreloader_img = new Image();
			_s.mainPreloader_img.onerror = _s.onSkinLoadErrorHandler;
			_s.mainPreloader_img.onload = _s.onPreloaderLoadHandler;
			_s.mainPreloader_img.src = _s.sknPth + "preloader.jpg";
			
			_s.hdIcn = _s.sknPth + 'hd.png';

			_s.skinPaths_ar = [
				 {img:_s.skipIconPath_img = new Image(), src:_s.sknPth + "skip-icon.png"},
                 {img:_s.mainScrubberBkLeft_img = new Image(), src:_s.sknPth + "scrubber-left-background.png"},
                 {img:_s.mainScrubberDragLeft_img = new Image(), src:_s.sknPth + "scrubber-left-drag.png"},
                 {img:_s.mainScrubberLine_img = new Image(), src:_s.sknPth + "scrubber-line.png"},
                 {img:_s.progressLeft_img = new Image(), src:_s.sknPth + "progress-left.png"},
				 {img:_s.volumeScrubberDragBottom_img = new Image(), src:_s.sknPth + "volume-scrubber-bottom-drag.png"},
				 {img:_s.popwColseN_img = new Image(), src:_s.sknPth + "popw-close-button.png"},
				 {img:_s.embedColoseN_img = new Image(), src:_s.sknPth + "embed-close-button.png"}

			];
			
			if(!_s.useVectorIcons_bl){
				_s.skinPaths_ar.push(
					 {img:_s.prevN_img = new Image(), src:_s.sknPth + "prev-video.png"},
					 {img:_s.nextN_img = new Image(), src:_s.sknPth + "next-video.png"},
					 {img:_s.playN_img = new Image(), src:_s.sknPth + "play.png"},
					 {img:_s.pauseN_img = new Image(), src:_s.sknPth + "pause.png"},
				     {img:_s.volumeN_img = new Image(), src:_s.sknPth + "volume.png"},
					 {img:_s.largePlayN_img = new Image(), src:_s.sknPth + "large-play.png"},
					 {img:_s.categoriesN_img = new Image(), src:_s.sknPth + "categories-button.png"},
					 {img:_s.replayN_img = new Image(), src:_s.sknPth + "replay-button.png"},
					 {img:_s.shuffleN_img = new Image(), src:_s.sknPth + "shuffle-button.png"},
					 {img:_s.fullScreenN_img = new Image(), src:_s.sknPth + "full-screen.png"},
					 {img:_s.ytbQualityN_img = new Image(), src:_s.sknPth + "youtube-quality.png"},
					 {img:_s.shareN_img = new Image(), src:_s.sknPth + "share.png"},
					 {img:_s.facebookN_img = new Image(), src:_s.sknPth + "facebook.png"},
					 {img:_s.infoN_img = new Image(), src:_s.sknPth + "info-button.png"},
					 {img:_s.downloadN_img = new Image(), src:_s.sknPth + "download-button.png"},
					 {img:_s.normalScreenN_img = new Image(), src:_s.sknPth + "normal-screen.png"},
					 {img:_s.embedN_img = new Image(), src:_s.sknPth + "embed.png"},
					 {img:_s.passColoseN_img = new Image(), src:_s.sknPth + "embed-close-button.png"},
					 {img:_s.showSubtitleNPath_img = new Image(), src:_s.sknPth + "show-subtitle-icon.png"},
					 {img:_s.hideSubtitleNPath_img = new Image(), src:_s.sknPth + "hide-subtitle-icon.png"},
					 {img:_s.playbackRateNPath_img = new Image(), src:_s.sknPth + "playback-rate-normal.png"}
				)

				if(_s.useAToB){
					_s.skinPaths_ar.push(
						{img:_s.atbNPath_img = new Image(), src:_s.sknPth + "a-to-b-button.png"}
					)
				}
			}
			
			if((_s.showOpener_bl && prt.displayType == FWDUVPlayer.STICKY) 
				|| (_s.stickyOnScrollShowOpener_bl && prt.stickyOnScroll)){
				_s.skinPaths_ar.push(
					 {img:_s.openerPauseN_img = new Image(), src:_s.sknPth + "open-pause-button-normal.png"},
					 {img:_s.openerPlayN_img = new Image(), src:_s.sknPth + "open-play-button-normal.png"},
					 {img:_s.animationPath_img = new Image(), src:_s.sknPth + "equalizer.png"},
					 {img:_s.closeN_img = new Image(), src:_s.sknPth + "opener-close.png"},
					 {img:_s.openTopN_img = new Image(), src:_s.sknPth + "open-button-normal-top.png"},
					 {img:_s.openBottomN_img = new Image(), src:_s.sknPth + "open-button-normal-bottom.png"}
					 
				)
				_s.openerPauseS_str = _s.sknPth + "open-pause-button-selected.png";
				_s.openerPlayS_str = _s.sknPth + "open-play-button-selected.png";
				_s.openerAnimationPath_str = _s.sknPth + "equalizer.png";	
				_s.openTopSPath_str = _s.sknPth + "open-button-selected-top.png";	
				_s.openBottomSPath_str = _s.sknPth + "open-button-selected-bottom.png";	
				_s.openTopSPath_str = _s.sknPth + "open-button-selected-top.png";
				_s.openBottomSPath_str = _s.sknPth + "open-button-selected-bottom.png";
				
				_s.closeSPath_str = _s.sknPth + "opener-close-over.png"
			}
			
			if(_s.showRewindButton_bl){
				_s.skinPaths_ar.push(
					 {img:_s.rewindN_img = new Image(), src:_s.sknPth + "rewind.png"}
				)
				_s.rewindSPath_str = _s.sknPth + "rewind-over.png";
			}

			if(_s.showInfoButton_bl){
				_s.skinPaths_ar.push(
					{img:_s.infoWindowClooseN_img = new Image(), src:_s.sknPth + "embed-close-button.png"}
				)
			}
			
			if(_s.showNextAndPrevButtonsInController_bl && !_s.useVectorIcons_bl){
				_s.skinPaths_ar.push(
					{img:_s.next2N_img = new Image(), src:_s.sknPth + "next-video.png"},
					{img:_s.prev2N_img = new Image(), src:_s.sknPth + "prev-video.png"}
				)
			}

			if(_s.show360DegreeVideoVrButton_bl){
				_s.skinPaths_ar.push(
					{img:_s.vr_img = new Image(), src:_s.sknPth + "vr.png"}
				)
				_s.vrSPath_img = _s.sknPth + "vr-over.png";
			}	

			if(_s.showAudioTracksButton_bl){
				_s.skinPaths_ar.push(
					{img:_s.at_img = new Image(), src:_s.sknPth + "at.png"}
				)
				_s.atSPath_img = _s.sknPth + "at-over.png";
			}	
			
			
			if(_s.showShareButton_bl && !_s.useVectorIcons_bl){
				_s.skinPaths_ar.push(
					{img:_s.shareClooseN_img = new Image(), src:_s.sknPth + "embed-close-button.png"},
					{img:_s.facebookN_img = new Image(), src:_s.sknPth + "facebook.png"},
					{img:_s.googleN_img = new Image(), src:_s.sknPth + "google-plus.png"},
					{img:_s.twitterN_img = new Image(), src:_s.sknPth + "twitter.png"},
					{img:_s.likedInkN_img = new Image(), src:_s.sknPth + "likedin.png"},
					{img:_s.bufferkN_img = new Image(), src:_s.sknPth + "buffer.png"},
					{img:_s.diggN_img = new Image(), src:_s.sknPth + "digg.png"},
					{img:_s.redditN_img = new Image(), src:_s.sknPth + "reddit.png"},
					{img:_s.thumbrlN_img = new Image(), src:_s.sknPth + "thumbrl.png"}
				)
				
				_s.facebookSPath_str = _s.sknPth + "facebook-over.png";
				_s.googleSPath_str = _s.sknPth + "google-plus-over.png";
				_s.twitterSPath_str = _s.sknPth + "twitter-over.png";
				_s.likedInSPath_str = _s.sknPth + "likedin-over.png";
				_s.bufferSPath_str = _s.sknPth + "buffer-over.png";
				_s.diggSPath_str = _s.sknPth + "digg-over.png";
				_s.redditSPath_str = _s.sknPth + "reddit-over.png";
				_s.thumbrlSPath_str = _s.sknPth + "thumbrl-over.png";
			}
			
			//setup skin paths
			_s.atbSPath_str = _s.sknPth + "a-to-b-button-over.png";
			_s.popwColseSPath_str = _s.sknPth + "popw-close-button-over.png";
			_s.popwWindowBackgroundPath_str = _s.sknPth + "popw-window-background.png";
			_s.popwBarBackgroundPath_str = _s.sknPth + "popw-bar-background.png";
			_s.playbackRateSPath_str = _s.sknPth + "playback-rate-selected.png";
			_s.prevSPath_str = _s.sknPth + "prev-video-over.png"; 
			_s.nextSPath_str = _s.sknPth + "next-video-over.png"; 
			_s.playSPath_str = _s.sknPth + "play-over.png"; 
			_s.pauseSPath_str = _s.sknPth + "pause-over.png";
			_s.bkMiddlePath_str = _s.sknPth + "controller-middle.png";
			_s.hdPath_str = _s.sknPth + "hd.png";
			_s.youtubeQualityArrowPath_str = _s.sknPth + "youtube-quality-arrow.png";
			_s.ytbQualityButtonPointerPath_str = _s.sknPth + "youtube-quality-pointer.png";
			_s.controllerBkPath_str = _s.sknPth + "controller-background.png";
			_s.skipIconSPath_str = _s.sknPth + "skip-icon-over.png";
			_s.adsBackgroundPath_str = _s.sknPth + "ads-background.png";
			_s.shareSPath_str = _s.sknPth + "share-over.png";

			_s.mainScrubberBkRightPath_str = _s.sknPth + "scrubber-right-background.png";
			_s.mainScrubberBkMiddlePath_str = _s.sknPth + "scrubber-middle-background.png";
			_s.mainScrubberDragMiddlePath_str = _s.sknPth + "scrubber-middle-drag.png";
		
			_s.volumeScrubberBkBottomPath_str = _s.sknPth + "volume-scrubber-bottom-background.png"; 
			_s.volumeScrubberBkMiddlePath_str = _s.sknPth + "volume-scrubber-middle-background.png";
			_s.volumeScrubberBkTopPath_str = _s.sknPth + "volume-scrubber-top-background.png";
			_s.volumeScrubberDragBottomPath_str = _s.sknPth + "volume-scrubber-bottom-drag.png";
			_s.volumeScrubberLinePath_str = _s.sknPth + "volume-scrubber-line.png";
			_s.volumeScrubberDragMiddlePath_str = _s.sknPth + "volume-scrubber-middle-drag.png";	
		
			_s.volumeSPath_str = _s.sknPth + "volume-over.png";
			_s.volumeDPath_str = _s.sknPth + "volume-disabled.png";
			_s.categoriesSPath_str = _s.sknPth + "categories-button-over.png";
			_s.replaySPath_str = _s.sknPth + "replay-button-over.png";
			_s.toopTipBk_str = _s.sknPth + "tooltip-background.png"; 
			_s.toopTipPointer_str = _s.sknPth + "tooltip-pointer.png"; 
			_s.shufflePathS_str = _s.sknPth + "shuffle-button-over.png";
			_s.passButtonNPath_str = _s.sknPth + "pass-button.png";
			_s.passButtonSPath_str = _s.sknPth + "pass-button-over.png";
			
			_s.largePlayS_str = _s.sknPth + "large-play-over.png";
			_s.fullScreenSPath_str = _s.sknPth + "full-screen-over.png";
			_s.ytbQualitySPath_str = _s.sknPth + "youtube-quality-over.png";
			_s.ytbQualityDPath_str = _s.sknPth + "youtube-quality-hd.png";
			_s.facebookSPath_str = _s.sknPth + "facebook-over.png";
			_s.infoSPath_str = _s.sknPth + "info-button-over.png";
			_s.downloadSPath_str = _s.sknPth + "download-button-over.png";
			_s.normalScreenSPath_str = _s.sknPth + "normal-screen-over.png";
			_s.progressMiddlePath_str = _s.sknPth + "progress-middle.png";
			_s.embedPathS_str = _s.sknPth + "embed-over.png";
			_s.embedWindowClosePathS_str = _s.sknPth + "embed-close-button-over.png"; 
			_s.embedWindowInputBackgroundPath_str = _s.sknPth + "embed-window-input-background.png";
			_s.embedCopyButtonNPath_str = _s.sknPth + "embed-copy-button.png";
			_s.embedCopyButtonSPath_str = _s.sknPth + "embed-copy-button-over.png";
			_s.sendButtonNPath_str = _s.sknPth + "send-button.png";
			_s.sendButtonSPath_str = _s.sknPth + "send-button-over.png";
			_s.embedWindowBackground_str = _s.sknPth + "embed-window-background.png";
			_s.showSubtitleSPath_str = _s.sknPth + "show-subtitle-icon-over.png";
			_s.hideSubtitleSPath_str = _s.sknPth + "hide-subtitle-icon-over.png";
			_s.inputArrowPath_str = _s.sknPth + "input-arrow.png"; 
			
			if(_s.showPlaylistsButtonAndPlaylists_bl){
				_s.skinPaths_ar.push(
				    {img:new Image(), src:_s.sknPth + "categories-background.png"}
				);
				
				if(!_s.useVectorIcons_bl){
					_s.skinPaths_ar.push(
						{img:_s.catNextN_img = new Image(), src:_s.sknPth + "categories-next-button.png"},
						{img:_s.catPrevN_img = new Image(), src:_s.sknPth + "categories-prev-button.png"},
						{img:_s.catCloseN_img = new Image(), src:_s.sknPth + "categories-close-button.png"}
					)
				}
				_s.catBkPath_str = _s.sknPth + "categories-background.png"; 
				_s.catThumbBkPath_str = _s.sknPth + "categories-thumbnail-background.png"; 
				_s.catThumbBkTextPath_str = _s.sknPth + "categories-thumbnail-text-backgorund.png"; 
				_s.catNextSPath_str = _s.sknPth + "categories-next-button-over.png"; 
				_s.catPrevSPath_str = _s.sknPth + "categories-prev-button-over.png"; 
				_s.catCloseSPath_str = _s.sknPth + "categories-close-button-over.png"; 
			}
			
			_s.poppAdClsNPth = _s.sknPth + "close-button-normal.png"; 
			_s.poppAdClsSPth = _s.sknPth + "close-button-selected.png"; 
			
			_s.annotationAddCloseNPath_str = _s.sknPth + "annotation-close-button-normal.png"; 
			_s.annotationAddCloseSPath_str = _s.sknPth + "annotation-close-button-selected.png";
			
			if(_s.showPlaylistButtonAndPlaylist_bl){
				var prevThumbsSetNPath_str;
				
				_s.playlistThumbnailsBkPath_str = _s.sknPth + "playlist-thumbnail-background.png";
				_s.playlistBkPath_str = _s.sknPth + "playlist-background.png";
				
				if(_s.playlistPosition_str == "bottom"){
					_s.skinPaths_ar.push(
					    {img:_s.hidePlaylistN_img = new Image(), src:_s.sknPth + "hide-horizontal-playlist.png"},
					    {img:_s.showPlaylistN_img = new Image(), src:_s.sknPth + "show-horizontal-playlist.png"}
					);
					_s.hidePlaylistSPath_str = _s.sknPth + "hide-horizontal-playlist-over.png"; 
					_s.showPlaylistSPath_str = _s.sknPth + "show-horizontal-playlist-over.png"; 
				}else{
					_s.skinPaths_ar.push(
					    {img:_s.hidePlaylistN_img = new Image(), src:_s.sknPth + "hide-vertical-playlist.png"},
					    {img:_s.showPlaylistN_img = new Image(), src:_s.sknPth + "show-vertical-playlist.png"}
					);
					_s.hidePlaylistSPath_str = _s.sknPth + "hide-vertical-playlist-over.png"; 
					_s.showPlaylistSPath_str = _s.sknPth + "show-vertical-playlist-over.png"; 
				}
				
				_s.skinPaths_ar.push(
				    {img:_s.scrBkTop_img = new Image(), src:_s.sknPth + "playlist-scrollbar-background-top.png"},
				    {img:_s.scrDragTop_img = new Image(), src:_s.sknPth + "playlist-scrollbar-drag-top.png"},
				    {img:_s.scrLinesN_img = new Image(), src:_s.sknPth + "playlist-scrollbar-lines.png"}
				);
				
				_s.scrBkMiddlePath_str = _s.sknPth + "playlist-scrollbar-background-middle.png";
				_s.scrBkBottomPath_str = _s.sknPth + "playlist-scrollbar-background-bottom.png";
				_s.scrDragMiddlePath_str = _s.sknPth + "playlist-scrollbar-drag-middle.png";
				_s.scrDragBottomPath_str = _s.sknPth + "playlist-scrollbar-drag-bottom.png";
				_s.scrLinesSPath_str = _s.sknPth + "playlist-scrollbar-lines-over.png";
				_s.inputArrowPath_str = _s.sknPth + "input-arrow.png";
			}

			if(_s.showChromecastButton_bl){
				_s.skinPaths_ar.push(
					{img:_s.castN_img = new Image(), src:_s.sknPth + "cast.png"},
					{img:_s.uncastN_img = new Image(), src:_s.sknPth + "uncast.png"}
				)
				_s.castSPath_str = _s.sknPth + "cast-over.png";
				_s.uncastSPath_str = _s.sknPth + "uncast-over.png";
			}
			
			_s.totalGraphics = _s.skinPaths_ar.length;
		};
		

		//####################################//
		/* Preloader load done! */
		//###################################//
		_s.onPreloaderLoadHandler = function(){
			_s.countLoadedSCript = 0;
			_s.scripts = [];
			if(_s.useAToB){
				_s.scripts.push('FWDUVPATB.js');
			}
			if(_s.thumbnailsPreview){
				_s.scripts.push('FWDUVPThumbnailsPreview.js');
			}
			if(_s.showChromecastButton_bl){
				_s.scripts.push('https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1');
				_s.scripts.push('FWDUVPCC.js');
			}

			if(_s.useFingerPrintStamp){
				_s.scripts.push('FWDUVPFPS.js');
			}
			_s.totalScripts = _s.scripts.length;

			_s.dispatchEvent(FWDUVPData.PRELOADER_LOAD_DONE);
			_s.loadPlugin();
		};

		_s.loadPlugin = function(){
			if(_s.countLoadedSCript == _s.totalScripts){
				_s.loadSkin();	
			}else{
				var script = document.createElement('script');
				var scriptURI = _s.scripts[_s.countLoadedSCript] 
				if(/\?/.test(scriptURI)){
					scriptURI += '&version=' + FWDUVPlayer.V;
				}else{
					scriptURI += '?version=' + FWDUVPlayer.V;
				}
				document.head.appendChild(script);
				if(scriptURI.indexOf('gstatic') != -1){
					script.src = scriptURI;
				}else{
					script.src =  _s.mainFolderPath_str + 'java/' + scriptURI;
				}
				
				script.onload = _s.loadPlugin;
				script.onerror = function(e){
					console.log(e);
					if(scriptURI == 'FWDUVPFPS.js'){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'You have enabled the FingerPrintstamp plugin, the fingerpintstamp js file named <font color="#FF0000">FWDUVPFPS.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPFPS.js</font> file. '});
					}else if(scriptURI == 'FWDUVPATB.js'){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'You have enabled the A to B plugin, the A to B js file named <font color="#FF0000">FWDUVPATB.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPATB.js</font> file. '});
					}else if(scriptURI == 'FWDUVPThumbnailsPreview.js'){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'You have enabled the thumbnal preview plugin, the thumbnail preview js file named <font color="#FF0000">FWDUVPThumbnailsPreview.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPThumbnailsPreview.js</font> file. '});
					}else if(scriptURI == 'FWDUVPCC.js'){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'You have enabled the chromecast plugin, the js file named <font color="#FF0000">FWDUVPCC.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPCC.js</font> file.'});
					}else if(scriptURI.indexOf('gstatic.js') != -1){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'Choromecast framework javascript file can\'t be loaded<font color="#FF0000"> ' + scriptURI +  ' </font>'});
					}
				
				}
			}
			_s.countLoadedSCript++;
		}

		
		//#####################################//
		/* Load IMA SDK */
		//#####################################//
		_s.countImaLoadedSCript = 0;
		_s.startToLoadIMA = function(){
			if(_s.imaScripts) return;
			_s.imaScripts = ['//imasdk.googleapis.com/js/sdkloader/ima3.js',  _s.mainFolderPath_str + 'java/FWDUVPIMA.js'];
			_s.totalImaScripts = _s.imaScripts.length;
			_s.loadIMA();
		}
		
		_s.loadIMA = function(){
			if(_s.countImaLoadedSCript == _s.totalImaScripts){
				_s.imaReady = true;
				_s.dispatchEvent(FWDUVPData.IMA_READY);
			}else{
				var script = document.createElement('script');
				var scriptURI = _s.imaScripts[_s.countImaLoadedSCript];
				document.head.appendChild(script);
				script.src = scriptURI;
				script.onload = _s.loadIMA;
				script.onerror = function(e){
					if(_s.countImaLoadedSCript == 1){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'IMA SDK can\'t be loaded'});
					}else if(_s.countImaLoadedSCript == 2){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'IMA file <font color="#FF0000">FWDUVPIMA.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPIMA.js</font> file. '});
					}
					_s.dispatchEvent(FWDUVPData.IMA_ERROR);
				}
				_s.countImaLoadedSCript++;
			}
		}
			
		
		//####################################//
		/* load buttons graphics */
		//###################################//
		_s.loadSkin = function(){
			var img;
			var src;
			for(var i=0; i<_s.totalGraphics; i++){
				img = _s.skinPaths_ar[i].img;
				src = _s.skinPaths_ar[i].src;
				img.onload = _s.onSkinLoadHandler;
				img.onerror = _s.onSkinLoadErrorHandler;
				img.src = src;
			}
		};
		
		_s.onSkinLoadHandler = function(e){
			_s.countLoadedSkinImages++;
			if(_s.countLoadedSkinImages == _s.totalGraphics){
				if(_s.showOnlyThumbnail){
					_s.thumbnailWidth = _s.thumbnailWidth - _s.scrBkTop_img.width;
					_s.showSearchInpt = false;
				}
				setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.SKIN_LOAD_COMPLETE);
				}, 50);
			}
		};
		
		_s.onSkinLoadErrorHandler = function(e){
			var message;
			if (FWDUVPUtils.isIEAndLessThen9){
				message = "Graphics image not found!";
			}else{
				message = "The skin icon with label <font color='#ff0000'>" + e.target.src + "</font> can't be loaded, check path!";
			}
			
			if(window.console) console.log(e);
			var err = {text:message};
			setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, err);
			}, 50);
		};
		

		//##########################################//
		/* Download video */
		//##########################################//
		_s.downloadVideo = function(sourcePath, pName){
				
			if(FWDUVPUtils.isLocal){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Downloading video files local is not allowed or possible! To function properly please test online."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
			
			if(!sourcePath){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Not allowed to download _s video!"});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
			
			if(!sourcePath.match(/\.mp3|\.mp4/ig)){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Only mp4 video files hosted on your server can be downloaded."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
				
			}
			
			var defaultSourcePath = sourcePath;
			var path1 = location.origin;
			var path2 = location.pathname;
		
			if(path2.indexOf(".") != -1){
				path2 = path2.substr(0, path2.lastIndexOf("/") + 1);
			}
			
			var hasHTTPorHTTPS_bl = sourcePath.indexOf("http:") == -1 && sourcePath.indexOf("https:") == -1;
		
			if(hasHTTPorHTTPS_bl){
				sourcePath = path1 + path2 + sourcePath;
			}
	
			if(!pName) return;
			pName = decodeURIComponent(pName);
			pName = pName.replace(/[^A-Z0-9\-\_\.]+/ig, "_");
		
			sourcePath = FWDUVPUtils.getValidSource(sourcePath);
			
			var url = _s.videoDownloaderPath_str;
			
			if(!_s.dlIframe){
				_s.dlIframe = document.createElement("IFRAME");
				_s.dlIframe.style.display = "none";
				document.documentElement.appendChild(_s.dlIframe);
			}
			
			if(_s.isMbl && !FWDUVPUtils.isAndroid){
				
				if(_s.openDownloadLinkOnMobile_bl){
					window.open(defaultSourcePath, "_blank");
					return;
				}
			
				var email = _s.getValidEmail();
				if(!email) return;
				
				if(_s.emailXHR != null){
					try{_s.emailXHR.abort();}catch(e){}
					_s.emailXHR.onreadystatechange = null;
					_s.emailXHR.onerror = null;
					_s.emailXHR = null;
				}
				
				_s.emailXHR = new XMLHttpRequest();
				
				_s.emailXHR.onreadystatechange = function(e){
					if(_s.emailXHR.readyState == 4){
						if(_s.emailXHR.status == 200){
							if(_s.emailXHR.responseText == "sent"){
								alert("Email sent.");
							}else{
								alert("Error sending email, _s is a server side error, the php file can't send the email!");
							}
							
						}else{
							alert("Error sending email: " + _s.emailXHR.status + ": " + _s.emailXHR.statusText);
						}
					}
				};
				
				_s.emailXHR.onerror = function(e){
					try{
						if(window.console) console.log(e);
						if(window.console) console.log(e.message);
					}catch(e){};
					alert("Error sending email: " + e.message);
				};

				_s.emailXHR.open("get", _s.mailPath_str + "?mail=" + email + "&name=" + pName + "&path=" + sourcePath, true);
				_s.emailXHR.send();
				return;
			}
			
		
			_s.dlIframe.src = url + "?path="+ sourcePath +"&name=" + pName;
		};
		
		
		_s.getValidEmail = function(){
			var email = prompt("Please enter your email address where the video download link will be sent:");
			var emailRegExp = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
			while(!emailRegExp.test(email) || email == ""){
				if(email === null) return;
				email = prompt("Please enter a valid email address:");
			}
			return email;
		};
		

		//####################################//
		/* load playlist */
		//####################################//
		_s.loadPlaylist = function(id){
			_s.id = id;
			_s.playlist_ar = undefined;
			_s.stopToLoadPlaylist();
			
			if(_s.isPlaylistDispatchingError_bl) return;
			
			clearTimeout(_s.dispatchPlaylistLoadCompleteWidthDelayId_to);
			var source = _s.catsRef_ar[id];

			if(source === undefined){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"<font color='#ff0000'>loadPlaylist()</font> - Please specify a DOM playlist id or youtube playlist id!"});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
			
			if(source === null){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"The playlist with id <font color='#ff0000'>" + _s.cats_ar[id].source + "</font> is not found in the DOM."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
		
			if(!isNaN(source)){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"<font color='#ff0000'>loadPlaylist()</font> - The parameter must be of type string!"});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}

			_s.resetYutubeVimeoPlaylistLoader();
			_s.isYoutbe_bl = false;
			_s.loadFromFolder_bl = false;
			_s.isVimeoAlbum_bl = false;
			_s.playlist_ar = [];
			_s.playlistPass = _s.cats_ar[id].pass;
			
			if(!source.length){
				_s.parseDOMPlaylist(source, _s.cats_ar[id].source);	
			}else if(source.indexOf("list=") != -1 || source.indexOf("youtube.") != -1){
				_s.isYoutbe_bl = true;
				_s.playlist_ar = _s.plsCache_ar[_s.id];
				if(_s.playlist_ar){
					_s.youtubePlLoadComplete();
				}else{
					_s.loadYoutubePlaylist(source);
				}
			}else if(source.indexOf("vimeo.com") != -1){
				_s.isVimeo_bl = true;
				_s.loadVimeoPlaylist(source, _s.cats_ar[id]['vimeoUserId'], _s.cats_ar[id]['clientId'], _s.cats_ar[id]['vimeoSecret'], _s.cats_ar[id]['vimeoToken']);
			}else if(source.indexOf("list=") != -1){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Loading youtube playlist is only possible by setting <font color='#ff0000'>useYoutube=\"yes\"</font>."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}else if(source.indexOf("folder=") != -1){
				_s.loadFolderPlaylist(source);
			}else if(source.indexOf(".xml") != -1
			  || source.indexOf("http:") != -1
			  || source.indexOf("https:") != -1
			  || source.indexOf("www.") != -1
			){
				_s.loadXMLPlaylist(source);
			}
		};

		
		//#######################################//
		/* load XML playlist (warning _s will will work only online on a web server,
		 * it is not working local!) */
		//######################################//
		_s.loadXMLPlaylist = function(url){
			if(_s.isPlaylistDispatchingError_bl) return;
			
			if(document.location.protocol == "file:"){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Loading XML files local is not allowed or possible!. To function properly please test online."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
			
			_s.sourceURL_str = url;
			_s.xhr = new XMLHttpRequest();
			_s.xhr.onreadystatechange = _s.ajaxOnLoadHandler;
			_s.xhr.onerror = _s.ajaxOnErrorHandler;
			
			try{
				_s.xhr.open("get", _s.proxyPath_str + "?url=" +  _s.sourceURL_str + "&rand=" + parseInt(Math.random() * 99999999), true);
				_s.xhr.setRequestHeader('Content-Type', 'text/xml');
				_s.xhr.send();
			}catch(e){
				var message = e;
				if(e){if(e.message)message = e.message;}
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"XML file can't be loaded! <font color='#ff0000'>" + _s.sourceURL_str + "</font>. " + message });
			}
		};
		

		//#######################################//
		/* load folder */
		//######################################//
		_s.loadFolderPlaylist = function(url){
			if(_s.isPlaylistDispatchingError_bl) return;
			
			if(document.location.protocol == "file:"){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Creating a video playlist from a folder is not allowed or possible local! To function properly please test online."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}	
			
			_s.loadFromFolder_bl = true;
			_s.sourceURL_str = url.substr(url.indexOf("=") + 1);
			_s.xhr = new XMLHttpRequest();
			_s.xhr.onreadystatechange = _s.ajaxOnLoadHandler;
			_s.xhr.onerror = _s.ajaxOnErrorHandler;
			
			try{
				_s.xhr.open("get", _s.proxyFolderPath_str + "?dir=" +  encodeURIComponent(_s.sourceURL_str) + "&videoLabel=" + _s.folderVideoLabel_str  + "&rand=" + parseInt(Math.random() * 9999999), true);
				_s.xhr.send();
			}catch(e){
				var message = e;
				if(e){if(e.message)message = e.message;}
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Please make sure the folder exists and it has video or audio files in it: <font color='#ff0000'>" + encodeURIComponent(_s.sourceURL_str) + "</font>"});
			}
		};


		//##########################################//
		/* load youtube list */
		//##########################################//
		_s.loadVimeoPlaylist = function(url, userId, clientId, vimeoSecret, vimeoToken){
			if(document.location.protocol == "file:"){
				_s.isPlaylistDispatchingError_bl = true;
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Loading Vimeo albums local is not allowed or possible! To function properly please test online."});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
			
			_s.isVimeoAlbum_bl = true;
			if(url) _s.vimeoAlbumURL = url;
			if(userId) _s.userId = userId;
			if(clientId) _s.clientId = clientId;
			if(vimeoSecret) _s.vimeoSecret = vimeoSecret;
			if(vimeoToken) _s.vimeoToken = vimeoToken;
			var albumId = _s.vimeoAlbumURL.match(/\/[\d]+/ig);
			albumId = albumId[0].substr(1);
			
			var offset = '';
			if(_s.clientId){
				offset = '&client_id=' + _s.clientId + '&vimeo_secret=' + _s.vimeoSecret + '&vimeo_token=' + _s.vimeoToken;
			}
			
			if(_s.nextPageToken_str){
				_s.sourceURL_str = _s.mainFolderPath_str + 'vimeo/data.php?rand=' + Math.round(Math.random() * 99999999) +  '&type=vimeo_user_album&user=' + _s.userId + '&album_id=' + albumId + '&page='+ _s.nextPageToken_str + '&per_page=50' + offset;
			}else{
				_s.sourceURL_str = _s.mainFolderPath_str + 'vimeo/data.php?rand=' + Math.round(Math.random() * 99999999) +  '&type=vimeo_user_album&user=' + _s.userId + '&album_id=' + albumId + '&page=1&per_page=50' + offset;
			}
			
			_s.xhr = new XMLHttpRequest();
			_s.xhr.onreadystatechange = _s.ajaxOnLoadHandler;
			_s.xhr.onerror = _s.ajaxOnErrorHandler;
			
			try{
				_s.xhr.open("get",_s.sourceURL_str, true);
				_s.xhr.send();
			}catch(e){
				var message = e;
				if(e){if(e.message)message = e.message;}
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading vimeo album! <font color='#ff0000'>" + _s.vimeoAlbumURL + "</font>"});
			}
		}
		
		_s.parseVimeoPlaylist = function(object){
			_s.stopToLoadPlaylist();
			if(object['body']['error']){
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:object['body']['error'] + ' ' + object['body']['developer_message']});
				return;
			}
			object = object['body'];
		
			var tt;
			var item;
			var videoSource;
			
			if(!_s.vimeoObject_ar){
				_s.vimeoObject_ar = [];
			}
			
			for(var i=0; i<object.data.length; i++){
				_s.vimeoObject_ar.push(object.data[i]);
			}
			
			tt = _s.vimeoObject_ar.length;
			
			
			if(object['paging']['next']){
				_s.nextPageToken_str = Number(object['page']) + 1;
				_s.loadVimeoPlaylist();
				return;
			}
		
			for(var i=0; i< tt; i++){
				
				var obj = {};
				item = _s.vimeoObject_ar[i];
				var videoId = item['uri'].match(/\/[\d]+/ig)[0].substr(1);
				obj.startAtVideo = 0;
				obj.videoSource = [{source:'https://vimeo.com/' + videoId}];
				
				obj['atb'] = 'yes';
				obj.gaStr = item['name'];
				obj.title = "<p class='ytbChangeColor fwduvp-ytb-info-title' style='color:" + _s.youtubeAndFolderVideoTitleColor_str + ";'>" + item['name'] + "</p>";
				
				var desc = item['description'];
				if(!desc) desc = "";
				if(obj.title.length > 165){
					desc = desc.substr(0, 60);
				}else{
					desc = desc.substr(0, 90);
				}
				
				desc = desc.substr(0, desc.lastIndexOf(" ")) + " ...";
				
				obj.titleText = item['name'];
				obj.titleText = item['name'];
				obj.desc = undefined;
				
				obj.desc = "<p class='fwduvp-ytb-info-title' style='color:" + _s.youtubeAndFolderVideoTitleColor_str + ";'>" + item['name'] + "</p><p class='fwduvp-ytb-info-p' style='color:" + _s.youtubeDescriptionColor_str + ";'>" + item['description'] + "</p>";
				obj.downloadable = false;
				try{
					obj.thumbSource = item['pictures']['sizes'][2]['link'];
				}catch(e){}
				obj.posterSource =  "none";
			
				obj.downloadable = false;
				_s.playlist_ar.push(obj);
			}

			if(_s.randomizePlaylist_bl){
				_s.playlist_ar = FWDUVPUtils.randomizeArray(_s.playlist_ar);
			}
		
			if(_s.maxPlaylistItems < _s.playlist_ar.length){
				_s.playlist_ar = _s.playlist_ar.splice(0, _s.maxPlaylistItems);
			}
			
			clearTimeout(_s.dispatchPlaylistLoadCompleteWidthDelayId_to);
			_s.dispatchPlaylistLoadCompleteWidthDelayId_to = setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.PLAYLIST_LOAD_COMPLETE);
			}, 50);
	
			_s.isDataLoaded_bl = true;
		}
		

		//##########################################//
		/* load youtube list */
		//##########################################//
		_s.loadYoutubePlaylist = function(url){
			if(_s.isPlaylistDispatchingError_bl && !_s.isYoutbe_bl) return;
		
			_s.isChannel = url.indexOf('channel/') != -1;
			_s.url = url;
			if(!_s.youtubeUrl_str){
				if(url.indexOf('list=')  != -1){
					var rx = /list=(.*?)(?:&|$)/i;
					var arr = rx.exec(url);
				}else{
					var rx = /channel\/(.*?)(?:&|$)/i;
					var arr = rx.exec(url);
				}
				
				url = arr[1];
				_s.youtubeUrl_str = url;
			}
			
			if(_s.nextPageToken_str){
				if(_s.isChannel){
					_s.sourceURL_str = "https://www.googleapis.com/youtube/v3/search?part=snippet&pageToken=" + _s.nextPageToken_str + "&channelId=" + _s.youtubeUrl_str + "&key=" + _s.youtubeAPIKey + "&maxResults=50&callback=" + prt.instanceName_str + "._d.parseYoutubePlaylist";
				}else{
					_s.sourceURL_str = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&pageToken=" + _s.nextPageToken_str + "&playlistId=" + _s.youtubeUrl_str + "&key=" + _s.youtubeAPIKey + "&maxResults=50&callback=" + prt.instanceName_str + "._d.parseYoutubePlaylist";
				}
				
			}else{
				if(_s.isChannel){
					_s.sourceURL_str = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=" + _s.youtubeUrl_str + "&key=" + _s.youtubeAPIKey + "&maxResults=50&callback=" + prt.instanceName_str + "._d.parseYoutubePlaylist";
				}else{
					_s.sourceURL_str = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" + _s.youtubeUrl_str + "&key=" + _s.youtubeAPIKey + "&maxResults=50&callback=" + prt.instanceName_str + "._d.parseYoutubePlaylist";
				}
			}
			
			if(_s.scs_el == null){
				try{
					_s.scs_el = document.createElement('script');
					_s.scs_el.src = _s.sourceURL_str;
					_s.scs_el.id = prt.instanceName_str + "._d.parseYoutubePlaylist";
					document.documentElement.appendChild(_s.scs_el);
				}catch(e){}
			}
			_s.JSONPRequestTimeoutId_to = setTimeout(function(){
				var err;
				if(_s.isChannel){
					err = 'channel';
				}
				_s.JSONPRequestTimeoutError("Error loading youtube " + err + "!<font color='#ff0000'>" + _s.youtubeUrl_str + "</font>");
			}, 6000);
		
		};
		
		_s.JSONPRequestTimeoutError = function(text){
			_s.stopToLoadPlaylist();
			_s.isPlaylistDispatchingError_bl = true;
			var showLoadPlaylistErrorId_to = setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:text});
				_s.isPlaylistDispatchingError_bl = false;
			}, 50);
			return;
		};
		
		_s.resetYutubeVimeoPlaylistLoader = function(){
			_s.isYoutbe_bl = false;
			_s.youtubeObject_ar = null;
			_s.vimeoObject_ar = null;
			_s.nextPageToken_str = null;
			_s.youtubeUrl_str = null;
		};

		
		//######################################//
		/* Handle ajax response */
		//######################################//
		_s.ajaxOnErrorHandler = function(e){
			try{
				if(window.console) console.log(e);
				if(window.console) console.log(e.message);
			}catch(e){};
			if(_s.isVimeoAlbum_bl){
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading vimeo album! <font color='#ff0000'>" + _s.vimeoAlbumURL + "</font>"});
			}else if(_s.loadFromFolder_bl){
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading file : <font color='#ff0000'>" + _s.proxyFolderPath_str + "</font>. Make sure the path is correct"});
			}else{
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading file : <font color='#ff0000'>" + _s.proxyPath_str + "</font>. Make sure the path is correct"});
			}
		};
		
		_s.ajaxOnLoadHandler = function(e){
			var response;
			var isXML = false;
			
			if(_s.xhr.readyState == 4){
				if(_s.xhr.status == 404){
					if(_s.isVimeoAlbum_bl){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading vimeo album! <font color='#ff0000'>" + _s.vimeoAlbumURL + "</font>"});
					}else if(_s.loadFromFolder_bl){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Folder proxy file path is not found: <font color='#ff0000'>" + _s.proxyFolderPath_str + "</font>"});
					}else{
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Proxy file path is not found: <font color='#ff0000'>" + _s.proxyPath_str + "</font>"});
					}
					
				}else if(_s.xhr.status == 408){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Server has timeout!"});
				}else if(_s.xhr.status == 200){
					if(_s.xhr.responseText.indexOf("<b>Warning</b>:") != -1){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading folder: <font color='#ff0000'>" + _s.sourceURL_str + "</font>. Make sure that the folder path is correct!"});
						return;
					}
					
					if(window.JSON){
						response = JSON.parse(_s.xhr.responseText);
					}else{
						response = eval('('+ _s.xhr.responseText +')');
					}
				
					if(response.body){
						_s.parseVimeoPlaylist(response);
					}else if(response.folder){
						_s.parseFolderJSON(response);
					}else if(response.li){
						_s.parseXML(response);
					}else if(response.error){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Error loading file: <font color='#ff0000'>" + _s.sourceURL_str + "</font>. Make sure the file path (xml or podcast) is correct and well formatted!"});
					}
				}
			}
		};
		
		_s.parseYoutubePlaylist = function(object){
			
			if(_s.isPlaylistDispatchingError_bl || !_s.isYoutbe_bl) return;
			if(object.error){
				var err;
				if(_s.isChannel){
					err = 'channel';
				}
				_s.JSONPRequestTimeoutError("Error loading youtube " + err + "! <font color='#ff0000'>" + _s.youtubeUrl_str + "</font>");
				if(console) console.log(object);
				return;
			}
			
			_s.playlist_ar = [];
			var tt;
			var item;
			var videoSource;
			
			if(!_s.youtubeObject_ar){
				_s.youtubeObject_ar = [];
			}
			
			for(var i=0; i<object.items.length; i++){
				_s.youtubeObject_ar.push(object.items[i]);
			}
			
			tt = _s.youtubeObject_ar.length;
			
			_s.stopToLoadPlaylist();
			
			if(object.nextPageToken){
				_s.nextPageToken_str = object.nextPageToken;
				_s.loadYoutubePlaylist(_s.url);
				return;
			}
			
			for(var i=0; i< tt; i++){
				
				var obj = {};
				item = _s.youtubeObject_ar[i];
				if(item.snippet.thumbnails){
					if(_s.isChannel){
						obj.videoSource = item.id.videoId;
					}else{
						obj.videoSource = item.snippet.resourceId.videoId;
					}
					
					obj.startAtVideo = 0;
					obj.videoSource = [{source:"https://www.youtube.com/watch?v=" + obj.videoSource}];
					obj.owner = item.snippet.channelTitle;
					obj.gaStr =  item.snippet.title;

					if(window['isWhite']){
						_s.youtubeAndFolderVideoTitleColor_str = '#000000';
					}else if(window['isDark']){
						_s.youtubeAndFolderVideoTitleColor_str = '#FFFFFF';
					}
					
					obj.title = "<p class='ytbChangeColor fwduvp-ytb-title' style='color:" + _s.youtubeAndFolderVideoTitleColor_str + ";'>" + item.snippet.title + "</p>";
					var desc = item.snippet.description;
					if(obj.title.length > 190){
						desc = desc.substr(0, 20);
					}else if(obj.title.length > 165){
						desc = desc.substr(0, 60);
					}else{
						desc = desc.substr(0, 90);
					}
					
					desc = desc.substr(0, desc.lastIndexOf(" ")) + " ...";
					obj.title += "<p class='fwduvp-ytb-p' style='color:" + _s.youtubeOwnerColor_str + ";'> " + desc + "</p>";
				
					obj.titleText = item.snippet.title;
					obj.titleText = item.snippet.title;
					obj.desc = undefined;
					
					obj.desc = "<p class='fwduvp-ytb-info-title' style='color:" + _s.youtubeAndFolderVideoTitleColor_str + ";'>" + item.snippet.title + "</p><p class='fwduvp-ytb-info-p' style='color:" + _s.youtubeDescriptionColor_str + ";'>" + item.snippet.description + "</p>";
				
					obj.downloadable = false;
				
					try{
						obj.thumbSource = item.snippet.thumbnails["default"].url;
						if(_s.showOnlyThumbnail){
							if(item.snippet.thumbnails["standard"]){
								obj.thumbSource = item.snippet.thumbnails["standard"].url;
							}else if(item.snippet.thumbnails["high"]){
								obj.thumbSource = item.snippet.thumbnails["high"].url;
							}
						}
					}catch(e){}
					obj.posterSource =  "none";
					
					if(item.snippet.title.indexOf("eleted video") == -1 && item.snippet.title.indexOf("his video is unavailable") == -1){
						_s.playlist_ar.push(obj);
					}
				}
			}

			if(_s.randomizePlaylist_bl){
				_s.playlist_ar = FWDUVPUtils.randomizeArray(_s.playlist_ar);
			}
		
			if(_s.maxPlaylistItems < _s.playlist_ar.length){
				_s.playlist_ar = _s.playlist_ar.splice(0, _s.maxPlaylistItems);
			}

			_s.plsCache_ar[_s.id] = _s.playlist_ar;
			
			_s.youtubePlLoadComplete();
		};

		_s.youtubePlLoadComplete = function(){
			clearTimeout(_s.dispatchPlaylistLoadCompleteWidthDelayId_to);
			_s.dispatchPlaylistLoadCompleteWidthDelayId_to = setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.PLAYLIST_LOAD_COMPLETE);
			}, 50);
			_s.isDataLoaded_bl = true;
		}
		
			
		_s.isDataLoaded_bl = true;
		
		_s.setYoutubePlaylistHEXColor = function(color){
			_s.youtubeAndFolderVideoTitleColor_str = color;
		}
		
		_s.closeJsonPLoader = function(){
			clearTimeout(_s.JSONPRequestTimeoutId_to);
		};
		

		//##########################################//
		/* parse DOM playlist */
		//##########################################//
		_s.parseDOMPlaylist = function(element, id){
			if(_s.isPlaylistDispatchingError_bl) return;
		
			var children_ar = FWDUVPUtils.getChildren(element);
			var totalChildren = children_ar.length;
			var child;
			var has360Video = false;
			_s.playlist_ar = [];
			
			if(totalChildren == 0){
				var showLoadPlaylistErrorId_to = setTimeout(function(){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"At least one video is required in the playlist with id: <font color='#ff0000'>" + id + "</font>"});
					_s.isPlaylistDispatchingError_bl = false;
				}, 50);
				return;
			}
			
			for(var i=0; i<totalChildren; i++){
				var obj = {};
				var adsObj;
				child = children_ar[i];
				
				if(!FWDUVPUtils.hasAttribute(child, "data-thumb-source")){
					_s.isPlaylistDispatchingError_bl = true;
					var showLoadPlaylistErrorId_to = setTimeout(function(){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Attribute <font color='#ff0000'>data-thumb-source</font> is required in the playlist at position <font color='#ff0000'>" + (i + 1)});
					}, 50);
					return;
				}
				
				if(!FWDUVPUtils.hasAttribute(child, "data-video-source")){
					_s.isPlaylistDispatchingError_bl = true;
					var showLoadPlaylistErrorId_to = setTimeout(function(){
						_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Attribute <font color='#ff0000'>data-video-source</font> is required in the playlist at position <font color='#ff0000'>" + (i + 1)});
					}, 50);
					return;
				}
				
				obj.thumbSource = encodeURI(FWDUVPUtils.getAttributeValue(child, "data-thumb-source"));
				
				obj.videoSource = FWDUVPUtils.getAttributeValue(child, "data-video-source");
				obj._dPlaybackRate  = FWDUVPUtils.getAttributeValue(child, "data-playback-rate");
				obj.startAtVideo = FWDUVPUtils.getAttributeValue(child, "data-start-at-video") || 0;
				obj.isLive = FWDUVPUtils.getAttributeValue(child, "data-is-live");
				obj.atb = FWDUVPUtils.getAttributeValue(child, "data-use-a-to-b") == "yes" ? true : false;
				obj.thumbnailsPreview = FWDUVPUtils.getAttributeValue(child, "data-thumbnails-preview");
				if(!_s.useAToB) obj.atb = false;
				
				if(obj.isLive == "yes"){
					obj.isLive = true;
				}else{
					obj.isLive = false;
				}
				
				obj.isPrivate = FWDUVPUtils.getAttributeValue(child, "data-is-private");
				if(obj.isPrivate == "yes"){
					obj.isPrivate = true;
				}else{
					obj.isPrivate = false;
				}

				obj.redirectURL = FWDUVPUtils.getAttributeValue(child, "data-redirect-url");
				obj.redirectTarget = FWDUVPUtils.getAttributeValue(child, "data-redirect-target");
				obj.privateVideoPassword_str = FWDUVPUtils.getAttributeValue(child, "data-private-video-password");
				obj.startAtTime = FWDUVPUtils.getAttributeValue(child, "data-start-at-time");
				if(obj.startAtTime == "00:00:00" || !FWDUVPUtils.checkTime(obj.startAtTime)) obj.startAtTime = undefined;
				
				obj.stopAtTime = FWDUVPUtils.getAttributeValue(child, "data-stop-at-time");
				if(obj.stopAtTime == "00:00:00" || !FWDUVPUtils.checkTime(obj.stopAtTime)) obj.stopAtTime = undefined;
				
				if(obj.videoSource.indexOf("{source:") != -1){
					
					try{
						obj.videoLabels_ar = [];
						obj.videoSource = eval(obj.videoSource);
						for(var m=0; m<obj.videoSource.length; m++){
							obj.videoLabels_ar[m] = obj.videoSource[m]["label"];
						}
						for(var m=0; m<obj.videoSource.length; m++){
							var src = obj.videoSource[m].source;
							if(src.indexOf("encrypt:") != -1) src = atob(src.substr(8));
							obj.videoSource[m].source = FWDUVPUtils.getValidSource(src);

							var mm = obj.videoSource[m].startWhenPlayButtonClick360DegreeVideo;
							if(mm == "yes"){
								mm = true;
							}else{
								mm = false;
							}
							obj.videoSource[m].startWhenPlayButtonClick360DegreeVideo = mm;

							var rr = obj.videoSource[m].rotationY360DegreeVideo;
							if(rr != undefined){
								rr = Number(obj.videoSource[m].rotationY360DegreeVideo);
							}else{
								rr = -90;
							}
							obj.videoSource[m].rotationY360DegreeVideo = rr;
						}

						for(var m=0; m<obj.videoSource.length; m++){
							obj.videoSource[m].is360 = obj.videoSource[m]['is360'];
							if(obj.videoSource[m].is360 == "yes") obj.videoSource[m].is360 = true;
							if(obj.videoSource[m].is360 == "no") obj.videoSource[m].is360 = false;
							if(obj.videoSource[m].is360 == true) has360Video = true;
						}
						
						obj.videoLabels_ar.reverse();
					}catch(e){
						_s.isPlaylistDispatchingError_bl = true;
						var showLoadPlaylistErrorId_to = setTimeout(function(){
							_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Please make sure that the <font color='#ff0000'>data-video-source</font> attribute contains an array of videos at position <font color='#ff0000'>" + (i + 1) + "</font>"});
						}, 50);
						return;
					}
				}else{
					src = obj.videoSource;
					if(src.indexOf("encrypt:") != -1) src = atob(src.substr(8));
					obj.videoSource = [{source:FWDUVPUtils.getValidSource(src)}];
				}
			
				if(FWDUVPUtils.hasAttribute(child, "data-subtitle-soruce")){
					obj.subtitleSource = FWDUVPUtils.getAttributeValue(child, "data-subtitle-soruce");
					if(obj.subtitleSource.indexOf("{source:") != -1){
						obj.startAtSubtitle = FWDUVPUtils.getAttributeValue(child, "data-start-at-subtitle") || 0;
						if(obj.subtitleSource.indexOf("{source:") != -1){
							try{
								obj.subtitleSource = eval(obj.subtitleSource);
							}catch(e){
								_s.isPlaylistDispatchingError_bl = true;
								var showLoadPlaylistErrorId_to = setTimeout(function(){
									_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Please make sure that the <font color='#ff0000'>data-subtitle-source</font> attribute contains an array of subtitles at position <font color='#ff0000'>" + (i + 1) + "</font>"});
								}, 50);
								return;
							}
							obj.subtitleSource.splice(0,0, {source:"none", label:_s.subtitlesOffLabel_str});
							obj.subtitleSource.reverse();
						}
					}else{
						obj.subtitleSource = [{source:obj.subtitleSource}];
					}
					if(obj.subtitleSource){
						for(var x=0; x<obj.subtitleSource.length; x++){
							var source = obj.subtitleSource[x].source;
							if(source.indexOf("encrypt:") != -1) obj.subtitleSource[x].source = atob(source.substr(8));
						}
					}
				}
				
				obj._dAdvertisementOnPauseSource  = FWDUVPUtils.getAttributeValue(child, "data-advertisement-on-pause-source");
				obj.scrubAtTimeAtFirstPlay = FWDUVPUtils.getAttributeValue(child, "data-scrub-at-time-at-first-play") || "none";
				if(/^((?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$)/g.test(obj.scrubAtTimeAtFirstPlay)){
					obj.scrubAtTimeAtFirstPlay = FWDUVPUtils.getSecondsFromString(obj.scrubAtTimeAtFirstPlay);
				}else{
					obj.scrubAtTimeAtFirstPlay = undefined;
				}
				
				if(FWDUVPUtils.hasAttribute(child, "data-poster-source")){
					obj.posterSource = encodeURI(FWDUVPUtils.getAttributeValue(child, "data-poster-source"));
				}else{
					obj.posterSource = "none";
				}
			
				obj.downloadPath = obj.videoSource[obj.startAtVideo];
				
				if(FWDUVPUtils.hasAttribute(child, "data-downloadable") && _s.showDownloadVideoButton_bl){
					obj.downloadable = FWDUVPUtils.getAttributeValue(child, "data-downloadable") == "yes" ? true : false;
					if(obj.downloadPath.source.indexOf(".") ==  -1)  obj.downloadable = false;
				}else{
					obj.downloadable = false;
				}

				if(FWDUVPUtils.hasAttribute(child, "data-play-if-logged-in")){
					obj.playIfLoggedIn = FWDUVPUtils.getAttributeValue(child, "data-play-if-logged-in");
					if(obj.playIfLoggedIn == 'no') obj.playIfLoggedIn = undefined;
				}
				
				//video popup adds and annotations
				var annotations_ar;
				var mainPopupAds_ar = FWDUVPUtils.getChildren(child);
				var tempPopupAds_ar;
				var popupAds_ar;
				var popupOrAnnotationChild;
				var finalPopupChild;
				var popupObj;
				
				for(var k=0; k<mainPopupAds_ar.length; k++){
					
					popupOrAnnotationChild = mainPopupAds_ar[k];	
					if(FWDUVPUtils.hasAttribute(popupOrAnnotationChild, "data-add-popup")){
						tempPopupAds_ar = FWDUVPUtils.getChildren(popupOrAnnotationChild);
						popupAds_ar = [];
						for(var x=0; x<tempPopupAds_ar.length; x++){
							finalPopupChild = tempPopupAds_ar[x];
							if(finalPopupChild){
								popupObj = {};
								popupObj.source = FWDUVPUtils.getValidSource(FWDUVPUtils.getAttributeValue(finalPopupChild, "data-image-path"));
								popupObj.timeStart = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(finalPopupChild, "data-time-start"));
								popupObj.timeEnd = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(finalPopupChild, "data-time-end"));
								popupObj.link = FWDUVPUtils.getAttributeValue(finalPopupChild, "data-link");
								popupObj.target = FWDUVPUtils.getAttributeValue(finalPopupChild, "data-target");
								popupObj.google_ad_width = parseInt(FWDUVPUtils.getAttributeValue(finalPopupChild, "data-google-ad-width")) || 600;
								popupObj.google_ad_height = parseInt(FWDUVPUtils.getAttributeValue(finalPopupChild, "data-google-ad-height")) || 200;
								popupObj.google_ad_client = FWDUVPUtils.getAttributeValue(finalPopupChild, "data-google-ad-client");
								popupObj.google_ad_slot = FWDUVPUtils.getAttributeValue(finalPopupChild, "data-google-ad-slot");
								popupAds_ar.push(popupObj);
							}
						}
						
						obj.popupAds_ar = popupAds_ar;
					}
					
					//ads
					if(FWDUVPUtils.hasAttribute(popupOrAnnotationChild, "data-ads")){
						var adsData_ar = FWDUVPUtils.getChildren(popupOrAnnotationChild);
						var ads_ar = [];
					
						var adsChild;
						var tt = adsData_ar.length;
						
						for(var m=0; m<tt; m++){
							var adsObj = {};
							adsChild = adsData_ar[m];
							
							adsObj.timeStart = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(adsChild, "data-time-start"));
							if(FWDUVPUtils.hasAttribute(adsChild, "data-add-duration")){
								adsObj.addDuration = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(adsChild, "data-add-duration"));
							}
							
							adsObj.thumbnailSource = FWDUVPUtils.getAttributeValue(adsChild, "data-thumbnail-source");
							if(adsObj.thumbnailSource == "" || adsObj.thumbnailSource == " ") adsObj.thumbnailSource = undefined;
							
							adsObj.timeToHoldAds = parseInt(FWDUVPUtils.getAttributeValue(adsChild, "data-time-to-hold-ads") || 4);
							adsObj.source = FWDUVPUtils.getValidSource(FWDUVPUtils.getAttributeValue(adsChild,"data-source"));
							adsObj.link = FWDUVPUtils.getAttributeValue(adsChild,"data-link");
							adsObj.target = FWDUVPUtils.getAttributeValue(adsChild,"data-target");
							
							ads_ar[m] = adsObj
						}
						
						obj.ads_ar = ads_ar
					}
					
					if(FWDUVPUtils.hasAttribute(child, "data-vast-url")){
						obj.ads_ar = undefined;
						var vsrc = FWDUVPUtils.getAttributeValue(child, "data-vast-url");
						
						if(FWDUVPUtils.isIMA(vsrc)){
							obj.imaURL = vsrc;
						}else{
							obj.vastURL = vsrc;
							obj.vastClickTroughTarget = FWDUVPUtils.getAttributeValue(child, "data-vast-clicktrough-target") || "_blank";
							obj.vastLinearStartTime = FWDUVPUtils.getAttributeValue(child, "data-vast-linear-astart-at-time") || "00:00:00";
						}
					}
				
					//cuepoints
					if(FWDUVPUtils.hasAttribute(popupOrAnnotationChild, "data-cuepoints")){
						var cuepointsData_ar = FWDUVPUtils.getChildren(popupOrAnnotationChild);
						var cuepoints_ar = [];
					
						var cuepointsChild;
						var tt = cuepointsData_ar.length;
						
						for(var m=0; m<tt; m++){
							var cuepointsObj = {};
							cuepointsChild = cuepointsData_ar[m];
							
							cuepointsObj.timeStart = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(cuepointsChild, "data-time-start"));
							cuepointsObj.javascriptCall = FWDUVPUtils.getAttributeValue(cuepointsChild, "data-javascript-call");
							cuepointsObj.isPlayed_bl = false;
							cuepoints_ar[m] = cuepointsObj
						}
						
						obj.cuepoints_ar = cuepoints_ar
					}
					
					//annotation
					if(FWDUVPUtils.hasAttribute(popupOrAnnotationChild, "data-annotations")){
						annotations_ar = FWDUVPUtils.getChildren(popupOrAnnotationChild);
				
						var annotationChild;
						var tt = annotations_ar.length;
						
						for(var m=0; m<tt; m++){
							var annotationObj = {};
							annotationChild = annotations_ar[m];
							
							annotationObj.start = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(annotationChild, "data-start-time"));
							annotationObj.end = FWDUVPUtils.getSecondsFromString(FWDUVPUtils.getAttributeValue(annotationChild, "data-end-time"));
							annotationObj.left = parseInt(FWDUVPUtils.getAttributeValue(annotationChild, "data-left"), 10);
							annotationObj.top = parseInt(FWDUVPUtils.getAttributeValue(annotationChild, "data-top"), 10);
							
							annotationObj.showCloseButton_bl = FWDUVPUtils.getAttributeValue(annotationChild, "data-show-close-button") == "yes" ? true : false; 
							annotationObj.clickSource = FWDUVPUtils.getAttributeValue(annotationChild, "data-click-source");
							annotationObj.clickSourceTarget = FWDUVPUtils.getAttributeValue(annotationChild, "data-click-source-target");
					
							annotationObj.normalStateClass = FWDUVPUtils.getAttributeValue(annotationChild, "data-normal-state-class");
							annotationObj.selectedStateClass = FWDUVPUtils.getAttributeValue(annotationChild, "data-selected-state-class");
							
							annotationObj.content = annotationChild.innerHTML;
							
							annotations_ar[m] = annotationObj
						}
						
						obj.annotations_ar = annotations_ar
					}
				}
				
				//video description
				var descChidren_ar = FWDUVPUtils.getChildren(child);
				var descChild;
				obj.title = "not defined!";
				obj.titleText = "not defined!";
				
				for(var k=0; k<descChidren_ar.length; k++){
					descChild = descChidren_ar[k];	
					if(FWDUVPUtils.hasAttribute(descChild, "data-video-short-description")){
						obj.title =  descChild.innerHTML;
						obj.titleText = descChild.textContent;
						obj.titleText = obj.titleText.replace(/^\s+/g, '')
						
					}else if(FWDUVPUtils.hasAttribute(descChild, "data-video-long-description")){
						obj.desc = descChild.innerHTML;
					}
				}
			
				var gaStr = obj.titleText.split('\n')
				for(var x=0; x<gaStr.length; x++){
				
					if(gaStr[x].length > 2){
						obj.gaStr = gaStr[x];
						break;
					}
				}
				
				if(FWDUVPUtils.hasAttribute(child, "data-ads-source")){
					adsObj = {};
					adsObj.source = FWDUVPUtils.getValidSource(FWDUVPUtils.getAttributeValue(child, "data-ads-source"));
					adsObj.pageToOpen = FWDUVPUtils.getAttributeValue(child, "data-ads-page-to-open-url");
					adsObj.pageTarget = FWDUVPUtils.getAttributeValue(child, "data-ads-page-target") || "_blank";
					adsObj.timeToHoldAds = parseInt(FWDUVPUtils.getAttributeValue(child, "data-time-to-hold-ads")) || 0;
					obj.ads = adsObj;
				}
			
				_s.playlist_ar[i] = obj;
			}

			if(_s.randomizePlaylist_bl){
				_s.playlist_ar = FWDUVPUtils.randomizeArray(_s.playlist_ar);
			}
		
			if(_s.maxPlaylistItems < _s.playlist_ar.length){
				_s.playlist_ar = _s.playlist_ar.splice(0, _s.maxPlaylistItems);
			}
		
			clearTimeout(_s.dispatchPlaylistLoadCompleteWidthDelayId_to);
			_s.dispatchPlaylistLoadCompleteWidthDelayId_to = setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.PLAYLIST_LOAD_COMPLETE);
			}, 50);
	
			_s.isDataLoaded_bl = true;
		};
		

		//####################################//
		/* parse folder JSON */
		//####################################//
		_s.parseFolderJSON = function(response){
			_s.playlist_ar = [];
			var obj;
			var obj_ar = response.folder;
			var counter = 0;
			if(obj_ar && !obj_ar.length){
				_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Please make sure the folder exists and it has video or audio files in it: <font color='#ff0000'>" + encodeURIComponent(_s.sourceURL_str) + "</font>"});
				return;
			}

			for(var i=0; i<obj_ar.length; i++){
				obj = {};
				obj.videoSource = encodeURI(obj_ar[i]["@attributes"]["data-video-path"]);
				
				obj.videoSource =  obj_ar[i]["@attributes"]["data-video-path"];
				obj._dPlaybackRate  = obj_ar[i]["@attributes"]["data-playback-rate"];
				obj.startAtVideo = obj_ar[i]["@attributes"]["data-start-at-video"] || 0;
				obj.videoSource = [{source:FWDUVPUtils.getValidSource(obj.videoSource)}];
				obj.thumbSource = encodeURI(obj_ar[i]["@attributes"]["data-thumb-path"]);
				obj.posterSource = encodeURI(obj_ar[i]["@attributes"]["data-poster-path"]);
				obj.downloadPath = encodeURIComponent(obj_ar[i]["@attributes"]["download-path"]);
				
				obj.downloadable = _s.showDownloadVideoButton_bl;
				if(_s.forceDisableDownloadButtonForFolder_bl) obj.downloadable = false;
				obj.titleText = "...";
				obj.title = "<p class='fwduvp-thumbnail-title' style='color:" + _s.youtubeAndFolderVideoTitleColor_str + "'>...</p>";
					
				obj.titleText = obj_ar[i]["@attributes"]["data-title"];
				obj.title = "<p class='fwduvp-thumbnail-title' style='color:" + _s.youtubeAndFolderVideoTitleColor_str + "'>" + obj_ar[i]["@attributes"]["data-title"] + "</p>";
				obj.desc = undefined;
				
				_s.playlist_ar[i] = obj;
			}

			if(_s.randomizePlaylist_bl){
				_s.playlist_ar = FWDUVPUtils.randomizeArray(_s.playlist_ar);
			}
		
			if(_s.maxPlaylistItems < _s.playlist_ar.length){
				_s.playlist_ar = _s.playlist_ar.splice(0, _s.maxPlaylistItems);
			}
			
			clearTimeout(_s.dispatchPlaylistLoadCompleteWidthDelayId_to);
			_s.dispatchPlaylistLoadCompleteWidthDelayId_to = setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.PLAYLIST_LOAD_COMPLETE);
			}, 50);
	
			_s.isDataLoaded_bl = true;
		};
		

		//####################################//
		/* parse xml JSON */
		//####################################//
		_s.parseXML = function(response){
			_s.playlist_ar = [];
			var obj;
			var obj_ar = response.li;
			var has360Video = false;
			
			if(!obj_ar.length) obj_ar = [obj_ar];
			
			for(var i=0; i<obj_ar.length; i++){
				obj = {};
				
				obj.videoSource =  obj_ar[i]["@attributes"]["data-video-source"];
				obj.startAtVideo = obj_ar[i]["@attributes"]["data-start-at-video"] || 0;

				obj.startWhenPlayButtonClick360DegreeVideo =  obj_ar[i]["@attributes"]["data-start-when-play-button-click-60D-degree-video"];
				if(obj.startWhenPlayButtonClick360DegreeVideo == 'yes') obj.startWhenPlayButtonClick360DegreeVideo = true;
				obj.rotationY360DegreeVideo =obj_ar[i]["@attributes"]["data-rotation-y-360-degree-video"];
				if(obj.rotationY360DegreeVideo === undefined) obj.rotationY360DegreeVideo = -90;
				obj.isLive = obj_ar[i]["@attributes"]["data-is-live"];
				obj.atb = obj_ar[i]["@attributes"]["data-use-a-to-b"] == "yes" ? true : false;
				if(!_s.useAToB) obj.atb = false;
									
				obj.isPrivate = obj_ar[i]["@attributes"]["data-is-private"]; 
				if(obj.isPrivate == "yes"){
					obj.isPrivate = true;
				}else{
					obj.isPrivate = false;
				}

				if(obj_ar[i]["@attributes"]["data-play-if-logged-in"]){
					obj.playIfLoggedIn = obj_ar[i]["@attributes"]["data-play-if-logged-in"];
					if(obj.playIfLoggedIn == 'no') obj.playIfLoggedIn = undefined;
				}
				
				obj.privateVideoPassword_str =  obj_ar[i]["@attributes"]["data-private-video-password"];
				
				obj.startAtTime =  obj_ar[i]["@attributes"]["data-start-at-time"];
				if(obj.startAtTime == "00:00:00" || !FWDUVPUtils.checkTime(obj.startAtTime)) obj.startAtTime = undefined;
				
				obj.stopAtTime =  obj_ar[i]["@attributes"]["data-stop-at-time"];
				if(obj.stopAtTime == "00:00:00" || !FWDUVPUtils.checkTime(obj.stopAtTime)) obj.stopAtTime = undefined;
				
				if(obj.videoSource.indexOf("{source:") != -1){
	
					try{
						obj.videoLabels_ar = [];
						obj.videoSource = eval(obj.videoSource);
						
						for(var m=0; m<obj.videoSource.length; m++){
							obj.videoLabels_ar[m] = obj.videoSource[m]["label"];
						}
						
						for(var m=0; m<obj.videoSource.length; m++){
							var src = obj.videoSource[m].source;
							if(src.indexOf("encrypt:") != -1) src = atob(src.substr(8));
							obj.videoSource[m].source = FWDUVPUtils.getValidSource(src);
						}
						
						for(var m=0; m<obj.videoSource.length; m++){
							obj.videoSource[m].is360 = obj.videoSource[m]['is360'];
							if(obj.videoSource[m].is360 == "yes") obj.videoSource[m].is360 = true;
							if(obj.videoSource[m].is360 == "no") obj.videoSource[m].is360 = false;
							if(obj.videoSource[m].is360 == true) has360Video = true;
						}
								
						obj.videoLabels_ar.reverse();
					}catch(e){
						_s.isPlaylistDispatchingError_bl = true;
						var showLoadPlaylistErrorId_to = setTimeout(function(){
							_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Please make sure that the <font color='#ff0000'>data-video-source</font> attribute contains an array of videos at position <font color='#ff0000'>" + (i + 1) + "</font>"});
						}, 50);
						return;
					}
				}else{
					var src = obj.videoSource;
					if(src.indexOf("encrypt:") != -1) src = atob(src.substr(8));
					obj.videoSource = [{source:FWDUVPUtils.getValidSource(src)}];
				}
				
				obj.subtitleSource =  obj_ar[i]["@attributes"]["data-subtitle-soruce"];
				obj.startAtSubtitle = obj_ar[i]["@attributes"]["data-start-at-subtitle"] || 0;
				if(obj.subtitleSource){
					if(obj.subtitleSource.indexOf("{source:") != -1){
						if(obj.subtitleSource.indexOf("{source:") != -1){
							try{
								obj.subtitleSource = eval(obj.subtitleSource);
								if(obj.subtitleSource.indexOf("encrypt:") != -1) obj.subtitleSource = atob(src.substr(8));
							}catch(e){
								_s.isPlaylistDispatchingError_bl = true;
								var showLoadPlaylistErrorId_to = setTimeout(function(){
									_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"Please make sure that the <font color='#ff0000'>data-subtitle-source</font> attribute contains an array of subtitles at position <font color='#ff0000'>" + (i + 1) + "</font>"});
								}, 50);
								return;
							}
							obj.subtitleSource.splice(0,0, {source:"none", label:_s.subtitlesOffLabel_str});
							obj.subtitleSource.reverse();
						}
					}else{
						obj.subtitleSource = [{source:obj.subtitleSource}];
					}
					if(obj.subtitleSource){
						for(var x=0; x<obj.subtitleSource.length; x++){
							var source = obj.subtitleSource[x].source;
							if(source.indexOf("encrypt:") != -1) obj.subtitleSource[x].source = atob(source.substr(8));
						}
					}
				}
				
				obj._dAdvertisementOnPauseSource  = obj_ar[i]["@attributes"]["data-advertisement-on-pause-source"];
				obj.scrubAtTimeAtFirstPlay =  obj_ar[i]["@attributes"]["data-scrub-at-time-at-first-play"];
				if(obj.scrubAtTimeAtFirstPlay){
					if(/^((?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$)/g.test(obj.scrubAtTimeAtFirstPlay)){
						obj.scrubAtTimeAtFirstPlay = FWDUVPUtils.getSecondsFromString(obj.scrubAtTimeAtFirstPlay);
					}
				}
				
				obj.downloadPath = obj.videoSource[obj.startAtVideo];
				obj.downloadable = obj_ar[i]["@attributes"]["data-downloadable"] == "yes" ? true : false;
				if(obj.videoSource[0]["source"].indexOf(".") == -1) obj.downloadable = false;
				obj.posterSource = encodeURI(obj_ar[i]["@attributes"]["data-poster-source"]);
				obj.thumbSource = obj_ar[i]["@attributes"]["data-thumb-source"];
				obj.title = obj_ar[i]["@attributes"]["data-title"];
				obj.titleText = obj_ar[i]["@attributes"]["data-title"];
				obj.desc = obj_ar[i]["@attributes"]["data-desc"];
				
				obj.gaStr = obj.titleText;
				
				//ads
				if(obj_ar[i]["@attributes"]["data-ads-source"]){
					var adsObj = {};
					adsObj.source = FWDUVPUtils.getValidSource(obj_ar[i]["@attributes"]["data-ads-source"]);
					adsObj.pageToOpen = obj_ar[i]["@attributes"]["data-ads-page-to-open-url"];
					adsObj.pageTarget = obj_ar[i]["@attributes"]["data-ads-page-target"] || "_blank";
					adsObj.timeToHoldAds = obj_ar[i]["@attributes"]["data-time-to-hold-ads"]  || 0;
					obj.ads = adsObj;
				}

				//vast
				if(obj_ar[i]["@attributes"]["data-vast-url"]){
					obj.ads_ar = undefined;
					var vsrc = obj_ar[i]["@attributes"]["data-vast-url"];
					
					if(FWDUVPUtils.isIMA(vsrc)){
						obj.imaURL = vsrc;
					}else{
						obj.vastURL = vsrc;
						obj.vastClickTroughTarget = obj_ar[i]["@attributes"]["data-vast-clicktrough-target"];
						obj.vastLinearStartTime = obj_ar[i]["@attributes"]["data-vast-linear-astart-at-time"] || "00:00:00";
					}
				}

				//cuepoints

				if(obj_ar[i]["@attributes"]["data-cuepoints"]){
					adsObj = {};
					adsObj.timeStart = obj_ar[i]["@attributes"]["data-time-start"];
					adsObj.javascriptCall = obj_ar[i]["@attributes"]["data-javascript-call"];
					adsObj.isPlayed_bl = false
					obj.cuepoints_ar = adsObj;
				}
			
				_s.playlist_ar[i] = obj;
			}
			
			if(_s.randomizePlaylist_bl){
				_s.playlist_ar = FWDUVPUtils.randomizeArray(_s.playlist_ar);
			}
		
			if(_s.maxPlaylistItems < _s.playlist_ar.length){
				_s.playlist_ar = _s.playlist_ar.splice(0, _s.maxPlaylistItems);
			}
				
			clearTimeout(_s.dispatchPlaylistLoadCompleteWidthDelayId_to);
			_s.dispatchPlaylistLoadCompleteWidthDelayId_to = setTimeout(function(){
				_s.dispatchEvent(FWDUVPData.PLAYLIST_LOAD_COMPLETE);
			}, 50);
	
			_s.isDataLoaded_bl = true;
		};
		

		//####################################//
		/* load vast */
		//####################################//
		_s.setVastSource = function(source, startTime){
			if(!_s.vastLoaded_bl){
				_s.vastScript = document.createElement('script');
				var scriptURI = _s.scripts[_s.countLoadedSCript];
				document.head.appendChild(_s.vastScript);
				_s.vastScript.src =  _s.mainFolderPath_str + 'java/FWDUVPVast.js';
				
				_s.vastScript.onload = function(){
					FWDUVPVast.setPrototype();
					_s.vast = new FWDUVPVast(_s);
					_s.vast.setSource(source, startTime);
				}
				
				_s.vastScript.onerror = function(e){
					_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:'VAST js plugin named <font color="#FF0000">FWDUVPVast.js</font> is not found. Please make sure that the content folder contains the java folder that contains the <font color="#FF0000">FWDUVPVast.js</font> file. '});
				}
				_s.vastLoaded_bl = true;
				return;
			}
			_s.vast.setSource(source);
		}
		
		_s.closeVast = function(){
			if(_s.vast) _s.vast.closeVast();
		}
		
		_s.fixVmapTimes = function(duration, curAddData, curPopupAdsData, id){
			if(_s.vast) _s.vast.fixVmapTimes(duration, curAddData, curPopupAdsData, id); 
		}
		
		_s.resetVastId = function(){
			if(_s.vast) _s.vast.id = -1;
		}
		
		
		//####################################//
		/* show error if a required property is not defined */
		//####################################//
		_s.showPropertyError = function(error){
			_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"The property called <font color='#FF0000'>" + error + "</font> is not defined."});
		};
		
		
		//####################################//
		/* stop to load current playlist... */
		//####################################//
		_s.stopToLoadPlaylist = function(){
			_s.closeJsonPLoader();
			try{
				_s.scs_el.src = null;
				document.documentElement.removeChild(_s.scs_el);
				_s.scs_el = null;
			}catch(e){}
			
			if(_s.xhr != null){
				try{_s.xhr.abort();}catch(e){}
				_s.xhr.onreadystatechange = null;
				_s.xhr.onerror = null;
				_s.xhr = null;
			}
		};
		

		//####################################//
		/* show error if a required property is not defined */
		//####################################//
		_s.showPropertyError = function(error){
			_s.dispatchEvent(FWDUVPData.LOAD_ERROR, {text:"The property called <font color='#ff0000'>" + error + "</font> is not defined."});
		};
		
		_s.init();
	};
	

	/* set prototype */
	FWDUVPData.setPrototype = function(){
		FWDUVPData.prototype = new FWDUVPEventDispatcher();
	};
	
	FWDUVPData.VAST_LOADING = 'vastLoading';
	FWDUVPData.VAST_LOADED = "vastLoaded";
	FWDUVPData.PLAYLIST_LOAD_COMPLETE = "playlistLoadComplete";
	FWDUVPData.PRELOADER_LOAD_DONE = "onPreloaderLoadDone";
	FWDUVPData.LOAD_DONE = "onLoadDone";
	FWDUVPData.LOAD_ERROR = "onLoadError";
	FWDUVPData.IMAGE_LOADED = "onImageLoaded";
	FWDUVPData.SKIN_LOAD_COMPLETE = "onSkinLoadComplete";
	FWDUVPData.SKIN_PROGRESS = "onSkinProgress";
	FWDUVPData.IMAGES_PROGRESS = "onImagesPogress";
	FWDUVPData.IMA_READY = 'imaReady';
	FWDUVPData.IMA_ERROR = 'ima_error';
	
	window.FWDUVPData = FWDUVPData;
}(window));