<?php
  /**
   * 后台栏目信息管理
   */
  define('IN_CMS', true);
  
  require_once 'include/init.php';
  
  $action = !empty($_GET['action']) ? trim($_GET['action']):'';
  if ($_SESSION['user_id'] != 1) {
	showMsg('你没有权限浏览此页。', '', 3);
  }
  $articleCateObject  = loadAppClass('article_cate',false,1);
  $fileObject  = loadAppClass('file',false,1);
  switch ($action) {
	case 'add':
        $smarty->assign('action', '?action=insert');
        $cateList = $articleCateObject->getCateList();
        $smarty->assign('cateList', $cateList);
        $smarty->display('admin/article_cate_edit.tpl');
		break;
	case 'edit':
        $cate_id = $_GET['cate_id'];
        $cateList = $articleCateObject->getCateList();
        $smarty->assign('cateList', $cateList);
        $cate = $articleCateObject->getCate($cate_id);
  		$images = $fileObject->getFilesByType($cate['cate_id'],"article_cate",'image',false);
		if(!empty($images)){
			$file_id = array();
			foreach($images as $image){
				$file_id[] =$image["file_id"];
			}
			$file_id = implode(',', $file_id);
			$smarty->assign('file_id', $file_id);
		}
		$smarty->assign('images', $images);

		$smarty->assign('action', '?action=update&cate_id='. $cate_id);
        $smarty->assign('cate', $cate);
        $smarty->display('admin/article_cate_edit.tpl');
		break;

	case 'insert':
		$data = array(
			'parent_id'=> intval($_POST['parent_id']),
			'cate_name' => trim($_POST['cate_name']),
			'cate_en_name' => trim($_POST['cate_en_name']),
			'link' => trim($_POST['link']),
			'link_name' => trim($_POST['link_name']),
			'sort_order' => intval($_POST['sort_order']),
		);
		$articleCateObject->insert($articleCateObject->cateTable,$data);
		$cate_id = $articleCateObject->insert_id();
		$fileObject->saveImage("image1",$cate_id,"article_cate");
		showMsg('操作成功。', 'article_cate.php', 3);
		break;


	case 'update':
        $cate_id = trim($_GET['cate_id']);
		$data = array(
			'parent_id'=> intval($_POST['parent_id']),
			'cate_name' => trim($_POST['cate_name']),
			'cate_en_name' => trim($_POST['cate_en_name']),
			'link' => trim($_POST['link']),
			'link_name' => trim($_POST['link_name']),
			'sort_order' => intval($_POST['sort_order']),
		);

		$articleCateObject->update($articleCateObject->cateTable,$data,array("cate_id"=>$cate_id));
		$fileObject->saveImage("image1",$cate_id,"article_cate");
		showMsg("操作成功！", 'article_cate.php', 3);
		break;

	case 'del':
		$cate_id = $_GET['cate_id'];
		 $notice = $articleCateObject->delete($articleCateObject->cateTable,array('cate_id' => $cate_id));
		 switch ($notice){
		 	case 0:
		 		showMsg("操作成功！", 'article_cate.php', 3);
		 	case 1:
		 		showMsg("操作失败！菜单已经锁定，不能删除！", 'article_cate.php', 3);
		 	case 2:
		 		showMsg("操作失败！访菜单下有子菜单，不能删除！", 'article_cate.php', 3);
		 }
		if($articleCateObject)
		showMsg("操作成功！", 'article_cate.php', 3);
		break;

	default:
		$cateList = $articleCateObject->getCateList();
		$smarty->assign('cateList', $cateList);
        $smarty->display('admin/article_cate_list.tpl');		
  }
?>
