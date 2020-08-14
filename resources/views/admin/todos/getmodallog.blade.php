<form  autocorrect="off" action="{{ route('admin.todos.storelog') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmitlog">
   {{ csrf_field() }}

   <div class="row">
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <input type="hidden" name="to_do_id" value="{{ $todo_id }}">
    <input type="hidden" name="status" value="{{ $status->status }}">
     

      <div class="col-sm-12 col-md-12" >
         <div class="form-group">
            <label>Due Date  <span style="color: red">*</span></label>
            <input type="date"  class="form-control" name="date" value=""  required="">
         </div>
      </div>

 
      <div class="col-sm-12">
         <div class="form-group">
            <label>Description  <span style="color: red">*</span></label>
            <textarea class="form-control" name="comment"  rows="3"  placeholder="Enter Comment" required=""></textarea>
         </div>
      </div>

      <div class="col-md-12">
         <div class="form-group">
            <button type="submit" class="btn btn-primary  submitbuttonlog pull-right"> Submit <span class="spinner"></span></button>
         </div>
      </div>
   </div>
</form>