<?php 
	$this->links[] = __DIR__.'/css_js/page.css';
	$this->scripts[] = __DIR__.'/css_js/page.js';
	$this->title = $item->get_property('seo_title_ru')->value;

	echo $this->_view('header');
?>
<div class="view-page">

	<?php echo (!empty($breadcrumbs)?$breadcrumbs:'') ?>

	<h1><?php echo $item->name ?></h1>
	<div class="description"><?php echo $item->info ?></div>
</div>

<?php echo $this->_view('footer') ?>