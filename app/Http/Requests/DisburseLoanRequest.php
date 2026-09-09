<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisburseLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $loan = $this->route('loan');
        return $this->user()->can('disburse', $loan);
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $loan = $this->route('loan');
            if ($loan && $loan->status === 'Disbursed') {
                $validator->errors()->add('status', 'This loan has already been disbursed and cannot be disbursed again.');
            }
        });
    }
}