<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function enroll(Request $request, Course $course): JsonResponse
    {
        $user = Auth::user();

        if (Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return response()->json(['message' => 'Вы уже записались на курс.'], 400);
        }

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        return response()->json($enrollment, 201);
    }

    public function myCourses(): JsonResponse
    {
        $user = Auth::user();
        $courses = $user->courses;

        return response()->json($courses);
    }
}
