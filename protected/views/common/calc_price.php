<div class="form-group">
	<label class="col-sm-4">Стоимость перевозки:</label>
	<div class="col-sm-8">
		<?= $r->getShippingCost(); ?> руб
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4">Стоимость обрешётки:</label>
	<div class="col-sm-8">
		<?= $r->getLatticeCost(); ?> руб
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4">Стоимость упаковки:</label>
	<div class="col-sm-8">
		<?= $r->getPackagingCost(); ?> руб
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4">Стоимость пломбирования:</label>
	<div class="col-sm-8">
		<?= $r->getSealCost(); ?> руб
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4">Стоимость доставки:</label>
	<div class="col-sm-8">
		<?= $r->getDeliveryCost(); ?> руб
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4">Общая стоимось:</label>
	<div class="col-sm-8">
		<b><?= $r->getTotalCost(); ?> руб</b>
	</div>
</div>