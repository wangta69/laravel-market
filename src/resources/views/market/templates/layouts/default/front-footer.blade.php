<!-- footer -->
<!-- <footer>

  <div class="copyright py-4 bg-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-7 text-sm-left text-center">
          <p class="mb-0">Copyright 온스토리 | All Rights Reserved
          </p>
        </div>
        <div class="col-sm-5 text-sm-right text-center">
         
        </div>
      </div>
    </div>
  </div>
</footer> -->
<!-- /footer -->
<div class="container-fluid">
  <footer class="py-4 bg-light mt-auto fixed-bottom">
    <div class="container px-4">
      <div class="">
        <div><a href="{{ route('market.pages', ['terms-of-use']) }}">서비스이용약관</a> | <a href="{{ route('market.pages', ['privacy-policy']) }}">개인정보처리방침</a></div>
        <ul class="mt-2" style="font-size: 12px;">
          <li>회사명. {{config('pondol-market.company.name')}} </li>
          <li>주소. {{config('pondol-market.company.address')}}</li>
          <li>사업자 등록번호. {{config('pondol-market.company.businessNumber')}} 
            대표. {{config('pondol-market.company.representative')}} 전화. {{config('pondol-market.company.tel1')}} 팩스. {{config('pondol-market.company.fax1')}}</li>
        </ul>

        <div>Copyright &copy; 온스토리</div>
        
      </div>
    </div> <!-- .container -->
  </footer>
</div> <!-- .container-fluid -->