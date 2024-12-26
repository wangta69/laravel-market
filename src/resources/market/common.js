// /**
//  * 우편번호 창
//  **/
// var search_zip = function(frm_name, frm_zip, frm_addr1, frm_addr2, frm_addr3, frm_jibeon) {
//   if(typeof daum === 'undefined'){
//     alert("다음 우편번호 postcode.v2.js 파일이 로드되지 않았습니다.");
//     return false;
//   }

//   var zip_case = 0;   //0이면 레이어, 1이면 페이지에 끼워 넣기, 2이면 새창

//   var complete_fn = function(data){

//     // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

//     // 각 주소의 노출 규칙에 따라 주소를 조합한다.
//     // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
//     var fullAddr = ''; // 최종 주소 변수
//     var extraAddr = ''; // 조합형 주소 변수

//     // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
//     if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
//       fullAddr = data.roadAddress;

//     } else { // 사용자가 지번 주소를 선택했을 경우(J)
//       fullAddr = data.jibunAddress;
//     }

//     // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
//     if(data.userSelectedType === 'R'){
//       //법정동명이 있을 경우 추가한다.
//       if(data.bname !== ''){
//         extraAddr += data.bname;
//       }
//       // 건물명이 있을 경우 추가한다.
//       if(data.buildingName !== ''){
//         extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
//       }
//       // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
//       extraAddr = (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
//     }

//     // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
//     var of = document[frm_name];

//     of[frm_zip].value = data.zonecode;

//     of[frm_addr1].value = fullAddr;
//     if(frm_addr3) {
//       of[frm_addr3].value = extraAddr;
//     }
    
//     if(of[frm_jibeon] !== undefined){
//       of[frm_jibeon].value = data.userSelectedType;
//     }

//     of[frm_addr2].focus();
//   };

//   switch(zip_case) {
//     case 1 :    //iframe을 이용하여 페이지에 끼워 넣기
//       var daum_pape_id = 'daum_juso_page'+frm_zip,
//         element_wrap = document.getElementById(daum_pape_id),
//         currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
//       if (element_wrap == null) {
//         element_wrap = document.createElement("div");
//         element_wrap.setAttribute("id", daum_pape_id);
//         element_wrap.style.cssText = 'display:none;border:1px solid;left:0;width:100%;height:300px;margin:5px 0;position:relative;-webkit-overflow-scrolling:touch;';
//         element_wrap.innerHTML = '<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-21px;z-index:1" class="close_daum_juso" alt="접기 버튼">';
//         jQuery('form[name="'+frm_name+'"]').find('input[name="'+frm_addr1+'"]').before(element_wrap);
//         jQuery("#"+daum_pape_id).off("click", ".close_daum_juso").on("click", ".close_daum_juso", function(e){
//           e.preventDefault();
//           jQuery(this).parent().hide();
//         });
//       }

//       new daum.Postcode({
//         oncomplete: function(data) {
//           complete_fn(data);
//           // iframe을 넣은 element를 안보이게 한다.
//           element_wrap.style.display = 'none';
//           // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
//           document.body.scrollTop = currentScroll;
//         },
//         // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분.
//         // iframe을 넣은 element의 높이값을 조정한다.
//         onresize : function(size) {
//           element_wrap.style.height = size.height + "px";
//         },
//         width : '100%',
//         height : '100%'
//       }).embed(element_wrap);

//       // iframe을 넣은 element를 보이게 한다.
//       element_wrap.style.display = 'block';
//       break;
//     case 2 :    //새창으로 띄우기
//       new daum.Postcode({
//         oncomplete: function(data) {
//           complete_fn(data);
//         }
//       }).open();
//       break;
//     default :   //iframe을 이용하여 레이어 띄우기
//       var rayer_id = 'daum_juso_rayer'+frm_zip,
//         element_layer = document.getElementById(rayer_id);

//       if (element_layer == null) {
//         element_layer = document.createElement("div");
//         element_layer.setAttribute("id", rayer_id);
//         element_layer.style.cssText = 'display:none;border:5px solid;position:fixed;width:300px;height:460px;left:50%;margin-left:-155px;top:50%;margin-top:-235px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:10000';
//         element_layer.innerHTML = '<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" class="close_daum_juso" alt="닫기 버튼">';
//         document.body.appendChild(element_layer);
//         jQuery("#"+rayer_id).off("click", ".close_daum_juso").on("click", ".close_daum_juso", function(e){
//           e.preventDefault();
//           jQuery(this).parent().hide();
//         });
//       }
//       console.log('element_layer>>', element_layer);
//       new daum.Postcode({
//         oncomplete: function(data) {
//           complete_fn(data);
//           // iframe을 넣은 element를 안보이게 한다.
//           element_layer.style.display = 'none';
//         },
//         width : '100%',
//         height : '100%'
//       }).embed(element_layer);

//       // iframe을 넣은 element를 보이게 한다.
//       element_layer.style.display = 'block';
//   } // switch(zip_case) {
// }

/** delivery-tracking 에서 처리할 예정 */
function delivery_logs(courier, invoicenumber) {
  if(!invoicenumber) {
    return alert('물품 대기 중입니다.');
  }
  var url = `/delivery-tracking/${courier}/${invoicenumber}/html`;
  window_open(url, '', {width: 900, height: 600});
}