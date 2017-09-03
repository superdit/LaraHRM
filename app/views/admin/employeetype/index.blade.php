
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
    @if ($open_create_modal == 1)
    $('#addModal').modal('show');
    $('#addModal').on('shown.bs.modal', function (e) {                
        @if (isset($error_messages) && $error_messages->first('name') != "")
        $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
        $('#form-group-name').addClass('has-error');
        @endif
        $('#addModal input[name="name"]').val('{{$input_values['name']}}');
    });            
    @endif
    
    @if ($open_edit_modal == 1)
    $('#editModal').modal('show');
    $('#editModal').on('shown.bs.modal', function (e) {                
        @if (isset($error_messages) && $error_messages->first('name') != "")
        $("[rel='tooltipname-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
        $('#form-group-name-edit').addClass('has-error');
        @endif
        $('#editModal input[name="name"]').val('{{$input_values['name']}}');
        
        $('#editModal input[name="id"]').val('{{$input_values['id']}}');
    });            
    @endif
    
    // Event on show delete modal confirmation
    $('.btn-emptype-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var emptype_name = $('#emptype_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this employee type: "'+emptype_name+'" ?</h4>';
        $('#modal-del-content').html(html);

        $('#btn-do-delete').attr('href', '{{URL::to("admin/employeetype/delete")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-emptype-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_name = $('#td_' + tmp_id + ' input[name="hid_name"]').val();

        setTimeout(function() {
            $('#editModal input[name="name"]').val(tmp_name);
            $('#editModal input[name="id"]').val(tmp_id);

            $("[rel='tooltipname-edit']").tooltip('destroy');
            $('#form-group-name-edit').removeClass('has-error');
        }, 500);
    });
});  
</script>
    @if (Session::has('add_emptype_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New Employee Type added.
    </div>
    @endif
    
    @if (Session::has('edit_emptype_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Empoyee type updated.
    </div>
    @endif
    
    @if (Session::has('delete_emptype_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Empoyee type deleted.
    </div>
    @endif

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/employeetype/create')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New Employee Type</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-name">
                    <label class="col-sm-2 control-label" for="name">Name</label>
                    <div class="col-sm-10">
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/employeetype/edit')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"/>
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit Employee Type</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-name-edit">
                    <label class="col-sm-2 control-label" for="name">Name</label>
                    <div class="col-sm-10">
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
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Employee Type Delete Confirmation</h4>
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

    <!--<h1 class="page-header">Employee Type</h1>-->
    
    <div style="padding-top: 10px;" class="container-fluid row">
        <div class="col-lg-9" style="padding-left: 0;">
            <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New</button>
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
    </div>
    
    <br/>
    
    
<!--    <div class="" style="z-index: -9999;">
  <div class="modal-dialog" style="z-index: 0;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div> /.modal-content 
  </div> /.modal-dialog 
</div> /.modal -->
    
    <div class="panel panel-default">
        <div class="panel-heading">List of Employee Type</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="5%"><input type="checkbox"></th>  
                  <th width="85%">#Empoyee Type </th>
                  <th width="10%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($emptypes as $index => $type)
              <tr>
                  <td><input type="checkbox"></td>
                  <td id="emptype_{{$type->id}}">{{ $type->name }}</td>
                  <td id="td_{{$type->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $type->id }}"/>
                      <input type="hidden" name="hid_name" value="{{ $type->name }}"/>
                      <a href="" title="quick edit" id="edit_{{$type->id}}" class="btn btn-xs btn-success btn-emptype-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete kpi" id="del_{{$type->id}}" class="btn btn-xs btn-danger btn-emptype-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          
        </div>
    </div>
