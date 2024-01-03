<?php

namespace App\Http\Requests\Course;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role == UserRole::MENTOR;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'file', 'image'],
        ];
    }
}
