<?php 
if(!defined("IN_CMS")) exit("攻击行为！");

define('APP_PATH', dirname(__DIR__));
$config = include APP_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'main.php';
session_start();
define('DEBUG', FALSE);
define('CHARSET', $config['charset']);
define('APP_ID', sprintf('%x',crc32(APP_PATH.$config['name'])));
date_default_timezone_set($config['timeZone']);

/**设置自动加载文件位置*/
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APP_PATH.'/system/base'),
    realpath(APP_PATH.'/system/db'),
	realpath(APP_PATH.'/system/db/schema'),
	realpath(APP_PATH.'/system/db/schema/mysql'),
	realpath(APP_PATH.'/system/db/ar'),
	realpath(APP_PATH.'/system/caching'),
	realpath(APP_PATH.'/system/collections'),
	realpath(APP_PATH.'/models'),
    get_include_path(),
)));
/**自动加载*/
if(function_exists('spl_autoload_register')){
	spl_autoload_register('myAutoLoad');
}else{
	function __autoload($classname){
		myAutoLoad($classname);
	}
}
/**自动加载函数*/
function myAutoLoad($classname){
	//$filename = implode('/',explode('_', $classname)).'.php';
	//require_once strtolower($filename);
	if(strcmp(strtolower($classname), 'smarty')<0)
		include_once $classname . '.php';
}

/**********************************function************************************************/
include 'global.php';

/**********************************components*****************************************/
$__components = array();
$__componentConfig = $config;

function setComponent($id,$component,$merge=true){
	global $__components, $__componentConfig;
	if($component===null){
		unset($__components[$id]);
		return;
	}elseif($component instanceof IApplicationComponent){
		$__components[$id]=$component;

		if(!$component->getIsInitialized())
			$component->init();

		return;
	}elseif(isset($__components[$id])){
		if(isset($component['class']) && get_class($__components[$id])!==$component['class']){
			unset($this->_components[$id]);
			$__componentConfig[$id]=$component; //we should ignore merge here
			return;
		}

		foreach($component as $key=>$value){
			if($key!=='class')
				$__components[$id]->$key=$value;
		}
	}elseif(isset($__componentConfig[$id]['class'],$component['class']) && $__componentConfig[$id]['class']!==$component['class']){
		$__componentConfig[$id]=$component; //we should ignore merge here
		return;
	}

	if(isset($__componentConfig[$id]) && $merge)
		$__componentConfig[$id]=CMap::mergeArray($__componentConfig[$id],$component);
	else
		$__componentConfig[$id]=$component;
}

function createComponent($config){
	if(is_string($config)){
		$type=$config;
		$config=array();
	}elseif(isset($config['class'])){
		$type=$config['class'];
		unset($config['class']);
	}else
		throw new Exception('Object configuration must be an array containing a "class" element.');

	//if(!class_exists($type,false))
	//	$type=Yii::import($type,true);

	if(($n=func_num_args())>1){
		$args=func_get_args();
		if($n===2)
			$object=new $type($args[1]);
		elseif($n===3)
			$object=new $type($args[1],$args[2]);
		elseif($n===4)
			$object=new $type($args[1],$args[2],$args[3]);
		else{
			unset($args[0]);
			$class=new ReflectionClass($type);
			// Note: ReflectionClass::newInstanceArgs() is available for PHP 5.1.3+
			// $object=$class->newInstanceArgs($args);
			$object=call_user_func_array(array($class,'newInstance'),$args);
		}
	}else
		$object=new $type;

	foreach($config as $key=>$value)
		$object->$key=$value;

	return $object;
}

/** Retrieves the named application component. */
function getComponent($id,$createIfNull=true){
	global $__components, $__componentConfig;
	if(isset($__components[$id]))
		return $__components[$id];
	elseif(isset($__componentConfig[$id]) && $createIfNull){
		$config=$__componentConfig[$id];
		if(!isset($config['enabled']) || $config['enabled']){
			//Yii::trace("Loading \"$id\" application component",'system.CModule');
			unset($config['enabled']);
			$component=createComponent($config);
			$component->init();
			return $__components[$id]=$component;
		}
	}
}
function getComponents($loadedOnly=true){
	global $__components, $__componentConfig;
	if($loadedOnly)
		return $__components;
	else
		return array_merge($__componentConfig, $__components);
}

/**初始化数据库操作*/
$db = getComponent('db');
function &getDb(){
	global $db;
	return $db;
}
function db(){
	return getDb();
}

//$cache = getComponent('cache');

//载入模块文件
$smarty_config = include APP_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'smarty.php';
require APP_PATH.$smarty_config["smarty_path"];
$smarty = new MySmarty();
$smarty -> layouts			= 'layouts/main.tpl';
$smarty -> template_dir 	= APP_PATH . $smarty_config["template_dir"];
$smarty -> compile_dir 	= APP_PATH . $smarty_config["compile_dir"];
$smarty -> config_dir 		= APP_PATH . $smarty_config["config_dir"];
$smarty -> cache_dir 		= APP_PATH . $smarty_config["cache_dir"];
$smarty -> caching   		= $smarty_config["caching"];	//本地测试时关闭缓存
$smarty -> left_delimiter  	= $smarty_config["left_delimiter"];
$smarty -> right_delimiter 	= $smarty_config["right_delimiter"];
$templateUrl = "templates";
$smarty->assign("templateUrl",$templateUrl);

$siteConfig = loadSeri("site_config");
$smarty->assign("site",$siteConfig);
?>