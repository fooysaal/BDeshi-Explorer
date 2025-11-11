<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
// use App\Models\App\Cms\Gallery;
use App\Models\App\Cms\GalleryImage;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GalleryImageRepository extends Repository
{

	public function all()
	{
		return GalleryImage::withTrashed()->orderBy('created_at', 'desc')->get();
	}

	public function create(Request $request)
	{

		if ($request->hasFile('galleryImages')) {
			$formFiles = $request->file('galleryImages');
			$data = [];
			foreach ($formFiles as $formFile) {
				$data[] = [
					'image' =>  FileUploader::uploadSingleFile($formFile, 'gallery-images'),
					'galleries_id' => $request->galleries_id,
					'created_by' => auth()->user()->id,
					'created_at' => now(),
					'updated_at' => now(),
				];
			}

			GalleryImage::insert($data);
		}
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->title = $request->title;
		$model->display_order = $request->display_order;
		$model->description = $request->description;
		// $model->resize_dimensions = $this->generateResizeDimensions();
		$model->created_by = auth()->user()->id;
		$model->is_active = $request->is_active ? 1 : 0;

		if ($request->hasFile('galleryImage')) {
			fileExistAndDelete($model->image, 'gallery-images');
			$model->image = FileUploader::uploadSingleFile($request->file('galleryImage'), 'gallery-images');
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

	public function findById($id)
	{
	}
}
