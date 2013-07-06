<?php

/**
 * This is the model class for table "{{admin}}".
 */
class Admin extends CActiveRecord
{
	public static $salt='';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{admin}}';
	}
	
	public static function getRow($id){
		return self::model()->findByPK($id);
	}
	
	public static function getList($keyword='', $order='ASC'){
		$criteria = new CDbCriteria;
		$criteria->order = 'id '.$order;
		if($keyword){
			$criteria->condition = 'locate(:Username, username)>0';
			$criteria->params = array(':Username' => $keyword);
		}
		
		$rows = self::model()->findAll($criteria);
		$list = array();
		foreach($rows as $item){
			$list[] = $item;
		}
		return $list;
	}
	
	// 检查是否有权限操作
	public static function chkAction($right){
		/*if(!in_array($right,explode(',',$_SESSION['siteAdminMenuList'])) && $_SESSION['siteAdminId'] != 1){
            showMsg('你没有执行权限','javascript:history.back()',3);
            exit();
		}*/
	}

	/**
	 * 是否登录
	 */
	public static function isLogin() {
		if (empty($_SESSION['userid'])) {
			showMsg('请先登陆。',"login.php",2,'100px',0,"如果浏览器没有自动跳转，请点击“立即跳转”按钮");
			exit();
		}
	}
	
	/**
	 * 登出
	 */
	public static function logout() {
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['action_list']);
	}
	
	/**
	 * 登录检查
	 * return int 登录状态：1--登录成功，2--密码错误，3--用户名不存在， 4--被锁定
	 */
	public static function chkLogin($username, $password){
		$admin = self::model()->find('username=:Username', array(':Username'=>$username));
		//test($admin->attributes);
		if($admin){
			if($admin->locked == 1){
				self::model()->updateByPK($admin->id, array('failed_logins'=>$admin->failed_logins+1));
				return '4';
			}elseif(self::validatePassword($password, $admin->password, $admin->salt)){
				$_SESSION['userid'] = $admin->id;
				$_SESSION['username'] = $admin->username;
				$_SESSION['password'] = $admin->password;
				$_SESSION['action_list'] = $admin->action_list;
				$ip = getRemoteIP();
				self::model()->updateByPK($admin->id, array('last_login'=>time(), 'failed_logins'=>0, 'last_ip'=>$ip));
				return '1';
			}else{
				self::model()->updateByPK($admin->id, array('failed_logins'=>$admin->failed_logins+1));
				return '2';
			}
		}else{
			return '3';
		}
	}
	
	public static function validatePassword($password,$dbPassword,$salt){
		return md5($salt . $password) === $dbPassword;
	}
   
	public static function hashPassword($password, $salt=''){
		if(!$salt)
			$salt = time();
		self::$salt = $salt;
		return md5($salt . $password);
	}
	
	/**检查用户名是否存在*/
	public static function existUserName($username){
		return self::model()->count('username=:Username', array(':Username'=>$username)) >0 ? true : false;
	}
}