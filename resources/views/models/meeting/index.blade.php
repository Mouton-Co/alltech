<x-dashboard>
    <div class="flex justify-start items-center gap-8 pb-3">
        <h1>{{ __('Daily schedule') }}</h1>
        <x-form.date-picker :date="$date"/>
    </div>

    @foreach ($companyTypes as $companyType)
        <div class="card mt-3 overflow-auto !pt-2 !pb-3 mb-6 no-scrollbar">
            <table class="vertical-lines">
                <caption>{{ $companyType->name }}</caption>
                <thead>
                    <tr>
                        <th>{{ __('Time') }}</th>
                        <th>{{ __('Contact') }}</th>
                        <th>{{ __('Company') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Coordinates') }}</th>
                        <th>{{ __('Objective') }}</th>
                        <th>{{ __('Requirements') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meetings as $meeting)
                        @if ($meeting->company_type_id != $companyType->id)
                            @continue
                        @endif
                        <tr>
                            <td>{{ $meeting->start_time . ' -> ' . $meeting->end_time }}</td>
                            <td>{{ $meeting->contact->name }}</td>
                            <td>{{ $meeting->company()->name }}</td>
                            <td>{{ $meeting->company()->location }}</td>
                            <td>{{ $meeting->contact->phone }}</td>
                            <td>{{ $meeting->contact->email }}</td>
                            <td>{{ $meeting->company()->coordinates }}</td>
                            <td>{{ $meeting->objective }}</td>
                            <td>{{ $meeting->requirements }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    @section('end-body-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    @endsection
</x-dashboard>
