<x-dashboard>
    <div class="flex justify-start items-center gap-8">
        <h1>{{ __('Daily schedule') }}</h1>
        <x-form.date-picker />
    </div>

    <div class="card mt-3 overflow-auto">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Company') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    @section('end-body-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    @endsection
</x-dashboard>
