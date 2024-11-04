@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('title', '회원가입')
@section('content')
<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mt-5">
          <div class="card-header">
            <p class="mini-title">{{ Config::get('app.name') }}</p>
            <h3 class="title">비밀번호 초기화</h3>
          </div><!-- .card-header -->
          <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="card-body">
              <!-- Password Reset Token -->
              <input type="hidden" name="token" value="{{ $request->route('token') }}">

              <!-- Email Address -->
              <div class="form-floating mb-3">
                <input class="form-control" id="email"  type="email" name="email" :value="old('email', $request->email)" required autofocus />
                <label for="email">이메일</label>
                
              </div>

              <!-- Password -->
              <div class="form-floating mb-3">
                <input class="form-control" id="password" type="password" name="password" required />
                <label for="password"> 패스워드</label>
                
              </div>

              <!-- Confirm Password -->
              <div class="form-floating mb-3">
                <input id="password_confirmation" class="form-control"
                  type="password"
                  name="password_confirmation" required />
                <label for="password_confirmation">Confirm Password</label>
                
              </div>

              <div class="flex items-center justify-end mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
              </div>
            
            </div><!-- .card-body -->
            
          </form>
        </div><!-- .card -->
      </div><!-- .col-lg-6 -->
    </div><!-- .row.justify-content-center" -->
  </div><!-- .container -->
</section>
@endsection