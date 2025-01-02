<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoPageRequest extends FormRequest
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
			'keywords' => 'required',
			'title' => 'required|string',
			'description' => 'required|string',
			'meta_robots' => 'string',
			'canonical_url' => 'string',
			'og_title' => 'string',
			'og_description' => 'string',
			'og_image' => 'string',
			'locale' => 'string',
			'sitemap_frequency' => 'string',
			'custom_scripts' => 'string',
        ];
    }
}
