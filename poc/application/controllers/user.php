<?php
class User extends CI_Controller{
	private $local_db;
	
	public function __construct(){
		parent::__construct();
		
		// Dapatkan data login
		$this->auth = $this->userauth->getLoginData();
		if(!$this->auth){
			redirect(LOGIN_PAGE);
		}
	}
	
	private function process_grid_state(){
		$segments = $this->uri->rsegment_array();
	
		$grid_state = 'user/listview/';
		foreach($segments as $segment){
			if(strrpos($segment, ':') !== FALSE){
				$grid_state .= $segment.'/';
			}
		}
		
		return $grid_state;
	}
	
	/** 
	 * Index
	 */
	public function index(){
		redirect('user/listview');
	}
	
	
	/** 
	 * Listview
	 * Halaman utama modul delivery request, menampilkan daftar delivery request yang sudah pernah
	 * dilakukan dan sebagai launcher untuk membuat delivery request baru ataupun tindakan-tindakan
	 * lain terhadap delivery request yang sudah dilakukan.
	 */
	public function listview_recon($code = NULL){
		$ui_messages = array();
		
		switch($code){
			case '200':
				$ui_messages[] = array(
					'severity' => 'SUCCESS',
					'title' => 'Sukses Menambah User',
					'message' => 'User baru sudah ditambahkan',
				);
				break;
				
			case '201':
				$ui_messages[] = array(
					'severity' => 'SUCCESS',
					'title' => 'Sukses Mengubah User',
					'message' => 'Data user sudah berubah, silakan cek kembali.',
				);
				break;
		}
		
		$num_args = func_num_args();
		$get_args = func_get_args();

		// Load Model & Parsing Parameter untuk sorting, searching dan paging
		$mod = model('user_recon_model');
		
		$cfg = $mod->parseParameter($num_args, $get_args);

		// Apply Config
		$mod->terapkanConfig($cfg);

		// Content Data
		// $res = $mod->select($this->auth, 'recondb.recon_user_bak', array('user_type != ' => '9'));
		$res = $mod->select($this->auth, 'recondb.recon_user', array('user_type != ' => '9'));

		$cfg->totalPage		= (int) ceil($res->actualRows / $cfg->rowPerPage);
				
		// Layout Data
		$data = array(
			'cfg' => $cfg,
			'searchable' => $mod->searchable,
			'sortable' => $mod->sortable,
			'ui_messages' => $ui_messages,
			'datasource' => $res->datasource,
			'auth' =>  $this->auth,
		);

		$this->load->view('backend/pages/user/listview_recon', $data);
	}

	public function listview_pos($code = NULL){
		$ui_messages = array();
		
		switch($code){
			case '200':
				$ui_messages[] = array(
					'severity' => 'SUCCESS',
					'title' => 'Sukses Menambah User',
					'message' => 'User baru sudah ditambahkan',
				);
				break;
				
			case '201':
				$ui_messages[] = array(
					'severity' => 'SUCCESS',
					'title' => 'Sukses Mengubah User',
					'message' => 'Data user sudah berubah, silakan cek kembali.',
				);
				break;
		}
		
		$num_args = func_num_args();
		$get_args = func_get_args();

		// Load Model & Parsing Parameter untuk sorting, searching dan paging
		$mod = model('user_pos_model');
		
		$cfg = $mod->parseParameter($num_args, $get_args);

		// Apply Config
		$mod->terapkanConfig($cfg);

		// Content Data
		// $res = $mod->select($this->auth, 'posdb.t_users_bak', array('id != ' => '0'));
		$res = $mod->select($this->auth, 'posdb.t_users', array('id != ' => '0'));

		$cfg->totalPage		= (int) ceil($res->actualRows / $cfg->rowPerPage);
				
		// Layout Data
		$data = array(
			'cfg' => $cfg,
			'searchable' => $mod->searchable,
			'sortable' => $mod->sortable,
			'ui_messages' => $ui_messages,
			'datasource' => $res->datasource,
			'auth' =>  $this->auth,
		);

		$this->load->view('backend/pages/user/listview_pos', $data);
	}

