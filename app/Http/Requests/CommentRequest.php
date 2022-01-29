<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
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
            "body" => "required|string",
            "job_id" => "required|integer|exists:jobs,id",
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
            "body.required" => "Cannot submit an empty comment.",
            "job_id.required" => "This comment should be posted to a job.",
            "job_id.exists" => "Comment must be posted to an existing Job",
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
