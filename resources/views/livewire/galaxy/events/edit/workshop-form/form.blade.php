<div class="bg-white rounded-md shadow dark:bg-gray-800">
    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 rounded-t-md dark:border-gray-700">
        <h2 class="text-xl text-gray-600 dark:text-gray-400">Form</h2>

        <div>
            <x-bit.button.round.secondary wire:click="addQuestion">Add Question</x-bit.button.round.secondary>
            <x-bit.button.round.secondary wire:click="addContent">Add Content Section</x-bit.button.round.secondary>
            <x-bit.button.round.secondary wire:click="addCollaborators">Add Collaborators</x-bit.button.round.secondary>
        </div>
    </div>

    <div class="p-4 space-y-2">
        @forelse ($form as $index => $question)
        @includeWhen($question['style'] === 'question', 'livewire.galaxy.forms.question')
        @includeWhen($question['style'] === 'content', 'livewire.galaxy.forms.content')
        @includeWhen($question['style'] === 'collaborators', 'livewire.galaxy.forms.collaborators')
        @empty
        <p class="text-gray-900 dark:text-gray-200">This form is empty! Get started by adding a content section or a question below.</p>
        @endforelse

        <div>
            <!-- This example requires Tailwind CSS v2.0+ -->
            <section class="fixed inset-0 z-50 overflow-hidden" x-show="open" x-data="{ open: @entangle('showSettings') }" @keydown.window.escape="open = false" x-ref="dialog" aria-labelledby="settings-panel" role="dialog" aria-modal="true">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute inset-0" x-description="Background overlay, show/hide based on slide-over state." @click="open = false" aria-hidden="true"></div>

                    <div class="absolute inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                        <div class="w-screen max-w-xl" x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" x-description="Slide-over panel, show/hide based on slide-over state.">
                            <div class="flex flex-col h-full pb-6 overflow-y-scroll bg-white shadow-xl dark:bg-gray-700">
                                <div class="p-4 bg-gray-100 dark:bg-gray-800 sm:p-6">
                                    <div class="flex items-start justify-between">
                                        <h2 class="text-lg font-medium text-gray-900 truncate dark:text-gray-200" id="settings-panel">
                                            Settings for: {{ $form[$openIndex]['question'] ?? 'Question' }}
                                        </h2>
                                        <div class="flex items-center ml-3 h-7">
                                            <button @click="open = false" class="text-gray-400 bg-white rounded-md dark:bg-gray-800 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <span class="sr-only">Close panel</span>
                                                <!-- Heroicon name: outline/x -->
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative flex-1 px-4 mt-6 sm:px-6">
                                    @if (isset($form[$openIndex]) && $form[$openIndex]['style'] === 'question')
                                    <div class="space-y-8">
                                        <div class="space-y-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Validation</h3>
                                            <x-bit.input.group :for="'question-rules-'.$openIndex" label="Rules">
                                                <x-bit.input.text type="text" class="w-full mt-1" :id="'question-rules-'.$openIndex" placeholder="required" wire:model="form.{{ $openIndex }}.rules" />
                                                <x-bit.input.help>Pipe delineated list of validation rules. <br>Required is probably all that is needed, but if more specific validation is required <a href="https://laravel.com/docs/7.x/validation#available-validation-rules" target="_blank" class="text-green-500 underline dark:text-green-400">see all options available</a>.</x-bit.input.help>
                                            </x-bit.input.group>
                                        </div>

                                        <div class="space-y-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Visibility</h3>

                                            <div class="grid grid-cols-3 gap-4">
                                                <x-bit.input.group :for="'question-visibility-'.$openIndex" label="When to show or hide this question" sr-only>
                                                    <x-bit.input.select class="w-full mt-1" :id="'question-visibility-'.$openIndex" wire:model="form.{{ $openIndex }}.visibility">
                                                        <option value="always" selected>Always show</option>
                                                        <option value="conditional">Show when</option>
                                                    </x-bit.input.select>
                                                </x-bit.input.group>

                                                @if (isset($form[$openIndex]['visibility']) && $form[$openIndex]['visibility'] === 'conditional')
                                                <x-bit.input.group class="col-span-2" :for="'question-visibility-andor-'.$openIndex" label="And/Or for conditions" sr-only>
                                                    <x-bit.input.select class="w-full mt-1" :id="'question-visibility-andor-'.$openIndex" wire:model="form.{{ $openIndex }}.visibility-andor">
                                                        <option value="" disabled>-</option>
                                                        <option value="and">All of the following conditions pass</option>
                                                        <option value="or">Any of the following conditions pass</option>
                                                    </x-bit.input.select>
                                                </x-bit.input.group>

                                                <div class="col-span-3 space-y-4">
                                                    @isset ($form[$openIndex]['conditions'])
                                                    @foreach ($form[$openIndex]['conditions'] as $index => $condition)
                                                    <div class="flex space-x-4">
                                                        <x-bit.input.group :for="'condition-field-'.$index" label="Field" sr-only>
                                                            <x-bit.input.select class="w-full mt-1" :id="'condition-field-'.$index" wire:model="form.{{ $openIndex }}.conditions.{{ $index }}.field">
                                                                <option value="" disabled>-</option>
                                                                @foreach ($fields as $field)
                                                                <option value="{{ $field }}">{{ $field }}</option>
                                                                @endforeach
                                                            </x-bit.input.select>
                                                        </x-bit.input.group>
                                                        <x-bit.input.group :for="'condition-method-'.$index" label="Method" sr-only>
                                                            <x-bit.input.select class="w-full mt-1" :id="'condition-method-'.$index" wire:model="form.{{ $openIndex }}.conditions.{{ $index }}.method">
                                                                <option value="" disabled>-</option>
                                                                <option value="equals">equals</option>
                                                                <option value="not">does not equal</option>
                                                                <option value=">">&gt;</option>
                                                                <option value=">=">&gt;=</option>
                                                                <option value="<">&lt;</option>
                                                                <option value="<=">&lt;=</option>
                                                            </x-bit.input.select>
                                                        </x-bit.input.group>
                                                        <x-bit.input.group :for="'condition-value-'.$index" label="Value" sr-only>
                                                            <x-bit.input.text type="text" class="w-full mt-1" :id="'condition-value-'.$index" wire:model="form.{{ $openIndex }}.conditions.{{ $index }}.value" />
                                                        </x-bit.input.group>
                                                        <x-bit.button.round.secondary size="xs" wire:click="removeCondition({{ $index }})">
                                                            <x-heroicon-o-trash class="w-4 h-4" />
                                                        </x-bit.button.round.secondary>
                                                    </div>
                                                    @endforeach
                                                    @endisset
                                                </div>
                                                @endif
                                            </div>


                                            @if (isset($form[$openIndex]['visibility']) && $form[$openIndex]['visibility'] === 'conditional')
                                            <x-bit.button.round.secondary wire:click="addCondition">Add Condition</x-bit.button.round.secondary>
                                            @endif
                                        </div>

                                        @if ($model->parent_id !== null)
                                        <div class="space-y-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Data</h3>
                                            <x-bit.input.checkbox :id="'question-data-'.$openIndex" :label="__('Pull Value From Parent Form')" wire:model="form.{{ $openIndex }}.data" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
