<?php
/**
 * @package Dnst_Json
 */
 
/**
 * Handle a json response, with an useful method 
 * throwError which do an exit() command.
 * Basic (void response) 
 * The __toString() method try to json_encode the content.
 * usage Basic (void response) :
 * 
 * $response = new Dnst_Json_Response();
 * $response->hello_world = "hello-world";
 * echo $response; 
 */
 
class Dnst_Json_Response{
	
	protected $_json;
	
	public function __construct(){
		$this->_json = (object) array();
	}
	
	public function setStatus( $status ){
		$this->_json->status = $status;
	}
	
	public function setAction( $action ){
		$this->_json->action = $action;
	}
	
	public function throwError( $error ){
		$this->_json->status = 'ko';
		$this->_json->error  = $error;
		exit( $this );
	}
	
	public function __set( $key, $value ){ 
		$this->_json->$key = $value; 
    } 
	
	public function __toString(){
		return json_encode( $this->_json );
	}
	
	
}