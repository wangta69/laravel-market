<h5>대표카테고리</h5>
<div id="main-category-box">
</div>
<h5><span class="act-add-category">서브카테고리</span> <i class="fa-solid fa-plus act-add-category"></i></h5>
<div id="sub-category-box">
</div>

@section('scripts')
@parent
<script>
var categories = {!! $categories !!};

/**
* 선택된 카테고리의 서브 item을 디스플레이
*/
function loadOptions(category, index, cat, callback) {
  console.log('loadOptions', 'category:', category, 'index:', index, cat);
  MARKET.ajaxroute('GET', 
    {'name': 'market.admin.category.sub'}, 
      {type:'json', category: category}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        setDynamicOption(resp,  index, cat);
        callback();
      }
    })

  // var url = "{{ route('market.admin.category.sub') }}?type=json&category=" + category;
  // $.ajax({
  //   url: url,
  //   type: 'GET',
  //   success: function (resp) {
  //     setDynamicOption(resp,  index, cat);
  //     callback(resp);
  //   }
  // });
}

// 수정모드이고 기존 카테고리 정보가 있을 경우
// 수정 모드일경우 초기화
function init_update() {
  for(var i = 0; i < categories.length; i++) {
    var category = categories[i].category
    if (!category) {
      return;
    }

    var len = category.length;
    var cat = [];

    if (i > 0) { // 서브 카테고리를 동적으로 추가한다.
      $elm = createSelectElements();
      $('#sub-category-box').append($elm);
    }

    switch (len) {
      case 3:
        cat.push(category.substring(0, 3))
        break;
      case 6:
        cat.push(category.substring(0, 3))
        cat.push(category.substring(0, 6))
        break;
      case 9:
        cat.push(category.substring(0, 3))
        cat.push(category.substring(0, 6))
        cat.push(category.substring(0, 9))
        break;
    }
    init_load(cat, i, category)
  } // for
}

function init_load(cat, i, category) {
  console.log('init_load', cat, i, category);
  if (cat[0]) {
    loadOptions('', i, category, function(resp) {
      loadOptions(cat[0], i, category, function(resp) {
        if (cat[1]) {
          loadOptions(cat[1], i, category, function(resp) {
          });
        } // if (cat[2]) {
      });
    });  
  } // if (cat[0]) {
}

function createSelectElement(name, text) {
  var str = `<select name="` + name + `" class="form-select sel-category">` +
    `<option value="" selected>` + text + `</option>` +
    `<option value="">------</option>` +
  `</select>`;
  return str;
}

function createSelectElements() {
  return '<div class="input-group category-box mt-1">' + 
    createSelectElement('category1[]', '대분류') + 
    createSelectElement('category2[]', '중분류') + 
    createSelectElement('category3[]', '소분류') +
    '</div>';
}

/**
 * @param resp: 서버로 전송받은 카테고리 옵션값
 * @param index: sub category index;
 * @param category: 수정일 경우 기존 category 값
 */
function setDynamicOption(resp, index, category) {
  $ele = $('select[name="category'+resp.depth+'[]"]').eq(index);

  // 기존 선택 초기화
  switch (resp.depth) {
    case 1:
      $('select[name="category2[]"]').eq(index).children('option:not(:first)').remove();
      $('select[name="category3[]"]').eq(index).children('option:not(:first)').remove();
      break;
    case 2:
      $('select[name="category3[]"]').eq(index).children('option:not(:first)').remove();
      break;
  }



  // 현재 카테고리값에 따른 뒤의 카테고리값 불러오기
  $ele.children('option:not(:first)').remove();
  
  $.each(resp.items, function (i, item) {
    var selected = category && category.substring(0, resp.depth * 3) == item.category ? 'selected': null;
    $ele.append(`<option value="${item.category}" ${selected}>${item.name}</option>`);
  }); //close each(
}

$(function(){
  $elm = createSelectElements();
  $('#main-category-box').append($elm);
  if (categories.length > 0 && categories[0].category) { // 수정일 경우
    init_update()
  } else {
    loadOptions('', 0, null, function(resp) {
      // setDynamicOption(resp,  0);
    });
  }


  // $(".sel-category").change('on', function() {
  $( document ).on('change', ".sel-category", function() {
    var category = $(this).val();
    var index  = $('.category-box').index($(this).parent('.category-box'));
    if (category) {
      loadOptions(category, index, null, function(resp){
        // setDynamicOption(resp,  index);
      });
    }
  });

  // 서브 카테고리 추가
  $(".act-add-category").click('on', function() {
    $elm = createSelectElements();
    $('#sub-category-box').append($elm);
    var index = $(".category-box").length;
    loadOptions('', index -1, null, function(resp){
      // setDynamicOption(resp,  index -1);
    });

  })
})
</script>
@endsection