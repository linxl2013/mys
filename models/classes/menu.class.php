<?php
class menu extends model{
	protected $table = "admin_menu";

	public function delete($id){
		$row = $this->getRow($id);
		if($row["locked"]){
			return 1;
		}
		if($this->existChild($row["id"])){
			return 2;
		}
		$this->db->delete($this->table, array('id'=>$id));
	}
  	
	public function getList($parent_id = 0, $order = 'DESC'){
		$sql = 'SELECT * FROM ' . $this->db->dbprefix($this->table) .
					" WHERE parent_id = '$parent_id'  ORDER BY sort $order, id ASC";
		$list = $this->db->query($sql);
		
		$child_arr = array();
  		if($list->num_rows() > 0){
  			foreach ($list->result() as $row){
				$child_arr[$row->id] = (array)$row;
				if($row->id != NULL){
					$child_arr[$row->id]['child'] = $this->getList($row->id, $order);
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