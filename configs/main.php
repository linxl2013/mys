<?php
if (!defined('IN_CMS')) die('攻击行为！');

return array(
	'name' => 'mys',
	'language' => 'zh_cn',
	'charset' => 'utf-8',
	'timeZone' => 'Asia/Shanghai',

	'db' => array(
		'class'=>'CDbConnection',
		'connectionString'=>'mysql:host=localhost;dbname=mys',
		'emulatePrepare' => true,

		'username' => 'root',
		'password' => 'qiao',
		'charset' => 'utf8',
		'tablePrefix' => 'mys_',
		// 开启表结构缓存（schema caching）提高性能
		'schemaCachingDuration'=>3600,
	),
	
	'cache' => array(
		'class'=>'CFileCache',
		'directoryLevel'=>'2',
	),
	
	/*'xcache'=>array(
		'class'=>'CXCache',
	),*/
);