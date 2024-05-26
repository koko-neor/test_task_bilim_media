<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAsStudent()
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($user, 'sanctum');
    }

    /** @test */
    public function it_can_enroll_in_a_course()
    {
        $this->authenticateAsStudent();

        $course = Course::factory()->create();

        $response = $this->postJson("/api/courses/{$course->id}/enroll");

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'user_id', 'course_id'
            ]);
    }

    /** @test */
    public function it_can_view_enrolled_courses()
    {
        $this->authenticateAsStudent();

        $user = auth()->user();
        $course = Course::factory()->create();

        $user->courses()->attach($course->id);

        $response = $this->getJson('/api/my-courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'description', 'category']
            ]);
    }

    /** @test */
    public function it_cannot_enroll_in_the_same_course_twice()
    {
        $this->authenticateAsStudent();

        $course = Course::factory()->create();
        $user = auth()->user();

        $user->courses()->attach($course->id);

        $response = $this->postJson("/api/courses/{$course->id}/enroll");

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Вы уже записались на курс.'
            ]);
    }
}
