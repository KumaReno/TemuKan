<?php

namespace App\Http\Requests;

class UpdateReportRequest extends StoreReportRequest
{
    public function rules(): array
    {
        $rules = array_map(
            fn (array $fieldRules): array => array_merge(['sometimes'], $fieldRules),
            parent::rules()
        );

        $rules['remove_image'] = ['sometimes', 'boolean'];

        return $rules;
    }
}
