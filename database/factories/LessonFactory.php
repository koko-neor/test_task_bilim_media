<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'order' => $this->faker->numberBetween(1, 10),
            'video_url' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
