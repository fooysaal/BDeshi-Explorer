<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\SocialNetworkingMedia;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SocialNetworkingMediaRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return SocialNetworkingMedia::orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$socialNetworkingMedia = new SocialNetworkingMedia;
		$socialNetworkingMedia->name = $request->name;
		$socialNetworkingMedia->description = $request->description;
		// $menu->slug = str_slug($menuTitle);
		$socialNetworkingMedia->is_active = 1;
		
		if ($request->hasFile('defaultIcon')) {
			$socialNetworkingMedia->default_icon = FileUploader::uploadSingleFile($request->file('defaultIcon'), 'social-networking-medias');;
		}

		$socialNetworkingMedia->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->name = $request->name;
		$model->description = $request->description;
		// $model->slug = str_slug($menuTitle);
		$model->is_active = 1;
		
		if ($request->hasFile('defaultIcon')) {
			fileExistAndDelete($model->default_icon, 'social-networking-medias');
			$model->default_icon = FileUploader::uploadSingleFile($request->file('defaultIcon'), 'social-networking-medias');;
		}

		$model->update();
	}

	public function findById($id)
	{
	}
}
