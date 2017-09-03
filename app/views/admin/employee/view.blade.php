@extends('layouts/backend')

@section('content')

    @include('admin/employee/header-tab')

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            Employee Information
            <a href="#" title="delete" class="pull-right btn btn-xs btn-danger btn-edit" data-toggle="modal" data-target=".delete-confirm"><i class="fa fa-trash-o"></i> delete</a>
            <span class="pull-right">&nbsp;</span>
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
                  <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                    <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                    <li><a href="#contact" data-toggle="tab" id="tabContact">Contact</a></li>
                    <li><a href="#attendance" data-toggle="tab" id="tabAttendance">Attendance</a></li>
                    <li><a href="#qualification" data-toggle="tab" id="tabQualification">Qualification</a></li>
                    <li><a href="#salary" data-toggle="tab" id="tabSalary">Salary</a></li>
                    <li><a href="#login" data-toggle="tab" id="tabLogin">Login Credential</a></li>
                    <li><a href="#performance" data-toggle="tab" id="tabPerformance">Performance</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <div class="form-group" id="form-group-idnumber-edit">
                        <label class="col-sm-2 control-label" for="name">Workshift</label>
                        <div class="col-sm-10">
                            <?php if (isset($employee->workshift->name)): ?>
                            <label class="control-label" for="name"><strong>{{ isset($employee->workshift->name) ? $employee->workshift->name : "" }}</strong></label>                            
                            <?php endif; ?>
                        </div>
                      </div>
                      <?php if (isset($employee->workshift->name)): ?>
                      <div class="form-group" id="form-group-idnumber-edit">
                        <label class="col-sm-2 control-label" for="name"></label>
                        <div class="col-sm-10">      
                            <label class="control-label" for="name">{{ $employee->workshift->start_work_time }} - {{ $employee->workshift->end_work_time }} on {{ $employee->workshift->days }}</label>
                        </div>
                      </div>
                      <?php endif; ?>
                      <div class="form-group" id="form-group-idnumber-edit">
                        <label class="col-sm-2 control-label" for="name">ID Number</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->id_number }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group" id="form-group-name-edit">
                        <label class="col-sm-2 control-label" for="name">Full Name</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->name }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group" id="form-group-email-edit">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->email }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group" id="form-group-birthdate-edit">
                        <label class="col-sm-2 control-label">Birthdate</label>
                        <div class="col-sm-10">
                          <div class="input-group" id="birthdate-edit">
                             <label class="control-label" for="name"><strong>{{ $employee->birthdate }}</strong></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" id="form-group-address-edit">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->address }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->gender }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Marital Status</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->marital_status }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            @if (isset($employee->employeetype->id))
                            <label class="control-label" for="name"><strong>{{ $employee->employeetype->name }}</strong></label>
                            @endif
                            <!--<label class="control-label" for="name"><strong>{{ $employee->status }}</strong></label>-->
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Job Title</label>
                        <div class="col-sm-10">
                            @if (isset($employee->job->id))
                            <label class="control-label" for="name"><strong>{{ $employee->job->title }}</strong></label>
                            @endif
                            <!--<label class="control-label" for="name"><strong>{{ $employee->status }}</strong></label>-->
                        </div>
                      </div>
                      <div class="form-group" id="form-group-phone">
                        <label class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>{{ $employee->phone }}</strong></label>
                        </div>
                      </div>
                      <div class="form-group" id="form-group-phone">
                        <label class="col-sm-2 control-label">Nationality</label>
                        <div class="col-sm-10">
                            <label class="control-label" for="name"><strong>@if (isset($employee->nation->name)) {{ $employee->nation->name }} @endif</strong></label>
                        </div>
                      </div>
                    </div>
                      
                    <div class="tab-pane" id="contact"></div>
                      
                    <div class="tab-pane" id="attendance"></div>
                    
                    <div class="tab-pane" id="login"></div>
                    
                    <div class="tab-pane" id="qualification"></div>
                    
                    <div class="tab-pane" id="salary"></div>
                    
                    <div class="tab-pane" id="performance">
                        <div class="panel panel-primary">
                            <div class="panel-heading">List of Job KPI</div>
                            <div class="panel-body">
                              <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                  <thead>
                                    <tr>
                                      <th width="45%">#Key Performance Indicator </th>
                                      <th width="15%">#Min. Rate</th>
                                      <th width="15%">#Max. Rate</th>
                                      <th width="15%">#Real</th>
                                      <th width="10%"></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($kpi as $index => $kp)
                                  <tr>
                                      <td id="kpi_{{$kp->id}}">{{ $kp->name }}</td>
                                      <td>{{ $kp->minimum_rating }}</td>
                                      <td>{{ $kp->maximum_rating }}</td>
                                      <td></td>
                                      <td id="td_{{$kp->id}}" class="text-right">
                                          <input type="hidden" name="hid_id" value="{{ $kp->id }}"/>
                                          <input type="hidden" name="hid_name" value="{{ $kp->name }}"/>
                                          <input type="hidden" name="hid_minimum_rating" value="{{ $kp->minimum_rating }}"/>
                                          <input type="hidden" name="hid_maximum_rating" value="{{ $kp->maximum_rating }}"/>
                                          <input type="hidden" name="hid_job_id" value="{{ $kp->job_id }}"/>
                                          <input type="hidden" name="hid_kra_id" value="{{ $kp->kra_id }}"/>
                                          <a href="" title="quick edit" id="edit_{{$kp->id}}" class="btn btn-xs btn-success btn-kpi-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                                      </td>
                                  </tr>
                                  @endforeach
                                  </tbody>
                                </table>
                              </div>

                            </div>
                        </div>
                        
                        
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                Other KPI
                                <a href="#" title="add other kpi" id="btnAddOtherKpi" data-toggle="modal" data-target="#addOtherKpi" class="pull-right btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="panel-body">

                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop