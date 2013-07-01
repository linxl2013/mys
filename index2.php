<?php 
define('IN_CMS', TRUE);
require_once 'system/base.php';


//$query = $db->createCommand('select * from {{admin}}')->queryAll();
//var_dump($query);

//$admin = new Admin;
//$admin =Admin::model()->findByPK(1);
//var_dump($admin->attributes);

$data = array();
$data['total'] = Admin::model()->count();
			
$criteria = new CDbCriteria;
$criteria->order = 'id ASC';
$criteria->limit = 100;
$criteria->offset = 0;
$data['rows'] = Admin::model()->findAll($criteria);

var_dump($data['total']);

