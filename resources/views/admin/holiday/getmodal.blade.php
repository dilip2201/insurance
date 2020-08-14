<form  autocorrect="off" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit">
    {{ csrf_field() }}

    @if(isset($holiday) && !empty($holiday->id) )
        <input type="hidden" name="holidayid" value="{{ encrypt($holiday->id) }}">
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control " name="title"
                       placeholder="Title"
                       value="@if(!empty($holiday)){{ $holiday->title }}@endif" >
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" class="form-control " name="start_date"
                       placeholder="Date"
                       value="@if(!empty($holiday)){{ $holiday->start_date }}@endif" >
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>End Date</label>
                <input type="date" class="form-control " name="end_date"
                       placeholder="Date"
                       value="@if(!empty($holiday)){{ $holiday->end_date }}@endif" >
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
            </div>
        </div>
    </div>
</form>

