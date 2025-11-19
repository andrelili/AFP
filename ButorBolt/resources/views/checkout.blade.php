<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Profil dropdown */
        .profile-menu {
            position: relative;
            margin-left: 10px;
        }

        .profile-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .profile-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
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
            text-decoration: none;
        }

        .profile-dropdown a:hover,
        .profile-dropdown button:hover {
            background-color: #f5f5f5;
        }

        /* Login modal */
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
        .modal-error {
            color:#b00020;
            margin-bottom:10px;
        }

        /* Guest figyelmeztetés */
        .guest-alert {
            border: 2px solid #f00;
            padding: 15px;
            text-align: center;
            border-radius: 12px;
            color: #b00020;
            font-weight: bold;
            margin-top: 20px;
        }

        .guest-alert a {
            color: #0000ff;
            text-decoration: underline;
            margin: 0 5px;
            cursor: pointer;
        }

        /* Kosár listázás */
        .cart-list {
            display:flex;
            flex-direction:column;
            gap:12px;
            margin-bottom: 40px;
            width: 90%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .cart-row {
            display:flex;
            gap:12px;
            align-items:center;
            background:#fff;
            border-radius:12px;
            padding:12px;
            box-shadow:0 6px 16px rgba(0,0,0,.06);
        }

        .cart-row img {
            width:100px;
            height:80px;
            object-fit:cover;
            border-radius:8px;
        }

        .cart-row div {
            flex:1;
        }

        .cart-total {
            text-align: right;
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="Logo">
        </a>
        <a href="{{ route('favourites.index') }}" class="icon" title="Kedvencek">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
            </svg>
        </a>
    </div>

    <div class="right-group">
        @guest
            <button class="btn-nav" id="btnOpenLogin" type="button">Bejelentkezés</button>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav">Regisztráció</a>
            @endif
        @else
            <div class="profile-menu">
                <div class="profile-circle" id="profileToggle">
                    @if (Auth::user()->profile_picture)
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

    {{-- Kosár tartalom --}}
    @if(!empty($cart))
    <div class="cart-list">
        @foreach($cart as $id => $row)
        <div class="cart-row">
            <a href="{{ route('items.show', ['id' => $row['id']]) }}">
                <img src="{{ $row['img'] }}" alt="{{ $row['name'] }}">
            </a>
            <div>
                <div style="font-weight:600;">{{ $row['name'] }}</div>
                <div>{{ number_format($row['price'],0,'',' ') }} Ft</div>
                <div style="font-size:.85rem;color:#666;">Mennyiség: {{ $row['qty'] }}</div>
            </div>
        </div>
        @endforeach

        {{-- Összesített ár --}}
        <div class="cart-total">
            Összesen: {{ number_format($total,0,'',' ') }} Ft
        </div>
    </div>
    @endif

    {{-- Rendelési űrlap --}}
    <div style="display: flex; flex-direction: column; align-items: center; gap: 40px;">
        <div class="form-container" id="checkoutFormContainer">
            <h2>Rendelés leadása</h2>

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
                        <input type="tel" name="phone" placeholder="Telefonszám" required pattern="[0-9]{9,15}" title="Csak számokat írj be, 9-15 számjegy között">
                    </div>
                    <div class="form-field">
                        <input type="text" name="address" placeholder="Szállítási cím" required>
                    </div>
                    <div class="form-field">
                        <input type="text" name="billing_address" placeholder="Számlázási cím" required>
                    </div>
                    <div class="form-field">
                        <select name="payment_method" id="payment_method" required>
                            <option value="">Fizetési mód kiválasztása</option>
                            <option value="card">Bankkártya</option>
                            <option value="cod">Utánvét</option>
                            <option value="paypal">Utalás</option>
                        </select>
                    </div>
                </div>

                <div id="card-fields" style="display:none; margin-top:20px;">
                    <div id="card-error" style="color:red; margin-bottom:10px; display:none;"></div>
                    <div class="form-field">
                        <input type="text" id="card_number" name="card_number" maxlength="19" placeholder="Kártyaszám (xxxx xxxx xxxx xxxx)">
                    </div>
                    <div class="form-field">
                        <input type="text" id="expiry" name="expiry" maxlength="5" placeholder="Lejárat (MM/YY)">
                    </div>
                    <div class="form-field">
                        <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="CVV (3 számjegy)">
                    </div>
                    <div class="form-field">
                        <input type="text" id="cardholder" name="cardholder" placeholder="Kártyatulajdonos neve">
                    </div>
                </div>

                <button type="submit" class="btn-register" style="width:100%;">Rendelés leadása</button>
            </form>

            @guest
            <div class="guest-alert">
                A rendelés leadásához <a href="#" id="guestLoginLink">jelentkezz be</a> vagy <a href="{{ route('register') }}">regisztrálj</a>.
            </div>
            @endguest

        </div>
    </div>
</main>

<footer class="footer" style="margin-top:60px;">
    <div class="footer-inner">
        <div>© {{ date('Y') }} ButorBolt</div>
    </div>
</footer>

<!-- Login modal -->
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
            <button class="btn-login" type="submit">Bejelentkezés</button>
            <button class="btn-admin" type="submit" value="1" name="admin_login">Admin</button>
        </form>
    </div>
</div>

<script>
// Profil dropdown
const profileToggle = document.getElementById('profileToggle');
const profileDropdown = document.getElementById('profileDropdown');

if (profileToggle) {
    profileToggle.addEventListener('click', () => {
        profileDropdown.style.display =
            profileDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
        if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.style.display = 'none';
        }
    });
}

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

// Login modal nyitása / zárása
const modal = document.getElementById('loginModal');
const btnOpen = document.getElementById('btnOpenLogin');
const btnClose = document.getElementById('closeModal');

if (btnOpen) btnOpen.addEventListener('click', () => modal.style.display = 'flex');
if (btnClose) btnClose.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', e => { if (modal && e.target === modal) modal.style.display = 'none'; });

// Guest: form tiltás és login link
@guest
const checkoutForm = document.getElementById('checkoutFormContainer');
if (checkoutForm){
    checkoutForm.querySelectorAll('input, select, button').forEach(el => el.disabled = true);
}
document.getElementById('guestLoginLink').addEventListener('click', function(e){
    e.preventDefault();
    modal.style.display = 'flex';
});
@endguest
</script>

</body>
</html>
