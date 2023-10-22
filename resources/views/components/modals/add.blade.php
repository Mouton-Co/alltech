<div class="rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all flex-col gap-3 z-40
delete-modal absolute top-[50%] translate-y-[-50%] left-[50%] translate-x-[-50%] w-[732px]
smaller-than-740:w-[calc(100%-16px)] {{ !empty($show) && $show ? 'flex' : 'hidden' }}" {{ $attributes }}
id="add-resource-modal">

    <div class="flex justify-between items-center">
        <h2 class="w-full">
            @if (!empty($title))
                {{ $title }}
            @else
                {{ __('Creating resource') }}
            @endif
        </h2>
        <button class="w-fit modal-cancel text-xl hover:text-orange">
            {{ __('X') }}
        </button>
    </div>
    
    <form action="{{ route("$route.store") }}" method="POST" class="w-full flex flex-col items-end gap-3">
        @csrf

        {{ $slot }}

        <button type="submit" class="btn-orange-thin w-fit px-5 h-[30px]">
            {{ __('Create') }}
        </button>
    </form>

</div>
