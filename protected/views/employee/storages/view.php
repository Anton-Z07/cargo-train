<div>
	<table class="table">
		<thead>
			<tr>
				<th>ID груза</th>
				<th>Вес</th>
				<th>Кол-во мест</th>
			</tr>
		</thead>
		<tbody>
			<? 
			$weight = 0;
			$places = 0;
			foreach ($storage->getRequests() as $r): 

			?>
				<tr>
					<td><?=$r->id;?></td>
					<td><?=$r->weight;?></td>
					<td><?=$r->place_count;?></td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</div>