jQuery(document).ready(function() {
	jQuery('#sub-title-type-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-title-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-alias-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-shortcode-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-size-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-background-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-template-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-border-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-border-2').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-corner-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-active-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-page-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-device-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-period-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-user-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-layout-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-shadow-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-position-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-position-2').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-position-3').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-close-1').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-close-2').tipsy({fade:true,gravity: 'e'});
	jQuery('#sub-title-animation-1').tipsy({fade:true,gravity: 'w'});
	jQuery('#sub-title-animation-2').tipsy({fade:true,gravity: 'w'});

	jQuery( "#bbse_popup_alias" ).keyup(function() {
	  check_alias();
	  update_shortcode();
	});

	jQuery( "#bbse_popup_shortcode" ).click(function() {
	  jQuery( this ).select();
	});

	jQuery( "#bbse_popup_background_check" ).click(function() {
	  if(jQuery("input:checkbox[id='bbse_popup_background_check']").is(":checked") ==true) jQuery("#bbse_popup_background_color_pick").css("display","inline");
	  else jQuery("#bbse_popup_background_color_pick").css("display","none");
	});

	jQuery( "#bbse_popup_size_width" ).keydown(function() {
	  check_number();
	});
	jQuery( "#bbse_popup_size_height" ).keydown(function() {
	  check_number();
	});
	jQuery( "#bbse_popup_border" ).keydown(function() {
	  check_number();
	});
	jQuery( "#bbse_popup_corner" ).keydown(function() {
	  check_number();
	});
	jQuery( "#bbse_popup_margin_top" ).keydown(function() {
	  check_number();
	});
	jQuery( "#bbse_popup_margin_left" ).keydown(function() {
	  check_number();
	});

	jQuery('.colpick').each( function() {
		jQuery('.colpick').minicolors({
			control: jQuery(this).attr('data-control') || 'hue',
			defaultValue: jQuery(this).attr('data-defaultValue') || '',
			inline: jQuery(this).attr('data-inline') === 'true',
			letterCase: jQuery(this).attr('data-letterCase') || 'lowercase',
			opacity: jQuery(this).attr('data-opacity'),
			position: jQuery(this).attr('data-position') || 'bottom left',
			change: function(hex, opacity) {
				var log;
				try {
					log = hex ? hex : 'transparent';
					if( opacity ) log += ', ' + opacity;
					console.log(log);
				} catch(e) {}
			},
			theme: 'default'
		});

	});

	jQuery('.sliderPopupBorder').change(function(){
		var idx = jQuery('.sliderPopupBorder').index(jQuery(this));
		var val = jQuery('.sliderPopupBorder').eq(idx).val();
		jQuery('.sliderPopupBorderValue').text(val+"px");
	});
	jQuery('.sliderPopupConer').change(function(){
		var idx = jQuery('.sliderPopupConer').index(jQuery(this));
		var val = jQuery('.sliderPopupConer').eq(idx).val();
		jQuery('.sliderPopupConerValue').text(val+"px");
	});
	jQuery('.sliderOverlayOpacityRadius').change(function(){
		var idx = jQuery('.sliderOverlayOpacityRadius').index(jQuery(this));
		var val = jQuery('.sliderOverlayOpacityRadius').eq(idx).val();
		jQuery('.sliderOverlayOpacityRadiusValue').text((val*100)+"%");
	});
	jQuery('.sliderHorizontalLength').change(function(){
		var idx = jQuery('.sliderHorizontalLength').index(jQuery(this));
		var val = jQuery('.sliderHorizontalLength').eq(idx).val();
		jQuery('.sliderHorizontalLengthValue').text(val+"px");
	});
	jQuery('.sliderVerticalLength').change(function(){
		var idx = jQuery('.sliderVerticalLength').index(jQuery(this));
		var val = jQuery('.sliderVerticalLength').eq(idx).val();
		jQuery('.sliderVerticalLengthValue').text(val+"px");
	})
	jQuery('.sliderBlurRadius').change(function(){
		var idx = jQuery('.sliderBlurRadius').index(jQuery(this));
		var val = jQuery('.sliderBlurRadius').eq(idx).val();
		jQuery('.sliderBlurRadiusValue').text(val+"px");
	})
	jQuery('.sliderOpacityRadius').change(function(){
		var idx = jQuery('.sliderOpacityRadius').index(jQuery(this));
		var val = jQuery('.sliderOpacityRadius').eq(idx).val();
		jQuery('.sliderOpacityRadiusValue').text((val*100)+"%");
	})

	//사용함/사용안함
	jQuery('span.useCheck').click(function(){
		var $status    = jQuery(this).data('use');
		var $container = jQuery(this).data('container');
		var $view = jQuery(this).data('view');
		var $cnt = jQuery(this).data('cnt');

		if ($status == 'yes'){// 활성이면 비활성시키고 TR 감춤
			jQuery('#'+$container).val('N');
			jQuery(this).data('use','no');

			var $btn = jQuery(this).find('img').attr('src').replace("yes", "no");
			jQuery(this).find('img').attr('src', $btn);

			for(i=1;i<=$cnt;i++){
				jQuery('#'+$view+'-'+i).css('display','none');
			}
		}
		else if ($status == 'no'){ // 비활성이면 활성시키고 TR 보여줌
			jQuery('#'+$container).val('Y');
			jQuery(this).data('use','yes');

			var $btn = jQuery(this).find('img').attr('src').replace("no.","yes.");
			jQuery(this).find('img').attr('src', $btn);

			for(i=1;i<=$cnt;i++){
				jQuery('#'+$view+'-'+i).css('display','table-row');
			}
		}
	});

	if(jQuery("#bbsePopupIframe").length > 0){
		jQuery("#bbsePopupIframe").attr("src","http://update.onsetheme.com/banner_iframe/BBSe-Theme_banner.php?pName=BBSe-Popup&pAgent="+bbsepopup_var.blogAgent+"&pLanguage="+bbsepopup_var.blogLanguage+"&pSiteUrl="+bbsepopup_var.blogHome);
	}
});

