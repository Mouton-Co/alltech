<?php

namespace App\Http\Requests\CompanyType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $errorBag = 'companyTypeUpdate--';

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $this->errorBag .= $this->get('company_type_id');

        return [
            'name' => 'required',
            'minimum_required' => 'required|int|min:1',
        ];
    }
}
