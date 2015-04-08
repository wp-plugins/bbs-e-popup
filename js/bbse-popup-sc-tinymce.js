(function() {
	var tarSize=Object.keys(bbsepopup_var.tinymceButton).length;

	var bbse_popup_array_create=function(){
		var rtn=aCom="";
		var cnt=1;

		for (var key in bbsepopup_var.tinymceButton){
			if(cnt<tarSize) aCom=",";
			else aCom="";
			rtn +="{ text: \""+key+"\", onclick: function(e){"
							+ "e.stopPropagation();"
							+ "var content = \"[bbse_popup "+bbsepopup_var.tinymceButton[key]+"]\";"
							+ "editor.insertContent(content);"
						+ "}"
				+ "}"+aCom;
			cnt++;
		}
		return "(["+rtn+"])";
	}

	tinymce.create('tinymce.plugins.BbsePopupScButtons', {
          init : function(editor, url) {
			if(tarSize>0){
				editor.addButton('bbse_popup_button', {
					title : "BBS e-Popup",
					text: 'BBS e-Popup',
					icon: false,
					type: 'menubutton',
					menu: eval(bbse_popup_array_create())
				});
			}
          },
          createControl : function(n, cm) {
               return null;
          },
	});
	/* Start the buttons */
	tinymce.PluginManager.add( 'bbse_popup_sc_button_script', tinymce.plugins.BbsePopupScButtons ); // functions.php 에 설정한 plugin_array 이름
})();