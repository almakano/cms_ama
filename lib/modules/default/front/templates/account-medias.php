<?php echo $this->_view('header') ?>
<div class="view-account-medias">

	<?php if(!empty($videos)) { ?>
	<div class="video-list">
		<?php foreach ($videos as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>" data-src="<?php echo $i->poster_url ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if(!empty($photos)) { ?>
	<div class="photo-list">
		<?php foreach ($photos as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>" data-src="<?php echo $i->url ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if(!empty($audios)) { ?>
	<div class="audio-list">
		<?php foreach ($audios as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if(!empty($files)) { ?>
	<div class="file-list">
		<?php foreach ($files as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>

</div>
<?php echo $this->_view('footer') ?>