<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
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
     */
    public function rules(): array
    {
        return [
            'filter_name' => 'required|string',
            'filter_used' => 'required|string',
            'recipient' => 'required|email',
            'send_at' => 'required|date_format:format,Y-m-d H:i:s',
            'repeat' => 'required|boolean',
            'repeat_frequency' => 'required_if:repeat,1|in'.implode(',', Report::REPEAT_FREQUENCY),
        ];
    }
}
