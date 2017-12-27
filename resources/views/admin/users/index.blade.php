@extends('admin.layouts.master')
@section('breadcumbs')
@include('admin.layouts.partials.breadcumbs',['page' => [ 'url'=>'/users','title'=>'Manage Users']  ])
@endsection

@section('top-css')
    <link href="/admin/plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')
<style type="text/css">
#BenchmarksModal {
	padding-top: 14%;
}
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
td.details-control {
    background: url('/images/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('/images/minus.png') no-repeat center center;
}
.table td, .table th {
    vertical-align: middle;
}
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title m-b-0">Users</h3>
			<p class="text-muted m-b-30">All users</p>
			<div class="table-responsive">
				<table id="users" class="table table-striped">
					<thead>
						<tr>
							<th>name</th>
							<th>email</th>
							<th>role</th>
							<th>Join date</th>
							<th>Last login</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- modal content -->
<div id="BenchmarksModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="Benchmarks" aria-hidden="true" style="display: none;">

</div>

@endsection


@section('js')
 <script src="/admin/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script type="text/javascript">
	     var table = $('#users').DataTable({
	     	dom: 'Bfrtip',
	        buttons: [
	            'csv', 'excel', 'pdf'
	        ],
          columnDefs: [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            order: [
                [4, 'desc']
            ],
            displayLength: 10,
            processing: true,
            serverSide: true,
            ajax: '/api/admin/users',
            columns:
            [
            	{ 'data': 'provider_id','width': 200, render: function(data, type, full, meta)
                  {
                  	return getUserImage(data,full.name);
                  }
           		},
                { 'data': 'email', 'name': 'email' },
                { 'data': 'role', 'name': 'role' },
                { 'data': 'created_at', 'name': 'created_at' },
                { 'data': 'updated_at', 'name': 'updated_at' },
                {  "searchable": false,'data': 'id','width': 120,render: function(data, type, full, meta)
                  {
                    var string =  '<button style="margin-right:5px" type="button" onclick="getModal('+data+')" class="btn btn-info btn-circle"><i class="fa  fa-list-alt"></i> </button>';
                    string+= '<button style="margin-right:5px" type="button" onclick="getSend('+data+')" class="btn btn-success btn-circle"><i class=" icon-share-alt"></i> </button>';
                    string+= '<button  type="button" onclick="banUser('+data+')" class="btn btn-danger btn-circle"><i class=" icon-trash"></i> </button>';
                    return string;
                  }
                }
            ]
        });

function str_limit(str,limit)
{
	if(str.length > limit) str = str.substring(0,limit) + '...';

	return str;
}
function getUserImage(id,name)
{
	return '<img  src="https://graph.facebook.com/' +id+ '/picture"><span style="margin-left:5px;">'+name+'</span>';
}
function getModal(id){
	$.get( "/api/admin/benchmarks/", function( data ) {
	 	 $("#BenchmarksModal").html(data);
     	var dt = $('#benchmarksTb').DataTable( {
		        "processing": true,
		        "serverSide": true,
		        "ajax": "/api/admin/benchmarks/"+id,
		        "columns": [
		            {
		                "class":          "details-control",
		                "orderable":      false,
		                "data":           null,
		                "defaultContent": ""
		            },

		            { "data": "title" },
		            { 'data': 'status', render: function(data, type, full, meta)
	                  {
	                  	if(data == 2){
	                  		return  '<span class="label label-table label-success">Ready</span>'
	                  	} else {
	                  		return  '<span class="label label-table label-danger">Pending</span>'
	                  	}

	                   }
               		},
		            { "data": "since" },
		            { "data": "until" },
		            { "data": "created_at" },
		            { 'data': 'id', render: function(data, type, full, meta)

	                	{
	                    return  '<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button>\
	                    	<button type="button" class="btn btn-info btn-circle"><i class="fa fa-eye"></i></button>';
	                	}
	                },
		        ],
		        "order": [[1, 'asc']]
			});

			var detailRows = [];
			function format ( d ) {
			    var string = '<div class="row">';
			    d.accounts.forEach(function(element) {
			    	string += '<div style="margin-top:10px;" class="col-md-3"><a target="_blank" href="https://www.facebook.com/'+element.real_id+'">'+str_limit(element.title,15)+'</a></div>';
			    });
      			string += '</div>';

      			return string;
			}
			$('#benchmarksTb tbody').on( 'click', 'tr td.details-control', function () {
			    var tr = $(this).closest('tr');
			    var row = dt.row( tr );
			    var idx = $.inArray( tr.attr('id'), detailRows );

			    if ( row.child.isShown() ) {
			        tr.removeClass( 'details' );
			        row.child.hide();

			        // Remove from the 'open' array
			        detailRows.splice( idx, 1 );
			    }
			    else {
			        tr.addClass( 'details' );
			        row.child( format( row.data() ) ).show();

			        // Add to the 'open' array
			        if ( idx === -1 ) {
			            detailRows.push( tr.attr('id') );
			        }
			    }
			} );

			// On each draw, loop over the `detailRows` array and show any child rows
			dt.on( 'draw', function () {
			    $.each( detailRows, function ( i, id ) {
			        $('#'+id+' td.details-control').trigger( 'click' );
			    } );
			} );

     	$("#BenchmarksModal").modal('show');
    });
}

    </script>
@endsection
