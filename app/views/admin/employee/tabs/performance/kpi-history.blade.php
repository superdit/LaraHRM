@extends('layouts/backend')

@section('content')

    <script>
    $(function() {             

    });
    </script>

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
                    <li><a href="#qualification" data-toggle="tab" id="tabQualification">Qualification</a></li>
                    <li><a href="#salary" data-toggle="tab" id="tabSalary">Salary</a></li>
                    <li><a href="#login" data-toggle="tab" id="tabLogin">Login Credential</a></li>
                    <li class="active"><a href="#performance" data-toggle="tab" id="tabPerformance">Performance</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane" id="profile"></div>
                      
                    <div class="tab-pane" id="contact"></div>
                      
                    <div class="tab-pane" id="attendance"></div>
                    
                    <div class="tab-pane" id="login"></div>
                    
                    <div class="tab-pane" id="qualification"></div>
                    
                    <div class="tab-pane" id="salary"></div>
                    
                    <div class="tab-pane active" id="performance">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                KPI Job
                                <a href="{{ URL::to('admin/employee/performance/'.$employee->id) }}" title="view kpi list" class="pull-right btn btn-xs btn-default"><i class="fa fa-navicon"></i> KPI List</a>
                                <span class="pull-right">&nbsp;</span>
                                <a href="{{ URL::to('admin/employee/add-kpi-review/'.$employee->id) }}" title="add kpi review" class="pull-right btn btn-xs btn-default"><i class="fa fa-plus"></i> Add Review</a>
                            </div>
                            <div class="panel-body">
                              @if (Session::has('add_kpireview_success'))
                              <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Success!</strong> KPI Review Added
                              </div>
                              @endif
                                
                              @if (Session::has('edit_kpireview_success'))
                              <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Success!</strong> KPI Review Updated
                              </div>
                              @endif
                              
                              @if (Session::has('delete_kpireview_success'))
                              <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Success!</strong> KPI Review Deleted
                              </div>
                              @endif
                              <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                  <thead>
                                    <tr>
                                      <th width="60%">#Reviewer </th>
                                      <th width="25%">#Reviewed at</th>
                                      <th width="15%"></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($kpi_results as $result)
                                    <tr>
                                        <td>@if (isset($result->reviewer->name)) {{ $result->reviewer->name }} @endif</td>
                                        <td>{{ $result->review_at }}</td>
                                        <td>
                                            <a href="{{ URL::to('admin/employee/delete-kpi-review/'.$employee->id.'/'.$result->review_at) }}" title="delete" class="btn btn-xs btn-danger btn-kpi-delete pull-right"><i class="fa fa-trash-o"></i></a>
                                            <div class="pull-right">&nbsp;</div>
                                            <a href="{{ URL::to('admin/employee/edit-kpi-review/'.$employee->id.'/'.$result->review_at) }}" title="quick edit" class="btn btn-xs btn-success btn-kpi-edit pull-right"><i class="fa fa-edit"></i></a>
                                            <div class="pull-right">&nbsp;</div>
                                            <a href="{{ URL::to('admin/employee/kpi-result/'.$employee->id.'/'.$result->review_at) }}" title="performance result" class="btn btn-xs btn-primary btn-kpi-edit pull-right"><i class="fa fa-signal"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>

                            </div>
                        </div>
                        
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop