<?php

namespace App\Livewire\Numbers;

use App\Enums\NumberStatus;
use App\Jobs\WhatsappApi\StartSessionJob;
use App\Models\Number;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public $phone_number;

    protected $rules = [
        'phone_number' => 'required|numeric|digits_between:10,12|unique:numbers,phone_number',
    ];

    public function store()
    {
        $this->validate();

        $number = Number::create([
            'phone_number' => $this->phone_number,
            'user_id' => auth()->id(),
            'status' => NumberStatus::PENDING,
        ]);

        StartSessionJob::dispatch($number->id);

        // create default statuses
        $number->statuses()->create([
            'name' => 'To do',
            'emoji' => '📝',
        ]);

        $number->statuses()->create([
            'name' => 'In progress',
            'emoji' => '🚧',
        ]);

        $number->statuses()->create([
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
