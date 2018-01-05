<script>
	$(function(){
		$('#form input').change(function(){
			$.post('/common/CalcPrice', $('#form').serialize(), function(data){
				$('#price').html(data);
			});
		});
	});

	function OnTypeChange(radio) {
		var name = $(radio).attr('name').split('[')[1].replace(']', '');
		var id = name + '_' + $(radio).val();
		$('.'+name).hide();
		$('#'+id).find('input').prop('disabled', false);
		$('#'+id).show();
		$('.'+name).not('#'+id).find('input').prop('disabled', true);
	}
</script>

<form method="POST" class="form-horizontal view" id="form">
	<div class="col-md-12 col-sm-12 col-lg-8">
		<div class="form-group">
			<label class="col-sm-4 control-label">Пункт отправления:</label>
			<div class="col-sm-8">
				<p class="form-control-static">Москва</p>
			</div>
		</div>		

		<div class="form-group">
			<label class="col-sm-4 control-label">Пункт назначения:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control station-name w200" placeholder="Станция назначения" name="destinaion" value="<?= U::gp('to'); ?>" autocomplete="off" />
			</div>
		</div>		

		<div class="form-group">
			<label class="col-sm-4 control-label">Количество мест:</label>
			<div class="col-sm-8">
				<input type="text" name="request[declared_place_count]" class="form-control">
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-4 control-label">Вес:</label>
			<div class="col-sm-8">
				<input type="text" name="request[declared_weight]" class="form-control w100" value="<?= U::gp('weight'); ?>"> кг
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Объём:</label>
			<div class="col-sm-8">
				<input type="text" name="request[declared_volume]" class="form-control w100"> м³
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Характер груза:</label>
			<div class="col-sm-8">
				<input type="text" name="request[declared_cargo_type]" class="form-control cargo-type" autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Упаковка:</label>
			<div class="col-sm-8">
				<select name="request[declared_package_type]" class="form-control w100">
					<option>Ящик</option>
					<option>Паллет</option>
					<option>Короб</option>
					<option>Мешок</option>
					<option>Тюк</option>
				</select>
			</div>
		</div>

		<hr />

		<h4>Грузоотправитель</h4>
		<div class="form-group">
			<label class="col-sm-4 control-label">Тип грузоотправителя:</label>
			<div class="col-sm-8">
				<label class="radio-inline">
					<input type="radio" name="request[shipper_type]" checked="checked" value="entity" onchange="OnTypeChange(this);">
					Юр. лицо
				</label>
				<label class="radio-inline">
					<input type="radio" name="request[shipper_type]" value="person" onchange="OnTypeChange(this);">
					Физ. лицо
				</label>
			</div>
		</div>

		<div id="shipper_type_entity" class="shipper_type">
			<div class="form-group">
				<label class="col-sm-4 control-label">Полное наименование:</label>
				<div class="col-sm-8">
					<input type="text" name="request[shipper_name]" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">КПП/ИНН:</label>
				<div class="col-sm-8">
					<input type="text" name="request[shipper_kpp]" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">ОКПО:</label>
				<div class="col-sm-8">
					<input type="text" name="request[shipper_okpo]" class="form-control">
				</div>
			</div>
		</div>

		<div id="shipper_type_person" class="shipper_type dn">
			<div class="form-group">
				<label class="col-sm-4 control-label">ФИО:</label>
				<div class="col-sm-8">
					<input type="text" name="request[shipper_name]" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Серия и номер паспорта:</label>
				<div class="col-sm-8">
					<input type="text" name="request[shipper_kpp]" class="form-control">
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Почтовый адрес:</label>
			<div class="col-sm-8">
				<input type="text" name="request[shipper_address]" class="form-control">
			</div>
		</div>

		<h4>Экспедирование</h4>
		<div class="form-group">
			<label class="col-sm-4 control-label">Адрес:</label>
			<div class="col-sm-8">
				<input type="text" name="request[forwarding_address]" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Время работы:</label>
			<div class="col-sm-8">
				<input type="text" name="request[forwarding_working_hours]" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Контактное лицо, телефон:</label>
			<div class="col-sm-8">
				<input type="text" name="request[forwarding_contacts]" class="form-control">
			</div>
		</div>

		<hr />

		<h4>Грузополучатель</h4>
		<div class="form-group">
			<label class="col-sm-4 control-label">Тип грузоотправителя:</label>
			<div class="col-sm-8">
				<label class="radio-inline">
					<input type="radio" name="request[consignee_type]" checked="checked" value="entity" onchange="OnTypeChange(this);">
					Юр. лицо
				</label>
				<label class="radio-inline">
					<input type="radio" name="request[consignee_type]" value="person" onchange="OnTypeChange(this);">
					Физ. лицо
				</label>
			</div>
		</div>

		<div id="consignee_type_entity" class="consignee_type">
			<div class="form-group">
				<label class="col-sm-4 control-label">Полное наименование:</label>
				<div class="col-sm-8">
					<input type="text" name="request[consignee_name]" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">КПП/ИНН:</label>
				<div class="col-sm-8">
					<input type="text" name="request[consignee_kpp]" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">ОКПО:</label>
				<div class="col-sm-8">
					<input type="text" name="request[consignee_okpo]" class="form-control">
				</div>
			</div>
		</div>

		<div id="consignee_type_person" class="consignee_type dn">
			<div class="form-group">
				<label class="col-sm-4 control-label">ФИО:</label>
				<div class="col-sm-8">
					<input type="text" name="request[consignee_name]" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Серия и номер паспорта:</label>
				<div class="col-sm-8">
					<input type="text" name="request[consignee_kpp]" class="form-control">
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Почтовый адрес:</label>
			<div class="col-sm-8">
				<input type="text" name="request[consignee_address]" class="form-control">
			</div>
		</div>

		<h4>Доставка</h4>
		<div class="form-group">
			<label class="col-sm-4 control-label">Адрес:</label>
			<div class="col-sm-8">
				<input type="text" name="request[delivery_address]" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Время работы:</label>
			<div class="col-sm-8">
				<input type="text" name="request[delivery_working_hours]" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Контактное лицо, телефон:</label>
			<div class="col-sm-8">
				<input type="text" name="request[delivery_contacts]" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Плательщик:</label>
			<div class="col-sm-8 radio">
				<label style="margin-right: 20px"><input type="radio" name="request[who_pays]" value="shipper" checked="checked" />Грузоотправитель</label>
				<label><input type="radio" name="request[who_pays]" value="consignee" />Грузополучатель</label>
			</div>
		</div>

		<h4>Доп. услуги</h4>
		<div class="form-group">
			<label class="col-sm-4 control-label">Обрешётка:</label>
			<div class="col-sm-8">
				<input type="checkbox" name="request[lattice]" class="big-check" value="1">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Упаковка:</label>
			<div class="col-sm-8">
				<input type="checkbox" name="request[packaging]" class="big-check" value="1">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Пломба:</label>
			<div class="col-sm-8">
				<input type="checkbox" name="request[seal]" class="big-check" value="1">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Доставка в тепле:</label>
			<div class="col-sm-8">
				<input type="checkbox" name="request[warmth]" class="big-check" value="1">
			</div>
		</div>

		<h4>Рассчёт цены</h4>
		<div class="form-group" id="price">
		</div>

		<div class="text-right">
			<a href="/employee/requests" class="btn btn-default">Отмена</a>&nbsp;
			<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
		</div>
	</div>
</form>
