<?php
/*
+----------------------------------------------------------------+
|																 |
|	WordPress 2.8 Plugin: WP-TaoBaoKe 1.0	 					 |
|	Copyright (c) 2009 Boning Fan				            	 |
|																 |
|	File Written By:											 |
|	- Boning Fan								            	 |
|	- http://www.sohao.net										 |
|																 |
|	File Information:								        	 |
|	- TaoBaoKe Options Page										 |
|	- wp-content/plugins/wp-taobaoke/taobaoke-options.php		 |
|																 |
+----------------------------------------------------------------+
*/

### Variables Variables Variables
$base_name = plugin_basename('wp-taobaoke/taobaoke-options.php');
$base_page = 'admin.php?page='.$base_name;
//$id = intval($_GET['id']);
//$mode = trim($_GET['mode']);
$mode = '';

$ajaxURL = '../wp-content/plugins/wp-taobaoke/taobaoke-ajax.php';

$tbk_credit_arr = array(
__('1heart', 'wp-taobaoke'), __('2heart', 'wp-taobaoke'), __('3heart', 'wp-taobaoke'), __('4heart', 'wp-taobaoke'), __('5heart', 'wp-taobaoke'),
__('1diamond', 'wp-taobaoke'), __('2diamond', 'wp-taobaoke'), __('3diamond', 'wp-taobaoke'), __('4diamond', 'wp-taobaoke'), __('5diamond', 'wp-taobaoke'),
__('1crown', 'wp-taobaoke'), __('2crown', 'wp-taobaoke'), __('3crown', 'wp-taobaoke'), __('4crown', 'wp-taobaoke'), __('5crown', 'wp-taobaoke'),
__('1goldencrown', 'wp-taobaoke'), __('2goldencrown', 'wp-taobaoke'), __('3goldencrown', 'wp-taobaoke'), __('4goldencrown', 'wp-taobaoke'), __('5goldencrown', 'wp-taobaoke')
);

$tbk_categories = tbk_getCategories('0');

### Form Processing
// Update Options
if(!empty($_POST['Submit'])) {
	$taobaoke_options = array();

	$cid_category = $_POST['cid_0'];
	if($cid_category != '0-' && isset($_POST['cid_'.$cid_category])) {
		$cid_2 = $_POST['cid_'.$cid_category];
		if($cid_2 != '0-' && isset($_POST['cid_'.$cid_2])) {
			$cid_3 = $_POST['cid_'.$cid_2];
			if($cid_3 != '0-' && isset($_POST['cid_'.$cid_3])) {
				$cid_4 = $_POST['cid_'.$cid_3];
				$cid_category = $cid_category.'_'.$cid_2.'_'.$cid_3.'_'.$cid_4;
			} else {
				$cid_category = $cid_category.'_'.$cid_2.'_'.$cid_3;
			}
		} else {
			$cid_category .= '_'.$cid_2;
		}
	}

	$taobaoke_options['pid'] = $_POST['taobaoke_pid'];
	$taobaoke_options['category'] = $cid_category;
	$taobaoke_options['commission_rate_start'] = intval($_POST['taobaoke_crs']);
	$taobaoke_options['commission_rate_end'] = intval($_POST['taobaoke_cre']);
	$taobaoke_options['commission_start'] = intval($_POST['taobaoke_cs']);
	$taobaoke_options['commission_end'] = intval($_POST['taobaoke_ce']);
	$taobaoke_options['commission_num_start'] = intval($_POST['taobaoke_cns']);
	$taobaoke_options['commission_num_end'] = intval($_POST['taobaoke_cne']);
	$taobaoke_options['credit_start'] =  trim($_POST['taobaoke_credit_start']);
	$taobaoke_options['credit_end'] =  trim($_POST['taobaoke_credit_end']);
	$taobaoke_options['product_price_start'] =  intval($_POST['taobaoke_pps']);
	$taobaoke_options['product_price_end'] =  intval($_POST['taobaoke_ppe']);
	$taobaoke_options['area'] = intval($_POST['taobaoke_area']);

	$update_views_queries = array();
	$update_views_text = array();
	$update_views_queries[] = update_option('taobaoke_options', $taobaoke_options);
	$update_views_text[] = __('TaoBaoKe Options', 'wp-taobaoke');
	$i=0;
	$text = '';
	foreach($update_views_queries as $update_views_query) {
		if($update_views_query) {
			$text .= '<font color="green">'.$update_views_text[$i].' '.__('Updated', 'wp-taobaoke').'</font><br />';
		}
		$i++;
	}
	if(empty($text)) {
		$text = '<font color="red">'.__('No TaoBaoKe Option Updated', 'wp-taobaoke').'</font>';
	}
}

