<?php

use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection; 
use Livewire\Attributes\On; 
use App\Models\Post;


new class extends Component {

  public Collection $posts;

  public $tags = [
    ['tag_name' => 'cat', 'cor' => '#eab308'],
    ['tag_name' => 'dog', 'cor' => '#3b82f6'],
    ['tag_name' => 'health', 'cor' => '#22c55e'],
    ['tag_name' => 'pets', 'cor' => '#f97316'],
    ['tag_name' => 'news', 'cor' => '#ef4444'],
    ['tag_name' => 'question', 'cor' => '#a855f7'],
   ];

  public $selected_tags = [];

  public $shouldShowEditForm = false;
  public $currentPost = "";
  public $post_edited_content = "";
  
  public function mount() :void {
   $this->getPosts();
  }

  #[On('refresh-posts')]
  public function getPosts():void
  {
     $searchPosts = Post::with('user')->latest()->get();

     if(!$searchPosts) return;
 
     $this->posts = $searchPosts;
  }

  public function deletePost($id):void
  {
    if(!$id) return;

    $deletedPost = Post::where('id', $id)->delete();

    $this->dispatch('refresh-posts');

    $this->dispatch('push-notification', message: [
      'title'     => 'Post deleted!',
      'subtitle'  => "The post has successfully deleted",
    ]);
  }

  public function handleClickEdit($data): void
  {
      $id = $data['id']; 
      $content = $data['content']; 
      $tags = json_decode($data['tags'], true);
      $this->selected_tags = $tags;
      $this->currentPost = $id;
      $this->shouldShowEditForm = true;
      $this->post_edited_content = $content;
  }

  public function handleClickCancel(): void
  {
    $this->currentPost= "";
    $this->shouldShowEditForm = false;
    $this->post_edited_content = "";
  }

  public function save():void
  {
    $post = Post::find($this->currentPost);
    $post->content = $this->post_edited_content;
    $post->tags = !empty($this->selected_tags) ? json_encode($this->selected_tags) : null;
    $post->save();

    $this->handleClickCancel();

    $this->dispatch('refresh-posts');

    $this->dispatch('push-notification', message: [
      'title'     => 'Post Updated!',
      'subtitle'  => "The post has successfully updated",
    ]);
  }

  public function colorDefiner ($tag) {
    if(!$tag) return;

    switch($tag){
      case "cat":
        return "bg-yellow-500";
        break;
      case "dog":
        return "bg-blue-500";
        break;
      case "health":
        return "bg-green-500";
        break;
      case "pets":
        return "bg-orange-500";
        break;
      case "news":
        return "bg-red-500";
        break;
      case "question":
        return "bg-purple-500";
        break;
      default: return "bg-zinc-500";      
    }
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

}; ?>

<div class="mt-10 flex flex-col gap-4">
  @foreach($posts as $post)
  <!-- edit form  -->
  @if($shouldShowEditForm && $currentPost === $post->id)
  <form wire:submit="save()">
    <div class="p-8 bg-gray-200 border border-zinc-300 rounded-md flex flex-col gap-4">
      <div class="w-full flex justify-between">
        <div class="gap-4 flex w-[80%]">
          <img class="rounded-full w-12 h-12 object-cover"
            src="{{asset('storage/photos/' . $post->user->profile_image)}}" />
          <div class="flex flex-col ">
            <span class="font-bold">{{$post->user->name}}</span>
            <small class="text-xs text-zinc-400">{{$post->created_at->format('j M Y, g:i a')}}</small>
          </div>
        </div>

        <div class="justify-end flex items-center gap-2 w-[20%]">
          @if($post->tags !== null)
          @foreach(json_decode($post->tags) as $tag)
          <div class="{{ $this->colorDefiner($tag)}}  px-5 pb-1 rounded-full">
            <small class="text-[12px] text-white">{{ $tag }}</small>
          </div>
          @endforeach
          @endif
        </div>

      </div>
      <textarea wire:model="post_edited_content" placeholder="Say somenthing about you or your pet"
        class="pt-8 px-6 w-full rounded-md outline-none border border-zinc-200"></textarea>
      <div class="w-full gap-1 flex justify-end">

        @foreach($tags as $tag)
        <div wire:click="handleClickTag('{{ $tag['tag_name'] }}')" style="background-color: {{$tag['cor']}}"
          class="{{ in_array($tag['tag_name'], $this->selected_tags) ? 'border-zinc-600' : ''}} border-[2.5px] cursor-pointer px-5 pb-1 rounded-full">
          <small class="text-[12px] text-white">{{ $tag['tag_name'] }}</small>
        </div>
        @endforeach
      </div>
      <div class="flex gap-2">
        <x-primary-button class="h-10" type="submit">Update post!</x-primary-button>
        <x-secondary-button wire:click="handleClickCancel" class="h-10">Cancel</x-secondary-button>
      </div>
      @if(!$shouldShowEditForm)
      <span class="text-zinc-600">{{$post->content}}</span>
      @endif
      @if($post->featured_image)
      <img class="rounded-md max-w-[1000px] " src="{{asset('storage/photos/' . $post->featured_image)}}" />
      @endif
    </div>
  </form>
  @else

  <div class="p-8 bg-gray-200 border border-zinc-300 rounded-md flex flex-col gap-4">
    <div class="w-full flex justify-between">
      <div class="gap-4 flex w-[80%]">
        <img class="rounded-full w-12 h-12 object-cover"
          src="{{asset('storage/photos/' . $post->user->profile_image)}}" />
        <div class="flex flex-col ">
          <span class="font-bold">{{$post->user->name}}</span>
          <small class="text-xs text-zinc-400">{{$post->created_at->format('j M Y, g:i a')}}</small>
        </div>
      </div>
      <div class="justify-end flex items-center gap-2 w-[20%]">
        @if($post->tags !== null)
        @foreach(json_decode($post->tags) as $tag)
        <div class="{{ $this->colorDefiner($tag)}}  px-5 pb-1 rounded-full">
          <small class="text-[12px] text-white">{{ $tag }}</small>
        </div>
        @endforeach
        @endif
        @if($post->user->id === auth()->user()->id)
        <!-- Drop Down -->
        <x-dropdown align="center" width="48">
          <x-slot name="trigger">
            <div class="ms-1">
              <svg class="w-5 fill-zinc-800 cursor-pointer hover:fill-zinc-600 transition-all"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                  d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z" />
              </svg>

            </div>

          </x-slot>

          <x-slot name="content">
            <x-dropdown-link
              wire:click="handleClickEdit({{ json_encode(['id' => $post->id, 'content' => $post->content, 'tags' => $post->tags]) }})"
              class="cursor-pointer">
              {{ __('Edit Post') }}
            </x-dropdown-link>

            <button class="w-full text-start">
              <x-dropdown-link wire:click="deletePost({{$post->id}})"
                wire:confirm="Are you sure you want to delete this post? that's a irreversible action"
                class="cursor-pointer">
                {{ __('Delete Post') }}
              </x-dropdown-link>
            </button>
          </x-slot>
        </x-dropdown>
        @endif
      </div>
    </div>
    <span class="text-zinc-600">{{$post->content}}</span>
    @if($post->featured_image)
    <img class="rounded-md max-w-[1000px] " src="{{asset('storage/photos/' . $post->featured_image)}}" />
    @endif
  </div>
  @endif
  @endforeach
</div>