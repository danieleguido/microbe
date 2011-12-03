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

<title><?php echo translate(  $microbe->getHtmlTitle() ) ?></title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css">
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL ?>/css/grid.css">
<link rel="stylesheet" type="text/css" href="http://jiminy.medialab.sciences-po.fr/labs/static/css/medialab.style.css">
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL ?>/css/style.css">

<?php echo  $microbe->getStylesheets(); ?>


<!--[if lte IE 7]>
<link rel="stylesheet" href="css/ie.css" />
<![endif]-->

<!-- jquery -->
<script type="text/javascript" src="http://jiminy.medialab.sciences-po.fr/labs/static/js/jquery-1.7.min.js"></script>

<?php echo  $microbe->getScripts(); ?>

</head>
<body>
	
	<div class="logo"><a href="<?php echo THE_URL ?>"><img src="http://jiminy.medialab.sciences-po.fr/labs/static/logo/the-lab-black.png"></a>
	</div>
	
	<div class="wrapper">
		<div class="content container_12">
			<div class="menu grid_12">
			
			<ul>
				<li class="fr <?php echo I18n_Json::getInstance()->language == "fr"? ' selected':''?>">
					<a href="?lang=fr"  title="<?php echo translate("french") ?>"> </a>
				</li>
				<li class="en <?php echo I18n_Json::getInstance()->language == "en"? ' selected':''?>">
					<a href="?lang=en" title="<?php echo translate("english") ?>"> </a>
				</li>
				<li class="<?php echo is_active_url( THE_URL."/docs" )?'selected':''?>">
					<a href="<?php echo THE_URL ?>/docs"><?php echo translate("docs") ?></a>
				</li>
				<li class="<?php echo is_active_url( THE_URL."/guidelines" )?'selected':''?>">
					<a href="<?php echo THE_URL ?>/guidelines"><?php echo translate("guidelines") ?></a>
				</li>
				<li class="<?php echo is_active_url( THE_URL."/gexf/bipartite" )?'selected':''?>">
					<a href="<?php echo THE_URL ?>/gexf/bipartite"><?php echo translate("gexf-tools") ?></a>
				</li>
				<li class="<?php echo is_active_url( THE_URL."/heatgraph" )?'selected':''?>">
					<a href="<?php echo THE_URL ?>/heatgraph"><?php echo translate("heat 'graphs'") ?></a>
				</li>
			</ul>
		</div>
			
			
			<div class="clear"></div>
			
			<div class="title alpha omega grid_12">
	    		<h1><?php echo empty( $microbe->title )? translate( "This is the Lab.!" ): $microbe->title.""; ?></h1>
	    		<div class="description">
	    		  	<?php echo empty( $microbe->description )? translate( "coming soon..." ): $microbe->description.""; ?> 
				</div>	
			</div>
	
			<div class="line grid_12 alpha omega">&nbsp;</div>
	
			<div class="clear"></div>
	    
	    	<div class="page grid_12 alpha omega">
	    		<?php $microbe->doPage();
	    		
	    		 ?>
	    	</div>
	    	
	    	
			
			
			<div class="push grid_12 alpha omega"></div>
		</div>
	</div>
	<!-- end of wrapper -->
	
	<div class="footer container_12">
		<div id="footer" class="grid_12 alpha omega"><img style="height:60px" src="http://jiminy.medialab.sciences-po.fr/labs/static/logo/Sc-Po-Medialab-blanc.png" alt="Sciences Po ¦ Medialab"></div>
	</div>
</body>
</html>
