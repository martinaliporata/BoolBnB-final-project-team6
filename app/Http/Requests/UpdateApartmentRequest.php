<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'Nome'=>'required|min:1',
            'Stanze' => 'required|numeric|min:1',
            'Letti' => 'required|numeric|min:1',
            'Bagni' => 'required|numeric|min:1',
            'Metri_quadrati' => 'required|numeric|min:10',
            'Indirizzo' => 'required|max:255|min:3',
            'Prezzo'=>'required|numeric|min:10',
            'Latitudine' => 'numeric',
            'Longitudine' => 'numeric',
            'Img' => 'required|URL'
        ];
    }
}
