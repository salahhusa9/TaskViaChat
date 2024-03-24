<?php

namespace App\Livewire\Numbers;

use App\Models\Number;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class QrCode extends ModalComponent
{
    public $number;

    public $qrCodeUrl = '';

    public function mount(Number $number)
    {
        $this->number = $number;

        $response = Http::withHeaders([
            'X-Api-Key' => config('whatsapp_api.api_key'),
            'Accept' => 'image/png',
            'Content-Type' => 'image/png',
        ])->get(config('services.whatsapp_api.base_url') . '/screenshot', [
            'session' => config('services.whatsapp_api.test_mode') ? 'default' : 'session-' . $number->id
        ]);

        $random = Str::random($length = 10);

        $store = Storage::disk('public')->put('qr-codes/' . $number->id . '/' . $random . '.png', $response->body());
        $this->qrCodeUrl = Storage::url('qr-codes/' . $number->id . '/' . $random . '.png');
    }

    public function placeholder()
    {
        return view('components.placeholder-loading');
    }

    public function render()
    {
        return view('livewire.numbers.qr-code');
    }
}
