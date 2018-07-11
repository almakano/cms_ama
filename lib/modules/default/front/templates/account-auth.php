<div class="view-account-auth">

	<form action="/?route=front/account_login" method="POST" class="form-login collapse in" data-parent=".view-account-auth">
		<div class="h1">Вход</div>
		<div>
			<input type="text" class="form-control form-control-sm" placeholder="Логин: example@example.com">
		</div>
		<div>
			<input type="password" class="form-control form-control-sm" placeholder="Пароль: password">
		</div>
		<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-register">Регистрация</button>
		<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-resetpass">Забыл пароль</button>
		<button>Войти</button>
	</form>

	<form action="/?route=front/account_register" method="POST" class="form-register collapse" data-parent=".view-account-auth">
		<div class="h1">Регистрация</div>
		<div>
			<input type="text" class="form-control form-control-sm" placeholder="Логин: example@example.com">
		</div>
		<div>
			<input type="password" class="form-control form-control-sm" placeholder="Пароль: password">
		</div>
		<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-register">Вход</button>
		<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-resetpass">Восстановление</button>
		<button>Регистрация</button>
	</form>

	<form action="/?route=front/account_resetpass" method="POST" class="form-resetpass collapse" data-parent=".view-account-auth">
		<div class="h1">Восстановление</div>
		<div>
			<input type="text" class="form-control form-control-sm" placeholder="Логин: example@example.com">
		</div>
		<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-login">Логин</button>
		<button type="button" data-toggle="collapse" data-target=".view-account-auth .form-register">Регистрация</button>
		<button>Отправить уведомление</button>
	</form>

</div>