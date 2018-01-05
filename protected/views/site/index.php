<div class="content <?= $search ? '' : 'full-height middle' ?>">
	<form class="submit-if-filled search-form middle-content">
		<div class="title">Железнодорожные перевозки грузов</div>
		<div class="span-holder">
			<input type="text" class="l-rounded" placeholder="Станция отправления" value="Москва" name="from" readonly="readonly" autocomplete="off"/>
			<span><i class="fa fa-lock" aria-hidden="true"></i></span>
		</div>
		<input type="text" class="station-name" placeholder="Станция назначения" name="to" value="<?= $to; ?>" value="<?= $to; ?>" autocomplete="off" autofocus/>
		<div class="span-holder">
			<input type="text" class="r-rounded optional weight" placeholder="Вес груза" name="weight" value="<?= $weight ? $weight : ''; ?>" />
			<span>кг</span>
		</div>
		<button type="submit" class="btn btn-lg btn-main"><i class="fa fa-search" aria-hidden="true"></i> Поиск рейсов</button>
	</form>
</div>

<? if ($search): ?>
	<div class="routes">
		<div class="content">
			<? if ($routes): ?>
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
						<? $weightOk = $time > -1 ? Settings::checkStayingWeight($time, $weight) : true; ?>
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
							<a class="btn btn-success" href="/site/register?r_id=<?=$route->id;?>&date=<?=$date;?>&from=<?=$from;?>&to=<?=$to;?>&weight=<?=$weight;?>">Создать заявку</a>
						<? endif; ?>
					</div>

					<div class="clearfix"></div>
				</div>
			<? endforeach; ?>
			<? else: ?>
				<h2>Нет машрутов :(</h2>
			<? endif; ?>
		</div>
	</div>
<? endif; ?>