<?php
/**
 * 后台栏目信息管理
 */
define('IN_CMS', true);

require_once 'include/init.php';
  
$action = !empty($_GET['action']) ? trim($_GET['action']):'';
if($_SESSION['userid'] != 1) {
	showMsg('你没有权限浏览此页。', '', 3);
}

switch ($action) {
	case 'add':
		$smarty->assign('action', '?action=insert');
		$list = ArticleCate::getList();
		$smarty->assign('list', $list);
		$smarty->assign('paneltitle', buildTitle(array('分类列表'=>'article_cate.php', '添加分类')));
		$smarty->display('admin/article_cate_edit.tpl');
		break;
		
	case 'edit':
		$id = $_GET['id'];
		$list = ArticleCate::getList();
		$row = ArticleCate::getRow($id);

		$smarty->assign('action', '?action=update&id='. $id);
		$smarty->assign('list', $list);
        $smarty->assign('row', $row);
		$smarty->assign('paneltitle', buildTitle(array('分类列表'=>'article_cate.php', '后台栏目列表')));
        $smarty->display('admin/article_cate_edit.tpl');
		break;

	case 'insert':
		$articleCate = new ArticleCate;
		$articleCate->parent_id = intval($_POST['parent_id']);
		$articleCate->name =trim($_POST['name']);
		$articleCate->sort = intval($_POST['sort']);
		$articleCate->save();
		$id = $articleCate->getPrimaryKey();
		if(empty($_POST['sort']))
			ArticleCate::model()->updateByPK($id, array('sort'=>$id));
		
		showMsg('添加分类成功。', 'article_cate.php', 3);
		break;

	case 'update':
        $id = trim($_POST['id']);
		$data = array(
			'parent_id'=> intval($_POST['parent_id']),
			'name' => trim($_POST['name']),
			'sort' => intval($_POST['sort']),
		);
		ArticleCate::model()->updateByPK($id, $data);

		showMsg("更新分类成功！", 'article_cate.php', 3);
		break;

	case 'delete':
		$id = $_GET['id'];
		if(ArticleCate::existChild($id))
			showMsg("操作失败！访菜单下有子菜单，不能删除！", 'article_cate.php', 3);

		ArticleCate::model()->deleteByPK($id);
		showMsg("操作成功！", 'article_cate.php', 3);
		break;

	default:
		$cateList = ArticleCate::getList();
		$smarty->assign('list', $cateList);
		$smarty->assign('paneltitle', buildTitle(array('分类列表')));
		$smarty->assign('panelbotton', buildButton(array('添加分类'=>'article_cate.php?action=add')));
		$smarty->display('admin/article_cate_list.tpl');
}
?>
