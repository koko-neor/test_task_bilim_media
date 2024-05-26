<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAsAdmin()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user, 'sanctum');
    }

    /** @test */
    public function it_can_create_a_lesson()
    {
        $this->authenticateAsAdmin();

        $course = Course::factory()->create();

        $response = $this->postJson("/api/courses/{$course->id}/lessons", [
            'title' => 'Test Lesson',
            'content' => 'Test Content',
            'order' => 1,
            'video_url' => 'https://example.com/video',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'content', 'order', 'video_url']
            ]);
    }

    /** @test */
    public function it_can_update_a_lesson()
    {
        $this->authenticateAsAdmin();

        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create(['course_id' => $course->id]);

        $response = $this->putJson("/api/lessons/{$lesson->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'order' => 2,
            'video_url' => 'https://example.com/video-updated',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'content', 'order', 'video_url']
            ]);
    }

    /** @test */
    public function it_can_delete_a_lesson()
    {
        $this->authenticateAsAdmin();

        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create(['course_id' => $course->id]);

        $response = $this->deleteJson("/api/lessons/{$lesson->id}");

        $response->assertStatus(204);
    }
}
