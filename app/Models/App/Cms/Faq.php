<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    public function faqCategory()
    {
      return $this->belongsTo('App\Models\App\Cms\FaqCategory', 'faq_category_id');
    }

    public function getNameAttribute()
    {
    	// dd($this->faqCategory);
        return optional($this->faqCategory)->name;
    }
}
