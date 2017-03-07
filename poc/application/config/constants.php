<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Important pages
|--------------------------------------------------------------------------
|
| 
|
*/

define('LOGIN_PAGE',							'front');
define('DASHBOARD',								'dashboard');
define('DASHBOARD_OTHER',								'dashboard/index_other');

// path file upload document perusahaan
define('PATH_UPLOAD_PERUSAHAAN',	'./uploads/perusahaan/');
// path file upload document perusahaan hist
define('PATH_UPLOAD_PERUSAHAAN_HIST',	'./uploads/perusahaan_hist/');
// path file upload document kendaraan
define('PATH_UPLOAD_KENDARAAN',	'./uploads/kendaraan/');
// path file upload document kendaraan hist
define('PATH_UPLOAD_KENDARAAN_HIST',	'./uploads/kendaraan_hist/');
// path file upload document supir
define('PATH_UPLOAD_SUPIR',	'./uploads/supir/');
// path file upload document supir hist
define('PATH_UPLOAD_SUPIR_HIST',	'./uploads/supir_hist/');
// path file upload document device
define('PATH_UPLOAD_DEVICE',	'./uploads/device/');
// path file upload document device hist
define('PATH_UPLOAD_DEVICE_HIST',	'./uploads/device_hist/');

// define default email notification
define('FROM_EMAIL', 'admin_siab@mail.com');
define('ALIAS_FROM_EMAIL', 'SIAB Admin');
// define email miles
define('EMAIL_MILES', 'nurdin@ilcs.co.id');
//define email aptrindo
define('EMAIL_APTRINDO', 'nurdinsidik07@gmail.com');
// define email bcc
define('EMAIL_BCC', 'nurdin@ilcs.co.id,nurdinsidik07@gmail.com');

// variable link dasar untuk email
define('DEFAULT_HALAMAN', 'http://103.19.81.26:5180/siab/web/');

// variable posisi upload int
define('DEFAULT_POS',23);

/*
|--------------------------------------------------------------------------
| Sub Application Database Config
|--------------------------------------------------------------------------
|
| 
|
*/

define('ILCS_MASTER_REFERENCE_DB', 'ilcs_master_reference');
define('ILCS_MANIFEST_DB', 'ilcs_manifest');
define('ILCS_DELIVERY_ORDER_DB', 'ilcs_delivery_order');
define('EDI_INTERFACE_DB', 'edi_interface');
define('ILCS_TPS_ONLINE', 'ilcs_tps_online');
define('IPC_DB', 'ipc_db');
define('ILCS_EXCHANGE_DB', 'ilcs_exchange');

/*
|--------------------------------------------------------------------------
| SOAP Endpoints
|--------------------------------------------------------------------------
|
| 
|
*/

//define('ENDPOINT_MANIFACE',		'http://server01.ilcs.co.id:15002/service/maniface');
define('ENDPOINT_MANIFACE',		'http://localhost:15001/service/maniface');



/*
|--------------------------------------------------------------------------
| ILCS Manifest
|--------------------------------------------------------------------------
|
| 
|
*/
define('MANIFEST_FILE_STORE_BASE', './assets/file_storage/manifest');
define('MANIFEST_FILE_RETRIEVE_BASE', '/assets/file_storage/manifest');


define('EXCHANGE_FILE_STORE_BASE', './assets/file_storage/exchange');
define('EXCHANGE_FILE_RETRIEVE_BASE', '/assets/file_storage/exchange');

/* End of file constants.php */
/* Location: ./application/config/constants.php */