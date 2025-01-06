<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public $racas = [
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
            'nome' => $this->faker->name(), // Nome do pet gerado aleatoriamente
            'especie' => $this->faker->randomElement(['Cachorro', 'Gato', 'Pássaro', 'Coelho']),
            'raca' => $this->faker->randomElement($this->racas),
            'idade' => $this->faker->numberBetween(1, 10), // Idade aleatória entre 1 e 15
            'user_id' => User::inRandomOrder()->first()->id, // Associa um usuário aleatório
        ];
    }
}
