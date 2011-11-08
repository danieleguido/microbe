<?php
/**
 * return the current translation
 */
function translate( $what ){
	return I18n_Json::get( $what );
}

?>