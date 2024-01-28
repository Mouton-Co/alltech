<x-dashboard>

    {{-- curtain --}}
    <x-modals.curtain />

    {{-- add modal --}}
    <x-modals.resource :route="route('email-cron.store')" :title="'Creating email'" :button="'Create'"
    id="add-resource-modal">
        @include('models.email-cron.form', ['emailCron' => null])
    </x-modals.resource>

    {{-- title and search --}}
    <div class="flex justify-between mb-3">
        <h1>{{ __('Email tasks') }}</h1>
        <form action="" class="relative">
            <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                class="w-64 smaller-than-740:w-full h-7 pb-[9.5px] border-gray bg-lightgray shadow
                focus:ring-orange focus:border-orange">
            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="absolute right-[2px] top-[2px]">
                <x-icon.search />
            </button>
        </form>
    </div>

    {{-- index table --}}
    <div class="overflow-scroll no-scrollbar">
        <table class="index-table">
            <caption class="hidden">{{ __('Email cron index table') }}</caption>
            <thead>
                <tr>
                    <th>{{ __('Day') }}</th>
                    <th>{{ __('Time') }}</th>
                    <th>{{ __('To') }}</th>
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Filter') }}</th>
                    <th class="flex justify-end">
                        <span class="flex items-center gap-3 cursor-pointer hover:text-orange" id="add-resource">
                            <x-icon.plus class="w-4 h-4" />
                            {{ __('Add new') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emailCrons as $emailCron)
                    <tr>
                        <td>{{ config('models.email-cron.days')[$emailCron->day] }}</td>
                        <td>{{ $emailCron->hour . ':00' }}</td>
                        <td>{{ $emailCron->to }}</td>
                        <td>{{ $emailCron->subject }}</td>
                        <td>{!! $emailCron->formatted_filter !!}</td>
                        <td class="flex justify-end gap-2">
                            <x-icon.edit class="text-blue w-4 cursor-pointer hover:text-orange edit-icon"
                                id="edit-{{ $emailCron->id }}"/>
                            <x-icon.delete class="text-blue w-6 cursor-pointer hover:text-orange delete-icon"
                                id="delete-{{ $emailCron->id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($emailCrons as $emailCron)
        {{-- delete modals --}}
        <x-modals.delete id="delete-modal-{{ $emailCron->id }}" :resource="$emailCron" :route="'email-cron'"
            :message="'Are you sure you wish to delete the email task?'" :method="'DELETE'"/>

        {{-- edit modals --}}
        <x-modals.resource :route="route('email-cron.update', $emailCron->id)" :title="'Editing email task'"
        :button="'Update'" id="edit-resource-modal-{{ $emailCron->id }}" :method="'PUT'">
            @include('models.email-cron.form', ['emailCron' => $emailCron])
        </x-modals.resource>
    @endforeach

    {{-- pagination --}}
    {{ $emailCrons->appends([
        'search' => request()->query('search') ?? '',
    ])->links() }}

</x-dashboard>
