<?php

namespace App\Http\Requests\App\Cms;

use Illuminate\Foundation\Http\FormRequest;

class GalleryImageUpdateRequest extends FormRequest
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
		return [
			'galleryImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
		];
	}
}
