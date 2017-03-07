<?php
class verification extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function recon($str){
		$mod = model('user_recon_model');
		$user = $mod->get_by_user_id($str);
		$ui_messages = array();
		$message='';
		$pass = '';
		
		if($user){
			if(is_post_request()){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('password', 'Password', 'required|callback_checkPassword');
				
				if($this->form_validation->run()){
					$exp_date = date('d-m-Y H:i:s', strtotime("$user->EXPRD - 7 day"));
					$mod->update_password($str, post('password'), $exp_date);
					redirect('verification/success');
				}else{
					$is_error = 'true';
					$ui_messages[] = array(
						'severity' => 'ERROR',
						'title' => 'Isian Masih Salah',
						'message' => 'Silakan perbaiki isian sesuai yang tertera',
					);
				}
			}else{

			}

			if($user->EXPRD < date('Y-m-d H:i:s')){
				$is_error = 'true';
				$message = 'Link tersebut sudah expired';
			}else{
				$pass = $this->randomPassword();
				$mod->update_password($str, $pass);
				$is_error = 'false';
				$message = 'Ok';
			}
		}else{
			$is_error = 'true';
			$message = 'Data tidak ada';
		}

		// Layout Data
		$data = array(
			'is_error' => $is_error,
			'message' => $message,
			'user' => $user,
			'pass' => $pass,
			'ui_messages' => $ui_messages,
		);
		// var_dump($data);exit();
		$this->load->view('backend/pages/verification/recon', $data);
	}

	public function pos($str){
		$mod = model('user_pos_model');
		$user = $mod->get_by_user_id($str);
		$ui_messages = array();
		$message='';
		$pass = '';
		
		if($user){
			if(is_post_request()){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('password', 'Password', 'required|callback_checkPassword');
				
				if($this->form_validation->run()){
					$exp_date = date('d-m-Y H:i:s', strtotime("$user->EXPRD - 7 day"));
					$mod->update_password($str, post('password'), $exp_date);
					redirect('verification/success');
				}else{
					$is_error = 'true';
					$ui_messages[] = array(
						'severity' => 'ERROR',
						'title' => 'Isian Masih Salah',
						'message' => 'Silakan perbaiki isian sesuai yang tertera',
					);
				}
			}else{

			}

			if($user->EXPRD < date('Y-m-d H:i:s')){
				$is_error = 'true';
				$message = 'Link tersebut sudah expired';
			}else{
				$pass = $this->randomPassword();
				$mod->update_password($str, $pass);
				$is_error = 'false';
				$message = 'Ok';
			}
		}else{
			$is_error = 'true';
			$message = 'Data tidak ada';
		}

		// Layout Data
		$data = array(
			'is_error' => $is_error,
			'message' => $message,
			'user' => $user,
			'pass' => $pass,
			'ui_messages' => $ui_messages,
		);
		// var_dump($data);exit();
		$this->load->view('backend/pages/verification/pos', $data);
	}

	public function force($str){
		$mod = model('user_force_model');
		$user = $mod->get_by_user_id($str);
		$ui_messages = array();
		$message='';
		
		if($user){
			if(is_post_request()){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('password', 'Password', 'required|callback_checkPassword');
				
				if($this->form_validation->run()){
					$exp_date = date('d-m-Y H:i:s', strtotime("$user->EXPRD - 7 day"));
					$mod->update_password($str, post('password'), $exp_date);
					redirect('verification/success');
				}else{
					$is_error = 'true';
					$ui_messages[] = array(
						'severity' => 'ERROR',
						'title' => 'Isian Masih Salah',
						'message' => 'Silakan perbaiki isian sesuai yang tertera',
					);
				}
			}else{

			}

			if($user->EXPRD < date('Y-m-d H:i:s')){
				$is_error = 'true';
				$message = 'Link tersebut sudah expired';
			}else{
				// $mod->update_password($str);
				$is_error = 'false';
				$message = 'Ok';
			}
		}else{
			$is_error = 'true';
			$message = 'Data tidak ada';
		}

		// Layout Data
		$data = array(
			'is_error' => $is_error,
			'message' => $message,
			'user' => $user,
			'pass' => $user->PWD,
			'ui_messages' => $ui_messages,
		);
		// var_dump($data);exit();
		$this->load->view('backend/pages/verification/force', $data);
	}

	function randomPassword() {
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

	public function success(){
		$this->load->view('backend/pages/verification/success');
	}

	function checkPassword($pwd) {
	    $is_error = 0;
	    $message = '';
	    if (strlen($pwd) < 8) {
	        $message .= "Password terlalu pendek, minimal 8 karakter! <br />";
	        $is_error = 1;
	    }
		if (strlen($pwd) > 20) {
	        $message .= "Password terlalu panjang, maksimal 20 karakter! <br />";
	        $is_error = 1;
	    }
	    if (!preg_match("#[0-9]+#", $pwd)) {
	        $message .= "Password harus mengandung angka! <br />";
	        $is_error = 1;
	    }
	    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
	        $message .= "Password harus mengandung huruf! <br />";
	        $is_error = 1;
	    }  
		if (!preg_match('/[\!@\$%\^&\*\(\)_\-\+=]/', $pwd)) {
	        $message .= "Password harus mengandung karakter spesial (!@$%^&*()_+-=)! <br />";
	        $is_error = 1;
	    }  	
		if (preg_match('/[\']/', $pwd)) {
	        $message .= "Password tidak boleh menggunakan karakter petik (')! <br />";
	        $is_error = 1;
	    } 

		
		if($is_error == 1){
			$this->form_validation->set_message('checkPassword',$message);
			return FALSE;
		}else{
			return TRUE;
		}
	}
}