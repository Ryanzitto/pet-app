<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\Pet;

new class extends Component {
    
    public $pet_name = "";
    public $pet_specie = "";
    public $pet_breed = "";
    public $pet_age = "";

    public $breed = [
        ""
    ];
    public $dog_breeds =[
        'Vira-lata', 
        'Golden Retriever',
        'Labrador Retriever',
        'Bulldog Francês',
        'Poodle',
        'Beagle',
        'Pinscher',
        'Shih Tzu',
        'Chihuahua',
        'Dachshund',
        'Cocker Spaniel',
        'Pug',
        'Pastor Alemão',
        'Rottweiler',
        'Doberman',
        'Boxer',
        'Schnauzer',
        'Basset Hound', 
        'Maltês',
        'Outro',
    ];
    public $cat_breeds = [
        'Vira-lata', 
        'Persa',
        'Siamês',
        'Maine Coon',
        'Ragdoll',
        'Bengal',
        'Sphynx',
        'Scottish Fold',
        'Abissínio',
        'Burmês',
        'Abyssinian',
        'Birman',
        'Exótico',
        'Manx',
        'Russian Blue',
        'Oriental',
        'Turkish Van',
        'Savannah',
        'American Shorthair',
        'Outro',
    ];

    public function toggleBreed($value){
    if($value === "1"){
        $this->breed = $this->cat_breeds;
        }
    if($value === "2") {
        $this->breed = $this->dog_breeds;
        }
    }

    public function save(){
        $validated = $this->validate([
            'pet_name' => ['required', 'string', 'max:255'],
            'pet_specie' => ['required', 'string', 'max:255'],
            'pet_breed' => ['required', 'string', 'max:255'],
            'pet_age' => ['required', 'integer', 'min:0'],
        ]);
    
        auth()->user()->pets()->create([
            'nome' => $validated['pet_name'], // Mapeia 'pet_name' para 'nome'
            'especie' => $validated['pet_specie'], // Mapeia 'pet_specie' para 'especie'
            'raca' => $validated['pet_breed'], // Mapeia 'pet_breed' para 'raca'
            'idade' => $validated['pet_age'], // Mapeia 'pet_age' para 'idade'
        ]);
    }
}; ?>

<div class="p-6">
    <div class=" w-full flex justify-between">
        <span>Creating pet</span>
        <span>Close</span>
    </div>
    <form wire:submit="save" class="w-full flex flex-wrap mt-8">
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet name" placeholder="toggleBreed"/>
            <x-text-input name="pet_name" wire:model="pet_name" class="w-full mt-2" placeholder="Example: Tony"/> 
            <x-input-error :messages="$errors->get('pet_name')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet specie"/>
            <x-select-input name="pet_specie" wire:model="pet_specie" wire:change="toggleBreed($event.target.value)" :options="['Cat', 'Dog']" :disabled="false" class="w-full mt-2"></x-select-input>
            <x-input-error :messages="$errors->get('pet_specie')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet breed"/>
            <x-select-input name="pet_breed" wire:model="pet_breed" :options="$this->breed" class="w-full mt-2"/>
            <x-input-error :messages="$errors->get('pet_breed')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet age"/>
            <x-text-input name="pet_age" wire:model="pet_age" type="number" class="w-full mt-2" placeholder="Example: 4"/> 
            <x-input-error :messages="$errors->get('pet_age')" class="mt-2" />
        </div>
        <div class="w-full flex px-4 mt-4 gap-4">
            <x-primary-button type="submit">Confirm</x-primary-button>
            <x-secondary-button>Cancel</x-secondary-button>
        </div>
    </form>
</div>
