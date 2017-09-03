@extends('layouts/backend-employee')

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
    
    @include('employee.profile.header-tab')
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Qualification
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
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane" id="profile"></div>
                    
                    <div class="tab-pane fade" id="contact"></div>
                      
                    <div class="tab-pane" id="attendance"></div>
                    
                    <div class="tab-pane" id="login"></div>
                    
                    <div class="tab-pane active fade in" id="qualification">
                        @include('employee.profile.tab-qualification')
                    </div>
                    
                    <div class="tab-pane" id="salary"></div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop