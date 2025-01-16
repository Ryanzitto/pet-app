<?php

use Livewire\Volt\Component;
use App\Models\Pet;

new class extends Component {
    public $pets;

    public $shouldShowEditForm = false;

    public $currentSelectedPetId = "";

    public string $pet_name = '';
    public string $pet_specie = '';
    public string $pet_breed = '';
    public string $pet_age = '';

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
    

    public function mount() :void
    {
        $this->getPets();
    }

    public function getPets():void
    {
        $userId = auth()->id();
        $searchPets = Pet::where('user_id', $userId)->latest()->get();
  
       if(!$searchPets) return;
   
       $this->pets = $searchPets;
    }

    public function handleClickEdit($petId): void
    {
        $this->shouldShowEditForm = true;
        $this->currentSelectedPetId = $petId;
    
        $pet = Pet::find($petId);
        if ($pet) {
            $this->pet_name = $pet->nome;
            $this->pet_specie = $pet->especie;
            $this->pet_breed = $pet->raca;
            $this->pet_age = $pet->idade;
        }
    }

    public function handleClickCancel():void
    {
        $this->shouldShowEditForm = false;
        $this->currentSelectedPetId = "";
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
            $this->url = "/images/dog.png";
            }
        }

    public function store(): void
    {
        $validated = $this->validate([
            'pet_name' => ['required', 'string', 'max:255'],
            'pet_specie' => ['required', 'string', 'max:255'],
            'pet_breed' => ['required', 'string', 'max:255'],
            'pet_age' => ['required', 'string', 'max:255'],
        ]);    
    
        Pet::where ('id', $this->currentSelectedPetId)
        ->update([
            'nome' =>$validated['pet_name'],
            'especie' =>$validated['pet_specie'],
            'raca' =>$validated['pet_breed'],
            'idade' =>$validated['pet_age'],
        ]);

        $this->getPets();
        $this->dispatch('push-notification', message: [
            'title'     => 'Atualização concluída',
            'subtitle'  => 'Informações sobre o pet foram atualizadas.'
        ]);
        $this->handleClickCancel();
    }

    public function delete ($id):void {
        if(!$id) return;
        $deletedPet = Pet::find($id)->delete();
        $this->getPets();
        $this->dispatch('push-notification', message: [
            'title'     => 'Atualização concluída',
            'subtitle'  => 'Informações sobre o pet foram apagas'
        ]);
    }
}; ?>

<section class="w-full">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Pet Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your pets information and more.") }}
        </p>
    </header>

    <div class="mt-6 space-6 gap-2 w-full grid grid-cols-2">
        @foreach($pets as $pet)
            @if($pet->id != $currentSelectedPetId)
                <div class="bg-gray-100 border border-1 border-gray-300 rounded-md flex flex-col justify-center p-4">
                    <div class="flex justify-center">
                        <div class="w-1/6 bg-gray-300 rounded-md border border-zinc-400">
                            <img class="w-20" src="{{$pet->especie === 'Cat' ? '/images/logo.png' : '/images/dog.png' }}"/>
                        </div>
                        <div class="w-4/6 flex flex-col px-6">
                            <div class="w-full">
                                <span class="font-bold">Name:</span>
                                <span>{{$pet->nome}}</span>
                            </div>
                            <div class="w-full">
                                <span class="font-bold">Specie:</span>
                                <span>{{$pet->especie}}</span>
                            </div>
                            <div class="w-full">
                                <span class="font-bold">Breed:</span>
                                <span>{{$pet->raca}}</span>
                            </div>
                            <div class="w-full">
                                <span class="font-bold">Age:</span>
                                <span>{{$pet->idade}}</span>
                            </div>
                        </div>
                        <div class="w-1/6 flex justify-end items-start gap-2">
                            <a class="" href="#" data-toggle="tooltip" rel="tooltip" data-placement="top" title="Delete">
                                <svg wire:click="delete({{$pet->id}})"
                                wire:confirm="Are you sure you want to delete this pet? that's a irreversible action"
                                class="w-4 fill-zinc-600 hover:fill-zinc-300 transition-all cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1 0 32c0 8.8 7.2 16 16 16l32 0zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/>
                                </svg> 
                            </a>
                            <a class="" href="#" data-toggle="tooltip" rel="tooltip" data-placement="top" title="Edit">
                                <svg wire:click="handleClickEdit({{$pet->id}})" class="w-5 fill-zinc-600 hover:fill-zinc-300 transition-all cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1 0 32c0 8.8 7.2 16 16 16l32 0zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/>
                                </svg> 
                            </a>
                        </div>
                    </div>
                    <div class="flex mt-2">
                        <x-primary-button class="bg-red-500 hover:bg-red-600 text-[10px]">report missing</x-primary-button>
                    </div>
                </div>
            @elseif($shouldShowEditForm && $pet->id == $currentSelectedPetId)
                <div class="rounded-md flex flex-col justify-center p-4 bg-gray-100 border border-1 border-gray-300 rounded-md">
                    <form wire:submit="store">
                        <div x-data="{ petId: {{ $pet->id }} }" wire:key="pet-{{ $pet->id }}"
                        class="flex flex-wrap w-full mb-3 p-4 sm:p-">
                        <div class="flex items-center gap-4 w-full pb-4">
                            <div class="w-6/12 mb-3 pe-1 dark:text-gray-300 flex flex-col">
                                <small class="text-lg">Você está editando: <b>{{$pet->nome}}</b></small>
                            </div>
                        </div>

                        <div class="w-6/12 mb-3 pe-1 dark:text-gray-300 flex flex-col">
                            <x-input-label for="name" value="Pet name" class="dark:text-gray-300"/>
                            <x-text-input wire:model="pet_name" id="name" name="name" type="text" required autofocus/>
                            <x-input-error class="mt-2" :messages="$errors->get('pet_name')" />
                        </div>

                        <div class="w-6/12 mb-3 pe-1 dark:text-gray-300 flex flex-col">
                            <x-input-label for="pet_specie" value="Pet specie" class="dark:text-gray-300"/>
                            <x-select-input wire:model="pet_specie" wire:change="toggleBreed($event.target.value)" :options="['1' => 'Cat', '2' => 'Dog']" :disabled="false" class="w-full mt-2"></x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('pet_specie')" />
                        </div>

                        <div class="w-6/12 mb-3 pe-1 dark:text-gray-300 flex flex-col">
                            <x-input-label for="url" value="Pet breed" class="dark:text-gray-300"/>
                            <x-select-input wire:model="pet_breed" :options="$this->breed" class="w-full mt-2"/>
                            <x-input-error class="mt-2" :messages="$errors->get('pet_breed')" />
                        </div>

                        <div class="w-6/12 mb-3 pe-1 dark:text-gray-300 flex flex-col">
                            <x-input-label for="pet_age" value="Pet age" class="dark:text-gray-300"/>
                            <x-text-input wire:model="pet_age" id="pet_age" name="pet_age"
                            type="text"/>
                            <x-input-error class="mt-2" :messages="$errors->get('pet_age')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <div>
                                <x-primary-button type="submit">Salvar Alterações</x-primary-button>
                            </div>
                            
                            <div>
                                <x-secondary-button wire:click="handleClickCancel">Cancelar</x-secondary-button>
                            </div>
                        </div>
                        </div> 
                    </form>  
                </div>
            @endif  
        @endforeach
    </div>
</section>
