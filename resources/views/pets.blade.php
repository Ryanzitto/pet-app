<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pets') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <livewire:pets.create-pet-form />
            </div>

            <div class="p-6 mt-6 text-gray-900 bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
                   <livewire:pets.petslisting/>
            </div>
        </div>
    </div>
</x-app-layout>