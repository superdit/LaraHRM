@extends('layouts/backend')

@section('content')

    <script>
        $(function() {             
           
            // Event on show delete modal confirmation
            $('.btn-empkpi-del').click(function() {
                var tmp_id = $(this).attr('id').replace("del_empkpi_", "");
                var tmp_name = $('#td_emkpi_' + tmp_id + ' input[name="hid_name"]').val();
                var html = '<h4 style="text-align:center;font-weight:bold;">Delete this KPI: "'+tmp_name+'" ?</h4>';
                $('#modal-del-content-kpi').html(html);

                $('#btn-do-delete-kpi').attr('href', '{{URL::to("admin/performance/delete-kpi-from-employee")}}/'+tmp_id+'/{{$employee->id}}');
            });

            // Event on show edit modal confirmation
            $('.btn-empkpi-edit').click(function() {
                var tmp_id = $(this).attr('id').replace("edit_empkpi_", "");
                var tmp_name = $('#td_emkpi_' + tmp_id + ' input[name="hid_name"]').val();
                var tmp_minimum = $('#td_emkpi_' + tmp_id + ' input[name="hid_minimum_rating"]').val();
                var tmp_maximum = $('#td_emkpi_' + tmp_id + ' input[name="hid_maximum_rating"]').val();

                setTimeout(function() {
                    $('#reviewModalKpi input[name="id"]').val(tmp_id);
                    $('#reviewModalKpi select[name="kpi_id"]').val(tmp_id);
                    $('#reviewModalKpi input[name="minimum_rating"]').val(tmp_minimum);
                    $('#reviewModalKpi input[name="maximum_rating"]').val(tmp_maximum);

                    $("[rel='tooltipname-kra-edit']").tooltip('destroy');
                    $('#form-group-name-kra-edit').removeClass('has-error');
                }, 500);

            });
        });
        var arrKpi = new Array(); 
        var tempKpi;
        @foreach ($allkpi as $index => $kp)
        tempKpi = {id:"{{$kp->id}}", kra_id: "{{$kp->kra_id}}", job_id: "{{$kp->job_id}}", name:"{{$kp->name}}", minimum_rating:"{{$kp->minimum_rating}}", maximum_rating:"{{$kp->maximum_rating}}"};
        arrKpi[{{$kp->id}}] = tempKpi;
        @endforeach
    </script>
    
    
    @if (Session::has('add_empkpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KPI added.
    </div>
    @endif

    @include('admin/employee/header-tab')
    
    <!-- Add Kpi modal -->
    <div class="modal fade" id="addOtherKpi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form role="form" class="form-horizontal" action="{{URL::to('admin/performance/add-kpi-to-employee')}}" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Other KPI</h4>
            </div>
            <div class="modal-body" id="modal-del-content">
                <input name="employee_id" type="hidden" value="{{ $employee->id }}"/>
                <div class="form-group" id="form-group-kpi_id">
                  <label class="col-sm-3 control-label" for="name">KPI</label>
                  <div class="col-sm-9">
                    <select name="kpi_id" id="select_kpi" style="font-size: 12px; width: 100%;">
                        @foreach($allkpi as $kp)
                        <option value="{{$kp->id}}">{{ $kp->name }}</option>
                        @endforeach
                    </select>
                    <style>.select2style { font-size: 12px; }</style>
                    <script>                            
                        $('#select_kpi').select2({
                            containerCssClass: 'select2style',
                            dropdownCssClass: 'select2style'
                        }).on("change", function(e) {

                            var kpi = arrKpi[$('#select_kpi').select2('val')];
                            $('#job_id').val(kpi.job_id);
                            $('#kra_id').val(kpi.kra_id);
                            $('#minimum_rating').val(kpi.minimum_rating);
                            $('#maximum_rating').val(kpi.maximum_rating);
                        });
                    </script>
                  </div>
                </div>
                <div class="form-group" id="form-group-name">
                    <label class="col-sm-3 control-label" for="name"></label>
                    <div class="col-sm-9">
                        <small><strong>KPI Information</strong></small>
                    </div>
                </div>
                <div class="form-group" id="form-group-job_id">
                  <label class="col-sm-3 control-label" for="name">Job Title</label>
                  <div class="col-sm-9">
                    <select name="job_id" class="form-control" id="job_id" disabled>
                        <option value="0">-- None --</option>
                        @foreach($jobs as $job)
                        <option value="{{$job->id}}">{{ $job->title }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group" id="form-group-kra_id">
                  <label class="col-sm-3 control-label" for="name">KRA</label>
                  <div class="col-sm-9">
                    <select name="kra_id" class="form-control" id="kra_id" disabled>
                        @foreach($kra as $kr)
                        <option value="{{$kr->id}}">{{ $kr->name }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group" id="form-group-minimum_rating">
                  <label class="col-sm-3 control-label" for="minimum_rating">Minimum Rating</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="minimum_rating" disabled/>
                  </div>
                </div>
                <div class="form-group" id="form-group-maximum_rating">
                  <label class="col-sm-3 control-label" for="maximum_rating">Maximum Rating</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="maximum_rating" disabled/>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <input type="submit" class="btn btn-primary" value="Save changes">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Add Kpi confirmation modal -->
     
    <!-- Delete Confirmation modal -->
    <div class="modal fade" id="delModalKpi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">KPI Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content-kpi">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="" id="btn-do-delete-kpi" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Delete Confirmation modal -->
     
     <!-- Review Kpi modal -->
    <div class="modal fade" id="reviewModalKpi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form role="form" class="form-horizontal" action="{{URL::to('admin/performance/write-kpi-review')}}" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Write KPI Review</h4>
            </div>
            <div class="modal-body" id="modal-del-content">
                <input type="hidden" name="id"/>
                <input name="employee_id" type="hidden" value="{{ $employee->id }}"/>
                <div class="form-group" id="form-group-name">
                    <label class="col-sm-3 control-label" for="name"></label>
                    <div class="col-sm-9">
                        <small><strong>KPI Information</strong></small>
                    </div>
                </div>
                <div class="form-group" id="form-group-kpi_id">
                  <label class="col-sm-3 control-label" for="name">KPI</label>
                  <div class="col-sm-9">
                    <select name="kpi_id" class="form-control" disabled="">
                        @foreach($allkpi as $kp)
                        <option value="{{$kp->id}}">{{ $kp->name }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group" id="form-group-minimum_rating">
                  <label class="col-sm-3 control-label" for="minimum_rating">Minimum Rating</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="minimum_rating" disabled/>
                  </div>
                </div>
                <div class="form-group" id="form-group-maximum_rating">
                  <label class="col-sm-3 control-label" for="maximum_rating">Maximum Rating</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="maximum_rating" disabled/>
                  </div>
                </div>
                <div class="form-group" id="form-group-name">
                    <label class="col-sm-3 control-label" for="name"></label>
                    <div class="col-sm-9">
                        <small><strong>KPI Review</strong></small>
                    </div>
                </div>
                <div class="form-group" id="form-group-real">
                  <label class="col-sm-3 control-label" for="real">Real Rating</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="real" name="real"/>
                  </div>
                </div>
                <div class="form-group" id="form-group-note">
                  <label class="col-sm-3 control-label" for="real">Note</label>
                  <div class="col-sm-9">
                      <textarea class="form-control" rows="5" name="note"></textarea>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <input type="submit" class="btn btn-primary" value="Save changes">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Review Kpi modal -->
    
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
                                <a href="{{ URL::to('admin/employee/kpi-history/'.$employee->id) }}" title="view kpi history" class="pull-right btn btn-xs btn-default"><i class="fa fa-navicon"></i> Review History</a>
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
<!--                                      <td id="td_{{$kp->id}}" class="text-right">
                                          <input type="hidden" name="hid_id" value="{{ $kp->id }}"/>
                                          <input type="hidden" name="hid_name" value="{{ $kp->name }}"/>
                                          <input type="hidden" name="hid_minimum_rating" value="{{ $kp->minimum_rating }}"/>
                                          <input type="hidden" name="hid_maximum_rating" value="{{ $kp->maximum_rating }}"/>
                                          <input type="hidden" name="hid_job_id" value="{{ $kp->job_id }}"/>
                                          <input type="hidden" name="hid_kra_id" value="{{ $kp->kra_id }}"/>
                                          <a href="" title="quick edit" id="edit_{{$kp->id}}" class="btn btn-xs btn-success btn-kpi-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                                      </td>-->
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