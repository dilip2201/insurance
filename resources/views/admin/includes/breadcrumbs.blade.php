<!-- Content Header (Page header) -->
<div class="content-header" style="padding: 10px .5rem;">
   <div class="container">
      <div class="row mb-2">
         <!-- /.col -->
         <div class="col-sm-6 ">
            <ol class="breadcrumb ">
               <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                @stack('breadcrumb')
               <li class="breadcrumb-item active">@yield('pageTitle')</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
