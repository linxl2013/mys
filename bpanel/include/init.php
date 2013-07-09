<?php
/**
 * 后台公用文件
 */
define("ADMIN_PATH", realpath(dirname(__FILE__)."/../"));
require_once ADMIN_PATH.'/../system/base.php';
$loginFilter = array("login.php","captcha.php",'uploadify.php');

if(!in_array(basename($_SERVER["PHP_SELF"]), $loginFilter)){
	Admin::isLogin();
}

$smarty->layouts = 'admin/layouts/main.tpl';

include_once 'function.php';
$smarty->assign('paneltitle', '');
$smarty->assign('panelbotton', '');

$keyword = empty($_GET['keyword']) ? '' : trim($_GET['keyword']);
$smarty->assign('keyword', $keyword);
$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
$smarty->assign('page', $page);

File::autoCleanTemp();
$smarty->assign(array("sess_name"=>session_name(), "sess_id"=>session_id()));
$smarty->assign('templateUrl', '../templates/admin');
$smarty->assign('assets', '../public/admin');
?>