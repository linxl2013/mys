<?php
define('IN_CMS', true);
session_start();
require_once 'system/library/captcha.class.php';

if(function_exists("gd_info")){
	$captcha = new captcha;
	$rs = $captcha->SetStr();
	ImageGIF($captcha->CreateImage(60,20,$rs['str']));
	$_SESSION['captcha'] = $rs['num'];

}else{
	readfile("loading.gif");
}