<x-dashboard>
    <div class="flex justify-between items-center">
        <h1>{{ __('Contacts') }}</h1>
        <a href="{{ route('contact.create') }}" class="btn-primary max-w-fit">
            {{ __('Add contact') }}
        </a>
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
            <tbody>
                @foreach ($contacts as $contact)
                <tr>
                    <td>
                        <a href="{{ route('contact.edit', $contact->id) }}">
                            {{ $contact->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('contact.edit', $contact->id) }}">
                            {{ $contact->email }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('contact.edit', $contact->id) }}">
                            {{ $contact->phone }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('contact.edit', $contact->id) }}">
                            {{ $contact->company->name }}
                        </a>
                    </td>
                    <td>
                        <x-icon.delete class="w-5" id="delete-button-{{ $contact->id }}"/>
                        <x-modals.delete :model="'contact'" :object="$contact" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard>
