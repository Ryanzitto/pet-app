<?php

use Livewire\Volt\Component;

new class extends Component {

    public $pet_name = "";
    public $pet_specie = "Cat";
    public $pet_breed = "Vira-lata";
    public $pet_age = "";

    public $url = "/images/logo.png";

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
    public $breed = 
        [
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
    if($value === "Cat"){
        $this->breed = $this->cat_breeds;
        $this->pet_breed = $this->cat_breeds[0];
        $this->url = "/images/logo.png";
        }
    if($value === "Dog") {
        $this->breed = $this->dog_breeds;
        $this->pet_breed = $this->dog_breeds[0];
        $this->url = "/images/logo.png";;
        }
    }

    public function save(){
        $validated = $this->validate([
            'pet_name' => ['required', 'string', 'max:255'],
            'pet_specie' => ['required','string', 'max:255'],
            'pet_breed' => ['required', 'string', 'max:255'],
            'pet_age' => ['required', 'string', 'max:255'],
        ]);

        auth()->user()->pets()->create([
            'nome' => $validated['pet_name'],
            'especie' => $validated['pet_specie'],
            'raca' => $validated['pet_breed'],
            'idade' => $validated['pet_age'],
        ]);

        $this->dispatch('refresh-pets');
        $this->reset();
        $this->dispatch('push-notification', message: [
            'title'     => 'Cadastro concluído',
            'subtitle'  => " {$validated['pet_name']} foi cadastrado com sucesso!",
         ]);

    }
}; ?>

<div class="p-6">
    <div class=" w-full flex justify-between">
        <span>Creating pet</span>
        <span>Close</span>
    </div>
    <form wire:submit="save()" class="w-full flex flex-wrap mt-8">
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet name" placeholder="toggleBreed"/>
            <x-text-input wire:model="pet_name" class="w-full mt-2" placeholder="Example: Tony"/> 
            <x-input-error :messages="$errors->get('pet_name')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet specie"/>
            <x-select-input wire:model="pet_specie" wire:change="toggleBreed($event.target.value)" :options="['1' => 'Cat', '2' => 'Dog']" :disabled="false" class="w-full mt-2"></x-select-input>
            <x-input-error :messages="$errors->get('pet_specie')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet breed"/>
            <x-select-input wire:model="pet_breed" :options="$this->breed" class="w-full mt-2"/>
            <x-input-error selected :messages="$errors->get('pet_breed')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Pet age"/>
            <x-text-input wire:model="pet_age" type="number" class="w-full mt-2" placeholder="Example: 4"/> 
            <x-input-error :messages="$errors->get('pet_age')" class="mt-2" />
        </div>
        <div class="w-full flex px-4 mt-4 justify-between">
            <div class="flex mt-4 gap-4">
                <x-primary-button class="h-10" type="submit">Confirm</x-primary-button>
                <x-secondary-button class="h-10">Cancel</x-secondary-button>
            </div>
            <div>
                <img class="w-16" src="{{$this->url}}"/>
            </div>
    </form>
</div>
