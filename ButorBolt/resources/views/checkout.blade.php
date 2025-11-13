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

        /* --- profilkép stílusok a fejlécben --- */
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
            transition: background 0.3s;
        }
        .profile-circle:hover {
            background-color: #e0e0e0;
        }
        .profile-img {
            width: 100%;
            height: 100%;
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
        }
        .profile-dropdown a:hover,
        .profile-dropdown button:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="Logo">
        </a>
        <div class="icon" title="Kedvencek">
            <a href="{{ route('favourites.index') }}" style="color: inherit;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
                </svg>
            </a>
        </div>
    </div>

    <div class="right-group">
        @guest
            <a href="{{ route('login') }}" class="btn-nav">Bejelentkezés</a>
            <a href="{{ route('register') }}" class="btn-nav">Regisztráció</a>
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
                    <div class="form-field">
                        <select name="payment_method" required>
                            <option value="">Fizetési mód kiválasztása</option>
                            <option value="card">Bankkártya</option>
                            <option value="cod">Utánvét</option>
                            <option value="paypal">Utalás</option>
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

<script>
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileToggle) {
        profileToggle.addEventListener('click', () => {
            profileDropdown.style.display =
                profileDropdown.style.display === 'block' ? 'none' : 'block';
        });
        window.addEventListener('click', e => {
            if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>
