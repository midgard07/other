<?php
require_once('./application/models/base/modelbase.php');

class User_Pos_Model extends ModelBase{
	// Datagrid Sortable Fields
	public $sortable = array(
		'u.username' => 'Username',
		'u.outlet' => 'Outlet',
	);
	
	// Datagrid Searchable Fields
	public $searchable = array(
		'u.username' => 'Username',
		'u.outlet' => 'Outlet',
	);
	
	public function __construct(){
		parent::__construct();
	}
	
	public function select($auth, $server, $where = array()){
		$this->siapkanDB();
		// $this->db	->select('SQL_CALC_FOUND_ROWS *', FALSE);
		
		$out = new StdClass();
		
		if($where){
			$this->db->where($where);
		}
				
		$out->datasource = $this->db->select('u.*')
									->get($server.' u')->result();

		
		$this->siapkanDB(true);
		if($where){
			$this->db->where($where);
		}
		
		$out->actualRows = $this->db->select('count(1) AS "numRows"')
									->get($server.' u')
									->row()->numRows;
		
		return $out;
	}

	public function get_by_username($username, $auth){		
		$stmt = $this->db	->select('u.*')
							->where('u.username',$username)
							->get('posdb.t_users u');
							
		return $stmt->row();
	}

	public function get_by_user_id($user_id){		
		$param = array($user_id);
		$query 		= "SELECT A.*, TO_CHAR(A.date_created+1, 'yyyy-mm-dd HH24:mi:ss') as exprd,
						USERNAME as USER_NAME, OUTLET as REAL_NAME
						FROM posdb.t_users A
						WHERE A.username = ?";
		$rs 		= $this->db->query($query, $param);
		$data 		= $rs->row();
		return $data;
	}

	public function update_password($user_id, $pass, $exprd = null){
		$this->db->trans_start();

		$user = array(
			'password' => md5($pass),
			'is_active' => 0,
		);

		if($exprd){
			$this->db->set('date_created',"to_date('$exprd','dd/mm/yyyy hh24:mi:ss')", false);
		}
		$this->db->where('username', $user_id)->update('posdb.t_users', $user);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function reset_pass($user_id, $auth){
		$this->db->trans_start();

		$user = array(
			'password' => '',
			'is_active' => 0,
		);
		$date = date('d/m/Y H:i:s');
		$this->db->set('date_created',"to_date('$date','dd/mm/yyyy hh24:mi:ss')", false);
		$this->db->where('username', $user_id)->update('posdb.t_users', $user);

		$this->db->trans_complete();
		return $this->db->trans_status();
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