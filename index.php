<?php
# start our awesome controls...
include "microbe/bootstrap.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="author" content="daniele guido" />
<meta name="copyright" content="Licensed under GPL and MIT." />
<meta name="description" content="microbe" />

<title>microbe - the hidden lab</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css">
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL ?>/css/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL ?>/css/style.css">
<!--[if lte IE 7]>
<link rel="stylesheet" href="css/ie.css" />
<![endif]-->


</head>
<body>
	<div class="content container_12">
		
		<div class="menu alpha omega grid_12">    </div>
		
		<div class="clear"></div>
		
		<div class="title alpha omega grid_12">
    		<h1>This is the Lab.</h1>
    		<div class="description">
    		  	coming soon...
			</div>	
		</div>

		<div class="line grid_12 alpha omega">&nbsp;</div>

		<div class="clear"></div>
    
    	<div class="page grid_9 alpha">
    		<?php $microbe->doPage() ?>
    	</div>
    	
    	<div class="publications-list grid_3 margin_top_2 omega ">
     		<ul>
     			<li></li>
     		</ul>
		</div>
		
		<div class="clear"></div>
    	
    	<div class="line grid_12 margin_top_3 alpha omega">&nbsp;</div>
	
		<div class="clear"></div>
	</div>
</body>
</html>
