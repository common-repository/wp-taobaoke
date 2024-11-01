<?php
$taobaoke_appKey = '12004919';
$default_pid = 'mm_11098708_0_0';
$taobaoke_appSecret = '56164109db202447e5e377baaa60002f';
$taobaoke_URL = 'http://gw.api.taobao.com/router/rest?';

$tbk_credit_code = array(
'1heart','2heart','3heart','4heart','5heart',
'1diamond','2diamond','3diamond','4diamond','5diamond',
'1crown','2crown','3crown','4crown','5crown',
'1goldencrown','2goldencrown','3goldencrown','4goldencrown','5goldencrown'
);

/*$tbk_area = array(
__('All Area', 'wp-taobaoke'), __('JiangZheHu', 'wp-taobaoke'), __('ZhuSanJiao', 'wp-taobaoke'), __('BeiJing', 'wp-taobaoke'), __('ShangHai', 'wp-taobaoke'),
__('HangZhou', 'wp-taobaoke'), __('GuangZhou', 'wp-taobaoke'), __('ShenZhen', 'wp-taobaoke'), __('NanJing', 'wp-taobaoke'), __('WuHan', 'wp-taobaoke'),
__('TianJin', 'wp-taobaoke'), __('ChengDu', 'wp-taobaoke'), __('HaErBin', 'wp-taobaoke'), __('ChongQing', 'wp-taobaoke'), __('NingBo', 'wp-taobaoke'),
__('WuXi', 'wp-taobaoke'), __('JiNan', 'wp-taobaoke'), __('SuZhou', 'wp-taobaoke'), __('WenZhou', 'wp-taobaoke'), __('QingDao', 'wp-taobaoke'),
__('ShenYang', 'wp-taobaoke'), __('FuZhou', 'wp-taobaoke'), __('XiAn', 'wp-taobaoke'), __('ChangSha', 'wp-taobaoke'), __('HeFei', 'wp-taobaoke'),
__('NanNing', 'wp-taobaoke'), __('NanChang', 'wp-taobaoke'), __('ZhengZhou', 'wp-taobaoke'), __('XiaMen', 'wp-taobaoke'), __('DaLian', 'wp-taobaoke'),
__('ChangZhou', 'wp-taobaoke'), __('ShiJiaZhuang', 'wp-taobaoke'), __('DongGuan', 'wp-taobaoke'), __('AnHui', 'wp-taobaoke'), __('FuJian', 'wp-taobaoke'),
__('GanSu', 'wp-taobaoke'), __('GuangDong', 'wp-taobaoke'), __('GuangXi', 'wp-taobaoke'), __('GuiZhou', 'wp-taobaoke'), __('HaiNan', 'wp-taobaoke'),
__('HeBei', 'wp-taobaoke'), __('HeiLongJiang', 'wp-taobaoke'), __('HeNan', 'wp-taobaoke'), __('HuBei', 'wp-taobaoke'), __('HuNan', 'wp-taobaoke'),
__('JiangSu', 'wp-taobaoke'), __('JiangXi', 'wp-taobaoke'), __('JiLin', 'wp-taobaoke'), __('LiaoNing', 'wp-taobaoke'), __('NeiMengGu', 'wp-taobaoke'),
__('NingXia', 'wp-taobaoke'), __('QingHai', 'wp-taobaoke'), __('ShanDong', 'wp-taobaoke'), __('ShanXi', 'wp-taobaoke'), __('ShanXii', 'wp-taobaoke'),
__('SiChuan', 'wp-taobaoke'), __('XinJiang', 'wp-taobaoke'), __('XiZang', 'wp-taobaoke'), __('YunNan', 'wp-taobaoke'), __('ZheJiang', 'wp-taobaoke'),
__('HongKong', 'wp-taobaoke'), __('Macau', 'wp-taobaoke'), __('TaiWan', 'wp-taobaoke'), __('OutSea', 'wp-taobaoke')
);*/

$tbk_area = array('--所有地区--', '江浙沪', '珠三角', '北京', '上海', '杭州', '广州', '深圳', '南京', '武汉', 
'天津', '成都', '哈尔滨', '重庆', '宁波', '无锡', '济南', '苏州', '温州', '青岛', '沈阳', '福州', '西安', 
'长沙', '合肥', '南宁', '南昌', '郑州', '厦门', '大连', '常州', '石家庄', '东莞', '安徽', '福建', '甘肃', 
'广东', '广西', '贵州', '海南', '河北', '黑龙江', '河南', '湖北', '湖南', '江苏', '江西', '吉林', '辽宁', 
'内蒙古', '宁夏', '青海', '山东', '山西', '陕西', '四川', '新疆', '西藏', '云南', '浙江', '香港', '澳门', 
'台湾', '海外');

