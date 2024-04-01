<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RechargeRequest extends FormRequest
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
        switch (strtolower($this->route()->getActionMethod())):
            case 'create':
                return [
                    'amount' => 'required|numeric',
                    'installments' => 'required|integer|min:1|max:12',
                    'card_id' => 'required|exists:cards,id',
                ];
                break;

            default:
                return [];
                break;
        endswitch;
    }
}
