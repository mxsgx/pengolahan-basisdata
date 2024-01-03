<?php

namespace App\Http\Controllers;

use App\Enums\AttachmentKind;
use App\Http\Requests\Assignment\CommentAssignmentRequest;
use App\Http\Requests\Assignment\CreateAssignmentRequest;
use App\Http\Requests\Assignment\SubmitSubmissionRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\Attachment;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function newAssignmentPage(Course $course)
    {
        return view('assignment.new', ['course' => $course]);
    }

    public function createAssignment(CreateAssignmentRequest $request, Course $course)
    {
        $assignment = Assignment::create($request->safe()->merge([
            'course_id' => $course->id,
        ])->toArray());

        return redirect()->route('assignment.edit', ['course' => $course, 'assignment' => $assignment]);
    }

    public function editAssignmentPage(Course $course, Assignment $assignment)
    {
        return view('assignment.edit', ['course' => $course, 'assignment' => $assignment]);
    }

    public function updateAssignment(UpdateAssignmentRequest $request, Course $course, Assignment $assignment)
    {
        $assignment->update($request->validated());

        return redirect()->route('assignment.edit', ['course' => $course, 'assignment' => $assignment]);
    }

    public function viewAssignmentPage(Course $course, Assignment $assignment)
    {
        return view('assignment.view', ['course' => $course, 'assignment' => $assignment]);
    }

    public function commentAssignment(CommentAssignmentRequest $request, Course $course, Assignment $assignment)
    {
        $assignment->comments()->create(['content' => $request->input('comment'), 'user_id' => $request->user()->id]);

        return redirect()->route('assignment.view', ['course' => $course, 'assignment' => $assignment]);
    }

    public function submitSubmission(SubmitSubmissionRequest $request, Course $course, Assignment $assignment)
    {
        $submission = $assignment->submissions()->where('student_id', $request->user()->id)->firstOrCreate([
            'student_id' => $request->user()->id,
        ]);
        if ($path = $request->file('submission_file')->store('courses/submissions', 's3')) {
            $submission->attachments()->create([
                'kind' => AttachmentKind::FILE,
                'data' => [
                    'tags' => ['submissionFile'],
                    'path' => $path,
                    'mime_type' => $request->file('submission_file')->getMimeType(),
                    'file_name' => $request->file('submission_file')->getClientOriginalName(),
                ],
            ]);
        }

        return redirect()->route('assignment.view', ['course' => $course, 'assignment' => $assignment]);
    }

    public function deleteSubmission(Course $course, Assignment $assignment, Submission $submission, Attachment $attachment)
    {
        $attachment->delete();

        if (Storage::disk('s3')->exists($attachment->data['path'])) {
            Storage::disk('s3')->delete($attachment->data['path']);
        }

        return redirect()->route('assignment.view', ['course' => $course, 'assignment' => $assignment]);
    }
}
