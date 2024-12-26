<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateBanner extends Migration
{
/**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    if (!Schema::hasTable('market_banners')) {
      Schema::create('market_banners', function(BluePrint $table) {
        $table->id();
        $table->string('position', '50')->nullable()->comment('베너위치값');
        $table->string('image')->nullable()->comment('이미지');
        $table->string('title', '50')->nullable()->comment('베너타이틀');
        $table->string('description')->nullable()->comment('베너설명');
        $table->string('url')->nullable()->comment('베너 링크');
        $table->timestamps();
        $table->softDeletes();
      });
    }
  }


  public function down()
  {
    Schema::dropIfExists('market_banners');
  }
}