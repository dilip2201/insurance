<form  autocorrect="off" action="{{ route('admin.works.storecompany') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit1">
   {{ csrf_field() }}
   <div class="row">
      <div class="col-sm-12 col-md-12">
         <div class="form-group">
            <label>Company  <span style="color: red">*</span></label>
            <input type="text" class="form-control " name="name"
               placeholder="Company" required="">
         </div>
      </div>
      <div class="col-md-12">
         <div class="form-group">
            <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
         </div>
      </div>
   
</form>