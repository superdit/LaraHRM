<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Salary Component
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
                  <td></td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>

<!----------------------------------------------------------------------------->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Salary Deduction
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
                  <td></td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>