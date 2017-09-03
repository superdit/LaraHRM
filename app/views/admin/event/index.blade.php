@extends('layouts/backend')

@section('content')

<!-- full calendar plugin -->
<link href="{{ URL::asset('js/fullcalendar-2.0.1/fullcalendar.css') }}" rel="stylesheet"></link>
<link href="{{ URL::asset('js/fullcalendar-2.0.1/fullcalendar.print.css') }}" rel="stylesheet" media="print"></link>
<script src="{{ URL::asset('js/fullcalendar-2.0.1/lib/moment.min.js') }}"></script>    
<!--<script src="{{ URL::asset('js/fullcalendar-2.0.1/lib/jquery.min.js') }}"></script>-->
<script src="{{ URL::asset('js/fullcalendar-2.0.1/lib/jquery-ui.custom.min.js') }}"></script>
<script src="{{ URL::asset('js/fullcalendar-2.0.1/fullcalendar.min.js') }}"></script>

<!-- classy context menu plugin -->
<script src="{{ URL::asset('js/classycontextmenu/js/jquery.hoverintent.js') }}"></script>
<script src="{{ URL::asset('js/classycontextmenu/js/jquery.classycontextmenu.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/classycontextmenu/css/jquery.classycontextmenu.min.css') }}" />

<style>
	body {
/*		margin: 0;
		padding: 0;*/
		//font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		margin: 40px auto;
	}
    
    .tooltip-inner {
        white-space: nowrap;
        max-width: 350px;
    }
</style>

<script>

