<?php
require_once('./application/models/base/modelbase.php');

class User_Recon_Model extends ModelBase{
	// Datagrid Sortable Fields
	public $sortable = array(
		'u.user_name' => 'Username',
		'u.real_name' => 'Nama',
	);
	
	// Datagrid Searchable Fields
	public $searchable = array(
		'u.user_name' => 'Username',
		'u.real_name' => 'Nama',
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

	public function get_biller($auth){		
		
		$stmt = $this->db	->select('b.*')
							->order_by('b.id')
							->get('recondb.biller b');
						
		return $stmt->result();
	}

	public function get_by_username($username, $auth){		
		$stmt = $this->db	->select('u.*')
							->where('u.user_name',$username)
							->get('recondb.recon_user u');
		return $stmt->row();
	}

	public function get_by_user_id($user_id){		
		$param = array($user_id);
		$query 		= "SELECT A.*, TO_CHAR(A.date_created+1, 'yyyy-mm-dd HH24:mi:ss') as exprd
						FROM recondb.recon_user A
						WHERE A.USER_ID = ?";
		$rs 		= $this->db->query($query, $param);
		$data 		= $rs->row();
		return $data;
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
		if(post('apps_id') == 'RECON'){
			$user = array(
				'user_id' => md5(post('username')),
				'user_name'=>strtoupper(post('username')),
				'user_type'=>2,
				'real_name' => post('name'),
				'biller_code' => post('biller_code'),
				'email' => post('email'),
				'is_lock' => 0,
				'is_disabled' => 0,
				'is_receive_notification' => 0,
			);
			$date = date('d/m/Y H:i:s');
			$this->db->set('date_created',"to_date('$date','dd/mm/yyyy hh24:mi:ss')", false);
			$this->db->insert('recondb.recon_user', $user);
		}else if(post('apps_id') == 'POS'){
			$query 		= "SELECT MAX(ID)+1 as max from posdb.t_users";
			$rs 		= $this->db->query($query);
			$data 		= $rs->row();

			$user = array(
				'id' => $data->MAX,
				'username'=>post('username'),
				'user_type'=>1,
				'ip_address' => '10.8.1.155',
				'outlet' => post('name'),
				'biller_id' => post('biller_id'),
				'email' => post('email'),
				'is_disabled' => 0,
				'is_receive_notification' => 0,
			);
			$date = date('d/m/Y H:i:s');
			$this->db->set('date_created',"to_date('$date','dd/mm/yyyy hh24:mi:ss')", false);
			$this->db->insert('posdb.t_users', $user);
		}else if(post('apps_id') == 'FORCE'){
			$user = array(
				'user_id' => md5(post('username')),
				'user_name'=>strtoupper(post('username')),
				'user_type'=>4,
				'real_name' => post('name'),
				'biller_code' => post('biller_code'),
				'email' => post('email'),
				'is_lock' => 0,
				'is_disabled' => 0,
				'is_receive_notification' => 0,
				'pwd' => $this->randomPassword(),
			);
			$date = date('d/m/Y H:i:s');
			$this->db->set('date_created',"to_date('$date','dd/mm/yyyy hh24:mi:ss')", false);
			$this->db->insert('forceflaggingdb.users', $user);
		}
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}

	public function update_password($user_id, $pass, $exprd = null){
		$this->db->trans_start();

		$user = array(
			'pwd' => md5($pass),
		);

		if($exprd){
			$this->db->set('date_created',"to_date('$exprd','dd/mm/yyyy hh24:mi:ss')", false);
		}
		$this->db->where('user_id', $user_id)->update('recondb.recon_user', $user);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function reset_pass($user_id, $auth){
		$this->db->trans_start();

		$user = array(
			'pwd' => '',
		);
		$date = date('d/m/Y H:i:s');
		$this->db->set('date_created',"to_date('$date','dd/mm/yyyy hh24:mi:ss')", false);
		$this->db->where('user_id', $user_id)->update('recondb.recon_user', $user);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
		$number = "0123456789";
		$character = '!@$%^&*()_+-=';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		$charLength = strlen($character) - 1; //put the length -1 in cache
		$numLength = strlen($number) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
			if($i==2){
				$n = rand(0, $charLength);
				$pass[] = $character[$n];
				
			} elseif($i==7){
				$n = rand(0, $numLength);
				$pass[] = $number[$n];
			}else {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
	    }
	    return implode($pass); //turn the array into a string
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