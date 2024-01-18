<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Time Start</th>
            <th>Time End</th>
            <th>User</th>
            <th>Contact</th>
            <th>Contact Company</th>
            <th>Contact Company Type</th>
            <th>Objective</th>
            <th>Marketing Requirements</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($meetings as $meeting)
            <tr>
                <td>{{ $meeting->id }}</td>
                <td>{{ $meeting->date }}</td>
                <td>{{ $meeting->start_time }}</td>
                <td>{{ $meeting->end_time }}</td>
                <td>{{ $meeting->user->name }}</td>
                <td>{{ $meeting->contact->name }}</td>
                <td>{{ $meeting->contact->company->name }}</td>
                <td>{{ $meeting->contact->company->type->name }}</td>
                <td>{{ $meeting->objective }}</td>
                <td>{{ $meeting->marketing_requirements }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
