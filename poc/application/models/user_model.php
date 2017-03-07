<?php
require_once('./application/models/base/modelbase.php');

class User_Model extends ModelBase{
	// Datagrid Sortable Fields
	public $sortable = array(
		'username' => 'Username',
		'nama' => 'Nama',
	);
	
	// Datagrid Searchable Fields
	public $searchable = array(
		'username' => 'Username',
		'nama' => 'Nama',
	);
	
	public function __construct(){
		parent::__construct();
	}
	
	public function select($auth, $where = array()){
		$this->siapkanDB();
		$this->db	->select('SQL_CALC_FOUND_ROWS *', FALSE);
		
		$out = new StdClass();
		
		if($where){
			$this->db->where($where);
		}
				
		$out->datasource = $this->db->select('u.*')
									->get('user u')->result();
		
		$out->actualRows = $this->db->query("SELECT FOUND_ROWS() as numRows")->row()->numRows;
		
		return $out;
	}
	
	public function get($id, $auth, $is_array = false){		
		
		$stmt = $this->db	->select('u.*')
							->where('u.id', $id)
							->get('user u');
						
		if($is_array){
			return $stmt->row_array();
		}else{
			return $stmt->row();
		}
	}

	public function get_user($id, $auth, $is_array = false){
		
		$stmt = $this->db	->select('u.*')
							->where('u.id', $id)
							->get('user u');
						
		if($is_array){
			return $stmt->row_array();
		}else{
			return $stmt->row();
		}
	}
	
	public function insert($auth){
		$this->db->trans_start();
		
		$user = array(
			'username' => post('username'),
			'nama'=>post('nama'),
			'password' => md5(post('password')),
			'flag' => post('flag'),
		);
		$this->db->insert('user', $user);
		$user_id = $this->db->insert_id();
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	public function update($id, $auth){
		$user = array(
			'username' => post('username'),
			'nama'=>post('nama'),
			'password' => md5(post('password')),
			'flag' => post('flag'),
		);
		
		$this->db->where('id', $id)->update('user', $user);
	}

	// update table acl_user
	public function update_user($id, $auth){

		$acl_user = array(
			'username' => post('username'),
			'nama' => post('nama'),			
			'flag' => post('flag'),
		);
		if(post('password') != null){
			$this->db->set('password', md5(post('password')));
		}
		$this->db->where('id', $id)->update('user', $acl_user);
	}
	
	public function delete($id, $auth){
		$upd = array(
			'flag' => 0,
		);
		
		$this->db->where('id', $id)->update('user', $upd);
	}
	
	
	public function updatePassword($id){
		$acl_user = array(
			'password' => md5(post('password')),
		);
		
		return $this->db->where('id', $id)->update('user', $acl_user);
	}
	
	public function getPassword($id){
		$stmt = $this->db	->select('password')
							->where('u.id', $id)
							->get('user u');
		return $stmt->row();
	}
}