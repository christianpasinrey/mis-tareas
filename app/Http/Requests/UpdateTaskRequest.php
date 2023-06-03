<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'status_id' => 'required|exists:task_statuses,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.max' => 'El título debe tener menos de 255 caracteres',
            'description.max' => 'La descripción debe tener menos de 255 caracteres',
            'due_date.date' => 'La fecha límite debe ser una fecha válida',
            'status_id.required' => 'El estado es obligatorio',
            'status_id.exists' => 'El estado seleccionado no existe',
        ];
    }
}
