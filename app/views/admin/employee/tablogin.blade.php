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

@if (is_null($employee->user))
<script>
$(function() {
    @if (Session::has('add_user_failed'))
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
});  
</script>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/user/create')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Create Employee Login Credential</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-username">
                <label class="col-sm-3 control-label" for="name">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" rel="tooltipusername" value="{{$employee->id_number}}">
                </div>
              </div>
              <div class="form-group" id="form-group-email">
                <label class="col-sm-3 control-label" for="name">Email</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="email" rel="tooltipemail" value="{{$employee->email}}">
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

<div class="text-center">
    <br/>
    <h3>This employee don't have login credential yet</h3>
    <br/><br/>
    <button class="btn btn-primary btn-lg text-center" data-toggle="modal" data-target="#addModal">Create Login Credential</button>
    <br/><br/><br/><br/>
</div>

@else

<script>
$(function() {
    
    @if (Session::has('edit_user_failed'))
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
});
</script>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/user/edit')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $employee->user->id }}"/>
            <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Employee Login Credential</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-username-edit">
                <label class="col-sm-3 control-label" for="name">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" rel="tooltipusername-edit" value="{{ $employee->user->username }}">
                </div>
              </div>
              <div class="form-group" id="form-group-email-edit">
                <label class="col-sm-3 control-label" for="name">Email</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="email" rel="tooltipemail-edit" value="{{ $employee->user->email }}">
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

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Login Credential
        <a href="#" title="edit login detail" class="pull-right btn btn-xs btn-default" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
    </div>
    <div class="panel-body">
        <div class="form-group" id="form-group-idnumber-edit">
            <label class="col-sm-2 control-label" for="name">Username</label>
            <div class="col-sm-10">
            <label class="control-label" for="name"><strong>{{ $employee->user->username }}</strong></label>
            </div>
        </div>
        <div class="form-group" id="form-group-name-edit">
            <label class="col-sm-2 control-label" for="name">Email</label>
            <div class="col-sm-10">
            <label class="control-label" for="name"><strong>{{ $employee->user->email }}</strong></label>
            </div>
        </div>
    </div>
</div>
@endif