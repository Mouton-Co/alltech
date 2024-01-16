<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    protected $errorBag = 'reportStore';

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
            'recipient' => 'email|nullable',
            'send_at' => 'date_format:format,Y-m-d H:i|nullable',
            'repeat' => 'boolean|nullable',
            'repeat_frequency' => 'required_if:repeat,1|nullable|in:'.implode(',', array_keys(Report::REPEAT_FREQUENCY)),
        ];
    }
}
