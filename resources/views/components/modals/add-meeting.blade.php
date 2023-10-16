<div id="add-modal-{{ $object->id }}" class="hidden relative z-50" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    {{-- curtain --}}
    <div id="curtain-{{ $object->id }}" class="fixed inset-0 bg-gray-500 curtain-closed"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div id="add-modal-popup-{{ $object->id }}" class="field-card modal-close card text-black
            dark:text-white !py-5">
                <div>
                    <div class="text-left">
                        <h2>{{ $object->name }}</h2>
                        <div class="mt-2">
                            <p class="text-sm">
                                {{ __("Are you sure you want to delete this item?") }}
                            </p>
                        </div>
                    </div>
                </div>
                <form class="flex gap-3 mt-5 sm:mt-6 justify-evenly" action="#"
                    method="post">
                    @csrf
                    <button id="add-modal-cancel-{{ $object->id }}" type="button" class="btn-secondary">
                        {{ __('Cancel') }}
                    </button>
                    <input class="btn-primary" type="submit" value="{{ __('Create') }}">
                </form>
            </div>
        </div>
    </div>
</div>
