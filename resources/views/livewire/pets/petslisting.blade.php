<?php

use Livewire\Volt\Component;
use App\Models\Pet;

new class extends Component {

  public $pets;

  public function mount(){
    $searchPets = Pet::all();

    if(!$searchPets) return;

    $this->pets = $searchPets;
  }

}; ?>

<div class="gap-6 flex flex-col">
@foreach($pets as $pet)
<div class="bg-gray-200 border border-1 border-gray-300 rounded-sm w-1/2 flex flex-wrap p-4">
    <div class="w-1/2">
        <span>Nome:</span>
        <span>{{$pet->nome}}</span>
    </div>
    <div class="w-1/2">
        <span>Especie:</span>
        <span>{{$pet->especie}}</span>
    </div>
    <div class="w-1/2">
        <span>Raça:</span>
        <span>{{$pet->raca}}</span>
    </div>
    <div class="w-1/2">
        <span>Idade:</span>
        <span>{{$pet->idade}}</span>
    </div>
</div>

@endforeach
</div>
