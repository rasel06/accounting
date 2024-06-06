<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'payment_method' => ['required'],
            'invoice_number' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'invoice_date' => ['required'],
            'number_of_unit' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'unit_price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'total' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'payment_method' => ['required'],
            'invoice_number' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'invoice_date' => ['required'],
            'invoice_file' => ['required', 'string', 'max:120'],
            'number_of_unit' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'unit_price' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'total' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'remarks' => ['required', 'string', 'max:200'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
        ];
    }
}
