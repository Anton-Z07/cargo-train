<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/employee/requests/ajax",
				data: function ( d ) {
	                d.f_id = $('#f_id').val();
	            }
			},
			columns: [
		        { data: 'id' },
		        { data: 'date' },
		        { data: 'destination' },
		        { data: 'status' },
		    ],
		    "fnCreatedRow": function( tr, data ) {
		   		$(tr).attr('data-id', data.id);
		   	},
		    columnDefs: [ 
		    	{ targets: 0, orderable: false }
		   	]
		});

		$('.datatable-ajax').on('click', 'tr', function() {
			if ($(this).attr('data-id'))
				window.location.href = "/employee/requests/view/"+$(this).attr('data-id');
		});
	});
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<form class="row form-inline" onsubmit="return false;">
			<input type="text" class="form-control" id="f_id" placeholder="ID заявки"> 
			<button type="submit" class="btn btn-primary" onclick="$('#table').DataTable().ajax.reload();">Применить</button>
			<a type="button" class="btn btn-success" style="float: right" href="/employee/requests/add">Новая заявка</a>
		</form>
	</div>
	<table class="table table-hover datatable-ajax" id="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Дата создания</th>
				<th>Куда</th>
				<th>Статус</th>
			</tr>
		</thead>
	</table>
</div>