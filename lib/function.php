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
if(!function_exists("bbse_commerce_get_pagination")) {
	function bbse_commerce_get_pagination($paged, $total_pages, $add_args=false) {
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

if(!function_exists('bbse_popup_admin_action_proc')){
	function bbse_popup_admin_action_proc() {
		global $wpdb;

		if(!stristr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])){echo "nonData";die();}
		$V = $_POST;

		if($V['tMode']=='insert'){ 
			if(!$V['bbse_popup_title'] || !$V['bbse_popup_alias'] || !$V['bbse_popup_shortcode'] || !$V['bbse_popup_size_width'] || !$V['bbse_popup_size_height'] || !$V['bbse_popup_contents'] || !$V['bbse_popup_status']){
				echo "fail";
				exit;
			}

			$popup_title=$V['bbse_popup_title'];
			$popup_alias=$V['bbse_popup_alias'];
			$popup_shortcode=$V['bbse_popup_shortcode'];

			if(!$V['bbse_popup_size_width']) $V['bbse_popup_size_width']='0';
			if(!$V['bbse_popup_size_height']) $V['bbse_popup_size_height']='0';
			$popup_size=$V['bbse_popup_size_width']."|||".$V['bbse_popup_size_height'];

			if($V['bbse_popup_background_check']=='Y') $popup_background=$V['bbse_popup_background'];
			else $popup_background="";

			if(!$V['bbse_popup_border']) $V['bbse_popup_border']='0';
			if(!$V['bbse_popup_border_color']) $V['bbse_popup_border_color']='#ffffff';
			$popup_border=$V['bbse_popup_border']."|||".$V['bbse_popup_border_color'];

			if(!$V['bbse_popup_corner']) $V['bbse_popup_corner']='0';
			$popup_corner=$V['bbse_popup_corner'];

			$popup_contents=str_replace("mce-text","text",$V['bbse_popup_contents']);
			$popup_status=$V['bbse_popup_status'];
			$popup_period=$V['bbse_popup_period'];
			$popup_period_start=$popup_period_end="";

			if($popup_period=='Y'){
				if($V['bbse_popup_period_start']) $popup_period_start=bbse_popup_get_date_to_unix('start',$V['bbse_popup_period_start']);
				if($V['bbse_popup_period_end']) $popup_period_end=bbse_popup_get_date_to_unix('end',$V['bbse_popup_period_end']);
			}

			$popup_period_msg=$V['bbse_popup_period_msg_enable']."|||".$V['bbse_popup_period_msg_language']."|||".$V['bbse_popup_period_msg_type']."|||".$V['bbse_popup_period_msg_position']."|||".$V['bbse_popup_period_msg_color'];

			$popup_user=$V['bbse_popup_user'];
			$popup_page=$V['bbse_popup_page'];
			$popup_browser=$V['bbse_popup_browser'];
			$popup_layout=$V['bbse_popup_layout'];

			if($popup_layout=='Window') $popup_layout_modal='Normal';
			else $popup_layout_modal=$V['bbse_popup_layout_modal'];

			if(!$V['bbse_popup_overlay_color']) $V['bbse_popup_overlay_color']='#000000';
			$popup_overlay=$V['bbse_popup_overlay_color']."|||".$V['bbse_popup_overlay_opacity_radius'];

			if(!$V['bbse_popup_shadow_color']) $V['bbse_popup_shadow_color']='#000000';
			$popup_shadow=$V['bbse_popup_shadow_enabled']."|||".$V['bbse_popup_shadow_horizontal_length']."|||".$V['bbse_popup_shadow_vertical_length']."|||".$V['bbse_popup_shadow_blur_radius']."|||".$V['bbse_popup_shadow_color']."|||".$V['bbse_popup_shadow_opacity_radius'];

			if(!$V['bbse_popup_margin_top']) $V['bbse_popup_margin_top']='0';
			if(!$V['bbse_popup_margin_bottom']) $V['bbse_popup_margin_bottom']='0';
			if(!$V['bbse_popup_margin_left']) $V['bbse_popup_margin_left']='0';
			if(!$V['bbse_popup_margin_right']) $V['bbse_popup_margin_right']='0';
			$popup_position=$V['bbse_popup_position']."|||".$V['bbse_popup_margin_top']."|||".$V['bbse_popup_margin_left'];

			if(!$V['bbse_popup_close_button']) $V['bbse_popup_close_button']=$bbsePopup_pro_closeButton['0'];
			if(!$V['bbse_popup_close_button_margin_top']) $V['bbse_popup_close_button_margin_top']='0';
			if(!$V['bbse_popup_close_button_margin_rihgt']) $V['bbse_popup_close_button_margin_rihgt']='0';
			$popup_close_button=$V['bbse_popup_close_button']."|||".$V['bbse_popup_close_button_margin_top']."|||".$V['bbse_popup_close_button_margin_rihgt'];

			$popup_reg=current_time('timestamp');

			$cnt=$wpdb->get_var("SELECT count(*) FROM ".BBSE_POPUP_DB_TABLE." WHERE popup_alias='".$popup_alias."'");

			if($cnt>'0'){
				echo "existAlias";
				return;
			}

			$result=$wpdb->query("INSERT INTO ".BBSE_POPUP_DB_TABLE." (popup_title, popup_alias, popup_shortcode, popup_size, popup_background, popup_border, popup_corner, popup_contents, popup_status, popup_period, popup_period_start, popup_period_end, popup_period_msg, popup_user, popup_page, popup_browser, popup_layout, popup_shadow, popup_layout_modal, popup_overlay, popup_position, popup_close_button, popup_reg) VALUES ('".$popup_title."', '".$popup_alias."', '".$popup_shortcode."', '".$popup_size."', '".$popup_background."', '".$popup_border."', '".$popup_corner."', '".$popup_contents."', '".$popup_status."', '".$popup_period."', '".$popup_period_start."', '".$popup_period_end."', '".$popup_period_msg."', '".$popup_user."', '".$popup_page."', '".$popup_browser."', '".$popup_layout."', '".$popup_shadow."', '".$popup_layout_modal."', '".$popup_overlay."', '".$popup_position."', '".$popup_close_button."','".$popup_reg."')");

			if($result){
				echo "success";
				exit;
			}
			else{
				echo "dbError";
				exit;
			}
		}
		elseif($V['tMode']=='update'){ 
			if(!$V['tData'] || !$V['bbse_popup_title'] || !$V['bbse_popup_alias'] || !$V['bbse_popup_shortcode'] || !$V['bbse_popup_size_width'] || !$V['bbse_popup_size_height'] || !$V['bbse_popup_contents'] || !$V['bbse_popup_status']){
				echo "fail";
				exit;
			}

			$cnt=$wpdb->get_var("SELECT count(*) FROM ".BBSE_POPUP_DB_TABLE." WHERE idx='".$V['tData']."'");

			if($cnt<='0'){
				echo "notExistData";
				return;
			}


			$popup_title=$V['bbse_popup_title'];
			$popup_alias=$V['bbse_popup_alias'];
			$popup_shortcode=$V['bbse_popup_shortcode'];

			if(!$V['bbse_popup_size_width']) $V['bbse_popup_size_width']='0';
			if(!$V['bbse_popup_size_height']) $V['bbse_popup_size_height']='0';
			$popup_size=$V['bbse_popup_size_width']."|||".$V['bbse_popup_size_height'];

			if($V['bbse_popup_background_check']=='Y') $popup_background=$V['bbse_popup_background'];
			else $popup_background="";

			if(!$V['bbse_popup_border']) $V['bbse_popup_border']='0';
			if(!$V['bbse_popup_border_color']) $V['bbse_popup_border_color']='#ffffff';
			$popup_border=$V['bbse_popup_border']."|||".$V['bbse_popup_border_color'];

			if(!$V['bbse_popup_corner']) $V['bbse_popup_corner']='0';
			$popup_corner=$V['bbse_popup_corner'];

			$popup_contents=str_replace("mce-text","text",$V['bbse_popup_contents']);
			$popup_status=$V['bbse_popup_status'];
			$popup_period=$V['bbse_popup_period'];
			$popup_period_start=$popup_period_end="";

			if($popup_period=='Y'){
				if($V['bbse_popup_period_start']) $popup_period_start=bbse_popup_get_date_to_unix('start',$V['bbse_popup_period_start']);
				if($V['bbse_popup_period_end']) $popup_period_end=bbse_popup_get_date_to_unix('end',$V['bbse_popup_period_end']);
			}

			$popup_period_msg=$V['bbse_popup_period_msg_enable']."|||".$V['bbse_popup_period_msg_language']."|||".$V['bbse_popup_period_msg_type']."|||".$V['bbse_popup_period_msg_position']."|||".$V['bbse_popup_period_msg_color'];

			$popup_user=$V['bbse_popup_user'];
			$popup_page=$V['bbse_popup_page'];
			$popup_browser=$V['bbse_popup_browser'];
			$popup_layout=$V['bbse_popup_layout'];

			if($popup_layout=='Window') $popup_layout_modal='Normal';
			else $popup_layout_modal=$V['bbse_popup_layout_modal'];

			if(!$V['bbse_popup_overlay_color']) $V['bbse_popup_overlay_color']='#000000';
			$popup_overlay=$V['bbse_popup_overlay_color']."|||".$V['bbse_popup_overlay_opacity_radius'];

			if(!$V['bbse_popup_shadow_color']) $V['bbse_popup_shadow_color']='#000000';
			$popup_shadow=$V['bbse_popup_shadow_enabled']."|||".$V['bbse_popup_shadow_horizontal_length']."|||".$V['bbse_popup_shadow_vertical_length']."|||".$V['bbse_popup_shadow_blur_radius']."|||".$V['bbse_popup_shadow_color']."|||".$V['bbse_popup_shadow_opacity_radius'];

			if(!$V['bbse_popup_margin_top']) $V['bbse_popup_margin_top']='0';
			if(!$V['bbse_popup_margin_left']) $V['bbse_popup_margin_left']='0';
			$popup_position=$V['bbse_popup_position']."|||".$V['bbse_popup_margin_top']."|||".$V['bbse_popup_margin_left'];

			if(!$V['bbse_popup_close_button']) $V['bbse_popup_close_button']=$bbsePopup_pro_closeButton['0'];
			if(!$V['bbse_popup_close_button_margin_top']) $V['bbse_popup_close_button_margin_top']='0';
			if(!$V['bbse_popup_close_button_margin_rihgt']) $V['bbse_popup_close_button_margin_rihgt']='0';
			$popup_close_button=$V['bbse_popup_close_button']."|||".$V['bbse_popup_close_button_margin_top']."|||".$V['bbse_popup_close_button_margin_rihgt'];

			$cnt=$wpdb->get_var("SELECT count(*) FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'".$V['tData']."' AND popup_alias='".$popup_alias."'");

			if($cnt>'0'){
				echo "existAlias";
				return;
			}

			if($popup_status=='Trash'){
				$data=$wpdb->get_row("SELECT popup_status FROM ".BBSE_POPUP_DB_TABLE." WHERE idx='".$V['tData']."'");
				$popup_pre_status=$data->popup_status;
			}
			else $popup_pre_status="";

			$result=$wpdb->query("UPDATE ".BBSE_POPUP_DB_TABLE." SET 
					popup_title='".$popup_title."', 
					popup_alias='".$popup_alias."', 
					popup_shortcode='".$popup_shortcode."', 
					popup_size='".$popup_size."', 
					popup_background='".$popup_background."',
					popup_border='".$popup_border."',
					popup_corner='".$popup_corner."',
					popup_contents='".$popup_contents."', 
					popup_status='".$popup_status."', 
					popup_pre_status='".$popup_pre_status."',
					popup_period='".$popup_period."', 
					popup_period_start='".$popup_period_start."', 
					popup_period_end='".$popup_period_end."', 
					popup_period_msg='".$popup_period_msg."',
					popup_user='".$popup_user."', 
					popup_page='".$popup_page."', 
					popup_browser='".$popup_browser."', 
					popup_layout='".$popup_layout."', 
					popup_layout_modal='".$popup_layout_modal."', 
					popup_overlay='".$popup_overlay."',
					popup_shadow='".$popup_shadow."',
					popup_position='".$popup_position."',
					popup_close_button='".$popup_close_button."' 
				WHERE idx='".$V['tData']."'");

			echo "success";
			exit;
		}
		elseif($V['tMode']=='chStatus'){ // Bulk actions && Trash && Duplicate
			if(!$V['tStatus'] || ($V['tStatus']!='Active' && $V['tStatus']!='Inactive' && $V['tStatus']!='Trash' && $V['tStatus']!='restore' && $V['tStatus']!='delete-permanently' && $V['tStatus']!='empty-trash' && $V['tStatus']!='duplicate') || ($V['tStatus']!='empty-trash' && !$V['tData'])){
				echo "fail";
				exit;
			}
			
			if($V['tData']=='empty'){
				$sql="popup_status='Trash'";
			}
			else if($V['tStatus']=='duplicate' && $V['tData']){
				$data=$wpdb->get_row("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE idx='".$V['tData']."'");
				$reg_date=current_time('timestamp');
				$tmpAlias=$data->popup_alias."-".rand(1,1000);
				$cnt=$wpdb->get_var("SELECT count(*) FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>' AND popup_alias='".$tmpAlias."'");

				if($cnt>'0') $tmpAlias=$data->popup_alias."-".rand(10000,1000000);

				$sql="'[".__("Duplicate","BBSe_Popup")."] ".$data->popup_title."', '".$tmpAlias."', '[bbse_popup ".$tmpAlias."]', '".$data->popup_size."', '".$data->popup_background."', '".$data->popup_border."', '".$data->popup_corner."', '".addslashes($data->popup_contents)."', 'Inactive', '".$data->popup_pre_status."', '".$data->popup_period."', '".$data->popup_period_start."', '".$data->popup_period_end."', '".$data->popup_period_msg."', '".$data->popup_user."', '".$data->popup_page."', '".$data->popup_browser."', '".$data->popup_layout."', '".$data->popup_layout_modal."', '".$data->popup_overlay."', '".$data->popup_shadow."', '".$data->popup_position."', '".$data->popup_close_button."'";
			}
			elseif($V['tStatus']=='empty-trash'){
				$sql="popup_status='Trash'";
			}
			else{
				$checkIdx=explode(",",$V['tData']);
				$sql="";
				for($i=0;$i<sizeof($checkIdx);$i++){
					if($checkIdx[$i]>0){
						if($sql) $sql .=" OR ";
						$sql .="idx='".$checkIdx[$i]."'";
					}
				}
			}

			if(!$sql){
				echo "fail";
				exit;
			}

			if($V['tStatus']=='delete-permanently'){
				$sResult = $wpdb->get_results("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE ".$sql);
				$delSql_1=$delSql_2="";

				foreach($sResult as $i=>$sData) {
					if($delSql_1) $delSql_1 .=" OR ";
					$delSql_1 .="idx='".$sData->idx."'";
				}

				if($delSql_1){
					$res = $wpdb->query("DELETE FROM ".BBSE_POPUP_DB_TABLE." WHERE ".$delSql_1);
				}
			}
			else if($V['tStatus']=='duplicate'){
				$res = $wpdb->query("INSERT INTO ".BBSE_POPUP_DB_TABLE." (popup_title, popup_alias, popup_shortcode, popup_size, popup_background, popup_border, popup_corner, popup_contents, popup_status, popup_pre_status, popup_period, popup_period_start, popup_period_end, popup_period_msg, popup_user, popup_page, popup_browser, popup_layout, popup_layout_modal, popup_overlay, popup_shadow, popup_position, popup_close_button) VALUES (".$sql.")");
			}
			elseif($V['tStatus']=='restore'){
				$res = $wpdb->query("UPDATE ".BBSE_POPUP_DB_TABLE." SET popup_status=popup_pre_status, popup_pre_status=''  WHERE ".$sql);
			}
			elseif($V['tStatus']=='Trash'){
				$res = $wpdb->query("UPDATE ".BBSE_POPUP_DB_TABLE." SET popup_pre_status=popup_status, popup_status='".$V['tStatus']."' WHERE ".$sql);
			}
			elseif($V['tStatus']=='delete-permanently' || $V['tStatus']=='empty-trash'){
				$res = $wpdb->query("DELETE FROM ".BBSE_POPUP_DB_TABLE." WHERE ".$sql);
			}
			else{
				$res = $wpdb->query("UPDATE ".BBSE_POPUP_DB_TABLE." SET popup_status='".$V['tStatus']."' WHERE ".$sql);
			}

			echo "success";
			exit;
		}
		else{
			echo "nonData";
			exit;
		}
	}
}
add_action( 'wp_ajax_admin_action_proc', 'bbse_popup_admin_action_proc' );
add_action( 'wp_ajax_nopriv_admin_action_proc', 'bbse_popup_admin_action_proc' );