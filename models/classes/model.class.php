<?php
class model{
	protected $table = '';
	protected $db;

	public function __construct(){
		$this->db = getDB();
	}

	public function insert($data){
		$this->db->insert($this->table, $data);
	}
	
	public function insert_id(){
		return $this->db->insert_id();
	}
	
	public function update($data, $where){
		$this->db->update($this->table, $data, $where);
	}

	public function delete($id){
		if(is_string($id) && strpos($id, ",") !== false)
			$id = explode(',',$id);
		elseif(!is_array($id))
			$id = array(intval($id));
		$this->db->where_in('id', $id);
		$this->db->delete($this->table);
	}
	
	public function getRow($id){
		$query = $this->db->get_where($this->table, array('id' => $id), 1);
		return $query->row_array();
	}
}
?>