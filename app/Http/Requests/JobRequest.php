<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JobRequest extends FormRequest
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
            "title" => "required|string|max:500",
            "description" => "required|string",
            "paid" => "sometimes|boolean",
            "rate" => "sometimes|string|max:255",
            "user_id" => "required|integer|exists:users,id",
        ];
    }

    /**
     * Customizes the default validation errors of the framework.
     * @return array
     */
    public function messages()
    {
        return [
            "title.required" => "Title is required.",
            "title.max" => "Title should not exceed 500 characters.",
            "description.required" => "Description is required.",
            "rate.max" => "Rate should not exceed 255 characters.",
            "user_id.required" => "Student is a required field.",
            "user_id.exists" => "Must be an existing Student.",
        ];
    }

    /**
     * Prepares specific fields for validation.
     */
    public function prepareForValidation()
    {
        $this->merge(["user_id" => Auth::user()->id]);
    }
}
