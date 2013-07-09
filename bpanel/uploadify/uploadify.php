<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
define('IN_CMS', true);
define('APP_PATH', dirname(dirname(__DIR__)));
//require_once '../include/init.php';
$session_name = session_name();
/*if (!isset($_POST[$session_name])) {
	$result['error']  = 11;
	$result['msg'] = "您没有权限上传，请重新登录！";
	echo json_encode($result);
	exit;
} else {
	session_id($_POST[$session_name]); // 将当前的SessionId设置成客户端传递回来的SessionId
	print_r($_SESSION);exit;
	if(empty($_SESSION['user_id'])){
		$result['error']  = 11;
		$result['msg'] = "您没有权限上传，请重新登录！";
		echo json_encode($result);
		exit;
	}
}*/
// Define a destination
$targetFolder = 'uploads/temp'; // Relative to the root
$result = array('error'=>0,"msg"=>'','path'=>'','file_id'=>'','file_name'=>'','save_name'=>'','extension'=>'','multi'=>false);
if(!empty($_POST['multi'])){
	$result["multi"] = true;
}
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = APP_PATH ."/". $targetFolder;
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','bmp','rar','zip','7z','docx','doc','pptx','ppt','xlsx','xls','pdf','txt'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array($fileParts['extension'] = strtolower($fileParts['extension']),$fileTypes)) {
		switch ($_FILES['Filedata']['error']) {
			case UPLOAD_ERR_OK :
				$saveName = uniqid()."_".rand(10,99);
				clearstatcache();
				if(!is_dir($targetPath)){
					$result['error']  = 10;
					$result['msg'] = $targetPath."目录不存在请手动创建。";
					break;
				}
				$targetFile =  rtrim($targetPath,'/') . '/' .$saveName. '.' . $fileParts['extension'];
				move_uploaded_file($tempFile,$targetFile);
				if(!empty($_POST["createThumb"])){
					$thumbName = rtrim($targetPath,'/') . '/' .$saveName. '_thumb.' . $fileParts['extension'];
					createThumb($targetFile, $thumbName,'', 67, 80);
				}
				$result['save_name']  = $saveName;
				$result['extension']  = $fileParts['extension'];
				$result['file_name']  = $fileParts['filename'];
				$result['msg'] = "上传成功。";
				break;
			case UPLOAD_ERR_INI_SIZE  :
				$result['error']  = UPLOAD_ERR_INI_SIZE;
				$result['msg'] = "你所上传的文件大小已经超过了".ini_get("upload_max_filesize")."。";
				break;
			case UPLOAD_ERR_FORM_SIZE :
				$result['error']  = UPLOAD_ERR_FORM_SIZE;
				$result['msg'] = " 上传文件的大小超过了表单“MAX_ FILE_SIZE”限制值。";
				break;
			case UPLOAD_ERR_PARTIAL :
				$result['error']  = UPLOAD_ERR_PARTIAL;
				$result['msg'] = " 文件仅部分上传，不完整。";
				break;
			case UPLOAD_ERR_NO_FILE :
				$result['error']  = UPLOAD_ERR_NO_FILE;
				$result['msg'] = "没有文件被上传。";
				break;
			case UPLOAD_ERR_NO_TMP_DIR :
				$result['error']  = UPLOAD_ERR_NO_TMP_DIR;
				$result['msg'] = "服务器上没有保存上传文件的临时目录。";
				break;
			case UPLOAD_ERR_CANT_WRITE :
				$result['error']  = UPLOAD_ERR_CANT_WRITE;
				$result['msg'] = "服务器上有临时目录，但PHP无法写入。";
				break;
			case UPLOAD_ERR_EXTENSION :
				$result['error']  = UPLOAD_ERR_EXTENSION;
				$result['msg'] = "上传的文件被PHP扩展程序中断";
				break;
			default :
				$result['error']  = 8;
				$result['msg'] = "未知的错误 " . $_FILES['Filedata']['error'];
			break;
		}
	} else {
		$result['error']  = 9;
		$result['msg'] = '无效的文件类型。';
	}
	echo json_encode($result);
}
?>