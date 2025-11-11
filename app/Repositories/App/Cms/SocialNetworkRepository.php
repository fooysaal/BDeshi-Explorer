<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\SocialNetwork;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SocialNetworkRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return SocialNetwork::withTrashed()->orderBy('created_at', 'desc')->get();
	}

	public function create(Request $request)
	{
		$socialNetwork = new SocialNetwork;
		$socialNetwork->social_networking_media_id = $request->social_networking_media_id;
		$socialNetwork->url = $request->url;
		$socialNetwork->order = $request->order;
		$socialNetwork->icon_image = $request->iconImage;
		// $menu->slug = str_slug($menuTitle);
		$socialNetwork->is_active = 1;

		// if ($request->hasFile('iconImage')) {
		// 	$socialNetwork->icon_image = FileUploader::uploadSingleFile($request->file('iconImage'), 'social-networks');;
		// }

		$socialNetwork->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->social_networking_media_id = $request->social_networking_media_id;
		$model->url = $request->url;
		$model->order = $request->order;
		// $model->slug = str_slug($menuTitle);
		$model->icon_image = $request->iconImage;
		$model->is_active = 1;

		// if ($request->hasFile('iconImage')) {
		// 	fileExistAndDelete($model->icon_image, 'social-networks');
		// 	$model->icon_image = FileUploader::uploadSingleFile($request->file('iconImage'), 'social-networks');;
		// }

		$model->update();
	}

	public function findById($id)
	{
	}
}
