@extends('layouts/backend-employee')

@section('content')

    @include('employee.profile.header-tab')
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Performance Review History
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
                    
                    <div class="tab-pane" id="salary"></div>
                    
                    <div class="tab-pane active" id="performance">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                KPI Job
                                <a href="{{ URL::to('employee/profile/performance') }}" title="view kpi list" class="pull-right btn btn-xs btn-default"><i class="fa fa-navicon"></i> KPI List</a>
                            </div>
                            <div class="panel-body">
                             
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
                                            <a href="{{ URL::to('employee/profile/kpi-result/'.$result->review_at) }}" title="performance result" class="btn btn-xs btn-primary btn-kpi-edit pull-right"><i class="fa fa-signal"></i></a>
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