var check_number=function(){
	var key = event.keyCode;
	if(!(key == 8 || key == 9 || key == 13 || key == 46 || key == 144 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 190)){
		event.returnValue = false;
	}
}

var check_alias=function() {
	var blank_pattern = /^\s+|\s+$/g;
	var valAlias=jQuery("#bbse_popup_alias").val();
	if (valAlias.indexOf(" ") > -1) {
		generateNotice('error', 'popupNotification', $trans._("Enter alias with blank spaces."), 'topRight', 5000, false);
		jQuery("#bbse_popup_alias").val(valAlias.replace(" ", ""));
		return;
	}
}

var update_shortcode = function(){
	var alias = jQuery("#bbse_popup_alias").val();			
	var shortcode = "[bbse_popup "+alias+"]";
	if(!alias)	shortcode = "";
	jQuery("#bbse_popup_shortcode").val(shortcode);
}

var change_modal = function(){
	var modal = jQuery("#bbse_popup_layout_modal").val();			
	if(modal=="Modal"){
		jQuery("#overlay-option").css("display","table-row");
		jQuery("#overlay-line").css("display","table-row");
	}
	else{
		jQuery("#overlay-option").css("display","none");
		jQuery("#overlay-line").css("display","none");
	}
}

var go_popup_page=function(gType,tData){
	var goUrl="";
	if(gType=='list'){
		goUrl="admin.php?page=bbse_Popup";
	}
	else if(gType=='update'){
		goUrl="admin.php?page=bbse_Popup_add&tMode=update&tData="+tData;
	}

	window.location.href=goUrl;
}

