<?php

namespace App\Http\Requests\App\Cms;

use Illuminate\Foundation\Http\FormRequest;

class PageTemplateRequest extends FormRequest
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
                        // 'title' => 'required|unique:' . Menu::getTableName() . ',title',
                        'name' => 'required|max:255',
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
                            // 'title' => 'required|unique:' . Menu::getTableName() . ',title,' . $this->menu->id,
                            'name' => 'required|max:255',
                        ];
                    }
                }
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            // 'title.unique' => 'Title has already been taken!',
        ];
    }
}
