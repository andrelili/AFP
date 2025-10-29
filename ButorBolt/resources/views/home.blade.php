<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="">
        </a>
        <div class="menu-icon" title="Menü">
            <span></span>
            <span></span>
            <span></span>
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

        <button class="btn-nav" id="btnOpenLogin" type="button">Bejelentkezés</button>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-nav">Regisztráció</a>
        @else
            <a href="{{ url('/register') }}" class="btn-nav">Regisztráció</a>
        @endif

        <div class="profile-circle" id="profileIcon" title="Profil" style="display:none;">👤</div>
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
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-field">
                <input type="text" name="username" id="username" placeholder="Felhasználónév" required>
            </div>
            <div class="form-field">
                <input type="password" name="password" id="password" placeholder="Jelszó" required>
            </div>
            @if($errors->any())
                <div class="modal-error" style="color:#b00020; margin-bottom:10px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <button class="btn-login" type="submit">Bejelentkezés</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('loginModal');
    const btnOpen = document.getElementById('btnOpenLogin');
    const btnClose = document.getElementById('closeModal');
    const profileIcon = document.getElementById('profileIcon');
    const welcomeText = document.getElementById('welcomeText');
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestionsBox');

    if (btnOpen) {
        btnOpen.addEventListener('click', () => {
            if (modal) modal.style.display = 'flex';
        });
    }

    if (btnClose) {
        btnClose.addEventListener('click', () => {
            if (modal) modal.style.display = 'none';
        });
    }

    window.addEventListener('click', (e) => {
        if (modal && e.target === modal) modal.style.display = 'none';
    });

    @if($errors->any())
    document.addEventListener('DOMContentLoaded', function(){
        if (modal) modal.style.display = 'flex';
    });
    @endif

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        suggestionsBox.innerHTML = '';

        if (query === '') {
            suggestionsBox.style.display = 'none';
            return;
        }

        const filtered = products.filter(p => p.name.toLowerCase().includes(query));

        if (filtered.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }

        filtered.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('suggestion-item');
            div.textContent = item.name;
            div.addEventListener('click', () => {
                window.location.href = `{{ url('/items') }}/${item.id}`;
            });
            suggestionsBox.appendChild(div);
        });

        suggestionsBox.style.display = 'block';
    });

    searchInput.addEventListener('blur', () => {
        setTimeout(() => suggestionsBox.style.display = 'none', 100);
    });


    const categoryButtonsContainer = document.getElementById('categoryButtons');
    const productCards = document.querySelectorAll('.product-card');
    const categoryButtons = categoryButtonsContainer.querySelectorAll('.btn-nav');

    categoryButtonsContainer.addEventListener('click', (event) => {
        if (event.target.tagName === 'BUTTON') {
            const selectedCategory = event.target.getAttribute('data-category');

            categoryButtons.forEach(button => {
                button.classList.remove('active');
            });
            event.target.classList.add('active');

            productCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                card.style.display = (selectedCategory === 'all' || cardCategory === selectedCategory) ? 'flex' : 'none';
            });
        }
    });
</script>

</body>
</html>
