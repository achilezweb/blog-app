<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string', 'max:255'],
            'tags' => ['array'],
            'tags.*' => ['exists:tags,id'],
            'categories' => ['array'],
            'categories.*' => ['exists:categories,id'],
            'privacy_id' => ['string'],
            'location_name' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB Max
            'media_files.*' => 'file|max:10240', // Validation for new media files
            'remove_media' => 'nullable|array', // IDs of media to remove
            'remove_media.*' => 'integer|exists:media,id'
        ];
    }
}
