@extends('layouts.app')

@section('content')
<div class="container" style="max-width:480px;">
  <h1 class="mb-4">ユーザ登録</h1>

  <form method="POST" action="{{ route('register') }}" novalidate class="card p-3">
    @csrf

    <div class="mb-3">
      <label class="form-label">お名前</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control">
      @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">メールアドレス</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control">
      @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">パスワード</label>
      <input type="password" name="password" class="form-control">
      @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-grid gap-2">
      <button class="btn btn-primary" type="submit">登録</button>
      <a class="btn btn-link" href="{{ route('login') }}">ログインページへ</a>
    </div>
  </form>
</div>
@endsection