var chk_popup_submit=function(tMode){
	var periodStart=periodEnd="";
	jQuery("#tMode").val(tMode);

	if(tMode=='insert') var modeStr=$trans._("Add");
	else if(tMode=='update') var modeStr=$trans._("Update");

	if(jQuery("#bbse_popup_period").val()=='Y'){
		if(jQuery("#bbse_popup_period_start").val()){
			var periodStart=jQuery("#bbse_popup_period_start").val().replace("-","");
			var periodStart=periodStart.replace("/","");
		}
		if(jQuery("#bbse_popup_period_end").val()){
			var periodEnd=jQuery("#bbse_popup_period_end").val().replace("-","");
			var periodEnd=periodEnd.replace("/","");
		}
	}

	if(!jQuery("#bbse_popup_title").val()){
		jQuery("#bbse_popup_title").focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup title."), 'topRight', 5000, false); // alert, information, error, warning, success
		return
	}
	if(!jQuery("#bbse_popup_alias").val()){
		jQuery("#bbse_popup_alias").focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup alias."), 'topRight', 5000, false);
		return
	}
	if(!jQuery("#bbse_popup_size_width").val() || jQuery("#bbse_popup_size_width").val()<=0){
		jQuery("#bbse_popup_size_width").focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup size (Width)."), 'topRight', 5000, false);
		return
	}
	if(!jQuery("#bbse_popup_size_height").val() || jQuery("#bbse_popup_size_height").val()<=0){
		jQuery("#bbse_popup_size_height").focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup size (Height)."), 'topRight', 5000, false);
		return
	}
	if(jQuery("input:checkbox[id='bbse_popup_background_check']").is(":checked") ==true && !jQuery("#bbse_popup_background").val()){
		jQuery("#bbse_popup_background").focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup background color."), 'topRight', 5000, false);
		return
	}
	if(jQuery("#bbse_popup_border").val()>0 && !jQuery("#bbse_popup_border_color").val()){
		jQuery("#bbse_popup_border_color").focus()
		generateNotice('error', 'popupNotification', $trans._("Select popup border color."), 'topRight', 5000, false);
		return
	}
	switchEditors.go('bbse_popup_contents', 'tmce');
	var ed = tinyMCE.get('bbse_popup_contents');
	jQuery("#bbse_popup_contents").val(ed.getContent({format : 'raw'}));  // raw(비쥬얼) / text(텍스트)
	
	var tmpDetail=jQuery("#bbse_popup_contents").val().replace('<p><br data-mce-bogus=\"1\"></p>', '');
	tmpDetail=tmpDetail.replace('<p><br></p>', '');

	if(!tmpDetail){
		tinyMCE.get('bbse_popup_contents').focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup contents."), 'topRight', 5000, false);
		return
	}
	if(jQuery("#bbse_popup_period").val()=='Y' && !jQuery("#bbse_popup_period_start").val() && !jQuery("#bbse_popup_period_end").val()){
		jQuery("#bbse_popup_period_start").focus()
		generateNotice('error', 'popupNotification', $trans._("Enter popup period."), 'topRight', 5000, false);
		return
	}
	if(jQuery("#bbse_popup_period").val()=='Y' && periodStart && periodEnd && (periodStart >periodEnd)){
		generateNotice('error', 'popupNotification', $trans._("The popup end date must be equal to or greater than the start date."), 'topRight', 5000, false);
		return
	}
	if(jQuery("#bbse_popup_period").val()=='N'){
		jQuery("#bbse_popup_period_start").val("");
		jQuery("#bbse_popup_period_end").val("");
	}

	generateConfirm(tMode,$trans._("%s for popup?",$trans._(modeStr)),'center');
}

var go_popup_submit=function(rtnFlag){
	if(rtnFlag==true){
		tMode=jQuery("#tMode").val();
		tAlias=jQuery("#bbse_popup_alias").val();
		jQuery.ajax({
			type: 'post', 
			async: true, 
			url: bbsepopup_var.procUrl, 
			data: jQuery("#popupFrm").serialize(), 
			success: function(data){
				jQuery("#noty_center_layout_container").remove();
				//alert(data);
				var result = data.split("|||"); 
				if(result['0'] == "success"){
					if(tMode=='insert'){
						generateNotice('success', 'popupNotification', $trans._("Added popup."), 'topRight', 10000, false);
						go_popup_page('list','');
					}
					else if(tMode=='update'){
						generateNotice('success', 'popupNotification', $trans._("Edited popup."), 'topRight', 10000, false);
					}
				}
				else if(result['0'] == 'existAlias'){
					generateNotice('error', 'popupNotification', $trans._("'%s' alias already exists.",tAlias), 'topRight', 10000, false);
				}
				else if(result['0'] == "notExistData"){
					generateNotice('error', 'popupNotification', $trans._("Popup does not exist."), 'topRight', 10000, false);
				}
				else if(result['0'] == "dbError"){
					generateNotice('error', 'popupNotification', $trans._("Error occurred while saving DB."), 'topRight', 10000, false);
				}
				else{
					generateNotice('error', 'popupNotification', $trans._("Failed to connect to server."), 'topRight', 10000, false);
				}
			}, 
			error: function(data, status, err){
				jQuery("#noty_center_layout_container").remove();
				generateNotice('error', 'popupNotification', $trans._("Failed to connect to server."), 'topRight', 10000, false);
			}
		});	
	}
}

