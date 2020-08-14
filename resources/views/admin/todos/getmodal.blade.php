<form  autocorrect="off" action="{{ route('admin.todos.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit">
   {{ csrf_field() }}
   @if(isset($todo) && !empty($todo->id) )
   <input type="hidden" name="todo_id" value="{{ encrypt($todo->id) }}">
   @endif
   <div class="row">
      <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Task Name <span style="color: red">*</span></label>
            <input type="text" class="form-control" name="task_name"
               placeholder="Task Name"
               value="@if(!empty($todo)){{ $todo->task_name }}@endif" required="">
         </div>
      </div>
      <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Work Alloted To  <span style="color: red">*</span></label>
            <select class="form-control select2" name="work_alloted_id" style="width: 100%;" required="">
            @if(!empty($users))
            @foreach($users as $user)  
            <option value="{{ $user->id }}" @if(!empty($todo) && $todo->user->name == $user->name) {{ 'selected' }} @endif> {{ $user->name }} {{ $user->lastname }}</option>
            @endforeach
            @endif
            </select>
         </div>
      </div>
      <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Due Date  <span style="color: red">*</span></label>
            @php 
            $duedate = '';
               if(!empty($todo)){
                  $duedate = $todo->due_date;
               }
               if(empty($todo)){
                  $duedate = date('Y-m-d', strtotime('tomorrow'));
               }
            @endphp
            <input type="date"  class="form-control" name="due_date" value="{{ $duedate }}"  required="">
         </div>
      </div>
 
      <div class="col-sm-12">
         <div class="form-group">
            <label>Description  <span style="color: red">*</span></label>
            <textarea class="form-control" name="description"  rows="3"  placeholder="Enter Desdcription" required="">@if(!empty($todo)){{ $todo->description }}@endif</textarea>
         </div>
      </div>
      <div class="col-md-12">
         <div class="form-group">
            <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
         </div>
      </div>
   </div>
</form>
<script type="text/javascript">
   $('.select2').select2()
</script>