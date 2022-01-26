<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AnnouncementRequest extends FormRequest
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
            "category" => "required|string",
            "description" => "required|string",
            "admin_id" => "required|integer|exists:admins,id",
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
            "category.required" =>
                "Please select a category for this announcement.",
            "description.required" => "Description is required.",
            "admin_id.required" => "Admin is a required field.",
            "admin_id.exists" => "Must be an existing Admin.",
        ];
    }

    /**
     * Prepares specific fields for validation.
     */
    public function prepareForValidation()
    {
        $this->merge(["admin_id" => Auth::guard("admin")->user()->id]);
    }
}
