<?php
/**
 * This is the model class for table "{{menu}}".
 */
class AdminMenu extends CActiveRecord
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
		return '{{admin_menu}}';
	}
	/*
	public function rules()
	{
		return array(
			array('parent_id, sort', 'length', 'max'=>11),
			array('name, code', 'length', 'max'=>50),
			array('url', 'length', 'max'=>255),
			
			array('id, parent_id, name, url, code, sort, locked', 'safe', 'on'=>'search'),
		);
	}*/
	/*
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('sort',$this->sort,true);
		$criteria->compare('locked',$this->locked,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

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
		$sql = 'SELECT * FROM {{admin_menu}} WHERE parent_id = :ParentID ORDER BY sort '.$order.', id ASC';
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

	public function getRow($id){
		$query = $this->db->get_where($this->table, array('id' => $id), 1);
		return $query->row_array();
	}
  	
  	
  	public function existChild($parent_id){
  		$this->db->select('id');
  		$query = $this->db->get_where($this->table, array('parent_id' => $parent_id), 1);
  		if($query->num_rows > 0){
  			return true;
  		}
  		return false;
  	}
  	
	public function checkLocked($action, $locked){
		if($locked != 3){
			if($action == "update"){
				if($locked == 1)
					showMsg("禁编辑该栏目！", 'menu.php', 3);
			}elseif($action == "del"){
				if($locked == 2)
	  				showMsg("禁删除该栏目！", 'menu.php', 3);
			}
  		}else{
			showMsg("禁对该栏目操作！", 'menu.php', 3);
		}
	}
}
?>