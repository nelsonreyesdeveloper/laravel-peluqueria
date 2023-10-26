<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
            'name' => ['required', 'string', function ($attribute, $value, $fail) {
                $words = str_word_count($value);

                if ($words < 2) {
                    $fail("El campo nombre debe contener al menos nombre y apellido.");
                }
            },'regex:/^[^0-9]*$/'],
            'email' => ['required', 'email', 'unique:users', 'regex:/^(.+\@gmail\.com|.+@yahoo\.com|.+@hotmail\.com|.+@yahoo\.com.es|.+@outlook\.com)$/i'],
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.regex' => 'No se permiten numeros en el nombre',
            'email.required' => 'El email es obligatorio',
            'email.unique' => 'El email ya existe',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'email.regex' => 'El email no es válido, solo se permite gmail, yahoo, hotmail, outlook',
            'password.regex' => 'La contraseña debe tener 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un caracter especial'
        ];
    }
}
