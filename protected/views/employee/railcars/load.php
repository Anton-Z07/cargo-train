<form method="GET" class="form-horizontal">
	<div class="col-md-10 col-sm-12 col-lg-8">
		<div class="form-group">
			<label class="col-sm-6 control-label">Маршрут:</label>
			<div class="col-sm-6">
				<select name="id_route" class="form-control">
					<? foreach (Route::findMany() as $route): ?>
						<option value="<?= $route->id; ?>"><?= $route->getName(); ?></option>
					<? endforeach; ?>
				</select>
			</div>
		</div>  

		<div class="form-group">
			<label class="col-sm-6 control-label">Дата отправления:</label>
			<div class="col-sm-6">
				<input type="text" name="date" class="form-control date" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-6 control-label">Первый проводник</label>
			<div class="col-sm-6">
				<input type="text" name="conductor1" class="form-control" required>
			</div>
		</div>  

		<div class="form-group">
			<label class="col-sm-6 control-label">Второй проводник</label>
			<div class="col-sm-6">
				<input type="text" name="conductor2" class="form-control" required>
			</div>
		</div>  

		<div class="text-right">
			<a href="/employee/railcars" class="btn btn-default">Отмена</a>&nbsp;
			<button type="submit" class="btn btn-primary">Далее <i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>