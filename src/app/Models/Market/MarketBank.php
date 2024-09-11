<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketBank extends Model
{
  use SoftDeletes;
  // protected $table = 'market_buyer';
  // protected $primaryKey = 'DB_num';
  // protected $fillable = ['o_id']; 
  // const UPDATED_AT = null;
}
