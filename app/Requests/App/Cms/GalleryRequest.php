<?php

namespace App\Http\Requests\App\Cms;

use App\Models\App\Cms\Gallery;
use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
			case 'DELETE': {
					return [];
				}
			case 'POST': {
					return [
						'name' => 'required|max:255|unique:' . Gallery::getTableName() . ',name',
						'galleryImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
					];
				}
			case 'PUT':
			case 'PATCH': {
					$statusButtonKey = config('app-view.statusButton.name');
					if ($this->$statusButtonKey === config('app-view.statusButton.value')) {
						return [];
					} else {
						return [
							'name' => 'required|max:255|unique:' . Gallery::getTableName() . ',name,' . $this->id,
							'galleryImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
						];
					}
				}
		}
	}

	public function messages()
	{
		return [
			'name.required' => 'Name is required!',
		];
	}
}
