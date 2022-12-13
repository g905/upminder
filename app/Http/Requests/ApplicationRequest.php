<?php

namespace App\Http\Requests;

use App\Models\ApplicationType;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    
    public function authorize()
    : bool
    {
        return true;
    }
    
    
    public function rules()
    : array
    {
        return [
            'app_type' => 'required|integer',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'is_done' => 'required|boolean',
        ];
    }
    
    protected function getValidatorInstance()
    : \Illuminate\Contracts\Validation\Validator
    {
        $validator = parent::getValidatorInstance();
        $communicate_id = array_search('Telegram', config('app.communicate_method'));
        // Если выбрали телеграм
        $validator->sometimes('telegram', 'required', function ($input) use ($communicate_id) {
            return $input->communicate_method == $communicate_id;
        });
        
        // Подбор ментора
        $validator->sometimes('language_id', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'find')
                    ->first()->id;
        });
        $validator->sometimes('communicate_method', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'find')
                    ->first()->id;
        });
        $validator->sometimes('city', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'find')
                    ->first()->id;
        });
        
        // Заявка на занятия
        $validator->sometimes('mentor_id', 'required|integer', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'lesson')
                    ->first()->id;
        });
        $validator->sometimes('mentor_service_id', 'required|integer', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'lesson')
                    ->first()->id;
        });
        $validator->sometimes('communicate_method', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'lesson')
                    ->first()->id;
        });
        $validator->sometimes('language_id', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'lesson')
                    ->first()->id;
        });
        
        // Заявка на менторство
        $validator->sometimes('mentor_tag_id', 'required|array', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'mentoring')
                    ->first()->id;
        });
        $validator->sometimes('category_id', 'required|integer', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'mentoring')
                    ->first()->id;
        });
        $validator->sometimes('communicate_method', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'mentoring')
                    ->first()->id;
        });
        $validator->sometimes('language_id', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'mentoring')
                    ->first()->id;
        });
        $validator->sometimes('timezone', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'mentoring')
                    ->first()->id;
        });
        $validator->sometimes('resume', 'nullable|max:8192', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'mentoring')
                    ->first()->id;
        });
        
        // Заявка компании
        $validator->sometimes('law_name', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'company')
                    ->first()->id;
        });
        $validator->sometimes('inn', 'required', function ($input) {
            return $input->app_type == ApplicationType::where('short_code', 'company')
                    ->first()->id;
        });
        return $validator;
    }
    
}
