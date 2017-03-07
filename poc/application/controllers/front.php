<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Front extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->library(array('form_validation'));	
	}

	public function index(){	
		// Dapatkan data login
		if($this->userauth->getLoginData()){
			redirect(DASHBOARD);
		}
	
		$view = array();
		
		// Proses ketika ada POST
		if(post()){
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_captcha_check');

			if($this->form_validation->run()){
				$username = post('username');
				$password = post('password');

				if($this->userauth->checkLogin($username, $password)){
					// Sukses Login
					redirect(DASHBOARD);
				}else{
					// Gagal Login, tampilkan pesan kesalahan
					$view['error_msg'] = 'Username atau password salah';
				}
			}else{
				$view['error_msg'] = validation_errors();
			}
		}
		
		// Reset Captcha
		$this->session->set_userdata('captcha_key', uniqid()); 
		$this->load->view('frontend/pages/front/index', $view);
	}

	public function logout(){
		$this->userauth->clearLoginData();
		redirect(LOGIN_PAGE);
	}

	public function show_captcha(){
		$string = '';  
		  
		for ($i = 0; $i < 5; $i++) {  
			// this numbers refer to numbers of the ascii table (lower case)  
			$string .= chr(rand(97, 122));  
		}  
		  
		$this->session->set_userdata('captcha_key', $string); 
		  
		$dir = "./assets/fonts/";  
		  
		$image = imagecreatetruecolor(170, 60);  
		$black = imagecolorallocate($image, 0, 0, 0);  
		$color = imagecolorallocate($image, 200, 100, 90); // red  
		$white = imagecolorallocate($image, 255, 255, 255);  
		  
		imagefilledrectangle($image, 0, 0, 399, 99, $white);  
		imagettftext($image, 30, 0, 10, 40, $color, $dir."sketch_block.ttf", $string);  
		  
		header("Content-type: image/png");  
		imagepng($image);
	}

	// Implement Captcha Check
	public function captcha_check($str)
	{
		if($str){
			if($this->session->userdata('captcha_key') && strtolower($str) == strtolower($this->session->userdata('captcha_key'))){
				return TRUE;
			}else{
				$this->form_validation->set_message('captcha_check', 'Teks yang anda ketik salah, silakan coba kembali');
				return FALSE;
			}
		}else{
			$this->form_validation->set_message('captcha_check', 'Harap ketik teks yang tampil di layar');
			return FALSE;
		}
	}
	
	
	// Test Email
	public function test_email(){
		$to      = 'djati@ilcs.co.id';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: webmaster@inaportnet.com' . "\r\n" .
			'Reply-To: webmaster@inaportnet.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		var_dump(mail($to, $subject, $message, $headers));

	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */