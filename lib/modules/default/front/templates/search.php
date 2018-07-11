<?php echo $this->_view('header') ?>
<div class="view-search">

	<?php if(!empty($accounts)) { ?>
	<div class="account-list">
		<?php foreach ($accounts as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>" data-src="<?php echo $i->avatar_url ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if(!empty($content)) { ?>
	<div class="content-list">
		<?php foreach ($content as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>" data-src="<?php echo $i->preview_url ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

</div>
<?php echo $this->_view('footer') ?>