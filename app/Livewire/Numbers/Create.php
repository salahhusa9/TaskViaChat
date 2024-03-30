<?php

namespace App\Livewire\Numbers;

use App\Enums\NumberStatus;
use App\Enums\WhatsappSessionStatus;
use App\Jobs\WhatsappApi\StartSessionJob;
use App\Models\Number;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionServer;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public $phone_number;

    protected $rules = [
        // 'phone_number' => 'required|numeric|digits_between:10,12|unique:whatsapp_sessions,phone_number',
        'phone_number' => 'required|numeric|digits_between:10,12',
    ];

    public function store()
    {
        $this->validate();

        $whatsappSessionServer = WhatsappSessionServer::first();

        $whatsappSession = $whatsappSessionServer
            ->whatsappSessions()
            ->create([
                'phone_number' => $this->phone_number,
                'user_id' => auth()->id(),
                'status' => WhatsappSessionStatus::PENDING,
            ]);

        StartSessionJob::dispatch($whatsappSession->id);

        // create default statuses
        $whatsappSession->taskStatuses()->create([
            'name' => 'To do',
            'emoji' => '📝',
        ]);

        $whatsappSession->taskStatuses()->create([
            'name' => 'In progress',
            'emoji' => '🚧',
        ]);

        $whatsappSession->taskStatuses()->create([
            'name' => 'Done',
            'emoji' => '✅',
        ]);

        $this->dispatch('refreshTable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.numbers.create');
    }
}
