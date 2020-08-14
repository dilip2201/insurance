@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Premium Report')

<div class="container">
    <!-- Info boxes -->

    <div class="row">

        <div class="col-12">
            <div class="card card-info card-outline displaybl">
                <div class="card-body" style="padding: 10px 15px;">
                    <div class="col-lg-12">
                      <div class="form-group row " style="margin-bottom: 0px;">
                        <div class="col-md-2">
                             <div class="form-group">
                                <label><b>Client: </b>
                                </label>
                                <select class="form-control client select2" id="client" name="client">
                                  <option value=""> Select Client</option>
                                   @if(!empty($clients))
                                   @foreach($clients as $client) 
                                   
                                   <option value="{{ $client->id }}"> {{ $client->name_salutation }} {{ $client->first_name }} {{ $client->last_name }}</option>
                                   @endforeach
                                   @endif
                                </select>
                             </div>
                          </div>
                          <div class="col-md-2">
                             <div class="form-group">
                                <label><b>Group: </b>
                                </label>
                                <select class="form-control group select2" id="group" name="group">
                                   <option value=""> Select Group</option>
                                   @if(!empty($groups))
                                   @foreach($groups as $group) 
                                  
                                   <option value="{{ $group->id }}"> {{ $group->name }}</option>
                                   @endforeach
                                   @endif
                                </select>
                             </div>
                          </div>
                          <div class="col-md-2">
                             <div class="form-group">
                                <label><b>Company: </b>
                                </label>
                                <select class="form-control company select2" id="company" name="company">
                                   <option value=""> Select Company</option>
                                   @if(!empty($companies))
                                   @foreach($companies as $company) 
                                  
                                   <option value="{{ $company->id }}"> {{ $company->name }}</option>
                                   @endforeach
                                   @endif
                                </select>
                             </div>
                          </div>
                          <div class="col-md-2">
                             <div class="form-group">
                                <label>Work:</label>
                                <select class="form-control" name="work"  class="work" id="work">
                                   <option value=""> Select Work</option>
                                   <option value="accounting"> Accounting</option>
                                   <option value="audit" > Audit</option>
                                   <option value="GST"> GST</option>
                                   <option value="TDS" > TDS</option>
                                   <option value="income_tax" > Income Tax</option>
                                   <option value="LIC" > LIC</option>
                                   <option value="personal_accident"> Personal Accident</option>
                                   <option value="term_plan" > Term Plan</option>
                                   <option value="mediclaim" > Mediclaim</option>
                                   <option value="top-up_mediclaim" > Top-up Mediclaim</option>
                                   <option value="vehical_insurance" > Vehical Insurance</option>
                                   <option value="mutual_funds" > Mutual Funds</option>
                                   <option value="SIP" > SIP</option>
                                   <option value="fixed_deposit" > Fixed Deposit</option>
                                   <option value="others" > Others</option>
                                </select>
                             </div>
                          </div>

                          <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                               <label>Start Date</label>
                               <input type="date" placeholder="Start Date" class="form-control start_date" id = "start_date" name="start_date" value="{{$start}}">
                            </div>
                          </div>
                         <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                               <label>End Date</label>
                               <input type="date" placeholder="End Date" class="form-control end_date" id="end_date" name="end_date" value="{{$end}}">
                            </div>
                         </div>
                            <div class="col-md-2" style="padding-left: 7.5px;">
                                <button class="btn btn-success btn-sm searchdata"
                                        style="padding: 6px 16px;">Search <span
                                        class="spinner"></span>
                                </button>
                                <a href="{{ url('admin/premiumreport') }}" class="btn btn-danger btn-sm"
                                   style="margin-left: 5px;padding: 6px 16px;cursor: pointer; ">
                                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="card  card-outline">
               
                <div class="card-body">
                    <!-- /.card-header -->
                    <table id="employee" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Due Date</th>
                            <th>Client</th>
                            <th>Work</th>
                            <th>Company</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!-- /.card-body -->
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
        </div>

    </div>
    <!-- /.row -->
