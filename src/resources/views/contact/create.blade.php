@extends('layouts.app')

@section('title','Contact')
@section('body_class','page--contact')

@section('head')
<style>
  .contact{padding:36px 0 60px;background:#fff}
  .contact__title{margin:0 0 28px;text-align:center;font-size:32px;font-family:Georgia,"Times New Roman",serif;color:#8a7a6d}
  .contact__table{max-width:900px;margin:0 auto;border:1px solid #e6ddd5;border-collapse:separate;border-spacing:0;background:#fff}
  .contact__row{border-bottom:1px solid #e6ddd5}
  .contact__th{width:260px;background:#b7a79a;color:#fff;padding:18px 20px;font-weight:700}
  .contact__td{padding:16px 20px}
  .req{color:#d85c5c;margin-left:.35em}
  .input{width:100%;height:46px;background:#f4f3f2;border:0;border-radius:6px;padding:0 12px}
  .textarea{width:100%;min-height:160px;background:#f4f3f2;border:0;border-radius:6px;padding:12px}
  .actions{margin-top:22px;text-align:center}
  .btn{display:inline-block;background:#8b6f63;color:#fff;border:0;border-radius:4px;padding:12px 28px;cursor:pointer}
  .muted{color:#b6ada7;font-size:13px;margin-top:6px}
  .flex{display:flex;gap:10px}
  .radio-group{display:flex;gap:24px;align-items:center}
</style>
@endsection

@section('content')
<section class="contact">
  <h1 class="contact__title">Contact</h1>

  @if ($errors->any())
    <ul style="color:#c0392b;max-width:900px;margin:0 auto 16px">
      @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  @endif

  <form method="POST" action="{{ route('contact.confirm') }}"novalidate>
    @csrf

    <table class="contact__table">
      <tr class="contact__row">
        <th class="contact__th">お名前 <span class="req">※</span></th>
        <td class="contact__td">
          <div class="flex">
            <input class="input" name="last_name"  value="{{ old('last_name', $old['last_name'] ?? '') }}"  placeholder="例: 山田" required>
            <input class="input" name="first_name" value="{{ old('first_name', $old['first_name'] ?? '') }}" placeholder="例: 太郎" >
          </div>
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">性別 <span class="req">※</span></th>
        <td class="contact__td">
          <div class="radio-group">
            <label><input type="radio" name="gender" value="1" {{ old('gender', $old['gender'] ?? '')=='1'?'checked':'' }}> 男性</label>
            <label><input type="radio" name="gender" value="2" {{ old('gender', $old['gender'] ?? '')=='2'?'checked':'' }}> 女性</label>
            <label><input type="radio" name="gender" value="3" {{ old('gender', $old['gender'] ?? '')=='3'?'checked':'' }}> その他</label>
          </div>
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">メールアドレス <span class="req">※</span></th>
        <td class="contact__td">
          <input class="input" type="email" name="email" value="{{ old('email', $old['email'] ?? '') }}" placeholder="例: test@example.com" >
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">電話番号 <span class="req">※</span></th>
        <td class="contact__td">
          <div class="flex">
            <input class="input" name="tel1" value="{{ old('tel1', $old['tel1'] ?? '') }}" placeholder="080" required>
            <input class="input" name="tel2" value="{{ old('tel2', $old['tel2'] ?? '') }}" placeholder="1234" required>
            <input class="input" name="tel3" value="{{ old('tel3', $old['tel3'] ?? '') }}" placeholder="5678" required>
          </div>
          <div class="muted">※ ハイフン無しで入力してください</div>
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">住所 <span class="req">※</span></th>
        <td class="contact__td">
          <input class="input" name="address" value="{{ old('address', $old['address'] ?? '') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" required>
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">建物名</th>
        <td class="contact__td">
          <input class="input" name="building" value="{{ old('building', $old['building'] ?? '') }}" placeholder="例: 千駄ヶ谷マンション101">
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">お問い合わせの種類 <span class="req">※</span></th>
        <td class="contact__td">
          <select class="input" name="category_id" required>
            <option value="">選択してください</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" @selected(old('category_id', $old['category_id'] ?? '')==$cat->id)>{{ $cat->content }}</option>
            @endforeach
          </select>
        </td>
      </tr>

      <tr class="contact__row">
        <th class="contact__th">お問い合わせ内容 <span class="req">※</span></th>
        <td class="contact__td">
          <textarea class="textarea" name="detail" maxlength="120" placeholder="お問い合わせ内容をご記載ください" required>{{ old('detail', $old['detail'] ?? '') }}</textarea>
        </td>
      </tr>
    </table>

    <div class="actions">
      <button class="btn" type="submit">確認画面</button>
    </div>
  </form>
</section>
@endsection
