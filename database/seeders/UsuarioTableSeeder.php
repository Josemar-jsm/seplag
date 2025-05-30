<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'usuario@example.com',
            'password' => bcrypt('senha123'),
        ]);
    }
}
