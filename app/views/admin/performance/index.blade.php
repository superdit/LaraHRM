<style>
    .tooltip-inner {
        white-space: nowrap;
        max-width: 350px;
    }
    .search-icon {
        -webkit-transform: rotate(90deg);     /* Chrome and other webkit browsers */
        -moz-transform: rotate(90deg);        /* FF */
        -o-transform: rotate(90deg);          /* Opera */
        -ms-transform: rotate(90deg);         /* IE9 */
        transform: rotate(90deg); 
    }
    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }
    .tabs-below > .nav-tabs,
    .tabs-right > .nav-tabs,
    .tabs-left > .nav-tabs {
      border-bottom: 0;
    }

    .tab-content > .tab-pane,
    .pill-content > .pill-pane {
      display: none;
    }

    .tab-content > .active,
    .pill-content > .active {
      display: block;
    }

    .tabs-below > .nav-tabs {
      border-top: 1px solid #ddd;
    }

    .tabs-below > .nav-tabs > li {
      margin-top: -1px;
      margin-bottom: 0;
    }

    .tabs-below > .nav-tabs > li > a {
/*      -webkit-border-radius: 0 0 4px 4px;
         -moz-border-radius: 0 0 4px 4px;
              border-radius: 0 0 4px 4px;*/
    }

    .tabs-below > .nav-tabs > li > a:hover,
    .tabs-below > .nav-tabs > li > a:focus {
      border-top-color: #ddd;
      border-bottom-color: transparent;
    }

    .tabs-below > .nav-tabs > .active > a,
    .tabs-below > .nav-tabs > .active > a:hover,
    .tabs-below > .nav-tabs > .active > a:focus {
      border-color: transparent #ddd #ddd #ddd;
    }

    .tabs-left > .nav-tabs > li,
    .tabs-right > .nav-tabs > li {
      float: none;
    }

    .tabs-left > .nav-tabs > li > a,
    .tabs-right > .nav-tabs > li > a {
      min-width: 74px;
      margin-right: 0;
      margin-bottom: 3px;
    }

    .tabs-left > .nav-tabs {
      float: left;
      margin-right: 19px;
      border-right: 1px solid #ddd;
    }

    .tabs-left > .nav-tabs > li > a {
      margin-right: -1px;
/*      -webkit-border-radius: 4px 0 0 4px;
         -moz-border-radius: 4px 0 0 4px;
              border-radius: 4px 0 0 4px;*/
    }

    .tabs-left > .nav-tabs > li > a:hover,
    .tabs-left > .nav-tabs > li > a:focus {
      border-color: #eeeeee #dddddd #eeeeee #eeeeee;
    }

    .tabs-left > .nav-tabs .active > a,
    .tabs-left > .nav-tabs .active > a:hover,
    .tabs-left > .nav-tabs .active > a:focus {
      border-color: #ddd transparent #ddd #ddd;
      *border-right-color: #ffffff;
    }

    .tabs-right > .nav-tabs {
      float: right;
      margin-left: 19px;
      border-left: 1px solid #ddd;
    }

    .tabs-right > .nav-tabs > li > a {
      margin-left: -1px;
/*      -webkit-border-radius: 0 4px 4px 0;
         -moz-border-radius: 0 4px 4px 0;
              border-radius: 0 4px 4px 0;*/
    }

    .tabs-right > .nav-tabs > li > a:hover,
    .tabs-right > .nav-tabs > li > a:focus {
      border-color: #eeeeee #eeeeee #eeeeee #dddddd;
    }

    .tabs-right > .nav-tabs .active > a,
    .tabs-right > .nav-tabs .active > a:hover,
    .tabs-right > .nav-tabs .active > a:focus {
      border-color: #ddd #ddd #ddd transparent;
      *border-left-color: #ffffff;
    }
    
    .select2style { font-size: 12px; }
