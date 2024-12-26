<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateMarketCoupon extends Migration
{
/**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    if (!Schema::hasTable('market_coupons')) {
      Schema::create('market_coupons', function(BluePrint $table) {
        $table->id();
        $table->string('title', '50')->comment('쿠폰명');
        $table->string('apply_type', '20')->comment('category, product, or all(카테고리별, 상품별, 전체)');
        $table->bigInteger('item_id')->unsigned()->nullable()->comment('apply_type.product 일 경우 적용 상품코드');
        $table->string('category', '12')->nullable()->comment('apply_type.category 일 경우 적용 카테고리');
        $table->integer('min_price')->default(0)->unsigned()->comment('최소결제 금액');
        $table->string('apply_amount_type', '10')->comment('price | percent');
        $table->integer('price')->nullable()->unsigned()->comment('apply_amount_type.price');
        $table->float('percentage')->nullable()->unsigned()->comment('apply_amount_type.percent');
        $table->integer('percentage_max_price')->nullable()->unsigned()->comment('apply_amount_type.percent 일경우 최대 할인금액');
        $table->timestamp('created_at')->comment('생성일');
        $table->softDeletes();
      });
    }

    if (!Schema::hasTable('market_coupon_issues')) {
      Schema::create('market_coupon_issues', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->unsigned()->comment('주문자아이디');
        $table->bigInteger('coupon_id')->unsigned()->index()->comment('쿠폰 아이디');
        $table->timestamp('created_at')->comment('발급일');
        $table->timestamp('expired_at')->comment('사용종료일(유효기간 만료일)');
        $table->timestamp('used_at')->comment('사용일');
      });
    }

    if (!Schema::hasColumn('market_payments', 'coupon_issue_id')) {
      Schema::table('market_payments', function (Blueprint $table) {
        $table->bigInteger('coupon_issue_id')->nullable()->unsigned()->comment('사용한 쿠폰 아이디')->after('amt_delivery');
      });
    }

    if (!Schema::hasColumn('market_payments', 'amt_coupon')) {
      Schema::table('market_payments', function (Blueprint $table) {
        $table->bigInteger('amt_coupon')->nullable()->unsigned()->comment('쿠폰 사용 금액')->after('coupon_issue_id');
      });
    }
    
  }

  public function down()
  {
    Schema::dropIfExists('market_coupons');
    Schema::dropIfExists('market_coupon_issues');
  }
}