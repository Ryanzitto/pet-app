<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = ['cat', 'dog', 'health', 'pets', 'news', 'question'];
        return [
            'content' => $this->faker->paragraphs(3, true),
            'user_id' => User::inRandomOrder()->first()->id, 
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'tags' => json_encode($this->faker->randomElements($tags, rand(1, 3))),
            'featured_image' => "post.jpg", 
        ];
    }
}