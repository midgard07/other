<?php
/** Dashboard 
  *	Halaman landing ketika user berhasil login
  *
  */
class Dashboard extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
// 		Dapatkan data login
		if(!$this->auth = $this->userauth->getLoginData()){
			redirect(LOGIN_PAGE);
		}
	}

	/** 
	 * Index
	 * Di Halaman ini system akan menampilkan ucapan selamat datang dan jadwal kapal
	 */
	public function index(){
		$view = array(
			'auth' => $this->auth
		);
		$this->load->view('backend/pages/dashboard/index', $view);
	}

	/** 
	 * Index
	 * Di Halaman ini system akan menampilkan ucapan selamat datang dan jadwal kapal
	 */
	public function index_other(){
		$view = array(
			'auth' => $this->auth
		);
		
		$this->load->view('backend/pages/dashboard/index_other', $view);
	}

	function passwordUpdate()
	{
		$this->load->library(array('form_validation'));
		$auth = $this->auth;
		$mod = model('user_model');
		$res = $mod->get($this->auth->id, $auth);
		$data = array(
			'datasource' => $res,
			'auth' => $auth);

		if (post())
		{
			$this->form_validation->set_rules('oldpassword', 'Password Lama', 'required|callback_oldpassword_check');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');

			if ( $this->form_validation->run() == TRUE)
			{
				if($mod->updatePassword($this->auth->id)){
					redirect(DASHBOARD);
				}
			}
		}

		$this->load->view('backend/pages/dashboard/update_password', $data);
	}
	
	public function oldpassword_check($str)
	{
		$mod = model('user_model');
		$res = $mod->getPassword($this->auth->id);

		if (md5($str) != $res->password)
		{
			$this->form_validation->set_message('oldpassword_check', 'Password sekarang masih salah input');
			return FALSE;
		}
		else
			return TRUE;
	}

}