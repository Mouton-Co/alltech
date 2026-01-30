<div>
    {{-- title --}}
    <h1 class="mb-3">Merge companies into {{ $targetCompany['name'] ?? '' }}</h1>

    {{-- target company details --}}
    <div class="max-w-lg">
        <div class="border-b border-gray-300 pb-3">
            <div class="-ml-2 -mt-2 flex flex-wrap items-baseline">
                <h3 class="ml-2 mt-2 text-base font-semibold text-gray-900">Target Company</h3>
                <p class="ml-2 mt-1 truncate text-sm text-gray-500">
                    This is the company that will remain after the merge.
                </p>
            </div>
        </div>
        <div class="pt-3 lg:col-start-3 lg:row-end-1">
            <div class="shadow-xs rounded-lg bg-white outline-1 outline-gray-900/5">
                <dl class="flex flex-wrap">
                    <div class="flex-auto pl-6 pt-3">
                        <div class="flex gap-2">
                            <x-icon.company class="h-5 w-5 text-gray-400" />
                            <h3 class="text-sm font-medium leading-6 text-gray-900">
                                {{ $targetCompany['name'] ?? '' }}
                            </h3>
                        </div>
                    </div>
                </dl>
                <div class="mt-3 border-t border-gray-900/5 px-6 py-3">
                    <div class="flex gap-2">
                        <x-icon.location class="h-5 w-5 text-gray-400" />
                        <h3 class="text-sm font-medium leading-6 text-gray-900">
                            {{ $targetCompany['location'] ?? '' }}
                        </h3>
                    </div>
                    <div class="flex gap-2">
                        <x-icon.coordinates class="h-5 w-5 text-gray-400" />
                        <h3 class="text-sm font-medium leading-6 text-gray-900">
                            {{ $targetCompany['region'] ?? '' }}
                        </h3>
                    </div>
                    <div class="flex gap-2">
                        <x-icon.company-type class="h-5 w-5 text-gray-400" />
                        <h3 class="text-sm font-medium leading-6 text-gray-900">
                            {{ $targetCompany['company_type']['name'] ?? '' }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
