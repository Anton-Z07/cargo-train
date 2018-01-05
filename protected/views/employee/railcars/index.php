<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/employee/railcars/ajax",
			},
			columns: [
		        { data: 'n' },
		        { data: 'number' },
		        { data: 'status' },
		        { data: 'route' },
		        { data: 'actions' },
		    ],
		    "fnCreatedRow": function( tr, data ) {
		   		$(tr).attr('data-id', data.id);
		   	},
		    columnDefs: [ 
		    	{ targets: 0, orderable: false },
		    	{ targets: 4, orderable: false, 
		    		render: function ( data, type, row ) {
		    			var load = '<a class="btn btn-success btn-xxs" href="/employee/railcars/load/'+row.id+'">Загрузить <i class="fa fa-shopping-bag"></i></a>';
		    			var edit = '<a class="btn btn-warning btn-xxs" href="/employee/railcars/add/'+row.id+'"><i class="fa fa-pencil"></i></a>';
		    			var view = '<a class="btn btn-info btn-xxs" href="/employee/railcars/view/'+row.id+'"><i class="fa fa-eye"></i></a>';
                    	var actions = '';
                    	if (data == 'load') actions += load + '&nbsp;';
                    	actions += view + '&nbsp;' + edit;
                    	return actions;
                	}
            	},
		   	]
		});

		$('.datatable-ajax').on('click', 'tr', function() {
			if ($(this).attr('data-id'))
				window.location.href = "/employee/railcars/view/"+$(this).attr('data-id');
		});
	});
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<a type="button" class="btn btn-success" style="float: right" href="/employee/railcars/add">Добавить вагон</a>
		</div>
	</div>
	<table class="table table-hover datatable-ajax">
		<thead>
			<tr>
				<th>#</th>
				<th>Номер</th>
				<th>Статус</th>
				<th>Маршрут</th>
				<th>Действия</th>
			</tr>
		</thead>
	</table>
</div>