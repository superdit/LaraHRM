@extends('layouts/backend')

@section('content')

    <script>
        $(function() {         
            $('#birthdate-edit').datetimepicker({pickTime: false, viewMode:2}); 
            
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
        });
    </script>

    <h1 class="page-header">Edit Employee</h1>
    
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
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            Edit Employee Information
            <a href="#" title="delete" class="pull-right btn btn-xs btn-danger btn-edit" data-toggle="modal" data-target=".delete-confirm"><i class="fa fa-trash-o"></i> delete</a>
            <span class="pull-right">&nbsp;</span>
            <a href="{{ URL::to('admin/employee/view/'.$employee->id) }}" title="view employee" class="pull-right btn btn-xs btn-primary btn-edit"><i class="fa fa-eye"></i> cancel</a>
        </div>
        <div class="panel-body">
            <form method="post" action="" enctype="multipart/form-data">
            <div class="col-md-2">
              <div class="thumbnail">
                <img src="{{ URL::to('/') }}/uploads/employee/default_photos/{{ $employee->photo }}" alt="...">
              </div>
              <input type="file" class="form-control" name="photo">
            </div>
            <div class="col-md-10 form-horizontal">
                  <input type="hidden" name="id" value="{{ $employee->id }}"/>
                  <div class="form-group" id="form-group-workshift">
                    <label class="col-sm-2 control-label">Workshift</label>
                    <div class="col-sm-10">
                        <select id="select_workshift" class="form-control">
                        @foreach($workshifts as $index => $shift)
                            <option {{ ($employee->workshift_id == $shift->id) ? "selected" : "" }}  value="{{$shift->id}}" data-description="{{$shift->start_work_time}} - {{$shift->end_work_time}} on {{$shift->days}}">{{$shift->name}}</option>
                        @endforeach
                        </select>
                        <script>
                        $(function() { 
                            $('#select_workshift').ddslick( {
                                width:550, 
                                height:200,
                                onSelected: function(data) {
                                    $('input[name="workshift_id"]').val($('#select_workshift').data('ddslick').selectedData.value);
                                }
                            } ); 
                        });
                        </script>
                        <input type="hidden" name="workshift_id"/>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-idnumber-edit">
                    <label class="col-sm-2 control-label" for="name">ID Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="id_number" rel="tooltipidnumber-edit" placeholder="eg: ABC000001" value="{{ $employee->id_number }}">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-name-edit">
                    <label class="col-sm-2 control-label" for="name">Full Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" rel="tooltipidnumber-edit" placeholder="eg: ABC000001" value="{{ $employee->name }}">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-email-edit">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" rel="tooltipidnumber-edit" placeholder="eg: ABC000001" value="{{ $employee->email }}">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-birthdate-edit">
                    <label class="col-sm-2 control-label">Birthdate</label>
                    <div class="col-sm-10">
                      <div class="input-group date pull-right" id="birthdate-edit">
                         <input type="text" class="form-control" name="birthdate" data-format="YYYY-MM-DD" placeholder="Y-m-d" value="{{ $employee->birthdate }}"/>
                         <span class="input-group-addon" rel="tooltipbirthdate"><span class="glyphicon glyphicon-calendar"></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-address-edit">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="address" rows="4" rel="tooltipaddress">{{ $employee->email }}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="gender">
                            <option vaiue="male" {{ ($employee->gender == "male" ? "selected" : "") }}>male</option>
                            <option value="female" {{ ($employee->gender == "female" ? "selected" : "") }}>female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Marital Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="marital_status">
                            <option vaiue="single" {{ ($employee->marital_status == "single" ? "selected" : "") }}>single</option>
                            <option value="married" {{ ($employee->marital_status == "married" ? "selected" : "") }}>married</option>
                            <option value="divorce" {{ ($employee->marital_status == "divorce" ? "selected" : "") }}>divorce</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="employee_type_id">
                            @foreach($emptypes as $type)
                            <option value="{{$type->id}}" {{ ($employee->employee_type_id == $type->id ? "selected" : "") }}>{{$type->name}}</option>
                            @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Job Title</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="job_id">
                            @foreach($jobs as $job)
                            <option value="{{$job->id}}" {{ ($employee->job_id == $job->id ? "selected" : "") }}>{{$job->title}}</option>
                            @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-phone">
                    <label class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone" rel="tooltipidnumber-edit" placeholder="eg: ABC000001" value="{{ $employee->phone }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nationality</label>
                    <div class="col-sm-10">
                        <select class="" name="nation_id" id="nation_id" style="font-size: 12px; width: 100%;">
                            @foreach ($nations as $nation)
                            @if (isset($employee->nation->id))
                            <option value="{{ $nation->id }}" {{ ($nation->id == $employee->nation->id) ? "selected" : "" }}>{{ $nation->name }}</option>
                            @else
                            <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        <script>$('#nation_id').select2();</script>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-phone">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" value="Save changes">
                    </div>
                  </div>
            </div>
            </form>
        </div>
      </div>

@stop