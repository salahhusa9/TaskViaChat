<?php

namespace App\Livewire\Numbers;

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
        ]);

        StartSessionJob::dispatch($number->id);

        $this->dispatch('refreshTable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.numbers.create');
    }
}
