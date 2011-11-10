<?php
/**
 * the base class for controllers.
 * The constructor call successively:
 *   + the init() method
 *   + the desired function ( action + "Action"() ), if any; @todo action not found
 *   + the drop() method, which sometimes could be useful.
 */
class Controller{
	
	public $microbe;
	
	/**
	 * if true, ignore the $action extablished value.
	 *  You should use the function $icrobe->setPage with the new value.
	 */
	public $discard_route_to_view = false;
	
	/**
	 * if true, ignore the $action extablished value.
	 *  You should use the function $icrobe->setPage with the new value.
	 */
	public $discard_route_to_layout = false;
	
	public function __construct( &$microbe ){
		$this->microbe = $microbe;
		$this->init();
		if( empty( $microbe->action ) ){
			$this->indexAction();	
		} else {
			$action = $microbe->action."Action";
			$this->$action();	
		}
		$this->drop();
	}
	
	public function emptyLayout(){
       $this->discard_route_to_layout = true;
       header( "Content-type: text/plain" );
  }
	
	public function ignoreView(){
		$this->discard_route_to_view = true;
		
	}
	
	public function setView( $view ){
		$this->microbe->setPage( $view );
	}
	
	public function init(){
		
	}
	
	public function drop(){
    
  }
	
	public function indexAction(){
		
	}
	
	public function __call( $a, $b ){
    throw( new Exception( "requested action $a was not found...", 404) );
  }
}

?>