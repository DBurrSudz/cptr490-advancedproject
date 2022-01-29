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
            "ncu_id" =>
                "required|string|max:255|unique:users,ncu_id|unique:admins,ncu_id",
            "dob" => "required|date",
            "address" => "sometimes|string|max:500",
            "description" => "sometimes|string",
        ];
    }

    public function messages()
    {
        return [
            "first_name.required" => "First name is required.",
            "first_name.max" => "First name should not exceed 255 characters.",
            "last_name.required" => "Last name is required.",
            "last_name.max" => "Last name should not exceed 255 characters.",
            "ncu_id.required" => "Please enter your NCU ID number.",
            "ncu_id.max" => "NCU ID should not exceed 255 characters.",
            "ncu_id.unique" => "The NCU ID entered is already taken.",
            "dob.required" => "D.O.B is required.",
            "address" => "Address should not exceed 255 characters",
        ];
    }
}
