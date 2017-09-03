@extends('layouts/backend')

@section('content')

    <script>
        $(function() {             
            // Event search click
            $('#btn-search').click(function(e) {
                var key = $('input[name="key"]').val();
                if (key.length > 0) {
                    window.location = '{{URL::to("admin/employee/search")}}/'+key;
                } else {
                    window.location = '{{URL::to("admin/employee")}}';
                }
            });
            
            $('input[name="key"]').keypress(function(e) {
                var code = e.keyCode || e.which;
                if(code == 13) {
                    var key = $('input[name="key"]').val();
                    if (key.length > 0) {
                        window.location = '{{URL::to("admin/employee/search")}}/'+key;
                    } else {
                        window.location = '{{URL::to("admin/employee")}}';
                    }
                }
            });
            
            $('#tabProfile').click(function() {
                window.location = '{{ URL::to("admin/employee/view")}}/{{$employee->id}}';
            });
            
            $('#tabContact').click(function() {
                window.location = '{{ URL::to("admin/employee/contact")}}/{{$employee->id}}';
            });
            
            $('#tabAttendance').click(function() {
                window.location = '{{ URL::to("admin/employee/attendance")}}/{{$employee->id}}';
            });
            
            $('#tabQualification').click(function() {
                window.location = '{{ URL::to("admin/employee/qualification")}}/{{$employee->id}}';
            });
            
            $('#tabSalary').click(function() {
                window.location = '{{ URL::to("admin/employee/salary")}}/{{$employee->id}}';
            });
            
            $('#tabLogin').click(function() {
                window.location = '{{ URL::to("admin/employee/login")}}/{{$employee->id}}';
            });            
            
//            $('#tabPerformance').click(function() {
//                window.location = '{{ URL::to("admin/employee/performance")}}/{{$employee->id}}';
//            });  

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

    </script>
    
<!--    @if (Session::has('edit_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> Employee updated.
    </div>
    @endif-->
    
    @if (Session::has('add_empkpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KPI added.
    </div>
    @endif

    <h1 class="page-header">Details Employee</h1>
    
    <div class="col-lg-9" style="padding-left: 0;">
        <a href="{{ URL::to('admin/employee') }}" type="button" title="back to employee list" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i></a>
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New Employee</button>
    </div>
    
    <div class="col-lg-3" style="padding-right: 0;">
        <div class="input-group pull-right">
            <input type="text" class="form-control" placeholder="quick search..." name="key" value="{{ (isset($key) ? $key : ''); }}">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
            </span>
        </div>
    </div>

    <br/>
    
    <br/><br/>
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
                    <style>
                        #tbl-kpi-review td { vertical-align: middle; }
                        .select2style { font-size: 12px; }
                        .bigdrop.select2-container .select2-results {max-height: 300px;font-size: 12px;}
                        .bigdrop .select2-results {max-height: 300px;font-size: 12px;}
                        
                        .employee-result td {vertical-align: top }
                        .employee-image { width: 60px; }
                        .employee-image img { height: 80px; width: 60px;  }
                        .employee-info { padding-left: 10px; vertical-align: top; }
                        .employee-title { font-size: 1.2em; padding-bottom: 15px; }
                        .employee-synopsis { font-size: .8em; color: #888; }
                    </style>
                    <div class="tab-pane active" id="performance">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                KPI Job Review
                                <a href="{{ URL::to('admin/employee/edit-kpi/'.$employee->id) }}" title="edit kpi" class="pull-right btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit KPI</a>
                                <span class="pull-right">&nbsp;</span>
                                <a href="{{ URL::to('admin/employee/kpi-history/'.$employee->id) }}" title="view kpi history" class="pull-right btn btn-xs btn-default"><i class="fa fa-navicon"></i> Review History</a>
                                <span class="pull-right">&nbsp;</span>
                                <a href="{{ URL::to('admin/employee/performance/'.$employee->id) }}" title="cancel kpi review" class="pull-right btn btn-xs btn-default"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                            <div class="panel-body">
                              <div class="table-responsive">
                            
                                <?php $fail = FALSE; ?>
                                @if (Session::has('add_kpireview_failed'))
                                <?php $fail = TRUE; ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Something not correct!</strong> Please check
                                    <br/>- #Real field must be filled and numeric
                                    <br/>- #Reviewer be filled
                                </div>
                                @endif
                            
                                <form method="post" action="{{ URL::to('admin/employee/add-kpi-review') }}">
                                <div class="form-group" id="form-group-minimum_rating">
                                    <label class="col-sm-1 control-label text-left" for="reviewer_id">Reviewer</label>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-7">
                                        <input type="hidden" class="bigdrop" id="reviewer_id" name="reviewer_id"/>
                                        <script>          
                                            function employeeFormatResult(employee) {
                                                var markup = "<table class='employee-result'><tr>";
//                                                if (movie.posters !== undefined && movie.posters.thumbnail !== undefined) {
                                                    markup += "<td class='employee-image'><img src='{{ URL::to('/') }}/uploads/employee/default_photos/" + employee.photo + "'/></td>";
//                                                }
                                                markup += "<td class='employee-info'><div class='employee-title'>" + employee.name + "</div>";
//                                                else if (movie.synopsis !== undefined) {
//                                                    markup += "<div class='employee-synopsis'>" + movie.synopsis + "</div>";
//                                                }
                                                markup += "</td></tr></table>";
                                                return markup;
                                            }

                                            function employeeFormatSelection(employee) {
                                                return employee.name;
                                            }
                                            $('#reviewer_id').select2({
                                                width: 400,
                                                containerCssClass: 'select2style',
                                                //dropdownCssClass: 'select2style',
                                                formatResult: employeeFormatResult, // omitted for brevity, see the source of this page
                                                formatSelection: employeeFormatSelection, // omitted for brevity, see the source of this page
                                                dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
                                                escapeMarkup: function (m) { return m; }, // we do not want to escape markup since we are displaying html in results
                                                placeholder: 'Search for an employee',
                                                minimumInputLength: 3,
                                                ajax: {
                                                    //url: "http://api.rottentomatoes.com/api/public/v1.0/movies.json",
                                                    url: "http://localhost:8888/employee/public/api/employee/search",
                                                    dataType: 'jsonp',
                                                    quietMillis: 100,
                                                    data: function (term, page) { // page is the one-based page number tracked by Select2
                                                        return {
                                                            q: term, //search term
                                                            page_limit: 10, // page size
                                                            page: page, // page number
                                                            //apikey: "33twy6rr6x8t2xrrjpmwh76j" // please do not use so this example keeps working
                                                        };
                                                    },
                                                    results: function (data, page) {
                                                        var more = (page * 10) < data.total; // whether or not there are more results available

                                                        // notice we return the value of more so Select2 knows if more results can be loaded
                                                        return {results: data.employees, more: more};
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                                <table id="tbl-kpi-review" class="table table-striped table-hover">
                                  <thead>
                                    <tr>
                                      <th width="60%">#Key Performance Indicator </th>
                                      <th width="15%">#Weight</th>
                                      <th width="15%">#Target</th>
                                      <th width="10%">#Real</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($kpi as $index => $kp)
                                  <tr>
                                      <td id="kpi_{{$kp->id}}">
                                          <input type="hidden" name="kpi_id[]" value="{{ $kp->id }}" />
                                          <strong>{{ $kp->name }}</strong>
                                      </td>
                                      <td>
                                          <input type="hidden" name="weight[]" value="{{ $kp->default_weight }}"/>
                                          {{ $kp->default_weight }}
                                      </td>
                                      <td>
                                          <input type="hidden" name="target[]" value="{{ $kp->default_target }}"/>
                                          {{ $kp->default_target }}
                                      </td>
                                      <td><input type="text" name="realization[]" class="form-control" @if($fail) value="{{ $input_values['realization'][$index] }}" @endif/></td>
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
                                  <tr>
                                      <td class="text-right">Comment</td>
                                      <td colspan="3"><textarea rows="3" class="form-control" name="note[]">@if($fail) {{ $input_values['note'][$index] }} @endif</textarea></td>
                                  </tr>
                                  @endforeach
                                  </tbody>
                                </table>
                                <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
                                <div>
                                    <a href="{{ URL::to('admin/employee/performance/'.$employee->id) }}" class="btn btn-default btn-sm">Cancel</a>
                                    <input type="submit" class="btn btn-primary btn-sm" value="Save changes">
                                </div>
                                </form>
                              </div>

                            </div>
                        </div>
                        
                        
<!--                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                Other KPI
                                <a href="#" title="review all other kpi" id="btnAddOtherKpi" class="pull-right btn btn-xs btn-default"><i class="fa fa-edit"></i></a>
                                <span class="pull-right">&nbsp;</span>
                                <a href="#" title="add other kpi" id="btnAddOtherKpi" data-toggle="modal" data-target="#addOtherKpi" class="pull-right btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
                            </div>
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
                                  @foreach($employee->kpi as $index => $kp)
                                  <tr>
                                      <td id="empkpi_{{$kp->id}}">{{ $kp->name }}</td>
                                      <td>{{ $kp->minimum_rating }}</td>
                                      <td>{{ $kp->maximum_rating }}</td>
                                      <td></td>
                                      <td id="td_emkpi_{{$kp->id}}" class="text-right">
                                          <input type="hidden" name="hid_id" value="{{ $kp->id }}"/>
                                          <input type="hidden" name="hid_name" value="{{ $kp->name }}"/>
                                          <input type="hidden" name="hid_minimum_rating" value="{{ $kp->minimum_rating }}"/>
                                          <input type="hidden" name="hid_maximum_rating" value="{{ $kp->maximum_rating }}"/>
                                          <input type="hidden" name="hid_job_id" value="{{ $kp->job_id }}"/>
                                          <input type="hidden" name="hid_kra_id" value="{{ $kp->kra_id }}"/>
                                          <a href="" id="edit_empkpi_{{$kp->id}}" title="write review" id="edit_empkpi_{{$kp->id}}" class="btn btn-xs btn-success btn-empkpi-edit" data-toggle="modal" data-target="#reviewModalKpi"><i class="fa fa-edit"></i></a>
                                          <a href="" title="delete kpi from employee" id="del_empkpi_{{$kp->id}}" class="btn btn-xs btn-danger btn-empkpi-del" data-toggle="modal" data-target="#delModalKpi"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                  </tr>
                                  @endforeach
                                  </tbody>
                                </table>
                              </div>

                            </div>
                            </div>
                        </div>-->
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

@stop