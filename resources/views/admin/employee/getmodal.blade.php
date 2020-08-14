<div class="row getModalPage">
    <form  autocorrect="off" autocomplete="off" method="post"
          class="form-horizontal form-bordered formsubmit">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group profileInImg">
                            @php $image = url('public/company/employee/default.png'); @endphp
                            @if(isset($employee) && !empty($employee->image) && $employee->image !== null)
                                @php $image = url('public/admin/images/sales/'.$employee->image); @endphp
                            @endif

                            @if(isset($employee) && !empty($employee->id) )
                                <input type="hidden" name="userid" value="{{ encrypt($employee->id) }}">
                            @endif
                            <span style="width: 100%; text-align: center; float: left;">
                        <img src="{{ $image }}" class="image_preview" width="auto" height="150px">

<label class="text-muted">
   <b>Acceptable formats:</b> png, jpg, jpeg <i class="maxStyle">(Max: 2MB) </i>
</label>

                     </span>
                            <div class="clearFix"></div>
                            <div class="proInputDv">
                                <input type="file" class=" changeuserimage" accept="image/*"
                                       name="image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 pdLeft5 pdResponsive">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-book" aria-hidden="true"></i> First Name
                                <span style="color: red;">*</span></label>
                            <input type="text" class="form-control classfocus" maxlength="50" name="name"
                                   placeholder="First Name"
                                   value="@if(!empty($employee)){{ $employee->name }}@endif" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-book" aria-hidden="true"></i> Last Name <span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control " maxlength="30" name="lastname"
                                   placeholder="Last Name"
                                   value="@if(!empty($employee)){{ $employee->lastname }}@endif" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span
                                    style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="email"
                                   placeholder="Email"
                                   value="@if(!empty($employee)){{ $employee->email }}@endif" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-phone" aria-hidden="true"></i> Phone<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control phonenumber" name="phone"
                                   placeholder="Phone"
                                   value="@if(!empty($employee)){{ $employee->phone }}@endif" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-address-card" aria-hidden="true"></i> Address</label>
                            <input type="text" class="form-control " name="address"
                                   placeholder="Address"
                                   value="@if(!empty($employee)){{ $employee->address }}@endif">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <div class="col-md-12 no-padding">
                                <label><i class="fa fa-map" aria-hidden="true"></i> City <span
                                        style="color: red;">*</span></label>
                                <select class="form-control cityselectwithstatecountry" name="cityid">
                                    @if(!empty($employee))
                                        <option value="{{ $employee->city->id }}"
                                                selected>{{ $employee->city->name }}
                                            , {{ $employee->city->state->name }}
                                            , {{ $employee->city->state->country->name }}</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-map-pin" aria-hidden="true"></i> Postal Code</label>
                            <input type="text" class="form-control " name="postal_code"
                                   placeholder="Postal Code"
                                   value="@if(!empty($employee)){{ $employee->postal_code }}@endif">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-phone" aria-hidden="true"></i> Birth Date</label>
                            <input type="date" class="form-control " name="birthdate"
                                   placeholder="Birthdate"
                                   value="@if(!empty($employee)){{ $employee->birthdate }}@endif" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-hand-o-right" aria-hidden="true"></i> Age</label>
                            <input type="text" class="form-control " name="age"
                                   placeholder="Age"
                                   value="@if(!empty($employee)){{ $employee->age }}@endif" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-hand-o-right" aria-hidden="true"></i> Gender</label><br>
                            <input type="radio"  name="gender" value="Female"> Female
                            <input type="radio"  name="gender" value="Male"> Male
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-hand-o-right" aria-hidden="true"></i> Account Number</label>
                            <input type="text" class="form-control " name="account_no"
                                   placeholder="Account Number"
                                   value="@if(!empty($employee)){{ $employee->account_no }}@endif" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
            <div class="form-group">
                <button type="submit" class="btn btn-primary  submitbutton"> Submit
                    <span class="spinner"></span></button>
            </div>
        </div>
    </form>
</div>
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
        dropdownParent: $('.openaddmodal'),
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
</script>

