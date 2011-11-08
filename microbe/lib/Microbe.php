<?php
/**
 * a dummy class. DO NOT USE ECHO HERE
 */
class Microbe{
	
	public function __construct( ){
	}	
	
	public $page = THE_MICROBE_DEFAULT_PAGE;
	
	public function setPage( $page ){
		
		$this->page = $page;
	}
	
	public function doPage(){
		include APPLICATION_PATH."/pages/".$this->page.".php";
	}
	
	public function isAppUrl(){
		 
		 // subract the url
		 $url = trim( substr( $_SERVER[ 'REDIRECT_URL' ], strlen( THE_URL ) ) );
		 
		 // trim trailing slashes
		 $url = trim( $url, "/" );
		 
		 // THE_MICROBE_404_PAGE
		 $routes =  explode("/", $url ) ;
		 
		 if( empty( $routes ) ){
		 	// default page
		 	$this->setPage( THE_MICROBE_DEFAULT_PAGE );
		 	return true;	
		 }
		 
		 $cw = $routes;
		 if( count( $routes ) > 2 ){
		 	// slice and return the first two as controller view actions	
		 } 
		 $view_filepath = APPLICATION_PATH."/pages/".implode("/", $cw ).".php";
		 
		 
		 // set as page the view
		 if( file_exists(  $view_filepath ) ){
		 	$this->setPage( implode("/", $cw ) );
		 	return true;	
		 }
		 
		 return false;
	}
}