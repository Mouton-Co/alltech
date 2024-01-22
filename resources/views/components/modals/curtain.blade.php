@php
    $show = !empty($show) && $show ? 'block' : 'hidden';
@endphp
<div id="curtain-modal" class="w-full h-full fixed top-0 left-0 z-50 opacity-70 bg-black {{ $show }}"></div>
