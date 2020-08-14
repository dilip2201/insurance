@php
$busineess = array();
if(!empty($client)){
  $busineess = $client->business->pluck('id')->toArray();
}
@endphp

<style type="text/css">
.items-collection .btn-group {
    width: 100%;
}
.items-collection label.btn-default.active {
    background-color: #007ba7;
    color: #FFF;
}
.btn-group>.btn:first-child {
    margin-left: 0;
}
.items-collection label.btn-default {
    width: 90%;
    border: 1px solid #305891;
    margin: 5px;
    border-radius: 17px;
    color: #305891;
}

[data-toggle=buttons]>.btn input[type=checkbox], [data-toggle=buttons]>.btn input[type=radio], [data-toggle=buttons]>.btn-group>.btn input[type=checkbox], [data-toggle=buttons]>.btn-group>.btn input[type=radio] {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
}
.items{
      display: inline-block;
}
.items-collection{
  width: 100%;
}
</style>
<div class="col-12">
    <div class="card card-secondary">
      <div class="card-header">
        <h3 class="card-title">@if(!empty($client)) Edit @else Add @endif client</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form role="form" action="{{ route('admin.clients.store') }}" autocomplete="off" method="post" class="formsubmit">
          {{ csrf_field() }}
              <!-- checkbox -->
              <input type="hidden" name="client_id" value="@if(!empty($client)){{$client->id}}@endif">
              <input type="hidden" class="head_mobile" value="">
              <input type="hidden" class="head_email" value="">
              <input type="hidden" class="head_address_line_one" value="">
              <input type="hidden" class="head_address_line_two" value="">
              <input type="hidden" class="head_area" value="">
              <input type="hidden" class="head_city" value="">
              <input type="hidden" class="head_pin" value="">
              <input type="hidden" class="head_whatsapp" value="">
            <fieldset>
                <legend>
                    Personal Info
                </legend>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Name Salutation <span style="color: red">*</span></label>
                        <select class="form-control" name="name_salutation">
                          <option value="Mr." @if(!empty($client) && $client->name_salutation == 'Mr.') selected @endif>Mr.</option>
                          <option value="Miss" @if(!empty($client) && $client->name_salutation == 'Miss') selected @endif>Miss</option>
                          <option value="Mrs." @if(!empty($client) && $client->name_salutation == 'Mrs.') selected @endif>Mrs.</option>
                          <option value="Ms." @if(!empty($client) && $client->name_salutation == 'Ms.') selected @endif>Ms.</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>First Name <span style="color: red">*</span></label>
                        <input type="text" placeholder="First Name" class="form-control" value="@if(!empty($client)){{ $client->first_name }}@endif" name="first_name">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Middle Name </label>
                        <input type="text" placeholder="Middle Name" class="form-control" value="@if(!empty($client)){{ $client->middle_name }}@endif" name="middle_name">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Last Name <span style="color: red">*</span></label>
                        <input type="text" placeholder="Last Name" class="form-control" value="@if(!empty($client)){{ $client->last_name }}@endif"  name="last_name">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Category <span style="color: red">*</span></label>
                        <select class="form-control" name="client_category">
                          <option value="Silver" @if(!empty($client) && $client->client_category == 'Silver') selected @endif>Silver</option>
                          <option value="Gold" @if(!empty($client) && $client->client_category == 'Gold') selected @endif>Gold</option>
                          <option value="Diamond" @if(!empty($client) && $client->client_category == 'Diamond') selected @endif>Diamond</option>
                          
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Date of Birth <span style="color: red">*</span></label>
                        <input type="date" placeholder="Date of Birth" value="@if(!empty($client)){{ date('Y-m-d',strtotime($client->date_of_birth)) }}@endif" class="form-control" name="date_of_birth">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Date of Anniversary</label>
                        <input type="date" placeholder="Date of Anniversary" value="@if(!empty($client)){{ date('Y-m-d',strtotime($client->date_of_anniversary)) }}@endif" class="form-control" name="date_of_anniversary">
                      </div>
                    </div>
                 
                    
                  </div>
            </fieldset>

             <fieldset>
                <legend>
                    Business Detail
                </legend>
                <div class="row">
        
            <div class="items-collection">
              @if(!empty($businesses))
                @foreach($businesses as $business)
                <div class="items col-xs-6 col-sm-3 col-md-3 col-lg-2">
                    <div class="info-block block-info clearfix">
                        <div data-toggle="buttons" class="btn-group bizmoduleselect">
                            <label class="btn btn-default @if(!empty($client) && in_array($business->id,$busineess)) active @endif">
                                <div class="itemcontent">
                                    <input type="checkbox" name="business_done[]" autocomplete="off"  value="{{ $business->id }}"  @if(!empty($client) && in_array($business->id,$busineess)) checked @endif>
                                    <h5 style="margin-bottom: 0px; font-size: 14px;">{{$business->name}}</h5>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                             
                              

            </div>
        
    </div>
            </fieldset>
            <fieldset>
                <legend>
                    Group Detail
                </legend>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                      <!-- textarea -->
                      <div class="form-group">
                        <input type="hidden" class="group_id_selected" value="@if(!empty($client)){{ $client->group_id }}@endif">
                        <label style="width: 100%;">Group <span style="color: red">*</span></label>
                        <select class="form-control groupload" name="group" style="width: 75%; display:inline-block;">
                          
                        </select>

                        <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal"
                       class="btn btn-info btn-sm openaddmodal" data-id="" style="float: right; ">
                        <i class="fa fa-plus"></i> Add</a>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                         <label>Relation <span style="color: red">*</span></label>
                         <select class="form-control" name="relation">
                          <option value="Self" @if(!empty($client) && $client->relation == 'Self') selected  @endif>Self</option>
                          <option value="Husband" @if(!empty($client) && $client->relation == 'Husband') selected @endif>Husband</option>
                          <option value="Wife" @if(!empty($client) && $client->relation == 'Wife') selected  @endif>Wife</option>
                          <option value="Father"@if(!empty($client) && $client->relation == 'Father') selected  @endif>Father</option>
                           <option value="Mother"@if(!empty($client) && $client->relation == 'Mother') selected  @endif>Mother</option>
                          <option value="Brother"@if(!empty($client) && $client->relation == 'Brother') selected  @endif>Brother</option>
                          <option value="Sister"@if(!empty($client) && $client->relation == 'Sister') selected  @endif>Sister</option>
                          <option value="Son" @if(!empty($client) && $client->relation == 'Son') selected  @endif>Son</option>
                          <option value="Daughter"@if(!empty($client) && $client->relation == 'Daughter') selected  @endif>Daughter</option>
                          <option value="Staff"@if(!empty($client) && $client->relation == 'Staff') selected  @endif>Staff</option>
                          <option value="Friend"@if(!empty($client) && $client->relation == 'Friend') selected  @endif>Friend</option>
                          <option value="Others"@if(!empty($client) && $client->relation == 'Others') selected  @endif>Others</option>
                        </select>
                      
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Is Group Head?</label>
                        <div class="outerDivFull" >
                            <div class="switchToggle">
                                <input type="checkbox" id="switch"  name="group_head" class="group_headis" @if(!empty($client) && $client->group_head == 'yes') checked  @endif  @if(empty($client)) checked @endif>
                                <label for="switch">Toggle</label>
                            </div>
                        </div>

                      </div>
                    </div>
                     
                    
                    
                
                </div>
            </fieldset>
            <fieldset>
                <legend>
                    Address Detail
                </legend>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Copy from Group Head</label>
                        <div class="outerDivFull" >
                            <div class="switchToggle">
                                <input type="checkbox" id="switchone"  name="copy_head" class="copy_head_button">
                                <label for="switchone">Toggle</label>
                            </div>
                        </div>

                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" placeholder="Mobile Number"  value="@if(!empty($client)){{ $client->mobile_number }}@endif" class="form-control mobile_number" name="mobile_number" required>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Whatsapp number</label>
                        <input type="text" placeholder="Whatsapp number"  value="@if(!empty($client)){{ $client->whatsapp_number }}@endif" class="form-control whatsapp_number" name="whatsapp_number">
                        <input type="checkbox" name="checkbox" id="checkbox_id" class="copyfrommobile">
<label for="checkbox_id" style="cursor: pointer;">Copy From Mobile</label>
                       
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="Email"  value="@if(!empty($client)){{ $client->email }}@endif" class="form-control email" name="email" required>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Address Line 1</label>
                        <textarea class="form-control address_1" rows="1" placeholder="Address Line 1" name="address_1" required>@if(!empty($client)){{ $client->address_1 }}@endif</textarea>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Address Line 2</label>
                        <textarea class="form-control address_2" rows="1" placeholder="Address Line 2" name="address_2" required>@if(!empty($client)){{ $client->address_2 }}@endif</textarea>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Area</label>
                        <input type="text" placeholder="Area" value="@if(!empty($client)){{ $client->area }}@endif" class="form-control area" name="area" required>
                      </div>
                    </div> 
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>City</label>
                        <input type="text" placeholder="City" value="@if(!empty($client)){{ $client->city }}@endif"  class="form-control city" name="city" required>
                      </div>
                    </div> 
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label>Pin Code</label>
                        <input type="text" placeholder="Pin Code" value="@if(!empty($client)){{ $client->pin_code }}@endif" class="form-control pin_code" name="pin_code" required>
                      </div>
                    </div> 
                </div>
            </fieldset>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="submitspinner"></span></button>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
</div>