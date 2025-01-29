<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >
    <title>{{ __('Calendar PDF') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen w-full flex-col justify-between p-3">
    <div class="flex items-center justify-between">
        <div class="flex flex-col items-start gap-3">
            <img
                class="h-12"
                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo-black.png'))) }}"
                alt="Logo"
            >

        </div>
        <span class="text-2xl font-bold uppercase text-[#221e1e]">
            {{ $month . ' ' . $year }}
        </span>
        <span class="max-h-fit rounded-sm bg-[#dd5f1f] px-6 py-1 text-base font-bold uppercase text-neutral-50 shadow">
            {{ $user->name ?? 'N/A' }}
        </span>
    </div>
    <div class="flex h-full w-full flex-col">
        <table>
            <thead>
                <tr>
                    @foreach ($days as $day)
                        <th class="py-1 text-center text-sm font-bold uppercase text-neutral-700">
                            {{ $day }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($calendar as $week)
                    <tr class="border-[1px] border-solid border-neutral-900">
                        @foreach ($week as $day)
                            @if ($day['day'] == '00')
                                <td class="border-[1px] border-solid border-neutral-900 bg-neutral-100"></td>
                            @else
                                <td
                                    class="relative border-[1px] border-solid border-neutral-900 text-xs text-neutral-700">
                                    <span class="absolute right-1 top-1 font-bold text-[#dd5f1f]">
                                        {{ $day['day'] }}
                                    </span>
                                    <div class="flex h-full w-full flex-col items-start justify-start p-2 text-[8px]">
                                        @foreach ($day['meetings'] as $meeting)
                                            <div class="-mb-1 flex gap-1">
                                                <span class="min-w-[50px] text-nowrap font-bold">
                                                    {{ date('H:i', strtotime($meeting->start_time)) . ' ' . $meeting?->type ?? 'N/A' }}
                                                </span>
                                                <div class="flex w-full flex-col items-start">
                                                    <span class="max-w-[140px] truncate font-bold">
                                                        {{ $meeting?->company()?->name ?? 'No company name set...' }}
                                                    </span>
                                                    <span class="-mt-1 truncate">
                                                        {{ $meeting?->location ?? 'No location set...' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <span class="mt-1 w-full text-right text-[8px] text-neutral-900">
            {{ __('© Copyright - Alltech Meeting Planner - ') . date('Y') }}
        </span>
    </div>
</body>

</html>
