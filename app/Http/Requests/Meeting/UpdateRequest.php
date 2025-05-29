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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'all_day' => ! empty($this->input('all_day')) && $this->input('all_day') == 'on' ? true : false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $this->errorBag .= $this->get('meeting_id');

        $rules = [
            'title' => 'required|string|max:255',
            'all_day' => 'required|boolean',
            'date' => 'required|date_format:format,Y-m-d',
            'location' => 'nullable|string',
            'report' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'type' => 'required|in:Call,Visit',
        ];

        if ($this->get('all_day')) {
            $rules['end_date'] = 'required|date_format:format,Y-m-d|after_or_equal:date';
        } else {
            $rules['start_time'] = 'required|date_format:format,H:i';
            $rules['end_time'] = 'required|date_format:format,H:i|after:start_time';
        }

        return $rules;
    }
}
