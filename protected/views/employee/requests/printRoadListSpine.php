<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Корешок дорожной ведомости</title>

		<style>
			div {
				position: absolute;
				font-size: 12px;
			}
		</style>
		<script>
		window.onload = function(){
			//window.print();
		};
	</script>
	</head>
	<body>
		<img src="/docs/roadListSpine.jpg" />

		<? $conductor_count = 0;
		if ($request->shipping->conductor1) $conductor_count++;
		if ($request->shipping->conductor2) $conductor_count++;

		$labels = [
			[114,184,200,$request->getDepartureName()],
			[330,184,200,195506],
			[480,184,200,$request->destination->name],
			[680,184,200,$request->destination->code],
			[650,124,200,$request->shipping->railcar->number],
			[650,154,200,$request->shipping->route->speed],
			[140,222,200,$request->shipper_name],
			[336,223,200,$request->shipper_kpp],
			[336,243,200,$request->shipper_okpo],
			[500,222,200,$request->consignee_name],
			[676,223,200,$request->consignee_kpp],
			[676,243,200,$request->consignee_okpo],
			[140,262,273,$request->shipper_address],
			[500,262,273,$request->consignee_address],
			[200,300,200,$request->who_pays == 'shipper' ? '✓' : ''],
			[560,300,200,$request->who_pays == 'consignee' ? '✓' : ''],
			[84,341,326,$request->forwarding_address],
			[130,370,200,$request->forwarding_working_hours],
			[160,394,230,$request->forwarding_contacts],
			[452,341,306,$request->delivery_address],
			[500,370,200,$request->delivery_working_hours],
			[530,394,230,$request->delivery_contacts],
			[95,456,100,$request->place_count],
			[140,456,430,$request->declared_cargo_type],
			[576,456,40,$request->declared_weight],
			[626,456,40,$request->weight],
			[676,456,40,$request->declared_volume],
			[726,456,40,$request->volume],
			[626,494,40,$request->weight],
			[726,494,40,$request->volume],
			[676,620,100,$request->getShippingCost()],
			[676,686,40,$request->getDeliveryCost()],
			[608, 804, 90, $conductor_count],
			[670, 779, 90, $request->shipping->conductor1],
			[670, 810, 90, $request->shipping->conductor2],
			[676, 639, 100, $request->getLatticeCost()],
			[676, 661, 100, $request->getPackagingCost() + $request->getSealCost()],
		];

		function printInSquares($x, $y, $step, $word, &$labels) {
			foreach (str_split( str_replace('.', '', $word)) as $l) {
				$labels[] = [$x, $y, $l];
				$x += $step;
			}
		}

		printInSquares(296, 438, 22.5, CargoType::getCode($request->declared_cargo_type), $labels);

		if ($request->declared_package_type) {
			$types = ['Ящик'=>502, 'Короб'=>538, 'Паллет'=>576, 'Тюк'=>616, 'Мешок'=>690];
			if (isset($types[$request->declared_package_type]))
				$labels[] = [ $types[$request->declared_package_type], 542, 40, '✓'];
		}

		if ($request->lattice) {
			$labels[] = [87, 607, '✓'];
			printInSquares(200, 611, 12, $request->place_count, $labels);
			printInSquares(289, 611, 12, $request->weight, $labels);
			printInSquares(387, 611, 14, $request->volume, $labels);
		}

		$pack_seal = 0;
		if ($request->packaging) {
			$labels[] = [87, 626, '✓'];
			printInSquares(200, 630, 12, $request->place_count, $labels);
		}

		if ($request->seal) {
			$labels[] = [87, 645, '✓'];
			printInSquares(200, 648, 12, '???', $labels);
		}

		if ($request->warmth) {
			$labels[] = [676, 708, 100, '25%'];
		}

		foreach ($labels as $label) {
			$style = 'left: ' . $label[0] . 'px; top: ' . $label[1] . 'px; ';
			$text = $label[count($label)-1];
			if (count($label) == 4) $style .= 'width: ' . $label[2] . 'px; ';
			echo "<div style='$style'>$text</div>";
		}
		?>
	</body>
</html>