jQuery(document).ready(function(){
	//오늘 하루 보지 않기
	jQuery('input[name=bbse_popup_nomore]').change(function(){
		var $name = jQuery(this).val();
		var check = CookieForBbsePopup.get ($name);
		var type = jQuery(this).data('type');
		var pIdx = jQuery(this).data('pidx');
		switch(type){
			case  'Today' : {
				if ( check != 'Today' || !check ){
					CookieForBbsePopup.set ($name , 'Today' , {
						expires_day : 1,
					});

					jQuery('#btn-popup-' + pIdx).click();
				}
			}
			case  'Minute' : {
				if ( check != 'Minute' || !check ){
					CookieForBbsePopup.set ($name , 'Minute' , {
						expires_minute : 30,
					});

					jQuery('#btn-popup-' + pIdx).click();
				}
			}
		}
	});

	 jQuery(window).resize(function(){
		var $screen = jQuery(window).width();
		if ($screen < 1023){
			jQuery(".bbse-layer-popup").fadeOut();
		}
	});

   /*event*/
	jQuery(".bannerBtn").mouseover(function() {	
		var no=jQuery(this).data("no");	
		for(j=1;j<7;j++){
			jQuery("#banner"+j).css("display","none");
		}     
		jQuery("#banner"+no).css("display","block");    
		jQuery(".bannerBtn").css("background", "#acacac");    
		jQuery(this).css("background", "#ff7659");    
	});
   /*event*/

   /*v2.1.5 : photo*/
	var photoN = 1;
	var $photoSlider_w = jQuery('#photoPopup-slide li').outerWidth();
	var $photoSlider = jQuery('#photoPopup-slide ul');     
	var $photoPopup_w =$photoSlider.outerWidth();
	jQuery('#photoPopup-slide li:first').clone().appendTo(jQuery('#photoPopup-slide ul'));
	jQuery('#phptoBreadcrumb li:first').children('.Popup-hover').css('display','block');
	jQuery('#phptoBreadcrumb li:first').addClass('show');

	jQuery('#PhotoBtn-next').click(function(){
		photoN+=1 ;
		if(photoN==4){
		  $photoSlider.css('left',0);
		  photoN=2;
		};
		$photoSlider.stop().animate({'left':(photoN-1)*-$photoSlider_w});
		jQuery('#phptoBreadcrumb li').children('.Popup-hover').css('display','none');
		jQuery('#popup-btn'+photoN).children('.Popup-hover').css('display','block');
		if(photoN==3){
		  jQuery('#popup-btn1').children('.Popup-hover').css('display','block');
			};
	});	

	jQuery('#PhotoBtn-prev').click(function(){
		photoN-=1 ;
		if(photoN==0){
		  $photoSlider.css('left',-$photoPopup_w + $photoSlider_w);
		  photoN=2
		};
		$photoSlider.stop().animate({'left':(photoN-1)*-$photoSlider_w});
		jQuery('#phptoBreadcrumb li').children('.Popup-hover').css('display','none');
		jQuery('#popup-btn'+photoN).children('.Popup-hover').css('display','block');
	});

	jQuery('#phptoBreadcrumb li').click(function(){
		photoN=parseInt(jQuery(this).attr('data-now'));
			$photoSlider.animate({'left':(photoN-1)*-$photoSlider_w});
		jQuery('#phptoBreadcrumb li').children('.Popup-hover').css('display','none');
		jQuery('#phptoBreadcrumb li').removeClass('show');
		jQuery(this).addClass('show');
		jQuery(this).children('.Popup-hover').css('display','block');
	});

	jQuery('#phptoBreadcrumb li').hover(function(){
		jQuery(this).children('.Popup-hover').css('display','block');
	},function(){
		if(jQuery(this).hasClass('show')){
		  jQuery(this).children('.Popup-hover').css('display','block');
		}else{
		  jQuery(this).children('.Popup-hover').css('display','none');
		}
	});
   /*v2.1.5 : photo*/
});

var CookieForBbsePopup ={
	cookie_arr : null,

	set : function (name,value,options){
		options = options || {};
		this.cookie_arr = [escape(name) + '=' + escape(value)];

		//-- expires
		if (options.expires){
			if( typeof options.expires === 'object' && options.expires instanceof Date ){
				var date = options.expires;
				var expires = "expires=" + date.toUTCString();
				this.cookie_arr.push (expires);
			}
		} 
		else if (options.expires_day) this.set_expires_date (options.expires_day , 24*60*60);
		else if (options.expires_hour) this.set_expires_date (options.expires_hour , 60*60);
		else if (options.expires_minute) this.set_expires_date (options.expires_minute , 60);

		//-- domain
		if (options.domain){
			var domain = "domain=" + options.domain;
			this.cookie_arr.push (domain);
		}
		//-- path
		if (options.path){
			var path = 'path=' + options.path;
			this.cookie_arr.push (path);
		}
		//-- secure
		if( options.secure === true ){
			var secure = 'secure';
			this.cookie_arr.push (secure);
		}

		document.cookie = this.cookie_arr.join('; ');
	},

	get : function (name){
		var nameEQ = escape(name) + "=";
		var ca = document.cookie.split(';');

		for(var i=0;i < ca.length;i++){
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
		}
		return null;
	},

	del : function (name , options){
		options = options || {};
		options.expires_day = -1;
		this.set ( name , '' , options );
	},

	set_expires_date : function (expires , time){
		var date = new Date();
		date.setTime(date.getTime()+(expires*time*1000));
		var expires = "expires=" + date.toUTCString();
		this.cookie_arr.push (expires);
	}
};


var popup_view=function(pIdx,pAlign,inEffe,outEffe){
	var temp = jQuery('#popup-' + pIdx+'-contents');		//레이어의 id를 temp변수에 저장

	jQuery("#popup-"+pIdx).css("display","block");

	temp.css('margin-top', '0px');
	temp.css('margin-left', '0px');
	temp.css('float', 'none');

	// 화면의 중앙에 레이어를 띄운다.
	if(pAlign=='center'){
		if (temp.outerHeight() < jQuery(window).height() ){
			var top = Math.max(0, (jQuery(window).height() - temp.outerHeight()) / 2) + "px";
			temp.css('margin-top', top);
		}

		if (temp.outerWidth() < jQuery(window).width() ){
			var left = Math.max(0, ((jQuery(window).width() - temp.outerWidth()) / 2) + jQuery(window).scrollLeft()) + "px";
			temp.css('margin-left', left);
		}
	}
	else if(pAlign=='right'){
		var left = Math.max(0, (jQuery(window).width() - temp.outerWidth() + jQuery(window).scrollLeft())) + "px";

		temp.css('margin-left', left);
	}

	
	if(outEffe) temp.removeClass(outEffe);
	if(inEffe) temp.addClass(inEffe);

	jQuery('#popup-' + pIdx+' .bg').click(function(e){	//배경을 클릭하면 레이어를 사라지게 하는 이벤트 핸들러
		if(inEffe) temp.removeClass(inEffe);
		if(outEffe) temp.addClass(outEffe);
		jQuery('#popup-' + pIdx).fadeOut();

		e.preventDefault();
	});

	temp.find('#btn-popup-' + pIdx).click(function(e){
		if(outEffe){
			if(inEffe) temp.removeClass(inEffe);
			temp.addClass(outEffe);
			jQuery('#popup-' + pIdx).fadeOut();

		}else{
			if(inEffe) temp.removeClass(inEffe);
			jQuery('#popup-' + pIdx).fadeOut();		//'닫기'버튼을 클릭하면 레이어가 사라진다.
		}
		e.preventDefault();
	});
}
