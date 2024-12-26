<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateMarketDetail extends Migration
{
/**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    if (!Schema::hasTable('market_item_specs')) {
      Schema::create('market_item_specs', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('item_id')->unsigned()->index();
        $table->string('title', '20')->nullable()->comment('추가 title');
        $table->string('comment', '50')->nullable()->comment('추가 설명');
        $table->timestamps();
        $table->softDeletes();
      });
    }
    
  }


  public function down()
  {
    Schema::dropIfExists('market_item_details');
  }
}