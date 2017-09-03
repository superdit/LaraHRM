<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>Dashboard Template for Bootstrap</title>
    
    <style>
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 300;
            src: url('{{URL::asset('css/OpenSans-Light.ttf')}}') format('truetype');
        }
        .ico-toggle {
            position: relative;
            top: 3px;
        }
        .sub-menu > li > a {
            padding-top: 7px !important;
            padding-bottom: 7px !important;
        }
        table > tbody > tr > td { vertical-align: middle !important; }
    </style>
   
    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"></link>
    <link href="{{ URL::asset('css/bootstrap-yeti.min.css') }}" rel="stylesheet"></link>
    <link href="{{ URL::asset('font-awesome-4.1/css/font-awesome.min.css') }}" rel="stylesheet"></link>


    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('css/dashboard.css') }}" rel="stylesheet"></link>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="{{ URL::asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/docs.min.js') }}"></script>
    
    <!-- Bootstrap datetimepicker plugin -->
    <script src="{{ URL::asset('js/bootstap-datetimepicker/js/moment.min.js') }}"></script>    
    <script src="{{ URL::asset('js/bootstap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <link href="{{ URL::asset('js/bootstap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"></link>
    
    <!-- Jquery chosen plugin -->
    <script src="{{ URL::asset('js/chosen/chosen.jquery.min.js') }}"></script>
    <link href="{{ URL::asset('js/chosen/chosen.min.css') }}" rel="stylesheet"></link>
    
    <!-- Jquery select2 plugin -->
    <script src="{{ URL::asset('js/select2-3.4.6/select2.min.js') }}"></script>
    <link href="{{ URL::asset('js/select2-3.4.6/select2.css') }}" rel="stylesheet"/>
    
    <!-- Jquery ddSlick plugin -->
    <script src="{{ URL::asset('js/jquery.ddslick.min.js') }}"></script>
    
    <!-- Jquery price format plugin -->
    <script src="{{ URL::asset('js/jquery.price_format.2.0.min.js') }}"></script>    
    
    <script>
    $(function() {
        $('.top-menu').click(function() {
            if($(this).parent().next().is(':visible')) {
                $(this).parent().next().slideUp();
                $(this).parent().find('.ico-toggle').removeClass('fa-toggle-up');
                $(this).parent().find('.ico-toggle').addClass('fa-toggle-down');
            } else {
                $(this).parent().next().slideDown();
                $(this).parent().find('.ico-toggle').removeClass('fa-toggle-down');
                $(this).parent().find('.ico-toggle').addClass('fa-toggle-up');
            }
        });
    });
    </script>
    
  <style id="holderjs-style" type="text/css"></style></head>

  <body style="">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://getbootstrap.com/examples/dashboard/#">Human Resource System</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://getbootstrap.com/examples/dashboard/#">Dashboard</a></li>
            <li><a href="http://getbootstrap.com/examples/dashboard/#">My Profile</a></li>
            <li><a href="{{URL::to('auth/signout')}}">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="overflow-y: scroll;">
          <ul class="nav nav-pills nav-stacked">
            <li @if( Request::segment(2) == 'dashboard') {{ 'class="active"' }} @endif><a href="{{URL::to('employee/dashboard')}}"><i class="fa fa-dashboard"></i> &nbsp;Dashboard</a></li>
            <li @if( Request::segment(2) == 'profile') {{ 'class="active"' }} @endif><a href="{{URL::to('employee/profile')}}"><i class="fa fa-user"></i> &nbsp;My Profile</a></li>
            <li @if( Request::segment(2) == 'team') {{ 'class="active"' }} @endif><a href="{{URL::to('employee/team')}}"><i class="fa fa-users"></i> &nbsp;Teams</a></li>
            <li @if( Request::segment(2) == 'event') {{ 'class="active"' }} @endif><a href="{{URL::to('employee/event')}}"><i class="fa fa-calendar"></i> &nbsp;Event Calendar</a></li>
          </ul>
        </div>
            
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        @yield('content')
        </div>  
    </div>
</body>
</html>