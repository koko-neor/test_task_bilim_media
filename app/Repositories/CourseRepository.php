<?php

namespace App\Repositories;

use App\Models\Course;
use App\DTO\CourseDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseRepository
 * @package App\Repositories
 */
class CourseRepository
{
    /**
     * Get all courses with lessons.
     *
     * @return Collection|static[]
     */
    public function getAllCourses(): Collection|static
    {
        return Course::with('lessons')->get();
    }

    /**
     * Create a new course.
     *
     * @param CourseDTO $dto
     * @return Course
     */
    public function createCourse(CourseDTO $dto): Course
    {
        return Course::create((array) $dto);
    }

    /**
     * Get a course by ID with lessons.
     *
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function getCourseById(int $id): Model|Collection|Builder|array
    {
        return Course::with('lessons')->findOrFail($id);
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
        $course->update((array) $dto);
        return $course;
    }

    /**
     * Delete a course.
     *
     * @param Course $course
     * @return void
     */
    public function deleteCourse(Course $course)
    {
        $course->delete();
    }

    /**
     * Search for courses based on criteria.
     *
     * @param array $criteria
     * @return Collection|static[]
     */
    public function searchCourses(array $criteria): Collection|static
    {
        $query = Course::query();

        if (isset($criteria['keyword'])) {
            $query->where('title', 'like', '%' . $criteria['keyword'] . '%')
                ->orWhere('description', 'like', '%' . $criteria['keyword'] . '%');
        }

        return $query->with('lessons')->get();
    }
}
