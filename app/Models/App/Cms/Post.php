<?php

namespace App\Models\App\Cms;

use App\Models\App\Cms\PostCategory;
use App\Models\App\Inventory\Tag;
use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    // public function postCategory()
    // {
    //   return $this->belongsTo('App\Models\App\Cms\PostCategory', 'post_category_id');
    // }
    
    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }


    public function getTemplateNameAttribute()
    {
        return optional($this->postCategory)->name;
    }


    //MUTATOR
    
    public function setPublishFromAttribute($value)
    {
        if ($value === null) {
            $this->attributes['publish_from'] = null;
        } else {
            $this->attributes['publish_from'] = date("Y-m-d", strtotime($value));
        }
    }

    public function setPublishToAttribute($value)
    {
        if ($value === null) {
            $this->attributes['publish_to'] = null;
        } else {
            $this->attributes['publish_to'] = date("Y-m-d", strtotime($value));
        }
    }

}
