<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item['name'] }} – ButorBolt</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
        <div class="icon" title="Kedvencek">❤️</div>
        <div class="icon" title="Szűrés">⌛</div>
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

<style>
.item-detail{display:flex;flex-direction:column;gap:20px;background:#fff;padding:24px;border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,.06)}
.item-image img{width:100%;border-radius:12px;object-fit:cover}
.item-info{display:flex;flex-direction:column;gap:12px}
.item-info h1{margin:0;font-size:1.8rem}
.price{font-weight:600;font-size:1.2rem}
.desc{color:#555}
@media(min-width:900px){
    .item-detail{flex-direction:row;align-items:flex-start}
    .item-image{flex:1}
    .item-info{flex:1;padding-left:24px}
}
</style>

</body>
</html>
