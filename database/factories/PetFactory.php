<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public $breeds = [
        "Labrador Retriever",
        "Pastor Alemão",
        "Poodle",
        "Bulldog Francês",
        "Golden Retriever",
        "Siamês",
        "Maine Coon",
        "Persa",
        "Bengal",
        "Ragdoll",
        "Calopsita",
        "Canário",
        "Periquito Australiano",
        "Agapornis (Pássaro do Amor)",
        "Papagaio-Amazona",
        "Lionhead (Cabeça de Leão)",
        "Netherland Dwarf",
        "Rex",
        "Lop Inglês",
        "Californiano"];

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(), 
            'specie' => $this->faker->randomElement(['Dog', 'Cat']),
            'breed' => $this->faker->randomElement($this->breeds),
            'age' => $this->faker->numberBetween(1, 10), 
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'is_neutered' => $this->faker->boolean(),
            'is_missing' => $this->faker->boolean(1),
            'pet_image' => 'placeholder.webp',
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
