<?php
/**
 * gexf controller
 */
class Heatgraph extends Controller{
	public function init(){
		$this->microbe->title= translate("Heat graph");	
		$this->microbe->description= translate("Heat graph");
	}
	public function indexAction(){
		// $this->microbe->addStylesheet( STATIC_URL."/css/heatgraph/text.css");
		$this->microbe->addStylesheet( STATIC_URL."/css/heatgraph/sandbox.css");
		
		$this->microbe->addScript( STATIC_URL."/js/heatgraph/base64.js");
		$this->microbe->addScript( STATIC_URL."/js/heatgraph/canvas2image.js");
		$this->microbe->addScript( STATIC_URL."/js/heatgraph/d3.js");
		$this->microbe->addScript( STATIC_URL."/js/heatgraph/preview.js");
		$this->microbe->addScript( STATIC_URL."/js/heatgraph/sandbox.js");
			

	}	
	
	
}
?>