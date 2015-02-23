<?php
// [Page] BBS e-popup list
if(!function_exists('bbse_Popup_list')){
	function bbse_Popup_list(){
		global $wpdb,$plugin_shortname,$bbse_popup_btmMsg_language;

		wp_enqueue_style('bbse-popup-admin-datepicker',BBSE_POPUP_PLUGIN_WEB_URL.'js/datepicker/smoothness/jquery-ui-1.10.4.custom.min.css');
		wp_enqueue_script('jquery-ui-datepicker');

		$datepickerLang=(BBSE_POPUP_LANGUAGE && in_array(BBSE_POPUP_LANGUAGE,$bbse_popup_btmMsg_language))?BBSE_POPUP_LANGUAGE:"en-US";
		wp_enqueue_script('bbse-popup-admin-datepicker-lang',BBSE_POPUP_PLUGIN_WEB_URL.'js/datepicker/datepicker-regional.'.BBSE_POPUP_LANGUAGE.'.js',array('jquery'));

		wp_enqueue_script('bbse-popup-admin-noty-common',BBSE_POPUP_PLUGIN_WEB_URL.'js/admin-noty-common.js',array('jquery'));
		wp_enqueue_script('bbse-popup-admin-noty',BBSE_POPUP_PLUGIN_WEB_URL.'js/noty/jquery.noty.packaged.min.js',array('jquery'));
		wp_enqueue_style('bbse-popup-admin-noty',BBSE_POPUP_PLUGIN_WEB_URL.'js/noty/animate.css');

		wp_enqueue_script('bbse-popup-admin-add-popup',BBSE_POPUP_PLUGIN_WEB_URL.'js/admin-list-popup.js',array('jquery'));
		require_once(BBSE_POPUP_PLUGIN_ABS_PATH."admin/bbse-popup-list.php");
	}
}

// [Page] Add BBS e-popup
if(!function_exists('bbse_Popup_add')){
	function bbse_Popup_add(){
		global $wpdb,$plugin_shortname,$bbse_popup_btmMsg_language,$anmIn,$anmOut,$bbsePopup_closeButton;

		wp_enqueue_style('bbse-popup-admin-datepicker',BBSE_POPUP_PLUGIN_WEB_URL.'js/datepicker/smoothness/jquery-ui-1.10.4.custom.min.css');
		wp_enqueue_script('jquery-ui-datepicker');

		$datepickerLang=(BBSE_POPUP_LANGUAGE && in_array(BBSE_POPUP_LANGUAGE,$bbse_popup_btmMsg_language))?BBSE_POPUP_LANGUAGE:"en-US";
		wp_enqueue_script('bbse-popup-admin-datepicker-lang',BBSE_POPUP_PLUGIN_WEB_URL.'js/datepicker/datepicker-regional.'.$datepickerLang.'.js',array('jquery'));

		wp_enqueue_style('bbse-popup-admin-tipsy',BBSE_POPUP_PLUGIN_WEB_URL.'js/tipsy/tipsy.css');
		wp_enqueue_script('bbse-popup-admin-tipsy',BBSE_POPUP_PLUGIN_WEB_URL.'js/tipsy/jquery.tipsy.js',array('jquery'));

		wp_enqueue_script('bbse-popup-admin-noty-common',BBSE_POPUP_PLUGIN_WEB_URL.'js/admin-noty-common.js',array('jquery'));
		wp_enqueue_script('bbse-popup-admin-noty',BBSE_POPUP_PLUGIN_WEB_URL.'js/noty/jquery.noty.packaged.min.js',array('jquery'));
		wp_enqueue_style('bbse-popup-admin-noty',BBSE_POPUP_PLUGIN_WEB_URL.'js/noty/animate.css');

		wp_enqueue_style('bbse-popup-admin-minicolor',BBSE_POPUP_PLUGIN_WEB_URL.'js/minicolor/css/jquery.minicolors.css');
		wp_enqueue_script('bbse-popup-admin-minicolor',BBSE_POPUP_PLUGIN_WEB_URL.'js/minicolor/jquery.minicolors.js',array('jquery'));

		wp_enqueue_script('bbse-popup-templates',BBSE_POPUP_PLUGIN_WEB_URL.'templates/js/bbse-popup_templates.js',array('jquery'));
		wp_enqueue_script('bbse-popup-admin-add-popup',BBSE_POPUP_PLUGIN_WEB_URL.'js/admin-add-popup.js',array('jquery'));
		require_once(BBSE_POPUP_PLUGIN_ABS_PATH."admin/bbse-popup-add.php");
	}
}

