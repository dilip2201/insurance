<option value="">---Select Group---</option>
@if(!empty($groups))
@foreach($groups as $group)
<option value="{{ $group->id }}" @if(!empty($groupid) && $groupid == $group->id) selected @endif>{{ $group->name }} @if(!empty($group->code)) ({{ $group->code }}) @endif</option>
@endforeach
@endif