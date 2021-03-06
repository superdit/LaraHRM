@extends('layouts/backend-employee')

@section('content')
    <style>
    .tooltip-inner {
        white-space: nowrap;
        max-width: 350px;
    }
    td { vertical-align: middle !important; }
    </style>

    <script>
    $(function() {                     
        // Event confirm delete attendance            
        $('.btn-empl-del-attendance').click(function() {
            var tmp_id = $(this).attr('id').replace("del_", ""); 
            var tmp_id_work_date = $('#td_' + tmp_id + ' input[name="hid_work_date"]').val();

            var html = '<h4 style="text-align:center;font-weight:bold;">Delete this attendance: "'+tmp_id_work_date+'" ?</h4>';
            $('#modal-del-content').html(html);

            $('#btn-do-delete-attendance').attr('href', '{{URL::to("admin/attendance/delete")}}/'+tmp_id);
        });

        // Event edit attendance     
        $('.btn-edit-attendance').click(function() {
            var tmp_id = $(this).attr('id').replace("edit_att_", ""); 
            var tmp_id_attendance = $('#td_' + tmp_id + ' input[name="hid_attendance_id"]').val();
            var tmp_work_date = $('#td_' + tmp_id + ' input[name="hid_work_date"]').val();
            var tmp_check_in_time = $('#td_' + tmp_id + ' input[name="hid_check_in_time"]').val();
            var tmp_check_out_time = $('#td_' + tmp_id + ' input[name="hid_check_out_time"]').val();

            setTimeout(function() {
                $('#editAttendanceModal input[name="id"]').val(tmp_id_attendance);        
                $('#editAttendanceModal input[name="work_date"]').val(tmp_work_date);
                $('#editAttendanceModal input[name="check_in_time"]').val(tmp_check_in_time);
                $('#editAttendanceModal input[name="check_out_time"]').val(tmp_check_out_time);

                $("[rel='tooltipwork_date_edit'], [rel='tooltipcheck_in_time_edit'], [rel='tooltipcheck_out_time_edit']").tooltip('destroy');
                $('#form-group-work_date_edit, #form-group-check_in_time_edit, #form-group-check_out_time_edit').removeClass('has-error');
            }, 500);
        });

        // Event confirm delete leave history
        $('.btn-del-leave').click(function() {
            var tmp_id = $(this).attr('id').replace("del_leave_", ""); 

            $('#btn-do-delete-leave').attr('href', '{{URL::to("admin/attendance/delete-leave/".$employee->id)}}/'+tmp_id);
        });

        // Event edit leave     
        $('.btn-edit-leave').click(function() {
            var tmp_id = $(this).attr('id').replace("edit_leave_", ""); 
            var tmp_id_leave = $('#td_' + tmp_id + ' input[name="hid_leave_id"]').val();
            var tmp_from_date = $('#td_' + tmp_id + ' input[name="hid_from_date"]').val();
            var tmp_to_date = $('#td_' + tmp_id + ' input[name="hid_to_date"]').val();
            var tmp_reason = $('#td_' + tmp_id + ' input[name="hid_reason"]').val();
            var tmp_status = $('#td_' + tmp_id + ' input[name="hid_status"]').val();
            var tmp_desc = $('#td_' + tmp_id + ' input[name="hid_description"]').val();


            setTimeout(function() {
                $('#editLeaveModal input[name="id"]').val(tmp_id_leave);        
                $('#editLeaveModal input[name="from_date"]').val(tmp_from_date);
                $('#editLeaveModal input[name="to_date"]').val(tmp_to_date);
                $('#editLeaveModal select[name="reason"]').val(tmp_reason);
                $('#editLeaveModal select[name="status"]').val(tmp_status);
                $('#editLeaveModal textarea[name="description"]').val(tmp_desc);

                $("[rel='tooltipfrom_date'], [rel='tooltipto_date']']").tooltip('destroy');
                $('#form-group-from_date_edit, #form-group-to_date_edit').removeClass('has-error');
            }, 500);
        });
    });
    </script>
    
    <!-- Notification for attendance -->
    @if (Session::has('add_att_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New Employee Attendance added.
    </div>
    @endif
    
    @if (Session::has('edit_att_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Attendance updated.
    </div>
    @endif
    
    @if (Session::has('delete_att_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Attendance deleted.
    </div>
    @endif

    <!-- Notification for leave -->
    @if (Session::has('add_leave_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New Leave Permission added.
    </div>
    @endif
    
    @if (Session::has('edit_leave_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Leave permission updated.
    </div>
    @endif
    
    @if (Session::has('delete_leave_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Leave permission history deleted.
    </div>
    @endif
    
    @include('employee/profile/header-tab')
    
    <!-- Add Leave modal -->
    <div class="modal fade" id="addLeaveModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form role="form" class="form-horizontal" action="{{URL::to('admin/attendance/add-leave')}}" method="post">
                <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add Leave Permission</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-from_date">
                    <label class="col-sm-3 control-label">From</label>
                    <div class="col-sm-9">
                      <div class="input-group date pull-right" id="from_date">
                        <input type="text" class="form-control" name="from_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                        <span class="input-group-addon" rel="tooltipfrom_date"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-to_date">
                    <label class="col-sm-3 control-label">To</label>
                    <div class="col-sm-9">
                      <div class="input-group date pull-right" id="to_date">
                        <input type="text" class="form-control" name="to_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                        <span class="input-group-addon" rel="tooltipto_date"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-type">
                    <label class="col-sm-3 control-label">Reason</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="reason">
                          <option value="family need">Family Need</option>
                          <option value="hajj">Hajj / Umrah</option>
                          <option value="medical appointment">Medical Appointment</option>
                          <option value="sickness">Sickness</option>
                          <option value="study">Study</option>
                          <option value="training">Training</option>
                          <option value="wedding">Wedding</option>
                          <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-type">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="status">
                          <option value="pending approval">Pending Approval</option>
                          <option value="approved">Approved</option>
                          <option value="rejected">Rejected</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-description">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="description" rows="4" rel="tooltipdescription"></textarea>
                    </div>
                  </div>
                </div>               
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Add Leave">
                </div>
            </form>
        </div>
      </div>
    </div>
    <!-- End Add Leave modal -->
    
    <!-- Edit Leave modal -->
    <div class="modal fade" id="editLeaveModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form role="form" class="form-horizontal" action="{{URL::to('admin/attendance/edit-leave')}}" method="post">
                <input type="hidden" name="id" value="{{ $employee->id }}"/>
                <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit Leave Permission</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-from_date-edit">
                    <label class="col-sm-3 control-label">From</label>
                    <div class="col-sm-9">
                      <div class="input-group date pull-right" id="from_date">
                        <input type="text" class="form-control" name="from_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                        <span class="input-group-addon" rel="tooltipfrom_date"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-to_date-edit">
                    <label class="col-sm-3 control-label">To</label>
                    <div class="col-sm-9">
                      <div class="input-group date pull-right" id="to_date">
                        <input type="text" class="form-control" name="to_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                        <span class="input-group-addon" rel="tooltipto_date"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-type">
                    <label class="col-sm-3 control-label">Reason</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="reason">
                          <option value="family need">Family Need</option>
                          <option value="hajj">Hajj / Umrah</option>
                          <option value="medical appointment">Medical Appointment</option>
                          <option value="sickness">Sickness</option>
                          <option value="study">Study</option>
                          <option value="training">Training</option>
                          <option value="wedding">Wedding</option>
                          <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-type">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="status">
                          <option value="pending approval">Pending Approval</option>
                          <option value="approved">Approved</option>
                          <option value="rejected">Rejected</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-description-edit">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="description" rows="4" rel="tooltipdescription"></textarea>
                    </div>
                  </div>
                </div>               
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save Changes">
                </div>
            </form>
        </div>
      </div>
    </div>
    <!-- End Edit Leave modal -->
    
    <!-- Delete Leave Confirmation modal -->
    <div class="modal fade" id="deleteLeaveModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Leave Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content">
              <h4 class="text-center">Delete this leave permission ?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="" id="btn-do-delete-leave" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End delete Leave confirmation modal -->
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Attendance History
            <a href="{{ URL::to('admin/employee/edit/'.$employee->id) }}" title="edit employee" class="pull-right btn btn-xs btn-primary btn-edit"><i class="fa fa-pencil"></i> edit</a>
        </div>
        <div class="panel-body">
            <div class="col-md-2">
              <div class="thumbnail">
                <img src="{{ URL::to('/') }}/uploads/employee/default_photos/{{ $employee->photo }}" alt="...">
              </div>
            </div>
            <div class="col-md-10 form-horizontal">    
                <div class="bs-example">
                  @include('employee/profile/header-tab-list')
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in" id="profile"></div>
                      
                    <div class="tab-pane active" id="attendance">
                        <h3 style="margin: 0;" class="pull-left">{{ ($view == 'attendance' ? 'Attendance' : 'Leave'); }} History</h3>
                        
                        @if ($view == 'attendance')
                        <a href="{{ URL::to('employee/profile/leave') }}" title="leave history" class="pull-right btn btn-xs btn-primary btn-edit"><i class="fa fa-list"></i> Leave History</a>
                        @else
                        <a href="{{ URL::to('employee/profile/attendance') }}" title="attendance history" class="pull-right btn btn-xs btn-primary btn-edit"><i class="fa fa-list"></i> Attendance History</a>
                        @endif
                        <div class="pull-right">&nbsp;</div>
                        <a href="" title="add leave" data-toggle="modal" data-target="#addLeaveModal" class="pull-right btn btn-xs btn-primary btn-edit"><i class="fa fa-plus"></i> Add Leave</a>
                        
                        <br/><br/>
                        <div class="table-responsive">
                            @if ($view == 'attendance')
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                  <!--<th>No</th>-->
                                  <th>#Work Date</th>
                                  <th>#Check In</th>
                                  <th>#Check Out</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php 
                                    $no_img = URL::to('/') . "/uploads/employee/attendance/check_inout_no_image.jpg";
                                    function checkRemoteFile($url) 
                                    {
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL,$url);
                                        // don't download content
                                        curl_setopt($ch, CURLOPT_NOBODY, 1);
                                        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                        if(curl_exec($ch)!==FALSE)
                                        {
                                            return true;
                                        }
                                        else
                                        {
                                            return false;
                                        }
                                    }
                              ?>
                              <style>
                                .popover
                                {
                                    min-width: 200px ! important;
                                    max-width: 900px ! important;
                                }
                              </style>
                              <script>
                                $(document).ready(function() {
                                    $('.thumb-pop').mouseenter(function() {
                                        var pop_img = $(this).attr('data-img');
                                        $(this).popover({
                                            trigger: "click",
                                            placement: "top",
                                            content: '<img width="250" src="'+pop_img+'"/>',
                                            html: true
                                        });
                                    });
                                });
                              </script>
                              @foreach ($attendance as $index => $att)
                              <tr>
                                  <!--<td>-->
                                      <!--{{ ($index + 1) + (($paginate->getCurrentPage() - 1) * $paginate->getPerPage()) }}-->
                                  <!--</td>-->
                                  <td>{{ $att->work_date }}</td>
                                  <td>
                                      {{ substr($att->check_in_time, 0, 5) }}
                                      &nbsp;&nbsp;
                                      <?php $check_in_img = URL::to('/') . "/uploads/employee/attendance/check_in/" . $employee->id . "_" . $employee->id_number . 
                                                                "_" . str_replace("-", "", $att->work_date) . str_replace(":", "", $att->check_in_time) . ".jpg"; 
                                            $isImgExist = checkRemoteFile($check_in_img);
                                      ?>
                                      @if ($isImgExist)
                                      <a href="javascript:void(0);" class="thumb-pop" data-img="{{ $check_in_img }}"><img title="view check in photo"  height="40" width="40" src="{{ $check_in_img }}" class="img-circle"/></a>
                                      @else
                                      <img height="40" width="40" src="{{ $no_img }}" class="img-circle"/>
                                      @endif
                                  </td>
                                  <td>
                                      {{ substr($att->check_out_time, 0, 5) }}
                                      &nbsp;&nbsp;
                                      <?php $check_out_img = URL::to('/') . "/uploads/employee/attendance/check_out/" . $employee->id . "_" . $employee->id_number . 
                                                                "_" . str_replace("-", "", $att->work_date) . str_replace(":", "", $att->check_out_time) . ".jpg"; 
                                            $isImgExist = checkRemoteFile($check_out_img);
                                      ?>
                                      @if ($isImgExist)
                                      <a href="javascript:void(0);" class="thumb-pop" data-img="{{ $check_out_img }}"><img title="view check out photo"  height="40" width="40" src="{{ $check_out_img }}" class="img-circle"/></a>
                                      @else
                                      <img height="40" width="40" src="{{ $no_img }}" class="img-circle"/>
                                      @endif
                                  </td>
                                  <td></td>
                              </tr>
                              @endforeach
                              </tbody>
                            </table>
                            @else
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                  <!--<th>No</th>-->
                                  <th width="15%">#From</th>
                                  <th width="15%">#To</th>
                                  <th width="25%">#Reason</th>
                                  <th width="20%">#Status</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach ($leaves as $index => $leave)
                              <tr>
                                  <!--<td>{{ ($index + 1) + (($paginate->getCurrentPage() - 1) * $paginate->getPerPage()) }}</td>-->
                                  <td>{{ $leave->from_date }}</td>
                                  <td>{{ $leave->to_date }}</td>
                                  <td>{{ $leave->reason }}</td>
                                  <td>{{ $leave->status }}</td>
                                  <td id="td_{{ $leave->id }}" style="text-align: right;">
                                      <input type="hidden" name="hid_leave_id" value="{{ $leave->id }}"/>
                                      <input type="hidden" name="hid_from_date" value="{{ $leave->from_date }}"/>
                                      <input type="hidden" name="hid_to_date" value="{{ $leave->to_date }}"/>
                                      <input type="hidden" name="hid_reason" value="{{ $leave->reason }}"/>
                                      <input type="hidden" name="hid_status" value="{{ $leave->status }}"/>
                                      <input type="hidden" name="hid_description" value="{{ $leave->description }}"/>
                                      <a href="" title="quick edit" id="edit_leave_{{ $leave->id }}" class="btn btn-xs btn-success btn-edit-leave" data-toggle="modal" data-target="#editLeaveModal"><i class="fa fa-edit"></i></a>
                                      <a href="" title="delete leaves" id="del_leave_{{ $leave->id }}" class="btn btn-xs btn-danger btn-del-leave" data-toggle="modal" data-target="#deleteLeaveModal"><i class="fa fa-trash-o"></i></a>                      
                                  </td>
                              </tr>
                              @endforeach
                              </tbody>
                            </table>
                            @endif
                        </div>
                        {{ $paginate->links() }}
                    </div>
                  
                    <div class="tab-pane fade" id="contact"></div>
                    
                    <div class="tab-pane fade" id="login"></div>
                    
                    <div class="tab-pane fade" id="qualification"></div>
                    
                    <div class="tab-pane fade" id="salary"></div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop