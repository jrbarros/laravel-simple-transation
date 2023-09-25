<?php

namespace App\Http\Requests;

use App\Enum\TransactionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'forma_pagamento' => ['required', new Enum(TransactionType::class)],
            'conta_id' => 'required|exists:accounts,account_id',
            'valor' => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'forma_pagamento.required' => 'Campo forma_pagamento é obrigatório',
            'forma_pagamento.enum' => 'Forma de transação não é válida',
            'conta_id.required' => 'Campo conta_id é obrigatório',
            'conta_id.exists' => 'Conta não encontrada',
            'valor.required' => 'Valor é obrigatório',
        ];
    }
}
