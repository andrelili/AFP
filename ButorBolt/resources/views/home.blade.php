<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kezdőlap</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
            <div class="icon" title="Kedvencek">❤️</div>
            <div class="icon" title="Szűrés">⌛</div>
        </div>

        <div class="center-group">
            <div class="search-box">
                <input type="text" placeholder="Keresés...">
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


            <button class="btn-nav" id="btnOpenLogin" type="button">Bejelentkezés</button>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav primary">Regisztráció</a>
            @else
                <a href="{{ url('/register') }}" class="btn-nav primary">Regisztráció</a>
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

        <section class="section">
            <div class="product-grid">
                @foreach ($products as $p)
                <div class="product-card">
                    <div class="product-img" style="background-image:url('{{ $p['img'] }}')"></div>
                    <div class="product-info">
                        <h3>{{ $p['name'] }}</h3>
                        <div class="price">{{ number_format($p['price'], 0, '', ' ') }} Ft</div>
                        <div class="actions">
                            <form method="POST" action="{{ Route::has('bag.add') ? route('bag.add', ['id' => $p['id']]) : url('/bag/add/'.$p['id']) }}">
                                @csrf
                                <button type="submit" class="btn-nav">Kosárba</button>
                            </form>
                            <a class="btn-nav primary" href="{{ Route::has('items.show') ? route('items.show', ['id' => $p['id']]) : url('/items/'.$p['id']) }}">Megnézem</a>
                        </div>
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
        const btnOpen = document.getElementById('btnOpenLogin');
        const btnClose = document.getElementById('closeModal');
        const btnLogin = document.getElementById('loginSubmit');
        const welcomeText = document.getElementById('welcomeText');
        const profileIcon = document.getElementById('profileIcon');


        btnOpen.addEventListener('click', () => {
            modal.style.display = 'flex';
        });


        btnClose.addEventListener('click', () => {
            modal.style.display = 'none';
        });


        window.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = 'none';
        });


        btnLogin.addEventListener('click', () => {
            const username = document.getElementById('username').value.trim();
            if (username) {
                welcomeText.textContent = `Üdv, ${username}!`;
                modal.style.display = 'none';


                profileIcon.style.display = 'inline-flex';


                btnOpen.style.display = 'none';
                document.querySelector('.btn-nav.primary').style.display = 'none';
            } else {
                alert('Kérlek add meg a felhasználóneved!');
            }
        });
    </script>

    <style>
        .home-wrap{padding: 24px;}
        .hero-card{background:#fff;border-radius:16px;padding:24px;margin:16px 0;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .hero-text h1{margin:0 0 8px}
        .section{margin:32px 0}
        .product-grid{display:grid;grid-template-columns:repeat(1,1fr);gap:16px}
        @media(min-width:700px){.product-grid{grid-template-columns:repeat(2,1fr)}}
        @media(min-width:1100px){.product-grid{grid-template-columns:repeat(4,1fr)}}
        .product-card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,.06);display:flex;flex-direction:column}
        .product-img{width:100%;padding-top:70%;background-size:cover;background-position:center}
        .product-info{padding:14px;display:flex;flex-direction:column;gap:10px}
        .price{font-weight:600}
        .actions{display:flex;gap:10px}
        .footer{margin-top:32px;border-top:1px solid #e8e8e8}
        .footer-inner{display:flex;justify-content:space-between;align-items:center;padding:12px 16px}
        .footer-links{display:flex;gap:12px}
        .footer a{text-decoration:none}
    </style>
</body>
</html>
