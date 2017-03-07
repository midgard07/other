<?php
class Exchange_Exception extends Exception{
	const INFO = 'INFO';
	const WARNING = 'WARNING';
	const ERROR = 'ERROR';
	
	public $severity = NULL;
	public $title = NULL;
	public $message = NULL;
	public $message_code = NULL;
	public $actions = NULL;
	public $payload = NULL;
	
	public function __construct($message = NULL, $message_code = NULL, $severity = NULL, $title = NULL, $actions = NULL){
		parent::__construct($message, $message_code);
		
		$this->severity = $severity;
		$this->title = $title;
		$this->message = $message;
		$this->message_code = $message_code;
		$this->actions = $actions;
	}
	
	public function set_payload(&$payload){
		$this->payload = $payload;
	}
	
}