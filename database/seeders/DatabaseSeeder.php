<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Dev',
            'email' => 'dev@dev.com.br',
            'email_verified_at' => now(),
            'profile_image' => 'dev.png',
            'password' => bcrypt('12345678'),
        ]);

        $this->call(UserSeeder::class);
        $this->call(PetSeeder::class);
        $this->call(PostSeeder::class);

    }
}