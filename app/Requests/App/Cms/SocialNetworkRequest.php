<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\SocialNetwork;
use Illuminate\Foundation\Http\FormRequest;

class SocialNetworkRequest extends FormRequest
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
                        'social_networking_media_id' => 'required',
                        'url' => 'required|unique:' . SocialNetwork::getTableName() . ',url',
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
                            'social_networking_media_id' => 'required',
                            'url' => 'required|unique:' . SocialNetwork::getTableName() . ',url,' . $this->social_network->id,
                        ];
                    }
                }
        }
    }

    public function messages()
    {
        return [
            'url.required' => 'Url is required!',
            'url.unique' => 'Url has already been taken!',
            'social_networking_media_id.required' => 'Name is required!',
        ];
    }
}
