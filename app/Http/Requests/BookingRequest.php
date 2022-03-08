<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingRequest extends FormRequest
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
            "user_id" => "required|integer|exists:users,id",
            "job_id" => "required|integer|exists:jobs,id",
        ];
    }

    public function messages()
    {
        return [
            "job_id.required" => "Application must be made to a selected job.",
            "job_id.exists" => "Must be an existing job.",
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(["user_id" => Auth::user()->id]);
    }
}
