<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $errorBag = 'meetingUpdate--';

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
        $this->errorBag .= $this->get('meeting_id');

        return [
            'meeting_id' => 'required|exists:meetings,id',
            'date' => 'required|date_format:format,Y-m-d',
            'start_time' => 'required|date_format:format,H:i',
            'end_time' => 'required|date_format:format,H:i|after:start_time',
            'objective' => 'nullable|string',
            'marketing_requirements' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
        ];
    }
}
