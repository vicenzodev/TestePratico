<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest{
    
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'client_id' => 'required|exists:clients,id',
            'gateway_id' => 'required|exists:gateways,id',
            'amount' => 'required|integer|min:1',
            'card_last_numbers' => 'required|string|size:4',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ];
    }
}
