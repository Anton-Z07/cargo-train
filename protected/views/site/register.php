<div class="content full-height middle">
	<form class="middle-content" method="POST">
		<div class="box register-box">
			<h2>Регистрация</h2>
			<a href="/site/login">Уже есть аккаунт? Войти</a>
			<br /><br />
			<label>Email</label>
			<input type="text" name="login" class="form-control" placeholder="Email" required autofocus>
			<label>Пароль</label>
			<input type="password" name="password" class="form-control" placeholder="Пароль" required>
			<? if ($error): ?>
				<div class="alert alert-danger"><?=$error;?></div>
			<? endif;?>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Продолжить</button>
		</div>
	</form>
</div>