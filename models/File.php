<?php
/**
 * This is the model class for table "{{file}}".
 */
class File extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{file}}';
	}
	
	/**根据type获取单个文件*/
	public static function getFileByType($type_id, $type,$mime_type='image'){
		return self::model()->find('type_id=:TypeID and type=:Type and mime_type=:MimeType', array(':TypeID'=>$type_id,':Type'=>$type,':MimeType'=>$mime_type));
	}
	
	/**根据type获取多个文件*/
	public static function getFilesByType($type_id,$type,$mime_type='image'){
		$criteria = new CDbCriteria;
		$criteria->condition = 'type_id=:TypeID and type=:Type and mime_type=:MimeType';
		$criteria->params = array(':TypeID'=>$type_id,':Type'=>$type,':MimeType'=>$mime_type);
		$criteria->order = 'sort asc';
		
		$list = self::model()->findAll($criteria);
		$rows = array();
		foreach($list as $key=>$row){
			$rows[] = $row->attributes;
		}
		return $rows;
	}
	
	/**保存文件*/
	public static function saveImage($form_id, $type_id=0, $type='product'){
		$images = empty($_POST[$form_id])?null:$_POST[$form_id];
		if(!empty($images['edit'])){
			foreach($images['edit'] as $id => $val){
				self::model()->updateByPK($id,array('alt'=>$val['alt'],'sort'=>$val['sort']));
			}
		}
		if(!empty($images['is_del'])){
			$delImgs = str_replace('0,', '', $images['is_del']);
			$delImgs = explode(',', $delImgs);
			self::delFile($delImgs);
		}
		$images = empty($_POST[$form_id.'_new'])?null:$_POST[$form_id.'_new'];
		if(!empty($images)){
			foreach($images['save_name'] as $key=>$val){
				$filename = self::moveFile($val.'.'.$images['extension'][$key]);
				
				$file = new File;
				$file->type_id = $type_id;
				$file->type = $type;
				$file->file_name = $images['file_name'][$key];
				$file->image = $filename;
				$file->alt =  $images['alt'][$key];
				$file->sort =  $images['sort'][$key];
				$file->mime_type = 'image';
				$file->save();
			}
		}
	}

	/**移动文件*/
	public static function moveFile($filename){
		$targetPath = APP_PATH.'/uploads/'.date('Ym');
		$tempPath = APP_PATH.'/uploads/temp';
		if(!is_dir($targetPath)){
			if(!mkdir($targetPath, 0755, true)){
				return false;
			}
		}
		clearstatcache();
		if(!file_exists($tempPath.'/'.$filename) || !is_file($tempPath.'/'.$filename)){
			return false;
		}
		if(rename($tempPath.'/'.$filename, $targetPath.'/'.$filename)){
			return 'uploads/'.date('Ym').'/'.$filename;
		}
		return false;
	}
	
	/**按类型删除文件*/
	public static function delFileByType($id,$type){
		$id_arr = !is_array($id) ? array($id) : $id;
		foreach($id_arr as $id ){
			$files = self::getFilesByType($id,$type);
			$ids = array();
			foreach($files as $item){
				$ids[] = $item['id'];
			}
			self::delFile($ids);
		}
	}
	
	/**删除具体文件*/
	public static function delFile($ids){
		$tempPath = APP_PATH.'/uploads/temp';
		if(!empty($ids)){
			foreach($ids as $val){
				$file = self::model()->findByPK($val);
				if(file_exists(APP_PATH.'/'.$file->image)&&is_file(APP_PATH.'/'.$file->image)){
					unlink(APP_PATH.'/'.$file->image);
				}
				if(file_exists(APP_PATH.'/'.$file->middle_image)&&is_file(APP_PATH.'/'.$file->middle_image)){
					unlink(APP_PATH.'/'.$file->middle_image);
				}
				if(file_exists(APP_PATH.'/'.$file->thumbnail)&&is_file(APP_PATH.'/'.$file->thumbnail)){
					unlink(APP_PATH.'/'.$file->thumbnail);
				}
			}
			self::model()->deleteByPK($ids);
		}
	}
	
	/**清除两天前的临时文件*/
	public static function autoCleanTemp(){
		$tempPath = APP_PATH.'/uploads/temp';
		$mark = glob($tempPath.'/*.mark');
		$currentTime = time();
		if(isset($mark[0])){
			$markFile = $mark[0];
			$mark = explode('.', basename($markFile));
			$markTime = $mark[0];
			if($currentTime - $markTime < 172800){
				return true;
			}
		}else{
			$fp = touch($tempPath."/$currentTime.mark");
			return true;
		}
		$handler = opendir($tempPath);
		while(($filename = readdir($handler)) !== false){
			if($filename != '.' && $filename != '..' && $filename != "$markTime.mark" ){
				$dayArr = explode('_', $filename);
				$day = date('Ymd',$dayArr[0]);
				if($currentTime - $dayArr[0] >= 172800 ){
					unlink($tempPath.'/'.$filename);
				}
			}
		}
		closedir($handler);
		rename($markFile, $tempPath."/$currentTime.mark");
		return true;
	}

	public static function getRow($id){
		return self::model()->findByPK($id);
	}
}
?>