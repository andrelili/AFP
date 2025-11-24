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

.modal-bg.active {
    display: flex;
}


.modal-bg {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 2000;
    justify-content: center;
    align-items: center;
}

.modal {
    background: #e9ecef;
    border: 3px solid black;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    padding: 30px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    position: relative;
}

.modal h3 {
    text-align: center;
    margin-bottom: 20px;
}

.modal .form-field input {
    width: 85%;
    height: 45px;
    border: 2px solid #000;
    border-radius: 5px;
    padding: 0 14px;
    font-size: 16px;
    outline: none;
    background-color: #fff;
    margin-bottom: 15px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    cursor: pointer;
    font-weight: bold;
}

.review-container {
    max-width: 700px;
    margin: 20px auto;
    padding: 15px;
    background: #fafafa;
    border-radius: 8px;
}

.review {
    margin-bottom: 15px;
    padding: 12px 15px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.review strong {
    font-size: 16px;
}

.review p {
    margin: 8px 0;
}

.review small {
    color: #777;
    font-size: 13px;
}

.rating-form,
.rating-guest {
    max-width: 700px;
    margin: 20px auto;
    padding: 20px;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.rating-form h4 {
    margin-bottom: 10px;
}

.rating-form textarea {
    width: 100%;
    min-height: 100px;
    border-radius: 6px;
    padding: 10px;
    border: 1px solid #ccc;
}

.star-rating span {
    font-size: 26px;
    cursor: pointer;
    padding: 3px;
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
            <button type="button" class="btn-nav btnOpenLogin">Bejelentkezés</button>
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

<div class="modal-bg" id="loginModal">
    <div class="modal">
        <span class="modal-close" id="closeModal">&times;</span>
        <h3>Bejelentkezés</h3>
        <form method="POST" action="{{ Route::has('login') ? route('login') : url('/login') }}">
            @csrf
            <input type="hidden" name="return_to" value="{{ url()->current() }}">
            <div class="form-field">
                <input type="text" name="username" id="username" placeholder="Felhasználónév" required>
            </div>
            <div class="form-field">
                <input type="password" name="password" id="password" placeholder="Jelszó" required>
            </div>
            @if($errors->any())
                <div class="modal-error" style="color:#b00020; margin-bottom:10px;">
                    {{ $errors->all()[0] }}
                </div>
            @endif
            @if (session('login_required'))
                <div class="modal-error" style="color:#b00020; margin-bottom:10px;">
                    {{ session('login_required') }}
                </div>
            @endif
            <button class="btn-login" type="submit">Bejelentkezés</button>
            <button class="btn-admin" type="submit" value="1" name="admin_login">Admin</button>
        </form>
    </div>
</div>

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
    @auth
        <form method="POST" action="{{ url('/items/'.$item['id'].'/review') }}" class="rating-form" style="margin-top: 30px;">
            @csrf
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
        </form>
    @else
        <div class="rating-guest" style="margin-top:30px;">
            <p>Értékelés íráshoz jelentkezz be.</p>
            <button type="button" class="btn-nav btnOpenLogin">Bejelentkezés</button>
        </div>
    @endauth
@php
    // Prefer reviews passed from the controller; fall back to an empty collection/array.
    $reviews = isset($reviews) ? $reviews : collect();

    $count = $reviews instanceof \Illuminate\Support\Collection
        ? $reviews->count()
        : count($reviews);

    $avgRating = 0;
    if ($count > 0) {
        $sum = $reviews instanceof \Illuminate\Support\Collection
            ? $reviews->sum('rating')
            : array_sum(array_column($reviews, 'rating'));
        $avgRating = round($sum / $count, 1);
    }
@endphp

@if($count > 0)
    <div class="review-container">
       <h4>
            Vásárlói értékelések
            <br>
            <strong style="font-size:20px;">
                Átlag: {{ $avgRating }} ★
            </strong>
        </h4>

        @foreach($reviews as $review)
            @php
                if (is_object($review)) {
                    if (!empty($review->user_name)) {
                        $rUser = $review->user_name;
                    } elseif (isset($review->user) && is_object($review->user) && !empty($review->user->username)) {
                        $rUser = $review->user->username;
                    } elseif (isset($review->user) && is_object($review->user) && !empty($review->user->name)) {
                        $rUser = $review->user->name;
                    } else {
                        $rUser = $review['user'] ?? 'Vendég';
                    }
                } else {
                    $rUser = $review['user'] ?? ($review['user_name'] ?? 'Vendég');
                }

                $rRating = $review->rating ?? ($review['rating'] ?? 0);
                $rComment = $review->comment ?? ($review['comment'] ?? '');
                if (isset($review->created_at) && method_exists($review->created_at, 'format')) {
                    $rDate = $review->created_at->format('Y-m-d H:i');
                } else {
                    $rDate = $review['date'] ?? ($review['created_at'] ?? '');
                }
            @endphp
            <div class="review">
                <strong>{{ $rUser }}</strong> – {{ $rRating }}★
                <p>{{ $rComment }}</p>
                <small>{{ $rDate }}</small>
            </div>
        @endforeach
    </div>
@endif


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
    const loginModal = document.getElementById('loginModal');
    const openLoginBtns = document.querySelectorAll('.btnOpenLogin');
    const closeBtn = document.getElementById('closeModal');

    openLoginBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            loginModal.classList.add('active'); // show modal
        });
    });

    closeBtn.addEventListener('click', () => {
        loginModal.classList.remove('active'); // close modal
    });

    window.addEventListener('click', e => {
        if(e.target === loginModal) {
            loginModal.classList.remove('active'); // close when clicking outside
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
@if(session('login_required') || $errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('loginModal');
        if(modal) modal.classList.add('active');
    });
</script>
@endif
</body>
</html>
