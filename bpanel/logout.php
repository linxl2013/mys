<?php
/**
  * 后台管理员退出管理
  */
define('IN_CMS', true);
require_once 'include/init.php';

Admin::logout();
showMsg('您已成功退出', 'login.php', 3);
?>