<style>
	#schedule-table {
		overflow: hidden;
	}
	#schedule-table tr:hover {
		background-color: #f0f0f0;
	}
	#schedule-table td,th {
		position: relative;
	}
	#schedule-table td:hover::after,
	#schedule-table th:hover::after {
		content: "";
		position: absolute;
		background-color: #f0f0f0;
		left: 0;
		top: -5000px;
		height: 10000px;
		width: 100%;
		z-index: -1;
	}
	#schedule-table td {
		min-width: 30px;
		vertical-align: middle;
		text-align: center;
	}
	#schedule-table td:first-child{
		width: 100px;
		text-align: left;
	}
	#schedule-table .day {
		cursor: pointer;
	}
	#schedule-table .day span {
		display: inline-block;
		vertical-align: middle;
		width: 12px;
		height: 12px;
		border: 1px solid #999;
		border-radius: 12px;
	}
	#schedule-table .day span.checked {
		background-color: #4caf50;
		border-color: #4caf50;
	}
	.tab-pane::after {
		content: " ";
		clear: both;
	}
	#stations-table .text {
		padding-top: 15px;
		padding-left: 20px;
	}
	#stations-table tbody td {
		vertical-align: top;
	}
	#stations-table tbody td input {
		display: inline-block;
	}
	.second-line {
		font-weight: normal;
		font-size: 12px;
		margin: 0;
	}
	.second-line * {
		vertical-align: top;
	}
	label input[type=checkbox] {
		margin: 0;
	}
	label span {
		margin-top: -1px;
    	display: inline-block;
	}
	.last-station-arrival {
		display: none;
	}
	label {
		font-weight: normal !important;
	}
	.plus-day input[type=checkbox] {
		vertical-align: middle;
    	margin-top: -2px;
	}
	.plus-day {
		margin-left: 5px;
	}
</style>

