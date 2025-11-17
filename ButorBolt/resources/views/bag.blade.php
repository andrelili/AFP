<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kosár – ButorBolt</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <style>
    .profile-img {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
    }

    .profile-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 50px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 6px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      z-index: 10;
    }

    .profile-dropdown a,
    .profile-dropdown button {
      display: block;
      width: 100%;
      padding: 10px;
      text-align: left;
      background: none;
      border: none;
      cursor: pointer;
      text-decoration: none;
      color: black;
    }

    .profile-dropdown a:hover,
    .profile-dropdown button:hover {
      background-color: #f5f5f5;
    }

    .profile-menu {
      position: relative;
      margin-left: 10px;
    }
  </style>
</head>
<body>

<header class="topbar">
  <div class="left-group">
    <a href="{{ route('home') }}">
      <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="">
    </a>

    <a href="{{ route('favourites.index') }}" class="icon" title="Kedvencek">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
           viewBox="0 0 24 24" fill="none" stroke="black"
           stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
      </svg>
    </a>
  </div>

    @auth
      <div class="profile-menu">
        <div class="profile-circle" id="profileToggle">
          @if (Auth::user()->profile_picture)
            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profilkép" class="profile-img">
          @else
            👤
          @endif
        </div>
        <div class="profile-dropdown" id="profileDropdown">
          <a href="{{ route('profile.show') }}">Profilom</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Kijelentkezés</button>
          </form>
        </div>
      </div>
    @else
      <div class="profile-circle" title="Profil">👤</div>
    @endauth
  </div>
</header>

<main class="home-wrap">
<section class="hero-card" style="margin-top:120px;">
    <div class="hero-text">
        <h1>Kosár</h1>
        <p>Itt találod az összes kosárba helyezett termékedet.</p>
    </div>
</section>

@if(empty($cart))
        <section class="hero-card" style="margin-top:40px;">
            <div class="hero-text" style="text-align:center;">
                <p>A kosarad üres.</p>
                <p>Böngéssz a <a href="{{ route('home') }}">főoldalon</a> és adj hozzá pár terméket!</p>
            </div>
        </section>
@else

      <div class="cart-list" style="display:flex;flex-direction:column;gap:12px;">
        @foreach($cart as $id => $row)
          @php $availableStock = $stockMap[$id] ?? 0; @endphp
          <div class="cart-row" style="display:flex;gap:12px;align-items:center;background:#fff;border-radius:12px;padding:12px;box-shadow:0 6px 16px rgba(0,0,0,.06);">
            <a href="{{ route('items.show', ['id' => $row['id']]) }}">
              <img src="{{ $row['img'] }}" alt="{{ $row['name'] }}" style="width:100px;height:80px;object-fit:cover;border-radius:8px;">
            </a>
            <div style="flex:1;">
              <div style="font-weight:600;">{{ $row['name'] }}</div>
              <div>{{ number_format($row['price'],0,'',' ') }} Ft</div>
              <div style="font-size:.85rem;color:#666;">Elérhető: {{ $availableStock }} db</div>
            </div>
            <form method="POST" action="{{ route('bag.update', ['id'=>$row['id']]) }}" style="display:flex;gap:6px;align-items:center;">
              @csrf
              @if($availableStock > 0)
                <input type="number"
         name="qty"
         value="{{ $row['qty'] }}"
         min="1"
         max="{{ $availableStock }}"
         style="width:70px; padding:6px; border-radius:8px; border:1px solid #ddd;">
                <button type="submit" class="btn-nav">Módosítás</button>
              @else
                <input type="number" disabled value="0" style="width:70px; padding:6px; border-radius:8px; border:1px solid #ddd;">
                <button type="button" class="btn-nav" disabled style="opacity:.6;">Nincs készleten</button>
              @endif
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

        <form method="GET" action="{{ route('checkout.show') }}">
          @csrf
          <button class="btn-nav" style="background:#28a745;color:white;">Tovább a rendeléshez</button>
        </form>

        <div style="font-weight:700;font-size:1.1rem;">
          Összesen: {{ number_format($total,0,'',' ') }} Ft
        </div>
      </div>

    @endif
  </section>
</main>

<script>
  const profileToggle = document.getElementById('profileToggle');
  const profileDropdown = document.getElementById('profileDropdown');

  if (profileToggle) {
    profileToggle.addEventListener('click', () => {
      profileDropdown.style.display =
        profileDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.style.display = 'none';
      }
    });
  }
</script>

</body>
</html>
