<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikeres rendelés</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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

    <div class="right-group">
        <div class="profile-circle" id="profileIcon" title="Profil" style="display:none;">👤</div>
    </div>
</header>

<main class="home-wrap" style="margin-top: 100px; text-align:center;">
    <div style="margin-top: 100px; display: flex; flex-direction: column; align-items: center; gap: 40px;">


        <div class="order-box">
            <div class="checkmark">✔️</div>
            <div style="text-align:left;">
                <h2>Sikeres rendelés!</h2>
                <p>Köszönjük, hogy nálunk vásároltál!</p>
            </div>
        </div>


        <div class="forgot-box"
             onclick="window.location='{{ route('home') }}';"
             title="Vissza a főoldalra">
            <div>⬅️</div>
            <div>Valamit elfelejtettem!</div>
        </div>

    </div>
</main>

<footer class="footer" style="margin-top:60px;">
    <div class="footer-inner">
        <div>© {{ date('Y') }} ButorBolt</div>
    </div>
</footer>

</body>
</html>
