<?php
/** Auth
  * Modul pengatur authentikasi user terhadap sistem 
  * secara keseluruhan. Untuk otorisasi user terhadap
  * modul harap gunakan secara lokal di modul masing2
  * 
  * @author		: Djati Satria (djati.satria@gmail.com)
  * @version 	: 2.0
  * @revision	: n/a
  */
  
class UserAuth extends CI_Model{
	// Key Untuk Simpan data login di session
	private $key 			= "usrmng.sc8d7gads";
	
	function __construct(){
		parent::__construct();
	}
	
	public function encryptPassword($str){
		// Sementara pakai MD5
		return md5($str);	
	}
	
	/* Get Login Data untuk otorisasi user */
	public function getLoginData(){
		// Development Use
		/*
		$dummy = new StdClass();
		$dummy->logged_in = true;
		$dummy->users_id = 1;
		$dummy->nama_lengkap = 'Development Dummy';
		$dummy->member_id = 1;
		$dummy->freight_forwarder_id = 1;
		$dummy->trucking_company_id = 1;
		
		return $dummy;
		*/
		
		// Production Use
		if($sess_data = $this->session->userdata($this->key)){
			if($sess_data->logged_in){
				return $sess_data;	
			}else{
				return false;		
			}
		}
		else return false;
	}
	
	/* Set Login Data Ketika Login Sukses */
	public function checkLogin($username, $password){
		// Daftar field yang akan diambil
		$fields = array(
			'u.user_id', 
			'u.user_name',
			'u.real_name',
		);
		
		$where = array(
			'u.user_name' => strtoupper($username),
			'u.pwd' => $this->encryptPassword($password),
			'u.user_type' => 9,
		);
		
		$userdata = $this->db	->select(implode(',', $fields))
								->where($where)
								->get('recondb.recon_user u')->row();

		// var_dump($this->db->last_query());exit;
								
		if($userdata){
			$ld = new StdClass();
			
			// Token untuk ajax request key
			$ld->token = uniqid();
			$ld->logged_in = true;
			foreach($userdata as $key => $val) $ld->{$key} = $val;
			
			$this->session->set_userdata($this->key, $ld);
			
			return true;
		}else{
			return false;
		}
	}
	
	/* Update Login Data, akan extends atau override data session yang sudah ada */
	public function updateLoginData($upd){
		$ld = $this->session->userdata($this->key);
		
		if($ld){
			foreach($upd as $key => $val) $ld->{$key} = $val;	
			$this->session->set_userdata($this->key, $ld);
			
			return true;
		}else{
			return false;	
		}
	}
	
	public function clearLoginData(){
		$this->session->unset_userdata($this->key);
	}
	
	public function checkToken($token){
		return true;	
	}
	
	
	
	public function update_approval_stat(){
		
	}
	
	public function get_validasi_dpd($id){
		if($this->getLoginData()){
			$item['perusahaan'] = $this->db->select('count(*) as count')->where(array('pa.dpd_id' => $id, 'pa.__active' => 4))
									->get('perusahaan_angkutan pa')->row();

			$item['kendaraan'] = $this->db->select('count(*) as count')->where(array('pa.dpd_id' => $id, 'k.__active' => 4))
									->from('kendaraan k')
									->join('kepemilikan_kendaraan kk', 'k.id = kk.kendaraan_id')
									->join('perusahaan_angkutan pa', 'pa.id = kk.perusahaan_angkutan_id')
									->get()->row();

			$item['supir'] = $this->db->select('count(*) as count')->where(array('pa.dpd_id' => $id, 's.__active' => 4))
									->from('supir s')
									->join('perusahaan_angkutan pa', 'pa.id = s.perusahaan_angkutan_id')
									->get()->row();

			return $item;
		}else{
			return NULL;
		}
	}
	public function get_aktivasi_dpd($id){
		if($this->getLoginData()){
			$item['perusahaan'] = $this->db->select('count(*) as count')->where(array('pa.dpd_id' => $id, 'pa.__active' => 2))
									->get('perusahaan_angkutan pa')->row();

			$item['kendaraan'] = $this->db->select('count(*) as count')->where(array('pa.dpd_id' => $id, 'k.__active' => 2))
									->from('kendaraan k')
									->join('kepemilikan_kendaraan kk', 'k.id = kk.kendaraan_id')
									->join('perusahaan_angkutan pa', 'pa.id = kk.perusahaan_angkutan_id')
									->get()->row();

			$item['supir'] = $this->db->select('count(*) as count')->where(array('pa.dpd_id' => $id, 's.__active' => 2))
									->from('supir s')
									->join('perusahaan_angkutan pa', 'pa.id = s.perusahaan_angkutan_id')
									->get()->row();

			return $item;
		}else{
			return NULL;
		}
	}
}