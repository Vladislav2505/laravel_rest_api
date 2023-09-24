<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'customerId' => ['required', 'integer'],
                'amount' => ['required', 'numeric'],
                'status' => ['required', Rule::in('P', 'B', 'V', 'p', 'b', 'v')],
                'billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
            ];
        } else {
            return [
                'customerId' => ['sometimes', 'required', 'integer'],
                'amount' => ['sometimes', 'required', 'numeric'],
                'status' => ['sometimes', 'required', Rule::in('P', 'B', 'V', 'p', 'b', 'v')],
                'billedDate' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['sometimes', 'date_format:Y-m-d H:i:s', 'nullable'],
            ];
        }
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('customerId')) {
            $this->merge([
                'customer_id' => $this->input('customerId'),
            ]);
        }
        if ($this->input('billedDate')) {
            $this->merge([
                'billed_date' => $this->input('billedDate'),
            ]);
        }
        if ($this->input('paidDate')) {
            $this->merge([
                'paid_date' => $this->input('paidDate'),
            ]);
        }
    }

}
