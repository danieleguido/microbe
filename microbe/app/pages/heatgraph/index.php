

<form id="settings">
    <table class="structure"><tr><td><div class="leftPanel">
	    <h3>Settings</h3>

        <table class="cleanTable">
	        <tr>
		        <th></th>
		        <th></th>
		        <th>HeatMap Mode</th>
		        <td>closest<br/>node</td>
		        <td>all<br/>nodes</td>
		        <td>node<br/>color</td>
		        <td>gradient</td>
		        <td>weighted</td>
	        </tr>
	        <tr>
		        <td><img src="img/bnw_heatmap.png"/></td>
		        <td><input type="radio" name="viztype" id="bnw_heatmap"/></td>
		        <td><b>Heatmap</b></td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/color_heatmap.png"/></td>
		        <td><input type="radio" name="viztype" id="color_heatmap" checked=true/></td>
		        <td><b>HeatMap</b> (colorized)</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/voronoi.png"/></td>
		        <td><input type="radio" name="viztype" id="voronoi"/></td>
		        <td><b>Voronoï</b></td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/grad_voronoi.png"/></td>
		        <td><input type="radio" name="viztype" id="gradient_voronoi"/></td>
		        <td><b>Gradient Voronoï</b></td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/weighted_voronoi.png"/></td>
		        <td><input type="radio" name="viztype" id="weighted_voronoi"/></td>
		        <td><b>Weighted Voronoï</b></td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>Yes</td>
	        </tr>
	        <tr>
		        <td><img src="img/voronoi_heatmap.png"/></td>
		        <td><input type="radio" name="viztype" id="voronoi_heatmap"/></td>
		        <td><b>Monster</b> (Voronoï + HeatMap)</td>
		        <td>Yes</td>
		        <td>Yes</td>
		        <td>Yes</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/overlay_heatmap.png"/></td>
		        <td><input type="radio" name="viztype" id="overlay_heatmap"/></td>
		        <td><b>SpotCloud</b> (Color Heatmap)</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>Yes</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/graph_preview.png"/></td>
		        <td><input type="radio" name="viztype" id="graph_preview"/></td>
		        <td><b>GraphPreview</b></td>
		        <td>No</td>
		        <td>No</td>
		        <td>No</td>
		        <td>No</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/graph_preview_edges.png"/></td>
		        <td><input type="radio" name="viztype" id="graph_preview_edges"/></td>
		        <td><b>GraphPreview</b> (with Edges)</td>
		        <td>No</td>
		        <td>No</td>
		        <td>No</td>
		        <td>No</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/monadic.png"/></td>
		        <td><input type="radio" name="viztype" id="monadic"/></td>
		        <td><b>Monadic</b> (for Ego graphs)</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
	        <tr>
		        <td><img src="img/monadic_color.png"/></td>
		        <td><input type="radio" name="viztype" id="monadic_color"/></td>
		        <td><b>Monadic</b> (color)</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
		        <td>Yes</td>
		        <td>No</td>
	        </tr>
        </table>
        <table class="cleanTable">
	        <th>Generic Settings</th>
	        <tr><td>
		        HeatMap Spreading:			<input type="text" id="spreading"		value="3"		style="width:40px;"><br/>
		        <small>(more blurs, less sharpens the heatmap)</small>
	        </td></tr>
	        <tr><td>
		        HeatMap Gradient steps:		<input type="text" id="gradient_steps"	value="0"		style="width:40px;"><br/>
		        <small>(0 is gradient, no steps)</small>
	        </td></tr>
	        <tr><td>
		        Lightness Ratio:			<input type="text" id="lightness_ratio"	value="0.75"	style="width:40px;"><br/>
		        <small>(0.5 makes "dark to color", 1 makes "dark to color to white")</small>
	        </td></tr>
	        <tr><td>
		        Width:						<input type="text" id="canvas_width"	value="500"		style="width:40px;">px,
		        Height:						<input type="text" id="canvas_height"	value="500"		style="width:40px;">px
	        </td></tr>
	        <tr><td>
		        Color Min:						<input type="text" id="color_min" class="control_with_arrows"	value="240"	 	size="3">
		        <div id="color_min_preview" style="width:10px; height:10px; border:1px solid black; display:inline-block;">&nbsp;</div>,
		        Color Max:						<input type="text" id="color_max" class="control_with_arrows"	value="0"		size="3">
		        <div id="color_max_preview" style="width:10px; height:10px; border:1px solid black; display:inline-block;">&nbsp;</div>
<!--		        <div id="color_preview_gradient" style="width:250px; height:20px; border:1px solid black;">&nbsp;</div>-->
	        </td></tr>
	        <script type="text/javascript">
	            $( function () {

	            
	            $("#color_min").change( function () { color_min = $("#color_min").attr("value"); $("#color_min_preview").css("background","hsl("+color_min+", 100%, 50%)");  } );
	            $("#color_max").change(  function () { color_max = $("#color_max").attr("value"); $("#color_max_preview").css("background","hsl("+color_max+", 100%, 50%)"); } );
	            

	            
	            $("#color_min").change( function () {
	                color_min = $("#color_min").attr("value");
	                color_max = $("#color_max").attr("value");
	                $("#color_preview_gradient").css( { "background" : "-webkit-gradient(linear, left top, right bottom  , from(hsl("+color_min+", 100%, 50%)), to(hsl("+color_max+", 100%, 50%)))" } )
                }) ;
	            
	           $("#color_max").change( function () {
	                color_min = $("#color_min").attr("value");
	                color_max = $("#color_max").attr("value");
	                $("#color_preview_gradient").css( { "background" : "-webkit-gradient(linear, left top, right bottom  , from(hsl("+color_min+", 100%, 50%)), to(hsl("+color_max+", 100%, 50%)))" } )
                }) ;
                
                $("#color_min").trigger('change');
	            $("#color_max").trigger('change');
	            
	            $(".control_with_arrows").keydown(function(e){

                    if (e.keyCode == 38) { // up 
                        $(this).attr("value", parseInt($(this).attr("value")) + 1)
                        $(this).trigger('change');
                        e.preventDefault();
                    }

                });
                $(".control_with_arrows").keydown(function(e){

                    if (e.keyCode == 40) { // down
                        $(this).attr("value", parseInt($(this).attr("value")) - 1)
                        $(this).trigger('change');
                        e.preventDefault();
                    }
                });
                
                });
	        </script>
        </table>
	    <b>Graph Source File</b><br/>
	    <input type="file" id="files" name="file" /><br/>
	    <div id="progress_bar"><div id="progress_bar_message" class="percent">0%</div></div>
	    <script>
		    document.getElementById('files').addEventListener('change', preview.handleFileSelect, false);
	    </script>
    </div></td>
    <td>
	    <h3>HeatMap</h3>
	    <select id="egoSelectMenu">
		    <option>Ego Mode: Select a Node...</option>
	    </select>
	    	    <input type="submit" id="render" value="Render!">
	    <input type="button" id="makeitbig" value="You really want it precise don't you!">
	    <input type="button" id="save" value="Download">

	    <br/>
	    <div id="drawspace"></div>
    </td></tr></table>
</form>