var change_animation=function(tType){
	var tAni=jQuery("#bbse_popup_animation_"+tType).val();
	if(tAni){
		jQuery(".aniSub_"+tType+"_select").css("display","none");
		if(jQuery("#bbse_popup_animation_"+tType+"_"+tAni)){
			jQuery("#bbse_popup_animation_"+tType+"_"+tAni).css("display","inline");
		}
	}
	else jQuery(".aniSub_"+tType+"_select").css("display","none");
}


var change_template=function(tVal){
	if(tVal){
		jQuery("#template-apply").css("display", "inline");
		jQuery("#template-apply-img").html("<img src='"+bbsepopup_var.popupWebPath+"templates/"+tVal+"/images/thumb_"+tVal+".jpg'>");
		jQuery("#template-apply-img").css("display", "inline");
	}
	else{
		jQuery("#template-apply").css("display", "none");
		jQuery("#template-apply-img").html("");
		jQuery("#template-apply-img").css("display", "none");
	}
}

var apply_template=function(){
	var tType=jQuery("#bbse_popup_template").val();
	var rtnHtml=bbsePopup_templates[tType]['html'];
	var layoutFlag=false;

	if(rtnHtml){
		jQuery("#bbse_popup_size_width").val(bbsePopup_templates[tType]['width']);
		jQuery("#bbse_popup_size_height").val(bbsePopup_templates[tType]['height']);

		if(bbsePopup_templates[tType]['background']=='Y'){
			jQuery("input:checkbox[id='bbse_popup_background_check']").prop("checked", true);
			jQuery("#bbse_popup_background").val(bbsePopup_templates[tType]['backgroundColor']);
		}
		else{
			jQuery("input:checkbox[id='bbse_popup_background_check']").prop("checked", false);
			jQuery("#bbse_popup_background").val("");
		}

		if(bbsePopup_templates[tType]['border']>0){
			layoutFlag=true;
			jQuery('.sliderPopupBorder').val(bbsePopup_templates[tType]['border']);
			jQuery('#bbse_popup_border_color').val(bbsePopup_templates[tType]['borderColor']);
			jQuery('.sliderPopupBorderValue').text(bbsePopup_templates[tType]['border']+"px");
		}
		else{
			jQuery('.sliderPopupBorder').val(0);
			jQuery('#bbse_popup_border_color').val("");
			jQuery('.sliderPopupBorderValue').text("0px");
		}

		if(bbsePopup_templates[tType]['radius']>0){
			layoutFlag=true;
			jQuery('.sliderPopupConer').val(bbsePopup_templates[tType]['radius']);
			jQuery('.sliderPopupConerValue').text(bbsePopup_templates[tType]['radius']+"px");
		}
		else{
			jQuery('.sliderPopupConer').val(0);
			jQuery('.sliderPopupConerValue').text("0px");
		}

		if(bbsePopup_templates[tType]['modal']=='Modal'){
			layoutFlag=true;
			jQuery('#bbse_popup_layout_modal').val(bbsePopup_templates[tType]['modal']);
			jQuery('#overlay-option').css("display","table-row");
			jQuery('#overlay-line').css("display","table-row");
			jQuery('#bbse_popup_overlay_color').val(bbsePopup_templates[tType]['modalOverlayColor']);
			jQuery('.sliderOverlayOpacityRadius').val((bbsePopup_templates[tType]['modalOverlayOpacity']/100));
			jQuery('.sliderOverlayOpacityRadiusValue').text(bbsePopup_templates[tType]['modalOverlayOpacity']+"%");
		}
		else{
			jQuery('#bbse_popup_layout_modal').val("Normal");
			jQuery('#overlay-option').css("display","none");
			jQuery('#overlay-line').css("display","none");
			jQuery('#bbse_popup_overlay_color').val("");
			jQuery('.sliderOverlayOpacityRadius').val("0");
			jQuery('.sliderOverlayOpacityRadiusValue').text("0%");
		}

		if(bbsePopup_templates[tType]['shadow']=='Y'){
			layoutFlag=true;
			jQuery("span.useCheck[data-view='shadow-option']").data('use','yes');
			var shEnBtnSrc=jQuery("#shadow_enable_button").prop('src');
			var newSrc=shEnBtnSrc.replace("switch_no.png","switch_yes.png");
			jQuery("#shadow_enable_button").prop('src',newSrc);
			jQuery("#bbse_popup_shadow_enabled").val('Y');

			for(i=1;i<=5;i++){
				jQuery('#shadow-option-'+i).css('display','table-row');
			}

			jQuery('.sliderHorizontalLength').val(bbsePopup_templates[tType]['shadowHorizontal']);
			jQuery('.sliderHorizontalLengthValue').text(bbsePopup_templates[tType]['shadowHorizontal']+"px");
			jQuery('.sliderVerticalLength').val(bbsePopup_templates[tType]['shadowVertical']);
			jQuery('.sliderVerticalLengthValue').text(bbsePopup_templates[tType]['shadowVertical']+"px");
			jQuery('.sliderBlurRadius').val(bbsePopup_templates[tType]['shadowBlur']);
			jQuery('.sliderBlurRadiusValue').text(bbsePopup_templates[tType]['shadowBlur']+"px");
			jQuery('#bbse_popup_shadow_color').val(bbsePopup_templates[tType]['shadowColor']);
			jQuery('.sliderOpacityRadius').val((bbsePopup_templates[tType]['shadowOpacity']/100));
			jQuery('.sliderOpacityRadiusValue').text(bbsePopup_templates[tType]['shadowOpacity']+"%");
		}
		else{
			jQuery("span.useCheck[data-view='shadow-option']").data('use','no');
			var shEnBtnSrc=jQuery("#shadow_enable_button").prop('src');
			var newSrc=shEnBtnSrc.replace("switch_yes.png","switch_no.png");
			jQuery("#shadow_enable_button").prop('src',newSrc);
			jQuery("#bbse_popup_shadow_enabled").val('N');

			for(i=1;i<=5;i++){
				jQuery('#shadow-option-'+i).css('display','none');
			}

			jQuery('.sliderHorizontalLength').val("0");
			jQuery('.sliderHorizontalLengthValue').text("0px");
			jQuery('.sliderVerticalLength').val("10");
			jQuery('.sliderVerticalLengthValue').text("10px");
			jQuery('.sliderBlurRadius').val("25");
			jQuery('.sliderBlurRadiusValue').text("25px");
			jQuery('#bbse_popup_shadow_color').val("#000000");
			jQuery('.sliderOpacityRadius').val("0.5");
			jQuery('.sliderOpacityRadiusValue').text("50%");
		}

		if(layoutFlag==true){
	    	if(!jQuery(".layoutRow").is(':visible')) 	jQuery(".layoutRow").toggleClass("hide");
			jQuery("#layoutPulldownIcon").prop("src",jQuery("#layoutPulldownIcon").prop("src").replace("arrow_down_16.png","arrow_up_16.png"));
		}

		if(bbsePopup_templates[tType]['closeButton']){
	    	if(!jQuery(".closebuttonRow").is(':visible')) jQuery(".closebuttonRow").toggleClass("hide");
			jQuery("#closebuttonPulldownIcon").prop("src",jQuery("#closebuttonPulldownIcon").prop("src").replace("arrow_down_16.png","arrow_up_16.png"));

			jQuery("input:radio[id=bbse_popup_close_button]:input[value='"+bbsePopup_templates[tType]['closeButton']+"']").attr("checked", true);
			jQuery('#bbse_popup_close_button_margin_top').val(bbsePopup_templates[tType]['closeButtonTop']);
			jQuery('#bbse_popup_close_button_margin_rihgt').val(bbsePopup_templates[tType]['closeButtonRight']);
		}
		else{
	    	if(jQuery(".closebuttonRow").is(':visible')) jQuery(".closebuttonRow").toggleClass("hide");
			jQuery("#closebuttonPulldownIcon").prop("src",jQuery("#closebuttonPulldownIcon").prop("src").replace("arrow_up_16.png","arrow_down_16.png"));

			jQuery("#bbse_popup_close_button").eq(0).attr("checked", true);
			jQuery('#bbse_popup_close_button_margin_top').val("0");
			jQuery('#bbse_popup_close_button_margin_rihgt').val("0");
		}

		switchEditors.go('bbse_popup_contents', 'tmce');

		var ed = tinyMCE.get('bbse_popup_contents');
		ed.setContent(rtnHtml, {format : 'text'});

		jQuery("#template-apply-img").html("");
		jQuery("#template-apply-img").css("display", "none");
	}
}
