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
    @if (Session::has('add_department_failed'))
        $('#addModal').modal('show');
        $('#addModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name').addClass('has-error');
            @endif
            $('#addModal input[name="name"]').val('{{$input_values['name']}}');
        });            
    @endif  
    
    @if (Session::has('edit_department_failed'))
        $('#editDepartmentModal').modal('show');
        $('#editDepartmentModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-edit').addClass('has-error');
            @endif
            $('#editDepartmentModal input[name="name"]').val('{{$input_values['name']}}');
        });            
    @endif  
    
    // Event on show delete modal confirmation
    $('.btn-department-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var name = $('#department_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this company department: "'+name+'" ?</h4>';
        $('#modal-del-content').html(html);

        $('#btn-do-delete').attr('href', '{{URL::to("admin/department/delete")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-department-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_department_", "");
        var tmp_name = $('#td_department_' + tmp_id + ' input[name="hid_name"]').val();

        setTimeout(function() {
            $('#editDepartmentModal input[name="name"]').val(tmp_name);
            $('#editDepartmentModal input[name="id"]').val(tmp_id);

            $("[rel='tooltipname-edit']").tooltip('destroy');
            $('#form-group-name-edit').removeClass('has-error');
        }, 500);

    });
});  
</script>

    @if (Session::has('add_department_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New Company Department added.
    </div>
    @endif
    
    @if (Session::has('edit_department_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Company Department updated.
    </div>
    @endif
    
    @if (Session::has('delete_department_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Company Department deleted.
    </div>
    @endif

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/department/create')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New Company Department</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-name">
                    <label class="col-sm-3 control-label" for="name">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" rel="tooltipname">
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
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/department/edit')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"/>
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit Company Department</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-name-edit">
                    <label class="col-sm-3 control-label" for="name">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" rel="tooltipname-edit">
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

    <!-- Delete Confirmation modal -->
    <div class="modal fade" id="delDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Company Department Delete Confirmation</h4>
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
    <!-- End Delete Confirmation modal -->

    <h1 class="page-header">Departments</h1>
    
    <div class="col-lg-9" style="padding-left: 0;">
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New Company Department</button>
        <button type="button" id="btn-del" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>
    </div>

    <div class="col-lg-3" style="padding-right: 0;">
        <div class="input-group pull-right">
            <input type="text" class="form-control" placeholder="quick search..." name="key" value="{{ (isset($key) ? $key : ''); }}">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
            </span>
        </div>
    </div>
    
    <br/>
    
    <br/><br/>

    <div class="panel panel-default">
        <div class="panel-heading">List of Department</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="5%"><input type="checkbox"></th>  
                  <th>#Department </th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($departments as $index => $department)
              <tr>
                  <td><input type="checkbox"></td>
                  <td id="department_{{$department->id}}">{{ $department->name }}</td>
                  <td id="td_department_{{$department->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $department->id }}"/>
                      <input type="hidden" name="hid_name" value="{{ $department->name }}"/>
                      <a href="" title="quick edit" id="edit_department_{{$department->id}}" class="btn btn-xs btn-success btn-department-edit" data-toggle="modal" data-target="#editDepartmentModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete department" id="del_{{$department->id}}" class="btn btn-xs btn-danger btn-department-del" data-toggle="modal" data-target="#delDepartmentModal"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          
        </div>
    </div>
@stop