@extends('layouts/backend')

@section('content')

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

<h1 class="page-header">Event Calendar</h1>

<div class="col-lg-9" style="padding-left: 0;">
    <button type="button" id="btn-add-new" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New Event</button>
    <a type="button" href="{{ URL::to('admin/event') }}" id="btn-show-list" class="btn btn-primary btn-sm"><i class="fa fa-calendar"></i> &nbsp;Show Calendar</a>
</div>

<div class="col-lg-3" style="padding-right: 0;">
    <div class="input-group pull-right">
        <input type="text" class="form-control" placeholder="quick search ..." name="key" value="{{ (isset($key) ? $key : ''); }}">
        <span class="input-group-btn">
            <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
        </span>
    </div>
</div

<br/><br/><br/><br/>

<div class="panel panel-default">
    <div class="panel-heading">List of Events</div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="35%">#Title</th>
              <th width="20%">#Start</th>
              <th width="20%">#End</th>
              <th width="10%" class="text-center">#All Day</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody>
          @foreach ($events as $index => $event) 
          <tr>
              <td>{{ $event->title }}</td>
              <td>{{ $event->start }}</td>
              <td>{{ $event->end }}</td>
              <td class="text-center">
                  @if ( $event->all_day == 1)
                  <i class="fa fa-check"></i>
                  @else
                  <i class="fa fa-times">
                  @endif
              </td>
              <td id="td_{{ $event->id }}" class="text-right">
                  <a href="" title="quick edit" id="edit_{{ $event->id }}" class="btn btn-xs btn-success btn-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                  <a href="" title="delete employee" id="del_{{ $event->id }}" class="btn btn-xs btn-danger btn-empl-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
              </td>              
          </tr>
          @endforeach
          </tbody>
        </table>
        {{ $paginate->links() }}
        <div class="pull-right">
            <br/>
            <p class="text-muted" style="margin-top: 5px;">{{ $paginate->getFrom() }} to {{ $paginate->getTo() }} of {{ $paginate->getTotal() }} Events&nbsp;&nbsp;</p>
        </div>
      </div>  
    </div>

</div>

@stop