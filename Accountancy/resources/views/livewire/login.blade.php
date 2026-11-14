<div class="mx-auto max-w-sm space-y-6 pt-8">
    <h1 class="text-center text-2xl font-semibold">Log in</h1>

    <form wire:submit="login" class="space-y-4 rounded border border-gray-200 bg-white p-6">
        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input id="email" type="email" wire:model="email" autocomplete="username" autofocus class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none">
            @error('email') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <input id="password" type="password" wire:model="password" autocomplete="current-password" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none">
            @error('password') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" wire:model="remember" class="rounded border-gray-300">
            Remember me
        </label>

        <button type="submit" class="w-full rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Log in</button>
    </form>
</div>
