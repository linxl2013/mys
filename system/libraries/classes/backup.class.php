<?php
  /**
   * 数据库备份还原管理类
   */
   
  //定义系统内部变量，防止黑客攻击
  if (!defined('IN_CMS'))
  {
    die('攻击行为！');
  }
  class backup {
  	private $table = "backup";
	public $db;  	
	public function __construct(){
		
		$this->db =getDB();
	}
	
	public function insert(){
		$file_path = $this->backupTables();
		$data = array(
				'file_path' => $file_path ,
				'backup_time' => time()
		);
		
		$this->db->insert($this->table, $data);
	}
	public function delete($in){
		if(is_string($in) && strpos($in, ",") !== false){
			$backup = $this->getBackup ($in);
			$real_path  = ROOT_PATH . '/'.$backup["file_path"];
			if(file_exists($real_path)){
				unlink($real_path);
			}
		}else{
			foreach($in as $backup_id){
				$backup = $this->getBackup ($backup_id);
				$real_path  = ROOT_PATH . '/'.$backup["file_path"];
				if(file_exists($real_path)){
					unlink($real_path);
				}
			}
			$in = implode(",",$in);
		}
		$this->db->where_in('backup_id', $in);
		$this->db->delete($this->table);
	}
	/* 备份数据库中的所有表 */
	function backupTables($tables = '*') {
		//get all of the tables
		if ($tables == '*') {
			$tables = array();
			$tables = $this->db->list_tables();
		} else {
			$tables = is_array($tables) ? $tables : explode(',', $tables);
			foreach($tables as &$table_temp){
				$table_temp = $this->db->dbprefix($table_temp);
			}
		}
		$return = '';
		//cycle through
		foreach ($tables as $table) {
			$return .= 'DROP TABLE IF EXISTS ' . $table . ';';
			$query = $this->db->query('SHOW CREATE TABLE ' . $table);
			if ($query->num_rows() > 0){
				$creatTableArr = $query->row_array();
				$return .= "\n\n" . $creatTableArr['Create Table'] . ";\n\n";
			}
			$fields = $this->db->list_fields($table);
			$query = $this->db->get($table);
			$table_data = $query->result_array();
			if(!empty($table_data)){
				$return .= 'INSERT INTO ' . '`'.$table .'` VALUES ';
				$datastr = "";
				foreach($table_data as $data){
					foreach($data as &$d){
						$d = addslashes($d);
						$d = "\"".$d."\"";
					}
					$datastr .= "(" . implode(",",$data)."),";
				} 
				$datastr = substr($datastr,0,strlen($datastr) -1).";\n\n";
				$return .= $datastr."\n\n\n";
			}
		}
		//save file
		$fileDir = ROOT_PATH .'./backup';
		if( !is_dir($fileDir) ) {
			@mkdir( $fileDir, 0755,true);
		}
		$filePath = 'backup/db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql';
		file_put_contents(ROOT_PATH . '/'.$filePath, $return);
		return $filePath;
		
	}
	
	public function getBackupList ($keyword='',$limit=20,$offset=0){
		$this->db->from($this->table);
		if($keyword){
			$this->db->like('backup_time', $keyword);
		}
		$this->db->order_by('backup_time', "desc");
		$this->db->limit($limit,$offset);
		$query =  $this->db->get();
		$rows = array();
		foreach($query->result_array() as $row){
			
			$row["format_time"] = date('Y-m-d H:i:s', $row["backup_time"]);
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function count($keyword=''){
		$this->db->from($this->table);
		if($keyword){
			$this->db->like('backup_time', $keyword);
		}
		return $this->db->count_all_results();
	
	}
	
	public function getBackup ($backup_id){
		$query = $this->db->get_where($this->table, array('backup_id' => $backup_id), 1);
		$row = $query->row_array();
		return $row;
	}

}
?>
