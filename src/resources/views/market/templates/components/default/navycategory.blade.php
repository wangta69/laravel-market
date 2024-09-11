<div class="mt-3">
      <i class="fa-solid fa-list"></i> 
        <a href="{{ route('market.category', [$categoryObj->path[0]->category]) }}" class="link">{{$categoryObj->path[0]->name}}</a> 
        @isset($categoryObj->path[1])
        > <a href="{{ route('market.category', [$categoryObj->path[1]->category]) }}" class="link">{{$categoryObj->path[1]->name}}</a> 
        @if(isset($categoryObj->path[2]))
        > <span>{{$categoryObj->path[2]->name}}</span> 
        @endif
        @endisset
       
      @if(count($categoryObj->sub_category))
      <i class="fa-solid fa-caret-down" id="category-on-off" data-bs-toggle="collapse" href="#collapseCategory" role="button" aria-expanded="false" aria-controls="collapseCategory"></i> 

      <div class="collapse" id="collapseCategory">
        <div class="card card-body">
          <ul>
            @foreach($categoryObj->sub_category as $k1 => $c1)
            <li> 
              <div class="row">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                  <a href="{{ route('market.category', [$c1->category]) }}" class="link">{{$c1->name}}</a> 
                </div>
          
                <div class="col-7 col-sm-8 col-md-9 col-lg-10 sub">
                  @foreach($categoryObj->sub_category[$k1]->sub as $k2 => $c2)
                  <a href="{{ route('market.category', [$c2->category]) }}" class="link">{{$c2->name}}</a>
                  @endforeach
                </div>
              </div>
            </li>
            @endforeach

          </ul>        
        </div>
      </div><!-- .collapse -->
      @endif
    </div>

@section('styles')
@parent
<style>
#category-on-off {
  transition: 0.3s ease-in-out;
}
#category-on-off.on {
  rotate: 180deg;
}

#collapseCategory ul {
  padding-left: initial;
  margin-bottom: initial;
}

#collapseCategory .sub a:not(:first-child)::before { 
  content: " | ";
}

</style>
@endsection


@section('scripts')
<script>
var categoryOnoffButton = document.getElementById('category-on-off');
var categoryCollapsible = document.getElementById('collapseCategory')

if (categoryCollapsible) {
  categoryCollapsible.addEventListener('hide.bs.collapse', event => {
    categoryOnoffButton.classList.remove('on');
  })
  categoryCollapsible.addEventListener('show.bs.collapse', event => {
    categoryOnoffButton.classList.add('on');
  })
}
</script>
@parent
@endsection