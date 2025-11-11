<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\Menu;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
                        'title' => 'required|max:100|unique:' . Menu::getTableName() . ',title',
                        'display_name' => 'max:100',
                        'url' => 'max:200',
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
                            'title' => 'required|unique:' . Menu::getTableName() . ',title,' . $this->menu->id,
                            'display_name' => 'max:100',
                            'url' => 'max:200',
                            // 'person_name' => 'required',
                        ];
                    }
                }
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.unique' => 'Title has already been taken!',
        ];
    }
}
