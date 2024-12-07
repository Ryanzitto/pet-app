<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(), // Nome do pet gerado aleatoriamente
            'especie' => $this->faker->randomElement(['Cachorro', 'Gato', 'Pássaro', 'Coelho']),
            'raca' => $this->faker->word(), // Raça do pet gerado aleatoriamente
            'idade' => $this->faker->numberBetween(1, 15), // Idade aleatória entre 1 e 15
            'user_id' => User::inRandomOrder()->first()->id, // Associa um usuário aleatório
        ];
    }
}
