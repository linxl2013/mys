<?php
/**
 * 管理员信息类
 */
define('IN_CMS', true);
require_once 'include/init.php';

//$adminDB = loadClass("admin",false,1);
//$adminDB->chkAction('adminSet');
  
$action = !empty($_GET['action']) ? $_GET['action']:'';
  
switch ($action) {
	case 'add':
		$smarty->assign('row', array());
		$smarty->assign('action','?action=insert');
		$smarty->assign('paneltitle', buildTitle(array('管理员列表'=>'admin.php', '添加管理员')));
		$smarty->display('admin/admin_edit.tpl');
		break;
	case 'edit':
		$id = trim($_GET['id']);
		if ('1' == $id && trim($_SESSION['userid']) != 1) {
			showMsg('你不能编辑此管理员资料！', 'admin.php', 3);
		}
		$admin = Admin::getRow($id);

		$smarty->assign('action', '?action=update&id='. $id);
		$smarty->assign('row', $admin);
		$smarty->assign('paneltitle', buildTitle(array('管理员列表'=>'admin.php', '编辑管理员')));
		$smarty->display('admin/admin_edit.tpl');
		break;
	case 'insert':
		if ('' == trim($_POST['username']))
			showMsg('登录名不能为空。','',3);

		if (('' == trim($_POST['password'])) || ('' == trim($_POST['confirm_password'])))
			showMsg('密码不能为空。','',3);

		if (trim($_POST['password']) != trim($_POST['confirm_password']))
			showMsg('两次输入的密码不一致。','',3);

		$username = trim($_POST['username']);

		if (Admin::existUserName($username))
			showMsg('此用户名已经被使用，请使用其他用户名。','',3);

		/*$actionList_ary = $_POST['actionList'];
		if (count($actionList_ary) > 0)
			$actionList = implode(',', $actionList_ary);
		else
			$actionList = '';*/

		$password = Admin::hashPassword(trim($_POST['password']));
		
		$admin = new Admin;
		$admin->username = $username;
		$admin->password = $password;
		$admin->email = trim($_POST['email']);
		$admin->salt = Admin::$salt;
		$admin->add_time = time();
		$admin->save();
		showMsg('管理员添加成功。', 'admin.php', 3);
		break;

	case 'update':
		$id = trim($_GET['id']);
		if ('1' == $id && trim($_SESSION['user_id']) != 1) {
			showMsg('你不能编辑此管理员资料！', 'admin.php', 3);
		}
		
		/*$actionList_ary = $_POST['actionList'];
		if ($actionList_ary) {
			$actionList = implode(',', $actionList_ary);
		} else {
			$actionList = '';
		}*/
		
		$admin = array();
		if (('' != trim($_POST['password'])) || ('' != trim($_POST['confirm_password']))) {
			if (trim($_POST['password']) != trim($_POST['confirm_password']))
				showMsg('两次输入的密码不一致。','',3);
			else
				$admin['password'] = Admin::hashPassword(trim($_POST['password']));
				$admin['salt'] = Admin::$salt;
		}
		
		$admin['email'] =  trim($_POST['email']);
		Admin::model()->updateByPK($id, $admin);

		showMsg('管理员更新成功。', 'admin.php', 3);
		break;

	case 'delete':
		$id = $_GET['id'];
		Admin::model()->deleteByPK($id, 'id<>:ID', array(':ID'=>1));
		showMsg('管理员删除成功。', 'admin.php', 3);
		break;

	default:
		$list = Admin::getList($keyword);
        $smarty->assign('list', $list);
		$smarty->assign('paneltitle', buildTitle(array('管理员列表')));
		$smarty->assign('panelbotton', buildButton(array('添加管理员'=>'admin.php?action=add')));
		$smarty->display('admin/admin_list.tpl');
}
?>