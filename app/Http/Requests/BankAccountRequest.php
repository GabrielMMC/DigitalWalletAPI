<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
                    'bank' => 'required',
                    'branch_number' => 'required|max:4',
                    'branch_digit' => 'required|max:2',
                    'account_number' => 'required|max:9',
                    'account_digit' => 'required|max:2',
                ];
                break;

            default:
                return [];
                break;
        endswitch;
    }
}
