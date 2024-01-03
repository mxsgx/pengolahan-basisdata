<?php

namespace App\Http\Requests\Assignment;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
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
            'content' => ['nullable', 'string'],
            'deadline_at' => ['nullable', 'date'],
            'material_id' => ['nullable', 'exists:materials,id'],
        ];
    }
}
