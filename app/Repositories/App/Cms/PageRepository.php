<?php

namespace App\Repositories\App\Cms;

use Illuminate\Support\Str;
use App\Models\App\Cms\Page;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class PageRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return Page::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$page = new Page;
		$page->page_template_id = $request->page_template_id;
		$pageTitle = $request->title;
		$page->title = $pageTitle;
		$page->contents = $request->contents;
		$page->excerpt = $request->excerpt;
		$page->publish_from = $request->publish_from;
		$page->publish_to = $request->publish_to;
		$page->seo_detail = $request->seo_detail;
		$page->slug = str_slug($pageTitle);
		$page->is_active = 1;
		$page->is_noindex = 1;
		$page->is_public = 1;

		if ($request->hasFile('featureImage')) {
			$page->featured_image = FileUploader::uploadSingleFile($request->file('featureImage'), 'pages');
		}

		if ($request->hasFile('bannerImage')) {
			$page->banner_image = FileUploader::uploadSingleFile($request->file('bannerImage'), 'pages');
		}

		$page->save();
	}

	public function update(Request $request, Model $model)
	{
		// For Status Update as toggle field
	    $statusButtonKey = config('app-view.statusButton.name');

	    // Handle status change action
	    if (isset($request->$statusButtonKey) && $request->$statusButtonKey === config('app-view.statusButton.value')) {
	        return $this->changeStatus($model);
	    }



	    // For update form
	    $model = updateModelAttributes($model, [
		    'page_template_id',
		    'title',
		    'contents',
		    'excerpt',
		    'publish_from',
		    'publish_to',
		    'seo_detail',
		   // 'is_active',
		   // 'is_noindex',
		   // 'is_public'
		], $request);

		$model->contents = $request->contents;
		$model->excerpt = $request->excerpt;

		//dd($model);

		try {
		    // Handle file uploads
		    if ($request->hasFile('featureImage')) {
		        fileExistAndDelete($model->featured_image, 'pages');
		        $model->featured_image = FileUploader::uploadSingleFile($request->file('featureImage'), 'pages');
		    }

		    if ($request->hasFile('bannerImage')) {
		        fileExistAndDelete($model->banner_image, 'pages');
		        $model->banner_image = FileUploader::uploadSingleFile($request->file('bannerImage'), 'pages');
		    }
		} catch (\Exception $e) {
		    // Log the error and handle it appropriately
		    logger('File upload failed: ' . $e->getMessage());
		    return back()->withErrors(['file' => 'File upload failed.']);
		}

	    // Update only if there are changes
	    if ($model->isDirty()) { // isDirty checks if any field has changed
	        $model->save();
	    }
	}


	public function findById($id)
	{
	}
}
