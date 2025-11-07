<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kezdőlap</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }
        .category-buttons .btn-nav {
            background-color: #fff;
            border: 1px solid #ccc;
        }
        .category-buttons .btn-nav.active {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }
        .modal-bg {
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            max-width: 90%;
            position: relative;
        }
        .modal-close {
            position: absolute;
            top:10px;
            right:15px;
            font-size: 20px;
            cursor: pointer;
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
        .heart-btn {
            font-size: 18px;
            line-height: 1;
            padding: 6px 10px;
            background-color: #fff;
        }
        .heart-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .heart-btn svg {
            transition: fill 0.3s ease;
        }
        .heart-btn.active svg {
            fill: black;
            stroke: black;
        }
        .heart-btn.active svg {
    animation: pulse 1s ease infinite alternate;
}

@keyframes pulse {
    0% { transform: scale(1); }
    100% { transform: scale(1.1); }
}
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="Logo">
        </a>
        <div class="menu-icon" title="Menü">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <a href="{{ route('favourites.index') }}" class="icon" title="Kedvencek">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
            </svg>
        </a>

        <div class="icon" title="Szűrés">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="black">
                <path d="M3 4h18l-7 8v7l-4 2v-9L3 4z"/>
            </svg>
        </div>
    </div>

    <div class="center-group">
        <div class="category-dropdown">
            <button class="dropdown-toggle" id="categoryDropdownToggle">
                Kategóriák ▾
            </button>
            <div class="dropdown-content" id="categoryDropdownMenu">
                <a data-category="all">Összes</a>
                @foreach ($categories as $category)
                    <a data-category="{{ $category }}">{{ $category }}</a>
                @endforeach
            </div>
        </div>
        <div class="search-box">
            <input type="text" placeholder="Keresés..." id="searchInput">
            <div class="suggestions-box" id="suggestionsBox"></div>
        </div>
    </div>

    <div class="right-group">
        <div class="icon" title="Kosár">
            <a href="{{ Route::has('bag.index') ? route('bag.index') : url('/bag') }}" style="text-decoration:none; color:inherit;">
                🛒
                @php $cnt = session('cart_count', collect(session('cart', []))->sum('qty')); @endphp
                @if($cnt > 0)
                    <span style="font-weight:700;">({{ $cnt }})</span>
                @endif
            </a>
        </div>

        @guest
            <button class="btn-nav" id="btnOpenLogin" type="button">Bejelentkezés</button>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav">Regisztráció</a>
            @else
                <a href="{{ url('/register') }}" class="btn-nav">Regisztráció</a>
            @endif
        @else
            <div class="profile-menu">
                <div class="profile-circle" id="profileToggle" title="Profil">
                    @if (session('admin_mode') && Auth::user()->is_admin)
                        <img src="{{ asset('images/adminkep.jpg') }}" alt="Admin" class="profile-img">
                    @elseif (Auth::user()->profile_picture)
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

<main class="home-wrap">
    <section class="hero-card" style="margin-top: 120px;">
        <div class="hero-text">
            <h1 id="welcomeText">Üdvözlünk a ButorBoltban!</h1>
            <p>Fedezd fel minőségi bútorainkat – modern, skandináv és klasszikus stílusban, elérhető áron!</p>
        </div>
    </section>

    <section class="category-buttons" id="categoryButtons">
         <button class="btn-nav active" data-category="all">Összes</button>
         @foreach ($categories as $category)
            <button class="btn-nav" data-category="{{ $category }}">{{ $category }}</button>
         @endforeach
    </section>

    <section class="section">
        <div class="product-grid">
            @foreach ($products as $p)
            <div class="product-card" data-category="{{ $p['category'] }}">
                <a href="{{ Route::has('items.show') ? route('items.show', ['id' => $p['id']]) : url('/items/'.$p['id']) }}"
                   style="text-decoration: none; color: inherit;">
                    <div class="product-img" style="background-image:url('{{ $p['img'] }}')"></div>
                    <div class="product-info">
                        <h3>{{ $p['name'] }}</h3>
                        <div class="price">{{ number_format($p['price'], 0, '', ' ') }} Ft</div>
                    </div>
                </a>
                <div class="actions" style="padding: 0 14px 14px;">
                    <form method="POST" action="{{ Route::has('bag.add') ? route('bag.add', ['id' => $p['id']]) : url('/bag/add/'.$p['id']) }}">
                        @csrf
                        <button type="submit" class="btn-nav">Kosárba</button>
                    </form>
                    <a class="btn-nav" href="{{ Route::has('items.show') ? route('items.show', ['id' => $p['id']]) : url('/items/'.$p['id']) }}">Megnézem</a>
                    @php
                        $favourites = session('favourites', []);
                        $isFavourited = isset($favourites[$p['id']]);
                    @endphp

@auth
<button type="button"
        class="btn-nav heart-btn {{ $isFavourited ? 'active' : '' }}"
        data-id="{{ $p['id'] }}"
        data-name="{{ $p['name'] }}"
        data-price="{{ $p['price'] }}"
        data-img="{{ $p['img'] }}"
        data-category="{{ $p['category'] }}"
        data-favourited="{{ $isFavourited ? 'true' : 'false' }}"
        title="Kedvencekhez adás">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
         viewBox="0 0 24 24" fill="none" stroke="black"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         class="heart-icon">
        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1
                 a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21
                 l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"/>
    </svg>
</button>
@else
<button type="button" class="btn-nav heart-btn disabled"
    title="Csak bejelentkezve használható"
    onclick="showLoginModalWithMessage('Kedvencekhez adáshoz jelentkezz be!')">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
    </svg>
</button>
@endauth
                </div>
            </div>
            @endforeach
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-inner">
        <div>© {{ date('Y') }} ButorBolt</div>
    </div>
</footer>

<div class="modal-bg" id="loginModal">
    <div class="modal">
        <span class="modal-close" id="closeModal">&times;</span>
        <h3>Bejelentkezés</h3>
        <form method="POST" action="{{ Route::has('login') ? route('login') : url('/login') }}">
            @csrf
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

<script>
    const modal = document.getElementById('loginModal');
    const btnOpen = document.getElementById('btnOpenLogin');
    const btnClose = document.getElementById('closeModal');
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestionsBox');
    const products = @json($products ?? []);

    if (btnOpen) btnOpen.addEventListener('click', () => modal.style.display = 'flex');
    if (btnClose) btnClose.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', e => { if (modal && e.target === modal) modal.style.display = 'none'; });

    @if($errors->any() && $errors->hasBag('default'))
    document.addEventListener('DOMContentLoaded', () => modal.style.display = 'flex');
    @endif
    @if (session('login_required'))
    document.addEventListener('DOMContentLoaded', () => {
        modal.style.display = 'flex';
    });
    @endif

    if (profileToggle) {
        profileToggle.addEventListener('click', () => {
            profileDropdown.style.display = (profileDropdown.style.display === 'block') ? 'none' : 'block';
        });
        window.addEventListener('click', e => {
            if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        suggestionsBox.innerHTML = '';
        if (query === '') { suggestionsBox.style.display = 'none'; return; }
        const filtered = products.filter(p => p.name.toLowerCase().includes(query));
        if (filtered.length === 0) { suggestionsBox.style.display = 'none'; return; }
        filtered.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('suggestion-item');
            div.textContent = item.name;
            div.addEventListener('click', () => { window.location.href = `{{ url('/items') }}/${item.id}`; });
            suggestionsBox.appendChild(div);
        });
        suggestionsBox.style.display = 'block';
    });
    searchInput.addEventListener('blur', () => setTimeout(() => suggestionsBox.style.display = 'none', 100));

    const categoryButtonsContainer = document.getElementById('categoryButtons');
    const productCards = document.querySelectorAll('.product-card');
    const categoryButtons = categoryButtonsContainer.querySelectorAll('.btn-nav');
    if (categoryButtonsContainer) {
        categoryButtonsContainer.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const selectedCategory = event.target.getAttribute('data-category');
                categoryButtons.forEach(b => b.classList.remove('active'));
                event.target.classList.add('active');
                productCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    card.style.display = (selectedCategory === 'all' || cardCategory === selectedCategory) ? 'flex' : 'none';
                });
            }
        });
    }

    const dropdownMenu = document.getElementById('categoryDropdownMenu');
    if (dropdownMenu) {
        dropdownMenu.addEventListener('click', (event) => {
            if (event.target.tagName === 'A') {
                event.preventDefault();
                const selectedCategory = event.target.getAttribute('data-category');
                const mainButton = document.querySelector(`#categoryButtons .btn-nav[data-category="${selectedCategory}"]`);
                if (mainButton) mainButton.click();
            }
        });
    }
