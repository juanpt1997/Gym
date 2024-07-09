<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Juan',
            'email' => 'tabaresricojuanpablo@gmail.com',
            'password' => '$2y$12$zfBlv3W4XcaWhlHg7DuPp.M/x1T.69xCrstnnKlFQTrnjY7GePGrK'
        ]);
        User::factory()->create([
            'name' => 'Ellie',
            'email' => 'ellie@gmail.com',
            'role' => 'instructor',
            'password' => '$2y$12$zfBlv3W4XcaWhlHg7DuPp.M/x1T.69xCrstnnKlFQTrnjY7GePGrK'
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => '$2y$12$zfBlv3W4XcaWhlHg7DuPp.M/x1T.69xCrstnnKlFQTrnjY7GePGrK'
        ]);

        User::factory()->count(10)->create();

        User::factory()->count(10)->create([
            'role' => 'instructor'
        ]);
    }
}
