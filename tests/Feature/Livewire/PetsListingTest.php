<?php

namespace Tests\Feature\Livewire;

use App\Livewire\PetsListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PetsListingTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(PetsListing::class)
            ->assertStatus(200);
    }
}
