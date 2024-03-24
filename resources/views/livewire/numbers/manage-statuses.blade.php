<div>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            Manage Statuses of task in {{ $number->phone_number }}
        </div>
        {{-- souse of whatsapp emojis --}}

        <a href="https://emojipedia.org/whatsapp/" target="_blank" class="text-blue-500">Whatsapp Emojis</a>

        <div class="mt-4 text-sm text-gray-600">
            <div class="grid grid-cols-2 gap-6">
                @forelse ($statuses as $status)
                    <div class="col-span-1">
                        <x-label for="name" value="Name" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model.live="statuses.{{ $loop->index }}.name" autocomplete="false" />
                        <x-input-error for="statuses.{{ $loop->index }}.name" class="mt-2" />
                    </div>

                    <div class="col-span-1">
                        <x-label for="emoji" value="Emoji" />
                        <x-input id="emoji" type="text" class="mt-1 block w-full" wire:model="statuses.{{ $loop->index }}.emoji" />
                        <x-input-error for="statuses.{{ $loop->index }}.emoji" class="mt-2" />
                    </div>

                    <hr class="col-span-1 sm:col-span-2 border-t border-gray-200"/>
                @empty
                    <div class="col-span-1 sm:col-span-2">
                        <p class="text-gray-600">
                            No statuses found.
                            Create a new one.
                        </p>
                    </div>
                @endforelse
                <div class="col-span-1 sm:col-span-2">
                    <x-secondary-button wire:click="addStatus" wire:loading.attr="disabled">
                        Add Status
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end">
        <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>
        <x-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
            Save
        </x-button>
        <x-action-message class="ml-2 py-2 me-3" on="saved">
            Saved
        </x-action-message>
    </div>
</div>


