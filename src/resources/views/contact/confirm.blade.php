@extends('layouts.app')

@section('title','Confirm')

@section('head')
<style>
  .confirm{padding:36px 0 60px;background:#fff}
  .confirm__title{margin:0 0 28px;text-align:center;font-size:32px;font-family:Georgia,"Times New Roman",serif;color:#8a7a6d}
  .tbl{max-width:900px;margin:0 auto;border:1px solid #e6ddd5;border-collapse:separate;border-spacing:0;background:#fff}
  .th{width:260px;background:#b7a79a;color:#fff;padding:18px 20px;font-weight:700}
  .td{padding:16px 20px;border-bottom:1px solid #e6ddd5}
  .row:last-child .td{border-bottom:0}
  .actions{margin-top:22px;text-align:center}
  .btn{display:inline-block;background:#8b6f63;color:#fff;border:0;border-radius:4px;padding:12px 28px;cursor:pointer;margin:0 8px}
  .btn--ghost{background:#fff;color:#8b6f63;border:1px solid #d6c8bd}
</style>
@endsection

@section('content')
<section class="confirm">
  <h1 class="confirm__title">Confirm</h1>

  <table class="tbl">
    <tr class="row"><th class="th">お名前</th><td class="td">{{ $data['last_name'] }}　{{ $data['first_name'] }}</td></tr>
    <tr class="row"><th class="th">性別</th><td class="td">{{ $genderLabel }}</td></tr>
    <tr class="row"><th class="th">メールアドレス</th><td class="td">{{ $data['email'] }}</td></tr>
    <tr class="row"><th class="th">電話番号</th><td class="td">{{ $data['tel'] }}</td></tr>
    <tr class="row"><th class="th">住所</th><td class="td">{{ $data['address'] }}</td></tr>
    <tr class="row"><th class="th">建物名</th><td class="td">{{ $data['building'] ?? '－' }}</td></tr>
    <tr class="row"><th class="th">お問い合わせの種類</th><td class="td">{{ $categoryLabel }}</td></tr>
    <tr class="row"><th class="th">お問い合わせ内容</th><td class="td">{{ $data['detail'] }}</td></tr>
  </table>

  <div class="actions">
    <form method="POST" action="{{ route('contact.store') }}" style="display:inline"novalidate>
@csrf
      <button class="btn" type="submit">送信</button>
    </form>
    <form method="POST" action="{{ route('contact.back') }}" style="display:inline">@csrf
      <button class="btn btn--ghost" type="submit">修正</button>
    </form>
  </div>
</section>
@endsection
