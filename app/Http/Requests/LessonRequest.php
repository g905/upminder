<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mentor_id' => 'required',
            'date_start' => 'required',
            'time_start' => 'required',
            'date_end' => 'required',
            'time_end' => 'required',
            'price' => 'required | numeric'
        ];
    }
}
