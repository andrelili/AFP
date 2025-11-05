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
    {{-- TERMÉK ADATLAP --}}
    <div class="item-detail">
        <div class="item-image">
            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}">
        </div>
        <div class="item-info">
            <h1>{{ $item['name'] }}</h1>
            <div class="price">{{ number_format($item['price'], 0, '', ' ') }} Ft</div>
            <p class="desc">{{ $item['desc'] ?? 'Ez a termék jelenleg nem rendelkezik leírással.' }}</p>

            <div style="font-weight: 600">Raktáron: {{$stock}} db</div>

            @if($stock > 0)
                <form method="POST" action="{{ url('/bag/add/'.$item['id']) }}" class="add-to-cart-form">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <label for="qty" style="font-weight: 600;">Mennyiség:</label>
                        <input type="number" id="qty" name="qty" value="1" min="1" max="{{$stock}}"
                            style="width: 70px; padding: 5px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>
                    <button type="submit" class="btn-nav primary">Kosárba</button>
                </form>
            @else
                <p>Nincs raktáron</p>
            @endif
            <a href="{{ route('home') }}" class="btn-nav">← Vissza a főoldalra</a>
        </div>
    </div>

    {{-- === ÉRTÉKELÉSI SZEKCIÓ KEZDETE === --}}
    <div class="item-detail rating-section">
        <h2>Értékelések</h2>

        {{-- Példa értékelések (ezt a backend fogja feltölteni) --}}
        <div class="review-list">
            <h4>Korábbi értékelések (Példa)</h4>
            
            <div class="review-item">
                <div class="stars">★★★★☆</div> {{-- 4 csillag --}}
                <small>Vásárló Neve - 2025-10-28</small>
                <p>Nagyon kényelmes, bár a színe egy kicsit sötétebb, mint a képen.</p>
            </div>

            <div class="review-item">
                <div class="stars">★★★★★</div> {{-- 5 csillag --}}
                <small>Másik Vásárló - 2025-10-25</small>
                <p>Tökéletes! Pont ilyet kerestem. Gyors szállítás.</p>
            </div>
        </div>

        {{-- Értékelés beküldése űrlap --}}
        <div class="rating-form" style="margin-top: 30px;">
            <h4>Értékelés írása</h4>
            
            {{-- A backend majd ide helyezi a <form action="..." method="POST"> taget --}}
            {{-- @csrf --}}
            
            {{-- Rejtett mező a csillagok értékének tárolására (1-5) --}}
            <input type="hidden" name="rating" id="ratingInput" value="0">
            
            <div class="star-rating" id="starRating">
                <span data-value="1">★</span>
                <span data-value="2">★</span>
                <span data-value="3">★</span>
                <span data-value="4">★</span>
                <span data-value="5">★</span>
            </div>
            
            <textarea name="comment" placeholder="Írd le a véleményed... (pl. minőség, kényelem, stb.)"></textarea>
            
            {{-- Ezt a gomb stílust a register.css-ből vesszük --}}
            <button type="submit" class="btn-nav primary" style="margin-top: 10px;">Értékelés elküldése</button>
            
            {{-- </form> --}}
        </div>
    </div>
    {{-- === ÉRTÉKELÉSI SZEKCIÓ VÉGE === --}}

</main>

{{-- === JAVASCRIPT A CSILLAGOKHOZ === --}}
<script>
    const starRatingContainer = document.getElementById('starRating');
    const ratingInput = document.getElementById('ratingInput');
    
    // Ellenőrizzük, hogy léteznek-e az elemek (ez jó gyakorlat)
    if (starRatingContainer && ratingInput) {
        const stars = starRatingContainer.querySelectorAll('span');

        // Kattintás esemény
        starRatingContainer.addEventListener('click', (e) => {
            // Ellenőrizzük, hogy biztosan egy csillagra (span) kattintott-e
            if (e.target.tagName === 'SPAN') {
                const value = e.target.getAttribute('data-value');
                ratingInput.value = value; // Beállítjuk a rejtett input értékét
                
                // Frissítjük a csillagok 'selected' class-át
                stars.forEach((star, index) => {
                    if (index < value) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }
        });

        // Egérrávitel (hover) esemény
        starRatingContainer.addEventListener('mouseover', (e) => {
            if (e.target.tagName === 'SPAN') {
                const value = e.target.getAttribute('data-value');
                // Színezi az összes csillagot a hover-eltig (inline stílussal)
                stars.forEach((star, index) => {
                    if (index < value) {
                        star.style.color = '#ffc107'; // Sárga
                    } else {
                        star.style.color = '#ccc'; // Szürke
                    }
                });
            }
        });

        // Egér elhagyja a csillagokat (mouseout) esemény
        starRatingContainer.addEventListener('mouseout', () => {
            // Visszaállítja a csillagokat a CSS class ('selected') alapján
            stars.forEach((star) => {
                star.style.color = ''; // Törli az inline stílust
            });
        });
    }
</script>

</body>
</html>