<style>
	.list {
		border: 1px solid #e0e0e0;
	}
	.header {
		border: 1px solid #e0e0e0;
		border-width: 0 0 1px 0;
	}
	h3 {
		margin: 0;
		display: inline-block;
	}
	#leftovers {
		border: 1px dashed black;
		border-width: 0 0 1px 0;
		cursor: pointer;
	}
	#spare {
		display: none;
	}
	.divider {
		display: inline-block;
		margin: 0 10px;
	}
</style>

<script>
	$(function(){
		Update();
		$('#leftovers').click(function(){
			$('#spare').toggle();
		});
	});

	function Update() {
		var weight = 0;
		var volume = 0;
		var requests = [];
		$('#loaded tbody tr').each(function(i, tr) {
			weight += parseInt($(tr).find('td').eq(1).text());
			volume += parseFloat($(tr).find('td').eq(2).text());
			requests.push( $(tr).find('td').eq(0).text() );
		});
		$('#loaded_weight').text( weight );
		$('#loaded_volume').text( volume );
		$('#requests').val( JSON.stringify(requests) );

		spare_weight = 0;
		spare_volume = 0;
		spare_count = 0;
		$('#spare tbody tr').each(function(i, tr) {
			spare_count++;
			spare_weight += parseInt($(tr).find('td').eq(1).text());
			spare_volume += parseFloat($(tr).find('td').eq(2).text());
		});
		$('#spare_weight').text( spare_weight );
		$('#spare_volume').text( spare_volume );
		$('#spare_count').text( spare_count );
	}

	function Unload(btn) {
		$(btn).hide();
		$(btn).next().show();
		var tr = $(btn).closest('tr');
		tr.remove();
		$('#spare tbody').append( tr );
		Update();
	}

	function Load(btn) {
		$(btn).hide();
		$(btn).prev().show();
		var tr = $(btn).closest('tr');
		tr.remove();
		$('#loaded tbody').append( tr );
		Update();
	}
</script>

<div>
	<div class="col-md-6"><h3>Загрузить в вагон</h3></div>
	<div class="col-md-6 text-right"><b>Занято: <span id="loaded_weight"></span>/<?=$railcar->capacity; ?> кг <span class="divider">|</span> <span id="loaded_volume"></span>/<?=$railcar->volume;?> м³</b></div>
	<table class="table" id="loaded">
		<thead>
			<tr>
				<th>ID груза</th>
				<th>Вес</th>
				<th>Объём</th>
				<th>Кол-во мест</th>
				<th>Пункт назначения</th>
				<th>Действия</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($to_load as $r): ?>
				<tr>
					<td><?=$r->id;?></td>
					<td><?=$r->weight;?> кг</td>
					<td><?=$r->volume;?> м³</td>
					<td><?=$r->place_count;?></td>
					<td><?=$r->destination->name;?></td>
					<td>
						<button class="btn btn-danger btn-xxs unload" onclick="Unload(this);">Не загружать</button>
						<button class="btn btn-success btn-xxs load" style="display: none;" onclick="Load(this);">Загрузить</button>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</div>

<br />
<hr />
<br />

<div>
	<div class="col-md-6"><h3 id="leftovers">Оставшиеся грузы (<span id="spare_count"></span>)</h3></div>
	<div class="col-md-6 text-right"><b>Суммарная масса: <span id="spare_weight"></span> кг</b>
	<span class="divider">|</span> <b>Объём: <span id="spare_volume"></span> кг</b>
	</div>
	<table class="table" id="spare">
		<thead>
			<tr>
				<th>ID груза</th>
				<th>Объём</th>
				<th>Кол-во мест</th>
				<th>Пункт назначения</th>
				<th>Действия</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($spare as $r): ?>
				<tr>
					<td><?=$r->id;?></td>
					<td><?=$r->weight;?> кг</td>
					<td><?=$r->volume;?> м³</td>
					<td><?=$r->place_count;?></td>
					<td><?=$r->destination->name;?></td>
					<td>
						<button class="btn btn-danger btn-xxs unload" style="display: none;" onclick="Unload(this);">Не загружать</button>
						<button class="btn btn-success btn-xxs load" onclick="Load(this);">Загрузить</button>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</div>

<br />
<br />

<form method="POST">
	<input type="hidden" name="requests" id="requests">
	<div class="text-right">
		<a href="/employee/railcars" class="btn btn-default">Отмена</a>&nbsp;
		<button type="submit" class="btn btn-primary">Вагон загружен <i class="fa fa-check-circle-o"></i></button>
	</div>
</form>