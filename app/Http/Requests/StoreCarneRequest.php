<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarneRequest extends FormRequest
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
            'valor_total' => 'required|numeric',
            'qtd_parcelas' => 'required|integer',
            'data_primeiro_vencimento' => 'required|date',
            'periodicidade' => 'required|in:mensal,semanal',
            'valor_entrada' => 'nullable|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'valor_total.required' => 'O campo valor total é obrigatório.',
            'valor_total.numeric' => 'O campo valor total deve ser um número.',
            'qtd_parcelas.required' => 'O campo quantidade de parcelas é obrigatório.',
            'qtd_parcelas.integer' => 'O campo quantidade de parcelas deve ser um número inteiro.',
            'data_primeiro_vencimento.required' => 'O campo data do primeiro vencimento é obrigatório.',
            'data_primeiro_vencimento.date' => 'O campo data do primeiro vencimento deve ser uma data válida.',
            'periodicidade.required' => 'O campo periodicidade é obrigatório.',
            'periodicidade.in' => 'O campo periodicidade deve ser mensal ou semanal.',
            'valor_entrada.numeric' => 'O campo valor da entrada deve ser um número.',
        ];
    }
}
