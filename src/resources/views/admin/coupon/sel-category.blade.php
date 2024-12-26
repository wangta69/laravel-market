
<div id="sel-category-box">
</div>

@section('scripts')
@parent
<script>
var category = "{{ $category }}";

/**
* 선택된 카테고리의 서브 item을 디스플레이
*/
function loadOptions(category, cat, callback) {

  console.log('loadOptions', 'category:', category, ',cat:', cat);
  ROUTE.ajaxroute('GET', 
    {route: 'market.admin.category.sub', data: {type:'json', category: category}}, 
    function(resp) {
      console.log('resp:', resp);
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        setDynamicOption(resp,  cat);
        callback();
      }
    })
}

// 수정모드이고 기존 카테고리 정보가 있을 경우
// 수정 모드일경우 초기화
function init_update() {

  console.log('init_update', category);
    if (!category) {
      return;
    }

    var len = category.length;
    var cat = [];



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
    init_load(cat, category)

}

function init_load(cat, category) {
  console.log('init_load', cat, category);
  if (cat[0]) {
    loadOptions('', category, function(resp) {
      loadOptions(cat[0], category, function(resp) {
        if (cat[1]) {
          loadOptions(cat[1], category, function(resp) {
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
    createSelectElement('category1', '대분류') + 
    createSelectElement('category2', '중분류') + 
    createSelectElement('category3', '소분류') +
    '</div>';
}

/**
 * @param resp: 서버로 전송받은 카테고리 옵션값
 * @param index: sub category index;
 * @param category: 수정일 경우 기존 category 값
 */
function setDynamicOption(resp, category) {
  $ele = $('select[name="category'+resp.depth+'"]');

  // 기존 선택 초기화
  switch (resp.depth) {
    case 1:
      $('select[name="category2"]').children('option:not(:first)').remove();
      $('select[name="category3"]').children('option:not(:first)').remove();
      break;
    case 2:
      $('select[name="category3"]').children('option:not(:first)').remove();
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
  $('#sel-category-box').append($elm);

  if (category) { // 수정일 경우
    init_update()
  } else {
    loadOptions('', 0, function(resp) {
      // setDynamicOption(resp,  0);
    });
  }


  // $(".sel-category").change('on', function() {
  $( document ).on('change', ".sel-category", function() {
    var category = $(this).val();
    var index  = $('.category-box').index($(this).parent('.category-box'));
    if (category) {
      loadOptions(category, index, function(resp){
        // setDynamicOption(resp,  index);
      });
    }
  });

})
</script>
@endsection