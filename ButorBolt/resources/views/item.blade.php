<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item['name'] }} – ButorBolt</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.heart-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    width: 40px;
    border-radius: 8px;
    border: 1px solid #000;
    background-color: #fff;
    transition: all 0.2s ease;
    cursor: pointer;
    margin-left: 8px;
    vertical-align: middle;
    padding: 0;
}

.heart-btn:hover {
    background-color: #000;
}

.heart-btn:hover svg path {
    stroke: white;
}

.heart-btn.active svg path {
    fill: black;
    stroke: black;
}
.heart-btn.active svg {
    animation: pulse 0.6s ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.profile-menu {
    position: relative;
}
.profile-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    cursor: pointer;
    transition: background 0.3s;
}
.profile-circle:hover {
    background-color: #e0e0e0;
}
.profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.profile-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 50px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    z-index: 100;
    min-width: 150px;
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
    color: #333;
}
.profile-dropdown a:hover,
.profile-dropdown button:hover {
    background-color: #f0f0f0;
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
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
            </svg>
        </a>
    </div>


        <div class="search-wrapper" style="display: flex; align-items: center; gap: 5px;">
    <div class="icon" title="Szűrés">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="black">
            <path d="M3 4h18l-7 8v7l-4 2v-9L3 4z"/>
        </svg>
    </div>
    <div class="search-box">
        <input type="text" placeholder="Keresés..." id="searchInput">
        <div class="suggestions-box" id="suggestionsBox"></div>
    </div>
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

        @guest
            <a href="{{ route('login') }}" class="btn-nav">Bejelentkezés</a>
            <a href="{{ route('register') }}" class="btn-nav primary">Regisztráció</a>
        @else
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
        @endguest
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
                        @php
                            $favourites = session('favourites', []);
                            $isFavourited = isset($favourites[$item['id']]);
                        @endphp

                        @auth
                            <button type="button"
                                class="btn-nav heart-btn {{ $isFavourited ? 'active' : '' }}"
                                data-id="{{ $item['id'] }}"
                                data-name="{{ $item['name'] }}"
                                data-price="{{ $item['price'] }}"
                                data-img="{{ $item['img'] }}"
                                data-category="{{ $item['category'] ?? 'Egyéb' }}"
                                title="Kedvencekhez adás">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="black"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1
                                            a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21
                                            l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"/>
                                </svg>
                            </button>
                        @else
                            <button type="button" class="heart-btn disabled"
                                title="Csak bejelentkezve használható">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                     viewBox="0 0 24 24" fill="none" stroke="black"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1
                                             a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21
                                             l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"/>
                                </svg>
                            </button>
                        @endauth
                    </div>
                </form>
            @else
                <p>Nincs raktáron</p>
            @endif
            <a href="{{ route('home') }}" class="btn-nav">← Vissza a főoldalra</a>
        </div>
    </div>

    {{-- === ÉRTÉKELÉSI SZEKCIÓ === --}}
    <div class="item-detail rating-section">
        <h2>Értékelések</h2>
        <div class="review-list">
            <h4>Korábbi értékelések (Példa)</h4>
            <div class="review-item">
                <div class="stars">★★★★☆</div>
                <small>Vásárló Neve - 2025-10-28</small>
                <p>Nagyon kényelmes, bár a színe egy kicsit sötétebb, mint a képen.</p>
            </div>
            <div class="review-item">
                <div class="stars">★★★★★</div>
                <small>Másik Vásárló - 2025-10-25</small>
                <p>Tökéletes! Pont ilyet kerestem. Gyors szállítás.</p>
            </div>
        </div>

        <div class="rating-form" style="margin-top: 30px;">
            <h4>Értékelés írása</h4>
            <input type="hidden" name="rating" id="ratingInput" value="0">
            <div class="star-rating" id="starRating">
                <span data-value="1">★</span>
                <span data-value="2">★</span>
                <span data-value="3">★</span>
                <span data-value="4">★</span>
                <span data-value="5">★</span>
            </div>
            <textarea name="comment" placeholder="Írd le a véleményed... (pl. minőség, kényelem, stb.)"></textarea>
            <button type="submit" class="btn-nav primary" style="margin-top: 10px;">Értékelés elküldése</button>
        </div>
    </div>
</main>

{{-- === JAVASCRIPT === --}}
<script>
    const starRatingContainer = document.getElementById('starRating');
    const ratingInput = document.getElementById('ratingInput');
    if (starRatingContainer && ratingInput) {
        const stars = starRatingContainer.querySelectorAll('span');
        starRatingContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'SPAN') {
                const value = e.target.getAttribute('data-value');
                ratingInput.value = value;
                stars.forEach((star, index) => {
                    star.classList.toggle('selected', index < value);
                });
            }
        });
        starRatingContainer.addEventListener('mouseover', (e) => {
            if (e.target.tagName === 'SPAN') {
                const value = e.target.getAttribute('data-value');
                stars.forEach((star, index) => {
                    star.style.color = index < value ? '#ffc107' : '#ccc';
                });
            }
        });
        starRatingContainer.addEventListener('mouseout', () => {
            stars.forEach((star) => { star.style.color = ''; });
        });
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const heartBtn = document.querySelector('.heart-btn:not(.disabled)');
    if (!heartBtn) return;
    const id = heartBtn.dataset.id;
    if (localStorage.getItem(`favourite_${id}`)) {
        heartBtn.classList.add('active');
        heartBtn.querySelector('svg path').setAttribute('fill', 'black');
    }
    heartBtn.addEventListener('click', async function() {
        const isActive = this.classList.contains('active');
        if (isActive) {
            const response = await fetch(`/favourites/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                this.classList.remove('active');
                this.querySelector('svg path').setAttribute('fill', 'none');
                localStorage.removeItem(`favourite_${id}`);
            }
            return;
        }
        const response = await fetch(`/favourites/add/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: heartBtn.dataset.name,
                price: heartBtn.dataset.price,
                img: heartBtn.dataset.img,
                category: heartBtn.dataset.category
            })
        });
        if (response.ok) {
            this.classList.add('active');
            this.querySelector('svg path').setAttribute('fill', 'black');
            localStorage.setItem(`favourite_${id}`, 'true');
        } else {
            alert('Hiba történt a kedvenchez adás közben.');
        }
    });
});
</script>

<script>
const profileToggle = document.getElementById('profileToggle');
const profileDropdown = document.getElementById('profileDropdown');
if (profileToggle) {
    profileToggle.addEventListener('click', () => {
        profileDropdown.style.display =
            profileDropdown.style.display === 'block' ? 'none' : 'block';
    });
    window.addEventListener('click', e => {
        if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.style.display = 'none';
        }
    });
}
</script>

</body>
</html>
