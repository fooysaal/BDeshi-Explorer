<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\FaqCategory;
use Illuminate\Foundation\Http\FormRequest;

class FaqCategoryRequest extends FormRequest
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
                        'name' => 'required|max:100|unique:' . FaqCategory::getTableName() . ',name',
                        'code' => 'max:50',
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
                            'name' => 'required|max:100|unique:' . FaqCategory::getTableName() . ',name,' . $this->faq_category->id,
                            'code' => 'max:50',
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
        ];
    }
}