document.addEventListener('DOMContentLoaded', () => {
    const heartButtons = document.querySelectorAll('.heart-btn:not(.disabled)');

    heartButtons.forEach(btn => {
        const id = btn.dataset.id;
        if (localStorage.getItem(`favourite_${id}`)) {
            btn.classList.add('active');
            const svg = btn.querySelector('svg path');
            svg.setAttribute('fill', 'black');
        }
    });
    heartButtons.forEach(btn => {
        btn.addEventListener('click', async function () {
            const id = this.dataset.id;
            const isActive = this.classList.contains('active');

            if (isActive) {
                try {
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
                } catch (err) {
                    console.error(err);
                }
                return;
            }
            try {
                const response = await fetch(`/favourites/add/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: btn.dataset.name,
                        price: btn.dataset.price,
                        img: btn.dataset.img,
                        category: btn.dataset.category
                    })
                });

                if (response.ok) {
                    this.classList.add('active');
                    this.querySelector('svg path').setAttribute('fill', 'black');
                    localStorage.setItem(`favourite_${id}`, 'true');
                } else {
                    alert('Hiba történt a kedvenchez adás közben.');
                }
            } catch (error) {
                console.error('Hálózati hiba:', error);
            }
        });
    });
});
function showLoginModalWithMessage(message) {
    const modal = document.getElementById('loginModal');
    const errorContainer = modal.querySelector('.modal-error');

    if (errorContainer) {
        errorContainer.textContent = message;
    } else {

        const form = modal.querySelector('form');
        const div = document.createElement('div');
        div.className = 'modal-error';
        div.style.color = '#b00020';
        div.style.marginBottom = '10px';
        div.textContent = message;
        form.insertBefore(div, form.firstChild.nextSibling);
    }

    modal.style.display = 'flex';
}
</script>

</body>
</html>
