<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Hybrid,Contract,Remote',
            'salary' => 'nullable|numeric|min:0',
            'required_skills' => 'nullable|string',
            'companyId' => 'required|exists:companies,id',
            'categoryId' => 'required|exists:job_categories,id',


        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'description.required' => 'The job description is required.',
            'location.required' => 'The job location is required.',
            'type.required' => 'The job type is required.',
            'type.in' => 'The job type must be one of the following: Full-time, Hybrid, Contract, Remote.',
            'salary.numeric' => 'The salary must be a number.',
            'salary.min' => 'The salary must be at least 0.',
            'companyId.required' => 'The company is required.',
            'companyId.exists' => 'The selected company does not exist.',
            'categoryId.required' => 'The category is required.',
            'categoryId.exists' => 'The selected category does not exist.',
        ];
    }
}
