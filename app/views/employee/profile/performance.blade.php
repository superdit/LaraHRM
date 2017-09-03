@extends('layouts/backend-employee')

@section('content')

    @include('employee.profile.header-tab')    
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My KPI Performance
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
                                <a href="{{ URL::to('employee/profile/kpi-history') }}" title="view kpi history" class="pull-right btn btn-xs btn-default"><i class="fa fa-navicon"></i> Review History</a>
                            </div>
                            <div class="panel-body">
                              @if (Session::has('add_kpireview_success'))
                              <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Success!</strong> KPI Review Added
                              </div>
                              @endif
                              <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                  <thead>
                                    <tr>
                                      <th width="70%">#Key Performance Indicator </th>
                                      <th width="15%">#Weight</th>
                                      <th width="15%">#Target</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($kpi as $index => $kp)
                                  <tr>
                                      <td id="kpi_{{$kp->id}}">{{ $kp->name }}</td>
                                      <td>{{ $kp->default_weight }}</td>
                                      <td>{{ $kp->default_target }}</td>
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