<script>
	$(function(){
		$('#schedule-table .day').click(function(){
			var span = $(this).find('span');
			span.toggleClass('checked');
			UpdateSchedule();
		});
		InitSchedule();
		IsNewStationNeeded();
		setInterval(IsNewStationNeeded, 500);
		disableEnterSubmit('form');
		$('form').submit(function(){
			MakeStations();
		});
		$('#stations-table .station input').change(UpdateStations);
		SetUpStations();
		UpdateStations();
	});

	function UpdateSchedule()
	{
		var res = {};
		$('#schedule tbody tr').each(function(n, tr) {
			var month = $(this).attr('data-month');
			$(this).find('td').each(function(day, td) {
				if (!day) return;
				if ($(td).find('span').hasClass('checked'))
				{
					if (!res[month]) 
						res[month] = [];
					res[month].push(day);
				}
			});
		});
		$('#route_schedule').val( JSON.stringify(res) );
	}
	function InitSchedule()
	{
		if (!$('#route_schedule').val()) return;
		var data = JSON.parse( $('#route_schedule').val() );
		for (month in data) {
			for (i in data[month]) {
				$('tr[data-month='+month+']').find('td').eq( data[month][i] ).find('span').addClass('checked');
			}
		}
	}
	function IsNewStationNeeded()
	{
		var needed = true;
		$('#stations-table .station:last-child input[type=text]:not(.hidden)').each(function(){
			if (!$(this).val() || $(this).val().indexOf('_') > -1)
				needed = false;
		});
		if ($('#stations-table .last-station:checked').size()) needed = false;
		if (needed)	AddStation();
	}

	function AddStation()
	{
		$('#stations-table .second-line').hide();
		var tr = $('#station-prototype').clone().removeAttr('id');
		$('#stations-table').append( tr );
		tr.find('.station-name').inputHint('/employee/home/StationsHint');
		tr.find('.time').mask('99:99');
		tr.find('input').change(UpdateStations);
		UpdateStations();
	}
	function UpdateStations()
	{
		var last_departure = '';
		var first_departure = '';
		var in_travel_time = 0;
		$('#stations-table tr.station').each(function(i){
			if ( $(this).find('.last-station' ).prop('checked') ) {
				var arrival = $(this).find('.last-arrival').val();
				var plus_day = $(this).find('.last-arrival').next().find('input[type=checkbox]').prop('checked');
				if (!arrival) return;
				arrival = new Date('1970-01-01 ' + arrival);
				in_travel_time += (arrival - last_departure) / 60000;
				if (plus_day) in_travel_time += 1440;
				$(this).find('.in-travel-time').text( minutesToText(in_travel_time) );
				$(this).find('.in-travel-time').attr('data-time', in_travel_time);
			} else {
				var ld = $(this).find('.departure').val();
				var standing = parseInt( $(this).find('.standing').val() );
				var departure = $(this).find('.departure').val();
				var plus_day = $(this).find('.departure').next().find('input[type=checkbox]').prop('checked');

				if (!ld) return;
				if (i == 0) {
					first_departure = last_departure = new Date('1970-01-01 ' + ld);
					return;
				}

				if (!standing || !departure) return;
				
				departure = new Date('1970-01-01 ' + departure);
				var arrival = new Date(departure.getTime() - standing*60000);
				var t = (arrival - last_departure) / 60000;
				in_travel_time += t;
				if (plus_day) in_travel_time += 1440;
				$(this).find('.arrival').text( ('0'+arrival.getHours()).slice(-2) + ":" + ('0'+arrival.getMinutes()).slice(-2) );
				$(this).find('.in-travel-time').text( minutesToText(in_travel_time) );
				$(this).find('.in-travel-time').attr('data-time', in_travel_time);
				last_departure = departure;
			}
		});
	}

	function MakeStations()
	{
		var data = [];

		$('#stations-table .station:not(:last-child)').each(function(){
			var t = {};
			t.n = $(this).find('.station-name').val();
			t.a = $(this).find('.arrival').text();
			t.d = $(this).find('.departure').val();
			t.s = $(this).find('.standing').size() ? $(this).find('.standing').val() : '';
			t.t = $(this).find('.in-travel-time').size() ? $(this).find('.in-travel-time').attr('data-time') : '';
			t.p = $(this).find('.departure').next().find('[type=checkbox]').prop('checked') ? 1 : 0;
			data.push(t);
		});
		var tr = $('#stations-table .station:last-child');
		if (tr.find('.last-station').prop('checked')) {
			var t = {};
			t.n = tr.find('.station-name').val();
			t.a = tr.find('.last-arrival').val();
			t.t = tr.find('.in-travel-time').attr('data-time');
			t.p = tr.find('.last-arrival').next().find('[type=checkbox]').prop('checked') ? 1 : 0;
			if (t.a && t.n) data.push(t);
		}

		$('#route_stations').val( JSON.stringify(data) );
	}

	function SetUpStations()
	{
		var json = $('#route_stations').val();
		var data = JSON.parse( json );
		var tr = false;
		if (!json || !data) return;
		for (var i in data) {
			if (i > 0) AddStation();
			tr = $('#stations-table .station:last-child').eq(0);
			var d = data[i];
			tr.find('.station-name').val( d.n );
			tr.find('.arrival').text( d.a );
			tr.find('.departure').val( d.d );
			tr.find('.standing').val( d.s );
			if (d.t != '0') tr.find('.in-travel-time').text( d.t );
			if (d.p) tr.find('.departure').next().find('[type=checkbox]').prop('checked', true);
		}
		if (tr) {
			tr.find('.last-arrival').val( tr.find('.arrival').text() );
			tr.find('.arrival').text( '' );
			tr.find('.last-station').click();
			tr.find('.departure').next().find('[type=checkbox]').prop('checked', false);
			if (d.p) tr.find('.last-arrival').next().find('[type=checkbox]').prop('checked', true);
		}
	}

	function OnLastStationClick(checkbox)
	{
		var tr = $(checkbox).closest('tr');
		if ( $(checkbox).prop('checked') ) {
			tr.find('.last-station-arrival').show();
			tr.find('.arrival').hide();

			tr.find('.last-arrival').removeClass('hidden');
			tr.find('.arrival,.standing,.departure').addClass('hidden');

			tr.find('.standing').closest('td').css('visibility','hidden');
			tr.find('.departure').closest('td').css('visibility','hidden');
		}
		else {
			tr.find('.last-station-arrival').hide();
			tr.find('.arrival').show();

			tr.find('.last-arrival').addClass('hidden');
			tr.find('.arrival,.standing,.departure').removeClass('hidden');

			tr.find('.standing').closest('td').css('visibility','visible');
			tr.find('.departure').closest('td').css('visibility','visible');
		}
	}
