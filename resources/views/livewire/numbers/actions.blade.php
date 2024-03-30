@if ($column->status == \App\Enums\WhatsappSessionStatus::SCAN_QR_CODE)
    <x-heroicon-o-qr-code
        wire:click="$dispatch('openModal', {component: 'numbers.qr-code', arguments: {number_id: {{ $column->id }}}})"
        class="h-6 w-6 shrink-0 text-gray-500 hover:text-indigo-600 cursor-pointer"
    />
@endif

@if ($column->status == \App\Enums\WhatsappSessionStatus::STARTING)
    <x-heroicon-o-arrow-path
        title="Start"
        wire:click="$dispatch('refreshTable')"
        class="h-6 w-6 shrink-0 text-gray-500 hover:text-indigo-600 cursor-pointer"
    />
@endif

@if ($column->status == \App\Enums\WhatsappSessionStatus::WORKING)
{{--  --}}
    <x-heroicon-o-adjustments-horizontal
        title="Manage Statuses"
        wire:click="$dispatch('openModal', {component: 'numbers.manage-statuses', arguments: {number_id: {{ $column->id }}}})"
        class="h-6 w-6 shrink-0 text-gray-500 hover:text-indigo-600 cursor-pointer"
    />
@endif