// Decide What To Do
if(!empty($_POST['do'])) {
	//  Uninstall wp-taobaoke
	switch($_POST['do']) {	
		case __('UNINSTALL wp-taobaoke', 'wp-taobaoke') :
			if(trim($_POST['uninstall_views_yes']) == 'yes') {
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				foreach($views_settings as $setting) {
					$delete_setting = delete_option($setting);
					if($delete_setting) {
						echo '<font color="green">';
						printf(__('Setting Key \'%s\' has been deleted.', 'wp-taobaoke'), "<strong><em>{$setting}</em></strong>");
						echo '</font><br />';
					} else {
						echo '<font color="red">';
						printf(__('Error deleting Setting Key \'%s\'.', 'wp-taobaoke'), "<strong><em>{$setting}</em></strong>");
						echo '</font><br />';
					}
				}
				echo '</p>';
				echo '<p>';
				foreach($views_postmetas as $postmeta) {
					$remove_postmeta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '$postmeta'");
					if($remove_postmeta) {
						echo '<font color="green">';
						printf(__('Post Meta Key \'%s\' has been deleted.', 'wp-taobaoke'), "<strong><em>{$postmeta}</em></strong>");
						echo '</font><br />';
					} else {
						echo '<font color="red">';
						printf(__('Error deleting Post Meta Key \'%s\'.', 'wp-taobaoke'), "<strong><em>{$postmeta}</em></strong>");
						echo '</font><br />';
					}
				}
				echo '</p>';
				echo '</div>'; 
				$mode = 'end-UNINSTALL';
			}
			break;
	}
}


