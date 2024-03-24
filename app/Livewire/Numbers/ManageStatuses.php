<?php

namespace App\Livewire\Numbers;

use App\Models\Number;
use Illuminate\Support\Collection;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ManageStatuses extends ModalComponent
{
    public $number;
    public Collection $statuses;

    protected $rules = [
        'statuses.*.name' => 'required|string',
        'statuses.*.emoji' => 'required|string',
    ];

    public function mount($number_id)
    {
        $this->number = Number::findOrFail($number_id);

        if ($this->number->user_id !== auth()->id()) {
            return abort(403);
        }

        $this->loadStatuses();
    }

    public function loadStatuses()
    {
        $this->statuses = collect($this->number->statuses()->get()->toArray());
    }

    public function addStatus()
    {
        $this->number->statuses()->create([
            'name' => 'New Status',
            'emoji' => '🤷‍♂️',
        ]);

        $this->save();

        $this->loadStatuses();
    }

    public function removeStatus($status_id)
    {
        $this->number->statuses()->findOrFail($status_id)->delete();
        $this->loadStatuses();
    }

    public function save()
    {
        foreach ($this->statuses as $status) {
            $this->number->statuses()->findOrFail($status['id'])->update([
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
