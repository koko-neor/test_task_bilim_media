<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAsAdmin()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user, 'sanctum');
    }

    protected function authenticateAsStudent()
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($user, 'sanctum');
    }

    /** @test */
    public function it_can_list_courses()
    {
        $this->authenticateAsStudent();

        Course::factory()->count(3)->create();

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'category', 'lessons']
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_course()
    {
        $this->authenticateAsAdmin();

        $response = $this->postJson('/api/courses', [
            'title' => 'Test Course',
            'description' => 'Test Description',
            'category' => 'Test Category',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'description', 'category']
            ]);
    }

    /** @test */
    public function it_can_update_a_course()
    {
        $this->authenticateAsAdmin();

        $course = Course::factory()->create();

        $response = $this->putJson("/api/courses/{$course->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'category' => 'Updated Category',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'description', 'category']
            ]);
    }

    /** @test */
    public function it_can_delete_a_course()
    {
        $this->authenticateAsAdmin();

        $course = Course::factory()->create();

        $response = $this->deleteJson("/api/courses/{$course->id}");

        $response->assertStatus(204);
    }
}
