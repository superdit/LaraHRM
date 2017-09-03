@extends('layouts/backend')

@section('content')

<h1 class="page-header">
    Employee Setting 
</h1>
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
    <li @if( Request::segment(3) == 'employmenttype') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/employmenttype') }}" ><i class="fa fa-tag"></i> &nbsp;Type</a></li>
    <li @if( Request::segment(3) == 'edudegree') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/edudegree') }}"><i class="fa fa-graduation-cap"></i> &nbsp;Degree</a></li>
    <li @if( Request::segment(3) == 'nation') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/nation') }}"><i class="fa fa-flag"></i> &nbsp;Nationality</a></li>
    <li @if( Request::segment(3) == 'job') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/job') }}"><i class="fa fa-briefcase"></i> &nbsp;Jobs</a></li>
    <li @if( Request::segment(3) == 'salarycomponent') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/salarycomponent') }}"><i class="fa fa-money"></i> &nbsp;Salary</a></li>
    <li @if( Request::segment(3) == 'workshift') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/workshift') }}"><i class="fa fa-clock-o"></i> &nbsp;Work Shift</a></li>
    <li @if( Request::segment(3) == 'performance' || Request::segment(3) == 'filter-kpi' || Request::segment(3) == 'edit-kpi-group') {{ 'class="active"' }} @endif><a href="{{ URL::to('admin/employeesetting/performance') }}"><i class="fa fa-bar-chart-o"></i> &nbsp;Performance</a></li>
</ul>
@if( Request::segment(3) == 'employmenttype')
    <?php echo App::make('Admin\EmployeetypeController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'edudegree')
    <?php echo App::make('Admin\EdudegreeController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'nation')
    <?php echo App::make('Admin\NationController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'job')
    <?php echo App::make('Admin\JobController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'salarycomponent')
    <?php echo App::make('Admin\SalarycomponentController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'workshift')
    <?php echo App::make('Admin\WorkshiftController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'performance')
    <?php echo App::make('Admin\PerformanceController')->getIndex(); ?>
@endif

@if( Request::segment(3) == 'filter-kpi')
    <?php echo App::make('Admin\PerformanceController')->getFilterKpi($kra_id, $job_id); ?>
@endif

@if( Request::segment(3) == 'edit-kpi-group')
    <?php echo App::make('Admin\PerformanceController')->getEditKpiGroup($job_id); ?>
@endif

@stop