@extends('layouts/backend')

@section('content')
    
    @if (Session::has('add_workexp_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Work Experience added.
    </div>
    @endif
    
    @if (Session::has('add_education_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Education added.
    </div>
    @endif
    
    @if (Session::has('add_skill_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Skill added.
    </div>
    @endif
    
    @if (Session::has('edit_workexp_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Work Experience updated.
    </div>
    @endif
    
    @if (Session::has('edit_education_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Education updated.
    </div>
    @endif
    
    @if (Session::has('edit_skill_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Skill updated.
    </div>
    @endif
    
    @if (Session::has('delete_workexp_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Work Experience deleted.
    </div>
    @endif
    
    @if (Session::has('delete_education_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Education deleted.
    </div>
    @endif

    @if (Session::has('delete_skill_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Skill deleted.
    </div>
    @endif
    
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
                    <li><a href="#profile" data-toggle="tab" id="tabProfile">Profile</a></li>
                    <li><a href="#contact" data-toggle="tab" id="tabContact">Contact</a></li>
                    <li><a href="#attendance" data-toggle="tab" id="tabAttendance">Attendance</a></li>
                    <li class="active"><a href="#qualification" data-toggle="tab" id="tabQualification">Qualification</a></li>
                    <li><a href="#salary" data-toggle="tab" id="tabSalary">Salary</a></li>
                    <li><a href="#login" data-toggle="tab" id="tabLogin">Login Credential</a></li>
                    <li><a href="#performance" data-toggle="tab" id="tabPerformance">Performance</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane" id="profile"></div>
                    
                    <div class="tab-pane fade" id="contact"></div>
                      
                    <div class="tab-pane" id="attendance"></div>
                    
                    <div class="tab-pane" id="login"></div>
                    
                    <div class="tab-pane active fade in" id="qualification">
                        @include('admin.employee.tabqualification')
                    </div>
                    
                    <div class="tab-pane" id="salary"></div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop