<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {

    public $displayToast = false;
    public $notifications = [];

    #[On('push-notification')]
    public function showToast($message): void
    {
        array_push($this->notifications, [
            'title'     => isset($message['title']) ? $message['title'] : 'Erro',
            'subtitle'  => isset($message['subtitle']) ? $message['subtitle'] : 'Algo deu errado.',
            'icon'  => isset($message['icon']) ? $message['icon'] : 'fas-check',
        ]);

        $this->displayToast = true;
    }

    public function hideToast($index): void
    {
        unset($this->notifications[$index]);
        $this->notifications = array_values($this->notifications); // Reindexa o array
        $this->displayToast = count($this->notifications) > 0; // Atualiza o estado do toast
    }
};
?>

<div class="fixed z-50 bottom-3 left-3 flex flex-col gap-2">
    @if ($displayToast)
    @foreach ($notifications as $notification)
    <div id="toast-notification-{{ $loop->index }}"
        class="animate-entrance w-full max-w-full p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
        role="alert">
        <div class="flex">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-800 rounded-lg">
                <x-dynamic-component :component="$notification['icon']" class="w-3.5 h-3.5 text-green-500" />
            </div>
            <div class="ms-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $notification['title'] }}</span>
                <div class="mb-2 text-sm font-normal">{{ $notification['subtitle'] }}</div>
            </div>
            <button wire:click="hideToast({{ $loop->index }})" type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white items-center justify-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-notification-{{ $loop->index }}" aria-label="Fechar">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    </div>
    @endforeach
    @endif
</div>