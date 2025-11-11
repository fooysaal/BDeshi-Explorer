<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\Gallery;
use App\Models\App\Cms\GalleryImage;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GalleryRepository extends Repository
{

	public function all()
	{
		return Gallery::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	public function create(Request $request)
	{
		$gallery = new Gallery;
		$gallery->name = $request->name;
		$gallery->display_order = $request->display_order;
		$gallery->description = $request->description;
		$gallery->resize_dimensions = $this->generateResizeDimensions();
		$gallery->is_active = 1;

		if ($request->hasFile('galleryImage')) {
			$gallery->image = FileUploader::uploadSingleFile($request->file('galleryImage'), 'galleries');
		}

		$gallery->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->name = $request->name;
		$model->display_order = $request->display_order;
		$model->description = $request->description;
		$model->resize_dimensions = $this->generateResizeDimensions();
		$model->is_active = 1;

		if ($request->hasFile('galleryImage')) {
			fileExistAndDelete($model->image, 'galleries');
			$model->image = FileUploader::uploadSingleFile($request->file('galleryImage'), 'galleries');
		}

		$model->update();
	}




	private function generateResizeDimensions()
	{
		$resizeDimension = [];
		if (request()->width || request()->height) {
			$resizeDimension['width'] = request()->width;
			$resizeDimension['height'] = request()->height;
			$resizeDimension['aspect_ratio'] = request()->aspect_ratio;
		}

		if (count($resizeDimension) > 0) {
			return json_encode($resizeDimension);
		}

		return null;
	}

	public function getGalleryImagesByGalleryId($id){
		return GalleryImage::ascending('display_order')->where('galleries_id', $id)->get();
	}

	public function findById($id)
	{
	}
}
