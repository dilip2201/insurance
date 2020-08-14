<style type="text/css">
   .form-control:disabled, .form-control[readonly] {
     background-color: #b9b9b9;
   }
</style>
<form  autocorrect="off" action="{{ route('admin.works.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit">
   {{ csrf_field() }}
   @if(isset($work) && !empty($work->id) )
   <input type="hidden" name="workid" value="{{ encrypt($work->id) }}">
   @endif
   <input type="hidden" class="group_id_selected" value="@if(!empty($work)){{ $work->company_id }}@endif">
   <fieldset>
      <legend>
         Work Detail
      </legend>
      <div class="row">
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Clients<span style="color: red">*</span></label>
               <select class="form-control select2" name="client" style="width: 100%;" required="">
               <option value="">Please Select Client</option> 
               @if(!empty($clients))
               @foreach($clients as $client) 
               <option value="{{ $client->id }}" @if(!empty($work) && $work->client_id == $client->id) {{ 'selected' }}@endif> {{ $client->name_salutation }} {{ $client->first_name }} {{ $client->last_name }}</option>
               @endforeach
               @endif
               </select>
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Work<span style="color: red">*</span></label>
               <select class="form-control" name="work" required=""> 
               <option value="">Please Select Work</option>
               <option value="accounting" @if(!empty($work) && $work->work == 'accounting') selected @endif> Accounting</option>
               <option value="audit" @if(!empty($work) && $work->work == 'audit') selected @endif> Audit</option>
               <option value="GST" @if(!empty($work) && $work->work == 'GST') selected @endif> GST</option>
               <option value="TDS" @if(!empty($work) && $work->work == 'TDS') selected @endif> TDS</option>
               <option value="income_tax" @if(!empty($work) && $work->work == 'income_tax') selected @endif> Income Tax</option>
               <option value="LIC" @if(!empty($work) && $work->work == 'LIC') selected @endif> LIC</option>
               <option value="personal_accident" @if(!empty($work) && $work->work == 'personal_accident') selected @endif> Personal Accident</option>
               <option value="term_plan" @if(!empty($work) && $work->work == 'term_plan') selected @endif> Term Plan</option>
               <option value="mediclaim" @if(!empty($work) && $work->work == 'mediclaim') selected @endif> Mediclaim</option>
               <option value="top-up_mediclaim" @if(!empty($work) && $work->work == 'top-up_mediclaim') selected @endif> Top-up Mediclaim</option>
               <option value="vehical_insurance" @if(!empty($work) && $work->work == 'vehical_insurance') selected @endif> Vehical Insurance</option>
               <option value="mutual_funds" @if(!empty($work) && $work->work == 'mutual_funds') selected @endif> Mutual Funds</option>
               <option value="SIP" @if(!empty($work) && $work->work == 'SIP') selected @endif> SIP</option>
               <option value="fixed_deposit" @if(!empty($work) && $work->work == 'fixed_deposit') selected @endif> Fixed Deposit</option>
               <option value="others" @if(!empty($work) && $work->work == 'others') selected @endif> Others</option>
               </select>
            </div>
         </div>
         <div class="col-sm-12 col-md-3">
            <div class="form-group">
               <label>Company<span style="color: red">*</span></label>
               <select class="form-control companyload" id="companyload" name="name" style="display:inline-block;" required="">
   
               </select>
            </div>
         </div>
         <div class="col-sm-12 col-md-1">
            <div class="form-group" style="margin-top: 30px;">
               <a href="#" data-toggle="modal" data-target=".add_modal1" data-id=""  style="padding-left: 5px;padding-right: 5px;padding-top: 1px;padding-bottom: 1px;margin-top: 6px;" 
                  class="btn btn-info openaddmodal1" data-id="">
               <i class="fa fa-plus"></i> </a>
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Document Number<span style="color: red">*</span></label>
               <input type="text" class="form-control " name="doc_number"
                  placeholder="Unique Number" value="@if(!empty($work)){{ $work->unique_number }}@endif" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Amount<span style="color: red">*</span></label>
               <input type="number" class="form-control " name="amount"
                  placeholder="Amount"
                  value="@if(!empty($work)){{ $work->amount }}@endif" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Period<span style="color: red">*</span></label>
               <select class="form-control" name="period" required="">
               <option value="">Please Select Period</option>
               <option value="one_time" @if(!empty($work) && $work->period == 'one_time') selected @endif> One time</option>
               <option value="monthly"  @if(!empty($work) && $work->period == 'monthly') selected @endif>Monthly</option>
               <option value="quarterly"  @if(!empty($work) && $work->period == 'quarterly') selected @endif>Quarterly</option>
               <option value="half_yearly"  @if(!empty($work) && $work->period == 'half_yearly') selected @endif> Half-yearly</option>
               <option value="yearly"  @if(!empty($work) && $work->period == 'yearly') selected @endif>Yearly</option>
               <option value="others"  @if(!empty($work) && $work->period == 'others') selected @endif>Others</option>
               </select>
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Start Date<span style="color: red">*</span></label>
               <input type="date" class="form-control " name="start_date"
                  placeholder="Email"
                  value="@if(!empty($work)){{ $work->start_date }}@endif" required="" >
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>End Date <span style="color: red">*</span></label>
               <input type="date" class="form-control " name="end_date"
                  placeholder="Email"
                  value="@if(!empty($work)){{ $work->end_date }}@endif" required="" >
            </div>
         </div>
         <div class="col-sm-12 col-md-3">
          <div class="form-group">
            <label>Status</label>
            <div class="outerDivFull" >
                <div class="switchToggle">
                    <input type="checkbox" id="switch" name="status" class="group_headis" @if(!empty($work) && $work->status == 'closed') checked  @endif >
                    <label for="switch">Toggle</label>
                </div>
            </div>

          </div>
        </div>
        <div class="col-sm-12 col-md-12 ">
            <div class="form-group">
               <label style="width: 100%;">Description</label>
               <textarea name="description" class="form-control" style="width: 100%;" placeholder="Description">@if(!empty($work)){{ $work->description }}@endif</textarea>
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
            </div>
         </div>
      </div>
   </fieldset>
</form>
