<?php
/**
 * the base class for controllers
 */
class Controller{
	
	public $microbe;
	
	/**
	 * if true, ignore the $action extablished value.
	 *  You should use the function $icrobe->setPage with the new value.
	 */
	public $discard_route_to_view = false;
	
	public function __construct( &$microbe ){
		$this->microbe = $microbe;
		$this->init();
		if( empty( $microbe->action ) ){
			$this->indexAction();	
		} else {
			$action = $this->_action();
			$this->$action();	
		}
		$this->drop();
	}
	
	protected function _action(){
		return str_replace("-","", $this->microbe->action )."Action";
	}
	
	public function ignoreView(){
		$this->discard_route_to_view = true;
		
	}
	
	public function setView( $view ){
		$this->microbe->setPage( $view );
	}
	
	public function init(){
		
	}
	
	

	/**
	 * this function may return a string value, or null or false.
	 * This funciton return false only when the validator attached fails.
	 */
	public function getParam( $key, Ui_Validator &$validator = null ){
		if( empty( $_REQUEST[ $key ] ) )
			return null;
		if( $validator == null )
			return $_REQUEST[ $key ];
			
		if( !$validator->isValid( $_REQUEST[ $key ] )){
			return false;
		}
		
		return  $_REQUEST[ $key ];
	}

	/**
	 * the end of all things, just before outputting the layout
	 */	
	public function drop(){
		
	}
	public function indexAction(){
		
	}
	
		
}

?>
