@section('title', '베너등록')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['베너관리', '베너등록']"> 

<div class="card">


 
  @if($item->id)
  <form method="POST" action="{{ route('market.admin.banner.edit', [$type, $item->id])}}" enctype="multipart/form-data">
    @method('PUT')
  @endif
  <form method="POST" action="{{ route('market.admin.banner.create', [$type])}}" enctype="multipart/form-data">
    @csrf  
            
    <div class="card-header">
      <strong></strong> 정보
    </div>
    <div class="card-body">

      <div class="row">
        <div class="col-4 col-lg-2">
          타이틀
        </div>
        <div class="col-8 col-lg-10">
          <input name="title" value="{{$item->title}}" class="form-control">
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-4 col-lg-2">
          이미지
        </div>
        <div class="col-8 col-lg-10">
        <div class="input-group">
          <input type='file' name='file' class="form-control">
          @if($item->image)
          <img src="{{market_get_thumb($item->image, 30, 30)}}" class="img-thumbnail">
          @endif
        </div>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-4 col-lg-2">
          설명
        </div>
        <div class="col-8 col-lg-10">
        <textarea name="description" class="form-control">{{$item->description}}</textarea>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-4 col-lg-2">
          URL
        </div>
        <div class="col-8 col-lg-10">
        <input name="url" value="{{$item->url}}" class="form-control">
        </div>
      </div>

   </div><!-- card-body -->
    <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa-regular fa-circle-check"></i> 변경
      </button>
      <a href="{{ URL::previous() }}" type="reset" class="btn btn-danger btn-sm">
        <i class="fa fa-ban"></i> 취소
      </a>
    </div>
  </form>
</div>

@section('styles')
@parent
@endsection
@section('scripts')
@parent
@endsection
</x-dynamic-component>