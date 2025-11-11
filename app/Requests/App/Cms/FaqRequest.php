<?php

namespace App\Http\Requests\App\Cms;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        // 'name' => 'required|unique:' . Testimonial::getTableName() . ',name',
                        // 'code' => 'nullable|unique:' . Testimonial::getTableName() . ',code',
                        'question' => 'required',
                        'answer' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    $statusButtonKey = config('app-view.statusButton.name');
                    if ($this->$statusButtonKey === config('app-view.statusButton.value')) {
                        return [];
                    }else{
                        return [
                            // 'name' => 'required|unique:' . Testimonial::getTableName() . ',name,' . $this->company_type->id,
                            // 'code' => 'nullable|unique:' . Testimonial::getTableName() . ',code,' . $this->company_type->id,
                            'question' => 'required',
                            'answer' => 'required',
                        ];
                    }
                }
        }
    }

    public function messages()
    {
        return [
            'question.required' => 'Question is required!',
            'answer.required' => 'Answer is required!',
        ];
    }
}