### Determines Which Mode It Is
switch($mode) {
	// Deactivating wp-taobaoke
	case 'end-UNINSTALL':
		$deactivate_url = 'plugins.php?action=deactivate&amp;plugin=wp-taobaoke/wp-taobaoke.php';
		if(function_exists('wp_nonce_url')) { 
			$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_wp-taobaoke/wp-taobaoke.php');
		}
		echo '<div class="wrap">';
		echo '<h2>'.__('Uninstall wp-taobaoke', 'wp-taobaoke').'</h2>';
		echo '<p><strong>'.sprintf(__('<a href="%s">Click Here</a> To Finish The Uninstallation And wp-taobaoke Will Be Deactivated Automatically.', 'wp-taobaoke'), $deactivate_url).'</strong></p>';
		echo '</div>';
		break;
	// Main Page
	default:
		$taobaoke_options = get_option('taobaoke_options');
		$cid_category = $taobaoke_options['category'];
?>

<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>">
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e('TaoBaoKe Options', 'wp-taobaoke'); ?></h2>
	<h3><?php _e('Basic Options', 'wp-taobaoke'); ?></h3>
	<p><?php _e('The TaoBaoKe PID is in your TaoBaoKe\'s account, you should use your PID, otherwise the commision won\'t work.', 'wp-taobaoke'); ?></p>
	<table class="form-table">
		<tr>
			<td valign="top">
				<strong style="font-size:12px;"><?php _e('TaoBaoKe PID:', 'wp-taobaoke'); ?></strong><br /><br />
			</td>
			<td valign="top">
				<input type="text" id="taobaoke_pid" name="taobaoke_pid" size="40" value="<?php echo $taobaoke_options['pid']; ?>" />
			</td>
		</tr>
	</table>
	<h3><?php _e('Advanced Options', 'wp-taobaoke'); ?></h3>
	<p><?php _e('Choose your criteria for your TaoBaoKe. For "Commission Price", "Product Price Interval", "Commission Num Interval", set to "0 - 0" means no limitation. ', 'wp-taobaoke'); ?></p>
	<table class="form-table">
		 <tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Product Category:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<!-- select name="taobaoke_category" size="1" style="font-size:12px;">
					<option style="font-size:12px;" value="0"<?php selected('0', $taobaoke_options['category']); ?>><?php _e('All Categories', 'wp-taobaoke'); ?></option>
					<?php foreach($tbk_categories as $k => $v) {?>
					<option style="font-size:12px;" value="<?php echo ($k+1); ?>"<?php selected($k+1, $taobaoke_options['category']); ?>><?php echo $v['name']; ?></option>
					<?php } ?>
				</select -->
				<div id="parentCidDiv" style="float:left;"></div>
				<div id="ajaxPic" style="display:none;float:left;margin:2px 0px 0px 10px"><img src="/wp-content/plugins/wp-taobaoke/images/ajax.gif"></div>
			</td>
		</tr>
		 <tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Commission Rate Interval:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<input type="text" onkeyup="filterDecimal(this);" size="8" id="taobaoke_crs" name="taobaoke_crs" value="<?php echo $taobaoke_options['commission_rate_start']; ?>"/> - <input type="text" onkeyup="filterDecimal(this);" size="8" id="taobaoke_cre" name="taobaoke_cre" value="<?php echo $taobaoke_options['commission_rate_end']; ?>"/> %
			</td>
		</tr>
		 <tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Commission Price:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<input type="text" onkeyup="filterDecimal(this);" size="8" id="taobaoke_cs" name="taobaoke_cs" value="<?php echo $taobaoke_options['commission_start']; ?>"/> - <input type="text" onkeyup="filterDecimal(this);" size="8" id="taobaoke_ce" name="taobaoke_ce" value="<?php echo $taobaoke_options['commission_end']; ?>"/> <?php _e('RMB', 'wp-taobaoke'); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Saler Credit Interval:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<select id="taobaoke_credit_start" name="taobaoke_credit_start" style="width:72px;font-size:12px;">
				  <?php foreach($tbk_credit_arr as $k => $v) { ?>
				  <option style="font-size:12px;" value="<?php echo ($k); ?>"<?php selected($k, $taobaoke_options['credit_start']); ?>><?php echo $v; ?></option>
				  <?php } ?>
				</select>
				-
				<select id="taobaoke_credit_end" name="taobaoke_credit_end" style="width:72px;font-size:12px;">
				  <?php $tbk_credit_arr_2 = array_reverse($tbk_credit_arr); foreach($tbk_credit_arr_2 as $k => $v) { ?>
				  <option style="font-size:12px;" value="<?php echo ($v); ?>"<?php selected($k, $taobaoke_options['credit_end']); ?>><?php echo $v; ?></option>
				  <?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Product Price Interval:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<input type="text" onkeyup="filterInt(this);" size="8" id="taobaoke_pps" name="taobaoke_pps" value="<?php echo $taobaoke_options['product_price_start']; ?>"/> - <input type="text" onkeyup="filterInt(this);" size="8" id="taobaoke_ppe" name="taobaoke_ppe" value="<?php echo $taobaoke_options['product_price_end']; ?>"/> <?php _e('RMB', 'wp-taobaoke'); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Commission Num Interval:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<input type="text" onkeyup="filterInt(this);" size="8" id="taobaoke_cns" name="taobaoke_cns" value="<?php echo $taobaoke_options['commission_num_start']; ?>"/> -  <input type="text" onkeyup="filterInt(this);" size="8" id="taobaoke_cne" name="taobaoke_cne" value="<?php echo $taobaoke_options['commission_num_end']; ?>"/>
			</td>
		</tr>
		<tr>
			<td valign="top" width="30%"><strong style="font-size:12px;"><?php _e('Saler Position:', 'wp-taobaoke'); ?></strong></td>
			<td valign="top">
				<select style="font-size:12px;" id="taobaoke_area" name="taobaoke_area">
			    <?php foreach($tbk_area as $k => $v) { ?>
			    <option style="font-size:12px;" value="<?php echo ($k); ?>"<?php selected($k, $taobaoke_options['area']); ?>><?php echo $v; ?></option>
			    <?php } ?>
				</select>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'wp-taobaoke'); ?>" />
	</p>
</div>
</form> 
<script type="text/javascript">

var cid0_api = '0|{"rsp":{"item_cats":[{"cid":"14","is_parent":true,"name":"数码相机/摄像机/图形冲印","parent_cid":"0","status":"normal"},{"cid":"50012164","is_parent":true,"name":"闪存卡/U盘/移动存储","parent_cid":"0","status":"normal"},{"cid":"21","is_parent":true,"name":"居家日用/厨房餐饮/卫浴洗浴","parent_cid":"0","status":"normal"},{"cid":"50008163","is_parent":true,"name":"家纺/床品/地毯/布艺","parent_cid":"0","status":"normal"},{"cid":"2128","is_parent":true,"name":"时尚家饰/工艺品/十字绣","parent_cid":"0","status":"normal"},{"cid":"35","is_parent":true,"name":"奶粉/尿片/母婴用品","parent_cid":"0","status":"normal"},{"cid":"50005998","is_parent":true,"name":"益智玩具/童车/童床/书包","parent_cid":"0","status":"normal"},{"cid":"50008165","is_parent":true,"name":"童装/童鞋/孕妇装","parent_cid":"0","status":"normal"},{"cid":"50002766","is_parent":true,"name":"食品/茶叶/零食/特产","parent_cid":"0","status":"normal"},{"cid":"50012472","is_parent":false,"name":"保健食品","parent_cid":"0","status":"normal"},{"cid":"1201","is_parent":false,"name":"MP3/MP4/iPod/录音笔","parent_cid":"0","status":"normal"},{"cid":"1512","is_parent":false,"name":"手机","parent_cid":"0","status":"normal"},{"cid":"50012081","is_parent":false,"name":"国货精品手机","parent_cid":"0","status":"normal"},{"cid":"50008168","is_parent":true,"name":"网络服务/电脑软件","parent_cid":"0","status":"normal"},{"cid":"50002768","is_parent":true,"name":"个人护理/保健/按摩器材","parent_cid":"0","status":"normal"},{"cid":"40","is_parent":true,"name":"腾讯QQ专区","parent_cid":"0","status":"normal"},{"cid":"11","is_parent":true,"name":"电脑硬件/台式整机/网络设备","parent_cid":"0","status":"normal"},{"cid":"1101","is_parent":false,"name":"笔记本电脑","parent_cid":"0","status":"normal"},{"cid":"50008090","is_parent":true,"name":"3C数码配件市场","parent_cid":"0","status":"normal"},{"cid":"50007218","is_parent":true,"name":"办公设备/文具/耗材","parent_cid":"0","status":"normal"},{"cid":"50010728","is_parent":true,"name":"运动/瑜伽/健身/球迷用品","parent_cid":"0","status":"normal"},{"cid":"50011699","is_parent":true,"name":"运动服/运动包/颈环配件","parent_cid":"0","status":"normal"},{"cid":"50010388","is_parent":false,"name":"运动鞋","parent_cid":"0","status":"normal"},{"cid":"20","is_parent":true,"name":"电玩/配件/游戏/攻略","parent_cid":"0","status":"normal"},{"cid":"25","is_parent":true,"name":"玩具/模型/娃娃/人偶","parent_cid":"0","status":"normal"},{"cid":"50011665","is_parent":true,"name":"网游装备/游戏币/帐号/代练","parent_cid":"0","status":"normal"},{"cid":"50008907","is_parent":true,"name":"IP卡/网络电话/手机号码","parent_cid":"0","status":"normal"},{"cid":"99","is_parent":true,"name":"网络游戏点卡","parent_cid":"0","status":"normal"},{"cid":"23","is_parent":true,"name":"古董/邮币/字画/收藏","parent_cid":"0","status":"normal"},{"cid":"50008164","is_parent":true,"name":"家具/家具定制/宜家代购","parent_cid":"0","status":"normal"},{"cid":"50007216","is_parent":true,"name":"鲜花速递/蛋糕配送/园艺花艺","parent_cid":"0","status":"normal"},{"cid":"2203","is_parent":false,"name":"户外/登山/野营/涉水","parent_cid":"0","status":"normal"},{"cid":"26","is_parent":true,"name":"汽车/配件/改装/摩托/自行车","parent_cid":"0","status":"normal"},{"cid":"50004958","is_parent":true,"name":"移动/联通/小灵通充值中心","parent_cid":"0","status":"normal"},{"cid":"27","is_parent":true,"name":"装潢/灯具/五金/安防/卫浴","parent_cid":"0","status":"normal"},{"cid":"50003754","is_parent":true,"name":"网店装修/物流快递/图片存储","parent_cid":"0","status":"normal"},{"cid":"50005700","is_parent":false,"name":"品牌手表/流行手表","parent_cid":"0","status":"normal"},{"cid":"50010788","is_parent":true,"name":"彩妆/香水/美发/工具","parent_cid":"0","status":"normal"},{"cid":"1705","is_parent":false,"name":"饰品/流行首饰/时尚饰品","parent_cid":"0","status":"normal"},{"cid":"50011740","is_parent":true,"name":"流行男鞋","parent_cid":"0","status":"normal"},{"cid":"16","is_parent":true,"name":"女装/女士精品","parent_cid":"0","status":"normal"},{"cid":"34","is_parent":true,"name":"音乐/影视/明星/乐器","parent_cid":"0","status":"normal"},{"cid":"50006843","is_parent":true,"name":"女鞋","parent_cid":"0","status":"normal"},{"cid":"30","is_parent":true,"name":"男装","parent_cid":"0","status":"normal"},{"cid":"1625","is_parent":true,"name":"女士内衣/男士内衣/家居服","parent_cid":"0","status":"normal"},{"cid":"50010404","is_parent":true,"name":"服饰配件/皮带/帽子/围巾","parent_cid":"0","status":"normal"},{"cid":"50011397","is_parent":true,"name":"珠宝/钻石/翡翠/黄金","parent_cid":"0","status":"normal"},{"cid":"28","is_parent":true,"name":"ZIPPO/瑞士军刀/眼镜","parent_cid":"0","status":"normal"},{"cid":"33","is_parent":true,"name":"书籍/杂志/报纸","parent_cid":"0","status":"normal"},{"cid":"29","is_parent":true,"name":"宠物/宠物食品及用品","parent_cid":"0","status":"normal"},{"cid":"2813","is_parent":true,"name":"成人用品/避孕用品/情趣内衣","parent_cid":"0","status":"normal"},{"cid":"50011150","is_parent":false,"name":"其它","parent_cid":"0","status":"normal"},{"cid":"50011949","is_parent":true,"name":"旅游度假/打折机票/特惠酒店","parent_cid":"0","status":"normal"},{"cid":"50011972","is_parent":true,"name":"影音电器","parent_cid":"0","status":"normal"},{"cid":"1801","is_parent":true,"name":"美容护肤/美体/精油","parent_cid":"0","status":"normal"},{"cid":"50006842","is_parent":true,"name":"箱包皮具/热销女包/男包","parent_cid":"0","status":"normal"},{"cid":"50012082","is_parent":true,"name":"厨房电器","parent_cid":"0","status":"normal"},{"cid":"50012100","is_parent":true,"name":"生活电器","parent_cid":"0","status":"normal"},{"cid":"50008075","is_parent":true,"name":"演出/旅游/吃喝玩乐折扣券","parent_cid":"0","status":"normal"}]}}|0';
document.getElementById('parentCidDiv').innerHTML = '';

<?php
$cid_arr = explode('_', $cid_category);
//echo "var cid0_api = '0|".tbk_getCategoriesJson('0')."|0'\n";
?>


createCidSelect(cid0_api, '<?php echo $cid_arr[0]; ?>');

<?php

foreach($cid_arr as $k => $v) {
	if($k > 0) {
		$pid = 0;
		if($k > 1) {
			$pid = $cid_arr[$k-2];
		}
		$js_code = "var book = {};book.value = '".$cid_arr[$k-1]."';book.id = 'cid_'+book.value;\n";
		
		if($pid != 0) {
		$js_code .= "var cidDiv = document.createElement('div');\n";
		$js_code .= "cidDiv.id = 'cid_'+book.value+'_span'\n";
		$js_code .= "cidDiv.style.cssText = 'float:left;padding:0px 1px';\n";
		$js_code .= "document.getElementById('cid_' + '".$pid."' + '_span').appendChild(cidDiv);\n\n";
		}
		$js_code .= "childCidList(book, '".$pid."', '".$v."');\n\n";
		echo $js_code;
	}
	
}

?>

//创建类目下拉菜单
function createCidSelect(cidStr, iNum) {
	var cidArr = cidStr.split('|');
	var cid = cidArr[0];
	var spanId = cidArr[2];

	document.getElementById('ajaxPic').style.display = 'none';
	
	if ('' == cid) return false; 
	
	cidArr = eval('(' + cidArr[1] + ')');
	cidArr = cidArr['rsp'];
	cidArr = cidArr['item_cats'];
	
	var sel = document.createElement('SELECT');
	sel.setAttribute('name', 'cid_' + cid);
    sel.setAttribute('id', 'cid_' + cid);
	var op = document.createElement('OPTION');
	op.setAttribute('value', '0-');
	op.innerHTML = '--所有分类--';
	sel.appendChild(op);
	if ('undefined' != cidArr && '' != cidArr) {
		var i;
		for (i in cidArr) {
			if (cidArr[i]['status'] == 'normal') {
				op = document.createElement('OPTION');
				op.setAttribute('value', cidArr[i]['cid']);
				if(cidArr[i]['cid'] == iNum) {
					op.setAttribute('selected', 'true');
				}
				op.innerHTML = cidArr[i]['name'];
				sel.appendChild(op);
			}
		}
	}

	var parentId = cid;
	if ('0' == cid) {
		var selDiv = document.createElement('div');
		selDiv.style.cssText = 'float:left;padding:0px 1px';
		selDiv.appendChild(sel);
		document.getElementById('parentCidDiv').appendChild(selDiv);
		document.getElementById('cid_' + cid).onchange = function(){childCidList(this, parentId);};
		
		var cidDiv = document.createElement('div');
		cidDiv.id = 'cid_' + cid + '_span';
		cidDiv.style.cssText = 'float:left;padding:0px 1px';
		document.getElementById('parentCidDiv').appendChild(cidDiv);
	} else {
		var selDiv = document.createElement('div');
		selDiv.style.cssText = 'float:left;padding:0px 1px';
		selDiv.appendChild(sel);
		document.getElementById('cid_' + spanId + '_span').appendChild(selDiv);
		document.getElementById('cid_' + cid).onchange = function(){childCidList(this, parentId);};
		
		var cidDiv = document.createElement('div');
		cidDiv.id = 'cid_' + cid + '_span';
		cidDiv.style.cssText = 'float:left;padding:0px 1px';
		document.getElementById('cid_' + spanId + '_span').appendChild(cidDiv);
	}
}

//子类目监听函数
function childCidList(o, parentId, currentId) {

	if (!currentId) currentId = '0-';

	var cid = o.value;
	var pDiv = document.getElementById(o.id + '_span');

	if(pDiv) {
		pDiv.innerHTML = ''
	}

	if(cid != '0-') {
		document.getElementById('ajaxPic').style.display = '';
	}

	if(window.ActiveXObject) {
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		xmlHttp = new XMLHttpRequest();
	}
	var paramString = 'cid=' + cid + '&action=childCid';
	var url = <?php echo "'$ajaxURL?'";?>+paramString;
	xmlHttp.open('GET', url, false);
	xmlHttp.send(null);
	
	if (4 == xmlHttp.readyState) {
		if (200 == xmlHttp.status) {
			var response = xmlHttp.responseText;
			//alert(response);
			if ('{"rsp":{}}' != response) {
				response = cid + '|' + response + '|' + parentId;
				createCidSelect(response, currentId);
			}
			document.getElementById('ajaxPic').style.display = 'none';
		}
	}
	xmlHttp = null;
}

</script>

<?php
} // End switch($mode)
?>