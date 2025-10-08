<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg px-3">
        <a class="navbar-brand" href="#">Logo</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <input class="form-control form-control-sm" type="text" placeholder="Keresés...">
            <button class="btn btn-outline-secondary btn-sm">Bejelentkezés</button>
            <button class="btn btn-outline-dark btn-sm">Regisztráció</button>
        </div>
    </nav>


    <div class="form-container text-center">
        <h4>Kérjük, adja meg az alábbi adatokat:</h4>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Vezetéknév">
                    <input type="text" class="form-control" placeholder="Email">
                    <input type="password" class="form-control" placeholder="Jelszó">
                    <input type="password" class="form-control" placeholder="Jelszó megerősítése">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Keresztnév">
                    <input type="text" class="form-control" placeholder="Felhasználónév">
                    <input type="text" class="form-control" placeholder="Telefonszám">
                    <input type="text" class="form-control" placeholder="Cím">
                </div>
            </div>

            <button type="submit" class="btn btn-register mt-4">Regisztráció</button>
        </form>
    </div>
</body>
</html>
