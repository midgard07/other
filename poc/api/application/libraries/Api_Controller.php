<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_Controller extends CI_Controller {
	protected $auth;
	
    public function __construct() {
        parent::__construct();
		
		$this->auth = $this->UserAuth->getLoginData();
    }
    
    protected function main($var = null) {
		$out = new StdClass();
        $auth = $this->auth;
		
        $out->is_error = false;
        $out->status_code = 200;

        if ($auth === false) {
            $out->is_error = true;
            $out->status_code = 101;
            $out->status_msg = 'Authentication Failed';
        } else {
            try {
				$request_method = $this->input->server('REQUEST_METHOD');
				
				if(method_exists($this, 'process_'.strtolower($request_method))){				
					switch ($request_method) {
						case 'GET':
							$out->status_code = "01";
							$out->status_msg = "Berhasil";
                            if($auth->id_perusahaan_angkutan){
                                $where = "where perusahaan_angkutan_id = ".$auth->id_perusahaan_angkutan." and a.__active = 1";
                            }else{
                                $where="where a.__active = 1";
                            }
                            $currPage = get('currPage') == null ? 1 : get('currPage');
                            if($var == 'supir'){
                                $row = $this->db->query(
                                    "select count(1) as total_row from supir a ".$where
                                    )->result();
                                $out->total_row = $row[0]->total_row;
                            	$out->currPage = $currPage;
                            }else if($var == 'kendaraan'){
                                $row = $this->db->query(
                                    "select count(1) as total_row from kendaraan a
                                    join kepemilikan_kendaraan b on a.id = b.kendaraan_id ".$where
                                    )->result();
                                $out->total_row = $row[0]->total_row;
                            	$out->currPage = $currPage;
                            }
                            $out->payload = $this->process_get($auth);
							break;
						case 'POST':
							$out->status_code = "01";
							$out->status_msg = "Berhasil";
							$out->payload = $this->process_post($auth);
							break;
						case 'UPDATE':
						case 'PUT':
							$out->payload = $this->process_update($auth);
							break;
						default:
							$out->is_error = true;
							$out->status_code = 201;
							$out->status_msg = 'Invalid Method';
					}
				}else{
					$out->is_error = true;
					$out->status_code = '202';
					$out->status_msg = 'Method not available for this class';
				}
            } catch (Exception $e) {
                $out->is_error = true;
                $out->status_code = $e->getCode();
                $out->status_msg = $e->getMessage();
            }
        }
		
        echo pretty_print_json(json_encode($out));
    }

    private function filter($obj,$filter) {
        $result = array();
        foreach ($obj as $key => $item) {
            if (in_array($key, $filter)) {
                $result[$key] = $item;
            }
        }
        return $this->sortArrayByArray($result, $filter);
    }
    
	private function get_grid_related_config(){
		$out = new StdClass();
		$out->page = get('page');
		$out->row_per_page = get('row_per_page');
		$out->search_field = get('search_field');
		$out->search_keyword = get('search_keyword');
		$out->sort_field = get('sort_field');
		$out->sort_order = get('sort_order');
		
		return $out;
	}
	
    private function send($data, $filter) {
        if($data){
            return $this->filter($data, $filter);
        }else{
            throw new Exception('Data Tidak Ditemukan', 404);
        }
    }

    protected function logging_desktop_app($param = null, $gate = null){
        
        if($param != null){
            $operator = $this->db->where('id_perusahaan_angkutan', $param)
                                ->where('is_admin_perusahaan', 1)
                                ->join('acl_user au', 'au.id = asr.user_id')
                                ->get('acl_std_role asr')->row()->username;
        }

        if($this->input->server('REQUEST_METHOD') === 'POST'){
            $method = 'POST';
            $parameter = serialize($_POST);
        }else if($this->input->server('REQUEST_METHOD') === 'GET'){
            $method = 'GET';
            $parameter = serialize($_GET);
        }else{
            $method = 'UNKNOWN';
            $parameter = 'UNKNOWN';
        }
        // save to database
        if($gate != null){
            $data = array(
                'function' => $_SERVER['REDIRECT_URL'],
                'method' => $method,
                'parameter' => $parameter,
                'transcation_date' => date('Y-m-d H:i:s'),
                'operator' => $gate,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
        }else{
            $data = array(
                'function' => $_SERVER['REDIRECT_URL'],
                'method' => $method,
                'parameter' => $parameter,
                'transcation_date' => date('Y-m-d H:i:s'),
                'operator' => $param == null ? $this->auth->username : $operator,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
        }

        $this->db->insert('logging_desktop_app',$data);
    }

    protected function logging_webservice($param){
        if($this->input->server('REQUEST_METHOD') === 'POST'){
            $method = 'POST';
            $parameter = serialize($_POST);
        }else if($this->input->server('REQUEST_METHOD') === 'GET'){
            $method = 'GET';
            $parameter = serialize($_GET);
        }else{
            $method = 'UNKNOWN';
            $parameter = 'UNKNOWN';
        }
        $data = array(
                'function' => $_SERVER['REDIRECT_URL'],
                'method' => $method,
                'parameter' => $parameter,
                'transcation_date' => date('Y-m-d H:i:s'),
                'operator' => $param,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );

        $this->db->insert('logging_desktop_app',$data);
    }
    
}

?>
