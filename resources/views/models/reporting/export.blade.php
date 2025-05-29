<table>
    <thead>
    <tr>
        <th>{{ __('Sales rep') }}</th>
        <th>{{ __('All day') }}</th>
        <th>{{ __('Date') }}</th>
        <th>{{ __('End date') }}</th>
        <th>{{ __('Start time') }}</th>
        <th>{{ __('End time') }}</th>
        <th>{{ __('Meeting title') }}</th>
        <th>{{ __('Company') }}</th>
        <th>{{ __('Company Type') }}</th>
        <th>{{ __('Contact') }}</th>
        <th>{{ __('Contact email') }}</th>
        <th>{{ __('Location') }}</th>
        <th>{{ __('Report') }}</th>
        <th>{{ __('Cancelled') }}</th>
        <th>{{ __('Cancelled reason') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($meetings as $meeting)
        <tr>
            <td>{{ $meeting->user->name }}</td>
            <td>{{ $meeting->all_day ?? false ? __('Yes') : __('No') }}</td>
            <td>{{ $meeting->date }}</td>
            <td>{{ $meeting->all_day ?? false ? $meeting->end_date : '' }}</td>
            <td>{{ $meeting->all_day ?? false ? '' : $meeting->start_time }}</td>
            <td>{{ $meeting->all_day ?? false ? '' : $meeting->end_time }}</td>
            <td>{{ $meeting->title }}</td>
            <td>{{ $meeting->company()->name }}</td>
            <td>{{ $meeting->company()->companyType->name }}</td>
            <td>{{ $meeting->contact->name }}</td>
            <td>{{ $meeting->contact->email }}</td>
            <td>{{ $meeting->location }}</td>
            <td>{{ $meeting->report }}</td>
            <td>{{ $meeting->cancelled_at ? __('Yes') : __('No') }}</td>
            <td>{{ $meeting->cancelled_reason }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
