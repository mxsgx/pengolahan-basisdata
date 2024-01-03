<?php

namespace App\Http\Controllers;

use App\Enums\AttachmentKind;
use App\Http\Requests\Material\CommentMaterialRequest;
use App\Http\Requests\Material\CreateMaterialRequest;
use App\Http\Requests\Material\UpdateMaterialRequest;
use App\Models\Course;
use App\Models\Material;

class MaterialController extends Controller
{
    public function newMaterialPage(Course $course)
    {
        return view('material.new', ['course' => $course]);
    }

    public function createMaterial(CreateMaterialRequest $request, Course $course)
    {
        $material = $course->materials()->create($request->safe()->merge([
            'mentor_id' => $request->user()->id,
        ])->except(['video_url']));

        if ($request->input('video_url')) {
            $material->video()->create([
                'kind' => AttachmentKind::LINK,
                'data' => [
                    'url' => $request->input('video_url'),
                    'tags' => ['embed'],
                ],
            ]);
        }

        return redirect()->route('material.edit', ['course' => $course, 'material' => $material]);
    }

    public function editMaterialPage(Course $course, Material $material)
    {
        return view('material.edit', ['course' => $course, 'material' => $material]);
    }

    public function updateMaterial(UpdateMaterialRequest $request, Course $course, Material $material)
    {
        $material->update($request->safe()->except(['video_url']));

        if ($request->input('video_url')) {
            $material->video()->update([
                'kind' => AttachmentKind::LINK,
                'data' => [
                    'url' => $request->input('video_url'),
                    'tags' => ['embed'],
                ],
            ]);
        }

        return redirect()->route('material.edit', ['course' => $course, 'material' => $material]);
    }

    public function viewMaterial(Course $course, Material $material)
    {
        return view('material.view', ['course' => $course, 'material' => $material]);
    }

    public function commentMaterial(CommentMaterialRequest $request, Course $course, Material $material)
    {
        $material->comments()->create(['content' => $request->input('comment'), 'user_id' => $request->user()->id]);

        return redirect()->route('material.view', ['course' => $course, 'material' => $material]);
    }
}
