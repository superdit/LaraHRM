<script>
$(function() {
   $('.salcomp_amount').priceFormat({prefix: 'Rp. ', centsLimit: 3, thousandsSeparator: '.'});
    
   var arrSalary = new Array(); 
   var tempSalary;
   @foreach ($salaryComponents as $index => $salary)
   tempSalary = {id:"{{$salary->id}}", name:"{{$salary->name}}", paid:"{{$salary->paid}}", amount:"{{$salary->amount}}", calculate:"{{$salary->calculate}}"};
   arrSalary[{{$salary->id}}] = tempSalary;
   @endforeach
   
   <?php
   $totalSalComp = count($salaryComponents);
   $empSalCompCount = count($employee->salarycomponent->lists('name')); 
   ?>
   
   $('select[name="salary_component_id"]').change(function() {
       var salary = arrSalary[$(this).val()];
       $('#info_paid').val(salary.paid);
       $('#info_amount').val(salary.amount);
       $('#info_calculate').val(salary.calculate);
   });
   
   @if ($totalSalComp != $empSalCompCount)
   $('#btnAddSalComp').click(function() {
        var salary = arrSalary[$('select[name="salary_component_id"]').val()];
        $('#info_paid').val(salary.paid);
        $('#info_amount').val(salary.amount);
        $('#info_calculate').val(salary.calculate); 
   });
   @else
   $('#btnAddSalComp').attr('disabled', 'true');
   @endif;
   
   // Event on show delete modal confirmation
   $('.btn-sal-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_", "");
        var title = $('#salary_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this salary component: "'+title+'" ?</h4>';
        $('#modal-del-content-salcomp').html(html);

        $('#btn-do-delete-salcomp').attr('href', '{{URL::to("admin/employee/delete-salary-component")}}/'+{{$employee->id}}+'/'+tmp_id);
   });
});  
</script>

<!-- Add Modal -->
<div class="modal fade" id="addSalaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/employee/add-salary-component')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Salary Component</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <select class="form-control" name="salary_component_id">
                      @foreach ($salaryComponents as $index => $salary)
                      @if (!in_array($salary->name, $employee->salarycomponent->lists('name')))
                      <option value="{{ $salary->id }}">{{ $salary->name }}</option>
                      @endif
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group" id="form-group-name">
                <label class="col-sm-3 control-label" for="name"></label>
                <div class="col-sm-9">
                    <small><strong>Salary Component Information</strong></small>
                </div>
              </div>
              <div class="form-group" id="form-group-paid">
                <label class="col-sm-3 control-label" for="paid">Paid</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="info_paid" value="{{$salaryComponents[0]->paid}}" disabled="true">
                </div>
              </div>
              <div class="form-group" id="form-group-amount">
                <label class="col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="info_amount" value="{{$salaryComponents[0]->amount}}" disabled="true">
                </div>
              </div>
              <div class="form-group" id="form-group-paid">
                <label class="col-sm-3 control-label" for="calculate">Calculate Salary</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="info_calculate" value="{{$salaryComponents[0]->calculate}}" disabled="true">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Add Salary Component">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Add Modal -->

<!-- Delete Confirmation modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Salary Component Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-salcomp">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-salcomp" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Confirmation modal -->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Salary Component
        <a href="#" title="add salary component" id="btnAddSalComp" data-toggle="modal" data-target="#addSalaryModal" class="pull-right btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="30%">#Salary Component </th>
                  <th width="20%">#Amount</th>
                  <th width="20%">#Paid</th>
                  <th width="15%">#Calculate</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee->salarycomponent as $index => $salary)
              <tr>
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
   var arrSalaryDeduc = new Array(); 
   var tempSalaryDeduc;
   @foreach ($salaryDeductions as $index => $salary)
   tempSalaryDeduc = {id:"{{$salary->id}}", name:"{{$salary->name}}", amount:"{{$salary->amount}}", description:"{{$salary->description}}"};
   arrSalaryDeduc[{{$salary->id}}] = tempSalaryDeduc;
   @endforeach
   
   <?php
   $totalSalDeduc = count($salaryDeductions);
   $empSalDeducCount = count($employee->salarydeduction->lists('name')); 
   ?>
   
   $('select[name="salary_deduction_id"]').change(function() {
       var salary = arrSalaryDeduc[$(this).val()];
       $('#info_paid_d').val(salary.paid);
       $('#info_amount_d').val(salary.amount);
       $('#info_description_d').val(salary.description);
   });
   
   @if ($totalSalDeduc != $empSalDeducCount)
   $('#btnAddSalDeduc').click(function() {
        var salary = arrSalaryDeduc[$('select[name="salary_deduction_id"]').val()];
        $('#info_paid_d').val(salary.paid);
        $('#info_amount_d').val(salary.amount);
        $('#info_description_d').val(salary.description); 
   });
   @else
   $('#btnAddSalDeduc').attr('disabled', 'true');
   @endif;
      
   // Event on show delete modal confirmation
   $('.btn-saldeduc-del').click(function() {
        var tmp_id = $(this).attr('id').replace("del_deduc_", "");
        var title = $('#salary_deduc_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this salary deduction: "'+title+'" ?</h4>';
        $('#modal-del-content-saldeduc').html(html);

        $('#btn-do-delete-saldeduc').attr('href', '{{URL::to("admin/employee/delete-salary-deduction")}}/'+{{$employee->id}}+'/'+tmp_id);
   });
});
</script>

<!-- Add Deduction Modal -->
<div class="modal fade" id="addDeductionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('admin/employee/add-salary-deduction')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Salary Deduction</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-name">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-9">
                  <select class="form-control" name="salary_deduction_id">
                      @foreach ($salaryDeductions as $index => $salary)
                      @if (!in_array($salary->name, $employee->salarydeduction->lists('name')))
                      <option value="{{ $salary->id }}">{{ $salary->name }}</option>
                      @endif
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group" id="form-group-name">
                <label class="col-sm-3 control-label" for="name"></label>
                <div class="col-sm-9">
                    <small><strong>Salary Deduction Information</strong></small>
                </div>
              </div>
              <div class="form-group" id="form-group-amount">
                <label class="col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="info_amount_d" value="{{$salaryDeductions[0]->amount}}" disabled="true">
                </div>
              </div>
              <div class="form-group" id="form-group-paid">
                <label class="col-sm-3 control-label" for="calculate">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="4" id="info_description_d" disabled="true">{{$salaryDeductions[0]->description}}</textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Add Salary Deduction">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Add Modal -->


<!-- Delete Confirmation modal -->
<div class="modal fade" id="delDeductionModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Salary Deduction Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-saldeduc">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-saldeduc" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Confirmation modal -->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Salary Deduction
        <a href="#" id="btnAddSalDeduc" title="add salary deduction" data-toggle="modal" data-target="#addDeductionModal" class="pull-right btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="30%">#Salary Deduction </th>
                  <th>#Amount</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee->salarydeduction as $index => $salary)
              <tr>
                  <td id="salary_deduc_{{$salary->id}}">{{ $salary->name }}</td>
                  <td class="salcomp_amount">{{ $salary->amount }}</td>
                  <td id="td_deduc_{{$salary->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $salary->id }}"/>
                      <input type="hidden" name="hid_name" value="{{ $salary->name }}"/>
                      <input type="hidden" name="hid_amount" value="{{ $salary->amount }}"/>
                      <input type="hidden" name="hid_description" value="{{ $salary->description }}"/>
                      <a href="" title="delete salary deduction" id="del_deduc_{{$salary->id}}" class="btn btn-xs btn-danger btn-saldeduc-del" data-toggle="modal" data-target="#delDeductionModal"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>