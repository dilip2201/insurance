@extends('admin.layouts.app')
@section('content')
@section('pageTitle', __('message.Add Employee'))
@push('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('admin.employee.index')}}">Employee List</a></li>
@endpush
@push('links')
    <link rel="stylesheet" href="{{ URL::asset('public/company/steps.css') }}">
@endpush
@push('style')
    <style>

    </style>
@endpush
<div class="container">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12">

            <div class="card card-info card-outline">
                <div class="card-header">
                    <span>Add Employee</span>
                     <a href="{{ route('admin.employee.index') }}"
                       class="btn btn-info btn-sm float-right"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <!-- /.card-header -->
                    <div class="row justify-content-center mt-0">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center p-0">
                            <div class="px-0 pb-0">
                                <div class="row ">
                                    <div class="col-md-12 mx-0 setup-panel">
                                        <form id="msform" class="formsubmit"
                                              action="{{ route('admin.employee.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <!-- progressbar -->
                                            <ul id="progressbar">
                                                <li class="active" id="account">
                                                  <span>Personal Details</span></li>
                                                <li id="personal" disabled="disabled">
                                                  <span>Employment
                                                        Details</span></li>
                                                <li id="payment" disabled="disabled">
                                                  <span>Bancking Details</span>
                                                </li>
                                                <li id="confirm" disabled="disabled">
                                                  <span>Ex Employment
                                                        Details</span></li>
                                            </ul>
                                            <!-- personal details -->
                                            <fieldset class="setup-content">
                                                @if(!empty($employee))
                                                    <input type="hidden" name="userid"
                                                           value="{{ encrypt($employee->id) }}">

                                                @endif
                                                <div class="form-card ">
                                                    <div class="row ">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    First Name
                                                                    <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control classfocus"
                                                                       maxlength="50" name="name"
                                                                       placeholder="First Name"
                                                                       value="@if(!empty($employee)){{ $employee->name }}@endif"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Last Name <span
                                                                        class="text-red">*</span></label>
                                                                <input type="text" class="form-control " maxlength="30"
                                                                       name="lastname"
                                                                       placeholder="Last Name"
                                                                       value="@if(!empty($employee)){{ $employee->lastname }}@endif"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-envelope" aria-hidden="true"></i>
                                                                    Email <span
                                                                        class="text-red">*</span></label>
                                                                <input type="email" class="form-control" name="email"
                                                                       placeholder="Email"
                                                                       value="@if(!empty($employee)){{ $employee->email }}@endif"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-phone" aria-hidden="true"></i>
                                                                    Phone<span
                                                                        class="text-red">*</span></label>
                                                                <input type="text" class="form-control phonenumber"
                                                                       name="phone"
                                                                       placeholder="Phone"
                                                                       value="@if(!empty($employee)){{ $employee->phone }}@endif"
                                                                       required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Father's Name</label>
                                                                <input type="text" class="form-control "
                                                                       name="father_name"
                                                                       placeholder="Father's Name"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->father_name }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Qualification</label>
                                                                <select class="form-control" name="qualification">
                                                                    @foreach(qualification() as $q)
                                                                        <option value="{{ $q }}"
                                                                                @if(!empty($employee) && $employee->employee_detail->qualification ==$q ) selected @endif>{{ $q }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-map" aria-hidden="true"></i> Current Address</label>
                                                                <input type="text" class="form-control " name="address"
                                                                       placeholder="Current Address"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->address }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-map" aria-hidden="true"></i> Permanent Address</label>
                                                                <input type="text" class="form-control"
                                                                       name="permanent_address"
                                                                       placeholder="Permanent Address"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->permanent_address }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Birth Date</label>
                                                                <input type="date" class="form-control" name="birthdate"
                                                                       placeholder="Birthdate"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->birthdate }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Date of Joining<span
                                                                        class="text-red">*</span></label>
                                                                <input type="date" class="form-control "
                                                                       name="date_of_joining" required
                                                                       placeholder="Date of Joining"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->date_of_joining }}@endif">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Emergency Number</label>
                                                                <input type="text" class="form-control "
                                                                       name="emergency_number"
                                                                       placeholder="Emergency Number"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->emergency_number }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    PAN Number</label>
                                                                <input type="text" class="form-control "
                                                                       name="pan_number"
                                                                       placeholder="PAN Number"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->pan_number }}@endif">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    City </label>
                                                                <select class="form-control cityselectwithstatecountry"
                                                                        name="cityid">
                                                                    @if(!empty($employee->city))
                                                                        <option value="{{ $employee->city->id }}"
                                                                                selected>{{ $employee->city->name }}
                                                                            , {{ $employee->city->state->name }}
                                                                            , {{ $employee->city->state->country->name }}</option>
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Profile Image </label>


                                                                <div class="clearFix"></div>
                                                                <div class="proInputDv">
                                                                    <input type="file" class=" changeuserimage"
                                                                           accept="image/*"
                                                                           name="image">

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Employment Status </label>
                                                                <div class="option-group field">
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="employment_status"
                                                                               id="employment_status" value="Present" checked
                                                                               @if(!empty($employee) && $employee->employee_detail->employment_status == 'Present' ) checked @endif >
                                                                       Present</span>
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="employment_status"
                                                                               @if(!empty($employee) && $employee->employee_detail->employment_status == 'Ex' ) checked
                                                                               @endif
                                                                               id="employment_status" value="Ex">
                                                                       Ex</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Gender </label>
                                                                <div class="option-group field">
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="gender"
                                                                               id="gender" value="Male" checked
                                                                               @if(!empty($employee) && $employee->employee_detail->gender == 'Male' ) checked @endif>
                                                                       Male</span>
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="gender"
                                                                               id="gender" value="Female"
                                                                               @if(!empty($employee) && $employee->employee_detail->gender == 'Female' ) checked @endif>
                                                                        Female</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            @php $image = url('public/company/employee/default.png'); @endphp
                                                            @if(isset($employee) && !empty($employee->image) && $employee->image !== null)
                                                                @php $image = url('public/company/employee/'.$employee->image); @endphp
                                                            @endif
                                                            <span style="width: 100%; text-align: center; ">
                                                                <img src="{{ $image }}" class="image_preview" width="auto" height="100px">
                                                                </span>
                                                        </div>

                                                    </div>

                                                </div>
                                                <input type="button" name="next"
                                                       class="next btn btn-sm btn-info action-button"
                                                       value="Next Step"/>
                                            </fieldset>
                                            <!------- employment details--------->
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row setup-content">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Probation Period</label>
                                                                <select
                                                                    class="select2-single form-control probation_select"
                                                                    name="probation_period" id="probation_period">
                                                                    <option value="">Select probation period</option>
                                                                    <option value="0"
                                                                            @if(!empty($employee) && $employee->employee_detail->probation_period == '0' ) selected @endif>
                                                                        0 days
                                                                    </option>
                                                                    <option value="30"
                                                                            @if(!empty($employee) && $employee->employee_detail->probation_period == '30' ) selected @endif>
                                                                        30 days
                                                                    </option>
                                                                    <option value="60"
                                                                            @if(!empty($employee) && $employee->employee_detail->probation_period == '60' ) selected @endif>
                                                                        60 days
                                                                    </option>
                                                                    <option value="90"
                                                                            @if(!empty($employee) && $employee->employee_detail->probation_period == '90' ) selected @endif>
                                                                        90 days
                                                                    </option>
                                                                    <option value="180"
                                                                            @if(!empty($employee) && $employee->employee_detail->probation_period == '180' ) selected @endif>
                                                                        180 days
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Date of Confirmation</label>
                                                                <input type="date" class="form-control "
                                                                       name="date_of_confirmation"
                                                                       placeholder="Date of Confirmation"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->date_of_confirmation }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Department</label>
                                                                <select class="select2-single form-control department"
                                                                        name="department" id="department">
                                                                    <option value="Marketplace"
                                                                            @if(!empty($employee) && $employee->employee_detail->department == 'Marketplace' ) selected @endif>
                                                                        Marketplace
                                                                    </option>
                                                                    <option value="Social Media"
                                                                            @if(!empty($employee) && $employee->employee_detail->department == 'Social Media' ) selected @endif>
                                                                        Social Media
                                                                    </option>
                                                                    <option value="IT"
                                                                            @if(!empty($employee) && $employee->employee_detail->department == 'IT' ) selected @endif>
                                                                        IT
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Salary on Confirmation</label>
                                                                <input type="text" class="form-control "
                                                                       name="salary"
                                                                       placeholder="Salary"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->salary }}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>Salary Type</label>
                                                                <select name="salarytype" class="form-control">
                                                                  <option value="">Select salary Type</option>
                                                                  @if(count($salarytypes) > 0)
                                                                  @foreach($salarytypes as $type)
                                                                  <option value="{{ $type->id }}">{{ $type->title }}</option>
                                                                  @endforeach
                                                                  @endif
                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Joining Formalities</label>
                                                                <div class="option-group field">
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="formalities"
                                                                               id="formalities" value="Completed" checked
                                                                               @if(!empty($employee) && $employee->employee_detail->formalities == 'Completed' ) checked @endif>
                                                                       Completed</span>
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="formalities"
                                                                               id="formalities" value="Pending"
                                                                               @if(!empty($employee) && $employee->employee_detail->formalities == 'Pending' ) checked @endif>
                                                                        Pending</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Offer Acceptance</label>
                                                                <div class="option-group field">
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="offer_acceptance"
                                                                               id="offer_acceptance" value="Completed" checked
                                                                               @if(!empty($employee) && $employee->employee_detail->formalities == 'Completed' ) checked @endif>
                                                                       Completed</span>
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="offer_acceptance"
                                                                               id="offer_acceptance" value="Pending"
                                                                               @if(!empty($employee) && $employee->employee_detail->formalities == 'Pending' ) checked @endif>
                                                                        Pending</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <input type="button" name="previous"
                                                       class="previous btn btn-sm btn-primary action-button-previous"
                                                       value="Previous"/>
                                                <input
                                                    type="button" name="next"
                                                    class="next btn btn-sm btn-info action-button"
                                                    value="Next Step"/>
                                            </fieldset>
                                            <!------- Banking details--------->
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row setup-content">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Bank Account Number</label>
                                                                <input type="text" class="form-control classfocus"
                                                                       maxlength="50" name="account_no"
                                                                       placeholder="Bank Account Number"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->account_no }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Bank Name</label>
                                                                <input type="text" class="form-control " maxlength="30"
                                                                       name="bank_name"
                                                                       placeholder="Bank Name"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->bank_name }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    IFSC Code
                                                                </label>
                                                                <input type="text" class="form-control "
                                                                       name="ifsc_code" placeholder="IFSC Code"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->ifsc_code }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    PF Account Number
                                                                </label>
                                                                <input type="text" class="form-control "
                                                                       name="pf_account_number"
                                                                       placeholder=" PF Account Number"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->pf_account_number }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    UN Number
                                                                </label>
                                                                <input type="text" class="form-control "
                                                                       name="un_number" placeholder="UN Number"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->un_number }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    PF Status
                                                                </label>
                                                                <div class="option-group field">
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="pf_status"
                                                                               id="pf_status" value="Active" checked
                                                                               @if(!empty($employee) && $employee->employee_detail->pf_status == 'Active' ) checked @endif>
                                                                       Active</span>
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="pf_status"
                                                                               id="pf_status" value="Inactive"
                                                                               @if(!empty($employee) && $employee->employee_detail->pf_status == 'Inactive' ) checked @endif>
                                                                        Inactive</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="button" name="previous"
                                                       class="previous btn btn-sm btn-primary action-button-previous"
                                                       value="Previous"/>
                                                <input
                                                    type="button" name="make_payment"
                                                    class="next btn btn-sm btn-info action-button"
                                                    value="Next Step"/>
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row setup-content">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Date of Resignation</label>
                                                                <input type="date" class="form-control classfocus"
                                                                       name="date_of_resignation"
                                                                       placeholder="Date of Resignation"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->date_of_resignation }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-book" aria-hidden="true"></i>
                                                                    Notice Period</label>
                                                                <select class=" form-control" name="notice_period"
                                                                        id="notice_period">
                                                                    <option value="">Select notice period</option>
                                                                    <option value="1"
                                                                            @if(!empty($employee) && $employee->employee_detail->notice_period == '1' ) selected @endif>
                                                                        1 Month
                                                                    </option>
                                                                    <option value="2"
                                                                            @if(!empty($employee) && $employee->employee_detail->notice_period == '2' ) selected @endif>
                                                                        2 Months
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Last Working Day</label>
                                                                <input type="date" class="form-control "
                                                                       name="last_working_day"
                                                                       placeholder="Last Working Day"
                                                                       value="@if(!empty($employee)){{ $employee->employee_detail->last_working_day }}@endif"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    Full & Final</label>
                                                                <div class="option-group field">
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="full_final"
                                                                               id="full_final" value="Yes" checked
                                                                               @if(!empty($employee) && $employee->employee_detail->full_final == 'Yes' ) checked @endif>
                                                                       Yes</span>
                                                                    <span class="option option-primary">
                                                                        <input type="radio" name="full_final"
                                                                               id="full_final" value="No"
                                                                               @if(!empty($employee) && $employee->employee_detail->full_final == 'No' ) checked @endif>
                                                                        No</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>

                                                </div>
                                                <input type="button" name="previous"
                                                       class="previous btn btn-sm btn-primary action-button-previous"
                                                       value="Previous"/>
                                                <button
                                                    type="submit" name="submit" class="btn btn-sm btn-success" 
                                                    value="Confirm">Confirm <span class="spinner"></span></button>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
