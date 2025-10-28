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
                        {{-- <small style="color: #6c757d;">Kategória: {{ $p['category'] }}</small> --}}
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

<div class="modal-bg" id="loginModal" style="display:none;">
    <div class="modal">
        <span class="modal-close" id="closeModal">&times;</span>
        <h3>Bejelentkezés</h3>
        <div class="form-field">
            <input type="text" id="username" placeholder="Felhasználónév">
        </div>
        <div class="form-field">
            <input type="password" id="password" placeholder="Jelszó">
        </div>
        <button class="btn-login" id="loginSubmit">Bejelentkezés</button>
    </div>
</div>

<script>
    const modal = document.getElementById('loginModal');
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestionsBox');

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

    if (btnOpen) {
        btnOpen.addEventListener('click', () => {
            modal.style.display = 'flex';
        });
    }
     if (btnClose) {
        btnClose.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

     window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });

     if (btnLogin) {
        btnLogin.addEventListener('click', () => {
            const username = document.getElementById('username').value.trim();
            if (username) {
                welcomeText.textContent = `Üdv, ${username}!`;
                modal.style.display = 'none';
                profileIcon.style.display = 'inline-flex';
            } else {
                alert('Kérlek add meg a felhasználóneved!');
            }
        });
    }


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
                if (selectedCategory === 'all' || cardCategory === selectedCategory) {
                    card.style.display = 'flex'; 
                } else {
                    card.style.display = 'none';
                }
            });
        }
    });

</script>

</body>
</html>
