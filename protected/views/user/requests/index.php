<div class="content">
	<div class="page">
		<h2>Ваши заявки на грузоперевозку
			<a href="/" class="btn btn-main" style="float:right">Создать заявку</a></h2>
		<? if ($requests): ?>
			<table class="table">
				<thead>
					<tr>
						<th>Номер</th>
						<th>Дата создания</th>
						<th>Пункт назначения</th>
						<th>Статус</th>
					</tr>
				</thead>
				<tbody>
					<? foreach ($requests as $r): ?>
						<tr>
							<td><?=$r->id; ?></td>
							<td><?=date('d.m.Y H:i', strtotime($r->create_date)); ?></td>
							<td><?=$r->destination->name; ?></td>
							<td><?=$r->getStatus(); ?></td>
						</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		<? else: ?>
			<div>Список заявок пуст</div>
		<? endif; ?>
	</div>
</div>