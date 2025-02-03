<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public $user;

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

}; ?>

<nav x-data="{ open: false }" class="min-w-[20%]">
  <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex flex-col items-center">
    <div class="w-full h-fit flex justify-center">
      <img class="w-20 -mr-6 rounded-full" src="/images/logo.png" />
      <img class="w-20 rounded-full" src="{{asset('storage/photos/' . auth()->user()->profile_image)}}" />
    </div>

    <div class="flex flex-col items-center mt-2">
      <span class="font-bold">Fred Krugger</span>
      <small class="text-zinc-400 font-medium">@fred_krug</small>
    </div>

    <div class="w-full flex flex-col gap-4 py-8 items-center">
      <div class="w-[50px] flex items-center justify-start">
        <x-nav-link class="-mt-1 text-xl text-zinc-500 hover:text-zinc-400 transition-all" :href="route('feed')"
          :active="request()->routeIs('feed')" wire:navigate>
          {{ __('Feed') }}
        </x-nav-link>
      </div>
      <div class="w-[50px] flex items-center justify-start">
        <x-nav-link class="-mt-1 text-xl text-zinc-500 hover:text-zinc-400 transition-all" :href="route('pets')"
          :active="request()->routeIs('pets')" wire:navigate>
          {{ __('Pets') }}
        </x-nav-link>
      </div>
    </div>


    <!-- Settings Dropdown -->
    <div class="w-full flex justify-center mt-4">
      <x-dropdown align="center" width="48">
        <x-slot name="trigger">
          <button
            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
              x-on:profile-updated.window="name = $event.detail.name"></div>
            <div class="ms-1">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </button>
        </x-slot>

        <x-slot name="content">
          <x-dropdown-link :href="route('profile')" wire:navigate>
            {{ __('Profile') }}
          </x-dropdown-link>

          <!-- Authentication -->
          <button wire:click="logout" class="w-full text-start">
            <x-dropdown-link>
              {{ __('Log Out') }}
            </x-dropdown-link>
          </button>
        </x-slot>
      </x-dropdown>
    </div>
  </div>








  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link :href="route('feed')" :active="request()->routeIs('feed')" wire:navigate>
        {{ __('feeds') }}
      </x-responsive-nav-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200">
      <div class="px-4">
        <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
          x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
        <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
      </div>

      <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile')" wire:navigate>
          {{ __('Profile') }}
        </x-responsive-nav-link>

        <!-- Authentication -->
        <button wire:click="logout" class="w-full text-start">
          <x-responsive-nav-link>
            {{ __('Log Out') }}
          </x-responsive-nav-link>
        </button>
      </div>
    </div>
  </div>
</nav>