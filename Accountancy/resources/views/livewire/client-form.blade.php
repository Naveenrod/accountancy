<div class="max-w-lg space-y-6">
    <div>
        <a href="{{ route('clientlist') }}" class="text-sm text-gray-500 hover:underline">&larr; Back to clients</a>
        <h1 class="mt-2 text-2xl font-semibold">{{ $client ? "Edit {$client->name}" : 'Add client' }}</h1>
    </div>

    <form wire:submit="save" class="space-y-4 rounded border border-gray-200 bg-white p-6">
        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input id="name" type="text" wire:model="name" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none">
            @error('name') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input id="email" type="email" wire:model="email" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none">
            @error('email') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
            {{ $client ? 'Save changes' : 'Add client' }}
        </button>
    </form>
</div>
