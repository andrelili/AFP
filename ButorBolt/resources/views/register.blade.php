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
        </div>
    </header>

    <main class="form-container">
        <h4>Kérjük, adja meg az alábbi adatokat:</h4>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-grid">
                <div class="form-field">
                    <input type="text" name="first_name" placeholder="Vezetéknév">
                </div>
                <div class="form-field">
                    <input type="text" name="last_name" placeholder="Keresztnév">
                </div>
                <div class="form-field">
                    <input type="email" name="email" placeholder="Email">
                </div>
                <div class="form-field">
                    <input type="text" name="username" placeholder="Felhasználónév">
                </div>
                <div class="form-field">
                    <input type="password" name="password" placeholder="Jelszó">
                </div>
                <div class="form-field">
                    <input type="password" name="password_confirmation" placeholder="Jelszó megerősítése">
                </div>
                <div class="form-field">
                    <input type="text" name="phone" placeholder="Telefonszám">
                </div>
                <div class="form-field">
                    <input type="text" name="address" placeholder="Cím">
                </div>
            </div>

            <button type="submit" class="btn-register">Regisztráció</button>
        </form>
    </main>
    @if ($errors->any())
    <div class="errors">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>
