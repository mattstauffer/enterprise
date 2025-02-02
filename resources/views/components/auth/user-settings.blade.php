<div class="hidden sm:flex sm:items-center sm:ml-6">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300">
                <div>{{ auth()->user()->name ?? auth()->user()->email }}</div>

                <div class="ml-1">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            @can ('galaxy.view')
            <x-dropdown-link :href="route('app.dashboard')">Frontend</x-dropdown-link>
            <x-dropdown-link :href="route('galaxy.dashboard')">Galaxy</x-dropdown-link>
            @endcan
            @impersonating
            <x-dropdown-link :href="route('impersonation.leave')">Leave Impersonation</x-dropdown-link>
            @endImpersonating
            <x-dropdown-link :href="route('app.dashboard', 'settings')">Settings</x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    {{ __('Logout') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>
