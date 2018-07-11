<?php if(!empty($list)) { ?>
<div class="view-content-shop-products">
	<?php foreach ($list as $i) { ?>
	<?php 
		$stars_count = $i->get_property('stars_count')->value;
		$comments_count = $i->get_property('comments_count')->value;
	?>
	<div class="product" data-id="<?php echo $i->id ?>">
		<div class="photo" data-src="<?php echo $i->preview->url ?>"></div>
		<div class="name"><?php echo $i->name ?></div>
		<div class="labels">
			<div class="stars<?php echo ($stars_count?' '.$stars_count.'-stars':'')?>"></div>
			<div class="comments<?php echo ($comments_count?' '.$comments_count.'-comments':'')?>"></div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>