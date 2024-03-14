<div class="rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all flex-col gap-3 z-60
resource-modal absolute top-[50%] translate-y-[-50%] left-[50%] translate-x-[-50%] w-[732px]
max-h-[calc(100vh-100px)] overflow-x-hidden overflow-auto
smaller-than-740:w-[calc(100%-16px)] {{ !empty($show) && $show ? 'flex' : 'hidden' }}" {{ $attributes }}>

    <div class="flex justify-between items-center">
        <h2 class="w-full">
            @if (!empty($title))
                {{ $title }}
            @else
                {{ __('Creating/Editing resource') }}
            @endif
        </h2>
        <button class="w-fit modal-cancel text-xl hover:text-orange">
            {{ __('X') }}
        </button>
    </div>
    
    <form action="{{ $route }}" method="POST" class="w-full flex flex-col items-end gap-3">
        @csrf
        @if (!empty($method))
            @method($method)
        @endif

        {{ $slot }}

        <div class="flex gap-3 w-full justify-end">
            @if (!empty($meeting))
                <div class="btn-transparent w-fit px-5 h-[30px] cursor-pointer flex items-center cancel-meeting-button"
                id="cancel-meeting-{{ $meeting }}">
                    {{ __('Cancel meeting') }}
                </div>
            @endif
            <button type="submit" class="btn-orange w-fit px-5 h-[30px]">
                @if (!empty($button))
                    {{ $button }}
                @else
                    {{ __('Create/Edit') }}
                @endif
            </button>
        </div>
    </form>

</div>
