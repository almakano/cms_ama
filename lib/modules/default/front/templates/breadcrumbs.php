<?php if(empty($list)) return; ?>

<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
	<?php foreach ($list as $i) { ?>
	<li class="breadcrumb-item<?php if($i['active']) echo ' active' ?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a href="<?php echo $i['url'] ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
			<span itemprop="name"><?php echo $i['name'] ?></span>
		</a>
	</li>
	<?php } ?>
</ul>