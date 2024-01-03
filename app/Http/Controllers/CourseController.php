<?php

namespace App\Http\Controllers;

use App\Enums\AttachmentKind;
use App\Enums\UserRole;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courseCataloguePage()
    {
        $courses = Course::cursorPaginate(12);

        return view('course.catalogue', ['courses' => $courses]);
    }

    public function newCoursePage()
    {
        return view('course.create');
    }

    public function createCourse(CreateCourseRequest $request)
    {
        $course = Course::create($request->safe()->merge([
            'mentor_id' => $request->user()->id,
        ])->except(['cover_image']));

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('courses/covers', 's3');

            if ($path) {
                $course->coverImage()->create([
                    'kind' => AttachmentKind::FILE,
                    'data' => [
                        'mime_type' => $request->file('cover_image')->getMimeType(),
                        'tags' => ['coverImage'],
                        'path' => $path,
                    ],
                ]);
            }
        }

        return redirect()->route('course.edit', ['course' => $course]);
    }

    public function editCoursePage(Course $course)
    {
        return view('course.edit', ['course' => $course]);
    }

    public function updateCourse(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('courses/covers', 's3');

            if ($path) {
                $course->coverImage()->update([
                    'kind' => AttachmentKind::FILE,
                    'data' => [
                        'mime_type' => $request->file('cover_image')->getMimeType(),
                        'tags' => ['coverImage'],
                        'path' => $path,
                    ],
                ]);
            }
        }

        return redirect()->route('course.edit', ['course' => $course]);
    }

    public function viewCourse(Course $course)
    {
        return view('course.view', ['course' => $course]);
    }

    public function enrolledCoursesPage(Request $request)
    {
        return view('course.enrolled');
    }

    public function enrollCourse(Request $request, Course $course)
    {
        abort_unless($request->user()->role == UserRole::STUDENT, 403);

        $request->user()->enrolledCourses()->syncWithoutDetaching($course);

        return redirect()->route('course.home', ['course' => $course]);
    }

    public function coursePage(Course $course)
    {
        return view('course.home', ['course' => $course]);
    }
}
