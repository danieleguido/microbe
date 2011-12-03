<?php
/**
 * a base class for api text-only controller
 */
class ApiController extends Controller{
	
	public $response;	

	public function init(){
		header( "Content-type: text/plain;charset=UTF-8", true );
		$this->ignoreView();
		$this->response = new Response();
		$this->response->setStatus("ok");
		$this->response->setAction( $this->microbe->action );
		if( isset( $_REQUEST[ 'verbose' ] ) ){
			$this->response->request = $_REQUEST;
		}
	}
	
	public function drop(){
		exit ( $this->response);
	}

	public function __call( $a, $b ){
		$this->response->throwError( "'{$this->microbe->action}' action was not found" );
	}
}

?>
