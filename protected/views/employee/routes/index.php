<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/employee/routes/ajax",
			},
			columns: [
		        { data: 'n' },
		        { data: 'number' },
		        { data: 'name' },
		        { data: 'id' },
		    ],
		    "fnCreatedRow": function( tr, data ) {
		   		$(tr).attr('data-id', data.id);
		   	},
		    columnDefs: [ 
		    	{ targets: 0, orderable: false },
		    	{ targets: 3, orderable: false, 
		    		render: function ( data, type, row ) {
		    			var edit = '<a class="btn btn-warning btn-xxs" href="/employee/routes/add/'+data+'"><i class="fa fa-pencil"></i></a>';
		    			var view = '<a class="btn btn-info btn-xxs" href="/employee/routes/view/'+data+'"><i class="fa fa-eye"></i></a>';
                    	return edit;
                	}
            	},
		   	]
		});

		$('.datatable-ajax').on('click', 'tr', function() {
			if ($(this).attr('data-id'))
				window.location.href = "/employee/routes/add/"+$(this).attr('data-id');
		});
	});
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<a type="button" class="btn btn-success" style="float: right" href="/employee/routes/add">Добавить маршрут</a>
		</div>
	</div>
	<table class="table table-hover datatable-ajax">
		<thead>
			<tr>
				<th>#</th>
				<th>Номер</th>
				<th>Название</th>
				<th>Действия</th>
			</tr>
		</thead>
	</table>
</div>