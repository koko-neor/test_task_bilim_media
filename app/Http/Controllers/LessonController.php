<?php

namespace App\Http\Controllers;

use App\DTO\LessonDTO;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\LessonService;
use Illuminate\Http\JsonResponse;

/**
 * Class LessonController
 * @package App\Http\Controllers
 */
class LessonController extends Controller
{
    /**
     * @param LessonService $lessonService
     */
    public function __construct(private LessonService $lessonService)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Store a newly created lesson.
     *
     * @param StoreLessonRequest $request
     * @param Course $course
     * @return LessonResource
     */
    public function store(StoreLessonRequest $request, Course $course): LessonResource
    {
        $dto = new LessonDTO(...$request->validated());
        $lesson = $this->lessonService->createLesson($course, $dto);
        return new LessonResource($lesson);
    }

    /**
     * Update the specified lesson.
     *
     * @param UpdateLessonRequest $request
     * @param Lesson $lesson
     * @return LessonResource
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson): LessonResource
    {
        $dto = new LessonDTO(...$request->validated());
        $updatedLesson = $this->lessonService->updateLesson($lesson, $dto);
        return new LessonResource($updatedLesson);
    }

    /**
     * Remove the specified lesson.
     *
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $this->lessonService->deleteLesson($lesson);
        return response()->json(null, 204);
    }

    /**
     * Display the specified lesson.
     *
     * @param Lesson $lesson
     * @return LessonResource
     */
    public function show(Lesson $lesson): LessonResource
    {
        return new LessonResource($lesson);
    }
}
