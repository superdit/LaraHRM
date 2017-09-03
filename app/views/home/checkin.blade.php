@extends('layouts/frontend')

@section('content')

<script>
$(function() {
  var sayCheese = new SayCheese('#container-element', { audio: true });
  
  sayCheese.on('start', function() {    
    $('video').attr({ 'width': 300, 'height': 200 });
  });
  
  $.blockUI.defaults.applyPlatformOpacityRules = false;
  
  var mode = "";
  
  $('#btn-check_in').click(function(e) {
      $.blockUI({ 
        message: '<h1 style="padding-bottom:15px;"><i class="fa fa-spinner fa-spin"></i> Just a moment...</h1>',
        css: { backgroundColor: '#E99002', color: '#fff', borderWidth: 0, width: '40%', left: '30%'  }
      });
      mode = "in";
      e.preventDefault();
      sayCheese.takeSnapshot();
  });
  
  $('#btn-check_out').click(function(e) {
      $.blockUI({ 
        message: '<h1 style="padding-bottom:15px;"><i class="fa fa-spinner fa-spin"></i> Just a moment...</h1>',
        css: { backgroundColor: '#E99002', color: '#fff', borderWidth: 0, width: '40%', left: '30%'  }
      });
      mode = "out";
      e.preventDefault();
      sayCheese.takeSnapshot();
  });

  sayCheese.on('snapshot', function(snapshot) {
      
    var url = "";
    var id_number = $('input[name="id_number"]').val();
    setTimeout(function() {
        url = snapshot.toDataURL('image/png');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('home/ajax-check-') }}" + mode,
            data: { img: url, id_number: id_number },
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            success: function(e){

                if (e === "1") {
                    $.blockUI({ 
                        message: '<h1 style="padding-bottom:15px;"><i class="fa fa-check"></i> Thank You</h1>',
                        css: { backgroundColor: '#43AC6A', color: '#fff', borderWidth: 0, width: '40%', left: '30%' }
                    });
                    resetForm();
                } else if (e === "0") {
                    $.blockUI({ 
                        message: '<h1 style="padding-bottom:15px;"><i class="fa fa-frown-o"></i> Not Found</h1>',
                        css: { backgroundColor: '#F04124', color: '#fff', borderWidth: 0, width: '40%', left: '30%' }
                    });
                    resetForm();
                } else if (e === "2") {
                    $.blockUI({ 
                        message: '<h1 style="padding-bottom:15px;"><i class="fa fa-thumbs-up"></i> You have checked ' + mode + '</h1>',
                        css: { backgroundColor: '#5BC0DE', color: '#fff', borderWidth: 0, width: '40%', left: '30%' }
                    });
                    resetForm();
                }
                
            }
        });
    }, 1000);
      
  });
  
  function resetForm() {
    setTimeout(function() { $.unblockUI(); }, 1000);
    $('input[name="id_number"], input[name="password"]').val('');
  }

  sayCheese.start();
});
</script>

<form class="form-signin" role="form">
    <div id="container-element"></div>
    
    <h2 class="form-signin-heading text-center">Check In/Out</h2>
    <input type="text" class="form-control" placeholder="Employee ID Number" name="id_number" required="" autofocus="">
    <br/>
    <button class="btn btn-primary" type="submit" id="btn-check_in"><i class="fa fa-angle-double-left"></i> Check In</button>
    <button class="btn btn-primary pull-right" id="btn-check_out" type="submit">Check Out <i class="fa fa-angle-double-right"></i></button>
    
</form>

@stop