</script>

<ul class="nav nav-tabs nav-justified">
	<li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Основное</a></li>
    <li role="presentation"><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">Расписание</a></li>
    <li role="presentation"><a href="#stations" aria-controls="stations" role="tab" data-toggle="tab">Станции</a></li>
</ul>


<form method="POST" class="form-horizontal">
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="main">
			<input type="hidden" name="route[id_destination]" id="route_id_destination" value="<?= $route->id_destination; ?>">
			<input type="hidden" name="route[schedule]" id="route_schedule" value="<?= htmlspecialchars($route->schedule); ?>">
			<input type="hidden" name="route[stations]" id="route_stations" value="<?= htmlspecialchars($route->stations); ?>"/>
			<div class="col-md-10 col-sm-12 col-lg-8">
				<div class="form-group">
					<label class="col-sm-6 control-label">Название:</label>
					<div class="col-sm-6">
						<input type="text" name="route[name]" class="form-control" value="<?= $route->name; ?>">
					</div>
				</div>	

				<div class="form-group">
					<label class="col-sm-6 control-label">Номер:</label>
					<div class="col-sm-6">
						<input type="text" name="route[number]" class="form-control" value="<?= $route->number; ?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-6 control-label">Скорость:</label>
					<div class="col-sm-6">
						<select name="route[speed]" class="form-control">
							<? Render::SelectOptionsFromArrayV(['Большая','Грузовая'], $route->speed); ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="schedule">
			<table id="schedule-table">
				<thead>
					<tr>
					<? $months = ['jan'=>['Январь',31],
						'feb'=>['Февраль',cal_days_in_month(CAL_GREGORIAN,2,date('Y'))],
						'mar'=>['Март',31],
						'apr'=>['Апрель',30],
						'may'=>['Май',31],
						'jun'=>['Июнь',30],
						'jul'=>['Июль',31],
						'aug'=>['Август',31],
						'sep'=>['Сентябрь',30],
						'oct'=>['Октябрь',31],
						'nov'=>['Ноябрь',30],
						'dec'=>['Декабрь',31],
					];
					for ($i=0; $i<=31; $i++)
						echo '<td>'.($i ? $i : '').'</td>';
					?>
					</tr>
				</thead>
				<tbody>
					<?
					foreach ($months as $k => $month) {
						echo "<tr data-month='$k'>";
						for ($day=0; $day<=$month[1]; $day++)
							if ($day)
								echo "<td class='day'><span></span></td>";
							else
								echo "<td>{$month[0]}</td>";
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
		<div role="tabpanel" class="tab-pane" id="stations">
			<table class="table" id="stations-table">
				<thead>
					<tr>
						<th>Станция</th>
						<th>Прибытие</th>
						<th>Стоянка</th>
						<th>Отправление</th>
						<th>В пути</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr class="station">
						<td><input type="text" class="form-control station-name" placeholder="Станция отправления" value="" /></td>
						<td></td>
						<td></td>
						<td><input type="text" class="form-control departure time" placeholder="14:30" value="" /></td>
						<td class="in-travel-time" data-time="0"></td>
					</tr>
				</tbody>
			</table>
			<table style="display:none">
				<tr class="station" id="station-prototype">
					<td><input type="text" class="form-control station-name" placeholder="Название станции" />
						<label class="second-line"><input type="checkbox" class="last-station" onchange="OnLastStationClick(this);" /> <span>Конечная</span></label>
					</td>
					<td class="arrival text"></td>
					<td class="last-station-arrival"><input type="text" class="form-control last-arrival time hidden" placeholder="14:30" /> <label class="plus-day"><input type="checkbox" class="next-day"><span>+день</span></label></td>
					<td><input type="text" class="form-control standing ib" /> <span>мин</span></td>
					<td><input type="text" class="form-control departure time" placeholder="14:30" /> <label class="plus-day"><input type="checkbox" class="next-day"><span>+день</span></label></td>
					<td class="in-travel-time text"></td>
				</tr>
			</table>
		</div>
	</div>

	<div style="clear: both;"></div>
	<br />

	<div class="text-right">
		<a href="/employee/routes" class="btn btn-default">Отмена</a>&nbsp;
		<button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
	</div>
</form>