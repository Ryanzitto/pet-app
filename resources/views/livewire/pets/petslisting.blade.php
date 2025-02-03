<?php

use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection; 
use Livewire\Attributes\On; 
use App\Models\Pet;


use Illuminate\Support\Facades\Storage;

new class extends Component {

  public Collection $pets;

  public function mount() :void {
   $this->getPets();
  }


  #[On('refresh-pets')]
  public function getPets():void
  {
     $searchPets = Pet::with('user')->latest()->get();

     if(!$searchPets) return;
 
     $this->pets = $searchPets;
  }

}; ?>



<div class="gap-6 flex flex-wrap justify-center">
@foreach($pets as $pet)
    <div class="bg-gray-100 border border-1 border-gray-300 rounded-sm w-[280px] p-4 flex flex-col items-center">
        <div class="w-full flex">
            <img class="rounded-sm" src="{{ asset('storage/photos/' . $pet->pet_image) }}" class="w-16 h-16"/>
        </div>
        <div class="h-[0.5px] w-[90%] bg-gray-300"></div>
        <div class="w-full flex flex-col p-2 mt-4">
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Pet name:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->name}}</span>
            </div>
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Specie:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->specie}}</span>
            </div>
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Breed:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->breed}}</span>
            </div>
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Gender:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->gender}}</span>
            </div>
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Age:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->age}}</span>
            </div>
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Neutered:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->is_neutered ? 'neutered' : 'not neutered'}}</span>
            </div>
            @if($pet->is_missing === true)
            <div class="w-full gap-2">
                <span class="text-[14px] text-zinc-700 font-bold">Pet name:</span>
                <span class="text-[14px] text-zinc-600">{{$pet->is_missing ? 'missing' : 'not missing'}}</span>
            </div>
            @endif
        </div>
    </div>
@endforeach
</div>
