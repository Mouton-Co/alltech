<x-dashboard>
    <div class="flex justify-between items-center">
        <h1>{{ __('Companies') }}</h1>
        <a href="{{ route('company.create') }}" class="btn-primary max-w-fit">
            {{ __('Add company') }}
        </a>
    </div>
    
    <div class="card mt-3 overflow-auto">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Location') }}</th>
                    <th>{{ __('Coordinates') }}</th>
                    <th>{{ __('Company Type') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                <tr>
                    <td>
                        <a href="{{ route('company.edit', $company->id) }}">
                            {{ $company->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('company.edit', $company->id) }}">
                            {{ $company->location }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('company.edit', $company->id) }}">
                            {{ $company->coordinates }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('company.edit', $company->id) }}">
                            {{ $company->companyType->name }}
                        </a>
                    </td>
                    <td>
                        <x-icon.delete class="w-5" id="delete-button-{{ $company->id }}"/>
                        <x-modals.delete :model="'company'" :object="$company" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard>
