@extends('layouts/backend')

@section('content')
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
  </style>
    <script>
    $(function() {
        @if ($open_create_modal == 1)
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
        });            
        @endif
        
        @if ($open_edit_modal == 1)
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
        });            
        @endif
        
        // Event on show delete modal confirmation
        $('.btn-kpi-del').click(function() {
            var tmp_id = $(this).attr('id').replace("del_", "");
            var kpi_name = $('#kpi_'+tmp_id).html();
            var html = '<h4 style="text-align:center;font-weight:bold;">Delete this KPI: "'+kpi_name+'" ?</h4>';
            $('#modal-del-content').html(html);

            $('#btn-do-delete').attr('href', '{{URL::to("admin/kpi/delete")}}/'+tmp_id);
        });
        
        // Event on show edit modal confirmation
        $('.btn-kpi-edit').click(function() {
            var tmp_id = $(this).attr('id').replace("edit_", "");
            var tmp_name = $('#td_' + tmp_id + ' input[name="hid_name"]').val();
            var tmp_min_rate = $('#td_' + tmp_id + ' input[name="hid_minimum_rating"]').val();
            var tmp_max_rate = $('#td_' + tmp_id + ' input[name="hid_maximum_rating"]').val();
            var tmp_job_id = $('#td_' + tmp_id + ' input[name="hid_job_id"]').val();
            
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
                
                $("[rel='tooltipmaximum_rating-edit'], [rel='tooltipminimum_rating-edit'], [rel='tooltipname-edit']").tooltip('destroy');
                $('#form-group-maximum_rating-edit, #form-group-minimum_rating-edit, #form-group-name-edit').removeClass('has-error');
            }, 500);
            
        });
    });
    </script>


    @if (Session::has('add_kpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> New KPI added.
    </div>
    @endif
    
    @if (Session::has('edit_kpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KPI updated.
    </div>
    @endif
    
    @if (Session::has('delete_kpi_success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong> KPI deleted.
    </div>
    @endif

    <h1 class="page-header">KPI (Key Performance Indicator)</h1>
    
    <div class="col-lg-9" style="padding-left: 0;">
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New KPI</button>
        <button type="button" id="btn-del" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete Checked</button>
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
    
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form-horizontal" action="{{URL::to('admin/kpi/create')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add New KPI</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-job_id">
                    <label class="col-sm-4 control-label" for="name">Job Title</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="job_id" rows="3" rel="tooltipjob_id">
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
            <form role="form" class="form-horizontal" action="{{URL::to('admin/kpi/edit')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" />
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit KPI</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group" id="form-group-job_id-edit">
                    <label class="col-sm-4 control-label" for="name">Job Title</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="job_id" rows="3" rel="tooltipjob_id-edit">
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
    
    <div class="panel panel-default">
        <div class="panel-heading">List of KPI</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="5%"><input type="checkbox"></th>  
                  <th width="25%">#Key Performance Indicator </th>
                  <th width="30%">#Job Title </th>
                  <th width="15%">#Min. Rate</th>
                  <th width="15%">#Max. Rate</th>
                  <th width="10%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($kpi as $index => $kp)
              <tr>
                  <td><input type="checkbox"></td>
                  <td id="kpi_{{$kp->id}}">{{ $kp->name }}</td>
                  <td>@if(isset($kp->job->title)) {{$kp->job->title}} @endif</td>
                  <td>{{ $kp->minimum_rating }}</td>
                  <td>{{ $kp->maximum_rating }}</td>
                  <td id="td_{{$kp->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $kp->id }}"/>
                      <input type="hidden" name="hid_name" value="{{ $kp->name }}"/>
                      <input type="hidden" name="hid_minimum_rating" value="{{ $kp->minimum_rating }}"/>
                      <input type="hidden" name="hid_maximum_rating" value="{{ $kp->maximum_rating }}"/>
                      <input type="hidden" name="hid_job_id" value="{{ $kp->job_id }}"/>
                      <a href="" title="quick edit" id="edit_{{$kp->id}}" class="btn btn-xs btn-success btn-kpi-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete kpi" id="del_{{$kp->id}}" class="btn btn-xs btn-danger btn-kpi-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          
        </div>
    </div>
@stop