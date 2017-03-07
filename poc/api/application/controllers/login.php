<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH.'libraries/Api_Controller.php');

/** Auth
 * Basic Authentication Module
 *
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
	
    public function index() {
        $val = $this->form_validation;
		$out = new StdClass();
		
		$out->is_error = true;
		$out->status_code = NULL;
		$out->status_msg = NULL;
		$out->payload = new StdClass();
		
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $val->set_rules('username', 'Username', 'required');
            $val->set_rules('email', 'Email', '');
            $val->set_rules('password', 'Password', 'required');

            if ($val->run()) {
				if(post('username')){
					$where = array(
						'username' => post('username'),
						'password' => md5(post('password'))
					);
				}else{
					$where = array(
						'email' => post('email'),
						'password' => md5(post('password'))
					);
				}
                
				$user = $this->db->where($where)->get('acl_user')->row();
				
                if ($user) {
					$acl = $this->db->where('user_id', $user->id)->get('acl_std_role')->row();
					

					if($acl){
						$out->is_error = false;
						
						$payload = new StdClass();
						
						$payload->login_status = 1;
						$payload->username = $user->username;
						$payload->PHPSESSID = session_id();
						foreach ($acl as $key => $value) {
							$payload->{$key} = $value;
						}
						
						$out->payload = $payload;
						$out->status_code = '01';
						$out->status_msg = "Berhasil";
						$this->UserAuth->setLoginData($payload);
					}else{
						$out->status_code = 404;
						$out->status_msg = 'Gagal Login. Tidak ada ACL Role untuk user ini.';
					}
                } else {
					$out->status_code = 404;
					$out->status_msg = 'Gagal Login. Username atau password salah.';
                }
            } else {
				$out->status_code = 500;
				$out->status_msg = validation_errors();
            }
        }else{
			$out->status_code = 501;
			$out->status_msg = 'No POST data received';
		}
					
		echo pretty_print_json(json_encode($out));

    }

}

/* End of file auth.php */
/* Location: ./application/controllers/api/login.php */