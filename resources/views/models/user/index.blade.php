<x-dashboard>
    <div class="flex justify-between items-center">
        <h1>{{ __('Users') }}</h1>
        <a href="{{ route('user.create') }}" class="btn-primary max-w-fit">
            {{ __('Add user') }}
        </a>
    </div>
    
    <div class="card mt-3 overflow-auto">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Role') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}">
                            {{ $user->email }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}">
                            {{ $user->role->name }}
                        </a>
                    </td>
                    <td>
                        @if ($user->id != auth()->user()->id)
                            <x-icon.delete class="w-5" />
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard>
