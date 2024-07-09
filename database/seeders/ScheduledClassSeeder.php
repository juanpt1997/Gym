<?php

namespace Database\Seeders;

use App\Models\ScheduledClass;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduledClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScheduledClass::factory()->count(3)->create([
            'instructor_id' => 2
        ]);
        ScheduledClass::factory()->count(7)->create();
    }
}
