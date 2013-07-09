<?php
/**
 * 后台文章信息管理
 */
define('IN_CMS', true);
require_once 'include/init.php';

$action = !empty($_GET['action']) ? trim($_GET['action']) : '';
$cate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);

switch ($action) {
	case 'add' :
		$cateList = ArticleCate::getList();
		$smarty->assign('cateList', $cateList);
		$smarty->assign('row', array('cate_id'=>$cate_id));
		$smarty->assign('action', '?action=insert&cate_id='.$cate_id);
		$smarty->assign('paneltitle', buildTitle(array('文章列表'=>'article.php', '添加文章')));
		$smarty->display('admin/article_edit.tpl');
		break;

	case 'edit' :
		$id = intval($_GET['id']);
		$cateList = ArticleCate::getList();
		$row = Article::getRow($id);
		
		/*
		$images = $fileObject->getFilesByType($article_id,$type,'image',false);
		if(!empty($images)){
			$file_id = array();
			foreach($images as $image){
				$file_id[] =$image["file_id"];
			}
			$file_id = implode(',', $file_id);
			$smarty->assign('file_id', $file_id);
		}
		//$recommend
		$smarty->assign('images', $images);
		*/
		$smarty->assign('cateList', $cateList);
		$smarty->assign('row', $row);
		$smarty->assign('paneltitle', buildTitle(array('文章列表'=>'article.php', '编辑文章')));
		$smarty->assign('action', '?action=update&id='.$id.'&cate_id='.$cate_id);
		$smarty->display('admin/article_edit.tpl');
		break;
	
	case 'update' :
		$id = intval($_POST['id']);
		empty($_POST["article_id"])?showMsg("编辑失败，文章ID错误！", $theFile.'?article_id='.$_POST["article_id"], 3):'';
		empty($_POST["title"])?showMsg("编辑失败，文章标题不能为空！",  $theFile.'?article_id='.$_POST["article_id"], 3):'';
		empty($_POST["detail"])?showMsg("编辑失败，请填写文章内容！",  $theFile.'?article_id='.$_POST["article_id"], 3):'';
		if(isset($_POST["cate_id"]) && empty($_POST["cate_id"])){
			showMsg("添加失败，请选择分类！", $theFile.'?action=add', 3);
		}
		if(empty($_POST["cate_id"])){
			$cate_id =  $topCateId;
		}else{
			$cate_id =  $_POST["cate_id"];
		}
		if(empty($_POST["cate_id"])){
			$cate_id =  $topCateId; 
		}else{
			$cate_id =  $_POST["cate_id"];
		}
		$theFile="article.php?cate_id=".$cate_id;
		$data = array(
			'cate_id' 		=> $cate_id,
			'title' 			=> trim($_POST["title"]), 
			//'en_title' 		=> trim($_POST["en_title"]),
			'detail' 		=> trim($_POST["detail"]),
			'summary' 		=> trim($_POST["summary"]),
			'source' 		=> trim($_POST["source"]),
			'edit_time' 	=> time(),
			'pub_time' 		=> strtotime($_POST["pub_time"]),
			'seo_title'		=> trim($_POST["seo_title"]),
			'seo_keyword'	=> trim($_POST["seo_keyword"]),
			'seo_desc'		=> trim($_POST["seo_desc"]),
			'sort_order' 	=> $_POST["sort_order"],
			'publisher'		=>$_SESSION['user_name']
		);
		if(!empty($_POST["ding"])){
			$data['ding'] = 1;
		}else{
			$data['ding'] = 0;
		}
		if(!empty($_POST["mark"])){
			$data['mark'] = $_POST["mark"];
		}else{
			$data['mark'] = 0;
		}
		
		File::saveImage('image1',$id,'article');
		//$fileObject->saveImage("image1",$_POST["article_id"],$type);
		//$fileObject->saveImage("image2",$_POST["article_id"],$type);
		$articleObject->update($data,array('article_id'=>$_POST["article_id"]));
		$searchRow = $searchObject->getRow($_POST["article_id"],$type);
		if(!empty($searchRow)){
			$searchData = array(
					"title"=>trim($_POST["title"]),
					"summary"=>trim($_POST["summary"]),
			);
			$searchObject->update($searchData,array('type_id'=>$_POST["article_id"],"type"=>$type));
		}else{
			$cate = $articleCateObject->getCate($cate_id);
			$searchData = array(
					"type_id"=>$_POST["article_id"],
					"cate_id"=>$cate_id,
					"cate_name"=>$cate["cate_name"],
					"title"=>trim($_POST["title"]),
					"summary"=>trim($_POST["summary"]),
					"link"=>"$theFile?id=".$_POST["article_id"],
					"cate_link"=>"",
					"type"=>$type
			);
			$searchObject->insert($searchData);
		}
		showMsg($lang['success'],  $theFile, 3);
		
		break;
	case 'insert' :
		empty($_POST["title"])?showMsg("添加失败，文章标题不能为空！", $theFile . '?action=add', 3):'';
		empty($_POST["detail"])?showMsg("添加失败，请填写文章内容！", $theFile.'?action=add', 3):'';
		if(isset($_POST["cate_id"]) && empty($_POST["cate_id"])){
			showMsg("添加失败，请选择分类！", $theFile.'?action=add', 3);
		}
		if(empty($_POST["cate_id"])){
			$cate_id =  $topCateId;
		}else{
			$cate_id =  $_POST["cate_id"];
		}
		$theFile="article.php?cate_id=".$cate_id;
		//提取编辑框里的内容中自行上传的图片的路径
		/*$detail = str_ireplace('\\', '', $_POST['detail']);
		$editorFileStr = getImageSrc($detail, trim($_POST['tmpEditorFileStr']));*/
		$data = array(
			'cate_id' 		=> $cate_id,
			'title' 			=> trim($_POST["title"]), 
			//'en_title' 		=> trim($_POST["en_title"]),
			'source' 		=> trim($_POST["source"]),
			'summary' 		=> trim($_POST["summary"]),
			'detail' 		=> trim($_POST["detail"]),
			'add_time' 		=> time(),
			'pub_time' 		=> strtotime($_POST["pub_time"]),
			'seo_title'		=> trim($_POST["seo_title"]),
			'seo_keyword'	=> trim($_POST["seo_keyword"]),
			'seo_desc'		=> trim($_POST["seo_desc"]),
			'sort_order' 	=> $_POST["sort_order"],
			'type' => $type
		);
		if(!empty($_POST["ding"])){
			$data['ding'] = 1;
		}
		if(!empty($_POST["mark"])){
			$data['mark'] = $_POST["mark"];
		}
		$articleObject->insert($data);
		$article_id = $articleObject->insert_id();
		if(empty($_POST["sort_order"])){
			$articleObject->update(array("sort_order"=>$article_id),array('article_id'=>$article_id));
		}
		$cate = $articleCateObject->getCate($cate_id);
		$searchData = array(
				"type_id"=>$article_id,
				"cate_id"=>$cate_id,
				"cate_name"=>$cate["cate_name"],
				"title"=>trim($_POST["title"]),
				"summary"=>trim($_POST["summary"]),
				"link"=>"$theFile?id=".$article_id,
				"cate_link"=>"",
				"type"=>$type
				);
		$searchObject->insert($searchData);
		$fileObject->saveImage("image1",$article_id,$type);
		$fileObject->saveImage("image2",$article_id,$type);
		showMsg($lang['success'],  $theFile, 3);
		break;
		
	case 'delete' :
		$id=is_array($_GET['id']) ? $_GET['id'] : intval($_GET['id']);
		if(empty($_GET['id'])){
			showMsg('没有选中项目。',  'article.php?cate_id='.$cate_id, 3);
		}
		$rel = Article::model()->deleteByPK($id);
		if($rel)
			showMsg('删除文章成功。',  'article.php?cate_id='.$cate_id, 3);
		else
			showMsg('删除文章失败。',  'article.php?cate_id='.$cate_id, 3);
		break;
		
	default :
		$limit = $perpage;
		$offset=($page-1)*$limit;

		$cate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);

		$count = Article::getCount($cate_id, $keyword);
		$articleList = Article::getList ($cate_id, $keyword, $limit, $offset);
		$list = array();
		foreach($articleList as $val) {
			$attributes = $val->attributes;
			$attributes['cate_name'] = $val->article_cate->name;
			$list[] = $attributes;
		}
		
		$pager = new Pager('article.php',$count,$page,$limit);
		$pager->queryString(array("cate_id"=>$cate_id,"keyword"=>$keyword));
		$pageBar = $pager->pageString();

		$smarty->assign('list', $list);
		$smarty->assign('pageBar', $pageBar);
		$smarty->assign('paneltitle', buildTitle(array('文章列表')));
		$smarty->assign('panelbotton', buildButton(array('添加文章'=>'article.php?action=add&cate_id='.$cate_id)));
		$smarty->display('admin/article_list.tpl');
		break;
}
?>