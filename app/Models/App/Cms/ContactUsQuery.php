<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Models\App\Cms\ContactUsReply;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUsQuery extends BaseModel
{
    use CommonEventObserver;
    use SoftDeletes;

    protected $table = 'contact_us_queries';
    protected $fillable = ['message_form','name','designation', 'email','mobile', 'date_and_time','address','subject','attachment', 'query_message','query_notes'];
    
    
    public function contactUsReplies()
    {
        return $this->hasMany(ContactUsReply::class, 'contact_us_query_id');
    }


}
