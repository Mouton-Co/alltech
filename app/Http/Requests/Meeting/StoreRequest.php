<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date'            => 'required|date_format:format,Y-m-d',
            'start_time'      => 'required|date_format:format,H:i:s',
            'end_time'        => 'required|date_format:format,H:i:s|after:start_time',
            'contact_id'      => 'required|exists:contacts,id',
            'company_id'      => 'required|exists:companies,id',
            'company_type_id' => 'required|exists:company_types,id',
            'user_id'         => 'required|exists:users,id',
        ];
    }
}
