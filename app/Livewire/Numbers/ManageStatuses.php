<?php

namespace App\Livewire\Numbers;

use App\Models\WhatsappSession;
use Illuminate\Support\Collection;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ManageStatuses extends ModalComponent
{
    public $whatsapp_session;
    public Collection $statuses;

    protected $rules = [
        'statuses.*.name' => 'required|string',
        'statuses.*.emoji' => 'required|string',
    ];

    public function mount($whatsapp_session_id)
    {
        $this->whatsapp_session = WhatsappSession::findOrFail($whatsapp_session_id);

        if ($this->whatsapp_session->user_id != auth()->id()) {
            return abort(403);
        }

        $this->loadStatuses();
    }

    public function loadStatuses()
    {
        $this->statuses = collect($this->whatsapp_session->taskStatuses()->get()->toArray());
    }

    public function addStatus()
    {
        $this->whatsapp_session->taskStatuses()->create([
            'name' => 'New Status',
            'emoji' => '🤷‍♂️',
        ]);

        $this->save();

        $this->loadStatuses();
    }

    public function removeStatus($status_id)
    {
        $this->whatsapp_session->taskStatuses()->findOrFail($status_id)->delete();
        $this->loadStatuses();
    }

    public function save()
    {
        foreach ($this->statuses as $status) {
            $this->whatsapp_session->taskStatuses()->findOrFail($status['id'])->update([
                'name' => $status['name'],
                'emoji' => $status['emoji'],
            ]);
        }

        $this->loadStatuses();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.numbers.manage-statuses');
    }
}
