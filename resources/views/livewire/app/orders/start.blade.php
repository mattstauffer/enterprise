<div>
    <div class="space-y-4">
        <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
            @foreach ($ticketTypes as $index => $ticket)
            <li class="flex justify-between py-6 sm:py-10">
                @if ($ticket->structure === 'flat')
                <div class="{{ $ticket->end->isPast() ? 'opacity-50' : '' }}">
                    <p class="text-2xl dark:text-gray-200">$<span class="pl-1">{{ $form[$index]['cost'] }}</span></p>
                    <h2 class="dark:text-gray-200">{{ $ticket->name }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->description }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->availablity }}</p>
                </div>
                @elseif ($ticket->structure === 'scaled-range')
                <div class="{{ $ticket->end->isPast() ? 'opacity-50' : '' }}">
                    <div>
                        <x-form.label :for="'ticket-cost'.$index" label="Price of Tickets" sr-only />
                        <span class="text-2xl dark:text-gray-200">$</span>
                        <select class="w-20 p-0 pl-1 text-2xl bg-transparent border-none rounded dark:text-gray-200 focus:ring-green-500 focus:border-green-500 {{ $order !== null ? 'opacity-75 cursor-not-allowed' : '' }}" {{ $order !== null ? 'disabled' : '' }} wire:model.lazy="form.{{ $index }}.price_id">
                            @foreach ($form[$index]['options'] as $priceId => $option)
                                <option value="{{ $priceId }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <h2 class="dark:text-gray-200">
                        <span>{{ $ticket->name }}</span>
                        <span> - {{ $form[$index]['name'] }}</span>
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->description }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->availablity }}</p>
                </div>
                @endif
                <div>
                    <x-form.label value="Quantity" />
                    <x-form.input min="0" type="number" :disabled="$ticket->end->isPast()" wire:model.lazy="form.{{ $index }}.amount" />
                    @if ($ticket->end->isPast())
                    <x-form.error error="No longer available" />
                    @endif
                </div>
            </li>
            @endforeach
        </ul>

        @if ($errors->any())
            <div class="px-4 py-2 text-gray-200 bg-red-500 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="px-4 py-6 mt-16 rounded-lg lg:w-2/3 lg:ml-auto bg-gray-50 dark:bg-gray-850 sm:p-6 lg:p-8 lg:mt-0">
            <dl class="space-y-4">
                <div class="flex items-center justify-between">
                    <dt class="text-lg font-medium text-gray-900 dark:text-gray-200">Order total</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $checkoutAmount }}</dd>
                    <div wire:loading.delay class="ml-4">
                        <x-heroicon-o-cog class="w-8 h-8 text-gray-400 animate-spin" />
                    </div>
                </div>
            </dl>

            <div class="mt-6 space-y-1">
                <x-bit.button.round.primary wire:click="update" block type="submit">Next</x-bit.button.round.primary>
                <p class="text-gray-700 dark:text-gray-400">Clicking next modifies your existing reservation. Your order is not complete until payment is received.</p>
                <p class="text-gray-700 dark:text-gray-400">By clicking next you agree to the policies listed <span class="hidden lg:inline">to the left</span><span class="lg:hidden">above</span>.</p>
            </div>
        </div>
    </div>
</div>
