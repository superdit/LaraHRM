@extends('layouts/backend')

@section('content')
  <style>
    .tooltip-inner {
        white-space: nowrap;
        max-width: 350px;
    }
    .search-icon {
        -webkit-transform: rotate(90deg);     /* Chrome and other webkit browsers */
        -moz-transform: rotate(90deg);        /* FF */
        -o-transform: rotate(90deg);          /* Opera */
        -ms-transform: rotate(90deg);         /* IE9 */
        transform: rotate(90deg); 
    }
  </style>
    <script>
        $(function() {
           $('#birthdate, #birthdate-edit').datetimepicker({pickTime: false}); 
           
           @if ($open_create_modal == 1)
            $('#addModal').modal('show');
            $('#addModal').on('shown.bs.modal', function (e) {                
                @if (isset($error_messages) && $error_messages->first('id_number') != "")
                $("[rel='tooltipidnumber']").tooltip({placement: 'right', title: '{{$error_messages->first('id_number')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-idnumber').addClass('has-error');
                @endif
                $('#addModal input[name="id_number"]').val('{{$input_values['id_number']}}');
                
                @if (isset($error_messages) && $error_messages->first('name') != "")
                $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-name').addClass('has-error');
                @endif
                $('#addModal input[name="name"]').val('{{$input_values['name']}}');
                
                @if (isset($error_messages) && $error_messages->first('email') != "")
                $("[rel='tooltipemail']").tooltip({placement: 'right', title: '{{$error_messages->first('email')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-email').addClass('has-error');
                @endif
                $('#addModal input[name="email"]').val('{{$input_values['email']}}');
                
                @if (isset($error_messages) && $error_messages->first('birthdate') != "")
                $("[rel='tooltipbirthdate']").tooltip({placement: 'right', title: '{{$error_messages->first('birthdate')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-birthdate').addClass('has-error');
                @endif
                $('#addModal input[name="birthdate"]').val('{{$input_values['birthdate']}}');
                
                @if (isset($error_messages) && $error_messages->first('address') != "")
                $("[rel='tooltipaddress']").tooltip({placement: 'right', title: '{{$error_messages->first('address')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-address').addClass('has-error');
                @endif
                $('#addModal textarea[name="address"]').val('{{$input_values['address']}}');
                
                @if (isset($error_messages) && $error_messages->first('phone') != "")
                $("[rel='tooltipphone']").tooltip({placement: 'right', title: '{{$error_messages->first('phone')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-phone').addClass('has-error');
                @endif
                $('#addModal input[name="phone"]').val('{{$input_values['phone']}}');
            });            
            @endif
            
            
            @if ($open_edit_modal == 1)
            $('#editModal').modal('show');
            $('#editModal').on('shown.bs.modal', function (e) {
                $('#editModal input[name="id"]').val('{{$input_values['id']}}');
                
                @if (isset($error_messages) && $error_messages->first('id_number') != "")
                $("[rel='tooltipidnumber-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('id_number')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-idnumber-edit').addClass('has-error');
                @endif
                $('#editModal input[name="id_number"]').val('{{$input_values['id_number']}}');
                
                @if (isset($error_messages) && $error_messages->first('name') != "")
                $("[rel='tooltipname-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-name-edit').addClass('has-error');
                @endif
                $('#editModal input[name="name"]').val('{{$input_values['name']}}');
                
                @if (isset($error_messages) && $error_messages->first('email') != "")
                $("[rel='tooltipemail-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('email')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-email-edit').addClass('has-error');
                @endif
                $('#editModal input[name="email"]').val('{{$input_values['email']}}');
                
                @if (isset($error_messages) && $error_messages->first('birthdate') != "")
                $("[rel='tooltipbirthdate-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('birthdate')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-birthdate-edit').addClass('has-error');
                @endif
                $('#editModal input[name="birthdate"]').val('{{$input_values['birthdate']}}');
                
                @if (isset($error_messages) && $error_messages->first('address') != "")
                $("[rel='tooltipaddress-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('address')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-address-edit').addClass('has-error');
                @endif
                $('#editModal textarea[name="address"]').val('{{$input_values['address']}}');
                
                @if (isset($error_messages) && $error_messages->first('phone') != "")
                $("[rel='tooltipphone-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('phone')}}', trigger: 'manual'}).tooltip('show');
                $('#form-group-phone-edit').addClass('has-error');
                @endif
                $('#editModal input[name="phone"]').val('{{$input_values['phone']}}');
            });            
            @endif
            
            // Event on show delete modal confirmation
            $('.btn-empl-del').click(function() {
                var tmp_id = $(this).attr('id').replace("del_", "");
                var tmp_id_number = $('#id_number_'+tmp_id).html();
                var html = '<h4 style="text-align:center;font-weight:bold;">Delete this employee id number: "'+tmp_id_number+'" ?</h4>';
                $('#modal-del-content').html(html);
                
                $('#btn-do-delete').attr('href', '{{URL::to("admin/employee/delete")}}/'+tmp_id);
            });
            
            // Event search click
            $('#btn-search').click(function(e) {
                var key = $('input[name="key"]').val();
                if (key.length > 0) {
                    window.location = '{{URL::to("admin/employee/search")}}/'+key;
                } else {
                    window.location = '{{URL::to("admin/employee")}}';
                }
            });
            
            $('input[name="key"]').keypress(function(e) {
                var code = e.keyCode || e.which;
                if(code == 13) {
                    var key = $('input[name="key"]').val();
                    if (key.length > 0) {
                        window.location = '{{URL::to("admin/employee/search")}}/'+key;
                    } else {
                        window.location = '{{URL::to("admin/employee")}}';
                    }
                }
            });
            
            // Event edit click
            $('.btn-edit').click(function(e) {
                var tmp_id = $(this).attr('id').replace('edit_', '');
                // Assign value to edit modal
                $('#edit-modal-form input[name="id"]').val($('#td_' + tmp_id + ' input[name="hid_id"]').val());
                $('#edit-modal-form input[name="id_number"]').val($('#td_' + tmp_id + ' input[name="hid_id_number"]').val());
                $('#edit-modal-form input[name="name"]').val($('#td_' + tmp_id + ' input[name="hid_name"]').val());
                $('#edit-modal-form input[name="email"]').val($('#td_' + tmp_id + ' input[name="hid_email"]').val());
                $('#edit-modal-form input[name="birthdate"]').val($('#td_' + tmp_id + ' input[name="hid_birthdate"]').val());
                $('#edit-modal-form textarea[name="address"]').val($('#td_' + tmp_id + ' input[name="hid_address"]').val());
                $('#edit-modal-form input[name="phone"]').val($('#td_' + tmp_id + ' input[name="hid_phone"]').val());
                $('#edit-modal-form select[name="gender"]').val($('#td_' + tmp_id + ' input[name="hid_gender"]').val());
                $('#edit-modal-form select[name="employee_type_id"]').val($('#td_' + tmp_id + ' input[name="hid_employee_type_id"]').val());
            });
            
            // Event check all
            var totalCheck = $('.cb_child').length;
            $('#cb_checkall').click(function() {                
                if ($(this).is(":checked")) {
                    $('.cb_child').prop('checked', true);
                } else {
                    $('.cb_child').prop('checked', false);
                }
            });
            
            // Event check one checkbox
            $('.cb_child').click(function() {
                var tmpTotalCheck = $('.cb_child:checked').length;
                if (0 < tmpTotalCheck < totalCheck) {
                    $('#cb_checkall').prop("indeterminate", true);
                }
                
                if (tmpTotalCheck == 0) {
                    $('#cb_checkall').prop("indeterminate", false);
                    $('#cb_checkall').prop("checked", false);
                }
                
                if (tmpTotalCheck == totalCheck) {
                    $('#cb_checkall').prop("indeterminate", false);
                    $('#cb_checkall').prop("checked", true);
                }
            });
            
            // Event delete selected
            $('#btn-del').click(function(e) {
                var str_id = '';
                var count_selected = 0;
                $('.cb_child').each(function(index, e) {
                    if ($($('.cb_child')[index]).is(':checked')) {
                        str_id = str_id + '_' + $($('.cb_child')[index]).val();
                        count_selected++;
                    }
                });
                if (count_selected == 0) {
                    return false;
                } else {
                    str_id = str_id.substring(1, str_id.length);
                    $('#btn-do-delete-selected').attr('href', '{{URL::to("admin/employee/delete-selected")}}/'+str_id);
                }
            });
            
            // Event show advance search panel
            $('#btn-advance-search').click(function() {
                if ($('#advSearchPanel').is(':visible')) {
                    $('#advSearchPanel').slideUp();
                } else {
                    $('#advSearchPanel').slideDown();
                }
            });
            
            // Event advanced search
            $('#btnAvdSearchReset').click(function(e) {
                e.preventDefault();
                $('#formAdvSearch input[name="id_number"], #formAdvSearch input[name="name"]').val('');
                $('#formAdvSearch select[name="employee_type_id"], #formAdvSearch select[name="job_id"]').val(0);
            });
            
            $('#btnAdvSearch').click(function(e) {
                e.preventDefault();
                var id_number = $('#formAdvSearch input[name="id_number"]').val();
                var name = $('#formAdvSearch input[name="name"]').val();
                var employee_type_id = $('#formAdvSearch select[name="employee_type_id"]').val();
                var job_id = $('#formAdvSearch select[name="job_id"]').val();
                window.location = '{{URL::to("admin/employee/adv-search")}}?id_number=' + id_number + '&name=' + name + '&employee_type_id=' + employee_type_id + '&job_id=' + job_id
            });
        });
    </script>
    
    
    @if ($add_success == 1)
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New employee added.
    </div>
    @endif
    
    @if ($edit_success == 1)
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> employee updated.
    </div>
    @endif
    
    @if ($delete_success == 1)
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee deleted.
    </div>
    @endif
    
    @if (Session::has('not_found'))
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Failed!</strong> Employee not found.
    </div>
    @endif

    <?php $advSearch = isset($isAdvSearch); ?>
    @if ($advSearch)
    <h1 class="page-header">Employee advance search result</h1>
    @else
    <h1 class="page-header">{{ (isset($key) ? 'Employee search result for "'.$key.'"' : 'Employee'); }}</h1>
    @endif
    
    <div class="col-lg-9" style="padding-left: 0;">
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Quick Add</button>
        <a href="{{ URL::to('admin/employee/add')  }}" id="btn-add-new" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> &nbsp;Add New</a>
        <button type="button" id="btn-advance-search" class="btn btn-default btn-sm"><i class="fa fa-gear"></i> &nbsp;Advance Search</button>
        <button type="button" id="btn-show-grid" class="btn btn-default btn-sm" title="show grid"><i class="fa fa-th-large"></i></button>
        <button type="button" id="btn-del" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delSelectedModal"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>
    </div>
    
    <div class="col-lg-3" style="padding-right: 0;">
        <div class="input-group pull-right">
            <input type="text" class="form-control" placeholder="quick search ..." name="key" value="{{ (isset($key) ? $key : ''); }}">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
            </span>
        </div>
    </div>

    <br/>
    
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/employee/create')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New Employee</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-idnumber">
                    <label class="col-sm-2 control-label" for="name">ID Number</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="id_number" rel="tooltipidnumber" placeholder="eg: ABC000001">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-name">
                    <label class="col-sm-2 control-label" for="name">Full Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" rel="tooltipname" placeholder="employee full name">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-email">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="email" placeholder="name@company.com" rel="tooltipemail">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-birthdate">
                    <label class="col-sm-2 control-label">Birthdate</label>
                    <div class="col-sm-10">
                      <div class="input-group date pull-right" id="birthdate">
                        <input type="text" class="form-control" name="birthdate" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                        <span class="input-group-addon" rel="tooltipbirthdate"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-address">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="address" rows="4" rel="tooltipaddress"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="gender">
                        <option vaiue="male">male</option>
                        <option value="female">female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="employee_type_id">
                        @foreach($emptypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Job Title</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="job_id">
                        @foreach($jobs as $job)
                        <option value="{{$job->id}}">{{$job->title}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-phone">
                    <label class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone" rel="tooltipphone" placeholder="numeric only and +">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Photo</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="photo">
                    </div>
                  </div>  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
      </div>
    </div>   
    <!-- End Add Modal -->
    
    <!-- Delete Confirmation modal -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Employee Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="" id="btn-do-delete" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End delete confirmation modal -->
     
     <!-- Delete Selected Confirmation modal -->
    <div class="modal fade" id="delSelectedModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel2">Employee Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content2">
            <h4 style="text-align:center;font-weight:bold;">Delete selected record ?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="" id="btn-do-delete-selected" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End delete Selected confirmation modal -->
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="edit-modal-form" class="form-horizontal" action="{{URL::to('admin/employee/edit-from-modal')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit Employee</h4>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id"/>
                  <div class="form-group" id="form-group-idnumber-edit">
                    <label class="col-sm-2 control-label" for="name">ID Number</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="id_number" rel="tooltipidnumber-edit" placeholder="eg: ABC000001">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-name-edit">
                    <label class="col-sm-2 control-label" for="name">Full Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" rel="tooltipname-edit" placeholder="employee full name">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-email-edit">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="email" placeholder="name@company.com" rel="tooltipemail-edit">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-birthdate-edit">
                    <label class="col-sm-2 control-label">Birthdate</label>
                    <div class="col-sm-10">
                      <div class="input-group date pull-right" id="birthdate-edit">
                        <input type="text" class="form-control" name="birthdate" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                        <span class="input-group-addon" rel="tooltipbirthdate-edit"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-address-edit">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="address" rows="4" rel="tooltipaddress-edit"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="gender">
                        <option vaiue="male">male</option>
                        <option value="female">female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="employee_type_id">
                        @foreach($emptypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-phone-edit">
                    <label class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone" rel="tooltipphone-edit" placeholder="numeric only and +">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Photo</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="photo">
                    </div>
                  </div>  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
      </div>
    </div>
    <!-- End Edit Modal -->
    
    <br/><br/>

    @if ($advSearch)
    <script>
    $(function() {
        $('#formAdvSearch input[name="id_number"]').val('{{$advSearchValue["id_number"]}}');
        $('#formAdvSearch input[name="name"]').val('{{$advSearchValue["name"]}}');
        $('#formAdvSearch select[name="employee_type_id"]').val('{{$advSearchValue["employee_type_id"]}}');
        $('#formAdvSearch select[name="job_id"]').val('{{$advSearchValue["job_id"]}}');
    });
    </script>
    @endif
    <!-- Advance Search Panel -->
    <div class="panel panel-default" id="advSearchPanel" style="display: {{ ($advSearch) ? 'visible' : 'none' }};">
        <div class="panel-heading">Advance Search Option</div>
        <div class="panel-body">
            <form id="formAdvSearch" method="post" action="{{URL::to("admin/employee/adv-search")}}">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="id_number">ID Number</label>
                    <input type="text" class="form-control" name="id_number">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Employee Type</label>
                    <select class="form-control" name="employee_type_id">
                        <option value="0">-- All --</option>
                        @foreach($emptypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Job</label>
                    <select class="form-control" name="job_id">
                        <option value="0">-- All --</option>
                        @foreach($jobs as $job)
                        <option value="{{$job->id}}">{{$job->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <label>&nbsp;</label><br/>
                <button type="submit" class="btn btn-primary btn-sm pull-right" id="btnAdvSearch"><i class="fa fa-search"></i> &nbsp;Search</button>
                <div class="pull-right">&nbsp;&nbsp;</div>
                <button class="btn btn-default btn-sm pull-right" id="btnAvdSearchReset">Reset</button>
            </div>
            </form>
        </div>
    </div>
    <!-- End Advance Search Panel -->
    
    <div class="panel panel-default">
        <div class="panel-heading">List of Employee</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="5%"><input type="checkbox" id="cb_checkall"></th>  
                  <!--<th width="5%">No</th>-->
                  <th width="15%">#ID Number</th>
                  <th width="55%">#Name</th>
                  <th width="10%">#Type</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee as $index => $empl)
              <tr>
                  <td><input type="checkbox" class="cb_child" value="{{$empl->id}}"></td>
                  <td id="id_number_{{$empl->id}}">{{$empl->id_number}}</td>
                  <td><a href="{{ URL::to('admin/employee/view/'.$empl->id) }}">{{$empl->name}}</a></td>
                  <td>@if (isset($empl->employeetype->name)) {{$empl->employeetype->name}} @endif</td>
                  <td id="td_{{ $empl->id }}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $empl->id }}"/>
                      <input type="hidden" name="hid_id_number" value="{{ $empl->id_number }}"/>
                      <input type="hidden" name="hid_name" value="{{ $empl->name }}"/>
                      <input type="hidden" name="hid_email" value="{{ $empl->email }}"/>
                      <input type="hidden" name="hid_address" value="{{ $empl->address }}"/>
                      <input type="hidden" name="hid_employee_type_id" value="{{ $empl->employee_type_id }}"/>
                      <input type="hidden" name="hid_birthdate" value="{{ $empl->birthdate }}"/>
                      <input type="hidden" name="hid_gender" value="{{ $empl->gender }}"/>
                      <input type="hidden" name="hid_phone" value="{{ $empl->phone }}"/>
                      <a href="{{ URL::to('admin/employee/view/'.$empl->id) }}" title="view details employee" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                      <a href="" title="quick edit" id="edit_{{ $empl->id }}" class="btn btn-xs btn-success btn-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete employee" id="del_{{ $empl->id }}" class="btn btn-xs btn-danger btn-empl-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
            @if ($advSearch)
            {{ $paginate->appends(array(
                        'id_number' => $advSearchValue["id_number"],
                        'name' => $advSearchValue["name"],
                        'employee_type_id' => $advSearchValue["employee_type_id"], 
                        'job_id' => $advSearchValue["job_id"]))->links() }}
            @else
            {{ $paginate->links() }}
            @endif
            <div class="pull-right">
                <br/>
                <p class="text-muted" style="margin-top: 5px;">{{ $paginate->getFrom() }} to {{ $paginate->getTo() }} of {{ $paginate->getTotal() }} Employee&nbsp;&nbsp;</p>
            </div>
          </div>  
        </div>
        
    </div>

    
@stop