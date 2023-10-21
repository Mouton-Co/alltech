<div class="rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all hidden flex-col gap-3 z-40
delete-modal absolute top-[50%] translate-y-[-50%] left-[50%] translate-x-[-50%] w-[512px]
smaller-than-520:w-[calc(100%-16px)]" {{ $attributes }}>
    <h2 class="w-full">{{ __('Please confirm') }}</h2>
    <p class="w-full">
        @if ($message)
            {{ $message }}
        @else
            {{ __('Are you sure you want to delete this resource?') }}
        @endif
    </p>
    <div class="w-full flex gap-3 mt-3">
        <form action="{{ route("$route.destroy", $resource->id) }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="btn-orange-thin w-full h-[30px]">
                {{ __('Delete') }}
            </button>
        </form>
        <button class="btn-transparent-thin w-full delete-modal-cancel">
            {{ __('Cancel') }}
        </button>
    </div>
</div>
