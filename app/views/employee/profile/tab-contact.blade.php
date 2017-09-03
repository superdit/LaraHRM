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
    
    @if (Session::has('add_contact_failed'))
        $('#addContactModal').modal('show');
        $('#addContactModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('contact_name') != "")
            $("[rel='tooltipcontact_name']").tooltip({placement: 'right', title: '{{$error_messages->first('contact_name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-contact_name').addClass('has-error');
            @endif
            $('#addContactModal input[name="contact_name"]').val('{{$input_values['contact_name']}}');
            
            @if (isset($error_messages) && $error_messages->first('relationship') != "")
            $("[rel='tooltiprelationship']").tooltip({placement: 'right', title: '{{$error_messages->first('relationship')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-relationship').addClass('has-error');
            @endif
            $('#addContactModal input[name="relationship"]').val('{{$input_values['relationship']}}');
            
            @if (isset($error_messages) && $error_messages->first('email') != "")
            $("[rel='tooltipemail']").tooltip({placement: 'right', title: '{{$error_messages->first('email')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-email').addClass('has-error');
            @endif
            $('#addContactModal input[name="email"]').val('{{$input_values['email']}}');
            
            $('#addContactModal input[name="work_phone"]').val('{{$input_values['work_phone']}}');
            $('#addContactModal input[name="home_phone"]').val('{{$input_values['home_phone']}}');
            $('#addContactModal input[name="mobile_phone"]').val('{{$input_values['mobile_phone']}}');
        });            
    @endif 
    
    @if (Session::has('edit_contact_failed'))
        $('#editContactModal').modal('show');
        $('#editContactModal').on('shown.bs.modal', function (e) {                
            @if (isset($error_messages) && $error_messages->first('contact_name') != "")
            $("[rel='tooltipcontact_name-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('contact_name')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-contact_name-edit').addClass('has-error');
            @endif
            $('#editContactModal input[name="contact_name"]').val('{{$input_values['contact_name']}}');
            
            @if (isset($error_messages) && $error_messages->first('relationship') != "")
            $("[rel='tooltiprelationship-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('relationship')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-relationship-edit').addClass('has-error');
            @endif
            $('#editContactModal input[name="relationship"]').val('{{$input_values['relationship']}}');
            
            @if (isset($error_messages) && $error_messages->first('email') != "")
            $("[rel='tooltipemail-edit']").tooltip({placement: 'right', title: '{{$error_messages->first('email')}}', trigger: 'manual'}).tooltip('show');
            $('#form-group-email-edit').addClass('has-error');
            @endif
            $('#editContactModal input[name="email"]').val('{{$input_values['email']}}');
            
            $('#editContactModal input[name="work_phone"]').val('{{$input_values['work_phone']}}');
            $('#editContactModal input[name="home_phone"]').val('{{$input_values['home_phone']}}');
            $('#editContactModal input[name="mobile_phone"]').val('{{$input_values['mobile_phone']}}');
        });            
    @endif 
    
    // Event on show delete work experience modal confirmation
    $('.btn-contact-del').click(function() { 
        var tmp_id = $(this).attr('id').replace("del_", "");
        var name = $('#contact_'+tmp_id).html();
        var html = '<h4 style="text-align:center;font-weight:bold;">Delete this employee contact: "'+name+'" ?</h4>';
        $('#modal-del-content-contact').html(html);

        $('#btn-do-delete-contact').attr('href', '{{URL::to("employee/profile/delete-contact")}}/'+tmp_id);
    });
    
    // Event on show edit modal confirmation
    $('.btn-contact-edit').click(function() {
        var tmp_id = $(this).attr('id').replace("edit_", "");
        var tmp_contact_name = $('#td_' + tmp_id + ' input[name="hid_contact_name"]').val();
        var tmp_relationship = $('#td_' + tmp_id + ' input[name="hid_relationship"]').val();
        var tmp_home_phone = $('#td_' + tmp_id + ' input[name="hid_home_phone"]').val();
        var tmp_work_phone = $('#td_' + tmp_id + ' input[name="hid_work_phone"]').val();
        var tmp_mobile_phone = $('#td_' + tmp_id + ' input[name="hid_mobile_phone"]').val();
        var tmp_email = $('#td_' + tmp_id + ' input[name="hid_email"]').val();

        setTimeout(function() {
            $('#editContactModal input[name="contact_name"]').val(tmp_contact_name);
            $('#editContactModal input[name="relationship"]').val(tmp_relationship);
            $('#editContactModal input[name="id"]').val(tmp_id);
            $('#editContactModal input[name="home_phone"]').val(tmp_home_phone);
            $('#editContactModal input[name="work_phone"]').val(tmp_work_phone);
            $('#editContactModal input[name="mobile_phone"]').val(tmp_mobile_phone);
            $('#editContactModal input[name="email"]').val(tmp_email);

            $("[rel='tooltipcontact_name-edit'], [rel='tooltiprelationship-edit'], [rel='tooltiphome_phone-edit'], [rel='tooltipwork_phone-edit'], [rel='tooltipmobile_phone-edit'], [rel='tooltipemail-edit']").tooltip('destroy');
            $('#form-group-contact_name-edit, #form-group-relationship-edit, #form-group-home_phone-edit, #form-group-work_phone-edit, #form-group-mobile_phone-edit, #form-group-email-edit').removeClass('has-error');
        }, 500);

    });
});
</script>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('employee/profile/add-contact')}}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Add Employee Contact</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-contact_name">
                <label class="col-sm-3 control-label" for="contact_name">Contact Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="contact_name" rel="tooltipcontact_name">
                </div>
              </div>
              <div class="form-group" id="form-group-relationship">
                <label class="col-sm-3 control-label" for="relationship">Relationship</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="relationship" rel="tooltiprelationship">
                </div>
              </div>
              <div class="form-group" id="form-group-home_phone">
                <label class="col-sm-3 control-label" for="home_phone">Home Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="home_phone" rel="tooltiphome_phone">
                </div>
              </div>
              <div class="form-group" id="form-group-work_phone">
                <label class="col-sm-3 control-label" for="work_phone">Work Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="work_phone" rel="tooltipwork_phone">
                </div>
              </div>
              <div class="form-group" id="form-group-mobile_phone">
                <label class="col-sm-3 control-label" for="mobile_phone">Mobile Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="mobile_phone" rel="tooltipmobile_phone">
                </div>
              </div>
              <div class="form-group" id="form-group-email">
                <label class="col-sm-3 control-label" for="email">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" rel="tooltipemail">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Contact Add Modal -->

<!-- Edit Contact Modal -->
<div class="modal fade" id="editContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" class="form-horizontal" action="{{URL::to('employee/profile/edit-contact')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id"/>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Edit Employee Contact</h4>
            </div>
            <div class="modal-body">
              <div class="form-group" id="form-group-contact_name-edit">
                <label class="col-sm-3 control-label" for="contact_name">Contact Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="contact_name" rel="tooltipcontact_name-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-relationship-edit">
                <label class="col-sm-3 control-label" for="relationship">Relationship</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="relationship" rel="tooltiprelationship-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-home_phone-edit">
                <label class="col-sm-3 control-label" for="home_phone">Home Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="home_phone" rel="tooltiphome_phone-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-work_phone-edit">
                <label class="col-sm-3 control-label" for="work_phone">Work Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="work_phone" rel="tooltipwork_phone-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-mobile_phone-edit">
                <label class="col-sm-3 control-label" for="mobile_phone">Mobile Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="mobile_phone" rel="tooltipmobile_phone-edit">
                </div>
              </div>
              <div class="form-group" id="form-group-email-edit">
                <label class="col-sm-3 control-label" for="email">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" rel="tooltipemail-edit">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
  </div>
</div>   
<!-- End Contact Edit Modal -->

<!-- Delete Contact Confirmation modal -->
<div class="modal fade" id="delContactModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Employee Contact Delete Confirmation</h4>
      </div>
      <div class="modal-body" id="modal-del-content-contact">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="" id="btn-do-delete-contact" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Contact Confirmation modal -->

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        Emergency Contact
        <a href="#" title="add work experience" class="pull-right btn btn-xs btn-default" data-toggle="modal" data-target="#addContactModal"><i class="fa fa-plus"></i></a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th width="20%">#Contact Name</th>
                  <th width="20%">#Relationship</th>
                  <th width="15%">#Work Phone</th>
                  <th width="15%">#Home Phone</th>
                  <th width="15%">#Mobile Phone</th>
                  <th width="15%"></th>
                </tr>
              </thead>
              <tbody>
              @foreach($employee->contact as $index => $contact)
              <tr>
                  <td id="contact_{{$contact->id}}">{{ $contact->contact_name }}</td>
                  <td>{{ $contact->relationship }}</td>
                  <td>{{ $contact->work_phone }}</td>
                  <td>{{ $contact->home_phone }}</td>
                  <td>{{ $contact->mobile_phone }}</td>
                  <td id="td_{{$contact->id}}" class="text-right">
                      <input type="hidden" name="hid_id" value="{{ $contact->id }}"/>
                      <input type="hidden" name="hid_contact_name" value="{{ $contact->contact_name }}"/>
                      <input type="hidden" name="hid_relationship" value="{{ $contact->relationship }}"/>
                      <input type="hidden" name="hid_work_phone" value="{{ $contact->work_phone }}"/>
                      <input type="hidden" name="hid_home_phone" value="{{ $contact->home_phone }}"/>
                      <input type="hidden" name="hid_mobile_phone" value="{{ $contact->mobile_phone }}"/>
                      <input type="hidden" name="hid_email" value="{{ $contact->email }}"/>
                      <a href="" title="quick edit" id="edit_{{$contact->id}}" class="btn btn-xs btn-success btn-contact-edit" data-toggle="modal" data-target="#editContactModal"><i class="fa fa-edit"></i></a>
                      <a href="" title="delete contact" id="del_{{$contact->id}}" class="btn btn-xs btn-danger btn-contact-del" data-toggle="modal" data-target="#delContactModal"><i class="fa fa-trash-o"></i></a>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>