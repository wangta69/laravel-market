// 커서 위치를 계산하는 함수를 정의합니다.
function getCursorPos(e, img) {
  var imgOffset = img.offset();
  let x = e.pageX - imgOffset.left;
  let y = e.pageY - imgOffset.top;

//   console.log('xy:', x, y);
  if (e.type === 'touchmove') {
    x = e.originalEvent.touches[0].pageX - imgOffset.left;
    y = e.originalEvent.touches[0].pageY - imgOffset.top;
  }

  x -= window.scrollX;
  y -= window.scrollY;

  return { x, y };
}


function magnify() {
  $(".thum-box").on('mouseenter', function(e){
    $(".zoom-result").show();
    var img = $("#prd-image");
    var result = $(".zoom-result");
    var lens = $(".zoom-lens");

    var resultSize = {width: result.width(), height: result.height()};
    var lensSize = {width: lens.width(), height: lens.height()};
  
    // 렌즈와 결과 영역의 배경 이미지의 크기 배율을 계산합니다.
    var cx = resultSize.width / lensSize.width;
    var cy = resultSize.height / lensSize.height;
  
    result.css({
      "backgroundImage": `url(${img.attr('src')})`, 
      "backgroundSize": `${img.width() * cx}px ${img.height() * cy}px`
    });

    imageZoom(img, result, lensSize, cx, cy, lens);
  });
  
  $(".thum-box").on('mouseleave', function(e){
    $(".zoom-result").hide();
  });
}

function imageZoom(img, result,lensSize, cx, cy, lens ) {
    // 필요한 요소들을 선택 또는 생성합니다.
    // 결과 영역에 배경 이미지를 설정합니다.


  // 마우스 이동 또는 터치 이벤트에 대한 핸들러를 설정합니다.
  // lens.add(img).on('mousemove touchmove', function (e) {
    lens.add(img).on('mousemove touchmove', function (e) {
      e.preventDefault();
      var pos = getCursorPos(e, img);

      // 렌즈가 이미지 범위를 넘어가지 않도록 조절합니다.
      var x = pos.x - lensSize.width / 2;
      var y = pos.y - lensSize.height / 2;

      // 렌즈와 결과 영역의 위치를 업데이트합니다.
      lens.css({ left: x, top: y });
      result.css('backgroundPosition', `-${x * cx}px -${y * cy}px`);
  });
}
$(function(){
  magnify();
})

