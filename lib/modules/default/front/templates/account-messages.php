<?php echo $this->_view('header') ?>
<div class="view-account-messages">

	<?php if(!empty($list)) { ?>
	<div class="list">
		<?php foreach ($list as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

</div>
<?php echo $this->_view('footer') ?>