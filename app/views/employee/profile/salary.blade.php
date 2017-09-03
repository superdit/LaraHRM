@extends('layouts/backend-employee')

@section('content')
    
    @if (Session::has('add_empsalcomp_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Salary Component added.
    </div>
    @endif
    
    @if (Session::has('add_empsaldeduc_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Salary Deduction added.
    </div>
    @endif
    
    @if (Session::has('delete_empsalcomp_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Salary Component deleted.
    </div>
    @endif
    
    @if (Session::has('delete_empsaldeduc_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee Salary Deduction deleted.
    </div>
    @endif

    @include('employee.profile.header-tab')
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Salary
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
                  @include('employee.profile.header-tab-list')
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane" id="profile"></div>
                    
                    <div class="tab-pane" id="contact"></div>
                      
                    <div class="tab-pane" id="attendance"></div>
                    
                    <div class="tab-pane" id="login"></div>
                    
                    <div class="tab-pane" id="qualification"></div>
                    
                    <div class="tab-pane active" id="salary">
                        @include('employee.profile.tab-salary')
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop