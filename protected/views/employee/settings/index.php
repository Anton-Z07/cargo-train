<script>
	$(function(){
		$('#staying-add').click(function(){
			var s = $(this).prev().prev().val();
			var w = $(this).prev().val();
			if (!s || !w) return;
			$('#staying-table tbody').append('<tr><td>'+s+' мин</td><td>'+w+' кг</td><td><a onclick="DeleteStaying(this);">удалить</a></td></tr>');
			UpdateStaying();
		});
	});

	function UpdateStaying()
	{
		var data = [];
		$('#staying-table tbody tr').each(function(){
			var t = {};
			t.time = parseInt($(this).find('td').eq(0).text());
			t.weight = parseInt($(this).find('td').eq(1).text());
			data.push(t);
		});
		$('#staying').val(JSON.stringify(data));
	}

	function DeleteStaying(btn)
	{
		$(btn).closest('tr').remove();
		UpdateStaying();
	}
</script>

<style>

</style>


<form method="POST" action="/employee/settings/save">
	<div>
		<input type="hidden" name="settings[staying_weight]" value="<?= htmlspecialchars(Settings::Get('staying_weight')); ?>" id="staying" />
		<h3>Макс. вес выдаваемого при стоянке груза</h3>
		<table class="table" id="staying-table">
			<thead>
				<tr>
					<th>Время стоянки</th>
					<th>Макс. вес груза</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<? if (is_array(Settings::GetDecoded('staying_weight'))) { foreach (Settings::GetDecoded('staying_weight') as $s): ?>
					<tr><td><?=$s->time; ?> мин</td>
						<td><?=$s->weight; ?> кг</td>
						<td><a onclick="DeleteStaying(this);">удалить</a></td>
					</tr>
				<? endforeach; } ?>
			</tbody>
		</table>
		<a onclick="$(this).next().toggle();" class="inner-link">Добавить</a>
		<div style="display: none;">
			<input type="text" placeholder="Время стоянки, мин" class="form-control w200" />
			<input type="text" placeholder="Макс. вес, кг" class="form-control w200" />
			<button type="button" class="btn btn-primary" id="staying-add"><i class="fa fa-plus" aria-hidden="true"></i> Добавить</button>
		</div>
	</div>
	<div class="buttons"><button type="submit" class="btn btn-success">Сохранить</button></div>
</form>