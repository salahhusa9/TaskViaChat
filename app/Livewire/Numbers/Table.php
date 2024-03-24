<?php

namespace App\Livewire\Numbers;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Number;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[On('refreshTable')]
class Table extends DataTableComponent
{
    protected $model = Number::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Phone number", "phone_number")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable()
                ->format(fn ($value, $column, $row) => view('livewire.numbers.status', ['status' => $value])),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make("Actions", 'id')
                ->format(fn ($value, $column, $row) => view('livewire.numbers.actions', ['column' => $column])),
        ];
    }
}
