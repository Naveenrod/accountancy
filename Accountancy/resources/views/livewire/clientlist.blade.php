<div class="space-y-4">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">Clients</h1>
            <p class="text-sm text-gray-500">Syncing is a placeholder for now: no data is sent to or read from the accounting software.</p>
        </div>
        <a href="{{ route('clients.create') }}" class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Add client</a>
    </div>

    @if ($message)
        <div class="rounded border border-blue-200 bg-blue-50 px-4 py-2 text-sm text-blue-800">{{ $message }}</div>
    @endif

    <input
        type="search"
        wire:model.live.debounce.300ms="search"
        placeholder="Search by name or email"
        class="w-full max-w-sm rounded border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none"
    >

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
                @forelse ($clients as $client)
                    <tr wire:key="client-{{ $client->id }}">
                        <td class="px-4 py-3 align-top">
                            <div class="font-medium">{{ $client->name }}</div>
                            <div class="text-gray-500">{{ $client->email }}</div>
                            <div class="mt-2 flex gap-2 text-xs">
                                <a href="{{ route('clients.edit', $client->id) }}" class="text-gray-600 hover:underline">Edit</a>
                                <button
                                    wire:click="delete({{ $client->id }})"
                                    wire:confirm="Delete {{ $client->name }}? This can't be undone."
                                    class="text-red-700 hover:underline"
                                >Delete</button>
                            </div>
                        </td>
                        @foreach ($services as $service => $name)
                            @php($sync = $client->syncFor($service))
                            <td class="px-4 py-3 align-top">
                                <span @class([
                                    'inline-block rounded-full px-2 py-0.5 text-xs font-medium',
                                    'bg-green-100 text-green-800' => $sync->status === 'Completed',
                                    'bg-yellow-100 text-yellow-800' => $sync->status === 'In Progress',
                                    'bg-red-100 text-red-800' => $sync->status === 'Failed',
                                    'bg-gray-100 text-gray-700' => $sync->status === 'Not Started',
                                ])>{{ $sync->status }}</span>

                                @if ($sync->invoice_count !== null)
                                    <div class="mt-1 text-xs text-gray-600">
                                        {{ $sync->invoice_count }} invoices &middot; {{ number_format($sync->balance, 2) }} owed
                                    </div>
                                @endif

                                @if ($sync->last_synced_at)
                                    <div class="mt-1 text-xs text-gray-400">Synced {{ $sync->last_synced_at->diffForHumans() }}</div>
                                @endif

                                <div class="mt-2 flex gap-2 text-xs">
                                    <button wire:click="pushContact({{ $client->id }}, '{{ $service }}')" class="text-blue-700 hover:underline">Push contact</button>
                                    <button wire:click="pullFinancials({{ $client->id }}, '{{ $service }}')" class="text-blue-700 hover:underline">Pull invoices</button>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($services) + 1 }}" class="px-4 py-8 text-center text-gray-500">
                            {{ $search ? 'No clients match your search.' : 'No clients yet.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $clients->links() }}
</div>
