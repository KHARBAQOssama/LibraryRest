<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $return = [
            'title' => 'required|string',
            'author' => 'required|string',
            'collection' => 'nullable|string',
            'publication_date' => 'required|date',
            'page_count' => 'required|integer|min:1',
            'location' => 'required|string',
            'status_id' => 'required',
            'content' => 'required|string',
            'genders' => 'required|array',
            'new_genders' => 'array',
        ];
        if($method == 'POST'){
            $return['isbn'] = 'required|string|unique:books';
        }else if($method == 'PUT' || $method == 'PATCH'){
            $return['isbn'] = 'required|string';
        }

        return $return;
    }
}
