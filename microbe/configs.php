<?php
/**
 * Congratulations!
 * this is the right place to configure your microbe application!
 */

# URL related const. To be modified, as you like. without the trailing slashes.
define( "THE_URL", "/opticc" );
define( "THE_MICROBE_URL", THE_URL ."/microbe" );
define( "STATIC_URL", THE_MICROBE_URL ."/static" );
define( "THE_MICROBE_DEFAULT_PAGE", "default/index" );
define( "THE_MICROBE_404_PAGE", "404" );
define( "THE_MICROBE_DEFAULT_ACTION", "index" );


/**
 * a dictionary of frieldy urls (provided by a 404 SERVER REDIRECTION,
 * cfr bootstrap.php) -> REAL urls.
 * please avoid silly loop (key==value) :D !
 * if a given url is not in this list, then the classic
 * controller->action approach is defined.
 * The key string should come from the $_SERVER['REDIRECT_URL'] or similar...
 */
$lost_in_translations = array( 
	THE_URL."/scripts" =>  "/labs/static/scripts/gexf/biparted.php"
);


/**
 * your own space.
 *  Please use this space to create customs defined const
 */

/**
 * limits of your own space.
 */
?>
