<?php

namespace App\Livewire;
use App\Services\AVDataService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Show;
use App\Enums\FlareStrand;
use DB;

class Performances extends Component
{
    use WithPagination;
    public $name;

    public bool $filterPricing;
    public string $titleSearch;
    public $venues;
    public $strands;
    public string $chosenVenue;
    public string $chosenOrder;
    public string $chosenStrand;

    public function mount(){
        $this->filterPricing = false;
        $this->titleSearch = '';
        $this->chosenVenue = '';
        $this->chosenStrand = '';
        $this->chosenOrder = 'az';
        $this->venues = DB::table('performances')->groupBy('screen')->orderBy('screen','asc')->pluck('screen');
        $this->strands = FlareStrand::cases();
    }

    public function render()
    {
        $query = Show::with('performances');

        if ($this->filterPricing) {
            $query->whereHas('performances', function ($query) {
                $query->where('pricing', 'Free'); 
            });
        }

        if ($this->chosenOrder === 'az') {
            $query->orderBy('title', 'asc'); 
        }

        if ($this->chosenOrder === 'za') {
            $query->orderBy('title', 'desc'); 
        }

        if ($this->chosenOrder === 'soonest') {
            $query->whereHas('performances', function ($query) {
                $query->orderBy('start_datetime', 'asc'); 
            });
        }

        if ($this->chosenStrand) {
            $query->whereHas('performances', function ($query) {
                $query->where('strand', $this->chosenStrand); 
            });
        }

        if ($this->chosenVenue) {
            $query->whereHas('performances', function ($query) {
                $query->where('screen', $this->chosenVenue); 
            });
        }

        if ($this->titleSearch) {
            $query->where('title', 'like', '%' . $this->titleSearch . '%');
        }

        $programme = $query->get();

        return view('livewire.performances', [
            'programme' => $programme
        ]);
    }
}