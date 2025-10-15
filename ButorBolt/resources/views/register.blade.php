<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="css/register.css">
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
                <input type="text" placeholder="Keresés...">
            </div>
        </div>

        <div class="right-group">
            <div class="icon" title="Kosár">🛒</div>
            <div class="profile-circle" title="Profil">👤</div>
        </div>
    </header>

    <main class="form-container">
        <h4>Kérjük, adja meg az alábbi adatokat:</h4>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-grid">
                <div class="form-field">
                    <input type="text" placeholder="Vezetéknév">
                </div>
                <div class="form-field">
                    <input type="text" placeholder="Keresztnév">
                </div>
                <div class="form-field">
                    <input type="email" placeholder="Email">
                </div>
                <div class="form-field">
                    <input type="text" placeholder="Felhasználónév">
                </div>
                <div class="form-field">
                    <input type="password" placeholder="Jelszó">
                </div>
                <div class="form-field">
                    <input type="password" placeholder="Jelszó megerősítése">
                </div>
                <div class="form-field">
                    <input type="text" placeholder="Telefonszám">
                </div>
                <div class="form-field">
                    <input type="text" placeholder="Cím">
                </div>
            </div>

            <button type="submit" class="btn-register">Regisztráció</button>
        </form>
    </main>

</body>
</html>
