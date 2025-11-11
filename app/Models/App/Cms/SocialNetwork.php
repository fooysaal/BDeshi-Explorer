<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialNetwork extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    public function socialNetworkingMedia()
    {
      return $this->belongsTo('App\Models\App\Cms\SocialNetworkingMedia', 'social_networking_media_id');
    }

    public function getMediaNameAttribute()
    {
    	// dd($this->faqCategory);
        return optional($this->socialNetworkingMedia)->name;
    }
}
