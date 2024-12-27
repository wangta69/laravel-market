@php

$company = jsonval('company')
@endphp
<div class="container-fluid">
  <footer class="py-4 bg-light mt-auto fixed-bottom">
    <div class="container px-4">
      <div class="">
        <div><a href="{{ route('market.pages', ['terms-of-use']) }}">서비스이용약관</a> | <a href="{{ route('market.pages', ['privacy-policy']) }}">개인정보처리방침</a></div>
        <ul class="mt-2" style="font-size: 12px;">
          <li>회사명. {{$company['name']}} </li>
          <li>주소. {{$company['address']}}</li>
          <li>사업자 등록번호. {{$company['businessNumber']}} 
            대표. {{$company['representative']}} 전화. {{$company['tel1']}} 팩스. {{$company['fax1']}}</li>
        </ul>

        <div>Copyright &copy; 온스토리</div>
        
      </div>
    </div> <!-- .container -->
  </footer>
</div> <!-- .container-fluid -->