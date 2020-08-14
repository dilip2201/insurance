@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Dashboard')
<div class="container">
   <!-- Info boxes -->
   <div class="row">
      @if(Auth::user()->role == 'super_admin')
      @if(!empty($birthdays))
      <fieldset>
         <legend>Upcoming Client Birthday's</legend>
          <div class="row">
          @if(count($birthdays) > 0)
            @foreach($birthdays as $birthday)
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fa fa-birthday-cake"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">{{$birthday->name_salutation.' '.$birthday->first_name.' '.$birthday->last_name}}</span>
                     <span class="info-box-number">
                     {{ date('d M Y',strtotime($birthday->date_of_birth)) }}
                     </span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            @endforeach
            @else
            <div class="info-box-content">
                  <span class="info-box-text">There are no any client birthday in this month. </span>          
            </div>
            @endif
         </div>
      </fieldset>
      @endif
      <fieldset>
         <legend>General Info </legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Users</span>
                     <span class="info-box-number">
                     {{ $users }}
                     </span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Group</span>
                     <span class="info-box-number">
                     {{ $groups }}
                     </span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Clients</span>
                     <span class="info-box-number">{{ $clients }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fa fa-tasks"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Works</span>
                     <span class="info-box-number">{{ $works }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>

      <fieldset>
         <legend>
            ToDo Detail
         </legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" ><i class="fa fa-list"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total ToDo</span>
                     <span class="info-box-number">{{ $todos }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#14a544!important;color:#ffff!important"><i class="fa fa-check" 
                     style="color:#ffff;"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Completed</span>
                     <span class="info-box-number">{{ $completed }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#bf1731!important;color:#ffff!important"><i class="fa fa-clock-o"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Pending</span>
                     <span class="info-box-number">{{ $pending }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#504e54!important;color:#ffff!important"><i class="fa fa-pause"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Hold</span>
                     <span class="info-box-number">{{ $hold }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#f12222!important;color:#ffff!important"><i class="fa fa-bandcamp"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Prospect</span>
                     <span class="info-box-number">{{ $prospect }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>
      <fieldset>
         <legend>Works Detail</legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"style="background-color:#14a544!important;color:#ffff!important"><i class="fa fa-check"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Open Work</span>
                     <span class="info-box-number">{{ $open }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#bf1731!important;color:#ffff!important"><i class="fa fa-close"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Close Work</span>
                     <span class="info-box-number">{{ $close }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>
      @endif
      <!-- fix for small devices only -->
      @if(Auth::user()->role == 'operator')
      <fieldset>
         <legend>
            ToDo Detail
         </legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" ><i class="fa fa-list"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total ToDo</span>
                     <span class="info-box-number">{{ $todo }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#14a544!important;color:#ffff!important"><i class="fa fa-check" 
                     style="color:#ffff;"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Completed</span>
                     <span class="info-box-number">{{ $completeds }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#bf1731!important;color:#ffff!important"><i class="fa fa-clock-o"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Pending</span>
                     <span class="info-box-number">{{ $pendings }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#504e54!important;color:#ffff!important"><i class="fa fa-pause"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Hold</span>
                     <span class="info-box-number">{{ $holds }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#f12222!important;color:#ffff!important"><i class="fa fa-bandcamp"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Prospect</span>
                     <span class="info-box-number">{{ $prospects }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>
      @endif
      @if(Auth::user()->role == 'user')
      <fieldset>
         <legend>
            General Detail
         </legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Clients</span>
                     <span class="info-box-number">{{ $clients }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"><i class="fa fa-tasks"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Works</span>
                     <span class="info-box-number">{{ $works }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>
      <fieldset>
         <legend>
            ToDo Detail
         </legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3" style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" ><i class="fa fa-list"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total ToDo</span>
                     <span class="info-box-number">{{ $todo }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#14a544!important;color:#ffff!important"><i class="fa fa-check" 
                     style="color:#ffff;"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Completed</span>
                     <span class="info-box-number">{{ $completeds }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#bf1731!important;color:#ffff!important"><i class="fa fa-clock-o"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Pending</span>
                     <span class="info-box-number">{{ $pendings }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#504e54!important;color:#ffff!important"><i class="fa fa-pause"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Hold</span>
                     <span class="info-box-number">{{ $holds }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#f12222!important;color:#ffff!important"><i class="fa fa-bandcamp"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Prospect</span>
                     <span class="info-box-number">{{ $prospects }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>
      <fieldset>
         <legend>Works Detail</legend>
         <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1"style="background-color:#14a544!important;color:#ffff!important"><i class="fa fa-check"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Open Work</span>
                     <span class="info-box-number">{{ $open }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box mb-3"  style="border: 1px solid #af9a9a;">
                  <span class="info-box-icon bg-info elevation-1" style="background-color:#bf1731!important;color:#ffff!important"><i class="fa fa-close"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Total Close Work</span>
                     <span class="info-box-number">{{ $close }}</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <!-- /.info-box -->
            </div>
         </div>
      </fieldset>
      @endif
      <div class="clearfix hidden-md-up"></div>
      <!--         <div class="col-12 col-sm-6 col-md-3">
         <div class="info-box mb-3">
             <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
             <div class="info-box-content">
                 <span class="info-box-text">Total Company</span>
                 <span class="info-box-number">4</span>
             </div>
         </div>
         </div> -->
      <!-- /.col -->
   </div>
</div>
@endsection