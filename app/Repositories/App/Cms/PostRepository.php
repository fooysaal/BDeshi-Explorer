<?php

namespace App\Repositories\App\Cms;

use Illuminate\Support\Str;
use App\Models\App\Cms\Post;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return Post::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$post = new Post;
		$post->post_category_id = $request->post_category_id;
		$postTitle = $request->title;
		$post->title = $postTitle;
		$post->contents = $request->contents;
		$post->excerpt = $request->excerpt;
		$post->publish_from = $request->publish_from;
		$post->publish_to = $request->publish_to;
		$post->seo_detail = $request->seo_detail;
		$post->slug = str_slug($postTitle);
		$post->is_active = 1;
		$post->is_noindex = 1;
		$post->is_public = 1;

		if ($request->hasFile('featureImage')) {
			$post->featured_image = FileUploader::uploadSingleFile($request->file('featureImage'), 'posts-images');
		}

		if ($request->hasFile('bannerImage')) {
			$post->banner_image = FileUploader::uploadSingleFile($request->file('bannerImage'), 'posts-images');
		}

		$post->save();

		// Tags
		$tags = $request->tags;
		if (isset($tags) && count($tags)) {
			$post->tags()->sync($tags);
		}
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
		    'post_category_id',
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

		if($request->has('title')) {
			$model->slug = Str::slug($request->title);
		}

	    // Handle file uploads
	    if ($request->hasFile('featureImage')) {
	        fileExistAndDelete($model->featured_image, 'posts-images');
	        $model->featured_image = FileUploader::uploadSingleFile($request->file('featureImage'), 'posts-images');
	    }

	    if ($request->hasFile('bannerImage')) {
	        fileExistAndDelete($model->banner_image, 'posts-images');
	        $model->banner_image = FileUploader::uploadSingleFile($request->file('bannerImage'), 'posts-images');
	    }

		$tags = $request->tags;
		if (isset($tags) && count($tags)) {
			$model->tags()->sync($tags, true);
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
