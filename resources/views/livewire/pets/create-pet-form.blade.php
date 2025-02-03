<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public $pet_name = "";
    public $pet_specie = "Cat";
    public $pet_breed = "Vira-lata";
    public $pet_age = "";
    public $pet_gender = "";
    public $is_neutered = "Yes";
    public $is_missing = false;
    public $pet_image;

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

    public function hashGenerator($tamanho) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringAleatoria = '';
        $max = strlen($caracteres) - 1;
    
        for ($i = 0; $i < $tamanho; $i++) {
            $indice = rand(0, $max);
            $stringAleatoria .= $caracteres[$indice];
        }
    
        return $stringAleatoria;
    }

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
            'pet_gender' => ['required', 'string', 'max:255'],
            'is_neutered' => ['required', 'string', 'max:255'],
            'is_missing' => ['required', 'boolean'],
            'pet_image' => ['image']
        ]);

        $extension = $this->pet_image->getClientOriginalExtension();
                   
        $filename = $this->hashGenerator(10) . '.' . $extension;

        $this->pet_image->storeAs(path: 'public/photos', name: $filename );
 
        auth()->user()->pets()->create([
            'name' => $validated['pet_name'],
            'specie' => $validated['pet_specie'],
            'breed' => $validated['pet_breed'],
            'age' => $validated['pet_age'],
            'gender' =>$validated['pet_gender'],
            'is_neutered' => $validated['is_neutered']  ? true : false,
            'is_missing' => $validated['is_missing'],
            'pet_image'  =>$filename
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
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Your pet is neutered?"/>
            <x-select-input wire:model="is_neutered" :options="['1' => 'Yes', '2' => 'No']" :disabled="false" class="w-full mt-2"></x-select-input> 
            <x-input-error :messages="$errors->get('is_neutered')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4">
            <x-input-label value="Gender"/>
            <x-select-input wire:model="pet_gender" :options="['1' => 'Male', '2' => 'Female']" :disabled="false" class="w-full mt-2"></x-select-input> 
            <x-input-error :messages="$errors->get('pet_gender')" class="mt-2" />
        </div>
        <div class="w-1/2 px-4 mt-4 flex flex-col justify-center">
            <x-input-label value="Pet image"/>
            <input wire:model="pet_image" type="file" class="w-full mt-2"/> 
            <x-input-error :messages="$errors->get('pet_image')" class="mt-2" />
            @if ($pet_image)
                Image Preview:
                <img class="w-32" src="{{ $pet_image->temporaryUrl() }}">
            @endif
        </div>
        <div class="w-1/2 px-4 mt-4">

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
