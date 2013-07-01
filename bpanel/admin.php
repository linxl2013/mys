<?php
  /**
   * 管理员信息类
   */
  define('IN_CMS', true);
  require_once 'include/init.php';
  	
  $adminDB = loadClass("admin",false,1);
  $adminDB->chkAction('adminSet');
  
  $action = !empty($_GET['action']) ? $_GET['action']:'';
  
  switch ($action) {
	case 'insert':
		if ('' == trim($_POST['user_name'])) {
			showMsg('登录名不能为空。','',3);
		}

		if (('' == trim($_POST['password'])) || ('' == trim($_POST['confirm_password']))) {
			showMsg('密码不能为空。','',3);
		}

		if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
			showMsg('两次输入的密码不一致。','',3);
		}

		$user_name = trim($_POST['user_name']);

		$tmp = $adminDB->existUserName($user_name);
		if ($tmp) {
			showMsg('此用户名已经被使用，请使用其他用户名。','',3);
		}

		$actionList_ary = $_POST['actionList'];
		if (count($actionList_ary) > 0) {
			$actionList = implode(',', $actionList_ary);
		} else {
			$actionList = '';
		}

		$password = $adminDB->hashPassword(trim($_POST['password']));

		$admin = array(
			'user_name'=> $user_name,
			'password' => $password,
		);
		$adminDB->insert($admin);
		showMsg($lang['success'], 'admin.php', 3);
		break;

	case 'del':
		$user_id = trim($_GET['user_id']);
		if ('1' == $user_id) {
			showMsg('该管理员不能删除！', 'admin.php', 3);
		}
		$adminDB->delete(array('user_id' => $user_id));
		showMsg($lang['success'], 'admin.php', 3);
		break;


	case 'update':
		$user_id = trim($_GET['user_id']);
		if ('1' == $user_id && trim($_SESSION['user_id']) != 1) {
			showMsg('你不能编辑此管理员资料！', 'admin.php', 3);
		}
		
		$actionList_ary = $_POST['actionList'];
		if ($actionList_ary) {
			$actionList = implode(',', $actionList_ary);
		} else {
			$actionList = '';
		}


		if (('' != trim($_POST['password'])) || ('' != trim($_POST['confirm_password']))) {
			if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
				showMsg('两次输入的密码不一致。','',3);
			}
			$password = $adminDB->hashPassword(trim($_POST['password']));

			$admin = array(
				'password' => $password,
			);
			$adminDB->update($admin,array("user_id"=>$user_id));
		} else {
		}
		showMsg($lang['success'], 'admin.php', 3);
		break;

	case 'add':
		$smarty->assign('post','?action=insert');
		$smarty->assign('action','insert');
		$smarty->display('admin/admin_edit.tpl');

		break;
	case 'edit':
		$user_id = trim($_GET['user_id']);
		if ('1' == $user_id && trim($_SESSION['user_id']) != 1) {
			showMsg('你不能编辑此管理员资料！', 'admin.php', 3);
		}
		$admin = $adminDB->getAdminUserInfo($user_id);

		if ($admin) {
			$smarty->assign('post','?action=update&user_id='. $user_id);
			$smarty->assign('action','edit');$smarty->assign('admin',$admin);
			$smarty->display('admin/admin_edit.tpl');
			
		} else {
			
		}

		break;
	default:
		$adminList = $adminDB->getAdminUserList();
        $smarty->assign('adminList',$adminList);
		$smarty->display('admin/admin_list.tpl');
  }
?>