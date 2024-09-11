
@extends('market.admin.layouts.main')
@section('title', '무통장 입금 계좌 등록')
@section('content')
<div id="content">
  @include('layouts.admin.main-top')
  <h2 class="title">무통장 입금 계좌 등록</h2>
  <form method="POST" action="{{ route('market.admin.config.bank') }}">
  @csrf
  <table class="table table-borderless table-striped listTable">
      <col width="*">
      <col width="*">
      <tr>
          <th class="text-center">
              은행명
          </th>
          <td>
              <select name="code">
                  @foreach($codes as $k=>$v)
                  <option value="{{$k}}">{{$v['name']}}</option>
                  @endforeach
              </select>
          </td>
      </tr>
      <tr>
          <th class="text-center">
              계좌번호
          </th>
          <td>
              <input type="text" name="no">
          </td>
      </tr>
      <tr>
          <th class="text-center">
              소유주
          </th>
          <td>
              <input type="text" name="owner">
          </td>
      </tr>
      <tr>
  </table>
  <button type="submit" class="btn">추가</button>
  </form>
</div>


@endsection
@section('styles')
@parent
@endsection
@section('scripts')
@parent
@endsection
