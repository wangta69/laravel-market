<?php

namespace App\Models\Market\Auth\User\Traits\Relations;

// use App\Models\Auth\Permission\Permission;
use App\Models\Market\Auth\Role\Role;
use App\Models\Market\Auth\User\SocialAccount;
use App\Models\Market\Auth\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait SocialAccountRelations
{
  /**
   * @return BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
