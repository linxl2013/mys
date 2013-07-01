<?php
/**
 * 后台网站信息管理
 */
define('IN_CMS', true);
require_once 'include/init.php';
  

Admin::chkAction('siteSet');
$action = !empty($_GET['action']) ? valConvert(trim($_GET['action'])):'';

switch ($action) {
	case'update':
		$setting['sitename']		= $_POST['sitename'];
		$setting['siteurl']			= $_POST['siteurl'];
		$setting['title']				= $_POST['title'];
		$setting['key']				= $_POST['key'];
		$setting['desc']				= $_POST['desc'];
		$setting['icp']				= $_POST['icp'];
		$setting['perpage']		= $_POST['perpage'];
		$setting['email']			= $_POST['email'];
		$setting['qq']				= $_POST['qq'];
		$setting['phone']			= $_POST['phone'];
		$setting['contact']			= $_POST['contact'];
		$setting['copyright']		= $_POST['copyright'];

		$config_path = APP_PATH .'/./configs/site_config.txt';//配置文件地址
		if(file_put_contents($config_path, serialize($setting))){
			showMsg('网站配置保存成功', 'settings.php', 3);
		}
		break;

	default:
		$setting = loadSeri('site_config');
		$setting = setSripSlashes($setting);

		$setting['copyright'] = str_replace('\"', '"', $setting['copyright']);
		$setting['counter_code'] = !empty($setting['counter_code']) ? str_replace('\"', '"', $setting['counter_code']):'';
		$setting['zxkf'] = !empty($site['counter_code']) ? str_replace('\"', '"', $setting['zxkf']):'';
		$smarty->assign('setting', $setting);
		$smarty->assign('paneltitle', buildTitle(array('网站配置')));
		$smarty->display('admin/setting.tpl');
 }
?>