<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    public function pageTemplate()
    {
      return $this->belongsTo('App\Models\App\Cms\PageTemplate', 'page_template_id');
    }

    public function getTemplateNameAttribute()
    {
        return optional($this->pageTemplate)->name;
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

    // ACCESSORS
    // for date formate change
    // public function getPublishFromAttribute()
    // {
    //     return date("d-m-Y", strtotime($this->attributes['publish_from']));
    // }

    // public function getPublishToAttribute()
    // {
    //     return date("d-m-Y", strtotime($this->attributes['publish_to']));
    // }
}
