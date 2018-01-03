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
.modal {
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
			<h3 class="box-title m-b-0">Invitations</h3>
			<a href="#" data-toggle="modal" data-target="#newInviteModal" class="btn btn-info pull-right">New</a>
			<div class="table-responsive">
				<table id="invitesTable" class="table table-striped">
					<thead>
						<tr>
							<th>Sender</th>
							<th>Sent to</th>
							<th>Used by</th>
							<th>Used Date</th>
							<th>Type</th>
							<th>Max</th>
							<th>Created at</th>
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
<div id="invitationModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="Benchmarks" aria-hidden="true" style="display: none;">
</div>
<div id="newLink" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="Benchmarks" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="Benchmarks">Invitation Link</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<div class="input-group">
							<input type="url" class="form-control" id="inviteUrl">
							<div class="input-group-addon"><i class="ti-link"></i></div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.modal-content -->

</div>

<!-- modal content -->
<div id="newInviteModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="Benchmarks" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="Benchmarks">New invitation</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<form id="newInvitationForm">
						<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
							<div class="form-group">
								<label class="form-control-label" for="exampleInputEmail1">Receiver Email address</label>
								<div class="input-group">
									<input name="email" type="email" class="form-control"  placeholder="Enter email">
									<div class="input-group-addon"><i class="ti-email"></i></div>
								</div>
								<div id="error-email" class="form-control-feedback"></div>
							</div>
							<div class="form-group ">
								<label for="exampleInputpwd2">Type</label>
								<div class="input-group">
									<select name="type" onchange="updateFields(this)" class="form-control">
										<option value="once">Single time use</option>
										<option value="auto">Auto</option>
										<option value="manual">Manual</option>
									</select>
									<div class="input-group-addon"><i class="ti-wand"></i></div>
								</div>
								<div id="error-type" class="form-control-feedback"></div>
							</div>
							<div class="form-group" id="maxInput" style="display:none">
									<label class="form-control-label" for="inputDanger1">Max free benchmarks</label>
									<input name="max" type="number" type="text" class="form-control " id="inputDanger1">
									<div id="error-max" class="form-control-feedback"></div>
							</div>
							<div class="form-check bd-example-indeterminate">
                                <label class="custom-control custom-checkbox">
                                    <input name="sendmail" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Send email</span>
                                </label>
                            </div>
							<div class="text-right">
								<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
								<button type="button" data-dismiss="modal" class="btn btn-inverse waves-effect waves-light">Cancel</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.modal-content -->

</div>
</div>
@endsection


@section('js')

 <script src="/admin/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script type="text/javascript">

    	var appUrl = {!! json_encode(url('/')) !!};

	     var table = $('#invitesTable').DataTable({
	     	dom: 'Bfrtip',
	        buttons: [
	            'csv', 'excel', 'pdf'
	        ],
          columnDefs: [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            order: [
                [1, 'desc']
            ],
            displayLength: 10,
            processing: true,
            serverSide: true,
            ajax: '/api/admin/invitations',
            columns:
            [
                { 'data': 'sender', render: function(data, type, full, meta)
                  {
                    return  getUserImage(data.provider_id,full.senderName);
                  }
                },
                { 'data': 'invited_email', 'name': 'invited_email' ,"defaultContent": ""},
                { 'data': 'reciever.name', 'name': 'reciever.name' ,"defaultContent": "<i>Not set yet</i>","searchable": false},
                { 'data': 'used_at', 'name': 'used_at' ,"defaultContent": "<i>Not used yet</i>"},
                { 'data': 'type', 'name': 'type' },
                { 'data': 'max', 'name': 'max',"defaultContent": "<i>Not Applicable</i>" },
                { 'data': 'created_at', 'name': 'created_at' },
                { "searchable": false,'data': 'id', render: function(data, type, full, meta)
                  {
                  	 var string =  '<button style="margin-right:3px"  data-id="'+data+'" type="button" class="btn btn-info btn-circle linki"><i class=" ti-link"></i> </button>';

                     string +=  '<button style="margin-right:3px" onclick="editInvit('+data+')" type="button" class="btn btn-warning btn-circle"><i class="fa fa-pencil"></i> </button>';

                    string += '<button type="button" data-id="'+data+'" class="btn btn-danger btn-circle delete"><i class=" fa fa-trash-o"></i> </button>';

                     return string;
                  }
                }
            ]
        });
$(document).on('click','.linki',function(){
	$('#inviteUrl').val(appUrl+'/invitation/'+$(this).data('id'));
	$('#newLink').modal('show');
});


$(document).on('click','.delete',function(){
	var inv = confirm("Are you sure you want to delete this invitation?");
	if (inv != true) {
	    return false;
	}

	$.post('/api/admin/invitations/delete/'+$(this).data('id')).then(function(e){
		if(e.status == 1){
			table.ajax.reload();
		}
	});
});


$( "#newInvitationForm" ).submit(function( event ) {
  event.preventDefault();
      $.ajax({
        url: '/api/admin/invitations/new',
        type: 'post',
        statusCode: {
            422: function (response) {
               var errors = response.responseJSON.errors;
               $.each(errors,function(i,v){
               		$('#error-'+i).text(v[0]);
               });
            }
        },
        data: $(this).serializeArray(),
        success: function (data) {
        	 table.ajax.reload( null, false );
        	 $('#newInviteModal').modal('hide');
        },
        error: function(data) {
        	//
        }
    })
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
function updateFields(element){
	if(element.value != 'auto'){
		$('#maxInput').css('display','none');
	} else {
		$('#maxInput').css('display','block');
	}
}


function getModal(id){
	$.get( "/api/admin/invitation/"+id, function( data ) {
	 	 $("#invitationModal").html(data);
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

     	$("#invitationModal").modal('show');
    });
}

    </script>
@endsection
