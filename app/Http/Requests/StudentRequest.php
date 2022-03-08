<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "dob" => "required|date",
            "address" => "nullable|string|max:500",
            "description" => "nullable|string",
        ];
    }

    public function messages()
    {
        return [
            "first_name.required" => "First name is required.",
            "first_name.max" => "First name should not exceed 255 characters.",
            "last_name.required" => "Last name is required.",
            "last_name.max" => "Last name should not exceed 255 characters.",
            "dob.required" => "D.O.B is required.",
            "address" => "Address should not exceed 255 characters",
        ];
    }
}
