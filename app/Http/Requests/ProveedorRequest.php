<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            'rfc' => 'required',
            'nombre_corto' => 'required',
            'razon_social' => 'required',
            'poblacion_id' => 'required',
            'municipio_id' => 'required',
            'estado_id' => 'required',
            'pais_id' => 'required',
            'calle' => 'required',
            'numero_exterior' => 'required',
            'colonia'=>'required',
        ];
    }
}
