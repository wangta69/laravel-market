@extends('market.admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['카테고리', '카테고리관리']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">카테고리 메니저</h2>

  <div class="card">
    <div class="card-body">
      <div>상품카테고리를 등록, 수정, 변경 삭제 하는 곳입니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
    
      <div class="col-xl-4 col-md-4">
        <h3 class="text-center p-1 title">대분류</h3>
        <div id="cat-1"></div>
        <div id="cat-1-input" class="input-group">
          <input name="name" class="form-control" placeholder="대분류 입력"/>
          <button type="button" class="btn btn-primary reg-cat">
            대분류등록
          </button>
        </div>
      </div>
      
      <div class="col-xl-4 col-md-4">
        <h3 class="text-center p-1 title">중분류</h3>
        <div id="cat-2"></div>
        <div id="cat-2-input" style="display: none;" class="input-group">
          <input name="name" class="form-control" placeholder="중분류 입력"/>
          <button type="submit" class="btn btn-primary reg-cat">
            중분류등록
          </button>
        </div>
      </div>

      <div class="col-xl-4 col-md-4">
        <h3 class="text-center p-1 title">소분류</h3>
        <div id="cat-3"></div>
        <div id="cat-3-input" style="display: none;" class="input-group">
          <input name="name" class="form-control" placeholder="소분류 입력"/>
          <button type="submit" class="btn btn-primary reg-cat">
            소분류등록
          </button>
        </div>
      </div>
    </div> <!-- .row -->
  </div><!-- .card-body -->
</div><!-- .card -->


  


@endsection
@section('styles')
  @parent
<style>
  .title {
    background-color: #ced4da

  }
/* .act-show-sub.on {
  font-weight: bold;
} */
</style>
@endsection
@section('scripts')
  @parent

<script>
  _depth = 0; // 카테고리  depth, 0: 대분류, 1: 중분류..
  _parent = ''; // 부모 카테고리
  _category = ''; // 현재 선택된 카테고리
  _act = ''; // 액션: delete, modify, 

  function itemDisplay() {
    $("#cat-2-input").hide();
    $("#cat-3-input").hide();


    len = _category.length;

    switch(len){
      case 0:
        $("#cat-2").html('');
        $("#cat-3").html('');
        subItems(''); // 처음 로딩시 1차 카테고리 가져오기
        break;
      case 3:
        $("#cat-3").html('');
        $("#cat-2-input").show();
        subItems('');
        subItems(_category.substring(0, 3));
        break;
      case 6:
        $("#cat-2-input").show();
        $("#cat-3-input").show();
        subItems('');
        subItems(_category.substring(0, 3));
        subItems(_category.substring(0, 6));
        break;
    }
  }

  /** 생성 */
  function store(name, callback) {
    ROUTE.ajaxroute('POST', 
    {route: 'market.admin.category', data: {name:name, parent: _category}}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
        callback();
      }
    })
  }
  /** 삭제 */
  function destroy(category, callback) {
    ROUTE.ajaxroute('DELETE', 
    {route: 'market.admin.category', data: {category: category}}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
        callback();
      }
    })
  }
  /** 수정 */
  function update(category, name, callback) {
    ROUTE.ajaxroute('PUT', 
    {route: 'market.admin.category', data: {category: category, name: name}}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
        callback();
      }
    })
  }

  /**
   * 선택된 카테고리의 서브 item을 디스플레이
   */
  function subItems(category) {
    var url = "{{ route('market.admin.category.sub') }}?type=json&category=" + category;

    $.ajax({
      url: url,
      type: 'GET',
      success: function(resp) {
        var itemsStr = '';
        if (resp.items.length == 0) {
          itemsStr = '<ul><li>등록된 카테고리가 없습니다.</li></ul>'
        } else {
          itemsStr = '<ul>';
          resp.items.forEach(function(item) {
            itemsStr += '<li user-attr-category="'+item.category+'" class="input-group mt-1">';
            itemsStr += '<input type="text" name="item_name" class="form-control" value="'+item.name+'">';
            itemsStr += '<button class="btn btn-primary act-show-sub">보기</button>';
            itemsStr += '<button class="btn btn-warning act-modify">수정</button>';
            itemsStr += '<button class="btn btn-danger act-delete">삭제</button>';
            itemsStr += '</li>';
          });
          itemsStr += '</ul>';
        }
        switch(resp.depth) {
          case 1:
            $("#cat-1").html(itemsStr);
            break;
          case 2:
            $("#cat-2").html(itemsStr);
            break;
          case 3:
            $("#cat-3").html(itemsStr);
            break;
        }
      }
    });
  }

  $(function(){

    // 카테고리 등록
    $('body').on('click', '.reg-cat', function(){
      _depth = $(".reg-cat").index(this);
      var name = $("input[name=name]").eq(_depth).val();
      store(name, function(){
        _parent = _category.substring(0, 3 * _depth);

        subItems(_parent);
        $("input[name=name]").val('');
      });
    });

    // 하위 카테고리 보기
    $('body').on('click', '.act-show-sub', function(){
      // 현재 카테고리 변경
      _category = $(this).parent().attr('user-attr-category');
      subItems(_category);

      itemDisplay();
      // 현재 선택된 것에 대한 bold 처리
      // $('.act-show-sub').removeClass('on');
      // $(this).addClass('on');
    })

    // 하위카테고리 삭제
    $('body').on('click', '.act-delete', function(){
      var category = $(this).parent().attr('user-attr-category');

      destroy(category, function(){
        itemDisplay();
      });
    })

    // 하위 카테고리 수정
    $('body').on('click', '.act-modify', function(){
      var category = $(this).parent().attr('user-attr-category');
      var name = $(this).siblings("input[name=item_name]").val();

      update(category, name, function(){
       //
      });
    })
  })
  itemDisplay();
  
</script>
@endsection
