<?php

use App\Http\Controllers\EnrollmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{course}', [CourseController::class, 'show']);
    Route::get('search', [CourseController::class, 'search']);

    Route::get('lessons/{lesson}', [LessonController::class, 'show']);

    Route::post('courses/{course}/enroll', [EnrollmentController::class, 'enroll']);
    Route::get('my-courses', [EnrollmentController::class, 'myCourses']);

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::post('courses', [CourseController::class, 'store']);
        Route::put('courses/{course}', [CourseController::class, 'update']);
        Route::delete('courses/{course}', [CourseController::class, 'destroy']);

        Route::post('courses/{course}/lessons', [LessonController::class, 'store']);
        Route::put('lessons/{lesson}', [LessonController::class, 'update']);
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy']);
    });
});
