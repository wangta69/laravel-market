<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketCoupon extends Model
{
  use SoftDeletes;
  const UPDATED_AT = null;
}

