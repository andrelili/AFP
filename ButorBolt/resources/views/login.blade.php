<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
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
            <div class="icon" title="Kosár">🛒</div>
            <button id="btnOpenLogin" class="btn-nav">Bejelentkezés</button>
            <button class="btn-nav primary">Regisztráció</button>
            <div class="profile-circle" title="Profil">👤</div>
        </div>
    </header>

    <main class="form-container">

        <h2 id="welcomeText">
            Üdv, {{ Auth::user()->name ?? 'Vendég' }}!
        </h2>

        <div class="grey-box">

        </div>
    </main>

    <div class="modal-bg" id="loginModal">
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


        btnOpen.addEventListener('click', () => {
            modal.style.display = 'flex';
        });


        btnClose.addEventListener('click', () => {
            modal.style.display = 'none';
        });


        btnLogin.addEventListener('click', () => {
            const username = document.getElementById('username').value.trim();
            if(username) {
                welcomeText.textContent = `Üdv, ${username}!`;
                modal.style.display = 'none';
            } else {
                alert('Kérlek add meg a felhasználóneved!');
            }
        });


        window.addEventListener('click', (e) => {
            if(e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

</body>
</html>
