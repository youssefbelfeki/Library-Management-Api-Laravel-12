<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                Rule::unique(table: 'books', column: 'isbn')->ignore(id: $this->route(param: 'book')->id)
            ],
            'description' => 'nullable|string',
            'genre' => 'nullable|string',
            'published_at' => 'nullable|date',
            'total_copies' => 'required|integer',
            'available_copies' => 'integer|max:total_copies',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|url',
            'status' => 'required|in:active,inactive',
            'author_id' => 'required|exists:authors,id',
        ];
    }
}
