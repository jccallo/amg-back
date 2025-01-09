<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'amount'    => 'required|numeric|min:0.01',    // El monto debe ser numérico y mayor que 0
            'date'      => 'required|date',                // Debe ser una fecha válida
            'client_id' => 'required|exists:clients,id',   // El client_id debe existir en la tabla clients
        ];
    }
}