@push('links')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
@endpush
@push('script')
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".formsubmit").validate({
                rules: {
                    name: {
                        require: true,
                        maxlength: 50
                    },
                    lastname: {
                        require: true,
                        maxlength: 50
                    },
                    email: {
                        require: true,
                        email: true
                    },
                    /* cityid: {
                         require: true,
                     },*/
                    phone: {
                        require: true,
                    }
                },
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
                            toastr.error(data.msg, 'Failed!');                            
                        }
                        if (data.status == 200) {
                            $('.spinner').html('');
                            $('.add_modal').modal('hide');
                             toastr.success(data.msg, 'Success!');
                            setTimeout(function () {
                              window.location.href = "{{ route('company.employee.index')}}";
                           }, 1500);
                            
                        }
                    },
                });
            });

        });

        $(document).ready(function () {

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;

            $(".next").click(function () {

                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel ul li[id="#' + curStepBtn + '"]').parent().next().children("li"),
                    curInputs = curStep.find("input[type='text'],input[type='date'],input[type='email']"),
                    isValid = true;

                $(".form-group").removeClass("error");
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("error");
                        $(curInputs[i]).closest(".form-group").find('.form-control').addClass("error");
                    }
                }

                if (!isValid) {
                    nextStepWizard.attr('disabled', true);
                } else {
                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        step: function (now) {

                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({'opacity': opacity});
                        },
                        duration: 600
                    });
                }


            });

            $(".previous").click(function () {

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

//Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
                previous_fs.show();

//hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
// for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            });

            $('.radio-group .radio').click(function () {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

            $(".submit").click(function () {
                return false;
            })

        });

    </script>
    <script>
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "{{ URL::asset('public/admin/images/flags') }}";
            var $state = $(
                '<span><img src="' + baseUrl + '/' + state.contryflage.toLowerCase() + '.png"  class="img-flag" /> ' + state.text + '</span>'
            );
            return $state;
        }

        $(".cityselectwithstatecountry").select2({
            // dropdownParent: $('.openaddmodal'),
            minimumInputLength: 2,
            templateResult: formatState,
            ajax: {
                url: "{{ route('public.citywithstatecountry') }}",
                dataType: 'json',
                type: "POST",

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name + ', ' + item.state.name + ', ' + item.state.country.name,
                                id: item.id,
                                contryflage: item.state.country.sortname
                            }
                        })
                    };
                }

            }
        });

        /*image preview*/
        function readURL(input, classes) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.' + classes).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('body').on('change', '.changeuserimage', function () {
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) != -1) {
                readURL(this, 'image_preview');
            }
        });
    </script>
@endpush
@endsection
