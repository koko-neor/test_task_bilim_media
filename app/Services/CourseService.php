<?php

namespace App\Services;

use App\DTO\CourseDTO;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseService
 * @package App\Services
 */
class CourseService
{
    /**
     * @param CourseRepository $courseRepository
     */
    public function __construct(private CourseRepository $courseRepository) {}

    /**
     * Get all courses.
     *
     * @return Collection|static[]
     */
    public function getAllCourses(): Collection|static
    {
        return $this->courseRepository->getAllCourses();
    }

    /**
     * Create a new course.
     *
     * @param CourseDTO $dto
     * @return Course
     */
    public function createCourse(CourseDTO $dto): Course
    {
        return $this->courseRepository->createCourse($dto);
    }

    /**
     * Get a course by ID.
     *
     * @param int $id
     * @return Model|Collection|Builder|array
     */
    public function getCourseById(int $id): Model|Collection|Builder|array
    {
        return $this->courseRepository->getCourseById($id);
    }

    /**
     * Update an existing course.
     *
     * @param Course $course
     * @param CourseDTO $dto
     * @return Course
     */
    public function updateCourse(Course $course, CourseDTO $dto): Course
    {
        return $this->courseRepository->updateCourse($course, $dto);
    }

    /**
     * Delete a course.
     *
     * @param Course $course
     * @return void
     */
    public function deleteCourse(Course $course)
    {
        $this->courseRepository->deleteCourse($course);
    }

    /**
     * Search for courses based on criteria.
     *
     * @param array $criteria
     * @return Collection|static[]
     */
    public function searchCourses(array $criteria): Collection|static
    {
        return $this->courseRepository->searchCourses($criteria);
    }
}
