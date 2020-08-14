@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'ToDo')
<div class="container">
   <!-- Info boxes -->
   <div class="row">

      <div class="col-12" style="margin-top: -40px;">
        
         <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal"
            class="btn btn-info btn-sm openaddmodal" data-id="" style="float: right; ">
         <i class="fa fa-plus"></i> Add New
         </a>
        
      </div>
      <div class="col-12">
         <div class="card card-info card-outline displaybl">
            <div class="card-body" style="padding: 10px 15px;">
               <div class="col-lg-12">
                  <div class="form-group row " style="margin-bottom: 0px;">
                     <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                           <label>Date</label>
                           <input type="date" placeholder="Date" class="form-control" id = "date" name="date" value="date">
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                           <label>Due Date</label>
                           <input type="date" placeholder="Due Date" class="form-control" id="due_date" name="due_date" value="due_date">
                        </div>
                     </div>
                     @if(auth()->user()->role == 'super_admin')
                     <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                           <label>Work Alloted</label>
                           <select class="form-control select2" name="work_alloted_id" id = "work_alloted_id" style="width: 100%;" required="">
                              <option value="">Select User</option>
                              @if(!empty($users))
                              @foreach($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                              @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                     @endif
                     <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                           <label>Status</label>
                           <select class="form-control" name="status" id="status" style="width: 100%;" required="">
                              <option value="">Select Status</option>
                              <option value="Pending" selected="">Pending</option>
                              <option value="Completed">Completed</option>
                              <option value="Hold">Hold</option>
                              <option value="Prospect">Prospect</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-2" style="padding-left: 0px;">
                        <button class="btn btn-success btn-sm searchdata"
                           style="margin-top: 33px;padding: 6px 16px;">Search <span
                           class="spinner"></span>
                        </button>
                        <a href="{{ route('admin.todos.index') }}" class="btn btn-danger btn-sm"
                           style="margin-top: 33px;margin-left: 5px;padding: 6px 16px;cursor: pointer; ">
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
                        <th>Date</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Work Alloted</th>
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
<!--/. container-fluid -->
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
<!-- /.modal -->
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endpush
@push('script')
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
  $('.select2').select2();
   $('body').on('click', '.get_desc', function () {
        var id = $(this).data('desc_id');
        $.dialog({
            title: 'Description',
            content: 'url:{{ url("admin/todos/get_desc") }}/' + id,
        });
    })
   $('body').on('click', '.get_remark', function () {
        var id = $(this).data('remark_id');
        $.dialog({
            title: 'Remark',
            content: 'url:{{ url("admin/todos/get_remark") }}/' + id,
        });
   })
   $(function () {

       /* datatable */
       $("#employee").DataTable({
           "responsive": true,
           "autoWidth": false,
           processing: true,
           serverSide: true,
           stateSave: true,
           ajax: {
               'url': "{{ route('admin.todos.getall') }}",
               'type': 'POST',
               'data': function (d) {
                   d._token = "{{ csrf_token() }}";
                   d.work_alloted_id = $("#work_alloted_id").val();
                   d.date = $("#date").val();
                   d.due_date = $("#due_date").val();
                   d.status = $("#status").val();
               }
           },
           columns: [
               {data: 'DT_RowIndex', "orderable": false},
               {data: 'date'},
               {data: 'task_name'},
               {data: 'description'},
               {data: 'due_date'},
               {data: 'work_alloted_id'},
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

    //Initialize Select2 Elements
   $('.select2').select2();
    function editbranch(branchid) {
           $('.editspan' + branchid).hide();
           $('.editedspan' + branchid).show();
    }
    /********* save status ********/
   $('body').on('click', '.saveicon', function () {
           var id = $(this).data('id');
           var statusid = $('.selected' + id).val();
           $.ajax({
               url: '{{ route("admin.todos.changestatus") }}',
               type: 'POST',
               headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               data: {status_id: statusid, todo_id: id},
               success: function (data) {
                   $("#employee").DataTable().ajax.reload();
               },
               error: function () {
                   toastr.error('Something went wrong!', 'Oh No!');
   
               }
           });
   
   
       });

   /********* add new todo ********/
   $('body').on('click', '.openaddmodal', function () {
       var id = $(this).data('id');
       if (id == '') {
           $('.modal-title').text('Add To Do');
       } else {
           $('.modal-title').text('Edit To Do');
       }
       $.ajax({
           url: "{{ route('admin.todos.getmodal')}}",
           type: 'POST',
           headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}'
           },
           data: {id: id},
           success: function (data) {
               $('.addholidaybody').html(data);
                   $(".formsubmit").validate({
                      rules: {  
                        "task_name": {
                                required:true,
                                maxlength: 200,
                            },
                          "description" : {
                                required:true,
                                maxlength: 1000,
                          }
                      }
                    });
   
           },
       });
   });
      /********* add new todo ********/
   $('body').on('click', '.openaddmodallog', function () {
       var id = $(this).data('id');

       $.ajax({
           url: "{{ route('admin.todos.getmodallog')}}",
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
         /********* add new todo ********/
   $('body').on('click', '.history_log_show', function () {
       var id = $(this).data('id');

       $.ajax({
           url: "{{ route('admin.todos.getmodalhistory')}}",
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

   /** change status**/
   $('body').on('change', '.changestatus', function () {

       var id = $(this).data('id');
       var status = $(this).val();
      
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
               url: '{{ route("admin.todos.changestatus") }}',
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
   
   });


   $('body').on('change', '.datechangeadd', function () {
    var status =$(this).val();
    
    if(status == 'Pending' || status == 'Hold'){
      $(".datechange").css("display", "block");
    }else{
      $(".datechange").css("display", "none");
    }
   });
  

</script>
@endpush
@endsection