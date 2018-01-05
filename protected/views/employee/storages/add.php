<form method="POST" class="form-horizontal">
	<div class="col-md-10 col-sm-12 col-lg-8">
		<div class="form-group">
			<label class="col-sm-6 control-label">Название:</label>
			<div class="col-sm-6">
				<input type="text" name="storage[name]" class="form-control" value="<?= $storage->name; ?>">
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-6 control-label">Автоматически помещать грузы до города:</label>
			<div class="col-sm-6">
				<select name="storage[id_destination]" class="form-control">
					<? Render::SelectOptions('Station', $storage->id_destination); ?>
				</select>
			</div>
		</div>		

		
		<div class="form-group">
			<label class="col-sm-6 control-label">Склад по умолчанию:</label>
			<div class="col-sm-6">
				<input type="hidden" name="storage[is_default]" value="0" />
				<input type="checkbox" name="storage[is_default]" class="form-control" value="1" <?= $storage->is_default ? 'checked="checked"' : ''; ?>>
			</div>
		</div>	

		<div class="text-right">
			<a href="/employee/storages" class="btn btn-default">Отмена</a>&nbsp;
			<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
		</div>
	</div>
</form>
