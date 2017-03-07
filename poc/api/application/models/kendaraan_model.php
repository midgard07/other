<?php
require_once('./application/models/base/modelbase.php');

class Kendaraan_Model extends ModelBase{
	// Datagrid Sortable Fields
	public $sortable = array(
		'nomor_plat' => 'Nomor Plat',
	);
	
	// Datagrid Searchable Fields
	public $searchable = array(
		'nomor_plat' => 'Nomor Plat',
	);
	
	public function __construct(){
		parent::__construct();
	}
	
	public function select($auth, $where = array()){
		// $this->siapkanDB();
		$this->db	->select('SQL_CALC_FOUND_ROWS *', FALSE);
		
		$out = new StdClass();
		
		if($where){
			$this->db->where($where);
		}
		
		if(!$auth->is_dpp_user){
			if($auth->id_perusahaan_angkutan){
				$this->db->where('kk.perusahaan_angkutan_id', $auth->id_perusahaan_angkutan);
			}
		}
		
		
		
		
		$out->datasource = $this->db->select('k.*, mk.merek_kendaraan, jk.jenis_kendaraan, jmp.jenis_mobil_penarik')
									->join('merek_kendaraan mk', 'mk.id = k.merek_kendaraan_id')
									->join('jenis_kendaraan jk', 'jk.id = k.jenis_kendaraan_id')
									->join('kepemilikan_kendaraan kk', 'kk.kendaraan_id = k.id')
									->join('jenis_mobil_penarik jmp', 'jmp.id = k.jenis_mobil_penarik_id')
									->get('kendaraan k')->result();
									
		
		
		$out->actualRows = $this->db->query("SELECT FOUND_ROWS() as numRows")->row()->numRows;
		
		return $out;
	}
	
	public function select_aso($auth, $where = array()){
		// $this->siapkanDB();
		//$this->db	->select('SQL_CALC_FOUND_ROWS *', FALSE);
		
		$out = new StdClass();
		
		if($where){
			$this->db->where($where);
		}
		
		if(!$auth->is_dpp_user){
			if($auth->id_perusahaan_angkutan){
				$this->db->where('kk.perusahaan_angkutan_id', $auth->id_perusahaan_angkutan);
			}
		}
		
		$query = $this->db->select('k.id, k.nomor_plat')
									->from('kendaraan k')
									->join('merek_kendaraan mk', 'mk.id = k.merek_kendaraan_id')
									->join('jenis_kendaraan jk', 'jk.id = k.jenis_kendaraan_id')
									->join('kepemilikan_kendaraan kk', 'kk.kendaraan_id = k.id')
									->join('jenis_mobil_penarik jmp', 'jmp.id = k.jenis_mobil_penarik_id');
									
		
		$out->datasource = $query->get()->result();

		// var_dump($this->db->last_query());exit;
		
		/**
		$out->datasource = $this->db->select('k.id, k.nomor_plat')
									->from('kendaraan k')
									->join('merek_kendaraan mk', 'mk.id = k.merek_kendaraan_id')
									->join('jenis_kendaraan jk', 'jk.id = k.jenis_kendaraan_id')
									->join('kepemilikan_kendaraan kk', 'kk.kendaraan_id = k.id')
									->join('jenis_mobil_penarik jmp', 'jmp.id = k.jenis_mobil_penarik_id')
									->get('kendaraan k')->result();
		*/
		
		$out->actualRows = $this->db->query("SELECT FOUND_ROWS() as numRows")->row()->numRows;
		
		return $out;
	}
	
