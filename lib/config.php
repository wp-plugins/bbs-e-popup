<?php
$plugin_shortname='bbse_popup';

$bbse_plugin_options=array(
	'license'=>
		array(
			array('name'=>'라이센스 관리',
					'type'=>'title'),
			array('name'=>'라이센스 Key',
					'id'=>$plugin_shortname.'_license_key',
					'type'=>'hidden'),
			array('name'=>'라이센스 상태',
					'id'=>$plugin_shortname.'_license_status',
					'type'=>'hidden'),
		),
);

$bbse_popup_btmMsg_language=Array("en-US","ja","ko-KR","zh-CN");

$bbsePopup_closeButton=Array(
	"btn_close01.png","btn_close02.png","btn_close03.png","btn_close04.png","btn_close05.png","btn_close06.png","btn_close07.png","btn_close08.png","btn_close09.png",
	"btn_close10.png","btn_close11.png","btn_close12.png","btn_close13.png","btn_close14.png","btn_close15.png","btn_close16.png","btn_close17.png","btn_close18.png", // v2.1.5
	"btn_close19.png","btn_close20.png","btn_close21.png","btn_close22.png","btn_close23.png","btn_close24.png","btn_close25.png","btn_close26.png","btn_close27.png",
	"btn_close28.png","btn_close29.png","btn_close30.png","btn_close31.png","btn_close32.png","btn_close33.png","btn_close34.png","btn_close35.png","btn_close36.png"
);

$bbse_popup_btmMsg=Array(
	"Today"=>Array(
						"en-US"=>"Don't see this window again today.",
						"ko-KR"=>"오늘 하루 동안 이 창이 보이지 않습니다.",
						"zh-CN"=>"今日全天不显示此窗。",
						"ja-JP"=>"今日一日この画面を見ません。",
						"ja"=>"今日一日この画面を見ません。"
					),
	"Minute"=>Array(
						"en-US"=>"This window will not show for 30 minutes.",
						"ko-KR"=>"30분 동안 이 창이 보이지 않습니다.",
						"zh-CN"=>"30分钟内不显示此窗。",
						"ja-JP"=>"30分間この画面を見ません、",
						"ja"=>"30分間この画面を見ません、"
					)									
);

$anmIn=array(
	'main'=>array("flash","pulse","rubberBand","shake","swing","tada","wobble","bounce","fade","flip","lightSpeed","rotate","slide","roll","zoom"),
	'bounce'=>array("In","InDown","InLeft","InRight","InUp"),
	'fade'=>array("In","InDown","InDownBig","InLeft","InLeftBig","InRight","InRightBig","InUp","InUpBig"),
	'flip'=>array("InX","InY"),
	'lightSpeed'=>array("In"),
	'rotate'=>array("In","InDownLeft","InDownRight","InUpLeft","InUpRight"),
	'slide'=>array("InDown","InLeft","InRight","InUp"),
	'roll'=>array("In"),
	'zoom'=>array("In","InDown","InLeft","InRight","InUp")
);

$anmOut=array(
	'main'=>array("bounce","fade","flip","lightSpeed","rotate","slide","roll","zoom"),
	'bounce'=>Array("Out","OutDown","OutLeft","OutRight","OutUp"),
	'fade'=>Array("Out","OutDown","OutDownBig","OutLeft","OutLeftBig","OutRight","OutRightBig","OutUp","OutUpBig"),
	'flip'=>Array("OutX","OutY"),
	'lightSpeed'=>Array("Out"),
	'rotate'=>Array("Out","OutDownLeft","OutDownRight","OutUpLeft","OutUpRight"),
	'slide'=>Array("OutDown","OutLeft","OutRight","OutUp"),
	'roll'=>Array("Out"),
	'zoom'=>Array("Out","OutDown","OutLeft","OutRight","OutUp")
);
