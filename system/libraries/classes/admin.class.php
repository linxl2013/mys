<?php
if(!defined('IN_CMS')) die('黑客攻击');

/**
 * 管理员信息类
 */  
class admin extends model{
	protected $table = 'admin';
	public $salt = '';

	public function insert($data){
		$data['salt'] = $this->salt;
		$this->db->insert($this->table, $data);
	}
	
	public function update($data,$where){
		$data['salt'] = $this->salt;
		$this->db->update($this->table, $data,$where);
	}
	
	public function existUserName($userName){
		$this->db->select('id');
		$query = $this->db->get_where($this->table, array('username' => $userName), 1);
		if($query->num_rows > 0){
			return true;
		}
		return false;
	}

	// 是否登录
	public function isLogin() {
		if (empty($_SESSION['userid'])) {
			showMsg('请先登陆。',"login.php",2,'100px',0,"如果浏览器没有自动跳转，请点击“立即跳转”按钮");
			exit();
		}
	}

	// 登出
	public function logout() {
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['action_list']);
	}

	// 检查是否有权限操作
	public function chkAction($right){
		/*if(!in_array($right,explode(',',$_SESSION['siteAdminMenuList'])) && $_SESSION['siteAdminId'] != 1){
            showMsg('你没有执行权限','javascript:history.back()',3);
            exit();
		}*/
	}

	// 登录检查
	// return int 登录状态：1--登录成功，2--密码错误，3--用户名不存在， 4--被锁定
	public function chkLogin($username, $password){
		$this->db->where('username', $username);
		$query = $this->db->get($this->table);
		$row = $query->row_array();
		if(!empty($row)){
			if($row["locked"] == 1){
				$this->db->update($this->table, array('failed_logins'=>$row["failed_logins"] + 1),array('id'=> $row["id"]));
				return '4';
			}elseif($this->validatePassword($password,$row["password"],$row["salt"])){
				$_SESSION['userid'] = $row["id"];
				$_SESSION['username'] = $row["username"];
				$_SESSION['password'] = $row["password"];
				$_SESSION['action_list'] = $row["action_list"];
				$last_login = time();
				$ip = getRemoteIP();
				$this->db->update($this->table, array('last_login'=>$last_login,'failed_logins'=>0,'last_ip'=>$ip),array('id'=>$row["id"]));
				return '1';
			}else{
				$this->db->update($this->table, array('failed_logins'=>$row["failed_logins"] + 1),array('id'=>$row["id"]));
				return '2';
			}
		}else{
			return '3';
		}
	}
	
	public function getList(){
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	public function getRow($id){
		$query = $this->db->get_where($this->table, array('id' => $id), 1);
   		return $query->row_array();
	}
   
	public function validatePassword($password,$dbPassword,$salt){
		return $this->hashPassword($password,$salt) === $dbPassword;
	}
   
	protected function hashPassword($password,$salt=''){
		if(!$salt)
			$salt = time();
		$this->salt = $salt;
		return md5($salt.$password);
	}
}
?>