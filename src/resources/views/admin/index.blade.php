@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">管理画面</h1>

  {{-- 検索フォーム --}}
  <form method="GET" action="{{ route('admin.index') }}" class="card p-3 mb-4">
    <div class="row g-3">

      <div class="col-md-4">
        <label class="form-label">名前</label>
        <input type="text" name="name" value="{{ $filters['name'] }}" class="form-control">
        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" name="name_exact" value="1" id="name_exact" {{ $filters['name_exact'] ? 'checked' : '' }}>
          <label for="name_exact" class="form-check-label">完全一致</label>
        </div>
      </div>

      <div class="col-md-4">
        <label class="form-label">メールアドレス</label>
        <input type="text" name="email" value="{{ $filters['email'] }}" class="form-control">
        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" name="email_exact" value="1" id="email_exact" {{ $filters['email_exact'] ? 'checked' : '' }}>
          <label for="email_exact" class="form-check-label">完全一致</label>
        </div>
      </div>

      <div class="col-md-4">
        <label class="form-label">性別</label>
        <select name="gender" class="form-select">
          @php $g = $filters['gender']; @endphp
          <option value="all" {{ $g==='all' ? 'selected' : '' }}>全て</option>
          <option value="1"   {{ $g==='1' ? 'selected' : '' }}>男性</option>
          <option value="2"   {{ $g==='2' ? 'selected' : '' }}>女性</option>
          <option value="3"   {{ $g==='3' ? 'selected' : '' }}>その他</option>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">お問い合わせ種類</label>
        <select name="category_id" class="form-select">
          @php $cid = $filters['category_id']; @endphp
          <option value="all" {{ $cid==='all' ? 'selected' : '' }}>全て</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ (string)$cid===(string)$c->id ? 'selected' : '' }}>{{ $c->content }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">日付（From）</label>
        <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="form-control">
      </div>

      <div class="col-md-4">
        <label class="form-label">日付（To）</label>
        <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="form-control">
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary">検索</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.index') }}">リセット</a>

        <a class="btn btn-success"
           href="{{ route('admin.export', request()->query()) }}">
           エクスポート
        </a>
      </div>

    </div>
  </form>


  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>氏名</th>
            <th>性別</th>
            <th>メール</th>
            <th>種類</th>
            <th>作成日</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        @php $mapGender=[1=>'男性',2=>'女性',3=>'その他']; @endphp
        @forelse($contacts as $ct)
          <tr>
            <td>{{ $ct->id }}</td>
            <td>{{ $ct->last_name }} {{ $ct->first_name }}</td>
            <td>{{ $mapGender[$ct->gender] ?? '' }}</td>
            <td>{{ $ct->email }}</td>
            <td>{{ optional($ct->category)->content }}</td>
            <td>{{ $ct->created_at?->format('Y-m-d') }}</td>
            <td class="d-flex gap-2">
              {{-- 詳細（モーダル） --}}
              <a href="#detail-{{ $ct->id }}" class="btn btn-sm btn-outline-primary">詳細</a>

              {{-- 削除 --}}
              <form method="POST" action="{{ route('admin.destroy', $ct) }}"
                    onsubmit="return confirm('削除しますか？');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit">削除</button>
              </form>
            </td>
          </tr>

          <div id="detail-{{ $ct->id }}" class="modal">
            <div class="modal-dialog">
              <a href="#" class="modal-close">×</a>
              <h5>詳細 (ID: {{ $ct->id }})</h5>
              <ul class="list-unstyled">
                <li>氏名：{{ $ct->last_name }} {{ $ct->first_name }}</li>
                <li>性別：{{ $mapGender[$ct->gender] ?? '' }}</li>
                <li>メール：{{ $ct->email }}</li>
                <li>電話：{{ $ct->tel }}</li>
                <li>住所：{{ $ct->address }}</li>
                <li>建物：{{ $ct->building }}</li>
                <li>種類：{{ optional($ct->category)->content }}</li>
                <li>内容：{{ $ct->detail }}</li>
                <li>作成日：{{ $ct->created_at?->format('Y-m-d H:i') }}</li>
              </ul>
            </div>
          </div>
        @empty
          <tr><td colspan="7" class="text-center">データがありません</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-body">
      {{ $contacts->links() }}
    </div>
  </div>
</div>

<style>
  .modal { position: fixed; inset: 0; display:none; background: rgba(0,0,0,.3); }
  .modal:target { display:block; }
  .modal-dialog { position: relative; margin: 10vh auto; background: #fff; padding: 1.25rem; max-width: 640px; border-radius: .5rem; }
  .modal-close { position: absolute; right: .75rem; top: .5rem; text-decoration: none; font-size: 1.25rem; }
</style>
@endsection
