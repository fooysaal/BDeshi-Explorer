<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\Menu;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MenuRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return Menu::withTrashed()->orderBy('created_at', 'desc')->get();
	}

	public function create(Request $request)
	{
		$menu = new Menu;
		$menu->menu_position_id = $request->menu_position_id;
		$menu->parent_id = $request->parent_id;
		$menuTitle = $request->title;
		$menu->title = $menuTitle;
		$menu->display_name = $request->display_name;
		$menu->page_id = $request->page_id;
		$menu->url = $request->url;
		$menu->display_order = $request->display_order;
		$menu->description = $request->description;
		$menu->slug = str_slug($menuTitle);
		$menu->is_active = $request->is_active ?? 0;
		$menu->open_in_newtab = $request->open_in_newtab ?? 0;

		$menu->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->menu_position_id = $request->menu_position_id;
		$model->parent_id = $request->parent_id;
		$menuTitle = $request->title;
		$model->title = $menuTitle;
		$model->display_name = $request->display_name;
		$model->page_id = $request->page_id;
		$model->url = $request->url;
		$model->display_order = $request->display_order;
		$model->description = $request->description;
		$model->slug = str_slug($menuTitle);
		$model->is_active = $request->is_active ?? 0;
		$model->open_in_newtab = $request->open_in_newtab ?? 0;

		$model->update();
	}

	public function findById($id)
	{
	}
}
