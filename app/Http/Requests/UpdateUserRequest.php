<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateUserRequest extends FormRequest
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
        $validation = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ];
        if(request('email') != JWTAuth::user()->email){
            $validation['email'] = 'required|string|email|max:255|unique:users';
        }

        return $validation;
    }
}
