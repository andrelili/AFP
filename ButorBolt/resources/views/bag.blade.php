<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kosár – ButorBolt</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

<header class="topbar">
  <div class="left-group">
    <img class="logo" src="{{asset('images/butorlogo.png')}}" alt="ButorBolt logó">
    <div class="menu-icon"><span></span><span></span><span></span></div>
    <div class="icon">❤️</div><div class="icon">⌛</div>
  </div>
  <div class="center-group"><div class="search-box"><input type="text" placeholder="Keresés..."></div></div>
  <div class="right-group">
    <a href="{{ route('home') }}" class="btn-nav">Főoldal</a>
  </div>
</header>

<main class="home-wrap" style="margin-top:120px;">
  <section class="hero-card">
    <h1>Kosár</h1>
    @if(empty($cart))
      <p>A kosarad üres.</p>
      <a href="{{ route('home') }}" class="btn-nav primary">Vissza a vásárláshoz</a>
    @else
      <div class="cart-list" style="display:flex;flex-direction:column;gap:12px;">
        @foreach($cart as $row)
          <div class="cart-row" style="display:flex;gap:12px;align-items:center;background:#fff;border-radius:12px;padding:12px;box-shadow:0 6px 16px rgba(0,0,0,.06);">
            <img src="{{ $row['img'] }}" alt="{{ $row['name'] }}" style="width:100px;height:80px;object-fit:cover;border-radius:8px;">
            <div style="flex:1;">
              <div style="font-weight:600;">{{ $row['name'] }}</div>
              <div>{{ number_format($row['price'],0,'',' ') }} Ft</div>
            </div>
            <form method="POST" action="{{ route('bag.update', ['id'=>$row['id']]) }}" style="display:flex;gap:6px;align-items:center;">
              @csrf
              <input type="number" name="qty" value="{{ $row['qty'] }}" min="1" style="width:70px;padding:6px;border-radius:8px;border:1px solid #ddd;">
              <button class="btn-nav">Módosít</button>
            </form>
            <form method="POST" action="{{ route('bag.remove', ['id'=>$row['id']]) }}">
              @csrf
              <button class="btn-nav" style="background:#eee;">Törlés</button>
            </form>
          </div>
        @endforeach
      </div>

      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:16px;">
        <form method="POST" action="{{ route('bag.clear') }}">
          @csrf
          <button class="btn-nav">Kosár ürítése</button>
        </form>
        <div style="font-weight:700;font-size:1.1rem;">Összesen: {{ number_format($total,0,'',' ') }} Ft</div>
      </div>
    @endif
  </section>
</main>

</body>
</html>
