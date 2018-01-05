<script>
	$(function(){
		$.get('/common/CalcPrice/<?=$request->id;?>', function(data) {
			$('#price').html(data);
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
		<label class="col-sm-4">Количество мест:</label>
		<div class="col-sm-8">
			<?= $request->place_count; ?>
		</div>
	</div>	

	<div class="form-group">
		<label class="col-sm-4">Вес:</label>
		<div class="col-sm-8">
			<?= $request->weight; ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Объём:</label>
		<div class="col-sm-8">
			<?= $request->declared_volume; ?>  м³
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Характер груза:</label>
		<div class="col-sm-8">
			<?= $request->declared_cargo_type; ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Упаковка:</label>
		<div class="col-sm-8">
			<?= $request->declared_package_type; ?>
		</div>
	</div>

	<h4>Грузоотправитель</h4>
	<div class="form-group">
		<label class="col-sm-4">Тип:</label>
		<div class="col-sm-8">
			<?= $request->getParticipantTypeName($request->shipper_type); ?>
		</div>
	</div>

	<? if ($request->shipper_type == 'entity'): ?>
		<div class="form-group">
			<label class="col-sm-4">Полное наименование:</label>
			<div class="col-sm-8">
				<?= $request->shipper_name; ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4">КПП/ИНН:</label>
			<div class="col-sm-8">
				<?= $request->shipper_kpp; ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4">ОКПО:</label>
			<div class="col-sm-8">
				<?= $request->shipper_okpo; ?>
			</div>
		</div>
	<? endif; ?>

	<? if ($request->shipper_type == 'person'): ?>
		<div class="form-group">
			<label class="col-sm-4">ФИО:</label>
			<div class="col-sm-8">
				<?= $request->shipper_name; ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4">Паспорт:</label>
			<div class="col-sm-8">
				<?= $request->shipper_kpp; ?>
			</div>
		</div>
	<? endif; ?>

	<div class="form-group">
		<label class="col-sm-4">Почтовый адрес:</label>
		<div class="col-sm-8">
			<?= $request->shipper_address; ?>
		</div>
	</div>

	<h4>Экспедирование</h4>
	<div class="form-group">
		<label class="col-sm-4">Адрес:</label>
		<div class="col-sm-8">
			<?= $request->forwarding_address; ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Время работы:</label>
		<div class="col-sm-8">
			<?= $request->forwarding_working_hours; ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Контактное лицо, телефон:</label>
		<div class="col-sm-8">
			<?= $request->forwarding_contacts; ?>
		</div>
	</div>

	<hr />

	<h4>Грузополучатель</h4>
	<div class="form-group">
		<label class="col-sm-4">Тип:</label>
		<div class="col-sm-8">
			<?= $request->getParticipantTypeName($request->consignee_type); ?>
		</div>
	</div>

	<? if ($request->consignee_type == 'entity'): ?>
		<div class="form-group">
			<label class="col-sm-4">Полное наименование:</label>
			<div class="col-sm-8">
				<?= $request->consignee_name; ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4">КПП/ИНН:</label>
			<div class="col-sm-8">
				<?= $request->consignee_kpp; ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4">ОКПО:</label>
			<div class="col-sm-8">
				<?= $request->consignee_okpo; ?>
			</div>
		</div>
	<? endif; ?>

	<? if ($request->consignee_type == 'person'): ?>
		<div class="form-group">
			<label class="col-sm-4">ФИО:</label>
			<div class="col-sm-8">
				<?= $request->consignee_name; ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4">Паспорт:</label>
			<div class="col-sm-8">
				<?= $request->consignee_kpp; ?>
			</div>
		</div>
	<? endif; ?>

	<div class="form-group">
		<label class="col-sm-4">Почтовый адрес:</label>
		<div class="col-sm-8">
			<?= $request->consignee_address; ?>
		</div>
	</div>

	<h4>Доставка</h4>
	<div class="form-group">
		<label class="col-sm-4">Адрес:</label>
		<div class="col-sm-8">
			<?= $request->delivery_address; ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Время работы:</label>
		<div class="col-sm-8">
			<?= $request->delivery_working_hours; ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Контактное лицо, телефон:</label>
		<div class="col-sm-8">
			<?= $request->delivery_contacts; ?>
		</div>
	</div>

	<hr />

	<div class="form-group">
		<label class="col-sm-4">Плательщик:</label>
		<div class="col-sm-8">
			<?= Request::getPartTypeName($request->who_pays); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4">Доп. услуги:</label>
		<div class="col-sm-8">
			<?= $request->getServicesNames(); ?>
		</div>
	</div>

	<h4>Рассчёт цены</h4>
	<div id="price"></div>

	<? if ($request->shipping): ?>
		<div class="form-group">
			<a href="/employee/requests/printRoadList/<?=$request->id;?>" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> Печать дорожной ведомости</a>
		</div>

		<div class="form-group">
			<a href="/employee/requests/printRoadListSpine/<?=$request->id;?>" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> Печать корешка дорожной ведомости</a>
		</div>

		<div class="form-group">
			<a href="/employee/requests/printReceipt/<?=$request->id;?>" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> Печать квитанции</a>
		</div>
	<? endif; ?>

	<div class="text-right">
		<a href="/employee/requests" class="btn btn-default">Назад</a>&nbsp;
	</div>
</div>