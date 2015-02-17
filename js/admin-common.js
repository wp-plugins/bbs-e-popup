var bbsePopupDicType=bbsePopup_dictionary[bbsepopup_var.blogLanguage];
jQuery.i18n.load(bbsePopupDicType);
$trans=jQuery.i18n;

var toggle_contents=function(tObj){
	var imgUrl="";
	var tRow=jQuery("."+tObj+"Row");
	var tIcon=jQuery("#"+tObj+"PulldownIcon");

    	tRow.toggleClass("hide");

	if(tRow.is(':visible')) imgUrl=tIcon.prop("src").replace("arrow_down_16.png","arrow_up_16.png");
	else imgUrl=tIcon.prop("src").replace("arrow_up_16.png","arrow_down_16.png");

	tIcon.prop("src",imgUrl);
}

var bbse_plugin_menu_str=function(oType){
	switch (oType) {
	  case "license" :
		return "License Key";
  		break;
	}
}

var bbse_plugin_save_submit=function(oType){
	var msgStr=bbse_plugin_menu_str(oType);

	if(confirm($trans._("Save %s?",msgStr))){
		jQuery("#action").val('save');
		jQuery("#option_type").val(oType);
		jQuery("#optionForm").submit();
	}
}

var bbse_plugin_reset_submit=function(oType){
	var msgStr=menu_str(oType);
	if(confirm($trans._("Initialize %s?",msgStr))){
		jQuery("#action").val('reset');
		jQuery("#option_type").val(oType);
		jQuery("#optionForm").submit();
	}
}

var go_GetLicenseInfo=function(){ // 라이센트 관리 메뉴로 이동
	var goUrl="admin.php?page=bbse_License_manage";
	window.location.href=goUrl;
}

var go_GetLicenseKey=function(){ // 라이센트 키 받기
	var goUrl="http://license.bbsetheme.com";
	window.open(goUrl)
}

var go_previe=function(goUrl){ // 미리보기
	window.open(goUrl)
}
