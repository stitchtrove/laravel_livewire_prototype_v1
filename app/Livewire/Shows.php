<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Show;

class Shows extends Component
{
    public $show;

    public function mount($id)
    {
        $this->show = Show::with('performances')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.shows');
    }
}
