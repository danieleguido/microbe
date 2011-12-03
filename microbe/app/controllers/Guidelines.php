<?php
/**
 *
 */
class Guidelines extends SemanticController {

	public function init(){
		$this->microbe->title = translate( "guidelines" );
		$this->microbe->description = translate( "a css style sheet to use directly into your project" );
	}	

	public function indexAction(){
		$this->load();
	}	

	

}
?>
