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
    $('.salcomp_amount').priceFormat({prefix: 'Rp. ', centsLimit: 3, thousandsSeparator: '.'});
    
    @if (Session::has('add_salcomp_failed'))
        $('#addModal').modal('show');
        $('#addModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name').addClass('has-error');
            @endif
            $('#addModal input[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('amount') != "")
            $("[rel='tooltipamount']").tooltip({placement: 'right', title: '{{$error_messages->first('amount')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-amount').addClass('has-error');
            @endif
            $('#addModal input[name="amount"]').val('{{$input_values['amount']}}');
            
            $('#addModal select[name="paid"]').val('{{$input_values['paid']}}');
            $('#addModal select[name="calculate"]').val('{{$input_values['calculate']}}');
        });            
    @endif 
    
    @if ($open_edit_modal == 1)
        $('#editModal').modal('show');
        $('#editModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-edit').addClass('has-error');
            @endif
            $('#editModal input[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('amount') != "")
            $("[rel='tooltipamount-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('amount')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-amount-edit').addClass('has-error');
            @endif
            $('#editModal input[name="amount"]').val('{{$input_values['amount']}}');
            
            $('#editModal select[name="paid"]').val('{{$input_values['paid']}}');
            $('#editModal select[name="calculate"]').val('{{$input_values['calculate']}}');
            $('#editModal input[name="id"]').val('{{$input_values['id']}}');
        });            
    @endif 
    
    // Event on show delete modal confirmation
    $('.btn-sal-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#salary_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this salary component: "'+title+'" ?</h4>';
        $('#modal-del-content').html(html);

        $('#btn-do-delete').attr('href', '{{URL::to("admin/salarycomponent/delete")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-sal-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_name = $('#td_' + tmp_id + ' input[name="hid_name"]').val();
        var tmp_amount = $('#td_' + tmp_id + ' input[name="hid_amount"]').val();
        var tmp_paid = $('#td_' + tmp_id + ' input[name="hid_paid"]').val();
        var tmp_calculate = $('#td_' + tmp_id + ' input[name="hid_calculate"]').val();

        setTimeout(function() {
            $('#editModal input[name="name"]').val(tmp_name);
            $('#editModal input[name="amount"]').val(tmp_amount);
            $('#editModal input[name="id"]').val(tmp_id);
            $('#editModal select[name="paid"]').val(tmp_paid);
            $('#editModal select[name="calculate"]').val(tmp_calculate);

            $("[rel='tooltipname-edit'], [rel='tooltipamount-edit']").tooltip('destroy');
            $('#form-group-name-edit, #form-group-amount-edit').removeClass('has-error');
        }, 500);

    });
});
</script>
@if (Session::has('add_salcomp_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> New Salary Component added.
</div>
@endif

@if (Session::has('add_saldeduc_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> New Salary Deduction added.
</div>
@endif

@if (Session::has('edit_salcomp_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Salary Component updated.
</div>
@endif

@if (Session::has('edit_saldeduc_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Salary Deduction updated.
</div>
@endif

@if (Session::has('delete_salcomp_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Salary Component deleted.
</div>
@endif

@if (Session::has('delete_saldeduc_success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> Salary Deduction deleted.
</div>
@endif

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/salarycomponent/create')}}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add New Salary Component</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" rel="tooltipname">
                </div>
              </div>
              <div class="form-group" id="form-group-paid">
                <label class="col-sm-3 control-label" for="paid">Paid</label>
                <div class="col-sm-9">
                  <select class="form-control" name="paid">
                      <option value="weekly">weekly</option>
                      <option value="bi-weekly">bi-weekly</option>
                      <option value="monthly">monthly</option>
                      <option value="bi-monthly">bi-monthly</option>
                      <option value="yearly">yearly</option>
                  </select>
                </div>
              </div>
              <div class="form-group" id="form-group-amount">
                <label class="col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="amount" rel="tooltipamount">
                </div>
              </div>
              <div class="form-group" id="form-group-paid">
                <label class="col-sm-3 control-label" for="calculate">Calculate Salary</label>
                <div class="col-sm-9">
                  <select class="form-control" name="calculate">
                      <option value="per hour">per hour</option>
                      <option value="per day">per day</option>
                      <option value="per week">per week</option>
                      <option value="per month">per month</option>
                      <option value="per year">per year</option>
                  </select>
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
        <form role="form" class="form-horizontal" action="{{URL::to('admin/salarycomponent/edit')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Salary Component</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name-edit">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" rel="tooltipname-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-paid-edit">
                <label class="col-sm-3 control-label" for="paid">Paid</label>
                <div class="col-sm-9">
                  <select class="form-control" name="paid">
                      <option value="weekly">weekly</option>
                      <option value="bi-weekly">bi-weekly</option>
                      <option value="monthly">monthly</option>
                      <option value="bi-monthly">bi-monthly</option>
                      <option value="yearly">yearly</option>
                  </select>
                </div>
              </div>
              <div class="form-group" id="form-group-amount-edit">
                <label class="col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="amount" rel="tooltipamount-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-paid-edit">
                <label class="col-sm-3 control-label" for="calculate">Calculate Salary</label>
                <div class="col-sm-9">
                  <select class="form-control" name="calculate">
                      <option value="per hour">per hour</option>
                      <option value="per day">per day</option>
                      <option value="per week">per week</option>
                      <option value="per month">per month</option>
                      <option value="per year">per year</option>
                  </select>
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
        <h4 class="modal-title" id="myModalLabel">Salary Component Delete Confirmation</h4>
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

<div style="padding-top: 10px;" class="container-fluid row">
    <div class="col-lg-9" style="padding-left: 0;">
        <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> &nbsp;Add New</button>
        <button type="button" id="btn-del" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>
    </div>

    <div class="col-lg-3" style="padding-right: 0;">
<!--        <div class="input-group pull-right">
            <input type="text" class="form-control" placeholder="quick search..." name="key" value="{{ (isset($key) ? $key : ''); }}">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
            </span>
        </div>-->
    </div>
</div>
    
<br/>

<div class="panel panel-default">
    <div class="panel-heading">List of Salary Component</div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="5%"><input type="checkbox"></th>  
              <th width="25%">#Salary Component </th>
              <th width="20%">#Amount</th>
              <th width="20%">#Paid</th>
              <th width="15%">#Calculate</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody>
          @foreach($salaryComponents as $index => $salary)
          <tr>
              <td><input type="checkbox"></td>
              <td id="salary_{{$salary->id}}">{{ $salary->name }}</td>
              <td class="salcomp_amount">{{ $salary->amount }}</td>
              <td>{{ $salary->paid }}</td>
              <td>{{ $salary->calculate }}</td>
              <td id="td_{{$salary->id}}" class="text-right">
                  <input type="hidden" name="hid_id" value="{{ $salary->id }}"/>
                  <input type="hidden" name="hid_name" value="{{ $salary->name }}"/>
                  <input type="hidden" name="hid_amount" value="{{ $salary->amount }}"/>
                  <input type="hidden" name="hid_paid" value="{{ $salary->paid }}"/>
                  <input type="hidden" name="hid_calculate" value="{{ $salary->calculate }}"/>
                  <a href="" title="quick edit" id="edit_{{$salary->id}}" class="btn btn-xs btn-success btn-sal-edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                  <a href="" title="delete salary component" id="del_{{$salary->id}}" class="btn btn-xs btn-danger btn-sal-del" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-trash-o"></i></a>
              </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>

    </div>
</div>
    
<!----------------------------------------------------------------------------->    
<script>
$(function() {
    @if (Session::has('add_saldeduc_failed'))
        $('#addDeducModal').modal('show');
        $('#addDeducModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-deduc']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-deduc').addClass('has-error');
            @endif
            $('#addDeducModal input[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('amount') != "")
            $("[rel='tooltipamount-deduc']").tooltip({placement: 'right', title: '{{$error_messages->first('amount')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-amount-deduc').addClass('has-error');
            @endif
            $('#addDeducModal input[name="amount"]').val('{{$input_values['amount']}}');
            
            $('#addDeducModal textarea[name="description"]').val('{{$input_values['description']}}');
        });            
    @endif     
    
    @if (Session::has('edit_saldeduc_failed'))
        $('#editDeducModal').modal('show');
        $('#editDeducModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('name') != "")
            $("[rel='tooltipname-deduc-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-name-deduc-edit').addClass('has-error');
            @endif
            $('#editDeducModal input[name="name"]').val('{{$input_values['name']}}');
            
            @if (isset($error_messages) && $error_messages->first('amount') != "")
            $("[rel='tooltipamount-deduc-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('amount')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-amount-deduc-edit').addClass('has-error');
            @endif
            $('#editDeducModal input[name="amount"]').val('{{$input_values['amount']}}');
            
            $('#editDeducModal textarea[name="description"]').val('{{$input_values['description']}}');
            $('#editDeducModal input[name="id"]').val('{{$input_values['id']}}');
        });            
    @endif     
    
    // Event on show delete modal confirmation
    $('.btn-saldeduc-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#deduc_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this salary deduction: "'+title+'" ?</h4>';
        $('#modal-del-content-deduc').html(html);

        $('#btn-do-delete-deduc').attr('href', '{{URL::to("admin/salarycomponent/delete-deduction")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-saldeduc-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_deduc_", "");
        var tmp_name = $('#td_deduc_' + tmp_id + ' input[name="hid_name"]').val();
        var tmp_amount = $('#td_deduc_' + tmp_id + ' input[name="hid_amount"]').val();
        var tmp_description = $('#td_deduc_' + tmp_id + ' input[name="hid_description"]').val();

        setTimeout(function() {
            $('#editDeducModal input[name="name"]').val(tmp_name);
            $('#editDeducModal input[name="amount"]').val(tmp_amount);
            $('#editDeducModal input[name="id"]').val(tmp_id);
            $('#editDeducModal textarea[name="description"]').val(tmp_description);

            $("[rel='tooltipname-deduc-edit'], [rel='tooltipamount-deduc-edit']").tooltip('destroy');
            $('#form-group-name-deduc-edit, #form-group-amount-deduc-edit').removeClass('has-error');
        }, 500);

    });
});   
</script>
<!-- Add Salary Deduction Modal -->
<div class="modal fade" id="addDeducModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/salarycomponent/create-deduction')}}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add New Salary Deduction</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name-deduc">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" rel="tooltipname-deduc">
                </div>
              </div>
              <div class="form-group" id="form-group-amount-deduc">
                <label class="col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="amount" rel="tooltipamount-deduc">
                </div>
              </div>
              <div class="form-group" id="form-group-description-deduc">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="description" rows="4"></textarea>
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

<!-- Edit Salary Deduction Modal -->
<div class="modal fade" id="editDeducModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/salarycomponent/edit-deduction')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Salary Deduction</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name-deduc-edit">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" rel="tooltipname-deduc-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-amount-deduc-edit">
                <label class="col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="amount" rel="tooltipamount-deduc-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-description-deduc">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="description" rows="4"></textarea>
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
<div class="modal fade" id="delDeducModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Salary Deduction Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-deduc">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-deduc" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Confirmation modal -->

<div class="col-lg-9" style="padding-left: 0;">
    <button type="button" id="btn-add" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDeducModal"><i class="fa fa-plus"></i> &nbsp;Add New</button>
    <button type="button" id="btn-del" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>
</div>

<div class="col-lg-3" style="padding-right: 0;">
<!--        <div class="input-group pull-right">
        <input type="text" class="form-control" placeholder="quick search..." name="key" value="{{ (isset($key) ? $key : ''); }}">
        <span class="input-group-btn">
            <button class="btn btn-default" id="btn-search"><i class="fa fa-search search-icon"></i></button>
        </span>
    </div>-->
</div>

<br/>

<br/><br/>

<div class="panel panel-default">
    <div class="panel-heading">List of Salary Deduction</div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="5%"><input type="checkbox"></th>  
              <th width="25%">#Salary Deduction </th>
              <th width="15%">#Amount</th>
              <th width="40%">#Description</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody>
          @foreach($salaryDeductions as $index => $deduction)
          <tr>
              <td><input type="checkbox"></td>
              <td id="deduc_{{$deduction->id}}">{{ $deduction->name }}</td>
              <td class="salcomp_amount">{{ $deduction->amount }}</td>
              <td>{{ $deduction->description }}</td>
              <td id="td_deduc_{{$deduction->id}}" class="text-right">
                  <input type="hidden" name="hid_id" value="{{ $deduction->id }}"/>
                  <input type="hidden" name="hid_name" value="{{ $deduction->name }}"/>
                  <input type="hidden" name="hid_amount" value="{{ $deduction->amount }}"/>
                  <input type="hidden" name="hid_description" value="{{ $deduction->description }}"/>
                  <a href="" title="quick edit" id="edit_deduc_{{$deduction->id}}" class="btn btn-xs btn-success btn-saldeduc-edit" data-toggle="modal" data-target="#editDeducModal"><i class="fa fa-edit"></i></a>
                  <a href="" title="delete salary deduction" id="del_{{$deduction->id}}" class="btn btn-xs btn-danger btn-saldeduc-del" data-toggle="modal" data-target="#delDeducModal"><i class="fa fa-trash-o"></i></a>
              </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>

    </div>
</div>