</div>
<div class="modal fade add_modal" >
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title">Large Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body addholidaybody">
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade add_log" >
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title">Due date</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body addholidaybodylog">
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade history_log" >
   <div class="modal-dialog  modal-lg">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title"><i class="fa fa-history" aria-hidden="true"></i> Logs</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body historylog">
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>



@push('script')
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        $(function () {
            /* datatable */
            $("#employee").DataTable({
                "responsive": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    'url': "{{ route('admin.premiumreport.getall') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.start_date = $("#start_date").val();
                        d.end_date = $("#end_date").val();
                        d.work = $("#work").val();
                        d.client = $("#client").val();
                        d.group = $("#group").val();
                        d.company = $("#company").val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "orderable": false},
                    {data: 'due_date'},
                    {data: 'client_id'},
                    {data: 'work_id'},
                    {data: 'company_id'},
                    {data: 'amount'},
                    {data: 'status'},
                    {data: 'action', orderable: false},
                ]
            });
            /*filter*/
            $('.searchdata').click(function () {
                event.preventDefault();
                $("#employee").DataTable().ajax.reload()
            });


                  /********* add new todo ********/
   $('body').on('click', '.openaddmodallog', function () {
       var id = $(this).data('id');

       $.ajax({
           url: "{{ route('admin.premiumreport.getmodallog')}}",
           type: 'POST',
           headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}'
           },
           data: {id: id},
           success: function (data) {
               $('.addholidaybodylog').html(data);
                   var status =$('.datechangeadd').val();
                    if(status == 'Pending' || status == 'Hold'){
                      $(".datechange").css("display", "block");
                    }else{
                      $(".datechange").css("display", "none");
                    }
                   $(".formsubmitlog").validate({
    
                   });
   
           },
       });
   });

      /** change status**/
   $('body').on('change', '.changestatus', function () {

       var id = $(this).find(':selected').data('id');
       var status = $(this).find(':selected').data('status');

  
       (new PNotify({
           title: "Confirmation Needed",
           text: "Are you sure you wants to "+ status +" this record?",
           icon: 'glyphicon glyphicon-question-sign',
           hide: false,
           confirm: {
               confirm: true
           },
           buttons: {
               closer: false,
               sticker: false
           },
           history: {
               history: false
           },
           addclass: 'stack-modal',
           stack: {
               'dir1': 'down',
               'dir2': 'right',
               'modal': true
           }
       })).get().on('pnotify.confirm', function () {
           $.ajax({
               url: '{{ route("admin.premiumreport.changestatus") }}',
               type: 'POST',
               headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               data: {id: id, status: status},
               success: function (data) {
                   $("#employee").DataTable().ajax.reload();
                   toastr.success('Status changed successfully.', 'Success!');
               },
               error: function () {
                   toastr.error('Something went wrong!', 'Oh No!');
   
               }
           });
       });

   
   });
            /********* add new todo ********/
   $('body').on('click', '.history_log_show', function () {
       var id = $(this).data('id');

       $.ajax({
           url: "{{ route('admin.premiumreport.getmodalhistory')}}",
           type: 'POST',
           headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}'
           },
           data: {id: id},
           success: function (data) {
               $('.historylog').html(data);
           },
       });
   });
         /********* form submit ********/
   $('body').on('submit', '.formsubmitlog', function (e) {
       e.preventDefault();
       $.ajax({
           url: $(this).attr('action'),
           data: new FormData(this),
           type: 'POST',
           contentType: false,
           cache: false,
           processData: false,
           beforeSend: function () {
               $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
           },
           success: function (data) {
              
               if (data.status == 400) {
                   $('.spinner').html('');
                   toastr.error(data.msg)
               }
               if (data.status == 200) {
                   $('.spinner').html('');
                   $('.add_log').modal('hide');
                   $('#employee').DataTable().ajax.reload();
                   toastr.success(data.msg,'Success!')
               }
           },
       });
   });
        });
    </script>
@endpush
@endsection
