<?php
	$this->scripts = array_merge([
		__DIR__.'/css_js/jquery.min.js',
		__DIR__.'/css_js/bootstrap.min.js',
		__DIR__.'/css_js/jquery.lazyload.makano.js',
		__DIR__.'/css_js/template.js',
	], $this->scripts);
?>
		</div>
		<div id="footer">
			<div class="container-fluid">
				
			</div>
		</div>
	</div>
	<?php
		if(!empty($notifies = \Notify::show()))
			echo '<div class="notifies">'.implode(PHP_EOL, $notifies).'</div>';

		echo $this->_foot();
	?>
</body>
</html>