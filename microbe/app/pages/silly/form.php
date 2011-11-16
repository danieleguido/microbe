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

<div><p>valid</p>
<input type="text" class="width_4 height_2" autocomplete="off" value="a value">
<input type="button" value="save" class="height_2">
</div>
<div class="margin_top_1">
<p>invalid (on error)</p>
<input type="text" class="invalid width_5 height_2" autocomplete="off" value="an invalid red fox just trumping cowardly value">
</div>
<div class="margin_top_1">
<p>a text area</p>
<textarea class="width_5 height_4" autocomplete="off">value="an invalid red fox just trumping cowardly value"</textarea>
<button class="block height_2">submit!</button>
</div>
<div class="margin_top_1">
<p>upload!</p>
	<input type="button" id="clickme" value="Upload Stuff!" class="height_2"/><input type="file" style="visibility:hidden;" id="uploadme" />
</div>