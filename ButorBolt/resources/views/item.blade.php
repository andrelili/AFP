<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item['name'] }} – ButorBolt</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{asset('css/item.css')}}">
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="">
        </a>
        <div class="menu-icon" title="Menü">
            <span></span><span></span><span></span>
        </div>
        <div class="icon" title="Kedvencek">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
            </svg>
        </div>
        <div class="icon" title="Szűrés">
            <svg xmlns="http://www.w3.org/2000/svg"
            width="22" height="22"
            viewBox="0 0 24 24"
            fill="black">
            <path d="M3 4h18l-7 8v7l-4 2v-9L3 4z"/>
            </svg>
        </div>
    </div>

    <div class="center-group">
        <div class="search-box"><input type="text" placeholder="Keresés..."></div>
    </div>

    <div class="right-group">
        <div class="icon" title="Kosár">
  <a href="{{ route('bag.index') }}" style="text-decoration:none; color:inherit;">
    🛒
    @php $cnt = session('cart_count', collect(session('cart', []))->sum('qty')); @endphp
    @if($cnt > 0)
      <span style="font-weight:700;">({{ $cnt }})</span>
    @endif
  </a>
</div>

        <a href="{{ url('/login') }}" class="btn-nav">Bejelentkezés</a>
        <a href="{{ url('/register') }}" class="btn-nav primary">Regisztráció</a>
        <div class="profile-circle" title="Profil">👤</div>
    </div>
</header>

<main class="home-wrap" style="margin-top:120px;">
    <div class="item-detail">
        <div class="item-image">
            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}">
        </div>
        <div class="item-info">
            <h1>{{ $item['name'] }}</h1>
            <div class="price">{{ number_format($item['price'], 0, '', ' ') }} Ft</div>
            <p class="desc">{{ $item['desc'] ?? 'Ez a termék jelenleg nem rendelkezik leírással.' }}</p>

            <form method="POST" action="{{ url('/bag/add/'.$item['id']) }}">
                @csrf
                <button type="submit" class="btn-nav primary">Kosárba</button>
            </form>
            <a href="{{ route('home') }}" class="btn-nav">← Vissza a főoldalra</a>
        </div>
    </div>
</main>

</body>
</html>
