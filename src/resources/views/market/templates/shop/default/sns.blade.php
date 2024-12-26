<div class="sns-area flex-grow-1 text-end">
  <span class="share-btn">
    <i  class="fa-solid fa-share-nodes"></i> 공유 
  </span>
  <ul class="social-sns"> <!--  style="right: -500px;" -->
    <li onclick="share('kakao')"><span class="kakao"><i></i></span></li>
    <li onclick="share('naver')"><span class="naver"><i></i></span></li>
    <li onclick="share('facebook')"><span class="facebook"><i class="fa-brands fa-facebook-f"></i></span></li>
    <li onclick="share('link')"><span class="link"><i class="fa-solid fa-link"></i></span></li>
    <li><span class="sns-close"><i class="fa-solid fa-xmark"></i></span></li>
  </ul>
</div><!-- .sns-area -->


@section('styles')
@parent
<style>
.sns-area {
  position: relative;
  /* overflow: hidden; */
  /* padding: 5px; */
}

.sns-area .share-btn {
  font-size: 14px;
  color: #183153;
  border-radius: 15px;
  border: 1px solid #dee2e6;
  padding: 5px 10px;
}

.social-sns {
  right: 0px;
  position: absolute;
  /* top: 50%; */
  transform: translateY(-50%);
  right: -500px;
  padding-left: 0;
  display: flex;
  list-style: none;
  align-items: center;
  margin-bottom: 0;
}

.social-sns.on {
  transform: translateY(0%);
  right: 0px;
}

.social-sns li {
  margin-left: 5px;
  cursor: pointer;

  width: auto;
  text-align: center;
  margin: 5px;
  float: left;
}

.social-sns li span {
  border: 1px solid #dfdfdf;
  padding: 5px;
  border-radius: 15px;
  font-size: 13px;
  font-weight: 700;
  display: flex;
  width: 30px;
  height: 30px;
  align-items: center;
  justify-content: center;
}




.social-sns i {
  width: 17px;
  height: 17px;
  display: inline-block;
  vertical-align: sub;
}

.social-sns .kakao {
  color: #3c1e1e;
  background-color: #ffe812;

}

.social-sns .kakao i {
  background-image: url(/pondol/market/assets/images/kakao-icon.svg);
}

.social-sns .naver {
  color: #fff;
    background-color: #1ec800;
}

.social-sns .naver i {
  background-image: url(/pondol/market/assets/images/naver-icon.svg);
}

.social-sns .facebook {
  background-color: #1877f2;
  color: #fff;
}

.social-sns .link {
  color: #fff;
  background-color: #9b9b9b;
}

.social-sns .sns-close {
  background: none;
    font-size: 14px;
    color: #183153;
    border-radius: 15px;
    border: 1px solid rgba(223, 223, 223, .8745098039);
    padding: 5px 10px;
}
</style>
@endsection

@section('scripts')
@parent
<script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
<script>
  Kakao.init('ec8ac98c1b4cca9c492d9b4350c998a2'); // Enter your app's JavaScript key
</script>
<script>
function swapSocialSns() {
  if($("ul.social-sns").hasClass("on")) {
    $(".share-btn").show();
    $("ul.social-sns").removeClass('on');
  } else {
    $(".share-btn").hide();
    $("ul.social-sns").addClass('on');
  }
}
$(function(){
  $(".share-btn").on('click', function(){
    swapSocialSns();
  })

  $(".sns-close").on('click', function(){
    swapSocialSns();
  })
})

function share(sns) {
  var url = window.location.href;
  // var title = encodeURI(document.querySelector('meta[name="title"]').content)
  // var description = encodeURI(document.querySelector('meta[name="description"]').content)
  var title = document.querySelector('meta[name="title"]').content
  var description = document.querySelector('meta[name="description"]').content

  switch(sns) {
    case 'kakao':
      kakaoShare(url, title, description);
      break;
    case 'naver':
      sns_url = "https://share.naver.com/web/shareView?url=" + encodeURIComponent(url) + "&title=" + title;
      window.open(sns_url);
      break;
    case 'facebook':
      sns_url = 'http://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url) + '&title=' + title;
      window.open(sns_url);
      break;
    case 'twitter':
      sns_url = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(url) + ' ' + title;
      window.open(sns_url);
      break;
    case 'telegram':
      sns_url = 'https://telegram.me/share/url?url=' + encodeURIComponent(url) + '&text=' + title;
      window.open(sns_url);
      break;
    case 'link':
      if (navigator.clipboard !== undefined) {
        navigator.clipboard.writeText(url).then(() => {
          showToaster({title: '알림', message: '링크가 copy되었습니다..', alert: false});
        });
      } else {
        // execCommand 사용
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        textArea.setSelectionRange(0, 99999);
        try {
          document.execCommand('copy');
        } catch (err) {
         console.error('복사 실패', err);
        }
        textArea.setSelectionRange(0, 0);
        document.body.removeChild(textArea);
        showToaster({title: '알림', message: '링크가 copy되었습니다..', alert: false});
      }
    }
}

function kakaoShare(url, title, description) {
  Kakao.Share.sendDefault({
    objectType: 'feed',
    content: {
      title: title,
      description: description,
      imageUrl: '[콘텐츠 이미지]',
      link: {
        mobileWebUrl: url,
        webUrl: url,
      },
    }
  })
}
</script>
@endsection
