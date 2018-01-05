<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<link rel="icon" href="/favicon.ico">
		<title><?= $this->title; ?> - <?= Yii::app()->name; ?></title>
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href='/css/opensans.css' rel='stylesheet'>
		<link href="/css/cabinet.css" rel="stylesheet">
		<link href="/vendors/datatables/datatables.min.css" rel="stylesheet">

		<script src="/js/plugins/jquery.min.js"></script>
		<script src="/js/plugins/jquery.maskedinput.min.js"></script>
		<script src="/js/plugins/bootstrap.min.js"></script>
		<script src="/vendors/datatables/datatables.min.js"></script>
		<script src="/js/plugins/moment.min.js"></script>
		<script src="/js/plugins/daterangepicker.js"></script>
		<script src="/js/cabinet.js"></script>
		<script src="/js/input-hint.js"></script>
	</head>

	<body>

		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/"><?= Yii::app()->name; ?></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/site/logout">Выйти</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">
					<ul class="nav nav-sidebar">
						<li><a href="/employee/search">Поиск</a></li>
						<li><a href="/employee/requests">Заявки</a></li>
						<li><a href="/employee/storages">Виртуальные склады</a></li>
						<li><a href="/employee/railcars">Вагоны</a></li>
						<li><a href="/employee/routes">Маршруты</a></li>
						<li><a href="/employee/settings">Настройки</a></li>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header"><?= $this->title; ?></h1>
					<?= $content; ?>
				</div>
			</div>
		</div>
	</body>
</html>