<div class="pt-4 space-y-4 border-t border-gray-100 dark:border-gray-800">
    <x-bit.input.group :for="'question-options-'.$index" label="Options">
        <x-bit.input.textarea class="w-full mt-1" :id="'question-options-'.$index" wire:model="form.{{ $index }}.options" />
        <x-bit.input.help>Put each option on a new line or separate by commas</x-bit.input.help>
    </x-bit.input.group>

    <x-bit.input.group :for="'question-scale-'.$index" label="Scale">
        <x-bit.input.textarea class="w-full mt-1" :id="'question-scale-'.$index" wire:model="form.{{ $index }}.scale" />
        <x-bit.input.help>Put each option on a new line or separate by commas</x-bit.input.help>
    </x-bit.input.group>

    <div class="flex space-x-8">
        <x-bit.input.group :for="'question-list-other-'.$index" label="Other">
            <div class="flex mt-1 space-x-4">
                <x-bit.input.checkbox wire:model="form.{{ $index }}.list-other" :id="'question-list-other-'.$index.'-checkbox'" label="Enable Other Option" />
            </div>
            <x-bit.input.help>Turn on if users are allowed to fill in their own option.</x-bit.input.help>
        </x-bit.input.group>
    </div>
</div>
