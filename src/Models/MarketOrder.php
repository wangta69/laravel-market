<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketOrder extends Model
{
  use SoftDeletes;
}
