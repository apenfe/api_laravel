<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    public function run(): void {
        // Crear un usuario con un token general
        User::factory(1)->create([
            'name' => 'Admin',
            'email' => 'adrian1414@hotmail.es',
            'password' => bcrypt('12345678'),
            'remember_token' => '123',
        ]);
    }
}