// Admin pagination
if(!function_exists("bbse_pupup_get_pagination")) {
	function bbse_pupup_get_pagination($paged, $total_pages, $add_args=false) {
		/*
		$paged : current pagea
		$total_pages : total pages
		$add_args : parameter (query string)
		*/

		$paging = paginate_links( array(
			'base' => '%_%',
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $total_pages,
			'mid_size' => 20,
			'add_args' => $add_args
		) );

		return "<div class=\"admin-pagination\">".$paging."</div>";
	}
}

// [Active] BBS e-Popup Plugin
register_activation_hook(BBSE_POPUP_PLUGIN_CURRENT_PATH, 'bbse_popup_plugin_activation');
if(!function_exists('bbse_popup_plugin_activation')){
	function bbse_popup_plugin_activation() {
		global $wpdb;

		$createTable1 = "
			create table if not exists `".BBSE_POPUP_DB_TABLE."` (
				`idx` int(10) unsigned NOT NULL auto_increment,  
				`popup_title` varchar(255) default NULL,  
				`popup_alias` varchar(100) default NULL,  
				`popup_shortcode` varchar(200) default NULL,
				`popup_size` varchar(100) default NULL, 
				`popup_background` varchar(50) default NULL, 
				`popup_border` varchar(100) default NULL, 
				`popup_corner` varchar(10) default NULL, 
				`popup_contents` mediumtext default NULL,
				`popup_status` enum('Active','Inactive','Trash') default NULL, 
				`popup_pre_status` enum('Active','Inactive') default NULL, 
				`popup_period` enum('Y','N') default NULL,
				`popup_period_start` int(10) default NULL,
				`popup_period_end` int(10) default NULL,
				`popup_period_msg` varchar(100) default NULL,
				`popup_user` enum('All','LoggedIn','NotLoggedIn') default NULL,
				`popup_page` enum('All','Fronty','Pages','Posts') default NULL,
				`popup_browser` enum('All','PC','Mobile') default NULL,
				`popup_layout` enum('Window','Layer') default NULL,
				`popup_layout_modal` enum('Normal','Modal') default NULL,
				`popup_overlay` varchar(30) default NULL,
				`popup_shadow` varchar(100) default NULL,
				`popup_position` text default NULL,
				`popup_close_button` varchar(100) default NULL,
				`popup_reg` int(10) default NULL,
				PRIMARY KEY (`idx`),
				KEY `popup_alias` (`popup_alias`),
				KEY `popup_shortcode` (`popup_shortcode`),
				KEY `popup_status` (`popup_status`),
				KEY `popup_period` (`popup_period`),
				KEY `popup_user` (`popup_user`)
			) default charset=utf8";
		$wpdb->query($createTable1);

		$createTable2 = "
			create table if not exists `".BBSE_POPUP_AGENT_TABLE."` (
				`idx` int(10) unsigned NOT NULL auto_increment,  
				`popup_agent` varchar(255) default NULL,  
				PRIMARY KEY (`idx`),
				KEY `idx` (`idx`)
			) default charset=utf8";
		$wpdb->query($createTable2);
		
		$total = $wpdb->get_var("select count(*) from `".BBSE_POPUP_AGENT_TABLE."` WHERE idx='1'");
		if(empty($total) || $total<='0'){
			$wpdb->query("INSERT INTO `".BBSE_POPUP_AGENT_TABLE."` (`popup_agent`) VALUES ('".BBSE_POPUP_AGENT."')");
		}
	}
}


