<?php
/**
  * 后天登陆页面
  */
define('IN_CMS', true);
require_once 'include/init.php';

if('POST' == $_SERVER['REQUEST_METHOD']){
	$username = trim($_POST['adminaccount']);
	$password = trim($_POST['adminpassword']);
	$captcha = trim($_POST['captcha']);
	if('' == $username || '' == $password || '' == $captcha){
		showMsg('登录名和密码以及验证码都必须填写。','',3);
	}

	if($captcha != $_SESSION['captcha']|| $_SESSION['captcha']==''){
		showMsg('验证码错误。','login.php',3);
	}
	
	$loginStatus = Admin::chkLogin($username,$password);

	$url = 'login.php';
	switch($loginStatus){
		case '1':
			$trip = '登陆成功!';
			$url = 'index.php';
			break;

		case '2': $trip = '登陆失败，请检查密码是否输入正确。'; break;
		case '3': $trip = '登陆失败，请检查该管理员是否存在。'; break;
		case '4': $trip = '登陆失败，该管理员已被锁定。'; break;
	}
	showMsg( $trip, $url, 3);
}else{
	$smarty->layouts = false;
	$smarty->display('admin/login.tpl');
}
?>