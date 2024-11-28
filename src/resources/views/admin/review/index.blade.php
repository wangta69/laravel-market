@section('title', '리뷰')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['상품문의 및 리뷰', '리뷰']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">리뷰</h2>
</div>

<div class="card m-t-15  m-b-0">
  <div class="card-body">

    <table class="table items">
      <tr>
        <th class="text-center">#</th>
        <th></th>
        <th class="text-center">내용</th>
        <th class="text-center">작성자</th>
        <th class="text-center">작성일</th>
        <th class="text-center">상태</th>
        <th></th>
      </tr>
      @forelse ($items as $index=>$item)
      <tr user-attr-id="{{$item->id}}">
        <td class="text-center">{{ number_format($items->total() - $items->perPage() * ($items->currentPage() - 1) - $index) }}</td>
        <td class="text-center">
          <div class="position-relative">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$item->rating}}</span>
            <span class="visually-hidden">rating</span>
          </div>

          <img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail">  
          <div>{{ $item->name }}</div>
          <div class="text-center">
            <a href="{{ route('market.item', [$item->item_id]) }}" class="link" target="_blank">
              <i class="fas fa-search"></i>
            </a>
          </div>
        </td>
        <td>
          <span data-bs-toggle="modal" data-bs-target="#qnaModal-{{$item->id}}">{!! nl2br($item->content) !!}</span>


          <div class="modal fade" id="qnaModal-{{$item->id}}" tabindex="-1" aria-labelledby="qnaModalLabel-{{$item->id}}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn btn-light">
                  <i class="fa-solid fa-star"></i>
                  <span class="badge bg-danger">{{$item->rating}}</span>
                </button>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                  {!! nl2br($item->content) !!}
                </div>
                <form>
                  <div class="modal-body text-start">
                    <textarea class="form-control" name="reply">{{ $item->reply }}</textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-primary act-save-review">리뷰평 저장</button>
                  </div>
                </form>
              </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
          </div><!-- .modal -->
        </td>
        <td class="text-center">{{$item->user_name}} <a onclick="win_user('{{ route('auth.admin.user', $item->user_id) }}')"><i class="fas fa-search"></i></a></td>
        <td class="text-center">{{$item->created_at}}</td>
        <td class="text-center">
          @if($item->reply) 
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#qnaModal-{{$item->id}}">리뷰평완료</button> 
          @else 
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#qnaModal-{{$item->id}}">리뷰평준비중</button> 
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7">
          상품문의가 존재 하지 않습니다.
        </td>
      </tr>
      @endforelse
    </table>

  </div> <!-- card-body -->
  <div class="card-footer">
  {{ $items->links('pagination::bootstrap-4') }}
  </div><!-- card-footer -->
</div>
 
@section('styles')
@parent

@endsection

@section('scripts')
  @parent
<script>
$(function(){
  $(".act-save-review").on('click', function(){
    var id = $(this).parents('tr').attr('user-attr-id')
    var form = $(this).parents('form').serializeObject();
    ROUTE.ajaxroute('PUT', 
    {route: 'market.admin.review', segments: [id], data: form}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
         location.reload();
        // showToaster({title: '알림', message: '처리되었습니다.', alert: false});

      }
    })
  })
})

</script>
@endsection
</x-dynamic-component>