//显示淘宝客
function tbk_show() {
	global $tbk_credit_code, $taobaoke_appKey, $default_pid, $taobaoke_appSecret, $taobaoke_URL, $tbk_area;
	$tbk_credit_code2 = array_reverse($tbk_credit_code);
	$taobaoke_options = get_option('taobaoke_options');
	$pid = $taobaoke_options['pid'];
	$category = $taobaoke_options['category'];

	$cid_str = '';
	$cid_arr = explode('_', $category);
	foreach($cid_arr as $k => $v) {
		if($v != '0-')
		$cid_str = $v;
	}
	//pid and category
	if(empty($pid)) {
		$pid = $default_pid;
	}

	if(empty($category)) {
		$category = '0';
	}

	if( $taobaoke_options['commission_rate_start'] < 0 ||  $taobaoke_options['commission_rate_start'] > 100) {
		$taobaoke_options['commission_rate_start'] = 0;
	}

	if($taobaoke_options['commission_rate_end'] < 0 && $taobaoke_options['commission_rate_end'] > 100) {
		$taobaoke_options['commission_rate_end'] = 100;
	}

	if($taobaoke_options['commission_rate_start'] > $taobaoke_options['commission_rate_end']) {
		$tmp = $taobaoke_options['commission_rate_end'];
		$taobaoke_options['commission_rate_end'] = $taobaoke_options['commission_rate_start'];
		$taobaoke_options['commission_rate_start'] = $tmp;
	}

	//参数数组
	$paramArr = array(
	    'app_key' => $taobaoke_appKey, 
	    'method' => 'taobao.taobaoke.items.get', 
	    'format' => 'xml', 
	    'v' => '1.0', 
	    'timestamp' => date('Y-m-d H:i:s'), 
	    'fields' => 'iid,title,nick,pic_url,price,click_url', 
	    'pid' => $pid,
		'cid' => $cid_str,
		'start_commissionRate' => $taobaoke_options['commission_rate_start'],
		'end_commissionRate' => $taobaoke_options['commission_rate_end']
	);

	//Tidy commission
	if($taobaoke_options['commission_start'] > 0 && $taobaoke_options['commission_end'] > 0) {
		
		//If start > end, switch them
		if($taobaoke_options['commission_start'] > $taobaoke_options['commission_end']) {
			$paramArr['start_commission'] = $taobaoke_options['commission_end'];
			$paramArr['end_commission'] = $taobaoke_options['commission_start'];
		} else {
			$paramArr['start_commission'] = $taobaoke_options['commission_start'];
			$paramArr['end_commission'] = $taobaoke_options['commission_end'];
		}
	}

	//Tidy commision num
	if($taobaoke_options['commission_num_start'] > 0 && $taobaoke_options['commission_num_end'] > 0) {
		
		//If start > end, switch them
		if($taobaoke_options['commission_num_start'] > $taobaoke_options['commission_num_end']) {
			$paramArr['start_commissionNum'] = $taobaoke_options['commission_num_end'];
			$paramArr['end_commissionNum'] = $taobaoke_options['commission_num_start'];
		} else {
			$paramArr['start_commissionNum'] = $taobaoke_options['commission_num_start'];
			$paramArr['end_commissionNum'] = $taobaoke_options['commission_num_end'];
		}
	}

	//Tidy credit
	if($taobaoke_options['credit_start'] > 0 && $taobaoke_options['credit_end'] > 0) {

		//If start > end, switch them
		if($taobaoke_options['credit_start'] > $taobaoke_options['credit_end']) {;
			$paramArr['start_credit'] = $tbk_credit_code[$taobaoke_options['credit_end']];
			$paramArr['end_credit'] = $tbk_credit_code2[$taobaoke_options['credit_start']];
		} else {
			$paramArr['start_credit'] = $tbk_credit_code[$taobaoke_options['credit_start']];
			$paramArr['end_credit'] = $tbk_credit_code2[$taobaoke_options['credit_end']];
		}
	}

	//Tidy product price
	if($taobaoke_options['product_price_start'] > 0 && $taobaoke_options['product_price_end'] > 0) {

		//If start > end, switch them
		if($taobaoke_options['product_price_start'] > $taobaoke_options['product_price_end']) {
			$paramArr['start_price'] = $taobaoke_options['product_price_end'];
			$paramArr['end_price'] = $taobaoke_options['product_price_start'];
		} else {
			$paramArr['start_price'] = $taobaoke_options['product_price_start'];
			$paramArr['end_price'] = $taobaoke_options['product_price_end'];
		}
	}
	//Tidy area
	if($taobaoke_options['area'] > 0 && $taobaoke_options['area'] < count($tbk_area)) {
		$area_id = intval($taobaoke_options['area']);
		$paramArr['area'] = $tbk_area[$area_id];
	}

	//生成签名
	$sign = tbk_createSign($paramArr);

	//组织参数
	$strParam = tbk_createStrParam($paramArr);
	$strParam .= 'sign='.$sign;

	//访问服务
	$url = $taobaoke_URL.$strParam;

	$result = file_get_contents($url);

	$result = tbk_getXmlData($result);

	$taobaokeItem = $result['taobaokeItem'];
	if(!empty($taobaokeItem)) {
		shuffle($taobaokeItem);
		foreach ($taobaokeItem as $key => $val) {
		?>

		<div id="wp-taobaoke-box" class="tbk-style-box" style="float:left;height:100%;margin-right:10px;">
		<div id="wp-taobaoke-title" class="tbk-style-title"><?php echo $val['title'];?></div>
		<div id="wp-taobaoke-image" class="tbk-style-image"><a href="<?php echo $val['click_url'];?>" target="_blank"><img src="<?php echo $val['pic_url'];?>" /></a></div>
		<div id="wp-taobaoke-price" class="tbk-style-price"><?php echo $val['price'];?>元</div>
		</div>
	
		<?php
			break;
		}
	}
}

