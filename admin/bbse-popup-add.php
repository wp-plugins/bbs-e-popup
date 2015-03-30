<?php
$tMode=($_REQUEST['tMode'])?$_REQUEST['tMode']:"insert";

if($tMode=='update'){
	$tData=$_REQUEST['tData'];
	$data=$wpdb->get_row("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE idx='".$tData."'");

	if(!$tData || $data->idx<='0') {
		echo "<script type='text/javascript'>location.href='admin.php?page=bbse_Popup';</script>";
		exit;
	}

	$popupBorder=explode("|||",$data->popup_border);
	$popupSize=explode("|||",$data->popup_size);


	$periodStart=$periodEnd="";
	if($data->popup_period=='Y'){
		if($data->popup_period_start) $periodStart=bbse_popup_get_unix_to_date($data->popup_period_start);
		if($data->popup_period_end) $periodEnd=bbse_popup_get_unix_to_date($data->popup_period_end);
	}

	$popupPeriodMsg=explode("|||",$data->popup_period_msg);
	$popupPosition=explode("|||",$data->popup_position);
	$popupShadow=explode("|||",$data->popup_shadow);
	$popupOverlay=explode("|||",$data->popup_overlay);

	$ppLanguage=$popupPeriodMsg['1'];

	$popupCloseButton=explode("|||",$data->popup_close_button);
}
else $ppLanguage=(BBSE_POPUP_LANGUAGE && in_array(BBSE_POPUP_LANGUAGE,$bbse_popup_btmMsg_language))?BBSE_POPUP_LANGUAGE:"en-US";

$templateList=Array(
					"event"=>__('Event','BBSe_Popup'),
					"play"=>__('Play','BBSe_Popup'),
					"video"=>__('Video','BBSe_Popup'),
					"point"=>__('Point','BBSe_Popup'),
					"christmas"=>__('Christmas','BBSe_Popup'),
					"grid"=>__('Grid','BBSe_Popup'),
					"simple"=>__('Simple','BBSe_Popup'),
					"macaron"=>__('Macaron','BBSe_Popup'),
					"happynewyear"=>__('Happy New Year','BBSe_Popup'),
					"speech"=>__('Speech','BBSe_Popup'),
					"daisy"=>__('Daisy','BBSe_Popup'),
					"bubble"=>__('Bubble','BBSe_Popup'),
					"wisdom"=>__('Wisdom','BBSe_Popup'),
					"view"=>__('View','BBSe_Popup'),
					"basic"=>__('Basic','BBSe_Popup')
					);
?>

