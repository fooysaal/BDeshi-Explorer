<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    public function galleryImages()
    {
        return $this->hasMany('App\Models\App\Cms\GalleryImage', 'galleries_id');
    }


    // accessors
    public function getWidthAttribute()
    {
        if (!isset($this->resize_dimensions)) {
            return null;
        }

        $resizeDimensions = json_decode($this->resize_dimensions);
        return $resizeDimensions->width;
    }

    public function getHeightAttribute()
    {
        if (!isset($this->resize_dimensions)) {
            return null;
        }

        $resizeDimensions = json_decode($this->resize_dimensions);
        return $resizeDimensions->height;
    }

    public function getAspectRatioAttribute()
    {
        if (!isset($this->resize_dimensions)) {
            return null;
        }

        $resizeDimensions = json_decode($this->resize_dimensions);
        if ($resizeDimensions->aspect_ratio === "true") {
            return true;
        } else {
            return false;
        }
    }
}
