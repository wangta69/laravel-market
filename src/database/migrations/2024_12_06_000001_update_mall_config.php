<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  UpdateMallConfig extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (Schema::hasTable('json_key_values')) {
      DB::table('json_key_values')->updateOrInsert(
        ['key' => 'company'],['v' => '{"name":"\uc628\uc2a4\ud1a0\ub9ac\ubab0","businessNumber":"xxx-xx-xxxxx","mailOrderSalesRegistrationNumber":"\uc81cxxxx-\uc11c\uc6b8\uac15\ub0a8-xxxx\ud638","address":"\uc11c\uc6b8\ud2b9\ubcc4\uc2dc \uac15\ub0a8\uad6c \uba4b\uc9c4\ube4c\ub529 1F","representative":"\uae40\uc7ac\ubc8c","tel1":"02-xxxx-xxxx","fax1":"02-yyyy-yyyy"}']
      );
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {   
  }
}
