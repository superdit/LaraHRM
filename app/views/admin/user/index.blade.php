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
    
    @if ($open_create_modal == 1)
        $('#addModal').modal('show');
        $('#addModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('username') != "")
            $("[rel='tooltipusername']").tooltip({placement: 'right', title: '{{$error_messages->first('username')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-username').addClass('has-error');
            @endif
            $('#addModal input[name="username"]').val('{{$input_values['username']}}');
            
            @if (isset($error_messages) && $error_messages->first('email') != "")
            $("[rel='tooltipemail']").tooltip({placement: 'right', title: '{{$error_messages->first('email')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-email').addClass('has-error');
            @endif
            $('#addModal input[name="email"]').val('{{$input_values['email']}}');
            
            @if (isset($error_messages) && $error_messages->first('password') != "")
            $("[rel='tooltippassword']").tooltip({placement: 'right', title: '{{$error_messages->first('password')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-password').addClass('has-error');
            @endif
            $('#addModal input[name="password"]').val('{{$input_values['password']}}');
            
            @if (isset($error_messages) && $error_messages->first('cpassword') != "")
            $("[rel='tooltipcpassword']").tooltip({placement: 'right', title: '{{$error_messages->first('cpassword')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-cpassword').addClass('has-error');
            @endif
            $('#addModal input[name="cpassword"]').val('{{$input_values['cpassword']}}');
        });            
    @endif  
    
    @if ($open_edit_modal == 1)
        $('#editModal').modal('show');
        $('#editModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('username') != "")
            $("[rel='tooltipusername-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('username')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-username-edit').addClass('has-error');
            @endif
            $('#editModal input[name="username"]').val('{{$input_values['username']}}');
            
            @if (isset($error_messages) && $error_messages->first('email') != "")
            $("[rel='tooltipemail-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('email')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-email-edit').addClass('has-error');
            @endif
            $('#editModal input[name="email"]').val('{{$input_values['email']}}');
            
            @if (isset($error_messages) && $error_messages->first('password') != "")
            $("[rel='tooltippassword-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('password')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-password-edit').addClass('has-error');
            @endif
            $('#editModal input[name="password"]').val('{{$input_values['password']}}');
            
            @if (isset($error_messages) && $error_messages->first('cpassword') != "")
            $("[rel='tooltipcpassword-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('cpassword')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-cpassword-edit').addClass('has-error');
            @endif
            $('#editModal input[name="cpassword"]').val('{{$input_values['cpassword']}}');
            
            $('#editModal input[name="id"]').val('{{$input_values['id']}}');
        });            
    @endif  
    
    // Event on show delete modal confirmation
    $('.btn-user-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var user_name = $('#user_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this user: "'+user_name+'" ?</h4>';
        $('#modal-del-content').html(html);

        $('#btn-do-delete').attr('href', '{{URL::to("admin/user/delete")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-user-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_username = $('#td_' + tmp_id + ' input[name="hid_username"]').val();
        var tmp_email = $('#td_' + tmp_id + ' input[name="hid_email"]').val();
        var tmp_password = $('#td_' + tmp_id + ' input[name="hid_password"]').val();

        setTimeout(function() {
            $('#editModal input[name="username"]').val(tmp_username);
            $('#editModal input[name="email"]').val(tmp_email);
            $('#editModal input[name="id"]').val(tmp_id);

            $("[rel='tooltipusername-edit'], [rel='tooltipemail-edit'], [rel='tooltippassword-edit'], [rel='tooltipcpassword-edit']").tooltip('destroy');
            $('#form-group-username-edit, #form-group-email-edit, #form-group-password-edit, #form-group-cpassword-edit').removeClass('has-error');
        }, 500);

    });
});  
</script>

    @if (Session::has('add_user_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New User added.
    </div>
    @endif
    
    @if (Session::has('edit_user_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> User updated.
    </div>
    @endif
    
    @if (Session::has('delete_user_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> User deleted.
    </div>
    @endif

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/user/create')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New User</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-username">
                    <label class="col-sm-3 control-label" for="name">Username</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="username" rel="tooltipusername">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-email">
                    <label class="col-sm-3 control-label" for="name">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="email" rel="tooltipemail">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-password">
                    <label class="col-sm-3 control-label" for="name">Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="password" rel="tooltippassword">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-cpassword">
                    <label class="col-sm-3 control-label" for="name">Confirm Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="cpassword" rel="tooltipcpassword">
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
            <form role="form" class="form-horizontal" action="{{URL::to('admin/user/edit')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" />
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-username-edit">
                    <label class="col-sm-3 control-label" for="name">Username</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="username" rel="tooltipusername-edit">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-email-edit">
                    <label class="col-sm-3 control-label" for="name">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="email" rel="tooltipemail-edit">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-blank">
                    <label class="col-sm-3 control-label" for="name"></label>
                    <div class="col-sm-9">
                        <small>Leave both password blank to keep current</small>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-password-edit">
                    <label class="col-sm-3 control-label" for="name">Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="password" rel="tooltippassword-edit">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-cpassword-edit">
                    <label class="col-sm-3 control-label" for="name">Confirm Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="cpassword" rel="tooltipcpassword-edit">
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
            <h4 class="modal-title" id="myModalLabel">User Delete Confirmation</h4>
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

    <h1 class="page-header">Users</h1>
    
    <div class="col-lg-9" style="padding-left: 0;">
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New User</button>
        <button type="button" id="btn-del" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete Checked</button>
    </div>
    
    <div class="col-lg-3" style="padding-right: 0;">
        <div class="input-group pull-right">
            <input type="text" class="form-control" placeholder="search anything..." name="key" value="{{ (isset($key) ? $key : ''); }}">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
            </span>
        </div>
    </div>
    
    <br/>
    
    <br/><br/>
    
    <div class="panel panel-default">
        <div class="panel-heading">List of User</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="5%"><input type="checkbox"></th>  
                  <th width="40%">#Username </th>
                  <th width="40%">#Email</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($users as $index => $user)
              <tr>
                  <td><input type="checkbox"></td>
                  <td id="user_{{$user->id}}">{{ $user->username }}</td>
                  <td>{{ $user->email }}</td>
                  <td id="td_{{$user->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $user->id }}"/>
                      <input type="hidden" name="hid_username" value="{{ $user->username }}"/>
                      <input type="hidden" name="hid_email" value="{{ $user->email }}"/>
                      <a href="" title="quick edit" id="edit_{{$user->id}}" class="btn btn-xs btn-success btn-user-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete user" id="del_{{$user->id}}" class="btn btn-xs btn-danger btn-user-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          
        </div>
    </div>
@stop