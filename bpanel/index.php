<?php
/**
  * 网站后台管理首页
  */
define('IN_CMS', true);
require_once 'include/init.php';

$smarty->layouts = false;

$_GET['frame'] = !empty($_GET['frame'])? trim($_GET['frame']):'';
switch ($_GET['frame']) {
	case 'top' :
		$adminWelcome = sprintf('欢迎你，<b>%s</b>', $_SESSION['username']);
		$smarty->assign('admin_welcome', $adminWelcome);
		$smarty->display('admin/top.tpl');
		break;
		
	case 'left' :
		$menuList = AdminMenu::getList();
		$smarty->assign('menuList', $menuList);
		$smarty->display('admin/left.tpl');
		break;
		
	case 'main' :
		$smarty->layouts = 'admin/layouts/main.tpl';
		$webinfo = array('serverName' => $_SERVER["SERVER_NAME"], 
						'serverIP' => gethostbyname($_SERVER["SERVER_NAME"]), 
						'customIP' => getRemoteIP(), 
						'serverPort' => $_SERVER["SERVER_PORT"], 
						'serverTime' => date("Y年m月d日H点i分s秒"),
						'serverTimeZone' => function_exists("date_default_timezone_get") ? date_default_timezone_get() : 'no_timezone',
						'serverSofteware' => $_SERVER["SERVER_SOFTWARE"], 
						'serverSystem' => PHP_OS,
						'phpVarsion' => PHP_VERSION, 
						'serverDir' => realpath("../"), 
						'serverMysql' => showWebInfo(function_exists("mysql_close")), 
						'serverZend' => showWebInfo(function_exists("zend_version")), 
						'serverUpfile' => get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许上传附件", 
						'serverGD' => showWebInfo(function_exists("imageline")),
						'serverZlib' => showWebInfo(function_exists('gzclose')),
						'safeMode' => showWebInfo((boolean)ini_get('safe_mode')),
						'safeModeGid' => showWebInfo((boolean)ini_get('safe_mode_gid')),
						'serverSocket' => showWebInfo(function_exists('fsockopen')),
						'serverGzip' => showWebInfo(function_exists('ob_gzhandler')),
						'charset' => CHARSET,
		);
		/*
		$gd = gd_version();
    	if($gd==0){
        	$sys_info['gd'] = 'N/A';
		}else{
        	if($gd==1)
            	$sys_info['gd'] = 'GD1';
        	else
            	$sys_info['gd'] = 'GD2';

        	$sys_info['gd'] .= ' (';
        	/* 检查系统支持的图片类型 * /
        	if($gd && (imagetypes() & IMG_JPG) > 0)
            	$sys_info['gd'] .= ' JPEG';
        	if($gd && (imagetypes() & IMG_GIF) > 0)
            	$sys_info['gd'] .= ' GIF';
        	if($gd && (imagetypes() & IMG_PNG) > 0)
            	$sys_info['gd'] .= ' PNG';
        	$sys_info['gd'] .= ')';
    	}*/
		
		;
		
		$smarty->assign('paneltitle', buildTitle(array('开始')));
		$smarty->assign('webinfo', $webinfo);
		$smarty->display('admin/start.tpl');
		break;

	case 'bottom' :
		$smarty->display('admin/bottom.tpl');
		break;

	default :
		$smarty->display('admin/index.tpl');
}
?>