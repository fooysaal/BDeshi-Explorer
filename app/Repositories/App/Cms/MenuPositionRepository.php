<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\MenuPosition;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MenuPositionRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return MenuPosition::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$menuPosition = new MenuPosition;
		$menuPosition->name = $request->name;
		$menuPosition->alias = $request->alias;
		$menuPosition->code = $request->code;
		$menuPosition->description = $request->description;
		// $menu->slug = str_slug($menuTitle);
		$menuPosition->is_active = 1;
		$menuPosition->is_default = 1;

		$menuPosition->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->name = $request->name;
		$model->alias = $request->alias;
		$model->code = $request->code;
		$model->description = $request->description;
		// $model->slug = str_slug($menuTitle);
		$model->is_active = 1;
		$model->is_default = 1;

		$model->update();
	}

	public function findById($id)
	{
	}
}
