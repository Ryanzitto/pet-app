<?php

use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection; 
use Livewire\Attributes\On; 
use App\Models\Pet;

new class extends Component {

  public Collection $pets;

  public function mount() :void {
   $this->getPets();
  }

  #[On('refresh-pets')]
  public function getPets():void
  {
     //provavelmente lista somente os pertencentes do mais antigo pro mais recente
     $searchPets = Pet::with('user')->latest()->get();

     if(!$searchPets) return;
 
     $this->pets = $searchPets;
  }
}; ?>

<div class="gap-6 flex flex-wrap justify-center">
@foreach($pets as $pet)
    <div class="bg-gray-100 border border-1 border-gray-300 rounded-sm w-[45%] flex flex-wrap p-4">
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
