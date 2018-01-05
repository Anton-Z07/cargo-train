<style>
	.r-date {
		font-size: 24px;
	}
	.r-time {
		vertical-align: top;
		padding-left: 4px;
		margin-top: 4px;
    	display: inline-block;
	}
	.route {
		border: 1px solid #ccc;
		border-width: 0 0 1px 0;
		margin-bottom: 10px;
		padding-bottom: 10px;
	}
	.s-name {
		display: inline-block;
		padding: 5px;
		background-color: #d7e9fb;
	}
	.in-travel {
		font-weight: 400;
		padding-top: 4px;
		font-size: 16px;
	}
	.r-price, .r-error {
		display: inline-block;
		padding: 5px;
		font-size: 16px;
		font-weight: 600;
		margin-top: 4px;
	}
	.r-price {
		background-color: #fffab9;
	}
	.r-error {
		background-color: #ffc0c0;
	}
	.divider {
		height: 15px;
	}
</style>

<div class="panel panel-flat">
	<form class="submit-if-filled">
		<input type="text" class="form-control station-name w200" placeholder="Станция отправления" value="<?= $from; ?>" name="from" autocomplete="off" />
		<input type="text" class="form-control station-name w200" placeholder="Станция назначения" name="to" value="<?= $to; ?>" autocomplete="off" />
		<input type="text" class="form-control w100 optional" placeholder="Вес груза" name="weight" value="<?= $weight ? $weight : ''; ?>" />
		<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Поиск рейсов</button>
	</form>
</div>

<? if ($routes): ?>
	<div class="routes">
		<? foreach ($routes as $a): 
			list($date, $route) = $a; ?>
			<div class="route">
				<div class="col-md-4 col-sm-6 col-xs-6">
					<? list($d, $t) = explode(' ', $route->getDepatrureDate($from, $date)); ?>
					<div>
						<span class="r-date"><?= Common::getReadableDate($d); ?> <?= Common::getYearIsDiff($d); ?></span>
						<span class="r-time"><?= $t; ?></span>
					</div>
					<div>Из <span class="s-name"><?= $from; ?></span></div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6">
					<? list($d, $t) = explode(' ', $route->getArrivalDate($to, $date)); ?>
					<div>
						<span class="r-date"><?= Common::getReadableDate($d); ?> <?= Common::getYearIsDiff($d); ?></span>
						<span class="r-time"><?= $t; ?></span>
					</div>
					<div>В <span class="s-name"><?= $to; ?></span></div>
					<b class="in-travel">В пути <?= $route->getInTravelTime($from, $to, true); ?></b>
				</div>
				<div class="divider col-xs-12 visible-sm-block visible-xs-block"></div>
				<div class="col-md-2 col-sm-6 col-xs-6">
					<?= ($time = $route->getStandingTime($to)) > 0 ? 'Стоянка' : ''; ?> <?= $route->getStandingTime($to, true); ?>
					<? $weightOk = Settings::checkStayingWeight($time, $weight); ?>
					<? if ($weight): ?>
						<div>
							<? if ($weightOk): ?>
								<span class="r-price"><?= $weight * 50; ?> руб</span> за <?= $weight; ?> кг
							<? else: ?>
								<span class="r-error">Короткая стоянка для <?= $weight; ?> кг!</span>
							<? endif; ?>
						</div>
					<? endif; ?>
				</div>

				<div class="col-md-2 col-sm-6 col-xs-6">
					<? if ($weightOk): ?>
						<a class="btn btn-success" href="/employee/requests/add?from=<?= $from; ?>&to=<?= $to; ?>&weight=<?= $weight ? $weight : ''; ?>">Создать заявку</a>
					<? endif; ?>
				</div>

				<div class="clearfix"></div>
			</div>
		<? endforeach; ?>
	</div>
<? endif; ?>