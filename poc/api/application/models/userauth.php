<?php
/** Auth
  * Modul pengatur authentikasi user terhadap sistem 
  * secara keseluruhan. Untuk otorisasi user terhadap
  * modul harap gunakan secara lokal di modul masing2
  * 
  * @author		: Djati Satria (djati.satria@gmail.com)
  * @version 	: 1.0
  * @revision	: n/a
  */
  
class UserAuth extends CI_Model{
	// Key Untuk Simpan data login di session
	private $key 			= "sdg98sadgjlasg";
	private $oauth_key 		= "demo.sc8d7gads";
	private $tb_user 		= 'acl_user';
	private $tb_role 		= 'acl_std_role';
	private $tb_hakakses 	= 'acl_module';
	private $tb_wewenang	= 'sys_hakakses';
	private $perusahaan 	= 'perusahaan_angkutan';
	private $logging_desktop_app 	= 'logging_desktop_app';
	
	function __construct(){
		parent::__construct();
	}
	
	/* Get Login Data untuk otorisasi user */
	public function getLoginData(){
		// Production Use
		if(isset($_SESSION[$this->key])) return $_SESSION[$this->key];
		else return false;
		
		return $obj;
	}

	public function getLoginDataOauth(){
		// Production Use
		if(isset($_SESSION[$this->oauth_key])) return $_SESSION[$this->oauth_key];
		else return false;
		
		return $obj;
	}
	
	/* Set Login Data Ketika Login Sukses */
	public function setLoginData($upd){
		$ld = new StdClass();
		
		// Token untuk ajax request key
		$ld->token = uniqid();
		foreach($upd as $key => $val) $ld->{$key} = $val;
		
		$_SESSION[$this->key] = & $ld;
	}
	
	public function clearLoginData(){
		unset($_SESSION[$this->key]);
	}
	
	/* Dapat Permission Untuk ID Modul yang diminta
	 */
	public function getPermission($module, $task = NULL){
		$auth = $this->getLoginData();
		
		$where = array(
			'nama_modul' => $module,
			'username' => $auth->username
		);
		
		return $this->db->where($where)->get($this->tb_hakakses)->row();
	}
	
	/* Dapat permission untuk tugas tertentu misalnya
	 * daftar user yang dapat menerima email proposal draft,
	 * atau dapatkan daftar user yang dapat menerima approval final
	 */ 
	public function getAuthority($task){
		
	}

	public function is_valid_company($security_word){
		$is_valid = false;

		$data = $this->db->where('md5(id)', $security_word)->get($this->perusahaan)->row();

		if($data){
			$is_valid = $data->id;
		}

		return $is_valid;
	}

	public function is_valid_username_login($username){
		$is_valid = false;

		$data = $this->db->where('username', $username)->get($this->tb_user)->row();

		if($data){
			$data = $this->db->where('user_id', $data->id)
							->where('is_admin_perusahaan', 1)
							->get($this->tb_role)->row();
			
			$is_valid = $data->id_perusahaan_angkutan;
		}

		return $is_valid;
	}

	public function is_valid_kode_perusahaan($nomor_anggota){
		$is_valid = false;

		$data = $this->db->where('nomor_anggota', $nomor_anggota)->get($this->perusahaan)->row();

		if($data){
			$is_valid = $data->id;
		}

		return $is_valid;
	}
}