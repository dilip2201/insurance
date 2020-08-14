 <option value="">Select Company</option>
@if(!empty($companies))
@foreach($companies as $company)
<option value="{{ $company->id }}"  @if(!empty($company_id) && $company_id == $company->id) selected @endif>{{ $company->name }}</option>
@endforeach
@endif