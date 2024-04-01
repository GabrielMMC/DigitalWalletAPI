<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
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
                    'bank_account_id' => 'required|exists:bank_accounts,id',
                ];
                break;

            default:
                return [];
                break;
        endswitch;
    }
}
