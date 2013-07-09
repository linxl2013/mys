<?php
/**
 * This is the model class for table "{{menu}}".
 */
class ArticleCate extends CActiveRecord
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
		return '{{article_cate}}';
	}
	
	public function relations()
	{
		return array(
			'article' => array(self::HAS_MANY, 'Article', 'cate_id'),
		);
	}

	/*public function delete($id){
		$row = $this->getRow($id);
		if($row["locked"]){
			return 1;
		}
		if($this->existChild($row["id"])){
			return 2;
		}
		$this->db->delete($this->table, array('id'=>$id));
	}*/
  	
	public static function getList($parent_id = 0, $order = 'DESC'){
		$sql = 'SELECT * FROM {{article_cate}} WHERE parent_id = :ParentID ORDER BY sort '.$order.', id ASC';
		$list = db()->createCommand($sql)
						->bindValue(':ParentID', intval($parent_id), PDO::PARAM_INT)
						->queryAll();

		$child_arr = array();
		if($list){
			foreach ($list as $row){
				$child_arr[$row['id']] = $row;
				if($row['id'] != NULL){
					$child_arr[$row['id']]['child'] = self::getList($row['id'], $order);
				}
			}
		}
		return $child_arr;
	}

	public static function getRow($id){
		return self::model()->findByPK($id);
	}
  	
  	public static function existChild($parent_id){
  		$count = self::model()->count('parent_id = :ParentID', array(':ParentID' => $parent_id));
		if($count > 0)
  			return true;
  		return false;
	}
  	

}
?>