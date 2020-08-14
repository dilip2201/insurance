@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'ToDo')
<div class="container">
   <!-- Info boxes -->
   <div class="row">

      
      <div class="col-4">
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title"> <span class="grouplabel"> Add  Group </span></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form autocorrect="off" action="{{ route('admin.group.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formgroupsubmit">
                {{ csrf_field() }}
                <input type="hidden" value="" class="groupid" name="groupid">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control groupname"  name="name" placeholder="Name" required="" maxlength="30">
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary  submitbutton pull-right"><span class="buttonname"> Submit</span> <span class="groupspinner"></span></button>
                        </div>
                    </div>
                </div>
            </form>

          </div>
        </div>
           
      </div>
      <div class="col-8">
        
         <div class="card  card-outline">
            <div class="card-body">
               <!-- /.card-header -->
               <table id="employee" class="table table-bordered table-hover" style="background: #fff;">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
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

<!-- /.modal -->

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
               'url': "{{ route('admin.group.getall') }}",
               'type': 'POST',
               'data': function (d) {
                   d._token = "{{ csrf_token() }}";
               }
           },
           columns: [
               {data: 'DT_RowIndex', "orderable": false},
               {data: 'name'},
               {data: 'code'},
               {data: 'action', orderable: false},
           ]
       });
       /*filter*/
      
   });



   /********* add new todo ********/
   $('body').on('click','.editgroup',function(){
    $('.groupname').val($(this).data('name'));
    
    $('.groupid').val($(this).data('id'));
    $('.grouplabel').text('Edit Group');
    $('.buttonname').text('Update');
    

   })

   $('body').on('click','.deletegroup',function(){
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
            url: '{{ route("admin.group.delete") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {id: id},
            success: function (data) {
                $('#employee').DataTable().ajax.reload();
                toastr.success('Group deleted successfully.', 'Success!');
            },
            error: function () {
                toastr.error('Something went wrong!', 'Oh No!');

            }
        });
    })


   });

   /********* form submit ********/
   $('body').on('submit', '.formgroupsubmit', function (e) {
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
                   $('.formgroupsubmit')[0].reset();
                   $('.groupid').val('');
                   $('.grouplabel').text('Add Group');
                   $('.buttonname').text('Submit');
                   $('#employee').DataTable().ajax.reload();
                   toastr.success(data.msg,'Success!')
               }
           },
       });
   });
      /********* form submit ********/
  

  

</script>
@endpush
@endsection