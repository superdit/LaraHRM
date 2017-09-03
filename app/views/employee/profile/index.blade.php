@extends('layouts/backend-employee')

@section('content')

    @include('employee/profile/header-tab')

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Profile
            <a href="{{ URL::to('employee/profile/edit') }}" title="edit employee" class="pull-right btn btn-xs btn-primary btn-edit"><i class="fa fa-pencil"></i> edit</a>
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
                    
                    <div class="tab-pane" id="performance"></div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop