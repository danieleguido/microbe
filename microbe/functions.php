<?php
/**
 * return the current translation
 */
function translate( $what ){
	return I18n_Json::get( $what );
}

/**
 * the full address /labs/controller/view
 */
function is_active_url( $address ){
	return	$GLOBALS['microbe']->getAddress() == $address;	
}

/**
 * array to html attributes function
 */
function iatts( array $atts ){
	$s = "";
	foreach( $atts as $k=>$v){
		$s .= ' '.$k.'="'.str_replace('"','\"',$v).'"';
	}
	return $s;	
}
?>