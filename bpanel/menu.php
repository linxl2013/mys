<?php
/**
 * 后台栏目信息管理
 */
define('IN_CMS', true);
require_once 'include/init.php';
  
$action = !empty($_GET['action']) ? trim($_GET['action']):'';
  
if($_SESSION['userid'] != 1){
	showMsg('你没有权限浏览此页。', 'index.php?frame=main', 3);
}
switch($action){
	case 'add':
		$menuList = AdminMenu::getList();
		$smarty->assign('menuList', $menuList);
		$smarty->assign('action', '?action=insert');
		$smarty->assign('paneltitle', buildTitle(array('后台栏目列表'=>'menu.php','添加栏目')));
		$smarty->display('admin/menu_edit.tpl');
		break;

	case 'edit':
		$id = intval($_GET['id']);
		$menuList = AdminMenu::getList();
		$menu = AdminMenu::getRow($id);
		
		$smarty->assign('menuList', $menuList);
		$smarty->assign('menu', $menu);
		$smarty->assign('action', '?action=update&id='. $id);
		$smarty->assign('paneltitle', buildTitle(array('后台栏目列表'=>'menu.php','添加栏目')));
		$smarty->display('admin/menu_edit.tpl');
		break;

	case 'insert':
		/*$data = array(
			'parent_id'=> intval($_POST['parent_id']),
			'name' => trim($_POST['name']),
			'url' => trim($_POST['url']),
			'sort' => intval($_POST['sort']),
		);*/
		$menu = new AdminMenu;
		//$menu->attributes = $data;
		$menu->parent_id	= intval($_POST['parent_id']);
		$menu->name			= trim($_POST['name']);
		$menu->url				= trim($_POST['url']);
		$menu->sort			= intval($_POST['sort']);
		$menu->save();
		$id = $menu->getPrimaryKey();
		if(empty($_POST['sort']))
			AdminMenu::model()->updateByPK($id, array('sort'=>$id));
		showMsg('操作成功。', 'menu.php', 3);
		break;

	case 'update':
		$id = intval($_GET['id']);
		$menu = AdminMenu::model()->findByPK($id);
		$menu->checkLocked("update", $menu->locked);
		$data = array(
			'parent_id'=> intval($_POST['parent_id']),
			'name' => trim($_POST['name']),
			'url' => trim($_POST['url']),
			'sort' => intval($_POST['sort']),
		);
		AdminMenu::model()->updateByPK($id, $data);
		showMsg("操作成功！", 'menu.php', 3);
		break;

	case 'delete':
		$id = $_GET['id'];
		$menu = AdminMenu::model()->findByPK($id);
		$menu->checkLocked("del", $menu->locked);
		$notice = $menu->delete($id);
		showMsg("操作成功！", 'menu.php', 3);
		break;

	default:
		$menuList = AdminMenu::getList();
		$smarty->assign('menuList', $menuList);
		$smarty->assign('paneltitle', buildTitle(array('后台栏目列表')));
		$smarty->assign('panelbotton', buildButton(array('添加栏目'=>'menu.php?action=add')));
		$smarty->display('admin/menu_list.tpl');
 }
?>