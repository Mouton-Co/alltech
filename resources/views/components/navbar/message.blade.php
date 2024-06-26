@php
    if (empty($color)) {
        if (empty($type)) {
            $type = 'success';
        }
        if ($type == 'success') {
            $color = 'green';
        } else {
            $color = 'red';
        }
    }
@endphp
<div class="mb-6">
    <div
        class="flex justify-between px-4 py-2 mt-3 text-{{ $color }}-500 rounded-lg bg-{{ $color }}-100
        overflow-hidden w-full shadow-md sm:rounded-lg border-solid border-{{ $color }}-500">
        <div class="flex align-center">
            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1
                        1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-medium">{{ $slot }}</div>
        </div>
        <button class="dismiss-button" type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-lg focus:ring-2
                    focus:ring-{{ $color }}-400 p-1.5 hover:bg-{{ $color }}-200 inline-flex h-8 w-8">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414
                        1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1
                        0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
