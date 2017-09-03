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
            @if (isset($error_messages) && $error_messages->first('title') != "")
            $("[rel='tooltiptitle']").tooltip({placement: 'right', title: '{{$error_messages->first('title')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-title').addClass('has-error');
            @endif
            $('#addModal input[name="title"]').val('{{$input_values['title']}}');
        });            
    @endif   
    
    @if ($open_edit_modal == 1)
        $('#editModal').modal('show');
        $('#editModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('title') != "")
            $("[rel='tooltiptitle-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('title')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-title-edit').addClass('has-error');
            @endif
            $('#editModal input[name="title"]').val('{{$input_values['title']}}');
            
            $('#editModal textarea[name="description"]').val('{{$input_values['description']}}');
            $('#editModal input[name="id"]').val('{{$input_values['id']}}');
        });            
    @endif   
    
    // Event on show delete modal confirmation
    $('.btn-job-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#job_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this job title: "'+title+'" ?</h4>';
        $('#modal-del-content').html(html);

        $('#btn-do-delete').attr('href', '{{URL::to("admin/job/delete")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-job-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_title = $('#td_' + tmp_id + ' input[name="hid_title"]').val();
        var tmp_description = $('#td_' + tmp_id + ' input[name="hid_description"]').val();

        setTimeout(function() {
            $('#editModal input[name="title"]').val(tmp_title);
            $('#editModal textarea[name="description"]').val(tmp_description);
            $('#editModal input[name="id"]').val(tmp_id);

            $("[rel='tooltiptitle-edit'], [rel='tooltipdescription-edit']").tooltip('destroy');
            $('#form-group-title-edit, #form-group-description-edit').removeClass('has-error');
        }, 500);

    });
});
</script>

@if (Session::has('add_job_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> New Job Title added.
</div>
@endif

@if (Session::has('edit_job_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Job Title updated.
</div>
@endif

@if (Session::has('delete_job_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Job deleted.
</div>
@endif

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/job/create')}}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add New Job Title</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-title">
                <label class="col-sm-3 control-label" for="name">Job Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="title" rel="tooltiptitle">
                </div>
              </div>
              <div class="form-group" id="form-group-description">
                <label class="col-sm-3 control-label" for="name">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="description" rel="tooltipdescription" rows="4"></textarea>
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
        <form role="form" class="form-horizontal" action="{{URL::to('admin/job/edit')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Job Title</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-title-edit">
                <label class="col-sm-3 control-label" for="name">Job Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="title" rel="tooltiptitle-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-description-edit">
                <label class="col-sm-3 control-label" for="name">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="description" rel="tooltipdescription-edit" rows="4"></textarea>
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
        <h4 class="modal-title" id="myModalLabel">Job Title Delete Confirmation</h4>
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

<div class="panel panel-default">
    <div class="panel-heading">List of Job Title</div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="5%"><input type="checkbox"></th>  
              <th width="25%">#Job Title </th>
              <th width="55%">#Job Description</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody>
          @foreach($jobs as $index => $job)
          <tr>
              <td><input type="checkbox"></td>
              <td id="job_{{$job->id}}">{{ $job->title }}</td>
              <td>{{ $job->description }}</td>
              <td id="td_{{$job->id}}" class="text-right">
                  <input type="hidden" name="hid_id" value="{{ $job->id }}"/>
                  <input type="hidden" name="hid_title" value="{{ $job->title }}"/>
                  <input type="hidden" name="hid_description" value="{{ $job->description }}"/>
                  <a href="" title="quick edit" id="edit_{{$job->id}}" class="btn btn-xs btn-success btn-job-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                  <a href="" title="delete job title" id="del_{{$job->id}}" class="btn btn-xs btn-danger btn-job-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
              </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>

    </div>
</div>