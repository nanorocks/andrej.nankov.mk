<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
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
			'content' => 'required|string',
			'excerpt' => 'string',
			'author_id' => 'required',
			'is_published' => 'required',
			'is_draft' => 'required',
			'views_count' => 'required',
			'likes_count' => 'required',
			'comments_count' => 'required',
			'featured_image' => 'string',
        ];
    }
}
