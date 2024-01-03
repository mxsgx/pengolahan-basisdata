<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', 'index')->name('index');

        Route::prefix('/login')->name('login.')->group(function () {
            Route::get('/', 'loginPage')->name('page');
            Route::post('/', 'login')->name('action');
        });

        Route::prefix('/register')->name('register.')->group(function () {
            Route::get('/', 'registerPage')->name('page');
            Route::post('/', 'register')->name('action');
        });
    });

    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::prefix('/c')->controller(CourseController::class)->middleware('auth')->group(function () {
    Route::redirect('/', '/');
    Route::get('/browse', 'courseCataloguePage')->name('course.catalogue');
    Route::get('/enrolled', 'enrolledCoursesPage')->name('course.enrolled');
    Route::get('/new', 'newCoursePage')->name('course.new');
    Route::post('/', 'createCourse')->name('course.create');
    Route::get('/{course}', 'coursePage')->name('course.home');
    Route::post('/{course}', 'enrollCourse')->name('course.enroll');
    Route::get('/{course}/edit', 'editCoursePage')->name('course.edit');
    Route::patch('/{course}', 'updateCourse')->name('course.update');

    Route::controller(MaterialController::class)->group(function () {
        Route::get('/{course}/m/{material}', 'viewMaterial')->name('material.view');
        Route::get('/{course}/m/{material}/edit', 'editMaterialPage')->name('material.edit');
        Route::patch('/{course}/m/{material}', 'updateMaterial')->name('material.update');
        Route::post('/{course}/m/{material}/comment', 'commentMaterial')->name('material.comment');
    });

    Route::controller(AssignmentController::class)->group(function () {
        Route::get('/{course}/a/{assignment}', 'viewAssignmentPage')->name('assignment.view');
        Route::get('/{course}/a/{assignment}/edit', 'editAssignmentPage')->name('assignment.edit');
        Route::patch('/{course}/a/{assignment}', 'updateAssignment')->name('assignment.update');
        Route::post('/{course}/a/{assignment}/comment', 'commentAssignment')->name('assignment.comment');
        Route::post('/{course}/a/{assignment}/submit', 'submitSubmission')->name('submission.submit');
        Route::delete('/{course}/a/{assignment}/s/{submission}/{attachment}', 'deleteSubmission')->name('submission.attachment.delete');
    });
});

Route::prefix('/m')->name('material.')->controller(MaterialController::class)->middleware('auth')->group(function () {
    Route::get('/{course}/new', 'newMaterialPage')->name('new');
    Route::post('/{course}', 'createMaterial')->name('create');
});

Route::prefix('/a')->name('assignment.')->controller(AssignmentController::class)->middleware('auth')->group(function () {
    Route::get('/{course}/new', 'newAssignmentPage')->name('new');
    Route::post('/{course}', 'createAssignment')->name('create');
});
