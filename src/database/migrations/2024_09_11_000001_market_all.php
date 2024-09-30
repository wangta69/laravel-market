<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class MarketAll extends Migration
{
/**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    if (!Schema::hasTable('market_addresses')) {
      Schema::create('market_addresses', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->unsigned()->index();
        $table->string('name', '30');
        $table->string('tel1', '20');
        $table->tinyInteger('default')->default(0)->unsigned()->comment('1: 기본주소');
        $table->string('zip', '6');
        $table->string('addr1', '50');
        $table->string('addr2', '50')->nullable();
        $table->string('message', '200')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
    }
    
    if (!Schema::hasTable('market_banks')) {
      Schema::create('market_banks', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->unsigned();
        $table->string('type', '10')->nullable()->comment('manager, user');
        $table->string('code', '3')->nullable()->comment('은행코드');
        $table->string('no', '20')->nullable()->nullable()->comment('은행 계좌번호');
        $table->string('owner', '20')->nullable()->comment('은행 계좌 소유주');
        $table->timestamps();
        $table->softDeletes();
      });
    }
    

    if (!Schema::hasTable('market_buyers')) {
      Schema::create('market_buyers', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned()->comment('주문자아이디');
        $table->string('o_id', '20')->unique()->comment('주문번호 market_orders.o_id');
        $table->string('name', '30')->nullable()->comment('받을 분 성함');
        $table->string('email', '50')->nullable()->comment('주문자이메일(비회원시)');
        $table->string('tel1', '20')->nullable()->comment('받을 분 연락처');
        $table->string('zip', '6');
        $table->string('addr1', '50')->comment('수신자 주소1');
        $table->string('addr2', '50')->nullable()->comment('수신자 주소2');
        $table->string('message', '200')->nullable()->comment('주문자 입력 메시지');
        $table->string('courier', '10')->nullable()->comment('배송업체코드');
        $table->string('invoice_no', '20')->nullable()->comment('송장번호(택배번호)');
        $table->tinyInteger('delivery_status')->nullable()->unsigned()->comment('0: 배송대기, 10: 배송중,  30: 배송완료, 40: 주문취소, 50: 반품, 60:교환, 70: 교환완료');
        $table->timestamps();
      });
    }
    


    if (!Schema::hasTable('market_carts')) {
      Schema::create('market_carts', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->bigInteger('c_id')->unsigned()->index()->comment('카트 아이디');
        $table->bigInteger('item_id')->unsigned()->index()->comment('제품코드 market_items.id');
        $table->smallInteger('qty')->default(0)->unsigned()->comment('구매갯수');
        $table->bigInteger('item_price')->default(0)->unsigned()->comment('제품단가');
        $table->bigInteger('option_price')->default(0)->unsigned()->comment('제품옵션단가');
        $table->bigInteger('point')->default(0)->unsigned()->comment('개당 적립포인트');
        $table->string('options', '200')->nullable()->comment('옵션정보입력//flag::옵션명::옵션값::옵셔가격||";');
        $table->timestamp('created_at');
      });
    }
    


    if (!Schema::hasTable('market_categories')) {
      Schema::create('market_categories', function(BluePrint $table) {
        $table->id();
        $table->string('category', '15')->unique()->comment('3자리씩 1차/2차/3차...분류');
        $table->string('name', '30')->comment('카테고리명');
        $table->tinyInteger('order')->default(0)->unsigned()->comment('카테고리 순서');
        $table->string('flag', '20')->nullable()->comment('카테고리flag (삭제)');
        $table->integer('price')->default(0)->comment('카테고리별 차등 가격');
        $table->string('skin', '30')->nullable()->comment('카테고리별 제품리스트 스킨');
        $table->string('skin_viewer', '30')->nullable()->comment('카테고리별 제품 viewer 스킨');
        $table->mediumText('html_top')->nullable()->comment('카테고리별 top 코딩');
        $table->mediumText('html_bottom')->nullable()->comment('카테고리별 bottom 코딩');
        $table->string('image', '500')->nullable()->comment('카테고리별 이미지');
        $table->smallInteger('pcnt')->default(0)->unsigned()->comment('카테고리별 제품등록수');
        $table->timestamps();
      });
    }
    


    if (!Schema::hasTable('market_configs')) {
      Schema::create('market_configs', function(BluePrint $table) {
        $table->string('key', '20');
        $table->text('value');
      });
    }
    


    // if (!Schema::hasTable('market_delivery_companies')) {
    //   Schema::create('market_delivery_companies', function(BluePrint $table) {
    //     $table->id();
    //     $table->string('code', '20')->nullable()->comment('택배사코드');
    //     $table->string('name', '20')->nullable()->comment('택배사명');
    //     $table->string('url', '100')->nullable()->comment('택배사 url');
    //     $table->string('query_url', '100')->nullable()->comment('배송조회url');
    //   });
    // }


    if (!Schema::hasTable('market_exchange_returns')) {
      Schema::create('market_exchange_returns', function(BluePrint $table) {
        $table->id();
        $table->string('type', '10')->comment('refund | exchange');
        $table->string('issue_id', '20');
        $table->tinyInteger('status')->default(0)->unsigned();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->bigInteger('order_id')->unsigned()->index()->comment('market_orders.id');
        $table->bigInteger('item_id')->unsigned()->comment('제품코드 market_items.id');
        $table->smallInteger('qty')->default(0)->unsigned()->comment('구매갯수');
        $table->bigInteger('item_price')->default(0)->unsigned()->comment('제품단가');
        $table->bigInteger('option_price')->default(0)->unsigned()->comment('제품옵션단가');
        $table->bigInteger('point')->default(0)->unsigned()->comment('적립포인트');
        $table->string('options', '200')->nullable()->comment('market_item_options.id | market_item_options.id |');
        $table->string('courier', '10')->nullable()->comment('(개별배송시) 각각의 제품에 대한 배송업체');
        $table->string('invoice_no', '200')->nullable()->comment('(개별배송시) 각각의 제품에 대한 송장번호');
        $table->tinyInteger('delivery_status')->default(0)->unsigned()->comment('(개별배송시) 각각의 제품에 대한 주문상태(앞으로 카트는 단순히 장바구니만을 처리하고 동일한 항목으로 orders등을 별도촐 처리)');
        $table->string('contact', '20')->comment('연락처');
        $table->text('reason')->comment('반품 혹은 교환이유');
        $table->text('memo')->nullable()->comment('관리자 메모');
        $table->timestamps();
        $table->softDeletes();
      });
    }
    


    if (!Schema::hasTable('market_items')) {
      Schema::create('market_items', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('shop_id')->nullable()->unsigned()->comment('등록자 아이디(이후 mall in mall 확장을 위해)');
        $table->string('category', '12')->nullable()->comment('대표카테고리');
        $table->string('name', '50')->nullable()->comment('상품명');
        $table->string('brand', '50')->nullable()->comment('브랜드');
        $table->string('model', '50')->nullable()->comment('모델');
        $table->integer('price')->default(0)->unsigned()->comment('판매가격(sales price)');
        $table->integer('cost')->default(0)->unsigned()->comment('원가(cost)');
        $table->mediumInteger('t_point')->default(0)->unsigned()->comment('제품별 지급 포인트');
        $table->string('image', '255')->nullable()->comment('대표이미지(기타이미지는 별도로 처리)');
        $table->tinyInteger('sell_cnt')->default(0)->unsigned()->comment('총판매수량');
        $table->smallInteger('stock')->default(-1)->comment('-1: 무제한, 0: 품절, 기타');
        $table->string('shorten_description', '500')->nullable()->comment('간략 제품설명');
        $table->text('description')->nullable()->comment('제품설명');
        $table->timestamps();
        $table->softDeletes();
        $table->fullText(['name', 'shorten_description', 'description', 'model']);
      });
    }


    if (!Schema::hasTable('market_item_categories')) {
      Schema::create('market_item_categories', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('item_id')->unsigned()->index()->comment('items.id');
        $table->string('category', '12')->nullable()->comment('');
        $table->tinyInteger('order')->default(0)->unsigned()->comment('');
        $table->timestamps();
        $table->softDeletes();
      });
    }


    if (!Schema::hasTable('market_item_displays')) {
      Schema::create('market_item_displays', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('item_id')->unsigned()->comment('items.id');
        $table->string('name', '30')->nullable()->comment('');
        $table->tinyInteger('order')->default(0)->unsigned()->comment('순서');
        $table->timestamps();
        $table->softDeletes();
        $table->unique(['item_id', 'name']);
      });
    }
    


    if (!Schema::hasTable('market_item_favorites')) {
      Schema::create('market_item_favorites', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->bigInteger('item_id')->unsigned();
        $table->timestamp('created_at');
        $table->unique(['user_id', 'item_id']);
      });
    }
    


    if (!Schema::hasTable('market_item_images')) {
      Schema::create('market_item_images', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('item_id')->unsigned()->index()->comment('items.id');
        $table->string('image', '255')->nullable()->comment('');
        $table->tinyInteger('order')->default(0)->unsigned()->comment('');
        $table->timestamps();
      });
    }
    


    if (!Schema::hasTable('market_item_options')) {
      Schema::create('market_item_options', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('item_id')->unsigned()->comment('items.id');
        $table->string('title', '20')->nullable()->comment('옵션 title');
        $table->string('name', '20')->nullable()->comment('옵션명');
        $table->integer('price')->nullable()->comment('옵션별추가가격(음수가능)');
        $table->tinyInteger('sale')->nullable()->unsigned()->comment('0: 품절, 1: 재고');
        $table->timestamps();
        $table->softDeletes();
      });
    }
    


    if (!Schema::hasTable('market_item_qnas')) {
      Schema::create('market_item_qnas', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->bigInteger('item_id')->unsigned();
        $table->tinyInteger('secret')->default(0)->unsigned();
        $table->string('title', '255')->nullable();
        $table->text('content');
        $table->text('reply')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
    }
    


    if (!Schema::hasTable('market_item_reviews')) {
      Schema::create('market_item_reviews', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->bigInteger('order_id')->unsigned();
        $table->bigInteger('item_id')->unsigned();
        $table->text('content');
        $table->text('reply')->nullable();
        $table->tinyInteger('rating')->default(0)->unsigned();
        $table->timestamps();
        $table->softDeletes();
      });
    }
    


    if (!Schema::hasTable('market_item_tags')) {
      Schema::create('market_item_tags', function(BluePrint $table) {
        $table->bigInteger('item_id')->unsigned()->index();
        $table->bigInteger('tag_id')->unsigned()->index();
        $table->foreign('item_id')->references('id')->on('market_items')->onDelete('cascade');
      });
    }
    

    if (!Schema::hasTable('market_log_logins')) {
      Schema::create('market_log_logins', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned()->index();
        $table->string('http_user_agent', '255')->nullable();
        $table->string('http_referer', '255')->nullable();
        $table->string('http_origin', '255')->nullable();
        $table->string('remote_addr', '255')->nullable();
        $table->timestamp('created_at');
      });
    }
    


    if (!Schema::hasTable('market_orders')) {
      Schema::create('market_orders', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->string('o_id', '20')->index()->comment('market_buyers.o_id와 동일');
        $table->bigInteger('item_id')->unsigned()->comment('제품코드 market_items.id');
        $table->smallInteger('qty')->default(0)->unsigned()->comment('구매갯수');
        $table->bigInteger('item_price')->default(0)->unsigned()->comment('제품단가');
        $table->bigInteger('option_price')->default(0)->unsigned()->comment('제품옵션단가');
        $table->bigInteger('point')->default(0)->unsigned()->comment('적립포인트');
        $table->string('options', '200')->nullable()->comment('market_item_options.id | market_item_options.id |');
        $table->string('courier', '10')->nullable()->comment('(개별배송시) 각각의 제품에 대한 배송업체');
        $table->string('invoice_no', '20')->nullable()->comment('(개별배송시) 각각의 제품에 대한 송장번호');
        $table->tinyInteger('delivery_status')->default(0)->unsigned()->comment('(개별배송시) 각각의 제품에 대한 주문상태(앞으로 카트는 단순히 장바구니만을 처리하고 동일한 항목으로 orders등을 별도촐 처리)');
        $table->timestamps();
        $table->softDeletes();
      });
    }


    if (!Schema::hasTable('market_payments')) {
      Schema::create('market_payments', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->nullable()->unsigned()->comment('주문자아이디');
        $table->string('o_id', '20')->unique()->comment('주문번호');
        $table->string('method', '20')->nullable()->comment('online:온라인, card:카드, ha:핸드폰, ab:자동이체, po:포인트결제, all:다중결제');
        $table->tinyInteger('status')->default(0)->unsigned()->comment('0: 지불대기, 10: 지불완료, 20: 결제취소');
        $table->string('sequence_no', '20')->nullable()->comment('카드전표');
        $table->bigInteger('bank')->nullable()->unsigned()->comment('market_banks.id');
        $table->string('inputer', '20')->nullable()->comment('입금자명');
        $table->bigInteger('amt_point')->default(0)->unsigned()->comment('포인트 결제 금액');
        $table->bigInteger('amt_product')->default(0)->unsigned()->comment('총 상품 금액');
        $table->bigInteger('amt_delivery')->default(0)->unsigned()->comment('택배비');
        $table->bigInteger('amt_total')->default(0)->unsigned()->comment(' 최종 결제금액(택배비 및 기타 경비를 계산한 후 최종결제금액)');
        $table->timestamps();
      });
    }
    


    if (!Schema::hasTable('market_points')) {
      Schema::create('market_points', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('user_id')->index()->unsigned();
        $table->bigInteger('point')->default(0)->unsigned();
        $table->bigInteger('cur_sum')->default(0)->unsigned()->comment('users.point + users.hold_point 와 동일한 값이 되어야 함');
        $table->string('item', '20')->comment('이벤트, 구매포인트');
        $table->string('sub_item', '20')->nullable()->comment('item의 세부정, buy, event..');
        $table->bigInteger('rel_item')->nullable()->unsigned()->comment('주로 참조 테이블 아이디');
        $table->timestamp('created_at')->index();
      });
    }
    


    if (!Schema::hasTable('market_tags')) {
      Schema::create('market_tags', function(BluePrint $table) {
        $table->id();
        $table->string('tag', '50')->unique();
      });
    }


    
  }


  public function down()
  {
    Schema::table('market_items', function($table) {
      $table->dropFullText(['name', 'shorten_description', 'description', 'model']); // removing full-text index
    });
    

    Schema::table('market_item_tags', function($table) {
      $table->dropForeign('market_item_tags_market_items_id_foreign');
    });

    // Schema::table('bbs_comments', function($table) {
    //   $table->dropForeign('bbs_comments_bbs_articles_id_foreign');
    // });

    // Schema::table('bbs_files', function($table) {
    //   $table->dropForeign('bbs_files_bbs_articles_id_foreign');
    // });

    Schema::dropIfExists('market_addresses');
    Schema::dropIfExists('market_banks');
    Schema::dropIfExists('market_buyers');
    Schema::dropIfExists('market_carts');
    Schema::dropIfExists('market_categories');
    Schema::dropIfExists('market_configs');
    // Schema::dropIfExists('market_delivery_companies');
    Schema::dropIfExists('market_exchange_returns');
    Schema::dropIfExists('market_items');
    Schema::dropIfExists('market_item_categories');
    Schema::dropIfExists('market_item_displays');
    Schema::dropIfExists('market_item_favorites');
    Schema::dropIfExists('market_item_images');
    Schema::dropIfExists('market_item_options');
    Schema::dropIfExists('market_item_qnas');
    Schema::dropIfExists('market_item_reviews');
    Schema::dropIfExists('market_item_tags');
    Schema::dropIfExists('market_log_logins');
    Schema::dropIfExists('market_orders');
    Schema::dropIfExists('market_payments');
    Schema::dropIfExists('market_points');
    Schema::dropIfExists('market_tags');
  }
}