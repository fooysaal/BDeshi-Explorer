<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\PostCategory;
use Illuminate\Foundation\Http\FormRequest;

class PostCategoryRequest extends FormRequest
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
                        'name' => 'required',
                        'code' => 'max:50',
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
                            'name' => 'required|unique:' . PostCategory::getTableName() . ',name,' . $this->post_category->id,
                            'code' => 'max:50',
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
        ];
    }
}
