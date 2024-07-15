<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DarDeBajaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // O bien, lógica para determinar si el usuario está autorizado
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'fechaBaja' => 'required|date',
        ];
    }
}
