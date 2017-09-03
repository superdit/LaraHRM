<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/signin/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://getbootstrap.com/assets/ico/favicon.ico">

    <title>Signin Template for Bootstrap</title>
    
    <style>
        @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 300;
        src: url('{{URL::asset('css/OpenSans-Light.ttf')}}') format('truetype');
        }
    </style>

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"></link>
    <link href="{{ URL::asset('css/bootstrap-yeti.min.css') }}" rel="stylesheet"></link>
    <link href="{{ URL::asset('font-awesome-4.0.3/css/font-awesome.min.css') }}" rel="stylesheet"></link>

    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('css/signin.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="{{ URL::asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    
    <!-- Datepicker plugin -->
    <script src="{{ URL::asset('js/bootstap-datetimepicker/js/moment.min.js') }}"></script>    
    <script src="{{ URL::asset('js/bootstap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <link href="{{ URL::asset('js/bootstap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"></link>
   
    <!-- Say Cheese plugin -->
    <script src="{{ URL::asset('js/say-cheese.js') }}"></script>
    
    <!-- blockUI plugin -->
    <script src="{{ URL::asset('js/jquery.blockUI.min.js') }}"></script>
  </head>

  <body>

    <div class="container">

      @yield('content')

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  

</body></html>