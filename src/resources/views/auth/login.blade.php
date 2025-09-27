@extends('layouts.app')

@section('title','Login')
@section('body_class','page--auth')

@section('head')
<style>
  .auth-hero{background:#f2ebe4;padding:38px 0 60px}
  .auth-hero__title{margin:0 0 28px;text-align:center;font-size:32px;font-family:Georgia,"Times New Roman",serif;color:#8a7a6d}
  .auth-card{max-width:700px;margin:0 auto;background:#fff;border:1px solid #e6ddd5;border-radius:8px;padding:46px 56px}
  .form__group{margin:22px 0}
  .form__label{display:block;margin:0 0 10px;color:#6e5e52;font-weight:700}
  .form__input{width:100%;height:48px;border:0;border-radius:8px;background:#f4f3f2;padding:0 14px;font-size:16px}
  .form__actions{margin-top:28px;text-align:center}
  .btn{display:inline-block;background:#8b6f63;color:#fff;border:0;border-radius:6px;padding:12px 36px;cursor:pointer}
</style>
@endsection

@section('content')
<section class="auth-hero">
  <h1 class="auth-hero__title">Login</h1>

  <div class="auth-card">
    @if ($errors->any())
      <ul style="color:#c0392b;margin-top:0;margin-bottom:18px">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    @endif

    <form method="POST" action="/login">
      @csrf
      <div class="form__group">
        <label class="form__label">メールアドレス</label>
        <input class="form__input" type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" required>
      </div>

      <div class="form__group">
        <label class="form__label">パスワード</label>
        <input class="form__input" type="password" name="password" placeholder="例: coachtech1106" required>
      </div>

      <div class="form__actions">
        <button class="btn" type="submit">ログイン</button>
      </div>
    </form>
  </div>
</section>
@endsection
