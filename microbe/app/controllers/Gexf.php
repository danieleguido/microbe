<?php
/**
 * gexf controller
 */
class Gexf extends Controller{
	public function init(){
		$this->microbe->title= translate("Gexf tools");	
	}
	public function indexAction(){
		// $this->microbe->cleanLayout();
		
	}	
	
	public function bipartiteAction(){
		// get uploaded stuff...
		$upload = new Zend_File_Transfer();
		$this->microbe->description= translate("transform a graph bipartite into two monopartite");	
	}
	
	public function formAction(){
		
	}
}
?>