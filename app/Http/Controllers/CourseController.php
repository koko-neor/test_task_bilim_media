<?php

namespace App\Http\Controllers;

use App\DTO\CourseDTO;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class CourseController
 * @package App\Http\Controllers
 */
class CourseController extends Controller
{
    /**
     * @param CourseService $courseService
     */
    public function __construct(private CourseService $courseService)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get all courses.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $courses = $this->courseService->getAllCourses();
        return CourseResource::collection($courses);
    }

    /**
     * Store a newly created course.
     *
     * @param StoreCourseRequest $request
     * @return CourseResource
     */
    public function store(StoreCourseRequest $request): CourseResource
    {
        $dto = new CourseDTO(...$request->validated());
        $course = $this->courseService->createCourse($dto);
        return new CourseResource($course);
    }

    /**
     * Display the specified course.
     *
     * @param int $id
     * @return CourseResource
     */
    public function show(int $id): CourseResource
    {
        $course = $this->courseService->getCourseById($id);
        return new CourseResource($course);
    }

    /**
     * Update the specified course.
     *
     * @param UpdateCourseRequest $request
     * @param Course $course
     * @return CourseResource
     */
    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $dto = new CourseDTO(...$request->validated());
        $updatedCourse = $this->courseService->updateCourse($course, $dto);
        return new CourseResource($updatedCourse);
    }

    /**
     * Remove the specified course.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        $this->courseService->deleteCourse($course);
        return response()->json(null, 204);
    }

    /**
     * Search for courses based on criteria.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $criteria = $request->only('keyword', 'category');
        $courses = $this->courseService->searchCourses($criteria);
        return CourseResource::collection($courses);
    }
}
