<form method="POST" class="form-horizontal">
	<div class="col-md-10 col-sm-12 col-lg-8">
		<div class="form-group">
			<label class="col-sm-6 control-label">Род вагона:</label>
			<div class="col-sm-6">
				<select name="railcar[type]" class="form-control">
					<? Render::SelectOptionsFromArrayV(['Крытый','Полувагон','Платформа','Самосвал','Цистерна'], $railcar->type); ?>
				</select>
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-6 control-label">Номер:</label>
			<div class="col-sm-6">
				<input type="text" name="railcar[number]" class="form-control" value="<?= $railcar->number; ?>">
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-6 control-label">Грузоподъёмность, кг:</label>
			<div class="col-sm-6">
				<input type="text" name="railcar[capacity]" class="form-control" value="<?= $railcar->capacity; ?>">
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-6 control-label">Объём, м³:</label>
			<div class="col-sm-6">
				<input type="text" name="railcar[volume]" class="form-control" value="<?= $railcar->volume; ?>">
			</div>
		</div>	

		<div class="text-right">
			<a href="/employee/railcars" class="btn btn-default">Отмена</a>&nbsp;
			<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
		</div>
	</div>
</form>