// [Get] Agent Name
if(!function_exists("bbse_pupup_get_agent")) {
	function bbse_pupup_get_agent() {
		global $wpdb;
		$agtData=$wpdb->get_row("SELECT * FROM ".BBSE_POPUP_AGENT_TABLE." WHERE idx='1'");

		if($agtData->popup_agent) $rtnAgent=$agtData->popup_agent;
		else $rtnAgent=BBSE_POPUP_AGENT;

		return $rtnAgent;
	}
}



// [Frontpage] css/javascript 
add_action('wp_enqueue_scripts', 'bbse_popup_scripts');
if(!function_exists('bbse_popup_scripts')){
	function bbse_popup_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-form');
		wp_enqueue_style('bbse-popup-view', BBSE_POPUP_PLUGIN_WEB_URL.'css/bbse-popup-style.css');
		wp_enqueue_script('bbse-popup-view',BBSE_POPUP_PLUGIN_WEB_URL.'js/bbse-popup-common.js');
	}
}

// [Remove shorcode] when is not post page
if(!function_exists('bbse_popup_remove_shortcode')){
	function bbse_popup_remove_shortcode( $content ) {
		global $wpdb;
		$patthern=Array("/<P>\[bbse_popup .*?\]<\/P>\r\n|\r|\n/is","/<P>\[bbse_popup .*?\]<\/P>/is","/\[bbse_popup .*?\]\r\n|\r|\n/is","/\[bbse_popup .*?\]/is");
		if (!is_single() && !is_page()) {
			$content=preg_replace($patthern, "", $content);
		}
		return $content;
	}
}
add_filter( 'the_content', 'bbse_popup_remove_shortcode' );

// [Hook] Footer
if(!function_exists('bbse_popup_set_footer_hook')){
	function bbse_popup_set_footer_hook() {
		$bbse_pid=$_REQUEST['bbse_pid'];
		$preview=$_REQUEST['preview'];

		if(is_front_page() && (!$_SERVER['QUERY_STRING'] || ($bbse_pid>0 && $preview==true))){
			$detect = new BBSePopupMobileDetect;

			if(!$detect->isMobile()){
				$popContent=bbse_popup_get_print('Fronty','');
				echo $popContent;
			}
		}
	}
}
add_action('wp_footer', 'bbse_popup_set_footer_hook');

