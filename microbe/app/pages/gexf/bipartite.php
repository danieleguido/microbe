<?php
/**
 * recommandation DEMO file for form
 */
?>
<script type="text/javascript">
	$(function(){
		$('#clickme').click(function(){
			$('#uploadme').click();
		});
 	});
</script>

<div class="margin_top_1">
<p>upload a bipartited gexf file to split. <br/>Note: waiting time is about 1 min for little graph.</p>
	<form action="<?php echo $this->getAddress()?>" method="post" enctype="multipart/form-data"> 
		<input type="button" id="clickme" value="Upload GEXF" class="height_2"/><input type="file" style="visibility:hidden;" id="uploadme" />
	</form>
</div>
<?php echo $this->view ?>