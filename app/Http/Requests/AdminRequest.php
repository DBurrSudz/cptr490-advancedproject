<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $shared = "required|string|max:255";
        return [
            "first_name" => $shared,
            "last_name" => $shared,
            "title" => $shared,
            "position" => $shared,
        ];
    }

    public function messages()
    {
        return [
            "first_name.required" => "First name is required.",
            "first_name.max" => "First name should not exceed 255 characters.",
            "last_name.required" => "Last name is required.",
            "last_name.max" => "Last name should not exceed 255 characters.",
            "title.required" => "Title is required.",
            "position.required" => "Position is required.",
            "title.max" => "Title should not exceed 255 characters.",
            "position.max" => "Position should not exceed 255 characters.",
        ];
    }
}

