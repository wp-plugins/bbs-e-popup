var generateNotice=function(type, theme, str, layout, timeout, modal) {
	jQuery("#noty_"+layout+"_layout_container").remove();
	var n = noty({
		text        : str,
		type        : type,
		dismissQueue: true,
		layout      : layout,
		theme       : theme,
		closeWith   : ['button', 'click'],
		maxVisible  : 1,
		modal       : modal,
		animation   : {
			open  : 'animated bounceInRight',
			close : 'animated bounceOutRight',
			easing: 'swing',
			speed : 500,
		}
	});

	setTimeout(function() {n.close();},timeout);
}

function generateConfirm(type,str,layout) {
	jQuery("#noty_"+layout+"_layout_container").remove();
	var n = noty({
		text        : str,
		type        : 'alert',
		dismissQueue: true,
		layout      : layout,
		theme       : 'defaultTheme',
		buttons     : [
			{
				addClass: 'btn btn-primary', 
				text: $trans._("Ok"), 
				onClick: function ($noty) {
					try {
					   $noty.close();
					}
					catch(err) { /*Block of code to handle errors*/ }
						
					if(type=='insert' || type=='update') go_popup_submit(true);
				}
			},
			{
				addClass: 'btn btn-danger', 
				text: $trans._("Cancel"), 
				onClick: function ($noty) {
					$noty.close();
				}
			}
		]
	});
}
