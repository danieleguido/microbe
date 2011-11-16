<style>
#features { padding:5px; }
#features li{list-style-type:decimal; list-style-position:inside;}
#features li{ padding: 7px; }
</style>
<h2>Guidelines</h2>
<p>
This css allow you to follow the basic design theme of medialab,
Simply putting this link just <strong>before</strong> your stylesheet definitions, so it will be easier to apply changes
later on.</p>

<textarea class="block full_width height_3 margin_top_1">
<link rel="stylesheet" type="text/css" href="http://jiminy.medialab.sciences-po.fr/labs/static/css/medialab.style.css">
</textarea>
<a class="button block margin_top_1 width_1" href="http://jiminy.medialab.sciences-po.fr/labs/static/css/medialab.style.css">view css</a>
<p>
Css focus on:
<ol id="features">
	<li>@font-face import</li>
	<li>body font definition</li>
	<li>h1, h2, paragraph and strong in font size, font family and margin</li>
	<li>complete support for input textfields, with hover and focus features</li>
	<li>a specific input type="file" css workaround</li>
	<li>provides specific classes to handle margins, display block</li>
</ol>

and <strong>does not </strong> affect other elements of the page, like tables and lists.
Of course, everything could be overridden.
</p>


