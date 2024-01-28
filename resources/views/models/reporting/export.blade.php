<table>
    <thead>
    <tr>
        <th>{{ __('Company') }}</th>
        <th>{{ __('Contact') }}</th>
        <th>{{ __('Contact email') }}</th>
        <th>{{ __('Sales rep') }}</th>
        <th>{{ __('Date') }}</th>
        <th>{{ __('Start time') }}</th>
        <th>{{ __('End time') }}</th>
        <th>{{ __('Objective') }}</th>
        <th>{{ __('Marketing requirements') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($meetings as $meeting)
        <tr>
            <td>{{ $meeting->company()->name }}</td>
            <td>{{ $meeting->contact->name }}</td>
            <td>{{ $meeting->contact->email }}</td>
            <td>{{ $meeting->user->name }}</td>
            <td>{{ $meeting->date }}</td>
            <td>{{ $meeting->start_time }}</td>
            <td>{{ $meeting->end_time }}</td>
            <td>{{ $meeting->objective }}</td>
            <td>{{ $meeting->marketing_requirements }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
