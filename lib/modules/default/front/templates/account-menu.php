<div class="view-account-menu">

	<ul class="list-unstyled">
		<li class=""><a href="/user/orders">Мои заказы</a></li>
		<li class=""><a href="/user/messages">Мои сообщения</a></li>
		<li class=""><a href="/user/content">Мой контент</a></li>
		<li class=""><a href="/user/medias">Мои загрузки</a></li>
		<li class=""><a href="/user/logout">Выход</a></li>
	</ul>

	<?php if(!empty($cart)) { ?>
	<div class="cart">
		<?php foreach ($cart as $i) { ?>
		<div class="item" data-id="<?php echo $i->id ?>">
			<div class="photo" data-src="<?php echo $i->preview_url ?>"></div>
			<div class="name"><?php echo $i->name ?></div>
			<button class="button-remove" type="button" onclick="cart.sub(<?php echo $i->id ?>)" title="Убрать лишний">-</button>
			<button class="button-add" type="button" onclick="cart.add(<?php echo $i->id ?>)" title="Добавить еще">+</button>
		</div>
		<?php } ?>
		<button type="button" onclick="cart.clear()" title="Очистить"></button>
	</div>
	<?php } ?>

</div>