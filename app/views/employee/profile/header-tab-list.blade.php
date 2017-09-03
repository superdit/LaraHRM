<ul class="nav nav-tabs" style="margin-bottom: 15px;">
    <li @if( Request::segment(3) == '') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile') }}">Profile</a></li>
    <li @if( Request::segment(3) == 'contact') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile/contact') }}">Contact</a></li>
    <li @if( Request::segment(3) == 'attendance' || Request::segment(3) == 'leave') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile/attendance') }}">Attendance</a></li>
    <li @if( Request::segment(3) == 'qualification') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile/qualification') }}">Qualification</a></li>
    <li @if( Request::segment(3) == 'salary') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile/salary') }}">Salary</a></li>
    <li @if( Request::segment(3) == 'login') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile/login') }}">Login Credential</a></li>
    <li @if( Request::segment(3) == 'performance' || Request::segment(3) == 'kpi-history' || Request::segment(3) == 'kpi-result') {{ 'class="active"' }} @endif><a href="{{ URL::to('employee/profile/performance') }}">Performance</a></li>
</ul>