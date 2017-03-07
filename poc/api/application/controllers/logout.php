<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH.'libraries/Api_Controller.php');

/** Auth
 * Basic Authentication Module
 *
 */
class Logout extends Api_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->main();
    }
	
	protected function process_get(){
		session_destroy();
		$this->UserAuth->clearLoginData();
		
		$out = new StdClass();
		$out->logout_status = 1;
		
		return $out;	
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */