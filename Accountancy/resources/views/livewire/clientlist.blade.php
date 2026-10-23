<div class="space-y-4">
    <div>
        <h1 class="text-2xl font-semibold">Clients</h1>
        <p class="text-sm text-gray-500">Syncing is a placeholder for now: no data is sent to or read from the accounting software.</p>
    </div>

    @if ($message)
        <div class="rounded border border-blue-200 bg-blue-50 px-4 py-2 text-sm text-blue-800">{{ $message }}</div>
    @endif

    <div class="overflow-x-auto rounded border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Client</th>
                    @foreach ($services as $name)
                        <th class="px-4 py-3">{{ $name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($clients as $client)
                    <tr wire:key="client-{{ $client['id'] }}">
                        <td class="px-4 py-3 align-top">
                            <div class="font-medium">{{ $client['name'] }}</div>
                            <div class="text-gray-500">{{ $client['email'] }}</div>
                        </td>
                        @foreach ($services as $service => $name)
                            <td class="px-4 py-3 align-top">
                                <span @class([
                                    'inline-block rounded-full px-2 py-0.5 text-xs font-medium',
                                    'bg-green-100 text-green-800' => $client[$service] === 'Completed',
                                    'bg-yellow-100 text-yellow-800' => $client[$service] === 'In Progress',
                                    'bg-red-100 text-red-800' => $client[$service] === 'Failed',
                                    'bg-gray-100 text-gray-700' => $client[$service] === 'Not Started',
                                ])>{{ $client[$service] }}</span>

                                @isset($client['financials'][$service])
                                    <div class="mt-1 text-xs text-gray-600">
                                        {{ $client['financials'][$service]['invoices'] }} invoices
                                        &middot; {{ number_format($client['financials'][$service]['balance'], 2) }} owed
                                    </div>
                                @endisset

                                <div class="mt-2 flex gap-2 text-xs">
                                    <button wire:click="pushContact({{ $client['id'] }}, '{{ $service }}')" class="text-blue-700 hover:underline">Push contact</button>
                                    <button wire:click="pullFinancials({{ $client['id'] }}, '{{ $service }}')" class="text-blue-700 hover:underline">Pull invoices</button>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
