<div class="view-slider">
	<?php if(!empty($list)) foreach ($list as $i) { ?>
	<div class="slide lazyload" data-src="<?php echo $i->url ?>"><?php echo $i->info ?></div>
	<?php } ?>
</div>