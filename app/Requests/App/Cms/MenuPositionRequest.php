<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\MenuPosition;
use Illuminate\Foundation\Http\FormRequest;

class MenuPositionRequest extends FormRequest
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
                        'name' => 'required|max:100|unique:' . MenuPosition::getTableName() . ',name',
                        'alias' => 'nullable|max:100|unique:' . MenuPosition::getTableName() . ',alias',
                        'code' => 'nullable|max:50|unique:' . MenuPosition::getTableName() . ',code',
                        // 'testimonial' => 'required',
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
                            'name' => 'required|max:100|unique:' . MenuPosition::getTableName() . ',name,' . $this->menu_position->id,
                            'alias' => 'nullable|max:100|unique:' . MenuPosition::getTableName() . ',alias,' . $this->menu_position->id,
                            'code' => 'nullable|max:50|unique:' . MenuPosition::getTableName() . ',code,' . $this->menu_position->id,
                            // 'person_name' => 'required',
                        ];
                    }
                }
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'name.unique' => 'Name has already been taken!',
            'alias.unique' => 'Display Name has already been taken!',
            'code.unique' => 'Code has already been taken!',
        ];
    }
}