	public function get($id, $auth, $is_array = false){		
		if(!$auth->is_dpp_user){
			if($auth->id_perusahaan_angkutan){
				$this->db->where('kk.perusahaan_angkutan_id', $auth->id_perusahaan_angkutan);
			}
		}
	
		$stmt = $this->db->select('
							k.*, mk.merek_kendaraan, jk.jenis_kendaraan, pa.nama_perusahaan, pa.alamat_perusahaan, pa.id AS id_perusahaan, jmp.jenis_mobil_penarik, sk.supir_id, s.nama_supir, dk.device_id, d.serial_number
						')
						->join('merek_kendaraan mk', 'mk.id = k.merek_kendaraan_id')
						->join('jenis_kendaraan jk', 'jk.id = k.jenis_kendaraan_id')
						->join('kepemilikan_kendaraan kk', 'kk.kendaraan_id = k.id AND kk.__active >= -1')
						->join('perusahaan_angkutan pa', 'pa.id = kk.perusahaan_angkutan_id')
						->join('jenis_mobil_penarik jmp', 'jmp.id = k.jenis_mobil_penarik_id')
						->join('supir_kendaraan sk', 'sk.kendaraan_id = k.id AND sk.__active=1', 'left')
						->join('supir s', 's.id = sk.supir_id', 'left')
						->join('device_kendaraan dk', 'dk.kendaraan_id = k.id AND dk.__active=1', 'left')
						->join('device d', 'd.id = dk.device_id', 'left')
						->where('k.id', $id)
						->where('k.__active', 1)
						->get('kendaraan k');
						
		if($is_array){
			return $stmt->row_array();
		}else{
			return $stmt->row();
		}
	}
	
	public function insert($auth){
		$this->db->trans_start();
		
		$kendaraan = array(
			'jenis_kendaraan_id' => post('jenis_kendaraan_id'),
			'merek_kendaraan_id' => post('merek_kendaraan_id'),			
			'nomor_plat' => post('nomor_plat'),
			'nomor_registrasi' => post('nomor_registrasi'),
			'tahun_registrasi' => post('tahun_registrasi'),
			'jenis_mobil_penarik' => post('jenis_mobil_penarik'),
			'nomor_stnk' => post('nomor_stnk'),
			'habis_berlaku_stnk' => post('habis_berlaku_stnk'),
			'nomor_rangka' => post('nomor_rangka'),
			'nomor_mesin' => post('nomor_mesin'),
			'isi_silinder' => post('isi_silinder'),
			'warna_tnkb' => post('warna_tnkb'),
			'jumlah_ban_head_truck' => post('jumlah_ban_head_truck'),
			'__active' => 2, // Not approved
			'__created' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username,
		);
		$this->db->insert('kendaraan', $kendaraan);
		$kendaraan_id = $this->db->insert_id();
		
		$kepemilikan_kendaraan = array(
			'perusahaan_angkutan_id' => $auth->id_perusahaan_angkutan,
			'kendaraan_id' => $kendaraan_id,
			'__active' => 2, // Not approved
			'__created' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username,
		);
		$this->db->insert('kepemilikan_kendaraan', $kepemilikan_kendaraan);
		
		// Update Statistic
		$this->db->set('aktivasi_kendaraan', 'aktivasi_kendaraan + 1', false)->update('approval_stat');
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	public function update($id, $auth){
		$kendaraan = array(
			'perusahaan_angkutan_id' => post('perusahaan_angkutan_id'),
			'nomor_plat' => post('nomor_plat'),
			'nomor_registrasi' => post('nomor_registrasi'),
			'tahun_registrasi' => post('tahun_registrasi'),
			'jenis_mobil_penarik' => post('jenis_mobil_penarik'),
			'nomor_stnk' => post('nomor_stnk'),
			'habis_berlaku_stnk' => post('habis_berlaku_stnk'),
			'nomor_rangka' => post('nomor_rangka'),
			'nomor_mesin' => post('nomor_mesin'),
			'isi_silinder' => post('isi_silinder'),
			'warna_tnkb' => post('warna_tnkb'),
			'jumlah_ban_head_truck' => post('jumlah_ban_head_truck'),
			'__updated' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username,
		);
		
		$this->db->where('id', $id)->update('kendaraan', $kendaraan);
	}
	
	public function delete($id, $auth){
		$upd = array(
			'__active' => 0,
			'__updated' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username
		);
		
		$this->db->where('id', $id)->update('kendaraan', $upd);
	}
	
	public function select_plat($plat, $auth, $where = array()){
		$this->siapkanDB();
		$this->db	->select('SQL_CALC_FOUND_ROWS *', FALSE);
		
		$out = new StdClass();
		
		if($where){
			$this->db->where($where);
		}
		
		if(!$auth->is_dpp_user){
			if($auth->id_perusahaan_angkutan){
				$this->db->where('kk.perusahaan_angkutan_id', $auth->id_perusahaan_angkutan);
			}
		}
		
		$out->datasource = $this->db->select('k.*, mk.merek_kendaraan, jk.jenis_kendaraan, jmp.jenis_mobil_penarik')
									->join('merek_kendaraan mk', 'mk.id = k.merek_kendaraan_id')
									->join('jenis_kendaraan jk', 'jk.id = k.jenis_kendaraan_id')
									->join('kepemilikan_kendaraan kk', 'kk.kendaraan_id = k.id')
									->join('jenis_mobil_penarik jmp', 'jmp.id = k.jenis_mobil_penarik_id')
									->like('k.nomor_plat', $plat)
									->get('kendaraan k')->result();
		
		$out->actualRows = $this->db->query("SELECT FOUND_ROWS() as numRows")->row()->numRows;
		
		return $out;
	}
	public function set_status($id, $auth, $status_code){
		$this->db->trans_start();
		
		$upd_template = array(
			'__active' => $status_code,
			'__updated' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username
		);
		
		// Main Data
		$this->db->where('id', $id)->update('kendaraan', $upd_template);
		
		// Pool
		$this->db->where('kendaraan_id', $id)->update('kepemilikan_kendaraan', $upd_template);
		
		// Update Statistic
		$this->db->set('aktivasi_kendaraan', 'aktivasi_kendaraan - 1', false)->update('approval_stat');
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	public function approve($id, $auth){
		$this->set_status($id, $auth, 1);
	}
	
	public function reject($id, $auth){
		$this->set_status($id, $auth, -1);
	}
	
	public function associate($id, $supir_id, $auth){
		$this->db->trans_start();
		
		// Template
		$upd_template = array(
			'__updated' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username
		);
		$supir_pre = $this->db->where('kendaraan_id', $id)
						->where('__active', 1)
						->get('supir_kendaraan')->row();
						
		if($supir_pre){
			$supir_prev = array(
				'is_associated' => 0	
					);
			$this->db->where('id', $supir_pre->supir_id)->update('supir', $supir_prev);
		}
		
		// Inactive Existing
		$this->db	->set($upd_template)
					->set('__active', 0)
					->where('kendaraan_id', $id)
					->update('supir_kendaraan');
					
		// Create New
		$supir_kendaraan = array(
			'kendaraan_id' => $id,
			'supir_id' => $supir_id,
			'__active' => 1,
			'__created' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username,
		);
		$this->db->insert('supir_kendaraan', $supir_kendaraan);
		$supir_kendaraan_id = $this->db->insert_id();
		
		$supir_ass = array(
			'is_associated' => 1	
				);
		$this->db->where('id', $supir_id)->update('supir', $supir_ass);
		
		
		// Update Statistic
		$this->db->set('asosiasi_supir_kendaraan ', 'asosiasi_supir_kendaraan  + 1', false)->update('approval_stat');
		
		$this->db->trans_complete();
		
		if($this->db->trans_status()){
			return $supir_kendaraan_id;
		}else{
			return FALSE;
		}
	}
	
	public function associate_device($id, $device_id, $auth){
		$this->db->trans_start();
		
		// Template
		$upd_template = array(
			'__updated' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username
		);
		
		$device_pre = $this->db->where('kendaraan_id', $id)
						->where('__active', 1)
						->get('device_kendaraan')->row();
						
		if($device_pre){
			$device_prev = array(
				'is_associated' => 0	
					);
			$this->db->where('id', $device_pre->device_id)->update('device', $device_prev);
		}
		
		// Inactive Existing
		$this->db	->set($upd_template)
					->set('__active', 0)
					->where('kendaraan_id', $id)
					->update('device_kendaraan');
					
					
		// Create New
		$device_kendaraan = array(
			'kendaraan_id' => $id,
			'device_id' => $device_id,
			'__active' => 1,
			'__created' => date('Y-m-d H:i:s'),
			'__operator' => $auth->username,
		);
		$this->db->insert('device_kendaraan', $device_kendaraan);
		
		
		$device_kendaraan_id = $this->db->insert_id();
		
		$device_ass = array(
			'is_associated' => 1	
				);
		$this->db->where('id', $device_id)->update('device', $device_ass);
		
		
		// Update Statistic
		$this->db->set('asosiasi_device_kendaraan ', 'asosiasi_device_kendaraan  + 1', false)->update('approval_stat');
		
		$this->db->trans_complete();
		
		if($this->db->trans_status()){
			return $device_kendaraan_id;
		}else{
			return FALSE;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}