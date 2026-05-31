@extends('master')

@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-md-12">

            <h3>Users
                <button type="button" class="btn btn-xs btn-primary float-right add">Add User</button>
            </h3>
            <hr>

            <table id="userDatatabel" class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>state</th>
                        <th>address</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>


            <!--  -->
            <div class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form id="addEditUserForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" id="userId" name="id">

                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" class="form-control input-sm">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Email:</label>
                                    <input type="text" name="email" class="form-control input-sm">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone:</label>
                                    <input type="number" name="country" class="form-control input-sm">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Country:</label>
                                    <input type="text" name="phone" class="form-control input-sm">
                                </div>
                                <div class="form-group">
                                    <label for="city">City:</label>
                                    <input type="text" name="city" class="form-control input-sm">
                                </div>
                                <div class="form-group">
                                    <label for="state">State: </label>
                                    <input type="text" name="state" class="form-control input-sm">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:
                                        <div class="justify-contetn-end">
                                            <button type="button" class="btn btn-xs btn-primary float-right add-address">Add Address</button>
                                        </div> 
                                        
                                    </label>
                                
                                    <div class=" " id="addressDiv">
                                        <div class="row mb-2 d-flex">
                                            <div class="col-9">
                                                <div class="address">
                                                    <input type="text" name="addresses[]" required  class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn remove-address btn-danger">Remove</button>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-save">Save</button>
                                <button type="submit" class="btn btn-primary btn-update">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function() {
        var token = ''
        var modal = $('.modal')
        var form = $('#addEditUserForm')
        var btnAdd = $('.add'),
            btnSave = $('.btn-save'),
            btnUpdate = $('.btn-update');
        
        var table = $('#userDatatabel').DataTable({
                "ajax": {
                    url: "{{ url('user') }}", // json datasource
                    type: "post", // method  , by default get
                    data: function ( d ) {
                        d._token = "{{ csrf_token() }}";
                    },
                    complete: function (data) {
                        
                    },
                    error: function () {  // error handling
                    
                    }
                },
                serverSide: true,
                processing: true,
                aaSorting:[[0,"desc"]],
                columns: [
                    {
                        data: 'id',
                        title: 'id'
                    },
                    {
                        data: 'name',
                        title: 'Name'
                    },
                    {
                        data: 'email',
                        title: 'Email'
                    },
                    {
                        data: 'phone',
                        title: 'Phone'
                    },
                    {
                        data: 'city',
                        title: 'City'
                    },
                    {
                        data: 'state',
                        title: 'State'
                    },
                    {
                        data: 'address',
                        title: 'Address'
                    },
                    {
                        data: 'action',
                        title: 'action',
                        orderable: false
                    },
                ]
            });

        btnAdd.click(function(){
            modal.modal()
            form.trigger('reset')
            $("span.error").remove();
            modal.find('.modal-title').text('Add New')
            btnSave.show();
            btnUpdate.hide()
        })

        $(document).ready(function() {
            $('.add-address').click(function() {
                $('#addressDiv').append(` <div class="row mb-2 d-flex">
                                            <div class="col-9">
                                                <div class="address">
                                                    <input type="text" name="addresses[]" required  class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn remove-address btn-danger">Remove</button>
                                            </div>    
                                        </div>
                                            `);
            });

            $(document).on('click', '.remove-address', function() {
                if ($('.address').length > 1) {
                    $(this).parent().parent().remove();
                }
            });
        });
  

    $("#addEditUserForm").submit(function (e) {
		e.preventDefault();
	}).validate({
		debug: false,
		errorClass: "error",
		errorElement: "span",
		rules: {
            name: "required",
                email: {
                    required: true,
                    email: true
                },
                phone: "required",
                country: "required",
                city: "required",
                state: "required",
                "addresses[]": "required"
		},
		messages: {
		},
		submitHandler: function (form, event) {
			event.preventDefault();
            user_id = $(form).find("input[name='id']").val();
            if(user_id == '')
				url = "{{ route('user-add') }}";
			else
				url = "{{ url('user-edit') }}/"+user_id;
			$.ajax({
				url:url, 
				type: "POST",
				data: new FormData(form),
				dataType: "JSON",
				processData: false,
				contentType: false,
				success: function (dataResult) {
					$("span.error").remove();
					if (dataResult.status) {
                        successMessage(dataResult.message)
                        $('.modal').modal('hide');
						table.ajax.reload();
					} else {
						if(dataResult.error.email)
							$('#addEditUserForm input[name="email"]').parent().append('<span class="error">'+dataResult.error.email+'</span>');
                        if(dataResult.error.name)
							$('#addEditUserForm input[name="name"]').parent().append('<span class="error">'+dataResult.error.name+'</span>');
                        if(dataResult.error.phone)
							$('#addEditUserForm input[name="phone"]').parent().append('<span class="error">'+dataResult.error.phone+'</span>');
                        if(dataResult.error.country)
							$('#addEditUserForm input[name="country"]').parent().append('<span class="error">'+dataResult.error.country+'</span>');
                        if(dataResult.error.city)
							$('#addEditUserForm input[name="city"]').parent().append('<span class="error">'+dataResult.error.city+'</span>');
                        if(dataResult.error.state)
							$('#addUserForm input[name="state"]').parent().append('<span class="error">'+dataResult.error.state+'</span>');
                        if(dataResult.error.addresses)
							$('#addEditUserForm input[name="addresses"]').parent().append('<span class="error">'+dataResult.error.addresses+'</span>');
						
					}
				}
			});
		}
	});

    

    // Edit Class
    $(document).on('click','.editUser',function (){
        let id = $(this).data('id');
        $.ajax({
            url: "{{route('get-user')}}",
            method: "post",
            dataType: 'json',
            data:{
                '_token' :"{{ csrf_token() }}",
                'user_id' : id
            },
            beforeSend: function (){
                $("#addEditUserForm").trigger('reset');
            },
            success: function (data){
                btnSave.hide();
                btnUpdate.show();
                modal.find('.modal-title').text('Update user')
                $("#userId").val(data.data.id);
                $('#addEditUserForm input[name="name"]').val(data.data.name)
                $('#addEditUserForm input[name="email"]').val(data.data.email)
                $('#addEditUserForm input[name="city"]').val(data.data.city)
                $('#addEditUserForm input[name="state"]').val(data.data.state)
                $('#addEditUserForm input[name="phone"]').val(data.data.phone)
                $('#addEditUserForm input[name="country"]').val(data.data.country)
                var html = ''
                if(data.data.addresses != null){
                    $.each(data.data.addresses, function (key, val) {
                            html += `<div class="row mb-2 d-flex">
                                                    <div class="col-9">
                                                        <div class="address">
                                                            <input type="text" name="addresses[]" value="`+val.address+`" required  class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <button type="button" class="btn remove-address btn-danger">Remove</button>
                                                    </div>    
                                                </div> `                            
                    });
                }

                $('#addressDiv').html(html)
                
                modal.modal()
            },
            error: function (response) {
                data = response.responseJSON;
                if (data.hasOwnProperty('error')) {
                    if (data.error.hasOwnProperty('class_id')) {
                        errorMessage(data.error.class_id);
                    }
                } else {
                    errorMessage(data.message);
                }
            }
        });
    });


   // delete user
	$(document).on("click", ".deleteUser", function () {
		id = $(this).data('id');
		Swal.fire({
			html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><h4>Are you Sure?</h4><p class="mb-0 text-muted">Do you really want to delete this?</p></div>',
			showCancelButton: !0,
			confirmButtonClass: "btn btn-danger w-xs me-2 mb-1",
			confirmButtonText: "Yes, Delete It!",
			cancelButtonClass: "btn btn-primary w-xs  mb-1",
			buttonsStyling: !1,
			showCloseButton: !0,
		}).then(function (t) {
			if (t.value) {
                $.ajax({
                    url: "{{route('user-delete')}}",
                    method: "post",
                    dataType: 'json',
                    data:{
                        '_token' :"{{ csrf_token() }}",
                        'user_id' : id
                    },
                    success: function (data){
                        successMessage(data.message)
                        table.ajax.reload();
                    },
                    error: function (response) {
                        data = response.responseJSON;
                        if (data.hasOwnProperty('error')) {
                            if (data.error.hasOwnProperty('class_id')) {
                                errorMessage(data.error.class_id);
                            }
                        } else {
                            errorMessage(data.message);
                        }
                    }
                });
			}
		});
	});
  
    })
</script>
@endsection