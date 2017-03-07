<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require_once(APPPATH.'libraries/Api_Controller.php');

/** Core
 * Truck Related edges
 *
 */
class Kendaraan extends Api_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->main();
    }
		
    protected function process_get($auth) {		
        $mod = model('kendaraan_model');
		$id = get('id');
		
		$datasource = array();
		
		if($id){
			// Single Row Mode
			$row = $mod->get($id, $auth);
			
			if($row){
				
				$datasource[] = $row;
			}else{
				throw new Exception('Tidak ditemukan Kendaraan dengan ID:'.$id, 404);
			}
		}else{
			// Multi Row Mode
			$cfg = new StdClass();
			$cfg->sortField = NULL;
			$cfg->sortMethod = NULL;
			$cfg->searchField = NULL;
			$cfg->keyword = NULL;
			$cfg->currPage = 1;
			$cfg->rowPerPage = DEFAULT_ROW_PER_PAGE;
			
			$mod->terapkanConfig($cfg);
			$datasource = $mod->select($auth, array('k.__active' => 1))->datasource;
		}
		
        return $datasource;
    }

}

/* End of file kendaraan.php */
/* Location: ./application/controllers/kendaraan.php */