// [Create] HTML for Popup
if(!function_exists('bbse_popup_get_print')){
	function bbse_popup_get_print($pMode,$pAlias) {
		global $wpdb,$bbse_popup_btmMsg,$bbsePopup_closeButton;
		$nowTime=current_time('timestamp');
		$rtnContents="";
		$rtnScript="";
		$bbse_pid=$_REQUEST['bbse_pid'];
		$preview=$_REQUEST['preview'];

		if(current_user_can('administrator') && $bbse_pid>'0' && $preview==true){
			$result = $wpdb->get_results("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE idx='".$bbse_pid."'");
		}
		else{
			if($pMode=='Fronty') $aliasOption = "";
			elseif(($pMode=='Posts' || $pMode=='Pages') && $pAlias) $aliasOption = " AND popup_alias='".$pAlias."'";
			else return $rtnContents;

			$result = $wpdb->get_results("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status='Active' AND (popup_page='All' OR popup_page='".$pMode."')".$aliasOption." AND ((popup_period='Y' AND ((popup_period_start='' AND popup_period_end>='".$nowTime."') OR (popup_period_start<='".$nowTime."' AND popup_period_end='') OR (popup_period_start<='".$nowTime."' AND popup_period_end>='".$nowTime."'))) OR popup_period='N')");
		}

		foreach($result as $i=>$data) {
			if(!current_user_can('administrator') || $bbse_pid<'0' || $preview!=true){
				if (($data->popup_user=='LoggedIn' && !is_user_logged_in()) || ($data->popup_user=='NotLoggedIn' && is_user_logged_in()) || ($_COOKIE['bbsePopupIdx'.$data->idx] == 'Today' || $_COOKIE['bbsePopupIdx'.$data->idx] == 'Minute')) continue;
			}

			$pId=$data->popup_alias;

			$pSize=explode("|||",$data->popup_size);
			$pBorder=explode("|||",$data->popup_border);
			$borderStyle=$cornerStyle=$aniStyle=$pShadowStyle=$bottomMsg="";

			if($data->popup_background) $cornerStyle .="background:".$data->popup_background.";";
			if(!$pBorder['1']) $pBorder['1']="#ffffff";
			if($pBorder['0']>'0') $borderStyle .="border:".$pBorder['0']."px solid ".$pBorder['1'].";";
			if($data->popup_corner>'0') {
				$cornerStyle .="border-radius:".$data->popup_corner."px;-webkit-border-radius:".$data->popup_corner."px;-moz-border-radius:".$data->popup_corner."px;-o-border-radius:".$data->popup_corner."px;";
				$pOverflowHidden="overflow:hidden;";
			}
			$pPosition=explode("|||",$data->popup_position);

			if($data->popup_layout_modal=='Modal'){
				$mainStyle="style=\"width:100%; height:100%;\"";

				$pOverlay=explode("|||",$data->popup_overlay);
				$pOverlayStyle="style=\"background:".$pOverlay['0']."; opacity:".$pOverlay['1']."; filter:alpha(opacity=".($pOverlay['1']*100).");\"";

				$modalBg="<div class=\"bg\" ".$pOverlayStyle."></div>";
			}
			else $mainStyle=$modalBg="";

		    $aniStyle="top:".$pPosition['1']."px;left:".$pPosition['2']."px;"; 

			$pShadow=explode("|||",$data->popup_shadow);
			if($pShadow['0']=='Y'){
				$tmpHax=str_replace("#","",$pShadow['4']);
				$rgbRed=hexdec(substr($tmpHax,0,1))*16+hexdec(substr($tmpHax,1,1));
				$rgbGreen=hexdec(substr($tmpHax,2,1))*16+hexdec(substr($tmpHax,3,1));
				$rgbBlue=hexdec(substr($tmpHax,4,1))*16+hexdec(substr($tmpHax,5,1));
				$shawowRGB=$rgbRed.",".$rgbGreen.",".$rgbBlue;

				$pShadowStyle="-webkit-box-shadow: ".$pShadow['1']."px ".$pShadow['2']."px ".$pShadow['3']."px rgba(".$shawowRGB.",".$pShadow['5'].");-moz-box-shadow: ".$pShadow['1']."px ".$pShadow['2']."px ".$pShadow['3']."px rgba(".$shawowRGB.",".$pShadow['5'].");box-shadow: ".$pShadow['1']."px ".$pShadow['2']."px ".$pShadow['3']."px rgba(".$shawowRGB.",".$pShadow['5'].");";
			}
			
			$pPeriodMsg=explode("|||",$data->popup_period_msg);
			if($pPeriodMsg['0']=='Y'){
				if($pPeriodMsg['3']=='Center'){
					$tmpBottomStyle=" style=\"width:350px;margin:0 auto;\"";
				}
				elseif($pPeriodMsg['3']=='Right'){
					$tmpBottomStyle=" style=\"width:100%;text-align:right;\"";
				}
				else $tmpBottomStyle="";
				$bottomMsg = "<div class=\"btn-popup\" ".$tmpBottomStyle."><span  style=\"padding:0 50px 0 20px;color:".$pPeriodMsg['4'].";font-size :12px;\"><input type=\"checkbox\" name=\"bbse_popup_nomore\" id=\"bbse_popup_nomore\" data-type=\"".$pPeriodMsg['2']."\" data-pidx=\"".$pId."\" value=\"bbsePopupIdx".$data->idx."\"> ".$bbse_popup_btmMsg[$pPeriodMsg['2']][$pPeriodMsg['1']]."</span></div>";
			}
						
			$pCloseButton=explode("|||",$data->popup_close_button);
			if(!$pCloseButton['0']) $pCloseButton['0']=$bbsePopup_pro_closeButton['0'];
			$pCloseButtonTop=$pCloseButton['1'];
			$pCloseButtonLeft=$pSize['0']+6-$pCloseButton['2'];

			// check for youtube shortcode
			$uTubeCnt=preg_match_all("/\[bbse_youtube .*?\]/is",$data->popup_contents,$uTubeList);
			if($uTubeCnt>'0'){
				$popUpContents=bbse_popup_get_youtube_oembed($data->popup_contents,$uTubeList);
			}
			else $popUpContents=$data->popup_contents;

			$popUpContents=str_replace("mce-text","text",$popUpContents);

			$rtnContents .="
				<div class=\"bbse-layer-popup\" id=\"popup-".$pId."\"".$mainStyle.">
					".$modalBg."
					<div class=\"free_popup_layer\" id=\"popup-".$pId."-contents\" style=\"".$aniStyle."position:absolute;width:".($pSize['0']+30)."px;height:".$pSize['1']."px;\">
						<div class=\"btn-popup\" style=\"position:absolute;top:".$pCloseButtonTop."px;left:".$pCloseButtonLeft."px;\">
							<a href=\"#\" id=\"btn-popup-".$pId."\" class=\"popup-cbtn\"><img src=\"".BBSE_POPUP_PLUGIN_WEB_URL."images/btn_close/".$pCloseButton['0']."\"></a>
						</div>
						<div id=\"BBSE-POPUP-CONTENT\" style=\"".$borderStyle.$cornerStyle."width:".$pSize['0']."px;height:".$pSize['1']."px;max-width:".$pSize['0']."px;".$pOverflowHidden.$pShadowStyle."\">
							".$popUpContents."
						</div>
						".$bottomMsg."
					</div>
				</div>";
			$rtnScript .="popup_view('".$pId."','".strtolower($pPosition['0'])."','','');\n";
		}
		$rtnContents .="<script language=\"javascript\">".$rtnScript."</script>";

		return $rtnContents;
	}
}

