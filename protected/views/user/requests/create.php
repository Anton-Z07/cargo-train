<div class="content">
	<div class="page">
		<form method="POST" class="form-horizontal">
			<div class="col-md-8 col-sm-12 col-lg-7">
				<div class="form-group">
					<label class="col-sm-4 control-label">Пункт отправления:</label>
					<div class="col-sm-8">
						<p class="form-control-static"><?=$from;?></p>
					</div>
				</div>		

				<div class="form-group">
					<label class="col-sm-4 control-label">Пункт назначения:</label>
					<div class="col-sm-8">
						<p class="form-control-static"><?=$to;?></p>
					</div>
				</div>		

				<div class="form-group">
					<label class="col-sm-4 control-label">Количество мест:</label>
					<div class="col-sm-8">
						<input type="text" name="request[declared_place_count]" class="form-control" autocomplete="off" />
					</div>
				</div>	

				<div class="form-group">
					<label class="col-sm-4 control-label">Вес, кг:</label>
					<div class="col-sm-8">
						<input type="text" name="request[declared_weight]" class="form-control w100" value="<?= U::gi('weight') ? U::gi('weight') : ''; ?>" autocomplete="off" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">Объём, м³:</label>
					<div class="col-sm-8">
						<input type="text" name="request[declared_volume]" class="form-control w100" autocomplete="off"/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">Характер груза:</label>
					<div class="col-sm-8">
						<input type="text" name="request[declared_cargo_type]" class="form-control cargo-type" autocomplete="off" placeholder="Начните печатать...">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">Упаковка:</label>
					<div class="col-sm-8">
						<select name="request[declared_package_type]" class="form-control w100">
							<option>Ящик</option>
							<option>Палет</option>
							<option>Короб</option>
							<option>Мешок</option>
							<option>Рулон</option>
							<option>Бочка</option>
						</select>
					</div>
				</div>

				<div class="text-right">
					<a href="/user/requests" class="btn btn-default">Отмена</a>&nbsp;
					<button type="submit" class="btn btn-success">Создать заявку <i class="icon-arrow-right14 position-right"></i></button>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>

	</div>
</div>