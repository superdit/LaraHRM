@extends('layouts/backend-employee')

@section('content')
    
    @if (Session::has('edit_user_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Credential updated.
    </div>
    @endif
    
    @include('employee.profile.header-tab')
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Login Credential
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
                  @include('employee.profile.header-tab-list')
                  <div class="tab-content">
                    <div class="tab-pane" id="profile"></div>
                    
                    <div class="tab-pane" id="contact"></div>
                      
                    <div class="tab-pane" id="attendance"></div>
                    
                    <div class="tab-pane active fade in" id="login">
                        @include('employee.profile.tab-login')
                    </div>
                    
                    <div class="tab-pane" id="qualification"></div>
                    
                    <div class="tab-pane" id="salary"></div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop