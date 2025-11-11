<?php

namespace App\Models\Site\Member;

use App\Models\User;
use App\Models\BaseModel;
use App\Traits\CommonScopes;
use App\Traits\CommonEventObserver;
use App\Models\Site\Member\HelpTicketType;
use App\Models\Site\Member\HelpTicketReply;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Site\Member\HelpTicketCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpTicket extends BaseModel
{
  use CommonEventObserver, CommonScopes, SoftDeletes;

  public function helpTicketType(): BelongsTo
  {
    return $this->belongsTo(HelpTicketType::class, 'help_ticket_type_id');
  }

  public function helpTicketCategory(): BelongsTo
  {
    return $this->belongsTo(HelpTicketCategory::class, 'help_ticket_category_id');
  }

	public function author(): BelongsTo
  {
		return $this->belongsTo(User::class, 'created_by');
  }

  public function replies()
  {
    return $this->hasMany(HelpTicketReply::class, 'help_ticket_id');
  }
}