	public function listview_force($code = NULL){
		$ui_messages = array();
		
		switch($code){
			case '200':
				$ui_messages[] = array(
					'severity' => 'SUCCESS',
					'title' => 'Sukses Menambah User',
					'message' => 'User baru sudah ditambahkan',
				);
				break;
				
			case '201':
				$ui_messages[] = array(
					'severity' => 'SUCCESS',
					'title' => 'Sukses Mengubah User',
					'message' => 'Data user sudah berubah, silakan cek kembali.',
				);
				break;
		}
		
		$num_args = func_num_args();
		$get_args = func_get_args();

		// Load Model & Parsing Parameter untuk sorting, searching dan paging
		$mod = model('user_force_model');
		
		$cfg = $mod->parseParameter($num_args, $get_args);

		// Apply Config
		$mod->terapkanConfig($cfg);

		// Content Data
		// $res = $mod->select($this->auth, 'forceflaggingdb.users_bak', array('user_type != ' => '9'));
		$res = $mod->select($this->auth, 'forceflaggingdb.users', array('user_type != ' => '9'));

		$cfg->totalPage		= (int) ceil($res->actualRows / $cfg->rowPerPage);
				
		// Layout Data
		$data = array(
			'cfg' => $cfg,
			'searchable' => $mod->searchable,
			'sortable' => $mod->sortable,
			'ui_messages' => $ui_messages,
			'datasource' => $res->datasource,
			'auth' =>  $this->auth,
		);

		$this->load->view('backend/pages/user/listview_force', $data);
	}
	
	public function add(){
		$mod = model('user_recon_model');
		
		$grid_state = $this->process_grid_state();
		$auth = $this->auth;
		$ui_messages = array();
		
		if(is_post_request()){
			$this->load->library('form_validation');
			if(post('apps_id') == 'RECON'){
				$this->form_validation->set_rules('apps_id', 'Aplikasi', 'required');
				$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email');
				$this->form_validation->set_rules('username', 'username', 'required|callback_check_username_recon');
				$this->form_validation->set_rules('name', 'Nama', 'required');
				$this->form_validation->set_rules('biller_code', 'Biller', 'required');
			}else if(post('apps_id') == 'POS'){
				$this->form_validation->set_rules('apps_id', 'Aplikasi', 'required');
				$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email');
				$this->form_validation->set_rules('username', 'username', 'required|callback_check_username_pos');
				$this->form_validation->set_rules('name', 'Nama', 'required');
				$this->form_validation->set_rules('biller_id', 'Biller', 'required');
			}else if(post('apps_id') == 'FORCE'){
				$this->form_validation->set_rules('apps_id', 'Aplikasi', 'required');
				$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email');
				$this->form_validation->set_rules('username', 'username', 'required|callback_check_username_force');
				$this->form_validation->set_rules('name', 'Nama', 'required');
				$this->form_validation->set_rules('biller_code', 'Biller Code', 'required');
			}
			
			if($this->form_validation->run()){
				// var_dump(md5(post('username')));exit;
				$user_save = $mod->insert($auth);
				if($user_save){
					if(post('apps_id') == 'RECON'){
						$to = post('email');
						$subject = "Register User RECON";
						$txt = "Dear ".strtoupper(post('name')).",

Silakan melakukan verifikasi untuk menjadi user recon, dengang klik link berikut :
http://172.16.254.51/user_mng/verification/recon/".md5(post('username')).".

Terima kasih";
						$headers = "From: ilcs-ebpp@ilcs.co.id" . "\r\n";

						mail($to,$subject,$txt,$headers);
						redirect('user/listview_recon/200');
					}else if(post('apps_id') == 'POS'){
						$to = post('email');
						$subject = "Register User POS";
						$txt = "Dear ".strtoupper(post('name')).",

Silakan melakukan verifikasi untuk menjadi user pos, dengang klik link berikut :
http://172.16.254.51/user_mng/verification/pos/".post('username').".

Terima kasih";
						$headers = "From: ilcs-ebpp@ilcs.co.id" . "\r\n";

						mail($to,$subject,$txt,$headers);
						redirect('user/listview_pos/200');
					}else if(post('apps_id') == 'FORCE'){
						$to = post('email');
						$subject = "Register User Force Flagging";
						$txt = "Dear ".strtoupper(post('name')).",

Silakan melakukan verifikasi untuk menjadi user force flagging, dengang klik link berikut :
http://172.16.254.51/user_mng/verification/force/".md5(post('username')).".

Terima kasih";
						$headers = "From: ilcs-ebpp@ilcs.co.id" . "\r\n";

						mail($to,$subject,$txt,$headers);
						redirect('user/listview_force/200');
					}
				}else{
					$ui_messages[] = array(
						'severity' => 'ERROR',
						'title' => 'Database Problem',
						'message' => 'Silakan menghubungi admin ILCS',
					);
				}
			}else{
				$ui_messages[] = array(
					'severity' => 'ERROR',
					'title' => 'Isian Masih Salah',
					'message' => 'Silakan perbaiki isian sesuai yang tertera',
				);
			}
		}
		$billers = $mod->get_biller($auth);
		
		$view = array(
			'grid_state' => $grid_state,
			'ui_messages' => $ui_messages,
			'auth' => $auth,
			'billers' => $billers,
		);
		
		$this->load->view('backend/pages/user/add', $view);
	}

