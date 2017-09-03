<script>
$(function() {             
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

    $('#tabProfile').click(function() {
        window.location = '{{ URL::to("admin/employee/view")}}/{{$employee->id}}';
    });

    $('#tabContact').click(function() {
        window.location = '{{ URL::to("admin/employee/contact")}}/{{$employee->id}}';
    });

    $('#tabAttendance').click(function() {
        window.location = '{{ URL::to("admin/employee/attendance")}}/{{$employee->id}}';
    });

    $('#tabQualification').click(function() {
        window.location = '{{ URL::to("admin/employee/qualification")}}/{{$employee->id}}';
    });

    $('#tabSalary').click(function() {
        window.location = '{{ URL::to("admin/employee/salary")}}/{{$employee->id}}';
    });

    $('#tabLogin').click(function() {
        window.location = '{{ URL::to("admin/employee/login")}}/{{$employee->id}}';
    });            

    $('#tabPerformance').click(function() {
        window.location = '{{ URL::to("admin/employee/performance")}}/{{$employee->id}}';
    });            
});
</script>

@if (Session::has('edit_success'))
<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<strong>Success!</strong> Employee updated.
</div>
@endif

<h1 class="page-header">Details Employee</h1>

<div class="col-lg-9" style="padding-left: 0;">
<a href="{{ URL::to('admin/employee') }}" type="button" title="back to employee list" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i></a>
<button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New Employee</button>
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

<!-- Delete Confirmation modal -->
<div class="modal fade delete-confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Employee Delete Confirmation</h4>
  </div>
  <div class="modal-body" id="modal-del-content">
      <h4 class="text-center">Delete this employee ?</h4>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <a href="{{ URL::to('admin/employee/delete/'.$employee->id) }}" id="btn-do-delete" class="btn btn-danger">Delete</a>
  </div>
</div>
</div>
</div>
<!-- End delete confirmation modal -->

<br/><br/>