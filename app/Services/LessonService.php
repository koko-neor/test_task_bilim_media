<?php

namespace App\Services;

use App\DTO\LessonDTO;
use App\Models\Course;
use App\Models\Lesson;
use App\Repositories\LessonRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LessonService
 * @package App\Services
 */
class LessonService
{
    /**
     * @param LessonRepository $lessonRepository
     */
    public function __construct(private LessonRepository $lessonRepository) {}

    /**
     * Create a new lesson.
     *
     * @param Course $course
     * @param LessonDTO $dto
     * @return Model
     */
    public function createLesson(Course $course, LessonDTO $dto): Model
    {
        return $this->lessonRepository->createLesson($course, $dto);
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
        return $this->lessonRepository->updateLesson($lesson, $dto);
    }

    /**
     * Delete a lesson.
     *
     * @param Lesson $lesson
     * @return void
     */
    public function deleteLesson(Lesson $lesson)
    {
        $this->lessonRepository->deleteLesson($lesson);
    }
}
