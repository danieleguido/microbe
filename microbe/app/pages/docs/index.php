<strong>The structure</strong>
<div lang="en">
welcome to The Lab of medialab Sciences-po.
The site is the lightest-weight mwc ever made in php.
<p>
 Basically, it tries to "emulate" Zend Framework mwc structure in a more
 'transparent' and 'easy' way. If you know how zend mwc works, you can skip
 this introduction.
</p>
<ol>
	<li>
		<h2>create an hello world page</h2>

		The structure allows to have pages without controllers. 
		Find the <code>$/microbe/pages/</code> directory ($ is the root dir of the microbe project, where there is the index.php layout file),
		then create a directory "hello-world" (lowercase letters) and put inside an index.php file.
		Point your browser on <code><?php echo THE_HOST.THE_URL ?>/hello-world</code>.
		you will see the content of <code>$/microbe/pages/hello-world/index.php</code> page.
		<p>
		Inside this page you can use all the settings made in config file, the autoloader to load php classes from the lib,
		and you can use all the common function stored into the functions.php file. But you won't be able to interact with the layout.<br/>
		To do so, you have to create a controller class.
		</p>
	</li>
	<li>
		<h2>interact with the layout: the controller class</h2>

		A page without controllers does not allow you to change the page title...
		any information about the layout (that is the "container" )
		Among the propertuies that can be modified, there are: stylesheets; scripts; html title;
	
	</li>
	<li>
		<h2>the bootstrap and the autoloader</h2>

		The <code>$/microbe/bootstrap.php</code> file starts the session, starts the microbe application and enables
		the autoload function in order to find the proper class file to include inside the <code>$/microbe/lib</code> hierarchy.
		
	
	</li>
</ol>
</div>

