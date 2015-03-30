<?php
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

				$sql="'[".__("Duplicate","BBSe_Popup")."] ".$data->popup_title."', '".$tmpAlias."', '[bbse_popup ".$tmpAlias."]', '".$data->popup_size."', '".$data->popup_background."', '".$data->popup_border."', '".$data->popup_corner."', '".$data->popup_contents."', 'Inactive', '".$data->popup_pre_status."', '".$data->popup_period."', '".$data->popup_period_start."', '".$data->popup_period_end."', '".$data->popup_period_msg."', '".$data->popup_user."', '".$data->popup_page."', '".$data->popup_browser."', '".$data->popup_layout."', '".$data->popup_layout_modal."', '".$data->popup_overlay."', '".$data->popup_shadow."', '".$data->popup_position."', '".$data->popup_close_button."'";
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