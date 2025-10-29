<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés leadása – ButorBolt</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
        <div class="icon" title="Kedvencek">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
            </svg>
        </div>
        <div class="icon" title="Szűrés">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="black">
                <path d="M3 4h18l-7 8v7l-4 2v-9L3 4z"/>
            </svg>
        </div>
    </div>

    <div class="right-group">
        <div class="profile-circle" id="profileIcon" title="Profil">👤</div>
    </div>
</header>

<main class="home-wrap" style="margin-top: 120px; text-align:center;">
    <div style="display: flex; flex-direction: column; align-items: center; gap: 40px; max-width:500px; margin:auto;">

        <div class="form-container" style="text-align:left;">
            <h2>Rendelés leadása</h2>
            <p>Kérjük, add meg a rendeléshez szükséges adatokat:</p>

            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-field">
                        <input type="text" name="name" placeholder="Teljes név" required>
                    </div>
                    <div class="form-field">
                        <input type="email" name="email" placeholder="Email cím" required>
                    </div>
                    <div class="form-field">
                        <input type="text" name="phone" placeholder="Telefonszám" required>
                    </div>
                    <div class="form-field">
                        <input type="text" name="address" placeholder="Szállítási cím" required>
                    </div>
                    <div class="form-field">
                        <input type="text" name="billing_address" placeholder="Számlázási cím" required>
                    </div>
                    <div class="form-field">
                        <select name="payment_method" required>
                            <option value="">Fizetési mód kiválasztása</option>
                            <option value="card">Bankkártya</option>
                            <option value="cod">Utánvét</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-register" style="width:100%;">Rendelés leadása</button>
            </form>
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
