<?php

namespace App\Models\Site\Member;

use App\Models\User;
use App\Models\BaseModel;
use App\Traits\CommonScopes;
use App\Traits\CommonEventObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpTicketReply extends BaseModel
{
	use CommonEventObserver, CommonScopes, SoftDeletes;

  /**
   * Get the author that owns the HelpTicketReply
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function author(): BelongsTo
  {
		return $this->belongsTo(User::class, 'created_by')->with('userType');
  }
}
