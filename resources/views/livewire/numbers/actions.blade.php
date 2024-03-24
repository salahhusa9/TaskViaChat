@if ($column->status == \App\Enums\NumberStatus::SCAN_QR_CODE)
    <x-heroicon-o-qr-code wire:click="scanQrCode({{ $column->id }})" class="h-6 w-6 shrink-0 text-gray-500 hover:text-indigo-600 cursor-pointer" />
@endif

@if ($column->status == \App\Enums\NumberStatus::STARTING)
    <x-heroicon-o-arrow-path
        title="Start"
        wire:click="$dispatch('refreshTable')"
        class="h-6 w-6 shrink-0 text-gray-500 hover:text-indigo-600 cursor-pointer" />
@endif



