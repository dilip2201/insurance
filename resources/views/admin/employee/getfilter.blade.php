@if($type == 'qualification')
    <option value="">Select employee</option>
    @foreach(qualification() as $q)
        <option value="{{ $q }}"
                @if(!empty($employee) && $employee->employee_detail->qualification ==$q ) selected @endif>{{ $q }}</option>
    @endforeach
@elseif($type == 'department')
    <option value="Marketplace"> Marketplace</option>
    <option value="Social Media"> Social Media</option>
    <option value="IT"> IT</option>
@elseif($type == 'status')
    <option value="active"> Active</option>
    <option value="inactive"> Inactive</option>
@endif