// [Parse] Youtube url 
if (!function_exists('bbse_popup_get_youtube_oembed')){
	function bbse_popup_get_youtube_oembed($pContents,$tUrl){
		$ptn_src="/src=[\"'].*?[\"']/is";
		$ptn_width="/width=[\"'].*?[\"']/is";
		$ptn_height="/height=[\"'].*?[\"']/is";
		$ptn_autoplay="/autoplay=[\"'].*?[\"']/is";

		for($u=0;$u<sizeof($tUrl['0']);$u++){
			unset($uScr);
			unset($uWidth);
			unset($uHeight);
			unset($uAutoplay);
			$uEmbed="";

			preg_match($ptn_src,$tUrl['0'][$u],$uScr);
			preg_match($ptn_width,$tUrl['0'][$u],$uWidth);
			preg_match($ptn_height,$tUrl['0'][$u],$uHeight);
			preg_match($ptn_autoplay,$tUrl['0'][$u],$uAutoplay);

			$uScr['0']=str_replace("\"","",$uScr['0']);
			$uScr['0']=str_replace("'","",$uScr['0']);
			$uScr['0']=str_replace("src=","",$uScr['0']);
			$uScr['0']=str_replace("SRC=","",$uScr['0']);

			$uWidth['0']=str_replace("\"","",$uWidth['0']);
			$uWidth['0']=str_replace("'","",$uWidth['0']);
			$uWidth['0']=str_replace("px","",strtolower($uWidth['0']));
			$uWidth['0']=str_replace("width=","",strtolower($uWidth['0']));

			$uHeight['0']=str_replace("\"","",$uHeight['0']);
			$uHeight['0']=str_replace("'","",$uHeight['0']);
			$uHeight['0']=str_replace("px","",strtolower($uHeight['0']));
			$uHeight['0']=str_replace("height=","",strtolower($uHeight['0']));

			$uAutoplay['0']=str_replace("\"","",$uAutoplay['0']);
			$uAutoplay['0']=str_replace("'","",$uAutoplay['0']);
			$uAutoplay['0']=str_replace("autoplay=","",strtolower($uAutoplay['0']));

			if($uScr['0'] && $uWidth['0'] && $uHeight['0']){
				//$uEmbed=wp_oembed_get($uScr['0'], Array('width'=>$uWidth['0'], 'height'=>$uHeight['0']));

				$uEmbed=bbse_popup_parse_youtube_url($uScr['0'],'embed', $uWidth['0'],$uHeight['0'],0,$uAutoplay['0']);
				if($uEmbed) $pContents=str_replace($tUrl['0'][$u],$uEmbed,$pContents);
			}
		}

		return $pContents;
	}
}