var tempEvent;
$(document).ready(function() {
    
    @if (Session::has('add_event_failed'))
    $('#addModal').modal('show');
    $('#addModal').on('shown.bs.modal', function (e) {                
        @if (isset($error_messages) && $error_messages->first('title') != "")
        $("[rel='tooltiptitle']").tooltip({placement: 'right', title: '{{$error_messages->first('title')}}', trigger: 'manual'}).tooltip('show');
        $('#form-group-title').addClass('has-error');
        @endif
        $('#addModal textarea[name="title"]').val('{{$input_values['title']}}');
        
        @if (isset($error_messages) && $error_messages->first('start') != "")
        $("[rel='tooltipstart']").tooltip({placement: 'right', title: '{{$error_messages->first('start')}}', trigger: 'manual'}).tooltip('show');
        $('#form-group-start').addClass('has-error');
        @endif
        $('#addModal input[name="start"]').val('{{$input_values['start']}}');
        
        @if (isset($error_messages) && $error_messages->first('end') != "")
        $("[rel='tooltipend']").tooltip({placement: 'right', title: '{{$error_messages->first('end')}}', trigger: 'manual'}).tooltip('show');
        $('#form-group-end').addClass('has-error');
        @endif
        $('#addModal input[name="end"]').val('{{$input_values['end']}}');
    });            
    @endif
    

    $('#start, #end').datetimepicker(); 

    $('#calendar').fullCalendar({
        viewRender: function(view, element) {
            bindContextMenu();
        },
        eventDragStart: function(event, jsEvent, ui, view) {
            $(".fc-day, .fc-event-inner, .fc-widget-content, .fc-day-content").ClassyContextMenu("hide");
            console.log(event, jsEvent, ui, view);
        },
        eventDragStop: function(view, element) {
            bindContextMenu();
        },
        eventResizeStart: function() {
            $(".fc-day, .fc-event-inner, .fc-widget-content, .fc-day-content").ClassyContextMenu("hide");
        },
        eventResizeStop: function(view, element) {
            bindContextMenu();
        },
        dayClick: function(date, jsEvent, view) {
            $('input[name="start"]').val(date.format() + ' 00:00');
        },
        eventClick: function (calEvent, jsEvent, view) {
            setTimeout(function() {
            }, 500);
        },
        eventMouseover: function(event, jsEvent, view) {
            tempEvent = event;
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2014-07-12',
        editable: true,
        events: <?php echo App::make('Admin\EventController')->getEventThisMonth(); ?>
    });

});

</script>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/event/create')}}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add New Event</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-title">
                <label class="col-sm-3 control-label" for="title">Title</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="title" rows="3" rel="tooltiptitle"></textarea>
                </div>
              </div>
              <div class="form-group" id="form-group-start">
                <label class="col-sm-3 control-label">Start</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="start">
                    <input type="text" class="form-control" name="start" data-format="YYYY-MM-DD HH:mm" placeholder="YYYY-MM-DD HH:mm"/>
                    <span class="input-group-addon" rel="tooltipstart"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-end">
                <label class="col-sm-3 control-label">End</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="end">
                    <input type="text" class="form-control" name="end" data-format="YYYY-MM-DD HH:mm" placeholder="YYYY-MM-DD HH:mm"/>
                    <span class="input-group-addon" rel="tooltipend"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-all_day">
                <label class="col-sm-3 control-label">All Day</label>
                <div class="col-sm-9">
                  <div class="input-group checkbox">
                      <input type="checkbox" name="all_day"/>
                  </div>
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
        <form role="form" class="form-horizontal" action="{{URL::to('admin/event/edit')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-title">
                <label class="col-sm-3 control-label" for="title">Title</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="title" rows="3" rel="tooltiptitle"></textarea>
                </div>
              </div>
              <div class="form-group" id="form-group-start">
                <label class="col-sm-3 control-label">Start</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="start">
                    <input type="text" class="form-control" name="start" data-format="YYYY-MM-DD HH:mm" placeholder="YYYY-MM-DD HH:mm"/>
                    <span class="input-group-addon" rel="tooltipstart"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-end">
                <label class="col-sm-3 control-label">End</label>
                <div class="col-sm-9">
                  <div class="input-group date pull-right" id="end">
                    <input type="text" class="form-control" name="end" data-format="YYYY-MM-DD HH:mm" placeholder="YYYY-MM-DD HH:mm"/>
                    <span class="input-group-addon" rel="tooltipend"><span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="form-group-all_day">
                <label class="col-sm-3 control-label">All Day</label>
                <div class="col-sm-9">
                  <div class="input-group checkbox">
                      <input type="checkbox" name="all_day"/>
                  </div>
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
<div class="modal fade bs-example-modal-sm" id="delModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Event Delete Confirmation</h4>
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
<!-- End delete confirmation modal -->

@if (Session::has('add_event_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Event added.
</div>
@endif

@if (Session::has('edit_event_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Event edited.
</div>
@endif

@if (Session::has('delete_event_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Event deleted.
</div>
@endif

<h1 class="page-header">Event Calendar</h1>

<div class="col-lg-9" style="padding-left: 0;">
    <button type="button" id="btn-add-new" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New Event</button>
    <a type="button" href="{{ URL::to('admin/event/list') }}" id="btn-show-list" class="btn btn-primary btn-sm"><i class="fa fa-align-justify"></i> &nbsp;Show Event List</a>
</div>

<div class="col-lg-3" style="padding-right: 0;">
    <div class="input-group pull-right">
        <input type="text" class="form-control" placeholder="quick search ..." name="key" value="{{ (isset($key) ? $key : ''); }}">
        <span class="input-group-btn">
            <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
        </span>
    </div>
</div>

<br/>

<div id="eventmenu" class="hide">
    <ul>
        <li id="menu-view"><a href="http://google.com">View</a></li>
        <li id="menu-edit"><a href="#" data-toggle="modal" data-target="#editModal">Edit</a></li>
        <li id="menu-delete"><a href="#" data-toggle="modal" data-target="#delModal">Delete</a></li>
    </ul>
</div>

<div id="daymenu" class="hide">
    <ul>
        <li id="menu-addevent"><a href="#" data-toggle="modal" data-target="#addModal">Add Event</a></li>
    </ul>
</div>

<script>

var firstTriggerDayMenu = false;
var firstTriggerEventMenu = false;

function bindContextMenu() {
    
    firstTriggerDayMenu = false;
    firstTriggerEventMenu = false;
    
    setTimeout(function() {
        
        $("#eventmenu, #daymenu").removeClass("hide");
        
        $(".fc-event-inner").ClassyContextMenu({
            menu: 'eventmenu',
            mouseButton: 'left',
            onSelect: function(e) {       
                if (e.id === "menu-delete") {
                    
                    if (!firstTriggerEventMenu) {
                        $('#menu-delete a').trigger('click');
                        firstTriggerEventMenu = true;
                    }
                    
                    var html = '<h4 style="text-align:center;font-weight:bold;">Delete this event: "'+tempEvent.title+'" ?</h4>';
                    $('#modal-del-content').html(html);
                    $('#btn-do-delete').attr('href', '{{URL::to("admin/event/delete")}}/'+tempEvent.id);
                }
                
                if (e.id === "menu-edit") {
                    console.log(tempEvent);
                    
                    if (!firstTriggerEventMenu) {
                        $('#menu-edit a').trigger('click');
                        firstTriggerEventMenu = true;
                    }
                    
                    $('#editModal input[name="id"]').val(tempEvent.id);
                    $('#editModal textarea[name="title"]').val(tempEvent.title);
                    $('#editModal input[name="start"]').val(tempEvent.start._i);
                    $('#editModal input[name="end"]').val(tempEvent.end._i);
                    if (tempEvent.all_day === 1) {
                        $('#editModal input[name="all_day"]').prop('checked', true);
                    } else {
                        $('#editModal input[name="all_day"]').prop('checked', false);
                    }
                }
            }
        });

//        $(".fc-day").ClassyContextMenu({
//            menu: 'daymenu',
//            mouseButton: 'left',
//            onShow: function(e) {
//                $("#menu-addevent").click(function() {
//                    setTimeout(function() {
//                        $('#menu-addevent a').trigger('click');
//                    }, 100);
//                });
//            },
//            onSelect: function(e) {
//                if (!firstTriggerDayMenu) {
//                    $('#menu-addevent a').trigger('click');
//                    firstTriggerDayMenu = true;
//                }
//            }
//        });

        $('.fc-widget-content').ClassyContextMenu({
            menu: 'daymenu',
            mouseButton: 'left',
            onSelect: function(e) {
                if (!firstTriggerDayMenu) {
                    $('#menu-addevent a').trigger('click');
                    firstTriggerDayMenu = true;
                }
            }
        });
        
    }, 500);
}

$(function() {
    
    bindContextMenu();
    
    $('.fc-button').hover(function() {
        $(".fc-day, .fc-event-inner, .fc-widget-content, .fc-day-content").ClassyContextMenu("hide");
    });
    
});
</script>

<div id="calendar"></div>
    
@stop