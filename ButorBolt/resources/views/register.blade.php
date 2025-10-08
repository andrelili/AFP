<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <!-- CSS a böngésző által elérhető css mappából -->
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

    <!-- Fejléc -->
    <header class="topbar">
        <div class="left-group">
            <!-- Logó -->
            <div class="logo">Logo</div>

            <!-- Menü ikon (három vonal) -->
            <div class="menu-icon" title="Menü">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <!-- Szív ikon -->
            <div class="icon" title="Kedvencek">❤️</div>

            <!-- Homokóra ikon -->
            <div class="icon" title="Szűrés">⏳</div>
        </div>

        <!-- Középső kereső -->
        <div class="center-group">
            <div class="search-box">
                <input type="text" placeholder="Keresés...">
            </div>
        </div>

        <!-- Jobb oldali ikonok és gombok -->
        <div class="right-group">
            <div class="icon" title="Kosár">🛒</div>
            <button class="btn-nav">Bejelentkezés</button>
            <button class="btn-nav primary">Regisztráció</button>
            <div class="profile-circle" title="Profil">👤</div>
        </div>
    </header>

    <!-- Regisztrációs űrlap -->
    <main class="form-container">
        <h4>Kérjük, adja meg az alábbi adatokat:</h4>

        <form>
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
