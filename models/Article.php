<?php
/**
 * This is the model class for table "{{menu}}".
 */
class Article extends CActiveRecord
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
		return '{{article}}';
	}
  	
	public function relations()
	{
		return array(
			'article_cate' => array(self::BELONGS_TO, 'ArticleCate', 'cate_id'),
		);
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