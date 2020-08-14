@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Works') 
<style>
   .switchToggle input:checked + label, .switchToggle input:checked + input + label {
   background: #ee9a00;
   }
   .switchToggle label {
   background: green;
   }

   .switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before{
    content: 'Close';
   }
   .switchToggle label{
      width: 84px;
      max-width: 84px;
   }
   .switchToggle input + label:before, .switchToggle input + input + label:before{
    content: 'Open';
   }
   .switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before{
    width: 42px;
   }
   .switchToggle input + label:before, .switchToggle input + input + label:before{
      width: 42px;
   }
   .switch {
   position: relative;
   display: inline-block;
   width: 60px;
   height: 34px;
   }
   .switch input { 
   opacity: 0;
   width: 0;
   height: 0;
   }
   .slider {
   position: absolute;
   cursor: pointer;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background-color: #ccc;
   -webkit-transition: .4s;
   transition: .4s;
   }
   .slider:before {
   position: absolute;
   content: "";
   height: 26px;
   width: 26px;
   left: 4px;
   bottom: 4px;
   background-color: white;
   -webkit-transition: .4s;
   transition: .4s;
   }
   input:checked + .slider {
   background-color: #2196F3;
   }
   input:focus + .slider {
   box-shadow: 0 0 1px #2196F3;
   }
   input:checked + .slider:before {
   -webkit-transform: translateX(26px);
   -ms-transform: translateX(26px);
   transform: translateX(26px);
   }
   /* Rounded sliders */
   .slider.round {
   border-radius: 34px;
   }
   .slider.round:before {
   border-radius: 50%;
   }
</style>
<div class="container">
   <div class="row">
      <div class="col-12" style="margin-top: -40px;">
         <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal"
            class="btn btn-info btn-sm openaddmodal" data-id="" style="float: right; ">
         <i class="fa fa-plus"></i> Add New
         </a>

      </div>
      <div class="col-12">
         <div class="card card-info card-outline displaybl"  >
            <div class="card-body" style="padding: 10px 15px;">
               <div class="col-lg-12">
                  <div class="form-group row " style="margin-bottom: 0px;">
                     <form method="post" style="display: contents;"  action="{{route('admin.works.downloadpdf')}}">
                        {{ csrf_field() }}
                        <input type="hidden" class="download_type" value="">
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
                        <div class="col-md-2">
                           <div class="form-group">
                              <label>Status:</label>
                              <select class="form-control" name="status"  class="status" id="status">
                                 <option value=""> Select Status</option>
                                 <option value="open" selected=""> Open</option>
                                 <option value="closed" >Close</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Date: </b></label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-default pull-right daterange"
                                            id="daterange-btn">
                                        <input type="hidden" name="startdate" class="startdate">
                                        <input type="hidden" name="enddate" class="enddate">
                                        <span><i class="fa fa-calendar"></i>
                                            
                                        </span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5" style="padding-left: 0px;">
                           <button class="btn btn-success btn-sm searchdata" style="padding: 6px 16px;">Search <span
                              class="spinner"></span>
                           </button>
                           <a href="{{ route('admin.works.index') }}" class="btn btn-danger btn-sm" style="padding: 6px 16px;cursor: pointer; "> <i class="fa fa-refresh" aria-hidden="true"></i> Reset </a>
                           @if(Auth::user()->role == 'super_admin')
                           <button type="submit" name="submittype" class="btn btn-danger btn-sm" style="padding: 6px 16px;cursor: pointer;background-color: DodgerBlue; border-color: DodgerBlue; " value="pdf" class="btn btn-danger btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> Pdf <span class="spinner"></span>
                           </button>
                           <button type="submit" name="submittype" class="btn btn-danger btn-sm" value="excel" style="padding: 6px 16px;cursor: pointer;background-color: DodgerBlue; border-color: DodgerBlue; "  class="btn btn-success btn-sm" ><i class="fa fa-download" aria-hidden="true"></i>  Excel <span
                              class="spinner"></span>
                            </button>
                            @endif
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>

         <div class="card  card-outline">
            <div class="card-body">
              <table id="employee" class="table table-bordered table-hover" style=" background: #fff;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Work</th>
                    <th>Company</th>
                    <th>Description</th>
                    <th>Document No.</th>
                    <th>Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Period</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
      </div>
   </div>
</div>

<!--/. container-fluid -->
<div class="modal fade add_modal" >
   <div class="modal-dialog modal-lg">
      <div class="modal-content add">
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
<div class="modal fade add_modal1" >
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title">Large Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body addholidaybody1">
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade add_company" >
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title"> Add Company</h5>
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
@push('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
   $('.select2').select2();
            var dstart = moment().startOf('week');
            var dend = moment().endOf('week');

            $('#daterange-btn span').html(dstart.format('D MMM, YYYY') + ' - ' + dend.format('D MMM, YYYY'))
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Today': [moment(), moment()],
                        'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                        'This Week': [moment().startOf('week'), moment().endOf('week')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')],
                        'All': [moment().subtract(10, 'year').startOf('year'), moment().add(10, 'year').endOf('year')],
                    },
                    locale: {
                        format: 'DD/MM/YYYY',
                    },
                    startDate: moment().startOf('week'),
                    endDate: moment().endOf('week')
                },
                function (start, end) {
                    $('.startdate').val(start.format('D-MMM-YYYY'));
                    $('.enddate').val(end.format('D-MMM-YYYY'));
                    $('#daterange-btn span').html(start.format('D-MMM-YYYY') + ' - ' + end.format('D-MMM-YYYY'))
                }
            )
