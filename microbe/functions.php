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
?>