	public function check_username_recon($str){
		$mod = model('user_recon_model');
		$user = $mod->get_by_username(strtoupper($str), $this->auth);
		// var_dump($user);exit;
		if($user){
			$this->form_validation->set_message('check_username_recon', 'Username Sudah Terdaftar');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function check_username_pos($str){
		$mod = model('user_pos_model');
		$user = $mod->get_by_username($str, $this->auth);
		// var_dump($user);exit;
		if($user){
			$this->form_validation->set_message('check_username_pos', 'Username Sudah Terdaftar');
				return FALSE;
		}else{
			return TRUE;
		}
	}

	public function check_username_force($str){
		$mod = model('user_force_model');
		$user = $mod->get_by_username(strtoupper($str), $this->auth);
		// var_dump($user);exit;
		if($user){
			$this->form_validation->set_message('check_username_force', 'Username Sudah Terdaftar');
				return FALSE;
		}else{
			return TRUE;
		}
	}

	public function add_opeartor(){
		$mod = model('user_model');
		
		$grid_state = $this->process_grid_state();
		$auth = $this->auth;
		$ui_messages = array();
		
		if(is_post_request()){
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('email', 'Email', 'required|is_unique[acl_user.email]');
			$this->form_validation->set_rules('password', 'Password Sementara', 'required');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
			$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'required|is_unique[acl_user.nomor_ktp]');
			
			if($this->form_validation->run()){
				$mod->insert($auth);
				
				redirect('user/listview/200');
			}else{
				$ui_messages[] = array(
					'severity' => 'ERROR',
					'title' => 'Isian Masih Salah',
					'message' => 'Silakan perbaiki isian sesuai yang tertera',
				);
			}
		}
		
		$view = array(
			'grid_state' => $grid_state,
			'ui_messages' => $ui_messages,			
		);
		
		$this->load->view('backend/pages/user/add_operator', $view);
	}
	
	public function view($user_id, $grid1 = null, $grid2){
		$grid_state = $this->process_grid_state();
		$auth = $this->auth;
		$ui_messages = array();
		if($grid2 == 'listview_recon'){
			$mod = model('user_recon_model');
		}else if($grid2 == 'listview_force'){
			$mod = model('user_force_model');
		}else if($grid2 == 'listview_pos'){
			$mod = model('user_pos_model');
		}
		
		$user = $mod->get_by_user_id($user_id, $auth);
		
		if(is_post_request()){
			$this->load->library('form_validation');
			
			$updated = $mod->reset_pass($user_id, $auth);
			if($updated){
				if($grid2 == 'listview_recon'){
					$to = $user->EMAIL;
					$subject = "Reset Password User RECON";
					$txt = "Dear ".$user->REAL_NAME.",

	Silakan melakukan verifikasi untuk menjadi user recon, dengang klik link berikut :
	http://172.16.254.51/user_mng/verification/recon/".$user->USER_ID.".

	Terima kasih";
					$headers = "From: ilcs-ebpp@ilcs.co.id" . "\r\n";
					mail($to,$subject,$txt,$headers);
				}else if($grid2 == 'listview_force'){
					$to = $user->EMAIL;
					$subject = "Reset Password User FORCE";
					$txt = "Dear ".$user->REAL_NAME.",

	Silakan melakukan verifikasi untuk menjadi user force flagging, dengang klik link berikut :
	http://172.16.254.51/user_mng/verification/force/".$user->USER_ID.".

	Terima kasih";
					$headers = "From: ilcs-ebpp@ilcs.co.id" . "\r\n";
					mail($to,$subject,$txt,$headers);
				}else if($grid2 == 'listview_pos'){
					$to = $user->EMAIL;
					$subject = "Reset Password User POS";
					$txt = "Dear ".$user->REAL_NAME.",

	Silakan melakukan verifikasi untuk menjadi user pos, dengang klik link berikut :
	http://172.16.254.51/user_mng/verification/pos/".$user->USERNAME.".

	Terima kasih";
					$headers = "From: ilcs-ebpp@ilcs.co.id" . "\r\n";
					mail($to,$subject,$txt,$headers);
				}
				redirect('user/'.$grid2.'/201');
			}
			
		}
		
		$view = array(
			'grid_state' => $grid_state,
			'ui_messages' => $ui_messages,			
			'user' => $user,
			'auth' => $this->auth,
		);
		$this->load->view('backend/pages/user/view', $view);
	}


}