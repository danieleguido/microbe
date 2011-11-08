<?php
/**
 * MICROBE. an astonishing framework for labs co-working.
 * nothing is hidden, here.
 * 
 * 
 * Microbe config under apache2
 
 Alias /labs /home/.../public/labs
  <Directory /home/.../public/labs>
        ErrorDocument 404 /labs/index.php
        Order deny,allow
        Allow from all
  </Directory>

 *
 *
 */



# some global consts, not to be modified.
define( "THE_MICROBE", dirname( __FILE__ ) );
define( "BOOTSTRAP_SCRIPT", __FILE__ );
define( "APPLICATION_PATH", THE_MICROBE."/app" );
define( "LIB_PATH", THE_MICROBE."/lib" );



define( "STATIC_PATH", THE_MICROBE."/static"  );
define( "LOCALE_PATH", STATIC_PATH."/locale" );

# load configuration. in this file you can find the array "$lost_in_translations"
include THE_MICROBE."/configs.php";

# autoloader function
function __autoload( $class_name ) {
	$class_filename = LIB_PATH."/".str_replace("_", "/", $class_name );
	include $class_filename . '.php';
}

# include the common useful function
include THE_MICROBE."/functions.php";

# start the microbe ( the constructor does really nothing :D )
$microbe = new Microbe();

# read the $_SERVER to find a 404 to route. 
if( isset( $_SERVER[ 'REDIRECT_STATUS' ] ) && $_SERVER[ 'REDIRECT_STATUS' ] == 404 ){
	
	# search firstly into direct routes
	if( !empty( $lost_in_translations ) && in_array( $_SERVER[ 'REDIRECT_URL' ], array_keys( $lost_in_translations ) ) ){
		header( "Location: ".	$lost_in_translations[ $_SERVER[ 'REDIRECT_URL' ] ] );
		exit;
	} 
	
	if( !$microbe->isAppUrl() ) {
		$microbe->setPage( THE_MICROBE_404_PAGE );
	}
	
}
 

# start the session
session_start();
?>