<div class="wrap">
	<div>
		<iframe id="bbsePopupIframe" class="banner_iframe" scrolling="no"></iframe>
	</div>
	<form name="popupFrm" id="popupFrm">
	<input type="hidden" name="action" id="action" value="admin_action_proc" />
	<input type="hidden" name="tMode" id="tMode" value="" />
	<input type="hidden" name="tData" id="tData" value="<?php echo ($tMode=='update' && $tData)?$tData:"";?>" />
	<input type="hidden" name="bbse_popup_browser" id="bbse_popup_browser" value="PC" />
	<input type="hidden" name="bbse_popup_layout" id="bbse_popup_layout" value="Layer" />

	<div style="margin-bottom:30px;">
		<h2>
			<?php echo ($tMode=='insert')?__('Add Popup','BBSe_Popup'):__('Update Popup','BBSe_Popup');?>
			<span style="float:right;"><button type="button" onClick="go_previe('<?php echo (BBSE_POPUP_LANGUAGE=='ko-KR')?"http://manual.onsetheme.com/bbs-e-popup/":"http://manual.onsetheme.com/bbs-e-popup_en/";?>');" class="button-bbse blue" style="width:120px;float:right;"> <?php echo __('Manual','BBSe_Popup');?> </button></span>

			<?php if($tMode=='update' && $tData>'0'){?><span style="float:right;margin-right:50px;"><button type="button" onClick="go_previe('<?php echo esc_url( home_url( '/' ) ); ?>?bbse_pid=<?php echo $data->idx;?>&preview=true');" class="button-bbse red" style="width:120px;"> <?php echo __('Preview','BBSe_Popup');?> </button></span><?php }?>
		</h2>
		<hr>
	</div>
	<div class="column-first">
		<table class="dataTbls overWhite collapse">
			<colgroup><col width="24%"><col width=""></colgroup>
			<tr>
				<th colspan="2" class="main_title" data-icon="&#xe024;"><span class="set-title-general" onClick="toggle_contents('general');"><?php echo __("Default settings","BBSe_Popup");?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_up_16.png" id="generalPulldownIcon" class="pulldown-icon" onClick="toggle_contents('general');" /></th>
			</tr>

			<tr class="generalRow">
				<th><span id="sub-title-title-1" class="cursor_default" original-title="<?php echo __('Enter popup title. (not shown on screen)','BBSe_Popup');?>"><?php echo __('Title','BBSe_Popup');?></span></th>
				<td><input type="text" name="bbse_popup_title" id="bbse_popup_title" value="<?php echo $data->popup_title;?>" style="width:80%;" /></td>
			</tr>
			<tr class="generalRow">
				<th><span id="sub-title-alias-1" class="cursor_default" original-title="<?php echo __('Set popup alias.','BBSe_Popup');?>"><?php echo __('Alias','BBSe_Popup');?></span></th>
				<td><input type="text" name="bbse_popup_alias" id="bbse_popup_alias" value="<?php echo $data->popup_alias;?>" style="width:20%;" /></td>
			</tr>
			<tr class="generalRow">
				<th><span id="sub-title-shortcode-1" class="cursor_default" original-title="<?php echo __('Set popup short code. (Auto setting)','BBSe_Popup');?>"><?php echo __('Shortcode','BBSe_Popup');?></span></th>
				<td><input type="text" name="bbse_popup_shortcode" id="bbse_popup_shortcode" value="<?php echo $data->popup_shortcode;?>" placeholder="<?php echo __(' --- Empty alias --- ','BBSe_Popup');?>" style="width:30%;" readonly /></td>
			</tr>
			<tr class="generalRow">
				<th><span id="sub-title-size-1" class="cursor_default" original-title="<?php echo __('Set popup size.','BBSe_Popup');?>"><?php echo __('Screen Size','BBSe_Popup');?></span></th>
				<td><?php echo __('Width','BBSe_Popup');?> <input type="text" name="bbse_popup_size_width" id="bbse_popup_size_width" value="<?php echo $popupSize['0'];?>" style="width:50px;" />px  X <?php echo __('Height','BBSe_Popup');?> <input type="text" name="bbse_popup_size_height" id="bbse_popup_size_height" value="<?php echo $popupSize['1'];?>" style="width:50px;" />px</td>
			</tr>
			<tr class="generalRow">
				<th><span id="sub-title-background-1" class="cursor_default" original-title="<?php echo __('Set the popup background color.','BBSe_Popup');?>"><?php echo __('Background Color','BBSe_Popup');?></span></th>
				<td><input type="checkbox" name="bbse_popup_background_check" id="bbse_popup_background_check" value="Y" <?php echo ($tMode=='insert' || $data->popup_background)?"checked='checked'":"";?>> <?php echo __('Enable','BBSe_Popup');?><span id="bbse_popup_background_color_pick" style="<?php echo ($tMode=='insert' || $data->popup_background)?"":"display:none;";?>margin-left:40px;"><input type="text" name="bbse_popup_background" id="bbse_popup_background" class="colpick" style='width:80px;height:20px;text-align:right;' value="<?php echo $data->popup_background;?>" /></span></td>
			</tr>
			<tr class="generalRow">
				<th><span id="sub-title-template-1" class="cursor_default" original-title="<?php echo __('Set the popup template.','BBSe_Popup');?>"><?php echo __('Template','BBSe_Popup');?></span></th>
				<td>
					<select name="bbse_popup_template" id="bbse_popup_template" onChange="change_template(this.value);">
					<option value="" class="tplList"><?php echo __('Disable','BBSe_Popup');?></option>
					<?php foreach($templateList as $key => $val) {
						echo "<option value=\"".$key."\" class=\"tplList\">".$val."</option>";
					}
					?>
					</select>
					<span id="template-apply" style="display:none;margin-left:40px;"><button type="button" class="button-small blue" onclick="apply_template();" style="width:100px;height:25px;"> <?php echo __("Apply","BBSe_Popup");?> </button></span>
					<span id="template-apply-img" class="template_apply_img"></span>
				</td>
			</tr>
		</table>

		<div class="clearfix"></div>

		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe0c6;"><span class="set-title-general" onClick="toggle_contents('contents');"><?php echo __("Popup Contents","BBSe_Popup");?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_up_16.png" id="contentsPulldownIcon" class="pulldown-icon" onClick="toggle_contents('contents');" /></th>
			</tr>
			<tr>
				<td class="contentsRow">
					<div style="margin:10px 0;min-height:100px;">
						<?php 
						wp_editor(html_entity_decode($data->popup_contents), "bbse_popup_contents", $settings=array('textarea_name'=>'bbse_popup_contents', 'textarea_rows'=>'15')); 
						?> 
					</div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>

		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width="24%"><col width=""></colgroup>
			<tr>
				<th colspan="2" class="main_title" data-icon="&#xe12b;"><span class="set-title-general" onClick="toggle_contents('animation');"><?php echo __('Popup Animation','BBSe_Popup');?></span>
				
				<img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_down_16.png" id="animationPulldownIcon" class="pulldown-icon" onClick="toggle_contents('animation');" />
				<span class="animation-free-only-red">* <?php echo __('Can only use BBS e-Popup Pro','BBSe_Popup');?></span>				
			</th>
			</tr>
			<tr class="animationRow hide">
				<th><span id="sub-title-animation-1" class="cursor_default" original-title="<?php echo __('Set effects when popup appears.','BBSe_Popup');?>"><?php echo __('Pop-up Entrances','BBSe_Popup');?></span></th>
				<td>
					<?php
					if($data->popup_animation_in) $curAnmIn=explode("-", $data->popup_animation_in);
					else $curAnmIn['0']=$curAnmIn['1']="";
					?>
					 <select name="bbse_popup_animation_in" id="bbse_popup_animation_in" onChange="change_animation('in');" style="width:140px;">
						 <option value='' <?php echo (!$curAnmIn['0'])?"selected='selected'":"";?>>NONE</option>
						<?php
						for($i=0;$i<sizeof($anmIn['main']);$i++){
							if($curAnmIn['0']==$anmIn['main'][$i]) $anmMainSelected="selected='selected'";
							else $anmMainSelected="";

							echo "<option value='".$anmIn['main'][$i]."' ".$anmMainSelected.">".strtoupper($anmIn['main'][$i])." IN</option>";
						}
						?>
					</select>
					 <span style="margin-left:40px;">
							<?php
							for($i=0;$i<sizeof($anmIn['main']);$i++){
								if(sizeof($anmIn[$anmIn['main'][$i]])>'0'){
									if($curAnmIn['0']==$anmIn['main'][$i]) $anmSubDisplay="inline";
									else $anmSubDisplay="none";

									echo "<select name='bbse_popup_animation_in_".$anmIn['main'][$i]."' id='bbse_popup_animation_in_".$anmIn['main'][$i]."' class='aniSub_in_select' style='display:".$anmSubDisplay.";width:140px;'>";
									for($j=0;$j<sizeof($anmIn[$anmIn['main'][$i]]);$j++){
										if($anmIn[$anmIn['main'][$i]][$j]=='In') $viewSub="Default";
										else $viewSub=str_replace("In","",$anmIn[$anmIn['main'][$i]][$j]);

										if($curAnmIn['0']==$anmIn['main'][$i] && $curAnmIn['1']==$anmIn[$anmIn['main'][$i]][$j]) $anmSubSelected="selected='selected'";
										else $anmSubSelected="";

										echo "<option value='".$anmIn[$anmIn['main'][$i]][$j]."' ".$anmSubSelected.">".strtoupper($viewSub)."</option>";
									}
									echo "</select>";
								}
							}
							?>
					</span>
					<span class="animation-free-only-gray"><?php echo __('Can only use BBS e-Popup Pro','BBSe_Popup');?></span>
				</td>
			</tr>
			<tr class="animationRow hide">
				<th><span id="sub-title-animation-2" class="cursor_default" original-title="<?php echo __('Set effects when popup disappears.','BBSe_Popup');?>"><?php echo __('Pop-up Exits','BBSe_Popup');?></span></th>
				<td>
					<?php
					if($data->popup_animation_out) $curAnmOut=explode("-", $data->popup_animation_out);
					else $curAnmOut['0']=$curAnmOut['1']="";
					?>

					 <select name="bbse_popup_animation_out" id="bbse_popup_animation_out" onChange="change_animation('out');" style="width:140px;">
						 <option value='' <?php echo (!$curAnmOut['0'])?"selected='selected'":"";?>>NONE</option>
						<?php
						for($i=0;$i<sizeof($anmOut['main']);$i++){
							if($curAnmOut['0']==$anmOut['main'][$i]) $anmMainSelected="selected='selected'";
							else $anmMainSelected="";

							echo "<option value='".$anmOut['main'][$i]."' ".$anmMainSelected.">".strtoupper($anmOut['main'][$i])." OUT</option>";
						}
						?>
					</select>
					 <span style="margin-left:40px;">
							<?php
							for($i=0;$i<sizeof($anmOut['main']);$i++){
								if(sizeof($anmOut[$anmOut['main'][$i]])>'0'){
									if($curAnmOut['0']==$anmOut['main'][$i]) $anmSubDisplay="inline";
									else $anmSubDisplay="none";

									echo "<select name='bbse_popup_animation_out_".$anmOut['main'][$i]."' id='bbse_popup_animation_out_".$anmOut['main'][$i]."' class='aniSub_out_select' style='display:".$anmSubDisplay.";width:140px;'>";
									for($j=0;$j<sizeof($anmOut[$anmOut['main'][$i]]);$j++){
										if($anmOut[$anmOut['main'][$i]][$j]=='Out') $viewSub="Default";
										else $viewSub=str_replace("Out","",$anmOut[$anmOut['main'][$i]][$j]);

										if($curAnmOut['0']==$anmOut['main'][$i] && $curAnmOut['1']==$anmOut[$anmOut['main'][$i]][$j]) $anmSubSelected="selected='selected'";
										else $anmSubSelected="";

										echo "<option value='".$anmOut[$anmOut['main'][$i]][$j]."' ".$anmSubSelected.">".strtoupper($viewSub)."</option>";
									}
									echo "</select>";
								}
							}
							?>
					</span>
					<span class="animation-free-only-gray"><?php echo __('Can only use BBS e-Popup Pro','BBSe_Popup');?></span>
				</td>
			</tr>
		</table>

		<div class="clearfix"></div>

		<div style="margin:40px 0;text-align:center;">
			<?php if($tMode=='update' && $tData>'0'){?><button type="button" onClick="go_previe('<?php echo esc_url( home_url( '/' ) ); ?>?bbse_pid=<?php echo $data->idx;?>&preview=true');" class="button-bbse red" style="width:120px;float:left;"> <?php echo __('Preview','BBSe_Popup');?> </button><?php }?>
			<button type="button" class="button-bbse blue" onClick="chk_popup_submit('<?php echo $tMode;?>');" style="width:20%;"> <?php echo ($tMode=='update')?__('Update Popup','BBSe_Popup'):__('Add New Popup','BBSe_Popup');?> </button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="button-bbse" onClick="go_popup_page('list','');" style="width:20%;"> <?php echo __('Popup List','BBSe_Popup');?> </button>
		</div>
	</div>

	<div class="column-second">
		<table class="dataTbls overWhite collapse">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe0fa;"><span class="set-title-general" onClick="toggle_contents('active');"><?php echo __('Pop-up status','BBSe_Popup');?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_up_16.png" id="activePulldownIcon" class="pulldown-icon" onClick="toggle_contents('active');" /></th>
			</tr>
			<tr class="activeRow">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;margin:10px 0;">
						<colgroup><col width="24%"><col width=""></colgroup>
						<tr>
							<td class="noneLine"><span id="sub-title-active-1" class="cursor_default" original-title="<?php echo __('Set popup status.','BBSe_Popup');?>"><?php echo __('Pop-up status','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<select name="bbse_popup_status" id="bbse_popup_status" style="width:150px;height:29px;line-height:29px;">
									<option value="Active" <?php echo (!$data->popup_status || $data->popup_status=='Active')?"selected='selected'":"";?>><?php echo __('Active','BBSe_Popup');?></option>
									<option value="Inactive" <?php echo ($data->popup_status=='Inactive')?"selected='selected'":"";?>><?php echo __('Inactive','BBSe_Popup');?></option>
									<option value="Trash" <?php echo ($data->popup_status=='Trash')?"selected='selected'":"";?>><?php echo __('Trash','BBSe_Popup');?></option>
								</select>
							</td>
						</tr>
					</table>
					<div style="margin-bottom:10px;text-align:center;">
						<button type="button" class="button-bbse blue" onClick="chk_popup_submit('<?php echo $tMode;?>');" style="width:30%;"> <?php echo ($tMode=='update')?__('Update Popup','BBSe_Popup'):__('Add New Popup','BBSe_Popup');?> </button>&nbsp;&nbsp;<button type="button" class="button-bbse" onClick="go_popup_page('list','');" style="width:30%;"> <?php echo __('Popup List','BBSe_Popup');?> </button>
					</div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>

		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe0d2;"><span class="set-title-general" onClick="toggle_contents('period');"><?php echo __('Period','BBSe_Popup');?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_down_16.png" id="periodPulldownIcon" class="pulldown-icon" onClick="toggle_contents('period');" /></th>
			</tr>
			<tr class="periodRow hide">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;margin:10px 0;">
						<colgroup><col width="24%"><col width=""></colgroup>
						<tr>
							<td class="noneLine"><span id="sub-title-period-1" class="cursor_default" original-title="<?php echo __('Popup exposed during set period.','BBSe_Popup');?>"><?php echo __('Period','BBSe_Popup');?></span></td>
							<td class="noneLine">
							<?php
								$use=($data->popup_period=='Y')?'yes':'no';
								$show=($data->popup_period=='Y')?'':'style="display:none"';
							?>
								<span class="useCheck" data-use="<?php echo $use?>" data-container="bbse_popup_period" data-view="period-input" data-cnt="1" style="cursor:pointer"><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL;?>images/switch_<?php echo $use?>.png" style="margin-bottom:-10px;" /></span>
								 <input type="hidden" name="bbse_popup_period" id="bbse_popup_period" value='<?php echo ($data->popup_period)?$data->popup_period:"N";?>'  />
							</td>
						</tr>
						<tr id="period-input-1" style="display:<?php echo ($data->popup_period=='Y')?"table-row":"none";?>;">
							<td class="noneLine"></td>
							<td class="noneLine">
								<input type="text" name="bbse_popup_period_start" id="bbse_popup_period_start" class="datepicker" value="<?php echo $periodStart;?>" style="height: 28px;margin: 0 4px 0 0;width:100px;cursor:pointer;background:#ffffff;text-align:center;" readonly />&nbsp;<img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/icon-calendar.png" onClick="jQuery('#bbse_popup_period_start').focus();" style="width:20px;height:20px;cursor:pointer;" align="absmiddle" />&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;<input type="text" name="bbse_popup_period_end" id="bbse_popup_period_end" value="<?php echo $periodEnd;?>" class="datepicker" style="width:100px;cursor:pointer;background:#ffffff;text-align:center;" readonly />&nbsp;<img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/icon-calendar.png" onClick="jQuery('#bbse_popup_period_end').focus();" style="width:20px;height:20px;cursor:pointer;" align="absmiddle" />
							</td>
						</tr>
						<tr><td class="dotLine" colspan="2" style="height:1px;"></td></tr>
						<tr>
							<td class="noneLine"><span id="sub-title-period-2" class="cursor_default" original-title="<?php echo __('Set message displayed by popup period.','BBSe_Popup');?>"><?php echo __('Message','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<table class="dataTbls overWhite collapse noTopline" style="width:100%;">
									<colgroup><col width="24%"><col width=""></colgroup>
									<tr>
										<td class="noneLine" style="line-height:15px;"><?php echo __('Enable','BBSe_Popup');?></td>
										<td class="noneLine">
											  <?php
												$use=($popupPeriodMsg['0']=='Y')?'yes':'no';
												$show=($popupPeriodMsg['0']=='Y')?'':'style="display:none"';
											  ?>
											<span class="useCheck" data-use="<?php echo $use?>" data-container="bbse_popup_period_msg_enable" data-view="period-msg" data-cnt="4" style="cursor:pointer"><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL;?>images/switch_<?php echo $use?>.png" style="margin-bottom:-10px;" /></span>
											 <input type="hidden" name="bbse_popup_period_msg_enable" id="bbse_popup_period_msg_enable" value='<?php echo ($popupPeriodMsg['0'])?$popupPeriodMsg['0']:"N";?>'  />
										</td>
									</tr>
									<tr id="period-msg-1" style="display:<?php echo ($popupPeriodMsg['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Type','BBSe_Popup');?></td>
										<td class="noneLine">
											<select name='bbse_popup_period_msg_type' id='bbse_popup_period_msg_type' style="width:275px;height:29px;line-height:29px;">
												<option value="Today" <?php echo (!$popupPeriodMsg['1'] || $popupPeriodMsg['1']=='Today')?"selected='selected'":"";?>><?php echo __("Don't see this window again today.",'BBSe_Popup');?></option>
												<option value="Minute" <?php echo ($popupPeriodMsg['1']=='Minute')?"selected='selected'":"";?>><?php echo __("This window will not show for 30 minutes.",'BBSe_Popup');?></option>
											</select>
										</td>
									</tr>
									<tr id="period-msg-2" style="display:<?php echo ($popupPeriodMsg['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Language','BBSe_Popup');?></td>
										<td class="noneLine">
											<select name='bbse_popup_period_msg_language' id='bbse_popup_period_msg_language' style="width:275px;height:29px;line-height:29px;">
												<option value="en-US" <?php echo ($ppLanguage=='en-US')?"selected='selected'":"";?>>English (United States)</option>
												<option value="ko-KR" <?php echo ($ppLanguage=='ko-KR')?"selected='selected'":"";?>>한국어</option>
												<option value="zh-CN" <?php echo ($ppLanguage=='zh-CN')?"selected='selected'":"";?>>简体中文</option>
												<option value="ja-JP" <?php echo ($ppLanguage=='ja-JP')?"selected='selected'":"";?>>日本語</option>
											</select>
										</td>
									</tr>
									<tr id="period-msg-3" style="display:<?php echo ($popupPeriodMsg['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Position','BBSe_Popup');?></td>
										<td class="noneLine">
											<select name='bbse_popup_period_msg_position' id='bbse_popup_period_msg_position' style="width:150px;height:29px;line-height:29px;">
												<option value="Left" <?php echo (!$popupPeriodMsg['3'] || $popupPeriodMsg['3']=='Left')?"selected='selected'":"";?>><?php echo __('Left','BBSe_Popup');?></option>
												<option value="Center" <?php echo ($popupPeriodMsg['3']=='Center')?"selected='selected'":"";?>><?php echo __('Center','BBSe_Popup');?></option>
												<option value="Right" <?php echo ($popupPeriodMsg['3']=='Right')?"selected='selected'":"";?>><?php echo __('Right','BBSe_Popup');?></option>
											</select>
										</td>
									</tr>
									<tr id="period-msg-4" style="display:<?php echo ($popupPeriodMsg['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Text Color','BBSe_Popup');?></td>
										<td class="noneLine">
											<span style="margin-left:5px;"><input type="text" name="bbse_popup_period_msg_color" id="bbse_popup_period_msg_color" class="colpick" style='width:80px;height:20px;text-align:right;' value="<?php echo ($popupPeriodMsg['4'])?$popupPeriodMsg['4']:"#ffffff";?>" /></span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>

		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe0d2;"><span class="set-title-general" onClick="toggle_contents('user');"><?php echo __('User status','BBSe_Popup');?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_down_16.png" id="userPulldownIcon" class="pulldown-icon" onClick="toggle_contents('user');" /></th>
			</tr>
			<tr class="userRow hide">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;margin:10px 0;">
						<colgroup><col width="24%"><col width=""></colgroup>
						<tr>
							<td class="noneLine"><span id="sub-title-user-1" class="cursor_default" original-title="<?php echo __('Set popup by user status (login/logout).','BBSe_Popup');?>"><?php echo __('User status','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<select name="bbse_popup_user" id="bbse_popup_user" style="width:150px;height:29px;line-height:29px;">
									<option value="All" <?php echo (!$data->popup_user || $data->popup_user=='All')?"selected='selected'":"";?>><?php echo __('All Users','BBSe_Popup');?></option>
									<option value="LoggedIn" <?php echo ($data->popup_user=='LoggedIn')?"selected='selected'":"";?>><?php echo __('Loged in Users','BBSe_Popup');?></option>
									<option value="NotLoggedIn" <?php echo ($data->popup_user=='NotLoggedIn')?"selected='selected'":"";?>><?php echo __('Not logged in Users','BBSe_Popup');?></option>
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>

		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe0c1;"><span class="set-title-general" onClick="toggle_contents('layout');"><?php echo __('Layout','BBSe_Popup');?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_down_16.png" id="layoutPulldownIcon" class="pulldown-icon" onClick="toggle_contents('layout');" /></th>
			</tr>
			<tr class="layoutRow hide">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;margin:20px 0;">
						<colgroup><col width="24%"><col width=""></colgroup>
						<tr>
							<td class="noneLine"><span id="sub-title-border-1" class="cursor_default" original-title="<?php echo __('Set popup border.','BBSe_Popup');?>"><?php echo __('Border','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<input type="range" name='bbse_popup_border' id='bbse_popup_border' class="sliderPopupBorder" min="0" max="10" step="1" value='<?php echo ($popupBorder['0'])?$popupBorder['0']:'0'?>' />
								<span class="sliderPopupBorderValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
								  <?php echo ($popupBorder['0'])?$popupBorder['0']:'0'?>px
								</span>
							</td>
						</tr>
						<tr>
							<td class="noneLine"><span id="sub-title-border-2" class="cursor_default" original-title="<?php echo __('Set popup border color.','BBSe_Popup');?>"><?php echo __('Border Color','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<span style="margin-left:5px;"><input type="text" name="bbse_popup_border_color" id="bbse_popup_border_color" class="colpick" style='width:80px;height:20px;text-align:right;' value="<?php echo ($popupBorder['1'])?$popupBorder['1']:"";?>" /></span>
							</td>
						</tr>
						<tr>
							<td class="dotLine"><span id="sub-title-corner-1" class="cursor_default" original-title="<?php echo __('Set popup border radius.','BBSe_Popup');?>"><?php echo __('Radius','BBSe_Popup');?></span></td>
							<td class="dotLine">
								<input type="range" name='bbse_popup_corner' id='bbse_popup_corner' class="sliderPopupConer" min="0" max="30" step="1" value='<?php echo ($data->popup_corner>'0')?$data->popup_corner:'0'?>' />
								<span class="sliderPopupConerValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
								  <?php echo ($data->popup_corner>'0')?$data->popup_corner:'0'?>px
								</span>
							</td>
						</tr>
						<tr>
							<td class="noneLine"><span id="sub-title-page-1" class="cursor_default" original-title="<?php echo __('Set page to display popup.','BBSe_Popup');?>"><?php echo __('View Page','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<select name="bbse_popup_page" id="bbse_popup_page" style="width:150px;height:29px;line-height:29px;">
									<option value="All" <?php echo (!$data->popup_page || $data->popup_page=='All')?"selected='selected'":"";?>><?php echo __('All Pages','BBSe_Popup');?></option>
									<option value="Fronty" <?php echo ($data->popup_page=='Fronty')?"selected='selected'":"";?>><?php echo __('Front page only','BBSe_Popup');?></option>
									<option value="Pages" <?php echo ($data->popup_page=='Pages')?"selected='selected'":"";?>><?php echo __('Pages only','BBSe_Popup');?></option>
									<option value="Posts" <?php echo ($data->popup_page=='Posts')?"selected='selected'":"";?>><?php echo __('Posts only','BBSe_Popup');?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="noneLine"><span id="sub-title-layout-1" class="cursor_default" original-title="<?php echo __('Set layout to show popup.','BBSe_Popup');?>"><?php echo __('Layout','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<span id='layout_modal'>
									<select name="bbse_popup_layout_modal" id="bbse_popup_layout_modal" onChange="change_modal();" style="width:150px;height:29px;line-height:29px;">
										<option value="Normal" <?php echo (!$data->popup_layout_modal || $data->popup_layout_modal=='Normal')?"selected='selected'":"";?>><?php echo __('Normal','BBSe_Popup');?></option>
										<option value="Modal" <?php echo ($data->popup_layout_modal=='Modal')?"selected='selected'":"";?>><?php echo __('Modal','BBSe_Popup');?></option>
									</select>
								</span>
							</td>
						</tr>
						<tr><td class="dotLine" colspan="2" style="height:1px;"></td></tr>
						<tr id="overlay-option" style="display:<?php echo ($data->popup_layout_modal=='Modal')?"table-row":"none";?>;">
							<td class="noneLine"><span id="sub-title-overlay-1" class="cursor_default" original-title="<?php echo __('Set modal overlay.','BBSe_Popup');?>"><?php echo __('Modal Overlay','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<table class="dataTbls overWhite collapse noTopline" style="width:100%;">
									<colgroup><col width="24%"><col width=""></colgroup>
									<tr>
										<td class="noneLine" style="line-height:15px;"><?php echo __('Overlay Color','BBSe_Popup');?></td>
										<td class="noneLine">
											<span style="margin-left:5px;"><input type="text" name="bbse_popup_overlay_color" id="bbse_popup_overlay_color" class="colpick" style='width:80px;height:20px;text-align:right;' value="<?php echo ($popupOverlay['0'])?$popupOverlay['0']:"#000000";?>" /></span>
										</td>
									</tr>
									<tr>
										<td class="noneLine" style="line-height:15px;"><?php echo __('Opacity','BBSe_Popup');?></td>
										<td class="noneLine">
											<input type="range" name='bbse_popup_overlay_opacity_radius' id='bbse_popup_overlay_opacity_radius' class="sliderOverlayOpacityRadius" min="0.1" max="1" step="0.1" value='<?php echo ($popupOverlay['1'])?$popupOverlay['1']:'0.5'?>' />
											<span class="sliderOverlayOpacityRadiusValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
											  <?php echo ($popupOverlay['1'])?($popupOverlay['1']*100)."%":'50%'?>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr id="overlay-line" style="display:<?php echo ($data->popup_layout_modal=='Modal')?"table-row":"none";?>;"><td class="dotLine" colspan="2" style="height:1px;padding:0;"></td></tr>
						<tr>
							<td class="noneLine"><span id="sub-title-shadow-1" class="cursor_default" original-title="<?php echo __('Set popup shadow.','BBSe_Popup');?>"><?php echo __('Shadow','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<table class="dataTbls overWhite collapse noTopline" style="width:100%;">
									<colgroup><col width="24%"><col width=""></colgroup>
									<tr>
										<td class="noneLine" style="line-height:15px;"><?php echo __('Enable','BBSe_Popup');?></td>
										<td class="noneLine">
											  <?php
												$use=($popupShadow['0']=='Y')?'yes':'no';
												$show=($popupShadow['0']=='Y')?'':'style="display:none"';
											  ?>
											<span class="useCheck" data-use="<?php echo $use?>" data-container="bbse_popup_shadow_enabled" data-view="shadow-option" data-cnt="5" style="cursor:pointer"><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL;?>images/switch_<?php echo $use?>.png" id="shadow_enable_button" style="margin-bottom:-10px;" /></span>
											 <input type="hidden" name="bbse_popup_shadow_enabled" id="bbse_popup_shadow_enabled" value='<?php echo ($popupShadow['0'])?$popupShadow['0']:"N";?>'  />
										</td>
									</tr>
									<tr id="shadow-option-1" style="display:<?php echo ($popupShadow['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Horizontal Length','BBSe_Popup');?></td>
										<td class="noneLine">
											<input type="range" name='bbse_popup_shadow_horizontal_length' id='bbse_popup_shadow_horizontal_length' class="sliderHorizontalLength" min="-10" max="10" step="1" value='<?php echo ($popupShadow['1'] || $popupShadow['1']=='0')?$popupShadow['1']:'0'?>' />
											<span class="sliderHorizontalLengthValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
											  <?php echo ($popupShadow['1'] || $popupShadow['1']=='0')?$popupShadow['1']:'0'?>px
											</span>
										</td>
									</tr>
									<tr id="shadow-option-2" style="display:<?php echo ($popupShadow['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Vertical Length','BBSe_Popup');?></td>
										<td class="noneLine">
											<input type="range" name='bbse_popup_shadow_vertical_length' id='bbse_popup_shadow_vertical_length' class="sliderVerticalLength" min="-30" max="30" step="1" value='<?php echo ($popupShadow['2'] || $popupShadow['2']=='0')?$popupShadow['2']:'10'?>' />
											<span class="sliderVerticalLengthValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
											  <?php echo ($popupShadow['2'] || $popupShadow['2']=='0')?$popupShadow['2']:'10'?>px
											</span>
										</td>
									</tr>
									<tr id="shadow-option-3" style="display:<?php echo ($popupShadow['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Blur Radius','BBSe_Popup');?></td>
										<td class="noneLine">
											<input type="range" name='bbse_popup_shadow_blur_radius' id='bbse_popup_shadow_blur_radius' class="sliderBlurRadius" min="-50" max="50" step="1" value='<?php echo ($popupShadow['3'] || $popupShadow['3']=='0')?$popupShadow['3']:'25'?>' />
											<span class="sliderBlurRadiusValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
											  <?php echo ($popupShadow['3'] || $popupShadow['3']=='0')?$popupShadow['3']:'25'?>px
											</span>
										</td>
									</tr>
									<tr id="shadow-option-4" style="display:<?php echo ($popupShadow['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Shadow Color','BBSe_Popup');?></td>
										<td class="noneLine">
											<span style="margin-left:5px;"><input type="text" name="bbse_popup_shadow_color" id="bbse_popup_shadow_color" class="colpick" style='width:80px;height:20px;text-align:right;' value="<?php echo ($popupShadow['4'])?$popupShadow['4']:"#000000";?>" /></span>
										</td>
									</tr>
									<tr id="shadow-option-5" style="display:<?php echo ($popupShadow['0']=='Y')?"table-row":"none";?>;">
										<td class="noneLine" style="line-height:15px;"><?php echo __('Opacity','BBSe_Popup');?></td>
										<td class="noneLine">
											<input type="range" name='bbse_popup_shadow_opacity_radius' id='bbse_popup_shadow_opacity_radius' class="sliderOpacityRadius" min="0.1" max="1" step="0.1" value='<?php echo ($popupShadow['5'])?$popupShadow['5']:'0.5'?>' />
											<span class="sliderOpacityRadiusValue" style="display:inline-block;height:2.5em;line-height:2.5em;font-weight:bold;vertical-align:top;">
											  <?php echo ($popupShadow['5'] || $popupShadow['5']=='0')?($popupShadow['5']*100)."%":'50%'?>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe093;"><span class="set-title-general" onClick="toggle_contents('position');"><?php echo __('Position','BBSe_Popup');?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_down_16.png" id="positionPulldownIcon" class="pulldown-icon" onClick="toggle_contents('position');" /></th>
			</tr>
			<tr class="positionRow hide">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;margin:20px 0;">
						<colgroup><col width="24%"><col width=""></colgroup>
						<tr>
							<td class="noneLine"><span id="sub-title-position-1" class="cursor_default" original-title="<?php echo __('Set position to show popup.','BBSe_Popup');?>"><?php echo __('Position on the page','BBSe_Popup');?></span></td>
							<td class="noneLine">
								<select name="bbse_popup_position" id="bbse_popup_position" style="width:150px;height:29px;line-height:29px;">
									<option value="Left" <?php echo ($popupPosition['0']=='Left')?"selected='selected'":"";?>><?php echo __('Left','BBSe_Popup');?></option>
									<option value="Center" <?php echo (!$popupPosition['0'] || $popupPosition['0']=='Center')?"selected='selected'":"";?>><?php echo __('Center','BBSe_Popup');?></option>
									<option value="Right" <?php echo ($popupPosition['0']=='Right')?"selected='selected'":"";?>><?php echo __('Right','BBSe_Popup');?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="noneLine"><span id="sub-title-position-2" class="cursor_default" original-title="<?php echo __('Set top margin of popup.','BBSe_Popup');?>"><?php echo __('Margin Top','BBSe_Popup');?></span></td>
							<td class="noneLine">
								 <input type="text" name="bbse_popup_margin_top" id="bbse_popup_margin_top" value="<?php echo ($popupPosition['1'])?$popupPosition['1']:"0";?>" style="width:50px;" /> px 
							</td>
						</tr>
						<tr>
							<td class="noneLine"><span id="sub-title-position-3" class="cursor_default" original-title="<?php echo __('Set left margin of popup.','BBSe_Popup');?>"><?php echo __('Margin Left','BBSe_Popup');?></span></td>
							<td class="noneLine">
								 <input type="text" name="bbse_popup_margin_left" id="bbse_popup_margin_left" value="<?php echo ($popupPosition['2'])?$popupPosition['2']:"0";?>" style="width:50px;" /> px 
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<table class="dataTbls overWhite collapse" style="margin-top:20px;">
			<colgroup><col width=""></colgroup>
			<tr>
				<th class="main_title" data-icon="&#xe093;"><span class="set-title-general" onClick="toggle_contents('closebutton');"><?php echo __('Close Button','BBSe_Popup');?></span><img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/arrow_down_16.png" id="closebuttonPulldownIcon" class="pulldown-icon" onClick="toggle_contents('closebutton');" /></th>
			</tr>
			<tr class="closebuttonRow hide">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;margin:20px 0;">
						<tr>
						<?php
						for($c=0;$c<sizeof($bbsePopup_closeButton);$c++){
							if(($c=='0' && !$popupCloseButton['0']) || ($popupCloseButton['0'] && $popupCloseButton['0']==$bbsePopup_closeButton[$c])) $btnChecked="checked=\"checked\"";
							else $btnChecked="";
							echo "<td class=\"tbClear\" style=\"height:20px;width:35px;text-align:center;\"><input type=\"radio\" name=\"bbse_popup_close_button\" id=\"bbse_popup_close_button\" ".$btnChecked." value=\"".$bbsePopup_closeButton[$c]."\" /></td>";
						}
						?>
						</tr>
						<tr>
						<?php
						for($c=0;$c<sizeof($bbsePopup_closeButton);$c++){
							echo "<td class=\"tbClear\" style=\"width:35px;text-align:center;\"><img src=\"".BBSE_POPUP_PLUGIN_WEB_URL."images/btn_close/".$bbsePopup_closeButton[$c]."\"></td>";
						}
						?>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="closebuttonRow hide">
				<td>
					<table class="dataTbls overWhite collapse noTopline" style="width:100%;">
						<colgroup><col width="24%"><col width=""></colgroup>
						<tr>
							<td class="noneLine"><span id="sub-title-close-1" class="cursor_default" original-title="<?php echo __('Set top margin of close button.','BBSe_Popup');?>"><?php echo __('Margin Top','BBSe_Popup');?></span></td>
							<td class="noneLine">
								 <input type="text" name="bbse_popup_close_button_margin_top" id="bbse_popup_close_button_margin_top" value="<?php echo ($popupCloseButton['1'])?$popupCloseButton['1']:"0";?>" style="width:50px;" /> px 
							</td>
						</tr>
						<tr>
							<td class="noneLine"><span id="sub-title-close-2" class="cursor_default" original-title="<?php echo __('Set right margin of close button.','BBSe_Popup');?>"><?php echo __('Margin Right','BBSe_Popup');?></span></td>
							<td class="noneLine">
								 <input type="text" name="bbse_popup_close_button_margin_rihgt" id="bbse_popup_close_button_margin_rihgt" value="<?php echo ($popupCloseButton['2'])?$popupCloseButton['2']:"0";?>" style="width:50px;" /> px 
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

	</div>


	<div class="clearfix"></div>
	<div class="bbse-popup-copyright">
		<div style="padding:5px 10px;">
			<?php echo __("BBS e-Popup is a freely distributed plug-in and the producer tag may not be deleted or changed.","BBSe_Popup");?><br />
			<?php echo __("In the event that the producer tag is deleted or changed, you will be held accountable according to BBSe license regulations and relevant laws.","BBSe_Popup");?>
			<div style="font-size:0.9em;float:right;">
				Powered by <a href="http://www.bbsetheme.com/" target="_blank">BBS e-Popup</a>
			</div>
		</div>
	</div>
	</form>

</div>

