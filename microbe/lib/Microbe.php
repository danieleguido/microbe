<?php
/**
 * a dummy class. DO NOT USE ECHO HERE
 */
class Microbe{
	
	public function __construct( ){
	}	
	
	public $page = THE_MICROBE_DEFAULT_PAGE;
	
	/** 
	 * the desired controller, object
	 */
	public $controller;
	
	/**
	 * the desired action, object
	 */
	public $action;
	
	/**
	 * a void object that can contain a lot of object
	 */
	public $vars;
	
	/**
	 * the full route as has been understood
	 */
	public $routes;
	
	/**
	 * retrive the controller / action couple
	 */
	public $address;
	
	public function setPage( $page ){
		
		$this->page = $page;
	}
	
	public function cleanLayout(){
		exit;	
	}
	
	public function doPage(){
		include APPLICATION_PATH."/pages/".$this->page.".php";
	}
	
	
	public function init(){
		 $this->vars = (object) array();
		 
		 # subract the url
		 $url = trim( substr( $_SERVER[ 'REDIRECT_URL' ], strlen( THE_URL ) ) );
		 
		 # trim trailing slashes
		 $url = trim( $url, "/" );
		 $this->routes =  explode("/", $url ) ;
		 
		 if( empty( $this->routes ) ){
		 	# set the default page
		 	$this->setPage( THE_MICROBE_DEFAULT_PAGE );
		 	return;
		 		
		 } else if( count( $this->routes ) == 1 ){  
		 	
		 	# simplify if the routes is a single controller request...
		 	return $this->forward( $this->routes[ 0 ] );
		 
		 } 
		 
		 // copy routes array
		 $this->address = $this->routes;
		 
		 if( count( $this->routes ) > 2 ){
		 	// slice and return the first two as controller view actions. remaining parts are stored inside the $this->router variable 
		 	$this->address = array_slice( $this->address, 0, 2 );
		 }
		 
		 return $this->forward( $this->address[ 0 ], $this->address[ 1 ] );
		 
	}
	
	public $errors = array();
	
	public function error( $error ){
		$this->errors[] = $error;
	}
	
	/**
	 * delegate a controller to serve the page
	 */
	public function forward( $controller, $action = THE_MICROBE_DEFAULT_ACTION ){
		$this->action = $action;
		$this->setPage( THE_MICROBE_404_PAGE );
			
		# check that the controller exists
		$controller_class = ucfirst( str_replace("-","_", $controller ) );
		$controller_path = CONTROLLERS_PATH."/".$controller_class.".php";
		if( file_exists( $controller_path ) ){
			# include class
			require $controller_path;
			
			# build. auto init and auto forward to action.
			$this->controller = new $controller_class( $this );	
			
			# leave freedom to controller to change route.
			if( $this->controller->discard_route_to_view ){
				return;	
			}
		}
		
		# if exists, 
		$view_filepath = VIEWS_PATH."/".$controller."/".$action.".php";
		
		# check that the view exists
		if( !file_exists(  $view_filepath ) ){
			$this->error( "view file was not found..." );
			$this->setPage( THE_MICROBE_404_PAGE );
		} else {
			$this->setPage( $controller."/".$action );
		}
	}
	
	/**
	 * @return the url param value
	 * e.g
	 * the url /microbe/silly/url/user/daniele contains 
	 * controller: silly, action: url, param 'user'='daniele'
	 */
	public function getParam( $param ){
		
	}
}