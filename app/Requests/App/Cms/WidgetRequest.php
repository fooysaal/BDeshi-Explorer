<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\Widget;
use Illuminate\Foundation\Http\FormRequest;

class WidgetRequest extends FormRequest
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
                    'title' => 'required|unique:' . Widget::getTableName() . ',title',
                    'contents' => 'required',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                $statusButtonKey = config('app-view.statusButton.name');
                if ($this->$statusButtonKey === config('app-view.statusButton.value')) {
                    return [];
                } else {
                    $rules = [
                        'contents' => 'required',
                    ];
                    if ($this->has('title')) {
                        $rules['title'] = 'required|unique:' . Widget::getTableName() . ',title,' . $this->widget->id;
                    }
                    return $rules;
                }
            }
    }
}


    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.unique' => 'Title has already been taken!',
            'contents.required' => 'Content is required!',
        ];
    }
}