// [Make] iframe for youtube url
if (!function_exists('bbse_popup_parse_youtube_url')){
	function bbse_popup_parse_youtube_url($url,$return='embed',$width='',$height='',$rel=0,$autoplay=0){
		$urls = parse_url($url);
		//url is http://youtu.be/xxxx
		if($urls['host'] == 'youtu.be'){
			$id = ltrim($urls['path'],'/');
		}
		//url is http://www.youtube.com/embed/xxxx
		else if(strpos($urls['path'],'embed') == 1){
			$id = end(explode('/',$urls['path']));
		}
		 //url is xxxx only
		else if(strpos($url,'/')===false){
			$id = $url;
		}
		else{
			parse_str($urls['query']);
			$id = $v;
			if(!empty($feature)){
				$id = end(explode('v=',$urls['query']));
			}
		}
		//return embed iframe
		if($return == 'embed'){
			if($id && $width && $height){
				return '<iframe src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'&autoplay='.$autoplay.'" frameborder="0" allowfullscreen style="width:'.($width?$width:560).'px;height:'.($height?$height:349).'px;z-index:3333"></iframe>';
			}
			else return "";
		}
		//return normal thumb
		else if($return == 'thumb'){
			if($id) return 'http://i1.ytimg.com/vi/'.$id.'/default.jpg';
			else return "";
		}
		//return hqthumb
		else if($return == 'hqthumb'){
			if($id) return 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg';
			else return "";
		}
		// else return id
		else{
			if($id) return $id;
			else return "";
		}
	}
}

// [Shortcode] parse
if (!function_exists('bbse_popup_shortcord_parse')){
	function bbse_popup_shortcord_parse($atts, $content=null){
		$pAlias="";
		for($i=0;$i<sizeof($atts);$i++){
			if($pAlias) $pAlias .=" ";
			$pAlias .=$atts[$i];
		}

		if(is_single()) $pMode="Posts";
		elseif(is_page()) $pMode="Pages";

		$rtnContents = bbse_popup_get_print($pMode,$pAlias);
		return $rtnContents;
	}
}
add_shortcode('bbse_popup', 'bbse_popup_shortcord_parse');

// [Admin] javascript 
add_action('admin_enqueue_scripts', 'bbse_popup_admin_scripts');
if(!function_exists('bbse_popup_admin_scripts')){
	function bbse_popup_admin_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-form');
	}
}

// [Admin] css
add_action('admin_enqueue_scripts', 'bbse_popup_admin_styles');
if(!function_exists('bbse_popup_admin_styles')){
	function bbse_popup_admin_styles(){
		$dic_js=BBSE_POPUP_PLUGIN_ABS_PATH.'js/BBSe-Popup_dic.po.js';
		wp_enqueue_style('bbse-popup-admin-ui', BBSE_POPUP_PLUGIN_WEB_URL.'css/admin-style.css');
		if(file_exists($dic_js)){
			wp_enqueue_script('bbse-popup-admin-dictionary',BBSE_POPUP_PLUGIN_WEB_URL.'js/BBSe-Popup_dic.po.js'); // Multi Language Dictionary
		}
		wp_enqueue_script('bbse-popup-admin-i18n',BBSE_POPUP_PLUGIN_WEB_URL.'js/jquery.i18n.js'); // Multi Language jQuery Plugin
		wp_enqueue_script('bbse-popup-admin-common',BBSE_POPUP_PLUGIN_WEB_URL.'js/admin-common.js');
		wp_localize_script( 'bbse-popup-admin-common', 'bbsepopup_var', 
			array(
				'procUrl' => admin_url( 'admin-ajax.php' ),
				'blogHome' => BBSE_POPUP_SITE_URL,
				'blogAgent' => bbse_pupup_get_agent(),
				'blogLanguage' => BBSE_POPUP_LANGUAGE,
				'popupWebPath' => BBSE_POPUP_PLUGIN_WEB_URL,
				'tinymceButton' => bbse_get_tinymce_popup_list()
			)
		); // Blog Infomation
	}
}

