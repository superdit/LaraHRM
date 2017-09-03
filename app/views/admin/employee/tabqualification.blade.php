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
    $('#from_date, #to_date, #from_date-edit, #to_date-edit').datetimepicker({pickTime: false, viewMode:2}); 
    
    @if (Session::has('add_workexp_failed'))
        $('#addWorkModal').modal('show');
        $('#addWorkModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('company_name') != "")
            $("[rel='tooltipcompany_name']").tooltip({placement: 'right', title: '{{$error_messages->first('company_name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-company_name').addClass('has-error');
            @endif
            $('#addWorkModal input[name="company_name"]').val('{{$input_values['company_name']}}');
            
            @if (isset($error_messages) && $error_messages->first('job_title') != "")
            $("[rel='tooltipjob_title']").tooltip({placement: 'right', title: '{{$error_messages->first('job_title')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-job_title').addClass('has-error');
            @endif
            $('#addWorkModal input[name="job_title"]').val('{{$input_values['job_title']}}');
            
            @if (isset($error_messages) && $error_messages->first('from_date') != "")
            $("[rel='tooltipfrom_date']").tooltip({placement: 'right', title: '{{$error_messages->first('from_date')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-from_date').addClass('has-error');
            @endif
            $('#addWorkModal input[name="from_date"]').val('{{$input_values['from_date']}}');
            
            @if (isset($error_messages) && $error_messages->first('to_date') != "")
            $("[rel='tooltipto_date']").tooltip({placement: 'right', title: '{{$error_messages->first('to_date')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-to_date').addClass('has-error');
            @endif
            $('#addWorkModal input[name="to_date"]').val('{{$input_values['to_date']}}');
            
            $('#addWorkModal input[name="location"]').val('{{$input_values['location']}}');
            $('#addWorkModal textarea[name="description"]').val('{{$input_values['description']}}');
        });            
    @endif 
    
    @if (Session::has('edit_workexp_failed'))
        $('#editWorkModal').modal('show');
        $('#editWorkModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('company_name') != "")
            $("[rel='tooltipcompany_name-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('company_name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-company_name-edit').addClass('has-error');
            @endif
            $('#editWorkModal input[name="company_name"]').val('{{$input_values['company_name']}}');
            
            @if (isset($error_messages) && $error_messages->first('job_title') != "")
            $("[rel='tooltipjob_title-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('job_title')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-job_title-edit').addClass('has-error');
            @endif
            $('#editWorkModal input[name="job_title"]').val('{{$input_values['job_title']}}');
            
            @if (isset($error_messages) && $error_messages->first('from_date') != "")
            $("[rel='tooltipfrom_date-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('from_date')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-from_date-edit').addClass('has-error');
            @endif
            $('#editWorkModal input[name="from_date"]').val('{{$input_values['from_date']}}');
            
            @if (isset($error_messages) && $error_messages->first('to_date') != "")
            $("[rel='tooltipto_date-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('to_date')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-to_date-edit').addClass('has-error');
            @endif
            $('#editWorkModal input[name="to_date"]').val('{{$input_values['to_date']}}');
            
            $('#editWorkModal input[name="location"]').val('{{$input_values['location']}}');
            $('#editWorkModal textarea[name="description"]').val('{{$input_values['description']}}');
            $('#editWorkModal input[name="id"]').val('{{$employee->id}}');
        });            
    @endif 
    
    // Event on show delete work experience modal confirmation
    $('.btn-workexp-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#workexp_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this work experience: "'+title+'" ?</h4>';
        $('#modal-del-content-workexp').html(html);

        $('#btn-do-delete-workexp').attr('href', '{{URL::to("admin/workexp/delete-from-employee")}}/'+{{$employee->id}}+'/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-workexp-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_company_name = $('#td_' + tmp_id + ' input[name="hid_company_name"]').val();
        var tmp_job_title = $('#td_' + tmp_id + ' input[name="hid_job_title"]').val();
        var tmp_from_date = $('#td_' + tmp_id + ' input[name="hid_from_date"]').val();
        var tmp_to_date = $('#td_' + tmp_id + ' input[name="hid_to_date"]').val();
        var tmp_location = $('#td_' + tmp_id + ' input[name="hid_location"]').val();
        var tmp_description = $('#td_' + tmp_id + ' input[name="hid_description"]').val();

        setTimeout(function() {
            $('#editWorkModal input[name="company_name"]').val(tmp_company_name);
            $('#editWorkModal input[name="job_title"]').val(tmp_job_title);
            $('#editWorkModal input[name="id"]').val(tmp_id);
            $('#editWorkModal input[name="from_date"]').val(tmp_from_date);
            $('#editWorkModal input[name="to_date"]').val(tmp_to_date);
            $('#editWorkModal input[name="job_title"]').val(tmp_job_title);
            $('#editWorkModal input[name="location"]').val(tmp_location);
            $('#editWorkModal textarea[name="description"]').val(tmp_description);

            $("[rel='tooltipcompany_name-edit'], [rel='tooltipjob_title-edit'], [rel='tooltipfrom_date-edit'], [rel='tooltipto_date-edit']").tooltip('destroy');
            $('#form-group-company_name-edit, #form-group-job_title-edit, #form-group-from_date-edit, #form-group-to_date-edit').removeClass('has-error');
        }, 500);

    });
});
</script>

<!-- Add Work Experience Modal -->
<div class="modal fade" id="addWorkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/workexp/add-to-employee')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Work Experience</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-company_name">
                <label class="col-sm-3 control-label" for="company_name">Company Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="company_name" rel="tooltipcompany_name">
                </div>
              </div>
              <div class="form-group" id="form-group-job_title">
                <label class="col-sm-3 control-label" for="job_title">Job Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="job_title" rel="tooltipjob_title">
                </div>
              </div>
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
              <div class="form-group" id="form-group-location">
                <label class="col-sm-3 control-label" for="location">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="location" rel="tooltiplocation" placeholder="city / state / country / etc">
                </div>
              </div>
              <div class="form-group" id="form-group-description">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="description"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Work Experience Add Modal -->

<!-- Edit Work Experience Modal -->
<div class="modal fade" id="editWorkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/workexp/edit-from-employee')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Work Experience</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-company_name-edit">
                <label class="col-sm-3 control-label" for="company_name">Company Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="company_name" rel="tooltipcompany_name-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-job_title-edit">
                <label class="col-sm-3 control-label" for="job_title">Job Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="job_title" rel="tooltipjob_title-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-from_date-edit">
                <label class="col-sm-3 control-label">From</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="from_date-edit">
                    <input type="text" class="form-control" name="from_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                    <span class="input-group-addon" rel="tooltipfrom_date-edit"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-to_date-edit">
                <label class="col-sm-3 control-label">To</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="to_date-edit">
                    <input type="text" class="form-control" name="to_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                    <span class="input-group-addon" rel="tooltipto_date-edit"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-location-edit">
                <label class="col-sm-3 control-label" for="location">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="location" rel="tooltiplocation-edit" placeholder="city / state / country / etc">
                </div>
              </div>
              <div class="form-group" id="form-group-description-edit">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="description"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Work Experience Edit Modal -->

<!-- Delete Work Experience Confirmation modal -->
<div class="modal fade" id="delWorkExpModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Work Experience Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-workexp">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-workexp" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Work Experience Confirmation modal -->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Work Experience
        <a href="#" title="add work experience" class="pull-right btn btn-xs btn-default" data-toggle="modal" data-target="#addWorkModal"><i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="25%">#Company Name</th>
                  <th width="30%">#Job Title</th>
                  <th width="15%">#From</th>
                  <th width="15%">#To</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee->workexperience as $index => $workexp)
              <tr>
                  <td id="workexp_{{$workexp->id}}">{{ $workexp->company_name }}</td>
                  <td>{{ $workexp->job_title }}</td>
                  <td>{{ $workexp->from_date }}</td>
                  <td>{{ $workexp->to_date }}</td>
                  <td id="td_{{$workexp->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $workexp->id }}"/>
                      <input type="hidden" name="hid_company_name" value="{{ $workexp->company_name }}"/>
                      <input type="hidden" name="hid_job_title" value="{{ $workexp->job_title }}"/>
                      <input type="hidden" name="hid_from_date" value="{{ $workexp->from_date }}"/>
                      <input type="hidden" name="hid_to_date" value="{{ $workexp->to_date }}"/>
                      <input type="hidden" name="hid_location" value="{{ $workexp->location }}"/>
                      <input type="hidden" name="hid_description" value="{{ $workexp->description }}"/>
                      <a href="" title="quick edit" id="edit_{{$workexp->id}}" class="btn btn-xs btn-success btn-workexp-edit" data-toggle="modal" data-target="#editWorkModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete salary component" id="del_{{$workexp->id}}" class="btn btn-xs btn-danger btn-workexp-del" data-toggle="modal" data-target="#delWorkExpModal"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>

<!----------------------------------------------------------------------------->

<script>
$(function() {
    $('#start_date, #graduate_date, #start_date-edit, #graduate_date-edit').datetimepicker({pickTime: false, viewMode:2}); 
    
    @if (Session::has('add_education_failed'))
        $('#addEduModal').modal('show');
        $('#addEduModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('school_name') != "")
            $("[rel='tooltipschool_name']").tooltip({placement: 'right', title: '{{$error_messages->first('school_name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-school_name').addClass('has-error');
            @endif
            $('#addEduModal input[name="school_name"]').val('{{$input_values['school_name']}}');
            
            @if (isset($error_messages) && $error_messages->first('field_of_study') != "")
            $("[rel='tooltipfield_of_study']").tooltip({placement: 'right', title: '{{$error_messages->first('field_of_study')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-field_of_study').addClass('has-error');
            @endif
            $('#addEduModal input[name="field_of_study"]').val('{{$input_values['field_of_study']}}');
            
            @if (isset($error_messages) && $error_messages->first('start_date') != "")
            $("[rel='tooltipstart_date']").tooltip({placement: 'right', title: '{{$error_messages->first('start_date')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-start_date').addClass('has-error');
            @endif
            $('#addEduModal input[name="start_date"]').val('{{$input_values['start_date']}}');
            
            @if (isset($error_messages) && $error_messages->first('graduate_date') != "")
            $("[rel='tooltipgraduate_date']").tooltip({placement: 'right', title: '{{$error_messages->first('graduate_date')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-graduate_date').addClass('has-error');
            @endif
            $('#addEduModal input[name="graduate_date"]').val('{{$input_values['graduate_date']}}');
            
            $('#addEduModal select[name="education_degree_id"]').val('{{$input_values['education_degree_id']}}');
            $('#addEduModal input[name="grade"]').val('{{$input_values['grade']}}');
            $('#addEduModal textarea[name="activities"]').val('{{$input_values['activities']}}');
            $('#addEduModal textarea[name="description"]').val('{{$input_values['description']}}');
        });            
    @endif
    
    // Event on show delete education modal confirmation
    $('.btn-edu-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#edu_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this education: "'+title+'" ?</h4>';
        $('#modal-del-content-edu').html(html);

        $('#btn-do-delete-edu').attr('href', '{{URL::to("admin/education/delete-from-employee")}}/'+{{$employee->id}}+'/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-edu-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_school_name = $('#td_edu_' + tmp_id + ' input[name="hid_school_name"]').val();
        var tmp_field_of_study = $('#td_edu_' + tmp_id + ' input[name="hid_field_of_study"]').val();
        var tmp_start_date = $('#td_edu_' + tmp_id + ' input[name="hid_start_date"]').val();
        var tmp_graduate_date = $('#td_edu_' + tmp_id + ' input[name="hid_graduate_date"]').val();
        var tmp_grade = $('#td_edu_' + tmp_id + ' input[name="hid_grade"]').val();
        var tmp_activities = $('#td_edu_' + tmp_id + ' input[name="hid_activities"]').val();
        var tmp_description = $('#td_edu_' + tmp_id + ' input[name="hid_description"]').val();
        var tmp_education_degree_id = $('#td_edu_' + tmp_id + ' input[name="hid_education_degree_id"]').val();

        setTimeout(function() {
            $('#editEduModal input[name="school_name"]').val(tmp_school_name);
            $('#editEduModal input[name="field_of_study"]').val(tmp_field_of_study);
            $('#editEduModal input[name="id"]').val(tmp_id);
            $('#editEduModal input[name="start_date"]').val(tmp_start_date);
            $('#editEduModal input[name="graduate_date"]').val(tmp_graduate_date);
            $('#editEduModal input[name="grade"]').val(tmp_grade);
            $('#editEduModal select[name="education_degree_id"]').val(tmp_education_degree_id);
            $('#editEduModal textarea[name="activities"]').val(tmp_activities);
            $('#editEduModal textarea[name="description"]').val(tmp_description);

            $("[rel='tooltipschool_name-edit'], [rel='tooltipfield_of_study-edit'], [rel='tooltipstart_date-edit'], [rel='tooltipgraduate_date-edit']").tooltip('destroy');
            $('#form-group-school_name-edit, #form-group-field_of_study-edit, #form-group-start_date-edit, #form-group-graduate_date-edit').removeClass('has-error');
        }, 500);

    });
});
</script>

<!-- Add Education Modal -->
<div class="modal fade" id="addEduModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/education/add-to-employee')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Education</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-school_name">
                <label class="col-sm-3 control-label" for="school_name">School / Institution</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="school_name" rel="tooltipcompany_name">
                </div>
              </div>
              <div class="form-group" id="form-group-start_date">
                <label class="col-sm-3 control-label">Start</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="start_date">
                    <input type="text" class="form-control" name="start_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                    <span class="input-group-addon" rel="tooltipstart_date"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-graduate_date">
                <label class="col-sm-3 control-label">Graduate</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="graduate_date">
                    <input type="text" class="form-control" name="graduate_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                    <span class="input-group-addon" rel="tooltipgraduate_date"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-education_degree_id">
                <label class="col-sm-3 control-label" for="education_degree_id">Degree</label>
                <div class="col-sm-9">
                    <select class="form-control" name="education_degree_id">
                        @foreach ($educationDegree as $index => $edudegree)
                        <option value="{{$edudegree->id}}">{{$edudegree->name}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group" id="form-group-field_of_study">
                <label class="col-sm-3 control-label" for="field_of_study">Field of Study</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="field_of_study" rel="tooltipfield_of_study">
                </div>
              </div>
              <div class="form-group" id="form-group-grade">
                <label class="col-sm-3 control-label" for="grade">Grade / GPA</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="grade" rel="tooltipgrade">
                </div>
              </div>
              <div class="form-group" id="form-group-activities">
                <label class="col-sm-3 control-label" for="activities">Activities</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="activities"></textarea>
                </div>
              </div>
              <div class="form-group" id="form-group-description">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="description"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Education Add Modal -->

<!-- Edit Education Modal -->
<div class="modal fade" id="editEduModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/education/edit-from-employee')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
            <input type="hidden" name="id" />
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Education</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-school_name">
                <label class="col-sm-3 control-label" for="school_name">School / Institution</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="school_name" rel="tooltipcompany_name">
                </div>
              </div>
              <div class="form-group" id="form-group-start_date">
                <label class="col-sm-3 control-label">Start</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="start_date">
                    <input type="text" class="form-control" name="start_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                    <span class="input-group-addon" rel="tooltipstart_date"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-graduate_date">
                <label class="col-sm-3 control-label">Graduate</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="graduate_date">
                    <input type="text" class="form-control" name="graduate_date" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                    <span class="input-group-addon" rel="tooltipgraduate_date"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-education_degree_id">
                <label class="col-sm-3 control-label" for="education_degree_id">Degree</label>
                <div class="col-sm-9">
                    <select class="form-control" name="education_degree_id">
                        @foreach ($educationDegree as $index => $edudegree)
                        <option value="{{$edudegree->id}}">{{$edudegree->name}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group" id="form-group-field_of_study">
                <label class="col-sm-3 control-label" for="field_of_study">Field of Study</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="field_of_study" rel="tooltipfield_of_study">
                </div>
              </div>
              <div class="form-group" id="form-group-grade">
                <label class="col-sm-3 control-label" for="grade">Grade / GPA</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="grade" rel="tooltipgrade">
                </div>
              </div>
              <div class="form-group" id="form-group-activities">
                <label class="col-sm-3 control-label" for="activities">Activities</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="activities"></textarea>
                </div>
              </div>
              <div class="form-group" id="form-group-description">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="description"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Education Edit Modal -->

<!-- Delete Education Confirmation modal -->
<div class="modal fade" id="delEduModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Education Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-edu">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-edu" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Education Confirmation modal -->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Education
        <a href="#" title="add education" class="pull-right btn btn-xs btn-default" data-toggle="modal" data-target="#addEduModal"><i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="25%">#School Name</th>
                  <th width="30%">#Field of Study</th>
                  <th width="15%">#From</th>
                  <th width="15%">#To</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee->education as $index => $edu)
              <tr>
                  <td id="edu_{{$edu->id}}">{{ $edu->school_name }}</td>
                  <td>{{ $edu->field_of_study }}</td>
                  <td>{{ $edu->start_date }}</td>
                  <td>{{ $edu->graduate_date }}</td>
                  <td id="td_edu_{{$edu->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $edu->id }}"/>
                      <input type="hidden" name="hid_school_name" value="{{ $edu->school_name }}"/>
                      <input type="hidden" name="hid_field_of_study" value="{{ $edu->field_of_study }}"/>
                      <input type="hidden" name="hid_grade" value="{{ $edu->grade }}"/>
                      <input type="hidden" name="hid_start_date" value="{{ $edu->start_date }}"/>
                      <input type="hidden" name="hid_graduate_date" value="{{ $edu->graduate_date }}"/>
                      <input type="hidden" name="hid_activities" value="{{ $edu->activities }}"/>
                      <input type="hidden" name="hid_description" value="{{ $edu->description }}"/>
                      <input type="hidden" name="hid_education_degree_id" value="{{ $edu->education_degree_id }}"/>
                      <a href="" title="quick edit" id="edit_{{$edu->id}}" class="btn btn-xs btn-success btn-edu-edit" data-toggle="modal" data-target="#editEduModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete education" id="del_{{$edu->id}}" class="btn btn-xs btn-danger btn-edu-del" data-toggle="modal" data-target="#delEduModal"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>

<!----------------------------------------------------------------------------->

<script>
$(function() {    
    @if (Session::has('add_skill_failed'))
        $('#addSkillModal').modal('show');
        $('#addSkillModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name').addClass('has-error');
            @endif
            $('#addSkillModal input[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('level') != "")
            $("[rel='tooltiplevel']").tooltip({placement: 'right', title: '{{$error_messages->first('level')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-level').addClass('has-error');
            @endif
            $('#addSkillModal select[name="level"]').val('{{$input_values['level']}}');
            
            $('#addSkillModal textarea[name="description"]').val('{{$input_values['description']}}');
        });            
    @endif
    
    @if (Session::has('edit_skill_failed'))
        $('#editSkillModal').modal('show');
        $('#editSkillModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-edit').addClass('has-error');
            @endif
            $('#editSkillModal input[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('level') != "")
            $("[rel='tooltiplevel-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('level')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-level-edit').addClass('has-error');
            @endif
            $('#editSkillModal select[name="level"]').val('{{$input_values['level']}}');
            
            $('#editSkillModal textarea[name="description"]').val('{{$input_values['description']}}');
            $('#editSkillModal input[name="id"]').val('{{$input_values['id']}}');
        });            
    @endif
    
    // Event on show delete skill modal confirmation
    $('.btn-skill-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#skill_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this skill: "'+title+'" ?</h4>';
        $('#modal-del-content-skill').html(html);

        $('#btn-do-delete-skill').attr('href', '{{URL::to("admin/skill/delete-from-employee")}}/'+{{$employee->id}}+'/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-skill-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_name = $('#td_skill_' + tmp_id + ' input[name="hid_name"]').val();
        var tmp_level = $('#td_skill_' + tmp_id + ' input[name="hid_level"]').val();
        var tmp_description = $('#td_skill_' + tmp_id + ' input[name="hid_description"]').val();

        setTimeout(function() {
            $('#editSkillModal input[name="name"]').val(tmp_name);
            $('#editSkillModal select[name="level"]').val(tmp_level);
            $('#editSkillModal input[name="id"]').val(tmp_id);
            $('#editSkillModal textarea[name="description"]').val(tmp_description);

            $("[rel='tooltipname-edit']").tooltip('destroy');
            $('#form-group-name-edit').removeClass('has-error');
        }, 500);

    });
});
</script>

<!-- Add Skill Modal -->
<div class="modal fade" id="addSkillModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/skill/add-to-employee')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Skill / Certification / Training</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" rel="tooltipname">
                </div>
              </div>
              <div class="form-group" id="form-group-level">
                <label class="col-sm-3 control-label" for="level">Level</label>
                <div class="col-sm-9">
                    <select class="form-control" name="level">
                        <option value="beginner">Beginner</option>
                        <option value="medium">Medium</option>
                        <option value="expert">Expert</option>
                        <option value="other">Other</option>
                    </select>
                </div>
              </div>
              <div class="form-group" id="form-group-description">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="description"></textarea>
                </div>
              </div>  
              <div class="form-group" id="form-group-document">
                <label class="col-sm-3 control-label" for="document">Related Document</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control" name="document" rel="tooltipcodument">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Skill Add Modal -->

<!-- Edit Skill Modal -->
<div class="modal fade" id="editSkillModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/skill/edit-from-employee')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
            <input type="hidden" name="id" />
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Skill / Certification / Training</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name-edit">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" rel="tooltipname-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-level-edit">
                <label class="col-sm-3 control-label" for="level">Level</label>
                <div class="col-sm-9">
                    <select class="form-control" name="level">
                        <option value="beginner">Beginner</option>
                        <option value="medium">Medium</option>
                        <option value="expert">Expert</option>
                        <option value="other">Other</option>
                    </select>
                </div>
              </div>
              <div class="form-group" id="form-group-description-edit">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea rows="4" class="form-control" name="description"></textarea>
                </div>
              </div>  
              <div class="form-group" id="form-group-document-edit">
                <label class="col-sm-3 control-label" for="document">Related Document</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control" name="document" rel="tooltipcodument">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Skill Edit Modal -->

<!-- Delete Skill Confirmation modal -->
<div class="modal fade" id="delSkillModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Skill Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-skill">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-skill" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Skill Confirmation modal -->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Skill / Certification / Training
        <a href="#" title="add skill / certification / training" class="pull-right btn btn-xs btn-default" data-toggle="modal" data-target="#addSkillModal"><i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="65%">#Name</th>
                  <th width="20%">#Level</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee->skill as $index => $skill)
              <tr>
                  <td id="skill_{{$skill->id}}">{{ $skill->name }}</td>
                  <td>{{ $skill->level }}</td>
                  <td id="td_skill_{{$skill->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $skill->id }}"/>
                      <input type="hidden" name="hid_name" value="{{ $skill->name }}"/>
                      <input type="hidden" name="hid_level" value="{{ $skill->level }}"/>
                      <input type="hidden" name="hid_description" value="{{ $skill->description }}"/>
                      <a href="" title="quick edit" id="edit_{{$skill->id}}" class="btn btn-xs btn-success btn-skill-edit" data-toggle="modal" data-target="#editSkillModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete skill" id="del_{{$skill->id}}" class="btn btn-xs btn-danger btn-skill-del" data-toggle="modal" data-target="#delSkillModal"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>