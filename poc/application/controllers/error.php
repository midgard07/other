<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Error extends CI_Controller {
	public function __construct(){
		parent::__construct();	
	}

	public function index(){
		show_404();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */