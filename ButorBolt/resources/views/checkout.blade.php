<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés leadása – ButorBolt</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        main.home-wrap {
            margin-top: 120px;
            text-align: center;
        }

        .form-container {
            text-align: left;
            width: 90%;
            max-width: 700px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media (min-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px 30px;
            }
        }

        .form-field input,
        .form-field select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .btn-register {
            background-color: #000;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-register:hover {
            background-color: #333;
        }

        /* --- Profil dropdown --- */
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
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="Logo">
        </a>
        </a>
        <a href="{{ route('favourites.index') }}" class="icon" title="Kedvencek">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
            </svg>
        </div>
    </div>

    <div class="right-group">
        @guest
            <a href="{{ route('login') }}" class="btn-nav">Bejelentkezés</a>
            <a href="{{ route('register') }}" class="btn-nav">Regisztráció</a>
        @else
            <div class="profile-menu">
                <div class="profile-circle" id="profileToggle">
                    👤
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
    <div style="display: flex; flex-direction: column; align-items: center; gap: 40px;">
        <div class="form-container">
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

                    <!-- Fizetés mód kiválasztása -->
                    <div class="form-field">
                        <select name="payment_method" id="payment_method" required>
                            <option value="">Fizetési mód kiválasztása</option>
                            <option value="card">Bankkártya</option>
                            <option value="cod">Utánvét</option>
                            <option value="paypal">Utalás</option>
                        </select>
                    </div>
                </div>

                <!-- Bankkártyás mezők -->
                <div id="card-fields" style="display:none; margin-top:20px;">
                    <div id="card-error" style="color:red; margin-bottom:10px; display:none;"></div>

                    <div class="form-field">
                        <input type="text" id="card_number" name="card_number" maxlength="19"
                               placeholder="Kártyaszám (xxxx xxxx xxxx xxxx)">
                    </div>

                    <div class="form-field">
                        <input type="text" id="expiry" name="expiry" maxlength="5"
                               placeholder="Lejárat (MM/YY)">
                    </div>

                    <div class="form-field">
                        <input type="text" id="cvv" name="cvv" maxlength="3"
                               placeholder="CVV (3 számjegy)">
                    </div>

                    <div class="form-field">
                        <input type="text" id="cardholder" name="cardholder"
                               placeholder="Kártyatulajdonos neve">
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

<script>
// Profil dropdown
document.getElementById('profileToggle')?.addEventListener('click', () => {
    const d = document.getElementById('profileDropdown');
    d.style.display = d.style.display === 'block' ? 'none' : 'block';
});


// Bankkártya mezők megjelenítése
document.getElementById('payment_method').addEventListener('change', function () {
    document.getElementById('card-fields').style.display =
        this.value === 'card' ? 'block' : 'none';
});


// Kártyaszám automatikus formázása
document.getElementById('card_number').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').substring(0, 16);
    this.value = v.replace(/(.{4})/g, '$1 ').trim();
});


// Lejárat automatikus MM/YY formázás
document.getElementById('expiry').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').substring(0, 4);
    if (v.length > 2) v = v.substring(0, 2) + '/' + v.substring(2);
    this.value = v;
});


// Hibaellenőrzés submit előtt
document.querySelector('form').addEventListener('submit', function (e) {
    const pm = document.getElementById('payment_method').value;
    const err = document.getElementById('card-error');

    if (pm !== 'card') return true;

    const card = document.getElementById('card_number').value.replace(/\s/g, '');
    const expiry = document.getElementById('expiry').value;
    const cvv = document.getElementById('cvv').value;
    const holder = document.getElementById('cardholder').value;

    let errors = [];

    if (!/^\d{16}$/.test(card)) errors.push("A kártyaszámnak 16 számjegyűnek kell lennie.");
    if (!/^\d{2}\/\d{2}$/.test(expiry)) errors.push("A lejáratnak MM/YY formátumúnak kell lennie.");
    if (!/^\d{3}$/.test(cvv)) errors.push("A CVV kódnak 3 számjegyűnek kell lennie.");
    if (holder.length < 5) errors.push("A kártyatulajdonos neve túl rövid.");

    if (errors.length > 0) {
        e.preventDefault();
        err.style.display = 'block';
        err.innerHTML = errors.join("<br>");
        return false;
    }
});
</script>

</body>
</html>
