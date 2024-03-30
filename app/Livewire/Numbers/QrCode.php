<?php

namespace App\Livewire\Numbers;

use App\Enums\WhatsappSessionStatus;
use App\Models\WhatsappSession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class QrCode extends ModalComponent
{
    public $whatsapp_session;

    public $qrCodeUrl = '';

    public function mount($number_id)
    {
        $this->whatsapp_session = $whatsapp_session = WhatsappSession::findOrFail($number_id);

        if ($whatsapp_session->status != WhatsappSessionStatus::SCAN_QR_CODE) {
            $this->closeModal();
            $this->dispatch('refreshTable');
        }

        $response = Http::withHeaders([
            'X-Api-Key' => $whatsapp_session->whatsappSessionServer->secret,
            'Accept' => 'image/png',
            'Content-Type' => 'image/png',
        ])->get(
            'https://' . $whatsapp_session->whatsappSessionServer->host . ':' . $whatsapp_session->whatsappSessionServer->port . '/api/screenshot',
            [
                'session' => $whatsapp_session->session_name,
            ]
        );

        $random = Str::random($length = 10);

        $store = Storage::disk('public')->put('qr-codes/' . $whatsapp_session->id . '/' . $random . '.png', $response->body());
        $this->qrCodeUrl = Storage::url('qr-codes/' . $whatsapp_session->id . '/' . $random . '.png');
    }

    public function recheck()
    {
        if ($this->whatsapp_session->status != WhatsappSessionStatus::SCAN_QR_CODE) {
            $this->closeModalWithEvents([
                'refreshTable'
            ]);
        }
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
