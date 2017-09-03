@extends('layouts/backend-employee')

@section('content')

    @include('employee.profile.header-tab')
    
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            My Performance Result
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
                                KPI Job Result
                                <a href="{{ URL::to('employee/profile/kpi-history') }}" title="view kpi history" class="pull-right btn btn-xs btn-default"><i class="fa fa-navicon"></i> Review History</a>
                                <span class="pull-right">&nbsp;</span>
                                <a href="{{ URL::to('employee/profile/performance') }}" title="kpi list" class="pull-right btn btn-xs btn-default"><i class="fa fa-times"></i> KPI List</a>
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
                            
                                <form method="post" action="{{ URL::to('admin/employee/edit-kpi-review') }}">
                                <div class="form-group" id="form-group-minimum_rating">
                                    <label class="col-sm-1 control-label text-left" for="reviewer_id">Reviewer</label>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-7">
                                        <input type="hidden" class="bigdrop" id="reviewer_id" name="reviewer_id" value="{{ $kpi_reviews[0]->reviewer_id }}"/>
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
                                                
                                                initSelection : function (element, callback) {
                                                    var data = {id: '{{ $kpi_reviews[0]->reviewer_id }}', name: '{{ $kpi_reviews[0]->reviewer->name }}'};
                                                    callback(data);
                                                },
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
                                      <th class="text-right" width="10%">#Weight</th>
                                      <th class="text-right" width="10%">#Target</th>
                                      <th class="text-right" width="10%">#Real</th>
                                      <th class="text-right" width="10%">#Score</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php $total_score = 0; ?>
                                  @foreach($kpi_reviews as $index => $kp)
                                  <tr>
                                      <td>{{ $kp->kpi->name }}</td>
                                      <td class="text-right">{{ $kp->weight }}</td>
                                      <td class="text-right">{{ $kp->target }}</td>
                                      <td class="text-right">{{ $kp->realization }}</td>
                                      <?php 
                                      $score = ($kp->realization / $kp->target) * $kp->weight; 
                                      $total_score += $score;
                                      ?>
                                      <td class="text-right">{{ number_format($score, 2, '.', '') }}</td>
                                  </tr>
                                  @endforeach
                                  <tr>
                                      <td class="text-right" colspan="4"><strong>Total KPI</strong></td>
                                      <td class="text-right"><strong>{{ number_format($total_score, 2, '.', '') }}</strong></td>
                                  </tr>
                                  </tbody>
                                </table>
                                <input type="hidden" name="employee_id" value="{{ $employee->id }}"/>
                                <input type="hidden" name="review_at" value="{{ $kpi_reviews[0]->review_at }}"
                                </form>
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