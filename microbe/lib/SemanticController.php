<?php
/**
 * This controller class load meta information about the controller and its pages 
 * from the db, usign redbean ORM. Use this type of controller when your pages have meta tags
 * Use the load() function to get all the information about the page.
 */
class SemanticController extends Controller{
	/**
	 * Called somewhere in your controller, this function load the page instance that could be retrieved
	 * with the $this->_page class variable.
	 * All defined constant related to orm redbean are stored inside the orm.php file.
	 */
	public function load( $autoinstall = REDBEAN_ENABLE_AUTOINSTALL ){
		
		$this->_page = R::findOne( 'page',' `alias` = ?', array( $this->microbe->controller.".".$this->microbe->action ) );
		
	
		$tag = R::dispense( 'tag' );
		$tag->content = "comment";
		$id = R::store( $tag );
		
		$message = R::dispense( 'message' );
		$message->sharedTag[] = $tag;
		$message->content = "a very long content, indeed";

		R::store( $message );

		$this->_page->sharedMessage[] = $message;
		R::store( $this->_page );

		print_r( $this->_page );

		if( $this->_page != null )
			return;

		if(	$autoinstall ==  REDBEAN_ENABLE_AUTOINSTALL )
			return $this->install();

		throw new Exception( "failure in loading meta information", REDBEAN_LOAD_FAULT );
	}
	
	/**
	 * remove the page object from the database. See install() function for more information.
	 */
	public function remove(){
		if( $this->_page == null )
			throw new Exception( "failure in removing bean", REDBEAN_LOAD_FAULT ) ;
	}
	
	/**
	 * install a page object inside the database.
	 * It creates a bean (Cfr. http://redbeanphp.com/manual/create_a_bean ) of type "page"
	 * which contains some basic information: title and alias (the friendly url).
	 * Install funciton is called automatically by the load() function, when no page could be found.
	 * If it fails, it will throws an exception.
	 */	
	public function install(){
		$page = R::dispense( 'page' );
		$address = $this->microbe->controller.".".$this->microbe->action;
		$page->title =  $address;
		$page->alias =  $address;
		$id = R::store( $page );
		$this->page = $page;	
	}
}

?>