//整理参数
function tbk_tidy_param($paramArr) {
	global $default_pid;

	//pid and category
	if(empty($paramArr['pid'])) {
		$paramArr['pid'] = $default_pid;
	}

	if(empty($paramArr['category'])) {
		$paramArr['category'] = 0;
	}

	if($paramArr['start_commissionRate'] < 0 || $paramArr['start_commissionRate'] > 100) {
		$paramArr['start_commissionRate'] = 0;
	}

	if($paramArr['end_commissionRate'] < 0 && $paramArr['end_commissionRate'] > 100) {
		$paramArr['end_commissionRate'] = 0;
	}

	if($paramArr['start_commissionRate'] > $paramArr['end_commissionRate']) {
		$tmp = $paramArr['end_commissionRate'];
		$paramArr['end_commissionRate'] = $paramArr['start_commissionRate'];
		$paramArr['start_commissionRate'] = $tmp;
	}
}

//商品分类
function tbk_getCategoriesJson($cid) {
	global $taobaoke_appKey, $taobaoke_appSecret, $taobaoke_URL;
	
	//参数数组
	$paramArr = array(
	    'app_key' => $taobaoke_appKey, 
	    'method' => 'taobao.itemcats.get.v2', 
	    'format' => 'json', 
	    'v' => '1.0', 
	    'timestamp' => date('Y-m-d H:i:s'), 
	    'fields' => 'cid,parent_cid,name,is_parent,status,sort_order',
		'parent_cid' => $cid
	);
	
	//生成签名
	$sign = tbk_createSign($paramArr);
	
	//组织参数
	$strParam = tbk_createStrParam($paramArr);
	$strParam .= 'sign='.$sign;
	
	//访问服务
	$url = $taobaoke_URL.$strParam;
	$result = file_get_contents($url);
	
	return $result;
}

//商品分类
function tbk_getCategories($cid) {
	global $taobaoke_appKey, $taobaoke_appSecret, $taobaoke_URL;
	
	//参数数组
	$paramArr = array(
	    'app_key' => $taobaoke_appKey, 
	    'method' => 'taobao.itemcats.get.v2', 
	    'format' => 'xml', 
	    'v' => '1.0', 
	    'timestamp' => date('Y-m-d H:i:s'), 
	    'fields' => 'cid,parent_cid,name,is_parent,status,sort_order',
		'parent_cid' => $cid
	);
	
	//生成签名
	$sign = tbk_createSign($paramArr);
	
	//组织参数
	$strParam = tbk_createStrParam($paramArr);
	$strParam .= 'sign='.$sign;
	
	//访问服务
	$url = $taobaoke_URL.$strParam;
	$result = file_get_contents($url);
	$result = tbk_getXmlData($result);
	
	$taobaokeItemCats = $result['item_cat'];

	return $taobaokeItemCats;
}
//签名函数 
function tbk_createSign ($paramArr) { 
    global $taobaoke_appSecret; 
    $sign = $taobaoke_appSecret; 
    ksort($paramArr); 
    foreach ($paramArr as $key => $val) { 
       if ($key !='' && $val !='') { 
           $sign .= $key.$val; 
       } 
    } 
    $sign = strtoupper(md5($sign)); 
    return $sign; 
}

//组参函数 
function tbk_createStrParam ($paramArr) { 
    $strParam = ''; 
    foreach ($paramArr as $key => $val) { 
       if ($key != '' && $val !='') { 
           $strParam .= $key.'='.urlencode($val).'&'; 
       } 
    } 
    return $strParam; 
} 

//解析xml函数
function tbk_getXmlData ($strXml) {
	$pos = strpos($strXml, 'xml');
	if ($pos) {
		$xmlCode=simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
		$arrayCode=tbk_get_object_vars_final($xmlCode);
		return $arrayCode ;
	} else {
		return '';
	}
}
	
function tbk_get_object_vars_final($obj){
	if(is_object($obj)){
		$obj=get_object_vars($obj);
	}
	if(is_array($obj)){
		foreach ($obj as $key=>$value){
			$obj[$key]=tbk_get_object_vars_final($value);
		}
	}
	return $obj;
}
?>