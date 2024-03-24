<div>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            Create Number
        </div>

        <div class="mt-4 text-sm text-gray-600">
            <div class="grid grid-cols-1 gap-6">
                <div class="col-span-1 sm:col-span-2">
                    <x-label for="phone_number" value="Number: (ex:212612345678)" />
                    <x-input id="phone_number" type="number" class="mt-1 block w-full" wire:model="phone_number" palceholder="ex: 212612345678"/>
                    <x-input-error for="phone_number" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end">
        <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>
        <x-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
            Create
        </x-button>
    </div>
</div>
