<script>
	$(function(){
		$('#same').click(function(){
			$('#places').val( <?= $request->declared_place_count; ?> );
			$('#weight').val( <?= $request->declared_weight; ?> );
			$('#volume').val( <?= $request->declared_volume; ?> );
		});
	});
</script>

<div class="col-md-8 col-sm-12 col-lg-7 form-horizontal view">
	<div class="form-group">
		<label class="col-sm-4">Пункт назначения:</label>
		<div class="col-sm-8">
			<?= $request->destination->name; ?>
		</div>
	</div>		

	<div class="form-group">
		<label class="col-sm-4">Заявленное кол-во мест:</label>
		<div class="col-sm-8">
			<?= $request->declared_place_count; ?>
		</div>
	</div>	

	<div class="form-group">
		<label class="col-sm-4">Заявленный вес:</label>
		<div class="col-sm-8">
			<?= $request->declared_weight; ?>
		</div>
	</div>	

	<div class="form-group">
		<label class="col-sm-4">Заявленный объём:</label>
		<div class="col-sm-8">
			<?= $request->declared_volume; ?>
		</div>
	</div>	

	<hr />

	<h4>Фактические данные:</h4>

	<a class="btn btn-link" id="same">Фактические данные совпадают с заявленными</a>

	<form method="POST" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-4 control-label">Количество мест:</label>
			<div class="col-sm-8">
				<input type="text" name="request[place_count]" class="form-control" id="places">
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-4 control-label">Вес:</label>
			<div class="col-sm-8">
				<input type="text" name="request[weight]" class="form-control" id="weight">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Объём:</label>
			<div class="col-sm-8">
				<input type="text" name="request[volume]" class="form-control" id="volume">
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-4 control-label">Виртуальный склад:</label>
			<div class="col-sm-8">
				<select name="request[id_storage]" class="form-control">
					<? Render::SelectOptions('Storage', $request->getAppropriateStorage()->id); ?>
				</select>
			</div>
		</div>		

		<div class="text-right">
			<a href="/employee/requests" class="btn btn-default">Отмена</a>&nbsp;
			<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
		</div>
	</form>
</div>