<?php
/**
 * Plugin Name: BBS e-Popup
 * Plugin URI: http://www.onsetheme.com/plugin-list
 * Description: BBS e-Popup for WordPress!
 * Version: 1.0.0
 * Author: BBS e-Theme
 * Author URI: http://www.bbsetheme.com
 * License: GNU General Public License, v2 or later
 * License URI: http://www.gnu.org/licenses/gpl.html

본 플러그인은 워드프레스와 동일한 GPL 라이센스의 플러그인입니다. 임의대로 수정,삭제 후 이용하셔도 됩니다.
단, 재배포 시 GPL 라이센스로 재배포 되어야 하며, 원 제작자의 표기를 해주시기 바랍니다.
‘BBS e-Popup' WordPress Plugin, Copyright 2014 BBS e-Theme(http://www.bbsetheme.com)
‘BBS e-Popup' is distributed under the terms of the GNU GPL
 */

define("BBSE_POPUP_VER", "v1.0.0");
define("BBSE_POPUP_SITE_URL", home_url());
define("BBSE_POPUP_CONTENT_URL", content_url());
define("BBSE_POPUP_PLUGIN_CURRENT_PATH", __FILE__);
define("BBSE_POPUP_PLUGIN_ABS_PATH", plugin_dir_path(__FILE__));
define("BBSE_POPUP_PLUGIN_WEB_URL", plugins_url()."/BBSe_Popup/");
define("BBSE_POPUP_DB_TABLE","wp_bbse_popup");
define("BBSE_POPUP_LANGUAGE", get_bloginfo('language'));

require_once(BBSE_POPUP_PLUGIN_ABS_PATH."lib/config.php");						    	// config
require_once(BBSE_POPUP_PLUGIN_ABS_PATH."lib/mobile-detect.class.php");         // mobile detecting 
require_once(BBSE_POPUP_PLUGIN_ABS_PATH."lib/function.php");                         // function
require_once(BBSE_POPUP_PLUGIN_ABS_PATH."lib/function-proc.php"); // execute function

load_plugin_textdomain( 'BBSe_Popup', false, dirname(plugin_basename( __FILE__ )).'/languages/');

if(is_admin()){
	// TinyMCE
	add_action( 'admin_init', 'bbse_popup_shortcode_tinymce'); // add TinyMCE Buttons
}

// [Check] Active plugins
if ( ! function_exists( 'bbse_popup_plugin_active_check' ) ){
	function bbse_popup_plugin_active_check($plugin_name) {
		$required_plugin = $plugin_name.'/'.$plugin_name.'.php';
		$plugins = get_option('active_plugins');
		$bbse_popup_active = false;
		if ( in_array( $required_plugin , $plugins ) ) {
			$bbse_popup_active = true;
		}
		return $bbse_popup_active;
	}
}

// session start
add_action('init', 'bbse_popup_session_start', 1);
if(!function_exists('bbse_popup_session_start')){
	function bbse_popup_session_start(){
		global $currentSessionID;

		if(!session_id()){
			session_start();
		}
		$currentSessionID = session_id();
	}
}

// tinyMCE 비주얼을 기본 선택으로 사용
add_filter( 'wp_default_editor', create_function('', 'return "tinymce";') );