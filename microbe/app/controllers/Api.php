<?php
 /**
  * BAsic controller class for API json response.
  * ignore the layout.
  */
class Api extends Controller{
  protected $_response;

  public function init(){
    // create a void layout
    $this->emptyLayout();
    $this->_response = new Dnst_Json_Response();
    $this->_response->action = $this->microbe->action;
  }
  
  public function indexAction(){
    
    $this->_response->hello_world = "hello-world";
    
  }
  
  public function drop(){
    echo $this->_response;
  }
  
  public function __call( $a, $b ){
    $this->_response->throwError( "requested action $a was not found..." );
  }
}    

?>