// [Admin] menu
add_action('admin_menu', 'bbse_popup_menu');
if(!function_exists('bbse_popup_menu')){
	function bbse_popup_menu(){
		add_menu_page('BBS e-Popup', 'BBS e-Popup', 'administrator', 'bbse_Popup', 'bbse_Popup_list');
		add_submenu_page('bbse_Popup', 'Popup list', __('Popup list','BBSe_Popup'), 'administrator', 'bbse_Popup', 'bbse_Popup_list');
		add_submenu_page('bbse_Popup', 'Add New Popup', __('Add New Popup','BBSe_Popup'), 'administrator', 'bbse_Popup_add', 'bbse_Popup_add');
	}
}

// [TinyMCE] get popup count for pages and posts
if (!function_exists('bbse_get_count_popup_list')) {
	function bbse_get_count_popup_list() {
		global $wpdb;
		$screen = get_current_screen();
		$nowTime=current_time('timestamp');
		$popList='0';
		$cntType="";

		if($screen ->id=='post' || $screen ->id=='edit-post') $cntType="Posts";
		elseif($screen ->id=='page' || $screen ->id=='edit-page') $cntType="Pages";
		if($cntType){
			$popList=$wpdb->get_var("SELECT count(*) FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status='Active' AND (popup_page='All' OR popup_page='".$cntType."') AND ((popup_period='Y' AND ((popup_period_start='' AND popup_period_end>='".$nowTime."') OR (popup_period_start<='".$nowTime."' AND popup_period_end='') OR (popup_period_start<='".$nowTime."' AND popup_period_end>='".$nowTime."'))) OR popup_period='N')");
		}

		 return $popList;
	}
}

// [TinyMCE] get pop-up alias list
if (!function_exists('bbse_get_tinymce_popup_list')) {
	function bbse_get_tinymce_popup_list() {
		global $wpdb;
		$tmpTinyMCE=Array();
		$screen = get_current_screen();
		$nowTime=current_time('timestamp');
		$pMode="";

		 if (bbse_check_tinymce_editor()) { // (posts or pages) && pop-up count > 0
			if($screen ->id=='post' || $screen ->id=='edit-post') $pMode="Posts";
			elseif($screen ->id=='page' || $screen ->id=='edit-page') $pMode="Pages";
			if($pMode){
				$result = $wpdb->get_results("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status='Active' AND (popup_page='All' OR popup_page='".$pMode."') AND ((popup_period='Y' AND ((popup_period_start='' AND popup_period_end>='".$nowTime."') OR (popup_period_start<='".$nowTime."' AND popup_period_end='') OR (popup_period_start<='".$nowTime."' AND popup_period_end>='".$nowTime."'))) OR popup_period='N')");
				foreach($result as $i=>$data) {
					$tmpTinyMCE[$data->popup_title]=$data->popup_alias;
				}
			}
		}
		 return $tmpTinyMCE;
	}
}

// [Check] the editor (pages & posts)
if (!function_exists('bbse_check_tinymce_editor')) {
	function bbse_check_tinymce_editor() {
		$screen = get_current_screen();
		$chkType="";
		if($screen ->id=='post' || $screen ->id=='edit-post') $chkType="Posts";
		elseif($screen ->id=='page' || $screen ->id=='edit-page') $chkType="Pages";

		if($chkType){
			 if(bbse_get_count_popup_list()>'0') return true;
			 else return false;
		 }
		 else return false;
	}
}