</style>
    <script>
    $(function() {
        @if (Session::has('add_kpi_failed'))
        $('#addModal').modal('show');
        $('#addModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name').addClass('has-error');
            @endif
            $('#addModal textarea[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('maximum_rating') != "")
            $("[rel='tooltipmaximum_rating']").tooltip({placement: 'right', title: '{{$error_messages->first('maximum_rating')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-maximum_rating').addClass('has-error');
            @endif
            $('#addModal input[name="maximum_rating"]').val('{{$input_values['maximum_rating']}}');
            
            @if (isset($error_messages) && $error_messages->first('minimum_rating') != "")
            $("[rel='tooltipminimum_rating']").tooltip({placement: 'right', title: '{{$error_messages->first('minimum_rating')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-minimum_rating').addClass('has-error');
            @endif
            $('#addModal input[name="minimum_rating"]').val('{{$input_values['minimum_rating']}}');
            
            $('#addModal select[name="kra_id"]').val('{{$input_values['kra_id']}}');
        });            
        @endif
        
        @if (Session::has('edit_kpi_failed'))
        $('#editModal').modal('show');
        $('#editModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-edit').addClass('has-error');
            @endif
            $('#editModal textarea[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('maximum_rating') != "")
            $("[rel='tooltipmaximum_rating-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('maximum_rating')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-maximum_rating-edit').addClass('has-error');
            @endif
            $('#editModal input[name="maximum_rating"]').val('{{$input_values['maximum_rating']}}');
            
            @if (isset($error_messages) && $error_messages->first('minimum_rating') != "")
            $("[rel='tooltipminimum_rating-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('minimum_rating')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-minimum_rating-edit').addClass('has-error');
            @endif
            $('#editModal input[name="minimum_rating"]').val('{{$input_values['minimum_rating']}}');
            
            $('#editModal input[name="id"]').val('{{$input_values['id']}}');
            $('#editModal select[name="kra_id"]').val('{{$input_values['kra_id']}}');
        });            
        @endif
        
        // Event on show delete modal confirmation
        $('.btn-kpi-del').click(function() {
            var tmp_id = $(this).attr('id').replace("del_", "");
            var kpi_name = $('#kpi_'+tmp_id).html();
            var html = '<h4 style="text-align:center;font-weight:bold;">Delete this KPI: "'+kpi_name+'" ?</h4>';
            $('#modal-del-content').html(html);

            $('#btn-do-delete').attr('href', '{{URL::to("admin/performance/delete-kpi")}}/'+tmp_id);
        });
        
        // Event on show edit modal confirmation
        $('.btn-kpi-edit').click(function() {
            var tmp_id = $(this).attr('id').replace("edit_", "");
            var tmp_name = $('#td_' + tmp_id + ' input[name="hid_name"]').val();
            var tmp_min_rate = $('#td_' + tmp_id + ' input[name="hid_minimum_rating"]').val();
            var tmp_max_rate = $('#td_' + tmp_id + ' input[name="hid_maximum_rating"]').val();
            var tmp_job_id = $('#td_' + tmp_id + ' input[name="hid_job_id"]').val();
            var tmp_kra_id = $('#td_' + tmp_id + ' input[name="hid_kra_id"]').val();
            
            setTimeout(function() {
                $('#editModal textarea[name="name"]').val(tmp_name);
                $('#editModal input[name="minimum_rating"]').val(tmp_min_rate);
                $('#editModal input[name="maximum_rating"]').val(tmp_max_rate);
                $('#editModal input[name="id"]').val(tmp_id);
                if (tmp_job_id == 0) {
                    $('#editModal select[name="job_id"]').val($('#editModal select[name="job_id"] option:first').val());
                } else {
                    $('#editModal select[name="job_id"]').val(tmp_job_id);
                }
                
                if (tmp_kra_id == 0) {
                    $('#editModal select[name="kra_id"]').val($('#editModal select[name="kra_id"] option:first').val());
                } else {
                    $('#editModal select[name="kra_id"]').val(tmp_kra_id);
                }
                
                $("[rel='tooltipmaximum_rating-edit'], [rel='tooltipminimum_rating-edit'], [rel='tooltipname-edit']").tooltip('destroy');
                $('#form-group-maximum_rating-edit, #form-group-minimum_rating-edit, #form-group-name-edit').removeClass('has-error');
            }, 500);
            
        });
        
        
        @if (Session::has('add_kra_failed'))
        $('#addModalKra').modal('show');
        $('#addModalKra').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-kra']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-kra').addClass('has-error');
            @endif
            $('#addModalKra input[name="name"]').val('{{$input_values['name']}}');
        });            
        @endif
        
        @if (Session::has('edit_kra_failed'))
        $('#editModalKra').modal('show');
        $('#editModalKra').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-kra-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-kra-edit').addClass('has-error');
            @endif
            $('#editModalKra input[name="name"]').val('{{$input_values['name']}}');
            
            $('#editModalKra input[name="id"]').val('{{$input_values['id']}}');
        });            
        @endif
        
        // Event on show delete modal confirmation
        $('.btn-kra-del').click(function() {
            var tmp_id = $(this).attr('id').replace("del_kra_", "");
            var kra_name = $('#kra_'+tmp_id).html();
            var html = '<h4 style="text-align:center;font-weight:bold;">Delete this KRA: "'+kra_name+'" ?</h4>';
            $('#modal-del-content-kra').html(html);

            $('#btn-do-delete-kra').attr('href', '{{URL::to("admin/performance/delete-kra")}}/'+tmp_id);
        });
        
        // Event on show edit modal confirmation
        $('.btn-kra-edit').click(function() {
            var tmp_id = $(this).attr('id').replace("edit_kra_", "");
            var tmp_name = $('#td_kra_' + tmp_id + ' input[name="hid_name"]').val();

            setTimeout(function() {
                $('#editModalKra input[name="id"]').val(tmp_id);
                $('#editModalKra input[name="name"]').val(tmp_name);
                
                $("[rel='tooltipname-kra-edit']").tooltip('destroy');
                $('#form-group-name-kra-edit').removeClass('has-error');
            }, 500);
            
        });
        
        $('#btn-add-toggle').click(function() {
            if ($('#add-kpi-form').is(':visible')) {
                $('#add-kpi-form').slideUp();
            } else {
                $('#add-kpi-form').slideDown();
            }
        });
    });
    </script>


    @if (Session::has('add_kpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New KPI added.
    </div>
    @endif
    
    @if (Session::has('add_kra_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New KRA added.
    </div>
    @endif
    
    @if (Session::has('edit_kpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KPI updated.
    </div>
    @endif
    
    @if (Session::has('edit_kra_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KRA updated.
    </div>
    @endif
    
    
    @if (Session::has('delete_kpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KPI deleted.
    </div>
    @endif
    
    @if (Session::has('delete_kra_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KRA deleted.
    </div>
    @endif

    @if (Session::has('edit_kpigroup_success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success!</strong> Job kpi updated.
    </div>
    @endif
    
    @if (Session::has('delete_kpigroup_success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success!</strong> Job kpi deleted.
    </div>
    @endif
    
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/performance/create-kpi')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New KPI</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-kra_id">
                    <label class="col-sm-4 control-label" for="name">KRA</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="kra_id" rows="3" rel="tooltipkra_id">
                          <option value="0">-- None --</option>
                          @foreach($kra as $kr)
                          <option value="{{$kr->id}}">{{ $kr->name }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-job_id">
                    <label class="col-sm-4 control-label" for="name">Job Title</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="job_id" rows="3" rel="tooltipjob_id">
                          <option value="0">-- None --</option>
                          @foreach($jobs as $job)
                          <option value="{{$job->id}}">{{ $job->title }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-name">
                    <label class="col-sm-4 control-label" for="name">Key Performance Indicator</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="name" rows="3" rel="tooltipname"></textarea>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-minimum_rating">
                    <label class="col-sm-4 control-label" for="name">Minimum Rating</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="minimum_rating" rel="tooltipminimum_rating">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-maximum_rating">
                    <label class="col-sm-4 control-label" for="name">Maximum Rating</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="maximum_rating" rel="tooltipmaximum_rating">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
      </div>
    </div>   
    <!-- End Add Modal -->
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/performance/edit-kpi')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" />
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit KPI</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-kra_id-edit">
                    <label class="col-sm-4 control-label" for="name">KRA</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="kra_id" rows="3" rel="tooltipkra_id-edit">
                          <option value="0">-- None --</option>
                          @foreach($kra as $kr)
                          <option value="{{$kr->id}}">{{ $kr->name }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>  
                  <div class="form-group" id="form-group-job_id-edit">
                    <label class="col-sm-4 control-label" for="name">Job Title</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="job_id" rows="3" rel="tooltipjob_id-edit">
                          <option value="0">-- None --</option>
                          @foreach($jobs as $job)
                          <option value="{{$job->id}}">{{ $job->title }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-name-edit">
                    <label class="col-sm-4 control-label" for="name">Key Performance Indicator</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="name" rows="3" rel="tooltipname-edit"></textarea>
                    </div>
                  </div>
                  <div class="form-group" id="form-group-minimum_rating-edit">
                    <label class="col-sm-4 control-label" for="name">Minimum Rating</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="minimum_rating" rel="tooltipminimum_rating-edit">
                    </div>
                  </div>
                  <div class="form-group" id="form-group-maximum_rating-edit">
                    <label class="col-sm-4 control-label" for="name">Maximum Rating</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="maximum_rating" rel="tooltipmaximum_rating-edit">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
      </div>
    </div>   
    <!-- End Edit Modal -->
    
    <!-- Delete Confirmation modal -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">KPI Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="" id="btn-do-delete" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Delete Confirmation modal -->
    
    
    
    <!-- Add Modal KRA -->
    <div class="modal fade" id="addModalKra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/performance/create-kra')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New KRA</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-name-kra">
                    <label class="col-sm-4 control-label" for="name">Key Result Area</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="name" rel="tooltipname-kra">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
      </div>
    </div>   
    <!-- End Add Modal KRA -->
    
    <!-- Edit Modal KRA -->
    <div class="modal fade" id="editModalKra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/performance/edit-kra')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"/>
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit KRA</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-name-kra-edit">
                    <label class="col-sm-4 control-label" for="name">Key Result Area</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="name" rel="tooltipname-kra-edit">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
      </div>
    </div>   
    <!-- End Edit Modal KRA -->
    
    <!-- Delete KRA Confirmation modal -->
    <div class="modal fade" id="delModalKra" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">KRA Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content-kra">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="" id="btn-do-delete-kra" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Delete KRA Confirmation modal -->
    
    <!-- Delete KRA Confirmation modal -->
    <div class="modal fade" id="delModalKpiGroup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">KPI Delete Confirmation</h4>
          </div>
          <div class="modal-body" id="modal-del-content-kra">
              @if (isset($selected_job))
              <h4 class="text-center">Delete all KPI of "{{ $selected_job->title }}" job?</h4>
              @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            @if (isset($selected_job))
            <a href="{{ URL::to('admin/performance/delete-kpi-group/'.$selected_job->id) }}" id="btn-do-delete-kpi-group" class="btn btn-danger">Delete</a>
            @endif
          </div>
        </div>
      </div>
    </div>
    <!-- End Delete KRA Confirmation modal -->
    
    <div class="row" style="padding-top:10px;">
    
        <div class="col-md-12">

          <div class="col-md-1 nopadding">
              <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li>&nbsp;</li><li>&nbsp;</li>
                    <li class="@if (!Session::has('tab_kra')) active @endif"><a href="#kpi" data-toggle="tab">KPI</a></li>
                    <li class="@if (Session::has('tab_kra')) active @endif"><a href="#kra" data-toggle="tab">KRA</a></li>
                    <li>&nbsp;</li><li>&nbsp;</li>
                </ul>
              </div>
          </div>
          
          <div class="col-md-11 nopadding">
            <div class="tab-content">
             <div class="tab-pane @if (!Session::has('tab_kra')) active @endif" id="kpi">
                <div class="col-lg-9" style="padding-left: 0;">
                    <!--<button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New</button>-->
                    <button type="button" id="btn-add-toggle" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> &nbsp;Add New KPI</button>
                    <!--<button type="button" id="btn-del" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>-->
                </div>

                <div class="col-lg-3" style="padding-right: 0;">
                    <div class="input-group pull-right">
                        <input type="text" class="form-control" placeholder="search anything..." name="key" value="{{ (isset($key) ? $key : ''); }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
                        </span>
                    </div>
                </div>

                <br/>

                <br/><br/>
                
                <?php $fail = FALSE; ?>
                @if (Session::has('add_kpigroup_failed'))
                <?php $fail = TRUE; ?>
                @endif
                
                <div class="panel panel-default" id="add-kpi-form" @if (!$fail) style="display: none;" @endif>
                    <div class="panel-heading clearfix">Add New KPI</div>
                    <div class="panel-body">
                        <form method="post" action="{{ URL::to('admin/performance/add-kpi-group') }}">
                            @if ($fail)
                            <div class="alert alert-danger alert-dismissable" style="margin-right:10px;margin-left:10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Something not correct!</strong> Please check
                                <br/>- All Kpi field must be filled
                                <br/>- Weight and target field must be numeric
                                <br/>- Total weight must be 100
                            </div>
                            @endif
                            <div class="form-group" id="form-group-name-kra">
                                <label class="col-sm-3 control-label" for="name">Job Title</label>
                                <div class="col-sm-9">
                                    <select name="job_id" id="add-job_id" rows="3" rel="ttip-job_id">
                                        @foreach($jobs as $job)
                                        @if (!in_array($job->id, $kpi_distinct))
                                            @if ($fail)
                                                @if ($input_values['job_id'] == $job->id)
                                                <option value="{{$job->id}}" selected>{{ $job->title }}</option>
                                                @else
                                                <option value="{{$job->id}}">{{ $job->title }}</option>
                                                @endif
                                            @else
                                                <option value="{{$job->id}}">{{ $job->title }}</option>
                                            @endif
                                        @endif
                                        @endforeach
                                    </select>
                                    <script>                            
                                        $('#add-job_id').select2({
                                            width: 300, 
                                            containerCssClass: 'select2style',
                                            dropdownCssClass: 'select2style'
                                        });
                                        $(function() {
                                            $('#btnAddKpiRow').click(function(e) {
                                                e.preventDefault();
                                                var row = $('#tbl-kpi tbody tr').html();
                                                $('#tbl-kpi tbody').append('<tr>' + row + '</tr>');
                                                
                                                $('#tbl-kpi tbody tr').last().find('input').val('');
                                                $('#tbl-kpi tbody tr').last().find('select').val(0);
                                                $('#tbl-kpi tbody tr').last().find('textarea').val('');
                                                
                                                $('.btn-kpi-del-row').bind('click', function(e) {
                                                    e.preventDefault();
                                                    if ($('#tbl-kpi tbody tr').length > 1) {
                                                        $(this).parent().parent().remove();
                                                    }
                                                });
                                            });
                                            
                                            $('.btn-kpi-del-row').click(function(e) {
                                                e.preventDefault();
                                                if ($('#tbl-kpi tbody tr').length > 1) {
                                                    $(this).parent().parent().remove();
                                                }
                                            });
                                            
                                            $('#btnCloseAddKpiForm').click(function(e) {
                                                e.preventDefault();
                                                $('#add-kpi-form').slideUp();
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            
                            <style>
                                #box-kpi { margin:12px; }
                                #tbl-kpi td { vertical-align: middle; }
                            </style>
                            <div id="box-kpi">
                            <br/><br/>
                            <table width="100%" id="tbl-kpi" class="table table-striped table-hover">
                                <thead>
                                    <th width="45%">Key Performance Indicator</th>
                                    <th width="30%">Key Result Area</th>
                                    <th width="10%">Weight</th>
                                    <th width="10%">Target</th>
                                    <th width="5%"></th>
                                </thead>
                                <tbody>
                                    @if ($fail)
                                    @foreach($input_values['name'] as $index => $name)
                                    <tr>
                                        <td><textarea class="form-control" name="name[]" rows="3">{{ $name }}</textarea></td>
                                        <td>
                                            <select class="form-control" name="kra_id[]">
                                                <option value="0">-- All --</option>
                                                @foreach($kra as $kr)
                                                @if($kr->id == $input_values['kra_id'][$index])
                                                    <option value="{{$kr->id}}" selected="">{{ $kr->name }}</option>
                                                @else
                                                    <option value="{{$kr->id}}">{{ $kr->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="default_weight[]" value="{{ $input_values['default_weight'][$index] }}" class="form-control"/></td>
                                        <td><input type="text" name="default_target[]" value="{{ $input_values['default_target'][$index] }}" class="form-control"/></td>
                                        <td><a href="" title="delete kpi" class="btn btn-xs btn-danger btn-kpi-del-row" ><i class="fa fa-times"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td><textarea class="form-control" name="name[]" rows="3"></textarea></td>
                                        <td>
                                            <select class="form-control" name="kra_id[]">
                                                <option value="0">-- All --</option>
                                                @foreach($kra as $kr)
                                                <option value="{{$kr->id}}">{{ $kr->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="default_weight[]" class="form-control"/></td>
                                        <td><input type="text" name="default_target[]" class="form-control"/></td>
                                        <td><a href="" title="delete kpi" class="btn btn-xs btn-danger btn-kpi-del-row" ><i class="fa fa-times"></i></a></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            </div>
                            
                            <div class="form-group" id="form-group-phone">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <input type="submit" class="btn btn-primary pull-right" value="Save changes">
                                    <div class="pull-right">&nbsp;&nbsp;</div>
                                    <input type="submit" class="btn btn-primary pull-right" id="btnAddKpiRow" value="Add KPI Row">
                                    <div class="pull-right">&nbsp;&nbsp;</div>
                                    <button class="btn btn-default pull-right" id="btnCloseAddKpiForm">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                @if (!isset($view_edit))
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <select class="pull-right" id="select_job">
                            <option value="0">-- All --</option>
                            @foreach($jobs as $job)
                            <option value="{{$job->id}}">{{ $job->title }}</option>
                            @endforeach
                        </select>
                        <script>                            
                            $('#select_job').select2({
                                width: 280, 
                                containerCssClass: 'select2style',
                                dropdownCssClass: 'select2style'
                            }).on("change", function(e) {
                                var job_id = $('#select_job').val();
                                var kra_id = $('#select_kra').val();
                                if (kra_id == 0 && job_id == 0) {
                                    window.location = "{{ URL::to('admin/employeesetting/performance') }}";
                                } else {
                                    window.location = "{{ URL::to('admin/employeesetting/filter-kpi/') }}/" + kra_id + "/" + job_id;
                                }
                            });
                        </script>
                        
                        <span class="pull-right"><small>Sort by Job Title: &nbsp;</small></span>
                        
                        <span class="pull-right">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span>
                        
                        <select class="pull-right" id="select_kra">
                            <option value="0">-- All --</option>
                            @foreach($kra as $kr)
                            <option value="{{$kr->id}}">{{ $kr->name }}</option>
                            @endforeach
                        </select>
                        <script>
                            $('#select_kra').select2({
                                width: 280, 
                                containerCssClass: 'select2style',
                                dropdownCssClass: 'select2style'
                            }).on("change", function(e) {
                                var kra_id = $('#select_kra').val();
                                var job_id = $('#select_job').val();
                                if (kra_id == 0 && job_id == 0) {
                                    window.location = "{{ URL::to('admin/employeesetting/performance') }}";
                                } else {
                                    window.location = "{{ URL::to('admin/employeesetting/filter-kpi/') }}/" + kra_id + "/" + job_id;
                                }
                            });
                            
                            @if (isset($kra_id) && $kra_id != 0)
                                $('#select_kra').select2('val', {{ $kra_id }});
                            @endif
                            
                            @if (isset($job_id) && $job_id != 0)
                                $('#select_job').select2('val', {{ $job_id }});
                            @endif
                        </script>
                        <span class="pull-right"><small>Sort by KRA: &nbsp;</small></span>
                    </div>
                    
                    <div class="panel-body">
                      <div class="table-responsive">
                        <h3>
                            @if (isset($selected_job))
                            {{ $selected_job->title }} KPI
                            <a class="btn btn-danger btn-xs pull-right" data-toggle="modal" data-target="#delModalKpiGroup"><i class="fa fa-trash-o"></i> Delete All</a>
                            <div class="pull-right">&nbsp;</div>
                            <a href="{{ URL::to('admin/employeesetting/edit-kpi-group/'.$selected_job->id) }}" class="btn btn-success btn-xs pull-right"><i class="fa fa-edit"></i> Edit</a>
                            @else
                            All KPI
                            @endif
                        </h3>
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th width="55%">#Key Performance Indicator </th>
                              <th width="25%">#Job Title </th>
                              <th width="10%">#Weight </th>
                              <th width="10%">#Target </th>
<!--                              <th width="10%">#Min. Rate</th>
                              <th width="10%">#Max. Rate</th>-->
                              <!--<th width="10%"></th>-->
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($kpi as $index => $kp)
                          <tr>
                              <td id="kpi_{{$kp->id}}">{{ $kp->name }}</td>
                              <!--<td>@if(isset($kp->job->title)) {{$kp->job->title}} @endif</td>-->
<!--                              <td>{{ $kp->minimum_rating }}</td>
                              <td>{{ $kp->maximum_rating }}</td>-->
                              <td>@if (isset($kp->job->title)) {{ $kp->job->title }} @endif</td>
                              <td>{{ $kp->default_weight }}</td>
                              <td>{{ $kp->default_target }}</td>
<!--                              <td id="td_{{$kp->id}}" class="text-right">
                                  <input type="hidden" name="hid_id" value="{{ $kp->id }}"/>
                                  <input type="hidden" name="hid_name" value="{{ $kp->name }}"/>
                                  <input type="hidden" name="hid_minimum_rating" value="{{ $kp->minimum_rating }}"/>
                                  <input type="hidden" name="hid_maximum_rating" value="{{ $kp->maximum_rating }}"/>
                                  <input type="hidden" name="hid_job_id" value="{{ $kp->job_id }}"/>
                                  <input type="hidden" name="hid_kra_id" value="{{ $kp->kra_id }}"/>
                                  <a href="" title="quick edit" id="edit_{{$kp->id}}" class="btn btn-xs btn-success btn-kpi-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                                  <a href="" title="delete kpi" id="del_{{$kp->id}}" class="btn btn-xs btn-danger btn-kpi-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
                              </td>-->
                          </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>

                    </div>
                </div>
                @else
                @if (Session::has('edit_kpigroup_failed'))
                <?php $fail = TRUE; ?>
                @endif
                <div class="panel panel-default" id="edit-kpi-form">
                    <div class="panel-heading clearfix">Edit KPI Job</div>
                    <div class="panel-body">
                        <form method="post" action="{{ URL::to('admin/performance/edit-kpi-group') }}">
                            @if ($fail)
                            <div class="alert alert-danger alert-dismissable" style="margin-right:10px;margin-left:10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Something not correct!</strong> Please check
                                <br/>- All Kpi field must be filled
                                <br/>- Weight and target field must be numeric
                                <br/>- Total weight must be 100
                            </div>
                            @endif
                            <input type="hidden" name="job_id" value="{{ $selected_job->id }}"/>
                            <div class="form-group" id="form-group-name-kra">
                                <label class="col-sm-3 control-label" for="name">Job Title</label>
                                <div class="col-sm-9">
                                    <small><strong>{{ $selected_job->title }}</strong></small>
                                    <script>       
                                        $(function() {
                                            $('#btnAddKpiRowEdit').click(function(e) {
                                                e.preventDefault();
                                                var row = $('#tbl-kpi-edit tbody tr').html();
                                                $('#tbl-kpi-edit tbody').append('<tr>' + row + '</tr>');
                                                
                                                $('#tbl-kpi-edit tbody tr').last().find('input').val('');
                                                $('#tbl-kpi-edit tbody tr').last().find('select').val(0);
                                                $('#tbl-kpi-edit tbody tr').last().find('textarea').val('');
                                                
                                                $('.btn-kpi-del-row-edit').bind('click', function(e) {
                                                    e.preventDefault();
                                                    if ($('#tbl-kpi-edit tbody tr').length > 1) {
                                                        $(this).parent().parent().remove();
                                                    }
                                                });
                                            });
                                            
                                            $('.btn-kpi-del-row-edit').click(function(e) {
                                                e.preventDefault();
                                                if ($('#tbl-kpi-edit tbody tr').length > 1) {
                                                    $(this).parent().parent().remove();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            
                            <style>
                                #box-kpi-edit { margin:12px; }
                                #tbl-kpi-edit td { vertical-align: middle; }
                            </style>
                            <div id="box-kpi">
                            <br/><br/>
                            <table width="100%" id="tbl-kpi-edit" class="table table-striped table-hover">
                                <thead>
                                    <th width="45%">Key Performance Indicator</th>
                                    <th width="30%">Key Result Area</th>
                                    <th width="10%">Weight</th>
                                    <th width="10%">Target</th>
                                    <th width="5%"></th>
                                </thead>
                                <tbody>
                                    @if ($fail)
                                    @foreach($input_values['name'] as $index => $name)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="id[]" value="{{ $input_values['id'][$index] }}"/>
                                            <textarea class="form-control" name="name[]" rows="3">{{ $name }}</textarea>
                                        </td>
                                        <td>
                                            <select class="form-control" name="kra_id[]">
                                                <option value="0">-- All --</option>
                                                @foreach($kra as $kr)
                                                @if($kr->id == $input_values['kra_id'][$index])
                                                    <option value="{{$kr->id}}" selected="">{{ $kr->name }}</option>
                                                @else
                                                    <option value="{{$kr->id}}">{{ $kr->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="default_weight[]" value="{{ $input_values['default_weight'][$index] }}" class="form-control"/></td>
                                        <td><input type="text" name="default_target[]" value="{{ $input_values['default_target'][$index] }}" class="form-control"/></td>
                                        <td><a href="" title="delete kpi" class="btn btn-xs btn-danger btn-kpi-del-row-edit" ><i class="fa fa-times"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    @foreach($job_kpis as $index => $kpi)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="id[]" value="{{ $kpi->id }}"/>
                                            <textarea class="form-control" name="name[]" rows="3">{{ $kpi->name }}</textarea>
                                        </td>
                                        <td>
                                            <select class="form-control" name="kra_id[]">
                                                <option value="0">-- All --</option>
                                                @foreach($kra as $kr)
                                                @if ($kpi->kra_id == $kr->id)
                                                <option selected value="{{$kr->id}}">{{ $kr->name }}</option>
                                                @else
                                                <option value="{{$kr->id}}">{{ $kr->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="default_weight[]" class="form-control" value="{{ $kpi->default_weight }}"/></td>
                                        <td><input type="text" name="default_target[]" class="form-control" value="{{ $kpi->default_target }}"/></td>
                                        <td><a href="" title="delete kpi" class="btn btn-xs btn-danger btn-kpi-del-row-edit" ><i class="fa fa-times"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            </div>
                            
                            <div class="form-group" id="form-group-phone">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <input type="submit" class="btn btn-primary pull-right" value="Save changes">
                                    <div class="pull-right">&nbsp;&nbsp;</div>
                                    <input type="submit" class="btn btn-primary pull-right" id="btnAddKpiRowEdit" value="Add KPI Row">
                                    <div class="pull-right">&nbsp;&nbsp;</div>
                                    <a href="{{ URL::to('admin/employeesetting/filter-kpi/0/'.$selected_job->id) }}" class="btn btn-default pull-right">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                @endif
                
             </div>
                
             <div class="tab-pane @if (Session::has('tab_kra')) active @endif" id="kra">
                <div class="col-lg-9" style="padding-left: 0;">
                    <button type="button" id="btn-add-kra" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModalKra"><i class="fa fa-plus"></i> &nbsp;Add New</button>
                    <button type="button" id="btn-del-kra" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>
                </div>

                <div class="col-lg-3" style="padding-right: 0;">
                    <div class="input-group pull-right">
                        <input type="text" class="form-control" placeholder="search anything..." name="key" value="{{ (isset($key) ? $key : ''); }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btn-search-kra"><i class="fa fa-search search-icon"></i></button>
                        </span>
                    </div>
                </div>

                <br/>

                <br/><br/>
                
                <div class="panel panel-default">
                    <div class="panel-heading">List of KRA</div>
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th width="5%"><input type="checkbox"></th>  
                              <th width="85%">#Key Result Area </th>
                              <th width="10%"></th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($kra as $index => $kr)
                          <tr>
                              <td><input type="checkbox"></td>
                              <td id="kra_{{$kr->id}}">{{ $kr->name }}</td>
                              <td id="td_kra_{{$kr->id}}" class="text-right">
                                  <input type="hidden" name="hid_id" value="{{ $kr->id }}"/>
                                  <input type="hidden" name="hid_name" value="{{ $kr->name }}"/>
                                  <a href="" title="quick edit" id="edit_kra_{{$kr->id}}" class="btn btn-xs btn-success btn-kra-edit" data-toggle="modal" data-target="#editModalKra"><i class="fa fa-edit"></i></a>
                                  <a href="" title="delete kra" id="del_kra_{{$kr->id}}" class="btn btn-xs btn-danger btn-kra-del" data-toggle="modal" data-target="#delModalKra"><i class="fa fa-trash-o"></i></a>
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
    
    </div><!-- /row -->