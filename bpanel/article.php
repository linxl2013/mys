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
		
		$images = File::getFilesByType($id,'article');
		$smarty->assign('image1', $images);
		
		$smarty->assign('cateList', $cateList);
		$smarty->assign('row', $row);
		$smarty->assign('paneltitle', buildTitle(array('文章列表'=>'article.php', '编辑文章')));
		$smarty->assign('action', '?action=update&id='.$id.'&cate_id='.$cate_id);
		$smarty->display('admin/article_edit.tpl');
		break;

	case 'update' :
		$id = empty($_POST['id']) ? showMsg('编辑失败，文章ID错误！', 'article.php', 3) : intval($_POST['id']);
		$title = empty($_POST['title']) ? showMsg('编辑失败，文章标题不能为空！', 'artocle.php?action=edit&id='.$id, 3) : trim($_POST['title']);
		$detail = empty($_POST['detail']) ? showMsg('编辑失败，请填写文章内容！', 'artocle.php?action=edit&id='.$id, 3) : trim($_POST['detail']);
		$cate_id = empty($_POST['cate_id']) ? showMsg("添加失败，请选择分类！", 'artocle.php?action=edit&id='.$id, 3) : intval($_POST['cate_id']);

		$data = array(
			'cate_id' 		=> $cate_id,
			'title' 			=> $title, 
			'detail'			=> $detail,
			'summary'		=> trim($_POST['summary']),
			'source'			=> trim($_POST['source']),
			'edit_time' 	=> time(),
			'pub_time' 	=> strtotime($_POST['pub_time']),
			'keyword'		=> trim($_POST['keyword']),
			'description'		=> trim($_POST['description']),
			'sort' 			=> $_POST['sort'],
			'publisher'		=> $_SESSION['username'],
			'ding'			=> empty($_POST['ding']) ? 0 : 1,
			'mark'			=> empty($_POST['mark']) ? 0 : 1,
		);
		Article::model()->updateByPK($id, $data);
		File::saveImage('image1',$id,'article');

		showMsg('文章更新成功。', 'article.php?cate_id=' . $cate_id, 3);
		break;

	case 'insert' :
		$title = empty($_POST['title']) ? showMsg('编辑失败，文章标题不能为空！', 'artocle.php?action=edit&id='.$id, 3) : trim($_POST['title']);
		$detail = empty($_POST['detail']) ? showMsg('编辑失败，请填写文章内容！', 'artocle.php?action=edit&id='.$id, 3) : trim($_POST['detail']);
		$cate_id = empty($_POST['cate_id']) ? showMsg("添加失败，请选择分类！", 'artocle.php?action=edit&id='.$id, 3) : intval($_POST['cate_id']);

		//提取编辑框里的内容中自行上传的图片的路径
		/*$detail = str_ireplace('\\', '', $_POST['detail']);
		$editorFileStr = getImageSrc($detail, trim($_POST['tmpEditorFileStr']));*/

		$article = new Article;
		$article->cate_id 		= $cate_id;
		$article->title 			= $title; 
		$article->detail			= $detail;
		$article->summary	= trim($_POST['summary']);
		$article->source		= trim($_POST['source']);
		$article->	publisher	= $_SESSION['username'];
		$article->add_time 	= time();
		$article->edit_time 	= time();
		$article->pub_time 	= strtotime($_POST['pub_time']);
		$article->keyword	= trim($_POST['keyword']);
		$article->description	= trim($_POST['description']);
		$article->sort 			= $_POST['sort'];
		$article->ding			= empty($_POST['ding']) ? 0 : 1;
		$article->mark			= empty($_POST['mark']) ? 0 : 1;
		$article->save();
		$id = $article->getPrimaryKey();
		if(empty($_POST['sort'])){
			Article::model()->updateByPK($id,array('sort'=>$id));
		}

		File::saveImage('image1',$id,'article');
		showMsg('添加文章成功。',  'article.php?cate_id=' . $cate_id, 3);
		break;

	case 'delete' :
		$id=is_array($_GET['id']) ? $_GET['id'] : intval($_GET['id']);
		if(empty($_GET['id'])){
			showMsg('没有选中项目。',  'article.php?cate_id='.$cate_id, 3);
		}
		File::delFileByType($id,'article');
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