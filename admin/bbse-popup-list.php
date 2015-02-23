<?php
$page=$_REQUEST['page'];
$s_list=(!$_REQUEST['s_list'])?"all":$_REQUEST['s_list'];  // 전체, 노출, 비노출, 노출품절, 휴지통
$s_period_1=$_REQUEST['s_period_1'];
$s_period_2=$_REQUEST['s_period_2'];
$s_type=$_REQUEST['s_type'];
$s_keyword=$_REQUEST['s_keyword'];

$per_page = (!$_REQUEST['per_page'])?10:$_REQUEST['per_page'];  // 한 페이지에 표시될 목록수
$paged = (!$_REQUEST['paged'])?1:intval($_REQUEST['paged']);  // 현재 페이지
$start_pos = ($paged-1) * $per_page;  // 목록 시작 위치

$sOption="";

if($s_list){
	if($s_list=='all') $sOption .=" AND popup_status<>'Trash'";
	elseif($s_list=='Active') $sOption .=" AND popup_status='Active'";
	elseif($s_list=='Inactive') $sOption .=" AND popup_status='Inactive'";
	elseif($s_list=='PCMobile') $sOption .=" AND popup_browser='All'";
	elseif($s_list=='PC') $sOption .=" AND popup_browser='PC'";
	elseif($s_list=='Mobile') $sOption .=" AND popup_browser='Mobile'";
	elseif($s_list=='Trash') $sOption .=" AND popup_status='Trash'";
}

$s_period_1_time=$s_period_2_time="";

if($s_period_1>'0') $s_period_1_time=bbse_popup_get_date_to_unix('start',$s_period_1);
if($s_period_2>'0') $s_period_2_time=bbse_popup_get_date_to_unix('end',$s_period_2);

if($s_period_1_time>'0' || $s_period_2_time>'0'){
	$sOption .=" AND popup_period='Y' ";
	if($s_period_1_time>'0') $sOption .="AND popup_period_end>='".$s_period_1_time."'";
	if($s_period_2_time>'0') $sOption .="AND popup_period_start<='".$s_period_2_time."'";
}

if($s_keyword){
	if($s_type){
		$sOption .=" AND ".$s_type." LIKE %s";
		$prepareParm[]="%".like_escape($s_keyword)."%";
	}
	else{
		$sOption .=" AND (popup_title LIKE %s OR popup_alias LIKE %s)";
		$prepareParm[]="%".like_escape($s_keyword)."%";
		$prepareParm[]="%".like_escape($s_keyword)."%";
	}
}

$prepareParm[]=$start_pos;
$prepareParm[]=$per_page;

$sql  = $wpdb->prepare("SELECT * FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>''".$sOption." ORDER BY idx DESC LIMIT %d, %d", $prepareParm);
$result = $wpdb->get_results($sql);

$s_total_sql  = $wpdb->prepare("SELECT count(idx) FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>''".$sOption, $prepareParm);
$s_total = $wpdb->get_var($s_total_sql);    // 총 상품수

$total_pages = ceil($s_total / $per_page);   // 총 페이지수

/* List Query  */
$total = count($wpdb->get_results("SELECT idx FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status<>'Trash'"));    // Total

$total_Active = count($wpdb->get_results("SELECT idx FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status='Active'"));    // Active
$total_Inactive = count($wpdb->get_results("SELECT idx FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status='Inactive'"));    // Inactive
$total_Trash = count($wpdb->get_results("SELECT idx FROM ".BBSE_POPUP_DB_TABLE." WHERE idx<>'' AND popup_status='Trash'"));    // Trash


