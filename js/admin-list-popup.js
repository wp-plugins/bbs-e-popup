jQuery(document).ready(function() {
	jQuery('#s_keyword').keyup(function(e) {
		if (e.keyCode == 13) search_submit();       
	});

	if(jQuery("#bbsePopupIframe").length > 0){
		jQuery("#bbsePopupIframe").attr("src","http://update.onsetheme.com/banner_iframe/BBSe-Theme_banner.php?pName=BBSe-Popup&pAgent="+bbsepopup_var.blogAgent+"&pLanguage="+bbsepopup_var.blogLanguage+"&pSiteUrl="+bbsepopup_var.blogHome);
	}
});

var view_list=function(sList){
	var goUrl="";
	var per_page=jQuery("#per_page").val();
	if(sList=='all') goUrl="admin.php?page=bbse_Popup&per_page="+per_page;
	else goUrl="admin.php?page=bbse_Popup&s_list="+sList+"&per_page="+per_page;
	window.location.href =goUrl;
}

var go_addNewPopup=function(){
	goUrl="admin.php?page=bbse_Popup_add";
	window.location.href =goUrl;
}

var change_popup_status=function(tMode,tStatus,tData){
	if(!tStatus){
		alert($trans._("Please select a bulk actions."));
		jQuery("#bulk_action").focus();
		return;
	}

	if(tStatus=="empty-trash"){
		if(!confirm($trans._("All popups in trash will be deleted.\nEmpty trash?"))){
			return;
		}
	}
	else if(!tData){
		var chked=jQuery("input[name=check\\[\\]]:checked").not(':disabled').size();
		var s_list=jQuery("#s_list").val();

		for(i=0;i<chked;i++){
			if(tData) tData +=",";
			tData +=jQuery("input[name=check\\[\\]]:checked").not(':disabled').eq(i).val();
		}

		if(chked<=0 || !tData) {
			alert($trans._("Select popup to execute batch work."));
			return;
		}

		if(tStatus=='Active'){
			if(!confirm($trans._("Change selected popup to 'Active'?"))){
				return;
			}
		}
		else if(tStatus=='Deactive'){
			if(!confirm($trans._("Change selected popup to 'Inactive'?"))){
				return;
			}
		}
		else if(tStatus=='restore'){
			if(!confirm($trans._("Restore selected popup?"))){
				return;
			}
		}
		else if(tStatus=='Trash'){
			if(!confirm($trans._("Move selected popup to 'Trash'?"))){
				return;
			}
		}
		else if(tStatus=='delete-permanently'){
			if(!confirm($trans._("Delete selected popup permanently?"))){
				return;
			}
		}
	}
	else if(tStatus=='Trash' && tData){
		if(!confirm($trans._("Move this popup to 'trash'?"))){
			return;
		}
	}
	else if(tData && tStatus=='restore'){
		if(!confirm($trans._("Restore this popup?"))){
			return;
		}
	}
	else if(tData && tStatus=='delete-permanently'){
		if(!confirm($trans._("Delete this popup permanently?"))){
			return;
		}
	}

	jQuery.ajax({
		type: 'post', 
		async: true, 
		url: bbsepopup_var.procUrl, 
		data: {action:"admin_action_proc",tMode:tMode, tStatus:tStatus, tData:tData}, 
		success: function(data){
			//alert(data);
			var result = data; 
			if(result=='success'){
				if(tStatus=='duplicate'){
					alert($trans._("Popup copy completed.\nUse after changing status of popup."));
				}
				search_submit();
			}
		}, 
		error: function(data, status, err){
			alert($trans._("Failed to connect to server."));
		}
	});	
}

var checkAll=function(){
	if(jQuery("#check_all").is(":checked")) jQuery("input[name=check\\[\\]]").attr("checked",true);
	else jQuery("input[name=check\\[\\]]").attr("checked",false);
}
	
var search_submit=function(){
	var page=jQuery("#page").val();
	var s_list=jQuery("#s_list").val();
	var per_page=jQuery("#per_page").val();
	var s_keyword=jQuery("#s_keyword").val();
	var s_period_1=jQuery("#s_period_1").val();
	var s_period_2=jQuery("#s_period_2").val();
	var strPara="page="+page+"&s_list="+s_list+"&per_page="+per_page;

	if(s_keyword) strPara +="&s_keyword="+s_keyword;
	if(s_period_1) strPara +="&s_period_1="+s_period_1;
	if(s_period_2) strPara +="&s_period_2="+s_period_2;

	window.location.href ="admin.php?"+strPara;
}