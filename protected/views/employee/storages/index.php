<script>
	$(function(){
		table = $('.datatable-ajax').DataTable({
        	"serverSide": true,
			ajax: {
				url: "/employee/storages/ajax",
			},
			columns: [
		        { data: 'n' },
		        { data: 'name' },
		        { data: 'destination' },
		        { data: 'is_default' },
		        { data: 'id' },
		    ],
		    "fnCreatedRow": function( tr, data ) {
		   		$(tr).attr('data-id', data.id);
		   	},
		    columnDefs: [ 
		    	{ targets: 0, orderable: false },
		    	{ targets: 4, orderable: false, 
		    		render: function ( data, type, row ) {
		    			var edit = '<a class="btn btn-warning btn-xxs" href="/employee/storages/add/'+data+'"><i class="fa fa-pencil"></i></a>';
		    			var view = '<a class="btn btn-info btn-xxs" href="/employee/storages/view/'+data+'"><i class="fa fa-eye"></i></a>';
                    	return view + '&nbsp;' + edit;
                	}
            	},
		   	]
		});

		$('.datatable-ajax').on('click', 'tr', function() {
			if ($(this).attr('data-id'))
				window.location.href = "/employee/storages/view/"+$(this).attr('data-id');
		});
	});
</script>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<a type="button" class="btn btn-success" style="float: right" href="/employee/storages/add">Добавить склад</a>
		</div>
	</div>
	<table class="table table-hover datatable-ajax">
		<thead>
			<tr>
				<th>#</th>
				<th>Название</th>
				<th>Главный город</th>
				<th>Склад по умолчанию</th>
				<th>Действия</th>
			</tr>
		</thead>
	</table>
</div>