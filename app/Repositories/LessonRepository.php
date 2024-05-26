<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Lesson;
use App\DTO\LessonDTO;
use Illuminate\Database\Eloquent\Model;


/**
 * Class LessonRepository
 * @package App\Repositories
 */
class LessonRepository
{
    /**
     * Create a new lesson.
     *
     * @param Course $course
     * @param LessonDTO $dto
     * @return Model
     */
    public function createLesson(Course $course, LessonDTO $dto): Model
    {
        return $course->lessons()->create((array) $dto);
    }

    /**
     * Update an existing lesson.
     *
     * @param Lesson $lesson
     * @param LessonDTO $dto
     * @return Lesson
     */
    public function updateLesson(Lesson $lesson, LessonDTO $dto): Lesson
    {
        $lesson->update((array) $dto);
        return $lesson;
    }

    /**
     * Delete a lesson.
     *
     * @param Lesson $lesson
     * @return void
     */
    public function deleteLesson(Lesson $lesson)
    {
        $lesson->delete();
    }
}
