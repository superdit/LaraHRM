<style>
.tooltip-inner {
    white-space: nowrap;
    max-width: 350px;
}
</style>
<script>
    $(function() {
        $('#start_time, #end_time').datetimepicker({pickDate: false}); 

        @if ($open_create_modal == 1)
        $('#addModal').modal('show');
        $('#addModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name').addClass('has-error');
            @endif
            $('#addModal input[name="name"]').val('{{$input_values['name']}}');

            @if (isset($error_messages) && $error_messages->first('start_work_time') != "")
            $("[rel='tooltipstart_time']").tooltip({placement: 'right', title: '{{$error_messages->first('start_work_time')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-start_time').addClass('has-error');
            @endif
            $('#addModal input[name="start_work_time"]').val('{{$input_values['start_work_time']}}');

            @if (isset($error_messages) && $error_messages->first('end_work_time') != "")
            $("[rel='tooltipend_time']").tooltip({placement: 'right', title: '{{$error_messages->first('end_work_time')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-end_time').addClass('has-error');
            @endif
            $('#addModal input[name="end_work_time"]').val('{{$input_values['end_work_time']}}');

            @foreach($input_values['days'] as $day)
                $('#addModal select[name="days[]"] option[value="{{$day}}"]').prop("selected", true);
            @endforeach
            $('#addModal select[name="days[]"]').trigger('chosen:updated')
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

            @if (isset($error_messages) && $error_messages->first('start_work_time') != "")
            $("[rel='tooltipstart_time-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('start_work_time')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-start_time-edit').addClass('has-error');
            @endif
            $('#editModal input[name="start_work_time"]').val('{{$input_values['start_work_time']}}');

            @if (isset($error_messages) && $error_messages->first('end_work_time') != "")
            $("[rel='tooltipend_time-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('end_work_time')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-end_time-edit').addClass('has-error');
            @endif
            $('#editModal input[name="end_work_time"]').val('{{$input_values['end_work_time']}}');

            $('#editModal input[name="id"]').val('{{$input_values['id']}}');

            @foreach($input_values['days'] as $day)
                $('#editModal select[name="days[]"] option[value="{{$day}}"]').prop("selected", true);
            @endforeach
            $('#editModal select[name="days[]"]').trigger('chosen:updated');
        });            
        @endif

        // Event edit click
        $('.btn-edit').click(function(e) {
            var tmp_id = $(this).attr('id').replace('edit_', '');
            // Assign value to edit modal
            $('#edit-modal-form input[name="id"]').val($('#td_' + tmp_id + ' input[name="hid_id"]').val());
            $('#edit-modal-form input[name="name"]').val($('#td_' + tmp_id + ' input[name="hid_name"]').val());
            $('#edit-modal-form input[name="start_work_time"]').val($('#td_' + tmp_id + ' input[name="hid_start_work_time"]').val());
            $('#edit-modal-form input[name="end_work_time"]').val($('#td_' + tmp_id + ' input[name="hid_end_work_time"]').val());
            var days = $('#td_' + tmp_id + ' input[name="hid_days"]').val();
            if (days !== "") {
                var tmp_days = days.split(",");
                for (i = 0; i < tmp_days.length; i++) {
                    $('#select_days_edit option[value="' + tmp_days[i] + '"]').attr("selected", "selected");
                }
                $("#select_days_edit").trigger("chosen:updated");
            }
        });

        $('.btn-empl-del').click(function() {
            var tmp_id = $(this).attr('id').replace("del_", "");
            var tmp_id_number = $('#td_' + tmp_id + ' input[name="hid_name"]').val();
            var html = '<h4 style="text-align:center;font-weight:bold;">Delete this workshift: "'+tmp_id_number+'" ?</h4>';
            $('#modal-del-content').html(html);

            $('#btn-do-delete').attr('href', '{{URL::to("admin/workshift/delete")}}/'+tmp_id);
        });
    });
</script>

@if ($add_success == 1)
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> New work shift added.
</div>
@endif

@if ($edit_success == 1)
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Work shift updated.
</div>
@endif

@if ($delete_success == 1)
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Work shift deleted.
</div>
@endif

<div style="padding-top: 10px;" class="container-fluid row">
    <div class="col-lg-9" style="padding-left: 0;">
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New</button>
    </div>

    <div class="col-lg-3" style="padding-right: 0;">
        <div class="input-group pull-right">
    <!--            <input type="text" class="form-control" placeholder="search anything..." name="key" value="{{ (isset($key) ? $key : ''); }}">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
            </span>-->
        </div>
    </div>
</div>

<br/>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/workshift/create')}}" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add New Work Shift</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name">
                <label class="col-sm-2 control-label" for="name">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" rel="tooltipname">
                </div>
              </div>
              <div class="form-group" id="form-group-start_time">
                <label class="col-sm-2 control-label">Start Time</label>
                <div class="col-sm-10">
                  <div class="input-group date pull-right" id="start_time">
                    <input type="text" class="form-control" name="start_work_time" data-format="HH:mm" placeholder="HH:mm"/>
                    <span class="input-group-addon" rel="tooltipstart_time"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-end_time">
                <label class="col-sm-2 control-label">End Time</label>
                <div class="col-sm-10">
                  <div class="input-group date pull-right" id="end_time">
                    <input type="text" class="form-control" name="end_work_time" data-format="HH:mm" placeholder="HH:mm"/>
                    <span class="input-group-addon" rel="tooltipend_time"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
               </div>
               <div class="form-group" id="form-group-days">
                <label class="col-sm-2 control-label">Days</label>
                <div class="col-sm-10">

                    <select class="chosen-select" name="days[]" multiple data-placeholder="choose days">
                        <option value=""></option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                    <style>
                        .search-field input { height: 25px !important; }
                    </style>
                    <script>
                        var config = {
                          '.chosen-select' : {width:"100%", height:"50%", no_results_text: "No day match:"}
                        };
                        $('.chosen-select').chosen(config['.chosen-select']);
                    </script>

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
        <h4 class="modal-title" id="myModalLabel">Workshift Delete Confirmation</h4>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" id="edit-modal-form" action="{{URL::to('admin/workshift/edit')}}" method="post">
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Work Shift</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name-edit">
                <label class="col-sm-2 control-label" for="name">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" rel="tooltipname-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-start_time-edit">
                <label class="col-sm-2 control-label">Start Time</label>
                <div class="col-sm-10">
                  <div class="input-group date pull-right" id="start_time">
                    <input type="text" class="form-control" name="start_work_time" data-format="HH:mm" placeholder="HH:mm"/>
                    <span class="input-group-addon" rel="tooltipstart_time-edit"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-end_time-edit">
                <label class="col-sm-2 control-label">End Time</label>
                <div class="col-sm-10">
                  <div class="input-group date pull-right" id="end_time">
                    <input type="text" class="form-control" name="end_work_time" data-format="HH:mm" placeholder="HH:mm"/>
                    <span class="input-group-addon" rel="tooltipend_time-edit"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-days">
                <label class="col-sm-2 control-label">Days</label>
                <div class="col-sm-10">

                    <select class="chosen-select-edit" name="days[]" multiple data-placeholder="choose days" id="select_days_edit">
                        <option value=""></option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                    <style>
                        .search-field input { height: 25px !important; }
                    </style>
                    <script>
                        var config = {
                          '.chosen-select-edit' : {width:"100%", height:"50%", no_results_text: "No day match:"}
                        };
                        $('.chosen-select-edit').chosen(config['.chosen-select-edit']);
                    </script>

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

<div class="panel panel-default">
    <div class="panel-heading">List of Workshift</div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th width="50%">#Name</th>
              <th width="15%">#Start Time</th>
              <th width="15%">#End Time</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody>
          @foreach($workshift as $index => $shift)
          <tr>
              <td>{{ ($index + 1) + (($paginate->getCurrentPage() - 1) * $paginate->getPerPage()) }}</td>
              <td>{{$shift->name}}</td>
              <td>{{substr($shift->start_work_time, 0, 5)}}</td>
              <td>{{substr($shift->end_work_time, 0, 5)}}</td>
              <td id="td_{{ $shift->id }}" class="text-right">
                  <input type="hidden" name="hid_id" value="{{ $shift->id }}"/>
                  <input type="hidden" name="hid_name" value="{{ $shift->name }}"/>
                  <input type="hidden" name="hid_start_work_time" value="{{substr($shift->start_work_time, 0, 5)}}"/>
                  <input type="hidden" name="hid_end_work_time" value="{{substr($shift->end_work_time, 0, 5)}}"/>                      
                  <input type="hidden" name="hid_days" value="{{ $shift->days }}"/>
                  <a href="" title="quick edit" id="edit_{{ $shift->id }}" class="btn btn-xs btn-success btn-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                  <a href="" title="delete work shift" id="del_{{ $shift->id }}" class="btn btn-xs btn-danger btn-empl-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
              </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      {{ $paginate->links() }}
    </div>
</div>
