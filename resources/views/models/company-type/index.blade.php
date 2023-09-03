<x-dashboard>
    <div class="flex justify-between items-center">
        <h1>{{ __('Company types') }}</h1>
        <a href="{{ route('company-type.create') }}" class="btn-primary max-w-fit">
            {{ __('Add company type') }}
        </a>
    </div>
    
    <div class="card mt-3 overflow-auto">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Minimum Required') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companyTypes as $companyType)
                <tr>
                    <td>
                        <a href="{{ route('company-type.edit', $companyType->id) }}">
                            {{ $companyType->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('company-type.edit', $companyType->id) }}">
                            {{ $companyType->minimum_required }}
                        </a>
                    </td>
                    <td>
                        @if ($companyType->id != auth()->user()->id)
                            <x-icon.delete class="w-5" id="delete-button-{{ $companyType->id }}"/>
                            <x-modals.delete :model="'company-type'" :object="$companyType" />
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard>
