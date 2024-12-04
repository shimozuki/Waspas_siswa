<?php

namespace App\Http\Livewire\Hasil;

use App\Models\Hasil;
use App\Models\Jurusan;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public Jurusan $jurusan;
    public $paginate=10;
    public $quota = [];

    public function mount($jurusan)
    {
        $this->jurusan = $jurusan;
    }

    public function render()
    {
        return view('livewire.hasil.table', [
            'data' => Hasil::query()->where('jurusan_id', $this->jurusan)->orderBy('rank', 'asc')->paginate($this->paginate),
        ]);
    }
}
