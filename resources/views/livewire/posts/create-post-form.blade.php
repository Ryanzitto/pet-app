<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\File;

new class extends Component {

    use WithFileUploads;

    public $tags = [
     ['tag_name' => 'cat', 'cor' => '#eab308'],
     ['tag_name' => 'dog', 'cor' => '#3b82f6'],
     ['tag_name' => 'health', 'cor' => '#22c55e'],
     ['tag_name' => 'pets', 'cor' => '#f97316'],
     ['tag_name' => 'news', 'cor' => '#ef4444'],
     ['tag_name' => 'question', 'cor' => '#a855f7'],
    ];
    public $selected_tags = [''];

    public $post_content = "";
    public $post_status = "published";
    public $post_featured_image;

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

    public function save(){
      $validated = $this->validate([
        'post_content' => ['required', 'string', 'max:255'],
        'post_featured_image' => ['nullable', File::image()]
      ]);

      if($this->post_featured_image !== null) {
        $extension = $this->post_featured_image->getClientOriginalExtension();
        
        $filename = $this->hashGenerator(10) . '.' . $extension;
  
        $this->post_featured_image->storeAs(path: 'public/photos', name: $filename );

        auth()->user()->posts()->create([
          'content' => $validated['post_content'],
          'featured_image' => $filename,
          'tags' => !empty($this->selected_tags) ? json_encode($this->selected_tags) : null,
        ]);
        } else {
          auth()->user()->posts()->create([
              'content' => $validated['post_content'],
            'featured_image' => null,
            'tags' => !empty($this->selected_tags) ? json_encode($this->selected_tags) : null,
          ]);
        }

        $this->dispatch('refresh-posts');
        $this->reset();
        $this->dispatch('push-notification', message: [
            'title'     => 'Post created!',
            'subtitle'  => "The post has successfully created",
         ]);
    }

    public function handleClickTag($tag): void
    {  
      if (in_array($tag, $this->selected_tags)){
        $index = array_search($tag, $this->selected_tags);
        unset($this->selected_tags[$index]);
      } else {
        array_push($this->selected_tags, $tag);
      }
    }
};

?>

<div class="p-6 bg-gray-200">
  <form wire:submit="save()" class="w-full">
    <textarea wire:model="post_content" placeholder="Say somenthing about you or your pet"
      class="pt-8 px-6 w-full rounded-md outline-none border border-zinc-200"></textarea>
    <x-input-error :messages="$errors->get('post_content')" class="mt-2" />
    <input wire:model="post_featured_image" class="hidden" id="fileInput" type="file" class="" />
    <div class="w-full mt-4 flex flex-col">
      <div class="flex justify-between h-fit items-center">
        <div
          class="max-h-10 cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
          onclick="document.getElementById('fileInput').click()">
          <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
              d="M0 96C0 60.7 28.7 32 64 32l384 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6l96 0 32 0 208 0c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
          </svg>
          <span class="ml-4">
            Upload a file
          </span>
        </div>
        <div class="flex gap-1">
          @foreach($tags as $tag)
          <div wire:click="handleClickTag('{{ $tag['tag_name'] }}')" style="background-color: {{$tag['cor']}}"
            class="{{ in_array($tag['tag_name'], $this->selected_tags) ? 'border-zinc-600' : ''}} border-[2.5px] cursor-pointer px-5 pb-1 rounded-full">
            <small class="text-[12px] text-white">{{ $tag['tag_name'] }}</small>
          </div>
          @endforeach
        </div>
        @if ($post_featured_image)
        <!-- <div class="flex flex-col gap-2">
          <img class="rounded-sm max-w-16" src="{{ $post_featured_image->temporaryUrl() }}">
          </div> -->
        @endif
      </div>
      <x-input-error :messages="$errors->get('post_featured_image')" />
      <div class="flex gap-2 mt-6">
        <x-primary-button class="h-10" type="submit">Post!</x-primary-button>
        <x-secondary-button class="h-10">Cancel</x-secondary-button>
      </div>
    </div>

</div>
</form>
</div>