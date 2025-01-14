/**
 * Ultimate Video Player PACKAGED v9.1
 * Popup advertisement.
 *
 * @author Tibi - FWDesign [https://webdesign-flash.ro/]
 * Copyright © 2006 All Rights Reserved.
 */
(function (window){
var FWDUVPPupupAds = function(prt, _d){
		
		'use strict';

		var _s = this;
		var prototype = FWDUVPPupupAds.prototype;
		
		_s.prt = prt;
		_s.totalAds = 0;
		_s.isMbl = FWDUVPUtils.isMobile;
		_s.hasPointerEvent_bl = FWDUVPUtils.hasPointerEvent;
		_s.showSubByDflt = _d.showSubByDflt;
		_s.nBC = _d.nBC;
		_s.sBC = _d.sBC;


		
		//##########################################//
		/* initialize  */
		//##########################################//
		_s.init = function(){
			if(_d.sknPth.indexOf("hex_white") != -1){
				_s.sBC = "#FFFFFF";
			} 
			_s.setOverflow("visible");
			_s.getStyle().cursor = "default";
			_s.setVisible(false);
		};
		

		//##########################################//
		/* Reset popup buttons ads */
		//##########################################//
		_s.resetPopups = function(popupAds_ar, id){
			if(_s.id == id) return;
			_s.hideAllPopupButtons(true);
			_s.popupAds_ar = popupAds_ar;
			_s.totalAds = _s.popupAds_ar.length;
		
			var popupAdButton;
			_s.popupAdsButtons_ar = [];
			
			for(var i=0; i<_s.totalAds; i++){
				FWDUVPPopupAddButton.setPrototype();
				popupAdButton = new FWDUVPPopupAddButton(
						_s,
						_s.popupAds_ar[i].source,
						_s.popupAds_ar[i].timeStart,
						_s.popupAds_ar[i].timeEnd,
						_s.popupAds_ar[i].link,
						_s.popupAds_ar[i].trget,
						_s.popupAds_ar[i].isClosed,
						i,
						_s.popupAds_ar[i].google_ad_client,
						_s.popupAds_ar[i].google_ad_slot,
						_s.popupAds_ar[i].google_ad_width,
						_s.popupAds_ar[i].google_ad_height,
						_s.popupAds_ar[i].tracking,
						_d.poppAdClsNPth,
						_d.poppAdClsSPth,
						_d.shwPpoppAdClsBtn,
						_d.useHEX,
						_s.nBC,
						_s.sBC
				);
				_s.popupAdsButtons_ar[i] = popupAdButton;
				_s.addChild(popupAdButton);
			}
		};

		
		//#####################################//
		/* Update text */
		//#####################################//
		_s.update = function(duration){
			if(_s.totalAds == 0) return;
			var popupAdButton;
			
			for(var i=0; i<_s.totalAds; i++){
				popupAdButton = _s.popupAdsButtons_ar[i];
				_s.curAdId = i;
				if(duration >= popupAdButton.start && duration < popupAdButton.end){
					popupAdButton.show();
				}else{
					popupAdButton.hide();
				}
			}	
		};
	
		_s.position = function(animate){
			if(_s.totalAds == 0) return;
			var popupAdButton;
			
			for(var i=0; i<_s.totalAds; i++){
				popupAdButton = _s.popupAdsButtons_ar[i];
				popupAdButton.resizeAndPosition(animate);
			}	
		};
		
		_s.hideAllPopupButtons = function(remove){
			if(_s.totalAds == 0) return;
			var popupAdButton;
			
			for(var i=0; i<_s.totalAds; i++){
				popupAdButton = _s.popupAdsButtons_ar[i];
				popupAdButton.hide(remove);
			}	
			if(remove){
				_s.popupAdsButtons_ar = null;
				_s.totalAds = 0;
			}
			_s.id = -1;
		};
		
		_s.resetId = function(){
			_s.id = -1;
		}
		
		_s.init();
	};

	
	/* set prototype */
	FWDUVPPupupAds.setPrototype = function(){
		FWDUVPPupupAds.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPPupupAds.LOAD_ERROR = "error";
	FWDUVPPupupAds.LOAD_COMPLETE = "complete";

	FWDUVPPupupAds.prototype = null;
	window.FWDUVPPupupAds = FWDUVPPupupAds;
}(window));