<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreJobRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|string',
            'job_type_id' => 'required|exists:job_types,id', // Validate against job_types table
            'category_id' => 'required|exists:categories,id', // Validate against categories table
            'vacancy' => 'required|integer',
            'location' => 'required|string|max:255',
            'experience' => 'required',
            'salary' => 'required|numeric',
            'description' => 'required|min:3|max:2000',
            'company_name' => 'required|string|max:255',
            'keywords' => 'required|string|max:255',
        ];
    }
}
