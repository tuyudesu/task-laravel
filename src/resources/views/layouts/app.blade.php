<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','FashionablyLate')</title>

  <style>
    :root{
      --color-bg:#F2EBE4; --color-card:#fff; --color-text:#6b5f57;
      --color-brand:#8b6f63; --color-border:#e5ddd5;
    }
    *{box-sizing:border-box}
    html,body{
      margin:0; padding:0; color:var(--color-text);
      font-family:-apple-system,BlinkMacSystemFont,"Hiragino Kaku Gothic ProN",Segoe UI,Roboto,Helvetica,Arial,"Noto Sans JP","Yu Gothic",sans-serif;
    }
    a{color:inherit; text-decoration:none}
    .l-container{max-width:980px; margin:0 auto; padding:0 24px}


    .site-header{background:#fff; border-bottom:1px solid var(--color-border)}
    .site-header__inner{
      display:flex; align-items:center; justify-content:space-between;
      height:68px;
    }
    .site-header__brand{
      font-family:Georgia,"Times New Roman",serif; font-size:28px; color:var(--color-brand);
    }
    .site-header__nav{display:flex; gap:12px; align-items:center}
    .site-header__link,
    .site-header__button{
      display:inline-block; height:36px; line-height:34px; padding:0 14px;
      border:1px solid #d6c8bd; background:#fff; color:#8b6f63; cursor:pointer;
      border-radius:0; 
    }
    .site-header__form{display:inline; margin:0}


    .form__label{display:block; margin:0 0 8px; font-weight:600; color:#6e5e52}
    .form__input{
      width:100%; height:48px; border:none; background:transparent; outline:0;
      padding:0; 
    }
    .form__input::placeholder{color:#cfc6bf; opacity:.55} 
    .form__input:focus{outline:2px solid rgba(139,111,99,.18); outline-offset:2px}
    .form__error{color:#c0392b; font-size:13px; margin-top:6px}
  </style>

  {{-- ページ専用CSS/JS 挿し込み口 --}}
  @yield('head')
</head>

<body class="@yield('body_class')">

  <header class="site-header" role="banner">
    <div class="l-container site-header__inner">
      <a class="site-header__brand" href="{{ url('/') }}">FashionablyLate</a>

      <nav class="site-header__nav" aria-label="User">
        @auth
          {{-- ログイン中：logout / admin --}}
          <form class="site-header__form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="site-header__button" type="submit">logout</button>
          </form>
          <a class="site-header__link" href="{{ route('admin.index') }}">admin</a>
        @else
          {{-- 未ログイン：login / register --}}
          <a class="site-header__link" href="{{ route('login') }}">login</a>
          <a class="site-header__link" href="{{ route('register') }}">register</a>
        @endauth
      </nav>
    </div>
  </header>

  @yield('content')

</body>
</html>
