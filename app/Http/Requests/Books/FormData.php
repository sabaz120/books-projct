<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $method = $this->method();

        if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
            // Check if updating an existing book
            $bookId = $this->route('id');
            // Retrieve the book from the database
            $book = \App\Models\Book::find($bookId);
            // Check if the authenticated user owns the book
            return $book && $book->user_id === auth()->user()->id;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        $method = $this->method();
        if ($method == 'PUT' || $method == 'PATCH') {
            $rules['name'] = 'string|max:150';
            $rules['author'] = 'string|max:150';
            $rules['summary'] = 'string|max:250';
        } elseif ($method == 'POST') {
            $rules['name'] = 'required|string|max:150';
            $rules['author'] = 'required|string|max:150';
            $rules['summary'] = 'required|string|max:250';
        }
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            "status" => false,
            "message" => __("books.invalid_data"),
            "data" => $validator->errors(),
        ];

        // Finally throw the HttpResponseException.
        throw new HttpResponseException(response()->json($response, 422));
    }

    protected function failedAuthorization()
    {
        $response = [
            "status" => false,
            "message" => __("books.unauthorized"),
        ];

        // Finally throw the HttpResponseException.
        throw new HttpResponseException(response()->json($response, 403));
    }
}
