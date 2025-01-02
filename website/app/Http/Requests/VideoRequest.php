<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
			'title' => 'required|string',
			'slug' => 'required|string',
			'description' => 'string',
			'video_url' => 'required|string',
			'thumbnail_url' => 'string',
			'author_id' => 'required',
			'views_count' => 'required',
			'likes_count' => 'required',
			'comments_count' => 'required',
			'is_published' => 'required',
        ];
    }
}
