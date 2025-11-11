<?php

namespace App\Repositories\App\Cms;

use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\Repositories\Repository;
use App\Models\App\Cms\PostCategory;
use Illuminate\Database\Eloquent\Model;

class PostCategoryRepository extends Repository
{
    public function all()
    {
        return PostCategory::withTrashed()->orderBy('created_at', 'desc')->get();
    }

    public function create(Request $request)
    {
        $postCategory = new PostCategory();

        $categoryName= $request->name;

        $postCategory->parent_id = $request->parent_id;
        $postCategory->name = $categoryName;
        $postCategory->code = $request->code;
        $postCategory->display_name = $request->display_name;
        $postCategory->display_order = $request->display_order;
        $postCategory->description = $request->description;
        $postCategory->slug = str_slug($categoryName);

        if ($request->hasFile('categoryImage')) {
			$postCategory->image = FileUploader::uploadSingleFile($request->file('categoryImage'), 'posts-images');
		}

        $postCategory->is_active = 1;
        $postCategory->save();
    }

    public function update(Request $request, Model $model)
    {
        $statusButtonKey = config('app-view.statusButton.name');

        if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
            return $this->changeStatus($model);
        }

        $categoryName = $request->name;

        $model->parent_id = $request->parent_id;
        $model->name = $categoryName;
        $model->code = $request->code;
        $model->display_name = $request->display_name;
        $model->display_order = $request->display_order;
        $model->description = $request->description;
        $model->slug = str_slug($categoryName);
        $model->is_active = 1;

        if ($request->hasFile('categoryImage')) {
            fileExistAndDelete($model->image, 'posts-images');
            $model->image = FileUploader::uploadSingleFile($request->file('categoryImage'), 'posts-images');
        }

        $model->update();
    }


    public function findById($id)
    {
    }
}
