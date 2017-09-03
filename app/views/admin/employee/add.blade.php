@extends('layouts/backend')

@section('content')

<script>
$(function() {
    $('#birthdate, #birthdate-edit').datetimepicker({pickTime: false, viewMode:2}); 
    
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
        if(code === 13) {
            var key = $('input[name="key"]').val();
            if (key.length > 0) {
                window.location = '{{URL::to("admin/employee/search")}}/'+key;
            } else {
                window.location = '{{URL::to("admin/employee")}}';
            }
        }
    });
    
    // Event show advance search panel
    $('#btn-advance-search').click(function() {
        if ($('#advSearchPanel').is(':visible')) {
            $('#advSearchPanel').slideUp();
        } else {
            $('#advSearchPanel').slideDown();
        }
    });
    
    // Event advanced search
    $('#btnAvdSearchReset').click(function(e) {
        e.preventDefault();
        $('#formAdvSearch input[name="id_number"], #formAdvSearch input[name="name"]').val('');
        $('#formAdvSearch select[name="employee_type_id"], #formAdvSearch select[name="job_id"]').val(0);
    });

    $('#btnAdvSearch').click(function(e) {
        e.preventDefault();
        var id_number = $('#formAdvSearch input[name="id_number"]').val();
        var name = $('#formAdvSearch input[name="name"]').val();
        var employee_type_id = $('#formAdvSearch select[name="employee_type_id"]').val();
        var job_id = $('#formAdvSearch select[name="job_id"]').val();
        window.location = '{{URL::to("admin/employee/adv-search")}}?id_number=' + id_number + '&name=' + name + '&employee_type_id=' + employee_type_id + '&job_id=' + job_id
    });
});
</script>

<h1 class="page-header">Add New Employee</h1>

<div class="col-lg-9" style="padding-left: 0;">
    <button type="button" id="btn-advance-search" class="btn btn-default btn-sm"><i class="fa fa-gear"></i> &nbsp;Advance Search</button>    
    <a type="button" href="{{ URL::to('admin/employee') }}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> &nbsp;Cancel</a>
</div>

<div class="col-lg-3" style="padding-right: 0;">
    <div class="input-group pull-right">
        <input type="text" class="form-control" placeholder="quick search ..." name="key" value="{{ (isset($key) ? $key : ''); }}">
        <span class="input-group-btn">
            <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
        </span>
    </div>
</div>

<br/></br><br/>

<!-- Advance Search Panel -->
<div class="panel panel-default" id="advSearchPanel" style="display: none;">
    <div class="panel-heading">Advance Search Option</div>
    <div class="panel-body">
        <form id="formAdvSearch" method="post" action="{{URL::to("admin/employee/adv-search")}}">
        <div class="col-md-4">
            <div class="form-group">
                <label for="id_number">ID Number</label>
                <input type="text" class="form-control" name="id_number">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Employee Type</label>
                <select class="form-control" name="employee_type_id">
                    <option value="0">-- All --</option>
                    @foreach($emptypes as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Job</label>
                <select class="form-control" name="job_id">
                    <option value="0">-- All --</option>
                    @foreach($jobs as $job)
                    <option value="{{$job->id}}">{{$job->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <label>&nbsp;</label><br/>
            <button type="submit" class="btn btn-primary btn-sm pull-right" id="btnAdvSearch"><i class="fa fa-search"></i> &nbsp;Search</button>
            <div class="pull-right">&nbsp;&nbsp;</div>
            <button class="btn btn-default btn-sm pull-right" id="btnAvdSearchReset">Reset</button>
        </div>
        </form>
    </div>
</div>
<!-- End Advance Search Panel -->

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        Add Employee Information
    </div>
    <div class="panel-body">
        <form method="post" action="{{ URL::to('admin/employee/add') }}" enctype="multipart/form-data">
        <div class="col-md-2">
          <div class="thumbnail text-center">
            Upload Picture
          </div>
          <input type="file" class="form-control" name="photo">
        </div>
        <div class="col-md-10 form-horizontal">
          <div class="form-group" id="form-group-workshift">
            <label class="col-sm-2 control-label">Workshift</label>
            <div class="col-sm-10">
                <select id="select_workshift" class="form-control">
                @foreach($workshifts as $index => $shift)
                    <option value="{{$shift->id}}" data-description="{{$shift->start_work_time}} - {{$shift->end_work_time}} on {{$shift->days}}">{{$shift->name}}</option>
                @endforeach
                </select>
                <script>
                $(function() { 
                    $('#select_workshift').ddslick( {
                        width:550, 
                        height:200,
                        onSelected: function(data) {
                            $('input[name="workshift_id"]').val($('#select_workshift').data('ddslick').selectedData.value);
                        }
                    } ); 
                });
                </script>
                <input type="hidden" name="workshift_id"/>
            </div>
          </div>
          <div class="form-group" id="form-group-idnumber-edit">
            <label class="col-sm-2 control-label" for="name">ID Number</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id_number" rel="tooltipidnumber-edit" placeholder="eg: ABC000001">
            </div>
          </div>
          <div class="form-group" id="form-group-name-edit">
            <label class="col-sm-2 control-label" for="name">Full Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" rel="tooltipidnumber-edit" placeholder="eg: ABC000001">
            </div>
          </div>
          <div class="form-group" id="form-group-email-edit">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" rel="tooltipidnumber-edit" placeholder="eg: ABC000001">
            </div>
          </div>
          <div class="form-group" id="form-group-birthdate-edit">
            <label class="col-sm-2 control-label">Birthdate</label>
            <div class="col-sm-10">
              <div class="input-group date pull-right" id="birthdate-edit">
                 <input type="text" class="form-control" name="birthdate" data-format="YYYY-MM-DD" placeholder="Y-m-d"/>
                 <span class="input-group-addon" rel="tooltipbirthdate"><span class="glyphicon glyphicon-calendar"></span>
              </div>
            </div>
          </div>
          <div class="form-group" id="form-group-address-edit">
            <label class="col-sm-2 control-label">Address</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="address" rows="4" rel="tooltipaddress"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Gender</label>
            <div class="col-sm-10">
                <select class="form-control" name="gender">
                    <option vaiue="male">male</option>
                    <option value="female">female</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Marital Status</label>
            <div class="col-sm-10">
                <select class="form-control" name="marital_status">
                    <option vaiue="single">single</option>
                    <option value="married">married</option>
                    <option value="divorce">divorce</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Type</label>
            <div class="col-sm-10">
                <select class="form-control" name="employee_type_id">
                    @foreach($emptypes as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Job Title</label>
            <div class="col-sm-10">
                <select class="form-control" name="job_id">
                    @foreach($jobs as $job)
                    <option value="{{$job->id}}">{{$job->title}}</option>
                    @endforeach
              </select>
            </div>
          </div>
          <div class="form-group" id="form-group-phone">
            <label class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone" rel="tooltipidnumber-edit" placeholder="eg: ABC000001">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nationality</label>
            <div class="col-sm-10">
                <select class="" name="nation_id" id="nation_id" style="font-size: 12px; width: 100%;">
                    @foreach ($nations as $nation)
                    <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                    @endforeach
                </select>
                <script>$('#nation_id').select2();</script>
            </div>
          </div>
          <div class="form-group" id="form-group-phone">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <input type="submit" class="btn btn-primary" value="Save changes">
            </div>
          </div>
        </div>
        </form>
    </div>
</div>

@stop