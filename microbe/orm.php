<?php
include LIB_PATH. "/Redbean/rb.php"; 

# some specific const to make function readable
define( 'REDBEAN_ENABLE_AUTOINSTALL', true );
define( 'REDBEAN_DISABLE_AUTOINSTALL', false );

# specific errors bead-related, INT exception codes
define( 'REDBEAN_LOAD_FAULT', 404 );


R::setup(
	'mysql:host='.$config[ 'mysql' ][ 'host' ].';dbname='.$config[ 'mysql' ][ 'name' ],
	$config[ 'mysql' ][ 'user' ],
	$config[ 'mysql' ][ 'pass' ]
);

?>
