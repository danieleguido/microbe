var graph;

window.onload = function(){
	// Change the picture when clicking on the inputs
	$("#settings").submit(function (e) {
		makeHeatmap(graph,true);
		return false;
	});
	
	// Other buttons
	$("#save").bind("click", function (){
		oCanvas = document.getElementById("canvas");  
		Canvas2Image.saveAsPNG(oCanvas);
	})
	$("#makeitbig").bind("click",function() {
		makeHeatmap(graph,false);
	});


// START - Autoload Test Mode
	$.get("/the-labs/microbe/static/misc/test.gexf", function(data){
		preview.parseGEXF($.parseXML(data)/*,	"s12227967"*/);
	});
// END - Autoload Test Mode
}

var makeHeatmap = function(graph,mini) {
	if(graph){
		var canvas_width = parseFloat($('#canvas_width').attr('value'));
		var canvas_height = parseFloat($('#canvas_height').attr('value'));
		
		
		factor_mini = 4;
		if (mini==true) {
			canvas_width = canvas_width / factor_mini;
			canvas_height = canvas_height / factor_mini;
		}
		
		var margin = 0.05 * Math.min(canvas_width,canvas_height);
		
		$("#drawspace").html('<canvas id="canvas" width="'+canvas_width+'" height="'+canvas_height+'" style="border:1px solid black">Your browser doesn\'t support CANVAS. Burn in Hell or get another one.</canvas>');
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d');
		var ratio, imgd, pix;
		
		var imgd = context.getImageData(0,0,canvas_width,canvas_height);
		var pix = imgd.data;
		
		var xmin = d3.min(graph.nodes, function (node) {return node.x ;});
		var xmax = d3.max(graph.nodes, function (node) {return node.x ;});
		var ymin = d3.min(graph.nodes, function (node) {return node.y ;});
		var ymax = d3.max(graph.nodes, function (node) {return node.y ;});
		
		var ratio = Math.max(xmax-xmin, ymax-ymin);
		
		var nodes = [];
		//nodes = graph.nodes.filter(function(d,i){return i<10;});
		var egoId = $("#egoSelectMenu").val();
		
		if(egoId != "none"){
			// Select Ego Network
			nodes = graph.nodes.filter(function(node){
				return node.id == egoId || graph.edges.some(function(edge){
					return (edge.sourceID == egoId && edge.targetID == node.id) || (edge.targetID == egoId && edge.sourceID == node.id);
				});
			});
		} else {
			nodes = graph.nodes;
		}
		
		var spreading = parseFloat($('#spreading').attr('value'));
		var steps = parseFloat($('#gradient_steps').attr('value'));
		var lightnessRatio = parseFloat($('#lightness_ratio').attr('value'));
		
		// Link spreading to the size of the canvas
		spreading *= 0.005 * (Math.min(canvas_width, canvas_height) - 2 * margin);
		
		if($('#color_heatmap').is(':checked')){
			var heats = [];
			
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				heat = d3.sum(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width - 2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height - 2*margin) / ratio;
					distance = Math.sqrt( Math.pow(nodex - x,2) + Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2) / halflife;
					
					return Math.sqrt(node.size) * Math.exp(- t_half * distance);
				});

				heats.push(heat);
			}
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});    
			
			heats.forEach(function(heat,hi){
				i = hi*4;
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				color_min = parseFloat($('#color_min').attr('value'))
				color_max = parseFloat($('#color_max').attr('value'))
				new_scale = d3.scale.linear().domain([0,360]).range([color_min,color_max])
				rgb = d3.hsl(new_scale(360*heat),1,0.5).rgb();
				
				pix[i  ] = rgb.r; // red
				pix[i+1] = rgb.g; // green
				pix[i+2] = rgb.b; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#bnw_heatmap').is(':checked')){
			var heats = [];
			
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				heat = d3.sum(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2)/halflife;
					
					return Math.sqrt(node.size) * Math.exp(- t_half * distance);
				});

				heats.push(heat);
			}
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});    
			
			heats.forEach(function(heat,hi){
				i = hi*4;
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				
				pix[i  ] = heat*255; // red
				pix[i+1] = heat*255; // green
				pix[i+2] = heat*255; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#voronoi').is(':checked')){
			var colors = [];
		
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				var closeNode;
				var closeNodeDistance = 10000;
				nodes.forEach(function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					if(distance < closeNodeDistance){
						closeNode = node;
						closeNodeDistance = distance;
					}
				});
				
				colors.push(closeNode.color);
			}
			
			colors.forEach(function(color,ci){
				i = ci*4;
				
				pix[i  ] = color.r*255; // red
				pix[i+1] = color.g*255; // green
				pix[i+2] = color.b*255; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			
			});
		} else if($('#gradient_voronoi').is(':checked')){
			var heats = [];
		
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				distance = d3.min(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					return Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
				});
				
				halflife = spreading;
				t_half = Math.log(2)/halflife;
				heat = Math.exp(- t_half * distance);
				
				heats.push(heat);
			}
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});
			
			var colors = [];
			
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				var closeNode;
				var closeNodeDistance = 10000;
				nodes.forEach(function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					if(distance < closeNodeDistance){
						closeNode = node;
						closeNodeDistance = distance;
					}
				});
				
				colors.push(closeNode.color);
			}
			
			colors.forEach(function(color,ci){
				i = ci*4;
				
				heat = heats[ci];
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				
				var hsl = d3.rgb(color.r*255, color.g*255, color.b*255).hsl();
				var rgb = d3.hsl(hsl.h, hsl.s, lightnessRatio*heat).rgb();
				
				pix[i  ] = rgb.r; // red
				pix[i+1] = rgb.g; // green
				pix[i+2] = rgb.b; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#weighted_voronoi').is(':checked')){
			var heats = [];
		
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				heat = d3.max(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2)/halflife;
					
					return Math.exp(- t_half * distance);
				});
				
				heats.push(heat);
			}
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});
			
			heats.forEach(function(heat,hi){
				i = hi*4;
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				
				pix[i  ] = heat*255; // red
				pix[i+1] = heat*255; // green
				pix[i+2] = heat*255; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#voronoi_heatmap').is(':checked')){
			var heats = [];
		
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				heat = d3.sum(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2)/halflife;
					
					return Math.sqrt(node.size) * Math.exp(- t_half * distance);
				});

				heats.push(heat);
			}
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});
			
			var colors = [];
			
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				var closeNode;
				var closeNodeDistance = 10000;
				nodes.forEach(function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					if(distance < closeNodeDistance){
						closeNode = node;
						closeNodeDistance = distance;
					}
				});
				
				colors.push(closeNode.color);
			}
			
			colors.forEach(function(color,ci){
				i = ci*4;
				
				heat = heats[ci];
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				
				var hsl = d3.rgb(color.r*255, color.g*255, color.b*255).hsl();
				var rgb = d3.hsl(hsl.h, hsl.s, lightnessRatio*heat).rgb();
				
				pix[i  ] = rgb.r; // red
				pix[i+1] = rgb.g; // green
				pix[i+2] = rgb.b; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#overlay_heatmap').is(':checked')){
			var heats = [];
		
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				heatR = d3.sum(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2)/halflife;
					
					return Math.sqrt(node.size) * Math.exp(- t_half * distance)*node.color.r;
				});
				heatG = d3.sum(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2)/halflife;
					
					return Math.sqrt(node.size) * Math.exp(- t_half * distance)*node.color.g;
				});
				heatB = d3.sum(nodes, function(node){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					halflife = Math.sqrt(node.size) * spreading;
					t_half = Math.log(2)/halflife;
					
					return Math.sqrt(node.size) * Math.exp(- t_half * distance)*node.color.b;
				});

				heats.push({r:heatR, g:heatG, b:heatB});
			}
			
			// Normalize
			heatMax = d3.max(heats.map(function(rgb){return Math.max(rgb.r, rgb.g, rgb.b);}));
			heats = heats.map(function(rgb){
				return {r:rgb.r/heatMax, g:rgb.g/heatMax, b:rgb.b/heatMax};
			});
			
			heats.forEach(function(color,i){
				i = i*4;
				
				if(steps>0){
					color.r = Math.floor(steps*color.r)/(steps-1);
					color.g = Math.floor(steps*color.g)/(steps-1);
					color.b = Math.floor(steps*color.b)/(steps-1);
				}
				
				pix[i  ] = color.r*255; // red
				pix[i+1] = color.g*255; // green
				pix[i+2] = color.b*255; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#graph_preview').is(':checked')){
			nodes.forEach(function(node){
				nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
				nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
				
				var size = 2 * Math.min(100,Math.max(1,node.size)) * (Math.min(canvas_width, canvas_height) - 2 * margin) / ratio;
				context.fillStyle = "rgb(200,0,0)";
				
				context.beginPath();
				context.arc(nodex, nodey, size, 0, Math.PI*2, true); 
				context.closePath();
				context.fill();
			});
		} else if($('#graph_preview_edges').is(':checked')){
			var edges = graph.edges.map(function(e){return e;});
			edges = edges.map(function(edge){
				var sourceNodeIndex = nodes.map(function(n){return n.id;}).indexOf(edge.sourceID);
				var targetNodeIndex = nodes.map(function(n){return n.id;}).indexOf(edge.targetID);
				if(sourceNodeIndex>=0 && targetNodeIndex>=0){
					edge.keep = true;
					edge.sourceNode = nodes[sourceNodeIndex];
					edge.targetNode = nodes[targetNodeIndex];
				} else {
					edge.keep = false;
				}
				return edge;
			}).filter(function(edge){
				return edge.keep;
			}).forEach(function(edge){
				sourceNodex = margin + (edge.sourceNode.x-xmin) * (canvas_width-2*margin) / ratio;
				sourceNodey = margin + (edge.sourceNode.y-ymin) * (canvas_height-2*margin) / ratio;
				targetNodex = margin + (edge.targetNode.x-xmin) * (canvas_width-2*margin) / ratio;
				targetNodey = margin + (edge.targetNode.y-ymin) * (canvas_height-2*margin) / ratio;
				
				context.beginPath();
				context.strokeStyle = "rgba(220,200,200,"+Math.min(0.3, 3 * (Math.min(canvas_width, canvas_height) - 2 * margin) / ratio)+")";  
				context.moveTo(sourceNodex,sourceNodey);  
				context.lineTo(targetNodex,targetNodey);  
				context.closePath();
				context.stroke(); 
			});
			nodes.forEach(function(node){
				nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
				nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
				
				var size = 2 * Math.min(100,Math.max(1,node.size)) * (Math.min(canvas_width, canvas_height) - 2 * margin) / ratio;
				context.fillStyle = "rgb(200,0,0)";
				
				context.beginPath();
				context.arc(nodex, nodey, size, 0, Math.PI*2, true); 
				context.closePath();
				context.fill();
			});
		} else if($('#monadic').is(':checked')){
			if(egoId != "none"){
				var egoIndex = nodes.map(function(n){return n.id;}).indexOf(egoId);
				var ego = nodes[egoIndex];
				
				var egox = margin + (ego.x-xmin) * (canvas_width-2*margin) / ratio;
				var egoy = margin + (ego.y-ymin) * (canvas_height-2*margin) / ratio;
			}

			var heats = [];
			
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				var distance_ego_to_pixel = Math.sqrt(Math.pow(egox - x,2)+Math.pow(egoy - y,2)) / (Math.min(canvas_width, canvas_height) - 2 * margin);
				
				heat = d3.sum(graph.nodes, function(node,ii){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					if(ego){
						
						halflife = spreading * distance_ego_to_pixel; //* (1 + 2 * distance_ego_to_pixel);
						t_half = Math.log(2)/halflife;
					
						return Math.exp(- t_half * distance) / Math.pow(distance_ego_to_pixel,1);
					} else {
						halflife = Math.sqrt(node.size) * spreading;
						t_half = Math.log(2)/halflife;
					
						return Math.sqrt(node.size) * Math.exp(- t_half * distance);
					}
				});

				heats.push(heat);
			}
			
			// Log
			heats = heats.map(function(h){return Math.sqrt(h);});
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});    
			
			heats.forEach(function(heat,hi){
				i = hi*4;
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				
				pix[i  ] = heat*255; // red
				pix[i+1] = heat*255; // green
				pix[i+2] = heat*255; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		} else if($('#monadic_color').is(':checked')){
			if(egoId != "none"){
				var egoIndex = nodes.map(function(n){return n.id;}).indexOf(egoId);
				var ego = nodes[egoIndex];
				
				var egox = margin + (ego.x-xmin) * (canvas_width-2*margin) / ratio;
				var egoy = margin + (ego.y-ymin) * (canvas_height-2*margin) / ratio;
			}

			var heats = [];
			
			for (var i = 0, n = pix.length; i < n; i += 4) {
				x = Math.floor(i / 4 % canvas_width);
				y = Math.floor(i / 4 / canvas_width);
				
				var distance_ego_to_pixel = Math.sqrt(Math.pow(egox - x,2)+Math.pow(egoy - y,2)) / (Math.min(canvas_width, canvas_height) - 2 * margin);
				
				heat = d3.sum(graph.nodes, function(node,ii){
					nodex = margin + (node.x-xmin) * (canvas_width-2*margin) / ratio;
					nodey = margin + (node.y-ymin) * (canvas_height-2*margin) / ratio;
					distance = Math.sqrt(Math.pow(nodex - x,2)+Math.pow(nodey - y,2));
					
					if(ego){
						
						halflife = spreading * distance_ego_to_pixel; //* (1 + 2 * distance_ego_to_pixel);
						t_half = Math.log(2)/halflife;
					
						return Math.exp(- t_half * distance) / Math.pow(distance_ego_to_pixel,1);
					} else {
						halflife = Math.sqrt(node.size) * spreading;
						t_half = Math.log(2)/halflife;
					
						return Math.sqrt(node.size) * Math.exp(- t_half * distance);
					}
				});

				heats.push(heat);
			}
			
			// Log
			heats = heats.map(function(h){return Math.sqrt(h);});
			
			// Normalize
			heatMax = d3.max(heats);
			heats = heats.map(function(heat){return heat/heatMax;});    
			
			heats.forEach(function(heat,hi){
				i = hi*4;
				
				if(steps>0){
					heat = Math.floor(steps*heat)/(steps-1);
				}
				
				
				rgb = d3.hsl(360*heat,1,0.5).rgb();
				
				pix[i  ] = rgb.r; // red
				pix[i+1] = rgb.g; // green
				pix[i+2] = rgb.b; // blue
				pix[i+3] = 255// i+3 is alpha (the fourth element)
			});
		}
		if (mini==true)
		   setTimeout('$("#canvas").width('+canvas_width*factor_mini+')',100)
		if(!$('#graph_preview').is(':checked') && !$('#graph_preview_edges').is(':checked')){
			context.putImageData(imgd, 0, 0);
		}
	}
}

buildEgoGraphUI = function(preselectedId){
	preselectedId = preselectedId || '';
	$("#egoSelectMenu").html('<option value="none">Ego Mode: Select a Node...</option>'
		+graph.nodes.map(function(node){
			return '<option value="'+node.id+'"'+((node.id == preselectedId)?(" selected=true"):(""))+'>'+node.id+' - '+node.label+'</option>';
		}).join("")
	);
}
