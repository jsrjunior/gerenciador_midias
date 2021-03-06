<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
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
            'nome' => 'required',
            'nome' => 'min:2',
            'qtd_temporadas' => 'required',
            'qtd_episodios' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'É necessario preencher :attribute ',
            'min' => 'É necessario mais que 2 caracteres'
        ];
    }
}
