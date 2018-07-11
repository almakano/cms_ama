<?php
	$this->dirs[] = __DIR__.'/css_js/fonts/fontawesome/';
	$this->links = array_merge([
		__DIR__.'/css_js/bootstrap.min.css',
		__DIR__.'/css_js/fonts/fontawesome/font-awesome.min.css',
		__DIR__.'/css_js/template.css',
	], $this->links);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->title ?></title>
	<?php echo $this->_head(); ?>
</head>
<body class="lazyload" data-src="">
	<div class="sidebar-overflow" data-toggle="sidebar_close"></div>
	<div class="body-wrapper">
		<nav class="sidebar sidebar-left">
			<div data-onload-src="?route=front/account_menu"></div>
		</nav>
		<div id="header">
			<div class="container-fluid">
				<button class="btn-menu" data-toggle="sidebar" data-target=".sidebar-left"></button>
			</div>
		</div>
		<div id="page">
			
