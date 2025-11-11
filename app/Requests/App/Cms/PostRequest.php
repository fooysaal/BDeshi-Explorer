<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
                        'title' => 'required|unique:' . Post::getTableName() . ',title',
						'featureImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
						'bannerImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                            'title' => 'required|unique:' . Post::getTableName() . ',title,' . $this->post->id,
							'featureImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
							'bannerImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