// [Add] the TinyMCE Buttons (start)
if (!function_exists('bbse_popup_shortcode_tinymce')) {
	function bbse_popup_shortcode_tinymce() {
		add_filter( 'mce_buttons', 'bbse_popup_shortcode_register_tinymce' ); // add button
		add_filter( 'mce_external_plugins', 'bbse_popup_shortcode_add_tinymce_plugin' ); // add function for button (Plugin)
	}
}

if (!function_exists('bbse_popup_shortcode_register_tinymce')) {
	function bbse_popup_shortcode_register_tinymce( $buttons ) {
		 array_push( $buttons, "bbse_popup_button" );  // set button (plugin .js)
		 return $buttons;
	}
}

if (!function_exists('bbse_popup_shortcode_add_tinymce_plugin')) {
	function bbse_popup_shortcode_add_tinymce_plugin( $plugin_array ) {
		 $plugin_array['bbse_popup_sc_button_script'] = BBSE_POPUP_PLUGIN_WEB_URL.'js/bbse-popup-sc-tinymce.js';
		 return $plugin_array;
	}
}
// [Add] the TinyMCE Buttons (end)

// [Deactive] the plugin
register_deactivation_hook(BBSE_POPUP_PLUGIN_CURRENT_PATH, 'bbse_popup_deactiv_proc');
if(!function_exists('bbse_popup_deactiv_proc')){
	function bbse_popup_deactiv_proc(){
		global $wpdb;
		
		// action for deactive
	}
}

// [Uninstall] the plugin
register_uninstall_hook(BBSE_POPUP_PLUGIN_CURRENT_PATH, 'uninstall_bbse_popup_plugin');
if(!function_exists('uninstall_bbse_popup_plugin')){
	function uninstall_bbse_popup_plugin(){
		global $wpdb;

		$dropTable1="drop table if exists `".BBSE_POPUP_DB_TABLE."`";
		$wpdb->query($dropTable1);
	}
}

// [Change] unixtime to date
if(!function_exists('bbse_popup_get_unix_to_date')){
	function bbse_popup_get_unix_to_date($tUnixTime){
		$rtnDate="";
		if($tUnixTime>'0'){
			switch(BBSE_POPUP_LANGUAGE){
				case 'en-US' : 
					$rtnDate=date("m-d-Y",$tUnixTime);
					break;
				case 'ko-KR' : 
				case 'zh-CN' : 
				case 'ja' : 
					$rtnDate=date("Y-m-d",$tUnixTime);
					break;
				default : 
					$rtnDate=date("m-d-Y",$tUnixTime);
					break;
			}
		}
		return $rtnDate;
	}
}

// [Change] date to unixtime
if(!function_exists('bbse_popup_get_date_to_unix')){
	function bbse_popup_get_date_to_unix($tType,$tDate){
		$rtnTime="";
		if($tDate){
			$tmpDate=explode("-", $tDate);
			switch(BBSE_POPUP_LANGUAGE){
				case 'en-US' : 
					if($tType=='start') $rtnTime=mktime('00','00','00',$tmpDate['0'],$tmpDate['1'],$tmpDate['2']);
					elseif($tType=='end') $rtnTime=mktime('23','59','59',$tmpDate['0'],$tmpDate['1'],$tmpDate['2']);
					break;
				case 'ko-KR' : 
				case 'zh-CN' : 
				case 'ja' : 
					if($tType=='start') $rtnTime=mktime('00','00','00',$tmpDate['1'],$tmpDate['2'],$tmpDate['0']);
					elseif($tType=='end') $rtnTime=mktime('23','59','59',$tmpDate['1'],$tmpDate['2'],$tmpDate['0']);
					break;
				default : 
					if($tType=='start') $rtnTime=mktime('00','00','00',$tmpDate['0'],$tmpDate['1'],$tmpDate['2']);
					elseif($tType=='end') $rtnTime=mktime('23','59','59',$tmpDate['0'],$tmpDate['1'],$tmpDate['2']);
					break;
			}
		}
		return $rtnTime;
	}
}
