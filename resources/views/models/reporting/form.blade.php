{{-- report id --}}
@if(!empty($report->id))
    <input type="hidden" name="report_id" value="{{ $report->id }}">
@endif

{{-- filter --}}
<input type="hidden" name="filter" value="{{ json_encode(request()->query()) }}">

{{-- filter name --}}
<input type="text" name="name" placeholder="Filter Name" class="filter-field">
