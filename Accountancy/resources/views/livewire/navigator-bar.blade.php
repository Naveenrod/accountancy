<nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
        <span class="text-lg font-semibold">{{ config('app.name') }}</span>

        @auth
            <button wire:click="toggleMenu" class="rounded p-2 text-gray-600 hover:bg-gray-100 sm:hidden" aria-label="Toggle menu">
                &#9776;
            </button>

            <div @class(['gap-2 sm:flex', 'flex' => $isOpen, 'hidden' => ! $isOpen])>
                @foreach (['home' => 'Home', 'clientlist' => 'Clients'] as $page => $label)
                    <button
                        wire:click="setPage('{{ $page }}')"
                        @class([
                            'rounded px-3 py-2 text-sm font-medium',
                            'bg-gray-900 text-white' => $currentPage === $page,
                            'text-gray-700 hover:bg-gray-100' => $currentPage !== $page,
                        ])
                    >{{ $label }}</button>
                @endforeach

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Log out</button>
                </form>
            </div>
        @endauth
    </div>
</nav>
