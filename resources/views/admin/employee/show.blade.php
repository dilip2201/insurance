@extends('company.layouts.app')
@section('content')
@section('pageTitle','Employee Detail')
<style>
    .table td, .table th{
        padding: 0.4rem;
    }
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
   color: #fff;
   background-color: #17a2b8;
   }
   .nav-pills .nav-link {
   color: #17a2b8;
   }
   a:hover {
   color: black!important;
   }
   .myaccordion {
   max-width: 1000px!important;
   margin: 0px auto!important;
   box-shadow: 0 0 1px rgba(0,0,0,0.1);
   }
   .myaccordion .btn {
   width: 100%;
   font-weight: bold;
   color: black!important;
   color: 17a2b8;
   padding: 0;
   }
   body {
   background: #F9F9F9;
   }
   .myaccordion {
   max-width: 500px;
   margin: 50px auto;
   box-shadow: 0 0 1px rgba(0,0,0,0.1);
   }
   .myaccordion .card,
   .myaccordion .card:last-child .card-header {
   border: none;
   }
   .myaccordion .card-header {
   border-bottom-color: #EDEFF0;
   background: transparent;
   }
   .myaccordion .fa-stack {
   font-size: 18px;
   }
   .myaccordion .btn {
   width: 100%;
   font-weight: bold;
   color: #004987;
   padding: 0;
   }
   .myaccordion .btn-link:hover,
   .myaccordion .btn-link:focus {
   text-decoration: none;
   }
   .myaccordion li + li {
   margin-top: 10px;
   }
   #headingTwo{
   background-color: #77737312;
   }
   .table td, .table th {
    /*background-color: #77737314;*/
   }
   .table {
        margin-bottom: 0rem; 
   }
   .crdhead{
       padding: .40rem 1.25rem!important;
   }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title ">About Me</h3>
                </div>
                <div class="card-body box-profile">

                    
                    @php
                        if(!empty($employee->image)){
                        $image = $employee->image;
                        }else{
                        $image = 'default.png';
                        }
                    @endphp

                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ url('public/company/employee/'.$image) }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $employee->name }} {{ $employee->lastname }}</h3>

                    <p class="text-muted text-center">{{ ucwords($employee->role) }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $employee->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b> <a class="float-right">{{ $employee->phone }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> <a class="float-right">@if($employee->status == 'active')<i class="fa fa-check" style="font-size: 16px; color: green"></i> @else <i class="fa fa-times" style="font-size: 16px; color: red"></i>   @endif</a>
                        </li>
                        <li class="list-group-item">
                            <b> Location</b>
                            <a class="float-right">{{ $employee->employee_detail->address }}</a>
                        </li>

                    </ul>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employment Details</h3>
                    <a href="{{ route('company.employee.index') }}"
                       class="btn btn-info btn-sm float-right"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                   <!--  <div class="row "> -->
                        <div class="tab-content">
                  <div class="tab-pane active" id="test">
                     <div id="accordion" class="myaccordion">
                        <div class="card">
                           <div class="card-header crdhead" id="headingTwo">
                              <h2 class="mb-0">
                                 <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 Personal Detail
                                 <span class="fa-stack fa-2x">
                                 <i class="fas fa-circle fa-stack-2x"></i>
                                 <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                 </span>
                                 </button>
                              </h2>
                           </div>
                           <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row ">
                                    <table class="table table-bordered">
                                       <tbody>
                                       <tr>
                                          <td><b>Father's Name</b></td>
                                          <td>@if($employee->employee_detail->father_name){{ $employee->employee_detail->father_name }} @else - @endif</td>
                                          <td><b>Permanent Address</b></td>
                                          <td>@if($employee->employee_detail->permanent_address){{ $employee->employee_detail->permanent_address }} @else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>Emergency Number</b></td>
                                          <td> @if($employee->employee_detail->emergency_number){{ $employee->employee_detail->emergency_number }} @else - @endif</td>
                                          <td><b>City</b></td>
                                          <td>@if($employee->city){{ $employee->city->name }}  @else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>State</b></td>
                                          <td> @if($employee->city){{ $employee->city->state->name }}   @else - @endif</td>
                                          <td><b>Country</b></td>
                                          <td>@if($employee->city){{ $employee->city->state->country->name }} @else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>Gender</b></td>
                                          <td>@if($employee->employee_detail->gender) {{ $employee->employee_detail->gender }} @else - @endif</td>
                                          <td><b>Age</b></td>
                                          <td>@if($employee->employee_detail->age){{ $employee->employee_detail->age }} @else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>PAN Number</b></td>
                                          <td>@if($employee->employee_detail->pan_number) {{ $employee->employee_detail->pan_number }}@else - @endif</td>
                                          <td><b>Qualification</b></td>
                                          <td>@if($employee->employee_detail->qualification){{ $employee->employee_detail->qualification }}@else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>Offer Acceptance</b></td>
                                          <td> @if($employee->employee_detail->offer_acceptance){{ $employee->employee_detail->offer_acceptance }}  @else - @endif</td>
                                          <td><b>Department</b></td>
                                          <td>@if($employee->employee_detail->department){{ $employee->employee_detail->department }} @else - @endif</td>
                                       </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header crdhead" id="headingTwo">
                              <h2 class="mb-0">
                                 <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 Employment Detail
                                 <span class="fa-stack fa-2x">
                                 <i class="fas fa-circle fa-stack-2x"></i>
                                 <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                 </span>
                                 </button>
                              </h2>
                           </div>
                           <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row ">
                                    <table class="table table-bordered">
                                       <tbody>
                                       <tr>
                                          <td><b>Joining Formalities</b></td>
                                          <td> @if($employee->employee_detail->formalities){{ $employee->employee_detail->formalities }}  @else - @endif</td>
                                          <td><b>Probation Period</b></td>
                                          <td>@if($employee->employee_detail->probation_period){{ $employee->employee_detail->probation_period }} @else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>Salary on Confirmation</b></td>
                                          <td> @if($employee->employee_detail->salary){{ $employee->employee_detail->salary }} @else - @endif</td>
                                          <td><b>Date of Confirmation</b></td>
                                          <td>@if($employee->employee_detail->date_of_confirmation){{ date('d M Y',strtotime($employee->employee_detail->date_of_confirmation)) }} @else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>Department</b></td>
                                          <td> @if($employee->employee_detail->department){{ $employee->employee_detail->department }} @else - @endif</td>
                                          <td><b>Offer Acceptance</b></td>
                                          <td>@if($employee->employee_detail->offer_acceptance){{ date('d M Y',strtotime($employee->employee_detail->offer_acceptance)) }} @else - @endif</td>
                                       </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header crdhead" id="headingTwo">
                              <h2 class="mb-0">
                                 <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                 Banking Detail
                                 <span class="fa-stack fa-2x">
                                 <i class="fas fa-circle fa-stack-2x"></i>
                                 <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                 </span>
                                 </button>
                              </h2>
                           </div>
                           <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">
                                 <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                       <td><b>Account</b></td>
                                       <td> @if($employee->employee_detail->account_no){{ $employee->employee_detail->account_no }}  @else - @endif</td>
                                       <td><b>Bank Name</b></td>
                                       <td>@if($employee->employee_detail->bank_name){{ $employee->employee_detail->bank_name }}@else - @endif</td>
                                    </tr>
                                    <tr>
                                       <td><b>IFSC Code</b></td>
                                       <td> @if($employee->employee_detail->ifsc_code){{ $employee->employee_detail->ifsc_code }}  @else - @endif</td>
                                       <td><b>PF Account Number</b></td>
                                       <td>@if($employee->employee_detail->pf_account_number){{ $employee->employee_detail->pf_account_number }}@else - @endif</td>
                                    </tr>
                                    <tr>
                                       <td><b>UN Number</b></td>
                                       <td> @if($employee->employee_detail->un_number){{ $employee->employee_detail->un_number }}  @else - @endif</td>
                                       <td><b>PF Status</b></td>
                                       <td>@if($employee->employee_detail->pf_status){{ $employee->employee_detail->pf_status }}@else - @endif</td>
                                    </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header crdhead" id="headingTwo">
                              <h2 class="mb-0">
                                 <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                 Ex Employment Detail
                                 <span class="fa-stack fa-2x">
                                 <i class="fas fa-circle fa-stack-2x"></i>
                                 <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                 </span>
                                 </button>
                              </h2>
                           </div>
                           <div id="collapseFive" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row ">
                                    <table class="table table-bordered">
                                       <tbody>
                                       <tr>
                                          <td><b>Date Of Registration</b></td>
                                          <td> @if($employee->employee_detail->date_of_resignation){{ $employee->employee_detail->date_of_resignation }}  @else - @endif</td>
                                          <td><b>Notice Period</b></td>
                                          <td>@if($employee->employee_detail->notice_period){{ $employee->employee_detail->notice_period }}@else - @endif</td>
                                       </tr>
                                       <tr>
                                          <td><b>Last Working Day</b></td>
                                          <td> @if($employee->employee_detail->last_working_day){{ $employee->employee_detail->last_working_day }}  @else - @endif</td>
                                          <td><b>Full & Final</b></td>
                                          <td>@if($employee->employee_detail->full_final){{ $employee->employee_detail->full_final }}@else - @endif</td>
                                       </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /.tab-pane -->
               </div>
               
                   <!--  </div> -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
</div>

@endsection
