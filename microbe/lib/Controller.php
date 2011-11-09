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
			$action = $microbe->action."Action";
			$this->$action();	
		}
	}
	
	public function ignoreView(){
		$this->discard_route_to_view = true;
		
	}
	
	public function setView( $view ){
		$this->microbe->setPage( $view );
	}
	
	public function init(){
		
	}
	
	public function indexAction(){
		
	}
	
		
}

?>