</script>
<script>
  
   function companyload(selectedcompany = 0){
   
       $.ajax({
               url: '{{ route("admin.works.companyload") }}',
               type: 'POST',
               data:{selectedcompany:selectedcompany},
               headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               success: function (data) {
                  $('.companyload').html(data);
                  $('.companyload').select2()
               },
           });
       }
       
       $(function () {
           /* datatable */
             var datable = $("#employee").DataTable({
               "responsive": true,
               "autoWidth": false,
               processing: true,
               serverSide: true,
               stateSave: true,
               ajax: {
                   'url': "{{ route('admin.works.getall') }}",
                   'type': 'POST',
                   'data': function (d) {
                       d._token = "{{ csrf_token() }}";
                       d.work = $("#work").val();
                       d.client = $("#client").val();
                       d.startdate = $('#daterange-btn').data('daterangepicker').startDate._d;
                       d.enddate = $('#daterange-btn').data('daterangepicker').endDate._d;
                       d.group = $("#group").val();
                       d.status = $("#status").val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', "orderable": false},
                   {data: 'client_id'},
                   {data: 'work'},
                   {data: 'company_id'},
                   {data: 'description'},
                   {data: 'unique_number'},
                   {data: 'amount'},
                   {data: 'start_date'},
                   {data: 'end_date'},
                   {data: 'period'},
                   {data: 'status'},
                   {data: 'action', orderable: false},
               ]
           });
           /*filter*/
           $('.searchdata').click(function () {
               event.preventDefault();
               $("#employee").DataTable().ajax.reload()
           })
       });
   
   
       $('body').on('click', '.clicktosearch', function () {
           $('.displaybl').toggle("slide");
       })
       /********* add new employee ********/
       $('body').on('click', '.openaddmodal', function () {
           var id = $(this).data('id');
           
           
           if (id == '') {
               $('.modal-title').text('Add Work');
           } else {
               $('.modal-title').text('Edit Work');
           }
           $.ajax({
               url: "{{ route('admin.works.getmodal')}}",
               type: 'POST',
               headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               data: {id: id},
               success: function (data) {
                   $('.addholidaybody').html(data);
                   $('.select2').select2();
                   companyload($('.group_id_selected').val());
                       $(".formsubmit").validate({
                                                rules: {
                            "doc_number": {
                                 required: true,
                                 maxlength: 25,
                             }

                        },

   
                   });
   
               },
           });
       });
       $('body').on('click', '.openaddmodal1', function () {
           var id = $(this).data('id');
         
               $('.modal-title').text('Add Company');
       
           $.ajax({
               url: "{{ route('admin.works.getcompanymodal')}}",
               type: 'POST',
               headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               data: {id: id},
               success: function (data) {
   
                   
   
                   $('.addholidaybody1').html(data);
                   
   
                   $(".formsubmit1").validate({
   
                   });
   
               },
           });
       });
       $('body').on('submit', '.formsubmit', function (e) {
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
                       $('.add_modal').modal('hide');
                       $('#employee').DataTable().ajax.reload();
                       toastr.success(data.msg,'Success!')
                   }
               },
           });
       });
   
       $('body').on('submit', '.formsubmit1', function (e) {
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
                       $('.add_modal1').modal('hide');
                   
                       companyload();
                       $('#employee').DataTable().ajax.reload();
                       toastr.success(data.msg,'Success!')
                   }
               },
           });
       });
       /****** delete record******/
       $('body').on('click', '.delete_record', function () {
           var id = $(this).data('id');
   
           (new PNotify({
               title: "Confirmation Needed",
               text: "Are you sure you wants to delete?",
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
                   url: '{{ url("admin/users/") }}/' + id,
                   type: 'DELETE',
                   headers: {
                       'X-CSRF-TOKEN': '{{ csrf_token() }}'
                   },
                   beforeSend: function () {
                   },
                   success: function (data) {
                       if (data.status == 400) {
                           toastr.error(data.msg, 'Oh No!');
                       }
                       if (data.status == 200) {
                           toastr.success(data.msg, 'Success!');
                           $("#employee").DataTable().ajax.reload();
                       }
                   },
                   error: function () {
                       toastr.error('Something went wrong!', 'Oh No!');
                   }
               });
           });
       });
       /** change status**/
       $('body').on('click', '.changestatus', function () {
           var id = $(this).data('id');
           var status = $(this).data('status');
         
               $.ajax({
                   url: '{{ route("admin.works.changestatus") }}',
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
           })
   
      
</script>
@endpush
@endsection