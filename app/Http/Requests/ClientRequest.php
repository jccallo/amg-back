<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $clientId = $this->route('id');

        $email = $this->getMethod() === 'POST' ?
            'required|email|unique:clients,email|max:255' :
            "required|email|unique:clients,email,{$clientId}|max:255";

        return [
            'name'                  => 'required|string|max:255',         // El campo 'name' es obligatorio, debe ser una cadena, y tiene un tamaño máximo de 255 caracteres
            'email'                 => $email,                            // El campo 'email' es obligatorio, debe ser un correo válido, único en la tabla 'clients', y tiene un tamaño máximo de 255 caracteres
            'phone'                 => 'required|string|min:10|max:10',
            'transactions'          => 'sometimes|array',                  // El campo 'transactions' debe ser un array
            'transactions.*.amount' => 'sometimes|numeric|min:0',          // Cada transacción debe tener un campo 'amount' obligatorio, debe ser un número, y debe ser mayor o igual a 0
            'transactions.*.date'   => 'sometimes|date',                   // Cada transacción debe tener un campo 'date' obligatorio y debe ser una fecha válida
        ];
    }
}
