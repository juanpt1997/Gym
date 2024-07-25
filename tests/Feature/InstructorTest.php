<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ClassType;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InstructorTest extends TestCase
{
    public function test_instructor_is_redirected_to_instructor_dashboard()
    {
        $user = User::factory()->create(
            ['role' => 'instructor']
        );

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirectToRoute('instructor.dashboard');

        $this->followRedirects($response)->assertSeeText("Hey instructor!");

    }

    public function test_instructor_can_schedule_a_class()
    {
        //Given
         $user = User::factory()->create(
            ['role' => 'instructor']
        );
        $this->seed(ClassTypeSeeder::class);

        //When
        $response = $this->actingAs($user)
            ->post('/instructor/schedule', [
            'class_type_id' => 1,
            'date' => '2024-08-27',
            'time' => '10:00'
        ]);
        
        //Then
        $response->assertRedirectToRoute('schedule.index');
    }
}
