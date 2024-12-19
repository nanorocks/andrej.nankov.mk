<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'slug' => 'required|string',
			'title' => 'required|string',
			'description' => 'required|string',
			'start_date' => 'required',
			'project_url' => 'string',
			'image_url' => 'string',
			'status' => 'required',
			'user_id' => 'required',
        ];
    }
}
