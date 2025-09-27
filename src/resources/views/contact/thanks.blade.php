
@extends('layouts.app')

@section('title','Thanks')

@section('head')
<style>
  .thanks{position:relative;min-height:52vh;display:grid;place-items:center;background:#fff}
  .thanks__bg{position:absolute;inset:0;display:grid;place-items:center;color:#000;opacity:.03;font-size:22vw;font-family:Georgia,"Times New Roman",serif}
  .thanks__box{position:relative;text-align:center}
  .thanks__msg{font-size:22px;color:#6b5f57;margin-bottom:18px}
  .btn{display:inline-block;background:#8b6f63;color:#fff;border:0;border-radius:4px;padding:12px 28px}
</style>
@endsection

@section('content')
<section class="thanks">
  <div class="thanks__bg">Thank you</div>
  <div class="thanks__box">
    <div class="thanks__msg">お問い合わせありがとうございました</div>
    <a class="btn" href="{{ route('contact.create') }}">HOME</a>
  </div>
</section>
@endsection
