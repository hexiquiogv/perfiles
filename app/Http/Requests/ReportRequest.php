<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'title' => 'required',
            'consulta_id' => 'required',
            // 'columns' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nombre del reporte es obligatorio',
            'consulta_id.required' => 'El valor de Modelo es obligatorio',
            // 'columns.required' => 'Al menos debe incluir una columna para exportar',
        ];
    }
}
