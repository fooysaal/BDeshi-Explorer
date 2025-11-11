<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    // mutator
    public function setOrderAttribute($value)
    {

        if (isset($value)) {
            $this->attributes['order'] = $value;
        } else {

            $this->attributes['order'] = 0;
        }
    }

    public function setFeedbackScoreAttribute($value)
    {
        if (isset($value)) {
            $this->attributes['feedback_score'] = $value;
        } else {
            $this->attributes['feedback_score'] = 0;
        }
    }
}
