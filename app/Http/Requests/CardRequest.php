<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
                    'holder_document' => 'required',
                    'holder_name' => 'required',
                    'last_four_digits' => 'required',
                    'brand' => 'required',
                    'expiration' => 'required',
                    'address_id' => 'required',
                ];
                break;

            default:
                return [];
                break;
        endswitch;
    }
}
