<form action="/?route=front/account_login" method="POST" class="form-login collapse in" data-parent=".view-account-auth">
	<input type="hidden" name="captcha" value="<?php echo $captcha ?>">
	<div class="h1">Вход</div>
	<div>
		<input type="text" class="form-control form-control-sm" placeholder="Логин: example@example.com" value="<?php echo $email ?>">
	</div>
	<div>
		<input type="password" class="form-control form-control-sm" placeholder="Пароль: password" value="<?php echo $pass ?>">
	</div>
	<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-register">Регистрация</button>
	<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-resetpass">Забыл пароль</button>
	<button>Войти</button>
</form>