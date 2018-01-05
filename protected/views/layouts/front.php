<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<link rel="icon" href="/favicon.ico">

		<title><?= Yii::app()->name; ?></title>

		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="/css/index.css" rel="stylesheet">

		<script src="/js/plugins/jquery.min.js"></script>
		<script src="/js/front.js"></script>
		<script src="/js/input-hint.js"></script>
	</head>

	<body>

		<div class="site-wrapper">
			<div class="header clearfix">
				<h3><a href="/">Softcargo.Train</a></h3>
				<nav>
					<ul class="nav">
						<? if (Yii::app()->user->isGuest): ?>
							<li><a href="/login">Вход в личный кабинет</a></li>
						<? else: ?>
							<li><a href="/login">Личный кабинет</a></li>
							<li><a href="/site/logout">Выйти</a></li>
						<? endif; ?>
					</ul>
				</nav>
			</div>

			
			<?= $content; ?>
		</div>
	</body>
</html>	