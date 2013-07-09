<?php
/**
 * This is the model class for table "{{menu}}".
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
		return self::model()->find('type_id=:TypeID and type=:Type and mime_type=:MimeType', array('type_id'=>$type_id,'type'=>$type,':MimeType'=>$mime_type));
	}
	
	/**根据type获取多个文件*/
	public static function getFilesByType($type_id,$type,$mime_type='image'){
		$list = self::model()->findAll('type_id=:TypeID and type=:Type and mime_type=:MimeType', array('type_id'=>$type_id,'type'=>$type,':MimeType'=>$mime_type));
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
				$file = new File;
				$file->type_id = $type_id;
				$file->type = $type;
				$file->file_name = $images['file_name'][$key] . $images['extension'][$key];
				$file->image = $val . $images['extension'][$key];
				$file->alt =  $images['alt'][$key];
				$file->sort =  $images['sort'][$key];
				$file->mime_type = 'image';
				$file->save();
			}
		}
		
	}
		
	public static function delFile($id){
		$tempPath = APP_PATH.'/uploads/temp';
		if(!empty($id)){
			foreach($delImgs as $val){
				$file = self::model()->findByPK($val);
				if(file_exists(APP_PATH.'/'.$file->image)){
					unlink(APP_PATH.'/'.$file->image);
				}
				if(file_exists(APP_PATH.'/'.$file->middle_image)){
					unlink(APP_PATH.'/'.$file->middle_image);
				}
				if(file_exists(APP_PATH.'/'.$file->thumbnail)){
					unlink(APP_PATH.'/'.$file->thumbnail);
				}
			}
			self::model()->deleteByPK($delImgs);
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
	
	public static function getCount($cate_id=0, $keyword=''){
		$criteria = new CDbCriteria;
		$condition = array();
		$params = array();
		
		if($keyword){
			$condition[] = 'locate(:Title, title)>0';
			$params[':Title'] = $keyword;
		}
		if($cate_id!=0){
			$condition[] = 'cate_id = :CateID';
			$params[':CateID'] = $cate_id;
		}
		if(!empty($condition)){
			$criteria->condition = implode(' and ', $condition);
			$criteria->params = $params;
		}
		return self::model()->count($criteria);
	}
	
	public static function getList($cate_id=0, $keyword='', $limit=0, $offset=0, $order='DESC'){
		$criteria = new CDbCriteria;
		$criteria->order = 't.sort '.$order;
		$condition = array();
		$params = array();
		
		if($keyword){
			$condition[] = 'locate(:Title, t.title)>0';
			$params[':Title'] = $keyword;
		}
		if($cate_id!=0){
			$condition[] = 't.cate_id = :CateID';
			$params[':CateID'] = $cate_id;
		}
		if(!empty($condition)){
			$criteria->condition = implode(' and ', $condition);
			$criteria->params = $params;
		}
		if($limit!=0 || $offset!=0){
			$criteria->limit = $limit;
			$criteria->offset = $offset;
		}
		$criteria->with = array('article_cate');
		
		return self::model()->findAll($criteria);
	}

	public static function getRow($id){
		return self::model()->findByPK($id);
	}
}
?>