/* Query String */
$add_args = array("page"=>$page, "s_list"=>$s_list, "per_page"=>$per_page, "s_keyword"=>$s_keyword, "s_period_1"=>$s_period_1, "s_period_2"=>$s_period_2, "s_type"=>$s_type);
?>
<div class="wrap">
	<div>
		<iframe id="bbsePopupIframe" class="banner_iframe" scrolling="no"></iframe>
	</div>

	<div>
		<h2>
			<?php echo __("Popup List","BBSe_Popup");?><button type="button" class="button-bbse blue" onClick="go_addNewPopup();" style="margin-left:30px;width:160px;height:30px;"> <?php echo __("Add Popup","BBSe_Popup");?> </button>
			<span style="float:right;"><a href="<?php echo (BBSE_POPUP_LANGUAGE=='ko-KR')?"http://manual.onsetheme.com/bbs-e-popup/":"http://manual.onsetheme.com/bbs-e-popup_en/";?>" target="_blank" title="<?php echo __("Manual","BBSe_Popup");?>"><button type="button" class="button-bbse blue" style="width:120px;float:right;"> <?php echo __('Manual','BBSe_Popup');?> </button></a></span>
		</h2>
		<hr>
		<ul class='title-sub-desc'>
			<li <?php echo ($s_list=='all')?"class=\"current\"":"";?>><a title='<?php echo __("View All","BBSe_Popup");?>' href="javascript:view_list('all');"><?php echo __("All","BBSe_Popup");?>(<?php echo $total;?>)</a></li>

			<li <?php echo ($s_list=='Active')?"class=\"current\"":"";?>><a title='<?php echo __("View Active","BBSe_Popup");?>' href="javascript:view_list('Active');"><?php echo __("Active","BBSe_Popup");?>(<?php echo $total_Active;?>)</a></li>
			<li <?php echo ($s_list=='Inactive')?"class=\"current\"":"";?>><a title='<?php echo __("View Inactive","BBSe_Popup");?>' href="javascript:view_list('Inactive');"><?php echo __("Inactive","BBSe_Popup");?>(<?php echo $total_Inactive;?>)</a></li>
			<li <?php echo ($s_list=='Trash')?"class=\"current\"":"";?>><a title='<?php echo __("View Trash","BBSe_Popup");?>' href="javascript:view_list('Trash');"><?php echo __("Trash","BBSe_Popup");?>(<?php echo $total_Trash;?>)</a>
		</ul>
	</div>

	<div class="clearfix"></div>

	<div style="margin-top:30px;">
		<ul class='title-sub-desc none-content'>
			<li>
				<select name='bulk_action' id='bulk_action'>
					<option value=''><?php echo __("Bulk Actions","BBSe_Popup");?></option>
				<?php if($s_list=='Trash'){?>
					<option value='restore'><?php echo __("Restore","BBSe_Popup");?></option>
					<option value='delete-permanently'><?php echo __("Delete Permanently","BBSe_Popup");?></option>
				<?php }else{?>
					<option value='Active'><?php echo __("Active","BBSe_Popup");?></option>
					<option value='Inactive'><?php echo __("Deactive","BBSe_Popup");?></option>
					<option value='Trash'><?php echo __("Move to Trash","BBSe_Popup");?></option>
				<?php }?>
				</select>
				<input type="button" name="doaction" id="doaction" class="button apply" onClick="change_popup_status('chStatus',jQuery('#bulk_action').val(),'');" value="<?php echo __("Apply","BBSe_Popup");?>"  />
			</li>
			<li><input type="text" name="s_period_1" id="s_period_1" class="datepicker" value="<?php echo $s_period_1;?>" style="height: 28px;margin: 0 4px 0 0;width:100px;cursor:pointer;background:#ffffff;text-align:center;" readonly />&nbsp;<img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/icon-calendar.png" onClick="jQuery('#s_period_1').focus();" style="width:20px;height:20px;cursor:pointer;" align="absmiddle" />&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;<input type="text" name="s_period_2" id="s_period_2" value="<?php echo $s_period_2;?>" class="datepicker" style="width:100px;cursor:pointer;background:#ffffff;text-align:center;" readonly />&nbsp;<img src="<?php echo BBSE_POPUP_PLUGIN_WEB_URL?>images/icon-calendar.png" onClick="jQuery('#s_period_2').focus();" style="width:20px;height:20px;cursor:pointer;" align="absmiddle" />		
			</li>
			<li>
				<select name='s_type' id='s_type'>
					<option <?php echo ($s_type=='')?"selected=\"selected\"":"";?> value=''><?php echo __("Filter Option","BBSe_Popup");?></option>
					<option <?php echo ($s_type=='popup_title')?"selected=\"selected\"":"";?> value='popup_title'><?php echo __("Popup Title","BBSe_Popup");?></option>
					<option <?php echo ($s_type=='popup_alias')?"selected=\"selected\"":"";?> value='popup_alias'><?php echo __("Popup Alias","BBSe_Popup");?></option>
				</select>
			</li>
			<li>
				<input type="text" name="s_keyword" id="s_keyword" value="<?php echo $s_keyword;?>" />
				<input type="submit" name="search-query-submit" id="search-query-submit" onClick="search_submit();" class="button apply" value="<?php echo __("Filter","BBSe_Popup");?>"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if($s_list=='Trash' && $total_Trash>'0'){?>
				<input type="button" name="empty-trash-button" id="empty-trash-button" onClick="change_popup_status('chStatus','empty-trash','');" class="button apply" value="<?php echo __("Empty Trash","BBSe_Popup");?>"  />
				<?php }?>
			</li>
		</ul>
		<ul class='title-sub-desc none-content' style="float:right;">
			<li>
				<select name='per_page' id='per_page' onChange="search_submit();" style="font-size:12px;">
					<option <?php echo ($per_page=='10')?"selected='selected'":"";?> value='10'><?php echo __("See 10 per page","BBSe_Popup");?></option>
					<option <?php echo ($per_page=='20')?"selected='selected'":"";?> value='20'><?php echo __("See 20 per page","BBSe_Popup");?></option>
					<option <?php echo ($per_page=='30')?"selected='selected'":"";?> value='30'><?php echo __("See 30 per page","BBSe_Popup");?></option>
					<option <?php echo ($per_page=='40')?"selected='selected'":"";?> value='40'><?php echo __("See 40 per page","BBSe_Popup");?></option>
					<option <?php echo ($per_page=='50')?"selected='selected'":"";?> value='50'><?php echo __("See 50 per page","BBSe_Popup");?></option>
				</select>
			</li>
		</ul>
	</div>

	<div class="clearfix"></div>

	<div style="margin-top:20px;">
		<form name="popupFrm" id="popupFrm">
		<input type="hidden" name="tMode" id="tMode" value="">
		<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
		<input type="hidden" name="s_list" id="s_list" value="<?php echo $s_list;?>">

		<div style="width:100%;">
			<table class="dataTbls normal-line-height collapse">
				<colgroup><col width="3%"><col width="5%"><col width=";"><col width="30%"><col width="20%"><col width="15%"><col width="100px"></colgroup>
				<tr>
					<th><input type="checkbox" name="check_all" id="check_all" onClick="checkAll();"></th>
					<th style="font-size:13px;"><?php echo __("NO.","BBSe_Popup");?></th>
					<th style="font-size:13px;"><?php echo __("TITLE","BBSe_Popup");?></th>
					<th style="font-size:13px;"><?php echo __("OPTION","BBSe_Popup");?></th>
					<th style="font-size:13px;"><?php echo __("ANIMATION","BBSe_Popup");?></th>
					<th style="font-size:13px;"><?php echo __("PERIOD","BBSe_Popup");?></th>
					<th style="font-size:13px;"><?php echo __("STATE","BBSe_Popup");?></th>
				</tr>
	<?php 

	if($s_total>'0'){
		foreach($result as $i=>$data) {
			$num = ($s_total-$start_pos) - $i; //번호
			if($data->popup_status=='Active'){
				$btnColor="black";
				$btnStr=__("Active","BBSe_Popup");
			}
			elseif($data->popup_status=='Inactive'){
				$btnColor="red";
				$btnStr=__("Inactive","BBSe_Popup");
			}
			elseif($data->popup_status=='Trash'){
				$btnColor="orange";
				$btnStr=__("Trash","BBSe_Popup");
			}

			if($data->popup_period=='Y'){
				if(BBSE_POPUP_LANGUAGE=='en-US') $popupPeriod=date("d/m/Y",$data->popup_period_start)." ~ ".date("d/m/Y",$data->popup_period_end);
				else if(BBSE_POPUP_LANGUAGE=='ko-KR') $popupPeriod=date("Y-m-d",$data->popup_period_start)." ~ ".date("Y-m-d",$data->popup_period_end);
			}
			else $popupPeriod=__("Unlimit","BBSe_Popup");
			
			if($data->popup_user=='All') $popupUser=__("All Users","BBSe_Popup");
			elseif($data->popup_user=='LoggedIn') $popupUser=__("Loged in Users","BBSe_Popup");
			elseif($data->popup_user=='NotLoggedIn') $popupUser=__("Not logged in Users","BBSe_Popup");

			$popupSize=explode("|||",$data->popup_size);
			$popupPosition=explode("|||",$data->popup_position);

			$pAnimIn=explode("-",$data->popup_animation_in);
			$pAnimOut=explode("-",$data->popup_animation_out);

			$pAnimation="";
			if($pAnimIn['0']){
				$pAnimation .=strtoupper($pAnimIn['0']);
				if($pAnimIn['1']){
					if($pAnimIn['1']=='In') $pAnimation .="-IN";
					else $pAnimation .="-".strtoupper(str_replace("In","",$pAnimIn['1']));
				}
				else $pAnimation .="-IN";
			}
			else $pAnimation .=__("NONE","BBSe_Popup");

			if($pAnimOut['0']){
				$pAnimation .=", ".strtoupper($pAnimOut['0']);
				if($pAnimOut['1']){
					if($pAnimOut['1']=='Out') $pAnimation .="-OUT";
					else $pAnimation .="-".strtoupper(str_replace("Out","",$pAnimOut['1']));
				}
				else $pAnimation .="-OUT";
			}
			else $pAnimation .=", ".__("NONE","BBSe_Popup");
	?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" name="check[]" id="check[]" value="<?php echo $data->idx;?>"></td>
					<td style="text-align:center;"><?php echo $num;?></td>
					<td>
						<a href="admin.php?page=bbse_Popup_add&tMode=update&tData=<?php echo $data->idx;?>" target="_self" title="<?php echo __("Popup Name","BBSe_Popup");?>"><span class="titleH5 emBlue"><?php echo $data->popup_title;?></span></a>
						<div class="row-actions">
							<?php if($s_list=='Trash'){?>
								<span class='edit'><a href="<?php echo esc_url( home_url( '/' ) ); ?>?bbse_pid=<?php echo $data->idx;?>&preview=true" target="_blank" title="<?php echo __("Preview","BBSe_Popup");?>"><?php echo __("Preview","BBSe_Popup");?></a> | </span>
								<span class='edit'><a href="javascript:change_popup_status('chStatus','restore','<?php echo $data->idx;?>');" title='<?php echo __("Restore","BBSe_Popup");?>'><?php echo __("Restore","BBSe_Popup");?></a> | </span>
								<span class='trash'><a class='submitdelete' href="javascript:change_popup_status('chStatus','delete-permanently','<?php echo $data->idx;?>');" title='<?php echo __("Delete Permanently","BBSe_Popup");?>'><?php echo __("Delete Permanently","BBSe_Popup");?></a></span>
							<?php }else{?>
								<span class='edit'><a href="<?php echo esc_url( home_url( '/' ) ); ?>?bbse_pid=<?php echo $data->idx;?>&preview=true" target="_blank" title="<?php echo __("Preview","BBSe_Popup");?>"><?php echo __("Preview","BBSe_Popup");?></a> | </span>
								<span class='edit'><a href="admin.php?page=bbse_Popup_add&tMode=update&tData=<?php echo $data->idx;?>" target="_self" title="<?php echo __("Edit","BBSe_Popup");?>"><?php echo __("Edit","BBSe_Popup");?></a> | </span>
								<span class='edit'><a href="javascript:change_popup_status('chStatus','duplicate','<?php echo $data->idx;?>');" title="<?php echo __("Duplicate","BBSe_Popup");?>"><?php echo __("Duplicate","BBSe_Popup");?></a> | </span>
								<span class='trash'><a class='submitdelete' href="javascript:change_popup_status('chStatus','Trash','<?php echo $data->idx;?>');" title='<?php echo __("Trash","BBSe_Popup");?>'><?php echo __("Trash","BBSe_Popup");?></a></span>
							<?php }?>
						</div>
					</td>
					<td style="text-align:center;"><strong><?php echo __("Size","BBSe_Popup");?> : </strong><?php echo $popupSize['0'];?>px X <?php echo $popupSize['1'];?>px, <strong><?php echo __("User","BBSe_Popup");?> : </strong><?php echo $popupUser;?>, <strong><?php echo __("Pages","BBSe_Popup");?> : </strong><?php echo $data->popup_page;?>, <strong><?php echo __("Browser","BBSe_Popup");?> : </strong><?php echo $data->popup_browser;?><br /><strong><?php echo __("Layout","BBSe_Popup");?> : </strong><?php echo __($data->popup_layout,"BBSe_Popup");?><?php echo ($data->popup_layout=='Layer')?" (".__($data->popup_layout_modal,"BBSe_Popup").")":"";?>, <strong><?php echo __("Position","BBSe_Popup");?> : </strong><?php echo __($popupPosition['0'],"BBSe_Popup");?></td>
					<td style="text-align:center;"><?php echo $pAnimation;?></td>
					<td style="text-align:center;"><?php echo $popupPeriod;?></td>
					<td style="text-align:center;"><button type="button" class="button-small-fill <?php echo $btnColor;?> default-cursor" style="width:70px;"><?php echo $btnStr;?></button></td>
				</tr>
	<?php
		}
	}
	else{
	?>
				<tr>
					<td style="height:130px;text-align:center;" colspan="7"><?php echo __("Results do not exist.","BBSe_Popup");?></td>
				</tr>
	<?php 
	}
	?>
			</table>
		</div>

		<div style="margin-top:20px;">
			<ul class='title-sub-desc none-content'>
				<li>
					<select name='bulk_action' id='bulk_action'>
						<option value=''><?php echo __("Bulk Actions","BBSe_Popup");?></option>
					<?php if($s_list=='Trash'){?>
						<option value='restore'><?php echo __("Restore","BBSe_Popup");?></option>
						<option value='delete-permanently'><?php echo __("Delete Permanently","BBSe_Popup");?></option>
					<?php }else{?>
						<option value='Active'><?php echo __("Active","BBSe_Popup");?></option>
						<option value='Inactive'><?php echo __("Deactive","BBSe_Popup");?></option>
						<option value='Trash'><?php echo __("Move to Trash","BBSe_Popup");?></option>
					<?php }?>
					</select>
					<input type="button" name="doaction" id="doaction" class="button apply" onClick="change_popup_status('chStatus',jQuery('#bulk_action').val(),'');" value="<?php echo __("Apply","BBSe_Popup");?>"  />
				</li>
			</ul>
		</div>

		<table align="center">
		<colgroup><col width=""></colgroup>
			<tr>
				<td>
					<?php echo bbse_pupup_get_pagination($paged, $total_pages, $add_args);?>
				</td>
			</tr>
		</table>
		
		</form>
		<div class="bbse-popup-copyright">
			<div style="padding:5px 10px;">
				<?php echo __("BBS e-Popup is a freely distributed plug-in and the producer tag may not be deleted or changed.","BBSe_Popup");?><br />
				<?php echo __("In the event that the producer tag is deleted or changed, you will be held accountable according to BBSe license regulations and relevant laws.","BBSe_Popup");?>
				<div style="font-size:0.9em;float:right;">
					Powered by <a href="http://www.bbsetheme.com/" target="_blank">BBS e-Popup</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="excelDown"></div>
