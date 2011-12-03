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
 * Configuration files:
 * THE_MICROBE."/configs.php" where useful PUBLIC configurations are (urls) 
 * APPLICATION_PATH."/config.ini" for applications PRIVATE configs connections, password etc.. 
 */
 
 

# start the session
session_start();

# some global consts, not to be modified. Real paths of microbe's places.
define( "THE_MICROBE", dirname( __FILE__ ) );
define( "BOOTSTRAP_SCRIPT", __FILE__ );
define( "APPLICATION_PATH", THE_MICROBE."/app" );
define( "CONTROLLERS_PATH", APPLICATION_PATH."/controllers" );
define( "VIEWS_PATH", APPLICATION_PATH."/pages" );
define( "LIB_PATH", THE_MICROBE."/lib" );

# some globals used by translation tools
define( "STATIC_PATH", THE_MICROBE."/static"  );
define( "LOCALE_PATH", STATIC_PATH."/locale" );

# load configuration. in this file you can find the array "$lost_in_translations"
include THE_MICROBE."/configs.php";

# autoloader function
function __autoload( $class_name ) {
	$class_filename = LIB_PATH."/".str_replace("_", "/", $class_name );
	if( file_exists( $class_filename . '.php' ) ){
		include $class_filename . '.php';
	}
}

# include the common useful function
include THE_MICROBE."/functions.php";

# start the microbe ( the constructor does really nothing :D )
$microbe = new Microbe();

# load app specific configuration. Note that you have to create the conbfig.ini file using the config.sample.ini as a model.
$config =  @parse_ini_file ( APPLICATION_PATH ."/config.ini", true );

# load the ORM - we use redbeanphp - to connect with the database. you can comment this feature. it uses the global config ini params defined above
include THE_MICROBE."/orm.php";

# read the $_SERVER to find a 404 to route. 
if( isset( $_SERVER[ 'REDIRECT_STATUS' ] ) && isset( $_SERVER[ 'REDIRECT_URL' ]) ){
	
	# search firstly into direct routes
	if( !empty( $lost_in_translations ) && in_array( $_SERVER[ 'REDIRECT_URL' ], array_keys( $lost_in_translations ) ) ){
		header( "Location: ".	$lost_in_translations[ $_SERVER[ 'REDIRECT_URL' ] ] );
		exit;
	} 
	
	$microbe->init();	
}

?>
