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
        <div class="icon" title="Kedvencek">❤️</div>
        <div class="icon" title="Szűrés">⌛</div>
    </div>

    <div class="center-group">
        <div class="search-box">
            <input type="text" placeholder="Keresés...">
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
