<?php
	$this->links[] = __DIR__.'/css_js/home.css';
	$this->scripts[] = __DIR__.'/css_js/home.js';
	$this->title = $item->get_property('seo_title_ru')->value;

	echo $this->_view('header');
?>
<div class="view-home">
	<div class="slider" data-onload-src="?route=front/slider&id=1"></div>
	<div class="container-fluid">
		<div class="slider" data-onload-src="?route=front/products_best"></div>
	</div>
	<h1><?php echo $item->name ?></h1>
	<div class="content"><?php echo $item->info ?></div>
</div>
<?php echo $this->_view('footer') ?>